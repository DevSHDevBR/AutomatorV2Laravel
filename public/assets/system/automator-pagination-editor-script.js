/*

  +--------------------------------------------+
  |         Automator Pagination Editor        |
  |--------------------------------------------+
  |                                            |
  | Editor visual exclusivo para paginações.   |
  |                                            |
  +--------------------------------------------+

*/

window.SysAutomatorPaginationEditor = (function () {


  const defaultState = {

    isNew:                  true,
    initialized:            false,
    suppressChangeTracking: true,
    hasChanges:             false,
    tableLoading:           false,
    columnsLoading:         false,
    selectedTable:          '',
    selectedIndex:          '',
    selectedColumnID:       '',
    activeLeftTab:          'structure',
    activeRightPanel:       'pagination',
    activeRightTab:         'pagination-settings',
    structureSortable:      null,

    paginationID:           '',
    acao:                   'store',

    recordData:             {},
    editorResponse:         {},

    userTypes:              [],
    developerUserTypeID:    null,
    currentUserIsDeveloper: false,

    applyingRecordData:     false,
    submitting:             false,

    actionBuilderForms:          {},
    actionBuilderAvailableForms: [],

    validation: {

      valid:  false,
      errors: [],

    },
    headerButtonsSortable:    null,
    actionButtonsSortable:    null,

    paginationButtons: {

      header: [],

      actions: [],

    },

  };


  let state = $.extend(true, {}, defaultState);


  const selectors = {

    editor: '#automator-pagination-editor-modal',

    body: '#automator-pagination-editor-body',

    table: '#tbl_sys_pagination_table',

    index: '#tbl_sys_pagination_index',

    leftAside: '#automator-pagination-editor-aside-left',

    rightAside: '#automator-pagination-editor-aside-right',

    inserterPanel: '#automator-pagination-editor-aside-left-inserter',

    structurePanel: '#automator-pagination-editor-aside-left-structure',

    buttonsPanel: '#automator-pagination-editor-aside-left-buttons',

    inserterList: '#automator-pagination-editor-aside-left-inserter-list',

    structureList: '#automator-pagination-editor-aside-left-structure-list',

    buttonsContainer: '#automator-pagination-editor-aside-left-buttons-accordions',

    leftActionButton: '.automator-pagination-editor-actions-btn',

    inserterButton: '[data-automator-pagination-left-tab="inserter"]',

    structureButton: '[data-automator-pagination-left-tab="structure"]',

    buttonsButton: '[data-automator-pagination-left-tab="buttons"]',

    paginationPanel: '#automator-pagination-editor-aside-right-pagination',

    proprietiesPanel: '#automator-pagination-editor-aside-right-proprieties',

    paginationButton: '#automator-pagination-editor-header-pagination-btn',

    proprietiesButton: '#automator-pagination-editor-header-proprieties-btn',

    saveButton: '#automator-pagination-editor-header-save-btn',

    rightTabButton: '.automator-pagination-editor-aside-right-tabs-button',

    rightTabContainer: '.automator-pagination-editor-aside-right-tabs-container-item',

    settingsTabButton: '#automator-pagination-editor-aside-right-tabs-button-pagination-settings',

    actionsTabButton: '#automator-pagination-editor-aside-right-tabs-button-pagination-actions',

    actionsTabContainer: '#automator-pagination-editor-aside-right-tabs-container-pagination-actions',

    addButton: '.automator-pagination-editor-buttons-accordions-add',

    tooltipWrapper: '[data-automator-pagination-tooltip]',

  };

  /*
  |--------------------------------------------------------------------------
  | Normaliza a ação de envio do editor
  |--------------------------------------------------------------------------
  */

  function normalizePaginationEditorSubmitAction(
    action = '',
    isNew = null
  ) {


    action = String(

      action || ''

    )
      .trim()
      .toLowerCase();


    const actionAliases = {

      add:    'add',
      create: 'add',
      store:  'add',

      edit:   'edit',
      update: 'edit',

    };


    if(
      Object.prototype.hasOwnProperty.call(

        actionAliases,

        action

      )
    ) {

      return actionAliases[action];

    }


    if(isNew === null) {

      isNew = state.isNew;

    }


    return AutomatorNormalizeBoolean(

      isNew

    ) === true

      ? 'add'

      : 'edit';


  }


  /*
  |--------------------------------------------------------------------------
  | Configuração
  |--------------------------------------------------------------------------
  */

  function config(data = {}, callback = null) {


    destroy(false);


    state = $.extend(

      true,

      {},

      defaultState

    );


    data = normalizePlainObject(data);


    state.isNew = data.isNew !== false;


    state.paginationID = String(

      data.paginationID ||

      data.pagination_id ||

      data.tbl_sys_pagination_ID ||

      data.id ||

      ''

    ).trim();


    if(state.paginationID != '') {

      state.isNew = false;

    }


    state.acao = normalizePaginationEditorSubmitAction(

      data.acao ||

      data.editorAction ||

      data.submitAction ||

      '',

      state.isNew

    );


    state.recordData = normalizePlainObject(

      data.recordData ||

      data.record_data ||

      {}

    );


    state.editorResponse = normalizePlainObject(

      data.editorResponse ||

      data.editor_response ||

      {}

    );


    /*
    |--------------------------------------------------------------------------
    | Carrega os tipos de usuário antes de inicializar o editor
    |--------------------------------------------------------------------------
    */


    applyPaginationEditorSecurityResponse(

      state.editorResponse

    );


    applyPaginationEditorSecurityResponse(

      normalizePlainObject(

        state.editorResponse.data

      )

    );


    applyPaginationEditorSecurityResponse(

      normalizePlainObject(

        state.editorResponse.dados

      )

    );


    applyPaginationEditorSecurityResponse(

      state.recordData

    );


    /*
    |--------------------------------------------------------------------------
    | Carrega os formulários auxiliares do editor de ações
    |--------------------------------------------------------------------------
    */


    applyPaginationButtonActionBuilderResponse(

      state.editorResponse

    );


    applyPaginationButtonActionBuilderResponse(

      normalizePlainObject(

        state.editorResponse.data

      )

    );


    applyPaginationButtonActionBuilderResponse(

      normalizePlainObject(

        state.editorResponse.dados

      )

    );


    applyPaginationButtonActionBuilderResponse(

      state.recordData

    );


    clearUnsavedChangesWarning();


    if(typeof callback === 'function') {

      callback();

    }


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza um formulário auxiliar do editor de ações
  |--------------------------------------------------------------------------
  */


  function normalizePaginationButtonActionBuilderFormData(
    formData = {}
  ) {


    formData = normalizePlainObject(

      formData

    );


    const formID = String(

      formData.id ||

      formData.formID ||

      formData.form_id ||

      formData.tbl_sys_form_ID ||

      ''

    ).trim();


    const formName = String(

      formData.name ||

      formData.formName ||

      formData.form_name ||

      formData.tbl_sys_form_name ||

      ''

    ).trim();


    const formTitle = String(

      formData.title ||

      formData.formTitle ||

      formData.form_title ||

      formData.tbl_sys_form_title ||

      ''

    ).trim();


    if(
      formID == '' &&
      formName == ''
    ) {

      return {};

    }


    return {

      id: formID,

      name: formName,

      title: formTitle,

      tbl_sys_form_ID: formID,

      tbl_sys_form_name: formName,

      tbl_sys_form_title: formTitle,

    };


  }


  /*
  |--------------------------------------------------------------------------
  | Retorna o tipo do construtor pelo nome do formulário
  |--------------------------------------------------------------------------
  */


  function getPaginationButtonActionBuilderModeByFormName(
    formName = ''
  ) {


    formName = String(

      formName || ''

    )
      .trim()
      .toLowerCase();


    const formNames = {

      'admin-open-form-modal': 'modal-form',

      'admin-open-view-modal': 'modal-view',

    };


    if(
      Object.prototype.hasOwnProperty.call(

        formNames,

        formName

      )
    ) {

      return formNames[formName];

    }


    return '';


  }


  /*
  |--------------------------------------------------------------------------
  | Registra um formulário auxiliar
  |--------------------------------------------------------------------------
  */


  function registerPaginationButtonActionBuilderForm(
    mode = '',
    formData = {}
  ) {


    mode = String(

      mode || ''

    ).trim();


    formData = normalizePaginationButtonActionBuilderFormData(

      formData

    );


    if(mode == '') {


      mode = getPaginationButtonActionBuilderModeByFormName(

        formData.name ||

        ''

      );


    }


    if(
      mode != 'modal-form' &&
      mode != 'modal-view'
    ) {

      return false;

    }


    if(
      String(
        formData.id || ''
      ).trim() == ''
    ) {

      return false;

    }


    state.actionBuilderForms[mode] = $.extend(

      true,

      {},

      state.actionBuilderForms[mode] || {},

      formData

    );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Registra a lista de formulários disponíveis
  |--------------------------------------------------------------------------
  */


  function registerPaginationButtonActionBuilderAvailableForms(
    availableForms = []
  ) {


    if(
      availableForms &&
      typeof availableForms === 'object' &&
      !Array.isArray(availableForms)
    ) {

      availableForms = Object.keys(

        availableForms

      ).map(function(formKey) {


        const formData = normalizePlainObject(

          availableForms[formKey]

        );


        if(
          !formData.name &&
          !formData.tbl_sys_form_name
        ) {

          formData.name = formKey;

        }


        return formData;


      });

    }


    if(!Array.isArray(availableForms)) {

      return false;

    }


    availableForms.forEach(function(formData) {


      formData = normalizePaginationButtonActionBuilderFormData(

        formData

      );


      if(
        String(
          formData.id || ''
        ).trim() == '' &&
        String(
          formData.name || ''
        ).trim() == ''
      ) {

        return;

      }


      const existingIndex =

        state.actionBuilderAvailableForms
          .findIndex(function(existingFormData) {


            existingFormData =

              normalizePaginationButtonActionBuilderFormData(

                existingFormData

              );


            if(
              formData.id != '' &&
              existingFormData.id == formData.id
            ) {

              return true;

            }


            return (

              formData.name != '' &&
              existingFormData.name == formData.name

            );


          });


      if(existingIndex >= 0) {


        state.actionBuilderAvailableForms[existingIndex] =

          $.extend(

            true,

            {},

            state.actionBuilderAvailableForms[existingIndex],

            formData

          );


      } else {


        state.actionBuilderAvailableForms.push(

          formData

        );


      }


      registerPaginationButtonActionBuilderForm(

        '',

        formData

      );


    });


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Reconstrói o mapa dos formulários auxiliares
  |--------------------------------------------------------------------------
  */


  function resolvePaginationButtonActionBuilderForms() {


    registerPaginationButtonActionBuilderAvailableForms(

      state.actionBuilderAvailableForms

    );


    Object.keys(

      state.actionBuilderForms

    ).forEach(function(mode) {


      registerPaginationButtonActionBuilderForm(

        mode,

        state.actionBuilderForms[mode]

      );


    });


    return (

      String(

        normalizePlainObject(

          state.actionBuilderForms['modal-form']

        ).id || ''

      ).trim() != '' ||

      String(

        normalizePlainObject(

          state.actionBuilderForms['modal-view']

        ).id || ''

      ).trim() != ''

    );


  }



  /*
  |--------------------------------------------------------------------------
  | Configuração dos formulários auxiliares das ações dos botões
  |--------------------------------------------------------------------------
  */


  function applyPaginationButtonActionBuilderResponse(
    response = {}
  ) {


    response = normalizePlainObject(

      response

    );


    const sources = [];


    function addSource(source = {}) {


      source = normalizePlainObject(

        source

      );


      if(
        Object.keys(
          source
        ).length <= 0
      ) {

        return;

      }


      sources.push(

        source

      );


    }


    addSource(

      response

    );


    addSource(

      response.paginationActionBuilder

    );


    addSource(

      response.pagination_action_builder

    );


    addSource(

      response.actionBuilder

    );


    addSource(

      response.action_builder

    );


    addSource(

      response.data

    );


    addSource(

      response.dados

    );


    const responseData = normalizePlainObject(

      response.data

    );


    addSource(

      responseData.paginationActionBuilder

    );


    addSource(

      responseData.pagination_action_builder

    );


    addSource(

      responseData.actionBuilder

    );


    addSource(

      responseData.action_builder

    );


    const responseDados = normalizePlainObject(

      response.dados

    );


    addSource(

      responseDados.paginationActionBuilder

    );


    addSource(

      responseDados.pagination_action_builder

    );


    addSource(

      responseDados.actionBuilder

    );


    addSource(

      responseDados.action_builder

    );


    sources.forEach(function(source) {


      source = normalizePlainObject(

        source

      );


      const builderForms = normalizePlainObject(

        source.forms ||

        source.builderForms ||

        source.builder_forms ||

        source.actionBuilderForms ||

        source.action_builder_forms ||

        {}

      );


      Object.keys(

        builderForms

      ).forEach(function(builderFormKey) {


        const builderForm = normalizePlainObject(

          builderForms[builderFormKey]

        );


        let builderMode = String(

          builderFormKey || ''

        ).trim();


        if(
          builderMode != 'modal-form' &&
          builderMode != 'modal-view'
        ) {

          builderMode =

            getPaginationButtonActionBuilderModeByFormName(

              builderForm.name ||

              builderForm.tbl_sys_form_name ||

              builderFormKey

            );

        }


        registerPaginationButtonActionBuilderForm(

          builderMode,

          builderForm

        );


      });


      const directBuilderForms = [

        source.modalForm,

        source.modal_form,

        source.formModal,

        source.form_modal,

      ];


      directBuilderForms.forEach(function(builderForm) {


        registerPaginationButtonActionBuilderForm(

          'modal-form',

          builderForm

        );


      });


      const directViewBuilderForms = [

        source.modalView,

        source.modal_view,

        source.viewModal,

        source.view_modal,

      ];


      directViewBuilderForms.forEach(function(builderForm) {


        registerPaginationButtonActionBuilderForm(

          'modal-view',

          builderForm

        );


      });


      const availableForms =

        source.availableForms ||

        source.available_forms ||

        source.formsAvailable ||

        source.forms_available ||

        source.allForms ||

        source.all_forms ||

        source.formsList ||

        source.forms_list ||

        [];


      registerPaginationButtonActionBuilderAvailableForms(

        availableForms

      );


    });


    resolvePaginationButtonActionBuilderForms();


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Retorna o formulário auxiliar de uma ação
  |--------------------------------------------------------------------------
  */


  function getPaginationButtonActionBuilderForm(
    mode = ''
  ) {


    mode = String(

      mode || ''

    ).trim();


    resolvePaginationButtonActionBuilderForms();


    let builderForm =

      normalizePaginationButtonActionBuilderFormData(

        state.actionBuilderForms[mode]

      );


    if(
      String(
        builderForm.id || ''
      ).trim() != ''
    ) {

      return builderForm;

    }


    const expectedFormName =

      mode == 'modal-form'

        ? 'admin-open-form-modal'

        : mode == 'modal-view'

          ? 'admin-open-view-modal'

          : '';


    if(expectedFormName == '') {

      return {};

    }


    state.actionBuilderAvailableForms
      .some(function(formData) {


        formData = normalizePaginationButtonActionBuilderFormData(

          formData

        );


        if(
          String(
            formData.name || ''
          ).trim() != expectedFormName
        ) {

          return false;

        }


        builderForm = formData;


        registerPaginationButtonActionBuilderForm(

          mode,

          formData

        );


        return true;


      });


    return builderForm;


  }

  /*
  |--------------------------------------------------------------------------
  | Detecta o tipo de ação pelo conteúdo atual do onclick
  |--------------------------------------------------------------------------
  */


  function detectPaginationButtonClickMode(
    onclickValue = ''
  ) {


    onclickValue = String(

      onclickValue || ''

    ).trim();


    if(onclickValue == '') {

      return '';

    }


    if(
      onclickValue.indexOf(
        'AutomatorPaginationCreateModalForm'
      ) >= 0
    ) {

      return 'modal-form';

    }


    if(
      onclickValue.indexOf(
        'AutomatorCreateViewModal'
      ) >= 0
    ) {

      return 'modal-view';

    }


    return 'manual';


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza tamanho utilizado pelos dois tipos de modal
  |--------------------------------------------------------------------------
  */


  function normalizePaginationButtonModalSize(
    size = 'lg'
  ) {


    size = String(

      size || ''

    ).trim();


    size = size.replace(

      /^modal-/,

      ''

    );


    const allowedSizes = [

      'sm',
      'md',
      'lg',
      'xl',
      'fullscreen',
      'fullscreen-sm-down',
      'fullscreen-md-down',
      'fullscreen-lg-down',
      'fullscreen-xl-down',
      'fullscreen-xxl-down',

    ];


    if(
      allowedSizes.indexOf(
        size
      ) < 0
    ) {

      return 'lg';

    }


    return size;


  }


  /*
  |--------------------------------------------------------------------------
  | Escapa texto para string JavaScript
  |--------------------------------------------------------------------------
  */


  function escapePaginationButtonJavascriptString(
    value = ''
  ) {


    return String(

      value === null ||
      value === undefined

        ? ''

        : value

    )
      .replace(
        /\\/g,
        '\\\\'
      )
      .replace(
        /'/g,
        "\\'"
      )
      .replace(
        /\r/g,
        '\\r'
      )
      .replace(
        /\n/g,
        '\\n'
      );


  }


  /*
  |--------------------------------------------------------------------------
  | Retorna o ID de um formulário a partir do nome
  |--------------------------------------------------------------------------
  */


  function getPaginationButtonFormIDByName(
    formName = ''
  ) {


    formName = String(

      formName || ''

    ).trim();


    if(formName == '') {

      return '';

    }


    let formID = '';


    state.actionBuilderAvailableForms
      .some(function(formData) {


        formData = normalizePlainObject(

          formData

        );


        const currentName = String(

          formData.name ||

          formData.tbl_sys_form_name ||

          ''

        ).trim();


        if(currentName != formName) {

          return false;

        }


        formID = String(

          formData.id ||

          formData.tbl_sys_form_ID ||

          ''

        ).trim();


        return true;


      });


    return formID;


  }


  /*
  |--------------------------------------------------------------------------
  | Retorna o nome de um formulário a partir do ID
  |--------------------------------------------------------------------------
  */


  function getPaginationButtonFormNameByID(
    formID = ''
  ) {


    formID = String(

      formID || ''

    ).trim();


    if(formID == '') {

      return '';

    }


    let formName = '';


    state.actionBuilderAvailableForms
      .some(function(formData) {


        formData = normalizePlainObject(

          formData

        );


        const currentID = String(

          formData.id ||

          formData.tbl_sys_form_ID ||

          ''

        ).trim();


        if(currentID != formID) {

          return false;

        }


        formName = String(

          formData.name ||

          formData.tbl_sys_form_name ||

          ''

        ).trim();


        return true;


      });


    return formName;


  }


  /*
  |--------------------------------------------------------------------------
  | Retorna a ação configurada para uma rota
  |--------------------------------------------------------------------------
  */


  function getPaginationButtonActionNameByRoute(
    routeName = ''
  ) {


    routeName = String(

      routeName || ''

    ).trim();


    if(routeName == '') {

      return '';

    }


    const actions = getActionsData();


    let actionName = '';


    Object.keys(

      actions

    ).some(function(currentActionName) {


      const actionData = normalizePlainObject(

        actions[currentActionName]

      );


      if(
        String(
          actionData.route || ''
        ).trim() != routeName
      ) {

        return false;

      }


      actionName = String(

        currentActionName

      ).trim();


      return true;


    });


    return actionName;


  }


  /*
  |--------------------------------------------------------------------------
  | Retorna a rota configurada para uma ação
  |--------------------------------------------------------------------------
  */


  function getPaginationButtonRouteByActionName(
    actionName = ''
  ) {


    actionName = String(

      actionName || ''

    ).trim();


    if(actionName == '') {

      return '';

    }


    const actions = getActionsData();


    const actionData = normalizePlainObject(

      actions[actionName]

    );


    return String(

      actionData.route || ''

    ).trim();


  }


  /*
  |--------------------------------------------------------------------------
  | Extrai um argumento simples de uma chamada JavaScript
  |--------------------------------------------------------------------------
  */


  function getPaginationButtonJavascriptArguments(
    javascript = '',
    functionName = ''
  ) {


    javascript = String(

      javascript || ''

    );


    functionName = String(

      functionName || ''

    ).trim();


    if(
      javascript == '' ||
      functionName == ''
    ) {

      return [];

    }


    const functionPosition = javascript.indexOf(

      functionName + '('

    );


    if(functionPosition < 0) {

      return [];

    }


    const startPosition =

      functionPosition +

      functionName.length +

      1;


    let currentValue = '';

    let quote = '';

    let escaped = false;

    let parenthesisDepth = 0;

    let bracesDepth = 0;

    let bracketsDepth = 0;

    const args = [];


    for(
      let index = startPosition;
      index < javascript.length;
      index++
    ) {


      const char = javascript.charAt(

        index

      );


      if(escaped === true) {

        currentValue += char;

        escaped = false;

        continue;

      }


      if(
        quote != '' &&
        char == '\\'
      ) {

        currentValue += char;

        escaped = true;

        continue;

      }


      if(quote != '') {

        currentValue += char;


        if(char == quote) {

          quote = '';

        }


        continue;

      }


      if(
        char == "'" ||
        char == '"' ||
        char == '`'
      ) {

        quote = char;

        currentValue += char;

        continue;

      }


      if(char == '(') {

        parenthesisDepth++;

        currentValue += char;

        continue;

      }


      if(char == ')') {


        if(
          parenthesisDepth <= 0 &&
          bracesDepth <= 0 &&
          bracketsDepth <= 0
        ) {

          args.push(

            currentValue.trim()

          );


          break;

        }


        parenthesisDepth--;

        currentValue += char;

        continue;

      }


      if(char == '{') {

        bracesDepth++;

        currentValue += char;

        continue;

      }


      if(char == '}') {

        bracesDepth--;

        currentValue += char;

        continue;

      }


      if(char == '[') {

        bracketsDepth++;

        currentValue += char;

        continue;

      }


      if(char == ']') {

        bracketsDepth--;

        currentValue += char;

        continue;

      }


      if(
        char == ',' &&
        parenthesisDepth <= 0 &&
        bracesDepth <= 0 &&
        bracketsDepth <= 0
      ) {

        args.push(

          currentValue.trim()

        );


        currentValue = '';

        continue;

      }


      currentValue += char;


    }


    return args;


  }


  /*
  |--------------------------------------------------------------------------
  | Remove aspas externas de um argumento
  |--------------------------------------------------------------------------
  */


  function normalizePaginationButtonJavascriptArgument(
    value = ''
  ) {


    value = String(

      value || ''

    ).trim();


    if(
      value.length >= 2 &&
      (
        (
          value.charAt(0) == "'" &&
          value.charAt(value.length - 1) == "'"
        ) ||
        (
          value.charAt(0) == '"' &&
          value.charAt(value.length - 1) == '"'
        ) ||
        (
          value.charAt(0) == '`' &&
          value.charAt(value.length - 1) == '`'
        )
      )
    ) {

      value = value.substring(

        1,

        value.length - 1

      );

    }


    return value
      .replace(
        /\\'/g,
        "'"
      )
      .replace(
        /\\"/g,
        '"'
      )
      .replace(
        /\\\\/g,
        '\\'
      );


  }


  /*
  |--------------------------------------------------------------------------
  | Converte valor JavaScript para boolean
  |--------------------------------------------------------------------------
  */


  function parsePaginationButtonJavascriptBoolean(
    value,
    defaultValue = false
  ) {


    value = String(

      value === null ||
      value === undefined

        ? ''

        : value

    )
      .trim()
      .toLowerCase();


    if(
      value == 'true' ||
      value == '1'
    ) {

      return true;

    }


    if(
      value == 'false' ||
      value == '0'
    ) {

      return false;

    }


    return defaultValue;


  }


  function getPaginationButtonJavascriptObjectProperties(
    javascript = ''
  ) {


    javascript = String(

      javascript || ''

    ).trim();


    if(javascript == '') {

      return {};

    }


    if(
      javascript.charAt(0) == '{' &&
      javascript.charAt(
        javascript.length - 1
      ) == '}'
    ) {

      javascript = javascript.substring(

        1,

        javascript.length - 1

      );

    }


    const properties = {};


    let currentProperty = '';

    let currentValue = '';

    let readingProperty = true;

    let quote = '';

    let escaped = false;

    let parenthesisDepth = 0;

    let bracesDepth = 0;

    let bracketsDepth = 0;


    function saveProperty() {


      let propertyName = String(

        currentProperty || ''

      ).trim();


      let propertyValue = String(

        currentValue || ''

      ).trim();


      if(
        propertyName.length >= 2 &&
        (
          (
            propertyName.charAt(0) == "'" &&
            propertyName.charAt(
              propertyName.length - 1
            ) == "'"
          ) ||
          (
            propertyName.charAt(0) == '"' &&
            propertyName.charAt(
              propertyName.length - 1
            ) == '"'
          ) ||
          (
            propertyName.charAt(0) == '`' &&
            propertyName.charAt(
              propertyName.length - 1
            ) == '`'
          )
        )
      ) {

        propertyName = propertyName.substring(

          1,

          propertyName.length - 1

        );

      }


      if(propertyName != '') {

        properties[propertyName] = propertyValue;

      }


      currentProperty = '';

      currentValue = '';

      readingProperty = true;


    }


    for(
      let index = 0;
      index < javascript.length;
      index++
    ) {


      const char = javascript.charAt(

        index

      );


      if(escaped === true) {


        if(readingProperty === true) {

          currentProperty += char;

        } else {

          currentValue += char;

        }


        escaped = false;

        continue;

      }


      if(
        quote != '' &&
        char == '\\'
      ) {


        if(readingProperty === true) {

          currentProperty += char;

        } else {

          currentValue += char;

        }


        escaped = true;

        continue;

      }


      if(quote != '') {


        if(readingProperty === true) {

          currentProperty += char;

        } else {

          currentValue += char;

        }


        if(char == quote) {

          quote = '';

        }


        continue;

      }


      if(
        char == "'" ||
        char == '"' ||
        char == '`'
      ) {

        quote = char;


        if(readingProperty === true) {

          currentProperty += char;

        } else {

          currentValue += char;

        }


        continue;

      }


      if(readingProperty === true) {


        if(char == ':') {

          readingProperty = false;

          continue;

        }


        currentProperty += char;

        continue;

      }


      if(char == '(') {

        parenthesisDepth++;

        currentValue += char;

        continue;

      }


      if(char == ')') {

        parenthesisDepth = Math.max(

          0,

          parenthesisDepth - 1

        );


        currentValue += char;

        continue;

      }


      if(char == '{') {

        bracesDepth++;

        currentValue += char;

        continue;

      }


      if(char == '}') {

        bracesDepth = Math.max(

          0,

          bracesDepth - 1

        );


        currentValue += char;

        continue;

      }


      if(char == '[') {

        bracketsDepth++;

        currentValue += char;

        continue;

      }


      if(char == ']') {

        bracketsDepth = Math.max(

          0,

          bracketsDepth - 1

        );


        currentValue += char;

        continue;

      }


      if(
        char == ',' &&
        parenthesisDepth <= 0 &&
        bracesDepth <= 0 &&
        bracketsDepth <= 0
      ) {

        saveProperty();

        continue;

      }


      currentValue += char;


    }


    saveProperty();


    return properties;


  }


  /*
  |--------------------------------------------------------------------------
  | Lê uma propriedade simples de objeto JavaScript
  |--------------------------------------------------------------------------
  */

  function getPaginationButtonJavascriptObjectValue(
    javascript = '',
    propertyName = '',
    normalizeValue = true
  ) {


    propertyName = String(

      propertyName || ''

    ).trim();


    if(propertyName == '') {

      return '';

    }


    const properties =

      getPaginationButtonJavascriptObjectProperties(

        javascript

      );


    if(
      Object.prototype.hasOwnProperty.call(

        properties,

        propertyName

      ) !== true
    ) {

      return '';

    }


    const propertyValue = String(

      properties[propertyName] || ''

    ).trim();


    if(normalizeValue !== true) {

      return propertyValue;

    }


    return normalizePaginationButtonJavascriptArgument(

      propertyValue

    );


  }


  /*
  |--------------------------------------------------------------------------
  | Separa as instruções de um callback JavaScript
  |--------------------------------------------------------------------------
  */


  function splitPaginationButtonJavascriptStatements(
    javascript = ''
  ) {


    javascript = String(

      javascript || ''

    ).trim();


    if(javascript == '') {

      return [];

    }


    const statements = [];


    let currentValue = '';

    let quote = '';

    let escaped = false;

    let parenthesisDepth = 0;

    let bracesDepth = 0;

    let bracketsDepth = 0;


    for(
      let index = 0;
      index < javascript.length;
      index++
    ) {


      const char = javascript.charAt(

        index

      );


      if(escaped === true) {

        currentValue += char;

        escaped = false;

        continue;

      }


      if(
        quote != '' &&
        char == '\\'
      ) {

        currentValue += char;

        escaped = true;

        continue;

      }


      if(quote != '') {

        currentValue += char;


        if(char == quote) {

          quote = '';

        }


        continue;

      }


      if(
        char == "'" ||
        char == '"' ||
        char == '`'
      ) {

        quote = char;

        currentValue += char;

        continue;

      }


      if(char == '(') {

        parenthesisDepth++;

        currentValue += char;

        continue;

      }


      if(char == ')') {

        parenthesisDepth = Math.max(

          0,

          parenthesisDepth - 1

        );


        currentValue += char;

        continue;

      }


      if(char == '{') {

        bracesDepth++;

        currentValue += char;

        continue;

      }


      if(char == '}') {

        bracesDepth = Math.max(

          0,

          bracesDepth - 1

        );


        currentValue += char;

        continue;

      }


      if(char == '[') {

        bracketsDepth++;

        currentValue += char;

        continue;

      }


      if(char == ']') {

        bracketsDepth = Math.max(

          0,

          bracketsDepth - 1

        );


        currentValue += char;

        continue;

      }


      if(
        char == ';' &&
        parenthesisDepth <= 0 &&
        bracesDepth <= 0 &&
        bracketsDepth <= 0
      ) {


        const statement = String(

          currentValue || ''

        ).trim();


        if(statement != '') {

          statements.push(

            statement + ';'

          );

        }


        currentValue = '';

        continue;

      }


      currentValue += char;


    }


    const remainingStatement = String(

      currentValue || ''

    ).trim();


    if(remainingStatement != '') {

      statements.push(

        remainingStatement

      );

    }


    return statements;


  }


  /*
  |--------------------------------------------------------------------------
  | Separa os argumentos de uma chamada JavaScript
  |--------------------------------------------------------------------------
  */


  function splitPaginationButtonJavascriptArguments(
    argumentsValue = ''
  ) {


    argumentsValue = String(

      argumentsValue || ''

    ).trim();


    if(argumentsValue == '') {

      return [];

    }


    const argumentsList = [];


    let currentValue = '';

    let quote = '';

    let escaped = false;

    let parenthesisDepth = 0;

    let bracesDepth = 0;

    let bracketsDepth = 0;


    for(
      let index = 0;
      index < argumentsValue.length;
      index++
    ) {


      const char = argumentsValue.charAt(

        index

      );


      if(escaped === true) {

        currentValue += char;

        escaped = false;

        continue;

      }


      if(
        quote != '' &&
        char == '\\'
      ) {

        currentValue += char;

        escaped = true;

        continue;

      }


      if(quote != '') {

        currentValue += char;


        if(char == quote) {

          quote = '';

        }


        continue;

      }


      if(
        char == "'" ||
        char == '"' ||
        char == '`'
      ) {

        quote = char;

        currentValue += char;

        continue;

      }


      if(char == '(') {

        parenthesisDepth++;

        currentValue += char;

        continue;

      }


      if(char == ')') {

        parenthesisDepth = Math.max(

          0,

          parenthesisDepth - 1

        );


        currentValue += char;

        continue;

      }


      if(char == '{') {

        bracesDepth++;

        currentValue += char;

        continue;

      }


      if(char == '}') {

        bracesDepth = Math.max(

          0,

          bracesDepth - 1

        );


        currentValue += char;

        continue;

      }


      if(char == '[') {

        bracketsDepth++;

        currentValue += char;

        continue;

      }


      if(char == ']') {

        bracketsDepth = Math.max(

          0,

          bracketsDepth - 1

        );


        currentValue += char;

        continue;

      }


      if(
        char == ',' &&
        parenthesisDepth <= 0 &&
        bracesDepth <= 0 &&
        bracketsDepth <= 0
      ) {


        argumentsList.push(

          String(

            currentValue || ''

          ).trim()

        );


        currentValue = '';

        continue;

      }


      currentValue += char;


    }


    if(
      String(
        currentValue || ''
      ).trim() != ''
    ) {

      argumentsList.push(

        String(

          currentValue || ''

        ).trim()

      );

    }


    return argumentsList;


  }


  /*
  |--------------------------------------------------------------------------
  | Interpreta um valor JavaScript sem executar o código
  |--------------------------------------------------------------------------
  */


  function parsePaginationButtonJavascriptValue(
    value = ''
  ) {


    value = String(

      value || ''

    ).trim();


    if(value == '') {

      return {

        type: 'raw',

        value: '',

      };

    }


    if(
      value.length >= 2 &&
      (
        (
          value.charAt(0) == "'" &&
          value.charAt(
            value.length - 1
          ) == "'"
        ) ||
        (
          value.charAt(0) == '"' &&
          value.charAt(
            value.length - 1
          ) == '"'
        ) ||
        (
          value.charAt(0) == '`' &&
          value.charAt(
            value.length - 1
          ) == '`'
        )
      )
    ) {

      return {

        type: 'string',

        value:

          normalizePaginationButtonJavascriptArgument(

            value

          ),

      };

    }


    if(value == 'true') {

      return {

        type: 'boolean',

        value: true,

      };

    }


    if(value == 'false') {

      return {

        type: 'boolean',

        value: false,

      };

    }


    if(value == 'null') {

      return {

        type: 'null',

        value: null,

      };

    }


    if(value == 'undefined') {

      return {

        type: 'undefined',

        value: 'undefined',

      };

    }


    if(
      /^-?(?:\d+|\d*\.\d+)$/.test(
        value
      )
    ) {

      return {

        type: 'number',

        value: Number(value),

      };

    }


    return {

      type: 'raw',

      value: value,

    };


  }


  /*
  |--------------------------------------------------------------------------
  | Converte uma instrução JavaScript em uma estrutura JSON
  |--------------------------------------------------------------------------
  */


  function parsePaginationButtonJavascriptStatement(
    statement = ''
  ) {


    statement = String(

      statement || ''

    ).trim();


    if(statement == '') {

      return null;

    }


    const statementWithoutSemicolon = statement.replace(

      /;\s*$/,

      ''

    ).trim();


    /*
    |--------------------------------------------------------------------------
    | Atribuição
    |--------------------------------------------------------------------------
    */


    const assignmentMatch =

      statementWithoutSemicolon.match(

        /^([a-zA-Z_$][a-zA-Z0-9_$]*(?:(?:\.[a-zA-Z_$][a-zA-Z0-9_$]*)|(?:\[[^\]]+\]))*)\s*=\s*([\s\S]+)$/

      );


    if(assignmentMatch) {


      const parsedValue =

        parsePaginationButtonJavascriptValue(

          assignmentMatch[2]

        );


      return {

        type: 'assignment',

        target: String(

          assignmentMatch[1] || ''

        ).trim(),

        valueType:

          parsedValue.type,

        value:

          parsedValue.value,

        code: statement,

      };


    }


    /*
    |--------------------------------------------------------------------------
    | Chamada de função
    |--------------------------------------------------------------------------
    */


    const functionCallMatch =

      statementWithoutSemicolon.match(

        /^([a-zA-Z_$][a-zA-Z0-9_$]*(?:\.[a-zA-Z_$][a-zA-Z0-9_$]*)*)\s*\(([\s\S]*)\)$/

      );


    if(functionCallMatch) {


      const functionArguments =

        splitPaginationButtonJavascriptArguments(

          functionCallMatch[2] || ''

        );


      return {

        type: 'function',

        function: String(

          functionCallMatch[1] || ''

        ).trim(),

        arguments:

          functionArguments.map(function(argumentValue) {


            const parsedArgument =

              parsePaginationButtonJavascriptValue(

                argumentValue

              );


            return {

              type:

                parsedArgument.type,

              value:

                parsedArgument.value,

              code:

                argumentValue,

            };


          }),

        code: statement,

      };


    }


    /*
    |--------------------------------------------------------------------------
    | Retorno
    |--------------------------------------------------------------------------
    */


    const returnMatch = statementWithoutSemicolon.match(

      /^return(?:\s+([\s\S]+))?$/

    );


    if(returnMatch) {


      const parsedReturnValue =

        parsePaginationButtonJavascriptValue(

          returnMatch[1] || ''

        );


      return {

        type: 'return',

        valueType:

          parsedReturnValue.type,

        value:

          parsedReturnValue.value,

        code: statement,

      };


    }


    /*
    |--------------------------------------------------------------------------
    | Código não reconhecido
    |--------------------------------------------------------------------------
    */


    return {

      type: 'raw',

      code: statement,

    };


  }


  /*
  |--------------------------------------------------------------------------
  | Converte um callback JavaScript para a árvore JSON do formulário
  |--------------------------------------------------------------------------
  */


  function parseJavascriptCallbackToJson(
    callbackValue = ''
  ) {


    callbackValue = String(

      callbackValue || ''

    ).trim();


    if(
      callbackValue == '' ||
      callbackValue == 'null' ||
      callbackValue == 'undefined'
    ) {

      return {};

    }


    const callbackBody =

      normalizePaginationButtonActionBuilderFunctionValue(

        callbackValue

      );


    if(callbackBody == '') {

      return {};

    }


    const statements =

      splitPaginationButtonJavascriptStatements(

        callbackBody

      )
      .map(function(statement) {


        return parsePaginationButtonJavascriptStatement(

          statement

        );


      })
      .filter(function(statement) {


        return (

          statement !== null &&
          typeof statement === 'object'

        );


      });


    return {

      type: 'javascript-callback',

      parameters: [

        'response',
        'modalEl',
        'modal',
        'recordData',

      ],

      statements: statements,

    };


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza o conteúdo retornado pelo campo JSON
  |--------------------------------------------------------------------------
  */


  function normalizePaginationButtonCallbackJsonValue(
    value = {}
  ) {


    if(
      value === null ||
      value === undefined ||
      value === ''
    ) {

      return {};

    }


    if(
      value &&
      typeof value === 'object'
    ) {

      return value;

    }


    const stringValue = String(

      value || ''

    ).trim();


    if(stringValue == '') {

      return {};

    }


    try {


      const decodedValue = JSON.parse(

        stringValue

      );


      if(
        decodedValue &&
        typeof decodedValue === 'object'
      ) {

        return decodedValue;

      }


    } catch(error) {}


    return {

      value: stringValue,

    };


  }


  /*
  |--------------------------------------------------------------------------
  | Converte um valor estruturado novamente para JavaScript
  |--------------------------------------------------------------------------
  */


  function buildPaginationButtonJavascriptValue(
    value,
    valueType = 'raw'
  ) {


    valueType = String(

      valueType || 'raw'

    )
      .trim()
      .toLowerCase();


    if(valueType == 'string') {

      return (

        '\'' +

        escapePaginationButtonJavascriptString(

          value === null ||
          value === undefined

            ? ''

            : value

        ) +

        '\''

      );

    }


    if(valueType == 'boolean') {

      return AutomatorNormalizeBoolean(

        value

      ) === true

        ? 'true'

        : 'false';

    }


    if(valueType == 'number') {


      const numberValue = Number(

        value

      );


      return Number.isFinite(

        numberValue

      )

        ? String(numberValue)

        : '0';

    }


    if(valueType == 'null') {

      return 'null';

    }


    if(valueType == 'undefined') {

      return 'undefined';

    }


    if(
      value &&
      typeof value === 'object'
    ) {


      try {


        return JSON.stringify(

          value

        );


      } catch(error) {


        return '{}';


      }


    }


    return String(

      value === null ||
      value === undefined

        ? ''

        : value

    );


  }


  /*
  |--------------------------------------------------------------------------
  | Converte uma instrução da árvore JSON novamente para JavaScript
  |--------------------------------------------------------------------------
  */


  function buildPaginationButtonJavascriptStatement(
    statement = {}
  ) {


    statement = normalizePlainObject(

      statement

    );


    const statementType = String(

      statement.type || ''

    )
      .trim()
      .toLowerCase();


    /*
    |--------------------------------------------------------------------------
    | Preserva o código original quando ele ainda corresponde à instrução
    |--------------------------------------------------------------------------
    */


    const originalCode = String(

      statement.code || ''

    ).trim();


    if(
      statementType == 'raw' &&
      originalCode != ''
    ) {

      return originalCode;

    }


    if(statementType == 'assignment') {


      const target = String(

        statement.target || ''

      ).trim();


      if(target == '') {

        return originalCode;

      }


      return (

        target +

        ' = ' +

        buildPaginationButtonJavascriptValue(

          statement.value,

          statement.valueType ||

          'raw'

        ) +

        ';'

      );

    }


    if(statementType == 'function') {


      const functionName = String(

        statement.function || ''

      ).trim();


      if(functionName == '') {

        return originalCode;

      }


      let functionArguments = statement.arguments;


      if(!Array.isArray(functionArguments)) {

        functionArguments = [];

      }


      const argumentValues =

        functionArguments.map(function(argumentData) {


          if(
            argumentData === null ||
            argumentData === undefined
          ) {

            return '';

          }


          if(
            typeof argumentData !== 'object'
          ) {

            return String(

              argumentData

            );

          }


          const argumentCode = String(

            argumentData.code || ''

          ).trim();


          if(
            argumentData.type == 'raw' &&
            argumentCode != ''
          ) {

            return argumentCode;

          }


          return buildPaginationButtonJavascriptValue(

            argumentData.value,

            argumentData.type ||

            'raw'

          );


        });


      return (

        functionName +

        '(' +

        argumentValues.join(

          ', '

        ) +

        ');'

      );

    }


    if(statementType == 'return') {


      const returnValue =

        buildPaginationButtonJavascriptValue(

          statement.value,

          statement.valueType ||

          'raw'

        );


      return (

        returnValue != ''

          ? 'return ' + returnValue + ';'

          : 'return;'

      );

    }


    return originalCode;


  }


  /*
  |--------------------------------------------------------------------------
  | Converte a árvore JSON do formulário novamente para callback JavaScript
  |--------------------------------------------------------------------------
  */


  function parseJsonToJavascriptCallback(
    value = {}
  ) {


    const callbackData =

      normalizePaginationButtonCallbackJsonValue(

        value

      );


    if(
      Object.keys(
        callbackData
      ).length <= 0
    ) {

      return '';

    }


    /*
    |--------------------------------------------------------------------------
    | Compatibilidade com o formato antigo { value: "código" }
    |--------------------------------------------------------------------------
    */


    if(
      Object.prototype.hasOwnProperty.call(

        callbackData,

        'value'

      ) &&
      !Array.isArray(
        callbackData.statements
      )
    ) {

      return String(

        callbackData.value || ''

      ).trim();

    }


    /*
    |--------------------------------------------------------------------------
    | Compatibilidade com callbacks que ainda estejam em uma propriedade code
    |--------------------------------------------------------------------------
    */


    if(
      !Array.isArray(
        callbackData.statements
      ) &&
      String(
        callbackData.code || ''
      ).trim() != ''
    ) {

      return String(

        callbackData.code || ''

      ).trim();

    }


    let statements = callbackData.statements;


    if(!Array.isArray(statements)) {

      return '';

    }


    return statements
      .map(function(statement) {


        return buildPaginationButtonJavascriptStatement(

          statement

        );


      })
      .filter(function(statement) {


        return String(

          statement || ''

        ).trim() != '';


      })
      .join(

        ' '

      )
      .trim();


  }

  function normalizePaginationButtonActionBuilderFunctionValue(
    value = ''
  ) {


    value = String(

      value || ''

    ).trim();


    if(
      value == '' ||
      value == 'null' ||
      value == 'undefined'
    ) {

      return '';

    }


    const functionBodyMatch = value.match(

      /^(?:async\s+)?function(?:\s+[a-zA-Z_$][a-zA-Z0-9_$]*)?\s*\([^)]*\)\s*\{([\s\S]*)\}$/i

    );


    if(functionBodyMatch) {

      return String(

        functionBodyMatch[1] || ''

      ).trim();

    }


    const arrowFunctionBodyMatch = value.match(

      /^(?:async\s+)?(?:\([^)]*\)|[a-zA-Z_$][a-zA-Z0-9_$]*)\s*=>\s*\{([\s\S]*)\}$/i

    );


    if(arrowFunctionBodyMatch) {

      return String(

        arrowFunctionBodyMatch[1] || ''

      ).trim();

    }


    const arrowFunctionExpressionMatch = value.match(

      /^(?:async\s+)?(?:\([^)]*\)|[a-zA-Z_$][a-zA-Z0-9_$]*)\s*=>\s*([\s\S]+)$/i

    );


    if(arrowFunctionExpressionMatch) {

      return (

        'return ' +

        String(

          arrowFunctionExpressionMatch[1] || ''

        ).trim() +

        ';'

      );

    }


    return value;


  }


  function extractPaginationButtonModalFormCallbackData(
    callbackValue = ''
  ) {


    callbackValue = String(

      callbackValue || ''

    ).trim();


    const response = {

      method:   'POST',
      action:   '',
      callback: '',

    };


    if(
      callbackValue == '' ||
      callbackValue == 'null' ||
      callbackValue == 'undefined'
    ) {

      return response;

    }


    let callbackBody =

      normalizePaginationButtonActionBuilderFunctionValue(

        callbackValue

      );


    const nativeCallbackExpression =

      /AutomatorPaginationCreateModalFormCallBack\s*\(\s*\[\s*\{([\s\S]*?)\}\s*\]\s*\)\s*;?/i;


    const nativeCallbackMatch = callbackBody.match(

      nativeCallbackExpression

    );


    if(nativeCallbackMatch) {


      const nativeCallbackProperties =

        getPaginationButtonJavascriptObjectProperties(

          '{' +

          String(

            nativeCallbackMatch[1] || ''

          ) +

          '}'

        );


      if(
        Object.prototype.hasOwnProperty.call(

          nativeCallbackProperties,

          'method'

        )
      ) {

        response.method = String(

          normalizePaginationButtonJavascriptArgument(

            nativeCallbackProperties.method

          ) || 'POST'

        )
          .trim()
          .toUpperCase();

      }


      if(
        Object.prototype.hasOwnProperty.call(

          nativeCallbackProperties,

          'action'

        )
      ) {

        response.action = String(

          normalizePaginationButtonJavascriptArgument(

            nativeCallbackProperties.action

          ) || ''

        ).trim();

      }


      callbackBody = callbackBody.replace(

        nativeCallbackExpression,

        ''

      ).trim();


    }


    response.callback = callbackBody;


    return response;


  }


  /*
  |--------------------------------------------------------------------------
  | Interpreta AutomatorPaginationCreateModalForm
  |--------------------------------------------------------------------------
  */


  function parsePaginationButtonModalFormOnclick(
    onclickValue = ''
  ) {


    const args = getPaginationButtonJavascriptArguments(

      onclickValue,

      'AutomatorPaginationCreateModalForm'

    );


    if(args.length <= 0) {

      return {};

    }


    const size = normalizePaginationButtonModalSize(

      normalizePaginationButtonJavascriptArgument(

        args[0] || 'lg'

      )

    );


    const title = normalizePaginationButtonJavascriptArgument(

      args[1] || ''

    );


    const formID = normalizePaginationButtonJavascriptArgument(

      args[2] || ''

    );


    const loadAction = normalizePaginationButtonJavascriptArgument(

      args[3] || ''

    );


    const callbackData =

      extractPaginationButtonModalFormCallbackData(

        args[5] || ''

      );


    let formName = getPaginationButtonFormNameByID(

      formID

    );


    if(formName == '') {

      formName = formID;

    }


    let loadRoute = getPaginationButtonRouteByActionName(

      loadAction

    );


    if(loadRoute == '') {

      loadRoute = loadAction;

    }


    let submitRoute = getPaginationButtonRouteByActionName(

      callbackData.action

    );


    if(submitRoute == '') {

      submitRoute = callbackData.action;

    }


    return {

      form: formName,

      title: title,

      loadMethod: 'GET',

      loadRoute: loadRoute,

      submitMethod:

        callbackData.method ||

        'POST',

      submitRoute: submitRoute,

      size: size,

      backdrop: true,

      keyboard: false,

      scrollable: true,

      callback:

        parseJavascriptCallbackToJson(

          callbackData.callback ||

          ''

        ),

      beforeShow: {},

      afterHide: {},

    };


  }


  /*
  |--------------------------------------------------------------------------
  | Interpreta AutomatorCreateViewModal
  |--------------------------------------------------------------------------
  */


  function parsePaginationButtonModalViewOnclick(
    onclickValue = ''
  ) {


    const args = getPaginationButtonJavascriptArguments(

      onclickValue,

      'AutomatorCreateViewModal'

    );


    if(args.length <= 0) {

      return {};

    }


    const payload = String(

      args[0] || ''

    );


    const options = String(

      args[1] || ''

    );


    const callbackValue = getPaginationButtonJavascriptObjectValue(

      options,

      'callback',

      false

    );


    const beforeShowValue = getPaginationButtonJavascriptObjectValue(

      options,

      'beforeShow',

      false

    );


    let afterHideValue = getPaginationButtonJavascriptObjectValue(

      options,

      'afterHideOn',

      false

    );


    if(afterHideValue == '') {

      afterHideValue = getPaginationButtonJavascriptObjectValue(

        options,

        'afterHide',

        false

      );

    }


    return {

      view:

        getPaginationButtonJavascriptObjectValue(

          payload,

          'view'

        ),

      title:

        getPaginationButtonJavascriptObjectValue(

          payload,

          'title'

        ),

      size:

        normalizePaginationButtonModalSize(

          getPaginationButtonJavascriptObjectValue(

            options,

            'size'

          ) || 'lg'

        ),

      backdrop:

        parsePaginationButtonJavascriptBoolean(

          getPaginationButtonJavascriptObjectValue(

            options,

            'backdrop'

          ),

          true

        ),

      keyboard:

        parsePaginationButtonJavascriptBoolean(

          getPaginationButtonJavascriptObjectValue(

            options,

            'keyboard'

          ),

          false

        ),

      scrollable:

        parsePaginationButtonJavascriptBoolean(

          getPaginationButtonJavascriptObjectValue(

            options,

            'scrollable'

          ),

          true

        ),

      callback:

        parseJavascriptCallbackToJson(

          callbackValue

        ),

      beforeShow:

        parseJavascriptCallbackToJson(

          beforeShowValue

        ),

      afterHide:

        parseJavascriptCallbackToJson(

          afterHideValue

        ),

    };


  }


  function normalizePaginationButtonActionBuilderSelectOptions(
    modalEl
  ) {


    modalEl = $(modalEl);


    if(!modalEl.length) {

      return false;

    }


    modalEl.find(

      'select'

    ).each(function() {


      const select = $(this);


      const currentValue = String(

        select.val() === null ||
        select.val() === undefined

          ? ''

          : select.val()

      );


      const required =

        select.prop('required') === true ||

        select.attr('required') !== undefined;


      let emptyOption = select.find(

        'option[value=""]'

      ).first();


      if(!emptyOption.length) {


        emptyOption = $(

          '<option value="">- Selecione -</option>'

        );


        select.prepend(

          emptyOption

        );


      } else {


        emptyOption.text(

          '- Selecione -'

        );


        emptyOption.prependTo(

          select

        );


      }


      emptyOption.prop(

        'disabled',

        required === true

      );


      if(currentValue == '') {


        select.val(

          ''

        );


        emptyOption.prop(

          'selected',

          true

        );


      } else {


        emptyOption.prop(

          'selected',

          false

        );


        select.val(

          currentValue

        );


      }


    });


    return true;


  }

  function getPaginationButtonActionBuilderFieldCandidates(
    fieldName = '',
    value = ''
  ) {


    fieldName = String(

      fieldName || ''

    ).trim();


    const candidates = [];


    function addCandidate(candidateValue) {


      if(
        candidateValue === null ||
        candidateValue === undefined
      ) {

        return;

      }


      candidateValue = String(

        candidateValue

      );


      if(
        candidates.indexOf(
          candidateValue
        ) < 0
      ) {

        candidates.push(

          candidateValue

        );

      }


    }


    addCandidate(

      value

    );


    if(
      value === true ||
      value === 1 ||
      value === '1' ||
      value === 'true'
    ) {

      addCandidate('1');

      addCandidate('true');

      addCandidate('sim');

      addCandidate('yes');

    }


    if(
      value === false ||
      value === 0 ||
      value === '0' ||
      value === 'false'
    ) {

      addCandidate('0');

      addCandidate('false');

      addCandidate('não');

      addCandidate('nao');

      addCandidate('no');

    }


    if(fieldName == 'form') {


      const formID = getPaginationButtonFormIDByName(

        value

      );


      const formName = getPaginationButtonFormNameByID(

        value

      );


      addCandidate(

        formID

      );


      addCandidate(

        formName

      );


    }


    return candidates;


  }


  function setPaginationButtonActionBuilderTextareaValue(
    field,
    value = ''
  ) {


    field = $(field);


    if(!field.length) {

      return false;

    }


    value = String(

      value === null ||
      value === undefined

        ? ''

        : value

    );


    field.val(

      value

    );


    const editorID = String(

      field.attr(
        'data-automator-editor-id'
      ) ||

      field.attr('id') ||

      ''

    ).trim();


    if(
      editorID != '' &&
      window.AutomatorEditors &&
      window.AutomatorEditors[editorID]
    ) {


      const editorInstance =

        window.AutomatorEditors[editorID];


      if(
        editorInstance.visual &&
        editorInstance.visual.length
      ) {

        editorInstance.visual.html(

          value

        );

      }


      if(
        editorInstance.code &&
        editorInstance.code.length
      ) {

        editorInstance.code.val(

          value

        );

      }


      if(
        editorInstance.source &&
        editorInstance.source.length
      ) {

        editorInstance.source.val(

          value

        );

      }


    }


    return true;


  }



  /*
  |--------------------------------------------------------------------------
  | Preenche um campo JSON do formulário auxiliar
  |--------------------------------------------------------------------------
  */


  function setPaginationButtonActionBuilderJsonValue(
    field,
    value = {}
  ) {


    field = $(field);


    if(!field.length) {

      return false;

    }


    const editor = field.closest(

      '[data-automator-json-editor="true"]'

    ).first();


    if(!editor.length) {

      return false;

    }


    if(
      typeof AutomatorJsonEditorSetValue ===
      'function'
    ) {


      return AutomatorJsonEditorSetValue(

        editor,

        value,

        false

      );


    }


    /*
    |--------------------------------------------------------------------------
    | Compatibilidade caso o script global ainda não esteja disponível
    |--------------------------------------------------------------------------
    */


    let normalizedValue = value;


    if(
      normalizedValue === null ||
      normalizedValue === undefined ||
      normalizedValue === ''
    ) {

      normalizedValue = {};

    }


    if(typeof normalizedValue !== 'string') {


      try {


        normalizedValue = JSON.stringify(

          normalizedValue

        );


      } catch(error) {


        normalizedValue = '{}';


      }


    }


    field.val(

      normalizedValue

    );


    editor.removeAttr(

      'data-automator-json-initialized'

    );


    if(
      typeof AutomatorJsonEditorInitializeAll ===
      'function'
    ) {


      AutomatorJsonEditorInitializeAll(

        editor[0]

      );


    }


    return true;


  }



  function setPaginationButtonActionBuilderFieldValue(
    field,
    fieldName = '',
    value = ''
  ) {


    field = $(field);


    if(!field.length) {

      return false;

    }


    /*
    |--------------------------------------------------------------------------
    | Campo JSON
    |--------------------------------------------------------------------------
    */


    if(
      field.is(
        '[data-automator-json-value="true"]'
      ) ||
      field.hasClass(
        'automator-json-editor-value'
      )
    ) {


      return setPaginationButtonActionBuilderJsonValue(

        field,

        value

      );


    }


    const candidates = getPaginationButtonActionBuilderFieldCandidates(

      fieldName,

      value

    );


    if(field.is(':checkbox')) {


      field.prop(

        'checked',

        candidates.indexOf(

          String(
            field.val()
          )

        ) >= 0

      );


      return true;

    }


    if(field.is(':radio')) {


      field.prop(

        'checked',

        candidates.indexOf(

          String(
            field.val()
          )

        ) >= 0

      );


      return true;

    }


    if(field.is('select')) {


      if(field.prop('multiple') === true) {


        const selectedValues = Array.isArray(value)

          ? value.map(String)

          : candidates;


        field.find(

          'option'

        ).each(function() {


          $(this).prop(

            'selected',

            selectedValues.indexOf(

              String(
                $(this).val()
              )

            ) >= 0

          );


        });


        return true;

      }


      let selectedValue = '';


      candidates.some(function(candidateValue) {


        const option = field.find(

          'option'

        ).filter(function() {


          return String(

            $(this).val()

          ) == String(candidateValue);


        }).first();


        if(!option.length) {

          return false;

        }


        selectedValue = String(

          option.val()

        );


        return true;


      });


      if(selectedValue == '') {


        const normalizedValue = String(

          value === null ||
          value === undefined

            ? ''

            : value

        )
          .trim()
          .toLowerCase();


        field.find(

          'option'

        ).each(function() {


          const option = $(this);


          const normalizedOptionText = String(

            option.text() || ''

          )
            .trim()
            .toLowerCase();


          if(normalizedOptionText == normalizedValue) {


            selectedValue = String(

              option.val()

            );


            return false;


          }


        });


      }


      field.val(

        selectedValue

      );


      return true;

    }


    if(field.is('textarea')) {


      return setPaginationButtonActionBuilderTextareaValue(

        field,

        value

      );


    }


    field.val(

      value === null ||
      value === undefined

        ? ''

        : value

    );


    return true;


  }



  /*
  |--------------------------------------------------------------------------
  | Retorna os dados a serem enviados ao formulário auxiliar
  |--------------------------------------------------------------------------
  */


  function getPaginationButtonActionBuilderValues(
    mode = '',
    onclickValue = ''
  ) {


    if(mode == 'modal-form') {

      return parsePaginationButtonModalFormOnclick(

        onclickValue

      );

    }


    if(mode == 'modal-view') {

      return parsePaginationButtonModalViewOnclick(

        onclickValue

      );

    }


    return {};


  }


  /*
  |--------------------------------------------------------------------------
  | Preenche o formulário auxiliar sem alterar o modal global
  |--------------------------------------------------------------------------
  */


  function populatePaginationButtonActionBuilderForm(
    modalEl,
    values = {}
  ) {


    modalEl = $(modalEl);


    if(!modalEl.length) {

      return false;

    }


    values = normalizePlainObject(

      values

    );


    normalizePaginationButtonActionBuilderSelectOptions(

      modalEl

    );


    /*
    |--------------------------------------------------------------------------
    | Garante a inicialização dos editores JSON inseridos dinamicamente
    |--------------------------------------------------------------------------
    */


    if(
      typeof AutomatorJsonEditorInitializeAll ===
      'function'
    ) {


      AutomatorJsonEditorInitializeAll(

        modalEl[0]

      );


    }


    Object.keys(

      values

    ).forEach(function(fieldName) {


      const value = values[fieldName];


      const fields = modalEl.find(

        '[name="' +

        fieldName +

        '"], [name="' +

        fieldName +

        '[]"], [data-automator-field-name="' +

        fieldName +

        '"]'

      );


      fields.each(function() {


        setPaginationButtonActionBuilderFieldValue(

          this,

          fieldName,

          value

        );


      });


    });


    /*
    |--------------------------------------------------------------------------
    | Mantém a opção vazia sincronizada nos selects
    |--------------------------------------------------------------------------
    */


    modalEl.find(

      'select'

    ).each(function() {


      const select = $(this);


      const emptyOption = select.find(

        'option[value=""]'

      ).first();


      if(!emptyOption.length) {

        return;

      }


      emptyOption.prop(

        'selected',

        String(
          select.val() || ''
        ) == ''

      );


    });


    /*
    |--------------------------------------------------------------------------
    | Atualiza somente campos comuns
    |--------------------------------------------------------------------------
    |
    | O editor JSON já foi sincronizado por AutomatorJsonEditorSetValue().
    | Disparar change novamente no input hidden poderia marcar o formulário
    | como alterado durante sua abertura.
    |--------------------------------------------------------------------------
    */


    modalEl
      .find(
        'input[name], select[name], textarea[name]'
      )
      .not(
        '[data-automator-json-value="true"]'
      )
      .trigger(

        'change'

      );


    /*
    |--------------------------------------------------------------------------
    | Garante uma última sincronização dos editores JSON
    |--------------------------------------------------------------------------
    */


    modalEl.find(

      '[data-automator-json-editor="true"]'

    ).each(function() {


      const editor = $(this);


      const valueInput = editor.find(

        '.automator-json-editor-value'

      ).first();


      if(
        !valueInput.length ||
        typeof AutomatorJsonEditorSetValue !==
        'function'
      ) {

        return;

      }


      AutomatorJsonEditorSetValue(

        editor,

        valueInput.val(),

        false

      );


    });


    const formEl = modalEl.find(

      'form'

    ).first();


    if(formEl.length) {


      if(
        typeof AutomatorFormSerializeCurrentState ===
        'function'
      ) {


        formEl.attr(

          'data-automator-initial-state',

          AutomatorFormSerializeCurrentState(

            formEl[0]

          )

        );


      }


      formEl.attr(

        'data-automator-form-changed',

        'false'

      );


    }


    modalEl.find(

      '.js-automator-pagination-modal-submit'

    ).prop(

      'disabled',

      false

    );


    return true;


  }


  function preparePaginationButtonActionBuilderModalStack(
    modalEl
  ) {


    if(!modalEl) {

      return false;

    }


    const openedModals = Array.from(

      document.querySelectorAll(

        '.modal.show'

      )

    ).filter(function(currentModal) {


      return currentModal !== modalEl;


    });


    let highestModalZIndex = 1055;


    openedModals.forEach(function(currentModal) {


      const currentZIndex = parseInt(

        window
          .getComputedStyle(
            currentModal
          )
          .zIndex,

        10

      );


      if(
        !isNaN(currentZIndex) &&
        currentZIndex > highestModalZIndex
      ) {

        highestModalZIndex = currentZIndex;

      }


    });


    const backdropZIndex =

      highestModalZIndex + 10;


    const modalZIndex =

      backdropZIndex + 5;


    modalEl.style.zIndex = String(

      modalZIndex

    );


    modalEl.setAttribute(

      'data-automator-pagination-action-builder-modal',

      'true'

    );


    const backdrops = document.querySelectorAll(

      '.modal-backdrop'

    );


    if(backdrops.length >= 1) {


      const currentBackdrop =

        backdrops[backdrops.length - 1];


      currentBackdrop.style.zIndex = String(

        backdropZIndex

      );


      currentBackdrop.setAttribute(

        'data-automator-pagination-action-builder-backdrop',

        modalEl.id || ''

      );


    }


    modalEl.addEventListener(

      'hidden.bs.modal',

      function() {


        document
          .querySelectorAll(
            '[data-automator-pagination-action-builder-backdrop="' +
            (
              modalEl.id || ''
            ) +
            '"]'
          )
          .forEach(function(backdrop) {


            backdrop.remove();


          });


        if(
          document.querySelectorAll(
            '.modal.show'
          ).length >= 1
        ) {

          document.body.classList.add(

            'modal-open'

          );


          document.body.style.overflow =

            'hidden';

        }


      },

      {

        once: true,

      }

    );


    return true;


  }


  function focusPaginationButtonEditorItem(
    item,
    openItem = true,
    scrollToItem = false
  ) {


    item = $(item);


    if(!item.length) {

      return false;

    }


    const buttonsPanel = $(

      selectors.buttonsPanel

    );


    const currentScrollTop = buttonsPanel.length

      ? buttonsPanel.scrollTop()

      : 0;


    switchLeftTab(

      'buttons'

    );


    showRightPanel(

      'pagination'

    );


    openRightConfigTab(

      'pagination-settings'

    );


    setSidebarOpen(

      'left',

      true

    );


    setSidebarOpen(

      'right',

      true

    );


    $(selectors.paginationButtonItem)
      .removeClass(
        'border-primary shadow-sm'
      );


    item.addClass(

      'border-primary shadow-sm'

    );


    if(openItem === true) {


      const collapseEl = item.find(

        '.accordion-collapse'

      ).first()[0];


      if(
        collapseEl &&
        typeof bootstrap !== 'undefined' &&
        bootstrap.Collapse
      ) {


        const collapse =

          bootstrap.Collapse.getOrCreateInstance(

            collapseEl,

            {

              toggle: false,

            }

          );


        collapse.show();


      }


    }


    if(
      buttonsPanel.length &&
      scrollToItem !== true
    ) {


      requestAnimationFrame(function() {


        buttonsPanel.scrollTop(

          currentScrollTop

        );


      });


      return true;


    }


    if(
      buttonsPanel.length &&
      scrollToItem === true
    ) {


      setTimeout(function() {


        const panelOffset =

          buttonsPanel.offset();


        const itemOffset =

          item.offset();


        if(
          !panelOffset ||
          !itemOffset
        ) {

          return;

        }


        const itemTop =

          itemOffset.top -

          panelOffset.top +

          buttonsPanel.scrollTop();


        const itemBottom =

          itemTop +

          item.outerHeight();


        const visibleTop =

          buttonsPanel.scrollTop();


        const visibleBottom =

          visibleTop +

          buttonsPanel.innerHeight();


        if(
          itemTop >= visibleTop &&
          itemBottom <= visibleBottom
        ) {

          return;

        }


        buttonsPanel.stop(

          true,

          false

        ).animate(

          {

            scrollTop:

              Math.max(

                0,

                itemTop - 15

              ),

          },

          200

        );


      }, 50);


    }


    return true;


  }


  function startPaginationButtonActionBuilderLoaderHold() {


    if(
      window.__automatorPaginationActionBuilderLoaderHold &&
      window.__automatorPaginationActionBuilderLoaderHold.active === true
    ) {

      return window.__automatorPaginationActionBuilderLoaderHold;

    }


    if(
      typeof window.AutomatorPageLoader !==
      'function'
    ) {

      return null;

    }


    const originalLoader =

      window.AutomatorPageLoader;


    const loaderHold = {

      active: true,

      originalLoader: originalLoader,

      release: function(callback = null) {


        if(loaderHold.active !== true) {


          if(typeof callback === 'function') {

            callback();

          }


          return false;

        }


        loaderHold.active = false;


        window.AutomatorPageLoader =

          originalLoader;


        window.__automatorPaginationActionBuilderLoaderHold =

          null;


        requestAnimationFrame(function() {


          requestAnimationFrame(function() {


            $('#page-loader').css(

              'z-index',

              ''

            );


            originalLoader(

              'hide',

              function() {


                if(typeof callback === 'function') {

                  callback();

                }


              }

            );


          });


        });


        return true;


      },

    };


    window.__automatorPaginationActionBuilderLoaderHold =

      loaderHold;


    window.AutomatorPageLoader = function(
      action = 'show',
      callback = null,
      time = 500
    ) {


      action = String(

        action || 'show'

      )
        .trim()
        .toLowerCase();


      if(
        loaderHold.active === true &&
        action == 'hide'
      ) {


        if(typeof callback === 'function') {

          callback();

        }


        return true;

      }


      return originalLoader(

        action,

        callback,

        time

      );


    };


    originalLoader(

      'show',

      function() {


        $('#page-loader').css(

          'z-index',

          '3005'

        );


      }

    );


    return loaderHold;


  }


  /*
  |--------------------------------------------------------------------------
  | Serializa o formulário auxiliar
  |--------------------------------------------------------------------------
  */


  function serializePaginationButtonActionBuilderForm(
    formEl
  ) {


    formEl = $(formEl);


    const values = {};


    /*
    |--------------------------------------------------------------------------
    | Sincroniza os editores JSON antes da leitura
    |--------------------------------------------------------------------------
    */


    formEl.find(

      '[data-automator-json-editor="true"]'

    ).each(function() {


      if(
        typeof AutomatorJsonEditorSyncValue ===
        'function'
      ) {


        AutomatorJsonEditorSyncValue(

          this,

          false

        );


      }


    });


    formEl.find(

      'input[name], select[name], textarea[name]'

    ).each(function() {


      const field = $(this);


      let fieldName = String(

        field.attr('name') || ''

      );


      if(fieldName == '') {

        return;

      }


      fieldName = fieldName.replace(

        /\[\]$/,

        ''

      );


      if(field.is(':checkbox')) {


        if(field.prop('checked') !== true) {

          return;

        }


        if(
          Object.prototype.hasOwnProperty.call(
            values,
            fieldName
          ) !== true
        ) {

          values[fieldName] = [];

        }


        values[fieldName].push(

          field.val()

        );


        return;

      }


      if(
        field.is(':radio') &&
        field.prop('checked') !== true
      ) {

        return;

      }


      values[fieldName] = field.val();


    });


    return values;


  }


  /*
  |--------------------------------------------------------------------------
  | Gera a chamada AutomatorPaginationCreateModalForm
  |--------------------------------------------------------------------------
  */


  function buildPaginationButtonModalFormOnclick(
    values = {}
  ) {


    values = normalizePlainObject(

      values

    );


    const formName = String(

      values.form || ''

    ).trim();


    const formID = getPaginationButtonFormIDByName(

      formName

    );


    if(formID == '') {

      return '';

    }


    const title = escapePaginationButtonJavascriptString(

      values.title || ''

    );


    const size = normalizePaginationButtonModalSize(

      values.size || 'lg'

    );


    const loadAction = getPaginationButtonActionNameByRoute(

      values.loadRoute || ''

    );


    const submitAction = getPaginationButtonActionNameByRoute(

      values.submitRoute || ''

    );


    const submitMethod = String(

      values.submitMethod || 'POST'

    )
      .trim()
      .toUpperCase();


    let idValue = 'null';


    if(loadAction != '') {

      idValue = '{id}';

    }


    let callbackBody = '';


    if(submitAction != '') {


      callbackBody +=

        'AutomatorPaginationCreateModalFormCallBack([' +

          '{ method: \'' +

            escapePaginationButtonJavascriptString(

              submitMethod

            ) +

          '\', action: \'' +

            escapePaginationButtonJavascriptString(

              submitAction

            ) +

          '\' }' +

        ']);';


    }


    const customCallback =

      parseJsonToJavascriptCallback(

        values.callback

      );


    if(customCallback != '') {


      if(callbackBody != '') {

        callbackBody += ' ';

      }


      callbackBody += customCallback;


    }


    let callbackValue = 'null';


    if(callbackBody != '') {


      callbackValue =

        'function(response, modalEl, modal, recordData) { ' +

          callbackBody +

        ' }';


    }


    return (

      'AutomatorPaginationCreateModalForm(' +

        '\'modal-' +

          escapePaginationButtonJavascriptString(

            size

          ) +

        '\', ' +

        '\'' +

          title +

        '\', ' +

        formID +

        ', ' +

        (

          loadAction != ''

            ? '\'' +

                escapePaginationButtonJavascriptString(

                  loadAction

                ) +

              '\''

            : "''"

        ) +

        ', ' +

        idValue +

        ', ' +

        callbackValue +

      ');'

    );


  }



  /*
  |--------------------------------------------------------------------------
  | Normaliza função escrita no formulário auxiliar
  |--------------------------------------------------------------------------
  */


  function normalizePaginationButtonActionBuilderFunction(
    value = ''
  ) {


    value = String(

      value || ''

    ).trim();


    if(value == '') {

      return '';

    }


    if(
      /^function\s*\(/.test(
        value
      ) ||
      /^\([^)]*\)\s*=>/.test(
        value
      ) ||
      /^[a-zA-Z_$][a-zA-Z0-9_$]*$/.test(
        value
      )
    ) {

      return value;

    }


    return (

      'function(response, modalEl, modal, recordData) { ' +

        value +

      ' }'

    );


  }

  /*
  |--------------------------------------------------------------------------
  | Gera a chamada AutomatorCreateViewModal
  |--------------------------------------------------------------------------
  */


  function buildPaginationButtonModalViewOnclick(
    values = {}
  ) {


    values = normalizePlainObject(

      values

    );


    const viewName = String(

      values.view || ''

    ).trim();


    if(viewName == '') {

      return '';

    }


    const title = String(

      values.title || ''

    ).trim();


    const size = normalizePaginationButtonModalSize(

      values.size || 'lg'

    );


    const backdrop = AutomatorNormalizeBoolean(

      values.backdrop

    );


    const keyboard = AutomatorNormalizeBoolean(

      values.keyboard

    );


    const scrollable = AutomatorNormalizeBoolean(

      values.scrollable

    );


    const callbackBody =

      parseJsonToJavascriptCallback(

        values.callback

      );


    const beforeShowBody =

      parseJsonToJavascriptCallback(

        values.beforeShow

      );


    const afterHideBody =

      parseJsonToJavascriptCallback(

        values.afterHide

      );


    const callback =

      normalizePaginationButtonActionBuilderFunction(

        callbackBody

      );


    const beforeShow =

      normalizePaginationButtonActionBuilderFunction(

        beforeShowBody

      );


    const afterHide =

      normalizePaginationButtonActionBuilderFunction(

        afterHideBody

      );


    const payloadItems = [

      "view: '" +

        escapePaginationButtonJavascriptString(

          viewName

        ) +

      "'",

    ];


    if(title != '') {


      payloadItems.push(

        "title: '" +

          escapePaginationButtonJavascriptString(

            title

          ) +

        "'"

      );


    }


    const optionItems = [

      "size: '" +

        escapePaginationButtonJavascriptString(

          size

        ) +

      "'",

      'backdrop: ' +

        (

          backdrop === true

            ? 'true'

            : 'false'

        ),

      'keyboard: ' +

        (

          keyboard === true

            ? 'true'

            : 'false'

        ),

      'scrollable: ' +

        (

          scrollable === true

            ? 'true'

            : 'false'

        ),

    ];


    if(callback != '') {

      optionItems.push(

        'callback: ' +

        callback

      );

    }


    if(beforeShow != '') {

      optionItems.push(

        'beforeShow: ' +

        beforeShow

      );

    }


    if(afterHide != '') {

      optionItems.push(

        'afterHideOn: ' +

        afterHide

      );

    }


    return (

      'AutomatorCreateViewModal(' +

        '{ ' +

          payloadItems.join(', ') +

        ' }, ' +

        '{ ' +

          optionItems.join(', ') +

        ' }' +

      ');'

    );


  }


  /*
  |--------------------------------------------------------------------------
  | Gera o onclick pelo formulário auxiliar
  |--------------------------------------------------------------------------
  */


  function buildPaginationButtonActionOnclick(
    mode = '',
    values = {}
  ) {


    if(mode == 'modal-form') {

      return buildPaginationButtonModalFormOnclick(

        values

      );

    }


    if(mode == 'modal-view') {

      return buildPaginationButtonModalViewOnclick(

        values

      );

    }


    return '';


  }


  /*
  |--------------------------------------------------------------------------
  | Atualiza a aparência do campo Click
  |--------------------------------------------------------------------------
  */


  function updatePaginationButtonClickFieldLayout(
    item,
    focusInput = false
  ) {


    item = $(item);


    if(!item.length) {

      return false;

    }


    const modeSelect = item.find(

      '.automator-pagination-editor-button-click-mode'

    ).first();


    const clickInput = item.find(

      selectors.paginationButtonOnclick

    ).first();


    const editButton = item.find(

      '.automator-pagination-editor-button-click-edit'

    ).first();


    const mode = String(

      modeSelect.val() || ''

    ).trim();


    if(mode == '') {


      clickInput
        .prop(
          'disabled',
          true
        )
        .prop(
          'readonly',
          false
        );


      editButton.addClass(

        'd-none'

      );


      return true;


    }


    clickInput.prop(

      'disabled',

      false

    );


    if(mode == 'manual') {


      clickInput.prop(

        'readonly',

        false

      );


      editButton.addClass(

        'd-none'

      );


      if(focusInput === true) {


        setTimeout(function() {


          clickInput.trigger(

            'focus'

          );


        }, 30);


      }


      return true;


    }


    clickInput.prop(

      'readonly',

      true

    );


    editButton.removeClass(

      'd-none'

    );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Acrescenta seletor e botão ao campo Click já renderizado
  |--------------------------------------------------------------------------
  */


  function enhancePaginationButtonClickEditor(
    item
  ) {


    item = $(item);


    if(!item.length) {

      return false;

    }


    const clickInput = item.find(

      selectors.paginationButtonOnclick

    ).first();


    if(!clickInput.length) {

      return false;

    }


    if(
      item.find(
        '.automator-pagination-editor-button-click-mode'
      ).length
    ) {

      updatePaginationButtonClickFieldLayout(

        item,

        false

      );


      return true;

    }


    const currentValue = String(

      clickInput.val() || ''

    );


    const currentMode = detectPaginationButtonClickMode(

      currentValue

    );


    const clickContainer = clickInput.closest(

      '.mb-3'

    );


    clickContainer.empty();


    const uniqueID = String(

      item.attr(
        'data-button-uid'
      ) || Date.now()

    );


    const modeID =

      'automator-pagination-button-click-mode-' +

      uniqueID;


    const inputID =

      'automator-pagination-button-click-value-' +

      uniqueID;


    const modeWrapper = $(

      '<div class="form-floating mb-2">' +

        '<select ' +

          'id="' +

            escapeHtml(

              modeID

            ) +

          '" ' +

          'class="' +

            'form-select form-select-sm ' +

            'automator-pagination-editor-button-click-mode' +

          '"' +

        '>' +

          '<option value=""' +

            (

              currentMode == ''

                ? ' selected'

                : ''

            ) +

          ' disabled>' +

            '- Selecione -' +

          '</option>' +

          '<option value="manual"' +

            (

              currentMode == 'manual'

                ? ' selected'

                : ''

            ) +

          '>' +

            'Manual' +

          '</option>' +

          '<option value="modal-form"' +

            (

              currentMode == 'modal-form'

                ? ' selected'

                : ''

            ) +

          '>' +

            'Formulário' +

          '</option>' +

          '<option value="modal-view"' +

            (

              currentMode == 'modal-view'

                ? ' selected'

                : ''

            ) +

          '>' +

            'Carregador de View' +

          '</option>' +

        '</select>' +

        '<label for="' +

          escapeHtml(

            modeID

          ) +

        '">' +

          'Tipo do Click' +

        '</label>' +

      '</div>'

    );


    const inputGroup = $(

      '<div class="input-group input-group-sm">' +

        '<div class="form-floating">' +

          '<input ' +

            'type="text" ' +

            'id="' +

              escapeHtml(

                inputID

              ) +

            '" ' +

            'class="' +

              'form-control form-control-sm ' +

              'automator-pagination-editor-button-onclick' +

            '" ' +

            'placeholder="Click" ' +

            'value="' +

              escapeHtml(

                currentValue

              ) +

            '" ' +

          '/>' +

          '<label for="' +

            escapeHtml(

              inputID

            ) +

          '">' +

            'Click' +

          '</label>' +

        '</div>' +

        '<button ' +

          'type="button" ' +

          'class="' +

            'btn btn-outline-secondary ' +

            'd-flex align-items-center justify-content-center ' +

            'automator-pagination-editor-button-click-edit ' +

            'd-none' +

          '" ' +

          'style="' +

            'min-width: 40px; ' +

            'width: 40px; ' +

            'padding-left: 0; ' +

            'padding-right: 0;' +

          '" ' +

          'data-bs-toggle="tooltip" ' +

          'data-bs-placement="top" ' +

          'data-bs-title="Editar Ação" ' +

          'title="Editar Ação"' +

        '>' +

          '<i class="fa fa-mouse"></i>' +

        '</button>' +

      '</div>'

    );


    clickContainer.append(

      modeWrapper

    );


    clickContainer.append(

      inputGroup

    );


    updatePaginationButtonClickFieldLayout(

      item,

      false

    );


    refreshTooltips();


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Fecha o formulário auxiliar sem submetê-lo ao backend
  |--------------------------------------------------------------------------
  */


  function closePaginationButtonActionBuilderModal(
    modalEl
  ) {


    if(!modalEl) {

      return false;

    }


    const formEl = modalEl.querySelector(

      'form'

    );


    if(formEl) {


      formEl.setAttribute(

        'data-submit',

        'true'

      );


      formEl.setAttribute(

        'data-automator-form-changed',

        'false'

      );


    }


    const modalInstance =

      bootstrap.Modal.getInstance(

        modalEl

      );


    if(modalInstance) {

      modalInstance.hide();

    } else {

      modalEl.remove();

    }


    return true;


  }

  /*
  |--------------------------------------------------------------------------
  | Abre o formulário auxiliar do campo Click
  |--------------------------------------------------------------------------
  */


  function openPaginationButtonActionBuilder(
    item
  ) {


    item = $(item);


    if(!item.length) {

      return false;

    }


    focusPaginationButtonEditorItem(

      item,

      true,

      false

    );


    const mode = String(

      item.find(
        '.automator-pagination-editor-button-click-mode'
      ).val() || ''

    ).trim();


    if(
      mode != 'modal-form' &&
      mode != 'modal-view'
    ) {

      return false;

    }


    /*
    |--------------------------------------------------------------------------
    | Reprocessa os dados recebidos antes de procurar o formulário
    |--------------------------------------------------------------------------
    */


    applyPaginationButtonActionBuilderResponse(

      state.editorResponse

    );


    applyPaginationButtonActionBuilderResponse(

      normalizePlainObject(

        state.editorResponse.data

      )

    );


    applyPaginationButtonActionBuilderResponse(

      normalizePlainObject(

        state.editorResponse.dados

      )

    );


    applyPaginationButtonActionBuilderResponse(

      state.recordData

    );


    const builderForm =

      getPaginationButtonActionBuilderForm(

        mode

      );


    const builderFormID = String(

      builderForm.id ||

      builderForm.tbl_sys_form_ID ||

      ''

    ).trim();


    if(builderFormID == '') {


      const expectedFormName =

        mode == 'modal-form'

          ? 'admin-open-form-modal'

          : 'admin-open-view-modal';


      AutomatorCreateAutoCloseToastAlert(

        'automator-pagination-action-builder-form-not-found',

        'center',

        'middle',

        true,

        true,

        'Formulário não encontrado',

        'O formulário ' +

        expectedFormName +

        ' não foi enviado nos dados de inicialização do editor de paginação.',

        null,

        false,

        null,

        5000

      );


      return false;


    }


    const clickInput = item.find(

      selectors.paginationButtonOnclick

    ).first();


    const values = getPaginationButtonActionBuilderValues(

      mode,

      clickInput.val()

    );


    const loaderHold =

      startPaginationButtonActionBuilderLoaderHold();


    AutomatorPaginationCreateModalForm(

      'modal-lg',

      'Editar Ação',

      builderFormID,

      '',

      null,

      function(
        response,
        modalEl,
        modal,
        recordData
      ) {


        preparePaginationButtonActionBuilderModalStack(

          modalEl

        );


        normalizePaginationButtonActionBuilderSelectOptions(

          modalEl

        );


        populatePaginationButtonActionBuilderForm(

          modalEl,

          values

        );


        const formEl = modalEl.querySelector(

          'form'

        );


        if(!formEl) {


          if(
            loaderHold &&
            typeof loaderHold.release === 'function'
          ) {

            loaderHold.release();

          }


          return false;

        }


        const submitHandler = function(event) {


          event.preventDefault();

          event.stopPropagation();

          event.stopImmediatePropagation();


          const builderValues =

            serializePaginationButtonActionBuilderForm(

              formEl

            );


          const onclickValue =

            buildPaginationButtonActionOnclick(

              mode,

              builderValues

            );


          if(onclickValue == '') {


            AutomatorCreateAutoCloseToastAlert(

              'automator-pagination-action-builder-invalid',

              'center',

              'middle',

              true,

              true,

              'Configuração incompleta',

              'Preencha os campos obrigatórios antes de gerar a ação.',

              null,

              false,

              null,

              5000

            );


            return false;

          }


          clickInput.val(

            onclickValue

          );


          syncPaginationButtonsState();


          setSaveState(

            true

          );


          closePaginationButtonActionBuilderModal(

            modalEl

          );


          return false;


        };


        formEl.addEventListener(

          'submit',

          submitHandler,

          true

        );


        const submitButton = modalEl.querySelector(

          '.js-automator-pagination-modal-submit'

        );


        if(submitButton) {


          submitButton.innerHTML =

            '<i class="fa fa-code me-1"></i>' +

            'Gerar Código';


          submitButton.disabled = false;


        }


        if(
          typeof AutomatorInitBootstrapTooltips ===
          'function'
        ) {

          AutomatorInitBootstrapTooltips(

            modalEl

          );

        }


        requestAnimationFrame(function() {


          requestAnimationFrame(function() {


            if(
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


            formEl.setAttribute(

              'data-automator-form-changed',

              'false'

            );


            if(
              loaderHold &&
              typeof loaderHold.release === 'function'
            ) {

              loaderHold.release(function() {


                AutomatorSetActionStatus(

                  false

                );


              });

            } else {


              $('#page-loader').css(

                'z-index',

                ''

              );


              AutomatorPageLoader(

                'hide',

                function() {


                  AutomatorSetActionStatus(

                    false

                  );


                }

              );


            }


          });


        });


        return true;


      }

    );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Eventos do seletor e botão do campo Click
  |--------------------------------------------------------------------------
  */


  function bindPaginationButtonClickBuilderEvents() {


    $(document)
      .off(
        'click.automator-pagination-editor-button-focus',
        selectors.paginationButtonItem
      )
      .on(
        'click.automator-pagination-editor-button-focus',
        selectors.paginationButtonItem,
        function(event) {


          const target = $(

            event.target

          );


          const item = $(this);


          const interactiveElement = target.closest(

            [

              'input',
              'select',
              'textarea',
              'option',
              'label',
              'button',
              'a',
              '.dropdown-menu',
              '.automator-pagination-editor-button-icon-results',
              '.automator-pagination-editor-button-class-autocomplete',

            ].join(', ')

          );


          if(interactiveElement.length) {

            return true;

          }


          focusPaginationButtonEditorItem(

            item,

            true,

            false

          );


          return true;


        }
      );


    $(document)
      .off(
        'click.automator-pagination-editor-button-header-focus',
        selectors.paginationButtonItem +
        ' .accordion-header, ' +
        selectors.paginationButtonItem +
        ' .accordion-button'
      )
      .on(
        'click.automator-pagination-editor-button-header-focus',
        selectors.paginationButtonItem +
        ' .accordion-header, ' +
        selectors.paginationButtonItem +
        ' .accordion-button',
        function() {


          const item = $(this).closest(

            selectors.paginationButtonItem

          );


          focusPaginationButtonEditorItem(

            item,

            false,

            false

          );


        }
      );


    $(document)
      .off(
        'focusin.automator-pagination-editor-button-field-focus',
        selectors.paginationButtonItem +
        ' input, ' +
        selectors.paginationButtonItem +
        ' select, ' +
        selectors.paginationButtonItem +
        ' textarea'
      )
      .on(
        'focusin.automator-pagination-editor-button-field-focus',
        selectors.paginationButtonItem +
        ' input, ' +
        selectors.paginationButtonItem +
        ' select, ' +
        selectors.paginationButtonItem +
        ' textarea',
        function() {


          const item = $(this).closest(

            selectors.paginationButtonItem

          );


          $(selectors.paginationButtonItem)
            .removeClass(
              'border-primary shadow-sm'
            );


          item.addClass(

            'border-primary shadow-sm'

          );


        }
      );


    $(document)
      .off(
        'change.automator-pagination-editor-button-click-mode',
        '.automator-pagination-editor-button-click-mode'
      )
      .on(
        'change.automator-pagination-editor-button-click-mode',
        '.automator-pagination-editor-button-click-mode',
        function() {


          const select = $(this);


          const item = select.closest(

            selectors.paginationButtonItem

          );


          const clickInput = item.find(

            selectors.paginationButtonOnclick

          ).first();


          focusPaginationButtonEditorItem(

            item,

            true,

            false

          );


          /*
          |--------------------------------------------------------------------------
          | A alteração manual do tipo sempre inicia uma nova configuração
          |--------------------------------------------------------------------------
          */


          clickInput.val(

            ''

          );


          updatePaginationButtonClickFieldLayout(

            item,

            true

          );


          syncPaginationButtonsState();


          setSaveState(

            true

          );


        }
      );


    $(document)
      .off(
        'click.automator-pagination-editor-button-click-edit',
        '.automator-pagination-editor-button-click-edit'
      )
      .on(
        'click.automator-pagination-editor-button-click-edit',
        '.automator-pagination-editor-button-click-edit',
        function(event) {


          event.preventDefault();

          event.stopPropagation();

          event.stopImmediatePropagation();


          const item = $(this).closest(

            selectors.paginationButtonItem

          );


          focusPaginationButtonEditorItem(

            item,

            true,

            false

          );


          openPaginationButtonActionBuilder(

            item

          );


          return false;


        }
      );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Cria a seção de filtros de consultas
  |--------------------------------------------------------------------------
  */


  function initializePaginationQueryFiltersSection() {


    const settingsContainer = $(

      '#automator-pagination-editor-aside-right-tabs-container-pagination-settings'

    );


    if(!settingsContainer.length) {

      return false;

    }


    let section = $(

      '#automator-pagination-editor-query-filters'

    );


    if(section.length) {

      return section;

    }


    section = $(

      '<section ' +

        'id="automator-pagination-editor-query-filters" ' +

        'class="border-top mt-3"' +

      '>' +

        '<div class="p-3 border-bottom bg-light">' +

          '<h6 class="mb-1 fw-bold">' +

            'Filtro de Consultas' +

          '</h6>' +

          '<p class="small text-muted mb-0">' +

            'Filtre os dados da paginação através das condições abaixo' +

          '</p>' +

        '</div>' +

        '<div ' +

          'class="' +

            'automator-pagination-editor-query-filters-disabled-message ' +

            'small text-muted text-center border-bottom p-3' +

          '"' +

        '>' +

          '<i class="fa fa-lock me-1"></i>' +

          'Selecione uma tabela e uma chave primária para configurar os filtros.' +

        '</div>' +

        '<div ' +

          'class="automator-pagination-editor-query-filters-content p-3"' +

        '>' +

          '<div ' +

            'class="automator-pagination-editor-query-filters-list" ' +

            'data-empty="Nenhum filtro adicionado."' +

          '></div>' +

          '<button ' +

            'type="button" ' +

            'class="' +

              'btn btn-sm btn-outline-primary w-100 ' +

              'automator-pagination-editor-query-filter-add' +

            '"' +

          '>' +

            '<i class="fa fa-plus me-1"></i>' +

            'Adicionar Filtro' +

          '</button>' +

        '</div>' +

      '</section>'

    );


    settingsContainer.append(

      section

    );


    updatePaginationQueryFiltersEmptyState();

    updatePaginationQueryFiltersAvailability();


    return section;


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza o comparador lógico do filtro
  |--------------------------------------------------------------------------
  */


  function normalizePaginationQueryFilterConnector(
    connector = 'AND'
  ) {


    connector = String(

      connector || 'AND'

    )
      .trim()
      .toUpperCase();


    return connector == 'OR'

      ? 'OR'

      : 'AND';


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza um filtro da paginação
  |--------------------------------------------------------------------------
  */


  function normalizePaginationQueryFilter(
    filter = {},
    index = 0
  ) {


    let column = '';

    let operator = '==';

    let value = '';

    let connector = 'AND';


    if(Array.isArray(filter)) {


      column = String(

        filter[0] || ''

      ).trim();


      operator = String(

        filter[1] || '=='

      ).trim();


      value =

        filter[2] === null ||
        filter[2] === undefined

          ? ''

          : String(

              filter[2]

            );


      connector = normalizePaginationQueryFilterConnector(

        filter[3] || 'AND'

      );


    } else {


      filter = normalizePlainObject(

        filter

      );


      column = String(

        filter.column ||

        filter.key ||

        filter.field ||

        filter.name ||

        filter[0] ||

        ''

      ).trim();


      operator = String(

        filter.operator ||

        filter.compare ||

        filter.comparison ||

        filter[1] ||

        '=='

      ).trim();


      value =

        filter.value !== undefined

          ? filter.value

          : filter[2] !== undefined

            ? filter[2]

            : '';


      value =

        value === null ||
        value === undefined

          ? ''

          : String(value);


      connector = normalizePaginationQueryFilterConnector(

        filter.connector ||

        filter.boolean ||

        filter.logical ||

        filter.comparator ||

        filter[3] ||

        'AND'

      );


    }


    /*
    |--------------------------------------------------------------------------
    | Converte operadores do banco para as opções visuais do editor
    |--------------------------------------------------------------------------
    */


    const visualOperators = {

      '=':   '==',

      '==':  '==',

      '===': '==',

      '!=':  '!=',

      '<>':  '!=',

      '!==': '!=',

    };


    if(
      Object.prototype.hasOwnProperty.call(

        visualOperators,

        operator

      )
    ) {

      operator = visualOperators[operator];

    }


    if(index <= 0) {

      connector = 'AND';

    }


    return {

      column: column,

      operator:

        operator != ''

          ? operator

          : '==',

      value: value,

      connector: connector,

    };


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza a lista de filtros
  |--------------------------------------------------------------------------
  */


  function normalizePaginationQueryFilters(
    filters = []
  ) {


    if(
      filters === null ||
      filters === undefined ||
      filters === ''
    ) {

      return [];

    }


    if(typeof filters === 'string') {


      try {


        filters = JSON.parse(

          filters

        );


      } catch(error) {


        return [];


      }


    }


    if(
      filters &&
      typeof filters === 'object' &&
      !Array.isArray(filters)
    ) {

      filters = Object.keys(

        filters

      ).map(function(key) {


        return filters[key];


      });


    }


    if(!Array.isArray(filters)) {

      return [];

    }


    return filters.map(function(
      filter,
      index
    ) {


      return normalizePaginationQueryFilter(

        filter,

        index

      );


    });


  }


  /*
  |--------------------------------------------------------------------------
  | Opções de colunas disponíveis para o filtro
  |--------------------------------------------------------------------------
  */


  function getPaginationQueryFilterColumnOptions(
    selectedColumn = ''
  ) {


    selectedColumn = String(

      selectedColumn || ''

    ).trim();


    const columns = getAvailableTableColumns();


    let html =

      '<option value="" disabled' +

        (

          selectedColumn == ''

            ? ' selected'

            : ''

        ) +

      '>' +

        '- Selecione -' +

      '</option>';


    Object.keys(

      columns

    ).forEach(function(columnName) {


      html +=

        '<option value="' +

          escapeHtml(

            columnName

          ) +

        '"' +

        (

          columnName == selectedColumn

            ? ' selected'

            : ''

        ) +

        '>' +

          escapeHtml(

            columns[columnName]

          ) +

        '</option>';


    });


    /*
    |--------------------------------------------------------------------------
    | Mantém uma coluna antiga que não esteja mais na resposta atual
    |--------------------------------------------------------------------------
    */


    if(
      selectedColumn != '' &&
      !Object.prototype.hasOwnProperty.call(
        columns,
        selectedColumn
      )
    ) {


      html +=

        '<option value="' +

          escapeHtml(

            selectedColumn

          ) +

        '" selected>' +

          escapeHtml(

            selectedColumn

          ) +

        '</option>';


    }


    return html;


  }


  /*
  |--------------------------------------------------------------------------
  | Opções de operadores dos filtros
  |--------------------------------------------------------------------------
  */


  function getPaginationQueryFilterOperatorOptions(
    selectedOperator = '=='
  ) {


    selectedOperator = String(

      selectedOperator || '=='

    ).trim();


    const operators = {

      '==': 'É igual a',

      '!=': 'Não é igual',

    };


    let html =

      '<option value="" disabled' +

        (

          selectedOperator == ''

            ? ' selected'

            : ''

        ) +

      '>' +

        '- Selecione -' +

      '</option>';


    if(
      selectedOperator != '' &&
      !Object.prototype.hasOwnProperty.call(
        operators,
        selectedOperator
      )
    ) {


      html +=

        '<option value="' +

          escapeHtml(

            selectedOperator

          ) +

        '" selected>' +

          escapeHtml(

            selectedOperator

          ) +

        '</option>';


    }


    Object.keys(

      operators

    ).forEach(function(operator) {


      html +=

        '<option value="' +

          escapeHtml(

            operator

          ) +

        '"' +

        (

          operator == selectedOperator

            ? ' selected'

            : ''

        ) +

        '>' +

          escapeHtml(

            operators[operator]

          ) +

        '</option>';


    });


    return html;


  }



  /*
  |--------------------------------------------------------------------------
  | Opções de comparação lógica
  |--------------------------------------------------------------------------
  */


  function getPaginationQueryFilterConnectorOptions(
    selectedConnector = 'AND'
  ) {


    selectedConnector = normalizePaginationQueryFilterConnector(

      selectedConnector

    );


    return (

      '<option value="AND"' +

        (

          selectedConnector == 'AND'

            ? ' selected'

            : ''

        ) +

      '>' +

        'E' +

      '</option>' +

      '<option value="OR"' +

        (

          selectedConnector == 'OR'

            ? ' selected'

            : ''

        ) +

      '>' +

        'Ou' +

      '</option>'

    );


  }


  /*
  |--------------------------------------------------------------------------
  | Renderiza um card de filtro
  |--------------------------------------------------------------------------
  */


  function renderPaginationQueryFilterCard(
    filter = {},
    openCard = true
  ) {


    filter = normalizePaginationQueryFilter(

      filter

    );


    const filterUID =

      'automator-pagination-query-filter-' +

      Date.now() +

      '-' +

      Math.floor(

        Math.random() * 999999

      );


    const card = $(

      '<div ' +

        'class="' +

          'card shadow-sm mb-3 ' +

          'automator-pagination-editor-query-filter-item' +

        '" ' +

        'data-filter-uid="' +

          escapeHtml(

            filterUID

          ) +

        '"' +

      '>' +

        '<div class="card-header p-0 bg-white">' +

          '<div class="d-flex align-items-center">' +

            '<button ' +

              'type="button" ' +

              'class="' +

                'btn border-0 px-3 py-2 ' +

                'automator-pagination-editor-query-filter-sort-handle' +

              '" ' +

              'title="Ordenar filtro"' +

            '>' +

              '<i class="fa fa-grip-vertical text-muted"></i>' +

            '</button>' +

            '<button ' +

              'type="button" ' +

              'class="' +

                'btn border-0 text-start flex-grow-1 py-2 ' +

                'automator-pagination-editor-query-filter-collapse' +

                (

                  openCard === true

                    ? ''

                    : ' collapsed'

                ) +

              '" ' +

              'data-bs-toggle="collapse" ' +

              'data-bs-target="#' +

                escapeHtml(

                  filterUID

                ) +

              '-body" ' +

              'aria-expanded="' +

                (

                  openCard === true

                    ? 'true'

                    : 'false'

                ) +

              '"' +

            '>' +

              '<span class="' +

                'fw-semibold small ' +

                'automator-pagination-editor-query-filter-title' +

              '">' +

                'Filtro' +

              '</span>' +

              '<i class="' +

                'fa float-end mt-1 ' +

                (

                  openCard === true

                    ? 'fa-chevron-up'

                    : 'fa-chevron-down'

                ) +

              '"></i>' +

            '</button>' +

          '</div>' +

        '</div>' +

        '<div ' +

          'id="' +

            escapeHtml(

              filterUID

            ) +

          '-body" ' +

          'class="' +

            'collapse automator-pagination-editor-query-filter-body' +

            (

              openCard === true

                ? ' show'

                : ''

            ) +

          '"' +

        '>' +

          '<div class="card-body p-2">' +

            '<div class="mb-2">' +

              '<label class="form-label small fw-semibold mb-1">' +

                'Coluna <span class="text-danger">*</span>' +

              '</label>' +

              '<select ' +

                'class="' +

                  'form-select form-select-sm ' +

                  'automator-pagination-editor-query-filter-column' +

                '" ' +

                'required' +

              '>' +

                getPaginationQueryFilterColumnOptions(

                  filter.column

                ) +

              '</select>' +

            '</div>' +

            '<div class="mb-2">' +

              '<label class="form-label small fw-semibold mb-1">' +

                'Condição <span class="text-danger">*</span>' +

              '</label>' +

              '<select ' +

                'class="' +

                  'form-select form-select-sm ' +

                  'automator-pagination-editor-query-filter-operator' +

                '" ' +

                'required' +

              '>' +

                getPaginationQueryFilterOperatorOptions(

                  filter.operator

                ) +

              '</select>' +

            '</div>' +

            '<div class="mb-2">' +

              '<label class="form-label small fw-semibold mb-1">' +

                'Valor' +

              '</label>' +

              '<input ' +

                'type="text" ' +

                'class="' +

                  'form-control form-control-sm ' +

                  'automator-pagination-editor-query-filter-value' +

                '" ' +

                'autocomplete="off" ' +

                'value="' +

                  escapeHtml(

                    filter.value

                  ) +

                '"' +

              '/>' +

            '</div>' +

            '<div class="mb-2">' +

              '<label class="form-label small fw-semibold mb-1">' +

                'Comparador <span class="text-danger">*</span>' +

              '</label>' +

              '<select ' +

                'class="' +

                  'form-select form-select-sm ' +

                  'automator-pagination-editor-query-filter-connector' +

                '" ' +

                'required' +

              '>' +

                getPaginationQueryFilterConnectorOptions(

                  filter.connector

                ) +

              '</select>' +

            '</div>' +

            '<button ' +

              'type="button" ' +

              'class="' +

                'btn btn-sm btn-outline-danger w-100 ' +

                'automator-pagination-editor-query-filter-delete' +

              '"' +

            '>' +

              '<i class="fa fa-trash me-1"></i>' +

              'Excluir Filtro' +

            '</button>' +

          '</div>' +

        '</div>' +

      '</div>'

    );


    return card;


  }



  /*
  |--------------------------------------------------------------------------
  | Atualiza o ícone do collapse do filtro
  |--------------------------------------------------------------------------
  */


  function updatePaginationQueryFilterCollapseIcon(
    card,
    opened = null
  ) {


    card = $(card);


    if(!card.length) {

      return false;

    }


    const collapseButton = card.find(

      '.automator-pagination-editor-query-filter-collapse'

    ).first();


    const body = card.find(

      '.automator-pagination-editor-query-filter-body'

    ).first();


    if(
      !collapseButton.length ||
      !body.length
    ) {

      return false;

    }


    if(opened === null) {

      opened = body.hasClass(

        'show'

      );

    }


    collapseButton
      .toggleClass(

        'collapsed',

        opened !== true

      )
      .attr(

        'aria-expanded',

        opened === true

          ? 'true'

          : 'false'

      );


    collapseButton
      .find('i')
      .removeClass(

        'fa-chevron-up fa-chevron-down'

      )
      .addClass(

        opened === true

          ? 'fa-chevron-up'

          : 'fa-chevron-down'

      );


    return true;


  }



  /*
  |--------------------------------------------------------------------------
  | Estado vazio da lista de filtros
  |--------------------------------------------------------------------------
  */


  function updatePaginationQueryFiltersEmptyState() {


    const list = $(

      '.automator-pagination-editor-query-filters-list'

    );


    if(!list.length) {

      return false;

    }


    list.find(

      '.automator-pagination-editor-query-filters-empty'

    ).remove();


    if(
      list.find(
        '.automator-pagination-editor-query-filter-item'
      ).length <= 0
    ) {


      list.append(

        '<div class="' +

          'automator-pagination-editor-query-filters-empty ' +

          'small text-muted text-center border rounded ' +

          'p-3 mb-3' +

        '" style="' +

          'border-style: dashed !important;' +

        '">' +

          'Nenhum filtro adicionado.' +

        '</div>'

      );


    }


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Atualiza as colunas disponíveis nos filtros
  |--------------------------------------------------------------------------
  */


  function refreshPaginationQueryFilterColumnOptions() {


    $(

      '.automator-pagination-editor-query-filter-column'

    ).each(function() {


      const select = $(this);


      const currentValue = String(

        select.val() || ''

      ).trim();


      select.html(

        getPaginationQueryFilterColumnOptions(

          currentValue

        )

      );


      if(currentValue != '') {

        select.val(

          currentValue

        );

      }


    });


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza posição, título e comparador dos filtros
  |--------------------------------------------------------------------------
  */


  function normalizePaginationQueryFilterPositions() {


    const cards = $(

      '.automator-pagination-editor-query-filter-item'

    );


    cards.each(function(index) {


      const card = $(this);


      card.find(

        '.automator-pagination-editor-query-filter-title'

      ).text(

        'Filtro ' +

        (

          index + 1

        )

      );


      const connectorSelect = card.find(

        '.automator-pagination-editor-query-filter-connector'

      ).first();


      if(index <= 0) {


        connectorSelect
          .val(
            'AND'
          )
          .prop(
            'disabled',
            true
          )
          .addClass(
            'bg-light'
          );


      } else {


        connectorSelect
          .prop(
            'disabled',
            false
          )
          .removeClass(
            'bg-light'
          );


      }


    });


    if(cards.length == 1) {


      cards
        .first()
        .find(
          '.automator-pagination-editor-query-filter-connector'
        )
        .val(
          'AND'
        );


    }


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Verifica se existem filtros cadastrados
  |--------------------------------------------------------------------------
  */


  function hasPaginationQueryFilters() {


    return (

      $(

        '.automator-pagination-editor-query-filter-item'

      ).length >= 1

    );


  }


  /*
  |--------------------------------------------------------------------------
  | Libera ou bloqueia a seção de filtros
  |--------------------------------------------------------------------------
  */


  function updatePaginationQueryFiltersAvailability() {


    const section = $(

      '#automator-pagination-editor-query-filters'

    );


    if(!section.length) {

      return false;

    }


    const hasTable = String(

      $(selectors.table).val() || ''

    ).trim() != '';


    const hasIndex = String(

      $(selectors.index).val() || ''

    ).trim() != '';


    const enabled =

      hasTable === true &&

      hasIndex === true;


    section.find(

      '.automator-pagination-editor-query-filters-disabled-message'

    ).toggleClass(

      'd-none',

      enabled === true

    );


    section.find(

      '.automator-pagination-editor-query-filters-content'

    )
      .toggleClass(

        'opacity-50',

        enabled !== true

      )
      .css(

        'pointer-events',

        enabled === true

          ? ''

          : 'none'

      );


    section.find(

      '.automator-pagination-editor-query-filter-add'

    ).prop(

      'disabled',

      enabled !== true

    );


    section.find(

      '.automator-pagination-editor-query-filter-column, ' +

      '.automator-pagination-editor-query-filter-operator, ' +

      '.automator-pagination-editor-query-filter-value, ' +

      '.automator-pagination-editor-query-filter-delete, ' +

      '.automator-pagination-editor-query-filter-sort-handle'

    ).prop(

      'disabled',

      enabled !== true

    );


    normalizePaginationQueryFilterPositions();


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza o operador para armazenamento e execução no backend
  |--------------------------------------------------------------------------
  */


  function normalizePaginationQueryFilterOperatorForStorage(
    operator = '=='
  ) {


    operator = String(

      operator || '=='

    ).trim();


    const operators = {

      '==':  '=',

      '===': '=',

      '=':   '=',

      '!=':  '!=',

      '!==': '!=',

      '<>':  '!=',

      '>':   '>',

      '>=':  '>=',

      '<':   '<',

      '<=':  '<=',

      'like': 'like',

      'LIKE': 'like',

    };


    if(
      Object.prototype.hasOwnProperty.call(

        operators,

        operator

      )
    ) {

      return operators[operator];

    }


    return '=';


  }

  /*
  |--------------------------------------------------------------------------
  | Retorna os filtros na ordem visual
  |--------------------------------------------------------------------------
  */


  function getPaginationQueryFiltersData() {


    const filters = [];


    $(

      '.automator-pagination-editor-query-filter-item'

    ).each(function(index) {


      const card = $(this);


      const column = String(

        card.find(
          '.automator-pagination-editor-query-filter-column'
        ).val() || ''

      ).trim();


      const operator =

        normalizePaginationQueryFilterOperatorForStorage(

          card.find(
            '.automator-pagination-editor-query-filter-operator'
          ).val() || '=='

        );


      const valueInput = card.find(

        '.automator-pagination-editor-query-filter-value'

      ).first();


      const value = String(

        valueInput.val() === null ||
        valueInput.val() === undefined

          ? ''

          : valueInput.val()

      );


      let connector = normalizePaginationQueryFilterConnector(

        card.find(
          '.automator-pagination-editor-query-filter-connector'
        ).val() || 'AND'

      );


      /*
      |--------------------------------------------------------------------------
      | O primeiro filtro sempre inicia o grupo com AND
      |--------------------------------------------------------------------------
      */


      if(index <= 0) {

        connector = 'AND';

      }


      filters.push([

        column,

        operator,

        value,

        connector,

      ]);


    });


    return filters;


  }


  /*
  |--------------------------------------------------------------------------
  | Valida os filtros da consulta
  |--------------------------------------------------------------------------
  */


  function validatePaginationQueryFilters(
    errors = []
  ) {


    $(

      '.automator-pagination-editor-query-filter-item'

    ).each(function(index) {


      const card = $(this);


      const columnSelect = card.find(

        '.automator-pagination-editor-query-filter-column'

      ).first();


      const operatorSelect = card.find(

        '.automator-pagination-editor-query-filter-operator'

      ).first();


      const connectorSelect = card.find(

        '.automator-pagination-editor-query-filter-connector'

      ).first();


      const column = String(

        columnSelect.val() || ''

      ).trim();


      const operator = String(

        operatorSelect.val() || ''

      ).trim();


      let connector = normalizePaginationQueryFilterConnector(

        connectorSelect.val() || 'AND'

      );


      if(index <= 0) {

        connector = 'AND';

        connectorSelect.val(

          'AND'

        );

      }


      const columnValid =

        column != '';


      const operatorValid =

        operator != '';


      const connectorValid =

        [

          'AND',
          'OR',

        ].indexOf(

          connector

        ) >= 0;


      columnSelect.toggleClass(

        'is-invalid',

        columnValid !== true

      );


      operatorSelect.toggleClass(

        'is-invalid',

        operatorValid !== true

      );


      connectorSelect.toggleClass(

        'is-invalid',

        connectorValid !== true

      );


      if(columnValid !== true) {

        errors.push(

          'Selecione a coluna do filtro ' +

          (

            index + 1

          ) +

          '.'

        );

      }


      if(operatorValid !== true) {

        errors.push(

          'Selecione a condição do filtro ' +

          (

            index + 1

          ) +

          '.'

        );

      }


      if(connectorValid !== true) {

        errors.push(

          'Selecione o comparador do filtro ' +

          (

            index + 1

          ) +

          '.'

        );

      }


    });


    return errors;


  }


  /*
  |--------------------------------------------------------------------------
  | Sortable dos filtros
  |--------------------------------------------------------------------------
  */


  function initializePaginationQueryFiltersSortable() {


    const list = document.querySelector(

      '.automator-pagination-editor-query-filters-list'

    );


    if(!list) {

      return false;

    }


    const currentSortable = $(list).data(

      'automator-pagination-query-filters-sortable'

    );


    if(currentSortable) {


      try {

        currentSortable.destroy();

      } catch(error) {}


      $(list).removeData(

        'automator-pagination-query-filters-sortable'

      );


    }


    if(
      typeof Sortable === 'undefined'
    ) {

      return false;

    }


    const sortable = new Sortable(

      list,

      {

        animation: 150,

        handle:

          '.automator-pagination-editor-query-filter-sort-handle',

        draggable:

          '.automator-pagination-editor-query-filter-item',

        ghostClass:

          'border border-primary bg-light',

        chosenClass:

          'shadow',

        onStart: function() {


          hideEditorTooltips();


        },

        onEnd: function() {


          normalizePaginationQueryFilterPositions();

          updatePaginationQueryFiltersEmptyState();

          syncEditorState();

          setSaveState(

            true

          );


        },

      }

    );


    $(list).data(

      'automator-pagination-query-filters-sortable',

      sortable

    );


    return sortable;


  }


  /*
  |--------------------------------------------------------------------------
  | Adiciona um filtro
  |--------------------------------------------------------------------------
  */


  function addPaginationQueryFilter(
    filter = {},
    openCard = true,
    markChanged = true
  ) {


    const list = $(

      '.automator-pagination-editor-query-filters-list'

    );


    if(!list.length) {

      return false;

    }


    list.find(

      '.automator-pagination-editor-query-filters-empty'

    ).remove();


    const card = renderPaginationQueryFilterCard(

      filter,

      openCard

    );


    list.append(

      card

    );


    normalizePaginationQueryFilterPositions();

    updatePaginationQueryFiltersEmptyState();

    initializePaginationQueryFiltersSortable();

    updatePaginationQueryFiltersAvailability();


    if(markChanged === true) {


      syncEditorState();

      setSaveState(

        true

      );


      setTimeout(function() {


        card.find(

          '.automator-pagination-editor-query-filter-column'

        ).first().trigger(

          'focus'

        );


      }, 30);


    }


    return card;


  }



  /*
  |--------------------------------------------------------------------------
  | Inicializa os filtros do registro
  |--------------------------------------------------------------------------
  */


  function initializePaginationQueryFilters(
    recordData = {}
  ) {


    initializePaginationQueryFiltersSection();


    const list = $(

      '.automator-pagination-editor-query-filters-list'

    );


    if(!list.length) {

      return false;

    }


    list.empty();


    const filters = normalizePaginationQueryFilters(

      getPaginationRecordValue(

        recordData,

        [

          'where',

          'pagination_where',

          'tbl_sys_pagination_where',

          'pagination_args.where',

        ],

        []

      )

    );


    filters.forEach(function(
      filter,
      index
    ) {


      addPaginationQueryFilter(

        filter,

        index === 0,

        false

      );


    });


    updatePaginationQueryFiltersEmptyState();

    normalizePaginationQueryFilterPositions();

    initializePaginationQueryFiltersSortable();

    refreshPaginationQueryFilterColumnOptions();

    updatePaginationQueryFiltersAvailability();


    return true;


  }



  /*
  |--------------------------------------------------------------------------
  | Eventos dos filtros
  |--------------------------------------------------------------------------
  */


  function bindPaginationQueryFiltersEvents() {


    $(document)
      .off(
        'click.automator-pagination-editor-query-filter-add',
        '.automator-pagination-editor-query-filter-add'
      )
      .on(
        'click.automator-pagination-editor-query-filter-add',
        '.automator-pagination-editor-query-filter-add',
        function(event) {


          event.preventDefault();

          event.stopPropagation();


          if(
            String(
              $(selectors.table).val() || ''
            ).trim() == '' ||
            String(
              $(selectors.index).val() || ''
            ).trim() == ''
          ) {

            return false;

          }


          addPaginationQueryFilter(

            {

              column: '',

              operator: '==',

              value: '',

              connector:

                hasPaginationQueryFilters()

                  ? 'AND'

                  : 'AND',

            },

            true,

            true

          );


          return false;


        }
      );


    $(document)
      .off(
        'click.automator-pagination-editor-query-filter-delete',
        '.automator-pagination-editor-query-filter-delete'
      )
      .on(
        'click.automator-pagination-editor-query-filter-delete',
        '.automator-pagination-editor-query-filter-delete',
        function(event) {


          event.preventDefault();

          event.stopPropagation();


          $(this)
            .closest(
              '.automator-pagination-editor-query-filter-item'
            )
            .remove();


          normalizePaginationQueryFilterPositions();

          updatePaginationQueryFiltersEmptyState();

          initializePaginationQueryFiltersSortable();

          syncEditorState();

          setSaveState(

            true

          );


          return false;


        }
      );


    $(document)
      .off(
        'input.automator-pagination-editor-query-filter ' +
        'change.automator-pagination-editor-query-filter',
        [

          '.automator-pagination-editor-query-filter-column',

          '.automator-pagination-editor-query-filter-operator',

          '.automator-pagination-editor-query-filter-value',

          '.automator-pagination-editor-query-filter-connector',

        ].join(', ')
      )
      .on(
        'input.automator-pagination-editor-query-filter ' +
        'change.automator-pagination-editor-query-filter',
        [

          '.automator-pagination-editor-query-filter-column',

          '.automator-pagination-editor-query-filter-operator',

          '.automator-pagination-editor-query-filter-value',

          '.automator-pagination-editor-query-filter-connector',

        ].join(', '),
        function() {


          normalizePaginationQueryFilterPositions();

          validatePaginationQueryFilters(

            []

          );

          syncEditorState();

          setSaveState(

            true

          );


        }
      );


    $(document)
      .off(
        'shown.bs.collapse.automator-pagination-editor-query-filter',
        '.automator-pagination-editor-query-filter-body'
      )
      .on(
        'shown.bs.collapse.automator-pagination-editor-query-filter',
        '.automator-pagination-editor-query-filter-body',
        function() {


          updatePaginationQueryFilterCollapseIcon(

            $(this).closest(
              '.automator-pagination-editor-query-filter-item'
            ),

            true

          );


        }
      );


    $(document)
      .off(
        'hidden.bs.collapse.automator-pagination-editor-query-filter',
        '.automator-pagination-editor-query-filter-body'
      )
      .on(
        'hidden.bs.collapse.automator-pagination-editor-query-filter',
        '.automator-pagination-editor-query-filter-body',
        function() {


          updatePaginationQueryFilterCollapseIcon(

            $(this).closest(
              '.automator-pagination-editor-query-filter-item'
            ),

            false

          );


        }
      );


    return true;


  }
  /*
  |--------------------------------------------------------------------------
  | Inicialização
  |--------------------------------------------------------------------------
  */

  function init(callback = null) {


    if(!$(selectors.editor).length) {


      console.warn(
        'Container do editor de paginação não encontrado.'
      );


      return false;


    }


    state.suppressChangeTracking = true;


    registerActionSelectors();

    initializePaginationModalScroll();

    initializePaginationQueryFiltersSection();


    bindTableEvents();

    bindHeaderEvents();

    bindLeftTabsEvents();

    bindRightTabsEvents();

    bindChangeObserver();

    bindUnsavedModalCloseWarning();

    bindActionsEvents();

    bindPaginationActionCardEvents();

    bindPaginationActionNameAutocompleteEvents();

    bindPaginationSlugEvents();

    bindColumnsEvents();

    bindPaginationPreviewSettingsEvents();

    bindEditorColumnDeselection();

    bindPaginationAccessEvents();

    bindPaginationButtonsEvents();

    bindPaginationButtonIconSelectionEvents();

    bindPaginationButtonClassAutocompleteEvents();

    bindPaginationActionRolesEvents();

    bindPaginationQueryFiltersEvents();


    initializePanels();

    initializeColumnTypes();

    initializeActions();

    initializePaginationButtons();

    initializePaginationButtonClassAutocomplete();

    initializeStructureSortable();

    initializePaginationPreview();


    loadTables(function() {


      const recordTable = String(

        getPaginationRecordValue(

          state.recordData,

          [

            'tbl_sys_pagination_table',

            'table',

            'pagination_table',

          ],

          $(selectors.table).val() || ''

        )

      ).trim();


      const recordIndex = String(

        getPaginationRecordValue(

          state.recordData,

          [

            'tbl_sys_pagination_index',

            'index',

            'pagination_index',

          ],

          $(selectors.index).val() || ''

        )

      ).trim();


      if(recordTable != '') {

        $(selectors.table).val(

          recordTable

        );

      }


      state.selectedTable = recordTable;

      state.selectedIndex = recordIndex;


      if(recordTable != '') {


        loadTableColumns(

          recordTable,

          recordIndex,

          function() {


            applyPaginationEditorRecordData(

              state.recordData,

              function() {


                finishInitialization(

                  callback

                );


              }

            );


          },

          false

        );


        return;


      }


      applyPaginationEditorRecordData(

        state.recordData,

        function() {


          finishInitialization(

            callback

          );


        }

      );


    }, false);


    return true;


  }



  /*
  |--------------------------------------------------------------------------
  | Normaliza valor para slug
  |--------------------------------------------------------------------------
  */

  function normalizePaginationSlug(
    value = ''
  ) {


    value = String(

      value || ''

    );


    if(
      typeof value.normalize === 'function'
    ) {


      value = value
        .normalize(
          'NFD'
        )
        .replace(
          /[\u0300-\u036f]/g,
          ''
        );


    }


    return value
      .toLowerCase()
      .replace(
        /[^a-z0-9\s_-]/g,
        ''
      )
      .replace(
        /[\s_]+/g,
        '-'
      )
      .replace(
        /-+/g,
        '-'
      )
      .replace(
        /^-+/g,
        ''
      )
      .substring(
        0,
        255
      );


  }


  /*
  |--------------------------------------------------------------------------
  | Renderiza a pré-visualização do ícone do botão
  |--------------------------------------------------------------------------
  */

  function renderPaginationButtonIconPreview(
    item,
    iconName = ''
  ) {


    item = $(item);


    if(!item.length) {

      return false;

    }


    iconName = normalizePaginationButtonIcon(

      iconName

    );


    const preview = item.find(

      selectors.paginationButtonIconPreview

    ).first();


    if(!preview.length) {

      return false;

    }


    preview
      .addClass(

        'd-flex align-items-center justify-content-center text-center'

      )
      .css({

        minWidth: '50px',

      })
      .html(

        '<span class="' +

          'h-100 w-100 d-flex align-items-center ' +

          'justify-content-center text-center border-0' +

        '">' +

          '<i class="fa fa-' +

            escapeHtml(

              iconName ||

              'icons'

            ) +

          '"></i>' +

        '</span>'

      );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Evento de seleção do ícone do botão
  |--------------------------------------------------------------------------
  */

  function bindPaginationButtonIconSelectionEvents() {


    $(document)
      .off(
        'click.automator-pagination-editor-button-icon-result',
        '.automator-pagination-editor-button-icon-result'
      )
      .on(
        'click.automator-pagination-editor-button-icon-result',
        '.automator-pagination-editor-button-icon-result',
        function(event) {


          event.preventDefault();

          event.stopPropagation();

          event.stopImmediatePropagation();


          const result = $(this);


          const item = result.closest(

            selectors.paginationButtonItem

          );


          if(!item.length) {

            return false;

          }


          const iconName = normalizePaginationButtonIcon(

            result.attr(
              'data-icon'
            )

          );


          const hiddenInput = item.find(

            selectors.paginationButtonIconHidden

          ).first();


          const searchInput = item.find(

            selectors.paginationButtonIconSearch

          ).first();


          const results = item.find(

            selectors.paginationButtonIconResults

          ).first();


          hiddenInput.val(

            iconName

          );


          searchInput
            .val('')
            .attr(

              'placeholder',

              iconName != ''

                ? iconName

                : 'Buscar ícone...'

            );


          renderPaginationButtonIconPreview(

            item,

            iconName

          );


          results
            .empty()
            .addClass(
              'd-none'
            );


          syncPaginationButtonsState();

          setSaveState(

            true

          );


          return false;


        }
      );


    return true;


  }



  function initializePaginationModalScroll() {


    const editor = $(

      selectors.editor

    );


    if(!editor.length) {

      return false;

    }


    const modalBody = editor.closest(

      '.modal-body'

    );


    const modalContent = editor.closest(

      '.modal-content'

    );


    const modalDialog = editor.closest(

      '.modal-dialog'

    );


    modalDialog.css({

      height:    '100%',
      maxHeight: '100vh',
      margin:    '0',

    });


    modalContent.css({

      height:    '100%',
      maxHeight: '100vh',
      overflow:  'hidden',

    });


    modalBody.css({

      display:   'flex',
      flex:      '1 1 auto',
      minHeight: '0',
      height:    '100%',
      overflow:  'hidden',
      padding:   '0',

    });


    editor.css({

      display:   'flex',
      flexDirection: 'column',
      flex:      '1 1 auto',
      minHeight: '0',
      height:    '100%',
      maxHeight: '100%',
      overflow:  'hidden',

    });


    $(selectors.body).css({

      display:   'flex',
      flex:      '1 1 auto',
      minHeight: '0',
      height:    'auto',
      overflow:  'hidden',

    });


    $(selectors.canvas).css({

      minHeight: '0',
      overflowX: 'auto',
      overflowY: 'auto',

    });


    $(selectors.leftAside)
      .add(
        selectors.rightAside
      )
      .css({

        minHeight: '0',
        height:    '100%',
        maxHeight: '100%',
        overflow:  'hidden',

      });


    $(

      selectors.inserterPanel + ', ' +
      selectors.structurePanel + ', ' +
      selectors.buttonsPanel + ', ' +
      selectors.paginationPanel + ', ' +
      selectors.proprietiesPanel

    ).css({

      minHeight: '0',
      height:    '100%',
      maxHeight: '100%',
      overflowX: 'hidden',
      overflowY: 'auto',

    });


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza objeto
  |--------------------------------------------------------------------------
  */

  function normalizePlainObject(
    value,
    defaultValue = {}
  ) {


    if(
      value &&
      typeof value === 'object' &&
      !Array.isArray(value)
    ) {

      return value;

    }


    if(
      typeof value === 'string' &&
      value.trim() != ''
    ) {


      try {


        const decoded = JSON.parse(value);


        if(
          decoded &&
          typeof decoded === 'object' &&
          !Array.isArray(decoded)
        ) {

          return decoded;

        }


      } catch(e) {}


    }


    return $.extend(

      true,

      {},

      defaultValue

    );


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza lista
  |--------------------------------------------------------------------------
  */

  function normalizeArrayValue(value) {


    if(Array.isArray(value)) {

      return value;

    }


    if(
      value === null ||
      value === undefined ||
      value === ''
    ) {

      return [];

    }


    if(typeof value === 'string') {


      try {


        const decoded = JSON.parse(

          value

        );


        return normalizeArrayValue(

          decoded

        );


      } catch(e) {


        return value
          .split(',')
          .map(function(item) {


            return String(

              item || ''

            ).trim();


          })
          .filter(function(item) {


            return item != '';


          });


      }


    }


    if(
      value &&
      typeof value === 'object'
    ) {


      return Object.keys(

        value

      ).map(function(key) {


        return value[key];


      });


    }


    return [

      value

    ];


  }


  function normalizePaginationActionRoles(
    roles = []
  ) {


    if(
      roles === null ||
      roles === undefined ||
      roles === ''
    ) {

      return [];

    }


    if(typeof roles === 'string') {


      try {

        roles = JSON.parse(

          roles

        );

      } catch(e) {

        return [];

      }


    }


    if(
      roles &&
      typeof roles === 'object' &&
      !Array.isArray(roles)
    ) {


      roles = Object.keys(

        roles

      ).map(function(key) {


        return roles[key];


      });


    }


    if(!Array.isArray(roles)) {

      return [];

    }


    return roles
      .map(function(role) {


        role = normalizePlainObject(

          role

        );


        return {

          key:

            String(

              role.key || ''

            ).trim(),

          compare:

            String(

              role.compare || '=='

            ).trim(),

          value:

            String(

              role.value === null ||
              role.value === undefined

                ? ''

                : role.value

            ).substring(

              0,

              255

            ),

        };


      })
      .filter(function(role) {


        return (

          role.key != '' ||

          role.value != ''

        );


      });


  }


  function getPaginationActionCompareOptions(
    selectedValue = '=='
  ) {


    const comparators = {

      '==':  'Igual a',
      '===': 'Estritamente igual a',
      '!=':  'Diferente de',
      '!==': 'Estritamente diferente de',
      '>':   'Maior que',
      '>=':  'Maior ou igual a',
      '<':   'Menor que',
      '<=':  'Menor ou igual a',

    };


    let html = '';


    Object.keys(

      comparators

    ).forEach(function(comparator) {


      html +=

        '<option value="' +

          escapeHtml(comparator) +

        '"' +

        (

          comparator == selectedValue

            ? ' selected'

            : ''

        ) +

        '>' +

          escapeHtml(

            comparators[comparator]

          ) +

        '</option>';


    });


    return html;


  }


  function addPaginationActionRole(
    item,
    role = {}
  ) {


    item = $(item);


    role = normalizePlainObject(

      role

    );


    const list = item.find(

      selectors.actionRolesList

    ).first();


    if(!list.length) {

      return false;

    }


    list.find(

      '.automator-pagination-editor-action-roles-empty'

    ).remove();


    const columns = getAvailableTableColumns();


    let columnOptions =

      '<option value="" disabled' +

        (

          String(

            role.key || ''

          ).trim() == ''

            ? ' selected'

            : ''

        ) +

      '>' +

        '- Selecionar coluna -' +

      '</option>';


    Object.keys(

      columns

    ).forEach(function(columnName) {


      columnOptions +=

        '<option value="' +

          escapeHtml(columnName) +

        '"' +

        (

          String(

            role.key || ''

          ) == String(columnName)

            ? ' selected'

            : ''

        ) +

        '>' +

          escapeHtml(

            columns[columnName]

          ) +

        '</option>';


    });


    const row = $(

      '<div class="' +

        'card shadow-sm mb-3 ' +

        'automator-pagination-editor-action-role-row' +

      '">' +

        '<div class="card-body p-2">' +

          '<div class="mb-2">' +

            '<label class="form-label small fw-semibold mb-1">' +

              'Coluna <span class="text-danger">*</span>' +

            '</label>' +

            '<select ' +

              'class="' +

                'form-select form-select-sm ' +

                'automator-pagination-editor-action-role-key' +

              '" ' +

              'required' +

            '>' +

              columnOptions +

            '</select>' +

          '</div>' +

          '<div class="mb-2">' +

            '<label class="form-label small fw-semibold mb-1">' +

              'Comparador <span class="text-danger">*</span>' +

            '</label>' +

            '<select ' +

              'class="' +

                'form-select form-select-sm ' +

                'automator-pagination-editor-action-role-compare' +

              '" ' +

              'required' +

            '>' +

              getPaginationActionCompareOptions(

                role.compare || '=='

              ) +

            '</select>' +

          '</div>' +

          '<div class="mb-2">' +

            '<label class="form-label small fw-semibold mb-1">' +

              'Valor' +

            '</label>' +

            '<input ' +

              'type="text" ' +

              'maxlength="255" ' +

              'class="' +

                'form-control form-control-sm ' +

                'automator-pagination-editor-action-role-value' +

              '" ' +

              'value="' +

                escapeHtml(

                  role.value || ''

                ) +

              '" ' +

            '/>' +

          '</div>' +

          '<button ' +

            'type="button" ' +

            'class="' +

              'btn btn-sm btn-outline-danger w-100 ' +

              'automator-pagination-editor-action-role-delete' +

            '"' +

          '>' +

            '<i class="fa fa-trash me-1"></i>' +

            'Excluir regra de uso' +

          '</button>' +

        '</div>' +

      '</div>'

    );


    list.append(

      row

    );


    return row;


  }


  /*
  |--------------------------------------------------------------------------
  | Atualiza o ícone de expansão da ação
  |--------------------------------------------------------------------------
  */

  function updatePaginationActionCollapseIcon(
    item,
    opened = null
  ) {


    item = $(item);


    if(!item.length) {

      return false;

    }


    const button = item.find(

      selectors.actionCollapse

    ).first();


    const body = item.find(

      selectors.actionBody

    ).first();


    if(
      !button.length ||
      !body.length
    ) {

      return false;

    }


    if(opened === null) {

      opened = body.hasClass(

        'show'

      );

    }


    opened = opened === true;


    button
      .toggleClass(
        'collapsed',
        opened !== true
      )
      .attr(
        'aria-expanded',
        opened === true

          ? 'true'

          : 'false'
      );


    button.find(

      'i'

    )
      .removeClass(

        'fa-chevron-up fa-chevron-down'

      )
      .addClass(

        opened === true

          ? 'fa-chevron-up'

          : 'fa-chevron-down'

      );


    return true;


  }



  function updatePaginationActionRolesEmptyState(
    item
  ) {


    item = $(item);


    const list = item.find(

      selectors.actionRolesList

    ).first();


    if(!list.length) {

      return false;

    }


    list
      .addClass(

        'small'

      )
      .attr(

        'data-empty',

        'Nenhuma regra de uso adicionada.'

      );


    list.find(

      '.automator-pagination-editor-action-roles-empty'

    ).remove();


    if(
      list.find(
        selectors.actionRoleRow
      ).length <= 0
    ) {


      list.append(

        '<div class="' +

          'automator-pagination-editor-action-roles-empty ' +

          'small text-muted text-center border rounded ' +

          'p-3 mb-2' +

        '" style="' +

          'border-style: dashed !important;' +

        '">' +

          'Nenhuma regra de uso adicionada.' +

        '</div>'

      );


    }


    return true;


  }


  function getPaginationActionRolesData(
    item
  ) {


    item = $(item);


    const roles = [];


    item.find(

      selectors.actionRoleRow

    ).each(function() {


      const row = $(this);


      roles.push({

        key:

          String(

            row.find(
              selectors.actionRoleKey
            ).val() || ''

          ).trim(),

        compare:

          String(

            row.find(
              selectors.actionRoleCompare
            ).val() || '=='

          ).trim(),

        value:

          String(

            row.find(
              selectors.actionRoleValue
            ).val() || ''

          ).substring(

            0,

            255

          ),

      });


    });


    return roles;


  }


  function validatePaginationActionRoles(
    item
  ) {


    item = $(item);


    let valid = true;


    item.find(

      selectors.actionRoleRow

    ).each(function() {


      const row = $(this);


      const keyInput = row.find(

        selectors.actionRoleKey

      ).first();


      const compareInput = row.find(

        selectors.actionRoleCompare

      ).first();


      const key = String(

        keyInput.val() || ''

      ).trim();


      const compare = String(

        compareInput.val() || ''

      ).trim();


      const keyValid =

        key != '';


      const compareValid =

        [

          '==',
          '===',
          '!=',
          '!==',
          '>',
          '>=',
          '<',
          '<=',

        ].indexOf(

          compare

        ) >= 0;


      keyInput.toggleClass(

        'is-invalid',

        keyValid !== true

      );


      compareInput.toggleClass(

        'is-invalid',

        compareValid !== true

      );


      if(
        keyValid !== true ||
        compareValid !== true
      ) {

        valid = false;

      }


    });


    return valid;


  }


  function bindPaginationActionRolesEvents() {


    $(document)
      .off(
        'click.automator-pagination-editor-action-role-add',
        selectors.actionRoleAdd
      )
      .on(
        'click.automator-pagination-editor-action-role-add',
        selectors.actionRoleAdd,
        function(event) {


          event.preventDefault();

          event.stopPropagation();


          const item = $(this).closest(

            selectors.actionItem

          );


          addPaginationActionRole(

            item,

            {

              key:     '',
              compare: '==',
              value:   '',

            }

          );


          updatePaginationActionRolesEmptyState(

            item

          );


          validatePaginationActionRoles(

            item

          );


          syncActionsValue(

            item.closest(
              selectors.actionsManager
            )

          );


          setSaveState(

            true

          );


          return false;


        }
      );


    $(document)
      .off(
        'click.automator-pagination-editor-action-role-delete',
        selectors.actionRoleDelete
      )
      .on(
        'click.automator-pagination-editor-action-role-delete',
        selectors.actionRoleDelete,
        function(event) {


          event.preventDefault();

          event.stopPropagation();


          const item = $(this).closest(

            selectors.actionItem

          );


          $(this)
            .closest(
              selectors.actionRoleRow
            )
            .remove();


          updatePaginationActionRolesEmptyState(

            item

          );


          syncActionsValue(

            item.closest(
              selectors.actionsManager
            )

          );


          setSaveState(

            true

          );


          return false;


        }
      );


    $(document)
      .off(
        'input.automator-pagination-editor-action-role change.automator-pagination-editor-action-role',
        [

          selectors.actionRoleKey,
          selectors.actionRoleCompare,
          selectors.actionRoleValue,

        ].join(', ')
      )
      .on(
        'input.automator-pagination-editor-action-role change.automator-pagination-editor-action-role',
        [

          selectors.actionRoleKey,
          selectors.actionRoleCompare,
          selectors.actionRoleValue,

        ].join(', '),
        function() {


          const item = $(this).closest(

            selectors.actionItem

          );


          validatePaginationActionRoles(

            item

          );


          syncActionsValue(

            item.closest(
              selectors.actionsManager
            )

          );


          setSaveState(

            true

          );


        }
      );


    return true;


  }



  /*
  |--------------------------------------------------------------------------
  | Registra seletores do gerenciador de ações
  |--------------------------------------------------------------------------
  */

  function registerActionSelectors() {


    selectors.columnType =
      '.automator-pagination-editor-aside-left-inserter-list-item';


    selectors.canvas =
      '#automator-pagination-editor-canvas';


    selectors.canvasContainer =
      '#automator-pagination-editor-canvas-container';


    selectors.canvasContent =
      '#automator-pagination-editor-canvas-container-content';


    selectors.preview =
      '#automator-pagination-editor-preview';


    selectors.previewTable =
      '#automator-pagination-editor-preview-table';


    selectors.previewHeader =
      '#automator-pagination-editor-preview-header';


    selectors.previewBody =
      '#automator-pagination-editor-preview-body';


    selectors.previewSearch =
      '#automator-pagination-editor-preview-search';


    selectors.previewPerPage =
      '#automator-pagination-editor-preview-per-page';


    selectors.paginationPerPage =
      selectors.editor + ' [name="per_page"], ' +
      selectors.editor + ' [name="tbl_sys_pagination_per_page"], ' +
      selectors.editor + ' [name="pagination_per_page"], ' +
      selectors.editor + ' [data-automator-pagination-per-page]';


    selectors.structureItem =
      '.automator-pagination-editor-column-item';


    selectors.structureEmpty =
      '.automator-pagination-editor-structure-empty';


    selectors.columnPropertiesContent =
      '#automator-pagination-editor-column-properties-content';


    selectors.columnPropertyInput =
      '.automator-pagination-editor-column-property';


    selectors.columnDelete =
      '.automator-pagination-editor-column-delete';


    selectors.columnPropertiesDelete =
      '.automator-pagination-editor-column-properties-delete';


    selectors.columnDynamicList =
      '.automator-pagination-editor-column-dynamic-list';


    selectors.columnDynamicListItems =
      '.automator-pagination-editor-column-dynamic-list-items';


    selectors.columnDynamicListAdd =
      '.automator-pagination-editor-column-dynamic-list-add';


    selectors.columnDynamicListDelete =
      '.automator-pagination-editor-column-dynamic-list-delete';


    selectors.headerButtonAdd =
      '#automator-pagination-editor-buttons-accordions-header ' +
      '.automator-pagination-editor-buttons-accordions-add';


    selectors.actionButtonAdd =
      '#automator-pagination-editor-buttons-accordions-actions ' +
      '.automator-pagination-editor-buttons-accordions-add';


    selectors.headerButtonsWrapper =
      '#automator-pagination-editor-buttons-accordions-header-wrapper';


    selectors.actionButtonsWrapper =
      '#automator-pagination-editor-buttons-accordions-actions-wrapper';


    selectors.paginationButtonsList =
      '.automator-pagination-editor-buttons-list';


    selectors.paginationButtonItem =
      '.automator-pagination-editor-button-item';


    selectors.paginationButtonSortHandle =
      '.automator-pagination-editor-button-sort-handle';


    selectors.paginationButtonID =
      '.automator-pagination-editor-button-id';


    selectors.paginationButtonType =
      '.automator-pagination-editor-button-type';


    selectors.paginationButtonAction =
      '.automator-pagination-editor-button-action';


    selectors.paginationButtonClass =
      '.automator-pagination-editor-button-class';


    selectors.paginationButtonIconHidden =
      '.automator-pagination-editor-button-icon-value';


    selectors.paginationButtonIconSearch =
      '.automator-pagination-editor-button-icon-search';


    selectors.paginationButtonIconPreview =
      '.automator-pagination-editor-button-icon-preview';


    selectors.paginationButtonIconResults =
      '.automator-pagination-editor-button-icon-results';


    selectors.paginationButtonText =
      '.automator-pagination-editor-button-text';


    selectors.paginationButtonOnclick =
      '.automator-pagination-editor-button-onclick';


    selectors.paginationButtonDelete =
      '.automator-pagination-editor-button-delete';


    selectors.actionsManager =
      '.automator-pagination-editor-actions-manager';


    selectors.actionsList =
      '.automator-pagination-editor-actions-list';


    selectors.actionsValue =
      '.automator-pagination-editor-actions-value';


    selectors.actionAdd =
      '.automator-pagination-editor-action-add';


    selectors.actionItem =
      '.automator-pagination-editor-action-item';


    selectors.actionHeader =
      '.automator-pagination-editor-action-header';


    selectors.actionHeaderTitle =
      '.automator-pagination-editor-action-header-title';


    selectors.actionCollapse =
      '.automator-pagination-editor-action-collapse';


    selectors.actionBody =
      '.automator-pagination-editor-action-body';


    selectors.actionName =
      '.automator-pagination-editor-action-name';


    selectors.actionRoute =
      '.automator-pagination-editor-action-route';


    selectors.actionShow =
      '.automator-pagination-editor-action-show';


    selectors.actionParamsList =
      '.automator-pagination-editor-action-params-list';


    selectors.actionParamAdd =
      '.automator-pagination-editor-action-param-add';


    selectors.actionParamRow =
      '.automator-pagination-editor-action-param-row';


    selectors.actionParamName =
      '.automator-pagination-editor-action-param-name';


    selectors.actionParamValue =
      '.automator-pagination-editor-action-param-value';


    selectors.actionParamDelete =
      '.automator-pagination-editor-action-param-delete';


    selectors.actionDelete =
      '.automator-pagination-editor-action-delete';


    selectors.actionRolesList =
      '.automator-pagination-editor-action-roles-list';


    selectors.actionRoleAdd =
      '.automator-pagination-editor-action-role-add';


    selectors.actionRoleRow =
      '.automator-pagination-editor-action-role-row';


    selectors.actionRoleKey =
      '.automator-pagination-editor-action-role-key';


    selectors.actionRoleCompare =
      '.automator-pagination-editor-action-role-compare';


    selectors.actionRoleValue =
      '.automator-pagination-editor-action-role-value';


    selectors.actionRoleDelete =
      '.automator-pagination-editor-action-role-delete';


    return true;


  }


  function positionPaginationActionAddButton(
    manager
  ) {


    manager = $(manager);


    if(!manager.length) {

      return false;

    }


    const list = manager.find(

      selectors.actionsList

    ).first();


    const addButton = manager.find(

      selectors.actionAdd

    ).first();


    if(
      !list.length ||
      !addButton.length
    ) {

      return false;

    }


    let addButtonContainer = addButton.closest(

      '.automator-pagination-editor-action-add-container'

    );


    if(!addButtonContainer.length) {


      addButton.wrap(

        '<div class="' +

          'automator-pagination-editor-action-add-container ' +

          'mt-3 w-100' +

        '"></div>'

      );


      addButtonContainer = addButton.closest(

        '.automator-pagination-editor-action-add-container'

      );


    }


    addButtonContainer.addClass(

      'w-100'

    );


    addButton.addClass(

      'w-100'

    );


    addButtonContainer.insertAfter(

      list

    );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Finaliza inicialização
  |--------------------------------------------------------------------------
  */

  function finishInitialization(callback = null) {


    applyPaginationSettingsDefaultValues();


    initializePaginationQueryFiltersSection();


    initializePaginationQueryFilters(

      state.recordData

    );


    updateStructureEmptyState();

    renderPaginationPreview();

    syncEditorState();

    syncPaginationValidationVisualState();


    state.initialized = true;

    state.hasChanges = false;

    state.suppressChangeTracking = false;


    getPaginationSaveButtonTooltipWrapper();


    setSaveState(

      false

    );


    syncPaginationValidationVisualState();

    refreshTooltips();


    setTimeout(function() {


      initializePaginationModalScroll();


      if(state.isNew === true) {


        const titleInput = $(

          '#tbl_sys_pagination_title'

        ).first();


        if(titleInput.length) {

          titleInput.trigger(

            'focus'

          );

        }


      }


    }, 300);


    if(typeof callback === 'function') {

      callback();

    }


    return true;


  }


  function syncPaginationValidationVisualState() {


    $(selectors.editor)
      .find(
        'input[required], select[required], textarea[required]'
      )
      .each(function() {


        const input = $(this);


        let hasValue = false;


        if(input.attr('type') == 'checkbox') {

          hasValue = input.prop('checked') === true;

        } else {

          hasValue = String(

            input.val() || ''

          ).trim() != '';

        }


        if(hasValue === true) {


          input
            .removeClass(
              'is-invalid'
            )
            .addClass(
              'is-valid'
            );


          return;

        }


        input.removeClass(

          'is-valid'

        );


        if(
          state.initialized !== true ||
          state.applyingRecordData === true
        ) {

          input.removeClass(

            'is-invalid'

          );

        }


      });


    const indexSelect = $(

      selectors.index

    );


    if(
      String(

        indexSelect.val() || ''

      ).trim() != ''
    ) {


      indexSelect
        .removeClass(
          'is-invalid'
        )
        .addClass(
          'is-valid'
        );


    }


    return true;


  }


  function applyPaginationSettingsDefaultValues() {


    $(selectors.editor)
      .find(
        '.automator-pagination-editor-setting'
      )
      .each(function() {


        const input = $(this);


        if(
          input.is('select') !== true ||
          String(
            input.val() || ''
          ).trim() != ''
        ) {

          return;

        }


        const defaultValue = String(

          input.attr(
            'data-default-value'
          ) || ''

        ).trim();


        if(
          defaultValue != '' &&
          input.find(
            'option[value="' +
            escapeSelectorValue(defaultValue) +
            '"]'
          ).length
        ) {


          input.val(

            defaultValue

          );


          return;

        }


        const fieldName = String(

          input.attr('name') || ''

        );


        const predefinedDefaults = {

          per_page:                   '15',
          tbl_sys_pagination_locked:  '0',

        };


        if(
          Object.prototype.hasOwnProperty.call(

            predefinedDefaults,

            fieldName

          ) &&
          input.find(
            'option[value="' +
            predefinedDefaults[fieldName] +
            '"]'
          ).length
        ) {


          input.val(

            predefinedDefaults[fieldName]

          );


          return;

        }


        const firstAvailableOption = input
          .find(
            'option:not([disabled])'
          )
          .filter(function() {


            return String(

              $(this).val() || ''

            ).trim() != '';


          })
          .first();


        if(
          firstAvailableOption.length &&
          !input.find(
            'option[value=""]'
          ).length
        ) {


          input.val(

            firstAvailableOption.val()

          );


        }


      });


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Destruição
  |--------------------------------------------------------------------------
  */

  function destroy(resetState = true) {


    clearUnsavedChangesWarning();


    [

      'structureSortable',

      'headerButtonsSortable',

      'actionButtonsSortable',

    ].forEach(function(sortableKey) {


      if(!state[sortableKey]) {

        return;

      }


      try {

        state[sortableKey].destroy();

      } catch(e) {}


      state[sortableKey] = null;


    });


    $(document).off(

      '.automator-pagination-editor'

    );


    $(document).off(

      '.AutomatorPaginationEditorCloseButton'

    );


    $(document).off(

      'hide.bs.modal.AutomatorPaginationEditorChanged'

    );


    $(document).off(

      'hidden.bs.modal.AutomatorPaginationEditorChanged'

    );


    if(window.__automatorPaginationEditorCloseCaptureHandler) {


      document.removeEventListener(

        'click',

        window.__automatorPaginationEditorCloseCaptureHandler,

        true

      );


      window.__automatorPaginationEditorCloseCaptureHandler = null;


    }


    removeBeforeUnloadWarning();

    hideEditorTooltips();


    $('#page-loader').css(

      'z-index',

      ''

    );


    if(
      typeof window.AutomatorPageLoader === 'function'
    ) {

      AutomatorPageLoader('hide');

    }


    if(
      typeof window.AutomatorSetActionStatus === 'function'
    ) {

      AutomatorSetActionStatus(false);

    }


    if(
      document.querySelectorAll('.modal.show').length <= 0
    ) {


      document.body.classList.remove(

        'modal-open'

      );


      document.body.style.removeProperty(

        'overflow'

      );


      document.body.style.removeProperty(

        'padding-right'

      );


      document
        .querySelectorAll('.modal-backdrop')
        .forEach(function(backdrop) {


          backdrop.remove();


        });


    }


    if(resetState === true) {


      state = $.extend(

        true,

        {},

        defaultState

      );


    }


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Inicializa painéis
  |--------------------------------------------------------------------------
  */

  function initializePanels() {


    $(selectors.paginationPanel)
      .removeClass('is-active');


    $(selectors.proprietiesPanel)
      .removeClass('is-active');


    $(selectors.paginationPanel)
      .addClass('is-active');


    state.activeRightPanel = 'pagination';

    state.selectedColumnID = '';


    setHeaderPanelButtonState('pagination');


    $(selectors.leftAside).attr(

      'data-active-tab',

      'structure'

    );


    state.activeLeftTab = 'structure';


    $(selectors.leftActionButton)
      .removeClass('is-active');


    $(selectors.structureButton)
      .addClass('is-active');


    setSidebarOpen(

      'left',

      true

    );


    setSidebarOpen(

      'right',

      true

    );


    openRightConfigTab('pagination-settings');


    renderNoColumnSelectedProperties();


    setProprietiesEnabled(

      false,

      'Nenhuma coluna foi selecionada.'

    );


    setEditorActionsEnabled(false);

    setAddButtonsEnabled(false);


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Eventos da tabela e índice
  |--------------------------------------------------------------------------
  */

  function bindTableEvents() {


    $(document)
      .off(
        'change.automator-pagination-editor-table',
        selectors.table
      )
      .on(
        'change.automator-pagination-editor-table',
        selectors.table,
        function() {


          const tableSelect = $(this);


          if(tableSelect.prop('disabled') === true) {

            return false;

          }


          const tableValue = String(

            tableSelect.val() || ''

          ).trim();


          AutomatorPageLoader('show', function() {


            $('#page-loader').css('z-index', '1085');


            state.selectedTable = tableValue;

            state.selectedIndex = '';


            resetIndexSelect();


            if(tableValue == '') {


              syncEditorState();

              setSaveState(true);


              $('#page-loader').css('z-index', '');


              AutomatorPageLoader('hide');


              return;

            }


            loadTableColumns(

              tableValue,

              '',

              function() {


                syncEditorState();

                setSaveState(true);


                $('#page-loader').css('z-index', '');


                AutomatorPageLoader('hide');


              },

              true

            );


          });


        }
      );


    $(document)
      .off(
        'change.automator-pagination-editor-index',
        selectors.index
      )
      .on(
        'change.automator-pagination-editor-index',
        selectors.index,
        function() {


          const indexSelect = $(this);


          if(indexSelect.prop('disabled') === true) {

            return false;

          }


          const previousIndex = state.selectedIndex;


          const indexValue = String(

            indexSelect.val() || ''

          ).trim();


          AutomatorPageLoader('show', function() {


            $('#page-loader').css('z-index', '1085');


            if(
              hasDependentInformation() === true &&
              previousIndex != '' &&
              indexValue != previousIndex
            ) {


              indexSelect.val(previousIndex);


              showMessage(

                'Atenção',

                'O índice não pode ser alterado depois que informações da paginação foram criadas.'

              );


              syncEditorState();


              $('#page-loader').css('z-index', '');


              AutomatorPageLoader('hide');


              return false;

            }


            state.selectedIndex = indexValue;


            syncEditorState();

            setSaveState(true);


            $('#page-loader').css('z-index', '');


            AutomatorPageLoader('hide');


          });


        }
      );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Carrega tabelas
  |--------------------------------------------------------------------------
  */

  function loadTables(
    callback = null,
    showLoader = true
  ) {


    const tableSelect = $(selectors.table);


    if(!tableSelect.length) {


      if(typeof callback === 'function') {

        callback();

      }


      return false;

    }


    const currentValue = String(

      tableSelect.val() || ''

    ).trim();


    state.tableLoading = true;


    tableSelect.prop('disabled', true);


    function executeRequest() {


      requestDatabaseData(

        {

          'data-type': 'get-tables',

        },

        function(response) {


          const tables = normalizeResponseItems(

            response.data || []

          );


          renderSelectOptions(

            tableSelect,

            tables,

            currentValue,

            '- Selecione -'

          );


          state.tableLoading = false;


          syncEditorState();


          if(showLoader === true) {


            $('#page-loader').css('z-index', '');


            AutomatorPageLoader('hide');


          }


          if(typeof callback === 'function') {

            callback(response);

          }


        },

        function() {


          state.tableLoading = false;


          syncEditorState();


          if(showLoader === true) {


            $('#page-loader').css('z-index', '');


            AutomatorPageLoader('hide');


          }


          if(typeof callback === 'function') {

            callback();

          }


        }

      );


    }


    if(showLoader === true) {


      AutomatorPageLoader('show', function() {


        $('#page-loader').css('z-index', '1085');


        executeRequest();


      });


    } else {

      executeRequest();

    }


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Carrega colunas da tabela
  |--------------------------------------------------------------------------
  */

  function loadTableColumns(
    tableName = '',
    selectedIndex = '',
    callback = null,
    loaderAlreadyVisible = false
  ) {


    tableName = String(

      tableName || ''

    ).trim();


    selectedIndex = String(

      selectedIndex || ''

    ).trim();


    if(tableName == '') {


      resetIndexSelect();


      if(typeof callback === 'function') {

        callback();

      }


      return false;

    }


    const indexSelect = $(

      selectors.index

    );


    if(!indexSelect.length) {


      if(typeof callback === 'function') {

        callback();

      }


      return false;

    }


    state.columnsLoading = true;


    indexSelect
      .prop(
        'disabled',
        true
      )
      .removeClass(
        'is-invalid is-valid'
      )
      .empty()
      .append(

        $('<option>', {

          value: '',
          text:  'Carregando colunas...',

        })

      );


    function executeRequest() {


      requestDatabaseData(

        {

          'data-type':  'get-table-columns',
          'table-name': tableName,

        },

        function(response) {


          const columns = normalizeResponseItems(

            response && response.data

              ? response.data

              : []

          );


          renderSelectOptions(

            indexSelect,

            columns,

            selectedIndex,

            '- Selecione a coluna -',

            {

              keepEmptyOption: true,
              selectFirst:     false,

            }

          );


          if(
            selectedIndex != '' &&
            indexSelect.find('option').filter(function() {


              return String(

                $(this).val()

              ) == selectedIndex;


            }).length
          ) {


            indexSelect.val(

              selectedIndex

            );


          }


          state.columnsLoading = false;

          state.selectedTable = tableName;

          state.selectedIndex = String(

            indexSelect.val() || ''

          ).trim();


          if(state.selectedIndex != '') {


            indexSelect
              .removeClass(
                'is-invalid'
              )
              .addClass(
                'is-valid'
              );


          }


          syncEditorState();

          syncPaginationValidationVisualState();


          if(
            loaderAlreadyVisible !== true &&
            state.initialized === true
          ) {


            $('#page-loader').css(

              'z-index',

              ''

            );


            AutomatorPageLoader(

              'hide'

            );


          }


          if(typeof callback === 'function') {

            callback(

              response

            );

          }


        },

        function(response) {


          state.columnsLoading = false;

          state.selectedIndex = '';


          resetIndexSelect(

            '- Não foi possível carregar as colunas -'

          );


          syncEditorState();


          if(
            loaderAlreadyVisible !== true &&
            state.initialized === true
          ) {


            $('#page-loader').css(

              'z-index',

              ''

            );


            AutomatorPageLoader(

              'hide'

            );


          }


          if(typeof callback === 'function') {

            callback(

              response

            );

          }


        }

      );


    }


    if(
      loaderAlreadyVisible !== true &&
      state.initialized === true
    ) {


      AutomatorPageLoader(

        'show',

        function() {


          $('#page-loader').css(

            'z-index',

            '1085'

          );


          executeRequest();


        }

      );


    } else {

      executeRequest();

    }


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Requisição de dados do banco
  |--------------------------------------------------------------------------
  */

  function requestDatabaseData(
    data = {},
    successCallback = null,
    errorCallback = null
  ) {


    if(
      typeof window.AutomatorRoutes === 'undefined' ||
      !window.AutomatorRoutes.apiAdmin
    ) {


      showMessage(

        'Erro',

        'A rota administrativa não foi encontrada.'

      );


      if(typeof errorCallback === 'function') {

        errorCallback();

      }


      return false;

    }


    data = $.extend(

      {

        acao: 'get-database-data',

      },

      data

    );


    $.ajax({

      url: window.AutomatorRoutes.apiAdmin,

      type: 'POST',

      data: data,

      headers: {

        'X-CSRF-TOKEN': AutomatorGetCSRFToken(),

        'Accept': 'application/json',

      },

      dataType: 'json',

      success: function(response) {


        if(
          response &&
          AutomatorNormalizeBoolean(response.status) === true
        ) {


          if(typeof successCallback === 'function') {

            successCallback(response);

          }


          return;

        }


        showMessage(

          response && response.title
            ? response.title
            : 'Atenção',

          response && response.message
            ? response.message
            : 'Não foi possível carregar as informações solicitadas.'

        );


        if(typeof errorCallback === 'function') {

          errorCallback(response);

        }


      },

      error: function(xhr) {


        let title = 'Erro';

        let message =
          'Não foi possível carregar as informações solicitadas.';


        if(
          xhr.responseJSON &&
          xhr.responseJSON.title
        ) {

          title = xhr.responseJSON.title;

        }


        if(
          xhr.responseJSON &&
          xhr.responseJSON.message
        ) {

          message = xhr.responseJSON.message;

        } else if(xhr.responseText) {

          message = xhr.responseText;

        }


        showMessage(

          title,

          message

        );


        if(typeof errorCallback === 'function') {

          errorCallback(xhr);

        }


      }

    });


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Eventos das tabs da lateral esquerda
  |--------------------------------------------------------------------------
  */

  function bindLeftTabsEvents() {


    $(document)
      .off(
        'click.automator-pagination-editor-left-tab',
        selectors.leftActionButton
      )
      .on(
        'click.automator-pagination-editor-left-tab',
        selectors.leftActionButton,
        function(event) {


          event.preventDefault();

          event.stopImmediatePropagation();


          const button = $(this);


          if(button.prop('disabled') === true) {

            return false;

          }


          const tab = String(

            button.attr(
              'data-automator-pagination-left-tab'
            ) || ''

          ).trim();


          hideEditorTooltips();


          if(
            state.activeLeftTab == tab &&
            isSidebarOpen('left') === true
          ) {

            setSidebarOpen(

              'left',

              false

            );


            return false;

          }


          switchLeftTab(tab);


          return false;


        }
      );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Alterna tabs da lateral esquerda
  |--------------------------------------------------------------------------
  */

  function switchLeftTab(tab = 'structure') {


    tab = String(tab || '').trim();


    if(tab == 'button') {

      tab = 'buttons';

    }


    const button = $(

      '[data-automator-pagination-left-tab="' +
      tab +
      '"]'

    );


    if(
      !button.length ||
      button.prop('disabled') === true
    ) {

      return false;

    }


    hideEditorTooltips();


    $(selectors.leftActionButton)
      .removeClass('is-active');


    button.addClass('is-active');


    $(selectors.leftAside).attr(

      'data-active-tab',

      tab

    );


    state.activeLeftTab = tab;


    setSidebarOpen(

      'left',

      true

    );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Eventos dos botões do cabeçalho
  |--------------------------------------------------------------------------
  */

  function bindHeaderEvents() {


    $(document)
      .off(
        'click.automator-pagination-editor-pagination-panel',
        selectors.paginationButton
      )
      .on(
        'click.automator-pagination-editor-pagination-panel',
        selectors.paginationButton,
        function(event) {


          event.preventDefault();

          event.stopImmediatePropagation();


          hideEditorTooltips();


          if(
            state.activeRightPanel == 'pagination' &&
            isSidebarOpen('right') === true
          ) {

            setSidebarOpen(

              'right',

              false

            );


            return false;

          }


          showRightPanel('pagination');


          return false;


        }
      );


    $(document)
      .off(
        'click.automator-pagination-editor-proprieties-panel',
        selectors.proprietiesButton
      )
      .on(
        'click.automator-pagination-editor-proprieties-panel',
        selectors.proprietiesButton,
        function(event) {


          event.preventDefault();

          event.stopImmediatePropagation();


          const button = $(this);


          if(button.prop('disabled') === true) {

            return false;

          }


          hideEditorTooltips();


          if(
            state.activeRightPanel == 'proprieties' &&
            isSidebarOpen('right') === true
          ) {

            setSidebarOpen(

              'right',

              false

            );


            return false;

          }


          showRightPanel('proprieties');


          return false;


        }
      );


    $(document)
      .off(
        'click.automator-pagination-editor-save',
        selectors.saveButton
      )
      .on(
        'click.automator-pagination-editor-save',
        selectors.saveButton,
        function(event) {


          event.preventDefault();

          event.stopImmediatePropagation();


          if($(this).prop('disabled') === true) {

            return false;

          }


          hideEditorTooltips();


          submitPaginationEditor();


          return false;


        }
      );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Coluna automática de botões
  |--------------------------------------------------------------------------
  */

  function ensurePaginationActionButtonsColumn(
    renderPreview = true
  ) {


    const actionButtons =

      getPaginationButtonsData(

        'actions'

      );


    const hasActionButtons =

      actionButtons.length > 0;


    $(selectors.editor).attr(

      'data-has-action-buttons-column',

      hasActionButtons === true

        ? 'true'

        : 'false'

    );


    /*
    |--------------------------------------------------------------------------
    | Remove versões antigas da coluna de ações na estrutura
    |--------------------------------------------------------------------------
    */

    $(selectors.structureList)
      .find(
        '[data-action-buttons-column="true"]'
      )
      .remove();


    updateStructureEmptyState();


    if(renderPreview === true) {

      renderPaginationPreview();

    }


    return hasActionButtons;


  }


  /*
  |--------------------------------------------------------------------------
  | Eventos iniciais dos botões
  |--------------------------------------------------------------------------
  */

  function bindPaginationButtonsEvents() {


    $(document)
      .off(
        'click.automator-pagination-editor-add-header-button',
        selectors.headerButtonAdd
      )
      .on(
        'click.automator-pagination-editor-add-header-button',
        selectors.headerButtonAdd,
        function(event) {


          event.preventDefault();

          event.stopPropagation();


          if($(this).prop('disabled') === true) {

            return false;

          }


          addPaginationButton(

            'header'

          );


          return false;


        }
      );


    $(document)
      .off(
        'click.automator-pagination-editor-add-action-button',
        selectors.actionButtonAdd
      )
      .on(
        'click.automator-pagination-editor-add-action-button',
        selectors.actionButtonAdd,
        function(event) {


          event.preventDefault();

          event.stopPropagation();


          if($(this).prop('disabled') === true) {

            return false;

          }


          addPaginationButton(

            'actions'

          );


          return false;


        }
      );


    $(document)
      .off(
        'keyup.automator-pagination-editor-button-id ' +
        'input.automator-pagination-editor-button-id ' +
        'change.automator-pagination-editor-button-id',
        selectors.paginationButtonID
      )
      .on(
        'keyup.automator-pagination-editor-button-id ' +
        'input.automator-pagination-editor-button-id ' +
        'change.automator-pagination-editor-button-id',
        selectors.paginationButtonID,
        function() {


          const input = $(this);


          const normalizedValue = normalizePaginationSlug(

            input.val()

          );


          if(
            String(
              input.val() || ''
            ) != normalizedValue
          ) {

            input.val(

              normalizedValue

            );

          }


          syncPaginationButtonsState();

          setSaveState(

            true

          );


        }
      );


    $(document)
      .off(
        'blur.automator-pagination-editor-button-id',
        selectors.paginationButtonID
      )
      .on(
        'blur.automator-pagination-editor-button-id',
        selectors.paginationButtonID,
        function() {


          const input = $(this);


          const normalizedValue = normalizePaginationButtonSlug(

            input.val()

          );


          if(
            String(
              input.val() || ''
            ) != normalizedValue
          ) {

            input.val(

              normalizedValue

            );


            syncPaginationButtonsState();

            setSaveState(

              true

            );

          }


        }
      );


    $(document)
      .off(
        'input.automator-pagination-editor-button-field ' +
        'change.automator-pagination-editor-button-field',
        [

          selectors.paginationButtonType,
          selectors.paginationButtonAction,
          selectors.paginationButtonClass,
          selectors.paginationButtonText,
          selectors.paginationButtonOnclick,

        ].join(', ')
      )
      .on(
        'input.automator-pagination-editor-button-field ' +
        'change.automator-pagination-editor-button-field',
        [

          selectors.paginationButtonType,
          selectors.paginationButtonAction,
          selectors.paginationButtonClass,
          selectors.paginationButtonText,
          selectors.paginationButtonOnclick,

        ].join(', '),
        function() {


          syncPaginationButtonsState();

          setSaveState(

            true

          );


        }
      );


    $(document)
      .off(
        'keyup.automator-pagination-editor-button-icon-search ' +
        'input.automator-pagination-editor-button-icon-search',
        selectors.paginationButtonIconSearch
      )
      .on(
        'keyup.automator-pagination-editor-button-icon-search ' +
        'input.automator-pagination-editor-button-icon-search',
        selectors.paginationButtonIconSearch,
        function() {


          const item = $(this).closest(

            selectors.paginationButtonItem

          );


          renderPaginationButtonIconResults(

            item,

            $(this).val()

          );


        }
      );


    $(document)
      .off(
        'click.automator-pagination-editor-button-icon-delete',
        selectors.paginationButtonDelete
      )
      .on(
        'click.automator-pagination-editor-button-icon-delete',
        selectors.paginationButtonDelete,
        function(event) {


          event.preventDefault();

          event.stopPropagation();


          const item = $(this).closest(

            selectors.paginationButtonItem

          );


          const list = item.closest(

            selectors.paginationButtonsList

          );


          item.remove();


          updatePaginationButtonsEmptyState(

            list

          );


          syncPaginationButtonsState();

          ensurePaginationActionButtonsColumn();

          updatePaginationActionsUsageState();

          setSaveState(

            true

          );


          return false;


        }
      );


    $(document)
      .off(
        'click.automator-pagination-editor-button-icon-outside'
      )
      .on(
        'click.automator-pagination-editor-button-icon-outside',
        function(event) {


          const target = $(event.target);


          if(
            target.closest(
              '.automator-pagination-editor-button-icon-wrapper'
            ).length
          ) {

            return;

          }


          $(selectors.paginationButtonIconResults)
            .empty()
            .addClass(
              'd-none'
            );


        }
      );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza classes do botão
  |--------------------------------------------------------------------------
  */

  function normalizePaginationButtonClasses(
    value = ''
  ) {


    const classes = [];


    String(

      value || ''

    )
      .split(
        /\s+/
      )
      .map(function(className) {


        return String(

          className || ''

        ).trim();


      })
      .filter(function(className) {


        return className != '';


      })
      .forEach(function(className) {


        if(
          classes.indexOf(
            className
          ) < 0
        ) {

          classes.push(

            className

          );

        }


      });


    return classes;


  }


  /*
  |--------------------------------------------------------------------------
  | Prepara autocomplete das classes do botão
  |--------------------------------------------------------------------------
  */

  function ensurePaginationButtonClassAutocomplete(
    item
  ) {


    item = $(item);


    if(!item.length) {

      return false;

    }


    const input = item.find(

      selectors.paginationButtonClass

    ).first();


    if(!input.length) {

      return false;

    }


    let wrapper = input.closest(

      '.automator-pagination-editor-button-class-wrapper'

    );


    if(!wrapper.length) {


      input.wrap(

        '<div class="' +

          'position-relative ' +

          'automator-pagination-editor-button-class-wrapper' +

        '"></div>'

      );


      wrapper = input.closest(

        '.automator-pagination-editor-button-class-wrapper'

      );


    }


    let results = wrapper.find(

      '.automator-pagination-editor-button-class-results'

    ).first();


    if(!results.length) {


      results = $(

        '<div class="' +

          'automator-pagination-editor-button-class-results ' +

          'position-absolute start-0 end-0 bg-white border ' +

          'rounded shadow d-none' +

        '" style="' +

          'top: calc(100% + 4px); ' +

          'max-height: 190px; ' +

          'overflow-y: auto; ' +

          'z-index: 1090;' +

        '"></div>'

      );


      wrapper.append(

        results

      );


    }


    input.attr(

      'autocomplete',

      'off'

    );


    return wrapper;


  }


  /*
  |--------------------------------------------------------------------------
  | Inicializa autocomplete das classes
  |--------------------------------------------------------------------------
  */

  function initializePaginationButtonClassAutocomplete() {


    $(selectors.paginationButtonItem).each(function() {


      ensurePaginationButtonClassAutocomplete(

        this

      );


    });


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Retorna o termo atual da busca de classes
  |--------------------------------------------------------------------------
  */

  function getPaginationButtonClassSearchValue(
    input
  ) {


    input = $(input);


    if(!input.length) {

      return '';

    }


    const value = String(

      input.val() || ''

    );


    const parts = value.split(

      /\s+/

    );


    return String(

      parts.pop() || ''

    )
      .trim()
      .toLowerCase();


  }


  /*
  |--------------------------------------------------------------------------
  | Renderiza sugestões de classes do botão
  |--------------------------------------------------------------------------
  */

  function renderPaginationButtonClassSuggestions(
    input
  ) {


    input = $(input);


    if(!input.length) {

      return false;

    }


    const item = input.closest(

      selectors.paginationButtonItem

    );


    if(!item.length) {

      return false;

    }


    const wrapper = ensurePaginationButtonClassAutocomplete(

      item

    );


    if(
      !wrapper ||
      !wrapper.length
    ) {

      return false;

    }


    const results = wrapper.find(

      '.automator-pagination-editor-button-class-results'

    ).first();


    if(!results.length) {

      return false;

    }


    const searchValue = getPaginationButtonClassSearchValue(

      input

    );


    /*
    |--------------------------------------------------------------------------
    | A lista só deve aparecer depois de pelo menos um caractere digitado
    |--------------------------------------------------------------------------
    */

    if(searchValue.length < 1) {


      results
        .empty()
        .addClass(
          'd-none'
        );


      return false;

    }


    const currentClasses = normalizePaginationButtonClasses(

      input.val()

    );


    const suggestions = getPaginationButtonClassSuggestions()
      .filter(function(className) {


        className = String(

          className || ''

        ).trim();


        if(className == '') {

          return false;

        }


        /*
        |--------------------------------------------------------------------------
        | Não repete classes já utilizadas no mesmo input
        |--------------------------------------------------------------------------
        */

        if(
          currentClasses.indexOf(
            className
          ) >= 0
        ) {

          return false;

        }


        return className
          .toLowerCase()
          .indexOf(
            searchValue
          ) >= 0;


      })
      .slice(
        0,
        100
      );


    let html = '';


    suggestions.forEach(function(className) {


      html +=

        '<button ' +

          'type="button" ' +

          'class="' +

            'btn btn-sm btn-light border-0 rounded-0 ' +

            'w-100 text-start ' +

            'automator-pagination-editor-button-class-result' +

          '" ' +

          'data-class-name="' +

            escapeHtml(

              className

            ) +

          '"' +

        '>' +

          '<span class="font-monospace">' +

            escapeHtml(

              className

            ) +

          '</span>' +

        '</button>';


    });


    if(html == '') {


      html =

        '<div class="small text-muted p-2">' +

          'Nenhuma classe encontrada.' +

        '</div>';


    }


    results
      .html(

        html

      )
      .removeClass(

        'd-none'

      );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Adiciona uma classe ao campo do botão
  |--------------------------------------------------------------------------
  */

  function addPaginationButtonClassToInput(
    input,
    className = ''
  ) {


    input = $(input);


    className = String(

      className || ''

    ).trim();


    if(
      !input.length ||
      className == ''
    ) {

      return false;

    }


    let currentValue = String(

      input.val() || ''

    );


    /*
    |--------------------------------------------------------------------------
    | Remove o termo incompleto digitado no final
    |--------------------------------------------------------------------------
    */

    if(
      currentValue != '' &&
      !/\s$/.test(
        currentValue
      )
    ) {


      const lastSpaceIndex = currentValue.lastIndexOf(

        ' '

      );


      if(lastSpaceIndex >= 0) {

        currentValue = currentValue.substring(

          0,

          lastSpaceIndex + 1

        );

      } else {

        currentValue = '';

      }


    }


    let classes = normalizePaginationButtonClasses(

      currentValue

    );


    if(
      classes.indexOf(
        className
      ) < 0
    ) {

      classes.push(

        className

      );

    }


    input.val(

      classes.join(

        ' '

      ) +

      ' '

    );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Eventos do autocomplete das classes dos botões
  |--------------------------------------------------------------------------
  */

  function bindPaginationButtonClassAutocompleteEvents() {


    $(document)
      .off(
        'input.automator-pagination-editor-button-class-autocomplete ' +
        'keyup.automator-pagination-editor-button-class-autocomplete',
        selectors.paginationButtonClass
      )
      .on(
        'input.automator-pagination-editor-button-class-autocomplete ' +
        'keyup.automator-pagination-editor-button-class-autocomplete',
        selectors.paginationButtonClass,
        function() {


          renderPaginationButtonClassSuggestions(

            this

          );


        }
      );


    $(document)
      .off(
        'focus.automator-pagination-editor-button-class-autocomplete',
        selectors.paginationButtonClass
      )
      .on(
        'focus.automator-pagination-editor-button-class-autocomplete',
        selectors.paginationButtonClass,
        function() {


          const input = $(this);


          ensurePaginationButtonClassAutocomplete(

            input.closest(
              selectors.paginationButtonItem
            )

          );


          if(
            getPaginationButtonClassSearchValue(
              input
            ).length >= 1
          ) {

            renderPaginationButtonClassSuggestions(

              input

            );

          }


        }
      );


    $(document)
      .off(
        'mousedown.automator-pagination-editor-button-class-result',
        '.automator-pagination-editor-button-class-result'
      )
      .on(
        'mousedown.automator-pagination-editor-button-class-result',
        '.automator-pagination-editor-button-class-result',
        function(event) {


          event.preventDefault();

          event.stopPropagation();

          event.stopImmediatePropagation();


          const result = $(this);


          const item = result.closest(

            selectors.paginationButtonItem

          );


          const input = item.find(

            selectors.paginationButtonClass

          ).first();


          const className = String(

            result.attr(
              'data-class-name'
            ) || ''

          ).trim();


          if(
            !input.length ||
            className == ''
          ) {

            return false;

          }


          addPaginationButtonClassToInput(

            input,

            className

          );


          item.find(

            '.automator-pagination-editor-button-class-results'

          )
            .empty()
            .addClass(
              'd-none'
            );


          syncPaginationButtonsState();

          setSaveState(

            true

          );


          setTimeout(function() {


            input.trigger(

              'focus'

            );


          }, 0);


          return false;


        }
      );


    $(document)
      .off(
        'click.automator-pagination-editor-button-class-result',
        '.automator-pagination-editor-button-class-result'
      )
      .on(
        'click.automator-pagination-editor-button-class-result',
        '.automator-pagination-editor-button-class-result',
        function(event) {


          event.preventDefault();

          event.stopPropagation();

          event.stopImmediatePropagation();


          return false;


        }
      );


    $(document)
      .off(
        'keydown.automator-pagination-editor-button-class-autocomplete',
        selectors.paginationButtonClass
      )
      .on(
        'keydown.automator-pagination-editor-button-class-autocomplete',
        selectors.paginationButtonClass,
        function(event) {


          if(event.key !== 'Escape') {

            return;

          }


          $(this)
            .closest(
              selectors.paginationButtonItem
            )
            .find(
              '.automator-pagination-editor-button-class-results'
            )
            .empty()
            .addClass(
              'd-none'
            );


        }
      );


    $(document)
      .off(
        'click.automator-pagination-editor-button-class-outside'
      )
      .on(
        'click.automator-pagination-editor-button-class-outside',
        function(event) {


          const target = $(

            event.target

          );


          if(
            target.closest(
              '.automator-pagination-editor-button-class-wrapper'
            ).length
          ) {

            return;

          }


          $(

            '.automator-pagination-editor-button-class-results'

          )
            .empty()
            .addClass(
              'd-none'
            );


        }
      );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Classes disponíveis para os botões da paginação
  |--------------------------------------------------------------------------
  */

  function getPaginationButtonClassSuggestions() {


    return [

      'btn',
      'btn-primary',
      'btn-secondary',
      'btn-success',
      'btn-danger',
      'btn-warning',
      'btn-info',
      'btn-light',
      'btn-dark',
      'btn-link',

      'btn-outline-primary',
      'btn-outline-secondary',
      'btn-outline-success',
      'btn-outline-danger',
      'btn-outline-warning',
      'btn-outline-info',
      'btn-outline-light',
      'btn-outline-dark',

      'btn-sm',
      'btn-lg',

      'text-primary',
      'text-secondary',
      'text-success',
      'text-danger',
      'text-warning',
      'text-info',
      'text-light',
      'text-dark',
      'text-white',
      'text-black',
      'text-muted',

      'bg-primary',
      'bg-secondary',
      'bg-success',
      'bg-danger',
      'bg-warning',
      'bg-info',
      'bg-light',
      'bg-dark',
      'bg-white',
      'bg-transparent',

      'border',
      'border-0',
      'border-primary',
      'border-secondary',
      'border-success',
      'border-danger',
      'border-warning',
      'border-info',
      'border-light',
      'border-dark',
      'border-white',

      'rounded',
      'rounded-0',
      'rounded-pill',
      'rounded-circle',

      'shadow',
      'shadow-sm',
      'shadow-lg',
      'shadow-none',

      'w-100',
      'd-inline-flex',
      'align-items-center',
      'justify-content-center',
      'text-decoration-none',
      'fw-bold',
      'fw-semibold',

    ];


  }


  function addPaginationButton(
    scope = 'actions',
    buttonData = {}
  ) {


    scope =

      scope == 'header'

        ? 'header'

        : 'actions';


    const list = $(

      selectors.paginationButtonsList +

      '[data-button-scope="' +

      scope +

      '"]'

    ).first();


    if(!list.length) {

      return false;

    }


    list.find(

      '.automator-pagination-editor-buttons-empty'

    ).remove();


    const item = renderPaginationButtonItem(

      buttonData,

      scope,

      true

    );


    if(
      !item ||
      !item.length
    ) {

      return false;

    }


    list.append(

      item

    );


    applyPaginationButtonIconFieldLayout(

      item

    );


    ensurePaginationButtonClassAutocomplete(

      item

    );


    enhancePaginationButtonClickEditor(

      item

    );


    initializePaginationButtonsSortables();


    /*
    |--------------------------------------------------------------------------
    | Sincroniza sem provocar duas renderizações consecutivas
    |--------------------------------------------------------------------------
    */


    syncPaginationButtonsState(

      false

    );


    ensurePaginationActionButtonsColumn(

      false

    );


    updatePaginationActionsUsageState();

    renderPaginationPreview();

    setSaveState(

      true

    );


    setTimeout(function() {


      item.find(

        selectors.paginationButtonID

      ).first().trigger(

        'focus'

      );


      refreshTooltips();


    }, 50);


    return item;


  }


  /*
  |--------------------------------------------------------------------------
  | Exibe painel da lateral direita
  |--------------------------------------------------------------------------
  */

  function showRightPanel(panel = 'pagination') {


    panel = String(panel || '').trim();


    if(
      panel == 'proprieties' &&
      $(selectors.proprietiesButton).prop('disabled') === true
    ) {

      return false;

    }


    hideEditorTooltips();


    $(selectors.paginationPanel)
      .removeClass('is-active');


    $(selectors.proprietiesPanel)
      .removeClass('is-active');


    if(panel == 'proprieties') {


      $(selectors.proprietiesPanel)
        .addClass('is-active');


      state.activeRightPanel = 'proprieties';


      setHeaderPanelButtonState('proprieties');


    } else {


      $(selectors.paginationPanel)
        .addClass('is-active');


      state.activeRightPanel = 'pagination';


      setHeaderPanelButtonState('pagination');


    }


    setSidebarOpen(

      'right',

      true

    );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Aparência dos botões da lateral direita
  |--------------------------------------------------------------------------
  */


  function setHeaderPanelButtonState(panel = 'pagination') {


    $(selectors.paginationButton)
      .removeClass('is-active');


    $(selectors.proprietiesButton)
      .removeClass('is-active');


    if(panel == 'proprieties') {

      $(selectors.proprietiesButton)
        .addClass('is-active');

    } else {

      $(selectors.paginationButton)
        .addClass('is-active');

    }


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Eventos das tabs da lateral direita
  |--------------------------------------------------------------------------
  */

  function bindRightTabsEvents() {


    $(document)
      .off(
        'click.automator-pagination-editor-right-tab',
        selectors.rightTabButton
      )
      .on(
        'click.automator-pagination-editor-right-tab',
        selectors.rightTabButton,
        function(event) {


          event.preventDefault();

          event.stopImmediatePropagation();


          const button = $(this);


          if(button.prop('disabled') === true) {

            return false;

          }


          const tabName = String(

            button.attr(
              'data-automator-pagination-right-tab'
            ) || ''

          ).trim();


          openRightConfigTab(tabName);


          return false;


        }
      );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Abre tab da lateral direita
  |--------------------------------------------------------------------------
  */

  function openRightConfigTab(tabName = '') {


    tabName = String(tabName || '').trim();


    const button = $(

      '#automator-pagination-editor-aside-right-tabs-button-' +
      tabName

    );


    const container = $(

      '#automator-pagination-editor-aside-right-tabs-container-' +
      tabName

    );


    if(
      !button.length ||
      !container.length ||
      button.prop('disabled') === true
    ) {

      return false;

    }


    $(selectors.rightTabButton)
      .removeClass('active');


    $(selectors.rightTabContainer)
      .removeClass('active');


    button.addClass('active');

    container.addClass('active');


    state.activeRightTab = tabName;


    showRightPanel('pagination');


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Observador de alterações
  |--------------------------------------------------------------------------
  */

  function bindChangeObserver() {


    $(document)
      .off(
        'input.automator-pagination-editor-change change.automator-pagination-editor-change',
        selectors.editor + ' input, ' +
        selectors.editor + ' select, ' +
        selectors.editor + ' textarea'
      )
      .on(
        'input.automator-pagination-editor-change change.automator-pagination-editor-change',
        selectors.editor + ' input, ' +
        selectors.editor + ' select, ' +
        selectors.editor + ' textarea',
        function() {


          if(state.initialized !== true) {

            return;

          }


          if(state.suppressChangeTracking === true) {

            return;

          }


          setSaveState(true);

          syncEditorState();


        }
      );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Wrapper do tooltip do botão salvar
  |--------------------------------------------------------------------------
  */

  function getPaginationSaveButtonTooltipWrapper() {


    const saveButton = $(

      selectors.saveButton

    ).first();


    if(!saveButton.length) {

      return $();

    }


    let wrapper = saveButton.closest(

      selectors.tooltipWrapper

    );


    if(wrapper.length) {

      wrapper
        .addClass(
          'd-inline-block'
        )
        .attr(
          'tabindex',
          '0'
        );


      return wrapper;

    }


    saveButton.wrap(

      '<span ' +

        'class="d-inline-block" ' +

        'tabindex="0" ' +

        'data-automator-pagination-tooltip ' +

        'data-automator-pagination-disabled-title="' +

          'Conclua as configurações necessárias para salvar a paginação.' +

        '"' +

      '></span>'

    );


    wrapper = saveButton.closest(

      selectors.tooltipWrapper

    );


    return wrapper;


  }


  /*
  |--------------------------------------------------------------------------
  | Estado do botão salvar
  |--------------------------------------------------------------------------
  */

  function setSaveState(changed = true) {


    changed = AutomatorNormalizeBoolean(

      changed

    );


    state.hasChanges = changed;


    const editor = $(selectors.editor);


    editor.attr(

      'data-automator-pagination-changed',

      changed === true
        ? 'true'
        : 'false'

    );


    const validation = validatePaginationEditor();


    state.validation = validation;


    const canSave =

      changed === true &&

      validation.valid === true &&

      state.submitting !== true;


    const saveButton = $(

      selectors.saveButton

    ).first();


    const wrapper =

      getPaginationSaveButtonTooltipWrapper();


    let disabledTitle =

      'Nenhuma alteração válida foi realizada.';


    if(state.submitting === true) {


      disabledTitle =

        'A paginação está sendo salva. Aguarde a conclusão da ação.';


    } else if(validation.valid !== true) {


      const validationErrors =

        Array.isArray(

          validation.errors

        )

          ? validation.errors.filter(function(
              error,
              index,
              errors
            ) {


              error = String(

                error || ''

              ).trim();


              return (

                error != '' &&

                errors.indexOf(error) === index

              );


            })

          : [];


      disabledTitle =

        validationErrors.length >= 1

          ? 'Configurações inválidas: ' +

            validationErrors.join(' ')

          : 'Existem configurações inválidas na paginação.';


    }


    saveButton.prop(

      'disabled',

      canSave !== true

    );


    /*
    |--------------------------------------------------------------------------
    | Um botão disabled não recebe eventos de mouse
    |--------------------------------------------------------------------------
    */

    saveButton.css(

      'pointer-events',

      canSave === true

        ? ''

        : 'none'

    );


    if(wrapper.length) {


      wrapper.attr(

        'data-automator-pagination-disabled-title',

        disabledTitle

      );


      wrapper.attr(

        'data-automator-pagination-enabled-title',

        'Salvar paginação'

      );


      setControlEnabled(

        saveButton,

        canSave,

        'Salvar paginação'

      );


    }


    if(changed === true) {

      bindBeforeUnloadWarning();

    } else {

      removeBeforeUnloadWarning();

    }


    return canSave;


  }


  function normalizePaginationButtonSlug(
    value = ''
  ) {


    return normalizePaginationSlug(

      value

    )
      .replace(
        /-+$/g,
        ''
      );


  }


  /*
  |--------------------------------------------------------------------------
  | Eventos dos campos com formato slug
  |--------------------------------------------------------------------------
  */

  function bindPaginationSlugEvents() {


    const paginationNameSelector =

      selectors.editor +

      ' [name="tbl_sys_pagination_name"]';


    $(document)
      .off(
        'input.automator-pagination-editor-pagination-name-slug ' +
        'keyup.automator-pagination-editor-pagination-name-slug ' +
        'paste.automator-pagination-editor-pagination-name-slug',
        paginationNameSelector
      )
      .on(
        'input.automator-pagination-editor-pagination-name-slug ' +
        'keyup.automator-pagination-editor-pagination-name-slug',
        paginationNameSelector,
        function() {


          const input = $(this);


          const normalizedValue = normalizePaginationSlug(

            input.val()

          );


          if(
            String(
              input.val() || ''
            ) != normalizedValue
          ) {

            input.val(

              normalizedValue

            );

          }


          setSaveState(

            true

          );


        }
      );


    $(document)
      .off(
        'blur.automator-pagination-editor-pagination-name-slug',
        paginationNameSelector
      )
      .on(
        'blur.automator-pagination-editor-pagination-name-slug',
        paginationNameSelector,
        function() {


          const input = $(this);


          const normalizedValue = normalizePaginationSlug(

            input.val()

          )
            .replace(
              /-+$/g,
              ''
            );


          if(
            String(
              input.val() || ''
            ) != normalizedValue
          ) {

            input.val(

              normalizedValue

            );


            setSaveState(

              true

            );

          }


        }
      );


    return true;


  }


  function normalizePaginationButtonIcon(
    value = ''
  ) {


    value = String(

      value || ''

    )
      .trim()
      .replace(
        /^fas?\s+/i,
        ''
      )
      .replace(
        /^far\s+/i,
        ''
      )
      .replace(
        /^fab\s+/i,
        ''
      )
      .replace(
        /^fa-/i,
        ''
      );


    return value;


  }


  function getPaginationConfiguredActions() {


    const actions = {};


    $(selectors.actionsManager)
      .first()
      .find(
        selectors.actionItem
      )
      .each(function() {


        const item = $(this);


        const actionName = normalizeActionName(

          item.find(
            selectors.actionName
          ).val()

        );


        const routeName = String(

          item.find(
            selectors.actionRoute
          ).val() || ''

        ).trim();


        if(
          actionName == '' ||
          routeName == ''
        ) {

          return;

        }


        actions[actionName] = actionName;


      });


    return actions;


  }


  function getPaginationButtonActionOptions(
    selectedAction = ''
  ) {


    selectedAction = String(

      selectedAction || ''

    );


    const actions =

      getPaginationConfiguredActions();


    let html =

      '<option value="">' +

        '- Selecione a ação -' +

      '</option>';


    Object.keys(actions).forEach(function(actionName) {


      html +=

        '<option value="' +

          escapeHtml(actionName) +

        '"' +

        (

          actionName == selectedAction

            ? ' selected'

            : ''

        ) +

        '>' +

          escapeHtml(actionName) +

        '</option>';


    });


    return html;


  }


  function createPaginationButtonData(
    buttonData = {}
  ) {


    buttonData = normalizePlainObject(

      buttonData

    );


    return {

      uid:

        buttonData.uid ||

        'pagination-button-' +

        Date.now() +

        '-' +

        Math.floor(
          Math.random() * 999999
        ),


      id:

        normalizePaginationButtonSlug(

          buttonData.id || ''

        ),


      type:

        String(

          buttonData.type || 'button'

        ) == 'link'

          ? 'link'

          : 'button',


      action:

        String(

          buttonData.action || ''

        ).trim(),


      class:

        String(

          buttonData.class || ''

        ).trim(),


      icon:

        normalizePaginationButtonIcon(

          buttonData.icon || ''

        ),


      text:

        String(

          buttonData.text || ''

        ).substring(
          0,
          255
        ),


      onclick:

        String(

          buttonData.onclick || ''

        ),

    };


  }


  function renderPaginationButtonItem(
    buttonData = {},
    buttonScope = 'actions',
    open = false
  ) {


    buttonData = createPaginationButtonData(

      buttonData

    );


    buttonScope =

      buttonScope == 'header'

        ? 'header'

        : 'actions';


    const collapseID =

      'automator-pagination-button-collapse-' +

      buttonData.uid;


    const title =

      buttonData.text ||

      buttonData.id ||

      'Novo botão';


    const item = $(

      '<div ' +

        'class="' +

          'accordion-item ' +

          'automator-pagination-editor-button-item ' +

          'border rounded mb-2 bg-white' +

        '" ' +

        'data-button-uid="' +

          escapeHtml(buttonData.uid) +

        '" ' +

        'data-button-scope="' +

          escapeHtml(buttonScope) +

        '"' +

      '>' +


        '<h2 class="accordion-header">' +


          '<button ' +

            'type="button" ' +

            'class="' +

              'accordion-button py-2 px-2 small fw-semibold' +

              (

                open === true

                  ? ''

                  : ' collapsed'

              ) +

            '" ' +

            'data-bs-toggle="collapse" ' +

            'data-bs-target="#' +

              escapeHtml(collapseID) +

            '" ' +

            'aria-expanded="' +

              (

                open === true

                  ? 'true'

                  : 'false'

              ) +

            '"' +

          '>' +


            '<span class="' +

              'automator-pagination-editor-button-sort-handle ' +

              'me-2 text-muted' +

            '">' +

              '<i class="fa fa-grip-vertical"></i>' +

            '</span>' +


            '<span class="' +

              'automator-pagination-editor-button-item-title ' +

              'text-truncate' +

            '">' +

              escapeHtml(title) +

            '</span>' +


          '</button>' +


        '</h2>' +


        '<div ' +

          'id="' +

            escapeHtml(collapseID) +

          '" ' +

          'class="accordion-collapse collapse' +

            (

              open === true

                ? ' show'

                : ''

            ) +

          '"' +

        '>' +


          '<div class="accordion-body p-2">' +


            '<div class="mb-2">' +

              '<label class="form-label small fw-semibold mb-1">' +

                'ID <span class="text-danger">*</span>' +

              '</label>' +

              '<input ' +

                'type="text" ' +

                'maxlength="255" ' +

                'class="' +

                  'form-control form-control-sm ' +

                  'automator-pagination-editor-button-id' +

                '" ' +

                'value="' +

                  escapeHtml(buttonData.id) +

                '" ' +

              '/>' +

              '<div class="invalid-feedback">' +

                'Informe um ID único para o botão.' +

              '</div>' +

            '</div>' +


            '<div class="mb-2">' +

              '<label class="form-label small fw-semibold mb-1">' +

                'Tipo <span class="text-danger">*</span>' +

              '</label>' +

              '<select class="' +

                'form-select form-select-sm ' +

                'automator-pagination-editor-button-type' +

              '">' +

                '<option value="button"' +

                  (

                    buttonData.type == 'button'

                      ? ' selected'

                      : ''

                  ) +

                '>Botão</option>' +

                '<option value="link"' +

                  (

                    buttonData.type == 'link'

                      ? ' selected'

                      : ''

                  ) +

                '>Link</option>' +

              '</select>' +

            '</div>' +


            '<div class="mb-2">' +

              '<label class="form-label small fw-semibold mb-1">' +

                'Ação <span class="text-danger">*</span>' +

              '</label>' +

              '<select class="' +

                'form-select form-select-sm ' +

                'automator-pagination-editor-button-action' +

              '">' +

                getPaginationButtonActionOptions(

                  buttonData.action

                ) +

              '</select>' +

              '<div class="invalid-feedback">' +

                'Selecione uma ação válida.' +

              '</div>' +

            '</div>' +


            '<div class="mb-2">' +

              '<label class="form-label small fw-semibold mb-1">' +

                'Classe' +

              '</label>' +

              '<input ' +

                'type="text" ' +

                'class="' +

                  'form-control form-control-sm ' +

                  'automator-pagination-editor-button-class' +

                '" ' +

                'value="' +

                  escapeHtml(buttonData.class) +

                '" ' +

              '/>' +

            '</div>' +


            '<div class="' +

              'mb-2 position-relative ' +

              'automator-pagination-editor-button-icon-wrapper' +

            '">' +

              '<label class="form-label small fw-semibold mb-1">' +

                'Ícone' +

              '</label>' +

              '<input ' +

                'type="hidden" ' +

                'class="automator-pagination-editor-button-icon-value" ' +

                'value="' +

                  escapeHtml(buttonData.icon) +

                '" ' +

              '/>' +

              '<div class="input-group input-group-sm">' +

                '<span class="' +

                  'input-group-text ' +

                  'automator-pagination-editor-button-icon-preview' +

                '">' +

                  '<i class="fa fa-' +

                    escapeHtml(

                      buttonData.icon ||

                      'icons'

                    ) +

                  '"></i>' +

                '</span>' +

                '<input ' +

                  'type="text" ' +

                  'autocomplete="off" ' +

                  'class="' +

                    'form-control ' +

                    'automator-pagination-editor-button-icon-search' +

                  '" ' +

                  'placeholder="Buscar ícone..." ' +

                '/>' +

              '</div>' +

              '<div class="' +

                'automator-pagination-editor-button-icon-results ' +

                'position-absolute start-0 end-0 bg-white border ' +

                'rounded shadow d-none' +

              '" style="' +

                'bottom: calc(100% + 4px); ' +

                'max-height: 190px; ' +

                'overflow-y: auto; ' +

                'z-index: 1090;' +

              '"></div>' +

            '</div>' +


            '<div class="mb-2">' +

              '<label class="form-label small fw-semibold mb-1">' +

                'Texto <span class="text-danger">*</span>' +

              '</label>' +

              '<input ' +

                'type="text" ' +

                'maxlength="255" ' +

                'class="' +

                  'form-control form-control-sm ' +

                  'automator-pagination-editor-button-text' +

                '" ' +

                'value="' +

                  escapeHtml(buttonData.text) +

                '" ' +

              '/>' +

              '<div class="invalid-feedback">' +

                'Informe o texto do botão.' +

              '</div>' +

            '</div>' +


            '<div class="mb-3">' +

              '<label class="form-label small fw-semibold mb-1">' +

                'Click' +

              '</label>' +

              '<input ' +

                'type="text" ' +

                'class="' +

                  'form-control form-control-sm ' +

                  'automator-pagination-editor-button-onclick' +

                '" ' +

                'value="' +

                  escapeHtml(buttonData.onclick) +

                '" ' +

              '/>' +

            '</div>' +


            '<button ' +

              'type="button" ' +

              'class="' +

                'btn btn-sm btn-outline-danger w-100 ' +

                'automator-pagination-editor-button-delete' +

              '"' +

            '>' +

              '<i class="fa fa-trash me-1"></i>' +

              'Remover botão' +

            '</button>' +


          '</div>' +


        '</div>' +


      '</div>'

    );


    item.data(

      'automator-pagination-button',

      buttonData

    );


    return item;


  }


  function preparePaginationButtonsContainers() {


    [

      {

        scope: 'header',

        wrapper: $(

          selectors.headerButtonsWrapper

        ),

      },

      {

        scope: 'actions',

        wrapper: $(

          selectors.actionButtonsWrapper

        ),

      },

    ].forEach(function(config) {


      const wrapper = config.wrapper;


      if(!wrapper.length) {

        return;

      }


      let list = wrapper.children(

        selectors.paginationButtonsList

      ).first();


      if(!list.length) {


        list = $(

          '<div ' +

            'class="' +

              'accordion ' +

              'automator-pagination-editor-buttons-list ' +

              'px-3 pt-3' +

            '" ' +

            'data-button-scope="' +

              escapeHtml(config.scope) +

            '" ' +

            'data-empty="Nenhum botão adicionado."' +

          '></div>'

        );


        wrapper.prepend(

          list

        );


      }


    });


    return true;


  }


  function initializePaginationButtons(
    recordData = null
  ) {


    preparePaginationButtonsContainers();


    bindPaginationButtonClickBuilderEvents();


    if(
      recordData === null ||
      recordData === undefined
    ) {

      recordData = state.recordData;

    }


    recordData = normalizePlainObject(

      recordData

    );


    let headerButtons = getPaginationRecordValue(

      recordData,

      [

        'header_actions',
        'tbl_sys_pagination_header_actions',
        'pagination_args.header_actions',

      ],

      []

    );


    let actionButtons = getPaginationRecordValue(

      recordData,

      [

        'list_actions',
        'tbl_sys_pagination_list_actions',
        'pagination_args.list_actions',

      ],

      []

    );


    headerButtons = normalizeArrayValue(

      headerButtons

    );


    actionButtons = normalizeArrayValue(

      actionButtons

    );


    state.paginationButtons.header =

      headerButtons.map(function(buttonData) {


        return createPaginationButtonData(

          buttonData

        );


      });


    state.paginationButtons.actions =

      actionButtons.map(function(buttonData) {


        return createPaginationButtonData(

          buttonData

        );


      });


    renderPaginationButtonsList(

      'header',

      state.paginationButtons.header

    );


    renderPaginationButtonsList(

      'actions',

      state.paginationButtons.actions

    );


    initializePaginationButtonsSortables();

    updatePaginationButtonActionOptions();

    updatePaginationActionsUsageState();

    ensurePaginationActionButtonsColumn();


    return true;


  }


  function renderPaginationButtonsList(
    scope = 'actions',
    buttons = []
  ) {


    scope =

      scope == 'header'

        ? 'header'

        : 'actions';


    buttons = normalizeArrayValue(

      buttons

    );


    const list = $(

      selectors.paginationButtonsList +

      '[data-button-scope="' +

      scope +

      '"]'

    ).first();


    if(!list.length) {

      return false;

    }


    list.empty();


    buttons.forEach(function(buttonData) {


      const item = renderPaginationButtonItem(

        buttonData,

        scope,

        false

      );


      list.append(

        item

      );


      applyPaginationButtonIconFieldLayout(

        item

      );


      ensurePaginationButtonClassAutocomplete(

        item

      );


      enhancePaginationButtonClickEditor(

        item

      );


    });


    updatePaginationButtonsEmptyState(

      list

    );


    refreshTooltips();


    return true;


  }


  function renderPaginationPreviewHeaderButton(
    buttonData = {}
  ) {


    buttonData = createPaginationButtonData(

      buttonData

    );


    const configuredActions =

      getPaginationConfiguredActions();


    const valid =

      buttonData.id != '' &&

      buttonData.text != '' &&

      buttonData.action != '' &&

      Object.prototype.hasOwnProperty.call(

        configuredActions,

        buttonData.action

      );


    if(valid !== true) {


      return (

        '<span ' +

          'class="' +

            'automator-pagination-editor-preview-tooltip-wrapper ' +

            'd-inline-block' +

          '" ' +

          'tabindex="0" ' +

          'data-bs-toggle="tooltip" ' +

          'data-bs-trigger="hover focus" ' +

          'data-bs-placement="top" ' +

          'data-bs-title="Configuração incompleta"' +

        '>' +

          '<button ' +

            'type="button" ' +

            'disabled ' +

            'tabindex="-1" ' +

            'aria-disabled="true" ' +

            'class="' +

              'btn btn-danger ' +

              'text-decoration-none' +

            '"' +

          '>' +

            '<i class="' +

              'fa fa-exclamation-triangle me-2 ' +

              'text-decoration-none' +

            '"></i>' +

            '<span class="text-decoration-none">' +

              'Configuração incompleta' +

            '</span>' +

          '</button>' +

        '</span>'

      );


    }


    let className = String(

      buttonData.class || ''

    ).trim();


    if(className == '') {

      className = 'btn-primary';

    }


    if(
      !/(^|\s)btn(\s|$)/.test(
        className
      )
    ) {

      className =

        'btn ' +

        className;

    }


    if(
      !/(^|\s)text-decoration-none(\s|$)/.test(
        className
      )
    ) {

      className +=

        ' text-decoration-none';

    }


    const tagName =

      buttonData.type == 'link'

        ? 'a'

        : 'button';


    let html =

      '<' +

      tagName +

      ' ';


    if(tagName == 'button') {

      html +=

        'type="button" ';

    } else {

      html +=

        'href="javascript:void(0)" ';

    }


    html +=

      'class="' +

        escapeHtml(className) +

      '" ' +

      'style="text-decoration: none;"' +

      '>' +


        (

          buttonData.icon != ''

            ? '<i class="' +

                'fa fa-' +

                escapeHtml(buttonData.icon) +

                ' me-2 text-decoration-none' +

              '"></i>'

            : ''

        ) +


        '<span class="text-decoration-none">' +

          escapeHtml(

            buttonData.text

          ) +

        '</span>' +


      '</' +

      tagName +

      '>';


    return html;


  }


  function renderPaginationPreviewHeaderButtons() {


    const buttons = getPaginationButtonsData(

      'header'

    );


    if(buttons.length <= 0) {

      return '';

    }


    let html = '';


    buttons.forEach(function(buttonData) {


      html +=

        '<span class="' +

          'd-inline-block me-2 mb-2 align-middle ' +

          'text-decoration-none' +

        '">' +

          renderPaginationPreviewHeaderButton(

            buttonData

          ) +

        '</span>';


    });


    return html;


  }


  function initializePaginationButtonsSortables() {


    if(typeof Sortable === 'undefined') {

      return false;

    }


    [

      {

        stateKey: 'headerButtonsSortable',

        scope: 'header',

      },

      {

        stateKey: 'actionButtonsSortable',

        scope: 'actions',

      },

    ].forEach(function(config) {


      if(state[config.stateKey]) {


        try {

          state[config.stateKey].destroy();

        } catch(e) {}


        state[config.stateKey] = null;


      }


      const list = document.querySelector(

        selectors.paginationButtonsList +

        '[data-button-scope="' +

        config.scope +

        '"]'

      );


      if(!list) {

        return;

      }


      state[config.stateKey] = new Sortable(

        list,

        {

          animation: 150,

          handle:
            selectors.paginationButtonSortHandle,

          draggable:
            selectors.paginationButtonItem,

          ghostClass:
            'automator-pagination-editor-sortable-ghost',

          chosenClass:
            'automator-pagination-editor-sortable-chosen',

          onEnd: function() {


            syncPaginationButtonsState();

            renderPaginationPreview();

            setSaveState(true);


          },

        }

      );


    });


    return true;


  }


  function getAvailableFontAwesomeIcons() {


    if(
      Array.isArray(
        window.__automatorPaginationFontAwesomeIcons
      )
    ) {

      return window.__automatorPaginationFontAwesomeIcons;

    }


    const icons = {};


    function registerIconName(
      iconName = ''
    ) {


      iconName = normalizePaginationButtonIcon(

        iconName

      );


      if(iconName == '') {

        return;

      }


      icons[iconName] = true;


    }


    Array.prototype.slice.call(

      document.styleSheets || []

    ).forEach(function(styleSheet) {


      let rules = [];


      try {

        rules = styleSheet.cssRules || [];

      } catch(e) {

        return;

      }


      Array.prototype.slice.call(

        rules

      ).forEach(function(rule) {


        const selectorText = String(

          rule.selectorText || ''

        );


        if(selectorText == '') {

          return;

        }


        const matches = selectorText.match(

          /\.fa-([a-z0-9-]+)(?=[:.,\s>+~#\[]|$)/gi

        );


        if(!matches) {

          return;

        }


        matches.forEach(function(match) {


          registerIconName(

            match.replace(
              /^\.fa-/i,
              ''
            )

          );


        });


      });


    });


    window.__automatorPaginationFontAwesomeIcons =

      Object.keys(icons).sort();


    return window.__automatorPaginationFontAwesomeIcons;


  }


  function renderPaginationButtonIconResults(
    item,
    searchValue = ''
  ) {


    item = $(item);


    searchValue = normalizePaginationButtonIcon(

      searchValue

    ).toLowerCase();


    const results = item.find(

      selectors.paginationButtonIconResults

    ).first();


    if(searchValue == '') {


      results
        .empty()
        .addClass('d-none');


      return false;


    }


    const icons = getAvailableFontAwesomeIcons()
      .filter(function(iconName) {


        return iconName
          .toLowerCase()
          .indexOf(searchValue) >= 0;


      })
      .slice(
        0,
        100
      );


    let html = '';


    icons.forEach(function(iconName) {


      html +=

        '<button ' +

          'type="button" ' +

          'class="' +

            'btn btn-sm btn-light border-0 rounded-0 ' +

            'w-100 text-start ' +

            'automator-pagination-editor-button-icon-result' +

          '" ' +

          'data-icon="' +

            escapeHtml(iconName) +

          '"' +

        '>' +

          '<i class="fa fa-' +

            escapeHtml(iconName) +

          ' me-2"></i>' +

          escapeHtml(iconName) +

        '</button>';


    });


    if(html == '') {


      html =

        '<div class="small text-muted p-2">' +

          'Nenhum ícone encontrado.' +

        '</div>';


    }


    results
      .html(html)
      .removeClass('d-none');


    return true;


  }


  function validatePaginationButtonItem(
    item
  ) {


    item = $(item);


    const list = item.closest(

      selectors.paginationButtonsList

    );


    const idInput = item.find(

      selectors.paginationButtonID

    ).first();


    const actionInput = item.find(

      selectors.paginationButtonAction

    ).first();


    const textInput = item.find(

      selectors.paginationButtonText

    ).first();


    const iconInput = item.find(

      selectors.paginationButtonIconHidden

    ).first();


    const iconWrapper = item.find(

      '.automator-pagination-editor-button-icon-wrapper'

    ).first();


    const buttonScope = String(

      item.attr(
        'data-button-scope'
      ) || 'actions'

    ).trim();


    const buttonID = normalizePaginationButtonSlug(

      idInput.val()

    );


    const actionName = String(

      actionInput.val() || ''

    ).trim();


    const buttonText = String(

      textInput.val() || ''

    ).trim();


    const iconName = normalizePaginationButtonIcon(

      iconInput.val()

    );


    let duplicatedID = false;


    if(buttonID != '') {


      list.find(

        selectors.paginationButtonItem

      ).not(item).each(function() {


        const currentID = normalizePaginationButtonSlug(

          $(this)
            .find(
              selectors.paginationButtonID
            )
            .val()

        );


        if(currentID == buttonID) {

          duplicatedID = true;

        }


      });


    }


    const availableActions =

      getPaginationConfiguredActions();


    const idValid =

      buttonID != '' &&

      buttonID.length <= 255 &&

      duplicatedID !== true;


    const actionValid =

      actionName != '' &&

      Object.prototype.hasOwnProperty.call(

        availableActions,

        actionName

      );


    const textValid =

      buttonText != '' &&

      buttonText.length <= 255;


    /*
    |--------------------------------------------------------------------------
    | O ícone é opcional para botões do cabeçalho
    |--------------------------------------------------------------------------
    */

    const iconValid =

      buttonScope == 'header' ||

      iconName != '';


    idInput.toggleClass(

      'is-invalid',

      idValid !== true

    );


    actionInput.toggleClass(

      'is-invalid',

      actionValid !== true

    );


    textInput.toggleClass(

      'is-invalid',

      textValid !== true

    );


    iconWrapper.toggleClass(

      'is-invalid',

      iconValid !== true

    );


    iconWrapper.find(

      '.automator-pagination-editor-button-icon-input-group'

    ).toggleClass(

      'border border-danger rounded',

      iconValid !== true

    );


    const valid =

      idValid === true &&

      actionValid === true &&

      textValid === true &&

      iconValid === true;


    item.attr(

      'data-button-valid',

      valid === true

        ? 'true'

        : 'false'

    );


    return valid;


  }


  function getPaginationButtonDataFromItem(
    item
  ) {


    item = $(item);


    const buttonData = createPaginationButtonData({

      uid:

        item.attr(
          'data-button-uid'
        ) || '',


      id:

        item.find(
          selectors.paginationButtonID
        ).val(),


      type:

        item.find(
          selectors.paginationButtonType
        ).val(),


      action:

        item.find(
          selectors.paginationButtonAction
        ).val(),


      class:

        item.find(
          selectors.paginationButtonClass
        ).val(),


      icon:

        item.find(
          selectors.paginationButtonIconHidden
        ).val(),


      text:

        item.find(
          selectors.paginationButtonText
        ).val(),


      onclick:

        item.find(
          selectors.paginationButtonOnclick
        ).val(),

    });


    item.data(

      'automator-pagination-button',

      buttonData

    );


    return buttonData;


  }


  function getPaginationButtonsData(
    scope = 'actions'
  ) {


    scope =

      scope == 'header'

        ? 'header'

        : 'actions';


    const buttons = [];


    $(

      selectors.paginationButtonsList +

      '[data-button-scope="' +

      scope +

      '"]'

    )
      .first()
      .find(
        selectors.paginationButtonItem
      )
      .each(function() {


        buttons.push(

          getPaginationButtonDataFromItem(

            this

          )

        );


      });


    return buttons;


  }


  function syncPaginationButtonsState(
    renderPreview = true
  ) {


    state.paginationButtons.header =

      getPaginationButtonsData(

        'header'

      );


    state.paginationButtons.actions =

      getPaginationButtonsData(

        'actions'

      );


    $(selectors.paginationButtonItem).each(function() {


      const item = $(this);


      validatePaginationButtonItem(

        item

      );


      const buttonData =

        getPaginationButtonDataFromItem(

          item

        );


      item
        .find(
          '.automator-pagination-editor-button-item-title'
        )
        .text(

          buttonData.text ||

          buttonData.id ||

          'Novo botão'

        );


    });


    updatePaginationActionsUsageState();


    if(renderPreview === true) {

      renderPaginationPreview();

    }


    return state.paginationButtons;


  }


  function updatePaginationButtonActionOptions() {


    $(selectors.paginationButtonItem).each(function() {


      const item = $(this);


      const select = item.find(

        selectors.paginationButtonAction

      ).first();


      if(!select.length) {

        return;

      }


      const currentValue = String(

        select.val() || ''

      ).trim();


      select.html(

        getPaginationButtonActionOptions(

          currentValue

        )

      );


      const currentOptionExists = select
        .find('option')
        .filter(function() {


          return String(

            $(this).val() || ''

          ) == currentValue;


        })
        .length >= 1;


      if(
        currentValue != '' &&
        currentOptionExists === true
      ) {

        select.val(

          currentValue

        );

      } else if(currentValue != '') {

        select.val('');

      }


      validatePaginationButtonItem(

        item

      );


    });


    updatePaginationActionsUsageState();


    return true;


  }


  function isPaginationActionUsedByButton(
    actionName = ''
  ) {


    actionName = String(

      actionName || ''

    ).trim();


    if(actionName == '') {

      return false;

    }


    let used = false;


    $(selectors.paginationButtonAction).each(function() {


      if(
        String(
          $(this).val() || ''
        ).trim() == actionName
      ) {

        used = true;

      }


    });


    return used;


  }


  function updatePaginationActionsUsageState() {


    $(selectors.actionItem).each(function() {


      const item = $(this);


      const actionName = normalizeActionName(

        item.find(
          selectors.actionName
        ).val()

      );


      const deleteButton = item.find(

        selectors.actionDelete

      ).first();


      if(!deleteButton.length) {

        return;

      }


      let tooltipWrapper = deleteButton.parent(

        '.automator-pagination-editor-action-delete-tooltip'

      );


      if(!tooltipWrapper.length) {


        deleteButton.wrap(

          '<span ' +

            'class="' +

              'd-block w-100 ' +

              'automator-pagination-editor-action-delete-tooltip' +

            '"' +

          '></span>'

        );


        tooltipWrapper = deleteButton.parent(

          '.automator-pagination-editor-action-delete-tooltip'

        );


      }


      tooltipWrapper.addClass(

        'd-block w-100'

      );


      deleteButton.addClass(

        'w-100'

      );


      const actionInUse =

        actionName != '' &&

        isPaginationActionUsedByButton(

          actionName

        );


      deleteButton.prop(

        'disabled',

        actionInUse

      );


      const tooltipText =

        actionInUse === true

          ? 'Esta ação está em uso na paginação e não é possivel remove-la'

          : 'Excluir ação';


      disposeTooltip(

        tooltipWrapper[0]

      );


      tooltipWrapper
        .attr(
          'data-bs-toggle',
          'tooltip'
        )
        .attr(
          'data-bs-placement',
          'left'
        )
        .attr(
          'data-bs-trigger',
          'hover'
        )
        .attr(
          'data-bs-title',
          tooltipText
        )
        .attr(
          'title',
          tooltipText
        );


      deleteButton
        .removeAttr(
          'data-bs-toggle'
        )
        .removeAttr(
          'data-bs-placement'
        )
        .removeAttr(
          'data-bs-trigger'
        )
        .removeAttr(
          'data-bs-title'
        )
        .removeAttr(
          'title'
        );


      createTooltip(

        tooltipWrapper[0]

      );


    });


    return true;


  }


  function updatePaginationButtonsEmptyState(
    list
  ) {


    list = $(list);


    list.find(

      '.automator-pagination-editor-buttons-empty'

    ).remove();


    if(
      list.find(
        selectors.paginationButtonItem
      ).length <= 0
    ) {


      list.append(

        '<div class="' +

          'automator-pagination-editor-buttons-empty ' +

          'small text-muted text-center border rounded ' +

          'border-dashed p-3 mb-2' +

        '">' +

          escapeHtml(

            list.attr('data-empty') ||

            'Nenhum botão adicionado.'

          ) +

        '</div>'

      );


    }


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Validação geral
  |--------------------------------------------------------------------------
  */

  function validatePaginationEditor() {


    const errors = [];


    validatePaginationSettings(

      errors

    );


    validatePaginationQueryFilters(

      errors

    );


    validatePaginationColumns(

      errors

    );


    validatePaginationActions(

      errors

    );


    validatePaginationButtons(

      errors

    );


    return {

      valid:

        errors.length <= 0,


      errors:

        errors,

    };


  }


  /*
  |--------------------------------------------------------------------------
  | Configurações básicas
  |--------------------------------------------------------------------------
  */

  function validatePaginationSettings(
    errors = []
  ) {


    const tableValue = String(

      $(selectors.table).val() || ''

    ).trim();


    const indexValue = String(

      $(selectors.index).val() || ''

    ).trim();


    if(tableValue == '') {

      errors.push(

        'Selecione a tabela da paginação.'

      );

    }


    if(indexValue == '') {

      errors.push(

        'Selecione o índice da paginação.'

      );

    }


    $(selectors.editor)
      .find(
        '.automator-pagination-editor-setting[required]'
      )
      .each(function() {


        const input = $(this);


        if(input.prop('disabled') === true) {

          return;

        }


        let valid = true;


        if(
          input.attr('type') == 'checkbox'
        ) {

          valid = input.prop('checked') === true;

        } else {

          valid = String(

            input.val() || ''

          ).trim() != '';

        }


        input.toggleClass(

          'is-invalid',

          valid !== true

        );


        if(valid !== true) {

          errors.push(

            'Preencha o campo obrigatório "' +

            String(

              input.attr('name') ||

              input.attr('id') ||

              'Configuração'

            ) +

            '".'

          );

        }


      });


    return errors;


  }

  /*
  |--------------------------------------------------------------------------
  | Validação das colunas
  |--------------------------------------------------------------------------
  */

  function validatePaginationColumns(
    errors = []
  ) {


    const columns = getColumnsData();


    if(columns.length <= 0) {

      errors.push(

        'Adicione pelo menos uma coluna à paginação.'

      );


      return errors;

    }


    columns.forEach(function(column, index) {


      column = normalizePaginationColumnData(

        column

      );


      if(column.isActionButtonsColumn === true) {

        return;

      }


      const columnName = String(

        column.name || ''

      ).trim();


      const columnLabel = String(

        column.label || ''

      ).trim();


      if(columnName == '') {

        errors.push(

          'Selecione a coluna da tabela no item ' +

          (index + 1) +

          '.'

        );

      }


      if(columnLabel == '') {

        errors.push(

          'Informe o título da coluna no item ' +

          (index + 1) +

          '.'

        );

      }


      /*
      |--------------------------------------------------------------------------
      | Colunas repetidas são permitidas
      |--------------------------------------------------------------------------
      |
      | Uma coluna relacional pode utilizar a mesma chave física de outra
      | coluna. Por exemplo, tbl_user_ID pode ser exibida como ID e também
      | utilizada para resolver o registro relacionado do tipo de usuário.
      |
      */


      const sizeType = String(

        getNestedValue(

          column.attrs,

          'configs.size-type',

          'auto'

        ) || 'auto'

      ).trim();


      const sizeValue = getNestedValue(

        column.attrs,

        'configs.size-value',

        null

      );


      if(sizeType == 'percent') {


        const parsedSize = parseFloat(

          sizeValue

        );


        if(
          !Number.isFinite(parsedSize) ||
          parsedSize < 1 ||
          parsedSize > 100
        ) {

          errors.push(

            'O tamanho percentual da coluna "' +

            (

              columnLabel ||

              columnName ||

              index + 1

            ) +

            '" deve estar entre 1 e 100.'

          );

        }


      }


      if(sizeType == 'px') {


        const parsedSize = parseFloat(

          sizeValue

        );


        if(
          !Number.isFinite(parsedSize) ||
          parsedSize < 1
        ) {

          errors.push(

            'O tamanho em PX da coluna "' +

            (

              columnLabel ||

              columnName ||

              index + 1

            ) +

            '" deve ser maior ou igual a 1.'

          );

        }


      }


      const accessValues = normalizePaginationAccessValues(

        column.access

      );


      if(
        state.developerUserTypeID &&
        accessValues.indexOf(

          String(
            state.developerUserTypeID
          )

        ) < 0
      ) {

        errors.push(

          'O acesso do tipo Desenvolvedor é obrigatório.'

        );

      }


    });


    return errors;


  }


  /*
  |--------------------------------------------------------------------------
  | Validação das ações
  |--------------------------------------------------------------------------
  */

  function validatePaginationActions(
    errors = []
  ) {


    $(selectors.actionsManager).each(function() {


      const manager = $(this);


      manager.find(

        selectors.actionItem

      ).each(function(index) {


        const item = $(this);


        const actionName = normalizeActionName(

          item.find(
            selectors.actionName
          ).val()

        );


        const routeName = String(

          item.find(
            selectors.actionRoute
          ).val() || ''

        ).trim();


        if(actionName == '') {


          errors.push(

            'Informe o nome da ação ' +

            (index + 1) +

            '.'

          );


        }


        if(
          validateActionName(

            manager,

            item

          ) !== true
        ) {


          errors.push(

            'O nome da ação "' +

            (

              actionName ||

              index + 1

            ) +

            '" é inválido ou está duplicado.'

          );


        }


        if(routeName == '') {


          errors.push(

            'Selecione a rota da ação "' +

            (

              actionName ||

              index + 1

            ) +

            '".'

          );


        }


        if(
          validateActionParams(

            item

          ) !== true
        ) {


          errors.push(

            'Existem parâmetros inválidos na ação "' +

            (

              actionName ||

              index + 1

            ) +

            '".'

          );


        }


        if(
          validatePaginationActionRoles(

            item

          ) !== true
        ) {


          errors.push(

            'Existem regras de uso inválidas na ação "' +

            (

              actionName ||

              index + 1

            ) +

            '".'

          );


        }


      });


    });


    return errors;


  }


  /*
  |--------------------------------------------------------------------------
  | Alerta ao recarregar ou sair da página
  |--------------------------------------------------------------------------
  */

  function bindBeforeUnloadWarning() {


    removeBeforeUnloadWarning();


    window.__automatorPaginationEditorBeforeUnloadHandler = function(event) {


      if(hasActiveUnsavedChanges() !== true) {

        return;

      }


      const message =
        'Existem alterações não salvas. Ao sair, as informações alteradas poderão ser perdidas.';


      event.preventDefault();

      event.returnValue = message;


      return message;


    };


    window.addEventListener(

      'beforeunload',

      window.__automatorPaginationEditorBeforeUnloadHandler

    );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Remove alerta de saída
  |--------------------------------------------------------------------------
  */

  function removeBeforeUnloadWarning() {


    if(window.__automatorPaginationEditorBeforeUnloadHandler) {


      window.removeEventListener(

        'beforeunload',

        window.__automatorPaginationEditorBeforeUnloadHandler

      );


      window.__automatorPaginationEditorBeforeUnloadHandler = null;


    }


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Limpa observadores de alterações
  |--------------------------------------------------------------------------
  */

  function clearUnsavedChangesWarning() {


    state.hasChanges = false;


    const editor = document.querySelector(

      selectors.editor

    );


    if(editor) {


      editor.setAttribute(

        'data-automator-pagination-changed',

        'false'

      );


      editor.removeAttribute(

        'data-automator-pagination-submit'

      );


      editor.removeAttribute(

        'data-automator-pagination-close-confirmed'

      );


    }


    removeBeforeUnloadWarning();


    $(window).off(

      'beforeunload.AutomatorPaginationEditorChanged'

    );


    if($(selectors.saveButton).length) {


      $(selectors.saveButton).prop(

        'disabled',

        true

      );


    }


    return true;


  }



  /*
  |--------------------------------------------------------------------------
  | Finaliza alterações depois de um submit realizado
  |--------------------------------------------------------------------------
  */

  function clearPaginationEditorChangesAfterSubmit() {


    state.hasChanges = false;

    state.submitting = false;

    state.suppressChangeTracking = true;


    const editor = document.querySelector(

      selectors.editor

    );


    if(editor) {


      editor.setAttribute(

        'data-automator-pagination-changed',

        'false'

      );


      editor.setAttribute(

        'data-automator-pagination-submit',

        'true'

      );


      editor.setAttribute(

        'data-automator-pagination-close-confirmed',

        'true'

      );


    }


    removeBeforeUnloadWarning();


    /*
    |--------------------------------------------------------------------------
    | Remove também o observador genérico da ação em andamento
    |--------------------------------------------------------------------------
    |
    | A persistência já foi concluída. A partir deste ponto, fechar o toast,
    | fechar o modal ou recarregar a página não deve gerar confirmação de saída.
    |
    */

    if(
      typeof window.AutomatorSetActionStatus === 'function'
    ) {

      AutomatorSetActionStatus(

        false

      );

    }


    $(window).off(

      'beforeunload.AutomatorModalFormChanged'

    );


    $(window).off(

      'beforeunload.AutomatorPaginationEditorChanged'

    );


    $(window).off(

      'beforeunload.AutomatorSetActionStatus'

    );


    if($(selectors.saveButton).length) {


      $(selectors.saveButton).prop(

        'disabled',

        true

      );


    }


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Verifica alterações ativas
  |--------------------------------------------------------------------------
  */

  function hasActiveUnsavedChanges() {


    const editor = document.querySelector(

      selectors.editor

    );


    if(!editor) {

      return false;

    }


    const modal = editor.closest('.modal');


    if(!modal) {

      return false;

    }


    const modalIsOpen =

      modal.classList.contains('show') ||

      $(modal).is(':visible');


    if(modalIsOpen !== true) {

      return false;

    }


    if(
      editor.getAttribute(
        'data-automator-pagination-submit'
      ) === 'true'
    ) {

      return false;

    }


    if(
      editor.getAttribute(
        'data-automator-pagination-changed'
      ) !== 'true'
    ) {

      return false;

    }


    return state.hasChanges === true;


  }


  /*
  |--------------------------------------------------------------------------
  | Solicita fechamento do editor
  |--------------------------------------------------------------------------
  */

  function requestCloseEditorModal(
    closeButton = null
  ) {


    const editor = document.querySelector(

      selectors.editor

    );


    if(!editor) {

      return true;

    }


    const modal = editor.closest('.modal');


    if(!modal) {

      return true;

    }


    if(hasActiveUnsavedChanges() === true) {


      const confirmClose = confirm(

        'Existem alterações não salvas. Deseja realmente fechar este editor?'

      );


      if(confirmClose !== true) {

        return false;

      }


    }


    clearUnsavedChangesWarning();


    editor.setAttribute(

      'data-automator-pagination-close-confirmed',

      'true'

    );


    if(
      closeButton &&
      modal.contains(closeButton)
    ) {


      closeButton.click();


      return true;

    }


    const originalCloseButton = modal.querySelector(

      '.js-automator-view-modal-close'

    );


    if(originalCloseButton) {


      originalCloseButton.click();


      return true;

    }


    const modalInstance = bootstrap.Modal.getInstance(

      modal

    );


    if(modalInstance) {

      modalInstance.hide();

    }


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Intercepta fechamento do modal
  |--------------------------------------------------------------------------
  */

  function bindUnsavedModalCloseWarning() {


    const editor = document.querySelector(

      selectors.editor

    );


    if(!editor) {

      return false;

    }


    const modal = editor.closest('.modal');


    if(!modal) {

      return false;

    }


    if(window.__automatorPaginationEditorCloseCaptureHandler) {


      document.removeEventListener(

        'click',

        window.__automatorPaginationEditorCloseCaptureHandler,

        true

      );


      window.__automatorPaginationEditorCloseCaptureHandler = null;


    }


    window.__automatorPaginationEditorCloseCaptureHandler = function(event) {


      const closeButton = event.target.closest(

        '.js-automator-view-modal-close, ' +
        '[data-bs-dismiss="modal"]'

      );


      if(
        !closeButton ||
        !modal.contains(closeButton)
      ) {

        return;

      }


      if(
        editor.getAttribute(
          'data-automator-pagination-close-confirmed'
        ) === 'true'
      ) {

        editor.removeAttribute(

          'data-automator-pagination-close-confirmed'

        );


        return;

      }


      if(hasActiveUnsavedChanges() !== true) {

        return;

      }


      event.preventDefault();

      event.stopPropagation();

      event.stopImmediatePropagation();


      requestCloseEditorModal(closeButton);


    };


    document.addEventListener(

      'click',

      window.__automatorPaginationEditorCloseCaptureHandler,

      true

    );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Sincroniza estado geral do editor
  |--------------------------------------------------------------------------
  */

  function syncEditorState() {


    const tableSelect = $(selectors.table);

    const indexSelect = $(selectors.index);


    const tableValue = String(

      tableSelect.val() || ''

    ).trim();


    const indexValue = String(

      indexSelect.val() || ''

    ).trim();


    const hasTable = tableValue != '';

    const hasIndex = indexValue != '';

    const hasDependentData = hasDependentInformation();

    const hasActions = hasRegisteredActions();

    const selectedColumn = getSelectedColumnItem();

    const hasSelectedColumn = selectedColumn.length >= 1;


    state.selectedTable = tableValue;

    state.selectedIndex = indexValue;


    indexSelect.prop(

      'disabled',

      state.columnsLoading === true ||

      hasTable === false ||

      (

        hasDependentData === true &&

        hasIndex === true

      )

    );


    tableSelect.prop(

      'disabled',

      state.tableLoading === true ||

      hasIndex === true

    );


    setEditorActionsEnabled(

      hasIndex

    );


    setProprietiesEnabled(

      hasIndex === true &&
      hasSelectedColumn === true,

      hasIndex === true

        ? 'Nenhuma coluna foi selecionada.'

        : 'Selecione uma tabela e um índice antes de editar propriedades.'

    );


    setAddButtonsEnabled(

      hasIndex,

      hasActions

    );


    refreshPaginationQueryFilterColumnOptions();

    updatePaginationQueryFiltersAvailability();


    if(hasIndex !== true) {


      clearSelectedColumn();

      renderPaginationPreview();


      if(
        state.activeLeftTab == 'inserter' ||
        state.activeLeftTab == 'buttons'
      ) {

        switchLeftTab(

          'structure'

        );

      }


      if(
        state.activeRightTab == 'pagination-actions'
      ) {

        openRightConfigTab(

          'pagination-settings'

        );

      }


      if(
        state.activeRightPanel == 'proprieties'
      ) {

        showRightPanel(

          'pagination'

        );

      }


    }


    updateStructureEmptyState();

    refreshTooltips();


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Inicializa pré-visualização da paginação
  |--------------------------------------------------------------------------
  */

  function initializePaginationPreview() {


    const canvasContent = $(

      selectors.canvasContent

    );


    if(!canvasContent.length) {

      return false;

    }


    canvasContent.html(

      '<div ' +

        'id="automator-pagination-editor-preview" ' +

        'class="automator-pagination-editor-preview h-100 w-100"' +

      '></div>'

    );


    renderPaginationPreview();


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Renderiza pré-visualização da paginação
  |--------------------------------------------------------------------------
  */


  function renderPaginationPreview() {


    const preview = $(

      selectors.preview

    );


    if(!preview.length) {

      return false;

    }


    const tableValue = String(

      $(selectors.table).val() || ''

    ).trim();


    const indexValue = String(

      $(selectors.index).val() || ''

    ).trim();


    if(
      tableValue == '' ||
      indexValue == ''
    ) {


      preview.html(

        '<div class="' +

          'automator-pagination-editor-preview-message ' +

          'd-flex align-items-center justify-content-center ' +

          'text-center text-muted p-4' +

        '">' +

          '<div>' +

            '<i class="' +

              'fa fa-triangle-exclamation fs-2 mb-3 d-block' +

            '"></i>' +

            '<strong class="d-block mb-1">' +

              'Configuração incompleta' +

            '</strong>' +

            '<span class="small">' +

              'Selecione uma tabela e a chave primária para configurar a paginação.' +

            '</span>' +

          '</div>' +

        '</div>'

      );


      return true;

    }


    const columns = getColumnsData();


    const actionButtons = getPaginationButtonsData(

      'actions'

    );


    const headerButtons = getPaginationButtonsData(

      'header'

    );


    const hasActionButtons =

      actionButtons.length > 0;


    const hasHeaderButtons =

      headerButtons.length > 0;


    const searchableColumns =

      getPaginationSearchableColumns();


    const hasSearchableColumn =

      searchableColumns.length > 0;


    const deleteAction =

      getPaginationDeleteAction();


    const hasDeleteAction =

      deleteAction !== null;


    const perPageValue = getPaginationPerPageValue();


    if(
      columns.length <= 0 &&
      hasActionButtons !== true
    ) {


      preview.html(

        '<div class="' +

          'automator-pagination-editor-preview-message ' +

          'd-flex align-items-center justify-content-center ' +

          'text-center text-muted p-4' +

        '">' +

          '<div>' +

            '<i class="' +

              'fa fa-table-columns fs-2 mb-3 d-block' +

            '"></i>' +

            '<strong class="d-block mb-1">' +

              'Nenhuma coluna adicionada' +

            '</strong>' +

            '<span class="small">' +

              'Utilize a aba Adicionar coluna para montar a paginação.' +

            '</span>' +

          '</div>' +

        '</div>'

      );


      return true;

    }


    let headerHTML = '';

    let bodyHTML = '';


    if(hasDeleteAction === true) {


      headerHTML +=

        '<th scope="col" class="text-center">' +

          '<input ' +

            'type="checkbox" ' +

            'class="' +

              'form-check-input ' +

              'automator-pagination-editor-preview-static-selection' +

            '" ' +

            'disabled ' +

          '/>' +

        '</th>';


      bodyHTML +=

        '<td class="text-center">' +

          '<input ' +

            'type="checkbox" ' +

            'class="' +

              'form-check-input ' +

              'automator-pagination-editor-preview-static-selection' +

            '" ' +

            'disabled ' +

          '/>' +

        '</td>';


    }


    columns.forEach(function(column) {


      column = normalizePaginationColumnData(

        column

      );


      const headerClass = String(

        getNestedValue(

          column.values,

          'header.class',

          ''

        ) || ''

      ).trim();


      const bodyClass = String(

        getNestedValue(

          column.values,

          'body.class',

          ''

        ) || ''

      ).trim();


      const sortable = normalizeBooleanValue(

        getNestedValue(

          column.values,

          'canSort.sort',

          false

        ),

        false

      );


      const label = String(

        column.label ||

        column.title ||

        column.type_title ||

        column.name ||

        'Coluna'

      );


      const columnStyle = getPaginationColumnPreviewStyle(

        column

      );


      headerHTML +=

        '<th ' +

          'scope="col" ' +

          'class="fw-semibold text-nowrap ' +

            escapeHtml(headerClass) +

          '" ' +

          'style="' +

            escapeHtml(columnStyle) +

          '" ' +

          'data-automator-pagination-preview-column="' +

            escapeHtml(column.id) +

          '"' +

        '>' +

          '<span class="' +

            'd-inline-flex align-items-center gap-2' +

          '">' +

            '<span>' +

              escapeHtml(label) +

            '</span>' +

            (

              sortable === true

                ? '<span class="' +

                    'd-inline-flex align-items-center gap-1 ' +

                    'text-secondary' +

                  '">' +

                    '<i class="' +

                      'fa fa-caret-down small' +

                    '"></i>' +

                    '<i class="' +

                      'fa fa-caret-up small' +

                    '"></i>' +

                  '</span>'

                : ''

            ) +

          '</span>' +

        '</th>';


      bodyHTML +=

        '<td ' +

          'class="' +

            escapeHtml(bodyClass) +

          '" ' +

          'style="' +

            escapeHtml(columnStyle) +

          '" ' +

          'data-automator-pagination-preview-column="' +

            escapeHtml(column.id) +

          '"' +

        '>' +

          escapeHtml(

            getPreviewColumnValue(

              column

            )

          ) +

        '</td>';


    });


    const actionsColumn =

      renderPaginationPreviewActionsColumn();


    headerHTML +=

      actionsColumn.header;


    bodyHTML +=

      actionsColumn.body;


    const headerActionsHTML =

      renderPaginationPreviewHeaderButtons();


    preview.html(

      '<div class="page-card automator-pagination-editor-preview-card">' +

        '<div class="page-card-body">' +

          '<div class="' +

            'row g-3 align-items-end justify-content-between mb-4' +

          '">' +

            '<div class="col-12 col-sm-auto">' +

              '<div class="' +

                'row g-3 align-items-end' +

                (

                  hasSearchableColumn === true

                    ? ''

                    : ' opacity-25'

                ) +

              '">' +

                '<div class="col-12 col-sm-auto">' +

                  '<label class="small fw-medium mb-1">' +

                    'Buscar' +

                  '</label>' +

                  '<input ' +

                    'id="automator-pagination-editor-preview-search" ' +

                    'type="text" ' +

                    'disabled ' +

                    'class="form-control" ' +

                    'placeholder="Digite para buscar..." ' +

                  '/>' +

                '</div>' +

                renderPaginationPreviewSearchFields() +

                '<div class="col-12 col-sm-auto">' +

                  '<button ' +

                    'type="button" ' +

                    'class="' +

                      'btn btn-light border d-inline-flex ' +

                      'align-items-center justify-content-center gap-2 w-100' +

                    '" ' +

                    'disabled' +

                  '>' +

                    '<i class="fa fa-filter text-secondary"></i>' +

                    'Filtrar' +

                  '</button>' +

                '</div>' +

              '</div>' +

            '</div>' +

            '<div class="col-12 col-sm-auto">' +

              '<label class="small fw-medium mb-1">' +

                'Registros/Página' +

              '</label>' +

              '<select ' +

                'id="automator-pagination-editor-preview-per-page" ' +

                'disabled ' +

                'class="form-select"' +

              '>' +

                renderPaginationPreviewPerPageOptions(

                  perPageValue

                ) +

              '</select>' +

            '</div>' +

          '</div>' +


          (

            hasHeaderButtons === true ||

            hasDeleteAction === true

              ? '<div class="' +

                  'd-flex flex-column flex-sm-row gap-2 ' +

                  'align-items-stretch align-items-sm-center ' +

                  'justify-content-between mb-3' +

                '">' +

                  '<div class="' +

                    'd-flex flex-wrap align-items-center ' +

                    'justify-content-start' +

                  '">' +

                    headerActionsHTML +

                  '</div>' +

                  '<div class="' +

                    'd-flex flex-wrap align-items-center ' +

                    'justify-content-start justify-content-sm-end' +

                  '">' +

                    (

                      hasDeleteAction === true

                        ? '<button ' +

                            'type="button" ' +

                            'class="btn btn-danger" ' +

                            'disabled' +

                          '>' +

                            'Excluir Selecionado(s)' +

                          '</button>'

                        : ''

                    ) +

                  '</div>' +

                '</div>'

              : ''

          ) +


          '<div class="' +

            'table-responsive shadow ' +

            'automator-pagination-editor-preview-table-responsive' +

          '">' +

            '<table ' +

              'id="automator-pagination-editor-preview-table" ' +

              'class="' +

                'table table-hover align-middle mb-0 text-nowrap' +

              '"' +

            '>' +

              '<thead class="table-light">' +

                '<tr id="automator-pagination-editor-preview-header">' +

                  headerHTML +

                '</tr>' +

              '</thead>' +

              '<tbody id="automator-pagination-editor-preview-body">' +

                '<tr>' +

                  bodyHTML +

                '</tr>' +

              '</tbody>' +

            '</table>' +

          '</div>' +

        '</div>' +

      '</div>'

    );


    bindPreviewColumnEvents();

    initializePaginationPreviewDropdowns();

    refreshTooltips();


    return true;


  }


  function applyPaginationButtonIconFieldLayout(
    item
  ) {


    item = $(item);


    if(!item.length) {

      return false;

    }


    const wrapper = item.find(

      '.automator-pagination-editor-button-icon-wrapper'

    ).first();


    if(!wrapper.length) {

      return false;

    }


    if(
      wrapper.attr(
        'data-icon-layout-ready'
      ) == 'true'
    ) {


      const currentIconName = normalizePaginationButtonIcon(

        wrapper.find(
          selectors.paginationButtonIconHidden
        ).first().val()

      );


      wrapper.find(

        selectors.paginationButtonIconSearch

      )
        .first()
        .val('')
        .attr(

          'placeholder',

          currentIconName != ''

            ? currentIconName

            : 'Buscar ícone...'

        );


      renderPaginationButtonIconPreview(

        item,

        currentIconName

      );


      return true;


    }


    const hiddenInput = wrapper.find(

      selectors.paginationButtonIconHidden

    ).first();


    const searchInput = wrapper.find(

      selectors.paginationButtonIconSearch

    ).first();


    const preview = wrapper.find(

      selectors.paginationButtonIconPreview

    ).first();


    const results = wrapper.find(

      selectors.paginationButtonIconResults

    ).first();


    if(
      !hiddenInput.length ||
      !searchInput.length ||
      !preview.length ||
      !results.length
    ) {

      return false;

    }


    const inputID =

      'automator-pagination-editor-button-icon-search-' +

      String(

        item.attr(
          'data-button-uid'
        ) ||

        Date.now() +

        '-' +

        Math.floor(
          Math.random() * 999999
        )

      )
        .replace(
          /[^a-zA-Z0-9_-]/g,
          '-'
        );


    const iconName = normalizePaginationButtonIcon(

      hiddenInput.val()

    );


    const newField = $(

      '<div class="' +

        'input-group ' +

        'automator-pagination-editor-button-icon-input-group' +

      '">' +

        '<span class="' +

          'input-group-text p-0 text-center ' +

          'd-flex align-items-center justify-content-center ' +

          'automator-pagination-editor-button-icon-preview' +

        '" ' +

        'style="' +

          'min-width: 50px; ' +

          'display: flex; ' +

          'align-items: center; ' +

          'justify-content: center;' +

        '"' +

        '>' +

          '<span class="' +

            'h-100 w-100 d-flex align-items-center ' +

            'justify-content-center text-center border-0' +

          '">' +

            '<i class="fa fa-' +

              escapeHtml(

                iconName ||

                'icons'

              ) +

            '"></i>' +

          '</span>' +

        '</span>' +

        '<div class="form-floating flex-grow-1">' +

          '<input ' +

            'type="text" ' +

            'id="' +

              escapeHtml(inputID) +

            '" ' +

            'autocomplete="off" ' +

            'class="' +

              'form-control ' +

              'automator-pagination-editor-button-icon-search' +

            '" ' +

            'placeholder="' +

              escapeHtml(

                iconName != ''

                  ? iconName

                  : 'Buscar ícone...'

              ) +

            '" ' +

          '/>' +

          '<label for="' +

            escapeHtml(inputID) +

          '">' +

            'Ícone' +

          '</label>' +

        '</div>' +

      '</div>'

    );


    wrapper
      .children(
        'label'
      )
      .remove();


    wrapper
      .children(
        '.input-group'
      )
      .remove();


    results.before(

      newField

    );


    wrapper.attr(

      'data-icon-layout-ready',

      'true'

    );


    renderPaginationButtonIconPreview(

      item,

      iconName

    );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Valor demonstrativo da coluna
  |--------------------------------------------------------------------------
  */

  function getPreviewColumnValue(column = {}) {


    const columnName = String(

      column.name || ''

    ).trim();


    if(columnName != '') {

      return columnName;

    }


    return 'Coluna não definida';


  }


  /*
  |--------------------------------------------------------------------------
  | Retorna style do tamanho da coluna
  |--------------------------------------------------------------------------
  */

  function getPaginationColumnPreviewStyle(
    column = {}
  ) {


    column = normalizeColumnSizeConfiguration(

      column

    );


    const sizeType = String(

      getNestedValue(

        column.attrs,

        'configs.size-type',

        'auto'

      ) || 'auto'

    );


    const sizeValue = getNestedValue(

      column.attrs,

      'configs.size-value',

      null

    );


    if(
      sizeType == 'percent' &&
      sizeValue !== null
    ) {

      return (

        'width: ' +

        sizeValue +

        '%; min-width: ' +

        sizeValue +

        '%;'

      );

    }


    if(
      sizeType == 'px' &&
      sizeValue !== null
    ) {

      return (

        'width: ' +

        sizeValue +

        'px; min-width: ' +

        sizeValue +

        'px;'

      );

    }


    return 'width: auto;';


  }


  /*
  |--------------------------------------------------------------------------
  | Eventos das configurações da pré-visualização
  |--------------------------------------------------------------------------
  */

  function bindPaginationPreviewSettingsEvents() {


    $(document)
      .off(
        'input.automator-pagination-editor-preview-settings change.automator-pagination-editor-preview-settings',
        selectors.paginationPerPage
      )
      .on(
        'input.automator-pagination-editor-preview-settings change.automator-pagination-editor-preview-settings',
        selectors.paginationPerPage,
        function() {


          renderPaginationPreview();


        }
      );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Obtém registros por página
  |--------------------------------------------------------------------------
  */

  function getPaginationPerPageValue() {


    const input = $(

      selectors.paginationPerPage

    ).first();


    let value = String(

      input.length
        ? input.val() || ''
        : ''

    ).trim();


    if(value == '') {

      value = '15';

    }


    return value;


  }


  /*
  |--------------------------------------------------------------------------
  | Renderiza opções de registros por página
  |--------------------------------------------------------------------------
  */

  function renderPaginationPreviewPerPageOptions(
    selectedValue = '15'
  ) {


    selectedValue = String(

      selectedValue || '15'

    );


    const values = [

      '10',
      '15',
      '25',
      '50',
      '100',

    ];


    if(values.indexOf(selectedValue) < 0) {

      values.push(selectedValue);

    }


    let html = '';


    values.forEach(function(value) {


      html +=

        '<option value="' +

          escapeHtml(value) +

        '"' +

        (

          String(value) == selectedValue

            ? ' selected'

            : ''

        ) +

        '>' +

          escapeHtml(value) +

        '</option>';


    });


    return html;


  }


  /*
  |--------------------------------------------------------------------------
  | Remove foco da coluna ao clicar fora
  |--------------------------------------------------------------------------
  */

  function bindEditorColumnDeselection() {


    $(document)
      .off(
        'click.automator-pagination-editor-column-deselection'
      )
      .on(
        'click.automator-pagination-editor-column-deselection',
        function(event) {


          if(state.selectedColumnID == '') {

            return;

          }


          const target = $(event.target);


          if(
            target.closest(
              selectors.structureItem
            ).length
          ) {

            return;

          }


          if(
            target.closest(
              '[data-automator-pagination-preview-column]'
            ).length
          ) {

            return;

          }


          if(
            target.closest(
              selectors.proprietiesPanel
            ).length
          ) {

            return;

          }


          if(
            target.closest(
              selectors.proprietiesButton
            ).length
          ) {

            return;

          }


          clearSelectedColumn();


        }
      );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Eventos das colunas
  |--------------------------------------------------------------------------
  */

  function bindColumnsEvents() {


    $(document)
      .off(
        'click.automator-pagination-editor-insert-column',
        selectors.columnType
      )
      .on(
        'click.automator-pagination-editor-insert-column',
        selectors.columnType,
        function(event) {


          event.preventDefault();

          event.stopPropagation();


          const item = $(this);


          if(
            String(
              $(selectors.index).val() || ''
            ).trim() == ''
          ) {

            return false;

          }


          addPaginationColumnFromType(item);


          return false;


        }
      );


    $(document)
      .off(
        'click.automator-pagination-editor-select-column',
        selectors.structureItem
      )
      .on(
        'click.automator-pagination-editor-select-column',
        selectors.structureItem,
        function(event) {


          if(
            $(event.target).closest(
              selectors.columnDelete
            ).length
          ) {

            return;

          }


          event.stopPropagation();


          selectPaginationColumn(

            $(this).attr(
              'data-column-id'
            )

          );


        }
      );


    $(document)
      .off(
        'click.automator-pagination-editor-delete-column',
        selectors.columnDelete
      )
      .on(
        'click.automator-pagination-editor-delete-column',
        selectors.columnDelete,
        function(event) {


          event.preventDefault();

          event.stopPropagation();


          removePaginationColumn(

            $(this)
              .closest(
                selectors.structureItem
              )
              .attr(
                'data-column-id'
              )

          );


          return false;


        }
      );


    $(document)
      .off(
        'click.automator-pagination-editor-properties-delete-column',
        selectors.columnPropertiesDelete
      )
      .on(
        'click.automator-pagination-editor-properties-delete-column',
        selectors.columnPropertiesDelete,
        function(event) {


          event.preventDefault();

          event.stopPropagation();


          if(state.selectedColumnID == '') {

            return false;

          }


          removePaginationColumn(

            state.selectedColumnID

          );


          return false;


        }
      );


    $(document)
      .off(
        'input.automator-pagination-editor-column-property change.automator-pagination-editor-column-property',
        selectors.columnPropertyInput
      )
      .on(
        'input.automator-pagination-editor-column-property change.automator-pagination-editor-column-property',
        selectors.columnPropertyInput,
        function() {


          if(
            $(this).hasClass(
              'automator-pagination-editor-dynamic-relation-property'
            )
          ) {

            return;

          }


          updateSelectedColumnFromProperties();


        }
      );


    $(document)
      .off(
        'change.automator-pagination-editor-column-size-type',
        selectors.columnPropertyInput +
        '[data-property-path="configs.size-type"]'
      )
      .on(
        'change.automator-pagination-editor-column-size-type',
        selectors.columnPropertyInput +
        '[data-property-path="configs.size-type"]',
        function(event) {


          event.stopPropagation();


          updateSelectedColumnFromProperties(

            true

          );


        }
      );


    $(document)
      .off(
        'click.automator-pagination-editor-dynamic-list-add',
        selectors.columnDynamicListAdd
      )
      .on(
        'click.automator-pagination-editor-dynamic-list-add',
        selectors.columnDynamicListAdd,
        function(event) {


          event.preventDefault();

          event.stopPropagation();


          addColumnDynamicListItem(

            $(this).closest(
              selectors.columnDynamicList
            )

          );


          updateSelectedColumnFromProperties();


          return false;


        }
      );


    $(document)
      .off(
        'click.automator-pagination-editor-dynamic-list-delete',
        selectors.columnDynamicListDelete
      )
      .on(
        'click.automator-pagination-editor-dynamic-list-delete',
        selectors.columnDynamicListDelete,
        function(event) {


          event.preventDefault();

          event.stopPropagation();


          $(this)
            .closest(
              '.automator-pagination-editor-column-dynamic-list-item'
            )
            .remove();


          updateSelectedColumnFromProperties();


          return false;


        }
      );


    bindPaginationRelationPropertyEvents();


    return true;


  }

  /*
  |--------------------------------------------------------------------------
  | Adiciona uma coluna a partir do tipo selecionado
  |--------------------------------------------------------------------------
  */

  function addPaginationColumnFromType(typeItem) {


    typeItem = $(typeItem);


    if(!typeItem.length) {

      return false;

    }


    const pagination = normalizePaginationDefinition(

      parseJSONValue(

        typeItem.attr(
          'data-block-pagination'
        ),

        {}

      )

    );


    const columnID =

      'pagination-column-' +

      Date.now() +

      '-' +

      Math.floor(

        Math.random() * 999999

      );


    const typeID = String(

      typeItem.attr(
        'data-block-type-id'
      ) || ''

    );


    const typeName = String(

      typeItem.attr(
        'data-block-type'
      ) || ''

    );


    const icon = String(

      typeItem.attr(
        'data-block-icon'
      ) || 'table-columns'

    );


    const title = String(

      typeItem.attr(
        'data-block-title'
      ) ||

      typeItem.find(
        'span'
      ).first().text() ||

      typeItem.attr(
        'data-bs-title'
      ) ||

      typeName ||

      'Coluna'

    ).trim();


    const column = {

      id:         columnID,
      type_id:    typeID,
      type:       typeName,
      icon:       icon,
      type_title: title,
      title:      title,
      name:       '',
      label:      title,
      pagination: pagination,

      values:

        getPaginationDefaultValues(

          pagination

        ),

      attrs: {

        configs: {

          'size-type':  'auto',
          'size-value': null,

        },

      },

      access:

        normalizePaginationAccessValues(

          []

        ),

    };


    const structureItem = createStructureColumnItem(

      column

    );


    $(selectors.structureList).append(

      structureItem

    );


    updateStructureEmptyState();

    renderPaginationPreview();

    selectPaginationColumn(

      columnID

    );


    setSaveState(

      true

    );


    syncEditorState();


    return structureItem;


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza definição das propriedades da paginação
  |--------------------------------------------------------------------------
  */

  function normalizePaginationDefinition(
    pagination = {}
  ) {


    if(
      !pagination ||
      typeof pagination !== 'object' ||
      Array.isArray(pagination)
    ) {

      pagination = {};

    }


    if(
      !pagination.args ||
      typeof pagination.args !== 'object' ||
      Array.isArray(pagination.args)
    ) {

      pagination.args = {};

    }


    Object.keys(pagination.args).forEach(function(groupName) {


      let group = pagination.args[groupName];


      if(
        !group ||
        typeof group !== 'object' ||
        Array.isArray(group)
      ) {

        group = {};

      }


      if(
        !group.fields ||
        typeof group.fields !== 'object' ||
        Array.isArray(group.fields)
      ) {

        group.fields = {};

      }


      Object.keys(group.fields).forEach(function(fieldName) {


        let field = group.fields[fieldName];


        if(
          !field ||
          typeof field !== 'object' ||
          Array.isArray(field)
        ) {

          field = {};

        }


        if(
          field.type == 'select' ||
          field.field == 'select'
        ) {

          field.values = normalizePropertySelectValues(

            field.values

          );

        }


        group.fields[fieldName] = field;


      });


      pagination.args[groupName] = group;


    });


    return pagination;


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza opções dos selects de propriedades
  |--------------------------------------------------------------------------
  */

  function normalizePropertySelectValues(
    values = {}
  ) {


    if(
      values === null ||
      values === undefined ||
      values === ''
    ) {

      return {};

    }


    if(Array.isArray(values)) {


      const normalizedValues = {};


      values.forEach(function(value, index) {


        if(
          value &&
          typeof value === 'object'
        ) {


          const optionValue = String(

            value.value !== undefined
              ? value.value
              : index

          );


          normalizedValues[optionValue] = String(

            value.label !== undefined
              ? value.label
              : (
                  value.title !== undefined
                    ? value.title
                    : optionValue
                )

          );


          return;

        }


        normalizedValues[String(value)] = String(value);


      });


      return normalizedValues;


    }


    if(typeof values === 'string') {


      const decodedValues = parseJSONValue(

        values,

        null

      );


      if(
        decodedValues &&
        typeof decodedValues === 'object'
      ) {

        return normalizePropertySelectValues(

          decodedValues

        );

      }


      return {};


    }


    if(typeof values === 'object') {

      return values;

    }


    return {};


  }


  /*
  |--------------------------------------------------------------------------
  | Cria item da lista de estrutura
  |--------------------------------------------------------------------------
  */

  function createStructureColumnItem(column = {}) {


    column = normalizePaginationColumnData(

      column

    );


    const isActionColumn =

      column.isActionButtonsColumn === true;


    const item = $(

      '<div ' +

        'class="' +

          'automator-pagination-editor-column-item ' +

          'border-bottom bg-white' +

        '" ' +

        'data-automator-pagination-column="true" ' +

        'data-column-id="' +

          escapeHtml(column.id || '') +

        '" ' +

        (

          isActionColumn === true

            ? 'data-action-buttons-column="true" '

            : ''

        ) +

      '>' +

        '<div class="' +

          'automator-pagination-editor-column-item-content ' +

          'd-flex align-items-center gap-2 p-3' +

        '">' +

          (

            isActionColumn === true

              ? ''

              : '<span class="' +

                  'automator-pagination-editor-column-sort-handle ' +

                  'text-muted' +

                '">' +

                  '<i class="fa fa-grip-vertical"></i>' +

                '</span>'

          ) +

          '<span class="' +

            'automator-pagination-editor-column-icon ' +

            'text-primary' +

          '">' +

            '<i class="fa fa-' +

              escapeHtml(

                column.icon ||

                'table-columns'

              ) +

            '"></i>' +

          '</span>' +

          '<span class="flex-grow-1 overflow-hidden">' +

            '<strong class="' +

              'automator-pagination-editor-column-title ' +

              'd-block small text-truncate' +

            '">' +

              escapeHtml(

                column.label ||

                column.type_title ||

                'Coluna'

              ) +

            '</strong>' +

            '<small class="' +

              'automator-pagination-editor-column-name ' +

              'd-block text-muted text-truncate' +

            '">' +

              escapeHtml(

                isActionColumn === true

                  ? 'Botões da paginação'

                  : (

                      column.name ||

                      'Coluna não definida'

                    )

              ) +

            '</small>' +

          '</span>' +

          (

            isActionColumn === true

              ? ''

              : '<button ' +

                  'type="button" ' +

                  'class="' +

                    'btn btn-sm btn-outline-danger ' +

                    'automator-pagination-editor-column-delete' +

                  '" ' +

                  'data-bs-toggle="tooltip" ' +

                  'data-bs-placement="left" ' +

                  'data-bs-title="Excluir coluna"' +

                '>' +

                  '<i class="fa fa-trash"></i>' +

                '</button>'

          ) +

        '</div>' +

      '</div>'

    );


    item.data(

      'automator-pagination-column',

      $.extend(

        true,

        {},

        column

      )

    );


    return item;


  }


  /*
  |--------------------------------------------------------------------------
  | Sortable das colunas
  |--------------------------------------------------------------------------
  */

  function initializeStructureSortable() {


    const structureList = document.querySelector(

      selectors.structureList

    );


    if(
      !structureList ||
      typeof window.Sortable === 'undefined'
    ) {

      return false;

    }


    if(state.structureSortable) {


      try {

        state.structureSortable.destroy();

      } catch(e) {}


      state.structureSortable = null;


    }


    state.structureSortable = Sortable.create(

      structureList,

      {

        animation: 180,

        handle:
          '.automator-pagination-editor-column-sort-handle',

        draggable:
          selectors.structureItem,

        ghostClass:
          'automator-pagination-editor-column-sort-ghost',

        chosenClass:
          'automator-pagination-editor-column-sort-chosen',

        dragClass:
          'automator-pagination-editor-column-sort-drag',

        onStart: function() {


          hideEditorTooltips();


        },

        onEnd: function() {


          updateStructureEmptyState();

          renderPaginationPreview();

          setSaveState(true);

          syncEditorState();


        },

      }

    );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Estado vazio da estrutura
  |--------------------------------------------------------------------------
  */

  function updateStructureEmptyState() {


    const structureList = $(

      selectors.structureList

    );


    if(!structureList.length) {

      return false;

    }


    structureList.find(

      selectors.structureEmpty

    ).remove();


    const totalColumns = structureList.find(

      selectors.structureItem

    ).length;


    if(totalColumns <= 0) {


      const emptyText = String(

        structureList.attr(
          'data-empty'
        ) ||

        'Nenhuma coluna adicionada.'

      );


      structureList.append(

        '<div class="' +

          'automator-pagination-editor-structure-empty ' +

          'text-muted text-center p-4 small' +

        '">' +

          '<i class="fa fa-table-columns d-block fs-4 mb-2"></i>' +

          escapeHtml(emptyText) +

        '</div>'

      );


    }


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Seleciona coluna
  |--------------------------------------------------------------------------
  */

  function selectPaginationColumn(columnID = '') {


    columnID = String(

      columnID || ''

    ).trim();


    const item = $(selectors.structureList)
      .find(
        selectors.structureItem +
        '[data-column-id="' +
        escapeSelectorValue(columnID) +
        '"]'
      )
      .first();


    if(!item.length) {

      clearSelectedColumn();

      return false;

    }


    const column = normalizePaginationColumnData(

      item.data(
        'automator-pagination-column'
      ) || {}

    );


    if(column.isActionButtonsColumn === true) {

      clearSelectedColumn();

      return false;

    }


    $(selectors.structureItem)
      .removeClass('is-selected');


    item.addClass('is-selected');


    state.selectedColumnID = columnID;


    renderColumnProperties(item);


    setProprietiesEnabled(

      true,

      'Nenhuma coluna foi selecionada.'

    );


    showRightPanel('proprieties');


    refreshTooltips();


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Seleção de coluna pela pré-visualização
  |--------------------------------------------------------------------------
  */

  function bindPreviewColumnEvents() {


    $(document)
      .off(
        'click.automator-pagination-editor-preview-column',
        selectors.preview +
        ' [data-automator-pagination-preview-column]'
      )
      .on(
        'click.automator-pagination-editor-preview-column',
        selectors.preview +
        ' [data-automator-pagination-preview-column]',
        function(event) {


          event.preventDefault();

          event.stopPropagation();


          selectPaginationColumn(

            $(this).attr(
              'data-automator-pagination-preview-column'
            )

          );


        }
      );


    return true;


  }

  /*
  |--------------------------------------------------------------------------
  | Limpa seleção de coluna
  |--------------------------------------------------------------------------
  */

  function clearSelectedColumn() {


    state.selectedColumnID = '';


    $(selectors.structureItem)
      .removeClass('is-selected');


    renderNoColumnSelectedProperties();


    setProprietiesEnabled(

      false,

      'Nenhuma coluna foi selecionada.'

    );


    if(
      state.activeRightPanel == 'proprieties'
    ) {

      showRightPanel('pagination');

    }


    return true;


  }

  function getSelectedColumnItem() {


    if(state.selectedColumnID == '') {

      return $();

    }


    return $(selectors.structureList)
      .find(
        selectors.structureItem +
        '[data-column-id="' +
        escapeSelectorValue(
          state.selectedColumnID
        ) +
        '"]'
      )
      .first();


  }


  /*
  |--------------------------------------------------------------------------
  | Remove coluna
  |--------------------------------------------------------------------------
  */

  function removePaginationColumn(columnID = '') {


    columnID = String(

      columnID || ''

    ).trim();


    const item = $(selectors.structureList)
      .find(
        selectors.structureItem +
        '[data-column-id="' +
        escapeSelectorValue(columnID) +
        '"]'
      )
      .first();


    if(!item.length) {

      return false;

    }


    disposeTooltipsInside(item[0]);


    item.remove();


    if(
      state.selectedColumnID == columnID
    ) {

      clearSelectedColumn();

    }


    updateStructureEmptyState();

    renderPaginationPreview();

    setSaveState(true);

    syncEditorState();


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Mensagem das propriedades
  |--------------------------------------------------------------------------
  */

  function renderNoColumnSelectedProperties() {


    const panel = $(

      selectors.proprietiesPanel

    );


    if(!panel.length) {

      return false;

    }


    panel.find(

      selectors.columnPropertiesContent

    ).remove();


    panel.append(

      '<div ' +

        'id="automator-pagination-editor-column-properties-content" ' +

        'class="p-4 text-center text-muted"' +

      '>' +

        '<i class="fa fa-table-columns d-block fs-3 mb-3"></i>' +

        '<strong class="d-block mb-1">' +

          'Nenhuma coluna selecionada' +

        '</strong>' +

        '<span class="small">' +

          'Selecione uma coluna na estrutura ou na tabela para editar suas propriedades.' +

        '</span>' +

      '</div>'

    );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Renderiza propriedades da coluna
  |--------------------------------------------------------------------------
  */

  function renderColumnProperties(item) {


    item = $(item);


    if(!item.length) {

      renderNoColumnSelectedProperties();

      return false;

    }


    const column = normalizePaginationColumnData(

      item.data(
        'automator-pagination-column'
      ) || {}

    );


    item.data(

      'automator-pagination-column',

      column

    );


    const pagination = normalizePaginationDefinition(

      column.pagination || {}

    );


    const groups = normalizePlainObject(

      pagination.args

    );


    const panel = $(

      selectors.proprietiesPanel

    );


    panel.find(

      selectors.columnPropertiesContent

    ).remove();


    let html = '';


    html +=

      '<div ' +

        'id="automator-pagination-editor-column-properties-content" ' +

        'class="pb-4"' +

      '>';


    html +=

      '<div class="p-3 border-bottom bg-light">' +

        '<strong class="small d-block">' +

          escapeHtml(

            column.type_title ||

            column.title ||

            column.type ||

            'Coluna'

          ) +

        '</strong>' +

        '<span class="small text-muted">' +

          escapeHtml(

            pagination.description || ''

          ) +

        '</span>' +

      '</div>';


    html +=

      '<div ' +

        'class="accordion mx-0" ' +

        'id="automator-pagination-editor-column-properties-accordion"' +

      '>';


    html += renderColumnPropertyGroup(

      'column',

      {

        label: 'Coluna',

        open: true,

        fields: {

          name: {

            label:       'Coluna da tabela',
            type:        'select',
            required:    true,
            nullable:    false,
            description: '',
            default:     column.name || '',
            values:      getAvailableTableColumns(),

          },

          label: {

            label:       'Título',
            type:        'text',
            required:    true,
            nullable:    false,
            description: '',
            default:     column.label || '',

          },

        },

      },

      column

    );


    html += renderColumnPropertyGroup(

      'configs',

      {

        label: 'Tamanho da coluna',

        fields: {

          'size-type': {

            label:       'Tipo de tamanho',
            type:        'select',
            required:    true,
            nullable:    false,
            default:     'auto',

            values: {

              auto:    'Automático',
              percent: 'Porcentagem',
              px:      'PX',

            },

          },

          'size-value': {

            label:       'Valor do tamanho',
            type:        'number',
            required:    false,
            nullable:    true,
            default:     null,

          },

        },

      },

      column

    );


    Object.keys(

      groups || {}

    ).forEach(function(groupName) {


      const group = normalizePlainObject(

        groups[groupName]

      );


      html += renderColumnPropertyGroup(

        groupName,

        group,

        column

      );


    });


    html +=

      '<div class="accordion-item border-start-0 border-end-0 rounded-0">' +

        '<h2 class="accordion-header">' +

          '<button ' +

            'type="button" ' +

            'class="' +

              'accordion-button collapsed py-2 px-3 ' +

              'small fw-bold rounded-0' +

            '" ' +

            'data-bs-toggle="collapse" ' +

            'data-bs-target="' +

              '#automator-pagination-column-property-group-access' +

            '" ' +

            'aria-expanded="false"' +

          '>' +

            'Nível de acesso' +

          '</button>' +

        '</h2>' +

        '<div ' +

          'id="automator-pagination-column-property-group-access" ' +

          'class="accordion-collapse collapse"' +

        '>' +

          '<div class="accordion-body p-3">' +

            renderPaginationColumnAccessList(

              column

            ) +

          '</div>' +

        '</div>' +

      '</div>';


    html += '</div>';


    html +=

      '<div class="px-3 pt-3">' +

        '<button ' +

          'type="button" ' +

          'class="' +

            'btn btn-outline-danger btn-sm w-100 ' +

            'automator-pagination-editor-column-properties-delete' +

          '"' +

        '>' +

          '<i class="fa fa-trash me-1"></i>' +

          'Excluir coluna' +

        '</button>' +

      '</div>';


    html += '</div>';


    panel.append(

      html

    );


    initializeColumnDynamicLists(

      panel

    );


    updateColumnSizeValueFieldVisibility();


    if(
      column.type == 'relation' ||
      panel.find(
        '.automator-pagination-editor-dynamic-relation-property'
      ).length
    ) {


      initializePaginationRelationPropertyFields(

        panel,

        state.initialized === true

      );


    }


    refreshTooltips();


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza dados internos da coluna
  |--------------------------------------------------------------------------
  */

  function normalizePaginationColumnData(
    column = {}
  ) {


    column = normalizePlainObject(

      column

    );


    column.pagination = normalizePaginationDefinition(

      column.pagination

    );


    column.values = normalizePlainObject(

      column.values

    );


    column.attrs = normalizePlainObject(

      column.attrs

    );


    column.attrs.configs = normalizePlainObject(

      column.attrs.configs

    );


    if(
      !column.attrs.configs['size-type']
    ) {

      column.attrs.configs['size-type'] = 'auto';

    }


    if(
      column.attrs.configs['size-value'] === undefined
    ) {

      column.attrs.configs['size-value'] = null;

    }


    column.access = normalizePaginationAccessValues(

      column.access ||

      column.user_types ||

      column.users_types ||

      column.tbl_users_types ||

      []

    );


    return column;


  }


  /*
  |--------------------------------------------------------------------------
  | Renderiza grupo de propriedades
  |--------------------------------------------------------------------------
  */

  function renderColumnPropertyGroup(
    groupName,
    groupConfig,
    column
  ) {


    groupConfig = normalizePlainObject(

      groupConfig

    );


    const fields = normalizePlainObject(

      groupConfig.fields

    );


    if(Object.keys(fields).length <= 0) {

      return '';

    }


    const groupID =

      'automator-pagination-column-property-group-' +

      normalizeActionName(groupName);


    const groupOpen =

      groupName == 'column' ||

      normalizeBooleanValue(

        groupConfig.open,

        false

      );


    let html = '';


    html +=

      '<div class="accordion-item border-start-0 border-end-0 rounded-0">';


    html +=

      '<h2 class="accordion-header">' +

        '<button ' +

          'type="button" ' +

          'class="' +

            'accordion-button py-2 px-3 ' +

            'small fw-bold rounded-0' +

            (

              groupOpen === true
                ? ''
                : ' collapsed'

            ) +

          '" ' +

          'data-bs-toggle="collapse" ' +

          'data-bs-target="#' +

            escapeHtml(groupID) +

          '" ' +

          'aria-expanded="' +

            (

              groupOpen === true
                ? 'true'
                : 'false'

            ) +

          '"' +

        '>' +

          escapeHtml(

            groupConfig.label ||

            groupName

          ) +

        '</button>' +

      '</h2>';


    html +=

      '<div ' +

        'id="' +

          escapeHtml(groupID) +

        '" ' +

        'class="accordion-collapse collapse' +

          (

            groupOpen === true
              ? ' show'
              : ''

          ) +

        '"' +

      '>' +

        '<div class="accordion-body p-3">';


    Object.keys(

      fields || {}

    ).forEach(function(fieldName) {


      const fieldConfig = normalizePlainObject(

        fields[fieldName]

      );


      const fieldPath = groupName == 'column'
        ? fieldName
        : groupName + '.' + fieldName;


      let currentValue = '';


      if(groupName == 'column') {

        currentValue = column[fieldName];

      } else if(groupName == 'configs') {

        currentValue = getNestedValue(

          column.attrs,

          fieldPath,

          fieldConfig.default

        );

      } else {

        currentValue = getNestedValue(

          column.values,

          fieldPath,

          fieldConfig.default

        );

      }


      html += renderColumnPropertyField(

        fieldPath,

        fieldConfig,

        currentValue

      );


    });


    html += '</div>';

    html += '</div>';

    html += '</div>';


    return html;


  }


  function getPaginationRelationPropertyInput(
    fieldPath = ''
  ) {


    return $(selectors.proprietiesPanel)
      .find(

        selectors.columnPropertyInput +

        '[data-property-path="' +

          escapeSelectorValue(

            fieldPath

          ) +

        '"]'

      )
      .first();


  }


  function setPaginationRelationPropertyLoading(
    input,
    label = 'Carregando...'
  ) {


    input = $(input);


    if(!input.length) {

      return false;

    }


    input
      .prop(
        'disabled',
        true
      )
      .empty()
      .append(

        $('<option>', {

          value: '',
          text:  label,

        })

      );


    return true;


  }


  function resetPaginationRelationColumnSelect(
    input,
    label = '- Selecione a Tabela -'
  ) {


    input = $(input);


    if(!input.length) {

      return false;

    }


    input
      .empty()
      .append(

        $('<option>', {

          value:    '',
          text:     label,
          disabled: true,
          selected: true,

        })

      )
      .val('')
      .prop(
        'disabled',
        true
      );


    return true;


  }


  function loadPaginationRelationTables(
    input,
    selectedValue = '',
    excludedTables = [],
    callback = null
  ) {


    input = $(input);


    selectedValue = String(

      selectedValue || ''

    ).trim();


    excludedTables = normalizeArrayValue(

      excludedTables

    ).map(function(tableName) {


      return String(

        tableName || ''

      ).trim();


    });


    if(!input.length) {


      if(typeof callback === 'function') {

        callback();

      }


      return false;

    }


    setPaginationRelationPropertyLoading(

      input,

      'Carregando tabelas...'

    );


    requestDatabaseData(

      {

        'data-type': 'get-tables',

      },

      function(response) {


        const tables = normalizeResponseItems(

          response && response.data

            ? response.data

            : []

        );


        renderSelectOptions(

          input,

          tables,

          selectedValue,

          '- Selecione a Tabela -',

          {

            keepEmptyOption: true,
            selectFirst:     false,
            emptyDisabled:   true,

          }

        );


        excludedTables.forEach(function(tableName) {


          if(tableName == '') {

            return;

          }


          input.find(

            'option[value="' +

              escapeSelectorValue(

                tableName

              ) +

            '"]'

          ).prop(

            'disabled',

            true

          );


        });


        if(
          selectedValue != '' &&
          input.find(
            'option[value="' +
              escapeSelectorValue(
                selectedValue
              ) +
            '"]'
          ).length
        ) {

          input.val(

            selectedValue

          );

        }


        input.prop(

          'disabled',

          false

        );


        if(typeof callback === 'function') {

          callback(

            response

          );

        }


      },

      function(response) {


        resetPaginationRelationColumnSelect(

          input,

          '- Não foi possível carregar as tabelas -'

        );


        if(typeof callback === 'function') {

          callback(

            response

          );

        }


      }

    );


    return true;


  }


  function loadPaginationRelationColumns(
    input,
    tableName = '',
    selectedValue = '',
    callback = null
  ) {


    input = $(input);


    tableName = String(

      tableName || ''

    ).trim();


    selectedValue = String(

      selectedValue || ''

    ).trim();


    if(!input.length) {


      if(typeof callback === 'function') {

        callback();

      }


      return false;

    }


    if(tableName == '') {


      resetPaginationRelationColumnSelect(

        input

      );


      if(typeof callback === 'function') {

        callback();

      }


      return false;

    }


    setPaginationRelationPropertyLoading(

      input,

      'Carregando colunas...'

    );


    requestDatabaseData(

      {

        'data-type':  'get-table-columns',
        'table-name': tableName,

      },

      function(response) {


        const columns = normalizeResponseItems(

          response && response.data

            ? response.data

            : []

        );


        renderSelectOptions(

          input,

          columns,

          selectedValue,

          '- Selecione a Coluna -',

          {

            keepEmptyOption: true,
            selectFirst:     false,
            emptyDisabled:   true,

          }

        );


        if(
          selectedValue != '' &&
          input.find(
            'option[value="' +
              escapeSelectorValue(
                selectedValue
              ) +
            '"]'
          ).length
        ) {

          input.val(

            selectedValue

          );

        }


        input.prop(

          'disabled',

          false

        );


        if(typeof callback === 'function') {

          callback(

            response

          );

        }


      },

      function(response) {


        resetPaginationRelationColumnSelect(

          input,

          '- Não foi possível carregar as colunas -'

        );


        if(typeof callback === 'function') {

          callback(

            response

          );

        }


      }

    );


    return true;


  }


  function updatePaginationRelationalFieldsState() {


    const modeInput = getPaginationRelationPropertyInput(

      'relation.mode'

    );


    const tableInput = getPaginationRelationPropertyInput(

      'relation.table'

    );


    const columnInput = getPaginationRelationPropertyInput(

      'relation.column'

    );


    const relationalTableInput = getPaginationRelationPropertyInput(

      'relation.relational-table'

    );


    const relationalColumnInput = getPaginationRelationPropertyInput(

      'relation.relational-column'

    );


    const relationalMode =

      String(

        modeInput.val() || ''

      ).trim() == 'relational';


    const relationTable = String(

      tableInput.val() || ''

    ).trim();


    const relationColumn = String(

      columnInput.val() || ''

    ).trim();


    const relationalTableWrapper = relationalTableInput.closest(

      '[data-automator-pagination-property-wrapper="relation.relational-table"]'

    );


    const relationalColumnWrapper = relationalColumnInput.closest(

      '[data-automator-pagination-property-wrapper="relation.relational-column"]'

    );


    relationalTableWrapper.toggleClass(

      'd-none',

      relationalMode !== true

    );


    relationalColumnWrapper.toggleClass(

      'd-none',

      relationalMode !== true

    );


    if(relationalMode !== true) {


      relationalTableInput.prop(

        'disabled',

        true

      );


      relationalColumnInput.prop(

        'disabled',

        true

      );


      return true;

    }


    relationalTableInput.prop(

      'disabled',

      relationTable == '' ||
      relationColumn == ''

    );


    relationalColumnInput.prop(

      'disabled',

      String(

        relationalTableInput.val() || ''

      ).trim() == ''

    );


    return true;


  }


  function initializePaginationRelationPropertyFields(
    container = null,
    showLoader = true
  ) {


    container = container

      ? $(container)

      : $(selectors.proprietiesPanel);


    const tableInput = container.find(

      selectors.columnPropertyInput +

      '[data-property-path="relation.table"]'

    ).first();


    const columnInput = container.find(

      selectors.columnPropertyInput +

      '[data-property-path="relation.column"]'

    ).first();


    const displayInput = container.find(

      selectors.columnPropertyInput +

      '[data-property-path="relation.display"]'

    ).first();


    const relationalTableInput = container.find(

      selectors.columnPropertyInput +

      '[data-property-path="relation.relational-table"]'

    ).first();


    const relationalColumnInput = container.find(

      selectors.columnPropertyInput +

      '[data-property-path="relation.relational-column"]'

    ).first();


    if(!tableInput.length) {

      return false;

    }


    const paginationTable = String(

      $(selectors.table).val() || ''

    ).trim();


    const selectedTable = String(

      tableInput.attr(
        'data-current-value'
      ) ||

      tableInput.val() ||

      ''

    ).trim();


    const selectedColumn = String(

      columnInput.attr(
        'data-current-value'
      ) ||

      columnInput.val() ||

      ''

    ).trim();


    const selectedDisplay = String(

      displayInput.attr(
        'data-current-value'
      ) ||

      displayInput.val() ||

      ''

    ).trim();


    const selectedRelationalTable = String(

      relationalTableInput.attr(
        'data-current-value'
      ) ||

      relationalTableInput.val() ||

      ''

    ).trim();


    const selectedRelationalColumn = String(

      relationalColumnInput.attr(
        'data-current-value'
      ) ||

      relationalColumnInput.val() ||

      ''

    ).trim();


    function finishInitialization() {


      updatePaginationRelationalFieldsState();

      updateSelectedColumnFromProperties();

      syncPaginationValidationVisualState();

      refreshTooltips();


      if(showLoader === true) {


        $('#page-loader').css(

          'z-index',

          ''

        );


        AutomatorPageLoader(

          'hide'

        );


      }


    }


    function executeInitialization() {


      loadPaginationRelationTables(

        tableInput,

        selectedTable,

        [

          paginationTable,

        ],

        function() {


          if(selectedTable == '') {


            resetPaginationRelationColumnSelect(

              columnInput

            );


            resetPaginationRelationColumnSelect(

              displayInput

            );


          }


          loadPaginationRelationColumns(

            columnInput,

            selectedTable,

            selectedColumn,

            function() {


              loadPaginationRelationColumns(

                displayInput,

                selectedTable,

                selectedDisplay,

                function() {


                  loadPaginationRelationTables(

                    relationalTableInput,

                    selectedRelationalTable,

                    [

                      paginationTable,
                      selectedTable,

                    ],

                    function() {


                      if(selectedRelationalTable == '') {


                        resetPaginationRelationColumnSelect(

                          relationalColumnInput

                        );


                        finishInitialization();


                        return;

                      }


                      loadPaginationRelationColumns(

                        relationalColumnInput,

                        selectedRelationalTable,

                        selectedRelationalColumn,

                        function() {


                          finishInitialization();


                        }

                      );


                    }

                  );


                }

              );


            }

          );


        }

      );


    }


    if(showLoader === true) {


      AutomatorPageLoader(

        'show',

        function() {


          $('#page-loader').css(

            'z-index',

            '1085'

          );


          executeInitialization();


        }

      );


    } else {

      executeInitialization();

    }


    return true;


  }


  function bindPaginationRelationPropertyEvents() {


    $(document)
      .off(
        'change.automator-pagination-editor-relation-mode',
        selectors.columnPropertyInput +
        '[data-property-path="relation.mode"]'
      )
      .on(
        'change.automator-pagination-editor-relation-mode',
        selectors.columnPropertyInput +
        '[data-property-path="relation.mode"]',
        function(event) {


          event.stopPropagation();


          updatePaginationRelationalFieldsState();

          updateSelectedColumnFromProperties();

          setSaveState(

            true

          );


        }
      );


    $(document)
      .off(
        'change.automator-pagination-editor-relation-table',
        selectors.columnPropertyInput +
        '[data-property-path="relation.table"]'
      )
      .on(
        'change.automator-pagination-editor-relation-table',
        selectors.columnPropertyInput +
        '[data-property-path="relation.table"]',
        function(event) {


          event.stopPropagation();


          const tableInput = $(this);


          const tableName = String(

            tableInput.val() || ''

          ).trim();


          const columnInput = getPaginationRelationPropertyInput(

            'relation.column'

          );


          const displayInput = getPaginationRelationPropertyInput(

            'relation.display'

          );


          const relationalTableInput = getPaginationRelationPropertyInput(

            'relation.relational-table'

          );


          const relationalColumnInput = getPaginationRelationPropertyInput(

            'relation.relational-column'

          );


          AutomatorPageLoader(

            'show',

            function() {


              $('#page-loader').css(

                'z-index',

                '1085'

              );


              resetPaginationRelationColumnSelect(

                columnInput

              );


              resetPaginationRelationColumnSelect(

                displayInput

              );


              resetPaginationRelationColumnSelect(

                relationalColumnInput

              );


              loadPaginationRelationColumns(

                columnInput,

                tableName,

                '',

                function() {


                  loadPaginationRelationColumns(

                    displayInput,

                    tableName,

                    '',

                    function() {


                      loadPaginationRelationTables(

                        relationalTableInput,

                        '',

                        [

                          String(
                            $(selectors.table).val() || ''
                          ).trim(),

                          tableName,

                        ],

                        function() {


                          updatePaginationRelationalFieldsState();

                          updateSelectedColumnFromProperties();

                          setSaveState(

                            true

                          );


                          $('#page-loader').css(

                            'z-index',

                            ''

                          );


                          AutomatorPageLoader(

                            'hide'

                          );


                        }

                      );


                    }

                  );


                }

              );


            }

          );


        }
      );


    $(document)
      .off(
        'change.automator-pagination-editor-relation-column',
        selectors.columnPropertyInput +
        '[data-property-path="relation.column"]'
      )
      .on(
        'change.automator-pagination-editor-relation-column',
        selectors.columnPropertyInput +
        '[data-property-path="relation.column"]',
        function(event) {


          event.stopPropagation();


          const tableName = String(

            getPaginationRelationPropertyInput(
              'relation.table'
            ).val() || ''

          ).trim();


          const relationalTableInput = getPaginationRelationPropertyInput(

            'relation.relational-table'

          );


          AutomatorPageLoader(

            'show',

            function() {


              $('#page-loader').css(

                'z-index',

                '1085'

              );


              loadPaginationRelationTables(

                relationalTableInput,

                String(

                  relationalTableInput.val() || ''

                ).trim(),

                [

                  String(
                    $(selectors.table).val() || ''
                  ).trim(),

                  tableName,

                ],

                function() {


                  updatePaginationRelationalFieldsState();

                  updateSelectedColumnFromProperties();

                  setSaveState(

                    true

                  );


                  $('#page-loader').css(

                    'z-index',

                    ''

                  );


                  AutomatorPageLoader(

                    'hide'

                  );


                }

              );


            }

          );


        }
      );


    $(document)
      .off(
        'change.automator-pagination-editor-relation-relational-table',
        selectors.columnPropertyInput +
        '[data-property-path="relation.relational-table"]'
      )
      .on(
        'change.automator-pagination-editor-relation-relational-table',
        selectors.columnPropertyInput +
        '[data-property-path="relation.relational-table"]',
        function(event) {


          event.stopPropagation();


          const tableName = String(

            $(this).val() || ''

          ).trim();


          const relationalColumnInput = getPaginationRelationPropertyInput(

            'relation.relational-column'

          );


          AutomatorPageLoader(

            'show',

            function() {


              $('#page-loader').css(

                'z-index',

                '1085'

              );


              loadPaginationRelationColumns(

                relationalColumnInput,

                tableName,

                '',

                function() {


                  updatePaginationRelationalFieldsState();

                  updateSelectedColumnFromProperties();

                  setSaveState(

                    true

                  );


                  $('#page-loader').css(

                    'z-index',

                    ''

                  );


                  AutomatorPageLoader(

                    'hide'

                  );


                }

              );


            }

          );


        }
      );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Renderiza campo de propriedade
  |--------------------------------------------------------------------------
  */

  function renderColumnPropertyField(
    fieldPath,
    fieldConfig,
    currentValue
  ) {


    fieldConfig = normalizePlainObject(

      fieldConfig

    );


    const fieldType = normalizePaginationPropertyType(

      fieldConfig.type ||

      fieldConfig.field ||

      'text'

    );


    const fieldLabel = String(

      fieldConfig.label ||

      fieldPath

    );


    const fieldDescription = String(

      fieldConfig.description || ''

    );


    const fieldRequired = normalizeBooleanValue(

      fieldConfig.required,

      false

    );


    const fieldNullable = normalizeBooleanValue(

      fieldConfig.nullable,

      true

    );


    const fieldID =

      'automator-pagination-column-property-' +

      normalizeActionName(

        fieldPath

      );


    if(fieldType == 'dynamic-list') {


      return (

        '<div ' +

          'class="' +

            'mb-3 automator-pagination-editor-column-dynamic-list' +

          '" ' +

          'data-property-path="' +

            escapeHtml(fieldPath) +

          '"' +

        '>' +

          '<label class="form-label small fw-semibold">' +

            escapeHtml(fieldLabel) +

          '</label>' +

          '<div ' +

            'class="automator-pagination-editor-column-dynamic-list-items" ' +

            'data-value="' +

              escapeHtml(

                JSON.stringify(

                  normalizeDynamicListValue(

                    currentValue

                  )

                )

              ) +

            '"' +

          '></div>' +

          '<button ' +

            'type="button" ' +

            'class="' +

              'btn btn-sm btn-outline-primary w-100 ' +

              'automator-pagination-editor-column-dynamic-list-add' +

            '"' +

          '>' +

            '<i class="fa fa-plus me-1"></i>' +

            'Adicionar substituição' +

          '</button>' +

        '</div>'

      );


    }


    if(
      fieldType == 'dynamic-table-list' ||
      fieldType == 'dynamic-column-list'
    ) {


      let nullLabel = '- Selecione -';


      if(fieldType == 'dynamic-table-list') {

        nullLabel = '- Selecione a Tabela -';

      }


      if(fieldType == 'dynamic-column-list') {

        nullLabel = '- Selecione a Tabela -';

      }


      const isRelationalField =

        fieldPath == 'relation.relational-table' ||

        fieldPath == 'relation.relational-column';


      return (

        '<div ' +

          'class="mb-3' +

            (

              isRelationalField === true

                ? ' automator-pagination-editor-relational-only'

                : ''

            ) +

          '" ' +

          'data-automator-pagination-property-wrapper="' +

            escapeHtml(fieldPath) +

          '"' +

        '>' +

          '<label ' +

            'for="' +

              escapeHtml(fieldID) +

            '" ' +

            'class="form-label small fw-semibold mb-1"' +

          '>' +

            escapeHtml(fieldLabel) +

            (

              fieldRequired === true

                ? ' <span class="text-danger">*</span>'

                : ''

            ) +

          '</label>' +

          '<select ' +

            'id="' +

              escapeHtml(fieldID) +

            '" ' +

            'class="' +

              'form-select form-select-sm ' +

              'automator-pagination-editor-column-property ' +

              'automator-pagination-editor-dynamic-relation-property' +

            '" ' +

            'data-property-type="' +

              escapeHtml(fieldType) +

            '" ' +

            'data-property-path="' +

              escapeHtml(fieldPath) +

            '" ' +

            'data-current-value="' +

              escapeHtml(

                currentValue === null ||
                currentValue === undefined

                  ? ''

                  : currentValue

              ) +

            '"' +

            (

              fieldRequired === true

                ? ' required'

                : ''

            ) +

          '>' +

            '<option ' +

              'value="" ' +

              'disabled="disabled" ' +

              (

                String(

                  currentValue || ''

                ).trim() == ''

                  ? 'selected="selected"'

                  : ''

              ) +

            '>' +

              nullLabel +

            '</option>' +

          '</select>' +

          (

            fieldDescription != ''

              ? '<div class="form-text">' +

                  escapeHtml(fieldDescription) +

                '</div>'

              : ''

          ) +

        '</div>'

      );


    }


    if(fieldType == 'select') {


      const values = normalizePropertySelectValues(

        fieldConfig.values

      );


      let options = '';


      if(fieldPath == 'name') {


        options +=

          '<option ' +

            'value="" ' +

            'disabled="disabled"' +

            (

              String(

                currentValue || ''

              ).trim() == ''

                ? ' selected="selected"'

                : ''

            ) +

          '>' +

            '- Selecionar coluna -' +

          '</option>';


      } else if(fieldNullable === true) {


        options +=

          '<option value="">' +

            '- Selecione -' +

          '</option>';


      }


      Object.keys(

        values || {}

      ).forEach(function(value) {


        options +=

          '<option value="' +

            escapeHtml(value) +

          '"' +

          (

            String(currentValue) == String(value)

              ? ' selected'

              : ''

          ) +

          '>' +

            escapeHtml(

              values[value] !== undefined &&
              values[value] !== null

                ? values[value]

                : value

            ) +

          '</option>';


      });


      return (

        '<div ' +

          'class="mb-3" ' +

          'data-automator-pagination-property-wrapper="' +

            escapeHtml(fieldPath) +

          '"' +

        '>' +

          '<label ' +

            'for="' +

              escapeHtml(fieldID) +

            '" ' +

            'class="form-label small fw-semibold mb-1"' +

          '>' +

            escapeHtml(fieldLabel) +

            (

              fieldRequired === true

                ? ' <span class="text-danger">*</span>'

                : ''

            ) +

          '</label>' +

          '<select ' +

            'id="' +

              escapeHtml(fieldID) +

            '" ' +

            'class="' +

              'form-select form-select-sm ' +

              'automator-pagination-editor-column-property' +

            '" ' +

            'data-property-path="' +

              escapeHtml(fieldPath) +

            '"' +

            (

              fieldRequired === true

                ? ' required'

                : ''

            ) +

          '>' +

            options +

          '</select>' +

          (

            fieldDescription != ''

              ? '<div class="form-text">' +

                  escapeHtml(fieldDescription) +

                '</div>'

              : ''

          ) +

        '</div>'

      );


    }


    const inputType =

      fieldType == 'number'

        ? 'number'

        : 'text';


    let inputAttributes = '';


    if(fieldPath == 'configs.size-value') {


      inputAttributes +=

        ' data-automator-pagination-column-size-value="true"';


    }


    return (

      '<div ' +

        'class="mb-3" ' +

        'data-automator-pagination-property-wrapper="' +

          escapeHtml(fieldPath) +

        '"' +

      '>' +

        '<label ' +

          'for="' +

            escapeHtml(fieldID) +

          '" ' +

          'class="form-label small fw-semibold mb-1"' +

        '>' +

          escapeHtml(fieldLabel) +

          (

            fieldRequired === true

              ? ' <span class="text-danger">*</span>'

              : ''

          ) +

        '</label>' +

        '<input ' +

          'type="' +

            inputType +

          '" ' +

          'id="' +

            escapeHtml(fieldID) +

          '" ' +

          'class="' +

            'form-control form-control-sm ' +

            'automator-pagination-editor-column-property' +

          '" ' +

          'data-property-path="' +

            escapeHtml(fieldPath) +

          '" ' +

          'placeholder="' +

            escapeHtml(

              fieldConfig.placeholder || ''

            ) +

          '" ' +

          'value="' +

            escapeHtml(

              currentValue === null ||
              currentValue === undefined

                ? ''

                : currentValue

            ) +

          '"' +

          (

            fieldRequired === true

              ? ' required'

              : ''

          ) +

          (

            fieldConfig.maxlength

              ? ' maxlength="' +

                  parseInt(
                    fieldConfig.maxlength,
                    10
                  ) +

                '"'

              : ''

          ) +

          inputAttributes +

        ' />' +

        (

          fieldDescription != ''

            ? '<div class="form-text">' +

                escapeHtml(fieldDescription) +

              '</div>'

            : ''

        ) +

      '</div>'

    );


  }


  /*
  |--------------------------------------------------------------------------
  | Grupo aberto nas propriedades
  |--------------------------------------------------------------------------
  */

  function getOpenedColumnPropertyGroup() {


    const openedGroup = $(selectors.proprietiesPanel)
      .find(
        '#automator-pagination-editor-column-properties-accordion ' +
        '.accordion-collapse.show'
      )
      .first();


    if(!openedGroup.length) {

      return '';

    }


    return String(

      openedGroup.attr('id') || ''

    );


  }


  /*
  |--------------------------------------------------------------------------
  | Restaura grupo aberto
  |--------------------------------------------------------------------------
  */

  function restoreOpenedColumnPropertyGroup(
    groupID = ''
  ) {


    groupID = String(

      groupID || ''

    ).trim();


    if(groupID == '') {

      return false;

    }


    const groupElement = document.getElementById(

      groupID

    );


    if(!groupElement) {

      return false;

    }


    const accordion = groupElement.closest(

      '#automator-pagination-editor-column-properties-accordion'

    );


    if(accordion) {


      accordion
        .querySelectorAll(
          '.accordion-collapse.show'
        )
        .forEach(function(element) {


          if(element === groupElement) {

            return;

          }


          element.classList.remove('show');


          const trigger = accordion.querySelector(

            '[data-bs-target="#' +

            element.id +

            '"]'

          );


          if(trigger) {

            trigger.classList.add('collapsed');

            trigger.setAttribute(

              'aria-expanded',

              'false'

            );

          }


        });


    }


    groupElement.classList.add('show');


    const trigger = document.querySelector(

      '[data-bs-target="#' +

      groupID +

      '"]'

    );


    if(trigger) {

      trigger.classList.remove('collapsed');

      trigger.setAttribute(

        'aria-expanded',

        'true'

      );

    }


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Atualiza coluna pelas propriedades
  |--------------------------------------------------------------------------
  */

  function updateSelectedColumnFromProperties(
    rerenderProperties = false
  ) {


    const item = getSelectedColumnItem();


    if(!item.length) {

      return false;

    }


    const openedGroupID = getOpenedColumnPropertyGroup();


    const column = normalizePaginationColumnData(

      $.extend(

        true,

        {},

        item.data(
          'automator-pagination-column'
        ) || {}

      )

    );


    $(selectors.proprietiesPanel)
      .find(
        selectors.columnPropertyInput
      )
      .each(function() {


        const input = $(this);


        const path = String(

          input.attr(
            'data-property-path'
          ) || ''

        ).trim();


        if(path == '') {

          return;

        }


        let value = input.val();


        if(path == 'name') {

          column.name = String(

            value || ''

          ).trim();

          return;

        }


        if(path == 'label') {

          column.label = String(

            value || ''

          );

          return;

        }


        if(path.indexOf('configs.') === 0) {


          if(path == 'configs.size-value') {


            if(
              value === null ||
              value === undefined ||
              String(value).trim() == ''
            ) {

              value = null;

            } else {

              value = parseFloat(value);

            }


          }


          setNestedValue(

            column.attrs,

            path,

            value

          );


          return;

        }


        setNestedValue(

          column.values,

          path,

          value

        );


      });


    $(selectors.proprietiesPanel)
      .find(
        selectors.columnDynamicList
      )
      .each(function() {


        const dynamicList = $(this);


        const path = String(

          dynamicList.attr(
            'data-property-path'
          ) || ''

        ).trim();


        if(path == '') {

          return;

        }


        setNestedValue(

          column.values,

          path,

          getColumnDynamicListValue(
            dynamicList
          )

        );


      });


    column.access = getSelectedPaginationColumnAccess();


    normalizeColumnSizeConfiguration(

      column

    );


    item.data(

      'automator-pagination-column',

      column

    );


    item.find(

      '.automator-pagination-editor-column-title'

    ).text(

      column.label ||

      column.type_title ||

      'Coluna'

    );


    item.find(

      '.automator-pagination-editor-column-name'

    ).text(

      column.name ||

      'Coluna não definida'

    );


    renderPaginationPreview();


    setSaveState(true);

    syncEditorState();


    if(rerenderProperties === true) {


      renderColumnProperties(item);


      setTimeout(function() {


        restoreOpenedColumnPropertyGroup(

          openedGroupID ||

          'automator-pagination-column-property-group-configs'

        );


      }, 10);


    } else {

      updateColumnSizeValueFieldVisibility();

    }


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza tamanho da coluna
  |--------------------------------------------------------------------------
  */

  function normalizeColumnSizeConfiguration(
    column = {}
  ) {


    column = normalizePaginationColumnData(

      column

    );


    let sizeType = String(

      getNestedValue(

        column.attrs,

        'configs.size-type',

        'auto'

      ) || 'auto'

    ).trim();


    let sizeValue = getNestedValue(

      column.attrs,

      'configs.size-value',

      null

    );


    if(
      sizeType != 'auto' &&
      sizeType != 'percent' &&
      sizeType != 'px'
    ) {

      sizeType = 'auto';

    }


    if(sizeType == 'auto') {

      sizeValue = null;

    }


    if(sizeType == 'percent') {


      sizeValue = parseFloat(sizeValue);


      if(
        !Number.isFinite(sizeValue) ||
        sizeValue < 1
      ) {

        sizeValue = 1;

      }


      if(sizeValue > 100) {

        sizeValue = 100;

      }


    }


    if(sizeType == 'px') {


      sizeValue = parseFloat(sizeValue);


      if(
        !Number.isFinite(sizeValue) ||
        sizeValue < 1
      ) {

        sizeValue = 1;

      }


    }


    setNestedValue(

      column.attrs,

      'configs.size-type',

      sizeType

    );


    setNestedValue(

      column.attrs,

      'configs.size-value',

      sizeValue

    );


    return column;


  }


  /*
  |--------------------------------------------------------------------------
  | Atualiza exibição do campo de tamanho
  |--------------------------------------------------------------------------
  */

  function updateColumnSizeValueFieldVisibility() {


    const sizeTypeInput = $(selectors.proprietiesPanel)
      .find(
        selectors.columnPropertyInput +
        '[data-property-path="configs.size-type"]'
      )
      .first();


    const sizeValueInput = $(selectors.proprietiesPanel)
      .find(
        selectors.columnPropertyInput +
        '[data-property-path="configs.size-value"]'
      )
      .first();


    if(
      !sizeTypeInput.length ||
      !sizeValueInput.length
    ) {

      return false;

    }


    const wrapper = sizeValueInput.closest(

      '[data-automator-pagination-property-wrapper="configs.size-value"]'

    );


    const sizeType = String(

      sizeTypeInput.val() || 'auto'

    ).trim();


    sizeValueInput.removeAttr('min');

    sizeValueInput.removeAttr('max');

    sizeValueInput.prop('required', false);


    if(sizeType == 'auto') {


      wrapper.addClass('d-none');

      sizeValueInput.val('');


      return true;


    }


    wrapper.removeClass('d-none');

    sizeValueInput.attr('min', '1');

    sizeValueInput.prop('required', true);


    if(sizeType == 'percent') {

      sizeValueInput.attr('max', '100');

    }


    return true;


  }

  function initializeColumnDynamicLists(container) {


    container = $(container);


    container.find(

      selectors.columnDynamicList

    ).each(function() {


      const dynamicList = $(this);

      const itemsContainer = dynamicList.find(

        selectors.columnDynamicListItems

      ).first();


      const values = parseJSONValue(

        itemsContainer.attr(
          'data-value'
        ),

        {}

      );


      itemsContainer.empty();


      Object.keys(values).forEach(function(key) {


        addColumnDynamicListItem(

          dynamicList,

          key,

          values[key]

        );


      });


    });


    return true;


  }


  function addColumnDynamicListItem(
    dynamicList,
    key = '',
    value = ''
  ) {


    dynamicList = $(dynamicList);


    const itemsContainer = dynamicList.find(

      selectors.columnDynamicListItems

    ).first();


    if(!itemsContainer.length) {

      return false;

    }


    const item = $(

      '<div class="' +

        'card mb-2 ' +

        'automator-pagination-editor-column-dynamic-list-item' +

      '">' +

        '<div class="card-body p-2">' +

          '<div class="mb-2">' +

            '<label class="form-label small fw-semibold mb-1">' +

              'Valor original' +

            '</label>' +

            '<input ' +

              'type="text" ' +

              'class="' +

                'form-control form-control-sm ' +

                'automator-pagination-editor-column-dynamic-list-key' +

              '" ' +

              'value="' +

                escapeHtml(key) +

              '" ' +

            '/>' +

          '</div>' +

          '<div class="mb-2">' +

            '<label class="form-label small fw-semibold mb-1">' +

              'Novo valor' +

            '</label>' +

            '<input ' +

              'type="text" ' +

              'class="' +

                'form-control form-control-sm ' +

                'automator-pagination-editor-column-dynamic-list-value' +

              '" ' +

              'value="' +

                escapeHtml(value) +

              '" ' +

            '/>' +

          '</div>' +

          '<button ' +

            'type="button" ' +

            'class="' +

              'btn btn-sm btn-danger w-100 ' +

              'automator-pagination-editor-column-dynamic-list-delete' +

            '"' +

          '>' +

            'Excluir substituição' +

          '</button>' +

        '</div>' +

      '</div>'

    );


    item
      .find('input')
      .addClass(
        'automator-pagination-editor-column-property-dynamic'
      )
      .on(
        'input change',
        function() {


          updateSelectedColumnFromProperties();


        }
      );


    itemsContainer.append(item);


    return item;


  }


  function getColumnDynamicListValue(dynamicList) {


    dynamicList = $(dynamicList);


    const values = {};


    dynamicList.find(

      '.automator-pagination-editor-column-dynamic-list-item'

    ).each(function() {


      const item = $(this);


      const key = String(

        item.find(
          '.automator-pagination-editor-column-dynamic-list-key'
        ).val() || ''

      ).trim();


      const value = String(

        item.find(
          '.automator-pagination-editor-column-dynamic-list-value'
        ).val() || ''

      );


      if(key == '') {

        return;

      }


      values[key] = value;


    });


    return values;


  }


  function getPaginationDefaultValues(
    pagination = {}
  ) {


    const values = {};

    pagination = normalizePaginationDefinition(

      pagination

    );


    const groups = pagination.args || {};


    Object.keys(groups).forEach(function(groupName) {


      const group = groups[groupName] || {};

      const fields = group.fields || {};


      Object.keys(fields).forEach(function(fieldName) {


        const field = fields[fieldName] || {};


        setNestedValue(

          values,

          groupName + '.' + fieldName,

          field.default !== undefined
            ? field.default
            : ''

        );


      });


    });


    return values;


  }


  function getColumnsData() {


    const columns = [];


    $(selectors.structureList)
      .find(
        selectors.structureItem
      )
      .each(function() {


        const item = $(this);


        if(
          item.attr(
            'data-action-buttons-column'
          ) == 'true'
        ) {

          return;

        }


        const column = normalizePaginationColumnData(

          item.data(
            'automator-pagination-column'
          ) || {}

        );


        if(
          column.isActionButtonsColumn === true
        ) {

          return;

        }


        columns.push(

          $.extend(

            true,

            {},

            column

          )

        );


      });


    return columns;


  }


  function getAvailableTableColumns() {


    const values = {};


    $(selectors.index)
      .find('option')
      .each(function() {


        const value = String(

          $(this).val() || ''

        ).trim();


        if(value == '') {

          return;

        }


        values[value] = String(

          $(this).text() || value

        );


      });


    return values;


  }


  function getNestedValue(
    object,
    path,
    defaultValue = ''
  ) {


    if(
      !object ||
      typeof object !== 'object'
    ) {

      return defaultValue;

    }


    const parts = String(

      path || ''

    ).split('.');


    let currentValue = object;


    for(
      let index = 0;
      index < parts.length;
      index++
    ) {


      const part = parts[index];


      if(
        currentValue === null ||
        currentValue === undefined ||
        typeof currentValue !== 'object' ||
        !Object.prototype.hasOwnProperty.call(
          currentValue,
          part
        )
      ) {

        return defaultValue;

      }


      currentValue = currentValue[part];


    }


    return currentValue;


  }


  function setNestedValue(
    object,
    path,
    value
  ) {


    if(
      !object ||
      typeof object !== 'object'
    ) {

      return false;

    }


    const parts = String(

      path || ''

    ).split('.');


    let currentValue = object;


    parts.forEach(function(part, index) {


      if(index == parts.length - 1) {

        currentValue[part] = value;

        return;

      }


      if(
        !currentValue[part] ||
        typeof currentValue[part] !== 'object'
      ) {

        currentValue[part] = {};

      }


      currentValue = currentValue[part];


    });


    return true;


  }


  function normalizePaginationPropertyType(
    fieldType = 'text'
  ) {


    fieldType = String(

      fieldType || 'text'

    ).toLowerCase();


    if(
      fieldType.indexOf('number') >= 0
    ) {

      return 'number';

    }


    if(
      fieldType == 'dynamic-list'
    ) {

      return 'dynamic-list';

    }


    if(
      fieldType == 'dynamic-table-list'
    ) {

      return 'dynamic-table-list';

    }


    if(
      fieldType == 'dynamic-column-list'
    ) {

      return 'dynamic-column-list';

    }


    if(fieldType == 'select') {

      return 'select';

    }


    return 'text';


  }


  function normalizeDynamicListValue(value) {


    if(
      value &&
      typeof value === 'object' &&
      !Array.isArray(value)
    ) {

      return value;

    }


    return {};


  }


  function escapeSelectorValue(value = '') {


    value = String(value || '');


    if(
      typeof CSS !== 'undefined' &&
      typeof CSS.escape === 'function'
    ) {

      return CSS.escape(value);

    }


    return value.replace(

      /(["'\\.#:[\],=])/g,

      '\\$1'

    );


  }


  function disposeTooltipsInside(
    container
  ) {


    if(!container) {

      return false;

    }


    if(
      container.matches &&
      container.matches(
        '[data-bs-toggle="tooltip"]'
      )
    ) {


      disposeTooltip(

        container

      );


    }


    container
      .querySelectorAll(
        '[data-bs-toggle="tooltip"]'
      )
      .forEach(function(element) {


        disposeTooltip(

          element

        );


      });


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Verifica informações dependentes
  |--------------------------------------------------------------------------
  */

  function hasDependentInformation() {


    const structureItems = $(selectors.structureList)
      .find(
        selectors.structureItem
      )
      .length;


    const buttonItems = $(selectors.buttonsContainer)
      .find(
        '[data-automator-pagination-button], ' +
        '.automator-pagination-editor-button-item'
      )
      .length;


    const actionItems = $(selectors.editor)
      .find(
        '[data-automator-pagination-action], ' +
        '.automator-dynamic-inserter-item'
      )
      .length;


    const queryFilterItems = $(

      '.automator-pagination-editor-query-filter-item'

    ).length;


    return (

      structureItems > 0 ||

      buttonItems > 0 ||

      actionItems > 0 ||

      queryFilterItems > 0

    );


  }


  /*
  |--------------------------------------------------------------------------
  | Verifica ações cadastradas
  |--------------------------------------------------------------------------
  */


  function hasRegisteredActions() {


    const actions = getActionsData();


    return (

      actions &&

      typeof actions === 'object' &&

      Object.keys(actions).length >= 1

    );


  }


  /*
  |--------------------------------------------------------------------------
  | Libera ou bloqueia ações principais
  |--------------------------------------------------------------------------
  */

  function setEditorActionsEnabled(enabled = false) {


    enabled = AutomatorNormalizeBoolean(enabled);


    setControlEnabled(

      $(selectors.inserterButton),

      enabled,

      'Adicionar coluna'

    );


    setControlEnabled(

      $(selectors.buttonsButton),

      enabled,

      'Botões'

    );


    setControlEnabled(

      $(selectors.actionsTabButton),

      enabled,

      'Ações'

    );


    $(selectors.editor).attr(

      'data-automator-pagination-ready',

      enabled === true
        ? 'true'
        : 'false'

    );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Libera ou bloqueia propriedades
  |--------------------------------------------------------------------------
  */

  function setProprietiesEnabled(
    enabled = false,
    disabledTitle = 'Nenhuma coluna foi selecionada.'
  ) {


    enabled = AutomatorNormalizeBoolean(enabled);


    const button = $(

      selectors.proprietiesButton

    );


    const wrapper = button.closest(

      selectors.tooltipWrapper

    );


    if(wrapper.length) {


      wrapper.attr(

        'data-automator-pagination-disabled-title',

        disabledTitle

      );


    }


    setControlEnabled(

      button,

      enabled,

      'Propriedades da coluna'

    );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Libera ou bloqueia botões internos
  |--------------------------------------------------------------------------
  */

  function setAddButtonsEnabled(
    hasBasicConfiguration = false,
    hasActions = false
  ) {


    hasBasicConfiguration = AutomatorNormalizeBoolean(

      hasBasicConfiguration

    );


    hasActions = AutomatorNormalizeBoolean(

      hasActions

    );


    $(selectors.headerButtonAdd).each(function() {


      const button = $(this);

      const wrapper = button.closest(

        selectors.tooltipWrapper

      );


      if(wrapper.length) {

        wrapper.attr(

          'data-automator-pagination-disabled-title',

          'Selecione uma tabela e um índice para adicionar um botão ao cabeçalho.'

        );

      }


      setControlEnabled(

        button,

        hasBasicConfiguration,

        'Adicionar botão ao cabeçalho'

      );


    });


    $(selectors.actionButtonAdd).each(function() {


      const button = $(this);

      const wrapper = button.closest(

        selectors.tooltipWrapper

      );


      if(wrapper.length) {

        wrapper.attr(

          'data-automator-pagination-disabled-title',

          hasBasicConfiguration === true
            ? 'Cadastre pelo menos uma ação para liberar a criação de botões de ação.'
            : 'Selecione uma tabela e um índice para configurar os botões de ação.'

        );

      }


      setControlEnabled(

        button,

        hasBasicConfiguration === true &&
        hasActions === true,

        'Adicionar botão de ação'

      );


    });


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Estado comum de controles e tooltips
  |--------------------------------------------------------------------------
  */

  function setControlEnabled(
    control,
    enabled = false,
    enabledTitle = ''
  ) {


    control = $(control);


    if(!control.length) {

      return false;

    }


    const wrapper = control.closest(

      selectors.tooltipWrapper

    );


    enabled = AutomatorNormalizeBoolean(enabled);


    control.prop(

      'disabled',

      enabled !== true

    );


    control.css(

      'pointer-events',

      enabled === true

        ? ''

        : 'none'

    );


    if(!wrapper.length) {

      return true;

    }


    wrapper.css(

      'pointer-events',

      'auto'

    );


    const disabledTitle = String(

      wrapper.attr(
        'data-automator-pagination-disabled-title'
      ) ||

      'Conclua as configurações necessárias para liberar esta ação.'

    ).trim();


    const currentEnabledTitle = String(

      enabledTitle ||

      wrapper.attr(
        'data-automator-pagination-enabled-title'
      ) ||

      ''

    ).trim();


    wrapper.attr(

      'data-automator-pagination-enabled-title',

      currentEnabledTitle

    );


    const tooltipTitle = enabled === true

      ? currentEnabledTitle

      : disabledTitle;


    disposeTooltip(

      wrapper[0]

    );


    if(tooltipTitle != '') {


      wrapper
        .attr(
          'data-bs-toggle',
          'tooltip'
        )
        .attr(
          'data-bs-placement',
          'bottom'
        )
        .attr(
          'data-bs-trigger',
          'hover focus'
        )
        .attr(
          'data-bs-title',
          tooltipTitle
        )
        .attr(
          'title',
          tooltipTitle
        );


      createTooltip(

        wrapper[0],

        true

      );


    } else {


      wrapper
        .removeAttr(
          'data-bs-toggle'
        )
        .removeAttr(
          'data-bs-placement'
        )
        .removeAttr(
          'data-bs-trigger'
        )
        .removeAttr(
          'data-bs-title'
        )
        .removeAttr(
          'title'
        );


    }


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Verifica se a sidebar está aberta
  |--------------------------------------------------------------------------
  */

  function isSidebarOpen(side = 'left') {


    side = String(side || '').trim();


    const aside = side == 'right'
      ? $(selectors.rightAside)
      : $(selectors.leftAside);


    if(!aside.length) {

      return false;

    }


    if(window.innerWidth <= 991.98) {

      return aside.hasClass('show');

    }


    return !aside.hasClass('is-collapsed');


  }


  /*
  |--------------------------------------------------------------------------
  | Controle das sidebars
  |--------------------------------------------------------------------------
  */

  function toggleSidebar(side = 'left') {


    side = String(side || '').trim();


    hideEditorTooltips();


    setSidebarOpen(

      side,

      !isSidebarOpen(side)

    );


    return true;


  }

  function setSidebarOpen(
    side = 'left',
    open = true
  ) {


    side = String(side || '').trim();

    open = AutomatorNormalizeBoolean(open);


    const aside = side == 'right'
      ? $(selectors.rightAside)
      : $(selectors.leftAside);


    if(!aside.length) {

      return false;

    }


    hideEditorTooltips();


    if(window.innerWidth <= 991.98) {


      aside.removeClass('is-collapsed');


      if(open === true) {

        aside.addClass('show');

      } else {

        aside.removeClass('show');

      }


      return true;


    }


    aside.removeClass('show');


    if(open === true) {

      aside.removeClass('is-collapsed');

    } else {

      aside.addClass('is-collapsed');

    }


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Reinicia select de índice
  |--------------------------------------------------------------------------
  */

  function resetIndexSelect(
    label = '- Selecione a tabela -'
  ) {


    const indexSelect = $(selectors.index);


    if(!indexSelect.length) {

      return false;

    }


    indexSelect
      .empty()
      .append(

        $('<option>', {

          value: '',

          text: label,

        })

      )
      .val('')
      .prop('disabled', true);


    state.selectedIndex = '';


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza itens do retorno
  |--------------------------------------------------------------------------
  */

  function normalizeResponseItems(items = []) {


    if(!Array.isArray(items)) {

      return [];

    }


    return items
      .map(function(item) {


        if(
          item === null ||
          item === undefined
        ) {

          return null;

        }


        if(typeof item !== 'object') {

          return {

            value: String(item),

            label: String(item),

          };

        }


        const value =
          item.value !== undefined
            ? item.value
            : (
                item.name !== undefined
                  ? item.name
                  : ''
              );


        const label =
          item.label !== undefined
            ? item.label
            : value;


        if(
          value === null ||
          value === undefined ||
          String(value).trim() == ''
        ) {

          return null;

        }


        return {

          value: String(value),

          label: String(label),

        };


      })
      .filter(function(item) {

        return item !== null;

      });


  }


  /*
  |--------------------------------------------------------------------------
  | Renderiza opções
  |--------------------------------------------------------------------------
  */

  function renderSelectOptions(
    select,
    items = [],
    selectedValue = '',
    nullLabel = '- Selecione -',
    options = {}
  ) {


    select = $(select);


    if(!select.length) {

      return false;

    }


    items = Array.isArray(items)

      ? items

      : [];


    options = normalizePlainObject(

      options

    );


    selectedValue = String(

      selectedValue === null ||
      selectedValue === undefined

        ? ''

        : selectedValue

    );


    const keepEmptyOption =

      options.keepEmptyOption !== false;


    const selectFirst =

      options.selectFirst === true;


    const defaultValue = String(

      options.defaultValue === null ||
      options.defaultValue === undefined

        ? ''

        : options.defaultValue

    );


    select.empty();


    if(keepEmptyOption === true) {


      select.append(

        $('<option>', {

          value:    '',
          text:     nullLabel,
          disabled: options.emptyDisabled === true,

        })

      );


    }


    items.forEach(function(item) {


      if(
        !item ||
        typeof item !== 'object'
      ) {

        return;

      }


      select.append(

        $('<option>', {

          value:

            item.value !== undefined &&
            item.value !== null

              ? String(item.value)

              : '',

          text:

            item.label !== undefined &&
            item.label !== null

              ? String(item.label)

              : String(
                  item.value || ''
                ),

        })

      );


    });


    const selectedExists =

      selectedValue != '' &&

      select.find('option').filter(function() {


        return String(

          $(this).val()

        ) === selectedValue;


      }).length >= 1;


    if(selectedExists === true) {


      select.val(

        selectedValue

      );


      return true;

    }


    const defaultExists =

      defaultValue != '' &&

      select.find('option').filter(function() {


        return String(

          $(this).val()

        ) === defaultValue;


      }).length >= 1;


    if(defaultExists === true) {


      select.val(

        defaultValue

      );


      return true;

    }


    if(selectFirst === true) {


      const firstAvailableOption = select
        .find(
          'option:not([disabled])'
        )
        .filter(function() {


          return String(

            $(this).val()

          ).trim() != '';


        })
        .first();


      if(firstAvailableOption.length) {


        select.val(

          firstAvailableOption.val()

        );


        return true;

      }


    }


    select.val('');


    return true;


  }

  /*
  |--------------------------------------------------------------------------
  | Inicializa tipos de coluna
  |--------------------------------------------------------------------------
  */

  function initializeColumnTypes() {


    $(selectors.columnType).each(function() {


      const item = $(this);


      const pagination = normalizePaginationDefinition(

        parseJSONValue(

          item.attr(
            'data-block-pagination'
          ),

          {}

        )

      );


      item.data(

        'automator-pagination-config',

        pagination

      );


      const description = String(

        pagination.description || ''

      ).trim();


      if(description != '') {

        item.attr(

          'data-bs-title',

          description

        );

      }


    });


    refreshTooltips();


    return true;


  }


  function findPaginationEditorSecuritySource(
    response = {}
  ) {


    response = normalizePlainObject(

      response

    );


    const candidates = [

      response,

      response.data,

      response.dados,

      response.configs,

      response.config,

      response.contentData,

      response.content_data,

      response.viewData,

      response.view_data,

      response.editorData,

      response.editor_data,

      response.recordData,

      response.record_data,

    ];


    let securitySource = {};


    candidates.some(function(candidate) {


      candidate = normalizePlainObject(

        candidate

      );


      const userTypes =

        candidate.userTypes ||

        candidate.user_types ||

        candidate.usersTypes ||

        candidate.users_types ||

        candidate.tbl_users_types ||

        null;


      if(
        Array.isArray(userTypes) ||
        (
          userTypes &&
          typeof userTypes === 'object'
        )
      ) {


        securitySource = candidate;


        return true;


      }


      return false;


    });


    return securitySource;


  }


  /*
  |--------------------------------------------------------------------------
  | Dados de segurança
  |--------------------------------------------------------------------------
  */

  function applyPaginationEditorSecurityResponse(
    response = {}
  ) {


    response = normalizePlainObject(

      response

    );


    const securitySource =

      findPaginationEditorSecuritySource(

        response

      );


    let userTypes =

      securitySource.userTypes ||

      securitySource.user_types ||

      securitySource.usersTypes ||

      securitySource.users_types ||

      securitySource.tbl_users_types ||

      response.userTypes ||

      response.user_types ||

      response.usersTypes ||

      response.users_types ||

      response.tbl_users_types ||

      [];


    if(
      !Array.isArray(userTypes) &&
      userTypes &&
      typeof userTypes === 'object'
    ) {

      userTypes = Object.values(

        userTypes

      );

    }


    /*
    |--------------------------------------------------------------------------
    | Não apaga dados já carregados
    |--------------------------------------------------------------------------
    |
    | Durante a criação de uma paginação, mais de uma etapa pode chamar esta
    | função. Alguns desses retornos não possuem os tipos de usuário. Nesse
    | cenário, a lista já carregada não deve ser substituída por um array vazio.
    |
    */

    if(
      Array.isArray(userTypes) &&
      userTypes.length >= 1
    ) {

      state.userTypes = userTypes;

    } else if(!Array.isArray(state.userTypes)) {

      state.userTypes = [];

    }


    state.developerUserTypeID = null;


    state.userTypes.forEach(function(userType) {


      userType = normalizePlainObject(

        userType

      );


      const userTypeID = String(

        userType.id ||

        userType.tbl_users_type_ID ||

        userType.tbl_user_type_ID ||

        ''

      ).trim();


      const userTypeName = String(

        userType.name ||

        userType.tbl_users_type_name ||

        userType.tbl_user_type_name ||

        ''

      )
        .trim()
        .toLowerCase();


      if(
        userType.isDeveloper === true ||
        userType.is_developer === true ||
        userTypeName == 'desenvolvedor'
      ) {

        state.developerUserTypeID = userTypeID;

      }


    });


    const currentUser = normalizePlainObject(

      securitySource.currentUser ||

      securitySource.current_user ||

      response.currentUser ||

      response.current_user ||

      {}

    );


    if(
      currentUser.isDeveloper !== undefined ||
      currentUser.is_developer !== undefined
    ) {


      state.currentUserIsDeveloper = (


        currentUser.isDeveloper === true ||

        currentUser.is_developer === true ||

        String(

          currentUser.isDeveloper ||

          currentUser.is_developer ||

          ''

        ) == '1'


      );


    }


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza acessos
  |--------------------------------------------------------------------------
  */

  function normalizePaginationAccessValues(
    values
  ) {


    values = normalizeArrayValue(

      values

    )
      .map(function(value) {

        return String(value);

      })
      .filter(function(value) {

        return value != '';

      })
      .filter(function(value, index, list) {

        return list.indexOf(value) === index;

      });


    if(
      state.developerUserTypeID &&
      values.indexOf(
        String(
          state.developerUserTypeID
        )
      ) < 0
    ) {

      values.push(

        String(
          state.developerUserTypeID
        )

      );

    }


    return values;


  }


  /*
  |--------------------------------------------------------------------------
  | Lista de checkboxes de acesso
  |--------------------------------------------------------------------------
  */

  function renderPaginationColumnAccessList(
    column = {}
  ) {


    column = normalizePaginationColumnData(

      column

    );


    const selectedValues = normalizePaginationAccessValues(

      column.access ||

      column.user_types ||

      column.users_types ||

      column.tbl_users_types ||

      []

    );


    if(state.userTypes.length <= 0) {


      return (

        '<div class="small text-muted">' +

          'Nenhum tipo de usuário foi disponibilizado para o editor.' +

        '</div>'

      );


    }


    let html = '';


    state.userTypes.forEach(function(userType) {


      userType = normalizePlainObject(

        userType

      );


      const userTypeID = String(

        userType.id ||

        userType.tbl_users_type_ID ||

        userType.tbl_user_type_ID ||

        ''

      );


      if(userTypeID == '') {

        return;

      }


      const userTypeName = String(

        userType.name ||

        userType.tbl_users_type_name ||

        userType.tbl_user_type_name ||

        'Tipo ' + userTypeID

      );


      const isDeveloper =

        userTypeID == String(

          state.developerUserTypeID || ''

        );


      const checked =

        isDeveloper === true ||

        selectedValues.indexOf(

          userTypeID

        ) >= 0;


      const inputID =

        'automator-pagination-column-access-' +

        escapeHtml(

          String(

            column.id || ''

          )

        ) +

        '-' +

        escapeHtml(

          userTypeID

        );


      html +=

        '<div class="form-check mb-2">' +

          '<input ' +

            'type="checkbox" ' +

            'class="' +

              'form-check-input ' +

              'automator-pagination-editor-column-access' +

            '" ' +

            'id="' +

              inputID +

            '" ' +

            'value="' +

              escapeHtml(userTypeID) +

            '" ' +

            (

              checked === true

                ? 'checked '

                : ''

            ) +

            (

              isDeveloper === true

                ? 'disabled data-developer="true" '

                : ''

            ) +

          '/>' +

          '<label ' +

            'class="form-check-label small" ' +

            'for="' +

              inputID +

            '"' +

          '>' +

            escapeHtml(userTypeName) +

          '</label>' +

        '</div>';


    });


    return html;


  }


  /*
  |--------------------------------------------------------------------------
  | Retorna acessos marcados
  |--------------------------------------------------------------------------
  */

  function getSelectedPaginationColumnAccess() {


    const values = [];


    $(selectors.proprietiesPanel)
      .find(
        '.automator-pagination-editor-column-access:checked'
      )
      .each(function() {


        values.push(

          String(
            $(this).val()
          )

        );


      });


    return normalizePaginationAccessValues(

      values

    );


  }


  /*
  |--------------------------------------------------------------------------
  | Eventos de segurança
  |--------------------------------------------------------------------------
  */

  function bindPaginationAccessEvents() {


    $(document)
      .off(
        'change.automator-pagination-editor-column-access',
        selectors.editor +
        ' .automator-pagination-editor-column-access'
      )
      .on(
        'change.automator-pagination-editor-column-access',
        selectors.editor +
        ' .automator-pagination-editor-column-access',
        function() {


          const input = $(this);


          if(
            input.attr(
              'data-developer'
            ) == 'true'
          ) {

            input.prop(

              'checked',

              true

            );

          }


          updateSelectedColumnFromProperties();


        }
      );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Inicializa ações
  |--------------------------------------------------------------------------
  */

  function initializeActions() {


    $(selectors.actionsManager).each(function() {


      const manager = $(this);


      const valueField = manager.find(

        selectors.actionsValue

      ).first();


      const actions = normalizePlainObject(

        parseJSONValue(

          valueField.val(),

          {}

        )

      );


      const list = manager.find(

        selectors.actionsList

      ).first();


      list.empty();


      Object.keys(actions).forEach(function(actionName) {


        const actionData = normalizePlainObject(

          actions[actionName]

        );


        addActionItem(

          manager,

          actionName,

          actionData,

          false

        );


      });


      positionPaginationActionAddButton(

        manager

      );


      updateActionsEmptyState(

        manager

      );


      syncActionsValue(

        manager

      );


    });


    updatePaginationButtonActionOptions();

    updatePaginationActionsUsageState();


    return true;


  }


  function updatePaginationActionCardHeader(
    item
  ) {


    item = $(item);


    if(!item.length) {

      return false;

    }


    const actionName = normalizeActionName(

      item.find(

        selectors.actionName

      ).val()

    );


    const headerTitle = item.find(

      selectors.actionHeaderTitle

    ).first();


    const collapseButton = item.find(

      selectors.actionCollapse

    ).first();


    const body = item.find(

      selectors.actionBody

    ).first();


    item
      .addClass(

        'shadow-sm mb-4'

      )
      .removeClass(

        'mb-3'

      );


    item.find(

      selectors.actionRolesList

    ).addClass(

      'small'

    );


    item.find(

      selectors.actionRoleAdd

    )
      .removeClass(

        'btn-outline-primary'

      )
      .addClass(

        'btn-outline-secondary'

      );


    headerTitle.text(

      actionName != ''

        ? actionName

        : 'Nova ação'

    );


    collapseButton.prop(

      'disabled',

      actionName == ''

    );


    collapseButton.attr(

      'aria-disabled',

      actionName == ''

        ? 'true'

        : 'false'

    );


    if(actionName == '') {


      body.addClass(

        'show'

      );


    }


    updatePaginationActionCollapseIcon(

      item,

      body.hasClass(
        'show'
      )

    );


    return true;


  }


  function bindPaginationActionCardEvents() {


    $(document)
      .off(
        'click.automator-pagination-editor-action-collapse',
        selectors.actionCollapse
      )
      .on(
        'click.automator-pagination-editor-action-collapse',
        selectors.actionCollapse,
        function(event) {


          event.preventDefault();

          event.stopPropagation();


          const button = $(this);


          if(button.prop('disabled') === true) {

            return false;

          }


          const item = button.closest(

            selectors.actionItem

          );


          const actionName = normalizeActionName(

            item.find(

              selectors.actionName

            ).val()

          );


          if(actionName == '') {

            return false;

          }


          const body = item.find(

            selectors.actionBody

          ).first();


          if(!body.length) {

            return false;

          }


          const bodyElement = body[0];


          if(
            typeof bootstrap !== 'undefined' &&
            bootstrap.Collapse
          ) {


            const collapse = bootstrap.Collapse.getOrCreateInstance(

              bodyElement,

              {

                toggle: false,

              }

            );


            collapse.toggle();


          } else {


            const opened = body.hasClass(

              'show'

            );


            body.toggleClass(

              'show',

              opened !== true

            );


            updatePaginationActionCollapseIcon(

              item,

              opened !== true

            );


          }


          return false;


        }
      );


    $(document)
      .off(
        'shown.bs.collapse.automator-pagination-editor-action-card ' +
        'hidden.bs.collapse.automator-pagination-editor-action-card',
        selectors.actionBody
      )
      .on(
        'shown.bs.collapse.automator-pagination-editor-action-card ' +
        'hidden.bs.collapse.automator-pagination-editor-action-card',
        selectors.actionBody,
        function(event) {


          const body = $(this);


          const item = body.closest(

            selectors.actionItem

          );


          const opened =

            event.type == 'shown';


          updatePaginationActionCollapseIcon(

            item,

            opened

          );


        }
      );


    return true;


  }

  /*
  |--------------------------------------------------------------------------
  | Eventos das ações
  |--------------------------------------------------------------------------
  */

  function bindActionsEvents() {


    $(document)
      .off(
        'click.automator-pagination-editor-action-add',
        selectors.actionAdd
      )
      .on(
        'click.automator-pagination-editor-action-add',
        selectors.actionAdd,
        function(event) {


          event.preventDefault();

          event.stopPropagation();


          const button = $(this);


          if(button.prop('disabled') === true) {

            return false;

          }


          const manager = button.closest(

            selectors.actionsManager

          );


          if(!manager.length) {


            console.warn(

              'O gerenciador de ações da paginação não foi encontrado.'

            );


            return false;

          }


          const actionItem = addActionItem(

            manager,

            '',

            {

              route: '',
              params: {},
              show: true,

            },

            true

          );


          if(
            actionItem &&
            actionItem.length
          ) {


            updateActionsEmptyState(

              manager

            );


            syncActionsValue(

              manager

            );


            updatePaginationButtonActionOptions();

            syncEditorState();

            setSaveState(true);


          }


          return false;


        }
      );


    $(document)
      .off(
        'keyup.automator-pagination-editor-action-name input.automator-pagination-editor-action-name',
        selectors.actionName
      )
      .on(
        'keyup.automator-pagination-editor-action-name input.automator-pagination-editor-action-name',
        selectors.actionName,
        function() {


          const input = $(this);


          const item = input.closest(

            selectors.actionItem

          );


          const manager = input.closest(

            selectors.actionsManager

          );


          const previousName = String(

            item.attr(
              'data-action-current-name'
            ) || ''

          ).trim();


          const normalizedName = normalizeActionName(

            input.val()

          );


          if(input.val() != normalizedName) {

            input.val(

              normalizedName

            );

          }


          updatePaginationActionCardHeader(

            item

          );


          const actionNameValid = validateActionName(

            manager,

            item

          );


          if(actionNameValid === true) {


            item.attr(

              'data-action-current-name',

              normalizedName

            );


            if(
              previousName != '' &&
              previousName != normalizedName
            ) {


              $(selectors.paginationButtonAction).each(function() {


                const buttonActionSelect = $(this);


                if(
                  String(

                    buttonActionSelect.val() || ''

                  ).trim() == previousName
                ) {

                  buttonActionSelect.attr(

                    'data-pending-action-value',

                    normalizedName

                  );

                }


              });


            }


          }


          syncActionsValue(

            manager

          );


          updatePaginationButtonActionOptions();


          $(selectors.paginationButtonAction).each(function() {


            const buttonActionSelect = $(this);


            const pendingValue = String(

              buttonActionSelect.attr(
                'data-pending-action-value'
              ) || ''

            ).trim();


            if(pendingValue == '') {

              return;

            }


            buttonActionSelect.val(

              pendingValue

            );


            buttonActionSelect.removeAttr(

              'data-pending-action-value'

            );


          });


          syncPaginationButtonsState();

          syncEditorState();

          setSaveState(true);


        }
      );


    $(document)
      .off(
        'change.automator-pagination-editor-action-route',
        selectors.actionRoute
      )
      .on(
        'change.automator-pagination-editor-action-route',
        selectors.actionRoute,
        function() {


          const select = $(this);


          const item = select.closest(

            selectors.actionItem

          );


          const manager = select.closest(

            selectors.actionsManager

          );


          const routeName = String(

            select.val() || ''

          ).trim();


          if(routeName == '') {


            item.find(

              selectors.actionParamsList

            ).empty();


            item.find(

              selectors.actionShow

            )
              .val('true')
              .prop(
                'disabled',
                true
              );


            item.find(

              selectors.actionParamAdd

            ).prop(

              'disabled',

              true

            );


            syncActionsValue(

              manager

            );


            updatePaginationButtonActionOptions();

            syncEditorState();

            setSaveState(true);


            return false;

          }


          AutomatorPageLoader(

            'show',

            function() {


              $('#page-loader').css(

                'z-index',

                '1085'

              );


              loadActionRouteData(

                item,

                routeName,

                function() {


                  syncActionsValue(

                    manager

                  );


                  updatePaginationButtonActionOptions();

                  syncEditorState();

                  setSaveState(true);


                  $('#page-loader').css(

                    'z-index',

                    ''

                  );


                  AutomatorPageLoader(

                    'hide'

                  );


                }

              );


            }

          );


          return false;


        }
      );


    $(document)
      .off(
        'change.automator-pagination-editor-action-show',
        selectors.actionShow
      )
      .on(
        'change.automator-pagination-editor-action-show',
        selectors.actionShow,
        function() {


          const manager = $(this).closest(

            selectors.actionsManager

          );


          syncActionsValue(

            manager

          );


          syncEditorState();

          setSaveState(true);


        }
      );


    $(document)
      .off(
        'click.automator-pagination-editor-action-param-add',
        selectors.actionParamAdd
      )
      .on(
        'click.automator-pagination-editor-action-param-add',
        selectors.actionParamAdd,
        function(event) {


          event.preventDefault();

          event.stopPropagation();


          const button = $(this);


          if(button.prop('disabled') === true) {

            return false;

          }


          const item = button.closest(

            selectors.actionItem

          );


          const manager = button.closest(

            selectors.actionsManager

          );


          addActionParam(

            item,

            {

              name: '',
              value: '',
              default: false,

            }

          );


          syncActionsValue(

            manager

          );


          syncEditorState();

          setSaveState(true);


          return false;


        }
      );


    $(document)
      .off(
        'input.automator-pagination-editor-action-param',
        selectors.actionParamName + ', ' +
        selectors.actionParamValue
      )
      .on(
        'input.automator-pagination-editor-action-param',
        selectors.actionParamName + ', ' +
        selectors.actionParamValue,
        function() {


          const item = $(this).closest(

            selectors.actionItem

          );


          const manager = $(this).closest(

            selectors.actionsManager

          );


          validateActionParams(

            item

          );


          syncActionsValue(

            manager

          );


          syncEditorState();

          setSaveState(true);


        }
      );


    $(document)
      .off(
        'click.automator-pagination-editor-action-param-delete',
        selectors.actionParamDelete
      )
      .on(
        'click.automator-pagination-editor-action-param-delete',
        selectors.actionParamDelete,
        function(event) {


          event.preventDefault();

          event.stopPropagation();


          const button = $(this);


          if(button.prop('disabled') === true) {

            return false;

          }


          const item = button.closest(

            selectors.actionItem

          );


          const manager = button.closest(

            selectors.actionsManager

          );


          button.closest(

            selectors.actionParamRow

          ).remove();


          validateActionParams(

            item

          );


          syncActionsValue(

            manager

          );


          syncEditorState();

          setSaveState(true);


          return false;


        }
      );


    $(document)
      .off(
        'click.automator-pagination-editor-action-delete',
        selectors.actionDelete
      )
      .on(
        'click.automator-pagination-editor-action-delete',
        selectors.actionDelete,
        function(event) {


          event.preventDefault();

          event.stopPropagation();


          const button = $(this);


          if(button.prop('disabled') === true) {

            return false;

          }


          const item = button.closest(

            selectors.actionItem

          );


          const manager = button.closest(

            selectors.actionsManager

          );


          const actionName = normalizeActionName(

            item.find(
              selectors.actionName
            ).val()

          );


          if(
            actionName != '' &&
            isPaginationActionUsedByButton(
              actionName
            ) === true
          ) {


            updatePaginationActionsUsageState();


            showMessage(

              'Ação em uso',

              'Esta ação está em uso na paginação e não é possivel remove-la.'

            );


            return false;

          }


          disposeTooltipsInside(

            item[0]

          );


          const tooltipWrapper = button.parent(

            '.automator-pagination-editor-action-delete-tooltip'

          );


          if(tooltipWrapper.length) {

            tooltipWrapper.remove();

          } else {

            item.remove();

          }


          updateActionsEmptyState(

            manager

          );


          syncActionsValue(

            manager

          );


          updatePaginationButtonActionOptions();

          syncPaginationButtonsState();

          syncEditorState();

          setSaveState(true);


          return false;


        }
      );


    return true;


  }

  /*
  |--------------------------------------------------------------------------
  | Adiciona ação
  |--------------------------------------------------------------------------
  */

  function addActionItem(
    manager,
    actionName = '',
    actionData = {},
    focusName = false
  ) {


    manager = $(manager);


    actionData = normalizePlainObject(

      actionData

    );


    const list = manager.find(

      selectors.actionsList

    ).first();


    const routes = normalizePlainObject(

      getActionsRoutes(

        manager

      )

    );


    const normalizedActionName = normalizeActionName(

      actionName

    );


    const itemID =

      'automator-pagination-action-' +

      Date.now() +

      '-' +

      Math.floor(

        Math.random() * 100000

      );


    const bodyID =

      itemID +

      '-body';


    let routeOptions =

      '<option value="">' +

        '- Selecione -' +

      '</option>';


    Object.keys(

      routes

    ).forEach(function(routeName) {


      const routeLabel = routes[routeName];


      routeOptions +=

        '<option value="' +

          escapeHtml(routeName) +

        '">' +

          escapeHtml(routeLabel) +

        '</option>';


    });


    const item = $(

      '<div ' +

        'id="' +

          escapeHtml(itemID) +

        '" ' +

        'class="' +

          'automator-pagination-editor-action-item ' +

          'border rounded mb-3' +

        '" ' +

        'data-automator-pagination-action="true" ' +

        'data-action-current-name="' +

          escapeHtml(normalizedActionName) +

        '"' +

      '>' +

        '<div class="' +

          'automator-pagination-editor-action-header ' +

          'px-3 py-2 border-bottom bg-light' +

        '">' +

          '<div class="d-flex align-items-center justify-content-between gap-2">' +

            '<strong class="' +

              'small text-truncate ' +

              'automator-pagination-editor-action-header-title' +

            '">' +

              escapeHtml(

                normalizedActionName != ''

                  ? normalizedActionName

                  : 'Nova ação'

              ) +

            '</strong>' +

            '<button ' +

              'type="button" ' +

              'class="' +

                'btn btn-sm btn-light border ' +

                'automator-pagination-editor-action-collapse' +

              '" ' +

              'aria-controls="' +

                escapeHtml(bodyID) +

              '" ' +

              'aria-expanded="true"' +

              (

                normalizedActionName == ''

                  ? ' disabled aria-disabled="true"'

                  : ''

              ) +

            '>' +

              '<i class="fa fa-chevron-up"></i>' +

            '</button>' +

          '</div>' +

        '</div>' +

        '<div ' +

          'id="' +

            escapeHtml(bodyID) +

          '" ' +

          'class="' +

            'collapse show ' +

            'automator-pagination-editor-action-body' +

          '"' +

        '>' +

          '<div class="p-3">' +

            '<div class="mb-3">' +

              '<label class="form-label small fw-semibold mb-1">' +

                'Nome da ação' +

              '</label>' +

              '<input ' +

                'type="text" ' +

                'class="' +

                  'form-control form-control-sm ' +

                  'automator-pagination-editor-action-name' +

                '" ' +

                'placeholder="Nome da ação" ' +

                'autocomplete="off" ' +

                'value="' +

                  escapeHtml(normalizedActionName) +

                '" ' +

              '/>' +

              '<div class="invalid-feedback">' +

                'Informe um nome único para a ação.' +

              '</div>' +

            '</div>' +

            '<div class="mb-3">' +

              '<label class="form-label small fw-semibold mb-1">' +

                'Rota' +

              '</label>' +

              '<select ' +

                'class="' +

                  'form-select form-select-sm ' +

                  'automator-pagination-editor-action-route' +

                '" ' +

                'disabled' +

              '>' +

                routeOptions +

              '</select>' +

            '</div>' +

            '<div class="mb-3">' +

              '<label class="form-label small fw-semibold mb-2">' +

                'Parâmetros' +

              '</label>' +

              '<div ' +

                'class="' +

                  'automator-pagination-editor-action-params-list' +

                '" ' +

                'data-empty="Nenhum parâmetro adicionado."' +

              '></div>' +

              '<button ' +

                'type="button" ' +

                'class="' +

                  'btn btn-sm btn-outline-primary w-100 mt-2 ' +

                  'automator-pagination-editor-action-param-add' +

                '" ' +

                'disabled' +

              '>' +

                '<i class="fa fa-plus me-1"></i>' +

                'Adicionar parâmetro' +

              '</button>' +

            '</div>' +

            '<div class="mb-3">' +

              '<label class="form-label small fw-semibold mb-2">' +

                'Regras de uso' +

              '</label>' +

              '<div class="' +

                'automator-pagination-editor-action-roles-list' +

              '"></div>' +

              '<button ' +

                'type="button" ' +

                'class="' +

                  'btn btn-sm btn-outline-primary w-100 mt-2 ' +

                  'automator-pagination-editor-action-role-add' +

                '"' +

              '>' +

                '<i class="fa fa-plus me-1"></i>' +

                'Adicionar condição' +

              '</button>' +

            '</div>' +

            '<div class="mb-3">' +

              '<label class="form-label small fw-semibold mb-1">' +

                'Visível' +

              '</label>' +

              '<select ' +

                'class="' +

                  'form-select form-select-sm ' +

                  'automator-pagination-editor-action-show' +

                '" ' +

                'disabled' +

              '>' +

                '<option value="true">Sim</option>' +

                '<option value="false">Não</option>' +

              '</select>' +

            '</div>' +

            '<button ' +

              'type="button" ' +

              'class="' +

                'btn btn-sm btn-outline-danger w-100 ' +

                'automator-pagination-editor-action-delete' +

              '" ' +

              'data-bs-toggle="tooltip" ' +

              'data-bs-placement="top" ' +

              'data-bs-title="Excluir ação"' +

            '>' +

              '<i class="fa fa-trash me-1"></i>' +

              'Excluir ação' +

            '</button>' +

          '</div>' +

        '</div>' +

      '</div>'

    );


    list.append(

      item

    );


    ensurePaginationActionNameAutocomplete(

      item

    );


    const routeName = String(

      actionData.route || ''

    ).trim();


    const actionNameValid = validateActionName(

      manager,

      item

    );


    if(
      routeName != '' &&
      actionNameValid === true
    ) {


      item.find(

        selectors.actionRoute

      ).val(

        routeName

      );


      item.find(

        selectors.actionShow

      ).val(

        normalizeBooleanValue(

          actionData.show,

          true

        )

          ? 'true'

          : 'false'

      );


      const params = normalizeActionParams(

        actionData.params

      );


      Object.keys(

        params

      ).forEach(function(paramName) {


        addActionParam(

          item,

          {

            name:    paramName,
            value:   params[paramName],
            default: false,

          }

        );


      });


      item.find(

        selectors.actionShow

      ).prop(

        'disabled',

        false

      );


      item.find(

        selectors.actionParamAdd

      ).prop(

        'disabled',

        false

      );


    }


    const roles = normalizePaginationActionRoles(

      actionData.roles

    );


    roles.forEach(function(role) {


      addPaginationActionRole(

        item,

        role

      );


    });


    updatePaginationActionRolesEmptyState(

      item

    );


    updatePaginationActionCardHeader(

      item

    );


    positionPaginationActionAddButton(

      manager

    );


    updateActionsEmptyState(

      manager

    );


    updatePaginationActionsUsageState();

    refreshTooltips();


    if(focusName === true) {


      setTimeout(function() {


        const nameInput = item.find(

          selectors.actionName

        ).first();


        nameInput.trigger(

          'focus'

        );


        if(
          nameInput.length &&
          nameInput[0].scrollIntoView
        ) {

          nameInput[0].scrollIntoView({

            behavior: 'smooth',
            block:    'center',

          });

        }


      }, 50);


    }


    return item;


  }


  /*
  |--------------------------------------------------------------------------
  | Valida nome da ação
  |--------------------------------------------------------------------------
  */

  function validateActionName(
    manager,
    item
  ) {


    manager = $(manager);

    item = $(item);


    const input = item.find(

      selectors.actionName

    ).first();


    const name = normalizeActionName(

      input.val()

    );


    input.val(name);


    let occurrences = 0;


    manager.find(

      selectors.actionName

    ).each(function() {


      if(
        normalizeActionName(
          $(this).val()
        ) == name &&
        name != ''
      ) {

        occurrences++;

      }


    });


    const valid =

      name != '' &&

      occurrences === 1;


    input.toggleClass(

      'is-invalid',

      valid !== true

    );


    item.find(

      selectors.actionRoute

    ).prop(

      'disabled',

      valid !== true

    );


    if(valid !== true) {


      item.find(

        selectors.actionShow

      ).prop('disabled', true);


      item.find(

        selectors.actionParamAdd

      ).prop('disabled', true);


    } else {


      const routeName = String(

        item.find(
          selectors.actionRoute
        ).val() || ''

      ).trim();


      item.find(

        selectors.actionShow

      ).prop(

        'disabled',

        routeName == ''

      );


      item.find(

        selectors.actionParamAdd

      ).prop(

        'disabled',

        routeName == ''

      );


    }


    return valid;


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza nome da ação
  |--------------------------------------------------------------------------
  */

  function normalizeActionName(value = '') {


    value = String(value || '');


    if(
      typeof value.normalize === 'function'
    ) {

      value = value
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '');

    }


    return value
      .toLowerCase()
      .replace(/[^a-z0-9]+/g, '-')
      .replace(/^-+|-+$/g, '')
      .replace(/-+/g, '-');


  }


  /*
  |--------------------------------------------------------------------------
  | Carrega dados da rota
  |--------------------------------------------------------------------------
  */

  function loadActionRouteData(
    item,
    routeName,
    callback = null
  ) {


    item = $(item);


    requestDatabaseData(

      {

        'data-type': 'get-route-data',

        'route-name': routeName,

      },

      function(response) {


        const paramsList = item.find(

          selectors.actionParamsList

        );


        paramsList.empty();


        const routeParams =

          response.data &&

          Array.isArray(response.data.params)

            ? response.data.params

            : [];


        routeParams.forEach(function(param) {


          addActionParam(

            item,

            {

              name: param.name || '',

              value: param.value || '',

              default: true,

            }

          );


        });


        item.find(

          selectors.actionShow

        )
          .val('true')
          .prop('disabled', false);


        item.find(

          selectors.actionParamAdd

        ).prop('disabled', false);


        validateActionParams(item);


        if(typeof callback === 'function') {

          callback(response);

        }


      },

      function(response) {


        item.find(

          selectors.actionShow

        ).prop('disabled', true);


        item.find(

          selectors.actionParamAdd

        ).prop('disabled', true);


        if(typeof callback === 'function') {

          callback(response);

        }


      }

    );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Adiciona parâmetro
  |--------------------------------------------------------------------------
  */

  function addActionParam(
    item,
    param = {}
  ) {


    item = $(item);


    const list = item.find(

      selectors.actionParamsList

    ).first();


    if(!list.length) {

      return false;

    }


    const isDefault =

      param.default === true;


    const row = $(

      '<div ' +

        'class="card mb-2 automator-pagination-editor-action-param-row" ' +

        'data-default-param="' +

          (isDefault ? 'true' : 'false') +

        '"' +

      '>' +

        '<div class="card-body p-2">' +

          '<div class="mb-2">' +

            '<label class="form-label small fw-semibold mb-1">' +

              'Nome do parâmetro' +

            '</label>' +

            '<input ' +

              'type="text" ' +

              'class="form-control form-control-sm automator-pagination-editor-action-param-name" ' +

              'placeholder="Nome do parâmetro" ' +

              'autocomplete="off" ' +

              'value="' + escapeHtml(param.name || '') + '" ' +

              (isDefault ? 'readonly ' : '') +

            '/>' +

            '<div class="invalid-feedback">' +

              'O nome do parâmetro deve ser único.' +

            '</div>' +

          '</div>' +

          '<div class="mb-2">' +

            '<label class="form-label small fw-semibold mb-1">' +

              'Valor do parâmetro' +

            '</label>' +

            '<input ' +

              'type="text" ' +

              'class="form-control form-control-sm automator-pagination-editor-action-param-value" ' +

              'placeholder="Valor do parâmetro" ' +

              'autocomplete="off" ' +

              'value="' + escapeHtml(param.value || '') + '" ' +

            '/>' +

          '</div>' +

          '<span ' +

            'class="d-block" ' +

            'data-bs-toggle="tooltip" ' +

            'data-bs-placement="left" ' +

            'data-bs-title="' +

              (

                isDefault

                  ? 'Parâmetro padrão da rota'

                  : 'Excluir parâmetro'

              ) +

            '"' +

          '>' +

            '<button ' +

              'type="button" ' +

              'class="btn btn-sm btn-danger w-100 automator-pagination-editor-action-param-delete" ' +

              (isDefault ? 'disabled ' : '') +

            '>' +

              (

                isDefault

                  ? 'Parâmetro padrão da rota'

                  : 'Excluir parâmetro'

              ) +

            '</button>' +

          '</span>' +

        '</div>' +

      '</div>'

    );


    list.append(row);


    validateActionParams(item);

    refreshTooltips();


    return row;


  }


  /*
  |--------------------------------------------------------------------------
  | Valida parâmetros
  |--------------------------------------------------------------------------
  */

  function validateActionParams(item) {


    item = $(item);


    const params = {};


    let valid = true;


    item.find(

      selectors.actionParamRow

    ).each(function() {


      const row = $(this);


      const input = row.find(

        selectors.actionParamName

      ).first();


      const name = normalizeParamName(

        input.val()

      );


      if(input.val() != name) {

        input.val(name);

      }


      if(name == '') {

        input.addClass('is-invalid');

        valid = false;

        return;

      }


      if(
        Object.prototype.hasOwnProperty.call(

          params,

          name

        )
      ) {

        input.addClass('is-invalid');

        params[name].addClass('is-invalid');

        valid = false;

        return;

      }


      input.removeClass('is-invalid');


      params[name] = input;


    });


    return valid;


  }


  /*
  |--------------------------------------------------------------------------
  | Configurações da paginação
  |--------------------------------------------------------------------------
  */

  function getPaginationSettingsData() {


    const settings = {};


    $(selectors.editor)
      .find(
        '.automator-pagination-editor-setting'
      )
      .each(function() {


        const input = $(this);


        const name = String(

          input.attr('name') || ''

        ).trim();


        if(
          name == '' ||
          input.hasClass(
            'automator-pagination-editor-actions-value'
          )
        ) {

          return;

        }


        if(input.attr('type') == 'checkbox') {

          settings[name] = input.prop(

            'checked'

          );


          return;

        }


        if(input.attr('type') == 'radio') {


          if(input.prop('checked') === true) {

            settings[name] = input.val();

          }


          return;

        }


        settings[name] = input.val();


      });


    /*
    |--------------------------------------------------------------------------
    | Filtros da consulta
    |--------------------------------------------------------------------------
    */


    settings.where = getPaginationQueryFiltersData();


    return settings;


  }



  /*
  |--------------------------------------------------------------------------
  | Normaliza valores enviados ao controller
  |--------------------------------------------------------------------------
  */

  function normalizePaginationSubmitValue(
    value
  ) {


    if(
      value === undefined ||
      value === null
    ) {

      return '';

    }


    if(Array.isArray(value)) {


      return value.map(function(item) {


        return normalizePaginationSubmitValue(

          item

        );


      });


    }


    if(
      value &&
      typeof value === 'object'
    ) {


      const normalizedValue = {};


      Object.keys(

        value

      ).forEach(function(key) {


        normalizedValue[key] =

          normalizePaginationSubmitValue(

            value[key]

          );


      });


      return normalizedValue;


    }


    if(typeof value === 'boolean') {

      return value;

    }


    return value;


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza booleano para envio
  |--------------------------------------------------------------------------
  */

  function getPaginationSubmitBoolean(
    value,
    defaultValue = false
  ) {


    if(
      value === undefined ||
      value === null ||
      value === ''
    ) {

      return defaultValue === true;

    }


    return normalizeBooleanValue(

      value,

      defaultValue

    );


  }


  /*
  |--------------------------------------------------------------------------
  | Serializa coluna
  |--------------------------------------------------------------------------
  */

  function serializePaginationColumn(
    column = {},
    order = 0
  ) {


    column = normalizePaginationColumnData(

      column

    );


    const values = normalizePlainObject(

      column.values

    );


    const header = normalizePlainObject(

      values.header

    );


    const body = normalizePlainObject(

      values.body

    );


    const currentProps = normalizePlainObject(

      values.props

    );


    const attrs = normalizePlainObject(

      column.attrs

    );


    const canSearch = normalizePlainObject(

      values.canSearch

    );


    const canSort = normalizePlainObject(

      values.canSort

    );


    const search = getPaginationSubmitBoolean(

      canSearch.search !== undefined

        ? canSearch.search

        : column.search,

      false

    );


    const sort = getPaginationSubmitBoolean(

      canSort.sort !== undefined

        ? canSort.sort

        : column.sort,

      false

    );


    const columnID = String(

      column.database_id ||

      column.tbl_sys_paginations_col_ID ||

      ''

    ).trim();


    const access = normalizePaginationAccessValues(

      column.access

    );


    const props = $.extend(

      true,

      {},

      currentProps

    );


    /*
    |--------------------------------------------------------------------------
    | Converte as configurações relacionais para props
    |--------------------------------------------------------------------------
    */

    const relation = normalizePlainObject(

      values.relation

    );


    if(
      String(

        column.type || ''

      ).trim().toLowerCase() == 'relation' ||

      Object.keys(relation).length >= 1
    ) {


      [

        'type',
        'mode',
        'table',
        'column',
        'display',
        'relational-table',
        'relational-column',
        'nullable',
        'empty',

      ].forEach(function(key) {


        if(relation[key] === undefined) {

          return;

        }


        props[key] = normalizePaginationSubmitValue(

          relation[key]

        );


      });


    }


    return {

      id:

        columnID,


      tbl_sys_paginations_col_ID:

        columnID,


      tbl_sys_pagination_ID:

        state.paginationID,


      tbl_sys_field_type_ID:

        String(

          column.type_id ||

          column.tbl_sys_field_type_ID ||

          ''

        ).trim(),


      tbl_sys_paginations_col_name:

        String(

          column.name || ''

        ).trim(),


      tbl_sys_paginations_col_title:

        String(

          column.label ||

          column.title ||

          ''

        ).trim(),


      tbl_sys_paginations_col_header:

        normalizePaginationSubmitValue(

          header

        ),


      tbl_sys_paginations_col_body:

        normalizePaginationSubmitValue(

          body

        ),


      tbl_sys_paginations_col_props:

        normalizePaginationSubmitValue(

          props

        ),


      tbl_sys_paginations_col_attrs:

        normalizePaginationSubmitValue(

          attrs

        ),


      tbl_sys_paginations_col_search:

        search,


      tbl_sys_paginations_col_sort:

        sort,


      tbl_sys_paginations_col_ordem:

        parseInt(

          order,

          10

        ) || 0,


      tbl_sys_paginations_col_args:

        normalizePaginationSubmitValue(

          values

        ),


      access:

        access,


      user_types:

        access,


      cols_access:

        access,


      field_type:

        String(

          column.type || ''

        ).trim(),


      field_type_title:

        String(

          column.type_title || ''

        ).trim(),


      icon:

        String(

          column.icon || ''

        ).trim(),


      is_action_buttons_column:

        column.isActionButtonsColumn === true,


      buttons:

        normalizeArrayValue(

          column.buttons

        ),

    };


  }


  /*
  |--------------------------------------------------------------------------
  | Serializa botões da paginação
  |--------------------------------------------------------------------------
  */

  function serializePaginationButtons(
    scope = 'actions'
  ) {


    return getPaginationButtonsData(

      scope

    ).map(function(buttonData) {


      buttonData = createPaginationButtonData(

        buttonData

      );


      return {

        type:

          String(

            buttonData.type || 'button'

          ).trim(),


        action:

          String(

            buttonData.action || ''

          ).trim(),


        id:

          normalizePaginationButtonSlug(

            buttonData.id

          ),


        class:

          String(

            buttonData.class || ''

          ).trim(),


        icon:

          normalizePaginationButtonIcon(

            buttonData.icon

          ),


        text:

          String(

            buttonData.text || ''

          ).substring(

            0,

            255

          ),


        onclick:

          String(

            buttonData.onclick || ''

          ),

      };


    });


  }



  /*
  |--------------------------------------------------------------------------
  | Formata os dados para envio ao controller
  |--------------------------------------------------------------------------
  */

  function formatPaginationEditorSubmitData() {


    const settings = normalizePlainObject(

      getPaginationSettingsData()

    );


    const paginationID = String(

      state.paginationID || ''

    ).trim();


    const tableName = String(

      $(selectors.table).val() || ''

    ).trim();


    const indexName = String(

      $(selectors.index).val() || ''

    ).trim();


    const actions = normalizePlainObject(

      getActionsData()

    );


    const headerActions = serializePaginationButtons(

      'header'

    );


    const listActions = serializePaginationButtons(

      'actions'

    );


    const columns = getColumnsData()
      .filter(function(column) {


        column = normalizePaginationColumnData(

          column

        );


        return column.isActionButtonsColumn !== true;


      })
      .map(function(
        column,
        index
      ) {


        return serializePaginationColumn(

          column,

          index

        );


      });


    const pagination = {

      tbl_sys_pagination_ID:

        paginationID,


      tbl_sys_pagination_name:

        String(

          settings.tbl_sys_pagination_name || ''

        ).trim(),


      tbl_sys_pagination_route:

        String(

          settings.tbl_sys_pagination_route || ''

        ).trim(),


      tbl_sys_pagination_title:

        String(

          settings.tbl_sys_pagination_title ||

          $('#tbl_sys_pagination_title').val() ||

          ''

        ).trim(),


      tbl_sys_pagination_table:

        tableName,


      tbl_sys_pagination_index:

        indexName,


      tbl_sys_pagination_locked:

        getPaginationSubmitBoolean(

          settings.tbl_sys_pagination_locked,

          false

        ),

    };


    const reservedSettings = [

      'id',
      'acao',
      'paginationID',
      'pagination_id',
      'tbl_sys_pagination_ID',
      'tbl_sys_pagination_name',
      'tbl_sys_pagination_route',
      'tbl_sys_pagination_title',
      'tbl_sys_pagination_table',
      'tbl_sys_pagination_index',
      'tbl_sys_pagination_locked',
      'actions',
      'header_actions',
      'list_actions',
      'columns',
      'cols',
      'pagination',
      'pagination_args',
      'pagination_cols',

    ];


    const paginationArgs = {};


    Object.keys(

      settings

    ).forEach(function(settingName) {


      if(
        reservedSettings.indexOf(
          settingName
        ) >= 0
      ) {

        return;

      }


      paginationArgs[settingName] =

        normalizePaginationSubmitValue(

          settings[settingName]

        );


    });


    paginationArgs.page_name = String(

      paginationArgs.page_name ||

      pagination.tbl_sys_pagination_route ||

      pagination.tbl_sys_pagination_name ||

      ''

    ).trim();


    paginationArgs.per_page = parseInt(

      paginationArgs.per_page ||

      settings.tbl_sys_pagination_per_page ||

      settings.pagination_per_page ||

      15,

      10

    );


    if(
      !Number.isFinite(
        paginationArgs.per_page
      ) ||
      paginationArgs.per_page <= 0
    ) {

      paginationArgs.per_page = 15;

    }


    paginationArgs.actions = actions;

    paginationArgs.header_actions = headerActions;

    paginationArgs.list_actions = listActions;


    const payload = {

      id:

        paginationID,


      paginationID:

        paginationID,


      pagination_id:

        paginationID,


      tbl_sys_pagination_ID:

        paginationID,


      acao:

        state.isNew === true

          ? 'store'

          : 'update',


      editorAction:

        state.isNew === true

          ? 'store'

          : 'update',


      pagination:

        pagination,


      pagination_args:

        paginationArgs,


      pagination_cols:

        columns,


      columns:

        columns,


      cols:

        columns,

    };


    /*
    |--------------------------------------------------------------------------
    | Compatibilidade com o formato plano atual
    |--------------------------------------------------------------------------
    */

    Object.keys(

      pagination

    ).forEach(function(key) {


      payload[key] = pagination[key];


    });


    Object.keys(

      paginationArgs

    ).forEach(function(key) {


      payload[key] = paginationArgs[key];


    });


    payload.actions = actions;

    payload.header_actions = headerActions;

    payload.list_actions = listActions;


    return payload;


  }



  /*
  |--------------------------------------------------------------------------
  | Payload completo
  |--------------------------------------------------------------------------
  */

  function serializePaginationEditor() {


    return formatPaginationEditorSubmitData();


  }



  function validatePaginationButtons(
    errors = []
  ) {


    $(selectors.paginationButtonItem).each(function(index) {


      const item = $(this);


      const valid =

        validatePaginationButtonItem(

          item

        );


      if(valid !== true) {


        const buttonID = String(

          item.find(
            selectors.paginationButtonID
          ).val() || ''

        ).trim();


        errors.push(

          'O botão "' +

          (

            buttonID ||

            index + 1

          ) +

          '" possui configurações inválidas.'

        );


      }


    });


    return errors;


  }


  /*
  |--------------------------------------------------------------------------
  | Valor do registro
  |--------------------------------------------------------------------------
  */

  function getPaginationRecordValue(
    recordData,
    keys = [],
    defaultValue = ''
  ) {


    recordData = normalizePlainObject(

      recordData

    );


    if(!Array.isArray(keys)) {

      keys = [

        keys

      ];

    }


    for(
      let index = 0;
      index < keys.length;
      index++
    ) {


      const key = String(

        keys[index] || ''

      ).trim();


      if(key == '') {

        continue;

      }


      if(
        Object.prototype.hasOwnProperty.call(

          recordData,

          key

        ) &&
        recordData[key] !== undefined &&
        recordData[key] !== null
      ) {

        return recordData[key];

      }


      if(key.indexOf('.') < 0) {

        continue;

      }


      const pathParts = key.split('.');

      let currentValue = recordData;

      let pathFound = true;


      for(
        let pathIndex = 0;
        pathIndex < pathParts.length;
        pathIndex++
      ) {


        const pathPart = pathParts[pathIndex];


        if(
          currentValue === null ||
          currentValue === undefined ||
          typeof currentValue !== 'object' ||
          !Object.prototype.hasOwnProperty.call(

            currentValue,

            pathPart

          )
        ) {

          pathFound = false;

          break;

        }


        currentValue = currentValue[pathPart];


      }


      if(
        pathFound === true &&
        currentValue !== undefined &&
        currentValue !== null
      ) {

        return currentValue;

      }


    }


    return defaultValue;


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza os valores recebidos de uma coluna
  |--------------------------------------------------------------------------
  */

  function normalizePaginationRecordColumnValues(
    recordColumn = {}
  ) {


    recordColumn = normalizePlainObject(

      recordColumn

    );


    const args = normalizePlainObject(

      recordColumn.tbl_sys_paginations_col_args ||

      recordColumn.args ||

      recordColumn.values ||

      {}

    );


    const header = normalizePlainObject(

      recordColumn.tbl_sys_paginations_col_header ||

      recordColumn.header ||

      args.header ||

      {}

    );


    const body = normalizePlainObject(

      recordColumn.tbl_sys_paginations_col_body ||

      recordColumn.body ||

      args.body ||

      {}

    );


    const props = normalizePlainObject(

      recordColumn.tbl_sys_paginations_col_props ||

      recordColumn.props ||

      args.props ||

      {}

    );


    const values = $.extend(

      true,

      {},

      args

    );


    values.header = $.extend(

      true,

      {},

      normalizePlainObject(

        values.header

      ),

      header

    );


    values.body = $.extend(

      true,

      {},

      normalizePlainObject(

        values.body

      ),

      body

    );


    values.props = $.extend(

      true,

      {},

      normalizePlainObject(

        values.props

      ),

      props

    );


    /*
    |--------------------------------------------------------------------------
    | Normaliza as configurações relacionais
    |--------------------------------------------------------------------------
    |
    | As paginações existentes armazenam as propriedades relacionais
    | diretamente em tbl_sys_paginations_col_props. O editor utiliza o grupo
    | values.relation, portanto os dois formatos precisam ser aceitos.
    |
    */

    const currentRelation = normalizePlainObject(

      values.relation

    );


    const propsRelation = normalizePlainObject(

      props.relation

    );


    const relation = $.extend(

      true,

      {},

      propsRelation,

      currentRelation

    );


    const relationKeys = [

      'type',
      'mode',
      'table',
      'column',
      'display',
      'relational-table',
      'relational-column',
      'nullable',
      'empty',

    ];


    relationKeys.forEach(function(key) {


      if(
        relation[key] !== undefined &&
        relation[key] !== null &&
        relation[key] !== ''
      ) {

        return;

      }


      if(
        props[key] !== undefined &&
        props[key] !== null
      ) {

        relation[key] = props[key];

      }


    });


    /*
    |--------------------------------------------------------------------------
    | Compatibilidade com nomes alternativos
    |--------------------------------------------------------------------------
    */

    if(
      relation.table === undefined ||
      relation.table === null ||
      relation.table === ''
    ) {

      relation.table =

        props.table ||

        props['relation-table'] ||

        props.relational_table ||

        '';

    }


    if(
      relation.column === undefined ||
      relation.column === null ||
      relation.column === ''
    ) {

      relation.column =

        props.column ||

        props.value ||

        props.key ||

        props['relation-column'] ||

        props.relational_column ||

        '';

    }


    if(
      relation.display === undefined ||
      relation.display === null ||
      relation.display === ''
    ) {

      relation.display =

        props.display ||

        props.label ||

        props.title ||

        props['display-column'] ||

        '';

    }


    if(
      relation['relational-table'] === undefined ||
      relation['relational-table'] === null ||
      relation['relational-table'] === ''
    ) {

      relation['relational-table'] =

        props['relational-table'] ||

        props.relational_table ||

        props.label_table ||

        '';

    }


    if(
      relation['relational-column'] === undefined ||
      relation['relational-column'] === null ||
      relation['relational-column'] === ''
    ) {

      relation['relational-column'] =

        props['relational-column'] ||

        props.relational_column ||

        props.label_column ||

        props.label_value ||

        '';

    }


    if(
      relation.type === undefined ||
      relation.type === null ||
      relation.type === ''
    ) {

      relation.type =

        props.type ||

        'single';

    }


    if(
      relation.mode === undefined ||
      relation.mode === null ||
      relation.mode === ''
    ) {

      relation.mode =

        props.mode ||

        'revert';

    }


    if(
      relation.nullable === undefined &&
      props.nullable !== undefined
    ) {

      relation.nullable = props.nullable;

    }


    if(
      relation.empty === undefined &&
      props.empty !== undefined
    ) {

      relation.empty = props.empty;

    }


    if(Object.keys(relation).length >= 1) {

      values.relation = relation;

    }


    /*
    |--------------------------------------------------------------------------
    | Busca
    |--------------------------------------------------------------------------
    */

    if(
      !values.canSearch ||
      typeof values.canSearch !== 'object' ||
      Array.isArray(values.canSearch)
    ) {

      values.canSearch = {};

    }


    if(
      values.canSearch.search === undefined
    ) {

      values.canSearch.search = normalizeBooleanValue(

        recordColumn.tbl_sys_paginations_col_search !== undefined

          ? recordColumn.tbl_sys_paginations_col_search

          : recordColumn.search,

        false

      );

    }


    /*
    |--------------------------------------------------------------------------
    | Ordenação
    |--------------------------------------------------------------------------
    */

    if(
      !values.canSort ||
      typeof values.canSort !== 'object' ||
      Array.isArray(values.canSort)
    ) {

      values.canSort = {};

    }


    if(
      values.canSort.sort === undefined
    ) {

      values.canSort.sort = normalizeBooleanValue(

        recordColumn.tbl_sys_paginations_col_sort !== undefined

          ? recordColumn.tbl_sys_paginations_col_sort

          : recordColumn.sort,

        false

      );

    }


    return values;


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza coluna recebida
  |--------------------------------------------------------------------------
  */

  function normalizePaginationRecordColumn(
    recordColumn = {},
    order = 0
  ) {


    recordColumn = normalizePlainObject(

      recordColumn

    );


    const attrs = normalizePlainObject(

      recordColumn.tbl_sys_paginations_col_attrs ||

      recordColumn.attrs ||

      {}

    );


    const values = normalizePaginationRecordColumnValues(

      recordColumn

    );


    let fieldPagination = normalizePlainObject(

      recordColumn.pagination ||

      recordColumn.tbl_sys_field_type_pagination ||

      {}

    );


    fieldPagination = normalizePaginationDefinition(

      fieldPagination

    );


    const typeName = String(

      recordColumn.field_type ||

      recordColumn.tbl_sys_field_type_name ||

      recordColumn.type ||

      ''

    ).trim();


    return normalizePaginationColumnData({

      id:

        recordColumn.uid ||

        recordColumn.editor_id ||

        'pagination-column-' +

        Date.now() +

        '-' +

        order +

        '-' +

        Math.floor(

          Math.random() * 999999

        ),


      database_id:

        recordColumn.tbl_sys_paginations_col_ID ||

        recordColumn.id ||

        '',


      type_id:

        recordColumn.tbl_sys_field_type_ID ||

        recordColumn.field_type_id ||

        '',


      type:

        typeName,


      icon:

        recordColumn.icon ||

        recordColumn.tbl_sys_field_type_icon ||

        (

          typeName == 'relation'

            ? 'sync-alt'

            : 'table-columns'

        ),


      type_title:

        recordColumn.field_type_title ||

        recordColumn.tbl_sys_field_type_title ||

        recordColumn.type_title ||

        recordColumn.title ||

        'Coluna',


      title:

        recordColumn.field_type_title ||

        recordColumn.tbl_sys_field_type_title ||

        recordColumn.type_title ||

        'Coluna',


      name:

        recordColumn.tbl_sys_paginations_col_name ||

        recordColumn.name ||

        recordColumn.column ||

        '',


      label:

        recordColumn.tbl_sys_paginations_col_title ||

        recordColumn.label ||

        recordColumn.title ||

        'Coluna',


      pagination:

        fieldPagination,


      values:

        values,


      attrs:

        attrs,


      access:

        recordColumn.access ||

        recordColumn.user_types ||

        recordColumn.users_types ||

        recordColumn.tbl_users_types ||

        recordColumn.cols_access ||

        [],


      isActionButtonsColumn:

        normalizeBooleanValue(

          recordColumn.is_action_buttons_column ||

          recordColumn.isActionButtonsColumn,

          false

        ),


      buttons:

        normalizeArrayValue(

          recordColumn.buttons

        ),

    });


  }


  /*
  |--------------------------------------------------------------------------
  | Aplica registro no editor
  |--------------------------------------------------------------------------
  */

  function applyPaginationEditorRecordData(
    recordData = {},
    callback = null
  ) {


    recordData = normalizePlainObject(

      recordData

    );


    state.applyingRecordData = true;

    state.suppressChangeTracking = true;


    const recordPaginationID = String(

      getPaginationRecordValue(

        recordData,

        [

          'tbl_sys_pagination_ID',
          'paginationID',
          'pagination_id',
          'id',

        ],

        state.paginationID

      ) || ''

    ).trim();


    if(recordPaginationID != '') {

      state.paginationID = recordPaginationID;

      state.isNew = false;

      state.acao = 'update';

    }


    applyPaginationEditorSecurityResponse(

      $.extend(

        true,

        {},

        state.editorResponse,

        recordData

      )

    );


    $(selectors.editor)
      .find(
        '.automator-pagination-editor-setting'
      )
      .each(function() {


        const input = $(this);


        const name = String(

          input.attr('name') || ''

        ).trim();


        if(
          name == '' ||
          input.hasClass(
            'automator-pagination-editor-actions-value'
          )
        ) {

          return;

        }


        const value = getPaginationRecordValue(

          recordData,

          [

            name,
            'pagination_args.' + name,

          ],

          undefined

        );


        if(
          value === undefined ||
          value === null
        ) {

          return;

        }


        if(input.attr('type') == 'checkbox') {


          input.prop(

            'checked',

            normalizeBooleanValue(

              value,

              false

            )

          );


          return;

        }


        if(input.attr('type') == 'radio') {


          $(selectors.editor)
            .find(
              '[name="' +
              escapeSelectorValue(name) +
              '"]'
            )
            .prop(
              'checked',
              false
            );


          $(selectors.editor)
            .find(
              '[name="' +
              escapeSelectorValue(name) +
              '"]'
            )
            .filter(function() {


              return String(

                $(this).val()

              ) == String(value);


            })
            .prop(
              'checked',
              true
            );


          return;

        }


        input.val(

          value

        );


      });


    const actions = normalizePlainObject(

      getPaginationRecordValue(

        recordData,

        [

          'actions',
          'tbl_sys_pagination_actions',
          'pagination_actions',
          'pagination_args.actions',

        ],

        {}

      )

    );


    $(selectors.actionsManager).each(function() {


      const manager = $(this);


      manager.find(

        selectors.actionsValue

      ).val(

        JSON.stringify(

          actions

        )

      );


    });


    initializeActions();


    /*
    |--------------------------------------------------------------------------
    | Os selects dos botões dependem das ações já carregadas
    |--------------------------------------------------------------------------
    */

    initializePaginationButtons(

      recordData

    );


    const recordColumns = normalizeArrayValue(

      getPaginationRecordValue(

        recordData,

        [

          'columns',
          'cols',
          'pagination_columns',
          'tbl_sys_paginations_cols',

        ],

        []

      )

    );


    $(selectors.structureList).empty();


    recordColumns.forEach(function(
      recordColumn,
      index
    ) {


      const column = normalizePaginationRecordColumn(

        recordColumn,

        index

      );


      if(
        column.isActionButtonsColumn === true
      ) {

        return;

      }


      $(selectors.structureList).append(

        createStructureColumnItem(

          column

        )

      );


    });


    initializeStructureSortable();

    updateStructureEmptyState();

    ensurePaginationActionButtonsColumn();

    renderPaginationPreview();

    syncEditorState();


    state.applyingRecordData = false;

    state.suppressChangeTracking = false;

    state.hasChanges = false;


    setSaveState(

      false

    );


    refreshTooltips();


    if(typeof callback === 'function') {

      callback(

        recordData

      );

    }


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | URL de salvamento
  |--------------------------------------------------------------------------
  */

  function getPaginationEditorSubmitURL() {


    const action = normalizePaginationEditorSubmitAction(

      state.acao,

      state.isNew

    );


    state.acao = action;


    let url = '';


    if(
      typeof window.AutomatorPaginationRoutes !== 'undefined' &&
      window.AutomatorPaginationRoutes
    ) {


      url = String(

        window.AutomatorPaginationRoutes[
          action
        ] ||

        (

          action == 'add'

            ? window.AutomatorPaginationRoutes.store

            : window.AutomatorPaginationRoutes.update

        ) ||

        ''

      ).trim();


    }


    /*
    |--------------------------------------------------------------------------
    | Compatibilidade com rotas globais específicas
    |--------------------------------------------------------------------------
    */

    if(
      url == '' &&
      typeof window.AutomatorRoutes !== 'undefined' &&
      window.AutomatorRoutes
    ) {


      if(action == 'add') {


        url = String(

          window.AutomatorRoutes.apiPaginationsStore ||

          window.AutomatorRoutes.apiPaginationStore ||

          ''

        ).trim();


      } else {


        url = String(

          window.AutomatorRoutes.apiPaginationsUpdate ||

          window.AutomatorRoutes.apiPaginationUpdate ||

          ''

        ).trim();


      }


    }


    /*
    |--------------------------------------------------------------------------
    | Não utiliza apiAdmin como rota de salvamento
    |--------------------------------------------------------------------------
    |
    | apiAdmin é uma rota administrativa genérica e não corresponde ao
    | endpoint responsável por cadastrar ou atualizar uma paginação.
    |
    */

    if(url == '') {

      return '';

    }


    if(url.indexOf('#ID#') >= 0) {


      if(
        action == 'edit' &&
        state.paginationID == ''
      ) {

        return '';

      }


      url = url.replace(

        '#ID#',

        state.paginationID

      );


    }


    return url;


  }


  /*
  |--------------------------------------------------------------------------
  | Envia paginação
  |--------------------------------------------------------------------------
  */

  function submitPaginationEditor() {


    if(state.submitting === true) {

      return false;

    }


    const validation = validatePaginationEditor();


    state.validation = validation;


    if(validation.valid !== true) {


      setSaveState(

        true

      );


      showMessage(

        'Configurações inválidas',

        validation.errors.join('\n')

      );


      return false;

    }


    const submitURL = getPaginationEditorSubmitURL();


    if(submitURL == '') {


      showMessage(

        'Erro',

        'A rota responsável por salvar a paginação não foi encontrada.'

      );


      return false;

    }


    const payload = formatPaginationEditorSubmitData();


    if(
      typeof window.AutomatorCreateSecurityConfirmationModal !== 'function'
    ) {


      showMessage(

        'Erro',

        'A função de confirmação de segurança não foi encontrada.'

      );


      return false;

    }


    /*
    |--------------------------------------------------------------------------
    | Remove tooltips antes de abrir a confirmação
    |--------------------------------------------------------------------------
    |
    | Evita que uma instância de tooltip ainda ativa tente processar seus
    | gatilhos internos durante a criação do segundo modal.
    |
    */

    hideEditorTooltips();


    state.submitting = true;


    $(selectors.saveButton).prop(

      'disabled',

      true

    );


    AutomatorGetActionStatus(function() {


      AutomatorSetActionStatus(

        true,

        function() {


          AutomatorPageLoader(

            'show',

            function() {


              $('#page-loader').css(

                'z-index',

                '1060'

              );


              AutomatorCreateSecurityConfirmationModal({

                type:

                  'pagination-editor-submit',


                title:

                  'Confirmação de Segurança',


                message:

                  'Para salvar esta paginação é necessário confirmar sua senha.',


                keepPageLoaderOnSuccess:

                  true,


                keepPageLoaderOnCancel:

                  false,


                skipSuccessToast:

                  true,


                resetActionStatusOnShown:

                  true,


                resetActionStatusOnCancel:

                  true,


                resetActionStatusOnSuccess:

                  false,


                cancelCallback: function() {


                  state.submitting = false;


                  $('#page-loader').css(

                    'z-index',

                    ''

                  );


                  setSaveState(

                    true

                  );


                  refreshTooltips();


                },


                successCallback: function() {


                  $('#page-loader').css(

                    'z-index',

                    '1085'

                  );


                  performPaginationEditorSubmit(

                    submitURL,

                    payload

                  );


                },

              });


            }

          );


        }

      );


    });


    return true;


  }


  function performPaginationEditorSubmit(
    submitURL = '',
    payload = {}
  ) {


    submitURL = String(

      submitURL || ''

    ).trim();


    if(submitURL == '') {


      state.submitting = false;


      $('#page-loader').css(

        'z-index',

        ''

      );


      AutomatorPageLoader(

        'hide',

        function() {


          AutomatorSetActionStatus(

            false

          );


          setSaveState(

            true

          );


          refreshTooltips();


        }

      );


      return false;

    }


    $.ajax({

      url: submitURL,

      type: 'POST',

      data: JSON.stringify(

        payload

      ),

      processData: false,

      contentType:

        'application/json; charset=UTF-8',

      headers: {

        'X-CSRF-TOKEN':

          AutomatorGetCSRFToken(),

        'Accept':

          'application/json',

      },

      dataType: 'json',

      success: function(response) {


        const status =

          response &&

          AutomatorNormalizeBoolean(

            response.status

          ) === true;


        if(status === true) {


          /*
          |--------------------------------------------------------------------------
          | A persistência foi concluída
          |--------------------------------------------------------------------------
          |
          | Remove todos os observadores antes de criar o toast. Dessa maneira,
          | tanto o fechamento manual do toast quanto seu fechamento automático
          | podem recarregar a página sem apresentar confirmação de saída.
          |
          */

          clearPaginationEditorChangesAfterSubmit();


          AutomatorCreateAutoCloseToastAlert(

            'automator-pagination-editor-save-success-' +

            Date.now(),

            'center',

            'middle',

            true,

            true,

            response.title ||

            'Sucesso',

            response.message ||

            'Paginação salva com sucesso.',

            null,

            false,

            function() {


              removeBeforeUnloadWarning();


              $(window).off(

                'beforeunload.AutomatorModalFormChanged'

              );


              $(window).off(

                'beforeunload.AutomatorPaginationEditorChanged'

              );


              $(window).off(

                'beforeunload.AutomatorSetActionStatus'

              );


              window.location.reload();


            },

            5000

          );


          return;

        }


        state.submitting = false;


        AutomatorCreateAutoCloseToastAlert(

          'automator-pagination-editor-save-error-' +

          Date.now(),

          'center',

          'middle',

          true,

          true,

          response && response.title

            ? response.title

            : 'Atenção',

          response && response.message

            ? response.message

            : 'Não foi possível salvar a paginação.',

          null,

          false,

          function() {


            $('#page-loader').css(

              'z-index',

              ''

            );


            AutomatorPageLoader(

              'hide',

              function() {


                AutomatorSetActionStatus(

                  false

                );


                setSaveState(

                  true

                );


                refreshTooltips();


              }

            );


          },

          5000

        );


      },

      error: function(xhr) {


        state.submitting = false;


        let message =

          'Não foi possível salvar a paginação.';


        if(
          xhr.responseJSON &&
          xhr.responseJSON.message
        ) {

          message =

            xhr.responseJSON.message;

        } else if(xhr.responseText) {

          message =

            xhr.responseText;

        }


        AutomatorCreateAutoCloseToastAlert(

          'automator-pagination-editor-save-request-error-' +

          Date.now(),

          'center',

          'middle',

          true,

          true,

          'Erro',

          message,

          null,

          false,

          function() {


            $('#page-loader').css(

              'z-index',

              ''

            );


            AutomatorPageLoader(

              'hide',

              function() {


                AutomatorSetActionStatus(

                  false

                );


                setSaveState(

                  true

                );


                refreshTooltips();


              }

            );


          },

          5000

        );


      }

    });


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza parâmetro
  |--------------------------------------------------------------------------
  */

  function normalizeParamName(value = '') {


    value = String(value || '');


    if(
      typeof value.normalize === 'function'
    ) {

      value = value
        .normalize('NFD')
        .replace(/[\u0300-\u036f]/g, '');

    }


    return value
      .replace(/[^a-zA-Z0-9_]/g, '')
      .replace(/^[0-9]+/, '');


  }


  function getPaginationActionNameSuggestions(
    currentItem = null,
    searchValue = ''
  ) {


    currentItem = $(currentItem);


    searchValue = normalizeActionName(

      searchValue

    );


    const defaultSuggestions = [

      'get',
      'add',
      'edit',
      'delete',

    ];


    const usedNames = [];


    $(selectors.actionItem).each(function() {


      const item = $(this);


      if(
        currentItem.length &&
        item[0] === currentItem[0]
      ) {

        return;

      }


      const actionName = normalizeActionName(

        item.find(
          selectors.actionName
        ).val()

      );


      if(actionName != '') {

        usedNames.push(

          actionName

        );

      }


    });


    return defaultSuggestions.filter(function(suggestion) {


      if(
        usedNames.indexOf(
          suggestion
        ) >= 0
      ) {

        return false;

      }


      if(
        searchValue != '' &&
        suggestion.indexOf(
          searchValue
        ) < 0
      ) {

        return false;

      }


      return true;


    });


  }


  function ensurePaginationActionNameAutocomplete(
    item
  ) {


    item = $(item);


    if(!item.length) {

      return false;

    }


    const input = item.find(

      selectors.actionName

    ).first();


    if(!input.length) {

      return false;

    }


    let wrapper = input.closest(

      '.automator-pagination-editor-action-name-wrapper'

    );


    if(!wrapper.length) {


      input.wrap(

        '<div class="' +

          'position-relative ' +

          'automator-pagination-editor-action-name-wrapper' +

        '"></div>'

      );


      wrapper = input.closest(

        '.automator-pagination-editor-action-name-wrapper'

      );


    }


    if(
      !wrapper.find(
        '.automator-pagination-editor-action-name-results'
      ).length
    ) {


      wrapper.append(

        '<div class="' +

          'automator-pagination-editor-action-name-results ' +

          'position-absolute start-0 end-0 bg-white border ' +

          'rounded shadow d-none' +

        '" style="' +

          'bottom: calc(100% + 4px); ' +

          'max-height: 180px; ' +

          'overflow-y: auto; ' +

          'z-index: 1090;' +

        '"></div>'

      );


    }


    return true;


  }


  function renderPaginationActionNameSuggestions(
    input
  ) {


    input = $(input);


    const item = input.closest(

      selectors.actionItem

    );


    if(!item.length) {

      return false;

    }


    ensurePaginationActionNameAutocomplete(

      item

    );


    const results = item.find(

      '.automator-pagination-editor-action-name-results'

    ).first();


    const searchValue = normalizeActionName(

      input.val()

    );


    /*
    |--------------------------------------------------------------------------
    | Exibe sugestões somente após digitar ao menos um caractere
    |--------------------------------------------------------------------------
    */

    if(searchValue.length < 1) {


      results
        .empty()
        .addClass(
          'd-none'
        );


      return false;


    }


    const suggestions = getPaginationActionNameSuggestions(

      item,

      searchValue

    );


    if(suggestions.length <= 0) {


      results
        .empty()
        .addClass(
          'd-none'
        );


      return false;


    }


    let html = '';


    suggestions.forEach(function(suggestion) {


      html +=

        '<button ' +

          'type="button" ' +

          'class="' +

            'btn btn-sm btn-light border-0 rounded-0 ' +

            'w-100 text-start ' +

            'automator-pagination-editor-action-name-result' +

          '" ' +

          'data-action-name="' +

            escapeHtml(suggestion) +

          '"' +

        '>' +

          escapeHtml(suggestion) +

        '</button>';


    });


    results
      .html(
        html
      )
      .removeClass(
        'd-none'
      );


    return true;


  }


  function bindPaginationActionNameAutocompleteEvents() {


    $(document)
      .off(
        'keyup.automator-pagination-editor-action-name-autocomplete ' +
        'input.automator-pagination-editor-action-name-autocomplete',
        selectors.actionName
      )
      .on(
        'keyup.automator-pagination-editor-action-name-autocomplete ' +
        'input.automator-pagination-editor-action-name-autocomplete',
        selectors.actionName,
        function() {


          renderPaginationActionNameSuggestions(

            this

          );


        }
      );


    $(document)
      .off(
        'focus.automator-pagination-editor-action-name-autocomplete',
        selectors.actionName
      )
      .on(
        'focus.automator-pagination-editor-action-name-autocomplete',
        selectors.actionName,
        function() {


          const input = $(this);


          const searchValue = normalizeActionName(

            input.val()

          );


          if(searchValue.length < 1) {


            const item = input.closest(

              selectors.actionItem

            );


            ensurePaginationActionNameAutocomplete(

              item

            );


            item.find(

              '.automator-pagination-editor-action-name-results'

            )
              .empty()
              .addClass(
                'd-none'
              );


          }


        }
      );


    $(document)
      .off(
        'mousedown.automator-pagination-editor-action-name-result',
        '.automator-pagination-editor-action-name-result'
      )
      .on(
        'mousedown.automator-pagination-editor-action-name-result',
        '.automator-pagination-editor-action-name-result',
        function(event) {


          event.preventDefault();

          event.stopPropagation();

          event.stopImmediatePropagation();


          const result = $(this);


          const item = result.closest(

            selectors.actionItem

          );


          const manager = item.closest(

            selectors.actionsManager

          );


          const input = item.find(

            selectors.actionName

          ).first();


          const routeSelect = item.find(

            selectors.actionRoute

          ).first();


          const selectedActionName = normalizeActionName(

            result.attr(

              'data-action-name'

            ) || ''

          );


          if(
            !item.length ||
            !manager.length ||
            !input.length ||
            selectedActionName == ''
          ) {

            return false;

          }


          input.val(

            selectedActionName

          );


          item.find(

            '.automator-pagination-editor-action-name-results'

          )
            .empty()
            .addClass(
              'd-none'
            );


          input.trigger(

            'blur'

          );


          updatePaginationActionCardHeader(

            item

          );


          const actionNameValid = validateActionName(

            manager,

            item

          );


          if(actionNameValid === true) {


            item.attr(

              'data-action-current-name',

              selectedActionName

            );


          }


          syncActionsValue(

            manager

          );


          updatePaginationButtonActionOptions();

          syncPaginationButtonsState();

          syncEditorState();

          setSaveState(

            true

          );


          setTimeout(function() {


            item.find(

              '.automator-pagination-editor-action-name-results'

            )
              .empty()
              .addClass(
                'd-none'
              );


            if(
              routeSelect.length &&
              routeSelect.prop(
                'disabled'
              ) !== true
            ) {

              routeSelect.trigger(

                'focus'

              );

            }


          }, 0);


          return false;


        }
      );


    $(document)
      .off(
        'click.automator-pagination-editor-action-name-result',
        '.automator-pagination-editor-action-name-result'
      )
      .on(
        'click.automator-pagination-editor-action-name-result',
        '.automator-pagination-editor-action-name-result',
        function(event) {


          event.preventDefault();

          event.stopPropagation();

          event.stopImmediatePropagation();


          return false;


        }
      );


    $(document)
      .off(
        'keydown.automator-pagination-editor-action-name-autocomplete',
        selectors.actionName
      )
      .on(
        'keydown.automator-pagination-editor-action-name-autocomplete',
        selectors.actionName,
        function(event) {


          if(event.key !== 'Escape') {

            return;

          }


          $(this)
            .closest(
              selectors.actionItem
            )
            .find(
              '.automator-pagination-editor-action-name-results'
            )
            .empty()
            .addClass(
              'd-none'
            );


        }
      );


    $(document)
      .off(
        'click.automator-pagination-editor-action-name-outside'
      )
      .on(
        'click.automator-pagination-editor-action-name-outside',
        function(event) {


          const target = $(

            event.target

          );


          if(
            target.closest(
              '.automator-pagination-editor-action-name-wrapper'
            ).length
          ) {

            return;

          }


          $(

            '.automator-pagination-editor-action-name-results'

          )
            .empty()
            .addClass(
              'd-none'
            );


        }
      );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Sincroniza JSON das ações
  |--------------------------------------------------------------------------
  */

  function syncActionsValue(manager) {


    manager = $(manager);


    const actions = {};


    manager.find(

      selectors.actionItem

    ).each(function() {


      const item = $(this);


      if(
        validateActionName(

          manager,

          item

        ) !== true
      ) {

        return;

      }


      const routeName = String(

        item.find(
          selectors.actionRoute
        ).val() || ''

      ).trim();


      if(routeName == '') {

        return;

      }


      const paramsValid = validateActionParams(

        item

      );


      const rolesValid = validatePaginationActionRoles(

        item

      );


      if(
        paramsValid !== true ||
        rolesValid !== true
      ) {

        return;

      }


      const actionName = normalizeActionName(

        item.find(
          selectors.actionName
        ).val()

      );


      if(actionName == '') {

        return;

      }


      const params = {};


      item.find(

        selectors.actionParamRow

      ).each(function() {


        const row = $(this);


        const inputName = row.find(

          selectors.actionParamName

        ).first();


        if(inputName.hasClass('is-invalid')) {

          return;

        }


        const paramName = normalizeParamName(

          inputName.val()

        );


        if(paramName == '') {

          return;

        }


        params[paramName] = String(

          row.find(
            selectors.actionParamValue
          ).val() || ''

        );


      });


      actions[actionName] = {

        route: routeName,

        params: params,

        roles:

          getPaginationActionRolesData(

            item

          ),

        show:

          String(

            item.find(
              selectors.actionShow
            ).val()

          ) === 'true',

      };


    });


    manager.find(

      selectors.actionsValue

    ).val(

      JSON.stringify(

        actions

      )

    );


    updateActionsEmptyState(

      manager

    );


    updatePaginationButtonActionOptions();

    updatePaginationActionsUsageState();


    /*
    |--------------------------------------------------------------------------
    | Atualiza elementos estáticos dependentes das ações
    |--------------------------------------------------------------------------
    |
    | A existência da ação delete controla:
    |
    | - A coluna de seleção no início da tabela;
    | - O checkbox de seleção geral;
    | - O botão "Excluir Selecionado(s)".
    |
    | A atualização deve ocorrer na própria sincronização das ações, sem
    | depender da criação ou atualização posterior de algum botão.
    |
    */

    if(
      $(selectors.preview).length
    ) {

      renderPaginationPreview();

    }


    return actions;


  }


  function getPaginationDeleteAction() {


    const actions = getActionsData();


    if(
      !actions ||
      typeof actions !== 'object' ||
      Array.isArray(actions)
    ) {

      return null;

    }


    if(
      actions.delete &&
      typeof actions.delete === 'object'
    ) {

      return actions.delete;

    }


    const actionNames = Object.keys(

      actions

    );


    for(
      let index = 0;
      index < actionNames.length;
      index++
    ) {


      const actionName = actionNames[index];


      if(
        normalizeActionName(

          actionName

        ) == 'delete'
      ) {

        return actions[actionName];

      }


    }


    return null;


  }


  function getPaginationSearchableColumns() {


    return getColumnsData()
      .map(function(column) {


        return normalizePaginationColumnData(

          column

        );


      })
      .filter(function(column) {


        return normalizeBooleanValue(

          getNestedValue(

            column.values,

            'canSearch.search',

            getNestedValue(

              column.values,

              'canSearch.canSearch',

              false

            )

          ),

          false

        );


      });


  }


  function renderPaginationPreviewSearchFields() {


    const columns = getPaginationSearchableColumns();


    if(columns.length < 2) {

      return '';

    }


    const dropdownID =

      'automator-pagination-preview-search-dropdown-' +

      Date.now() +

      '-' +

      Math.floor(

        Math.random() * 999999

      );


    let html = '';


    columns.forEach(function(column) {


      column = normalizePaginationColumnData(

        column

      );


      const columnName = String(

        column.name || ''

      ).trim();


      const columnLabel = String(

        column.label ||

        column.title ||

        columnName

      ).trim();


      if(columnName == '') {

        return;

      }


      const checkboxID =

        'automator-pagination-preview-search-in-' +

        String(

          column.id ||

          columnName

        )
          .replace(
            /[^a-zA-Z0-9_-]/g,
            '-'
          );


      html +=

        '<div class="form-check mb-2">' +

          '<input ' +

            'type="checkbox" ' +

            'class="' +

              'form-check-input ' +

              'automator-pagination-editor-preview-search-checkbox' +

            '" ' +

            'id="' +

              escapeHtml(checkboxID) +

            '" ' +

            'value="' +

              escapeHtml(columnName) +

            '" ' +

            'disabled ' +

            'checked ' +

          '/>' +

          '<label ' +

            'class="form-check-label small w-100" ' +

            'for="' +

              escapeHtml(checkboxID) +

            '"' +

          '>' +

            escapeHtml(columnLabel) +

          '</label>' +

        '</div>';


    });


    if(html == '') {

      return '';

    }


    return (

      '<div class="col-12 col-sm-auto">' +

        '<div class="' +

          'dropdown ' +

          'automator-pagination-editor-preview-search-dropdown' +

        '">' +

          '<button ' +

            'type="button" ' +

            'id="' +

              escapeHtml(dropdownID) +

            '" ' +

            'class="' +

              'btn btn-outline-secondary dropdown-toggle w-100' +

            '" ' +

            'data-bs-toggle="dropdown" ' +

            'data-bs-auto-close="outside" ' +

            'aria-expanded="false"' +

          '>' +

            'Buscar por' +

          '</button>' +

          '<div ' +

            'class="dropdown-menu p-2 shadow" ' +

            'aria-labelledby="' +

              escapeHtml(dropdownID) +

            '" ' +

            'style="min-width: 220px;"' +

          '>' +

            html +

          '</div>' +

        '</div>' +

      '</div>'

    );


  }


  function initializePaginationPreviewDropdowns() {


    const preview = document.querySelector(

      selectors.preview

    );


    if(
      !preview ||
      typeof bootstrap === 'undefined' ||
      typeof bootstrap.Dropdown === 'undefined'
    ) {

      return false;

    }


    preview
      .querySelectorAll(
        '[data-bs-toggle="dropdown"]'
      )
      .forEach(function(element) {


        const currentInstance =

          bootstrap.Dropdown.getInstance(

            element

          );


        if(currentInstance) {

          return;

        }


        bootstrap.Dropdown.getOrCreateInstance(

          element

        );


      });


    return true;


  }

  function renderPaginationPreviewActionButton(
    buttonData = {}
  ) {


    buttonData = createPaginationButtonData(

      buttonData

    );


    const configuredActions =

      getPaginationConfiguredActions();


    const valid =

      buttonData.id != '' &&

      buttonData.text != '' &&

      buttonData.action != '' &&

      Object.prototype.hasOwnProperty.call(

        configuredActions,

        buttonData.action

      );


    if(valid !== true) {


      return (

        '<span ' +

          'class="' +

            'automator-pagination-editor-preview-tooltip-wrapper' +

          '" ' +

          'tabindex="0" ' +

          'data-bs-toggle="tooltip" ' +

          'data-bs-trigger="hover focus" ' +

          'data-bs-placement="top" ' +

          'data-bs-title="Configuração incompleta"' +

        '>' +

          '<button ' +

            'type="button" ' +

            'disabled ' +

            'tabindex="-1" ' +

            'aria-disabled="true" ' +

            'class="btn btn-danger btn-sm"' +

          '>' +

            '<i class="fa fa-exclamation-triangle"></i>' +

          '</button>' +

        '</span>'

      );


    }


    let className = String(

      buttonData.class || ''

    ).trim();


    if(className == '') {

      className = 'btn-primary';

    }


    if(
      !/(^|\s)btn(\s|$)/.test(
        className
      )
    ) {

      className =

        'btn ' +

        className;

    }


    if(
      !/(^|\s)btn-sm(\s|$)/.test(
        className
      )
    ) {

      className +=

        ' btn-sm';

    }


    const iconName =

      buttonData.icon != ''

        ? buttonData.icon

        : 'circle';


    const tooltipText =

      buttonData.text != ''

        ? buttonData.text

        : 'Executar ação';


    const tagName =

      buttonData.type == 'link'

        ? 'a'

        : 'button';


    let html =

      '<' +

      tagName +

      ' ';


    if(tagName == 'button') {

      html +=

        'type="button" ';

    } else {

      html +=

        'href="javascript:void(0)" ';

    }


    html +=

      'class="' +

        escapeHtml(className) +

      '" ' +

      'data-bs-toggle="tooltip" ' +

      'data-bs-trigger="hover focus" ' +

      'data-bs-placement="top" ' +

      'data-bs-title="' +

        escapeHtml(tooltipText) +

      '"' +

      '>' +

        '<i class="fa fa-' +

          escapeHtml(iconName) +

        '"></i>' +

      '</' +

      tagName +

      '>';


    return html;


  }


  function renderPaginationPreviewActionsColumn() {


    const buttons = getPaginationButtonsData(

      'actions'

    );


    if(buttons.length <= 0) {

      return {

        header: '',
        body:   '',

      };

    }


    let buttonsHTML = '';


    buttons.forEach(function(buttonData) {


      buttonsHTML +=

        '<span class="' +

          'd-inline-block me-1 mb-1 align-middle' +

        '">' +

          renderPaginationPreviewActionButton(

            buttonData

          ) +

        '</span>';


    });


    return {

      header:

        '<th ' +

          'scope="col" ' +

          'class="fw-semibold text-nowrap text-center"' +

        '>' +

          'Ações' +

        '</th>',


      body:

        '<td class="text-nowrap text-center">' +

          buttonsHTML +

        '</td>',

    };


  }


  /*
  |--------------------------------------------------------------------------
  | Retorna ações
  |--------------------------------------------------------------------------
  */

  function getActionsData() {


    const manager = $(

      selectors.actionsManager

    ).first();


    if(!manager.length) {

      return {};

    }


    const valueField = manager.find(

      selectors.actionsValue

    ).first();


    if(valueField.length) {


      const currentValue = parseJSONValue(

        valueField.val(),

        null

      );


      if(
        currentValue &&
        typeof currentValue === 'object' &&
        !Array.isArray(currentValue)
      ) {

        return currentValue;

      }


    }


    return syncActionsValue(

      manager

    );


  }


  /*
  |--------------------------------------------------------------------------
  | Atualiza estado vazio
  |--------------------------------------------------------------------------
  */

  function updateActionsEmptyState(manager) {


    manager = $(manager);


    const list = manager.find(

      selectors.actionsList

    ).first();


    list.find(

      '.automator-pagination-editor-actions-empty'

    ).remove();


    if(
      list.find(
        selectors.actionItem
      ).length <= 0
    ) {


      list.append(

        '<div class="' +

          'automator-pagination-editor-actions-empty ' +

          'text-muted text-center py-4 small' +

        '">' +

          escapeHtml(

            list.attr('data-empty') ||

            'Nenhuma ação adicionada.'

          ) +

        '</div>'

      );


    }


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Rotas disponíveis
  |--------------------------------------------------------------------------
  */

  function getActionsRoutes(manager) {


    manager = $(manager);


    const script = manager.find(

      '.automator-pagination-editor-actions-routes'

    ).first();


    return parseJSONValue(

      script.text(),

      {}

    );


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza parâmetros salvos
  |--------------------------------------------------------------------------
  */

  function normalizeActionParams(params) {


    if(
      !params ||
      typeof params !== 'object' ||
      Array.isArray(params)
    ) {

      return {};

    }


    return params;


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza booleano
  |--------------------------------------------------------------------------
  */

  function normalizeBooleanValue(
    value,
    defaultValue = false
  ) {


    if(
      value === null ||
      value === undefined ||
      value === ''
    ) {

      return defaultValue;

    }


    return (

      value === true ||

      value === 1 ||

      value === '1' ||

      value === 'true'

    );


  }


  /*
  |--------------------------------------------------------------------------
  | Decodifica JSON
  |--------------------------------------------------------------------------
  */

  function parseJSONValue(
    value,
    defaultValue = {}
  ) {


    if(
      value &&
      typeof value === 'object'
    ) {

      return value;

    }


    if(
      value === null ||
      value === undefined ||
      String(value).trim() == ''
    ) {

      return defaultValue;

    }


    try {

      const decoded = JSON.parse(value);

      return decoded;

    } catch(e) {

      return defaultValue;

    }


  }


  /*
  |--------------------------------------------------------------------------
  | Escapa HTML
  |--------------------------------------------------------------------------
  */

  function escapeHtml(value = '') {


    return $('<div>')
      .text(String(value || ''))
      .html();


  }


  /*
  |--------------------------------------------------------------------------
  | Normaliza estado interno do tooltip
  |--------------------------------------------------------------------------
  */

  function normalizeTooltipInternalState(
    tooltip
  ) {


    if(
      !tooltip ||
      typeof tooltip !== 'object'
    ) {

      return false;

    }


    /*
    |--------------------------------------------------------------------------
    | Bootstrap utiliza Object.values(_activeTrigger)
    |--------------------------------------------------------------------------
    |
    | A propriedade não deve ser recriada depois que a instância já tiver sido
    | descartada. Nessa situação, outras propriedades internas também estarão
    | nulas e a instância não poderá mais ser reutilizada.
    |--------------------------------------------------------------------------
    */


    if(
      tooltip._element === null ||
      tooltip._element === undefined
    ) {

      return false;

    }


    if(
      !tooltip._activeTrigger ||
      typeof tooltip._activeTrigger !== 'object'
    ) {

      tooltip._activeTrigger = {

        click: false,

        focus: false,

        hover: false,

      };

    }


    if(
      !Object.prototype.hasOwnProperty.call(
        tooltip._activeTrigger,
        'click'
      )
    ) {

      tooltip._activeTrigger.click = false;

    }


    if(
      !Object.prototype.hasOwnProperty.call(
        tooltip._activeTrigger,
        'focus'
      )
    ) {

      tooltip._activeTrigger.focus = false;

    }


    if(
      !Object.prototype.hasOwnProperty.call(
        tooltip._activeTrigger,
        'hover'
      )
    ) {

      tooltip._activeTrigger.hover = false;

    }


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Remove somente a representação visual de um tooltip
  |--------------------------------------------------------------------------
  */

  function removePaginationTooltipVisualElement(
    element,
    describedBy = ''
  ) {


    if(element) {

      element.removeAttribute(

        'aria-describedby'

      );

    }


    describedBy = String(

      describedBy || ''

    ).trim();


    if(describedBy != '') {


      const tooltipElement = document.getElementById(

        describedBy

      );


      if(tooltipElement) {

        tooltipElement.remove();

      }


    }


    document
      .querySelectorAll(
        '.tooltip.automator-pagination-editor-tooltip'
      )
      .forEach(function(tooltipElement) {


        const tooltipID = String(

          tooltipElement.id || ''

        ).trim();


        const ownerExists =

          tooltipID != ''

            ? document.querySelector(

                '[aria-describedby="' +

                tooltipID.replace(

                  /\\/g,

                  '\\\\'

                ).replace(

                  /"/g,

                  '\\"'

                ) +

                '"]'

              )

            : null;


        if(
          tooltipID == '' ||
          tooltipID == describedBy ||
          !ownerExists
        ) {

          tooltipElement.remove();

        }


      });


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Descarta um tooltip sem iniciar transição de ocultação
  |--------------------------------------------------------------------------
  */

  function disposeTooltip(
    element
  ) {


    if(!element) {

      return false;

    }


    const describedBy = String(

      element.getAttribute(
        'aria-describedby'
      ) || ''

    ).trim();


    if(
      typeof bootstrap === 'undefined' ||
      typeof bootstrap.Tooltip === 'undefined'
    ) {


      removePaginationTooltipVisualElement(

        element,

        describedBy

      );


      return false;

    }


    let tooltip = null;


    try {


      tooltip = bootstrap.Tooltip.getInstance(

        element

      );


    } catch(error) {


      tooltip = null;


    }


    /*
    |--------------------------------------------------------------------------
    | Não chama tooltip.hide() antes de dispose()
    |--------------------------------------------------------------------------
    |
    | hide() inicia uma transição assíncrona. Se dispose() for executado antes
    | do fim da transição, o Bootstrap limpa _activeTrigger e o callback ainda
    | pendente tenta executar Object.values(null).
    |--------------------------------------------------------------------------
    */


    if(tooltip) {


      try {


        if(tooltip._timeout) {

          clearTimeout(

            tooltip._timeout

          );


          tooltip._timeout = null;

        }


      } catch(error) {}


      try {


        tooltip.dispose();


      } catch(error) {


        /*
        |--------------------------------------------------------------------------
        | A limpeza visual e dos atributos ainda será realizada abaixo
        |--------------------------------------------------------------------------
        */


      }


    }


    removePaginationTooltipVisualElement(

      element,

      describedBy

    );


    return true;


  }


  function createTooltip(
    element,
    forceRecreate = false
  ) {


    if(
      !element ||
      typeof bootstrap === 'undefined' ||
      typeof bootstrap.Tooltip === 'undefined'
    ) {

      return false;

    }


    if(
      !element.hasAttribute(
        'data-bs-toggle'
      ) ||
      element.getAttribute(
        'data-bs-toggle'
      ) != 'tooltip'
    ) {

      return false;

    }


    const title = String(

      element.getAttribute(
        'data-bs-title'
      ) ||

      element.getAttribute(
        'title'
      ) ||

      ''

    ).trim();


    if(title == '') {


      disposeTooltip(

        element

      );


      return false;


    }


    let currentTooltip = null;


    try {


      currentTooltip = bootstrap.Tooltip.getInstance(

        element

      );


    } catch(error) {


      currentTooltip = null;


    }


    if(currentTooltip) {


      const currentTooltipValid =

        normalizeTooltipInternalState(

          currentTooltip

        );


      if(
        forceRecreate === true ||
        currentTooltipValid !== true
      ) {


        disposeTooltip(

          element

        );


        currentTooltip = null;


      } else {


        try {


          if(
            typeof currentTooltip.setContent ===
            'function'
          ) {


            currentTooltip.setContent({

              '.tooltip-inner': title,

            });


          }


        } catch(error) {


          disposeTooltip(

            element

          );


          currentTooltip = null;


        }


      }


    }


    if(currentTooltip) {

      return currentTooltip;

    }


    const editor = document.querySelector(

      selectors.editor

    );


    const modal = editor

      ? editor.closest(
          '.modal'
        )

      : null;


    try {


      const tooltip = new bootstrap.Tooltip(

        element,

        {

          container:

            modal ||

            document.body,

          boundary:

            'clippingParents',

          trigger:

            element.getAttribute(
              'data-bs-trigger'
            ) ||

            'hover focus',

          placement:

            element.getAttribute(
              'data-bs-placement'
            ) ||

            'top',

          customClass:

            'automator-pagination-editor-tooltip',

        }

      );


      normalizeTooltipInternalState(

        tooltip

      );


      return tooltip;


    } catch(error) {


      removePaginationTooltipVisualElement(

        element,

        element.getAttribute(
          'aria-describedby'
        ) || ''

      );


      console.warn(

        'Não foi possível inicializar o tooltip do editor de paginações.',

        error

      );


      return false;


    }


  }


  function refreshTooltips() {


    const editor = document.querySelector(

      selectors.editor

    );


    if(!editor) {

      return false;

    }


    /*
    |--------------------------------------------------------------------------
    | Remove somente tooltips visuais órfãos
    |--------------------------------------------------------------------------
    */


    document
      .querySelectorAll(
        '.tooltip.automator-pagination-editor-tooltip'
      )
      .forEach(function(tooltipElement) {


        const tooltipID = String(

          tooltipElement.id || ''

        ).trim();


        if(tooltipID == '') {

          tooltipElement.remove();

          return;

        }


        const owner = document.querySelector(

          '[aria-describedby="' +

          tooltipID.replace(

            /\\/g,

            '\\\\'

          ).replace(

            /"/g,

            '\\"'

          ) +

          '"]'

        );


        if(!owner) {

          tooltipElement.remove();

        }


      });


    editor
      .querySelectorAll(
        '[data-bs-toggle="tooltip"]'
      )
      .forEach(function(element) {


        createTooltip(

          element,

          false

        );


      });


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Oculta e descarta tooltips ativos do editor
  |--------------------------------------------------------------------------
  */

  function hideEditorTooltips() {


    const editor = document.querySelector(

      selectors.editor

    );


    if(!editor) {

      return false;

    }


    editor
      .querySelectorAll(
        '[data-bs-toggle="tooltip"]'
      )
      .forEach(function(element) {


        disposeTooltip(

          element

        );


      });


    document
      .querySelectorAll(
        '.tooltip.automator-pagination-editor-tooltip'
      )
      .forEach(function(tooltipElement) {


        tooltipElement.remove();


      });


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Mensagens
  |--------------------------------------------------------------------------
  */

  function showMessage(
    title = 'Atenção',
    message = ''
  ) {


    if(
      typeof window.AutomatorCreateAutoCloseToastAlert === 'function'
    ) {


      AutomatorCreateAutoCloseToastAlert(

        'automator-pagination-editor-message-' +
        Date.now(),

        'center',

        'middle',

        true,

        true,

        title,

        message,

        null,

        false,

        null,

        5000

      );


      return true;

    }


    alert(

      title + '\n\n' + message

    );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Estado
  |--------------------------------------------------------------------------
  */

  function getState() {


    return state;


  }



  return {

    config,
    init,
    destroy,

    loadTables,
    loadTableColumns,

    switchLeftTab,
    toggleSidebar,

    showRightPanel,
    openRightConfigTab,

    syncEditorState,
    setEditorActionsEnabled,
    setProprietiesEnabled,
    setAddButtonsEnabled,
    setSaveState,

    initializeColumnTypes,
    initializeActions,
    initializePaginationPreview,
    initializeStructureSortable,

    addPaginationColumnFromType,
    selectPaginationColumn,
    removePaginationColumn,

    renderPaginationPreview,
    renderColumnProperties,

    getColumnsData,
    getActionsData,
    syncActionsValue,

    validatePaginationEditor,
    serializePaginationEditor,
    applyPaginationEditorRecordData,
    submitPaginationEditor,

    clearUnsavedChangesWarning,
    requestCloseEditorModal,

    getState,
    initializePaginationButtons,
    addPaginationButton,
    getPaginationButtonsData,
    syncPaginationButtonsState,
    validatePaginationButtons,
    updatePaginationButtonActionOptions,
    updatePaginationActionsUsageState,
    ensurePaginationActionButtonsColumn,

  };


})();


/*
|--------------------------------------------------------------------------
| Configura o editor
|--------------------------------------------------------------------------
*/

function SysAutomatorConfigPaginationEditor(
  response,
  modalEl,
  modal,
  recordData
) {


  response = (

    response &&
    typeof response === 'object'

  )
    ? response
    : {};


  recordData = (

    recordData &&
    typeof recordData === 'object'

  )
    ? recordData
    : {};


  const responseRecordData = (

    response.data &&
    typeof response.data === 'object' &&
    !Array.isArray(response.data)

  )
    ? response.data
    : {};


  /*
  |--------------------------------------------------------------------------
  | Mantém os dados retornados pela requisição de edição
  |--------------------------------------------------------------------------
  |
  | AutomatorCreateViewModal envia os dados encontrados no parâmetro
  | recordData. Entretanto, esta proteção também aceita response.data para
  | evitar que o editor seja aberto sem os dados caso o formato da resposta
  | da API seja alterado ou chamado diretamente.
  |
  */

  recordData = $.extend(

    true,

    {},

    responseRecordData,

    recordData

  );


  const paginationID =

    recordData.tbl_sys_pagination_ID ||

    recordData.paginationID ||

    recordData.pagination_id ||

    recordData.id ||

    response.paginationID ||

    response.pagination_id ||

    response.tbl_sys_pagination_ID ||

    response.pageID ||

    null;


  let editorAction = String(

    response.editorAction ||

    response.submitAction ||

    response.acao ||

    (

      paginationID
        ? 'edit'
        : 'add'

    )

  )
    .trim()
    .toLowerCase();


  /*
  |--------------------------------------------------------------------------
  | Compatibilidade com nomes antigos
  |--------------------------------------------------------------------------
  */

  if(
    editorAction == 'store' ||
    editorAction == 'create'
  ) {

    editorAction = 'add';

  }


  if(editorAction == 'update') {

    editorAction = 'edit';

  }


  if(
    editorAction != 'add' &&
    editorAction != 'edit'
  ) {

    editorAction = paginationID
      ? 'edit'
      : 'add';

  }


  if(
    typeof window.SysAutomatorPaginationEditor === 'undefined' ||
    !window.SysAutomatorPaginationEditor
  ) {


    $('#page-loader').css(

      'z-index',

      ''

    );


    if(
      typeof window.AutomatorPageLoader === 'function'
    ) {


      AutomatorPageLoader(

        'hide',

        function() {


          if(
            typeof window.AutomatorSetActionStatus === 'function'
          ) {

            AutomatorSetActionStatus(false);

          }


        }

      );


    }


    return false;

  }


  window.__automatorPaginationEditorInitializing = false;

  window.__automatorPaginationEditorInitialized  = false;


  SysAutomatorPaginationEditor.config({

    isNew:

      !paginationID,


    paginationID:

      paginationID,


    acao:

      editorAction,


    editorAction:

      editorAction,


    recordData:

      recordData,


    editorResponse:

      response,

  });


  /*
  |--------------------------------------------------------------------------
  | Inicializa depois da configuração
  |--------------------------------------------------------------------------
  |
  | O seeder atual chama apenas esta função no callback do modal. Portanto,
  | a inicialização deve continuar partindo daqui para preservar o fluxo que
  | já está configurado no sistema.
  |
  */

  return SysAutomatorInitPaginationEditor(

    response,

    modalEl,

    modal,

    recordData

  );


}


/*
|--------------------------------------------------------------------------
| Inicializa o editor
|--------------------------------------------------------------------------
*/

function SysAutomatorInitPaginationEditor(
  response,
  modalEl,
  modal,
  recordData
) {


  if(
    typeof window.SysAutomatorPaginationEditor === 'undefined' ||
    !window.SysAutomatorPaginationEditor
  ) {


    $('#page-loader').css(

      'z-index',

      ''

    );


    if(
      typeof window.AutomatorPageLoader === 'function'
    ) {


      AutomatorPageLoader(

        'hide',

        function() {


          if(
            typeof window.AutomatorSetActionStatus === 'function'
          ) {

            AutomatorSetActionStatus(false);

          }


        }

      );


    }


    return false;

  }


  const editor = $(

    '#automator-pagination-editor-modal'

  );


  if(!editor.length) {


    $('#page-loader').css(

      'z-index',

      ''

    );


    if(
      typeof window.AutomatorPageLoader === 'function'
    ) {


      AutomatorPageLoader(

        'hide',

        function() {


          if(
            typeof window.AutomatorSetActionStatus === 'function'
          ) {

            AutomatorSetActionStatus(false);

          }


        }

      );


    }


    return false;

  }


  const currentState =

    typeof SysAutomatorPaginationEditor.getState === 'function'

      ? SysAutomatorPaginationEditor.getState()

      : null;


  /*
  |--------------------------------------------------------------------------
  | Evita inicialização duplicada
  |--------------------------------------------------------------------------
  */

  if(
    window.__automatorPaginationEditorInitialized === true ||
    (
      currentState &&
      currentState.initialized === true
    )
  ) {


    initializePaginationEditorAfterRender(

      function() {


        $('#page-loader').css(

          'z-index',

          ''

        );


        if(
          typeof window.AutomatorPageLoader === 'function'
        ) {


          AutomatorPageLoader(

            'hide',

            function() {


              if(
                typeof window.AutomatorSetActionStatus === 'function'
              ) {

                AutomatorSetActionStatus(false);

              }


            }

          );


        }


      }

    );


    return true;

  }


  if(
    window.__automatorPaginationEditorInitializing === true
  ) {

    return true;

  }


  window.__automatorPaginationEditorInitializing = true;


  editor.attr(

    'data-automator-pagination-initializing',

    'true'

  );


  $('#page-loader').css(

    'z-index',

    '1085'

  );


  let initializationResult = false;


  try {


    initializationResult =

      SysAutomatorPaginationEditor.init(

        function() {


          window.__automatorPaginationEditorInitializing = false;

          window.__automatorPaginationEditorInitialized  = true;


          editor
            .removeAttr(
              'data-automator-pagination-initializing'
            )
            .attr(
              'data-automator-pagination-initialized',
              'true'
            );


          window.requestAnimationFrame(function() {


            window.requestAnimationFrame(function() {


              initializePaginationEditorAfterRender(

                function() {


                  $('#page-loader').css(

                    'z-index',

                    ''

                  );


                  if(
                    typeof window.AutomatorPageLoader === 'function'
                  ) {


                    AutomatorPageLoader(

                      'hide',

                      function() {


                        if(
                          typeof window.AutomatorSetActionStatus === 'function'
                        ) {

                          AutomatorSetActionStatus(false);

                        }


                      }

                    );


                  } else if(
                    typeof window.AutomatorSetActionStatus === 'function'
                  ) {

                    AutomatorSetActionStatus(false);

                  }


                }

              );


            });


          });


        }

      );


  } catch(error) {


    window.__automatorPaginationEditorInitializing = false;

    window.__automatorPaginationEditorInitialized  = false;


    editor.removeAttr(

      'data-automator-pagination-initializing'

    );


    $('#page-loader').css(

      'z-index',

      ''

    );


    if(
      typeof window.AutomatorPageLoader === 'function'
    ) {


      AutomatorPageLoader(

        'hide',

        function() {


          if(
            typeof window.AutomatorSetActionStatus === 'function'
          ) {

            AutomatorSetActionStatus(false);

          }


        }

      );


    } else if(
      typeof window.AutomatorSetActionStatus === 'function'
    ) {

      AutomatorSetActionStatus(false);

    }


    console.error(

      'Não foi possível inicializar o editor de paginações.',

      error

    );


    return false;

  }


  if(initializationResult === false) {


    window.__automatorPaginationEditorInitializing = false;


    editor.removeAttr(

      'data-automator-pagination-initializing'

    );


    $('#page-loader').css(

      'z-index',

      ''

    );


    if(
      typeof window.AutomatorPageLoader === 'function'
    ) {


      AutomatorPageLoader(

        'hide',

        function() {


          if(
            typeof window.AutomatorSetActionStatus === 'function'
          ) {

            AutomatorSetActionStatus(false);

          }


        }

      );


    } else if(
      typeof window.AutomatorSetActionStatus === 'function'
    ) {

      AutomatorSetActionStatus(false);

    }


    return false;

  }


  return true;


}


function initializePaginationEditorAfterRender(
  callback = null
) {


  const editor = document.querySelector(

    '#automator-pagination-editor-modal'

  );


  let finished = false;


  function finish() {


    if(finished === true) {

      return false;

    }


    finished = true;


    if(typeof callback === 'function') {

      callback();

    }


    return true;


  }


  if(!editor) {

    finish();

    return false;

  }


  /*
  |--------------------------------------------------------------------------
  | Aguarda o navegador concluir a montagem visual
  |--------------------------------------------------------------------------
  */

  const images = Array.from(

    editor.querySelectorAll('img')

  );


  const pendingImages = images.filter(function(image) {


    return image.complete !== true;


  });


  if(pendingImages.length <= 0) {


    window.requestAnimationFrame(function() {


      finish();


    });


    return true;

  }


  let completedImages = 0;


  function completeImage() {


    if(finished === true) {

      return false;

    }


    completedImages++;


    if(
      completedImages >= pendingImages.length
    ) {


      window.requestAnimationFrame(function() {


        finish();


      });


    }


    return true;


  }


  pendingImages.forEach(function(image) {


    image.addEventListener(

      'load',

      completeImage,

      {

        once: true,

      }

    );


    image.addEventListener(

      'error',

      completeImage,

      {

        once: true,

      }

    );


  });


  /*
  |--------------------------------------------------------------------------
  | Proteção para recursos que não concluam o carregamento
  |--------------------------------------------------------------------------
  */

  setTimeout(function() {


    finish();


  }, 1000);


  return true;


}


/*
|--------------------------------------------------------------------------
| Destrói o editor
|--------------------------------------------------------------------------
*/

function SysAutomatorDestroyPaginationEditor(
  response,
  modalEl,
  modal,
  recordData
) {


  window.__automatorPaginationEditorInitializing = false;

  window.__automatorPaginationEditorInitialized  = false;


  try {


    if(
      typeof window.SysAutomatorPaginationEditor !== 'undefined' &&
      window.SysAutomatorPaginationEditor
    ) {


      SysAutomatorPaginationEditor.destroy(true);


    }


  } catch(e) {


    console.warn(

      'Editor de paginações já estava destruído ou não foi inicializado.',

      e

    );


  }


  $('#automator-pagination-editor-modal')
    .removeAttr(
      'data-automator-pagination-initializing'
    )
    .removeAttr(
      'data-automator-pagination-initialized'
    );


  $('#page-loader').css(

    'z-index',

    ''

  );


  if(
    typeof window.AutomatorPageLoader === 'function'
  ) {

    AutomatorPageLoader('hide');

  }


  if(
    typeof window.AutomatorSetActionStatus === 'function'
  ) {

    AutomatorSetActionStatus(false);

  }


  if(
    document.querySelectorAll('.modal.show').length <= 0
  ) {


    document.body.classList.remove(

      'modal-open'

    );


    document.body.style.removeProperty(

      'overflow'

    );


    document.body.style.removeProperty(

      'padding-right'

    );


    document
      .querySelectorAll('.modal-backdrop')
      .forEach(function(backdrop) {


        backdrop.remove();


      });


  }


  return true;


}