@php
  
  $messages = [

    'title-error' => SysAutomator::SysAutomatorGetTranslateWord('Adicione um titulo para a página para liberar esta ação.'),
    'name-error'  => SysAutomator::SysAutomatorGetTranslateWord('Adicione um nome para a página para liberar esta ação.'),
  
  ];

@endphp
<style>

  .automator-editor-custom-popover .popover-header { text-align: center; }
  .wp-modal-editor { display: flex; flex-direction: column; height: 100vh; background: #fff; color: #1e1e1e; position: relative; overflow: hidden; }
  .wp-nav-header { height: 65px; border-bottom: 1px solid #e0e0e0; display: flex; align-items: center; justify-content: space-between; padding: 0 15px; flex-shrink: 0; background: #fff; z-index: 1060; }
  .wp-nav-center { flex: 1; max-width: 500px; margin: 0 20px; }
  
  .wp-editor-body { display: flex; flex: 1; overflow: hidden; position: relative; }
  
  /* Sidebar Animada */
  .wp-aside { 
      width: 320px; 
      background: #fff; 
      border-right: 1px solid #e0e0e0; 
      transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1); 
      overflow-y: auto; 
      overflow-x: hidden;
      display: flex; 
      flex-direction: column;
      z-index: 1030;
  }
  .wp-aside-right { border-right: none; border-left: 1px solid #e0e0e0; }

  .wp-inserter-item:hover,
  .wp-inserter-item:active,
  .wp-inserter-item:focus {
    background-color: #007cba !important;
    color: #FFFFFF !important;
    cursor: pointer !important;
  }

  .wp-inserter-item:hover > i,
  .wp-inserter-item:active > i,
  .wp-inserter-item:focus > i { color: #FFFFFF !important; }
  
  .wp-aside.collapsed { 
      width: 0; 
      opacity: 0; 
      visibility: hidden;
      transform: translateX(-20px);
  }
  .wp-aside-right.collapsed { transform: translateX(20px); }

  .wp-main-canvas { flex: 1; overflow-y: auto; padding: 40px 20px; background-color: #f0f0f0; }
  .wp-editor-width { max-width: 850px; margin: 0 auto; background: #fff; min-height: 100%; box-shadow: 0 0 20px rgba(0,0,0,0.05); padding: 40px; }

  /* Blocos */
  .wp-block { position: relative; margin-bottom: 15px; padding: 15px; border: 1px solid transparent; transition: border 0.2s; border-radius: 4px; }
  .wp-block.is-active { border: 1px solid #007cba; box-shadow: 0 0 0 1px #007cba; }
  .wp-block.is-locked { opacity: 0.7; border: 1px dashed #ccc !important; }
  
  .wp-block-handle { cursor: move; color: #ccc; position: absolute; left: -25px; top: 15px; padding: 5px; opacity: 0; transition: opacity 0.2s; }
  .wp-block:hover > .wp-block-handle { opacity: 1; }

  .wp-toolbar { position: absolute; top: -45px; left: 0; background: #fff; border: 1px solid #ccc; border-radius: 4px; box-shadow: 0 2px 10px rgba(0,0,0,0.15); display: none; padding: 5px; z-index: 1050; align-items: center; gap: 5px; }
  .wp-block.is-active > .wp-toolbar { display: flex; }

  /* Containers */
  .wp-block.can-have-child {
      border: 1px dashed #d0d0d0;
      min-height: 80px;
      padding-top: 30px;
  }
  
  .wp-block.can-have-child::before {
      /*content: 'Container';*/
      content: attr(data-container-name);
      position: absolute;
      top: 5px;
      left: 15px;
      font-size: 10px;
      text-transform: uppercase;
      color: #aaa;
      font-weight: bold;
  }

  .wp-block-child-area { min-height: 50px; width: 100%; }

  .wp-block.is-empty .wp-block-child-area {
      background: #fdfdfd;
      border: 1px dashed #eee;
      display: flex;
      align-items: center;
      justify-content: center;
  }

  .wp-block.is-empty .wp-block-child-area::after {
      content: 'Clique para adicionar blocos';
      font-size: 12px;
      color: #ccc;
  }

  /* Color Picker Circular */
  .wp-editor-custom-color-picker {
    border-radius: 50%;
    border: 1px solid #ced4da;
    position: relative;
    overflow: hidden;
    width: 28px;
    height: 28px;
    cursor: pointer;
  }
  .wp-editor-custom-color-picker > input {
    border: none !important;
    width: 40px;
    height: 40px;
    padding: 0;
    cursor: pointer;
    position: absolute;
    top: -6px;
    left: -6px;
    background: none;
  }

  [contenteditable]:focus { outline: none; }
  .wp-empty:empty:before { content: attr(data-placeholder); color: #949494; }

  .structure-item { display:flex; align-items:center; gap:8px; padding:8px 10px; border-radius:6px; cursor:pointer; }
  .structure-item:hover { background:#f8f9fa; }


  .wp-tabs {
      display: flex;
      border-bottom: 1px solid #e0e0e0;
  }

  .wp-tab-btn {
      flex: 1;
      padding: 12px;
      border: none;
      background: none;
      font-size: 13px;
      font-weight: 600;
      color: #757575;
      border-bottom: 2px solid transparent;
  }

  .wp-tab-btn.active {
      color: #1e1e1e;
      border-bottom-color: #007cba;
  }

  .wp-tab-btn:disabled { opacity: 0.5; cursor: not-allowed; }

  #automator-editor-dropdown ul.dropdown-menu { padding-top: 0px; padding-bottom: 0px; }
  #automator-editor-dropdown ul.dropdown-menu > li:first-child > button {
    border-top-right-radius: 0.375rem;
    border-top-left-radius: 0.375rem;
  }

  #automator-editor-dropdown ul.dropdown-menu > li:last-child > button {
    border-bottom-right-radius: 0.375rem;
    border-bottom-left-radius: 0.375rem;
  }

  #tbl_sys_route_title:focus { box-shadow: unset !important; }

</style>

<div class="wp-modal-editor" id="automator-page-editor">
  
  <header class="wp-nav-header">

    <div class="d-flex align-items-center">
      
      <span class="me-2" data-bs-toggle="tooltip" data-bs-title="{!! $messages['title-error'] !!}"  data-bs-title-error="{!! $messages['title-error'] !!}" data-bs-name-error="{!! $messages['name-error'] !!}">
        <button type="button" class="btn btn-sm btn-primary wp-btn-action" onclick="AutomatorPageEditor.switchLeftTab('inserter')" title="Adicionar Bloco" disabled>
          <i class="fas fa-plus"></i>
        </button>
      </span>
      
      <span class="me-2" data-bs-toggle="tooltip" data-bs-title="{!! $messages['title-error'] !!}"  data-bs-title-error="{!! $messages['title-error'] !!}" data-bs-name-error="{!! $messages['name-error'] !!}">
        <button type="button" class="btn btn-sm btn-secondary wp-btn-action" onclick="AutomatorPageEditor.switchLeftTab('structure')" title="Estrutura da Página" disabled>
          <i class="fas fa-list-ol"></i>
        </button>
      </span>
      
      <div class="vr mx-2 d-none"></div>
      
      <span class="me-1 d-none" data-bs-toggle="tooltip" data-bs-title="{!! $messages['title-error'] !!}"  data-bs-title-error="{!! $messages['title-error'] !!}" data-bs-name-error="{!! $messages['name-error'] !!}">
        <button type="button" class="btn btn-sm btn-light wp-btn-action" onclick="document.execCommand('undo')" disabled><i class="fas fa-undo"></i></button>
      </span>
      
      <span class="d-none" data-bs-toggle="tooltip" data-bs-title="{!! $messages['title-error'] !!}"  data-bs-title-error="{!! $messages['title-error'] !!}" data-bs-name-error="{!! $messages['name-error'] !!}">
        <button type="button" class="btn btn-sm btn-light wp-btn-action" onclick="document.execCommand('redo')" disabled><i class="fas fa-redo"></i></button>
      </span>

    </div>

    <div class="wp-nav-center">

      <div class="input-group">
        
        <div class="form-floating">
          
          <input type="text" class="form-control border border-secondary border-end-0 bg-light" id="tbl_sys_route_title" name="tbl_sys_route_title" placeholder="Título da Página" autocomplete="off">
          
          <label for="tbl_sys_route_title">Título da Página</label>
        
        </div>
        
        <span class="input-group-text p-0 d-inline-block" style="border-top: 0px; border-bottom: 0px;">
        
          <input type="checkbox" class="btn-check" id="tbl_sys_route_title_sync" autocomplete="off" checked />
          <label class="btn btn-outline-secondary border-secondary h-100 d-flex align-items-center" for="tbl_sys_route_title_sync" style="border-top-left-radius: 0px; border-bottom-left-radius: 0px;">Gerar Nome</label>
        
        </span>

      </div>

    </div>

    <div class="d-flex align-items-center">

      <!--  -->
      <div id="automator-editor-dropdown" class="dropdown mx-2" data-bs-toggle="tooltip" data-bs-title="{!! $messages['title-error'] !!}" data-bs-title-error="{!! $messages['title-error'] !!}" data-bs-name-error="{!! $messages['name-error'] !!}">

        <button id="automator-editor-dropdown-button" class="automator-editor-dropdown-dropdown-button dropdown-toggle btn btn-outline-secondary" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false" disabled style="min-width: 63px;">

          <span data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="Computador XXL">

            <i class="fa-regular fa-window-maximize"></i>
            
          </span>

        </button>

        <ul class="dropdown-menu dropdown-menu-end shadow" data-popper-placement="bottom-end" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 54px);">
          
          <li><button type="button" onclick="AutomatorPageEditor.updateCurrentResolutionSize(this)" class="dropdown-item active" data-value="col-xxl-"><i class="fa-regular fa-window-maximize"></i> Computador XXL</button></li>
          <li><button type="button" onclick="AutomatorPageEditor.updateCurrentResolutionSize(this)" class="dropdown-item" data-value="col-xl-"><i class="fa-solid fa-window-maximize"></i> Computador XL</button></li>
          <li><button type="button" onclick="AutomatorPageEditor.updateCurrentResolutionSize(this)" class="dropdown-item" data-value="col-lg-"><i class="fa-solid fa-laptop"></i> Computador</button></li>
          <li><button type="button" onclick="AutomatorPageEditor.updateCurrentResolutionSize(this)" class="dropdown-item" data-value="col-md-"><i class="fa-solid fa-tablet"></i> Large Tablet</button></li>
          <li><button type="button" onclick="AutomatorPageEditor.updateCurrentResolutionSize(this)" class="dropdown-item" data-value="col-sm-"><i class="fa-solid fa-tablet-screen-button"></i> Tablet</button></li>
          <li><button type="button" onclick="AutomatorPageEditor.updateCurrentResolutionSize(this)" class="dropdown-item" data-value="col-"><i class="fa-solid fa-mobile-screen"></i> Mobile</button></li>
                      
        </ul>

      </div>
      <!--  -->

      <span class="d-inline-block me-2" data-bs-toggle="tooltip" data-bs-title="{!! $messages['title-error'] !!}" data-bs-title-error="{!! $messages['title-error'] !!}" data-bs-name-error="{!! $messages['name-error'] !!}">

        <button type="button" class="btn btn-primary px-3 wp-btn-save" style="height: 38px;" onclick="AutomatorPageEditor.save()" disabled>Salvar</button>

      </span>
      
      <span class="d-inline-block" data-bs-toggle="tooltip" data-bs-title="{!! $messages['title-error'] !!}" data-bs-title-error="{!! $messages['title-error'] !!}" data-bs-name-error="{!! $messages['name-error'] !!}">
        
        <button id="wp-btn-configs" type="button" class="btn btn-secondary" style="height: 38px; font-size: 16px;" onclick="AutomatorPageEditor.toggleSidebar('right')" data-bs-trigger="hover" data-bs-toggle="tooltip" data-bs-title="Configurações" disabled>
          <i class="fas fa-cog"></i>
        </button>

      </span>

    </div>

  </header>

  <div class="wp-editor-body">

    <aside class="wp-aside wp-aside-left collapsed" id="wp_sidebar_left">
      
      <div id="left-tab-inserter">

        <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light">

          <h6 class="small fw-bold mb-0 text-uppercase">Blocos</h6>
          <button type="button" class="btn-close d-lg-none" onclick="AutomatorPageEditor.toggleSidebar('left')"></button>

        </div>
        
        <div class="row p-3 g-2">

          <div class="col-12">

            <div class="input-group">

              <div class="form-floating">

                <input type="text" class="form-control" id="dynamic-inserter-list-search" value="" placeholder="Procurar Campo" onkeyup="AutomatorPageEditorFilterFields(this)" />
                <label for="dynamic-inserter-list-search">Procurar Campo</label>

              </div>

              <span class="input-group-text"><i class="fa fa-search"></i></span>

            </div>

          </div>

        </div>
        
        <div class="p-3 pt-0 g-3 row row-cols-2" id="dynamic-inserter-list">
          
          @php

            $grupos = SysAutomator::SysAutomatorRenderPageBuilderFields();
            foreach($grupos as $grupo) {
              echo '<div class="col col-sm-12 mt-4 fw-bold small text-muted text-uppercase">' . $grupo['tbl_sys_field_type_group_title'] . '</div>';
              foreach($grupo['tbl_sys_field_type_group_fields'] as $field) {
                echo '<div class="col">';
                  echo '<div class="wp-inserter-item border p-3 text-center rounded mb-2" onclick="AutomatorPageEditor.SysAutomatorEditorIncludeField(' . $field['tbl_sys_field_type_ID'] . ')" data-bs-toggle="popover" data-bs-trigger="hover focus" data-bs-custom-class="automator-editor-custom-popover" data-bs-title="' . $field['tbl_sys_field_type_title'] . '" data-bs-content="' . $field['tbl_sys_field_type_description'] . '">';
                    echo '<i class="fa fa-' . $field['tbl_sys_field_type_icon'] . ' d-block mb-2 text-primary fs-5"></i> <span class="small d-block text-truncate">' . $field['tbl_sys_field_type_title'] . '</span>';
                  echo '</div>';
                echo '</div>';
              }
            }
          
          @endphp

        </div>

      </div>

      <div id="left-tab-structure" class="d-none">
        
        <div class="p-3 border-bottom d-flex justify-content-between align-items-center bg-light">
          
          <h6 class="small fw-bold mb-0 text-uppercase">Estrutura</h6>
          <button type="button" class="btn-close d-lg-none" onclick="AutomatorPageEditor.toggleSidebar('left')"></button>
        
        </div>
        <div id="wp_structure_list" class="p-2"></div>

      </div>

    </aside>


    <main class="wp-main-canvas" onclick="AutomatorPageEditor.deselectAll()">
      
      <div class="wp-editor-width">
        
        <div id="wp_canvas_content" class="row"></div>
      
      </div>
    
    </main>


    <aside class="wp-aside wp-aside-right" id="wp_sidebar_right">
      
      <div class="wp-tabs">

        <button type="button" class="wp-tab-btn active" id="tab-btn-page" onclick="AutomatorPageEditor.switchTab('page')">Página</button>
        <button type="button" class="wp-tab-btn" id="tab-btn-block" onclick="AutomatorPageEditor.switchTab('block')" disabled>Bloco</button>

      </div>
      
      <div id="wp_settings_container">
        
        <div class="p-3" id="tab-content-page">
          
          <input type="hidden" name="tbl_sys_route_id" id="tbl_sys_route_id" value="{{ $route->id ?? '' }}">
          <input type="hidden" name="tbl_sys_route_api" id="tbl_sys_route_api" value="0">
          <input type="hidden" name="tbl_sys_route_type" id="tbl_sys_route_type" value="GET">

          <div class="form-floating mb-3">
          
            <input type="text" class="form-control" name="tbl_sys_route_name" id="tbl_sys_route_name" placeholder="Nome" required value="{{ $route->name ?? '' }}">
            <label for="tbl_sys_route_name">Nome da Página</label>
          
          </div>

          <div class="form-floating mb-3">
            
            <select class="form-select" name="tbl_sys_route_admin" id="tbl_sys_route_admin" required>
            
              <option value="1" {{ (isset($route) && $route->admin == 1) ? 'selected' : '' }}>Sim</option>
              <option value="0" {{ (isset($route) && $route->admin == 0) ? 'selected' : '' }}>Não</option>
            
            </select>
            <label for="tbl_sys_route_admin">Página Administrativa</label>

          </div>

          <div class="form-floating mb-3">
            
            <input type="text" class="form-control" name="tbl_sys_route_permalink" id="tbl_sys_route_permalink" placeholder="Permalink" value="{{ $route->permalink ?? '' }}">
            <label for="tbl_sys_route_permalink">Permalink</label>

          </div>

          <div class="form-floating mb-3">

            <textarea class="form-control" name="tbl_sys_route_description" id="tbl_sys_route_description" style="height: 100px" placeholder="Descrição">{{ $route->description ?? '' }}</textarea>
            <label for="tbl_sys_route_description">Descrição</label>

          </div>

          <div class="form-floating mb-3">

            <input type="text" class="form-control" name="tbl_sys_route_controller" id="tbl_sys_route_controller" placeholder="Controlador" value="{{ $route->controller ?? '' }}">
            <label for="tbl_sys_route_controller">Controlador</label>
          
          </div>

          <div class="form-floating mb-3">

            <input type="text" class="form-control" name="tbl_sys_route_method" id="tbl_sys_route_method" placeholder="Método" value="{{ $route->method ?? '' }}">
            <label for="tbl_sys_route_method">Método da Página</label>
          
          </div>
        
        </div>
        
        <div id="tab-content-block" class="d-none">
          
          <div id="block-settings-render">
            
            <p class="text-muted text-center py-5 small">Selecione um bloco para editar.</p>
          
          </div>
        
        </div>

      </div>

    </aside>

  </div>

</div>