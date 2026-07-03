<style type="text/css">

  .automator-view-modal .modal-body {
    overflow: hidden !important;
  }

  #automator-editor-modal {
    flex-direction: column;
    background: #FFFFFF;
    position: relative;
    overflow: hidden;
    display: flex;
    height: 100vh;
    color: #1E1E1E;
  }

  #automator-editor-header {
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

  #automator-editor-header-center {
    max-width: 500px;
    margin: 0 20px;
    flex: 1;
  }

  #automator-editor-body {
    overflow: hidden !important;
    position: relative;
    display: flex;
    flex: 1;
    min-height: 0;
  }

  .automator-editor-aside {
    flex-direction: column;
    border-right: 1px solid #e0e0e0;
    transition: width .3s ease, transform .3s ease, opacity .3s ease, visibility .3s ease;
    background: #ffffff;
    overflow-y: auto !important;
    overflow-x: hidden !important;
    z-index: 1030;
    display: flex;
    width: 320px;
    flex-shrink: 0;
    height: 100%;
    max-height: 100%;
  }

  #automator-editor-aside-left {
    position: relative;
  }

  #automator-editor-aside-left.is-collapsed {
    visibility: hidden;
    transform: translateX(-20px);
    opacity: 0;
    width: 0;
  }

  #automator-editor-aside-left-inserter,
  #automator-editor-aside-left-structure {
    position: absolute;
    inset: 0;
    background: #ffffff;
    overflow-y: auto !important;
    overflow-x: hidden !important;
    z-index: 1031;
    display: block;
    height: 100%;
    width: 100%;
    transition: transform .28s ease, opacity .28s ease;
  }

  .automator-editor-aside-left-collapsed {
    display: block !important;
  }

  #automator-editor-aside-left[data-active-tab="inserter"] #automator-editor-aside-left-inserter {
    transform: translateX(0);
    opacity: 1;
    pointer-events: auto;
  }

  #automator-editor-aside-left[data-active-tab="inserter"] #automator-editor-aside-left-structure {
    transform: translateX(100%);
    opacity: 0;
    pointer-events: none;
  }

  #automator-editor-aside-left[data-active-tab="structure"] #automator-editor-aside-left-inserter {
    transform: translateX(-100%);
    opacity: 0;
    pointer-events: none;
  }

  #automator-editor-aside-left[data-active-tab="structure"] #automator-editor-aside-left-structure {
    transform: translateX(0);
    opacity: 1;
    pointer-events: auto;
  }

  .automator-editor-actions-btn.is-active {
    box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
  }

  #automator-editor-aside-right {
    border-right: none;
    border-left: 1px solid #e0e0e0;
  }

  #automator-editor-aside-right.is-collapsed {
    visibility: hidden;
    transform: translateX(20px);
    opacity: 0;
    width: 0;
  }

  #automator-editor-canvas {
    background-color: #f0f0f0;
    overflow-y: auto !important;
    overflow-x: auto !important;
    padding: 40px 20px;
    flex: 1;
    min-width: 0;
    min-height: 0;
    box-sizing: border-box;
  }

  #automator-editor-canvas-container {
    box-shadow: 0 0 20px rgba(0, 0, 0, 0.18);
    background: #ffffff;
    min-height: 500px;
    max-width: 850px;
    margin: 0 auto 20px auto;
    padding: 0 10px;
  }

  #automator-editor-modal.is-preview-mode #automator-editor-canvas-container,
  #automator-editor-modal.is-sidebars-hidden #automator-editor-canvas-container {
    max-width: none !important;
  }

  #automator-editor-header-viewport-label {
    min-width: 34px;
    display: inline-block;
    text-align: center;
  }

  #automator-editor-canvas-container > .container-fluid {
    padding-left: 0 !important;
    padding-right: 0 !important;
  }

  #automator-editor-canvas-container-content {
    min-height: 500px;
    padding-top: 10px;
    padding-bottom: 10px;
    height: auto;
    width: 100%;
  }

  #automator-editor-canvas-container-content .gjs-editor {
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

  .automator-editor-aside-left-inserter-list-item {
    cursor: pointer;
    transition: all 0.2s ease;
    background: #ffffff;
    user-select: none;
    opacity: 1 !important;
  }

  .automator-editor-aside-left-inserter-list-item:hover {
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

  #automator-editor-aside-right-content {
    padding-left: 0 !important;
    padding-right: 0 !important;
  }

  #automator-editor-aside-right-content .accordion {
    margin-left: 0 !important;
    margin-right: 0 !important;
  }

  #automator-editor-aside-right-content .accordion-item {
    border-left: 0 !important;
    border-right: 0 !important;
    border-radius: 0 !important;
  }

  #automator-editor-aside-right-content .accordion-button {
    border-radius: 0 !important;
    box-shadow: none !important;
  }

  #automator-editor-aside-right-content > .mb-3,
  #automator-editor-aside-right-content > .text-muted {
    padding-left: 15px;
    padding-right: 15px;
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

  @media (max-width: 991.98px) {

    #automator-editor-body {
      position: relative;
    }

    #automator-editor-aside-left,
    #automator-editor-aside-right {
      position: absolute;
      top: 0;
      bottom: 0;
      height: auto;
      max-height: none;
      width: min(320px, 88vw);
      z-index: 1070;
      box-shadow: 0 0 25px rgba(0, 0, 0, .18);
    }

    #automator-editor-aside-left {
      left: 0;
      transform: translateX(-105%);
      opacity: 0;
      visibility: hidden;
    }

    #automator-editor-aside-left.show {
      transform: translateX(0);
      opacity: 1;
      visibility: visible;
    }

    #automator-editor-aside-right {
      right: 0;
      transform: translateX(105%);
      opacity: 0;
      visibility: hidden;
    }

    #automator-editor-aside-right.show {
      transform: translateX(0);
      opacity: 1;
      visibility: visible;
    }

    #automator-editor-aside-left.is-collapsed,
    #automator-editor-aside-right.is-collapsed {
      width: min(320px, 88vw);
    }

  }

  .automator-editor-api-property-editor {
    display: flex;
    width: 100%;
    max-height: 260px;
    overflow: hidden;
    border: 1px solid #ced4da;
    border-radius: .25rem;
    background: #ffffff;
  }

  .automator-editor-api-property-editor-count {
    width: 42px;
    min-width: 42px;
    max-height: 260px;
    padding: 6px 6px;
    background: #f8f9fa;
    color: #999;
    font-family: monospace;
    font-size: 12px;
    line-height: 20px;
    text-align: right;
    overflow: hidden;
    user-select: none;
    border-right: 1px solid #dee2e6;
  }

  .automator-editor-api-property-editor-count span {
    display: block;
    height: 20px;
    line-height: 20px;
  }

  .automator-editor-api-property-editor-count span.is-active {
    color: #0d6efd;
    font-weight: 700;
  }

  .automator-editor-api-property-editor textarea[data-field-type="editor-css"] {
    border: 0 !important;
    border-radius: 0 !important;
    resize: none;
    font-family: monospace;
    font-size: 12px;
    line-height: 20px;
    padding: 6px 8px;
    min-height: 140px;
    max-height: 260px;
    height: 260px;
    white-space: pre;
    overflow: auto !important;
    background-image: linear-gradient(
      to bottom,
      transparent var(--editor-css-active-line-top, 0px),
      rgba(13, 110, 253, .08) var(--editor-css-active-line-top, 0px),
      rgba(13, 110, 253, .08) calc(var(--editor-css-active-line-top, 0px) + 20px),
      transparent calc(var(--editor-css-active-line-top, 0px) + 20px)
    );
    background-attachment: local;
  }

  .automator-editor-api-property-editor textarea[data-field-type="editor-css"]:focus {
    box-shadow: none !important;
    outline: none !important;
  }

  #automator-editor-modal.is-preview-mode .automator-editor-aside {
    display: none !important;
    width: 0 !important;
  }

  #automator-editor-modal.is-preview-mode #automator-editor-canvas {
    padding-left: 20px;
    padding-right: 20px;
  }

  #automator-editor-modal.is-preview-mode .automator-editor-preview-disabled {
    opacity: .45;
    pointer-events: none;
  }

</style>

<div id="extracted-json" class="d-none"></div>

<header id="automator-editor-header">

  <div class="d-flex align-items-center">

    <span class="me-2" data-bs-placement="bottom" data-bs-toggle="tooltip" data-bs-title="{!! $texts['add-block'] ?? 'Adicionar bloco' !!}" data-bs-trigger="hover">
      <button type="button" class="btn btn-primary automator-editor-actions-btn" data-automator-left-tab="inserter" onclick="SysAutomatorEditor.switchLeftTab('inserter')">
        <i class="fas fa-plus"></i>
      </button>
    </span>

    <span class="me-2" data-bs-placement="bottom" data-bs-toggle="tooltip" data-bs-title="{!! $texts['structure'] ?? 'Estrutura' !!}" data-bs-trigger="hover">
      <button type="button" class="btn btn-secondary automator-editor-actions-btn" data-automator-left-tab="structure" onclick="SysAutomatorEditor.switchLeftTab('structure')">
        <i class="fas fa-list"></i>
      </button>
    </span>

    <span class="dropdown me-2" data-bs-placement="bottom" data-bs-toggle="tooltip" data-bs-title="Resolução" data-bs-trigger="hover">
      <button id="automator-editor-header-viewport-btn" type="button" class="btn btn-secondary dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
        <i class="fas fa-desktop me-1"></i>
        <span id="automator-editor-header-viewport-label">Auto</span>
      </button>

      <ul class="dropdown-menu">
        <li><button class="dropdown-item" type="button" onclick="SysAutomatorEditor.setViewportMode('auto')">Auto</button></li>
        <li><button class="dropdown-item" type="button" onclick="SysAutomatorEditor.setViewportMode('xs')">XS - 375px</button></li>
        <li><button class="dropdown-item" type="button" onclick="SysAutomatorEditor.setViewportMode('sm')">SM - 576px</button></li>
        <li><button class="dropdown-item" type="button" onclick="SysAutomatorEditor.setViewportMode('md')">MD - 768px</button></li>
        <li><button class="dropdown-item" type="button" onclick="SysAutomatorEditor.setViewportMode('lg')">LG - 992px</button></li>
        <li><button class="dropdown-item" type="button" onclick="SysAutomatorEditor.setViewportMode('xl')">XL - 1200px</button></li>
        <li><button class="dropdown-item" type="button" onclick="SysAutomatorEditor.setViewportMode('xxl')">XXL - 1400px</button></li>
      </ul>
    </span>

  </div>

  @if(isset($header['content']))

    <div id="automator-editor-header-center" class="text-center">

      @if($header['type'] == 'form-input')

        @php

          $haveSlug = ( (isset($header['content']['have-slug'])) ? ( (is_array($header['content']['have-slug'])) ? ( (count($header['content']['have-slug']) >= 1) ? ( (isset($header['content']['have-slug']['enabled'])) ? $header['content']['have-slug']['enabled'] : false ) : false ) : false ) : false );

        @endphp

        @if($haveSlug == true)

          <div class="input-group">
        
            <div class="form-floating">
              
              <input type="{!! $header['content']['type'] !!}" value="{!! $header['content']['value'] !!}" class="form-control border border-secondary border-end-0 bg-light" id="{!! $header['content']['id'] !!}" name="{!! $header['content']['name'] !!}" placeholder="{!! $header['content']['label'] !!}" autocomplete="off" onkeyup="SysAutomatorEditor.syncHeaderInputSlug(this)" data-automator-sync-slug-field="{!! $header['content']['have-slug']['field'] !!}"{!! ( ($header['content']['required'] == true) ? ' required' : '' ) !!} />
              
              <label for="{!! $header['content']['id'] !!}">{!! $header['content']['label'] !!}</label>
            
            </div>
            
            <span class="input-group-text p-0 d-inline-block" style="border-top: 0px; border-bottom: 0px;">
            
              <input type="checkbox" class="btn-check" id="{!! $header['content']['id'] !!}-sync" autocomplete="off" />
              <label class="btn btn-outline-secondary border-secondary h-100 d-flex align-items-center" for="{!! $header['content']['id'] !!}-sync" style="border-top-left-radius: 0px; border-bottom-left-radius: 0px;">{!! $header['content']['have-slug']['label'] !!}</label>
            
            </span>

          </div>

        @else

          <div class="form-floating">
              
            <input type="{!! $header['content']['type'] !!}" class="form-control border border-secondary border-end-0 bg-light" id="{!! $header['content']['id'] !!}" name="{!! $header['content']['name'] !!}" placeholder="{!! $header['content']['label'] !!}" autocomplete="off" value="{!! $header['content']['label'] !!}" />
            <label for="{!! $header['content']['id'] !!}">{!! $header['content']['label'] !!}</label>
          
          </div>

        @endif

      @else

        {!! $header['content'] !!}

      @endif
      <!-- <span class="small fw-bold text-muted">Editor de Conteúdo</span> -->
      
    </div>

  @endif

  <div class="d-flex align-items-center">

    <span class="d-inline-block me-2" data-bs-placement="bottom" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-title="Pré Visualizar">
      <button id="automator-editor-header-preview-btn" type="button" class="btn btn-secondary" onclick="SysAutomatorEditor.togglePreviewMode()">
        <i class="fas fa-eye"></i>
      </button>
    </span>

    <span class="d-inline-block me-2" data-bs-placement="bottom" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-title="{!! $texts['proprieties'] ?? 'Propriedades' !!}">
      <button id="automator-editor-header-configs-btn" type="button" class="btn btn-secondary" onclick="SysAutomatorEditor.toggleSidebar('right')">
        <i class="fas fa-sitemap"></i>
      </button>
    </span>

    <span class="d-inline-block">
      <button id="automator-editor-header-save-btn" type="button" class="btn btn-primary px-3" style="height: 38px;" onclick="SysAutomatorEditor.saveContent()">
        {!! $texts['save'] ?? 'Salvar' !!}
      </button>
    </span>

  </div>

</header>

<div id="automator-editor-body">

  <aside id="automator-editor-aside-left" class="automator-editor-aside bg-white" data-active-tab="inserter">

    <div id="automator-editor-aside-left-inserter">

      <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light">
        <h6 class="small fw-bold mb-0 text-uppercase">{!! $texts['blocks'] ?? 'Blocos' !!}</h6>
        <button type="button" class="btn-close d-lg-none" onclick="SysAutomatorEditor.toggleSidebar('left')"></button>
      </div>

      <div class="p-3 pt-0 g-3 row row-cols-2" id="automator-editor-aside-left-inserter-list">

        @php

          $grupos = SysAutomator::SysAutomatorRenderPageBuilderFields();

          foreach($grupos as $grupo) {

            echo '<div class="col col-sm-12 mt-4 fw-bold small text-muted text-uppercase">' . $grupo['tbl_sys_field_type_group_title'] . '</div>';

            foreach($grupo['tbl_sys_field_type_group_fields'] as $field) {

              echo '<div class="col">';

                echo '<div 
                  data-block-type="' . $field['tbl_sys_field_type_name'] . '" 
                  data-block-icon="' . $field['tbl_sys_field_type_icon'] . '" 
                  data-block-type-id="' . $field['tbl_sys_field_type_ID'] . '" 
                  data-bs-title="' . $field['tbl_sys_field_type_title'] . '" 
                  data-bs-content="' . $field['tbl_sys_field_type_description'] . '"
                  class="automator-editor-aside-left-inserter-list-item border p-3 text-center rounded mb-2">';

                    echo '<i class="fa fa-' . $field['tbl_sys_field_type_icon'] . ' d-block mb-2 text-primary fs-5"></i>';
                    echo '<span class="small d-block text-truncate">' . $field['tbl_sys_field_type_title'] . '</span>';

                echo '</div>';

              echo '</div>';

            }

          }

        @endphp

      </div>

    </div>

    <div id="automator-editor-aside-left-structure" class="automator-editor-aside-left-collapsed">

      <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light">
        <h6 class="small fw-bold mb-0 text-uppercase">{!! $texts['structure'] ?? 'Estrutura' !!}</h6>
        <button type="button" class="btn-close d-lg-none" onclick="SysAutomatorEditor.toggleSidebar('left')"></button>
      </div>

      <div id="automator-editor-aside-left-structure-list" data-empty="{!! $texts['no-blocks-added'] ?? 'Nenhum bloco adicionado.' !!}"></div>

    </div>

  </aside>

  <main id="automator-editor-canvas">

    <div id="automator-editor-canvas-container">

      <div class="container-fluid">

        <div id="automator-editor-canvas-container-content"></div>

      </div>

    </div>

  </main>

  <aside id="automator-editor-aside-right" class="automator-editor-aside">

    <div class="p-3 border-bottom bg-light">
      <h6 class="small fw-bold mb-0 text-uppercase">{!! $texts['proprieties'] ?? 'Propriedades' !!}</h6>
    </div>

    <div id="automator-editor-aside-right-content" class="p-0 small text-muted">
      <div class="text-center p-3">{!! $texts['select-block'] ?? 'Selecione um bloco para editar.' !!}</div>
    </div>

  </aside>

</div>