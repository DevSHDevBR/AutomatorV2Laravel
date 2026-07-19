@php

  $texts   = $texts ?? [];
  $header  = $header ?? [];
  $fields  = $fields ?? [];
  $configs = $configs ?? [];

@endphp

<style type="text/css">

  .automator-view-modal .modal-body {
    overflow: hidden !important;
  }

  #automator-pagination-editor-modal {
    flex-direction: column;
    background: #FFFFFF;
    position: relative;
    overflow: hidden;
    display: flex;
    height: 100vh;
    color: #1E1E1E;
  }

  #automator-pagination-editor-header {
    justify-content: space-between;
    border-bottom: 1px solid #e0e0e0;
    align-items: center;
    flex-shrink: 0;
    background: #ffffff;
    min-height: 65px;
    padding: 0 15px;
    z-index: 1080;
    display: flex;
  }

  #automator-pagination-editor-header-center {
    max-width: 500px;
    margin: 0 20px;
    flex: 1;
  }

  #automator-pagination-editor-header-center input[type='text']:focus {
    box-shadow: unset !important;
  }

  #automator-pagination-editor-body {
    overflow: hidden !important;
    position: relative;
    display: flex;
    flex: 1;
    min-height: 0;
  }

  .automator-pagination-editor-aside {
    flex-direction: column;
    border-right: 1px solid #e0e0e0;
    transition:
      width .3s ease,
      min-width .3s ease,
      max-width .3s ease,
      transform .3s ease,
      opacity .3s ease,
      visibility .3s ease;
    background: #ffffff;
    overflow: hidden !important;
    position: relative;
    z-index: 1030;
    display: flex;
    width: 320px;
    min-width: 320px;
    max-width: 320px;
    flex-shrink: 0;
    height: 100%;
    min-height: 0;
    max-height: 100%;
    opacity: 1;
    visibility: visible;
  }

  #automator-pagination-editor-aside-left {
    position: relative;
  }

  #automator-pagination-editor-aside-left.is-collapsed {
    visibility: hidden;
    transform: translateX(-20px);
    pointer-events: none;
    min-width: 0;
    max-width: 0;
    opacity: 0;
    width: 0;
  }

  #automator-pagination-editor-aside-left-inserter,
  #automator-pagination-editor-aside-left-structure,
  #automator-pagination-editor-aside-left-buttons {
    position: absolute;
    inset: 0;
    background: #ffffff;
    overflow-y: auto !important;
    overflow-x: hidden !important;
    overscroll-behavior: contain;
    z-index: 1031;
    display: block;
    min-height: 0;
    height: 100%;
    width: 100%;
    padding-bottom: 25px;
    transition:
      transform .28s ease,
      opacity .28s ease,
      visibility .28s ease;
  }

  #automator-pagination-editor-aside-left[data-active-tab="inserter"] #automator-pagination-editor-aside-left-inserter {
    visibility: visible;
    transform: translateX(0);
    opacity: 1;
    pointer-events: auto;
  }

  #automator-pagination-editor-aside-left[data-active-tab="inserter"] #automator-pagination-editor-aside-left-structure,
  #automator-pagination-editor-aside-left[data-active-tab="inserter"] #automator-pagination-editor-aside-left-buttons {
    visibility: hidden;
    transform: translateX(100%);
    opacity: 0;
    pointer-events: none;
  }

  #automator-pagination-editor-aside-left[data-active-tab="structure"] #automator-pagination-editor-aside-left-inserter {
    visibility: hidden;
    transform: translateX(-100%);
    opacity: 0;
    pointer-events: none;
  }

  #automator-pagination-editor-aside-left[data-active-tab="structure"] #automator-pagination-editor-aside-left-structure {
    visibility: visible;
    transform: translateX(0);
    opacity: 1;
    pointer-events: auto;
  }

  #automator-pagination-editor-aside-left[data-active-tab="structure"] #automator-pagination-editor-aside-left-buttons {
    visibility: hidden;
    transform: translateX(100%);
    opacity: 0;
    pointer-events: none;
  }

  #automator-pagination-editor-aside-left[data-active-tab="buttons"] #automator-pagination-editor-aside-left-inserter,
  #automator-pagination-editor-aside-left[data-active-tab="buttons"] #automator-pagination-editor-aside-left-structure {
    visibility: hidden;
    transform: translateX(-100%);
    opacity: 0;
    pointer-events: none;
  }

  #automator-pagination-editor-aside-left[data-active-tab="buttons"] #automator-pagination-editor-aside-left-buttons {
    visibility: visible;
    transform: translateX(0);
    opacity: 1;
    pointer-events: auto;
  }

  .automator-pagination-editor-actions-btn.is-active {
    box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
  }

  .automator-pagination-editor-actions-btn:disabled,
  #automator-pagination-editor-header-proprieties-btn:disabled,
  #automator-pagination-editor-header-save-btn:disabled,
  .automator-pagination-editor-buttons-accordions-add:disabled,
  .automator-pagination-editor-action-route:disabled,
  .automator-pagination-editor-action-show:disabled,
  .automator-pagination-editor-action-param-add:disabled,
  .automator-pagination-editor-action-param-delete:disabled,
  .automator-pagination-editor-aside-right-tabs-button:disabled {
    cursor: not-allowed !important;
  }

  .automator-pagination-editor-aside-right-tabs-button:disabled {
    opacity: .65;
  }

  .automator-pagination-editor-control-disabled {
    opacity: .65;
  }

  .automator-pagination-editor-action-item {
    background: #ffffff;
    overflow: hidden;
  }

  .automator-pagination-editor-action-item .form-label {
    line-height: 1.2;
  }

  .automator-pagination-editor-action-item .form-control-sm,
  .automator-pagination-editor-action-item .form-select-sm {
    font-size: .8125rem;
  }

  .automator-pagination-editor-actions-list:empty::before,
  .automator-pagination-editor-action-params-list:empty::before {
    content: attr(data-empty);
    display: block;
    padding: 10px;
    border: 1px dashed #ced4da;
    border-radius: 4px;
    color: #6c757d;
    font-size: 12px;
    text-align: center;
  }

  .automator-pagination-editor-action-param-row {
    background: #f8f9fa;
    border-color: #dee2e6;
  }

  .automator-pagination-editor-action-param-row[data-default-param="true"] {
    background: #f1f3f5;
  }

  .automator-pagination-editor-action-param-row[data-default-param="true"] .automator-pagination-editor-action-param-name {
    background: #e9ecef;
  }

  .automator-pagination-editor-action-param-delete:disabled {
    opacity: .65;
    cursor: not-allowed !important;
  }

  .automator-pagination-editor-column-tooltip {
    cursor: pointer;
  }

  #automator-pagination-editor-aside-right {
    border-right: none;
    border-left: 1px solid #e0e0e0;
    position: relative;
  }

  #automator-pagination-editor-aside-right.is-collapsed {
    visibility: hidden;
    transform: translateX(20px);
    pointer-events: none;
    min-width: 0;
    max-width: 0;
    opacity: 0;
    width: 0;
  }

  #automator-pagination-editor-aside-right-pagination,
  #automator-pagination-editor-aside-right-proprieties {
    position: absolute;
    inset: 0;
    background: #ffffff;
    overflow-y: auto !important;
    overflow-x: hidden !important;
    overscroll-behavior: contain;
    min-height: 0;
    height: 100%;
    width: 100%;
    padding-bottom: 25px;
    visibility: hidden;
    opacity: 0;
    pointer-events: none;
    transition:
      transform .28s ease,
      opacity .28s ease,
      visibility .28s ease;
  }

  #automator-pagination-editor-aside-right-pagination {
    transform: translateX(-100%);
  }

  #automator-pagination-editor-aside-right-proprieties {
    transform: translateX(100%);
  }

  #automator-pagination-editor-aside-right-pagination.is-active,
  #automator-pagination-editor-aside-right-proprieties.is-active {
    visibility: visible;
    transform: translateX(0);
    opacity: 1;
    pointer-events: auto;
  }

  #automator-pagination-editor-aside-right-tabs {
    border-bottom: 1px solid #e0e0e0;
    display: flex;
    flex-shrink: 0;
  }

  .automator-pagination-editor-aside-right-tabs-button {
    border: 0;
    border-bottom: 2px solid transparent;
    background: #ffffff;
    color: #757575;
    flex: 1;
    padding: 12px 8px;
    font-size: 13px;
    font-weight: 600;
  }

  .automator-pagination-editor-aside-right-tabs-button.active {
    border-bottom-color: #0d6efd;
    color: #1e1e1e;
  }

  .automator-pagination-editor-aside-right-tabs-container-item {
    display: none;
  }

  .automator-pagination-editor-aside-right-tabs-container-item.active {
    display: block;
  }

  #automator-pagination-editor-aside-right-tabs-container {
    min-height: 0;
  }

  #automator-pagination-editor-aside-right-content {
    padding-left: 0 !important;
    padding-right: 0 !important;
  }

  #automator-pagination-editor-aside-right-content .accordion {
    margin-left: 0 !important;
    margin-right: 0 !important;
  }

  #automator-pagination-editor-aside-right-content .accordion-item {
    border-left: 0 !important;
    border-right: 0 !important;
    border-radius: 0 !important;
  }

  #automator-pagination-editor-aside-right-content .accordion-button {
    border-radius: 0 !important;
    box-shadow: none !important;
  }

  #automator-pagination-editor-aside-right-content > .mb-3,
  #automator-pagination-editor-aside-right-content > .text-muted {
    padding-left: 15px;
    padding-right: 15px;
  }

  #automator-pagination-editor-canvas {
    background-color: #f0f0f0;
    overflow-y: auto !important;
    overflow-x: auto !important;
    padding: 20px;
    flex: 1;
    min-width: 0;
    min-height: 0;
    box-sizing: border-box;
  }

  #automator-pagination-editor-canvas-container {
    background: #ffffff;
    min-height: 100%;
    width: 100%;
    max-width: none;
    margin: 0;
    box-sizing: border-box;
  }

  #automator-pagination-editor-modal.is-sidebars-hidden #automator-pagination-editor-canvas-container {
    max-width: none !important;
  }

  #automator-pagination-editor-modal.is-preview-mode #automator-pagination-editor-canvas {
    overflow-x: auto !important;
    overflow-y: auto !important;
  }

  #automator-pagination-editor-header-viewport-label {
    min-width: 34px;
    display: inline-block;
    text-align: center;
  }

  #automator-pagination-editor-canvas-container > .container-fluid {
    padding-left: 0 !important;
    padding-right: 0 !important;
  }

  #automator-pagination-editor-canvas-container-content {
    min-height: 100%;
    height: 100%;
    width: 100%;
  }

  .automator-pagination-editor-preview {
    min-height: 100%;
  }

  .automator-pagination-editor-preview-message {
    min-height: 420px;
  }

  .automator-pagination-editor-preview-card {
    width: 100%;
    min-height: 100%;
    background: #ffffff;
  }

  #automator-pagination-editor-aside-left-structure-list {
    min-height: 100%;
  }

  .automator-pagination-editor-structure-empty {
    pointer-events: none;
  }

  .automator-pagination-editor-column-item {
    cursor: pointer;
    transition:
      background-color .2s ease,
      border-color .2s ease,
      box-shadow .2s ease;
  }

  .automator-pagination-editor-column-item:hover {
    background: #f8f9fa !important;
  }

  .automator-pagination-editor-column-item.is-selected {
    background: #e7f1ff !important;
    box-shadow: inset 4px 0 0 #0d6efd;
  }

  .automator-pagination-editor-column-sort-handle {
    cursor: grab;
  }

  .automator-pagination-editor-column-sort-handle:active {
    cursor: grabbing;
  }

  .automator-pagination-editor-column-sort-ghost {
    min-height: 58px;
    margin: 8px;
    border: 2px dashed #0d6efd !important;
    background: rgba(13, 110, 253, .08) !important;
    opacity: 1 !important;
  }

  .automator-pagination-editor-column-sort-chosen {
    background: #e7f1ff !important;
  }

  .automator-pagination-editor-column-sort-drag {
    box-shadow: 0 8px 25px rgba(0, 0, 0, .18);
  }

  #automator-pagination-editor-preview [data-automator-pagination-preview-column] {
    cursor: pointer;
  }

  #automator-pagination-editor-preview [data-automator-pagination-preview-column]:hover {
    box-shadow: inset 0 0 0 2px rgba(13, 110, 253, .35);
  }

  #automator-pagination-editor-canvas-container-content .gjs-editor {
    min-height: 500px;
  }

  .gjs-cv-canvas {
    width: 100% !important;
    min-height: 500px !important;
    top: 0 !important;
    overflow: hidden !important;
  }

  .gjs-pn-panel {
    display: none !important;
  }

  .automator-pagination-editor-aside-left-inserter-list-item {
    cursor: pointer;
    transition: all 0.2s ease;
    background: #ffffff;
    user-select: none;
    opacity: 1 !important;
  }

  .automator-pagination-editor-aside-left-inserter-list-item:hover {
    border-color: #0d6efd !important;
    color: #0d6efd;
  }

  .automator-editor-body-aside-left-structure-item {
    cursor: pointer;
    background: #ffffff;
  }

  .automator-editor-body-aside-left-structure-item:hover {
    background: #f8f9fa;
  }

  .automator-editor-structure-handle {
    cursor: grab;
  }

  .automator-editor-structure-children {
    min-height: 3px;
  }

  .automator-editor-structure-item-wrapper.is-selected > .automator-editor-body-aside-left-structure-item {
    background: #e7f1ff;
    border-left: 4px solid #0d6efd;
    color: #0d6efd;
  }

  .automator-editor-structure-item-wrapper.is-selected > .automator-editor-body-aside-left-structure-item .fa-cube,
  .automator-editor-structure-item-wrapper.is-selected > .automator-editor-body-aside-left-structure-item .automator-editor-structure-handle {
    color: #0d6efd !important;
  }

  #automator-pagination-editor-modal.is-preview-mode .automator-pagination-editor-aside {
    display: none !important;
    width: 0 !important;
    min-width: 0 !important;
    max-width: 0 !important;
  }

  #automator-pagination-editor-modal.is-preview-mode #automator-pagination-editor-canvas {
    padding-left: 20px;
    padding-right: 20px;
  }

  #automator-pagination-editor-modal.is-preview-mode .automator-editor-preview-disabled {
    opacity: .45;
    pointer-events: none;
  }

  .tooltip.automator-pagination-editor-tooltip {
    pointer-events: none;
  }

  @media (max-width: 991.98px) {

    #automator-pagination-editor-body {
      position: relative;
    }

    #automator-pagination-editor-aside-left,
    #automator-pagination-editor-aside-right {
      position: absolute;
      top: 0;
      bottom: 0;
      height: auto;
      min-height: 0;
      max-height: none;
      width: min(320px, 88vw);
      min-width: min(320px, 88vw);
      max-width: min(320px, 88vw);
      z-index: 1070;
      box-shadow: 0 0 25px rgba(0, 0, 0, .18);
      visibility: hidden;
      opacity: 0;
      pointer-events: none;
    }

    #automator-pagination-editor-aside-left {
      left: 0;
      transform: translateX(-105%);
    }

    #automator-pagination-editor-aside-left.show {
      visibility: visible;
      transform: translateX(0);
      pointer-events: auto;
      opacity: 1;
    }

    #automator-pagination-editor-aside-right {
      right: 0;
      transform: translateX(105%);
    }

    #automator-pagination-editor-aside-right.show {
      visibility: visible;
      transform: translateX(0);
      pointer-events: auto;
      opacity: 1;
    }

    #automator-pagination-editor-aside-left.is-collapsed,
    #automator-pagination-editor-aside-right.is-collapsed {
      width: min(320px, 88vw);
      min-width: min(320px, 88vw);
      max-width: min(320px, 88vw);
    }

  }


  /*
  |--------------------------------------------------------------------------
  | Checkbox e radio estáticos da pré-visualização
  |--------------------------------------------------------------------------
  |
  | Permanecem desabilitados funcionalmente, mas mantêm a aparência normal
  | do Bootstrap e não apresentam cursor de bloqueio.
  |
  */

  #automator-pagination-editor-preview
  .automator-pagination-editor-preview-static-selection.form-check-input:disabled {
    opacity: 1 !important;
    filter: none !important;
    cursor: default !important;
    pointer-events: none !important;
  }

  #automator-pagination-editor-preview
  .automator-pagination-editor-preview-static-selection.form-check-input:disabled:checked {
    background-color: #0d6efd !important;
    border-color: #0d6efd !important;
  }

  #automator-pagination-editor-preview
  .automator-pagination-editor-preview-static-selection.form-check-input:disabled:not(:checked) {
    background-color: #ffffff !important;
    border-color: #adb5bd !important;
  }

  #automator-pagination-editor-preview
  .automator-pagination-editor-preview-search-checkbox.form-check-input:disabled {
    opacity: 1 !important;
    filter: none !important;
    cursor: default !important;
    pointer-events: none !important;
  }

  #automator-pagination-editor-preview
  .automator-pagination-editor-preview-search-checkbox.form-check-input:disabled:checked {
    background-color: #0d6efd !important;
    border-color: #0d6efd !important;
  }

  /*
  |--------------------------------------------------------------------------
  | Tooltip de botão desabilitado
  |--------------------------------------------------------------------------
  |
  | O Bootstrap não recebe eventos diretamente em elementos disabled.
  | O tooltip é colocado em um wrapper que continua recebendo hover/focus.
  |
  */

  #automator-pagination-editor-preview
  .automator-pagination-editor-preview-tooltip-wrapper {
    display: inline-block;
    cursor: help;
  }

  #automator-pagination-editor-preview
  .automator-pagination-editor-preview-tooltip-wrapper > .btn:disabled {
    pointer-events: none !important;
  }

  /*
  |--------------------------------------------------------------------------
  | Dropdown de busca da pré-visualização
  |--------------------------------------------------------------------------
  */

  #automator-pagination-editor-preview
  .automator-pagination-editor-preview-search-dropdown {
    position: relative;
  }

  #automator-pagination-editor-preview
  .automator-pagination-editor-preview-search-dropdown .dropdown-menu {
    z-index: 1095 !important;
  }

</style>

<div id="extracted-json" class="d-none"></div>

<header id="automator-pagination-editor-header">

  <div class="d-flex align-items-center">

    <span
      class="me-2"
      data-automator-pagination-tooltip="true"
      data-automator-pagination-disabled-title="{!! $texts['complete-config'] ?? 'Selecione uma tabela e um índice para adicionar colunas.' !!}"
    >

      <button
        type="button"
        disabled
        class="btn btn-primary automator-pagination-editor-actions-btn"
        data-automator-pagination-left-tab="inserter"
      >

        <i class="fas fa-plus"></i>

      </button>

    </span>

    <span
      class="me-2"
      data-bs-placement="bottom"
      data-bs-toggle="tooltip"
      data-bs-title="{!! $texts['columns'] ?? 'Colunas' !!}"
      data-bs-trigger="hover"
    >

      <button
        type="button"
        class="btn btn-secondary automator-pagination-editor-actions-btn is-active"
        data-automator-pagination-left-tab="structure"
      >

        <i class="fas fa-list"></i>

      </button>

    </span>

    <span
      class="me-2"
      data-automator-pagination-tooltip="true"
      data-automator-pagination-disabled-title="{!! $texts['complete-config'] ?? 'Selecione uma tabela e um índice para acessar os botões.' !!}"
    >

      <button
        type="button"
        disabled
        class="btn btn-danger automator-pagination-editor-actions-btn"
        data-automator-pagination-left-tab="buttons"
      >

        <i class="fas fa-server"></i>

      </button>

    </span>

  </div>

  @if(isset($header['content']))

    <div id="automator-pagination-editor-header-center" class="text-center my-2">

      @if(($header['type'] ?? '') == 'form-input')

        <div class="form-floating">

          <input
            type="{!! $header['content']['type'] ?? 'text' !!}"
            class="form-control border border-secondary bg-light"
            id="{!! $header['content']['id'] ?? '' !!}"
            name="{!! $header['content']['name'] ?? '' !!}"
            placeholder="{!! $header['content']['label'] ?? '' !!}"
            autocomplete="off"
            value="{!! $header['content']['value'] ?? '' !!}"
            {!! ((isset($header['content']['required']) && $header['content']['required'] == true) ? ' required' : '') !!}
          />

          <label for="{!! $header['content']['id'] ?? '' !!}">

            {!! $header['content']['label'] ?? '' !!}

          </label>

        </div>

      @else

        {!! $header['content'] !!}

      @endif

    </div>

  @else

    <div id="automator-pagination-editor-header-center" class="text-center">

      <span class="small fw-bold text-muted">

        {!! $texts['editor'] ?? 'Editor de Paginações' !!}

      </span>

    </div>

  @endif

  <div class="d-flex align-items-center">

    <span
      class="d-inline-block me-2"
      data-bs-placement="bottom"
      data-bs-toggle="tooltip"
      data-bs-trigger="hover"
      data-bs-title="{!! $texts['pagination'] ?? 'Paginação' !!}"
    >

      <button
        id="automator-pagination-editor-header-pagination-btn"
        type="button"
        class="btn btn-warning text-white"
      >

        <i class="fas fa-sitemap"></i>

      </button>

    </span>

    <span
      class="d-inline-block me-2"
      data-automator-pagination-tooltip="true"
      data-automator-pagination-disabled-title="{!! $texts['complete-config'] ?? 'Selecione uma tabela e um índice para acessar as propriedades.' !!}"
    >

      <button
        id="automator-pagination-editor-header-proprieties-btn"
        type="button"
        disabled
        class="btn btn-secondary"
      >

        <i class="fas fa-cog"></i>

      </button>

    </span>

    <span class="d-inline-block">

      <button
        id="automator-pagination-editor-header-save-btn"
        type="button"
        disabled
        class="btn btn-primary px-3"
        style="height: 38px;"
      >

        {!! $texts['save'] ?? 'Salvar' !!}

      </button>

    </span>

  </div>

</header>

<div id="automator-pagination-editor-body">

  <aside
    id="automator-pagination-editor-aside-left"
    class="automator-pagination-editor-aside bg-white"
    data-active-tab="structure"
  >

    <div id="automator-pagination-editor-aside-left-inserter">

      <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light">

        <h6 class="small fw-bold mb-0 text-uppercase">

          {!! $texts['add-column'] ?? 'Adicionar Coluna' !!}

        </h6>

        <button
          type="button"
          class="btn-close d-lg-none"
          onclick="SysAutomatorPaginationEditor.toggleSidebar('left')"
        ></button>

      </div>

      <div
        id="automator-pagination-editor-aside-left-inserter-list"
        class="p-3 pt-0 g-3 row row-cols-2"
      >

        @foreach($fields as $grupo)

          @php

            $groupTitle = $grupo['tbl_sys_field_type_group_title'] ?? $grupo['title'] ?? $grupo['titulo'] ?? 'Grupo';

            $groupFields = $grupo['tbl_sys_field_type_group_fields'] ?? $grupo['fields'] ?? [];

          @endphp

          <div class="col col-sm-12 mt-4 fw-bold small text-muted text-uppercase">

            {!! $groupTitle !!}

          </div>

          @foreach($groupFields as $field)

            @php

              $fieldId = $field['tbl_sys_field_type_ID'] ?? $field['id'] ?? '';

              $fieldName = $field['tbl_sys_field_type_name'] ?? $field['name'] ?? '';

              $fieldTitle = $field['tbl_sys_field_type_title'] ?? $field['title'] ?? $field['titulo'] ?? $fieldName;

              $fieldIcon = $field['tbl_sys_field_type_icon'] ?? $field['icon'] ?? 'square';


              $fieldPagination = $field['pagination'] ?? $field['tbl_sys_field_type_pagination'] ?? [];


              if(is_string($fieldPagination) && trim($fieldPagination) != '') {

                $decodedFieldPagination = json_decode($fieldPagination, true);

                $fieldPagination = is_array($decodedFieldPagination)
                  ? $decodedFieldPagination
                  : [];

              }


              if(!is_array($fieldPagination)) {

                $fieldPagination = [];

              }


              $fieldDescription = $fieldPagination['description'] ?? '';

            @endphp

            <div class="col">

              <div
                data-block-type="{!! $fieldName !!}"
                data-block-icon="{!! $fieldIcon !!}"
                data-block-type-id="{!! $fieldId !!}"
                data-block-pagination="{{ json_encode($fieldPagination, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) }}"
                data-bs-placement="right"
                data-bs-toggle="tooltip"
                data-bs-trigger="hover"
                data-bs-title="{!! e($fieldDescription) !!}"
                class="automator-pagination-editor-column-tooltip automator-pagination-editor-aside-left-inserter-list-item border p-3 text-center rounded mb-2"
              >

                <i class="fa fa-{!! $fieldIcon !!} d-block mb-2 text-primary fs-5"></i>

                <span class="small d-block text-truncate">

                  {!! $fieldTitle !!}

                </span>

              </div>

            </div>

          @endforeach

        @endforeach

      </div>

    </div>

    <div id="automator-pagination-editor-aside-left-structure">

      <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light">

        <h6 class="small fw-bold mb-0 text-uppercase">

          {!! $texts['structure'] ?? 'Estrutura' !!}

        </h6>

        <button
          type="button"
          class="btn-close d-lg-none"
          onclick="SysAutomatorPaginationEditor.toggleSidebar('left')"
        ></button>

      </div>

      <div
        id="automator-pagination-editor-aside-left-structure-list"
        data-empty="{!! $texts['no-blocks-added'] ?? 'Nenhum campo adicionado.' !!}"
      ></div>

    </div>

    <div id="automator-pagination-editor-aside-left-buttons">

      <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light">

        <h6 class="small fw-bold mb-0 text-uppercase">

          {!! $texts['buttons'] ?? 'Botões' !!}

        </h6>

        <button
          type="button"
          class="btn-close d-lg-none"
          onclick="SysAutomatorPaginationEditor.toggleSidebar('left')"
        ></button>

      </div>

      <div id="automator-pagination-editor-aside-left-buttons-accordions">

        <div
          id="automator-pagination-editor-buttons-accordions-header"
          class="accordion automator-pagination-editor-buttons-accordions mx-0"
        >

          <div class="accordion-item border-start-0 border-end-0 rounded-0">

            <h2 class="accordion-header">

              <button
                type="button"
                class="accordion-button py-2 px-3 small fw-bold rounded-0 collapsed"
                data-bs-toggle="collapse"
                data-bs-target="#automator-pagination-editor-buttons-accordions-header-wrapper"
                aria-expanded="false"
              >

                {!! $texts['header'] ?? 'Cabeçalho' !!}

              </button>

            </h2>

            <div
              id="automator-pagination-editor-buttons-accordions-header-wrapper"
              class="accordion-collapse collapse"
              data-empty="{!! $texts['no-buttons-added'] ?? 'Nenhum botão adicionado.' !!}"
            >

              <span
                class="d-table p-3 w-100"
                data-automator-pagination-tooltip="true"
                data-automator-pagination-disabled-title="{!! $texts['actions-required'] ?? 'Cadastre pelo menos uma ação para liberar a criação de botões.' !!}"
              >

                <button
                  type="button"
                  disabled
                  class="d-table w-100 btn btn-outline-primary automator-pagination-editor-buttons-accordions-add"
                >

                  {!! $texts['add-button'] ?? 'Adicionar Botão' !!}

                </button>

              </span>

            </div>

          </div>

        </div>

        <div
          id="automator-pagination-editor-buttons-accordions-actions"
          class="accordion automator-pagination-editor-buttons-accordions mx-0"
        >

          <div class="accordion-item border-start-0 border-end-0 rounded-0">

            <h2 class="accordion-header">

              <button
                type="button"
                class="accordion-button py-2 px-3 small fw-bold rounded-0 collapsed"
                data-bs-toggle="collapse"
                data-bs-target="#automator-pagination-editor-buttons-accordions-actions-wrapper"
                aria-expanded="false"
              >

                {!! $texts['actions'] ?? 'Ações' !!}

              </button>

            </h2>

            <div
              id="automator-pagination-editor-buttons-accordions-actions-wrapper"
              class="accordion-collapse collapse"
              data-empty="{!! $texts['no-buttons-added'] ?? 'Nenhum botão adicionado.' !!}"
            >

              <span
                class="d-table p-3 w-100"
                data-automator-pagination-tooltip="true"
                data-automator-pagination-disabled-title="{!! $texts['actions-required'] ?? 'Cadastre pelo menos uma ação para liberar a criação de botões.' !!}"
              >

                <button
                  type="button"
                  disabled
                  class="d-table w-100 btn btn-outline-primary automator-pagination-editor-buttons-accordions-add"
                >

                  {!! $texts['add-button'] ?? 'Adicionar Botão' !!}

                </button>

              </span>

            </div>

          </div>

        </div>

      </div>

    </div>

  </aside>

  <main id="automator-pagination-editor-canvas">

    <div id="automator-pagination-editor-canvas-container">

      <div
        id="automator-pagination-editor-canvas-container-content"
        class="container-fluid"
      ></div>

    </div>

  </main>

  <aside
    id="automator-pagination-editor-aside-right"
    class="automator-pagination-editor-aside"
  >

    <div id="automator-pagination-editor-aside-right-pagination">

      <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light">

        <h6 class="small fw-bold mb-0 text-uppercase">

          {!! $texts['pagination'] ?? 'Paginação' !!}

        </h6>

        <button
          type="button"
          class="btn-close d-lg-none"
          onclick="SysAutomatorPaginationEditor.toggleSidebar('right')"
        ></button>

      </div>

      @php

        $configsT = is_array($configs)
          ? count($configs)
          : 0;

      @endphp

      @if($configsT >= 1)

        <div id="automator-pagination-editor-aside-right-tabs">

          @foreach($configs as $configIndex => $configContent)

            <button
              type="button"
              id="automator-pagination-editor-aside-right-tabs-button-{!! $configIndex !!}"
              class="automator-pagination-editor-aside-right-tabs-button{!! (($loop->first) ? ' active' : '') !!}"
              data-automator-pagination-right-tab="{!! $configIndex !!}"
              data-automator-pagination-tooltip="true"
              data-automator-pagination-disabled-title="{!! $configContent['disabledText'] ?? SysAutomator::SysAutomatorGetTranslateWord("Conclua as configurações básicas para liberar esta aba.") !!}"
              {!! (
                isset($configContent['disabled']) &&
                $configContent['disabled'] == true
                  ? ' disabled'
                  : ''
              ) !!}
            >

              {!! $configContent['label'] ?? $configIndex !!}

            </button>

          @endforeach

        </div>

        <div id="automator-pagination-editor-aside-right-tabs-container">

          @foreach($configs as $configIndex => $configContent)

            <div
              id="automator-pagination-editor-aside-right-tabs-container-{!! $configIndex !!}"
              class="automator-pagination-editor-aside-right-tabs-container-item{!! (($loop->first) ? ' active' : '') !!}"
              {!! (
                isset($configContent['default']) &&
                $configContent['default'] == true
                  ? ' data-automator-default="true"'
                  : ''
              ) !!}
            >

              @if(isset($configContent['description']))

                @php

                  $description = [

                    'class' => (
                      is_array($configContent['description'])
                        ? ($configContent['description']['class'] ?? 'shadow border-bottom mb-3 border-secondary bg-light')
                        : 'shadow border-bottom mb-3 border-secondary bg-light'
                    ),

                    'content' => (
                      is_array($configContent['description'])
                        ? ($configContent['description']['content'] ?? '')
                        : $configContent['description']
                    )

                  ];

                @endphp

                <div
                  class="d-table w-100 {!! $description['class'] !!} p-3"
                  style="font-size: 14px;"
                >

                  {!! $description['content'] !!}

                </div>

              @endif

              <div class="d-table w-100 p-3">

                @foreach(($configContent['fields'] ?? []) as $configContentFieldKey => $configContentFieldArgs)

                  @php

                    $fieldType = $configContentFieldArgs['type'] ?? 'text';

                    $fieldClass = $configContentFieldArgs['class'] ?? 'form-floating mb-3';

                    $fieldLabel = $configContentFieldArgs['label'] ?? $configContentFieldKey;
                    
                    $fieldPlacehold = ( (isset($configContentFieldArgs['placeholder'])) ? $configContentFieldArgs['placeholder'] : ( ($configContentFieldArgs['label']) ? $configContentFieldArgs['label'] :  $configContentFieldKey) );

                    $fieldName = $configContentFieldArgs['name'] ?? $configContentFieldKey;

                    $fieldValue = $configContentFieldArgs['value'] ?? '';

                    $fieldRequired = (
                      isset($configContentFieldArgs['required']) &&
                      $configContentFieldArgs['required'] == true
                    );

                    $fieldDisabled = (
                      isset($configContentFieldArgs['disabled']) &&
                      $configContentFieldArgs['disabled'] == true
                    );

                    $fieldNullable = (
                      isset($configContentFieldArgs['nullValue']) &&
                      $configContentFieldArgs['nullValue'] != ''
                        ? $configContentFieldArgs['nullValue']
                        : false
                    );

                    $choices = $configContentFieldArgs['choices'] ?? (
                      $configContentFieldArgs['options'] ?? []
                    );

                  @endphp

                  @if($fieldType == 'radio')

                    <div class="{!! $fieldClass !!}">

                      <label class="form-label small fw-bold">

                        {!! $fieldLabel !!}{!! ($fieldRequired ? ' <span class="text-danger">*</span>' : '') !!}

                      </label>

                      @foreach($choices as $choiceKey => $choiceLabel)

                        <div class="form-check">

                          <input
                            type="radio"
                            class="form-check-input automator-pagination-editor-setting"
                            id="{!! $configContentFieldKey !!}-{!! $choiceKey !!}"
                            name="{!! $fieldName !!}"
                            value="{!! $choiceKey !!}"
                            {!! ((string) $fieldValue === (string) $choiceKey ? ' checked' : '') !!}
                            {!! ($fieldRequired ? ' required' : '') !!}
                            {!! ($fieldDisabled ? ' disabled' : '') !!}
                          />

                          <label
                            class="form-check-label"
                            for="{!! $configContentFieldKey !!}-{!! $choiceKey !!}"
                          >

                            {!! $choiceLabel !!}

                          </label>

                        </div>

                      @endforeach

                    </div>

                  @elseif($fieldType == 'select')

                    <div class="{!! $fieldClass !!}">

                      <select
                        class="form-select automator-pagination-editor-setting"
                        id="{!! $configContentFieldKey !!}"
                        name="{!! $fieldName !!}"
                        {!! ($fieldRequired ? ' required' : '') !!}
                        {!! ($fieldDisabled ? ' disabled' : '') !!}
                      >

                        @if($fieldNullable !== false)

                          <option
                            value=""
                            {!! (
                              $fieldRequired
                                ? ' disabled'
                                : ''
                            ) !!}
                            {!! (
                              (string) $fieldValue == ''
                                ? ' selected'
                                : ''
                            ) !!}
                          >

                            {!! $fieldNullable !!}

                          </option>

                        @endif

                        @foreach($choices as $choiceKey => $choiceLabel)

                          <option
                            value="{!! $choiceKey !!}"
                            {!! (
                              (string) $fieldValue === (string) $choiceKey
                                ? ' selected'
                                : ''
                            ) !!}
                          >

                            {!! $choiceLabel !!}

                          </option>

                        @endforeach

                      </select>

                      <label for="{!! $configContentFieldKey !!}">

                        {!! $fieldLabel !!}{!! ($fieldRequired ? ' <span class="text-danger">*</span>' : '') !!}

                      </label>

                    </div>

                  @elseif($fieldType == 'dynamic-inserter')

                    @php

                      $routes = $configContentFieldArgs['routes'] ?? [];

                    @endphp

                    <div
                      class="automator-pagination-editor-actions-manager"
                      data-field-name="{!! $fieldName !!}"
                    >

                      <input
                        type="hidden"
                        name="{!! $fieldName !!}"
                        class="automator-pagination-editor-setting automator-pagination-editor-actions-value"
                        value="{!! e(
                          is_array($fieldValue)
                            ? json_encode(
                              $fieldValue,
                              JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                            )
                            : $fieldValue
                        ) !!}"
                      />

                      <div class="d-flex align-items-center justify-content-between mb-3">

                        <label class="small fw-bold mb-0">

                          {!! $fieldLabel !!}

                        </label>

                        <button
                          type="button"
                          class="btn btn-sm btn-primary automator-pagination-editor-action-add"
                        >

                          <i class="fa fa-plus me-1"></i>

                          {!! SysAutomator::SysAutomatorGetTranslateWord('Adicionar ação') !!}

                        </button>

                      </div>

                      <div
                        class="automator-pagination-editor-actions-list"
                        data-empty="{!! SysAutomator::SysAutomatorGetTranslateWord('Nenhuma ação adicionada.') !!}"
                      ></div>

                      <script
                        type="application/json"
                        class="automator-pagination-editor-actions-routes"
                      >{!! json_encode(
                        $routes,
                        JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES
                      ) !!}</script>

                    </div>

                  @elseif($fieldType == 'textarea')

                    <div class="{!! $fieldClass !!}">

                      <textarea
                        class="form-control automator-pagination-editor-setting"
                        id="{!! $configContentFieldKey !!}"
                        name="{!! $fieldName !!}"
                        placeholder="{!! $fieldLabel !!}"
                        rows="{!! $configContentFieldArgs['rows'] ?? 4 !!}"
                        {!! ($fieldRequired ? ' required' : '') !!}
                        {!! ($fieldDisabled ? ' disabled' : '') !!}
                      >{!! $fieldValue !!}</textarea>

                      <label for="{!! $configContentFieldKey !!}">

                        {!! $fieldLabel !!}{!! ($fieldRequired ? ' <span class="text-danger">*</span>' : '') !!}

                      </label>

                    </div>

                  @else

                    <div class="{!! $fieldClass !!}">

                      <input
                        type="{!! $fieldType !!}"
                        class="form-control automator-pagination-editor-setting"
                        id="{!! $configContentFieldKey !!}"
                        name="{!! $fieldName !!}"
                        placeholder="{!! $fieldPlacehold !!}"
                        value="{!! $fieldValue !!}"
                        {!! ($fieldRequired ? ' required' : '') !!}
                        {!! ($fieldDisabled ? ' disabled' : '') !!}
                      />

                      <label for="{!! $configContentFieldKey !!}">

                        {!! $fieldLabel !!}{!! ($fieldRequired ? ' <span class="text-danger">*</span>' : '') !!}

                      </label>

                    </div>

                  @endif

                @endforeach

              </div>

            </div>

          @endforeach

        </div>

      @endif

    </div>

    <div id="automator-pagination-editor-aside-right-proprieties">

      <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light">

        <h6 class="small fw-bold mb-0 text-uppercase">

          {!! $texts['proprieties'] ?? 'Propriedades' !!}

        </h6>

        <button
          type="button"
          class="btn-close d-lg-none"
          onclick="SysAutomatorPaginationEditor.toggleSidebar('right')"
        ></button>

      </div>

    </div>

  </aside>

</div>