window.SysAutomatorEditor = (function () {

  const defaultState = {
    isNew: true,
    hasChanges: false,
    initialized: false,
    componentsLoaded: false,
    componentsLoading: false,
    previewMode: false,
    viewportMode: 'auto',
    previewRestoreState: null
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
    saveBtn: '#automator-editor-header-save-btn',
    previewBtn: '#automator-editor-header-preview-btn',
    previewTooltip: '#automator-editor-header-preview-btn',
    viewportBtn: '#automator-editor-header-viewport-btn',
    viewportLabel: '#automator-editor-header-viewport-label',
    canvasContainer: '#automator-editor-canvas-container'
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

  function waitEditorReady(callback = null) {

    let attempts = 0;
    const maxAttempts = 120;

    function check() {

      attempts++;

      const frameEl =
        grapesEditor &&
        grapesEditor.Canvas &&
        grapesEditor.Canvas.getFrameEl
          ? grapesEditor.Canvas.getFrameEl()
          : null;

      const frameDoc =
        grapesEditor &&
        grapesEditor.Canvas &&
        grapesEditor.Canvas.getDocument
          ? grapesEditor.Canvas.getDocument()
          : null;

      const frameBody =
        grapesEditor &&
        grapesEditor.Canvas &&
        grapesEditor.Canvas.getBody
          ? grapesEditor.Canvas.getBody()
          : null;

      const wrapper =
        grapesEditor &&
        grapesEditor.DomComponents &&
        grapesEditor.DomComponents.getWrapper
          ? grapesEditor.DomComponents.getWrapper()
          : null;

      const frameReady =
        frameEl &&
        frameDoc &&
        frameBody &&
        wrapper &&
        $(selectors.canvas).find('.gjs-editor').length &&
        $(selectors.canvas).find('.gjs-frame').length;

      if (frameReady) {

        setTimeout(function () {

          syncCanvasHeight();
          syncEditorViewportSpacing();

          if (typeof grapesEditor.refresh === 'function') {
            grapesEditor.refresh();
          }

          setTimeout(function () {

            syncCanvasHeight();
            syncEditorViewportSpacing();

            if (typeof callback === 'function') {
              callback();
            }

          }, 250);

        }, 250);

        return;

      }

      if (attempts >= maxAttempts) {

        console.warn('Editor carregado parcialmente. Continuando inicialização.');

        if (typeof callback === 'function') {
          callback();
        }

        return;

      }

      setTimeout(check, 100);

    }

    check();

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

    if (grapesEditor.RichTextEditor) {

      if (typeof grapesEditor.RichTextEditor.remove === 'function') {
        grapesEditor.RichTextEditor.remove('link');
      }

      if (
        typeof grapesEditor.RichTextEditor.getAll === 'function' &&
        grapesEditor.RichTextEditor.getAll().remove
      ) {
        grapesEditor.RichTextEditor.getAll().remove('link');
      }

    }

    bindEditorEvents();
    bindInterfaceBlocks();
    initInterface();

    grapesEditor.once('load', function () {

      loadInitialContent();

      waitEditorReady(function () {

        injectCanvasEditorStyles();
        ensureStructureDropStyles();
        normalizeAllCardChildrenOrder();
        updateEmptyContainers();
        updateStructureList();
        syncCanvasHeight();
        syncEditorViewportSpacing();

        state.initialized = true;
        state.hasChanges = false;

        setSaveState(false);
        resetEditorChangeObserverState();

        if (typeof callback === 'function') {
          callback({ state, editor, selectors, grapesEditor });
        }

      });

    });

  }

  function destroy(resetConfig = true) {

    discardEditorUnsavedChanges();


    /*
    |--------------------------------------------------------------------------
    | Remove os observadores externos do editor
    |--------------------------------------------------------------------------
    */

    $(document).off(
      '.automator-editor-page-settings'
    );


    const currentEditor =
      grapesEditor;

    grapesEditor = null;


    if (currentEditor) {

      try {

        currentEditor.destroy();

      } catch (e) {

        console.warn(
          'GrapesJS do editor de páginas já estava destruído.',
          e
        );

      }

    }


    try {

      $(selectors.canvas).empty();

      $(selectors.structureList).empty();

    } catch (e) {}


    if ($(selectors.rightContent).length) {

      $(selectors.rightContent).html(
        '<div class="text-center p-3">' +
        'Selecione um bloco para editar.' +
        '</div>'
      );

    }


    if (resetConfig === true) {

      state =
        $.extend(
          true,
          {},
          defaultState
        );

      editor =
        $.extend(
          true,
          {},
          defaultEditor
        );

    }

  }

  function discardEditorUnsavedChanges() {

    state.hasChanges = false;

    setSaveState(false);

    const formEl = document.getElementById('automator-editor-change-observer-form');

    if (formEl) {

      const field = formEl.querySelector('#automator-editor-change-observer-state');

      if (field) {
        field.value = serializeEditorCurrentState();
      }

      if (typeof AutomatorFormSerializeCurrentState === 'function') {
        formEl.setAttribute('data-automator-initial-state', AutomatorFormSerializeCurrentState(formEl));
      } else if (field) {
        formEl.setAttribute('data-automator-initial-state', field.value);
      }

      formEl.setAttribute('data-automator-form-changed', 'false');

    }

    $('#automator-editor-modal')
      .find('form')
      .attr('data-automator-form-changed', 'false');

    $(window).off('beforeunload.AutomatorModalFormChanged');

    return true;

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

  function getViewportModes() {

    return {
      auto: {
        label: 'Auto',
        width: null
      },
      xs: {
        label: 'XS',
        width: 375
      },
      sm: {
        label: 'SM',
        width: 576
      },
      md: {
        label: 'MD',
        width: 768
      },
      lg: {
        label: 'LG',
        width: 992
      },
      xl: {
        label: 'XL',
        width: 1200
      },
      xxl: {
        label: 'XXL',
        width: 1400
      }
    };

  }

  function setViewportMode(mode) {

    const modes = getViewportModes();

    if (!modes[mode]) {
      mode = 'auto';
    }

    state.viewportMode = mode;

    updateViewportButton();
    syncCanvasDeviceViewport();
    syncCanvasHeight();

  }

  function updateViewportButton() {

    const modes = getViewportModes();
    const current = modes[state.viewportMode] || modes.auto;

    $(selectors.viewportLabel).text(current.label);

  }

  function syncCanvasDeviceViewport() {

    const modes = getViewportModes();
    const current = modes[state.viewportMode] || modes.auto;
    const container = $(selectors.canvasContainer);

    if (!container.length) {
      return;
    }

    if (!current.width) {

      container.css({
        width: '',
        maxWidth: state.previewMode ? 'none' : ''
      });

    } else {

      container.css({
        width: current.width + 'px',
        maxWidth: current.width + 'px'
      });

    }

    if (grapesEditor) {

      const frameEl = grapesEditor.Canvas.getFrameEl();

      if (frameEl && current.width) {
        frameEl.style.width = current.width + 'px';
        frameEl.style.maxWidth = current.width + 'px';
      }

      if (frameEl && !current.width) {
        frameEl.style.width = '';
        frameEl.style.maxWidth = '';
      }

      if (typeof grapesEditor.refresh === 'function') {
        grapesEditor.refresh();
      }

    }

  }

  function syncEditorLayoutState() {

    const modal = $('#automator-editor-modal');

    const leftHidden =
      $(selectors.leftAside).hasClass('is-collapsed') ||
      !$(selectors.leftAside).is(':visible');

    const rightHidden =
      $(selectors.rightAside).hasClass('is-collapsed') ||
      !$(selectors.rightAside).is(':visible');

    if (state.previewMode || (leftHidden && rightHidden)) {
      modal.addClass('is-sidebars-hidden');
    } else {
      modal.removeClass('is-sidebars-hidden');
    }

    syncCanvasDeviceViewport();

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

  function prepareSavedPageContentForEditor(content = '') {

    content = String(content || '');

    if (content.trim() === '') {
      return '';
    }

    const replacements = [];

    function createToken(shortcode) {

      const index = replacements.length;

      const shortcodeData = parseSavedShortcodeString(shortcode);

      if (!shortcodeData) {
        replacements.push(shortcode);
      } else {
        replacements.push(
          buildShortcodeEditorHtmlFromSavedShortcode(
            shortcodeData.shortcodeCode,
            shortcodeData.attrsText,
            shortcodeData.originalShortcode
          )
        );
      }

      return '%%AUTOMATOR_EDITOR_SHORTCODE_' + index + '%%';

    }

    content = content.replace(
      /<div\b[^>]*>\s*<code\b[^>]*>\s*(\[(?:automator|system-form|system-pages)\b[^\]]*\])\s*<\/code>\s*<\/div>/gi,
      function(fullMatch, shortcode) {
        return createToken(shortcode);
      }
    );

    content = content.replace(
      /<code\b[^>]*>\s*(\[(?:automator|system-form|system-pages)\b[^\]]*\])\s*<\/code>/gi,
      function(fullMatch, shortcode) {
        return createToken(shortcode);
      }
    );

    content = content.replace(
      /\[(automator|system-form|system-pages)\b([^\]]*)\]/gi,
      function(fullMatch) {
        return createToken(fullMatch);
      }
    );

    replacements.forEach(function(html, index) {
      content = content.replaceAll(
        '%%AUTOMATOR_EDITOR_SHORTCODE_' + index + '%%',
        html
      );
    });

    return content;

  }

  function parseSavedShortcodeString(shortcode = '') {

    shortcode = String(shortcode || '').trim();

    const match = shortcode.match(/^\[(automator|system-form|system-pages)\b([^\]]*)\]$/i);

    if (!match) {
      return null;
    }

    return {
      shortcodeCode: String(match[1] || '').trim(),
      attrsText: String(match[2] || ''),
      originalShortcode: shortcode
    };

  }

  function buildShortcodeEditorHtmlFromSavedShortcode(
    shortcodeCode = '',
    attrsText = '',
    originalShortcode = ''
  ) {

    shortcodeCode = String(shortcodeCode || '').trim();
    attrsText = String(attrsText || '');
    originalShortcode = String(originalShortcode || '').trim();

    const attrs = parseSavedShortcodeAttributes(attrsText);

    let componentType = 'shortcode';
    let selectedShortcode = shortcodeCode;
    let shortcodeWrapper = 'automator';

    if (shortcodeCode === 'automator' && attrs.function) {

      selectedShortcode = String(attrs.function || '').trim();

      if (selectedShortcode === 'pagination') {
        componentType = 'pagination';
      } else {
        componentType = 'shortcode';
      }

    } else {

      selectedShortcode = shortcodeCode;

      if (selectedShortcode === 'pagination') {
        componentType = 'pagination';
      } else {
        componentType = 'shortcode';
      }

    }

    const componentData =
      findComponentDefinitionByType(componentType) ||
      findComponentDefinitionByType('shortcode');

    if (!componentData) {
      return '<code>' + escapeHtml(originalShortcode) + '</code>';
    }

    const fieldTypeID = componentData.id || '';
    const title = componentData.title || 'Shortcode';
    const type = componentData.type || componentType;
    const baseClasses = [];

    if (componentData.grapesComponent && componentData.grapesComponent.classes) {

      componentData.grapesComponent.classes.forEach(function(className) {

        if (!isReservedEditorClass(className)) {
          baseClasses.push(className);
        }

      });

    }

    const classes = ensureEditorInternalClasses(baseClasses).join(' ');

    let html = '';

    html += '<div';
    html += ' class="' + escapeHtml(classes) + '"';
    html += ' style="width: 100%;"';
    html += ' data-automator-field-type-id="' + escapeHtml(fieldTypeID) + '"';
    html += ' data-automator-field-type-name="' + escapeHtml(type) + '"';
    html += ' data-automator-field-type-title="' + escapeHtml(title) + '"';
    html += ' data-automator-base-classes="' + escapeHtml(baseClasses.join(' ')) + '"';
    html += ' data-automator-can-have-child="false"';
    html += ' data-automator-shortcode-component="true"';
    html += ' data-automator-shortcode-wrapper="' + escapeHtml(shortcodeWrapper) + '"';

    if (String(type).toLowerCase() === 'pagination') {

      html += ' data-automator-property-config.pagination="' + escapeHtml(attrs.name || attrs.pagination || '') + '"';

      $.each(attrs, function(attrName, attrValue) {

        if (
          attrName === 'function' ||
          attrName === 'name' ||
          attrName === 'pagination'
        ) {
          return;
        }

        html += ' data-automator-property-pagination_params.' + escapeHtml(attrName) + '="' + escapeHtml(attrValue) + '"';

      });

    } else {

      html += ' data-automator-property-config.shortcode="' + escapeHtml(selectedShortcode) + '"';

      $.each(attrs, function(attrName, attrValue) {

        if (attrName === 'function') {
          return;
        }

        html += ' data-automator-property-shortcode_params.' + escapeHtml(attrName) + '="' + escapeHtml(attrValue) + '"';

      });

    }

    html += '>';

    html += '<code class="automator-editor-shortcode-preview" data-automator-shortcode-preview="true">';
    html += escapeHtml(
      String(type).toLowerCase() === 'pagination'
        ? buildPaginationShortcodeHtml(componentData.raw, {
            pagination: attrs.name || attrs.pagination || ''
          }).replace(/<\/?code[^>]*>/gi, '')
        : '[automator function="' + selectedShortcode + '"]'
    );
    html += '</code>';

    html += '</div>';

    return html;

  }

  function buildSavedShortcodePreviewFromAutomatorFunction(
    selectedShortcode = '',
    attrs = {}
  ) {

    selectedShortcode = String(selectedShortcode || '').trim();

    if (selectedShortcode === '') {
      return '[automator]';
    }

    let preview = '[automator function="' + escapeShortcodeAttribute(selectedShortcode) + '"';

    $.each(attrs, function(attrName, attrValue) {

      if (attrName === 'function') {
        return;
      }

      if (attrValue === null || typeof attrValue === 'undefined' || String(attrValue) === '') {
        return;
      }

      preview += ' ' + attrName + '="' + escapeShortcodeAttribute(attrValue) + '"';

    });

    preview += ']';

    return preview;

  }

  function parseSavedShortcodeAttributes(attrsText = '') {

    const attrs = {};
    const regex = /([a-zA-Z0-9_\-]+)\s*=\s*("([^"]*)"|'([^']*)'|([^\s\]]+))/g;

    let match;

    while ((match = regex.exec(attrsText)) !== null) {

      const key = match[1];

      let value = '';

      if (typeof match[3] !== 'undefined') {
        value = match[3];
      } else if (typeof match[4] !== 'undefined') {
        value = match[4];
      } else if (typeof match[5] !== 'undefined') {
        value = match[5];
      }

      attrs[key] = value;

    }

    return attrs;

  }

  function loadInitialContent() {

    if (!grapesEditor) {
      return;
    }

    const content = prepareSavedPageContentForEditor(
      String(editor.content || '')
    );

    const css = String(editor.css || '');

    grapesEditor.setComponents(content);

    if (css) {
      grapesEditor.setStyle(css);
    } else {
      grapesEditor.setStyle('');
    }

    rehydrateLoadedEditorComponents();

  }

  function rehydrateLoadedEditorComponents() {

    if (!grapesEditor) {
      return;
    }

    const wrapper = grapesEditor.DomComponents.getWrapper();

    if (!wrapper || !wrapper.components) {
      return;
    }

    walkComponents(wrapper.components(), function(component) {
      rehydrateLoadedEditorComponent(component);
    });

    normalizeAllCardChildrenOrder();
    updateEmptyContainers();
    updateStructureList();

  }

  function rehydrateLoadedEditorComponent(component) {

    if (!component || !component.getAttributes) {
      return;
    }

    if (isPlaceholderComponent(component)) {
      return;
    }

    const currentAttrs = component.getAttributes() || {};

    if (
      currentAttrs['data-automator-field-type-id'] &&
      currentAttrs['data-automator-field-type-name']
    ) {

      const componentData = getComponent(currentAttrs['data-automator-field-type-id']);

      rehydrateLoadedComponentProperties(component, componentData);

      if (isShortcodeComponent(component)) {
        syncShortcodeComponent(component);
      }

      return;

    }

    const componentData = findComponentDefinitionForLoadedComponent(component);

    if (!componentData) {
      return;
    }

    applyComponentDefinitionToLoadedComponent(
      component,
      componentData
    );

    rehydrateLoadedComponentProperties(
      component,
      componentData
    );

    if (isShortcodeComponent(component)) {
      syncShortcodeComponent(component);
    }

  }

  function findComponentDefinitionForLoadedComponent(component) {

    if (!component || !component.get) {
      return null;
    }

    const tagName = String(component.get('tagName') || '').toLowerCase();
    const classes = component.getClasses ? component.getClasses() : [];

    let matched = null;

    $.each(editor.components || {}, function(fieldTypeID, componentData) {

      if (matched || !componentData || !componentData.grapesComponent) {
        return;
      }

      const typeName = getComponentDataType(componentData);

      if (
        typeName === 'card' &&
        hasClassInList(classes, 'card')
      ) {
        matched = componentData;
        return;
      }

      if (
        typeName === 'card-header' &&
        hasClassInList(classes, 'card-header')
      ) {
        matched = componentData;
        return;
      }

      if (
        typeName === 'card-body' &&
        hasClassInList(classes, 'card-body')
      ) {
        matched = componentData;
        return;
      }

      if (
        typeName === 'card-footer' &&
        hasClassInList(classes, 'card-footer')
      ) {
        matched = componentData;
        return;
      }

      if (
        typeName === 'link' &&
        tagName === 'a'
      ) {
        matched = componentData;
        return;
      }

      if (
        typeName === 'image' &&
        tagName === 'img'
      ) {
        matched = componentData;
        return;
      }

      const componentTag = String(
        componentData.grapesComponent.tagName || ''
      ).toLowerCase();

      if (
        componentTag &&
        componentTag === tagName &&
        componentDefinitionClassesMatch(componentData, classes)
      ) {
        matched = componentData;
        return;
      }

    });

    return matched;

  }

  function componentDefinitionClassesMatch(componentData, currentClasses = []) {

    if (!componentData || !componentData.grapesComponent) {
      return false;
    }

    const definitionClasses =
      componentData.grapesComponent.classes || [];

    const requiredClasses = [];

    definitionClasses.forEach(function(className) {

      if (
        className &&
        !isReservedEditorClass(className) &&
        !isBootstrapColumnSizeClass(className)
      ) {
        requiredClasses.push(className);
      }

    });

    if (!requiredClasses.length) {
      return true;
    }

    for (let i = 0; i < requiredClasses.length; i++) {

      if (!hasClassInList(currentClasses, requiredClasses[i])) {
        return false;
      }

    }

    return true;

  }

  function hasClassInList(classes = [], className = '') {

    className = String(className || '');

    if (!className) {
      return false;
    }

    if (typeof classes === 'string') {
      classes = classes.split(/\s+/);
    }

    return classes.indexOf(className) !== -1;

  }

  function applyComponentDefinitionToLoadedComponent(
    component,
    componentData
  ) {

    if (!component || !componentData) {
      return;
    }

    const componentConfig = componentData.grapesComponent || {};
    const currentAttrs = component.getAttributes ? component.getAttributes() : {};
    const currentClasses = component.getClasses ? component.getClasses() : [];

    const definitionAttrs = componentConfig.attributes || {};
    const definitionClasses = componentConfig.classes || [];

    const finalAttrs = $.extend({}, currentAttrs, definitionAttrs);

    finalAttrs['data-automator-field-type-id'] = String(componentData.id || '');
    finalAttrs['data-automator-field-type-name'] = String(componentData.type || '');
    finalAttrs['data-automator-field-type-title'] = String(componentData.title || 'Bloco');
    finalAttrs['data-automator-can-have-child'] = componentData.hasChild ? 'true' : 'false';

    if (!finalAttrs['data-automator-base-classes']) {
      finalAttrs['data-automator-base-classes'] = sanitizeEditorClasses(definitionClasses).join(' ');
    }

    component.setAttributes(finalAttrs);

    const finalClasses = uniqueArray(
      sanitizeEditorClasses(currentClasses)
        .concat(sanitizeEditorClasses(definitionClasses))
        .concat(['automator-editor-visual-space'])
    );

    if (typeof component.setClass === 'function') {
      component.setClass(finalClasses);
    } else {

      finalClasses.forEach(function(className) {
        component.addClass(className);
      });

    }

    component.set({
      name: componentData.title || component.get('name') || 'Bloco',
      draggable: true,
      selectable: true,
      hoverable: true,
      highlightable: true,
      copyable: true,
      removable: true,
      droppable: componentData.hasChild ? true : false,
      editable: componentData.hasChild ? false : canAutomatorBeEdited(componentData.raw)
    });

  }

  function rehydrateLoadedComponentProperties(
    component,
    componentData
  ) {

    if (!component || !componentData || !component.getAttributes) {
      return;
    }

    const attrs = component.getAttributes() || {};
    const rawAttrs = $.extend({}, attrs);

    $.each(rawAttrs, function(attrName, attrValue) {

      attrName = String(attrName || '');

      if (
        attrName.indexOf('data-automator-') === 0 ||
        attrName.indexOf('data-gjs-') === 0
      ) {
        return;
      }

      const propertyName = getPropertyNameFromRealAttribute(
        componentData,
        attrName
      );

      if (!propertyName) {
        return;
      }

      attrs['data-automator-property-' + propertyName] = attrValue;

    });

    component.setAttributes(attrs);

  }

  function getPropertyNameFromRealAttribute(
    componentData,
    realAttrName
  ) {

    realAttrName = String(realAttrName || '').toLowerCase();

    if (!componentData || !componentData.raw || !componentData.raw.properties) {
      return getDefaultPropertyNameFromRealAttribute(realAttrName);
    }

    let found = '';

    $.each(componentData.raw.properties, function(groupKey, group) {

      if (found) {
        return;
      }

      $.each(group.fields || {}, function(fieldKey, field) {

        if (found) {
          return;
        }

        const inputName = groupKey + '.' + fieldKey;

        const mappedAttr =
          field.attribute ||
          field.attr ||
          field.html_attr ||
          getRealAttributeNameFromProperty(inputName);

        if (
          String(mappedAttr || '').toLowerCase() === realAttrName
        ) {
          found = inputName;
        }

      });

    });

    if (found) {
      return found;
    }

    return getDefaultPropertyNameFromRealAttribute(realAttrName);

  }

  function getDefaultPropertyNameFromRealAttribute(realAttrName) {

    realAttrName = String(realAttrName || '').toLowerCase();

    const map = {
      href: 'configs.href',
      src: 'configs.src',
      alt: 'configs.alt',
      title: 'configs.title',
      target: 'configs.target',
      rel: 'configs.rel',
      name: 'configs.name',
      value: 'configs.value',
      placeholder: 'configs.placeholder',
      type: 'configs.type',
      action: 'configs.action',
      method: 'configs.method',
      id: 'advanced.id',
      style: 'advanced.style',
      class: 'advanced.class'
    };

    return map[realAttrName] || '';

  }

  function initInterface(callback = null) {

    updateLeftTabVisibility('inserter');

    setLeftSidebarOpen(true);


    if (
      editor.settingsBlock &&
      editor.settingsBlock.collapsed === true
    ) {

      $(selectors.rightAside)
        .addClass('is-collapsed')
        .removeClass('show');

    } else {

      $(selectors.rightAside)
        .removeClass('is-collapsed');

    }


    /*
    |--------------------------------------------------------------------------
    | Inicializa os recursos da interface
    |--------------------------------------------------------------------------
    */

    initBootstrapHelpers();

    bindHeaderSlugSync();

    bindPageSettingsChangeObserver();

    bindEditorGlobalTabFocus();

    updateViewportButton();

    focusRightSidebarTab('page');

    syncEditorLayoutState();


    if (typeof callback === 'function') {

      callback({
        state,
        editor,
        selectors,
        grapesEditor
      });

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

    syncCanvasDeviceViewport();

  }


  function bindEditorEvents() {

    if (!grapesEditor) {
      return;
    }

    grapesEditor.on('load', function () {
      injectCanvasEditorStyles();
      ensureStructureDropStyles();
      normalizeAllCardChildrenOrder();
      syncCanvasHeight();
      syncEditorViewportSpacing();
    });

    grapesEditor.on('update', function () {

      markEditorAsChanged();

      normalizeAllCardChildrenOrder();
      updateStructureList();
      updateEmptyContainers();

      if (!isEditingPropertiesPanel()) {
        syncCanvasHeight();
        syncEditorViewportSpacing();
      }

    });

    grapesEditor.on('component:selected', function (component) {
      focusRightSidebarTab('block');
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

      markEditorAsChanged();

      normalizeAllCardChildrenOrder();
      updateStructureList();
      updateEmptyContainers();

      syncCanvasHeight();
      syncEditorViewportSpacing();

    });

    grapesEditor.on('component:update', function () {

      markEditorAsChanged();

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

  function togglePreviewMode() {

    setPreviewMode(!state.previewMode);

  }

  function setPreviewMode(enabled) {

    const enablePreview = enabled === true;

    if (enablePreview === state.previewMode) {
      return;
    }

    const modal = $('#automator-editor-modal');

    if (enablePreview) {

      state.previewRestoreState = getCurrentEditorViewState();
      state.previewMode = true;

      hideBootstrapFloatingElements();

      modal.addClass('is-preview-mode');

      setLeftSidebarOpen(false);

      $(selectors.rightAside)
        .addClass('is-collapsed')
        .removeClass('show');

      updateLeftTabButtons('');

      clearEditorSelection();

      setCanvasPreviewMode(true);

    } else {

      state.previewMode = false;

      modal.removeClass('is-preview-mode');

      setCanvasPreviewMode(false);

      restoreEditorViewState(state.previewRestoreState);

      state.previewRestoreState = null;

      if (grapesEditor && typeof grapesEditor.refresh === 'function') {
        grapesEditor.refresh();
      }

    }

    updatePreviewButton();
    updatePreviewLockedButtons();
    syncEditorLayoutState();

    syncCanvasHeight();
    syncEditorViewportSpacing();

  }

  function clearEditorSelection() {

    if (!grapesEditor) {
      return;
    }

    try {

      const selected = grapesEditor.getSelected();

      if (selected) {
        grapesEditor.selectRemove(selected);
      }

    } catch (e) {
      console.warn('Não foi possível limpar a seleção do editor:', e);
    }

  }

  function updatePreviewButton() {

    const button = $(selectors.previewBtn);
    const icon = button.find('i');

    if (!button.length) {
      return;
    }

    const tooltipEl = button.closest('[data-bs-toggle="tooltip"]');

    if (state.previewMode) {
      icon.removeClass('fa-eye').addClass('fa-edit');
      tooltipEl.attr('data-bs-title', 'Editar');
      tooltipEl.attr('title', 'Editar');
    } else {
      icon.removeClass('fa-edit').addClass('fa-eye');
      tooltipEl.attr('data-bs-title', 'Pré Visualizar');
      tooltipEl.attr('title', 'Pré Visualizar');
    }

  }

  function updatePreviewLockedButtons() {

    const lockedButtons = $(
      '[data-automator-left-tab], ' +
      '#automator-editor-header-configs-btn, ' +
      selectors.saveBtn
    );

    if (state.previewMode) {
      lockedButtons.addClass('automator-editor-preview-disabled').prop('disabled', true);
    } else {
      lockedButtons.removeClass('automator-editor-preview-disabled').prop('disabled', false);
      setSaveState(state.hasChanges);
    }

  }

  function setCanvasPreviewMode(enabled) {

    if (!grapesEditor) {
      return;
    }

    const doc = grapesEditor.Canvas.getDocument();
    const body = grapesEditor.Canvas.getBody();

    if (!doc || !body) {
      return;
    }

    injectCanvasPreviewStyles();

    const oldPreview = body.querySelector('#automator-editor-render-preview');

    if (oldPreview) {
      oldPreview.remove();
    }

    if (enabled) {

      const preview = doc.createElement('div');

      preview.id = 'automator-editor-render-preview';
      preview.innerHTML = normalizeFinalHtml(cleanEditorHtml(''));

      body.classList.add('automator-editor-canvas-preview-mode');

      Array.from(body.children).forEach(function (child) {

        if (
          child.id === 'automator-editor-render-preview' ||
          child.tagName === 'STYLE' ||
          child.tagName === 'SCRIPT'
        ) {
          return;
        }

        child.setAttribute('data-automator-preview-hidden', 'true');
        child.style.display = 'none';

      });

      body.appendChild(preview);

    } else {

      body.classList.remove('automator-editor-canvas-preview-mode');

      const preview = body.querySelector('#automator-editor-render-preview');

      if (preview) {
        preview.remove();
      }

      Array.from(body.children).forEach(function (child) {

        if (child.getAttribute('data-automator-preview-hidden') === 'true') {
          child.style.display = '';
          child.removeAttribute('data-automator-preview-hidden');
        }

      });

    }

  }

  function injectCanvasPreviewStyles() {

    if (!grapesEditor) {
      return;
    }

    const doc = grapesEditor.Canvas.getDocument();

    if (!doc || doc.getElementById('automator-editor-preview-styles')) {
      return;
    }

    const style = doc.createElement('style');
    style.id = 'automator-editor-preview-styles';

    style.innerHTML = `
      body.automator-editor-canvas-preview-mode {
        background: #ffffff !important;
      }

      #automator-editor-render-preview {
        position: relative !important;
        z-index: 999999 !important;
        width: 100% !important;
        min-height: 100% !important;
        background: #ffffff !important;
        pointer-events: auto !important;
      }

      #automator-editor-render-preview * {
        pointer-events: auto !important;
      }

      #automator-editor-render-preview [data-automator-field-type-title] {
        outline: none !important;
      }

      #automator-editor-render-preview [data-automator-field-type-title]::before {
        display: none !important;
        content: none !important;
      }

      #automator-editor-render-preview .automator-editor-visual-space {
        padding: initial !important;
        margin-top: initial !important;
        margin-bottom: initial !important;
        background: initial !important;
        border: none !important;
      }

      #automator-editor-render-preview .automator-editor-child-placeholder {
        display: none !important;
      }

      #automator-editor-render-preview .automator-editor-shortcode-preview {
        border: none !important;
        background: transparent !important;
      }
    `;

    doc.head.appendChild(style);

  }

  function buildShortcodeLikeComponent(fieldTypeID, field, item, fallbackTitle) {

    const baseClasses = sanitizeEditorClasses(getAutomatorClasses(field));
    const defaultValues = getDefaultShortcodeValues(field);

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
        buildShortcodePreviewComponent(field, defaultValues)
      ]
    };

  }

  function buildShortcodePreviewComponent(field, values = {}) {

    return {
      tagName: 'code',
      name: 'Código do shortcode',
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
      content: getShortcodeEditorPreviewCode(field, values)
    };

  }

  function getShortcodeEditorPreviewCode(field, values = {}) {

    const html = buildShortcodeLikeHtml(field, values);

    const wrapper = document.createElement('div');

    wrapper.innerHTML = html;

    const code = wrapper.querySelector('code');

    if (code) {
      return code.textContent || '';
    }

    return String(html || '').replace(/<[^>]+>/g, '');

  }

  function buildPaginationShortcodeHtml(field, values = {}) {

    const pagination =
      values.pagination ||
      values['config.pagination'] ||
      values.name ||
      '';

    let attrs = '';

    if (pagination !== '') {
      attrs += ' name="' + escapeShortcodeAttribute(pagination) + '"';
    }

    $.each(values, function(key, value) {

      key = String(key || '');

      if (
        key === 'pagination' ||
        key === 'config.pagination' ||
        key === 'name' ||
        key.indexOf('data-') === 0 ||
        key.indexOf('__') === 0
      ) {
        return;
      }

      if (key.indexOf('pagination_params.') !== 0) {
        return;
      }

      const attrName = key.replace('pagination_params.', '');

      if (!attrName || value === null || typeof value === 'undefined' || String(value) === '') {
        return;
      }

      attrs += ' ' + attrName + '="' + escapeShortcodeAttribute(value) + '"';

    });

    return '<code>[automator function="pagination"' + attrs + ']</code>';

  }

  function buildShortcodeLikeHtml(field, values = {}) {

    const type = String(getValue(field, 'type') || '').toLowerCase();

    if (type === 'shortcode') {
      return buildDynamicShortcodeHtml(field, values);
    }

    if (type === 'pagination') {
      return buildPaginationShortcodeHtml(field, values);
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
      return '<code>[automator]</code>';
    }

    const definitions = getShortcodeDefinitions(field);
    const selected = definitions[shortcode] || null;
    const params = selected ? selected.params || {} : {};

    let attrs = '';

    attrs += ' function="' + escapeShortcodeAttribute(shortcode) + '"';

    $.each(params, function(paramKey) {

      let value =
        values['shortcode_params.' + paramKey] ||
        values[paramKey] ||
        '';

      if (typeof value === 'undefined' || value === null) {
        value = '';
      }

      value = String(value);

      if (value === '') {
        return;
      }

      attrs += ' ' + paramKey + '="' + escapeShortcodeAttribute(value) + '"';

    });

    return '<code>[automator' + attrs + ']</code>';

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

    syncFinalAttributePropertyToComponent(component, propertyName, value);

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
      markEditorAsChanged();
      return;
    }

    if (isColumnSizeProperty(propertyName, component)) {
      syncBootstrapColumnClass(component, value, propertyName);
      markEditorAsChanged();
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

    markEditorAsChanged();
    updateStructureList();

  }

  function syncFinalAttributePropertyToComponent(component, propertyName, value) {

    if (!component || !component.getAttributes) {
      return;
    }

    propertyName = String(propertyName || '');

    if (isIgnoredFinalProperty(propertyName)) {
      return;
    }

    const realAttrName = getRealAttributeNameFromProperty(propertyName);

    if (!realAttrName) {
      return;
    }

    const attrs = component.getAttributes() || {};

    value = value === null || typeof value === 'undefined'
      ? ''
      : String(value);

    if (value === '') {
      delete attrs[realAttrName];
    } else {
      attrs[realAttrName] = value;
    }

    component.setAttributes(attrs);

    const viewEl = component.getEl ? component.getEl() : null;

    if (viewEl) {

      if (value === '') {
        viewEl.removeAttribute(realAttrName);
      } else {
        viewEl.setAttribute(realAttrName, value);
      }

    }

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

    component.components([
      buildShortcodePreviewComponent(componentData.raw, values)
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
        values.name ||
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

    if (attrs['data-automator-shortcode-wrapper']) {
      values.__shortcode_wrapper = attrs['data-automator-shortcode-wrapper'];
    }

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

    const attrs = component && component.getAttributes ? component.getAttributes() : {};
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
      const style = component && component.getStyle ? component.getStyle() : {};
      return objectToStyleString(style);
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
        <div class="automator-editor-body-aside-left-structure-item d-flex align-items-center border-bottom" style="padding-left: ${(level * 20) + 10}px !important;">
          <i class="fas fa-grip-vertical automator-editor-structure-handle me-2 text-muted"></i>
          <i class="fa fa-cube me-2 small text-primary"></i>
          <span class="small flex-grow-1 text-truncate cursor-pointer">${escapeHtml(name)}</span>
          <button type="button" class="btn btn-xs btn-light">
            <i class="fas fa-mouse-pointer"></i>
          </button>
        </div>
      `);

      item.on('click', function () {
        focusRightSidebarTab('block');
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

    ensureStructureDropStyles();

    $('.automator-editor-structure-children').each(function () {

      const el = this;

      $(el).css({
        minHeight: '44px',
        paddingTop: '6px',
        paddingBottom: '6px'
      });

      if ($(el).data('sortable')) {
        return;
      }

      new Sortable(el, {
        group: 'automator-structure',
        animation: 150,
        handle: '.automator-editor-structure-handle',
        draggable: '> .automator-editor-structure-item-wrapper',
        ghostClass: 'automator-editor-structure-sortable-ghost',
        chosenClass: 'automator-editor-structure-sortable-chosen',
        dragClass: 'automator-editor-structure-sortable-drag',
        emptyInsertThreshold: 48,
        swapThreshold: 0.65,
        invertSwap: true,

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
            markEditorAsChanged();
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

    if (state.previewMode) {
      return null;
    }

    const data = getEditorSubmitContentData();

    syncEditorSubmitContentToForm(data);

    $('#extracted-json').html(JSON.stringify(data));

    console.log('SysAutomatorEditor submit:', data);

    const formEl = getEditorSubmitForm();

    if (!formEl) {

      AutomatorCreateAutoCloseToastAlert(
        'automator-editor-submit-form-not-found-' + Date.now(),
        'center',
        'middle',
        true,
        true,
        'Erro',
        'O formulário de envio da página não foi encontrado.',
        null,
        false,
        null,
        5000
      );

      return data;

    }

    formEl.setAttribute('data-automator-form-changed', 'true');

    if (typeof formEl.requestSubmit === 'function') {
      formEl.requestSubmit();
    } else {
      $(formEl).trigger('submit');
    }

    return data;

  }

  function getEditorSubmitContentData() {

    if (!grapesEditor) {

      return {
        html: '',
        css: '',
        components: []
      };

    }

    return {
      html: normalizeFinalHtml(cleanEditorHtml('')),
      css: grapesEditor.getCss(),
      components: grapesEditor.getComponents().toJSON()
    };

  }

  function syncEditorSubmitContentToForm(data = {}) {

    const formEl = getEditorSubmitForm();

    if (!formEl) {
      return false;
    }

    syncEditorRouteFieldsToForm(formEl);

    setEditorSubmitHiddenInput(
      formEl,
      'tbl_sys_route_content',
      data.html || ''
    );

    setEditorSubmitHiddenInput(
      formEl,
      'tbl_sys_route_css',
      data.css || ''
    );

    setEditorSubmitHiddenInput(
      formEl,
      'automator_editor_components',
      JSON.stringify(data.components || [])
    );

    return true;

  }

  function setEditorSubmitHiddenInput(
    formEl,
    name,
    value
  ) {

    if (
      !formEl ||
      !name
    ) {
      return null;
    }

    const existingFields =
      formEl.querySelectorAll(
        'input[type="hidden"][name="' + name + '"]'
      );

    let input = null;

    if (existingFields.length > 0) {

      input =
        existingFields[0];

      /*
      |--------------------------------------------------------------------------
      | Remove duplicatas do mesmo campo
      |--------------------------------------------------------------------------
      */

      for (
        let index = 1;
        index < existingFields.length;
        index++
      ) {

        existingFields[index].remove();

      }

    }

    if (!input) {

      input =
        document.createElement('input');

      input.type =
        'hidden';

      input.name =
        name;

      formEl.appendChild(
        input
      );

    }

    input.value =
      value !== null &&
      typeof value !== 'undefined'
        ? String(value)
        : '';

    return input;

  }

  function getEditorSubmitForm() {

    /*
    |--------------------------------------------------------------------------
    | Formulário específico do editor
    |--------------------------------------------------------------------------
    */

    const editorForm =
      document.getElementById(
        'automator-editor-change-observer-form'
      );

    if (editorForm) {
      return editorForm;
    }

    /*
    |--------------------------------------------------------------------------
    | Formulário registrado no contexto do modal
    |--------------------------------------------------------------------------
    */

    if (
      window.AutomatorPaginationCurrentModalView &&
      window.AutomatorPaginationCurrentModalView.formEl
    ) {

      return window
        .AutomatorPaginationCurrentModalView
        .formEl;

    }

    /*
    |--------------------------------------------------------------------------
    | Último fallback dentro do editor
    |--------------------------------------------------------------------------
    */

    const editorModal =
      document.getElementById(
        'automator-editor-modal'
      );

    if (editorModal) {

      const formEl =
        editorModal.querySelector(
          'form'
        );

      if (formEl) {
        return formEl;
      }

    }

    return null;

  }

  function cleanEditorHtml(html) {

    if (!grapesEditor) {
      return html || '';
    }

    const wrapper = grapesEditor.DomComponents.getWrapper();

    if (!wrapper || !wrapper.components) {
      return html || '';
    }

    let finalHtml = '';

    wrapper.components().each(function (component) {
      finalHtml += getCleanComponentHtml(component);
    });

    return finalHtml;

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

    const type = component.get ? component.get('type') : '';

    if (type === 'textnode') {
      return component.get('content') || '';
    }

    const tagName = component.get ? component.get('tagName') || 'div' : 'div';
    const el = document.createElement(tagName);

    applyCleanComponentAttributes(component, el);

    const children = component.components ? component.components() : null;

    if (children && children.length) {

      let childrenHtml = '';

      children.each(function (child) {
        childrenHtml += getCleanComponentHtml(child);
      });

      el.innerHTML = childrenHtml;

    } else {

      el.innerHTML = component.getInnerHTML
        ? component.getInnerHTML()
        : '';

    }

    applyFinalComponentPropertiesToElement(component, el);
    removeEditorOnlyElements(el);
    removeEditorOnlyAttributes(el);

    return el.outerHTML;

  }

  function applyCleanComponentAttributes(component, el) {

    const attrs = component && component.getAttributes ? component.getAttributes() : {};
    const classes = component && component.getClasses ? component.getClasses() : [];
    const style = component && component.getStyle ? component.getStyle() : {};

    const finalClasses = sanitizeEditorClasses(classes);

    $.each(attrs || {}, function (key, value) {

      if (!key || key === 'class' || key === 'style') {
        return;
      }

      if (key.indexOf('data-automator-') === 0) {
        return;
      }

      if (key.indexOf('data-gjs-') === 0) {
        return;
      }

      if (value === null || typeof value === 'undefined') {
        return;
      }

      el.setAttribute(key, value);

    });

    if (finalClasses.length) {
      el.setAttribute('class', finalClasses.join(' '));
    }

    const styleString = objectToStyleString(style);

    if (styleString) {
      el.setAttribute('style', styleString);
    }

  }

  function applyFinalComponentPropertiesToElement(component, el) {

    if (!component || !el) {
      return;
    }

    const attrs = component.getAttributes ? component.getAttributes() : {};

    $.each(attrs, function (attrName, attrValue) {

      attrName = String(attrName || '');

      if (attrName.indexOf('data-automator-property-') !== 0) {
        return;
      }

      const propertyName = attrName.replace('data-automator-property-', '');

      if (isIgnoredFinalProperty(propertyName)) {
        return;
      }

      const realAttrName = getRealAttributeNameFromProperty(propertyName);

      if (!realAttrName) {
        return;
      }

      const value = attrValue === null || typeof attrValue === 'undefined'
        ? ''
        : String(attrValue);

      if (value === '') {
        el.removeAttribute(realAttrName);
        return;
      }

      el.setAttribute(realAttrName, value);

      if (realAttrName === 'target' && value === '_blank') {
        el.setAttribute('rel', 'noopener noreferrer');
      }

    });

  }

  function getRealAttributeNameFromRawProperty(component, propertyName) {

    const raw = getRawDataFromComponent(component);

    if (!raw || !raw.properties) {
      return '';
    }

    const parts = String(propertyName || '').split('.');
    const groupKey = parts[0] || '';
    const fieldKey = parts[1] || '';

    if (!groupKey || !fieldKey) {
      return '';
    }

    const group = raw.properties[groupKey];

    if (!group || !group.fields || !group.fields[fieldKey]) {
      return '';
    }

    const field = group.fields[fieldKey];

    if (field.attribute) {
      return String(field.attribute).toLowerCase();
    }

    if (field.attr) {
      return String(field.attr).toLowerCase();
    }

    if (field.html_attr) {
      return String(field.html_attr).toLowerCase();
    }

    const key = String(fieldKey || '').toLowerCase();
    const label = String(field.label || '').toLowerCase();

    if (
      key === 'href' ||
      key === 'url' ||
      key === 'link' ||
      key === 'link_url' ||
      key === 'link-url' ||
      label.indexOf('url') !== -1 ||
      label.indexOf('link') !== -1 ||
      label.indexOf('href') !== -1
    ) {
      return 'href';
    }

    if (
      key === 'src' ||
      key === 'image' ||
      key === 'imagem' ||
      label.indexOf('imagem') !== -1 ||
      label.indexOf('image') !== -1
    ) {
      return 'src';
    }

    return getRealAttributeNameFromProperty(propertyName);

  }

  function getRawDataFromComponent(component) {

    if (!component || !component.getAttributes) {
      return null;
    }

    const attrs = component.getAttributes();
    const fieldTypeID = attrs['data-automator-field-type-id'] || '';

    if (!fieldTypeID) {
      return null;
    }

    const componentData = getComponent(fieldTypeID);

    return componentData && componentData.raw
      ? componentData.raw
      : null;

  }

  function getRealAttributeNameFromProperty(propertyName) {

    const clean = String(propertyName || '').toLowerCase();
    const parts = clean.split('.');
    const last = parts[parts.length - 1];

    const map = {
      href: 'href',
      url: 'href',
      link: 'href',
      src: 'src',
      image: 'src',
      imagem: 'src',
      alt: 'alt',
      title: 'title',
      target: 'target',
      rel: 'rel',
      name: 'name',
      value: 'value',
      placeholder: 'placeholder',
      type: 'type',
      role: 'role',
      download: 'download',
      width: 'width',
      height: 'height',
      action: 'action',
      method: 'method',
      for: 'for'
    };

    return map[last] || '';

  }

  function removeEditorOnlyElements(el) {

    $(el).find('[data-automator-placeholder="true"]').remove();
    $(el).find('[data-automator-shortcode-preview="true"]').remove();

  }

  function removeEditorOnlyAttributes(el) {

    $(el).add($(el).find('*')).each(function () {

      const element = this;
      const attributes = Array.from(element.attributes || []);

      attributes.forEach(function (attr) {

        const name = attr.name;
        const value = attr.value;

        if (name.indexOf('data-automator-property-') === 0) {

          const propertyName = name.replace('data-automator-property-', '');

          if (!isIgnoredFinalProperty(propertyName)) {

            const realAttrName = getRealAttributeNameFromProperty(propertyName);

            if (realAttrName && String(value || '') !== '') {
              element.setAttribute(realAttrName, value);
            }

          }

          element.removeAttribute(name);

          return;

        }

        if (
          name.indexOf('data-gjs-') === 0 ||
          name.indexOf('data-automator-') === 0 ||
          name === 'contenteditable' ||
          name === 'draggable'
        ) {
          element.removeAttribute(name);
        }

      });

      if (element.hasAttribute('class')) {

        const classes = sanitizeEditorClasses(element.getAttribute('class'));

        if (classes.length) {
          element.setAttribute('class', classes.join(' '));
        } else {
          element.removeAttribute('class');
        }

      }

    });

  }

  function isIgnoredFinalProperty(propertyName) {

    propertyName = String(propertyName || '');

    return (
      propertyName === 'advanced.id' ||
      propertyName === 'advanced.class' ||
      propertyName === 'advanced.style' ||
      propertyName.indexOf('shortcode_params.') === 0 ||
      propertyName.indexOf('config.shortcode') === 0 ||
      propertyName.indexOf('config.pagination') === 0
    );

  }

  function normalizeFinalHtml(html) {

    const wrapper = document.createElement('div');

    wrapper.innerHTML = html || '';

    removeEditorOnlyElements(wrapper);
    removeEditorOnlyAttributes(wrapper);

    return wrapper.innerHTML;

  }

  function cleanShortcodeWrapperHtml(component) {

    return getShortcodeFinalHtml(component);

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

    return Object.entries(style)
      .filter(function (item) {
        return item && item[0] && item[1] !== null && typeof item[1] !== 'undefined' && String(item[1]) !== '';
      })
      .map(function (item) {
        return item[0] + ':' + item[1];
      })
      .join(';');

  }

  function updateStructureActiveItem(component) {

    $('.automator-editor-structure-item-wrapper').removeClass('is-selected');

    if (!component || !component.cid) {
      return;
    }

    $('.automator-editor-structure-item-wrapper[data-cid="' + component.cid + '"]').addClass('is-selected');

  }

  function switchLeftTab(tab) {

    if (state.previewMode) {
      return;
    }

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

    if (state.previewMode) {
      return;
    }

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

    syncEditorLayoutState();

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

    syncEditorLayoutState();

  }

  function updateLeftTabButtons(activeTab) {

    $('[data-automator-left-tab]').removeClass('is-active');

    if (!activeTab) {
      return;
    }

    $('[data-automator-left-tab="' + activeTab + '"]').addClass('is-active');

  }

  function setSaveState(enabled) {

    if (state.previewMode) {
      $(selectors.saveBtn).prop('disabled', true);
      return;
    }

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
        min-height: 72px !important;
      }

      .automator-editor-child-placeholder {
        width: 100%;
        min-height: 78px;
        border: 2px dashed #0d6efd;
        background: rgba(13, 110, 253, .075);
        color: #0d6efd;
        font-size: 26px;
        font-weight: 700;
        border-radius: 8px;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
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
        min-height: 58px;
      }

      .row {
        display: flex;
        flex-wrap: wrap;
      }

      .automator-editor-shortcode-preview {
        width: 100%;
        min-height: 54px;
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

      .gjs-placeholder {
        min-height: 74px !important;
        height: 74px !important;
        background: rgba(25, 135, 84, .16) !important;
        border: 3px dashed rgba(25, 135, 84, .85) !important;
        border-radius: 8px !important;
        box-sizing: border-box !important;
      }

      .gjs-placeholder-int {
        min-height: 68px !important;
        height: 68px !important;
        background: transparent !important;
      }

      .gjs-com-badge,
      .gjs-badge {
        z-index: 99999 !important;
      }

      body > div[data-gjs-type="wrapper"] {
        background: #ECECEC;
        padding: 24px !important;
        min-height: 520px !important;
      }
    `;

    doc.head.appendChild(style);

  }


  function focusRightSidebarTab(tabKey) {

    const tabs = $('#automator-editor-aside-right-tabs');

    if (!tabs.length) {
      return false;
    }

    let targetButton = null;
    let targetContainer = null;

    if (tabKey === 'block') {

      targetButton = $('#automator-editor-aside-right-tabs-button-block');
      targetContainer = $('#automator-editor-aside-right-tabs-container-block');

    } else {

      targetContainer = $('.automator-editor-aside-right-tabs-container-item[data-automator-default="true"]').first();

      if (!targetContainer.length) {
        targetContainer = $('.automator-editor-aside-right-tabs-container-item')
          .not('#automator-editor-aside-right-tabs-container-block')
          .first();
      }

      if (targetContainer.length) {

        const containerID = targetContainer.attr('id') || '';
        const tabID = containerID.replace(
          'automator-editor-aside-right-tabs-container-',
          ''
        );

        targetButton = $('#automator-editor-aside-right-tabs-button-' + tabID);

      }

    }

    if (!targetButton || !targetButton.length || !targetContainer || !targetContainer.length) {
      return false;
    }

    $('.automator-editor-aside-right-tabs-button').removeClass('active');
    $('.automator-editor-aside-right-tabs-container-item').removeClass('active');

    targetButton.addClass('active');
    targetContainer.addClass('active');

    return true;

  }

  function bindEditorGlobalTabFocus() {

    $(document)
      .off('mousedown.automator-editor-right-tab-focus')
      .on('mousedown.automator-editor-right-tab-focus', function (event) {

        if (state.previewMode) {
          return;
        }

        const target = $(event.target);

        if (!$('#automator-editor-modal').length) {
          return;
        }

        if (
          target.closest('#automator-editor-header').length ||
          target.closest(selectors.leftAside).length ||
          target.closest(selectors.rightAside).length ||
          target.closest(selectors.canvasContainer).length
        ) {
          return;
        }

        focusRightSidebarTab('page');

      });

  }

  function syncCanvasHeight() {

    const currentEditor = grapesEditor;

    if (
      !currentEditor ||
      !currentEditor.Canvas ||
      typeof currentEditor.Canvas.getFrameEl !== 'function' ||
      typeof currentEditor.Canvas.getBody !== 'function'
    ) {
      return;
    }

    setTimeout(function () {

      if (
        !currentEditor ||
        currentEditor !== grapesEditor ||
        !currentEditor.Canvas ||
        typeof currentEditor.Canvas.getFrameEl !== 'function' ||
        typeof currentEditor.Canvas.getBody !== 'function'
      ) {
        return;
      }

      const frameEl = currentEditor.Canvas.getFrameEl();
      const frameBody = currentEditor.Canvas.getBody();

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

      if (
        currentEditor === grapesEditor &&
        typeof currentEditor.refresh === 'function'
      ) {
        currentEditor.refresh();
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

      let targetSelector = source.attr('data-automator-sync-slug-field');

      if (!targetSelector) {
          return;
      }

      const checkbox = $('#' + source.attr('id') + '-sync');

      if (!checkbox.length || !checkbox.prop('checked')) {
          return;
      }

      let target;

      // foi informado um seletor CSS (#id, .classe, etc)
      if (
          targetSelector.startsWith('#') ||
          targetSelector.startsWith('.') ||
          targetSelector.startsWith('[')
      ) {

          target = $(targetSelector).first();

      } else {

          // foi informado apenas o name/id
          target = $('[name="' + targetSelector + '"], #' + targetSelector).first();

      }

      if (!target.length) {
          return;
      }

      target
          .val(stringToSlug(source.val()))
          .trigger('input')
          .trigger('change');

  }

  function bindHeaderSlugSync() {

    $('[data-automator-sync-slug-field]').each(function () {

      const input = $(this);
      const checkbox = $('#' + input.attr('id') + '-sync');

      input.off('.automator-header-slug-sync');
      checkbox.off('.automator-header-slug-sync');

      input.on('input.automator-header-slug-sync keyup.automator-header-slug-sync change.automator-header-slug-sync', function () {
        syncHeaderInputSlug(this);
      });

      checkbox.on('change.automator-header-slug-sync', function () {
        if ($(this).prop('checked')) {
          syncHeaderInputSlug(input[0]);
        }
      });

    });

  }

  function bindPageSettingsChangeObserver() {

    /*
    |--------------------------------------------------------------------------
    | Campos que pertencem às configurações da página
    |--------------------------------------------------------------------------
    |
    | O evento é delegado porque alguns desses campos podem ser renderizados
    | dinamicamente na sidebar direita depois que o editor foi iniciado.
    |
    */

    const selector =
      '#automator-editor-modal ' +
      'input[name^="tbl_sys_route_"], ' +

      '#automator-editor-modal ' +
      'select[name^="tbl_sys_route_"], ' +

      '#automator-editor-modal ' +
      'textarea[name^="tbl_sys_route_"], ' +

      '#automator-editor-modal ' +
      '[data-automator-field-name^="tbl_sys_route_"]';


    /*
    |--------------------------------------------------------------------------
    | Remove somente os eventos deste observador
    |--------------------------------------------------------------------------
    */

    $(document).off(
      '.automator-editor-page-settings',
      selector
    );


    /*
    |--------------------------------------------------------------------------
    | Registra alterações feitas pelo usuário
    |--------------------------------------------------------------------------
    */

    $(document).on(
      'input.automator-editor-page-settings ' +
      'change.automator-editor-page-settings ' +
      'keyup.automator-editor-page-settings',
      selector,
      function(event) {

        const field = event.currentTarget;

        if (!field) {
          return;
        }


        /*
        |--------------------------------------------------------------------------
        | Ignora os campos ocultos do formulário interno de envio
        |--------------------------------------------------------------------------
        |
        | Esses campos são sincronizados programaticamente antes do submit e não
        | representam uma interação direta do usuário.
        |
        */

        if (
          field.closest &&
          field.closest(
            '#automator-editor-change-observer-form'
          )
        ) {
          return;
        }


        /*
        |--------------------------------------------------------------------------
        | Ignora alterações durante o carregamento inicial
        |--------------------------------------------------------------------------
        */

        if (!state.initialized) {
          return;
        }


        /*
        |--------------------------------------------------------------------------
        | Registra a modificação no mesmo estado usado pelo GrapesJS
        |--------------------------------------------------------------------------
        */

        markEditorAsChanged();

      }
    );


    return true;

  }

  function ensureStructureDropStyles() {

    if (document.getElementById('automator-editor-structure-drop-styles')) {
      return;
    }

    const style = document.createElement('style');
    style.id = 'automator-editor-structure-drop-styles';

    style.innerHTML = `
      .automator-editor-structure-children {
        min-height: 44px !important;
        padding-top: 6px !important;
        padding-bottom: 6px !important;
        box-sizing: border-box !important;
      }

      .automator-editor-structure-children:empty {
        min-height: 54px !important;
        border: 1px dashed rgba(13, 110, 253, .35);
        background: rgba(13, 110, 253, .035);
      }

      .automator-editor-structure-sortable-ghost {
        min-height: 54px !important;
        border: 2px dashed rgba(25, 135, 84, .85) !important;
        background: rgba(25, 135, 84, .14) !important;
        opacity: 1 !important;
        border-radius: 6px !important;
      }

      .automator-editor-structure-sortable-chosen {
        background: rgba(13, 110, 253, .08) !important;
      }

      .automator-editor-structure-sortable-drag {
        min-height: 54px !important;
        opacity: .85 !important;
      }

      .automator-editor-body-aside-left-structure-item {
        min-height: 50px !important;
        padding-top: 12px !important;
        padding-bottom: 12px !important;
      }
    `;

    document.head.appendChild(style);

  }


  function getCurrentEditorViewState() {

    const selected = grapesEditor ? grapesEditor.getSelected() : null;

    return {
      leftActiveTab: $(selectors.leftAside).attr('data-active-tab') || 'inserter',
      leftCollapsed: $(selectors.leftAside).hasClass('is-collapsed'),
      leftShow: $(selectors.leftAside).hasClass('show'),
      rightCollapsed: $(selectors.rightAside).hasClass('is-collapsed'),
      rightShow: $(selectors.rightAside).hasClass('show'),
      rightActiveTabButton: $('.automator-editor-aside-right-tabs-button.active').attr('id') || '',
      rightActiveTabContainer: $('.automator-editor-aside-right-tabs-container-item.active').attr('id') || '',
      selectedCid: selected ? selected.cid : null
    };

  }

  function restoreEditorViewState(restoreState = null) {

    if (!restoreState) {
      return;
    }

    updateLeftTabVisibility(restoreState.leftActiveTab || 'inserter');

    if (window.innerWidth <= 991.98) {

      $(selectors.leftAside)
        .toggleClass('show', restoreState.leftShow === true)
        .removeClass('is-collapsed');

      $(selectors.rightAside)
        .toggleClass('show', restoreState.rightShow === true)
        .toggleClass('is-collapsed', restoreState.rightCollapsed === true);

    } else {

      $(selectors.leftAside)
        .removeClass('show')
        .toggleClass('is-collapsed', restoreState.leftCollapsed === true);

      $(selectors.rightAside)
        .removeClass('show')
        .toggleClass('is-collapsed', restoreState.rightCollapsed === true);

    }

    if (restoreState.rightActiveTabButton && restoreState.rightActiveTabContainer) {

      $('.automator-editor-aside-right-tabs-button').removeClass('active');
      $('.automator-editor-aside-right-tabs-container-item').removeClass('active');

      $('#' + restoreState.rightActiveTabButton).addClass('active');
      $('#' + restoreState.rightActiveTabContainer).addClass('active');

    }

    if (grapesEditor && restoreState.selectedCid) {

      const component = findComponentByCid(restoreState.selectedCid);

      if (component) {

        setTimeout(function () {

          grapesEditor.select(component);
          renderComponentSettings(component);
          updateStructureActiveItem(component);

        }, 50);

      }

    }

    syncEditorLayoutState();

  }


  function getEditorChangeObserverForm() {

    const modalEl = document.getElementById('automator-editor-modal');

    if (!modalEl) {
      return null;
    }

    let formEl = document.getElementById('automator-editor-change-observer-form');

    if (!formEl) {

      formEl = document.createElement('form');

      formEl.id = 'automator-editor-change-observer-form';
      formEl.setAttribute('data-submit', 'false');
      formEl.setAttribute('autocomplete', 'off');
      formEl.style.display = 'none';

      const textarea = document.createElement('textarea');

      textarea.name = 'automator_editor_state';
      textarea.id = 'automator-editor-change-observer-state';

      formEl.appendChild(textarea);
      modalEl.appendChild(formEl);

    }

    return formEl;

  }


  function serializeEditorCurrentState() {

    const response = {
      html: '',
      css: '',
      components: [],
      fields: []
    };

    if (grapesEditor) {

      response.html = normalizeFinalHtml(cleanEditorHtml(''));
      response.css = grapesEditor.getCss();
      response.components = grapesEditor.getComponents().toJSON();

    }

    $('#automator-editor-modal')
      .find('input, textarea, select')
      .not('#automator-editor-change-observer-form input, #automator-editor-change-observer-form textarea, #automator-editor-change-observer-form select')
      .each(function () {

        const field = this;
        const name = field.getAttribute('name') || field.getAttribute('id') || '';

        if (!name || field.disabled) {
          return;
        }

        const type = String(field.getAttribute('type') || '').toLowerCase();

        if (type === 'checkbox' || type === 'radio') {

          response.fields.push({
            name: name,
            value: field.value,
            checked: field.checked ? 1 : 0
          });

        } else {

          response.fields.push({
            name: name,
            value: field.value
          });

        }

      });

    return JSON.stringify(response);

  }


  function syncEditorChangeObserverState(updateInitialState = false) {

    const formEl = getEditorChangeObserverForm();

    if (!formEl) {
      return false;
    }

    const field = formEl.querySelector('#automator-editor-change-observer-state');

    if (!field) {
      return false;
    }

    field.value = serializeEditorCurrentState();

    if (updateInitialState === true) {

      if (typeof AutomatorInitModalFormChangeObserver === 'function') {

        AutomatorInitModalFormChangeObserver(
          document.getElementById('automator-editor-modal'),
          formEl,
          null
        );

      } else {

        formEl.setAttribute(
          'data-automator-initial-state',
          typeof AutomatorFormSerializeCurrentState === 'function'
            ? AutomatorFormSerializeCurrentState(formEl)
            : field.value
        );

        formEl.setAttribute('data-automator-form-changed', 'false');

      }

    } else {

      field.dispatchEvent(new Event('input', { bubbles: true }));
      field.dispatchEvent(new Event('change', { bubbles: true }));

      if (typeof AutomatorUpdateModalFormChangedStatus === 'function') {
        AutomatorUpdateModalFormChangedStatus(formEl, null);
      } else {
        formEl.setAttribute('data-automator-form-changed', 'true');
      }

    }

    return true;

  }

  function resetEditorChangeObserverState() {

    const formEl =
      getEditorChangeObserverForm();


    /*
    |--------------------------------------------------------------------------
    | Redefine o estado principal do editor
    |--------------------------------------------------------------------------
    */

    state.hasChanges = false;

    setSaveState(false);


    if (!formEl) {
      return false;
    }


    /*
    |--------------------------------------------------------------------------
    | Atualiza o conteúdo inicial utilizado para comparação
    |--------------------------------------------------------------------------
    */

    syncEditorChangeObserverState(true);


    /*
    |--------------------------------------------------------------------------
    | Garante que o formulário seja considerado inalterado
    |--------------------------------------------------------------------------
    */

    formEl.setAttribute(
      'data-automator-form-changed',
      'false'
    );


    /*
    |--------------------------------------------------------------------------
    | Atualiza manualmente o estado inicial após todos os campos carregarem
    |--------------------------------------------------------------------------
    */

    if (
      typeof AutomatorFormSerializeCurrentState ===
      'function'
    ) {

      formEl.setAttribute(
        'data-automator-initial-state',
        AutomatorFormSerializeCurrentState(
          formEl
        )
      );

    }


    return true;

  }

  function markEditorAsChanged() {

    /*
    |--------------------------------------------------------------------------
    | Não registra modificações durante a inicialização
    |--------------------------------------------------------------------------
    */

    if (!state.initialized) {
      return false;
    }


    /*
    |--------------------------------------------------------------------------
    | O preview não permite edição
    |--------------------------------------------------------------------------
    */

    if (state.previewMode) {
      return false;
    }


    /*
    |--------------------------------------------------------------------------
    | Atualiza o estado geral
    |--------------------------------------------------------------------------
    */

    state.hasChanges = true;


    /*
    |--------------------------------------------------------------------------
    | Habilita o botão Criar/Salvar
    |--------------------------------------------------------------------------
    */

    setSaveState(true);


    /*
    |--------------------------------------------------------------------------
    | Atualiza o observador de saída do modal/página
    |--------------------------------------------------------------------------
    */

    syncEditorChangeObserverState(false);


    return true;

  }

  function syncEditorRouteFieldsToForm(formEl) {

    if (!formEl) {
      return false;
    }

    const editorModal =
      document.getElementById('automator-editor-modal') ||
      formEl.closest('.modal') ||
      document;

    const fields = [
      'tbl_sys_route_ID',
      'tbl_sys_route_title',
      'tbl_sys_route_name',
      'tbl_sys_route_permalink',
      'tbl_sys_route_api',
      'tbl_sys_route_admin',
      'tbl_sys_route_locked',
      'tbl_sys_route_type',
      'tbl_sys_route_controller',
      'tbl_sys_route_method',
      'tbl_sys_route_args',
      'tbl_sys_route_description',
      'tbl_sys_route_area',
      'tbl_sys_route_status',
      'tbl_sys_route_parent_id'
    ];

    fields.forEach(function(fieldName) {

      /*
      |--------------------------------------------------------------------------
      | O ID da rota já é definido pelo onclick/callback da paginação
      |--------------------------------------------------------------------------
      |
      | Não devemos buscá-lo novamente usando document.querySelector(), pois
      | poderia ser encontrado outro elemento fora do editor e sobrescrever o
      | ID numérico correto.
      |
      */

      if (fieldName === 'tbl_sys_route_ID') {

        const currentIDField =
          formEl.querySelector(
            'input[type="hidden"][name="tbl_sys_route_ID"]'
          );

        if (!currentIDField) {
          return;
        }

        const currentID =
          String(currentIDField.value || '').trim();

        /*
        |--------------------------------------------------------------------------
        | Preserva somente um ID válido
        |--------------------------------------------------------------------------
        */

        if (
          currentID !== '' &&
          /^\d+$/.test(currentID)
        ) {

          setEditorSubmitHiddenInput(
            formEl,
            'tbl_sys_route_ID',
            currentID
          );

        }

        return;

      }

      /*
      |--------------------------------------------------------------------------
      | Procura o campo somente dentro do editor
      |--------------------------------------------------------------------------
      */

      let field =
        editorModal.querySelector(
          '[name="' + fieldName + '"]:not([type="hidden"])'
        ) ||
        editorModal.querySelector(
          '#' + fieldName
        );

      /*
      |--------------------------------------------------------------------------
      | Fallback para campos hidden reais de configurações
      |--------------------------------------------------------------------------
      */

      if (!field) {

        field =
          editorModal.querySelector(
            '[name="' + fieldName + '"]'
          );

      }

      if (!field) {
        return;
      }

      /*
      |--------------------------------------------------------------------------
      | Evita utilizar o próprio campo hidden do formulário como origem
      |--------------------------------------------------------------------------
      */

      if (
        field.form === formEl &&
        field.type === 'hidden'
      ) {
        return;
      }

      let value = '';

      const type =
        String(
          field.getAttribute('type') || ''
        ).toLowerCase();

      if (type === 'checkbox') {

        value =
          field.checked
            ? (field.value || '1')
            : '0';

      } else if (type === 'radio') {

        const checked =
          editorModal.querySelector(
            '[name="' + fieldName + '"]:checked'
          );

        if (!checked) {
          return;
        }

        value =
          checked.value;

      } else {

        value =
          field.value;

      }

      setEditorSubmitHiddenInput(
        formEl,
        fieldName,
        value
      );

    });

    return true;

  }


  return {
    config,
    init,
    destroy,
    initInterface,

    focusRightSidebarTab,
    bindEditorGlobalTabFocus,

    bindPageSettingsChangeObserver,

    markEditorAsChanged,
    resetEditorChangeObserverState,
    syncEditorChangeObserverState,
    getCurrentEditorViewState,
    restoreEditorViewState,
    ensureStructureDropStyles,

    getEditorSubmitContentData,
    syncEditorSubmitContentToForm,
    syncEditorRouteFieldsToForm,
    getEditorSubmitForm,

    waitEditorReady,

    stringToSlug,
    syncHeaderInputSlug,
    bindHeaderSlugSync,

    loadSidebarComponents,

    insertField: injectBlock,
    injectBlock,

    togglePreviewMode,
    setPreviewMode,

    setViewportMode,
    syncCanvasDeviceViewport,

    switchLeftTab,
    updateLeftTabVisibility,
    toggleSidebar,

    saveContent,
    updateStructureList,

    applySelectedComponentSettings,
    deleteSelectedComponent,

    discardEditorUnsavedChanges,

    rehydrateLoadedEditorComponents,
    prepareSavedPageContentForEditor,

    getEditor,
    getComponent,
    getComponents
  };

})();