/*
|--------------------------------------------------------------------------
| Automator Form Editor
|--------------------------------------------------------------------------
|
| Editor visual exclusivo para formulários.
| Não usa SysAutomatorEditor.
| Não salva HTML como fonte da verdade.
| Usa GrapesJS apenas como camada visual.
|
*/

window.SysAutomatorFormEditor = (function () {

  const defaultState = {
    isNew: true,
    hasChanges: false,
    initialized: false,
    previewMode: false,
    viewportMode: 'auto',
    selectedFieldCid: null,
    componentsLoaded: false,
    componentsLoading: false,
    userTypes: [],
    developerUserTypeID: null,
    currentUserIsDeveloper: false,
    currentFormLocked: false,
  };

  let state = $.extend(true, {}, defaultState);
  let grapesEditor = null;
  let formFields = [];
  let formComponents = {};
  let previewSnapshot = null;

  const selectors = {
    modal: '#automator-editor-modal',
    canvas: '#automator-editor-canvas-container-content',
    canvasContainer: '#automator-editor-canvas-container',
    leftAside: '#automator-editor-aside-left',
    rightAside: '#automator-editor-aside-right',
    inserterList: '#automator-editor-aside-left-inserter-list',
    structureList: '#automator-editor-aside-left-structure-list',
    rightContent: '#automator-editor-aside-right-content',
    saveBtn: '#automator-editor-header-save-btn',
    previewBtn: '#automator-editor-header-preview-btn',
    viewportLabel: '#automator-editor-header-viewport-label'
  };


  /*
  |--------------------------------------------------------------------------
  | Inicialização
  |--------------------------------------------------------------------------
  */

    
  function config(data = {}, callback = null) {

    destroy(false);

    state = $.extend(true, {}, defaultState);

    state.isNew = data.isNew !== false;
    state.suppressChangeTracking = true;
    state.userTypes = [];
    state.developerUserTypeID = null;
    state.currentUserIsDeveloper = false;
    state.currentFormLocked = false;

    formFields = [];
    formComponents = {};
    previewSnapshot = null;

    clearUnsavedChangesWarning();

    prepareSidebarItems();

    bindSidebarBlocks();
    bindHeaderSlugSync();
    bindFormSettingsChanges();
    bindFormSecurityEvents();
    bindUnsavedModalCloseWarning();

    loadEditorSecurityOptions(function () {

      renderFormSecurityPanel();

      loadSidebarComponents(function () {

        if (typeof callback === 'function') {
          callback();
        }

      });

    });

  }


  function init(callback = null) {

    if (!$(selectors.canvas).length) {
      console.warn('Área do canvas do editor de formulários não encontrada.');
      return false;
    }

    grapesEditor = grapesjs.init({
      container: selectors.canvas,
      height: '100%',
      width: 'auto',
      storageManager: false,
      fromElement: false,
      noticeOnUnload: false,
      avoidInlineStyle: false,
      panels: {
        defaults: []
      },
      canvas: {
        styles: getCanvasStyleUrls()
      },
      deviceManager: {
        devices: []
      }
    });

    bindCanvasFrameLifecycle();

    grapesEditor.once('load', function () {

      grapesEditor.setComponents([
        {
          type: 'default',
          tagName: 'form',
          name: 'Formulário',
          classes: ['row'],
          attributes: {
            'data-automator-form-editor-preview': 'true',
            'data-automator-form-editor-dropzone': 'true'
          },
          draggable: false,
          droppable: true,
          editable: false,
          selectable: false,
          hoverable: false,
          highlightable: false,
          copyable: false,
          removable: false,
          components: []
        }
      ]);

      injectCanvasStyles();
      bindEditorEvents();
      bindCanvasClickSelection();

      setLeftSidebarOpen(true);
      setRightSidebarOpen(true);
      updateViewportButton();
      syncCanvasDeviceViewport();
      updateStructureList();

      state.initialized = true;
      state.hasChanges = false;

      setSaveState(false);

      setTimeout(function () {

        resetCanvasEditMode();
        bindCanvasClickSelection();
        syncCanvasHeight();
        syncEditorViewportSpacing();
        syncCanvasDeviceViewport();

        if (typeof callback === 'function') {
          callback();
        }

      }, 250);

    });

    return true;

  }


  function destroy(resetState = true) {

    const currentEditor = grapesEditor;

    clearUnsavedChangesWarning();

    if (window.__automatorFormEditorCloseCaptureHandler) {
      document.removeEventListener(
        'click',
        window.__automatorFormEditorCloseCaptureHandler,
        true
      );

      window.__automatorFormEditorCloseCaptureHandler = null;
    }

    grapesEditor = null;

    $(document).off('.automator-form-editor');
    $(document).off('.AutomatorFormEditorCloseButton');
    $(document).off('hide.bs.modal.AutomatorFormEditorChanged');
    $(document).off('hidden.bs.modal.AutomatorFormEditorChanged');

    if (currentEditor) {

      try {
        currentEditor.destroy();
      } catch (e) {
        console.warn('GrapesJS do editor de formulários já estava destruído.', e);
      }

    }

    try {
      $(selectors.canvas).empty();
      $(selectors.structureList).empty();
    } catch (e) {}

    if ($(selectors.rightContent).length) {
      $(selectors.rightContent).html(
        '<div class="text-center p-3">Selecione um campo para editar.</div>'
      );
    }

    if (resetState === true) {
      state = $.extend(true, {}, defaultState);
      formFields = [];
      formComponents = {};
      previewSnapshot = null;
    }

    return true;

  }


  function getFormEditorOptionsUrl() {

    let url = '';

    if (
      typeof window.AutomatorRoutes !== 'undefined' &&
      window.AutomatorRoutes.apiForms
    ) {
      url = String(window.AutomatorRoutes.apiForms || '').replace('#ID#', '0');
    }

    if (!url) {
      return '';
    }

    url += url.indexOf('?') >= 0
      ? '&mode=editor-options'
      : '?mode=editor-options';

    return url;

  }


  function loadEditorSecurityOptions(callback = null) {

    const url = getFormEditorOptionsUrl();

    if (!url) {

      if (typeof callback === 'function') {
        callback();
      }

      return false;

    }

    $.ajax({
      url: url,
      type: 'GET',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Accept': 'application/json'
      },
      dataType: 'json',
      success: function(response) {

        applyEditorSecurityResponse(response);

        if (typeof callback === 'function') {
          callback(response);
        }

      },
      error: function() {

        applyEditorSecurityResponse({});

        if (typeof callback === 'function') {
          callback();
        }

      }
    });

    return true;

  }


  function applyEditorSecurityResponse(response = {}) {

    const userTypes = response.userTypes || response.user_types || [];

    state.userTypes = Array.isArray(userTypes) ? userTypes : [];
    state.developerUserTypeID = null;

    state.userTypes.forEach(function(userType) {

      const id = String(userType.id || userType.tbl_users_type_ID || '');
      const name = String(userType.name || userType.tbl_users_type_name || '').trim().toLowerCase();

      if (
        userType.isDeveloper === true ||
        userType.is_developer === true ||
        name === 'desenvolvedor'
      ) {
        state.developerUserTypeID = id;
      }

    });

    const currentUser = response.currentUser || response.current_user || {};

    state.currentUserIsDeveloper = (
      currentUser.isDeveloper === true ||
      currentUser.is_developer === true
    );

    return true;

  }


  function normalizeAccessValues(values) {

    if (!Array.isArray(values)) {
      values = [];
    }

    values = values
      .map(function(value) {
        return String(value);
      })
      .filter(function(value) {
        return value !== '';
      })
      .filter(function(value, index, list) {
        return list.indexOf(value) === index;
      });

    if (
      state.developerUserTypeID &&
      values.indexOf(String(state.developerUserTypeID)) === -1
    ) {
      values.push(String(state.developerUserTypeID));
    }

    return values;

  }


  function getCheckedAccessValues(container) {

    const values = [];

    $(container)
      .find('.automator-form-editor-access-checkbox:checked')
      .each(function() {
        values.push(String($(this).val()));
      });

    return normalizeAccessValues(values);

  }


  function renderAccessCheckboxList(name, selectedValues, scope, disabled = false) {

    selectedValues = normalizeAccessValues(selectedValues || []);

    let html = '';

    if (!state.userTypes.length) {
      return '<div class="text-muted small">Nenhum tipo de usuário encontrado.</div>';
    }

    state.userTypes.forEach(function(userType) {

      const id = String(userType.id || userType.tbl_users_type_ID || '');
      const label = String(userType.name || userType.tbl_users_type_name || ('Tipo ' + id));
      const isDeveloper = id === String(state.developerUserTypeID);
      const checked = selectedValues.indexOf(id) !== -1 || isDeveloper;
      const inputId = name + '-' + scope + '-' + id;

      html += '<div class="form-check mb-1">';
      html += '<input type="checkbox" class="form-check-input automator-form-editor-access-checkbox" id="' + escapeHtml(inputId) + '" name="' + escapeHtml(name) + '[]" value="' + escapeHtml(id) + '" data-scope="' + escapeHtml(scope) + '"' + (checked ? ' checked' : '') + ((isDeveloper || disabled) ? ' disabled' : '') + (isDeveloper ? ' data-developer="true"' : '') + '>';
      html += '<label class="form-check-label" for="' + escapeHtml(inputId) + '">' + escapeHtml(label) + '</label>';
      html += '</div>';

    });

    return html;

  }


  function isTruthyValue(value) {

    return (
      value === true ||
      value === 1 ||
      value === '1' ||
      value === 'true' ||
      value === 'TRUE' ||
      value === 'sim' ||
      value === 'SIM'
    );

  }


  function isFormAdminEnabled() {

    const input = $('#automator-editor-modal').find('[name="tbl_sys_form_admin"]').first();

    if (!input.length) {
      return true;
    }

    if (input.attr('type') === 'checkbox') {
      return input.prop('checked') === true;
    }

    return isTruthyValue(input.val());

  }


  function isFormLockedForCurrentUser() {

    return state.currentFormLocked === true && state.currentUserIsDeveloper !== true;

  }


  function getCurrentFormAccess() {

    const panel = $('#automator-editor-form-security-access');

    if (!panel.length) {
      return normalizeAccessValues([]);
    }

    return getCheckedAccessValues(panel);

  }


  function renderFormSecurityPanel(selectedValues = null) {

    const formSettings = $('#automator-editor-aside-right-tabs-container-form-settings');

    if (!formSettings.length) {
      return false;
    }

    const disabled = isFormLockedForCurrentUser() || (state.currentUserIsDeveloper !== true && isFormAdminEnabled() !== true);

    const currentValues =
      selectedValues !== null
        ? selectedValues
        : getCurrentFormAccess();

    $('#automator-editor-form-security-accordion').remove();

    let html = '';

    html += '<div class="accordion automator-editor-settings-accordion mx-0 mt-3" id="automator-editor-form-security-accordion">';
    html += '<div class="accordion-item border-start-0 border-end-0 rounded-0">';
    html += '<h2 class="accordion-header">';
    html += '<button class="accordion-button collapsed py-2 px-3 small fw-bold rounded-0" type="button" data-bs-toggle="collapse" data-bs-target="#automator-editor-form-security-collapse">';
    html += 'Segurança';
    html += '</button>';
    html += '</h2>';
    html += '<div id="automator-editor-form-security-collapse" class="accordion-collapse collapse">';
    html += '<div class="accordion-body px-3 py-2" id="automator-editor-form-security-access">';
    html += renderAccessCheckboxList('form_access', currentValues, 'form', disabled);
    html += '</div>';
    html += '</div>';
    html += '</div>';
    html += '</div>';

    formSettings.append(html);

    syncFormSecurityState();

    return true;

  }


  function syncFormSecurityState() {

    const adminEnabled = isFormAdminEnabled();
    const formLocked = isFormLockedForCurrentUser();

    const modal = $('#automator-editor-modal');

    modal
      .find('[name="tbl_sys_form_route"], [name="tbl_sys_form_validate"]')
      .prop('disabled', formLocked || (state.currentUserIsDeveloper !== true && adminEnabled !== true));

    const accessPanel = $('#automator-editor-form-security-access');

    accessPanel.find('.automator-form-editor-access-checkbox').each(function() {

      const input = $(this);
      const isDeveloper = input.attr('data-developer') === 'true';

      if (isDeveloper) {
        input.prop('checked', true).prop('disabled', true);
        return;
      }

      input.prop(
        'disabled',
        formLocked || (state.currentUserIsDeveloper !== true && adminEnabled !== true)
      );

      if (adminEnabled !== true && state.currentUserIsDeveloper !== true) {
        input.prop('checked', false);
      }

    });

    modal.find('input, select, textarea, button').each(function() {

      const el = $(this);
      const name = el.attr('name') || '';

      if (
        name === 'tbl_sys_form_admin' &&
        state.currentUserIsDeveloper === true
      ) {
        return;
      }

      if (
        el.closest('#automator-editor-header').length ||
        el.closest('#automator-editor-form-security-access').length ||
        el.closest(selectors.rightContent).length
      ) {
        return;
      }

      if (formLocked) {
        el.prop('disabled', true);
      }

    });

    if (formLocked) {
      $(selectors.inserterList).find('[data-block-type-id]').addClass('disabled').css('pointer-events', 'none');
    } else {
      $(selectors.inserterList).find('[data-block-type-id]').removeClass('disabled').css('pointer-events', '');
    }

    return true;

  }


  function bindFormSecurityEvents() {

    $(document)
      .off('change.automator-form-editor-security')
      .on(
        'change.automator-form-editor-security',
        '#automator-editor-modal .automator-form-editor-access-checkbox',
        function() {

          const input = $(this);

          if (input.attr('data-developer') === 'true') {
            input.prop('checked', true);
          }

          setSaveState(true);

        }
      );

    $(document)
      .off('change.automator-form-editor-admin-security input.automator-form-editor-admin-security')
      .on(
        'change.automator-form-editor-admin-security input.automator-form-editor-admin-security',
        '#automator-editor-modal [name="tbl_sys_form_admin"]',
        function() {

          syncFormSecurityState();
          setSaveState(true);

        }
      );

    return true;

  }


  function clearUnsavedChangesWarning() {

    state.hasChanges = false;

    const editorEl = document.querySelector(selectors.modal);

    if (editorEl) {
      editorEl.setAttribute('data-automator-form-changed', 'false');
      editorEl.removeAttribute('data-automator-form-submit');
    }

    $(window).off('beforeunload.AutomatorFormEditorChanged');

    if (window.__automatorFormEditorBeforeUnloadHandler) {
      window.removeEventListener(
        'beforeunload',
        window.__automatorFormEditorBeforeUnloadHandler
      );

      window.__automatorFormEditorBeforeUnloadHandler = null;
    }

    if ($(selectors.saveBtn).length) {
      $(selectors.saveBtn).prop('disabled', true);
    }

    return true;

  }



  function bindCanvasFrameLifecycle() {

    if (!grapesEditor || !grapesEditor.on) {
      return false;
    }

    grapesEditor.off('canvas:frame:load');

    grapesEditor.on('canvas:frame:load', function() {

      setTimeout(function() {

        injectCanvasStyles();

        if (state.previewMode === true) {
          return;
        }

        resetCanvasEditMode();
        bindCanvasClickSelection();

      }, 80);

    });

    return true;

  }


  /*
  |--------------------------------------------------------------------------
  | Eventos
  |--------------------------------------------------------------------------
  */

  function bindSidebarBlocks() {

    $(document)
      .off('click.automator-form-editor-block')
      .on(
        'click.automator-form-editor-block',
        selectors.inserterList + ' [data-block-type-id]',
        function (event) {

          event.preventDefault();

          const item = $(this);

          addFieldFromSidebarItem(item);

        }
      );

  }


  function bindEditorEvents() {

    if (!grapesEditor) {
      return false;
    }

    grapesEditor.off('component:selected');
    grapesEditor.off('component:deselected');
    grapesEditor.off('component:add component:remove component:drag:end');
    grapesEditor.off('component:update');

    grapesEditor.on('component:selected', function(component) {

      if (state.previewMode === true) {
        clearSelection();
        return;
      }

      const fieldComponent = getClosestFormFieldComponent(component);

      if (!fieldComponent) {
        clearSelection();
        selectFormSettingsTab();
        return;
      }

      selectFieldComponent(fieldComponent, false);

    });

    grapesEditor.on('component:deselected', function() {

      if (state.previewMode === true) {
        return;
      }

      state.selectedFieldCid = null;

      $(selectors.rightContent).html(
        '<div class="text-center p-3">Selecione um campo para editar.</div>'
      );

      updateStructureActiveItem(null);

    });

    grapesEditor.on('component:add', function(component) {

      normalizeAddedFieldComponent(component);

      state.hasChanges = true;

      setSaveState(true);
      syncFieldsFromCanvas();
      updateStructureList();

      if (!isEditingPropertiesPanel()) {
        syncCanvasHeight();
        syncEditorViewportSpacing();
      }

      bindCanvasClickSelection();

    });

    grapesEditor.on('component:remove component:drag:end', function() {

      state.hasChanges = true;

      setSaveState(true);
      syncFieldsFromCanvas();
      updateStructureList();

      if (!isEditingPropertiesPanel()) {
        syncCanvasHeight();
        syncEditorViewportSpacing();
      }

      bindCanvasClickSelection();

    });

    grapesEditor.on('component:update', function() {

      state.hasChanges = true;

      setSaveState(true);
      syncFieldsFromCanvas();
      updateStructureList();

    });

    bindCanvasClickSelection();
    normalizeGrapesToolsPointerEvents();

    return true;

  }

  function selectFormSettingsTab() {

    setRightSidebarOpen(true);

    state.selectedFieldCid = null;

    $('.automator-editor-aside-right-tabs-button').removeClass('active');
    $('#automator-editor-aside-right-tabs-button-form-settings').addClass('active');

    $('.automator-editor-aside-right-tabs-container-item').removeClass('active');
    $('#automator-editor-aside-right-tabs-container-form-settings').addClass('active');

    updateStructureActiveItem(null);

    return true;

  }


  function selectFieldComponent(component, forceSelect = true) {

    if (!component || !grapesEditor) {
      return false;
    }

    const fieldComponent = getClosestFormFieldComponent(component);

    if (!fieldComponent) {
      return false;
    }

    if (state.previewMode === true) {
      return false;
    }

    forceEnableCanvasPointerEvents();
    restoreGrapesToolbar();

    if (forceSelect === true) {

      try {
        const selected = grapesEditor.getSelected();

        if (selected && selected.cid !== fieldComponent.cid) {
          grapesEditor.selectRemove(selected);
        }
      } catch (e) {}

      grapesEditor.select(fieldComponent);

    }

    state.selectedFieldCid = fieldComponent.cid;

    focusFieldRightSidebar();
    renderFieldSettings(fieldComponent);
    updateStructureActiveItem(fieldComponent);

    setTimeout(function() {
      normalizeGrapesToolsPointerEvents();
      restoreGrapesToolbar();
    }, 30);

    return true;

  }


  function forceEnableCanvasPointerEvents() {

    const canvasEl = $(selectors.canvas);

    canvasEl
      .find(
        '.gjs-editor, .gjs-cv-canvas, .gjs-cv-canvas__frames, .gjs-frame-wrapper, .gjs-frame, iframe'
      )
      .css({
        display: '',
        visibility: '',
        pointerEvents: 'auto',
        position: '',
        inset: '',
        zIndex: '',
        opacity: ''
      });

    normalizeGrapesToolsPointerEvents();

    return true;

  }


  function bindCanvasClickSelection() {

    if (
      !grapesEditor ||
      !grapesEditor.Canvas ||
      typeof grapesEditor.Canvas.getDocument !== 'function'
    ) {
      return false;
    }

    const doc = grapesEditor.Canvas.getDocument();

    if (!doc || !doc.body) {
      return false;
    }

    if (doc.__automatorFormEditorClickHandler) {
      doc.removeEventListener('pointerdown', doc.__automatorFormEditorClickHandler, true);
      doc.removeEventListener('mousedown', doc.__automatorFormEditorClickHandler, true);
      doc.removeEventListener('click', doc.__automatorFormEditorClickHandler, true);
    }

    doc.__automatorFormEditorClickHandler = function(event) {

      if (state.previewMode === true) {
        return;
      }

      const target = event.target;

      if (!target || !target.closest) {
        return;
      }

      const fieldEl = target.closest('[data-automator-form-field="true"]');

      if (fieldEl) {

        const uid = fieldEl.getAttribute('data-automator-form-field-uid');
        const component = findFormFieldComponentByUid(uid);

        if (!component) {
          return;
        }

        event.preventDefault();
        event.stopPropagation();
        event.stopImmediatePropagation();

        selectFieldComponent(component, true);

        return;
      }

      const formEl = target.closest('[data-automator-form-editor-preview="true"]');

      if (formEl || target === doc.body || target === doc.documentElement) {

        event.preventDefault();
        event.stopPropagation();

        clearSelection();
        selectFormSettingsTab();

      }

    };

    doc.addEventListener('pointerdown', doc.__automatorFormEditorClickHandler, true);
    doc.addEventListener('mousedown', doc.__automatorFormEditorClickHandler, true);
    doc.addEventListener('click', doc.__automatorFormEditorClickHandler, true);

    return true;

  }


  function fieldIdExistsExcept(id, exceptComponent) {

    let exists = false;

    getFormFieldComponents().forEach(function(component) {

      if (component === exceptComponent) {
        return;
      }

      const data = getFieldDataFromComponent(component);
      const props = getFieldProps(data);

      if (String(props.input_id || '') === String(id || '')) {
        exists = true;
      }

    });

    return exists;

  }

  function fieldNameExistsExcept(name, exceptComponent) {

    let exists = false;

    getFormFieldComponents().forEach(function(component) {

      if (component === exceptComponent) {
        return;
      }

      const data = getFieldDataFromComponent(component);

      if (String(data.tbl_sys_forms_field_name || '') === String(name || '')) {
        exists = true;
      }

    });

    return exists;

  }


  function countFieldComponentsByUid(uid) {

    let total = 0;

    getFormFieldComponents().forEach(function(component) {

      const attrs = component.getAttributes ? component.getAttributes() : {};

      if (attrs['data-automator-form-field-uid'] === uid) {
        total++;
      }

    });

    return total;

  }

  function normalizeBootstrapWrapperClass(wrapperClass) {

    const classes = String(wrapperClass || '')
      .split(/\s+/)
      .filter(Boolean);

    const ordered = [];
    const others = [];

    const order = [
      /^col-\d{1,2}$/,
      /^col-sm-\d{1,2}$/,
      /^col-md-\d{1,2}$/,
      /^col-lg-\d{1,2}$/,
      /^col-xl-\d{1,2}$/,
      /^col-xxl-\d{1,2}$/
    ];

    order.forEach(function(regex) {
      classes.forEach(function(cls) {
        if (regex.test(cls) && ordered.indexOf(cls) === -1) {
          ordered.push(cls);
        }
      });
    });

    classes.forEach(function(cls) {
      const isColumn = order.some(function(regex) {
        return regex.test(cls);
      });

      if (!isColumn && others.indexOf(cls) === -1) {
        others.push(cls);
      }
    });

    if (!ordered.length) {
      ordered.push('col-12');
    }

    return ordered.concat(others).join(' ');

  }


  function normalizeAddedFieldComponent(component) {

    if (!component || state.previewMode === true || state.normalizingComponent === true) {
      return false;
    }

    const attrs = component.getAttributes ? component.getAttributes() : {};

    if (attrs['data-automator-form-field'] !== 'true') {
      return false;
    }

    let fieldData = getFieldDataFromComponent(component);

    if (!fieldData || !fieldData.uid) {
      return false;
    }

    const duplicatedUid = countFieldComponentsByUid(fieldData.uid) > 1;
    const duplicatedName = fieldNameExistsExcept(fieldData.tbl_sys_forms_field_name, component);
    const props = getFieldProps(fieldData);
    const duplicatedId = fieldIdExistsExcept(props.input_id, component);

    if (!duplicatedUid && !duplicatedName && !duplicatedId) {
      return false;
    }

    const oldTitle = fieldData.tbl_sys_forms_field_title || 'Campo';
    const oldType = fieldData.tbl_sys_field_type_name || 'field';
    const oldProps = getFieldProps(fieldData);

    fieldData.uid = 'form-field-' + Date.now() + '-' + Math.floor(Math.random() * 999999);

    fieldData.tbl_sys_forms_field_ID = '';
    fieldData.tbl_sys_forms_field_title = oldTitle;
    fieldData.tbl_sys_forms_field_name = generateUniqueFieldName(oldType);
    fieldData.tbl_sys_forms_field_index = fieldData.tbl_sys_forms_field_name;

    oldProps.input_id = generateUniqueFieldId(fieldData.tbl_sys_forms_field_name);

    if (!oldProps.wrapper_class) {
      oldProps.wrapper_class = getDefaultWrapperClassFromRawParams(fieldData.raw || {});
    }

    fieldData.tbl_sys_forms_field_attrs = 'id="' + oldProps.input_id + '"';
    fieldData.tbl_sys_forms_field_props = oldProps;

    state.normalizingComponent = true;

    setFieldDataToComponent(component, fieldData, {
      refreshPanel: false,
      skipResize: true
    });

    state.normalizingComponent = false;

    return true;

  }


  function getClosestFormFieldComponent(component) {

    if (!component) {
      return null;
    }

    let current = component;

    while (current) {

      const attrs = current.getAttributes ? current.getAttributes() : {};

      if (attrs['data-automator-form-field'] === 'true') {
        return current;
      }

      current = current.parent ? current.parent() : null;

    }

    return null;

  }



  function isEditingPropertiesPanel() {

    const active = document.activeElement;

    if (!active) {
      return false;
    }

    return $(active).closest(selectors.rightAside).length > 0;

  }


  function focusFieldRightSidebar() {

    setRightSidebarOpen(true);

    $('#automator-editor-aside-right-tabs-button-block').trigger('click');

    $('.automator-editor-aside-right-tabs-button').removeClass('active');
    $('#automator-editor-aside-right-tabs-button-block').addClass('active');

    $('.automator-editor-aside-right-tabs-container-item').removeClass('active');
    $('#automator-editor-aside-right-tabs-container-block').addClass('active');

    return true;

  }



  function getDefaultWrapperClassFromRawParams(raw) {

    let params =
      raw && raw.tbl_sys_field_type_params
        ? raw.tbl_sys_field_type_params
        : (
            raw && raw.params
              ? raw.params
              : {}
          );

    if (typeof params === 'string') {
      try {
        params = JSON.parse(params);
      } catch (e) {
        params = {};
      }
    }

    if (!params || typeof params !== 'object') {
      return 'col-12';
    }

    if (params.wrapper_class) {
      return String(params.wrapper_class || 'col-12').trim() || 'col-12';
    }

    if (!params.wrapper || !params.wrapper.fields) {
      return 'col-12';
    }

    const fields = params.wrapper.fields;
    const classes = [];

    const map = {
      'column-xs': 'col',
      'column-sm': 'col-sm',
      'column-md': 'col-md',
      'column-lg': 'col-lg',
      'column-xl': 'col-xl',
      'column-xxl': 'col-xxl'
    };

    $.each(map, function(fieldKey, classPrefix) {

      if (!fields[fieldKey]) {
        return;
      }

      let value = parseInt(fields[fieldKey].default || '', 10);

      if (!value || value < 1 || value > 12) {
        return;
      }

      classes.push(classPrefix + '-' + value);

    });

    if (!classes.length) {
      classes.push('col-12');
    }

    return classes.join(' ');

  }


  function buildFieldComponent(fieldData) {

    const type = String(fieldData.tbl_sys_field_type_name || '').toLowerCase();

    if (type === 'hidden') {
      return buildHiddenFieldComponent(fieldData);
    }

    const wrapperClass = getFieldWrapperClass(fieldData);

    return {
      type: 'default',
      tagName: 'div',
      name: fieldData.tbl_sys_forms_field_title || 'Campo',
      classes: getFieldComponentClasses(fieldData),
      attributes: {
        'data-automator-form-field': 'true',
        'data-automator-form-field-uid': fieldData.uid,
        'data-automator-field-type-id': fieldData.tbl_sys_field_type_ID,
        'data-automator-field-type-name': fieldData.tbl_sys_field_type_name,
        'data-automator-field-type-title': fieldData.tbl_sys_forms_field_title,
        'data-automator-form-field-data': encodeFieldData(fieldData)
      },
      style: {
        height: 'auto',
        'min-height': '0'
      },
      draggable: true,
      droppable: false,
      editable: false,
      selectable: true,
      hoverable: true,
      highlightable: true,
      copyable: true,
      removable: true,
      components: [
        {
          type: 'default',
          tagName: 'div',
          classes: ['automator-form-editor-field-preview'],
          draggable: false,
          droppable: false,
          selectable: false,
          hoverable: false,
          highlightable: false,
          copyable: false,
          removable: false,
          components: buildFieldPreviewComponents(fieldData)
        }
      ]
    };

  }

  function buildHiddenFieldComponent(fieldData) {

    const props = getFieldProps(fieldData);

    return {
      type: 'default',
      tagName: 'input',
      name: fieldData.tbl_sys_forms_field_title || 'Campo oculto',
      attributes: {
        type: 'hidden',
        id: props.input_id || '',
        name: fieldData.tbl_sys_forms_field_name || '',
        value: fieldData.tbl_sys_forms_field_default || '',

        'data-automator-form-field': 'true',
        'data-automator-hidden-field': 'true',
        'data-automator-form-field-uid': fieldData.uid,
        'data-automator-field-type-id': fieldData.tbl_sys_field_type_ID,
        'data-automator-field-type-name': fieldData.tbl_sys_field_type_name,
        'data-automator-field-type-title': fieldData.tbl_sys_forms_field_title,
        'data-automator-form-field-data': encodeFieldData(fieldData)
      },
      style: {
        display: 'none'
      },
      draggable: false,
      droppable: false,
      editable: false,
      selectable: true,
      hoverable: false,
      highlightable: false,
      copyable: false,
      removable: true
    };

  }


  function isPasswordButtonProperty(propertyName) {

    const clean = String(propertyName || '').toLowerCase();

    return (
      clean === 'hasbutton' ||
      clean === 'has-button' ||
      clean === 'has_button' ||
      clean === 'advanced.hasbutton' ||
      clean === 'advanced.has-button' ||
      clean === 'advanced.has_button'
    );

  }


  function injectCanvasStyles() {

    if (!grapesEditor || !grapesEditor.Canvas) {
      return false;
    }

    const doc = grapesEditor.Canvas.getDocument();

    if (!doc) {
      return false;
    }

    getCanvasStyleUrls().forEach(function(url) {

      const exists = Array.prototype.slice.call(doc.querySelectorAll('link[rel="stylesheet"]')).some(function(link) {
        return String(link.getAttribute('href') || '').indexOf(url) !== -1;
      });

      if (!exists) {
        const link = doc.createElement('link');
        link.rel = 'stylesheet';
        link.href = url;
        doc.head.appendChild(link);
      }

    });

    if (!doc.getElementById('automator-form-editor-canvas-styles')) {

      const style = doc.createElement('style');

      style.id = 'automator-form-editor-canvas-styles';

      style.innerHTML = `
        html,
        body {
          background: #ffffff !important;
          padding: 0 !important;
          margin: 0 !important;
          overflow-x: hidden !important;
          overflow-y: hidden !important;
          width: 100% !important;
          min-height: 100% !important;
        }

        form[data-automator-form-editor-preview="true"] {
          width: 100% !important;
          min-height: 420px !important;
          height: auto !important;
          background: #ffffff !important;
          border: 1px dashed rgba(13, 110, 253, .35) !important;
          padding: 15px !important;
          box-sizing: border-box !important;
          margin: 0 !important;
          display: flex !important;
          flex-wrap: wrap !important;
          align-items: flex-start !important;
          align-content: flex-start !important;
        }

        .automator-form-editor-field-wrapper {
          position: relative !important;
          height: auto !important;
          min-height: auto !important;
          max-height: none !important;
          box-sizing: border-box !important;
          cursor: pointer !important;
          margin-bottom: 1rem !important;
          align-self: flex-start !important;
          flex-grow: 0 !important;
          flex-shrink: 0 !important;
          padding: 6px;
        }

        .automator-form-editor-field-preview {
          width: 100% !important;
          height: auto !important;
          min-height: auto !important;
          max-height: none !important;
          padding: 0 !important;
          margin: 0 !important;
          display: block !important;
        }

        .automator-form-editor-field-wrapper::before {
          content: attr(data-automator-field-type-title);
          position: absolute;
          right: 12px;
          top: -24px;
          background: #3b97e3;
          color: #ffffff;
          font-size: 12px;
          line-height: 18px;
          padding: 3px 8px;
          border-radius: 3px 3px 0 0;
          display: none;
          z-index: 9999;
          pointer-events: none;
          font-family: Arial, sans-serif;
          font-weight: 500;
        }

        .automator-form-editor-field-wrapper:hover::before,
        .automator-form-editor-field-wrapper.gjs-selected::before {
          display: block;
        }

        .automator-form-editor-field-wrapper:hover,
        .automator-form-editor-field-wrapper.gjs-selected {
          outline: 2px solid #0d6efd !important;
          outline-offset: -2px !important;
        }

        .automator-form-editor-field-wrapper input,
        .automator-form-editor-field-wrapper select,
        .automator-form-editor-field-wrapper textarea,
        .automator-form-editor-field-wrapper label,
        .automator-form-editor-field-wrapper button {
          pointer-events: none !important;
        }

        [data-automator-hidden-field="true"] {
          display: none !important;
          width: 0 !important;
          height: 0 !important;
          min-height: 0 !important;
          margin: 0 !important;
          padding: 0 !important;
          border: 0 !important;
          outline: 0 !important;
        }

        body.automator-form-editor-preview-mode .automator-form-editor-field-wrapper::before,
        body.automator-form-editor-preview-mode .gjs-selected,
        body.automator-form-editor-preview-mode .gjs-hovered,
        body.automator-form-editor-preview-mode .gjs-toolbar,
        body.automator-form-editor-preview-mode .gjs-badge,
        body.automator-form-editor-preview-mode .gjs-tools,
        body.automator-form-editor-preview-mode .gjs-highlighter,
        body.automator-form-editor-preview-mode .gjs-resizer,
        body.automator-form-editor-preview-mode .gjs-offset-v {
          outline: none !important;
          display: none !important;
          pointer-events: none !important;
        }
      `;

      doc.head.appendChild(style);

    }

    $('#automator-form-editor-static-preview-styles').remove();

    $('<style id="automator-form-editor-static-preview-styles"></style>')
      .text(`
        #automator-editor-canvas-container-content {
          position: relative;
        }

        .automator-form-editor-static-preview {
          position: relative;
          z-index: 100;
          background: #ffffff;
          min-height: 500px;
          width: 100%;
          padding: 15px;
          box-sizing: border-box;
          pointer-events: auto;
        }

        .automator-form-editor-static-preview form {
          width: 100%;
          margin: 0;
        }

        #automator-editor-modal.is-preview-mode #automator-editor-canvas-container {
          background: #ffffff;
        }
      `)
      .appendTo('head');

    
    injectCanvasScripts();

    return true;

  }



  function bindFormSettingsChanges() {

    $(document)
      .off('input.automator-form-editor-settings change.automator-form-editor-settings')
      .on(
        'input.automator-form-editor-settings change.automator-form-editor-settings',
        '#automator-editor-modal input, #automator-editor-modal select, #automator-editor-modal textarea',
        function () {

          if (state.previewMode === true) {
            return;
          }

          if (state.suppressChangeTracking === true) {
            return;
          }

          if (state.initialized !== true) {
            return;
          }

          setSaveState(true);

        }
      );

  }


  /*
  |--------------------------------------------------------------------------
  | Slug do header
  |--------------------------------------------------------------------------
  */

  function stringToSlug(value) {

    return String(value || '')
      .normalize('NFD')
      .replace(/[\u0300-\u036f]/g, '')
      .toLowerCase()
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/^-+|-+$/g, '');

  }


  function syncHeaderInputSlug(input) {

    const source = $(input);
    const targetSelector = source.attr('data-automator-sync-slug-field');

    if (!targetSelector) {
      return false;
    }

    const checkbox = $('#' + source.attr('id') + '-sync');

    if (!checkbox.length || !checkbox.prop('checked')) {
      return false;
    }

    const target = $(targetSelector).first();

    if (!target.length) {
      return false;
    }

    target
      .val(stringToSlug(source.val()))
      .trigger('input')
      .trigger('change');

    return true;

  }


  function bindHeaderSlugSync() {

    $(document)
      .off('input.automator-form-editor-slug keyup.automator-form-editor-slug change.automator-form-editor-slug')
      .on(
        'input.automator-form-editor-slug keyup.automator-form-editor-slug change.automator-form-editor-slug',
        '[data-automator-sync-slug-field]',
        function () {
          syncHeaderInputSlug(this);
        }
      );


    $(document)
      .off('change.automator-form-editor-slug-checkbox')
      .on(
        'change.automator-form-editor-slug-checkbox',
        '[id$="-sync"]',
        function () {

          const id = String(this.id || '').replace(/-sync$/, '');
          const input = $('#' + id);

          if (input.length) {
            syncHeaderInputSlug(input[0]);
          }

        }
      );

  }


  function prepareSidebarItems() {

    $(selectors.inserterList)
      .find('[data-block-type-id]')
      .each(function () {

        const item = $(this);

        item.removeAttr('onclick');
        item.removeAttr('draggable');
        item.removeAttr('data-bs-toggle');
        item.removeAttr('data-component-loading');
        item.removeAttr('data-component-loaded');

        item.css('opacity', '1');

      });

  }


  function loadSidebarComponents(callback = null) {

    const items =
      $(selectors.inserterList).find('[data-block-type-id]');

    formComponents = {};

    if (!items.length) {

      state.componentsLoaded = true;
      state.componentsLoading = false;

      if (typeof callback === 'function') {
        callback();
      }

      return;

    }

    state.componentsLoaded = false;
    state.componentsLoading = true;

    const requests = [];

    items.each(function () {

      const item = $(this);
      const fieldTypeID = String(item.attr('data-block-type-id') || '');

      if (!fieldTypeID) {
        return;
      }

      item.attr('data-component-loading', 'true');

      const request = $.ajax({
        url: window.AutomatorRoutes.apiEditor || '',
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          'Accept': 'application/json'
        },
        data: {
          fieldTypeID: fieldTypeID,
          mode: 'form'
        },
        dataType: 'json'
      })
      .done(function (response) {

        const campo =
          response && response.campo
            ? response.campo
            : (
                response && response.fieldType
                  ? response.fieldType
                  : null
              );

        formComponents[fieldTypeID] =
          normalizeFormComponentResponse(
            fieldTypeID,
            campo,
            item
          );

        item
          .removeAttr('data-component-loading')
          .attr('data-component-loaded', 'true');

      })
      .fail(function () {

        formComponents[fieldTypeID] =
          normalizeFormComponentResponse(
            fieldTypeID,
            null,
            item
          );

        item
          .removeAttr('data-component-loading')
          .attr('data-component-loaded', 'false');

      });

      requests.push(request);

    });

    $.when.apply($, requests).always(function () {

      state.componentsLoaded = true;
      state.componentsLoading = false;

      if (typeof callback === 'function') {
        callback();
      }

    });

  }


  function normalizeFormComponentResponse(fieldTypeID, campo, item) {

    const title =
      item.attr('data-bs-title') ||
      item.find('span').first().text() ||
      getFormFieldValue(campo, 'tbl_sys_field_type_title') ||
      getFormFieldValue(campo, 'title') ||
      'Campo';

    const icon =
      item.attr('data-block-icon') ||
      getFormFieldValue(campo, 'tbl_sys_field_type_icon') ||
      getFormFieldValue(campo, 'icon') ||
      'cube';

    const type =
      item.attr('data-block-type') ||
      getFormFieldValue(campo, 'tbl_sys_field_type_name') ||
      getFormFieldValue(campo, 'type') ||
      '';

    return {
      id: String(fieldTypeID),
      title: title,
      icon: icon,
      type: type,
      loaded: !!campo,
      raw: campo || null
    };

  }


  function getFormFieldValue(obj, key) {

    if (!obj || typeof obj !== 'object') {
      return '';
    }

    if (
      typeof obj[key] !== 'undefined' &&
      obj[key] !== null &&
      obj[key] !== ''
    ) {
      return obj[key];
    }

    return '';

  }


  /*
  |--------------------------------------------------------------------------
  | Inserção de campo
  |--------------------------------------------------------------------------
  */

  function addFieldFromSidebarItem(item) {

    if (!grapesEditor) {
      alert('Editor ainda não foi inicializado.');
      return false;
    }

    if (state.componentsLoading === true) {
      alert('Os campos ainda estão sendo carregados. Aguarde um instante.');
      return false;
    }

    const fieldTypeID = String(item.attr('data-block-type-id') || '');

    if (!fieldTypeID) {
      alert('Tipo de campo inválido.');
      return false;
    }

    const componentData = formComponents[fieldTypeID];

    if (!componentData || componentData.loaded !== true) {
      alert('Este campo não foi carregado corretamente.');
      return false;
    }

    insertFormFieldComponent({
      fieldTypeID: componentData.id,
      fieldTypeName: componentData.type,
      fieldTypeTitle: componentData.title,
      fieldIcon: componentData.icon,
      raw: componentData.raw
    });

    return true;

  }


  function insertFormFieldComponent(args) {

    const fieldData = createDefaultFieldData({
      fieldTypeID: args.fieldTypeID || '',
      fieldTypeName: args.fieldTypeName || '',
      fieldTypeTitle: args.fieldTypeTitle || '',
      fieldIcon: args.fieldIcon || 'square',
      raw: args.raw || {}
    });

    const component = buildFieldComponent(fieldData);

    const formComponent = getFormComponent();

    if (!formComponent) {
      alert('O formulário base não foi encontrado no editor.');
      return false;
    }

    let added;

    if (String(fieldData.tbl_sys_field_type_name || '').toLowerCase() === 'hidden') {
      added = formComponent.components().add(component, { at: 0 });
    } else {
      added = formComponent.components().add(component);
    }

    const addedComponent = Array.isArray(added) ? added[0] : added;

    if (addedComponent) {

      grapesEditor.select(addedComponent);

      setTimeout(function () {
        focusFieldRightSidebar();
        renderFieldSettings(addedComponent);
      }, 80);

    }

    reorderHiddenFields();

    state.hasChanges = true;

    setSaveState(true);
    syncFieldsFromCanvas();
    updateStructureList();
    syncCanvasHeight();
    syncEditorViewportSpacing();

    setTimeout(function() {
      normalizeGrapesToolsPointerEvents();
      bindCanvasClickSelection();
    }, 100);

    return true;

  }

  function reorderHiddenFields() {

    const formComponent = getFormComponent();

    if (!formComponent || !formComponent.components) {
      return false;
    }

    const hidden = [];
    const visible = [];

    formComponent.components().each(function(component) {

      const data = getFieldDataFromComponent(component);
      const type = String(data.tbl_sys_field_type_name || '').toLowerCase();

      if (type === 'hidden') {
        hidden.push(component);
      } else {
        visible.push(component);
      }

    });

    hidden.concat(visible).forEach(function(component, index) {

      if (component && component.move) {
        component.move(formComponent, { at: index });
      }

    });

    return true;

  }


  function createDefaultFieldData(args = {}) {

    const fieldTypeName = args.fieldTypeName || 'text';
    const fieldTitle = args.fieldTypeTitle || 'Campo';
    const raw = args.raw || {};

    const uniqueName = generateUniqueFieldName(fieldTypeName);
    const uniqueId = generateUniqueFieldId(uniqueName);

    const wrapperClass =
      fieldTypeName === 'hidden'
        ? ''
        : (getDefaultWrapperClassFromRawParams(raw) || 'col-12');

    return {
      uid: 'form-field-' + Date.now() + '-' + Math.floor(Math.random() * 999999),

      tbl_sys_forms_field_ID: '',
      tbl_sys_field_type_ID: args.fieldTypeID || '',
      tbl_sys_field_type_name: fieldTypeName,
      tbl_sys_field_type_icon: args.fieldIcon || 'square',

      tbl_sys_forms_field_title: fieldTitle,
      tbl_sys_forms_field_name: uniqueName,
      tbl_sys_forms_field_index: uniqueName,
      tbl_sys_forms_field_class: '',
      tbl_sys_forms_field_default: '',
      tbl_sys_forms_field_attrs: 'id="' + uniqueId + '"',
      tbl_sys_forms_field_required: false,
      tbl_sys_forms_field_locked: false,
      tbl_sys_forms_field_ordem: 0,

      field_access: normalizeAccessValues([]),

      raw: raw,

      tbl_sys_forms_field_props: {
        input_id: uniqueId,
        wrapper_class: wrapperClass,
        choices: {}
      }
    };

  }


  function generateUniqueFieldName(fieldTypeName = 'field') {

    let base = stringToSlug(fieldTypeName || 'field').replace(/-/g, '_');

    if (!base) {
      base = 'field';
    }

    let name = base + '_' + Date.now() + '_' + Math.floor(Math.random() * 9999);

    while (fieldNameExists(name)) {
      name = base + '_' + Date.now() + '_' + Math.floor(Math.random() * 999999);
    }

    return name;

  }


  function generateUniqueFieldId(fieldName = 'field') {

    let id = 'field_' + String(fieldName || 'field').replace(/[^a-zA-Z0-9_]/g, '_');

    while (fieldIdExists(id)) {
      id = 'field_' + Date.now() + '_' + Math.floor(Math.random() * 999999);
    }

    return id;

  }


  function fieldNameExists(name) {

    let exists = false;

    getFormFieldComponents().forEach(function(component) {

      const data = getFieldDataFromComponent(component);

      if (String(data.tbl_sys_forms_field_name || '') === String(name || '')) {
        exists = true;
      }

    });

    return exists;

  }


  function fieldIdExists(id) {

    let exists = false;

    getFormFieldComponents().forEach(function(component) {

      const data = getFieldDataFromComponent(component);
      const props = getFieldProps(data);

      if (String(props.input_id || '') === String(id || '')) {
        exists = true;
      }

    });

    return exists;

  }



  function buildFieldPreviewComponents(fieldData) {

    const type = String(fieldData.tbl_sys_field_type_name || 'text').toLowerCase();
    const props = getFieldProps(fieldData);
    const inputId = props.input_id || '';
    const inputName = fieldData.tbl_sys_forms_field_name || '';
    const hasPasswordButton = type === 'password' && fieldHasPasswordButton(fieldData);

    if (type === 'hidden') {
      return [];
    }

    if (type === 'relation' || type === 'relations') {

      const relationStatusComponents = buildRelationStatusPreviewComponents(fieldData);

      if (relationStatusComponents.length) {
        return relationStatusComponents;
      }

      const relationType = getRelationFieldType(fieldData);

      if (relationType === 'checkbox' || relationType === 'radio') {
        return buildChoiceListPreviewComponents(fieldData, relationType);
      }

    }

    if (type === 'checkbox' || type === 'dynamic-list' || type === 'dynamic_list') {
      return buildChoiceListPreviewComponents(fieldData, 'checkbox');
    }

    if (type === 'password') {

      const inputComponent = {
        tagName: 'div',
        classes: ['form-floating', 'flex-grow-1'],
        selectable: false,
        draggable: false,
        droppable: false,
        editable: false,
        removable: false,
        components: [
          {
            tagName: 'input',
            classes: ['form-control', 'automator-input-password'],
            attributes: {
              id: inputId,
              name: inputName,
              type: 'password',
              value: '',
              placeholder: fieldData.tbl_sys_forms_field_title || '',
              disabled: 'disabled',
              'data-automator-field': 'true',
              'data-automator-field-name': inputName,
              'data-automator-field-id': inputId
            },
            selectable: false,
            draggable: false,
            droppable: false,
            editable: false,
            removable: false
          },
          buildLabelComponent(fieldData)
        ]
      };

      if (hasPasswordButton) {
        return [
          {
            tagName: 'div',
            classes: ['input-group'],
            selectable: false,
            draggable: false,
            droppable: false,
            editable: false,
            removable: false,
            components: [
              inputComponent,
              {
                tagName: 'span',
                classes: ['input-group-text', 'p-0', 'text-center'],
                attributes: {
                  style: 'min-width: 50px;'
                },
                selectable: false,
                draggable: false,
                droppable: false,
                editable: false,
                removable: false,
                components: [
                  {
                    tagName: 'button',
                    classes: ['h-100', 'w-100', 'border-0'],
                    attributes: {
                      type: 'button',
                      disabled: 'disabled',
                      'data-show': 'Exibir senha',
                      'data-hide': 'Ocultar senha',
                      'data-bs-title': 'Exibir senha'
                    },
                    selectable: false,
                    draggable: false,
                    droppable: false,
                    editable: false,
                    removable: false,
                    components: [
                      {
                        tagName: 'i',
                        classes: ['fa', 'fa-eye'],
                        selectable: false,
                        draggable: false,
                        droppable: false,
                        editable: false,
                        removable: false
                      }
                    ]
                  }
                ]
              }
            ]
          }
        ];
      }

      return [inputComponent];

    }

    if (type === 'textarea' || type === 'editor' || type === 'json') {
      return [
        {
          tagName: 'div',
          classes: ['form-floating'],
          selectable: false,
          draggable: false,
          droppable: false,
          editable: false,
          removable: false,
          components: [
            {
              tagName: 'textarea',
              classes: ['form-control'],
              attributes: {
                id: inputId,
                name: inputName,
                placeholder: fieldData.tbl_sys_forms_field_title || '',
                disabled: 'disabled',
                style: 'height: 90px; min-height: 90px;'
              },
              selectable: false,
              draggable: false,
              droppable: false,
              editable: false,
              removable: false
            },
            buildLabelComponent(fieldData)
          ]
        }
      ];
    }

    if (type === 'select' || type === 'relation' || type === 'relations') {
      return [
        {
          tagName: 'div',
          classes: ['form-floating'],
          selectable: false,
          draggable: false,
          droppable: false,
          editable: false,
          removable: false,
          components: [
            {
              tagName: 'select',
              classes: ['form-select'],
              attributes: {
                id: inputId,
                name: inputName,
                disabled: 'disabled'
              },
              selectable: false,
              draggable: false,
              droppable: false,
              editable: false,
              removable: false,
              components: buildSelectOptions(fieldData)
            },
            buildLabelComponent(fieldData)
          ]
        }
      ];
    }

    return [
      {
        tagName: 'div',
        classes: ['form-floating'],
        selectable: false,
        draggable: false,
        droppable: false,
        editable: false,
        removable: false,
        components: [
          {
            tagName: 'input',
            classes: ['form-control'],
            attributes: {
              id: inputId,
              name: inputName,
              type: normalizeInputType(type),
              placeholder: fieldData.tbl_sys_forms_field_title || '',
              disabled: 'disabled'
            },
            selectable: false,
            draggable: false,
            droppable: false,
            editable: false,
            removable: false
          },
          buildLabelComponent(fieldData)
        ]
      }
    ];

  }


  function renderStaticPreviewChoiceInputsHtml(fieldData, inputType = 'checkbox') {

    const props = getFieldProps(fieldData);
    const choices = getFieldChoices(fieldData);

    const inputId = props.input_id || '';
    const inputName = fieldData.tbl_sys_forms_field_name || '';
    const title = fieldData.tbl_sys_forms_field_title || 'Campo';
    const keys = Object.keys(choices);

    const required = (
      fieldData.tbl_sys_forms_field_required === true ||
      fieldData.tbl_sys_forms_field_required === 1 ||
      fieldData.tbl_sys_forms_field_required === '1' ||
      fieldData.tbl_sys_forms_field_required === 'true'
    );

    const requiredAttr = required ? ' required' : '';
    const requiredMark = required ? ' <span class="text-danger">*</span>' : '';

    let html = '';

    if (String(title || '').trim() !== '') {
      html += '<label class="form-label small fw-bold d-block mb-2">' + escapeHtml(title) + requiredMark + '</label>';
    }

    if (keys.length) {

      keys.forEach(function(key, index) {

        const optionId = inputId + '_' + index;
        const optionName = inputType === 'checkbox' ? inputName + '[]' : inputName;
        const optionLabel = normalizeChoiceItemLabel(choices[key], key);

        html += '<input';
        html += ' id="' + escapeHtml(optionId) + '"';
        html += ' type="' + escapeHtml(inputType) + '"';
        html += ' name="' + escapeHtml(optionName) + '"';
        html += ' value="' + escapeHtml(key) + '"';
        html += ' class="btn-check"';
        html += ' data-automator-relation-disabled="false"';
        html += ' data-automator-field="true"';
        html += ' data-automator-field-name="' + escapeHtml(inputName) + '"';
        html += ' data-automator-field-id="' + escapeHtml(optionId) + '"';
        html += requiredAttr;
        html += ' />';

        html += '<label class="btn btn-outline-secondary mb-2 me-2" for="' + escapeHtml(optionId) + '">';
        html += escapeHtml(optionLabel);
        html += '</label>';

      });

    } else {

      html += '<div class="alert alert-warning mb-0 py-2 px-3">Configuração pendente</div>';

    }

    return html;

  }


  function buildLabelComponent(fieldData) {

    let label = escapeHtml(fieldData.tbl_sys_forms_field_title || 'Campo');

    if (fieldData.tbl_sys_forms_field_required === true || fieldData.tbl_sys_forms_field_required === 1 || fieldData.tbl_sys_forms_field_required === '1') {
      label += ' <span class="text-danger">*</span>';
    }

    return {
      tagName: 'label',
      content: label,
      draggable: false,
      droppable: false,
      selectable: false,
      editable: false,
      removable: false
    };

  }


  function createStaticPreviewOverlay() {

    removeStaticPreviewOverlay();

    syncFieldsFromCanvas();

    const canvas = $(selectors.canvas);

    if (!canvas.length) {
      return false;
    }

    const overlay = $('<div class="automator-form-editor-static-preview"></div>');

    overlay.html(renderStaticPreviewFormHtml());

    canvas.append(overlay);

    bindStaticPreviewEvents(overlay);
    applyStaticPreviewColumnStyles();

    syncCanvasDeviceViewport();
    syncCanvasHeight();

    return true;

  }

  function getActivePreviewViewportMode() {

    const mode = normalizeViewportMode(state.viewportMode || 'auto');

    if (mode !== 'auto') {
      return mode;
    }

    const label = String($(selectors.viewportLabel).text() || '').trim();

    return normalizeViewportMode(label || 'auto');

  }

  function getColumnSizeFromWrapperStrict(wrapperClass, breakpoint) {

    const classes = String(wrapperClass || '').split(/\s+/).filter(Boolean);

    if (breakpoint === 'xs') {

      const found = classes.find(function(cls) {
        return /^col-\d{1,2}$/.test(cls);
      });

      return found ? found.replace('col-', '') : '';

    }

    const found = classes.find(function(cls) {
      return new RegExp('^col-' + breakpoint + '-\\d{1,2}$').test(cls);
    });

    return found ? found.replace('col-' + breakpoint + '-', '') : '';

  }


  function removeStaticPreviewOverlay() {

    $('.automator-form-editor-static-preview').remove();

    return true;

  }


  function renderStaticPreviewFormHtml() {

    syncFieldsFromCanvas();

    const mode = getActivePreviewViewportMode();

    let html = '';

    html += '<form class="row" method="POST" action="#" data-submit="false" data-form-validate="false" data-preview-viewport="' + escapeHtml(mode) + '" onsubmit="return false;">';

    formFields.forEach(function(fieldData) {
      html += renderStaticPreviewFieldHtml(fieldData);
    });

    html += '</form>';

    return html;

  }


  function getPreviewColumnBreakpointByMode(mode) {

    mode = normalizeViewportMode(mode || state.viewportMode || 'auto');

    if (mode === 'auto') {
      return null;
    }

    return mode;

  }


  function getColumnSizeForPreviewViewport(wrapperClass, mode) {

    const viewportMode = normalizeViewportMode(mode || getActivePreviewViewportMode());

    if (viewportMode === 'auto') {
      return null;
    }

    const order = ['xs', 'sm', 'md', 'lg', 'xl', 'xxl'];
    const currentIndex = order.indexOf(viewportMode);

    if (currentIndex === -1) {
      return null;
    }

    let size = '';

    for (let i = 0; i <= currentIndex; i++) {

      const breakpoint = order[i];
      const value = getColumnSizeFromWrapperStrict(wrapperClass, breakpoint);

      if (value !== '') {
        size = value;
      }

    }

    if (size === '') {
      size = '12';
    }

    size = parseInt(size, 10);

    if (!size || size < 1 || size > 12) {
      size = 12;
    }

    return size;

  }


  function getPreviewWrapperStyle(wrapperClass) {

    const size = getColumnSizeForPreviewViewport(wrapperClass, getActivePreviewViewportMode());

    if (!size) {
      return '';
    }

    const percent = ((size / 12) * 100).toFixed(6);

    return 'flex:0 0 ' + percent + '%;width:' + percent + '%;max-width:' + percent + '%;';

  }



  function getPreviewWrapperClass(wrapperClass) {

    return normalizeBootstrapWrapperClass(wrapperClass || 'col-12');

  }

  function applyStaticPreviewColumnStyles() {

    const overlay = $('.automator-form-editor-static-preview');

    if (!overlay.length) {
      return false;
    }

    overlay.find('[data-preview-column-size]').each(function() {

      const el = this;
      const size = parseInt(el.getAttribute('data-preview-column-size') || '12', 10);
      const percent = ((size / 12) * 100).toFixed(6) + '%';

      el.style.setProperty('flex', '0 0 ' + percent, 'important');
      el.style.setProperty('width', percent, 'important');
      el.style.setProperty('max-width', percent, 'important');

    });

    return true;

  }


  function getAutomatorEditorAssetUrl(assetName) {

    assetName = String(assetName || '').trim();

    if (!assetName) {
      return '';
    }

    const el = document.querySelector(
      '[data-automator-editor-asset="' + assetName + '"]'
    );

    if (!el) {
      return '';
    }

    return (
      el.getAttribute('data-automator-editor-href') ||
      el.getAttribute('data-automator-editor-src') ||
      el.getAttribute('href') ||
      el.getAttribute('src') ||
      ''
    );

  }


  function getAutomatorEditorAssetsByType(type) {

    const assets = [];

    document
      .querySelectorAll('[data-automator-editor-asset]')
      .forEach(function(el) {

        const assetName = el.getAttribute('data-automator-editor-asset') || '';

        const url =
          el.getAttribute('data-automator-editor-href') ||
          el.getAttribute('data-automator-editor-src') ||
          el.getAttribute('href') ||
          el.getAttribute('src') ||
          '';

        if (!url) {
          return;
        }

        if (type === 'styles') {

          if (
            el.tagName.toLowerCase() === 'link' ||
            url.indexOf('.css') !== -1
          ) {
            assets.push({
              name: assetName,
              url: url
            });
          }

        }

        if (type === 'scripts') {

          if (
            el.tagName.toLowerCase() === 'script' ||
            url.indexOf('.js') !== -1
          ) {
            assets.push({
              name: assetName,
              url: url
            });
          }

        }

      });

    return assets;

  }



  function getCanvasStyleUrls() {

    const assets = getAutomatorEditorAssetsByType('styles');

    return assets
      .map(function(asset) {
        return asset.url;
      })
      .filter(Boolean)
      .filter(function(url, index, list) {
        return list.indexOf(url) === index;
      });

  }

  function getCanvasScriptUrls() {

    const preferredOrder = [
      'jquery',
      'mask',
      'validate',
      'sortable'
    ];

    const assets = getAutomatorEditorAssetsByType('scripts');
    const ordered = [];

    preferredOrder.forEach(function(assetName) {

      const found = assets.find(function(asset) {
        return asset.name === assetName;
      });

      if (found && found.url) {
        ordered.push(found.url);
      }

    });

    assets.forEach(function(asset) {

      if (ordered.indexOf(asset.url) === -1) {
        ordered.push(asset.url);
      }

    });

    return ordered.filter(Boolean);

  }


  function injectCanvasScripts() {

    if (!grapesEditor || !grapesEditor.Canvas) {
      return false;
    }

    const doc = grapesEditor.Canvas.getDocument();

    if (!doc || !doc.body) {
      return false;
    }

    getCanvasScriptUrls().forEach(function(url) {

      const exists = Array.prototype.slice
        .call(doc.querySelectorAll('script[src]'))
        .some(function(script) {
          return String(script.getAttribute('src') || '') === String(url);
        });

      if (exists) {
        return;
      }

      const script = doc.createElement('script');

      script.src = url;
      script.async = false;
      script.setAttribute('data-automator-editor-canvas-script', 'true');

      doc.body.appendChild(script);

    });

    return true;

  }


  function fieldHasPasswordButton(fieldData) {

    const props = getFieldProps(fieldData);

    if (
      props.hasButton === true ||
      props.hasButton === 1 ||
      props.hasButton === '1' ||
      props.hasButton === 'true'
    ) {
      return true;
    }

    if (
      props.advanced &&
      (
        props.advanced.hasButton === true ||
        props.advanced.hasButton === 1 ||
        props.advanced.hasButton === '1' ||
        props.advanced.hasButton === 'true'
      )
    ) {
      return true;
    }

    if (
      props.params &&
      (
        props.params['advanced.hasButton'] === true ||
        props.params['advanced.hasButton'] === 1 ||
        props.params['advanced.hasButton'] === '1' ||
        props.params['advanced.hasButton'] === 'true'
      )
    ) {
      return true;
    }

    return false;

  }



  function renderStaticPreviewFieldHtml(fieldData) {

    const type = String(fieldData.tbl_sys_field_type_name || 'text').toLowerCase();
    const props = getFieldProps(fieldData);

    const inputId = props.input_id || '';
    const inputName = fieldData.tbl_sys_forms_field_name || '';
    const title = fieldData.tbl_sys_forms_field_title || 'Campo';
    const wrapperClass = getFieldWrapperClass(fieldData);
    const previewClass = getPreviewWrapperClass(wrapperClass);
    const previewStyle = getPreviewWrapperStyle(wrapperClass);
    const previewSize = getColumnSizeForPreviewViewport(wrapperClass, getActivePreviewViewportMode()) || 12;

    const required = (
      fieldData.tbl_sys_forms_field_required === true ||
      fieldData.tbl_sys_forms_field_required === 1 ||
      fieldData.tbl_sys_forms_field_required === '1' ||
      fieldData.tbl_sys_forms_field_required === 'true'
    );

    const requiredAttr = required ? ' required' : '';
    const requiredMark = required ? ' <span class="text-danger">*</span>' : '';

    if (type === 'hidden') {
      return '<input type="hidden" id="' + escapeHtml(inputId) + '" name="' + escapeHtml(inputName) + '" value="' + escapeHtml(fieldData.tbl_sys_forms_field_default || '') + '">';
    }

    let html = '';

    html += '<div class="mb-3 ' + escapeHtml(previewClass) + '" data-preview-column-size="' + escapeHtml(previewSize) + '" style="' + escapeHtml(previewStyle) + '">';

    if (type === 'relation' || type === 'relations') {

      const relationType = getRelationFieldType(fieldData);

      if (relationType === 'checkbox' || relationType === 'radio') {

        html += renderStaticPreviewChoiceInputsHtml(fieldData, relationType);

      } else {

        html += '<div class="form-floating">';
        html += '<select class="form-select" id="' + escapeHtml(inputId) + '" name="' + escapeHtml(inputName) + '"' + requiredAttr + '>';
        html += renderStaticPreviewSelectOptions(fieldData);
        html += '</select>';
        html += '<label for="' + escapeHtml(inputId) + '">' + escapeHtml(title) + requiredMark + '</label>';
        html += '</div>';

      }

    } else if (type === 'select') {

      html += '<div class="form-floating">';
      html += '<select class="form-select" id="' + escapeHtml(inputId) + '" name="' + escapeHtml(inputName) + '"' + requiredAttr + '>';
      html += renderStaticPreviewSelectOptions(fieldData);
      html += '</select>';
      html += '<label for="' + escapeHtml(inputId) + '">' + escapeHtml(title) + requiredMark + '</label>';
      html += '</div>';

    } else if (type === 'textarea' || type === 'editor' || type === 'json') {

      html += '<div class="form-floating">';
      html += '<textarea class="form-control" id="' + escapeHtml(inputId) + '" name="' + escapeHtml(inputName) + '" placeholder="' + escapeHtml(title) + '" style="min-height: 90px;"' + requiredAttr + '>' + escapeHtml(fieldData.tbl_sys_forms_field_default || '') + '</textarea>';
      html += '<label for="' + escapeHtml(inputId) + '">' + escapeHtml(title) + requiredMark + '</label>';
      html += '</div>';

    } else if (type === 'checkbox' || type === 'dynamic-list' || type === 'dynamic_list') {

      html += renderStaticPreviewChoiceInputsHtml(fieldData, 'checkbox');

    } else if (type === 'password') {

      const hasPasswordButton = fieldHasPasswordButton(fieldData);

      if (hasPasswordButton) {

        html += '<div class="input-group">';
        html += '<div class="form-floating flex-grow-1">';
        html += '<input type="password" class="form-control automator-input-password" id="' + escapeHtml(inputId) + '" name="' + escapeHtml(inputName) + '" value="" placeholder="' + escapeHtml(title) + '"' + requiredAttr + '>';
        html += '<label for="' + escapeHtml(inputId) + '">' + escapeHtml(title) + requiredMark + '</label>';
        html += '</div>';
        html += '<span class="input-group-text p-0 text-center" style="min-width: 50px;">';
        html += '<button type="button" class="h-100 w-100 border-0" data-show="Exibir senha" data-hide="Ocultar senha" onclick="AutomatorPasswordInputBTN(this, \'' + escapeHtml(inputId) + '\')" data-bs-title="Exibir senha"><i class="fa fa-eye"></i></button>';
        html += '</span>';
        html += '</div>';

      } else {

        html += '<div class="form-floating">';
        html += '<input type="password" class="form-control automator-input-password" id="' + escapeHtml(inputId) + '" name="' + escapeHtml(inputName) + '" value="" placeholder="' + escapeHtml(title) + '"' + requiredAttr + '>';
        html += '<label for="' + escapeHtml(inputId) + '">' + escapeHtml(title) + requiredMark + '</label>';
        html += '</div>';

      }

    } else {

      html += '<div class="form-floating">';
      html += '<input type="' + escapeHtml(normalizeInputType(type)) + '" class="form-control" id="' + escapeHtml(inputId) + '" name="' + escapeHtml(inputName) + '" value="' + escapeHtml(fieldData.tbl_sys_forms_field_default || '') + '" placeholder="' + escapeHtml(title) + '"' + requiredAttr + '>';
      html += '<label for="' + escapeHtml(inputId) + '">' + escapeHtml(title) + requiredMark + '</label>';
      html += '</div>';

    }

    html += '</div>';

    return html;

  }


  function renderStaticPreviewSelectOptions(fieldData) {

    const choices = getFieldChoices(fieldData);
    const props = getFieldProps(fieldData);

    const selectedValue = String(
      typeof props.preview_value !== 'undefined'
        ? props.preview_value
        : (
            typeof fieldData.tbl_sys_forms_field_default !== 'undefined'
              ? fieldData.tbl_sys_forms_field_default
              : ''
          )
    );

    let html = '';

    if (getFieldHasEmptyOption(fieldData)) {

      const required = fieldData.tbl_sys_forms_field_required === true || fieldData.tbl_sys_forms_field_required === 1 || fieldData.tbl_sys_forms_field_required === '1' || fieldData.tbl_sys_forms_field_required === 'true';

      html += '<option value=""' + (selectedValue === '' ? ' selected' : '') + (required ? ' disabled' : '') + '>';
      html += escapeHtml(getFieldEmptyOptionText(fieldData) || 'Selecione uma opção');
      html += '</option>';

    }

    Object.keys(choices).forEach(function(key) {

      html += '<option value="' + escapeHtml(key) + '"' + (String(key) === selectedValue ? ' selected' : '') + '>';
      html += escapeHtml(normalizeChoiceItemLabel(choices[key], key));
      html += '</option>';

    });

    if (!Object.keys(choices).length) {
      html += '<option value="">Configuração pendente</option>';
    }

    return html;

  }


  function bindStaticPreviewEvents(overlay) {

    overlay
      .off('.automator-form-editor-static-preview')
      .on('change.automator-form-editor-static-preview input.automator-form-editor-static-preview', 'input, select, textarea', function() {

        const input = $(this);
        const name = input.attr('name');

        if (!name) {
          return;
        }

        const fieldData = formFields.find(function(item) {
          return String(item.tbl_sys_forms_field_name || '') === String(name || '').replace(/\[\]$/, '');
        });

        if (!fieldData) {
          return;
        }

        const component = findFormFieldComponentByUid(fieldData.uid);

        if (!component) {
          return;
        }

        const props = getFieldProps(fieldData);

        if (input.attr('type') === 'checkbox') {
          props.preview_value = input.prop('checked') ? '1' : '0';
        } else {
          props.preview_value = input.val();
        }

        fieldData.tbl_sys_forms_field_props = props;

        const attrs = component.getAttributes ? component.getAttributes() : {};
        attrs['data-automator-form-field-data'] = encodeFieldData(fieldData);

        component.setAttributes(attrs);

      });

    return true;

  }



  function buildSelectOptions(fieldData) {

    const choices = getFieldChoices(fieldData);
    const props = getFieldProps(fieldData);
    const components = [];

    const selectedValue = String(
      typeof props.preview_value !== 'undefined'
        ? props.preview_value
        : (
            typeof fieldData.tbl_sys_forms_field_default !== 'undefined'
              ? fieldData.tbl_sys_forms_field_default
              : ''
          )
    );

    if (getFieldHasEmptyOption(fieldData)) {

      const attrs = {
        value: ''
      };

      if (selectedValue === '') {
        attrs.selected = 'selected';
      }

      if (
        fieldData.tbl_sys_forms_field_required === true ||
        fieldData.tbl_sys_forms_field_required === 1 ||
        fieldData.tbl_sys_forms_field_required === '1' ||
        fieldData.tbl_sys_forms_field_required === 'true'
      ) {
        attrs.disabled = 'disabled';
      }

      components.push({
        tagName: 'option',
        attributes: attrs,
        content: getFieldEmptyOptionText(fieldData) || 'Selecione uma opção',
        draggable: false,
        droppable: false,
        selectable: false,
        editable: false,
        removable: false
      });

    }

    Object.keys(choices).forEach(function(key) {

      const attrs = {
        value: key
      };

      if (String(key) === selectedValue) {
        attrs.selected = 'selected';
      }

      components.push({
        tagName: 'option',
        attributes: attrs,
        content: choices[key],
        draggable: false,
        droppable: false,
        selectable: false,
        editable: false,
        removable: false
      });

    });

    return components;

  }


  function findFormFieldComponentByUid(uid) {

    if (!uid) {
      return null;
    }

    let found = null;

    getFormFieldComponents().forEach(function(component) {

      if (found) {
        return;
      }

      const attrs = component.getAttributes ? component.getAttributes() : {};

      if (attrs['data-automator-form-field-uid'] === uid) {
        found = component;
      }

    });

    return found;

  }


  function bindPreviewFieldEvents() {

    if (
      !grapesEditor ||
      !grapesEditor.Canvas ||
      typeof grapesEditor.Canvas.getDocument !== 'function'
    ) {
      return false;
    }

    const doc = grapesEditor.Canvas.getDocument();

    if (!doc) {
      return false;
    }

    $(doc)
      .off('change.automator-form-editor-preview-field')
      .on(
        'change.automator-form-editor-preview-field',
        '[data-automator-form-field="true"] input, [data-automator-form-field="true"] select, [data-automator-form-field="true"] textarea',
        function() {

          if (state.previewMode !== true) {
            return;
          }

          const input = $(this);
          const wrapper = input.closest('[data-automator-form-field="true"]');

          if (!wrapper.length) {
            return;
          }

          const uid = wrapper.attr('data-automator-form-field-uid');
          const component = findFormFieldComponentByUid(uid);

          if (!component) {
            return;
          }

          let fieldData = getFieldDataFromComponent(component);
          const props = getFieldProps(fieldData);

          if (input.attr('type') === 'checkbox') {
            props.preview_value = input.prop('checked') ? '1' : '0';
          } else {
            props.preview_value = input.val();
          }

          fieldData.tbl_sys_forms_field_props = props;

          const attrs = component.getAttributes ? component.getAttributes() : {};
          attrs['data-automator-form-field-data'] = encodeFieldData(fieldData);

          component.setAttributes(attrs);

        }
      );

    return true;

  }


  function normalizeInputType(type) {

    const allowed = [
      'text',
      'number',
      'email',
      'url',
      'password',
      'date',
      'time',
      'datetime-local',
      'file'
    ];

    if (type === 'interval') {
      return 'number';
    }

    if (allowed.indexOf(type) !== -1) {
      return type;
    }

    return 'text';

  }


  /*
  |--------------------------------------------------------------------------
  | Dados do campo
  |--------------------------------------------------------------------------
  */

  function encodeFieldData(data) {

    try {
      return btoa(unescape(encodeURIComponent(JSON.stringify(data || {}))));
    } catch (e) {
      return '';
    }

  }


  function decodeFieldData(value) {

    try {
      return JSON.parse(decodeURIComponent(escape(atob(value || ''))));
    } catch (e) {
      return {};
    }

  }


  function getFieldDataFromComponent(component) {

    if (!component || !component.getAttributes) {
      return {};
    }

    const attrs = component.getAttributes();

    return decodeFieldData(attrs['data-automator-form-field-data'] || '');

  }


  function setFieldDataToComponent(component, fieldData, options = {}) {

    if (!component || !component.setAttributes) {
      return false;
    }

    const type = String(fieldData.tbl_sys_field_type_name || '').toLowerCase();
    const attrs = component.getAttributes ? component.getAttributes() : {};

    attrs['data-automator-form-field-data'] = encodeFieldData(fieldData);
    attrs['data-automator-field-type-title'] = fieldData.tbl_sys_forms_field_title || '';
    attrs['data-automator-field-type-name'] = fieldData.tbl_sys_field_type_name || '';
    attrs['data-automator-field-type-id'] = fieldData.tbl_sys_field_type_ID || '';

    component.setAttributes(attrs);
    component.set('name', fieldData.tbl_sys_forms_field_title || 'Campo');

    if (type === 'hidden') {

      const props = getFieldProps(fieldData);

      attrs.type = 'hidden';
      attrs.id = props.input_id || '';
      attrs.name = fieldData.tbl_sys_forms_field_name || '';
      attrs.value = fieldData.tbl_sys_forms_field_default || '';
      attrs['data-automator-hidden-field'] = 'true';

      component.setAttributes(attrs);
      component.setStyle({ display: 'none' });

    } else {

      component.setClass(getFieldComponentClasses(fieldData));

      component.setStyle({
        height: 'auto',
        'min-height': '0'
      });

      component.components([
        {
          type: 'default',
          tagName: 'div',
          classes: ['automator-form-editor-field-preview'],
          draggable: false,
          droppable: false,
          selectable: false,
          hoverable: false,
          highlightable: false,
          copyable: false,
          removable: false,
          components: buildFieldPreviewComponents(fieldData)
        }
      ]);

    }

    reorderHiddenFields();

    if (options.silent !== true && state.suppressChangeTracking !== true) {
      state.hasChanges = true;
      setSaveState(true);
    }

    syncFieldsFromCanvas();
    updateStructureList();

    if (options.refreshPanel !== false && !isEditingPropertiesPanel()) {
      renderFieldSettings(component);
    }

    if (options.skipResize !== true && !isEditingPropertiesPanel()) {
      syncCanvasHeight();
      syncEditorViewportSpacing();
    }

    return true;

  }



  function getFieldProps(fieldData) {

    let props = fieldData.tbl_sys_forms_field_props || {};

    if (typeof props === 'string') {

      try {
        props = JSON.parse(props);
      } catch (e) {
        props = {};
      }

    }

    if (!props || typeof props !== 'object') {
      props = {};
    }

    return props;

  }


  function getFieldWrapperClass(fieldData) {

    const props = getFieldProps(fieldData);

    return normalizeBootstrapWrapperClass(props.wrapper_class || 'col-12');

  }


  function setFieldProp(fieldData, key, value) {

    const props = getFieldProps(fieldData);

    props[key] = value;

    fieldData.tbl_sys_forms_field_props = props;

    return fieldData;

  }


  function getFieldChoices(fieldData) {

    const props = getFieldProps(fieldData);
    const type = String(fieldData.tbl_sys_field_type_name || '').toLowerCase();

    if (type === 'relation' || type === 'relations') {

      const relationChoices = getRelationChoicesFromState(fieldData);

      if (Object.keys(relationChoices).length) {
        return relationChoices;
      }

    }

    if (props.choices && typeof props.choices === 'object') {
      return props.choices;
    }

    if (props.values && typeof props.values === 'object') {
      return props.values;
    }

    return {};

  }



  function buildChoiceListPreviewComponents(fieldData, inputType = 'checkbox') {

    const props = getFieldProps(fieldData);
    const choices = getFieldChoices(fieldData);
    const inputId = props.input_id || '';
    const inputName = fieldData.tbl_sys_forms_field_name || '';
    const title = fieldData.tbl_sys_forms_field_title || 'Campo';
    const keys = Object.keys(choices);
    const components = [];

    if (String(title || '').trim() !== '') {
      components.push({
        tagName: 'label',
        classes: ['form-label', 'small', 'fw-bold', 'd-block', 'mb-2'],
        content: escapeHtml(title),
        selectable: false,
        draggable: false,
        droppable: false,
        editable: false,
        removable: false
      });
    }

    if (keys.length) {

      keys.forEach(function(key, index) {

        const optionId = inputId + '_' + index;
        const optionName = inputType === 'checkbox' ? inputName + '[]' : inputName;
        const optionLabel = normalizeChoiceItemLabel(choices[key], key);

        components.push({
          tagName: 'div',
          classes: ['form-check', 'py-1'],
          selectable: false,
          draggable: false,
          droppable: false,
          editable: false,
          removable: false,
          components: [
            {
              tagName: 'input',
              classes: ['form-check-input'],
              attributes: {
                id: optionId,
                name: optionName,
                type: inputType,
                value: key,
                disabled: 'disabled',
                'data-automator-relation-disabled': 'false',
                'data-automator-field': 'true',
                'data-automator-field-name': inputName,
                'data-automator-field-id': optionId
              },
              selectable: false,
              draggable: false,
              droppable: false,
              editable: false,
              removable: false
            },
            {
              tagName: 'label',
              classes: ['form-check-label'],
              attributes: {
                for: optionId
              },
              content: escapeHtml(optionLabel),
              selectable: false,
              draggable: false,
              droppable: false,
              editable: false,
              removable: false
            }
          ]
        });

      });

    } else {

      components.push({
        tagName: 'div',
        classes: ['alert', 'alert-warning', 'mb-0', 'py-2', 'px-3'],
        content: 'Configuração pendente',
        selectable: false,
        draggable: false,
        droppable: false,
        editable: false,
        removable: false
      });

    }

    return [
      {
        tagName: 'div',
        classes: ['automator-form-editor-checkbox-list'],
        selectable: false,
        draggable: false,
        droppable: false,
        editable: false,
        removable: false,
        components: components
      }
    ];

  }

  function setFieldChoicesFromText(fieldData, text) {

    const choices = {};
    const lines = String(text || '').split('\n');

    lines.forEach(function (line) {

      line = String(line || '').trim();

      if (!line) {
        return;
      }

      const parts = line.split('|');

      const key = String(parts[0] || '').trim();
      const label = String(parts[1] || parts[0] || '').trim();

      if (key !== '') {
        choices[key] = label;
      }

    });

    return setFieldProp(fieldData, 'choices', choices);

  }


  function choicesToText(fieldData) {

    const choices = getFieldChoices(fieldData);

    return Object.keys(choices)
      .map(function (key) {
        return key + '|' + choices[key];
      })
      .join('\n');

  }


  /*
  |--------------------------------------------------------------------------
  | Painel de propriedades do campo
  |--------------------------------------------------------------------------
  */


  function getComponentFromChoicesBuilder(builder) {

    const cid = $(builder).closest('.automator-form-editor-choices-builder').attr('data-component-cid');

    if (cid) {
      return findComponentByCid(cid);
    }

    if (grapesEditor) {
      const selected = grapesEditor.getSelected();

      if (selected) {
        return getClosestFormFieldComponent(selected);
      }
    }

    return null;

  }


  function isFieldLockedForCurrentUser(fieldData) {

    if (state.currentUserIsDeveloper === true) {
      return false;
    }

    return isTruthyValue(fieldData.tbl_sys_forms_field_locked);

  }


  function renderFieldSecurityAccordion(fieldData, component) {

    const componentCid = component && component.cid ? component.cid : '';
    const collapseId = 'automator-form-editor-field-security-' + componentCid;
    const selectedValues = normalizeAccessValues(fieldData.field_access || []);
    const disabled = isFieldLockedForCurrentUser(fieldData);

    let html = '';

    html += '<div class="accordion automator-editor-settings-accordion mx-0" id="automator-form-editor-field-security-accordion-' + escapeHtml(componentCid) + '">';
    html += '<div class="accordion-item border-start-0 border-end-0 rounded-0">';
    html += '<h2 class="accordion-header">';
    html += '<button class="accordion-button collapsed py-2 px-3 small fw-bold rounded-0" type="button" data-bs-toggle="collapse" data-bs-target="#' + escapeHtml(collapseId) + '">';
    html += 'Segurança';
    html += '</button>';
    html += '</h2>';
    html += '<div id="' + escapeHtml(collapseId) + '" class="accordion-collapse collapse">';
    html += '<div class="accordion-body px-3 py-2 automator-form-editor-field-security-access" data-component-cid="' + escapeHtml(componentCid) + '">';
    html += renderAccessCheckboxList('field_access', selectedValues, 'field', disabled);
    html += '</div>';
    html += '</div>';
    html += '</div>';
    html += '</div>';

    return html;

  }


  function bindFieldSecurityEvents(component) {

    const panel = $(selectors.rightContent);

    panel
      .off('.automator-form-editor-field-security')
      .on(
        'change.automator-form-editor-field-security',
        '.automator-form-editor-field-security-access .automator-form-editor-access-checkbox',
        function() {

          const input = $(this);

          if (input.attr('data-developer') === 'true') {
            input.prop('checked', true);
          }

          syncFieldAccessFromPanel(component);

        }
      );

    return true;

  }


  function syncFieldAccessFromPanel(component) {

    if (!component) {
      return false;
    }

    let fieldData = getFieldDataFromComponent(component);

    if (isFieldLockedForCurrentUser(fieldData)) {
      return false;
    }

    const panel = $(selectors.rightContent).find('.automator-form-editor-field-security-access').first();

    if (!panel.length) {
      return false;
    }

    fieldData.field_access = getCheckedAccessValues(panel);

    setFieldDataToComponent(component, fieldData, {
      refreshPanel: false,
      skipResize: true
    });

    updateLiveFormFieldElement(component, fieldData);

    setSaveState(true);

    return true;

  }


  function renderFieldSettings(component) {

    const fieldData = getFieldDataFromComponent(component);
    const locked = isFieldLockedForCurrentUser(fieldData);

    fieldData.__component = component;

    let disabledAttr = locked ? ' disabled' : '';
    let html = '';

    if (locked) {
      html += '<div class="alert alert-warning mx-3 mt-3 mb-2 small">';
      html += 'Este campo está bloqueado. Apenas usuários desenvolvedores podem alterar suas configurações.';
      html += '</div>';
    }

    html += '<div class="mb-3 mt-1 px-3">';
    html += '<label class="form-label small fw-bold">Tipo de campo</label>';
    html += '<input type="text" class="form-control form-control-sm" value="' + escapeHtml(fieldData.tbl_sys_field_type_name || '') + '" disabled>';
    html += '</div>';

    html += '<div class="mb-3 px-3">';
    html += '<label class="form-label small fw-bold">Título</label>';
    html += '<input type="text" class="form-control form-control-sm automator-form-field-property" data-property="tbl_sys_forms_field_title" value="' + escapeHtml(fieldData.tbl_sys_forms_field_title || '') + '"' + disabledAttr + '>';
    html += '</div>';

    html += '<div class="mb-3 px-3">';
    html += '<label class="form-label small fw-bold">Nome do campo</label>';
    html += '<input type="text" class="form-control form-control-sm automator-form-field-property" data-property="tbl_sys_forms_field_name" value="' + escapeHtml(fieldData.tbl_sys_forms_field_name || '') + '"' + disabledAttr + '>';
    html += '</div>';

    html += '<div class="mb-3 px-3">';
    html += '<label class="form-label small fw-bold">Índice</label>';
    html += '<input type="text" class="form-control form-control-sm automator-form-field-property" data-property="tbl_sys_forms_field_index" value="' + escapeHtml(fieldData.tbl_sys_forms_field_index || '') + '"' + disabledAttr + '>';
    html += '</div>';

    html += renderFormFieldApiProperties(fieldData, component);

    html += renderFieldSecurityAccordion(fieldData, component);

    html += '<div class="px-3 py-3">';
    html += '<button type="button" class="btn btn-outline-danger btn-sm w-100" onclick="SysAutomatorFormEditor.deleteSelectedField()"' + disabledAttr + '>';
    html += '<i class="fa fa-trash me-1"></i> Excluir campo';
    html += '</button>';
    html += '</div>';

    delete fieldData.__component;

    $(selectors.rightContent).html(html);

    if (locked) {
      $(selectors.rightContent).find('input, select, textarea, button').prop('disabled', true);
      $(selectors.rightContent).find('[data-developer="true"]').prop('checked', true).prop('disabled', true);
    }

    bindFieldPropertyInputs(component);
    bindFormFieldApiProperties(component);
    bindFieldSecurityEvents(component);

  }


  function renderFormFieldApiProperties(fieldData, component) {

    const params = getFormFieldParams(fieldData);
    const componentCid = component.cid;
    const fieldType = String(fieldData.tbl_sys_field_type_name || '').toLowerCase();
    const isRelation = fieldType === 'relation' || fieldType === 'relations';

    let html = '';

    html += '<div class="accordion automator-editor-settings-accordion mx-0" id="automator-form-editor-settings-accordion-' + escapeHtml(componentCid) + '">';

    let groups = [];

    $.each(params, function(groupKey, group) {
      groups.push({
        key: groupKey,
        group: group
      });
    });

    if (isRelation) {

      groups.sort(function(a, b) {

        const aKey = String(a.key || '').toLowerCase();
        const bKey = String(b.key || '').toLowerCase();
        const aLabel = String(a.group.label || '').toLowerCase();
        const bLabel = String(b.group.label || '').toLowerCase();

        const aIsConfig = aKey === 'configs' || aKey === 'configuracoes' || aKey === 'configurações' || aLabel === 'configurações' || aLabel === 'configuracoes';
        const bIsConfig = bKey === 'configs' || bKey === 'configuracoes' || bKey === 'configurações' || bLabel === 'configurações' || bLabel === 'configuracoes';

        const aIsOptions = aKey === 'options' || aKey === 'opcoes' || aKey === 'opções' || aLabel === 'opções' || aLabel === 'opcoes';
        const bIsOptions = bKey === 'options' || bKey === 'opcoes' || bKey === 'opções' || bLabel === 'opções' || bLabel === 'opcoes';

        if (aIsConfig && !bIsConfig) return -1;
        if (!aIsConfig && bIsConfig) return 1;

        if (aIsOptions && !bIsOptions) return bIsConfig ? 1 : -1;
        if (!aIsOptions && bIsOptions) return aIsConfig ? -1 : 1;

        return 0;

      });

    }

    groups.forEach(function(item) {

      const groupKey = item.key;
      const group = item.group;
      const collapseId = 'automator-form-editor-settings-' + componentCid + '-' + groupKey;

      html += '<div class="accordion-item border-start-0 border-end-0 rounded-0">';
      html += '<h2 class="accordion-header">';
      html += '<button class="accordion-button collapsed py-2 px-3 small fw-bold rounded-0" type="button" data-bs-toggle="collapse" data-bs-target="#' + escapeHtml(collapseId) + '">';
      html += escapeHtml(group.label || groupKey);
      html += '</button>';
      html += '</h2>';

      html += '<div id="' + escapeHtml(collapseId) + '" class="accordion-collapse collapse">';
      html += '<div class="accordion-body px-3 py-2">';

      if (
        isRelation &&
        (
          groupKey === 'options' ||
          groupKey === 'opcoes' ||
          groupKey === 'opções' ||
          String(group.label || '').toLowerCase() === 'opções' ||
          String(group.label || '').toLowerCase() === 'opcoes'
        )
      ) {

        html += renderRelationDatabaseOptionsFields(fieldData);

      } else {

        $.each(group.fields || {}, function(fieldKey, field) {

          const inputName = groupKey + '.' + fieldKey;
          const defaultValue = getFormFieldStoredParamValue(fieldData, inputName, field.default || '');

          html += renderFormFieldApiPropertyField(
            fieldKey,
            field,
            inputName,
            defaultValue,
            fieldData
          );

        });

      }

      html += '</div>';
      html += '</div>';
      html += '</div>';

    });

    html += '</div>';

    return html;

  }


  function renderRelationDatabaseOptionsFields(fieldData) {

    const props = getFieldProps(fieldData);
    const relation = props.relation && typeof props.relation === 'object' ? props.relation : {};

    let html = '';

    html += renderRelationDatabaseSelectField(
      'Tabela destino',
      'relation.table',
      relation.table || '',
      'automator-relation-table-target'
    );

    html += renderRelationDatabaseSelectField(
      'Campo destino',
      'relation.value',
      relation.value || '',
      'automator-relation-column-value'
    );

    html += renderRelationDatabaseSelectField(
      'Label destino',
      'relation.label',
      relation.label || '',
      'automator-relation-column-label'
    );

    html += '<div class="form-text mt-2">';
    html += 'As opções serão geradas usando <strong>campo destino</strong> como value e <strong>label destino</strong> como texto exibido.';
    html += '</div>';

    return html;

  }


  function renderRelationDatabaseSelectField(label, propertyName, value, extraClass) {

    let html = '';

    html += '<div class="mb-3">';
    html += '<label class="form-label small fw-bold">' + escapeHtml(label) + '</label>';
    html += '<select class="form-select form-select-sm automator-form-editor-api-property automator-relation-db-select ' + escapeHtml(extraClass || '') + '" data-field-type="relation-db-select" data-field-key="' + escapeHtml(propertyName) + '" data-property-name="' + escapeHtml(propertyName) + '" data-current-value="' + escapeHtml(value || '') + '">';
    html += '<option value="">Carregando...</option>';
    html += '</select>';
    html += '</div>';

    return html;

  }


  function getRelationDatabaseAdminUrl() {

    if (
      typeof window.AutomatorRoutes !== 'undefined' &&
      window.AutomatorRoutes.apiAdmin
    ) {
      return window.AutomatorRoutes.apiAdmin;
    }

    return '';

  }


  function getRelationDatabaseCache() {

    if (!state.relationDatabaseCache || typeof state.relationDatabaseCache !== 'object') {
      state.relationDatabaseCache = {
        loadingCount: 0
      };
    }

    if (typeof state.relationDatabaseCache.loadingCount === 'undefined') {
      state.relationDatabaseCache.loadingCount = 0;
    }

    return state.relationDatabaseCache;

  }

  function showRelationDatabaseLoader() {

    const cache = getRelationDatabaseCache();

    cache.loadingCount++;

    if (cache.loadingCount > 1) {
      return true;
    }

    if (typeof showFormEditorLoader === 'function') {
      showFormEditorLoader();
      return true;
    }

    if (typeof AutomatorPageLoader === 'function') {
      AutomatorPageLoader('show');
      return true;
    }

    return false;

  }


  function hideRelationDatabaseLoader() {

    const cache = getRelationDatabaseCache();

    cache.loadingCount--;

    if (cache.loadingCount > 0) {
      return true;
    }

    cache.loadingCount = 0;

    if (typeof hideFormEditorLoader === 'function') {
      hideFormEditorLoader();
      return true;
    }

    if (typeof AutomatorPageLoader === 'function') {
      AutomatorPageLoader('hide');
      return true;
    }

    return false;

  }


  function postRelationDatabaseData(data, callback) {

    const url = getRelationDatabaseAdminUrl();

    if (!url) {

      if (typeof callback === 'function') {
        callback({
          status: false,
          data: [],
          message: 'Rota administrativa não encontrada.'
        });
      }

      return false;

    }

    $.ajax({
      url: url,
      type: 'POST',
      dataType: 'json',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Accept': 'application/json'
      },
      data: data,
      success: function(response) {

        if (typeof callback === 'function') {
          callback(response || {});
        }

      },
      error: function(xhr) {

        let response = {};

        if (xhr && xhr.responseJSON) {
          response = xhr.responseJSON;
        }

        if (typeof callback === 'function') {
          callback(response || {
            status: false,
            data: []
          });
        }

      }
    });

    return true;

  }



  function loadRelationDatabaseTables(callback, options = {}) {

    if (options.showLoader === true) {
      showRelationDatabaseLoader();
    }

    postRelationDatabaseData({
      acao: 'get-database-data',
      'data-type': 'get-tables'
    }, function(response) {

      if (options.showLoader === true) {
        hideRelationDatabaseLoader();
      }

      const tables = Array.isArray(response.data) ? response.data : [];

      if (typeof callback === 'function') {
        callback(tables);
      }

    });

    return true;

  }


  function loadRelationDatabaseColumns(tableName, callback, options = {}) {

    tableName = String(tableName || '').trim();

    if (!tableName) {

      if (typeof callback === 'function') {
        callback([]);
      }

      return false;

    }

    if (options.showLoader === true) {
      showRelationDatabaseLoader();
    }

    postRelationDatabaseData({
      acao: 'get-database-data',
      'data-type': 'get-table-columns',
      'table-name': tableName
    }, function(response) {

      if (options.showLoader === true) {
        hideRelationDatabaseLoader();
      }

      const columns = Array.isArray(response.data) ? response.data : [];

      if (typeof callback === 'function') {
        callback(columns);
      }

    });

    return true;

  }


  function populateRelationDatabaseSelect(select, items, selectedValue, options = {}) {

    const el = $(select);

    el.data('relation-populating', true);

    let html = '';

    html += '<option value="">Selecione uma opção</option>';

    (items || []).forEach(function(item) {

      const value = String(item.value || '');
      const label = String(item.label || value);
      const disabled = (
        options.disabledValue !== undefined &&
        options.disabledValue !== null &&
        String(options.disabledValue) !== '' &&
        String(options.disabledValue) === value
      );

      html += '<option value="' + escapeHtml(value) + '"' + (disabled ? ' disabled' : '') + '>';
      html += escapeHtml(label);
      html += '</option>';

    });

    el.html(html);
    el.val(String(selectedValue || ''));

    if (String(selectedValue || '') !== '' && el.val() !== String(selectedValue || '')) {

      const selectedItem = (items || []).find(function(item) {
        return String(item.value || '') === String(selectedValue || '');
      });

      if (selectedItem) {

        el.append(
          '<option value="' + escapeHtml(selectedValue) + '" selected disabled>' +
          escapeHtml(selectedItem.label || selectedValue) +
          '</option>'
        );

        el.val(String(selectedValue || ''));

      }

    }

    el.data('relation-populating', false);

    return true;

  }


  function getSelectedRelationEditorComponent() {

    if (!grapesEditor || !state.selectedFieldCid) {
      return null;
    }

    let found = null;

    getFormFieldComponents().forEach(function(component) {

      if (component.cid === state.selectedFieldCid) {
        found = component;
      }

    });

    return found;

  }


  function getRelationPanelSelect(propertyName) {

    return $(selectors.rightContent)
      .find('.automator-relation-db-select[data-property-name="' + propertyName + '"]')
      .first();

  }



  function initRelationDatabaseOptionsPanel(component) {

    if (!component) {
      return false;
    }

    const fieldData = getFieldDataFromComponent(component);
    const type = String(fieldData.tbl_sys_field_type_name || '').toLowerCase();

    if (type !== 'relation' && type !== 'relations') {
      return false;
    }

    const props = getFieldProps(fieldData);
    const relation = props.relation && typeof props.relation === 'object' ? props.relation : {};

    const tableName = String(relation.table || '').trim();
    const valueColumn = String(relation.value || '').trim();
    const labelColumn = getRelationLabelColumn(fieldData);

    loadRelationDatabaseTables(function(tables) {

      populateRelationDatabaseSelect(
        getRelationPanelSelect('relation.table'),
        tables,
        tableName
      );

      if (!tableName) {

        populateRelationDatabaseSelect(getRelationPanelSelect('relation.value'), [], '');
        populateRelationDatabaseSelect(getRelationPanelSelect('relation.label'), [], '');

        return;

      }

      loadRelationDatabaseColumns(tableName, function(columns) {

        populateRelationDatabaseSelect(
          getRelationPanelSelect('relation.value'),
          columns,
          valueColumn
        );

        populateRelationDatabaseSelect(
          getRelationPanelSelect('relation.label'),
          columns,
          labelColumn
        );

      }, {
        showLoader: false
      });

    }, {
      showLoader: false
    });

    return true;

  }


  function setRelationPropertyOnFieldData(fieldData, propertyName, value) {

    const props = getFieldProps(fieldData);

    if (!props.relation || typeof props.relation !== 'object') {
      props.relation = {};
    }

    if (propertyName === 'relation.table') {

      props.relation.table = value;

    } else if (propertyName === 'relation.value') {

      props.relation.value = value;

    } else if (propertyName === 'relation.label') {

      props.relation.label = value;

    }

    delete props.relation.key;
    delete props.relation.label_table;
    delete props.relation.label_value;
    delete props.relation.label_display;

    props.relation_options = {};
    props.relation_options_status = '';
    props.relation_options_message = '';

    fieldData.tbl_sys_forms_field_props = props;

    return fieldData;

  }


  function syncRelationDatabaseProperty(component, propertyName, value) {

    if (!component) {
      return false;
    }

    let fieldData = getFieldDataFromComponent(component);

    fieldData = setRelationPropertyOnFieldData(fieldData, propertyName, value);

    setFieldDataToComponent(component, fieldData, {
      refreshPanel: false,
      skipResize: true
    });

    updateLiveFormFieldElement(component, fieldData);

    return true;

  }


  function handleRelationDatabaseSelectChange(select, component) {

    const input = $(select);

    if (input.data('relation-populating') === true) {
      return false;
    }

    const propertyName = input.attr('data-property-name');
    const value = input.val();

    if (!component) {
      component = getSelectedRelationEditorComponent();
    }

    if (!component) {
      return false;
    }

    syncRelationDatabaseProperty(component, propertyName, value);

    const valueSelect = getRelationPanelSelect('relation.value');
    const labelSelect = getRelationPanelSelect('relation.label');

    if (propertyName === 'relation.table') {

      syncRelationDatabaseProperty(component, 'relation.value', '');
      syncRelationDatabaseProperty(component, 'relation.label', '');

      populateRelationDatabaseSelect(valueSelect, [], '');
      populateRelationDatabaseSelect(labelSelect, [], '');

      if (!value) {
        refreshRelationComponentOptions(component, {
          showLoader: true
        });
        return true;
      }

      loadRelationDatabaseColumns(value, function(columns) {

        populateRelationDatabaseSelect(valueSelect, columns, '');
        populateRelationDatabaseSelect(labelSelect, columns, '');

        refreshRelationComponentOptions(component, {
          showLoader: true
        });

      }, {
        showLoader: true
      });

      return true;

    }

    refreshRelationComponentOptions(component, {
      showLoader: true
    });

    return true;

  }


  function refreshRelationComponentOptions(component, options = {}) {

    if (!component) {

      if (typeof options.callback === 'function') {
        options.callback(false);
      }

      return false;

    }

    let fieldData = getFieldDataFromComponent(component);
    const relationStatus = getRelationConfigStatus(fieldData);

    if (relationStatus !== 'valid') {

      const props = getFieldProps(fieldData);

      props.relation_options_status = relationStatus;
      props.relation_options_message = relationStatus === 'pending'
        ? 'Configuração pendente'
        : 'Configuração inválida';
      props.relation_options = {};

      fieldData.tbl_sys_forms_field_props = props;

      setFieldDataToComponent(component, fieldData, {
        refreshPanel: false,
        skipResize: true,
        silent: options.silent === true
      });

      updateLiveFormFieldElement(component, fieldData);

      if (typeof options.callback === 'function') {
        options.callback(false);
      }

      return false;

    }

    const props = getFieldProps(fieldData);
    const relation = props.relation || {};

    const tableName = String(relation.table || '').trim();
    const valueColumn = String(relation.value || '').trim();
    const labelColumn = getRelationLabelColumn(fieldData);

    loadRelationDatabaseOptions(
      tableName,
      valueColumn,
      labelColumn,
      function(loadedOptions) {

        fieldData = getFieldDataFromComponent(component);

        const updatedProps = getFieldProps(fieldData);
        const optionsList = loadedOptions || {};
        const hasOptions = Object.keys(optionsList).length > 0;

        updatedProps.relation_options = optionsList;
        updatedProps.relation_options_status = hasOptions ? 'valid' : 'invalid';
        updatedProps.relation_options_message = hasOptions ? '' : 'Configuração inválida';

        fieldData.tbl_sys_forms_field_props = updatedProps;

        setFieldDataToComponent(component, fieldData, {
          refreshPanel: false,
          skipResize: true,
          silent: options.silent === true
        });

        updateLiveFormFieldElement(component, fieldData);

        if (typeof options.callback === 'function') {
          options.callback(hasOptions);
        }

      },
      {
        showLoader: options.showLoader === true
      }
    );

    return true;

  }


  function loadRelationDatabaseOptions(tableName, valueColumn, labelColumn, callback, options = {}) {

    tableName = String(tableName || '').trim();
    valueColumn = String(valueColumn || '').trim();
    labelColumn = String(labelColumn || '').trim();

    if (!tableName || !valueColumn || !labelColumn) {

      if (typeof callback === 'function') {
        callback({}, {
          status: false,
          message: 'Configuração pendente'
        });
      }

      return false;

    }

    if (options.showLoader === true) {
      showRelationDatabaseLoader();
    }

    postRelationDatabaseData({
      acao: 'get-database-data',
      'data-type': 'get-table-options',
      'table-name': tableName,
      'value-column': valueColumn,
      'label-column': labelColumn
    }, function(response) {

      if (options.showLoader === true) {
        hideRelationDatabaseLoader();
      }

      const choices = {};

      if (response && response.status === true && Array.isArray(response.data)) {

        response.data.forEach(function(item) {

          const value = String(
            typeof item.value !== 'undefined' && item.value !== null
              ? item.value
              : ''
          );

          const label = String(
            typeof item.label !== 'undefined' && item.label !== null && String(item.label) !== ''
              ? item.label
              : value
          );

          if (value !== '') {
            choices[value] = label;
          }

        });

      }

      if (typeof callback === 'function') {
        callback(choices, response || {});
      }

    });

    return true;

  }


  function buildRelationStatusPreviewComponents(fieldData) {

    const props = getFieldProps(fieldData);
    const status = getRelationConfigStatus(fieldData);

    let message = '';

    if (status === 'pending') {
      message = 'Configuração pendente';
    } else if (status === 'invalid') {
      message = 'Configuração inválida';
    } else if (props.relation_options_status === 'invalid') {
      message = props.relation_options_message || 'Configuração inválida';
    }

    if (!message) {
      return [];
    }

    return [
      {
        tagName: 'div',
        classes: ['alert', status === 'pending' ? 'alert-warning' : 'alert-danger', 'mb-0', 'py-2', 'px-3'],
        content: escapeHtml(message),
        selectable: false,
        draggable: false,
        droppable: false,
        editable: false,
        removable: false
      }
    ];

  }


  function getRelationConfigStatus(fieldData) {

    const type = String(fieldData.tbl_sys_field_type_name || '').toLowerCase();

    if (type !== 'relation' && type !== 'relations') {
      return 'valid';
    }

    const props = getFieldProps(fieldData);
    const relation = props.relation && typeof props.relation === 'object' ? props.relation : {};

    const tableName = String(relation.table || '').trim();
    const valueColumn = String(relation.value || '').trim();
    const labelColumn = getRelationLabelColumn(fieldData);

    if (!tableName && !valueColumn && !labelColumn) {
      return 'pending';
    }

    if (!tableName || !valueColumn || !labelColumn) {
      return 'invalid';
    }

    return 'valid';

  }



  function getFormFieldParams(fieldData) {

    const raw = fieldData.raw || {};

    let params =
      raw.params ||
      raw.properties ||
      raw.tbl_sys_field_type_params ||
      {};

    if (typeof params === 'string') {

      try {
        params = JSON.parse(params);
      } catch (e) {
        params = {};
      }

    }

    if (!params || typeof params !== 'object') {
      params = {};
    }

    if (!Object.keys(params).length) {
      params = getDefaultFormFieldParams(fieldData);
    }

    return normalizeFormFieldParams(params, fieldData);

  }

  function getDefaultFormFieldParams(fieldData) {

    const params = {

      wrapper: {

        label: 'Tamanho do campo',

        fields: {

          'column-xs': {
            label: 'Tamanho XS',
            field: 'range',
            minval: 1,
            maxval: 12,
            default: getColumnSizeFromWrapper(getFieldWrapperClass(fieldData), 'xs') || 12
          },

          'column-sm': {
            label: 'Tamanho SM',
            field: 'range',
            minval: 1,
            maxval: 12,
            default: getColumnSizeFromWrapper(getFieldWrapperClass(fieldData), 'sm') || 12
          },

          'column-md': {
            label: 'Tamanho MD',
            field: 'range',
            minval: 1,
            maxval: 12,
            default: getColumnSizeFromWrapper(getFieldWrapperClass(fieldData), 'md') || 6
          },

          'column-lg': {
            label: 'Tamanho LG',
            field: 'range',
            minval: 1,
            maxval: 12,
            default: getColumnSizeFromWrapper(getFieldWrapperClass(fieldData), 'lg') || 6
          },

          'column-xl': {
            label: 'Tamanho XL',
            field: 'range',
            minval: 1,
            maxval: 12,
            default: getColumnSizeFromWrapper(getFieldWrapperClass(fieldData), 'xl') || 6
          },

          'column-xxl': {
            label: 'Tamanho XXL',
            field: 'range',
            minval: 1,
            maxval: 12,
            default: getColumnSizeFromWrapper(getFieldWrapperClass(fieldData), 'xxl') || 6
          }

        }

      },

      validation: {

        label: 'Validação',

        fields: {

          required: {
            label: 'Obrigatório',
            field: 'select',
            default: boolToString(fieldData.tbl_sys_forms_field_required),
            choices: {
              1: 'Sim',
              0: 'Não'
            }
          },

          locked: {
            label: 'Bloqueado',
            field: 'select',
            default: boolToString(fieldData.tbl_sys_forms_field_locked),
            choices: {
              1: 'Sim',
              0: 'Não'
            }
          }

        }

      },

      advanced: {

        label: 'Avançado',

        fields: {

          class: {
            label: 'Classe do campo',
            field: 'text',
            default: fieldData.tbl_sys_forms_field_class || ''
          },

          default: {
            label: 'Valor padrão',
            field: 'text',
            default: fieldData.tbl_sys_forms_field_default || ''
          },

          attrs: {
            label: 'Atributos extras',
            field: 'textarea',
            default: fieldData.tbl_sys_forms_field_attrs || ''
          }

        }

      }

    };

    if (fieldSupportsChoices(fieldData)) {

      params.options = {

        label: 'Opções',

        fields: {

          choices: {
            label: 'Opções',
            field: 'choices-builder',
            default: ''
          }

        }

      };

    }

    return params;

  }

  function normalizeFormFieldParams(params, fieldData) {

    let normalized = {};

    $.each(params || {}, function(groupKey, group) {

      if (!group || typeof group !== 'object') {
        return;
      }

      normalized[groupKey] = {
        label: group.label || group.name || groupKey,
        fields: {}
      };

      $.each(group.fields || {}, function(fieldKey, field) {

        if (!field || typeof field !== 'object') {
          return;
        }

        let fieldType = normalizeFormFieldParamType(
          field.field || field.type || 'text'
        );

        if (
          fieldSupportsChoices(fieldData) &&
          isChoicesParamField(groupKey, fieldKey, field)
        ) {
          fieldType = 'choices-builder';
        }

        normalized[groupKey].fields[fieldKey] = {
          label: field.label || field.name || fieldKey,
          field: fieldType,
          minval: field.minval || field.min || 1,
          maxval: field.maxval || field.max || 12,
          default: field.default || '',
          choices: field.choices || field.values || {},
          placeholder: field.placeholder || ''
        };

      });

    });

    normalized = ensureChoicesBuilderParam(normalized, fieldData);

    return normalized;

  }


  function isChoicesParamField(groupKey, fieldKey, field) {

    const cleanKey = String(fieldKey || '').toLowerCase();
    const cleanLabel = String(field.label || '').toLowerCase();
    const cleanType = String(field.field || field.type || '').toLowerCase();

    return (
      cleanType === 'choices-builder' ||
      cleanKey === 'choices' ||
      cleanKey === 'options' ||
      cleanKey === 'opcoes' ||
      cleanKey === 'opções' ||
      cleanLabel === 'opções' ||
      cleanLabel === 'opcoes' ||
      cleanLabel === 'opções do campo'
    );

  }


  function ensureChoicesBuilderParam(params, fieldData) {

    if (!fieldSupportsChoices(fieldData)) {
      return params;
    }

    let firstChoicesGroup = null;
    let firstChoicesField = null;

    $.each(params, function(groupKey, group) {

      $.each(group.fields || {}, function(fieldKey, field) {

        if (
          field.field === 'choices-builder' ||
          isChoicesParamField(groupKey, fieldKey, field)
        ) {

          if (firstChoicesGroup === null) {

            firstChoicesGroup = groupKey;
            firstChoicesField = fieldKey;
            group.fields[fieldKey].field = 'choices-builder';

          } else {

            delete group.fields[fieldKey];

          }

        }

      });

    });

    if (firstChoicesGroup !== null) {
      return params;
    }

    if (!params.options) {
      params.options = {
        label: 'Opções',
        fields: {}
      };
    }

    params.options.fields.choices = {
      label: 'Opções',
      field: 'choices-builder',
      default: ''
    };

    return params;

  }

  function normalizeFormFieldParamType(type) {

    type = String(type || 'text').toLowerCase();

    if (
      type === 'input' ||
      type === 'input[type="text"]' ||
      type === "input[type='text']"
    ) {
      return 'text';
    }

    if (
      type === 'input[type="number"]' ||
      type === "input[type='number']" ||
      type === 'number'
    ) {
      return 'number';
    }

    if (type === 'color' || type === 'color-picker') {
      return 'color-picker';
    }

    if (type === 'radio-buttons') {
      return 'select';
    }

    return type;

  }


  function isEmptyToggleProperty(propertyName, fieldKey) {

    const clean = String(propertyName || fieldKey || '').toLowerCase();

    return (
      clean.indexOf('has-empty') !== -1 ||
      clean.indexOf('has_empty') !== -1 ||
      clean.indexOf('hasnull') !== -1 ||
      clean.indexOf('has-null') !== -1 ||
      clean.indexOf('has_null') !== -1 ||
      clean.indexOf('tem-vazio') !== -1 ||
      clean.indexOf('tem_vazio') !== -1 ||
      clean.indexOf('allow-empty') !== -1 ||
      clean.indexOf('empty-enabled') !== -1
    );

  }


  function isEmptyValueProperty(propertyName, fieldKey) {

    const clean = String(propertyName || fieldKey || '').toLowerCase();

    return (
      clean.indexOf('empty-value') !== -1 ||
      clean.indexOf('empty_value') !== -1 ||
      clean.indexOf('valor-vazio') !== -1 ||
      clean.indexOf('valor_vazio') !== -1 ||
      clean.indexOf('empty-label') !== -1 ||
      clean.indexOf('empty_label') !== -1 ||
      clean.indexOf('nulltext') !== -1 ||
      clean.indexOf('null-text') !== -1 ||
      clean.indexOf('null_text') !== -1
    );

  }


  function getFieldHasEmptyOption(fieldData) {

    const props = getFieldProps(fieldData);

    if (typeof props.has_empty !== 'undefined') {
      return props.has_empty === true || props.has_empty === 1 || props.has_empty === '1' || props.has_empty === 'true';
    }

    if (props.params && typeof props.params === 'object') {

      for (const key in props.params) {
        if (isEmptyToggleProperty(key, key)) {
          return props.params[key] === true || props.params[key] === 1 || props.params[key] === '1' || props.params[key] === 'true';
        }
      }

    }

    return false;

  }


  function getFieldEmptyOptionText(fieldData) {

    const props = getFieldProps(fieldData);

    if (typeof props.empty_value !== 'undefined') {
      return props.empty_value;
    }

    if (props.params && typeof props.params === 'object') {

      for (const key in props.params) {
        if (isEmptyValueProperty(key, key)) {
          return props.params[key] || '';
        }
      }

    }

    return '';

  }


  function updateEmptyValueFieldsState() {

    $('.automator-form-editor-api-property').each(function() {

      const input = $(this);
      const propertyName = input.attr('data-property-name');
      const fieldKey = input.attr('data-field-key');

      if (!isEmptyValueProperty(propertyName, fieldKey)) {
        return;
      }

      const selected = $('.automator-form-editor-api-property').filter(function() {
        return isEmptyToggleProperty(
          $(this).attr('data-property-name'),
          $(this).attr('data-field-key')
        );
      }).first().val();

      const enabled =
        selected === true ||
        selected === 1 ||
        selected === '1' ||
        selected === 'true';

      input.prop('disabled', !enabled);

      if (!enabled) {
        input.val('');
      }

    });

  }


  function renderFormFieldApiPropertyField(fieldKey, field, inputName, defaultValue, fieldData) {

    let html = '';

    html += '<div class="mb-3">';
    html += '<label class="form-label small fw-bold">' + escapeHtml(field.label || fieldKey) + '</label>';

    if (field.field === 'choices-builder') {

      html += renderChoicesBuilder(fieldData, inputName, fieldData.__component || null);

    } else if (field.field === 'select' || field.field === 'radio-buttons') {

      html += '<select class="form-select form-select-sm automator-form-editor-api-property" data-field-key="' + escapeHtml(fieldKey) + '" data-field-type="' + escapeHtml(field.field) + '" data-property-name="' + escapeHtml(inputName) + '">';

      $.each(field.choices || {}, function(choiceKey, choiceLabel) {
        html += '<option value="' + escapeHtml(choiceKey) + '"' + (String(choiceKey) === String(defaultValue) ? ' selected' : '') + '>';
        html += escapeHtml(choiceLabel);
        html += '</option>';
      });

      html += '</select>';

    } else if (field.field === 'editor-css') {

      html += '<div class="automator-editor-api-property-editor">';
      html += '<div class="automator-editor-api-property-editor-count" id="' + escapeHtml(inputName) + '-count">1</div>';
      html += '<textarea class="form-control form-control-sm automator-form-editor-api-property" rows="4" data-field-key="' + escapeHtml(fieldKey) + '" data-field-type="editor-css" data-property-name="' + escapeHtml(inputName) + '" wrap="off">' + escapeHtml(defaultValue) + '</textarea>';
      html += '</div>';

    } else if (field.field === 'textarea') {

      html += '<textarea class="form-control form-control-sm automator-form-editor-api-property" rows="4" data-field-key="' + escapeHtml(fieldKey) + '" data-field-type="' + escapeHtml(field.field) + '" data-property-name="' + escapeHtml(inputName) + '" placeholder="' + escapeHtml(field.placeholder || '') + '">' + escapeHtml(defaultValue) + '</textarea>';

    } else if (field.field === 'range') {

      const min = field.minval || field.min || 1;
      const max = field.maxval || field.max || 12;
      const value = defaultValue || field.default || min;

      html += '<div class="d-flex align-items-center gap-2">';
      html += '<input type="range" class="form-range automator-form-editor-api-property flex-grow-1" min="' + escapeHtml(min) + '" max="' + escapeHtml(max) + '" value="' + escapeHtml(value) + '" data-field-key="' + escapeHtml(fieldKey) + '" data-field-type="' + escapeHtml(field.field) + '" data-property-name="' + escapeHtml(inputName) + '">';
      html += '<input type="number" class="form-control form-control-sm automator-form-editor-api-property-number" style="width:70px;" min="' + escapeHtml(min) + '" max="' + escapeHtml(max) + '" value="' + escapeHtml(value) + '" data-field-key="' + escapeHtml(fieldKey) + '" data-field-type="' + escapeHtml(field.field) + '" data-property-name="' + escapeHtml(inputName) + '">';
      html += '</div>';

    } else if (field.field === 'color-picker') {

      html += '<input type="color" class="form-control form-control-color automator-form-editor-api-property" value="' + escapeHtml(normalizeColorValue(defaultValue)) + '" data-field-key="' + escapeHtml(fieldKey) + '" data-field-type="' + escapeHtml(field.field) + '" data-property-name="' + escapeHtml(inputName) + '">';

    } else {

      const disabledAttr = isEmptyValueProperty(inputName, fieldKey, fieldData) && !getFieldHasEmptyOption(fieldData)
        ? ' disabled'
        : '';

      html += '<input type="text" class="form-control form-control-sm automator-form-editor-api-property" value="' + escapeHtml(defaultValue) + '" data-field-key="' + escapeHtml(fieldKey) + '" data-field-type="' + escapeHtml(field.field || 'text') + '" data-property-name="' + escapeHtml(inputName) + '" placeholder="' + escapeHtml(field.placeholder || '') + '"' + disabledAttr + '>';

    }

    html += '</div>';

    return html;

  }


  function renderChoicesBuilder(fieldData, propertyName, component = null) {

    const choices = getFieldChoices(fieldData);
    const componentCid = component && component.cid ? component.cid : '';

    let html = '';

    html += '<div class="automator-form-editor-choices-builder" data-component-cid="' + escapeHtml(componentCid) + '" data-property-name="' + escapeHtml(propertyName || 'options.choices') + '">';
    html += '<div class="automator-form-editor-choices-list">';

    Object.keys(choices).forEach(function(value) {
      html += renderChoiceRow(value, choices[value]);
    });

    html += '</div>';

    html += '<button type="button" class="btn btn-outline-primary btn-sm w-100 automator-form-editor-choice-add">';
    html += '<i class="fa fa-plus me-1"></i> Adicionar opção';
    html += '</button>';

    html += '<div class="form-text mt-2">Cada opção será salva como <strong>valor : label</strong>.</div>';
    html += '</div>';

    return html;

  }



  function renderChoiceRow(value = '', label = '') {

    if (value === '' && label === '') {
      value = generateTemporaryChoiceValue();
      label = 'Nova opção';
    }

    let html = '';

    html += '<div class="input-group input-group-sm mb-2 automator-form-editor-choice-row">';
    html += '<input type="text" class="form-control automator-form-editor-choice-value" placeholder="valor" value="' + escapeHtml(value) + '">';
    html += '<span class="input-group-text">:</span>';
    html += '<input type="text" class="form-control automator-form-editor-choice-label" placeholder="label" value="' + escapeHtml(label) + '">';
    html += '<button type="button" class="btn btn-outline-danger automator-form-editor-choice-remove">';
    html += '<i class="fa fa-trash"></i>';
    html += '</button>';
    html += '</div>';

    return html;

  }


  function generateTemporaryChoiceValue() {

    return 'opcao_' + Date.now() + '_' + Math.floor(Math.random() * 9999);

  }



  function bindFormFieldApiProperties(component) {

    const panel = $(selectors.rightContent);

    panel
      .off('.automator-form-editor-api-property')
      .on('input.automator-form-editor-api-property keyup.automator-form-editor-api-property change.automator-form-editor-api-property focusout.automator-form-editor-api-property blur.automator-form-editor-api-property', '.automator-form-editor-api-property', function() {

        const input = $(this);

        if (input.hasClass('automator-relation-db-select')) {
          return false;
        }

        const propertyName = input.attr('data-property-name');
        const fieldKey = input.attr('data-field-key');
        const value = input.val();

        panel.find('.automator-form-editor-api-property-number[data-property-name="' + propertyName + '"]').val(value);

        syncFormFieldParamProperty(component, propertyName, value);

        if (isEmptyToggleProperty(propertyName, fieldKey)) {
          updateEmptyValueFieldsState();
        }

      });

    panel
      .off('change.automator-form-editor-relation-db-select')
      .on('change.automator-form-editor-relation-db-select', '.automator-relation-db-select', function(event) {

        event.preventDefault();
        event.stopPropagation();

        handleRelationDatabaseSelectChange(this, component);

        return false;

      });

    panel
      .off('.automator-form-editor-api-property-number')
      .on('input.automator-form-editor-api-property-number keyup.automator-form-editor-api-property-number change.automator-form-editor-api-property-number focusout.automator-form-editor-api-property-number blur.automator-form-editor-api-property-number', '.automator-form-editor-api-property-number', function() {

        const input = $(this);
        const propertyName = input.attr('data-property-name');
        const value = input.val();

        panel.find('.automator-form-editor-api-property[data-property-name="' + propertyName + '"]').val(value);

        syncFormFieldParamProperty(component, propertyName, value);

      });

    panel
      .off('.automator-form-editor-choice-add')
      .on('click.automator-form-editor-choice-add', '.automator-form-editor-choice-add', function(event) {

        event.preventDefault();
        event.stopPropagation();

        const builder = $(this).closest('.automator-form-editor-choices-builder');
        const targetComponent = getComponentFromChoicesBuilder(builder);

        if (!targetComponent) {
          return false;
        }

        const list = builder.find('.automator-form-editor-choices-list');

        list.append(renderChoiceRow('', ''));

        syncChoicesBuilder(targetComponent, builder);

        list.find('.automator-form-editor-choice-row:last .automator-form-editor-choice-value').trigger('focus');

        return false;

      });

    panel
      .off('.automator-form-editor-choice-remove')
      .on('click.automator-form-editor-choice-remove', '.automator-form-editor-choice-remove', function(event) {

        event.preventDefault();
        event.stopPropagation();

        const builder = $(this).closest('.automator-form-editor-choices-builder');
        const targetComponent = getComponentFromChoicesBuilder(builder);

        if (!targetComponent) {
          return false;
        }

        $(this).closest('.automator-form-editor-choice-row').remove();

        syncChoicesBuilder(targetComponent, builder);

        return false;

      });

    panel
      .off('.automator-form-editor-choice')
      .on(
        'input.automator-form-editor-choice keyup.automator-form-editor-choice change.automator-form-editor-choice focusout.automator-form-editor-choice blur.automator-form-editor-choice',
        '.automator-form-editor-choice-value, .automator-form-editor-choice-label',
        function() {

          const builder = $(this).closest('.automator-form-editor-choices-builder');
          const targetComponent = getComponentFromChoicesBuilder(builder);

          if (!targetComponent) {
            return false;
          }

          syncChoicesBuilder(targetComponent, builder);

        }
      );

    updateEmptyValueFieldsState();
    bindCssEditors();
    initRelationDatabaseOptionsPanel(component);

  }




  function syncChoicesBuilder(component, builderEl) {

    if (!component || !builderEl) {
      return false;
    }

    let fieldData = getFieldDataFromComponent(component);
    const choices = {};
    const builder = $(builderEl).closest('.automator-form-editor-choices-builder');

    builder.find('.automator-form-editor-choice-row').each(function() {

      let value = String($(this).find('.automator-form-editor-choice-value').val() || '').trim();
      let label = String($(this).find('.automator-form-editor-choice-label').val() || '').trim();

      if (value === '' && label === '') {
        value = generateTemporaryChoiceValue();
        label = 'Nova opção';

        $(this).find('.automator-form-editor-choice-value').val(value);
        $(this).find('.automator-form-editor-choice-label').val(label);
      }

      if (value !== '') {
        choices[value] = label || value;
      }

    });

    fieldData = setFieldProp(fieldData, 'choices', choices);

    setFieldDataToComponent(component, fieldData, {
      refreshPanel: false,
      skipResize: true
    });

    updateLiveFormFieldElement(component, fieldData);

    return true;

  }

  function bindCssEditors() {

    $('.automator-form-editor-api-property[data-field-type="editor-css"]').each(function () {

      const textarea = this;
      const container = textarea.closest('.automator-editor-api-property-editor');

      if (!container) {
        return;
      }

      const lineNumbers = container.querySelector('.automator-editor-api-property-editor-count');

      if (!lineNumbers) {
        return;
      }

      const lineHeight = 20;

      function getCurrentLine() {

        const value = textarea.value || '';
        const cursorPosition = textarea.selectionStart || 0;

        return value.substring(0, cursorPosition).split('\n').length;

      }

      function updateLineNumbers() {

        const totalLines = Math.max(
          1,
          (textarea.value || '').split('\n').length
        );

        const currentLine = getCurrentLine();

        let html = '';

        for (let i = 1; i <= totalLines; i++) {
          html += '<span class="' + (i === currentLine ? 'is-active' : '') + '">' + i + '</span>';
        }

        lineNumbers.innerHTML = html;

        syncScroll();

      }

      function updateActiveLineBackground() {

        const currentLine = getCurrentLine();
        const activeTop = ((currentLine - 1) * lineHeight) - textarea.scrollTop + 6;

        textarea.style.setProperty('--editor-css-active-line-top', activeTop + 'px');

      }

      function syncScroll() {

        lineNumbers.scrollTop = textarea.scrollTop;
        updateActiveLineBackground();

      }

      updateLineNumbers();

      $(textarea)
        .off('.editor-css-lines')
        .on('input.editor-css-lines', function () {
          updateLineNumbers();
        })
        .on('scroll.editor-css-lines', function () {
          syncScroll();
        })
        .on('click.editor-css-lines keyup.editor-css-lines focus.editor-css-lines', function () {
          updateLineNumbers();
        });

    });

  }


  function updateLiveFormFieldElement(component, fieldData) {

    if (
      !grapesEditor ||
      !grapesEditor.Canvas ||
      typeof grapesEditor.Canvas.getDocument !== 'function'
    ) {
      return false;
    }

    const doc = grapesEditor.Canvas.getDocument();
    const attrs = component.getAttributes ? component.getAttributes() : {};
    const uid = attrs['data-automator-form-field-uid'];

    if (!doc || !uid) {
      return false;
    }

    const el = doc.querySelector('[data-automator-form-field-uid="' + uid + '"]');

    if (!el) {
      return false;
    }

    const fieldDataEncoded = encodeFieldData(fieldData);

    el.setAttribute('data-automator-form-field-data', fieldDataEncoded);

    return true;

  }



  function syncFormFieldParamProperty(component, propertyName, value) {

    if (!component) {
      return false;
    }

    let fieldData = getFieldDataFromComponent(component);
    const cleanProperty = String(propertyName || '').toLowerCase();

    if (isFormColumnSizeProperty(cleanProperty)) {

      const breakpoint = getFormColumnBreakpointFromProperty(cleanProperty);
      let wrapperClass = getFieldWrapperClass(fieldData);

      wrapperClass = setColumnSizeInWrapper(wrapperClass, breakpoint, value);

      fieldData = setFieldProp(fieldData, 'wrapper_class', wrapperClass);

    } else if (
      (
        String(fieldData.tbl_sys_field_type_name || '').toLowerCase() === 'relation' ||
        String(fieldData.tbl_sys_field_type_name || '').toLowerCase() === 'relations'
      ) &&
      (
        cleanProperty === 'advanced.type' ||
        cleanProperty === 'type' ||
        cleanProperty === 'configs.type'
      )
    ) {

      const props = getFieldProps(fieldData);

      props.type = String(value || 'select');

      if (!props.params || typeof props.params !== 'object') {
        props.params = {};
      }

      props.params[propertyName] = props.type;
      props.params['advanced.type'] = props.type;

      fieldData.tbl_sys_forms_field_props = props;

    } else if (isPasswordButtonProperty(cleanProperty)) {

      const props = getFieldProps(fieldData);
      const enabled = (
        value === true ||
        value === 1 ||
        value === '1' ||
        value === 'true'
      );

      props.hasButton = enabled;

      if (!props.params || typeof props.params !== 'object') {
        props.params = {};
      }

      props.params[propertyName] = enabled ? 'true' : 'false';

      if (!props.advanced || typeof props.advanced !== 'object') {
        props.advanced = {};
      }

      props.advanced.hasButton = enabled ? 'true' : 'false';

      fieldData.tbl_sys_forms_field_props = props;

    } else if (isEmptyToggleProperty(cleanProperty, cleanProperty)) {

      const props = getFieldProps(fieldData);
      const enabled = String(value) === '1' || String(value) === 'true';

      props.has_empty = enabled;

      if (!props.params || typeof props.params !== 'object') {
        props.params = {};
      }

      props.params[propertyName] = value;

      if (!enabled) {

        props.empty_value = '';

        Object.keys(props.params).forEach(function(key) {
          if (isEmptyValueProperty(key, key)) {
            props.params[key] = '';
          }
        });

      }

      fieldData.tbl_sys_forms_field_props = props;

      updateEmptyValueFieldsState();

    } else if (isEmptyValueProperty(cleanProperty, cleanProperty)) {

      const props = getFieldProps(fieldData);

      if (getFieldHasEmptyOption(fieldData)) {
        props.empty_value = value;
      } else {
        props.empty_value = '';
        value = '';
      }

      if (!props.params || typeof props.params !== 'object') {
        props.params = {};
      }

      props.params[propertyName] = value;

      fieldData.tbl_sys_forms_field_props = props;

    } else if (cleanProperty === 'validation.required' || cleanProperty === 'configs.required') {

      fieldData.tbl_sys_forms_field_required = String(value) === '1' || String(value) === 'true';

    } else if (cleanProperty === 'validation.locked' || cleanProperty === 'configs.locked') {

      fieldData.tbl_sys_forms_field_locked = String(value) === '1' || String(value) === 'true';

    } else if (
      cleanProperty === 'advanced.class' ||
      cleanProperty === 'aparencia.class' ||
      cleanProperty === 'appearance.class'
    ) {

      fieldData.tbl_sys_forms_field_class = normalizeCustomClass(value);

    } else if (cleanProperty === 'advanced.default') {

      fieldData.tbl_sys_forms_field_default = value;

    } else if (cleanProperty === 'advanced.attrs') {

      fieldData.tbl_sys_forms_field_attrs = value;

    } else if (
      cleanProperty === 'relation.table' ||
      cleanProperty === 'relation.value' ||
      cleanProperty === 'relation.label'
    ) {

      fieldData = setRelationPropertyOnFieldData(fieldData, cleanProperty, value);

    } else {

      fieldData = setFieldParamValue(fieldData, propertyName, value);

    }

    setFieldDataToComponent(component, fieldData, {
      refreshPanel: false,
      skipResize: true
    });

    updateLiveFormFieldElement(component, fieldData);

    return true;

  }



  function isFormColumnSizeProperty(propertyName) {

    const clean = String(propertyName || '').toLowerCase();

    return (
      clean === 'wrapper.column-xs' ||
      clean === 'wrapper.column-sm' ||
      clean === 'wrapper.column-md' ||
      clean === 'wrapper.column-lg' ||
      clean === 'wrapper.column-xl' ||
      clean === 'wrapper.column-xxl' ||
      clean.indexOf('column-xs') !== -1 ||
      clean.indexOf('column-sm') !== -1 ||
      clean.indexOf('column-md') !== -1 ||
      clean.indexOf('column-lg') !== -1 ||
      clean.indexOf('column-xl') !== -1 ||
      clean.indexOf('column-xxl') !== -1
    );

  }


  function getFormColumnBreakpointFromProperty(propertyName) {

    const clean = String(propertyName || '').toLowerCase();

    if (clean.indexOf('column-xxl') !== -1) {
      return 'xxl';
    }

    if (clean.indexOf('column-xl') !== -1) {
      return 'xl';
    }

    if (clean.indexOf('column-lg') !== -1) {
      return 'lg';
    }

    if (clean.indexOf('column-md') !== -1) {
      return 'md';
    }

    if (clean.indexOf('column-sm') !== -1) {
      return 'sm';
    }

    return 'xs';

  }


  function setFieldParamValue(fieldData, propertyName, value) {

    const props = getFieldProps(fieldData);

    if (!props.params || typeof props.params !== 'object') {
      props.params = {};
    }

    props.params[propertyName] = value;

    fieldData.tbl_sys_forms_field_props = props;

    return fieldData;

  }



  function getFormFieldStoredParamValue(fieldData, propertyName, defaultValue) {

    const props = getFieldProps(fieldData);
    const cleanProperty = String(propertyName || '').toLowerCase();
    const fieldType = String(fieldData.tbl_sys_field_type_name || '').toLowerCase();

    if (fieldType === 'relation' || fieldType === 'relations') {

      const relation = props.relation && typeof props.relation === 'object' ? props.relation : {};

      if (cleanProperty === 'relation.table') {
        return relation.table || defaultValue;
      }

      if (cleanProperty === 'relation.value') {
        return relation.value || defaultValue;
      }

      if (cleanProperty === 'relation.label') {
        return getRelationLabelColumn(fieldData) || defaultValue;
      }

    }

    if (isPasswordButtonProperty(cleanProperty)) {
      return fieldHasPasswordButton(fieldData) ? 'true' : 'false';
    }

    if (
      (fieldType === 'relation' || fieldType === 'relations') &&
      (
        cleanProperty === 'advanced.type' ||
        cleanProperty === 'type' ||
        cleanProperty === 'configs.type'
      )
    ) {
      return getRelationFieldType(fieldData) || defaultValue;
    }

    if (
      props.params &&
      typeof props.params === 'object' &&
      typeof props.params[propertyName] !== 'undefined'
    ) {
      return props.params[propertyName];
    }

    if (isFormColumnSizeProperty(cleanProperty)) {

      const breakpoint = getFormColumnBreakpointFromProperty(cleanProperty);

      return getColumnSizeFromWrapper(
        getFieldWrapperClass(fieldData),
        breakpoint
      ) || defaultValue;

    }

    if (cleanProperty === 'validation.required') {
      return boolToString(fieldData.tbl_sys_forms_field_required);
    }

    if (cleanProperty === 'validation.locked') {
      return boolToString(fieldData.tbl_sys_forms_field_locked);
    }

    if (
      cleanProperty === 'advanced.class' ||
      cleanProperty === 'aparencia.class' ||
      cleanProperty === 'appearance.class'
    ) {
      return fieldData.tbl_sys_forms_field_class || defaultValue;
    }

    if (cleanProperty === 'advanced.default') {
      return fieldData.tbl_sys_forms_field_default || defaultValue;
    }

    if (cleanProperty === 'advanced.attrs') {
      return fieldData.tbl_sys_forms_field_attrs || defaultValue;
    }

    if (cleanProperty === 'options.choices') {
      return choicesToText(fieldData);
    }

    return defaultValue;

  }


  function normalizeColorValue(value) {

    value = String(value || '').trim();

    if (/^#[0-9a-fA-F]{6}$/.test(value)) {
      return value;
    }

    if (/^#[0-9a-fA-F]{3}$/.test(value)) {
      return value;
    }

    return '#000000';

  }

  function getColumnSizeFromWrapper(wrapperClass, breakpoint) {

    const classes = String(wrapperClass || '').split(/\s+/);

    if (breakpoint === 'xs') {

      const found = classes.find(function(cls) {
        return /^col-\d{1,2}$/.test(cls);
      });

      return found ? found.replace('col-', '') : '12';

    }

    const found = classes.find(function(cls) {
      return new RegExp('^col-' + breakpoint + '-\\d{1,2}$').test(cls);
    });

    return found ? found.replace('col-' + breakpoint + '-', '') : '';

  }


  function setColumnSizeInWrapper(wrapperClass, breakpoint, value) {

    let classes = String(wrapperClass || '')
      .split(/\s+/)
      .filter(Boolean);

    if (breakpoint === 'xs') {

      classes = classes.filter(function(cls) {
        return !/^col-\d{1,2}$/.test(cls);
      });

      classes.push('col-' + value);

    } else {

      classes = classes.filter(function(cls) {
        return !new RegExp('^col-' + breakpoint + '-\\d{1,2}$').test(cls);
      });

      if (value !== '') {
        classes.push('col-' + breakpoint + '-' + value);
      }

    }

    return normalizeBootstrapWrapperClass(classes.join(' '));

  }


  function renderInput(label, property, value) {

    let html = '';

    html += '<div class="mb-3">';
    html += '<label class="form-label small fw-bold">' + escapeHtml(label) + '</label>';
    html += '<input type="text" class="form-control form-control-sm automator-form-field-property" data-property="' + escapeHtml(property) + '" value="' + escapeHtml(value) + '">';
    html += '</div>';

    return html;

  }


  function renderOption(value, label, selected) {

    return '<option value="' + escapeHtml(value) + '"' + (String(value) === String(selected) ? ' selected' : '') + '>' + escapeHtml(label) + '</option>';

  }



  function bindFieldPropertyInputs(component) {

    $('.automator-form-field-property')
      .off('.automator-form-field-property')
      .on('input.automator-form-field-property change.automator-form-field-property', function () {

        const input = $(this);
        const property = input.attr('data-property');
        const value = input.val();

        let fieldData = getFieldDataFromComponent(component);

        if (property === 'wrapper_class') {

          fieldData = setFieldProp(fieldData, 'wrapper_class', value);

        } else if (property === 'choices') {

          fieldData = setFieldChoicesFromText(fieldData, value);

        } else if (
          property === 'tbl_sys_forms_field_required' ||
          property === 'tbl_sys_forms_field_locked'
        ) {

          fieldData[property] = String(value) === '1';

        } else {

          fieldData[property] = value;

        }

        if (property === 'tbl_sys_forms_field_title') {

          const currentName = String(fieldData.tbl_sys_forms_field_name || '').trim();
          const currentIndex = String(fieldData.tbl_sys_forms_field_index || '').trim();

          if (!currentName) {
            fieldData.tbl_sys_forms_field_name = stringToSlug(value).replace(/-/g, '_');
          }

          if (!currentIndex) {
            fieldData.tbl_sys_forms_field_index = stringToSlug(value).replace(/-/g, '_');
          }

        }

        setFieldDataToComponent(component, fieldData, {
          refreshPanel: false,
          skipResize: true
        });

        updateLiveFormFieldElement(component, fieldData);

      });

  }


  function fieldSupportsChoices(fieldData) {

    const type = String(fieldData.tbl_sys_field_type_name || '').toLowerCase();

    return (
      type === 'select' ||
      type === 'radio' ||
      type === 'checkbox' ||
      type === 'relation' ||
      type === 'relations' ||
      type === 'dynamic-list' ||
      type === 'dynamic_list'
    );

  }


  /*
  |--------------------------------------------------------------------------
  | Estrutura
  |--------------------------------------------------------------------------
  */

  function updateStructureList() {

    const list = $(selectors.structureList);

    if (!list.length) {
      return false;
    }

    list.empty();

    const components = getFormFieldComponents();

    if (!components.length) {

      list.html(
        '<div class="text-muted text-center py-5 small">' +
          escapeHtml(list.attr('data-empty') || 'Nenhum campo adicionado.') +
        '</div>'
      );

      return true;

    }

    components.forEach(function (component) {

      const fieldData = getFieldDataFromComponent(component);

      const item = $(
        '<div class="automator-editor-structure-item-wrapper" data-cid="' + component.cid + '">' +
          '<div class="automator-editor-body-aside-left-structure-item d-flex align-items-center p-2 border-bottom">' +
            '<i class="fas fa-grip-vertical automator-editor-structure-handle me-2 text-muted"></i>' +
            '<i class="fa fa-cube me-2 small text-primary"></i>' +
            '<span class="small flex-grow-1 text-truncate">' + escapeHtml(fieldData.tbl_sys_forms_field_title || 'Campo') + '</span>' +
          '</div>' +
        '</div>'
      );

      item.on('click', function () {
        grapesEditor.select(component);
      });

      list.append(item);

    });

    initStructureSortable();

    return true;

  }


  function initStructureSortable() {

    if (typeof Sortable === 'undefined') {
      return false;
    }

    const list = document.querySelector(selectors.structureList);

    if (!list || $(list).data('sortable')) {
      return false;
    }

    new Sortable(list, {
      animation: 150,
      handle: '.automator-editor-structure-handle',
      draggable: '.automator-editor-structure-item-wrapper',

      onEnd: function () {
        syncStructureToCanvas();
      }
    });

    $(list).data('sortable', true);

    return true;

  }


  function syncStructureToCanvas() {

    if (!grapesEditor) {
      return false;
    }

    const formComponent = getFormComponent();

    if (!formComponent) {
      return false;
    }

    const orderedCids = [];

    $(selectors.structureList)
      .children('.automator-editor-structure-item-wrapper')
      .each(function () {

        const cid = $(this).attr('data-cid');

        if (cid) {
          orderedCids.push(cid);
        }

      });

    orderedCids.forEach(function (cid, index) {

      const component = findComponentByCid(cid);

      if (component && component.move) {
        component.move(formComponent, { at: index });
      }

    });

    state.hasChanges = true;

    setSaveState(true);
    syncFieldsFromCanvas();
    updateStructureList();

    return true;

  }


  function updateStructureActiveItem(component) {

    $('.automator-editor-structure-item-wrapper').removeClass('is-selected');

    if (!component || !component.cid) {
      return false;
    }

    $('.automator-editor-structure-item-wrapper[data-cid="' + component.cid + '"]')
      .addClass('is-selected');

    return true;

  }


  /*
  |--------------------------------------------------------------------------
  | Sidebar / viewport / preview
  |--------------------------------------------------------------------------
  */

  function switchLeftTab(tab) {

    const sidebar = $(selectors.leftAside);

    if (!sidebar.length) {
      return false;
    }

    const current = sidebar.attr('data-active-tab') || 'inserter';

    if (current === tab && isLeftSidebarOpen()) {
      setLeftSidebarOpen(false);
      updateLeftTabButtons('');
      return true;
    }

    sidebar.attr('data-active-tab', tab);

    updateLeftTabButtons(tab);
    setLeftSidebarOpen(true);

    if (tab === 'structure') {
      updateStructureList();
    }

    return true;

  }


  function updateLeftTabButtons(tab) {

    $('[data-automator-left-tab]').removeClass('is-active');

    if (tab) {
      $('[data-automator-left-tab="' + tab + '"]').addClass('is-active');
    }

  }


  function toggleSidebar(side) {

    if (side === 'left') {

      setLeftSidebarOpen(!isLeftSidebarOpen());

      return true;

    }

    if (side === 'right') {

      setRightSidebarOpen(!isRightSidebarOpen());

      return true;

    }

    return false;

  }


  function isLeftSidebarOpen() {

    const el = $(selectors.leftAside);

    if (window.innerWidth <= 991.98) {
      return el.hasClass('show');
    }

    return !el.hasClass('is-collapsed');

  }


  function isRightSidebarOpen() {

    const el = $(selectors.rightAside);

    if (window.innerWidth <= 991.98) {
      return el.hasClass('show');
    }

    return !el.hasClass('is-collapsed');

  }


  function setLeftSidebarOpen(open) {

    const el = $(selectors.leftAside);

    if (window.innerWidth <= 991.98) {

      el.removeClass('is-collapsed');

      if (open) {
        el.addClass('show');
      } else {
        el.removeClass('show');
      }

      return true;

    }

    el.removeClass('show');

    if (open) {
      el.removeClass('is-collapsed');
    } else {
      el.addClass('is-collapsed');
    }

    return true;

  }


  function setRightSidebarOpen(open) {

    const el = $(selectors.rightAside);

    if (window.innerWidth <= 991.98) {

      el.removeClass('is-collapsed');

      if (open) {
        el.addClass('show');
      } else {
        el.removeClass('show');
      }

      return true;

    }

    el.removeClass('show');

    if (open) {
      el.removeClass('is-collapsed');
    } else {
      el.addClass('is-collapsed');
    }

    return true;

  }

  function getViewportModes() {

    return {
      auto: { label: 'Auto', width: null },
      xs:   { label: 'XS',   width: 375 },
      sm:   { label: 'SM',   width: 576 },
      md:   { label: 'MD',   width: 768 },
      lg:   { label: 'LG',   width: 992 },
      xl:   { label: 'XL',   width: 1200 },
      xxl:  { label: 'XXL',  width: 1400 }
    };

  }


  function normalizeViewportMode(mode) {

    mode = String(mode || 'auto').toLowerCase();

    const aliases = {
      'extra-small': 'xs',
      'small': 'sm',
      'medium': 'md',
      'large': 'lg',
      'extra-large': 'xl',
      'extra-extra-large': 'xxl',
      '2xl': 'xxl',
      'xxl': 'xxl',
      'xl': 'xl',
      'lg': 'lg',
      'md': 'md',
      'sm': 'sm',
      'xs': 'xs',
      'auto': 'auto'
    };

    return aliases[mode] || 'auto';

  }


  function setViewportMode(mode) {

    mode = normalizeViewportMode(mode);

    const modes = getViewportModes();

    if (!modes[mode]) {
      mode = 'auto';
    }

    state.viewportMode = mode;

    updateViewportButton();
    syncCanvasDeviceViewport();

    if (state.previewMode === true) {
      $('.automator-form-editor-static-preview').html(renderStaticPreviewFormHtml());
      applyStaticPreviewColumnStyles();
      bindStaticPreviewEvents($('.automator-form-editor-static-preview'));
    }

    syncCanvasHeight();

    return true;

  }


  function updateViewportButton() {

    const modes = getViewportModes();
    const current = modes[state.viewportMode] || modes.auto;

    $(selectors.viewportLabel).text(current.label);

  }



  function syncCanvasDeviceViewport() {

    const modes = getViewportModes();
    const current = modes[state.viewportMode] || modes.auto;

    const editorCanvas = $('#automator-editor-canvas');
    const container = $(selectors.canvasContainer);
    const canvas = $(selectors.canvas);

    if (!editorCanvas.length || !container.length || !canvas.length) {
      return false;
    }

    const targets = canvas.find(
      '.gjs-editor, .gjs-cv-canvas, .gjs-cv-canvas__frames, .gjs-frame-wrapper, .gjs-frame, iframe'
    );

    if (!current.width) {

      container.css({
        width: '',
        minWidth: '',
        maxWidth: ''
      });

      targets.css({
        width: '',
        minWidth: '',
        maxWidth: ''
      });

      $('.automator-form-editor-static-preview').css({
        width: '',
        minWidth: '',
        maxWidth: ''
      });

    } else {

      container.css({
        width: current.width + 'px',
        minWidth: current.width + 'px',
        maxWidth: current.width + 'px'
      });

      targets.css({
        width: current.width + 'px',
        minWidth: current.width + 'px',
        maxWidth: current.width + 'px'
      });

      $('.automator-form-editor-static-preview').css({
        width: current.width + 'px',
        minWidth: current.width + 'px',
        maxWidth: current.width + 'px'
      });

    }

    editorCanvas.css({
      overflowX: 'auto',
      overflowY: 'auto'
    });

    if (
      grapesEditor &&
      grapesEditor.Canvas &&
      typeof grapesEditor.Canvas.getFrameEl === 'function'
    ) {

      const frameEl = grapesEditor.Canvas.getFrameEl();

      if (frameEl) {

        if (current.width) {
          frameEl.style.width = current.width + 'px';
          frameEl.style.minWidth = current.width + 'px';
          frameEl.style.maxWidth = current.width + 'px';
          frameEl.setAttribute('width', current.width);
        } else {
          frameEl.style.width = '';
          frameEl.style.minWidth = '';
          frameEl.style.maxWidth = '';
          frameEl.removeAttribute('width');
        }

      }

    }

    if (state.previewMode !== true) {
      resetCanvasEditMode();
      bindCanvasClickSelection();
    }

    return true;

  }



  function togglePreviewMode() {

    if (state.previewMode === true) {
      exitPreviewMode();
      return true;
    }

    enterPreviewMode();

    return true;

  }


  function showFormEditorLoader(callback = null) {

    if (typeof AutomatorPageLoader === 'function') {
      AutomatorPageLoader('show');
    }

    setTimeout(function() {
      if (typeof callback === 'function') {
        callback();
      }
    }, 80);

  }


  function hideFormEditorLoader(callback = null) {

    if (typeof AutomatorPageLoader === 'function') {

      AutomatorPageLoader('hide', function() {
        if (typeof callback === 'function') {
          callback();
        }
      });

      return true;

    }

    if (typeof callback === 'function') {
      callback();
    }

    return true;

  }


  function cloneFormEditorData(data) {

    try {
      return JSON.parse(JSON.stringify(data || {}));
    } catch (e) {
      return {};
    }

  }


  function rebuildEditorFromSnapshot(snapshot, callback = null) {

    if (!grapesEditor || !snapshot) {

      if (typeof callback === 'function') {
        callback();
      }

      return false;

    }

    clearSelection();

    const fields = cloneFormEditorData(snapshot.fields || []);

    grapesEditor.setComponents([
      {
        type: 'default',
        tagName: 'form',
        name: 'Formulário',
        classes: ['row'],
        attributes: {
          'data-automator-form-editor-preview': 'true',
          'data-automator-form-editor-dropzone': 'true'
        },
        draggable: false,
        droppable: true,
        editable: false,
        selectable: false,
        hoverable: false,
        highlightable: false,
        copyable: false,
        removable: false,
        components: []
      }
    ]);

    setTimeout(function() {

      injectCanvasStyles();

      const formComponent = getFormComponent();

      if (formComponent) {

        fields
          .sort(function(a, b) {
            return parseInt(a.tbl_sys_forms_field_ordem || 0, 10) - parseInt(b.tbl_sys_forms_field_ordem || 0, 10);
          })
          .forEach(function(fieldData) {
            formComponent.components().add(buildFieldComponent(fieldData));
          });

      }

      reorderHiddenFields();

      formFields = cloneFormEditorData(fields);

      syncFieldsFromCanvas();
      updateStructureList();

      if (snapshot.__editorState) {
        state.hasChanges = snapshot.__editorState.hasChanges === true;
        state.viewportMode = snapshot.__editorState.viewportMode || state.viewportMode;
      }

      setSaveState(state.hasChanges);

      resetCanvasEditMode();
      bindEditorEvents();
      bindCanvasClickSelection();

      if (grapesEditor.refresh) {
        grapesEditor.refresh();
      }

      if (typeof callback === 'function') {
        callback();
      }

    }, 120);

    return true;

  }


  function normalizeCustomClass(value) {

    return String(value || '')
      .split(/\s+/)
      .map(function(cls) {
        return cls.trim();
      })
      .filter(Boolean)
      .filter(function(cls) {
        return !/^col-\d{1,2}$/.test(cls) &&
               !/^col-sm-\d{1,2}$/.test(cls) &&
               !/^col-md-\d{1,2}$/.test(cls) &&
               !/^col-lg-\d{1,2}$/.test(cls) &&
               !/^col-xl-\d{1,2}$/.test(cls) &&
               !/^col-xxl-\d{1,2}$/.test(cls) &&
               cls !== 'automator-form-editor-field-wrapper';
      })
      .join(' ');

  }


  function getFieldComponentClasses(fieldData) {

    const wrapperClass = getFieldWrapperClass(fieldData);
    const customClass = normalizeCustomClass(fieldData.tbl_sys_forms_field_class || '');

    const classes = [];

    wrapperClass.split(/\s+/).filter(Boolean).forEach(function(cls) {
      if (classes.indexOf(cls) === -1) {
        classes.push(cls);
      }
    });

    customClass.split(/\s+/).filter(Boolean).forEach(function(cls) {
      if (classes.indexOf(cls) === -1) {
        classes.push(cls);
      }
    });

    if (classes.indexOf('automator-form-editor-field-wrapper') === -1) {
      classes.push('automator-form-editor-field-wrapper');
    }

    return classes;

  }


  function exitPreviewMode() {

    showFormEditorLoader(function() {

      destroyBootstrapTooltipsSafe($('#automator-editor-header')[0]);

      const snapshot = cloneFormEditorData(previewSnapshot);

      state.previewMode = false;

      if (snapshot.__editorState && snapshot.__editorState.viewportMode) {
        state.viewportMode = normalizeViewportMode(snapshot.__editorState.viewportMode);
      }

      updateViewportButton();

      $(selectors.modal).removeClass('is-preview-mode');

      removeStaticPreviewOverlay();

      disableGrapesTools(false);
      resetCanvasEditMode();

      rebuildEditorFromSnapshot(snapshot, function() {

        previewSnapshot = null;

        setLeftSidebarOpen(true);
        setRightSidebarOpen(true);

        selectFormSettingsTab();

        updatePreviewButton();
        updateViewportButton();

        syncCanvasDeviceViewport();
        syncCanvasHeight();
        syncEditorViewportSpacing();

        setTimeout(function() {

          resetCanvasEditMode();
          bindEditorEvents();
          bindCanvasClickSelection();
          normalizeGrapesToolsPointerEvents();
          restoreGrapesToolbar();


          hideFormEditorLoader();

        }, 150);

      });

    });

    return true;

  }


  function enterPreviewMode() {

    showFormEditorLoader(function() {

      destroyBootstrapTooltipsSafe($('#automator-editor-header')[0]);

      const activeViewportMode = normalizeViewportMode(state.viewportMode || 'auto');

      previewSnapshot = cloneFormEditorData(captureData());

      previewSnapshot.__editorState = {
        hasChanges: state.hasChanges,
        viewportMode: activeViewportMode
      };

      state.viewportMode = activeViewportMode;
      state.previewMode = true;

      updateViewportButton();

      $(selectors.modal).addClass('is-preview-mode');

      clearSelection();

      setLeftSidebarOpen(false);
      setRightSidebarOpen(false);

      removeStaticPreviewOverlay();

      formFields = cloneFormEditorData(previewSnapshot.fields || []);

      createStaticPreviewOverlay();

      disableGrapesTools(true);

      updatePreviewButton();

      syncCanvasDeviceViewport();
      applyStaticPreviewColumnStyles();
      syncCanvasHeight();
      syncEditorViewportSpacing();

      hideFormEditorLoader();

    });

    return true;

  }


  function disableGrapesTools(disabled) {

    const canvasEl = $(selectors.canvas);

    if (disabled) {

      canvasEl
        .find(
          '.gjs-toolbar, .gjs-badge, .gjs-highlighter, .gjs-placeholder, .gjs-tools, .gjs-resizer, .gjs-offset-v, .gjs-offset-fixed-v, .gjs-hovered, .gjs-selected, #gjs-tools, #gjs-cv-tools'
        )
        .css({
          display: 'none',
          pointerEvents: 'none'
        });

      canvasEl
        .find('.gjs-editor')
        .css({
          visibility: 'hidden',
          pointerEvents: 'none',
          position: 'absolute',
          inset: '0',
          zIndex: '1'
        });

      return true;

    }

    resetCanvasEditMode();
    restoreGrapesToolbar();

    return true;

  }



  function resetCanvasEditMode() {

    const canvasEl = $(selectors.canvas);

    canvasEl.removeClass('automator-form-editor-preview-mode');

    canvasEl
      .find(
        '.gjs-editor, .gjs-cv-canvas, .gjs-cv-canvas__frames, .gjs-frame-wrapper, .gjs-frame, iframe'
      )
      .css({
        display: '',
        visibility: '',
        pointerEvents: 'auto',
        position: '',
        inset: '',
        zIndex: '',
        opacity: ''
      });

    canvasEl
      .find(
        '#gjs-tools, #gjs-cv-tools, .gjs-tools, .gjs-toolbar, .gjs-badge, .gjs-highlighter, .gjs-placeholder, .gjs-resizer, .gjs-offset-v, .gjs-offset-fixed-v'
      )
      .css({
        display: '',
        visibility: '',
        opacity: ''
      });

    normalizeGrapesToolsPointerEvents();
    restoreGrapesToolbar();

    return true;

  }


  function normalizeGrapesToolsPointerEvents() {

    const canvasEl = $(selectors.canvas);

    canvasEl
      .find('#gjs-tools, .gjs-tools, .gjs-highlighter, .gjs-badge, .gjs-placeholder, .gjs-resizer, .gjs-offset-v, .gjs-offset-fixed-v')
      .css({
        pointerEvents: 'none'
      });

    canvasEl
      .find('.gjs-toolbar, .gjs-toolbar *')
      .css({
        display: '',
        visibility: '',
        opacity: '',
        pointerEvents: 'auto'
      });

    canvasEl
      .find('.gjs-editor, .gjs-cv-canvas, .gjs-cv-canvas__frames, .gjs-frame-wrapper, .gjs-frame, iframe')
      .css({
        display: '',
        visibility: '',
        pointerEvents: 'auto',
        position: '',
        inset: '',
        zIndex: '',
        opacity: ''
      });

    return true;

  }


  function restoreGrapesToolbar() {

    const canvasEl = $(selectors.canvas);

    canvasEl
      .find('#gjs-tools, #gjs-cv-tools, .gjs-tools')
      .css({
        display: '',
        visibility: '',
        opacity: '',
        pointerEvents: 'none'
      });

    canvasEl
      .find('.gjs-toolbar, .gjs-toolbar *')
      .css({
        display: '',
        visibility: '',
        opacity: '',
        pointerEvents: 'auto'
      });

    canvasEl
      .find('.gjs-badge, .gjs-highlighter, .gjs-resizer, .gjs-placeholder, .gjs-offset-v, .gjs-offset-fixed-v')
      .css({
        display: '',
        visibility: '',
        opacity: '',
        pointerEvents: 'none'
      });

    if (grapesEditor && typeof grapesEditor.refresh === 'function') {
      grapesEditor.refresh();
    }

    return true;

  }


  function applyCanvasPreviewMode(enabled) {

    if (enabled === true) {
      return enterPreviewMode();
    }

    return exitPreviewMode();

  }


  function updatePreviewButton() {

    const btn = $(selectors.previewBtn);
    const icon = btn.find('i');

    if (!btn.length) {
      return false;
    }

    const tooltipText = state.previewMode === true
      ? 'Voltar para edição'
      : 'Pré Visualizar';

    if (state.previewMode === true) {
      icon.removeClass('fa-eye').addClass('fa-edit');
    } else {
      icon.removeClass('fa-edit').addClass('fa-eye');
    }

    btn.attr('title', tooltipText);
    btn.attr('data-bs-title', tooltipText);
    btn.attr('data-tooltip', tooltipText);

    const wrapper = btn.closest('[data-bs-toggle="tooltip"], [data-tooltip]');

    if (wrapper.length) {
      wrapper.attr('title', tooltipText);
      wrapper.attr('data-bs-title', tooltipText);
      wrapper.attr('data-tooltip', tooltipText);
    }

    updatePreviewHeaderControls();

    return true;

  }


  function destroyBootstrapTooltipsSafe(container) {

    try {
      if (document.activeElement && typeof document.activeElement.blur === 'function') {
        document.activeElement.blur();
      }
    } catch (e) {}

    $('.tooltip').remove();

    return true;

  }


  function restoreBootstrapTooltipsSafe(container) {

    $('.tooltip').remove();

    return true;

  }


  function updatePreviewHeaderControls() {

    const previewMode = state.previewMode === true;

    const keepEnabled = [
      '#automator-editor-header-preview-btn',
      '#automator-editor-header-viewport-btn'
    ];

    const header = $('#automator-editor-header');

    destroyBootstrapTooltipsSafe(header[0]);

    header
      .find('button, input, select, textarea')
      .each(function() {

        const el = $(this);

        const shouldKeepEnabled = keepEnabled.some(function(selector) {
          return el.is(selector) || el.closest(selector).length > 0;
        });

        if (previewMode === true) {

          if (shouldKeepEnabled) {
            el.prop('disabled', false).removeClass('automator-editor-preview-disabled');
          } else {
            el.prop('disabled', true).addClass('automator-editor-preview-disabled');
          }

        } else {

          el.prop('disabled', false).removeClass('automator-editor-preview-disabled');

        }

      });

    header
      .find('.dropdown-menu button')
      .prop('disabled', false)
      .removeClass('automator-editor-preview-disabled');

    return true;

  }

  /*
  |--------------------------------------------------------------------------
  | Captura dos dados
  |--------------------------------------------------------------------------
  */

  function captureData() {

    syncFieldsFromCanvas();

    const payload = {
      form: captureFormSettings(),
      fields: formFields,
      editor: {
        source: 'grapesjs-view-only',
        html: '',
        css: '',
        components: grapesEditor
          ? grapesEditor.getComponents().toJSON()
          : []
      }
    };

    return payload;

  }



  function captureFormSettings() {

    const form = {};

    $('#automator-editor-modal')
      .find('[name]')
      .not('[name="form_access[]"]')
      .not('[name="field_access[]"]')
      .each(function () {

        const input = $(this);
        const name = input.attr('name');

        if (!name) {
          return;
        }

        if (input.attr('type') === 'checkbox') {
          form[name] = input.prop('checked') ? 1 : 0;
          return;
        }

        if (input.attr('type') === 'radio') {

          if (input.prop('checked')) {
            form[name] = input.val();
          }

          return;
        }

        form[name] = input.val();

      });

    form.tbl_sys_form_title = $('#tbl_sys_form_title').val() || '';

    form.form_access = isFormAdminEnabled()
      ? getCurrentFormAccess()
      : [];

    return form;

  }



  function syncFieldsFromCanvas() {

    const components = getFormFieldComponents();

    formFields = [];

    components.forEach(function (component, index) {

      const fieldData = getFieldDataFromComponent(component);

      fieldData.tbl_sys_forms_field_ordem = index + 1;
      fieldData.tbl_sys_forms_field_props = getFieldProps(fieldData);
      fieldData.field_access = normalizeAccessValues(fieldData.field_access || []);

      formFields.push(fieldData);

    });

    return formFields;

  }


  /*
  |--------------------------------------------------------------------------
  | Ações
  |--------------------------------------------------------------------------
  */

  function save() {

    const payload = captureData();
    
    $(selectors.modal).attr('data-automator-form-submit', 'true');
    setSaveState(false);

    console.log('Payload do editor de formulário:', payload);

    $('#extracted-json').html(
      JSON.stringify(payload, null, 2)
    );

    return payload;

  }


  function deleteSelectedField() {

    if (!grapesEditor) {
      return false;
    }

    const selected = grapesEditor.getSelected();

    if (!selected) {
      return false;
    }

    const fieldData = getFieldDataFromComponent(selected);

    if (
      fieldData.tbl_sys_forms_field_locked === true ||
      fieldData.tbl_sys_forms_field_locked === 1 ||
      fieldData.tbl_sys_forms_field_locked === '1'
    ) {
      alert('Este campo está bloqueado e não pode ser excluído.');
      return false;
    }

    if (!confirm('Deseja realmente excluir este campo?')) {
      return false;
    }

    selected.remove();

    $(selectors.rightContent).html(
      '<div class="text-center p-3">Selecione um campo para editar.</div>'
    );

    state.hasChanges = true;

    setSaveState(true);
    syncFieldsFromCanvas();
    updateStructureList();

    return true;

  }


  /*
  |--------------------------------------------------------------------------
  | Helpers GrapesJS
  |--------------------------------------------------------------------------
  */

  function getFormComponent() {

    if (!grapesEditor) {
      return null;
    }

    const wrapper = grapesEditor.DomComponents.getWrapper();

    if (!wrapper || !wrapper.components) {
      return null;
    }

    let found = null;

    walkComponents(wrapper.components(), function(component) {

      const attrs = component.getAttributes
        ? component.getAttributes()
        : {};

      if (attrs['data-automator-form-editor-preview'] === 'true') {
        found = component;
        return false;
      }

      return true;

    });

    return found;

  }


  function getFormFieldComponents() {

    const formComponent = getFormComponent();
    const response = [];

    if (!formComponent || !formComponent.components) {
      return response;
    }

    formComponent.components().each(function (component) {

      const attrs = component.getAttributes ? component.getAttributes() : {};

      if (attrs['data-automator-form-field'] === 'true') {
        response.push(component);
      }

    });

    return response;

  }


  function findComponentByCid(cid) {

    if (!grapesEditor || !cid) {
      return null;
    }

    let found = null;

    const wrapper = grapesEditor.DomComponents.getWrapper();

    if (!wrapper) {
      return null;
    }

    walkComponents(wrapper.components(), function (component) {

      if (component.cid === cid) {
        found = component;
        return false;
      }

      return true;

    });

    return found;

  }


  function walkComponents(components, callback) {

    if (!components) {
      return false;
    }

    components.each(function (component) {

      const result = callback(component);

      if (result === false) {
        return false;
      }

      const children = component.components ? component.components() : null;

      if (children && children.length) {
        walkComponents(children, callback);
      }

    });

    return true;

  }


  function clearSelection() {

    if (!grapesEditor) {
      return false;
    }

    try {

      const selected = grapesEditor.getSelected();

      if (selected) {
        grapesEditor.selectRemove(selected);
      }

    } catch (e) {}

    return true;

  }


  /*
  |--------------------------------------------------------------------------
  | Estilo e dimensões
  |--------------------------------------------------------------------------
  */


  function hasActiveUnsavedChanges() {

    const editorEl = document.querySelector(selectors.modal);

    if (!editorEl) {
      return false;
    }

    const modalEl = editorEl.closest('.modal');

    if (!modalEl) {
      return false;
    }

    const modalIsOpen =
      modalEl.classList.contains('show') ||
      $(modalEl).is(':visible');

    if (modalIsOpen !== true) {
      return false;
    }

    if (editorEl.getAttribute('data-automator-form-submit') === 'true') {
      return false;
    }

    if (editorEl.getAttribute('data-automator-form-changed') !== 'true') {
      return false;
    }

    return state.hasChanges === true;

  }



  function requestCloseEditorModal() {

    const editorEl = document.querySelector(selectors.modal);

    if (!editorEl) {
      return true;
    }

    const modalEl = editorEl.closest('.modal');

    if (!modalEl) {
      return true;
    }

    if (hasActiveUnsavedChanges() === true) {

      const confirmClose = confirm(
        'Existem alterações não salvas. Deseja realmente fechar este editor?'
      );

      if (confirmClose !== true) {
        return false;
      }

    }

    clearUnsavedChangesWarning();

    modalEl.setAttribute('data-automator-form-editor-safe-close', 'true');

    try {
      if (
        typeof window.SysAutomatorFormEditor !== 'undefined' &&
        window.SysAutomatorFormEditor
      ) {
        window.SysAutomatorFormEditor.destroy(true);
      }
    } catch (e) {
      console.warn('Editor de formulários já estava destruído.', e);
    }

    safeCloseEditorBootstrapModal(modalEl);

    return true;

  }


  function safeCloseEditorBootstrapModal(modalEl) {

    if (!modalEl) {
      return false;
    }

    const cleanup = function() {

      try {
        modalEl.remove();
      } catch (e) {}

      $('.modal-backdrop').remove();

      if (document.querySelectorAll('.modal.show').length <= 0) {
        document.body.classList.remove('modal-open');
        document.body.style.removeProperty('overflow');
        document.body.style.removeProperty('padding-right');
      }

      $(window).off('beforeunload.AutomatorFormEditorChanged');
      $(window).off('beforeunload.AutomatorModalViewChanged');

      AutomatorSetActionStatus(false);

    };

    try {

      const modalInstance = bootstrap.Modal.getInstance(modalEl);

      modalEl.addEventListener('hidden.bs.modal', function() {
        setTimeout(cleanup, 30);
      }, { once: true });

      if (modalInstance && typeof modalInstance.hide === 'function') {
        modalInstance.hide();
        return true;
      }

    } catch (e) {
      console.warn('Fechamento Bootstrap ignorado para evitar conflito no dispose.', e);
    }

    modalEl.classList.remove('show');
    modalEl.style.display = 'none';

    setTimeout(cleanup, 30);

    return true;

  }

  function syncCanvasHeight() {

    const currentEditor = grapesEditor;

    if (
      !currentEditor ||
      !currentEditor.Canvas ||
      typeof currentEditor.Canvas.getFrameEl !== 'function'
    ) {
      return false;
    }

    setTimeout(function() {

      if (
        !currentEditor ||
        currentEditor !== grapesEditor ||
        !currentEditor.Canvas ||
        typeof currentEditor.Canvas.getFrameEl !== 'function'
      ) {
        return false;
      }

      const frameEl = currentEditor.Canvas.getFrameEl();
      const canvas = $('#automator-editor-canvas');
      const canvasContent = $(selectors.canvas);
      const staticPreview = $('.automator-form-editor-static-preview');

      if (!frameEl || !canvas.length) {
        return false;
      }

      let height = canvas.innerHeight() || 500;

      if (staticPreview.length) {
        height = Math.max(height, staticPreview.outerHeight(true) + 40, 500);
      }

      frameEl.style.height = height + 'px';
      frameEl.style.minHeight = height + 'px';
      frameEl.style.maxHeight = height + 'px';
      frameEl.style.overflow = 'hidden';

      canvasContent
        .find('.gjs-editor, .gjs-cv-canvas, .gjs-cv-canvas__frames, .gjs-frame-wrapper')
        .css({
          height: height + 'px',
          minHeight: height + 'px',
          maxHeight: height + 'px',
          overflow: 'hidden'
        });

      canvasContent.css({
        minHeight: '',
        height: ''
      });

      if (state.previewMode !== true) {
        resetCanvasEditMode();
        bindCanvasClickSelection();
        normalizeGrapesToolsPointerEvents();
      }

    }, 80);

    return true;

  }



  function syncEditorViewportSpacing() {

    const modalContent = $(selectors.modal).closest('.modal-content');
    const modalHeader = modalContent.find('.modal-header');
    const editorHeader = $('#automator-editor-header');
    const editorBody = $('#automator-editor-body');
    const canvas = $('#automator-editor-canvas');

    if (!modalContent.length || !editorBody.length || !canvas.length) {
      return false;
    }

    const availableHeight =
      modalContent.innerHeight()
      - (modalHeader.outerHeight(true) || 0)
      - (editorHeader.outerHeight(true) || 0);

    editorBody.css({
      height: availableHeight + 'px',
      maxHeight: availableHeight + 'px',
      overflow: 'hidden'
    });

    canvas.css({
      height: availableHeight + 'px',
      maxHeight: availableHeight + 'px',
      overflow: 'auto'
    });

    syncCanvasDeviceViewport();

    return true;

  }

  /*
  |--------------------------------------------------------------------------
  | Estado
  |--------------------------------------------------------------------------
  */

    
  function setSaveState(enabled) {

    const hasChanges = enabled === true;

    state.hasChanges = hasChanges;

    $(selectors.saveBtn).prop('disabled', !hasChanges);

    if (hasChanges === true) {
      updateUnsavedChangesWarning(true);
    } else {
      clearUnsavedChangesWarning();
    }

    return true;

  }


  function updateUnsavedChangesWarning(enabled) {

    const modalEl = document.querySelector(selectors.modal);
    const hasChanges = enabled === true;

    if (modalEl) {
      modalEl.setAttribute('data-automator-form-changed', hasChanges ? 'true' : 'false');
    }

    if (window.__automatorFormEditorBeforeUnloadHandler) {
      window.removeEventListener('beforeunload', window.__automatorFormEditorBeforeUnloadHandler);
      window.__automatorFormEditorBeforeUnloadHandler = null;
    }

    if (hasChanges !== true) {
      return true;
    }

    window.__automatorFormEditorBeforeUnloadHandler = function(e) {

      if (hasActiveUnsavedChanges() !== true) {
        return undefined;
      }

      const message = 'Existem alterações não salvas. Ao sair, as informações alteradas poderão ser perdidas.';

      e.preventDefault();
      e.returnValue = message;

      return message;

    };

    window.addEventListener('beforeunload', window.__automatorFormEditorBeforeUnloadHandler);

    return true;

  }

  function bindUnsavedModalCloseWarning() {

    if (window.__automatorFormEditorCloseCaptureHandler) {
      document.removeEventListener(
        'click',
        window.__automatorFormEditorCloseCaptureHandler,
        true
      );
    }

    window.__automatorFormEditorCloseCaptureHandler = function(e) {

      const target = e.target;

      if (!target || !target.closest) {
        return true;
      }

      const editorEl = document.querySelector(selectors.modal);

      if (!editorEl) {
        return true;
      }

      const modalEl = editorEl.closest('.modal');

      if (!modalEl || !modalEl.contains(target)) {
        return true;
      }

      const closeBtn = target.closest(
        '.btn-close, ' +
        '[data-bs-dismiss="modal"], ' +
        '[data-dismiss="modal"], ' +
        '[aria-label="Close"], ' +
        '[aria-label="Fechar"], ' +
        '.js-automator-view-modal-close'
      );

      if (!closeBtn) {
        return true;
      }

      e.preventDefault();
      e.stopPropagation();
      e.stopImmediatePropagation();

      requestCloseEditorModal();

      return false;

    };

    document.addEventListener(
      'click',
      window.__automatorFormEditorCloseCaptureHandler,
      true
    );

    $(document)
      .off('hide.bs.modal.AutomatorFormEditorChanged')
      .on('hide.bs.modal.AutomatorFormEditorChanged', '.modal', function(e) {

        if (!this.querySelector(selectors.modal)) {
          return true;
        }

        if (this.getAttribute('data-automator-form-editor-safe-close') === 'true') {
          return true;
        }

        e.preventDefault();

        requestCloseEditorModal();

        return false;

      });

    $(document)
      .off('hidden.bs.modal.AutomatorFormEditorChanged')
      .on('hidden.bs.modal.AutomatorFormEditorChanged', '.modal', function() {

        if (!this.querySelector(selectors.modal)) {
          return true;
        }

        clearUnsavedChangesWarning();

        return true;

      });

    return true;

  }


  /*
  |--------------------------------------------------------------------------
  | Utilitários
  |--------------------------------------------------------------------------
  */

  function boolToString(value) {

    return (
      value === true ||
      value === 1 ||
      value === '1' ||
      value === 'true'
    ) ? '1' : '0';

  }


  function escapeHtml(value) {

    return String(value || '')
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');

  }


  function getEditor() {
    return grapesEditor;
  }


  function getState() {
    return state;
  }

  function getFormEditorLoadUrl(formID) {

    let url = '';

    if (
      typeof window.AutomatorPaginationRoutes !== 'undefined' &&
      window.AutomatorPaginationRoutes.get
    ) {
      url = window.AutomatorPaginationRoutes.get;
    } else if (
      typeof window.AutomatorRoutes !== 'undefined' &&
      window.AutomatorRoutes.apiForms
    ) {
      url = window.AutomatorRoutes.apiForms;
    }

    url = String(url || '').replace('#ID#', formID);

    url += url.indexOf('?') >= 0
      ? '&mode=editor'
      : '?mode=editor';

    return url;

  }


  function loadExistingForm(formID, callback = null) {

    const url = getFormEditorLoadUrl(formID);

    if (!url) {
      alert('Rota para carregar formulário não encontrada.');
      return false;
    }

    $.ajax({
      url: url,
      type: 'GET',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'Accept': 'application/json'
      },
      dataType: 'json',
      success: function(response) {

        if (!response || response.status !== true) {
          alert(response && response.message ? response.message : 'Não foi possível carregar o formulário.');
          return false;
        }

        applyExistingFormData(response);

        if (typeof callback === 'function') {
          callback(response);
        }

      },
      error: function(xhr) {

        let message = 'Não foi possível carregar o formulário.';

        if (xhr.responseJSON && xhr.responseJSON.message) {
          message = xhr.responseJSON.message;
        }

        alert(message);

      }
    });

    return true;

  }



  function refreshAllRelationFieldsOptions(callback = null) {

    const relationComponents = [];

    getFormFieldComponents().forEach(function(component) {

      const fieldData = getFieldDataFromComponent(component);
      const type = String(fieldData.tbl_sys_field_type_name || '').toLowerCase();

      if (type === 'relation' || type === 'relations') {
        relationComponents.push(component);
      }

    });

    if (!relationComponents.length) {

      if (typeof callback === 'function') {
        callback();
      }

      return true;

    }

    let pending = relationComponents.length;

    relationComponents.forEach(function(component) {

      refreshRelationComponentOptions(component, {
        silent: true,
        showLoader: false,
        callback: function() {

          pending--;

          if (pending <= 0 && typeof callback === 'function') {
            callback();
          }

        }
      });

    });

    return true;

  }



  function applyExistingFormData(response) {

    applyEditorSecurityResponse(response);

    const formData = response.form || {};
    const fields = response.fields || [];

    state.currentFormLocked = isTruthyValue(formData.tbl_sys_form_locked);
    state.suppressChangeTracking = true;

    Object.keys(formData).forEach(function(name) {

      if (name === 'form_access') {
        return;
      }

      const field = $('#automator-editor-modal').find('[name="' + name + '"]');

      if (!field.length) {
        return;
      }

      if (field.attr('type') === 'checkbox') {
        field.prop('checked', isTruthyValue(formData[name]));
        return;
      }

      field.val(formData[name]);

    });

    if (formData.tbl_sys_form_title) {
      $('#tbl_sys_form_title').val(formData.tbl_sys_form_title);
    }

    $('#tbl_sys_form_title-sync').prop('checked', false);

    renderFormSecurityPanel(formData.form_access || []);

    const formComponent = getFormComponent();

    if (!formComponent) {
      state.suppressChangeTracking = false;
      return false;
    }

    formComponent.components([]);

    fields.forEach(function(field) {

      const fieldData = normalizeExistingFormFieldData(field);

      formComponent.components().add(
        buildFieldComponent(fieldData)
      );

    });

    reorderHiddenFields();
    syncFieldsFromCanvas();
    updateStructureList();
    syncCanvasHeight();
    syncEditorViewportSpacing();
    syncCanvasDeviceViewport();
    syncFormSecurityState();

    refreshAllRelationFieldsOptions(function() {

      state.isNew = false;
      state.hasChanges = false;
      state.suppressChangeTracking = false;

      setSaveState(false);

      syncFieldsFromCanvas();
      updateStructureList();
      syncCanvasHeight();
      syncEditorViewportSpacing();

    });

    return true;

  }


  function normalizeExistingFormFieldData(field) {

    const props =
      typeof field.tbl_sys_forms_field_props === 'object' &&
      field.tbl_sys_forms_field_props !== null
        ? field.tbl_sys_forms_field_props
        : {};

    if (!props.input_id) {
      props.input_id = 'field_' + String(field.tbl_sys_forms_field_name || 'campo').replace(/[^a-zA-Z0-9_]/g, '_');
    }

    if (!props.wrapper_class && String(field.tbl_sys_field_type_name || '').toLowerCase() !== 'hidden') {
      props.wrapper_class = 'col-12';
    }

    return {
      uid: field.uid || ('form-field-existing-' + (field.tbl_sys_forms_field_ID || Date.now())),

      tbl_sys_forms_field_ID: field.tbl_sys_forms_field_ID || '',
      tbl_sys_field_type_ID: field.tbl_sys_field_type_ID || '',
      tbl_sys_field_type_name: field.tbl_sys_field_type_name || '',
      tbl_sys_field_type_icon: field.tbl_sys_field_type_icon || 'square',

      tbl_sys_forms_field_title: field.tbl_sys_forms_field_title || '',
      tbl_sys_forms_field_name: field.tbl_sys_forms_field_name || '',
      tbl_sys_forms_field_index: field.tbl_sys_forms_field_index || '',
      tbl_sys_forms_field_class: field.tbl_sys_forms_field_class || '',
      tbl_sys_forms_field_default: field.tbl_sys_forms_field_default || '',
      tbl_sys_forms_field_attrs: field.tbl_sys_forms_field_attrs || '',
      tbl_sys_forms_field_required: field.tbl_sys_forms_field_required || false,
      tbl_sys_forms_field_locked: field.tbl_sys_forms_field_locked || false,
      tbl_sys_forms_field_ordem: field.tbl_sys_forms_field_ordem || 0,

      field_access: normalizeAccessValues(field.field_access || []),

      raw: field.raw || {},

      tbl_sys_forms_field_props: props
    };

  }


  function getRelationFieldType(fieldData) {

    const type = String(fieldData.tbl_sys_field_type_name || '').toLowerCase();

    if (type !== 'relation' && type !== 'relations') {
      return '';
    }

    const props = getFieldProps(fieldData);

    let relationType = props.type || '';

    if (
      (!relationType || relationType === '') &&
      props.params &&
      typeof props.params === 'object'
    ) {
      relationType =
        props.params['advanced.type'] ||
        props.params['type'] ||
        props.params['configs.type'] ||
        '';
    }

    relationType = String(relationType || 'select').toLowerCase();

    if (
      relationType !== 'checkbox' &&
      relationType !== 'radio' &&
      relationType !== 'select'
    ) {
      relationType = 'select';
    }

    return relationType;

  }


  function isRelationCheckboxField(fieldData) {

    return getRelationFieldType(fieldData) === 'checkbox';

  }


  function isRelationRadioField(fieldData) {

    return getRelationFieldType(fieldData) === 'radio';

  }


  function isChoiceListField(fieldData) {

    const type = String(fieldData.tbl_sys_field_type_name || '').toLowerCase();

    return (
      type === 'checkbox' ||
      type === 'dynamic-list' ||
      type === 'dynamic_list' ||
      isRelationCheckboxField(fieldData) ||
      isRelationRadioField(fieldData)
    );

  }



  function normalizeChoiceItemLabel(item, fallback = '') {

    if (item && typeof item === 'object') {

      if (typeof item.label !== 'undefined') {
        return String(item.label);
      }

      if (typeof item.name !== 'undefined') {
        return String(item.name);
      }

      if (typeof item.title !== 'undefined') {
        return String(item.title);
      }

      if (typeof item.tbl_users_type_name !== 'undefined') {
        return String(item.tbl_users_type_name);
      }

    }

    if (
      typeof item !== 'undefined' &&
      item !== null &&
      String(item) !== ''
    ) {
      return String(item);
    }

    return String(fallback);

  }


  function getRelationLabelColumn(fieldData) {

    const props = getFieldProps(fieldData);
    const relation = props.relation && typeof props.relation === 'object' ? props.relation : {};

    if (typeof relation.label === 'string') {
      return String(relation.label || '').trim();
    }

    if (relation.label && typeof relation.label === 'object') {

      if (typeof relation.label.display !== 'undefined') {
        return String(relation.label.display || '').trim();
      }

      if (typeof relation.label.value !== 'undefined') {
        return String(relation.label.value || '').trim();
      }

    }

    return '';

  }



  function getRelationChoicesFromState(fieldData) {

    const props = getFieldProps(fieldData);

    if (
      props.relation_options &&
      typeof props.relation_options === 'object' &&
      Object.keys(props.relation_options).length
    ) {
      return props.relation_options;
    }

    return {};

  }



  $(window)
    .off('resize.automator-form-editor')
    .on('resize.automator-form-editor', function () {

      syncCanvasHeight();
      syncEditorViewportSpacing();

    });


  return {
    config,
    init,
    destroy,

    loadExistingForm,

    switchLeftTab,
    toggleSidebar,

    setViewportMode,
    togglePreviewMode,

    syncHeaderInputSlug,
    bindHeaderSlugSync,

    loadEditorSecurityOptions,
    renderFormSecurityPanel,
    syncFormSecurityState,
    captureData,
    save,
    deleteSelectedField,

    clearUnsavedChangesWarning,
    requestCloseEditorModal,

    getEditor,
    getState
  };

})();


/*
|--------------------------------------------------------------------------
| Wrappers globais usados pelo AutomatorCreateViewModal
|--------------------------------------------------------------------------
*/


function SysAutomatorConfigFormEditor(
  response,
  modalEl,
  modal,
  recordData
) {

  AutomatorPageLoader('show');

  const formID =
    response.formID ||
    response.form_id ||
    response.tbl_sys_form_ID ||
    null;

  SysAutomatorFormEditor.config({
    isNew: !formID,
    formID: formID
  }, function () {

    SysAutomatorFormEditor.init(function () {

      if (formID) {

        SysAutomatorFormEditor.loadExistingForm(formID, function() {

          setTimeout(function () {

            const state = SysAutomatorFormEditor.getState();

            if (state) {
              state.suppressChangeTracking = false;
              state.hasChanges = false;
            }

            SysAutomatorFormEditor.clearUnsavedChangesWarning();

            AutomatorPageLoader('hide', function () {
              AutomatorSetActionStatus(false);
            });

          }, 350);

        });

        return;

      }

      $('#tbl_sys_form_title-sync').prop('checked', true);

      const titleInput = $('#tbl_sys_form_title');

      if (titleInput.length) {

        SysAutomatorFormEditor.syncHeaderInputSlug(titleInput[0]);

        setTimeout(function () {
          titleInput.trigger('focus');
        }, 100);

      }

      setTimeout(function () {

        const state = SysAutomatorFormEditor.getState();

        if (state) {
          state.suppressChangeTracking = false;
          state.hasChanges = false;
        }

        SysAutomatorFormEditor.clearUnsavedChangesWarning();

        AutomatorPageLoader('hide', function () {
          AutomatorSetActionStatus(false);
        });

      }, 350);

    });

  });

}


function SysAutomatorInitFormEditor(
  response,
  modalEl,
  modal,
  recordData
) {

  return true;

}


function SysAutomatorDestroyFormEditor(
  response,
  modalEl,
  modal,
  recordData
) {

  if (
    typeof window.SysAutomatorFormEditor === 'undefined' ||
    !window.SysAutomatorFormEditor
  ) {
    return true;
  }

  try {

    SysAutomatorFormEditor.destroy(true);

  } catch (e) {

    console.warn(
      'Editor de formulários já estava destruído ou não foi inicializado.',
      e
    );

  }

  return true;

}


function SysAutomatorCaptureFormEditorData() {

  if (
    typeof window.SysAutomatorFormEditor === 'undefined' ||
    !window.SysAutomatorFormEditor
  ) {
    return {};
  }

  return SysAutomatorFormEditor.captureData();

}


function SysAutomatorSaveFormEditor() {

  if (
    typeof window.SysAutomatorFormEditor === 'undefined' ||
    !window.SysAutomatorFormEditor
  ) {
    return false;
  }

  return SysAutomatorFormEditor.save();

}