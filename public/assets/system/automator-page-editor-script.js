window.SysAutomatorEditor = (function () {

  const defaultState = {
    isNew: true,
    hasChanges: false,
    initialized: false,
    componentsLoaded: false,
    componentsLoading: false
  };

  const defaultEditor = {
    content: '',
    css: '',
    blocks: {},
    components: {},
    settingsBlock: {
      collapsed: false,
      tab: 'page-settings'
    }
  };

  let state = $.extend(true, {}, defaultState);
  let editor = $.extend(true, {}, defaultEditor);
  let grapesEditor = null;

  const selectors = {
    canvas: '#automator-editor-canvas-container-content',
    leftAside: '#automator-editor-aside-left',
    rightAside: '#automator-editor-aside-right',
    inserterBlock: '#automator-editor-aside-left-inserter',
    inserterList: '#automator-editor-aside-left-inserter-list',
    structureBlock: '#automator-editor-aside-left-structure',
    structureList: '#automator-editor-aside-left-structure-list',
    rightContent: '#automator-editor-aside-right-content',
    saveBtn: '#automator-editor-header-save-btn'
  };

  function config(data = {}, callback = null) {

    state = $.extend(true, {}, defaultState);
    editor = $.extend(true, {}, defaultEditor);

    if (typeof data.isNew !== 'undefined') {
      state.isNew = data.isNew;
    }

    if (data.editor) {
      $.extend(true, editor, data.editor);
    }

    prepareSidebarItems();

    loadSidebarComponents(function () {
      if (typeof callback === 'function') {
        callback({ state, editor, selectors, grapesEditor });
      }
    });

  }

  function init(callback = null) {

    if (!$(selectors.canvas).length) {
      console.warn('Área central do editor não encontrada.');
      return;
    }

    destroy(false);

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
        styles: [
          'https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css'
        ]
      },
      deviceManager: {
        devices: []
      }
    });

    loadInitialContent();
    bindInterfaceBlocks();
    bindEditorEvents();
    initInterface();

    state.initialized = true;
    state.hasChanges = false;

    setSaveState(false);
    updateStructureList();

    if (typeof callback === 'function') {
      callback({ state, editor, selectors, grapesEditor });
    }

  }

  function destroy(resetConfig = true) {

    if (grapesEditor) {
      try {
        grapesEditor.destroy();
      } catch (e) {
        console.warn('Erro ao destruir GrapesJS:', e);
      }
    }

    grapesEditor = null;

    $(selectors.canvas).empty();
    $(selectors.structureList).empty();

    if ($(selectors.rightContent).length) {
      $(selectors.rightContent).html('<div class="text-center p-3">Selecione um bloco para editar.</div>');
    }

    if (resetConfig === true) {
      state = $.extend(true, {}, defaultState);
      editor = $.extend(true, {}, defaultEditor);
    }

  }

  function prepareSidebarItems() {

    $(selectors.inserterList).find('[data-block-type-id]').each(function () {

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

    const items = $(selectors.inserterList).find('[data-block-type-id]');

    editor.components = {};

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

      const request = $.ajax({
        url: window.AutomatorRoutes.apiEditor || '',
        type: 'POST',
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          'Accept': 'application/json'
        },
        data: {
          fieldTypeID: fieldTypeID
        }
      })
      .done(function (response) {

        const automator = extractAutomatorPayload(response);

        editor.components[fieldTypeID] = normalizeComponentResponse(
          fieldTypeID,
          automator,
          item
        );

      })
      .fail(function () {

        editor.components[fieldTypeID] = normalizeComponentResponse(
          fieldTypeID,
          null,
          item
        );

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

  function extractAutomatorPayload(response) {

    if (!response) {
      return null;
    }

    if (response.automator) {
      return response.automator;
    }

    if (response.field) {
      return response.field;
    }

    if (response.data) {
      return response.data;
    }

    if (response.dados) {
      return response.dados;
    }

    return response;

  }

  function normalizeComponentResponse(fieldTypeID, automator, item) {

    const title =
      item.attr('data-bs-title') ||
      item.find('span').first().text() ||
      getValue(automator, 'title') ||
      getValue(automator, 'tbl_sys_field_type_title') ||
      'Bloco';

    const icon =
      item.attr('data-block-icon') ||
      getValue(automator, 'icon') ||
      getValue(automator, 'tbl_sys_field_type_icon') ||
      'cube';

    const type =
      item.attr('data-block-type') ||
      getValue(automator, 'type') ||
      getValue(automator, 'tbl_sys_field_type_name') ||
      '';

    return {
      id: String(fieldTypeID),
      title: title,
      icon: icon,
      type: type,
      loaded: !!automator,
      hasChild: canAutomatorHaveChild(automator),
      grapesComponent: buildGrapesComponent(fieldTypeID, automator, item, title),
      raw: automator || null
    };

  }

  function loadInitialContent() {

    if (!grapesEditor) {
      return;
    }

    if (editor.content) {
      grapesEditor.setComponents(editor.content);
    } else {
      grapesEditor.setComponents('');
    }

    if (editor.css) {
      grapesEditor.setStyle(editor.css);
    }

  }

  function initInterface(callback = null) {

    updateLeftTabVisibility('inserter');
    setLeftSidebarOpen(true);

    if (editor.settingsBlock && editor.settingsBlock.collapsed === true) {
      $(selectors.rightAside).addClass('is-collapsed').removeClass('show');
    } else {
      $(selectors.rightAside).removeClass('is-collapsed');
    }

    initBootstrapHelpers();

    if (typeof callback === 'function') {
      callback({ state, editor, selectors, grapesEditor });
    }

  }

  function bindInterfaceBlocks() {

    $(selectors.inserterList).find('[data-block-type-id]').each(function () {

      const item = $(this);
      const fieldTypeID = String(item.attr('data-block-type-id') || '');

      item.off('.automator-editor');

      item.on('click.automator-editor', function (event) {

        event.preventDefault();
        event.stopPropagation();

        hideBootstrapFloatingElements();

        injectBlock(fieldTypeID);

      });

    });

  }

  function syncEditorViewportSpacing() {

    const modalContent = $('#automator-editor-modal').closest('.modal-content');
    const modalHeader  = $('#automator-editor-modal').closest('.modal-content').find('.modal-header');
    const editorHeader = $('#automator-editor-header');

    const editorBody   = $('#automator-editor-body');
    const canvas       = $('#automator-editor-canvas');

    if (
        !modalContent.length ||
        !editorBody.length ||
        !canvas.length
    ) {
        return;
    }

    const totalHeight =
        modalContent.innerHeight();

    const modalHeaderHeight =
        modalHeader.outerHeight(true) || 0;

    const editorHeaderHeight =
        editorHeader.outerHeight(true) || 0;

    const availableHeight =
        totalHeight
        - modalHeaderHeight
        - editorHeaderHeight;

    editorBody.css({
        height: availableHeight + 'px',
        maxHeight: availableHeight + 'px'
    });

    canvas.css({
        height: availableHeight + 'px',
        maxHeight: availableHeight + 'px'
    });

    if (grapesEditor) {
        grapesEditor.refresh();
    }

  }

  function bindEditorEvents() {

    if (!grapesEditor) {
      return;
    }

    grapesEditor.on('load', function () {
      injectCanvasEditorStyles();
      normalizeAllCardChildrenOrder();
      syncCanvasHeight();
      syncEditorViewportSpacing();
    });

    grapesEditor.on('update', function () {
      state.hasChanges = true;
      setSaveState(true);
      normalizeAllCardChildrenOrder();
      updateStructureList();
      updateEmptyContainers();

      if (!isEditingPropertiesPanel()) {
        syncCanvasHeight();
        syncEditorViewportSpacing();
      }
    });

    grapesEditor.on('component:selected', function (component) {
      renderComponentSettings(component);
      updateStructureActiveItem(component);
      updateEmptyContainers();

      if (!isEditingPropertiesPanel()) {
        syncCanvasHeight();
        syncEditorViewportSpacing();
      }
    });

    grapesEditor.on('component:deselected', function () {
      $(selectors.rightContent).html('Selecione um bloco para editar.');
      updateStructureActiveItem(null);
      updateEmptyContainers();

      if (!isEditingPropertiesPanel()) {
        syncCanvasHeight();
        syncEditorViewportSpacing();
      }
    });

    grapesEditor.on('component:add component:remove component:drag:end', function () {
      normalizeAllCardChildrenOrder();
      updateStructureList();
      updateEmptyContainers();

      syncCanvasHeight();
      syncEditorViewportSpacing();
    });

    grapesEditor.on('component:update', function () {
      normalizeAllCardChildrenOrder();
      updateStructureList();
      updateEmptyContainers();

      if (!isEditingPropertiesPanel()) {
        syncCanvasHeight();
        syncEditorViewportSpacing();
      }
    });

  }

  function injectBlock(fieldTypeID) {

    fieldTypeID = String(fieldTypeID || '');

    if (!grapesEditor) {
      alert('Editor ainda não foi inicializado.');
      return;
    }

    if (state.componentsLoading === true) {
      alert('Os blocos ainda estão sendo carregados. Aguarde um instante.');
      return;
    }

    const componentData = editor.components[fieldTypeID];

    if (!componentData || componentData.loaded !== true) {
      alert('Este bloco não foi carregado corretamente.');
      return;
    }

    if (!componentData.grapesComponent) {
      alert('Este bloco não possui configuração para inserir.');
      return;
    }

    const componentType = getComponentDataType(componentData);
    const selected = grapesEditor.getSelected();

    const componentConfig = buildComponentConfigForInsertion(componentData);

    let targetParent = null;

    if (isCardSectionType(componentType)) {

      targetParent = resolveCardSectionInsertionParent(selected);

      if (!targetParent) {
        alert('Este componente só pode ser inserido diretamente dentro de um Card.');
        return;
      }

      if (!canAddCardSectionToCard(targetParent, componentType, null)) {
        alert('Este Card já possui este componente.');
        return;
      }

    } else if (canReceiveChildren(selected)) {

      targetParent = selected;

    }

    let addedComponents;

    if (targetParent) {
      removePlaceholderChildren(targetParent);
      addedComponents = targetParent.components().add(componentConfig);
    } else {
      addedComponents = grapesEditor.addComponents(componentConfig);
    }

    selectAddedComponent(addedComponents);

    const addedComponent = getFirstAddedComponent(addedComponents);

    if (addedComponent) {

      const cardParent = isCardComponent(addedComponent)
        ? addedComponent
        : findClosestCardComponent(addedComponent);

      if (cardParent) {
        normalizeCardChildrenOrder(cardParent);
      }

    }

    normalizeAllCardChildrenOrder();

    state.hasChanges = true;

    setSaveState(true);
    updateStructureList();
    updateEmptyContainers();
    syncCanvasHeight();
    syncEditorViewportSpacing();

  }

  function canReceiveChildren(component) {

    if (!component || !component.get || !component.components) {
      return false;
    }

    const attrs = component.getAttributes ? component.getAttributes() : {};
    const canHaveChild = attrs['data-automator-can-have-child'] === 'true';

    return canHaveChild && component.get('droppable') === true;

  }

  function getReservedEditorClasses() {

    return [
      'automator-editor-visual-space',
      'automator-editor-component'
    ];

  }

  function isReservedEditorClass(className) {

    return getReservedEditorClasses().indexOf(className) !== -1;

  }

  function sanitizeEditorClasses(classes) {

    if (!classes) {
      return [];
    }

    if (typeof classes === 'string') {
      classes = classes.split(/\s+/);
    }

    return classes.filter(function (className) {
      return className && !isReservedEditorClass(className);
    });

  }

  function ensureEditorInternalClasses(classes) {

    classes = sanitizeEditorClasses(classes);

    classes.push('automator-editor-visual-space');

    return uniqueArray(classes);

  }

  function buildGrapesComponent(fieldTypeID, field, item, fallbackTitle) {

    if (!field) {
      return null;
    }

    if (isShortcodeLikeComponent(field)) {
      return buildShortcodeLikeComponent(fieldTypeID, field, item, fallbackTitle);
    }

    const tagName = getAutomatorTag(field);
    let baseClasses = getAutomatorClasses(field);
    const canHaveChild = canAutomatorHaveChild(field);
    const editable = canAutomatorBeEdited(field);
    const textContent = getDefaultContent(field, fallbackTitle);

    let initialClasses = baseClasses.slice();

    if (isColumnField(field, item, fallbackTitle)) {

      baseClasses = baseClasses.filter(function (className) {
        return !isBootstrapColumnSizeClass(className);
      });

      initialClasses = uniqueArray(
        baseClasses.concat(getDefaultBootstrapColumnClasses(field))
      );

    }

    const component = {
      type: editable ? 'text' : 'default',
      name: fallbackTitle,
      tagName: tagName,
      classes: ensureEditorInternalClasses(initialClasses),
      attributes: {
        'data-automator-field-type-id': String(fieldTypeID),
        'data-automator-field-type-name': item.attr('data-block-type') || '',
        'data-automator-field-type-title': fallbackTitle,
        'data-automator-base-classes': sanitizeEditorClasses(baseClasses).join(' '),
        'data-automator-can-have-child': canHaveChild ? 'true' : 'false'
      },
      draggable: true,
      droppable: canHaveChild ? true : false,
      editable: editable,
      selectable: true,
      hoverable: true,
      highlightable: true,
      copyable: true,
      removable: true
    };

    if (canHaveChild) {
      component.components = [
        buildPlaceholderComponent()
      ];
      return component;
    }

    component.droppable = false;

    if (textContent) {
      component.components = [
        {
          type: 'textnode',
          content: textContent,
          draggable: false,
          droppable: false,
          selectable: false,
          editable: true,
          removable: false,
          copyable: false
        }
      ];
    }

    if (tagName === 'img') {
      component.attributes.src = getDefaultImage(field);
      component.attributes.alt = fallbackTitle;
      component.void = true;
      component.droppable = false;
      component.editable = false;
      delete component.components;
    }

    if (tagName === 'hr' || tagName === 'br') {
      component.void = true;
      component.droppable = false;
      component.editable = false;
      delete component.components;
    }

    return component;

  }

  function isShortcodeLikeComponent(field) {

    const type = String(getValue(field, 'type') || '').toLowerCase();
    const tag = getAutomatorTag(field);
    const prefix = String(getValue(field, 'prefix') || '').toLowerCase();
    const sufix = String(getValue(field, 'sufix') || getValue(field, 'suffix') || '').toLowerCase();

    return (
      type === 'pagination' ||
      tag === 'code' ||
      prefix.indexOf('<code') !== -1 ||
      sufix.indexOf('</code>') !== -1
    );

  }

  function buildShortcodeLikeComponent(fieldTypeID, field, item, fallbackTitle) {

    const baseClasses = sanitizeEditorClasses(getAutomatorClasses(field));
    const defaultValues = getDefaultShortcodeValues(field);
    const previewText = getShortcodePreviewText(field, defaultValues);

    return {
      type: 'default',
      name: fallbackTitle,
      tagName: 'div',
      classes: ensureEditorInternalClasses(baseClasses),
      attributes: {
        'data-automator-field-type-id': String(fieldTypeID),
        'data-automator-field-type-name': item.attr('data-block-type') || '',
        'data-automator-field-type-title': fallbackTitle,
        'data-automator-base-classes': baseClasses.join(' '),
        'data-automator-can-have-child': 'false',
        'data-automator-shortcode-component': 'true'
      },
      style: {
        width: '100%'
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
          tagName: 'div',
          name: 'Pré-visualização',
          classes: ['automator-editor-shortcode-preview'],
          attributes: {
            'data-automator-shortcode-preview': 'true'
          },
          draggable: false,
          droppable: false,
          editable: false,
          selectable: false,
          hoverable: false,
          highlightable: false,
          copyable: false,
          removable: false,
          content: previewText
        }
      ]
    };

  }

  function buildShortcodeLikeHtml(field, values = {}) {

    const type = String(getValue(field, 'type') || '').toLowerCase();

    if (type === 'shortcode') {
      return buildDynamicShortcodeHtml(field, values);
    }

    let html = '';

    html += getValue(field, 'prefix') || '';
    html += getValue(field, 'sufix') || getValue(field, 'suffix') || '';

    html = String(html || '');

    $.each(values, function (key, value) {
      html = html.replaceAll('${' + key + '}', value || '');
      html = html.replaceAll('[$' + key + '$]', value || '');
    });

    html = html
      .replaceAll('${name}', values.name || '')
      .replaceAll('[$name$]', values.name || '')
      .replaceAll('[$content$]', '')
      .replaceAll('[$children$]', '');

    html = html.replace(/\$\{[^}]+\}/g, '');

    if (!html) {
      html = '<code>[' + (getValue(field, 'type') || 'automator') + ']</code>';
    }

    return html;

  }

  function buildDynamicShortcodeHtml(field, values = {}) {

    const shortcode =
      values.shortcode ||
      values['config.shortcode'] ||
      '';

    if (!shortcode) {
      return '<div style="width: 100%;"><code>[shortcode]</code></div>';
    }

    const definitions = getShortcodeDefinitions(field);
    const selected = definitions[shortcode] || null;
    const params = selected ? selected.params || {} : {};

    let attrs = '';

    $.each(params, function (paramKey) {

      let value =
        values['shortcode_params.' + paramKey] ||
        values[paramKey] ||
        '';

      if (typeof value === 'undefined' || value === null) {
        value = '';
      }

      if (paramKey === 'vars' && String(value) === '') {
        attrs += ' vars=""';
        return;
      }

      if (String(value) === '') {
        return;
      }

      attrs += ' ' + paramKey + '="' + escapeShortcodeAttribute(value) + '"';

    });

    return '<div style="width: 100%;"><code>[' + shortcode + attrs + ']</code></div>';

  }

  function escapeShortcodeAttribute(value) {

    return String(value || '')
      .replace(/&/g, '&amp;')
      .replace(/"/g, '&quot;')
      .replace(/\[/g, '&#91;')
      .replace(/\]/g, '&#93;');

  }

  function buildPlaceholderComponent() {

    return {
      tagName: 'button',
      name: 'Adicionar bloco',
      classes: ['automator-editor-child-placeholder'],
      attributes: {
        type: 'button',
        'data-automator-placeholder': 'true'
      },
      content: '+',
      draggable: false,
      droppable: false,
      editable: false,
      selectable: false,
      hoverable: false,
      highlightable: false,
      copyable: false,
      removable: false
    };

  }

  function updateEmptyContainers() {

    if (!grapesEditor) {
      return;
    }

    const wrapper = grapesEditor.DomComponents.getWrapper();

    if (!wrapper) {
      return;
    }

    walkComponents(wrapper.components(), function (component) {

      const attributes = component.getAttributes ? component.getAttributes() : {};
      const canHaveChild = attributes['data-automator-can-have-child'] === 'true';

      if (!canHaveChild) {
        removePlaceholderChildren(component);
        component.set('droppable', false);
        return;
      }

      component.set('droppable', true);

      const children = component.components();
      let realChildren = 0;
      let placeholder = null;

      children.each(function (child) {

        const childAttrs = child.getAttributes ? child.getAttributes() : {};

        if (childAttrs['data-automator-placeholder'] === 'true') {
          placeholder = child;
        } else {
          realChildren++;
        }

      });

      if (realChildren === 0 && !placeholder) {
        component.components().add(buildPlaceholderComponent());
      }

      if (realChildren > 0 && placeholder) {
        placeholder.remove();
      }

    });

  }

  function removePlaceholderChildren(component) {

    if (!component || !component.components) {
      return;
    }

    component.components().each(function (child) {

      const attributes = child.getAttributes ? child.getAttributes() : {};

      if (attributes['data-automator-placeholder'] === 'true') {
        child.remove();
      }

    });

  }

  function renderComponentSettings(component) {

    if (!component) {
      $(selectors.rightContent).html('Selecione um bloco para editar.');
      return;
    }

    const attributes = component.getAttributes ? component.getAttributes() : {};
    const fieldTypeID = attributes['data-automator-field-type-id'] || '';
    const componentData = getComponent(fieldTypeID);
    const raw = componentData ? componentData.raw : null;

    const componentName =
      component.get('name') ||
      attributes['data-automator-field-type-title'] ||
      component.get('tagName') ||
      'Bloco';

    const tagName = component.get('tagName') || 'div';
    const baseClasses = getBaseClassesFromComponent(component);

    let html = '';

    html += '<div class="mb-3 mt-1">';
    html += '<label class="form-label small fw-bold">Componente</label>';
    html += '<input type="text" class="form-control form-control-sm" value="' + escapeHtml(componentName) + '" disabled>';
    html += '</div>';

    html += '<div class="mb-3">';
    html += '<label class="form-label small fw-bold">Tag</label>';
    html += '<input type="text" class="form-control form-control-sm" value="' + escapeHtml(tagName) + '" disabled>';
    html += '</div>';

    if (baseClasses.length) {
      html += '<div class="mb-3">';
      html += '<label class="form-label small fw-bold">Classes obrigatórias</label>';
      html += '<input type="text" class="form-control form-control-sm" value="' + escapeHtml(baseClasses.join(' ')) + '" disabled>';
      html += '</div>';
    }

    html += renderApiProperties(raw, component);

    $(selectors.rightContent).html(html);

    bindRightPanelAutoSync();

  }

  function renderApiPropertyField(fieldKey, field, inputName, defaultValue, raw = null, component = null) {

    let html = '';

    html += '<div class="mb-3">';
    html += '<label class="form-label small fw-bold">' + escapeHtml(field.label || fieldKey) + '</label>';

    if (field.field === 'select' || field.field === 'radio-buttons') {

      let choices = field.choices || {};

      if (isShortcodeRaw(raw) && fieldKey === 'shortcode') {
        choices = getShortcodeChoices(raw);
      }

      html += '<select class="form-select form-select-sm automator-editor-api-property automator-editor-field-' + escapeHtml(field.field) + '" data-field-key="' + escapeHtml(fieldKey) + '" data-field-type="' + escapeHtml(field.field) + '" data-property-name="' + escapeHtml(inputName) + '">';

      html += '<option value="">Selecione</option>';

      $.each(choices || {}, function (choiceKey, choiceLabel) {

        const optionStyle = getOptionPreviewStyle(inputName, choiceKey);

        html += '<option value="' + escapeHtml(choiceKey) + '"' + (String(choiceKey) === String(defaultValue) ? ' selected' : '') + (optionStyle ? ' style="' + escapeHtml(optionStyle) + '"' : '') + '>';
        html += escapeHtml(choiceLabel);
        html += '</option>';

      });

      html += '</select>';

    } else if (field.field === 'editor-css') {

      html += '<div class="automator-editor-api-property-editor">';
      html += '<div class="automator-editor-api-property-editor-count" id="' + escapeHtml(inputName) + '-count">1</div>';
      html += '<textarea class="form-control form-control-sm automator-editor-api-property" rows="4" data-field-key="' + escapeHtml(fieldKey) + '" data-field-type="' + escapeHtml(field.field) + '" data-property-name="' + escapeHtml(inputName) + '" wrap="off">' + escapeHtml(defaultValue) + '</textarea>';
      html += '</div>';

    } else if (field.field === 'textarea') {

      html += '<textarea class="form-control form-control-sm automator-editor-api-property" rows="4" data-field-key="' + escapeHtml(fieldKey) + '" data-field-type="' + escapeHtml(field.field) + '" data-property-name="' + escapeHtml(inputName) + '">' + escapeHtml(defaultValue) + '</textarea>';

    } else if (field.field === 'range') {

      const min = field.minval || field.min || 1;
      const max = field.maxval || field.max || 12;

      html += '<div class="d-flex align-items-center gap-2">';
      html += '<input type="range" class="form-range automator-editor-api-property flex-grow-1" min="' + escapeHtml(min) + '" max="' + escapeHtml(max) + '" value="' + escapeHtml(defaultValue || min) + '" data-field-key="' + escapeHtml(fieldKey) + '" data-field-type="' + escapeHtml(field.field) + '" data-property-name="' + escapeHtml(inputName) + '">';
      html += '<input type="number" class="form-control form-control-sm automator-editor-api-property-number" style="width:70px;" min="' + escapeHtml(min) + '" max="' + escapeHtml(max) + '" value="' + escapeHtml(defaultValue || min) + '" data-field-key="' + escapeHtml(fieldKey) + '" data-field-type="' + escapeHtml(field.field) + '" data-property-name="' + escapeHtml(inputName) + '">';
      html += '</div>';

    } else if (isColorField(fieldKey, field)) {

      html += '<input type="color" class="form-control form-control-color automator-editor-api-property" value="' + escapeHtml(normalizeColorValue(defaultValue)) + '" data-field-key="' + escapeHtml(fieldKey) + '" data-field-type="' + escapeHtml(field.field || 'color') + '" data-property-name="' + escapeHtml(inputName) + '">';

    } else {

      html += '<input type="text" class="form-control form-control-sm automator-editor-api-property" data-field-key="' + escapeHtml(fieldKey) + '" data-field-type="' + escapeHtml(field.field || 'text') + '" data-property-name="' + escapeHtml(inputName) + '" value="' + escapeHtml(defaultValue) + '">';

    }

    html += '</div>';

    return html;

  }

  function isShortcodeRaw(raw) {

    const type = String(getValue(raw, 'type') || '').toLowerCase();

    return type === 'shortcode';

  }

  function getShortcodeDefinitions(raw) {

    if (!raw) {
      return {};
    }

    if (raw.shortcodes && typeof raw.shortcodes === 'object') {
      return normalizeShortcodeDefinitions(raw.shortcodes);
    }

    if (
      raw.vars &&
      raw.vars.shortcode &&
      raw.vars.shortcode.items &&
      typeof raw.vars.shortcode.items === 'object'
    ) {
      return normalizeShortcodeDefinitions(raw.vars.shortcode.items);
    }

    if (
      raw.vars &&
      raw.vars.shortcode &&
      raw.vars.shortcode.choices &&
      typeof raw.vars.shortcode.choices === 'object'
    ) {
      return normalizeShortcodeDefinitions(raw.vars.shortcode.choices);
    }

    if (raw.existe && typeof raw.existe === 'object') {
      return normalizeShortcodeDefinitions(raw.existe);
    }

    return {};

  }

  function normalizeShortcodeDefinitions(items) {

    const definitions = {};

    if ($.isArray(items)) {

      items.forEach(function (item) {

        if (!item) {
          return;
        }

        const code =
          item.tbl_sys_shortcode_code ||
          item.code ||
          item.value ||
          '';

        if (!code) {
          return;
        }

        definitions[code] = {
          code: code,
          title: item.tbl_sys_shortcode_title || item.title || item.label || code,
          description: item.tbl_sys_shortcode_description || item.description || '',
          params: normalizeShortcodeParams(
            item.tbl_sys_shortcode_params ||
            item.params ||
            {}
          )
        };

      });

      return definitions;

    }

    $.each(items || {}, function (key, item) {

      if (typeof item === 'string') {

        definitions[key] = {
          code: key,
          title: item,
          description: '',
          params: {}
        };

        return;

      }

      if (!item || typeof item !== 'object') {
        return;
      }

      const code =
        item.tbl_sys_shortcode_code ||
        item.code ||
        item.value ||
        key;

      definitions[code] = {
        code: code,
        title: item.tbl_sys_shortcode_title || item.title || item.label || code,
        description: item.tbl_sys_shortcode_description || item.description || '',
        params: normalizeShortcodeParams(
          item.tbl_sys_shortcode_params ||
          item.params ||
          {}
        )
      };

    });

    return definitions;

  }

  function normalizeShortcodeParams(params) {

    if (!params) {
      return {};
    }

    if (typeof params === 'string') {

      try {
        params = JSON.parse(params);
      } catch (e) {
        return {};
      }

    }

    const normalized = {};

    $.each(params || {}, function (paramKey, paramConfig) {

      if (paramConfig === true || paramConfig === false) {

        normalized[paramKey] = {
          label: paramKey,
          field: 'text',
          default: '',
          required: paramConfig === true,
          choices: {}
        };

        return;

      }

      if (typeof paramConfig === 'string') {

        normalized[paramKey] = {
          label: paramConfig,
          field: 'text',
          default: '',
          required: false,
          choices: {}
        };

        return;

      }

      normalized[paramKey] = {
        label: paramConfig.label || paramConfig.name || paramKey,
        field: normalizeShortcodeParamFieldType(paramConfig.field || paramConfig.type || 'text'),
        default: paramConfig.default || '',
        required: paramConfig.required === true || paramConfig.nullable === false,
        choices: paramConfig.choices || paramConfig.values || {}
      };

    });

    return normalized;

  }

  function normalizeShortcodeParamFieldType(type) {

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

    if (type === 'select') {
      return 'select';
    }

    if (type === 'textarea') {
      return 'textarea';
    }

    if (type === 'editor-css') {
      return 'editor-css';
    }

    if (type === 'color' || type === 'color-picker') {
      return 'color-picker';
    }

    return type;

  }

  function getShortcodeChoices(raw) {

    const definitions = getShortcodeDefinitions(raw);
    const choices = {};

    $.each(definitions, function (code, item) {
      choices[code] = item.title || code;
    });

    return choices;

  }

  function getSelectedShortcodeDefinition(raw, component) {

    const values = getComponentStoredValues(component);

    const selected =
      values.shortcode ||
      values['config.shortcode'] ||
      '';

    if (!selected) {
      return null;
    }

    const definitions = getShortcodeDefinitions(raw);

    return definitions[selected] || null;

  }

  function renderShortcodeDynamicProperties(raw, component) {

    const selected = getSelectedShortcodeDefinition(raw, component);
    const componentCid = component.cid;
    const collapseId = 'automator-editor-settings-' + componentCid + '-shortcode-params';

    let html = '';

    html += '<div class="accordion-item border-start-0 border-end-0 rounded-0">';
    html += '<h2 class="accordion-header">';
    html += '<button class="accordion-button py-2 px-3 small fw-bold rounded-0" type="button" data-bs-toggle="collapse" data-bs-target="#' + escapeHtml(collapseId) + '">';
    html += 'Parâmetros do Shortcode';
    html += '</button>';
    html += '</h2>';

    html += '<div id="' + escapeHtml(collapseId) + '" class="accordion-collapse collapse show">';
    html += '<div class="accordion-body px-3 py-2">';

    if (!selected) {

      html += '<div class="text-muted small">Selecione um shortcode para carregar os parâmetros.</div>';

    } else {

      if (selected.description) {
        html += '<div class="alert alert-light border small mb-3">' + escapeHtml(selected.description) + '</div>';
      }

      const params = selected.params || {};
      const keys = Object.keys(params);

      if (!keys.length) {
        html += '<div class="text-muted small">Este shortcode não possui parâmetros configuráveis.</div>';
      }

      keys.forEach(function (paramKey) {

        const param = params[paramKey];
        const inputName = 'shortcode_params.' + paramKey;
        const defaultValue = getStoredPropertyValue(component, inputName, param.default || '');

        html += renderApiPropertyField(paramKey, param, inputName, defaultValue, raw, component);

      });

    }

    html += '</div>';
    html += '</div>';
    html += '</div>';

    return html;

  }

  function bindCssEditors() {

    $('.automator-editor-api-property[data-field-type="editor-css"]').each(function () {

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

  function isEditingCssProperty() {

    const active = document.activeElement;

    return !!(
      active &&
      active.matches &&
      active.matches('.automator-editor-api-property[data-field-type="editor-css"]')
    );

  }

  function isEditingPropertiesPanel() {

    const active = document.activeElement;

    if (!active) {
      return false;
    }

    return $(active).closest(selectors.rightAside).length > 0;

  }

  function getOptionPreviewStyle(propertyName, choiceKey) {

    const cleanProperty = String(propertyName || '').toLowerCase();
    const cleanChoice = String(choiceKey || '').toLowerCase();

    if (
      cleanProperty === 'tipograph.type' ||
      cleanProperty === 'typograph.type' ||
      cleanProperty === 'typography.type' ||
      cleanProperty.indexOf('tipograph') !== -1
    ) {

      const map = {
        h1: 'font-size: 2rem; font-weight: 700;',
        h2: 'font-size: 1.75rem; font-weight: 700;',
        h3: 'font-size: 1.5rem; font-weight: 700;',
        h4: 'font-size: 1.25rem; font-weight: 700;',
        h5: 'font-size: 1rem; font-weight: 700;',
        h6: 'font-size: .875rem; font-weight: 700;'
      };

      return map[cleanChoice] || '';

    }

    return '';

  }

  function bindRightPanelAutoSync() {

    $('.automator-editor-api-property').off('.automator-editor-sync');

    $('.automator-editor-api-property').on('input.automator-editor-sync change.automator-editor-sync', function () {

      const input = $(this);
      const propertyName = input.attr('data-property-name');
      const value = input.val();

      $('.automator-editor-api-property-number[data-property-name="' + propertyName + '"]').val(value);

      syncSelectedComponentProperty(propertyName, value);

    });

    $('.automator-editor-api-property-number').off('.automator-editor-sync');

    $('.automator-editor-api-property-number').on('input.automator-editor-sync change.automator-editor-sync', function () {

      const input = $(this);
      const propertyName = input.attr('data-property-name');
      const value = input.val();

      $('.automator-editor-api-property[data-property-name="' + propertyName + '"]').val(value);

      syncSelectedComponentProperty(propertyName, value);

    });

    bindCssEditors();

  }

  function renderApiProperties(raw, component) {

    if (!raw || !raw.properties) {
      return '<div class="text-muted small px-3 py-2">Este bloco não possui configurações adicionais.</div>';
    }

    const componentCid = component.cid;
    let html = '';

    html += '<div class="accordion automator-editor-settings-accordion mx-0" id="automator-editor-settings-accordion-' + escapeHtml(componentCid) + '">';

    $.each(raw.properties, function (groupKey, group) {

      const collapseId = 'automator-editor-settings-' + componentCid + '-' + groupKey;

      html += '<div class="accordion-item border-start-0 border-end-0 rounded-0">';
      html += '<h2 class="accordion-header">';
      html += '<button class="accordion-button collapsed py-2 px-3 small fw-bold rounded-0" type="button" data-bs-toggle="collapse" data-bs-target="#' + escapeHtml(collapseId) + '">';
      html += escapeHtml(group.label || groupKey);
      html += '</button>';
      html += '</h2>';

      html += '<div id="' + escapeHtml(collapseId) + '" class="accordion-collapse collapse">';
      html += '<div class="accordion-body px-3 py-2">';

      $.each(group.fields || {}, function (fieldKey, field) {

        const inputName = groupKey + '.' + fieldKey;
        const defaultValue = getStoredPropertyValue(component, inputName, field.default || '');

        html += renderApiPropertyField(fieldKey, field, inputName, defaultValue, raw, component);

      });

      html += '</div>';
      html += '</div>';
      html += '</div>';

      if (isShortcodeRaw(raw) && groupKey === 'config') {
        html += renderShortcodeDynamicProperties(raw, component);
      }

    });

    html += '</div>';

    return html;

  }

  function syncSelectedComponentProperty(propertyName, value) {

    if (!grapesEditor) {
      return;
    }

    const component = grapesEditor.getSelected();

    if (!component) {
      return;
    }

    const attributes = component.getAttributes() || {};
    attributes['data-automator-property-' + propertyName] = value;
    component.setAttributes(attributes);

    if (isShortcodeComponent(component)) {

      if (propertyName === 'config.shortcode') {

        clearShortcodeDynamicParams(component);
        syncShortcodeComponent(component);

        setTimeout(function () {
          renderComponentSettings(component);
        }, 0);

      } else {

        syncShortcodeComponent(component);

      }

    }

    if (isTagProperty(propertyName, component)) {
      syncComponentTag(component, value, propertyName);
      return;
    }

    if (isColumnSizeProperty(propertyName, component)) {
      syncBootstrapColumnClass(component, value, propertyName);
      return;
    }

    if (propertyName === 'advanced.style') {
      component.setStyle(value || '');
    }

    if (propertyName === 'advanced.class') {
      syncAdvancedClasses(component, value);
    }

    if (propertyName === 'advanced.id' || propertyName.endsWith('.id')) {
      syncComponentId(component, value);
    }

    if (isColorProperty(propertyName)) {
      syncColorProperty(component, propertyName, value);
    }

    if (propertyName === 'fluid.type') {
      syncBootstrapContainerClass(component, value);
    }

    if (propertyName === 'margin.margin') {
      syncBootstrapMarginClass(component, value);
    }

    state.hasChanges = true;
    setSaveState(true);
    updateStructureList();

  }

  function clearShortcodeDynamicParams(component) {

    if (!component || !component.getAttributes) {
      return;
    }

    const attrs = component.getAttributes() || {};

    $.each(attrs, function (key) {

      if (key.indexOf('data-automator-property-shortcode_params.') === 0) {
        delete attrs[key];
      }

    });

    component.setAttributes(attrs);

  }

  function isShortcodeComponent(component) {

    if (!component || !component.getAttributes) {
      return false;
    }

    const attrs = component.getAttributes();
    const typeName = String(attrs['data-automator-field-type-name'] || '').toLowerCase();

    return (
      attrs['data-automator-shortcode-component'] === 'true' ||
      typeName === 'pagination' ||
      typeName === 'shortcode'
    );

  }

  function syncShortcodeComponent(component) {

    if (!component || !component.getAttributes) {
      return;
    }

    const attrs = component.getAttributes();
    const fieldTypeID = attrs['data-automator-field-type-id'] || '';
    const componentData = getComponent(fieldTypeID);

    if (!componentData || !componentData.raw) {
      return;
    }

    const values = getComponentStoredValues(component);
    const previewText = getShortcodePreviewText(componentData.raw, values);

    component.components([
      {
        tagName: 'div',
        name: 'Pré-visualização',
        classes: ['automator-editor-shortcode-preview'],
        attributes: {
          'data-automator-shortcode-preview': 'true'
        },
        draggable: false,
        droppable: false,
        editable: false,
        selectable: false,
        hoverable: false,
        highlightable: false,
        copyable: false,
        removable: false,
        content: previewText
      }
    ]);

  }

  function getDefaultShortcodeValues(field) {

    const values = {};

    if (!field || !field.properties) {
      return values;
    }

    $.each(field.properties, function (groupKey, group) {

      $.each(group.fields || {}, function (fieldKey, fieldConfig) {

        const inputName = groupKey + '.' + fieldKey;
        const defaultValue = fieldConfig.default || '';

        values[inputName] = defaultValue;
        values[fieldKey] = defaultValue;

      });

    });

    return values;

  }

  function getShortcodePreviewText(field, values = {}) {

    if (!field) {
      return 'Selecionar item';
    }

    const type = String(getValue(field, 'type') || '').toLowerCase();

    if (type === 'pagination') {

      const selectedValue =
        values.pagination ||
        values['config.pagination'] ||
        '';

      if (!selectedValue) {
        return 'Selecionar paginação';
      }

      return getPropertyChoiceLabel(field, 'config.pagination', selectedValue) || selectedValue;

    }

    if (type === 'shortcode') {

      const shortcode =
        values.shortcode ||
        values['config.shortcode'] ||
        '';

      if (!shortcode) {
        return 'Selecionar shortcode';
      }

      const definitions = getShortcodeDefinitions(field);
      const selected = definitions[shortcode];

      return selected
        ? selected.title + ' [' + shortcode + ']'
        : '[' + shortcode + ']';

    }

    return getValue(field, 'title') || 'Componente do sistema';

  }

  function getPropertyChoiceLabel(field, propertyName, value) {

    if (!field || !field.properties) {
      return '';
    }

    const parts = String(propertyName || '').split('.');
    const groupKey = parts[0] || '';
    const fieldKey = parts[1] || '';

    const group = field.properties[groupKey];

    if (!group || !group.fields || !group.fields[fieldKey]) {
      return '';
    }

    const choices = group.fields[fieldKey].choices || {};

    return choices[value] || '';

  }

  function getShortcodeFinalHtml(component) {

    if (!component || !component.getAttributes) {
      return '';
    }

    const attrs = component.getAttributes();
    const fieldTypeID = attrs['data-automator-field-type-id'] || '';
    const componentData = getComponent(fieldTypeID);

    if (!componentData || !componentData.raw) {
      return '';
    }

    const values = getComponentStoredValues(component);

    return buildShortcodeLikeHtml(componentData.raw, values);

  }

  function getComponentStoredValues(component) {

    const values = {};
    const attrs = component.getAttributes ? component.getAttributes() : {};

    $.each(attrs, function (key, value) {

      if (key.indexOf('data-automator-property-') !== 0) {
        return;
      }

      const propertyName = key.replace('data-automator-property-', '');
      const parts = propertyName.split('.');
      const lastKey = parts[parts.length - 1];

      values[propertyName] = value;
      values[lastKey] = value;

    });

    return values;

  }

  function isTagProperty(propertyName, component = null) {

    const clean = String(propertyName || '').toLowerCase();

    const attrs = component && component.getAttributes
      ? component.getAttributes()
      : {};

    const typeName = String(attrs['data-automator-field-type-name'] || '').toLowerCase();
    const title = String(attrs['data-automator-field-type-title'] || '').toLowerCase();

    const isTitleComponent =
      typeName === 'title' ||
      typeName === 'titulo' ||
      title.indexOf('título') !== -1 ||
      title.indexOf('titulo') !== -1 ||
      title.indexOf('title') !== -1;

    const isTagField =
      clean === 'tag.tag' ||
      clean === 'title.tag' ||
      clean === 'heading.tag' ||
      clean === 'text.tag' ||
      clean === 'type.tag' ||
      clean === 'tag' ||
      clean === 'tipograph.type' ||
      clean === 'typograph.type' ||
      clean === 'typography.type' ||
      clean.indexOf('tipograph') !== -1 ||
      clean.endsWith('.tag');

    return isTitleComponent && isTagField;

  }

  function syncComponentTag(component, newTag, propertyName = '') {

    newTag = String(newTag || '').replace('<', '').replace('>', '').toLowerCase();

    const allowedTags = ['h1', 'h2', 'h3', 'h4', 'h5', 'h6'];

    if (allowedTags.indexOf(newTag) === -1) {
      return;
    }

    const attrs = component.getAttributes ? component.getAttributes() : {};
    attrs['data-automator-property-' + propertyName] = newTag;

    const currentTag = component.get('tagName') || '';

    if (currentTag === newTag) {
      component.setAttributes(attrs);
      state.hasChanges = true;
      setSaveState(true);
      updateStructureList();
      return;
    }

    const parent = component.parent();
    const index = parent && parent.components
      ? parent.components().indexOf(component)
      : -1;

    const content = component.getInnerHTML ? component.getInnerHTML() : '';
    const classes = component.getClasses ? component.getClasses() : [];
    const style = component.getStyle ? component.getStyle() : {};
    const name = component.get('name') || attrs['data-automator-field-type-title'] || 'Titulo';

    const newComponentConfig = {
      type: 'text',
      name: name,
      tagName: newTag,
      classes: classes,
      attributes: attrs,
      style: style,
      draggable: true,
      droppable: false,
      editable: true,
      selectable: true,
      hoverable: true,
      highlightable: true,
      copyable: true,
      removable: true,
      components: [
        {
          type: 'textnode',
          content: content || 'Novo título',
          draggable: false,
          droppable: false,
          selectable: false,
          editable: true,
          removable: false,
          copyable: false
        }
      ]
    };

    let added = null;

    if (parent && parent.components && index >= 0) {
      added = parent.components().add(newComponentConfig, {
        at: index
      });

      component.remove();
    } else {
      added = grapesEditor.addComponents(newComponentConfig);
      component.remove();
    }

    selectAddedComponent(added);

    state.hasChanges = true;
    setSaveState(true);
    updateStructureList();

  }

  function isColumnSizeProperty(propertyName, component = null) {

    const clean = String(propertyName || '').toLowerCase();

    const attrs = component && component.getAttributes
      ? component.getAttributes()
      : {};

    const typeName = String(attrs['data-automator-field-type-name'] || '').toLowerCase();
    const title = String(attrs['data-automator-field-type-title'] || '').toLowerCase();

    const isColumnComponent =
      typeName === 'col' ||
      typeName === 'column' ||
      typeName.indexOf('col') !== -1 ||
      title.indexOf('coluna') !== -1 ||
      title.indexOf('column') !== -1;

    const isSizeField =
      clean === 'xs.size' ||
      clean === 'sm.size' ||
      clean === 'md.size' ||
      clean === 'lg.size' ||
      clean === 'xl.size' ||
      clean === 'xxl.size' ||
      clean === 'size.column' ||
      clean === 'size.column-xs' ||
      clean === 'size.column-sm' ||
      clean === 'size.column-md' ||
      clean === 'size.column-lg' ||
      clean === 'size.column-xl' ||
      clean === 'size.column-xxl' ||
      clean.indexOf('column-') !== -1 ||
      clean.endsWith('.size');

    return isColumnComponent && isSizeField;

  }

  function syncBootstrapColumnClass(component, value, propertyName = '') {

    value = parseInt(value, 10);

    if (!value || value < 1) {
      value = 1;
    }

    if (value > 12) {
      value = 12;
    }

    const breakpoint = getColumnBreakpointFromProperty(propertyName);
    const newClass = breakpoint ? 'col-' + breakpoint + '-' + value : 'col-' + value;

    const attrs = component.getAttributes ? component.getAttributes() : {};
    const baseClasses = getBaseClassesFromComponent(component).filter(function (className) {
      return !isBootstrapColumnSizeClass(className);
    });

    let classes = component.getClasses ? component.getClasses() : [];

    classes = classes.filter(function (className) {

      if (isReservedEditorClass(className)) {
        return false;
      }

      if (baseClasses.indexOf(className) !== -1) {
        return false;
      }

      if (breakpoint === '' && /^col-\d{1,2}$/.test(className)) {
        return false;
      }

      if (breakpoint !== '' && new RegExp('^col-' + breakpoint + '-\\d{1,2}$').test(className)) {
        return false;
      }

      return true;

    });

    const finalClasses = ensureEditorInternalClasses(
      baseClasses
        .concat(classes)
        .concat([newClass])
    );

    component.setClass(finalClasses);

    attrs.class = finalClasses.join(' ');
    attrs['data-automator-base-classes'] = baseClasses.join(' ');
    attrs['data-automator-property-' + propertyName] = String(value);
    attrs['data-automator-column-class-' + (breakpoint || 'xs')] = newClass;

    component.setAttributes(attrs);

    forceRenderComponentClass(component, finalClasses);

    if (component.view && typeof component.view.render === 'function') {
      component.view.render();
    }

    state.hasChanges = true;
    setSaveState(true);
    updateStructureList();

  }

  function isBootstrapColumnSizeClass(className) {

    return (
      /^col-\d{1,2}$/.test(className) ||
      /^col-(sm|md|lg|xl|xxl)-\d{1,2}$/.test(className)
    );

  }

  function forceRenderComponentClass(component, classes) {

    if (!component) {
      return;
    }

    const finalClasses = ensureEditorInternalClasses(classes);
    const classString = finalClasses.join(' ');

    const attrs = component.getAttributes ? component.getAttributes() : {};
    attrs.class = classString;
    component.setAttributes(attrs);

    if (component.view && component.view.el) {
      component.view.el.setAttribute('class', classString);
    }

    const viewEl = component.getEl ? component.getEl() : null;

    if (viewEl) {
      viewEl.setAttribute('class', classString);
    }

  }

  function isColumnField(field, item = null, fallbackTitle = '') {

    const type = String(getValue(field, 'type') || '').toLowerCase();
    const title = String(getValue(field, 'title') || fallbackTitle || '').toLowerCase();
    const itemType = item ? String(item.attr('data-block-type') || '').toLowerCase() : '';

    return (
      type === 'col' ||
      type === 'column' ||
      type.indexOf('col') !== -1 ||
      itemType === 'col' ||
      itemType.indexOf('col') !== -1 ||
      title.indexOf('coluna') !== -1 ||
      title.indexOf('column') !== -1
    );

  }

  function getDefaultBootstrapColumnClasses(field) {

    const classes = [];
    const properties = field && field.properties ? field.properties : {};

    $.each(properties, function (groupKey, group) {

      const cleanGroup = String(groupKey || '').toLowerCase();

      if (
        cleanGroup !== 'xs' &&
        cleanGroup !== 'sm' &&
        cleanGroup !== 'md' &&
        cleanGroup !== 'lg' &&
        cleanGroup !== 'xl' &&
        cleanGroup !== 'xxl'
      ) {
        return;
      }

      const fields = group.fields || {};

      $.each(fields, function (fieldKey, fieldConfig) {

        const cleanField = String(fieldKey || '').toLowerCase();

        if (cleanField !== 'size') {
          return;
        }

        let value = parseInt(fieldConfig.default || 12, 10);

        if (!value || value < 1) {
          value = 1;
        }

        if (value > 12) {
          value = 12;
        }

        if (cleanGroup === 'xs') {
          classes.push('col-' + value);
        } else {
          classes.push('col-' + cleanGroup + '-' + value);
        }

      });

    });

    return classes;

  }

  function getColumnBreakpointFromProperty(propertyName) {

    const clean = String(propertyName || '').toLowerCase();

    if (clean.indexOf('column-xxl') !== -1 || clean.startsWith('xxl.')) {
      return 'xxl';
    }

    if (clean.indexOf('column-xl') !== -1 || clean.startsWith('xl.')) {
      return 'xl';
    }

    if (clean.indexOf('column-lg') !== -1 || clean.startsWith('lg.')) {
      return 'lg';
    }

    if (clean.indexOf('column-md') !== -1 || clean.startsWith('md.')) {
      return 'md';
    }

    if (clean.indexOf('column-sm') !== -1 || clean.startsWith('sm.')) {
      return 'sm';
    }

    if (clean.indexOf('column-xs') !== -1 || clean.startsWith('xs.')) {
      return '';
    }

    return '';

  }

  function isColorField(fieldKey, field) {

    const key = String(fieldKey || '').toLowerCase();
    const label = String(field.label || '').toLowerCase();
    const type = String(field.field || '').toLowerCase();

    return (
      type === 'color' ||
      type === 'color-picker' ||
      key.indexOf('color') !== -1 ||
      key.indexOf('colour') !== -1 ||
      key.indexOf('background') !== -1 ||
      key.indexOf('bg') !== -1 ||
      key.indexOf('border_color') !== -1 ||
      label.indexOf('cor') !== -1 ||
      label.indexOf('color') !== -1 ||
      label.indexOf('fundo') !== -1 ||
      label.indexOf('background') !== -1
    );

  }

  function syncAdvancedClasses(component, value) {

    const baseClasses = getBaseClassesFromComponent(component).filter(function (className) {
      return !isBootstrapColumnSizeClass(className);
    });

    const currentClasses = component.getClasses ? component.getClasses() : [];

    const protectedColumnClasses = currentClasses.filter(function (className) {
      return isBootstrapColumnSizeClass(className);
    });

    const advancedClasses = sanitizeEditorClasses(
      String(value || '').split(/\s+/)
    );

    component.setClass(
      ensureEditorInternalClasses(
        baseClasses
          .concat(protectedColumnClasses)
          .concat(advancedClasses)
      )
    );

  }

  function syncComponentId(component, value) {

    const attributes = component.getAttributes() || {};

    if (value) {
      attributes.id = value;
    } else {
      delete attributes.id;
    }

    component.setAttributes(attributes);

  }

  function isColorProperty(propertyName) {

    const clean = String(propertyName || '').toLowerCase();

    return (
      clean.indexOf('color') !== -1 ||
      clean.indexOf('colour') !== -1 ||
      clean.indexOf('background') !== -1 ||
      clean.indexOf('.bg') !== -1 ||
      clean.indexOf('bg.') !== -1 ||
      clean.indexOf('fundo') !== -1 ||
      clean.indexOf('cor') !== -1
    );

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

  function syncColorProperty(component, propertyName, value) {

    const clean = String(propertyName || '').toLowerCase();
    const style = component.getStyle ? component.getStyle() : {};

    if (clean.indexOf('background') !== -1 || clean.indexOf('fundo') !== -1 || clean.indexOf('.bg') !== -1 || clean.indexOf('bg.') !== -1) {
      style['background-color'] = value;
    } else if (clean.indexOf('border') !== -1) {
      style['border-color'] = value;
    } else {
      style['color'] = value;
    }

    component.setStyle(style);

  }

  function syncBootstrapContainerClass(component, value) {

    let classes = component.getClasses ? component.getClasses() : [];
    const baseClasses = getBaseClassesFromComponent(component);

    classes = classes.filter(function (className) {
      return className !== 'container' && className !== 'container-fluid';
    });

    if (value) {
      classes.push(value);
    }

    component.setClass(uniqueArray(baseClasses.concat(classes)));

  }

  function syncBootstrapMarginClass(component, value) {

    let classes = component.getClasses ? component.getClasses() : [];
    const baseClasses = getBaseClassesFromComponent(component);

    classes = classes.filter(function (className) {
      return !/^m[trblxyse]?-[0-5]$/.test(className);
    });

    if (value) {
      classes.push(value);
    }

    component.setClass(uniqueArray(baseClasses.concat(classes)));

  }

  function applySelectedComponentSettings() {

    state.hasChanges = true;

    setSaveState(true);
    updateStructureList();

  }
  // function applySelectedComponentSettings() {

  //   if (!grapesEditor) {
  //     return;
  //   }

  //   const component = grapesEditor.getSelected();

  //   if (!component) {
  //     return;
  //   }

  //   const baseClasses = getBaseClassesFromComponent(component);
  //   const additionalClasses = ($('#automator-editor-component-classes').val() || '').split(' ').filter(Boolean);
  //   const id = $('#automator-editor-component-id').val() || '';

  //   component.setClass(uniqueArray(baseClasses.concat(additionalClasses).concat(['automator-editor-component'])));

  //   const attributes = component.getAttributes() || {};

  //   if (id) {
  //     attributes.id = id;
  //   } else {
  //     delete attributes.id;
  //   }

  //   $('.automator-editor-api-property').each(function () {

  //     const input = $(this);
  //     const propertyName = input.attr('data-property-name');
  //     const value = input.val();

  //     attributes['data-automator-property-' + propertyName] = value;

  //     if (propertyName === 'advanced.style') {
  //       component.setStyle(value || '');
  //     }

  //     if (propertyName === 'advanced.class') {
  //       const extra = String(value || '').split(' ').filter(Boolean);
  //       component.setClass(uniqueArray(baseClasses.concat(additionalClasses).concat(extra).concat(['automator-editor-component'])));
  //     }

  //   });

  //   component.setAttributes(attributes);

  //   state.hasChanges = true;
  //   setSaveState(true);
  //   updateStructureList();

  // }

  // function getStoredPropertyValue(component, propertyName, defaultValue) {

  //   const attrs = component.getAttributes ? component.getAttributes() : {};
  //   const key = 'data-automator-property-' + propertyName;

  //   if (typeof attrs[key] !== 'undefined') {
  //     return attrs[key];
  //   }

  //   return defaultValue;

  // }

  function getStoredPropertyValue(component, propertyName, defaultValue) {

    const attrs = component.getAttributes ? component.getAttributes() : {};
    const key = 'data-automator-property-' + propertyName;

    if (typeof attrs[key] !== 'undefined') {
      return attrs[key];
    }

    if (propertyName === 'advanced.id' && attrs.id) {
      return attrs.id;
    }

    if (propertyName === 'advanced.class') {
      return getAdditionalClassesFromComponent(component).join(' ');
    }

    if (propertyName === 'advanced.style') {
      const style = component.getStyle ? component.getStyle() : {};
      return Object.entries(style).map(function (item) {
        return item[0] + ':' + item[1];
      }).join(';');
    }

    return defaultValue;

  }

  function getBaseClassesFromComponent(component) {

    const attributes = component.getAttributes ? component.getAttributes() : {};
    const base = attributes['data-automator-base-classes'] || '';

    return String(base).split(' ').filter(Boolean);

  }

  function getAdditionalClassesFromComponent(component) {

    const baseClasses = getBaseClassesFromComponent(component);
    const classes = component.getClasses ? component.getClasses() : [];

    return classes.filter(function (className) {
      return (
        baseClasses.indexOf(className) === -1 &&
        !isReservedEditorClass(className) &&
        !isBootstrapColumnSizeClass(className)
      );
    });

  }

  function getAutomatorTag(field) {

    const tag = getValue(field, 'tag') || getConfigValue(field, 'tag') || 'div';

    if ($.isArray(tag)) {
      return tag[0] || 'div';
    }

    return String(tag).replace('<', '').replace('>', '') || 'div';

  }

  function getAutomatorClasses(field) {

    const classes =
      getValue(field, 'class') ||
      getConfigValue(field, 'class') ||
      '';

    if ($.isArray(classes)) {
      return classes;
    }

    return String(classes).split(' ').filter(Boolean);

  }

  function canAutomatorHaveChild(field) {

    return normalizeBoolean(getValue(field, 'can_have_child')) ||
      normalizeBoolean(getValue(field, 'has_child')) ||
      normalizeBoolean(getConfigValue(field, 'can_have_child')) ||
      normalizeBoolean(getConfigValue(field, 'has_child'));

  }

  function canAutomatorBeEdited(field) {

    if (canAutomatorHaveChild(field)) {
      return false;
    }

    const tag = getAutomatorTag(field);

    if (tag === 'img' || tag === 'hr' || tag === 'br' || tag === 'input') {
      return false;
    }

    return true;

  }

  function getDefaultContent(field, fallbackTitle) {

    let content =
      getValue(field, 'content') ||
      getConfigValue(field, 'content') ||
      getValue(field, 'default') ||
      getConfigValue(field, 'default') ||
      '';

    if (content) {
      return content;
    }

    const tag = getAutomatorTag(field);
    const type = String(getValue(field, 'type') || '').toLowerCase();

    if (tag === 'p' || type === 'paragraph' || type === 'paragrafo') {
      return 'Digite seu texto aqui.';
    }

    if (tag === 'h1') {
      return 'Título principal';
    }

    if (tag === 'h2') {
      return 'Novo título';
    }

    if (tag === 'h3') {
      return 'Subtítulo';
    }

    if (tag === 'a') {
      return 'Clique aqui';
    }

    if (tag === 'button') {
      return 'Botão';
    }

    return '';

  }

  function getDefaultImage(field) {

    return getValue(field, 'src') ||
      getConfigValue(field, 'src') ||
      'https://via.placeholder.com/900x400';

  }

  function getConfigValue(field, key) {

    const config = getAutomatorConfig(field);

    if (config && typeof config[key] !== 'undefined') {
      return config[key];
    }

    return null;

  }

  function getAutomatorConfig(field) {

    if (!field) {
      return {};
    }

    if (field.configs && typeof field.configs === 'object') {
      return field.configs.code || field.configs;
    }

    if (field.config && typeof field.config === 'object') {
      return field.config.code || field.config;
    }

    if (field.tbl_sys_field_type_configs) {
      return parseConfig(field.tbl_sys_field_type_configs);
    }

    if (field.configs && typeof field.configs === 'string') {
      return parseConfig(field.configs);
    }

    if (field.config && typeof field.config === 'string') {
      return parseConfig(field.config);
    }

    return {};

  }

  function parseConfig(config) {

    try {

      const parsed = typeof config === 'string'
        ? JSON.parse(config)
        : config;

      return parsed.code || parsed || {};

    } catch (e) {
      return {};
    }

  }

  function getValue(obj, key) {

    if (!obj || typeof obj !== 'object') {
      return null;
    }

    if (typeof obj[key] !== 'undefined' && obj[key] !== null && obj[key] !== '') {
      return obj[key];
    }

    return null;

  }

  function normalizeBoolean(value) {

    return value === true || value === 'true' || value === 1 || value === '1';

  }

  function selectAddedComponent(addedComponents) {

    if (!addedComponents) {
      return;
    }

    if (addedComponents.length && addedComponents[0]) {
      grapesEditor.select(addedComponents[0]);
      return;
    }

    grapesEditor.select(addedComponents);

  }

  function deleteSelectedComponent() {

    if (!grapesEditor) {
      return;
    }

    const component = grapesEditor.getSelected();

    if (!component) {
      return;
    }

    if (!confirm('Deseja realmente excluir este bloco?')) {
      return;
    }

    component.remove();

    $(selectors.rightContent).html('Selecione um bloco para editar.');

    state.hasChanges = true;
    setSaveState(true);
    updateStructureList();
    updateEmptyContainers();

  }

  function updateStructureList() {

    if (!grapesEditor) {
      return;
    }

    const wrapper = grapesEditor.DomComponents.getWrapper();

    if (!wrapper) {
      return;
    }

    const list = $(selectors.structureList);
    const emptyText = list.attr('data-empty') || 'Nenhum bloco adicionado.';

    list.empty();

    const components = wrapper.components();

    if (!components || components.length === 0) {
      list.html('<div class="text-muted text-center py-5 small">' + emptyText + '</div>');
      return;
    }

    const rootList = $('<div class="automator-editor-structure-children" data-parent-cid="root"></div>');
    list.append(rootList);

    renderStructureItems(components, rootList, 0);
    initStructureSortable();

  }

  function renderStructureItems(components, container, level) {

    components.each(function (component) {

      const attributes = component.getAttributes ? component.getAttributes() : {};

      if (attributes['data-automator-placeholder'] === 'true') {
        return;
      }

      const name =
        component.get('name') ||
        attributes['data-automator-field-type-title'] ||
        component.get('tagName') ||
        'Bloco';

      const cid = component.cid;
      const canHaveChild = attributes['data-automator-can-have-child'] === 'true';

      const wrapper = $('<div class="automator-editor-structure-item-wrapper" data-cid="' + escapeHtml(cid) + '"></div>');

      const item = $(`
        <div class="automator-editor-body-aside-left-structure-item d-flex align-items-center p-2 border-bottom" style="padding-left: ${(level * 20) + 10}px !important;">
          <i class="fas fa-grip-vertical automator-editor-structure-handle me-2 text-muted"></i>
          <i class="fa fa-cube me-2 small text-primary"></i>
          <span class="small flex-grow-1 text-truncate cursor-pointer">${escapeHtml(name)}</span>
          <button type="button" class="btn btn-xs btn-light">
            <i class="fas fa-mouse-pointer"></i>
          </button>
        </div>
      `);

      item.on('click', function () {
        grapesEditor.select(component);
      });

      wrapper.append(item);

      if (canHaveChild) {
        const childList = $('<div class="automator-editor-structure-children" data-parent-cid="' + escapeHtml(cid) + '"></div>');
        wrapper.append(childList);

        const children = component.components();

        if (children && children.length) {
          renderStructureItems(children, childList, level + 1);
        }
      }

      container.append(wrapper);

    });

  }

  function initStructureSortable() {

    if (typeof Sortable === 'undefined') {
      return;
    }

    $('.automator-editor-structure-children').each(function () {

      const el = this;

      if ($(el).data('sortable')) {
        return;
      }

      new Sortable(el, {
        group: 'automator-structure',
        animation: 150,
        handle: '.automator-editor-structure-handle',
        draggable: '> .automator-editor-structure-item-wrapper',

        onMove: function (evt) {
          return canMoveStructureItem(evt);
        },

        onEnd: function (evt) {

          if (!evt.to) {
            updateStructureList();
            return;
          }

          setTimeout(function () {
            syncStructureContainer(evt.to);
          }, 0);

        }
      });

      $(el).data('sortable', true);

    });

  }

  function syncStructureContainer(containerEl) {

    if (!grapesEditor || !containerEl) {
      return;
    }

    const parentCid = $(containerEl).attr('data-parent-cid');

    const parentComponent = parentCid === 'root'
      ? grapesEditor.DomComponents.getWrapper()
      : findComponentByCid(parentCid);

    if (!parentComponent || !parentComponent.components) {
      updateStructureList();
      return;
    }

    const orderedCids = [];

    $(containerEl)
      .children('.automator-editor-structure-item-wrapper')
      .each(function () {

        const cid = $(this).attr('data-cid');

        if (cid) {
          orderedCids.push(cid);
        }

      });

    if (!orderedCids.length) {
      updateStructureList();
      return;
    }

    for (let i = 0; i < orderedCids.length; i++) {

      const component = findComponentByCid(orderedCids[i]);

      if (!component) {
        continue;
      }

      if (!canMoveComponentToParent(component, parentComponent)) {
        updateStructureList();
        return;
      }

    }

    orderedCids.forEach(function (cid, index) {

      const component = findComponentByCid(cid);

      if (!component || !component.move) {
        return;
      }

      component.move(parentComponent, {
        at: index
      });

    });

    normalizeAllCardChildrenOrder();
    updateEmptyContainers();

    grapesEditor.trigger('component:update');
    grapesEditor.trigger('update');

    state.hasChanges = true;

    setSaveState(true);

    setTimeout(function () {
      updateStructureList();
    }, 50);

  }

  function getFirstAddedComponent(addedComponents) {

    if (!addedComponents) {
      return null;
    }

    if (addedComponents.length && addedComponents[0]) {
      return addedComponents[0];
    }

    return addedComponents;

  }

  function cloneComponentConfig(componentConfig) {

    return $.extend(true, {}, componentConfig);

  }

  function getComponentDataType(componentData) {

    if (!componentData) {
      return '';
    }

    return String(componentData.type || '').toLowerCase();

  }

  function getComponentTypeName(component) {

    if (!component || !component.getAttributes) {
      return '';
    }

    const attrs = component.getAttributes();

    return String(attrs['data-automator-field-type-name'] || '').toLowerCase();

  }

  function isCardType(typeName) {

    return String(typeName || '').toLowerCase() === 'card';

  }

  function isCardHeaderType(typeName) {

    return String(typeName || '').toLowerCase() === 'card-header';

  }

  function isCardBodyType(typeName) {

    return String(typeName || '').toLowerCase() === 'card-body';

  }

  function isCardFooterType(typeName) {

    return String(typeName || '').toLowerCase() === 'card-footer';

  }

  function isCardSectionType(typeName) {

    typeName = String(typeName || '').toLowerCase();

    return (
      isCardHeaderType(typeName) ||
      isCardBodyType(typeName) ||
      isCardFooterType(typeName)
    );

  }

  function isCardComponent(component) {

    return isCardType(getComponentTypeName(component));

  }

  function isCardSectionComponent(component) {

    return isCardSectionType(getComponentTypeName(component));

  }

  function isCardHeaderComponent(component) {

    return isCardHeaderType(getComponentTypeName(component));

  }

  function isCardBodyComponent(component) {

    return isCardBodyType(getComponentTypeName(component));

  }

  function isCardFooterComponent(component) {

    return isCardFooterType(getComponentTypeName(component));

  }

  function findComponentDefinitionByType(typeName) {

    typeName = String(typeName || '').toLowerCase();

    let found = null;

    $.each(editor.components || {}, function (fieldTypeID, componentData) {

      if (found) {
        return;
      }

      if (getComponentDataType(componentData) === typeName) {
        found = componentData;
      }

    });

    return found;

  }

  function buildComponentConfigForInsertion(componentData) {

    const componentType = getComponentDataType(componentData);

    if (isCardType(componentType)) {
      return buildCompleteCardComponentConfig(componentData);
    }

    return cloneComponentConfig(componentData.grapesComponent);

  }

  function buildCompleteCardComponentConfig(cardComponentData) {

    const cardComponent = cloneComponentConfig(cardComponentData.grapesComponent);

    cardComponent.components = [
      buildCardSectionComponentConfig('card-header'),
      buildCardSectionComponentConfig('card-body'),
      buildCardSectionComponentConfig('card-footer')
    ].filter(Boolean);

    if (!cardComponent.attributes) {
      cardComponent.attributes = {};
    }

    cardComponent.attributes['data-automator-can-have-child'] = 'true';
    cardComponent.droppable = true;

    return cardComponent;

  }

  function buildCardSectionComponentConfig(typeName) {

    const componentData = findComponentDefinitionByType(typeName);

    if (componentData && componentData.grapesComponent) {
      return cloneComponentConfig(componentData.grapesComponent);
    }

    const fallbackTitle = getFallbackCardSectionTitle(typeName);
    const fallbackClass = typeName;

    return {
      type: 'default',
      name: fallbackTitle,
      tagName: 'div',
      classes: ensureEditorInternalClasses([fallbackClass]),
      attributes: {
        'data-automator-field-type-id': '',
        'data-automator-field-type-name': typeName,
        'data-automator-field-type-title': fallbackTitle,
        'data-automator-base-classes': fallbackClass,
        'data-automator-can-have-child': 'true'
      },
      draggable: true,
      droppable: true,
      editable: false,
      selectable: true,
      hoverable: true,
      highlightable: true,
      copyable: true,
      removable: true,
      components: [
        buildPlaceholderComponent()
      ]
    };

  }

  function getFallbackCardSectionTitle(typeName) {

    if (isCardHeaderType(typeName)) {
      return 'Card Header';
    }

    if (isCardBodyType(typeName)) {
      return 'Card Body';
    }

    if (isCardFooterType(typeName)) {
      return 'Card Footer';
    }

    return 'Card Section';

  }

  function resolveCardSectionInsertionParent(selected) {

    if (!selected) {
      return null;
    }

    if (isCardComponent(selected)) {
      return selected;
    }

    return findClosestCardComponent(selected);

  }

  function findClosestCardComponent(component) {

    if (!component) {
      return null;
    }

    let parent = component.parent ? component.parent() : null;

    while (parent) {

      if (isCardComponent(parent)) {
        return parent;
      }

      parent = parent.parent ? parent.parent() : null;

    }

    return null;

  }

  function canAddCardSectionToCard(cardComponent, sectionType, movingComponent = null) {

    if (!cardComponent || !isCardComponent(cardComponent)) {
      return false;
    }

    sectionType = String(sectionType || '').toLowerCase();

    if (isCardBodyType(sectionType)) {
      return true;
    }

    if (!isCardHeaderType(sectionType) && !isCardFooterType(sectionType)) {
      return false;
    }

    let exists = false;

    cardComponent.components().each(function (child) {

      if (movingComponent && child.cid === movingComponent.cid) {
        return;
      }

      const childType = getComponentTypeName(child);

      if (childType === sectionType) {
        exists = true;
      }

    });

    return !exists;

  }

  function canMoveStructureItem(evt) {

    if (!evt || !evt.dragged || !evt.to) {
      return false;
    }

    const componentCid = $(evt.dragged).attr('data-cid');
    const parentCid = $(evt.to).attr('data-parent-cid');

    const component = findComponentByCid(componentCid);

    const parentComponent = parentCid === 'root'
      ? grapesEditor.DomComponents.getWrapper()
      : findComponentByCid(parentCid);

    return canMoveComponentToParent(component, parentComponent);

  }

  function canMoveComponentToParent(component, parentComponent) {

    if (!component || !parentComponent) {
      return false;
    }

    const movingType = getComponentTypeName(component);

    if (isCardSectionType(movingType)) {

      if (!isCardComponent(parentComponent)) {
        return false;
      }

      return canAddCardSectionToCard(parentComponent, movingType, component);

    }

    if (isCardSectionComponent(parentComponent)) {
      return canReceiveChildren(parentComponent);
    }

    if (isCardComponent(parentComponent)) {
      return canReceiveChildren(parentComponent);
    }

    if (parentComponent === grapesEditor.DomComponents.getWrapper()) {
      return true;
    }

    return canReceiveChildren(parentComponent);

  }

  function normalizeAllCardChildrenOrder() {

    if (!grapesEditor) {
      return;
    }

    const wrapper = grapesEditor.DomComponents.getWrapper();

    if (!wrapper) {
      return;
    }

    walkComponents(wrapper.components(), function (component) {

      if (isCardComponent(component)) {
        normalizeCardChildrenOrder(component);
      }

      return true;

    });

  }

  function normalizeCardChildrenOrder(cardComponent) {

    if (!cardComponent || !cardComponent.components || !isCardComponent(cardComponent)) {
      return;
    }

    const children = [];

    cardComponent.components().each(function (child) {

      const attrs = child.getAttributes ? child.getAttributes() : {};

      if (attrs['data-automator-placeholder'] === 'true') {
        return;
      }

      children.push(child);

    });

    if (!children.length) {
      return;
    }

    let header = null;
    let footer = null;
    const middle = [];

    children.forEach(function (child) {

      if (isCardHeaderComponent(child) && !header) {
        header = child;
        return;
      }

      if (isCardFooterComponent(child) && !footer) {
        footer = child;
        return;
      }

      middle.push(child);

    });

    const ordered = [];

    if (header) {
      ordered.push(header);
    }

    middle.forEach(function (child) {
      ordered.push(child);
    });

    if (footer) {
      ordered.push(footer);
    }

    ordered.forEach(function (child, index) {

      if (!child || !child.move) {
        return;
      }

      child.move(cardComponent, {
        at: index
      });

    });

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

    if (wrapper.cid === cid) {
      return wrapper;
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
      return;
    }

    components.each(function (component) {

      const result = callback(component);

      if (result === false) {
        return false;
      }

      const children = component.components();

      if (children && children.length) {
        walkComponents(children, callback);
      }

    });

  }

  function saveContent() {

    if (!grapesEditor) {
      const emptyData = {
        html: '',
        css: '',
        components: []
      };

      console.log('SysAutomatorEditor submit:', emptyData);

      return emptyData;
    }

    const data = {
      html: cleanEditorHtml(grapesEditor.getHtml()),
      css: grapesEditor.getCss(),
      components: grapesEditor.getComponents().toJSON()
    };

    $('#extracted-json').html(JSON.stringify(data));

    console.log('SysAutomatorEditor submit:', data);

    state.hasChanges = false;
    setSaveState(false);

    return data;

  }

  function cleanEditorHtml(html) {

    if (!grapesEditor) {
      return html || '';
    }

    const wrapperComponent = grapesEditor.DomComponents.getWrapper();

    if (!wrapperComponent) {
      return html || '';
    }

    const htmlParts = [];

    wrapperComponent.components().each(function (component) {
      htmlParts.push(getCleanComponentHtml(component));
    });

    return htmlParts.join('');

  }

  function getCleanComponentHtml(component) {

    if (!component) {
      return '';
    }

    if (isPlaceholderComponent(component)) {
      return '';
    }

    if (isShortcodeComponent(component)) {
      return cleanShortcodeWrapperHtml(component);
    }

    const clonedHtml = component.toHTML ? component.toHTML() : '';

    const wrapper = document.createElement('div');
    wrapper.innerHTML = clonedHtml || '';

    $(wrapper).find('[data-automator-placeholder="true"]').remove();
    $(wrapper).find('[data-automator-shortcode-preview="true"]').remove();

    $(wrapper).find('[class]').each(function () {

      const el = $(this);
      const classes = sanitizeEditorClasses(el.attr('class'));

      if (classes.length) {
        el.attr('class', classes.join(' '));
      } else {
        el.removeAttr('class');
      }

    });

    $(wrapper).find('[data-automator-base-classes]').removeAttr('data-automator-base-classes');
    $(wrapper).find('[data-automator-can-have-child]').removeAttr('data-automator-can-have-child');
    $(wrapper).find('[data-automator-shortcode-component]').removeAttr('data-automator-shortcode-component');

    return wrapper.innerHTML;

  }

  function cleanShortcodeWrapperHtml(component) {

    const shortcodeHtml = getShortcodeFinalHtml(component);

    const attrs = component.getAttributes ? component.getAttributes() : {};
    const tagName = component.get('tagName') || 'div';
    const classes = component.getClasses ? component.getClasses() : [];
    const style = component.getStyle ? component.getStyle() : {};

    const finalClasses = sanitizeEditorClasses(classes);

    const el = document.createElement(tagName);

    if (finalClasses.length) {
      el.setAttribute('class', finalClasses.join(' '));
    }

    const cleanAttrs = $.extend({}, attrs);

    delete cleanAttrs['data-automator-base-classes'];
    delete cleanAttrs['data-automator-can-have-child'];
    delete cleanAttrs['data-automator-shortcode-component'];
    delete cleanAttrs['data-automator-field-type-id'];
    delete cleanAttrs['data-automator-field-type-name'];
    delete cleanAttrs['data-automator-field-type-title'];

    $.each(cleanAttrs, function (key, value) {

      if (key.indexOf('data-automator-property-') === 0) {
        return;
      }

      if (key === 'class' || key === 'style') {
        return;
      }

      el.setAttribute(key, value);

    });

    const styleString = objectToStyleString(style);

    if (styleString) {
      el.setAttribute('style', styleString);
    }

    el.innerHTML = shortcodeHtml;

    return el.outerHTML;

  }

  function isPlaceholderComponent(component) {

    if (!component || !component.getAttributes) {
      return false;
    }

    const attrs = component.getAttributes();

    return attrs['data-automator-placeholder'] === 'true';

  }

  function objectToStyleString(style) {

    if (!style || typeof style !== 'object') {
      return '';
    }

    return Object.entries(style).map(function (item) {
      return item[0] + ':' + item[1];
    }).join(';');

  }

  function updateStructureActiveItem(component) {

    $('.automator-editor-structure-item-wrapper').removeClass('is-selected');

    if (!component || !component.cid) {
      return;
    }

    $('.automator-editor-structure-item-wrapper[data-cid="' + component.cid + '"]').addClass('is-selected');

  }

  function switchLeftTab(tab) {

    const sidebar = $(selectors.leftAside);
    const currentTab = sidebar.attr('data-active-tab') || '';

    if (currentTab === tab && isLeftSidebarOpen()) {
      setLeftSidebarOpen(false);
      updateLeftTabButtons('');
      return;
    }

    updateLeftTabVisibility(tab);
    setLeftSidebarOpen(true);

  }

  function updateLeftTabVisibility(tab) {

    const sidebar = $(selectors.leftAside);

    sidebar.attr('data-active-tab', tab);

    updateLeftTabButtons(tab);

    if (tab === 'structure') {
      updateStructureList();
    }

  }

  function toggleSidebar(side) {

    if (side === 'left') {

      if (isLeftSidebarOpen()) {
        setLeftSidebarOpen(false);
        updateLeftTabButtons('');
        return;
      }

      const currentTab = $(selectors.leftAside).attr('data-active-tab') || 'inserter';

      updateLeftTabVisibility(currentTab);
      setLeftSidebarOpen(true);

      return;

    }

    const el = $(selectors.rightAside);

    if (window.innerWidth <= 991.98) {
      el.toggleClass('show');
      return;
    }

    el.toggleClass('is-collapsed');

  }

  function isLeftSidebarOpen() {

    const sidebar = $(selectors.leftAside);

    if (window.innerWidth <= 991.98) {
      return sidebar.hasClass('show');
    }

    return !sidebar.hasClass('is-collapsed');

  }

  function setLeftSidebarOpen(open) {

    const sidebar = $(selectors.leftAside);

    if (window.innerWidth <= 991.98) {

      sidebar.removeClass('is-collapsed');

      if (open) {
        sidebar.addClass('show');
      } else {
        sidebar.removeClass('show');
      }

      return;

    }

    sidebar.removeClass('show');

    if (open) {
      sidebar.removeClass('is-collapsed');
    } else {
      sidebar.addClass('is-collapsed');
    }

  }

  function updateLeftTabButtons(activeTab) {

    $('[data-automator-left-tab]').removeClass('is-active');

    if (!activeTab) {
      return;
    }

    $('[data-automator-left-tab="' + activeTab + '"]').addClass('is-active');

  }

  function setSaveState(enabled) {
    $(selectors.saveBtn).prop('disabled', !enabled);
  }

  function hideBootstrapFloatingElements() {

    if (typeof bootstrap === 'undefined') {
      return;
    }

    document.querySelectorAll('[data-bs-toggle="popover"]').forEach(function (el) {
      try {
        const instance = bootstrap.Popover.getInstance(el);
        if (instance) instance.hide();
      } catch (e) {}
    });

    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
      try {
        const instance = bootstrap.Tooltip.getInstance(el);
        if (instance) instance.hide();
      } catch (e) {}
    });

  }

  function initBootstrapHelpers() {

    if (typeof bootstrap === 'undefined') {
      return;
    }

    document.querySelectorAll('[data-bs-toggle="tooltip"]').forEach(function (el) {
      try {
        bootstrap.Tooltip.getOrCreateInstance(el);
      } catch (e) {}
    });

  }

  function injectCanvasEditorStyles() {

    const doc = grapesEditor.Canvas.getDocument();

    if (!doc || doc.getElementById('automator-editor-canvas-styles')) {
      return;
    }

    const style = doc.createElement('style');
    style.id = 'automator-editor-canvas-styles';

    style.innerHTML = `
      [data-automator-field-type-title] {
        position: relative !important;
        min-height: 62px !important;
        outline: 1px dashed rgba(13, 110, 253, .45) !important;
        outline-offset: -1px !important;
        box-sizing: border-box !important;
      }

      [data-automator-field-type-title]::before {
        content: attr(data-automator-field-type-title);
        position: absolute;
        right: 110px;
        top: -28px;
        background: #3b97e3;
        color: #ffffff;
        font-size: 12px;
        line-height: 18px;
        padding: 5px 10px;
        border-radius: 3px 3px 0 0;
        display: block;
        z-index: 9999;
        pointer-events: none;
        font-family: Arial, sans-serif;
        font-weight: 500;
      }

      [data-automator-field-type-title]:hover,
      [data-automator-field-type-title].gjs-selected {
        outline: 2px solid #0d6efd !important;
        outline-offset: -2px !important;
      }

      .automator-editor-visual-space {
        padding: 10px !important;
        margin-top: 24px !important;
        margin-bottom: 14px !important;
        box-sizing: border-box !important;
      }

      body > .automator-editor-visual-space {
        width: auto !important;
        max-width: 100% !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
      }

      .row.automator-editor-visual-space {
        padding: 10px !important;
        margin-top: 24px !important;
        margin-bottom: 14px !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        width: 100% !important;
        max-width: 100% !important;
        border-left: 1px dashed rgba(13, 110, 253, .35);
        border-right: 1px dashed rgba(13, 110, 253, .35);
      }

      .container.automator-editor-visual-space,
      .container-fluid.automator-editor-visual-space {
        width: 100% !important;
        max-width: 100% !important;
        margin-left: 0 !important;
        margin-right: 0 !important;
        padding: 10px !important;
        background: rgba(255, 255, 255, .5);
      }

      [data-automator-can-have-child="true"] {
        min-height: 42px !important;
      }

      .automator-editor-child-placeholder {
        width: 100%;
        min-height: 42px;
        border: 1px dashed #0d6efd;
        background: rgba(13, 110, 253, .06);
        color: #0d6efd;
        font-size: 22px;
        font-weight: 700;
        border-radius: 6px;
        cursor: pointer;
      }

      p[data-automator-field-type-title],
      h1[data-automator-field-type-title],
      h2[data-automator-field-type-title],
      h3[data-automator-field-type-title],
      h4[data-automator-field-type-title],
      h5[data-automator-field-type-title],
      h6[data-automator-field-type-title],
      span[data-automator-field-type-title],
      a[data-automator-field-type-title] {
        cursor: text !important;
      }

      .container,
      .container-fluid,
      .row {
        min-height: 35px;
      }

      .row {
        display: flex;
        flex-wrap: wrap;
      }

      .automator-editor-shortcode-preview {
        width: 100%;
        min-height: 42px;
        display: flex;
        align-items: center;
        justify-content: center;
        background: rgba(13, 110, 253, .06);
        border: 1px dashed rgba(13, 110, 253, .55);
        border-radius: 6px;
        color: #0d6efd;
        font-size: 13px;
        font-weight: 600;
        text-align: center;
        padding: 10px;
        user-select: none;
        pointer-events: none;
      }

      body > div[data-gjs-type="wrapper"] { background: #ECECEC; padding: 24px !important; }
    `;

    doc.head.appendChild(style);

  }

  function syncCanvasHeight() {

    if (!grapesEditor) {
      return;
    }

    setTimeout(function () {

      const frameEl = grapesEditor.Canvas.getFrameEl();
      const frameBody = grapesEditor.Canvas.getBody();

      if (!frameEl || !frameBody) {
        return;
      }

      let contentHeight = 0;

      Array.from(frameBody.children).forEach(function (child) {

        if (
          child.tagName === 'SCRIPT' ||
          child.tagName === 'STYLE'
        ) {
          return;
        }

        const rect = child.getBoundingClientRect();

        contentHeight = Math.max(
          contentHeight,
          rect.top + rect.height
        );

      });

      const height = Math.max(
        500,
        Math.ceil(contentHeight + 20)
      );

      frameEl.style.height = height + 'px';
      frameEl.style.minHeight = height + 'px';
      frameEl.style.overflow = 'hidden';

      $(selectors.canvas).find('.gjs-editor').css({
        height: height + 'px',
        minHeight: height + 'px',
        overflow: 'hidden'
      });

      $(selectors.canvas).find('.gjs-cv-canvas').css({
        height: height + 'px',
        minHeight: height + 'px',
        overflow: 'hidden'
      });

      $(selectors.canvas).find('.gjs-cv-canvas__frames').css({
        height: height + 'px',
        minHeight: height + 'px',
        overflow: 'hidden'
      });

      $(selectors.canvas).find('.gjs-frame-wrapper').css({
        height: height + 'px',
        minHeight: height + 'px',
        overflow: 'hidden'
      });

      if (typeof grapesEditor.refresh === 'function') {
        grapesEditor.refresh();
      }

    }, 80);

  }

  function uniqueArray(items) {

    return items.filter(function (item, index) {
      return item && items.indexOf(item) === index;
    });

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

  function getComponent(fieldTypeID) {
    return editor.components[String(fieldTypeID || '')] || null;
  }

  function getComponents() {
    return editor.components;
  }

  $(window).off('resize.automator-editor-spacing');
  $(window).on('resize.automator-editor-spacing', function () {

    syncCanvasHeight();
    syncEditorViewportSpacing();

  });

  return {
    config,
    init,
    destroy,
    initInterface,

    loadSidebarComponents,

    insertField: injectBlock,
    injectBlock,

    switchLeftTab,
    updateLeftTabVisibility,
    toggleSidebar,

    saveContent,
    updateStructureList,

    applySelectedComponentSettings,
    deleteSelectedComponent,

    getEditor,
    getComponent,
    getComponents
  };

})();