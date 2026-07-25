@php
  

  $currentMenuData = [];
  foreach($menus as $_menu) {

    if(count($currentMenuData) <= 0) {

      if($currentMenu == $_menu['tbl_sys_menu_ID']) {

        $currentMenuData = SysAutomator::SysAutomatorGetMenuItemsByMenuID($_menu['tbl_sys_menu_ID']);

      }

    }

  }


  $_nav = [];
  foreach($navs as $navKey => $nav) {

    if(count($_nav) <= 0) {

      if(isset($currentMenuData['menu']['tbl_sys_nav_ID'])) {

        if($currentMenuData['menu']['tbl_sys_nav_ID'] == $nav['tbl_sys_nav_ID']) {

          $_nav = $nav;

        }

      }

    }

  }


@endphp



<style type="text/css">


  #menu-sortable-list > .menu-item-wrapper {

    --tw-space-y-reverse: 0;
    margin-bottom:        calc(.75rem * var(--tw-space-y-reverse));
    margin-top:           calc(.75rem * calc(1 - var(--tw-space-y-reverse)));
  
  }


  .ghost-item {

    background: #EBF5FF !important;
    opacity:    0.4;
    border:     2px dashed #3B82F6 !important;
  
  }


  .chosen-item {

    box-shadow: 0 10px 15px -3px rgba(0,0,0,.1),
                0 4px 6px -2px rgba(0,0,0,.05) !important;
  
  }

  
  .icon-picker-container { position: relative; }

  .icon-picker-dropdown {
    
    border-radius: .5rem;
    box-shadow:    0 10px 15px -3px rgba(0,0,0,.1);
    background:    #FFFFFF;
    max-height:    250px;
    overflow-y:    auto;
    position:      absolute;
    padding:       .5rem;
    z-index:       1050;
    display:       none;
    border:        1px solid #DEE2E6;
    width:         100%;
    left:          0;
    top:           100%;
  
  }


  .icon-picker-grid {

    grid-template-columns: repeat(5, 1fr);
    display:               grid;
    gap:                   .5rem;
  
  }


  .icon-picker-item {

    justify-content: center;
    flex-direction:  column;
    border-radius:   .375rem;
    align-items:     center;
    transition:      background-color .2s;
    padding:         .5rem;
    display:         flex;
    cursor:          pointer;
  
  }


  .icon-picker-item:hover { background-color: #F8F9FA; }


  .icon-picker-item i {

    justify-content: center;
    margin-bottom:   .25rem;
    align-items:     center;
    font-size:       1.25rem;
    display:         flex;
    height:          20px;
    width:           20px;
  
  }


  .icon-picker-item span {

    word-break: break-all;
    text-align: center;
    font-size:  .625rem;
    color:      #6C757D;
  
  }


  .icon-picker-no-results {

    text-align: center;
    font-size:  .875rem;
    padding:    1rem;
    color:      #ADB5BD;

  }

  
  .icon-search-wrapper { position: relative; }


  .icon-search-wrapper .icon-search-prefix,
  .icon-search-wrapper .current-icon-display {

    pointer-events: none;
    transform:      translateY(-50%);
    position:       absolute;
    color:          #6C757D;
    left:           .75rem;
    top:            50%;
  
  }


  .icon-search-wrapper .icon-search-input { padding-left: 2.25rem; }


  .submenu-item { margin-bottom: 10px; }
  .submenu-list > .submenu-item:first-child { margin-top: 20px; }
  .submenu-list > .submenu-item:last-child  { margin-bottom: 20px; }


  .menu-item { transition: border-color .2s; }
  .menu-item:hover { border-color: #0D6EfD !important; }


  .menu-item-body {

    border-bottom-right-radius: .5rem;
    border-bottom-left-radius:  .5rem;
    background-color:           #F8F9FA;
    border-top:                 1px solid #F0F0F0;
    padding:                    1rem;

  }


  .handle { cursor: grab; }
  .handle:active { cursor: grabbing; }


  #menu-sortable-list { min-height: 60px; }


  .menu-itens-users-types button,
  .menu-itens-users-types button:hover {

    background-color: #FFFFFF !important;
    padding-bottom:   .25rem;
    border-radius:    var(--bs-border-radius-sm);
    padding-left:     .5rem;
    padding-top:      .25rem;
    text-align:       left;
    font-size:        .875rem;
    border:           1px solid #DEE2E6;
    width:            100%;

  }


  .menu-itens-users-types button:after { visibility: hidden; }



</style>


<script>
  
  window.AutomatorPaginationRoutes = {};
  window.AutomatorPaginationRoutes.add = "{!! SysAutomator::SysAutomatorGetRouteLinkByName('admin-api-menus-store', true) !!}";;

</script>
<div class="page-card mb-4">
  
  <div class="page-card-body">

    <div class="row g-3 align-items-end justify-content-between">

      <div class="col-12 col-sm-auto">

        <button type="button" class="btn btn-success border d-inline-flex align-items-center justify-content-center gap-2 w-100" onclick="AutomatorPaginationCreateModalForm('modal-lg', 'Criar Novo Menu', 19, '', null, function(response, modalEl, modal, recordData) { AutomatorPaginationCreateModalFormCallBack([{ method: 'POST', action: 'add' }]); });">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['create-new-menu']) !!}</button>

      </div>
      <div class="col-12 col-sm-auto">

        <form id="current-menu-form-change" method="POST" action="{!! $routes['select'] !!}" class="row g-3 align-items-end automator-ajax-ignore" onsubmit="return validateCurrentMenuSelection(this);">
          
          @csrf
          <div class="col-12 col-sm-auto">

            <select name="menu" id="select-menu" class="form-select" onchange="enableCurrentMenuChangeSubmit(this, {{ $currentMenu }});">

              @foreach($menus as $menu)

                <option {!! ( ($currentMenu == $menu['tbl_sys_menu_ID']) ? 'selected' : '' ) !!} value="{{ $menu['tbl_sys_menu_ID'] }}">{!! $menu['tbl_sys_menu_title'] !!}</option>

              @endforeach
                          
            </select>

          </div>
          <div class="col-12 col-sm-auto">

            <button type="submit" class="btn btn-primary border d-inline-flex align-items-center justify-content-center gap-2 w-100 disabled">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['select-menu']) !!}</button>

          </div>

        </form>
        
      </div>
      
    </div>

  </div>
  
</div>


<form class="row">
  
  <div class="col-12 col-md-4 mb-3">
    
    <div class="page-card">
  
      <div class="page-card-body">
        
        <div class="row">
          
          <div class="col-12 mb-3">

            <div class="form-floating">
              <input type="text" class="form-control" id="current-menu-title" placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-name']) !!}" required value="{!! $currentMenuData['menu']['tbl_sys_menu_title'] !!}" />
              <label for="current-menu-title">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-name']) !!} <span class="text-danger">*</span></label>
            </div>
          
          </div>

          <div class="col-12 mb-3">

            <div class="form-floating">
            
              <input type="text" class="form-control" id="current-menu-index" placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-id']) !!}" value="{!! $currentMenuData['menu']['tbl_sys_menu_index'] !!}" />
              <label for="current-menu-index">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-id']) !!}</label>
            
            </div>
          
          </div>

          <div class="col-12 mb-3">

            <div class="form-floating">

              <input type="text" class="form-control" id="current-menu-class" placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-class']) !!}" value="{!! $currentMenuData['menu']['tbl_sys_menu_class'] !!}" />
              <label for="current-menu-class">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-class']) !!}</label>
            
            </div>
          
          </div>

          <div class="col-12 mb-3">

            <div class="form-floating">

              <select class="form-select" id="current-menu-nav-id" aria-label="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-nav']) !!}">
                
                <option {!! ( (isset($currentMenuData['menu']['tbl_sys_nav_ID'])) ? ( ($currentMenuData['menu']['tbl_sys_nav_ID'] == '' || $currentMenuData['menu']['tbl_sys_nav_ID'] == null) ? 'selected ' : '' ) : '' ) !!}value="">- {!! SysAutomator::SysAutomatorGetTranslateWord($textos['select']) !!} -</option>
                @foreach($navs as $navKey => $nav)

                  <option {!! ( (isset($currentMenuData['menu']['tbl_sys_nav_ID'])) ? ( ($currentMenuData['menu']['tbl_sys_nav_ID'] == $nav['tbl_sys_nav_ID']) ? 'selected ' : '' ) : '') !!}value="{{ $nav['tbl_sys_nav_ID'] }}"{!! ( (SysAutomator::SysAutomatorNavHasMenu($nav['tbl_sys_nav_ID']) == true) ? ' disabled' : '' ) !!}>{!! $nav['tbl_sys_nav_title'] !!}</option>

                @endforeach

              </select>
              <label for="current-menu-nav-id">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-nav']) !!}</label>
            
            </div>
          
          </div>
          
          <div class="col-12">

            <button type="button" id="gerenciar-menu-save" class="btn btn-primary disabled w-100" onclick="saveMenu()" disabled>{!! SysAutomator::SysAutomatorGetTranslateWord($textos['save-data']) !!}</button>

          </div>

        </div>

      </div>
      
    </div>

  </div>

  <div class="col-12 col-md-8 mb-3">
    
    <div class="page-card">
  
      <div class="page-card-body">
        
        <div class="row">

          <div class="col-12 pb-3 mb-3 border-bottom">

            <button type="button" class="btn btn-info border d-inline-flex align-items-center justify-content-center gap-2 text-white" onclick="addMenuItem(this)"><i class="fa fa-plus text-white"></i> {!! SysAutomator::SysAutomatorGetTranslateWord($textos['add-menu-item']) !!}</button>
            
          </div>
          
        </div>
        <div class="row">

          <div class="col-12 px-0">
            
            <div id="menu-sortable-list" class="w-100">

              @if(count($currentMenuData['items']) >= 1)

                @foreach($currentMenuData['items'] as $menuItem)

                  @php

                    $mID         = $menuItem['tbl_sys_menu_item_ID'];
                    $mNome       = $menuItem['tbl_sys_menu_item_title']      ?? '';
                    $mStatus     = $menuItem['tbl_sys_menu_item_status']     ?? 'ativo';
                    $mParent     = $menuItem['tbl_sys_menu_item_parent_id']  ?? 0;
                    $mIndex      = $menuItem['tbl_sys_menu_item_index']      ?? '';
                    $mClass      = $menuItem['tbl_sys_menu_item_class']      ?? '';
                    $mType       = $menuItem['tbl_sys_menu_item_type']       ?? 'route';
                    $mRouteID    = $menuItem['tbl_sys_route_ID']             ?? 0;
                    $mLink       = $menuItem['tbl_sys_menu_item_link']       ?? '';
                    $mAdmin      = $menuItem['tbl_sys_menu_item_admin']      ?? 0;
                    $mLocked     = $menuItem['tbl_sys_menu_item_locked']      ?? 0;
                    $mIcone      = $menuItem['tbl_sys_menu_item_icon']       ?? '';
                    $mAccess     = $menuItem['access'] ?? [];
                    $mAccessVals = ( (count($mAccess) >= 1) ? SysAutomator::SysAutomatorFormatMenuItemUserTypesAccessValues($mAccess) : [] );
                    $canDelete   = $menuItem['tbl_sys_menu_item_can_delete'] ?? [];
                    $deleteON    = (
                      (
                        ($user !== null) &&
                        (is_array($user))
                      )
                      ? (
                          (
                            (isset($user['tbl_user_types_IDs'])) &&
                            (is_array($user['tbl_user_types_IDs'])) &&
                            (count($user['tbl_user_types_IDs']) >= 1)
                          )
                          ? (
                              (
                                is_array($canDelete) &&
                                count(array_intersect($user['tbl_user_types_IDs'], $canDelete)) >= 1
                              )
                              ? true : false
                            )
                          : false
                        )
                      : false
                    );

                    $mProps    = $menuItem['tbl_sys_menu_item_props']      ?? '';
                    $mProps    = ( ($mProps != '') ? json_decode($mProps, true) : '' );
                    $mSubs     = $menuItem['children'] ?? $menuItem['sub_itens'] ?? [];
                    $mHasSubs  = count($mSubs) >= 1;

                  @endphp

                  <div class="menu-item-wrapper" data-id="{{ $mID }}">

                    <div class="menu-item card border group-parent">

                      <div class="card-body d-flex align-items-center py-2 px-3 handle">

                        <span class="text-secondary me-3"><i class="fa fa-grip-vertical"></i></span>

                        <div class="flex-grow-1 d-flex align-items-center gap-3">
                          
                          <span class="menu-item-nome fw-bold text-dark">{{ $mNome }}</span>
                        
                        </div>

                        <div class="d-flex align-items-center gap-3">

                          <span class="menu-item-status badge rounded-pill {{ $mStatus === 'ativo' ? 'text-bg-success' : 'text-bg-danger' }}">{{ ucfirst(SysAutomator::SysAutomatorGetTranslateWord($textos['status-' . $mStatus])) }}</span>

                          <button type="button" onclick="toggleAccordion('item-{{ $mID }}')" class="btn btn-link btn-sm text-secondary p-1" data-bs-toggle="tooltip" data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['edit-menu']) !!}"><i id="icon-item-{{ $mID }}" class="fa-solid fa-pencil"></i></button>

                          <button type="button" onclick="addSubmenu({{ $mID }})" class="btn btn-link btn-sm text-secondary p-1" data-bs-toggle="tooltip" data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['add-submenu-item']) !!}"><i class="fa-solid fa-plus"></i></button>

                          <button type="button" onclick="toggleSubmenuDisplay(this)" class="btn btn-link btn-sm text-secondary p-1 chevron-btn chevron-btn-{{ $mID }} {{ $mHasSubs ? '' : 'd-none' }}" data-bs-toggle="tooltip" data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['collapse-menu']) !!}"><i id="icon2-item-{{ $mID }}" class="fa-solid fa-chevron-up"></i></button>

                          <button type="button" class="btn btn-link btn-sm text-secondary p-1 ban-icon ban-icon-{{ $mID }} {{ $mHasSubs ? 'd-none' : '' }}" data-bs-toggle="tooltip" data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['no-submenus']) !!}"><i id="ban-icon2-item-{{ $mID }}" class="fa-solid fa-ban"></i></button>

                          @if($deleteON == true)

                            <button type="button" onclick="deleteMenuItem({{ $mID }}, this)" class="btn btn-link btn-sm text-danger p-1" data-bs-toggle="tooltip" data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['remove-menu']) !!}"><i class="fa-solid fa-trash"></i></button>

                          @else

                            <button type="button" class="btn btn-link btn-sm text-danger p-1 opacity-75" style="cursor: not-allowed;" data-bs-toggle="tooltip" data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['remove-menu-off']) !!}"><i class="fa-solid fa-trash"></i></button>

                          @endif

                        </div>

                      </div>


                      <div id="content-item-{{ $mID }}" class="menu-item-body d-none">

                        <input type="hidden" class="menu-item-parent-val" value="{{ $mParent }}" />

                        <div class="row g-3">

                          <div class="col-12 col-md-6">

                            <label for="tbl_sys_menu_item_title-{{ $mID }}" class="form-label fw-bold text-uppercase small mb-1">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-rotulo']) !!}</label>
                            <input type="text" id="tbl_sys_menu_item_title-{{ $mID }}" name="tbl_sys_menu_item_title" value="{{ $mNome }}" class="form-control form-control-sm" onkeyup="atualizarNomeMenu(this)" placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-rotulo']) !!}" />
                          
                          </div>

                          <div class="col-12 col-md-6">
                            
                            <label for="tbl_sys_menu_item_status-{{ $mID }}" class="form-label fw-bold text-uppercase small mb-1">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-status']) !!}</label>
                            <select id="tbl_sys_menu_item_status-{{ $mID }}" name="tbl_sys_menu_item_status" class="form-select form-select-sm" onchange="return atualizarStatusMenu(this)">
                              
                              <option value="ativo"   {{ $mStatus == 'ativo'   ? 'selected' : '' }}>{{ ucfirst(SysAutomator::SysAutomatorGetTranslateWord($textos['status-ativo'])) }}</option>
                              <option value="inativo" {{ $mStatus == 'inativo' ? 'selected' : '' }}>{{ ucfirst(SysAutomator::SysAutomatorGetTranslateWord($textos['status-inativo'])) }}</option>
                            
                            </select>
                          
                          </div>

                          <div class="col-12 col-md-6">
                            
                            <label for="tbl_sys_menu_item_index-{{ $mID }}" class="form-label fw-bold text-uppercase small mb-1">{{ SysAutomator::SysAutomatorGetTranslateWord($textos['menu-item-id']) }}</label>
                            <input id="tbl_sys_menu_item_index-{{ $mID }}" type="text" name="tbl_sys_menu_item_index" value="{{ $mIndex }}" placeholder="{{ SysAutomator::SysAutomatorGetTranslateWord($textos['menu-item-id']) }}" class="form-control form-control-sm" />
                          
                          </div>

                          <div class="col-12 col-md-6">
                            
                            <label for="tbl_sys_menu_item_class-{{ $mID }}" class="form-label fw-bold text-uppercase small mb-1">{{ SysAutomator::SysAutomatorGetTranslateWord($textos['menu-item-classes']) }}</label>
                            <input id="tbl_sys_menu_item_class-{{ $mID }}" type="text" name="tbl_sys_menu_item_class" value="{{ $mClass }}"placeholder="{{ SysAutomator::SysAutomatorGetTranslateWord($textos['menu-item-classes']) }}" class="form-control form-control-sm" />
                          
                          </div>

                          <div class="col-12 col-md-6">
                            
                            <label for="tbl_sys_menu_item_type-{{ $mID }}" class="form-label fw-bold text-uppercase small mb-1">{{ SysAutomator::SysAutomatorGetTranslateWord($textos['menu-item-type']) }}</label>
                            <select id="tbl_sys_menu_item_type-{{ $mID }}" name="tbl_sys_menu_item_type" class="form-select form-select-sm" onchange="atualizarTipoMenu(this)">
                              
                              <option value="route"   {{ $mType == 'route'   ? 'selected' : '' }}>{{ SysAutomator::SysAutomatorGetTranslateWord($textos['page']) }}</option>
                              <option value="link"    {{ $mType == 'link'    ? 'selected' : '' }}>{{ SysAutomator::SysAutomatorGetTranslateWord($textos['link']) }}</option>
                              <option value="button"  {{ $mType == 'button'  ? 'selected' : '' }}>{{ SysAutomator::SysAutomatorGetTranslateWord($textos['button']) }}</option>
                              <option value="divider" {{ $mType == 'divider' ? 'selected' : '' }}>{{ SysAutomator::SysAutomatorGetTranslateWord($textos['divider']) }}</option>
                            
                            </select>
                          
                          </div>

                          <div class="col-12 col-md-6 menu-itens-rota {{ $mType != 'route' ? 'd-none' : '' }}">
                            
                            <label for="tbl_sys_route_ID-{{ $mID }}" class="form-label fw-bold text-uppercase small mb-1">{{ SysAutomator::SysAutomatorGetTranslateWord($textos['page']) }}</label>
                            <select id="tbl_sys_route_ID-{{ $mID }}" name="tbl_sys_route_ID" class="form-select form-select-sm">
                              
                              <option value="0" {{ $mRouteID == 0 ? 'selected' : '' }}>- {{ SysAutomator::SysAutomatorGetTranslateWord($textos['select']) }} -</option>
                              @foreach($paginas as $pagina)
                                
                                <option value="{{ $pagina->tbl_sys_route_ID }}" {{ $mRouteID == $pagina->tbl_sys_route_ID ? 'selected' : '' }}>{{ $pagina->tbl_sys_route_title }}</option>
                              
                              @endforeach
                            
                            </select>
                          
                          </div>

                          <div class="col-12 col-md-6 menu-itens-link {{ $mType != 'link' ? 'd-none' : '' }}">
                            
                            <label for="tbl_sys_menu_item_link-{{ $mID }}" class="form-label fw-bold text-uppercase small mb-1">{{ SysAutomator::SysAutomatorGetTranslateWord($textos['link']) }}</label>
                            <input id="tbl_sys_menu_item_link-{{ $mID }}" type="text" name="tbl_sys_menu_item_link" value="{{ $mLink }}" placeholder="{{ SysAutomator::SysAutomatorGetTranslateWord($textos['link']) }}" class="form-control form-control-sm" />
                          
                          </div>

                          <div class="col-12 col-md-6 icon-picker-container" data-automator-icon-picker="true" >

                            <label for="tbl_sys_menu_item_icon_search-{{ $mID }}" class="form-label fw-bold text-uppercase small mb-1" >{{ SysAutomator::SysAutomatorGetTranslateWord($textos['icon']) }}</label>

                            <input type="hidden" id="tbl_sys_menu_item_icon-{{ $mID }}" name="tbl_sys_menu_item_icon" value="{{ trim(str_replace(['fa-solid fa-', 'fa fa-', 'fas fa-'], '', $mIcone)) }}" class="icon-picker-value" />

                            <div class="icon-search-wrapper">

                              <i class="fa fa-{{ $mIcone !== '' ? trim(str_replace(['fa-solid fa-', 'fa fa-', 'fas fa-'], '', $mIcone)) : 'magnifying-glass' }} icon-search-prefix current-icon-display" aria-hidden="true"></i>

                              <input id="tbl_sys_menu_item_icon_search-{{ $mID }}" type="text" value="" class="form-control form-control-sm icon-search-input" placeholder="{{ SysAutomator::SysAutomatorGetTranslateWord($textos['icon-search']) }}" autocomplete="off" onfocus="showIconPicker(this)" oninput="filterIcons(this)" />

                            </div>

                            <div class="icon-picker-dropdown" role="listbox" aria-label="{{ SysAutomator::SysAutomatorGetTranslateWord($textos['icon']) }}">

                              <div class="icon-picker-grid"></div>

                            </div>

                          </div>

                          @if($deleteON == true)

                            <div class="col-12 col-md-6">
                            
                              <label for="tbl_sys_menu_item_locked-{{ $mID }}" class="form-label fw-bold text-uppercase small mb-1">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['admin-locked']) !!}</label>
                              <select id="tbl_sys_menu_item_locked-{{ $mID }}" name="tbl_sys_menu_item_locked" class="form-select form-select-sm">
                                
                                <option value="1"   {{ $mLocked == '1'   ? 'selected' : '' }}>{!! SysAutomator::SysAutomatorGetTranslateWord($textos['yes']) !!}</option>
                                <option value="0" {{ $mLocked == '0' ? 'selected' : '' }}>{!! SysAutomator::SysAutomatorGetTranslateWord($textos['no']) !!}</option>
                              
                              </select>
                            
                            </div>

                          @endif

                          <div class="col-12 m-0 p-0"></div>
                          <div class="col-12 col-md-4">
                            
                            <label for="tbl_sys_menu_item_admin-{{ $mID }}" class="form-label fw-bold text-uppercase small mb-1">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['admin-area']) !!}</label>
                            <select id="tbl_sys_menu_item_admin-{{ $mID }}" name="tbl_sys_menu_item_admin" class="form-select form-select-sm" onchange="atualizarDisplayUsersTypes(this)">
                              
                              @if( (isset($_nav['tbl_sys_nav_admin'])) && ($_nav['tbl_sys_nav_admin'] == true) )
                                
                                <option value="1" selected>{!! SysAutomator::SysAutomatorGetTranslateWord($textos['yes']) !!}</option>
                                <option value="0" disabled>{!! SysAutomator::SysAutomatorGetTranslateWord($textos['no']) !!}</option>

                              @else

                                <option value="1" {{ $mAdmin == '1'   ? 'selected' : '' }}>{!! SysAutomator::SysAutomatorGetTranslateWord($textos['yes']) !!}</option>
                                <option value="0" {{ $mAdmin == '0' ? 'selected' : '' }}>{!! SysAutomator::SysAutomatorGetTranslateWord($textos['no']) !!}</option>

                              @endif
                            
                            </select>
                          
                          </div>

                          <div id="tbl_sys_menu_item_users_types-{{ $mID }}" class="col-12 col-md-8 menu-itens-users-types{{ $mAdmin == '0' ? ' d-none' : '' }}">
                            
                            <div class="col-12"><span class="form-label fw-bold text-uppercase small mb-1">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['permissions']) !!}</span></div>
                            <div class="dropdown">

                              <button id="tbl_sys_menu_item_access_{{ $mID }}-btn" type="button" class="btn btn-sm dropdown-toggle form-select" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['permissions']) !!} - <i><b>{!! ( (count($mAccessVals) >= 1) ? SysAutomator::SysAutomatorCountMenuItemUserTypesAccessValues($usersTypes, $mAccessVals) : '0' ) !!}</b> {!! SysAutomator::SysAutomatorGetTranslateWord($textos['selected']) !!}</i></button>
                              <div class="dropdown-menu p-2 shadow" style="min-width: 220px;">

                                @foreach($usersTypes as $_userTypeID => $_userTypeName)

                                  <div class="form-check mb-2">

                                    <label for="tbl_sys_menu_item_access_{{ $mID }}-{{ $_userTypeID }}" class="form-check-label small w-100">

                                      <input id="tbl_sys_menu_item_access_{{ $mID }}-{{ $_userTypeID }}" onchange="atualizarContagemUserTypesCheckbox(this)" name="tbl_sys_menu_item_access" type="checkbox" value="{{ $_userTypeID }}" class="form-check-input" {!! ( (count($mAccessVals) >= 1) ? ( (in_array($_userTypeID, array_values($mAccessVals))) ? 'checked' : '' ) : '' ) !!} />
                                      {!! $_userTypeName !!}
                                    
                                    </label>

                                  </div>

                                @endforeach

                              </div>

                            </div>
                          
                          </div>

                          <div class="col-12 mt-4">
                            
                            <div class="col-12 mb-3"><span class="form-label fw-bold text-uppercase small mb-1 me-2">{{ SysAutomator::SysAutomatorGetTranslateWord($textos['props']) }}</span> <button type="button" class="btn btn-secondary btn-sm" style="font-size: 10px;" data-bs-toggle="tooltip" data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['add-prop']) !!}" onclick="addMenuProp({{ $mID }}, this);"><i class="fa fa-plus"></i></button></div>
                            <div class="col-12 menu-item-props" data-item="{{ $mID }}" data-zero="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['no-props-found-in-menu-item']) !!}">

                              @if(is_array($mProps))

                                @if(count($mProps) >= 1)

                                  @php

                                    $mPropCount = 0;

                                  @endphp
                                  @foreach($mProps as $mPropKey => $mPropValue)

                                    <div class="row menu-item-props-item" data-prop="{{ $mPropCount }}">

                                      <div class="col-12 col-md-5 mb-3">
                                        
                                        <div class="form-floating">

                                          <input type="text" class="form-control" id="menu-item-prop-{{ $mID }}-key-{{ $mPropCount }}" placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-prop-name']) !!}" value="{!! $mPropKey !!}" />
                                          <label for="menu-item-prop-{{ $mID }}-key-{{ $mPropCount }}">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-prop-name']) !!}</label>
                                          
                                        </div>

                                      </div>
                                      <div class="col-12 col-md-5 mb-3">

                                        <div class="form-floating">

                                          <input type="text" class="form-control" id="menu-item-prop-{{ $mID }}-value-{{ $mPropCount }}" placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-prop-value']) !!}" value="{!! $mPropValue !!}" />
                                          <label for="menu-item-prop-{{ $mID }}-value-{{ $mPropCount }}">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-prop-value']) !!}</label>
                                          
                                        </div>
                                        
                                      </div>
                                      <div class="col-12 col-md-2 mb-3"><button class="btn btn-danger btn-sm w-100 text-center h-100" data-bs-toggle="tooltip" data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-prop-remove']) !!}" onclick="removeMenuProp({{ $mID }}, {{ $mPropCount }}, this, false)"><i class="fa fa-trash"></i></button></div>

                                    </div>
                                      
                                    @php

                                      $mPropCount++;
                                      
                                    @endphp

                                  @endforeach

                                @else

                                  <div class="row"><div class="col-12 text-center">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['no-props-found-in-menu-item']) !!}</div></div>

                                @endif

                              @else

                                <div class="row"><div class="col-12 text-center">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['no-props-found-in-menu-item']) !!}</div></div>

                              @endif

                            </div>
                          
                          </div>

                        </div>

                      </div>


                      <div class="submenu-list transition-transform duration-200 mx-3 my-0 {!! ( (!$mHasSubs) ? 'd-none' : '' ) !!}" data-parent-id="{{ $mID }}">

                        @foreach($mSubs as $submenu)

                          @php

                            $mSubAccess   = $submenu['access'] ?? [];
                            $mSubAccessVals = ( (count($mSubAccess) >= 1) ? SysAutomator::SysAutomatorFormatMenuItemUserTypesAccessValues($mSubAccess) : [] );
                            $canDeleteSub = $submenu['tbl_sys_menu_item_can_delete'] ?? [];
                            $deleteSubON  = (
                              (
                                ($user !== null) &&
                                (is_array($user))
                              )
                              ? (
                                  (
                                    (isset($user['tbl_user_types_IDs'])) &&
                                    (is_array($user['tbl_user_types_IDs'])) &&
                                    (count($user['tbl_user_types_IDs']) >= 1)
                                  )
                                  ? (
                                      (
                                        is_array($canDeleteSub) &&
                                        count(array_intersect($user['tbl_user_types_IDs'], $canDeleteSub)) >= 1
                                      )
                                      ? true : false
                                    )
                                  : false
                                )
                              : false
                            );
                            $mPropsSub    = $submenu['tbl_sys_menu_item_props']      ?? '';
                            $mPropsSub    = ( ($mPropsSub != '') ? json_decode($mPropsSub, true) : '' );

                          @endphp
                          
                          <div class="menu-item-wrapper submenu-item" data-id="{{ $submenu['tbl_sys_menu_item_ID'] }}">
                            <div class="menu-item group group-child bg-white border rounded-2 card transition-all">
                              <div class="card-body d-flex align-items-center py-2 px-3 cursor-move handle">
                                
                                <span class="text-secondary me-3"><i class="fa fa-grip-vertical"></i></span>

                                <div class="flex-grow-1 d-flex align-items-center gap-3">
                          
                                  <span class="menu-item-nome fw-bold text-dark">{{ $submenu['tbl_sys_menu_item_title'] }}</span>
                                
                                </div>

                                <div class="d-flex align-items-center gap-3">

                                  <span class="menu-item-status badge rounded-pill {{ $submenu['tbl_sys_menu_item_status'] === 'ativo' ? 'text-bg-success' : 'text-bg-danger' }}">{{ ucfirst(SysAutomator::SysAutomatorGetTranslateWord($textos['status-' . $submenu['tbl_sys_menu_item_status']])) }}</span>

                                  <button type="button" onclick="toggleAccordion('item-{{ $submenu['tbl_sys_menu_item_ID'] }}')" class="btn btn-link btn-sm text-secondary p-1" data-bs-toggle="tooltip" data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['edit-menu']) !!}"><i id="icon-item-{{ $submenu['tbl_sys_menu_item_ID'] }}" class="fa fa-pencil transition-transform duration-200"></i></button>

                                  @if($deleteSubON == true)

                                    <button type="button" onclick="deleteMenuItem({{ $submenu['tbl_sys_menu_item_ID'] }}, this)" class="btn btn-link btn-sm text-danger p-1" data-bs-toggle="tooltip" data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['remove-menu']) !!}"><i class="fa-solid fa-trash"></i></button>

                                  @else

                                    <button type="button" class="btn btn-link btn-sm text-danger p-1 opacity-75" style="cursor: not-allowed;" data-bs-toggle="tooltip" data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['remove-menu-off']) !!}"><i class="fa-solid fa-trash"></i></button>

                                  @endif

                                </div>

                              </div>

                              <div id="content-item-{{ $submenu['tbl_sys_menu_item_ID'] }}" class="d-none menu-item-body">
                                
                                <input type="hidden" class="menu-item-parent-val" value="{{ $submenu['tbl_sys_menu_item_parent_id'] }}" />
                                <div class="row g-3">
                                  
                                  <div class='col-12 col-md-6'>
                                    
                                    <label for="tbl_sys_menu_item_title-{{ $submenu['tbl_sys_menu_item_ID'] }}" class="form-label fw-bold text-uppercase small mb-1">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-rotulo']) !!}</label>
                                    <input type="text" id="tbl_sys_menu_item_title-{{ $submenu['tbl_sys_menu_item_ID'] }}" name="tbl_sys_menu_item_title" value="{{ $submenu['tbl_sys_menu_item_title'] }}" class="form-control form-control-sm" onkeyup="atualizarNomeMenu(this)" placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-rotulo']) !!}" />
                                  
                                  </div>
                                  
                                  <div class="col-12 col-md-6">
                                    
                                    <label for="tbl_sys_menu_item_status-{{ $submenu['tbl_sys_menu_item_ID'] }}" class="form-label fw-bold text-uppercase small mb-1">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-status']) !!}</label>
                                    <select id="tbl_sys_menu_item_status-{{ $submenu['tbl_sys_menu_item_ID'] }}" name="tbl_sys_menu_item_status" class="form-select form-select-sm" onchange="return atualizarStatusMenu(this)">
                                      
                                      <option value="ativo" {{ ( ($submenu['tbl_sys_menu_item_status'] == 'ativo') ? 'selected' : '' ) }}>{{ ucfirst(SysAutomator::SysAutomatorGetTranslateWord($textos['status-ativo'])) }}</option>
                                      <option value="inativo" {{ ( ($submenu['tbl_sys_menu_item_status'] == 'inativo') ? 'selected' : '' ) }}>{{ ucfirst(SysAutomator::SysAutomatorGetTranslateWord($textos['status-inativo'])) }}</option>
                                    
                                    </select>
                                  
                                  </div>
                                  
                                  <div class="col-12 col-md-6">
                                    
                                    <label for="tbl_sys_menu_item_index-{{ $submenu['tbl_sys_menu_item_ID'] }}" class="form-label fw-bold text-uppercase small mb-1">{{ SysAutomator::SysAutomatorGetTranslateWord($textos['menu-item-id']) }}</label>
                                    <input id="tbl_sys_menu_item_index-{{ $submenu['tbl_sys_menu_item_ID'] }}" type="text" name="tbl_sys_menu_item_index" value="{{ $submenu['tbl_sys_menu_item_index'] }}" class="form-control form-control-sm" />
                                  
                                  </div>
                                  
                                  <div class="col-12 col-md-6">
                                    
                                    <label for="tbl_sys_menu_item_class-{{ $submenu['tbl_sys_menu_item_ID'] }}" class="form-label fw-bold text-uppercase small mb-1">{{ SysAutomator::SysAutomatorGetTranslateWord($textos['menu-item-classes']) }}</label>
                                    <input id="tbl_sys_menu_item_class-{{ $submenu['tbl_sys_menu_item_ID'] }}" type="text" name="tbl_sys_menu_item_class" value="{{ $submenu['tbl_sys_menu_item_class'] }}" placeholder="{{ SysAutomator::SysAutomatorGetTranslateWord($textos['menu-item-id']) }}" class="form-control form-control-sm" />
                                  
                                  </div>
                                  
                                  <div class="col-12 col-md-6">
                                    
                                    <label for="tbl_sys_menu_item_type-{{ $submenu['tbl_sys_menu_item_ID'] }}" class="form-label fw-bold text-uppercase small mb-1">{{ SysAutomator::SysAutomatorGetTranslateWord($textos['menu-item-type']) }}</label>
                                    <select id="tbl_sys_menu_item_type-{{ $submenu['tbl_sys_menu_item_ID'] }}" name="tbl_sys_menu_item_type" class="form-select form-select-sm" onchange="atualizarTipoMenu(this)">
                                      
                                      <option value="route" {{ ( ($submenu['tbl_sys_menu_item_type'] == 'route') ? 'selected' : '' ) }}>{{ SysAutomator::SysAutomatorGetTranslateWord($textos['page']) }}</option>
                                      <option value="link" {{ ( ($submenu['tbl_sys_menu_item_type'] == 'link') ? 'selected' : '' ) }}>{{ SysAutomator::SysAutomatorGetTranslateWord($textos['link']) }}</option>
                                      <option value="button" {{ ( ($submenu['tbl_sys_menu_item_type'] == 'button') ? 'selected' : '' ) }}>{{ SysAutomator::SysAutomatorGetTranslateWord($textos['button']) }}</option>
                                      <option value="divider" {{ ( ($submenu['tbl_sys_menu_item_type'] == 'divider') ? 'selected' : '' ) }}>{{ SysAutomator::SysAutomatorGetTranslateWord($textos['divider']) }}</option>
                                    
                                    </select>
                                  
                                  </div>
                                  <div class="col-12 col-md-6 menu-itens-rota {{ ( ($submenu['tbl_sys_menu_item_type'] != 'route') ? 'd-none' : '' ) }}">
                                    
                                    <label for="tbl_sys_route_ID-{{ $submenu['tbl_sys_menu_item_ID'] }}" class="form-label fw-bold text-uppercase small mb-1">{{ SysAutomator::SysAutomatorGetTranslateWord($textos['page']) }}</label>
                                    <select id="tbl_sys_route_ID-{{ $submenu['tbl_sys_menu_item_ID'] }}" name="tbl_sys_route_ID" class="form-select form-select-sm">
                                      
                                      <option value="" {!! ( (isset($submenu['tbl_sys_route_ID']) == '0') ? 'selected' : '' ) !!}>- {{ SysAutomator::SysAutomatorGetTranslateWord($textos['select']) }} -</option>
                                      @foreach($paginas as $pagina)
                                        
                                        <option value="{{ $pagina->tbl_sys_route_ID }}" {!! ( ( (isset($submenu['tbl_sys_route_ID'])) && ($submenu['tbl_sys_route_ID'] !== null) && ($submenu['tbl_sys_route_ID'] == $pagina->tbl_sys_route_ID) ) ? 'selected' : '' ) !!}>{{ $pagina->tbl_sys_route_title }}</option>
                                      
                                      @endforeach
                                    
                                    </select>
                                  
                                  </div>

                                  <div class="col-12 col-md-6 menu-itens-link {{ ( ($submenu['tbl_sys_menu_item_type'] != 'link') ? 'd-none' : '' ) }}">
                                    
                                    <label for="tbl_sys_menu_item_link-{{ $submenu['tbl_sys_menu_item_ID'] }}" class="form-label fw-bold text-uppercase small mb-1">{{ SysAutomator::SysAutomatorGetTranslateWord($textos['link']) }}</label>
                                    <input id="tbl_sys_menu_item_link-{{ $submenu['tbl_sys_menu_item_ID'] }}" type="text" name="tbl_sys_menu_item_link" value="{{ $submenu['tbl_sys_menu_item_link'] }}" placeholder="{{ SysAutomator::SysAutomatorGetTranslateWord($textos['link']) }}" class="form-control form-control-sm" />
                                  
                                  </div>

                                  @if($deleteSubON == true)

                                    <div class="col-12 col-md-6">
                                    
                                      <label for="tbl_sys_menu_item_locked-{{ $submenu['tbl_sys_menu_item_ID'] }}" class="form-label fw-bold text-uppercase small mb-1">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['admin-locked']) !!}</label>
                                      <select id="tbl_sys_menu_item_locked-{{ $submenu['tbl_sys_menu_item_ID'] }}" name="tbl_sys_menu_item_locked" class="form-select form-select-sm">
                                        
                                        <option value="1"   {{ $submenu['tbl_sys_menu_item_locked'] == '1'   ? 'selected' : '' }}>{!! SysAutomator::SysAutomatorGetTranslateWord($textos['yes']) !!}</option>
                                        <option value="0" {{ $submenu['tbl_sys_menu_item_locked'] == '0' ? 'selected' : '' }}>{!! SysAutomator::SysAutomatorGetTranslateWord($textos['no']) !!}</option>
                                      
                                      </select>
                                    
                                    </div>

                                  @endif

                                  <div class="col-12 m-0 p-0"></div>
                                  <div class="col-12 col-md-5">
                            
                                    <label for="tbl_sys_menu_item_admin-{{ $submenu['tbl_sys_menu_item_ID'] }}" class="form-label fw-bold text-uppercase small mb-1">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['admin-area']) !!}</label>
                                    <select id="tbl_sys_menu_item_admin-{{ $submenu['tbl_sys_menu_item_ID'] }}" name="tbl_sys_menu_item_admin" class="form-select form-select-sm" onchange="atualizarDisplayUsersTypes(this)">
                                      
                                      <option value="1"   {{ $submenu['tbl_sys_menu_item_admin'] == '1'   ? 'selected' : '' }}>{!! SysAutomator::SysAutomatorGetTranslateWord($textos['yes']) !!}</option>
                                      <option value="0" {{ $submenu['tbl_sys_menu_item_admin'] == '0' ? 'selected' : '' }}>{!! SysAutomator::SysAutomatorGetTranslateWord($textos['no']) !!}</option>
                                    
                                    </select>
                                  
                                  </div>

                                  <div id="tbl_sys_menu_item_users_types-{{ $submenu['tbl_sys_menu_item_ID'] }}" class="col-12 col-md-7 menu-itens-users-types{{ $submenu['tbl_sys_menu_item_admin'] == '0' ? ' d-none' : '' }}">
                            
                                    <div class="col-12"><span class="form-label fw-bold text-uppercase small mb-1">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['permissions']) !!}</span></div>
                                    <div class="dropdown">

                                      <button id="tbl_sys_menu_item_access_{{ $submenu['tbl_sys_menu_item_ID'] }}-btn" type="button" class="btn btn-sm dropdown-toggle form-select" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['permissions']) !!} - <i><b>{!! ( (count($mSubAccessVals) >= 1) ? SysAutomator::SysAutomatorCountMenuItemUserTypesAccessValues($usersTypes, $mSubAccessVals) : '0' ) !!}</b> {!! SysAutomator::SysAutomatorGetTranslateWord($textos['selected']) !!}</i></button>
                                      <div class="dropdown-menu p-2 shadow" style="min-width: 220px;">

                                        @foreach($usersTypes as $_userTypeID => $_userTypeName)

                                          <div class="form-check mb-2">

                                            <label for="tbl_sys_menu_item_access_{{ $submenu['tbl_sys_menu_item_ID'] }}-{{ $_userTypeID }}" class="form-check-label small w-100">

                                              <input id="tbl_sys_menu_item_access_{{ $submenu['tbl_sys_menu_item_ID'] }}-{{ $_userTypeID }}" onchange="atualizarContagemUserTypesCheckbox(this)" name="tbl_sys_menu_item_access" type="checkbox" value="{{ $_userTypeID }}" class="form-check-input" {!! ( (count($mSubAccessVals) >= 1) ? ( (in_array($_userTypeID, array_values($mSubAccessVals))) ? 'checked' : '' ) : '' ) !!} />
                                              {!! $_userTypeName !!}
                                            
                                            </label>

                                          </div>

                                        @endforeach

                                      </div>

                                    </div>
                                  
                                  </div>

                                  <div class="col-12 mt-4">
                                    
                                    <div class="col-12 mb-3"><span class="form-label fw-bold text-uppercase small mb-1 me-2">{{ SysAutomator::SysAutomatorGetTranslateWord($textos['props']) }}</span> <button type="button" class="btn btn-secondary btn-sm" style="font-size: 10px;" data-bs-toggle="tooltip" data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['add-prop']) !!}" onclick="addMenuProp({{ $submenu['tbl_sys_menu_item_ID'] }}, this, true);"><i class="fa fa-plus"></i></button></div>
                                    <div class="col-12 menu-item-props-subs" data-item="{{ $submenu['tbl_sys_menu_item_ID'] }}" data-zero="{{ SysAutomator::SysAutomatorGetTranslateWord($textos['no-props-found-in-menu-item']) }}">

                                      @if(is_array($mPropsSub))

                                        @if(count($mPropsSub) >= 1)

                                          @php

                                            $mPropCountSub = 0;

                                          @endphp
                                          @foreach($mPropsSub as $mPropKeySub => $mPropValueSub)

                                            <div class="row menu-item-props-item" data-prop="{{ $mPropCountSub }}">

                                              <div class="col-12 col-md-5 mb-3">
                                                
                                                <div class="form-floating">

                                                  <input type="text" class="form-control" id="menu-item-prop-{{ $submenu['tbl_sys_menu_item_ID'] }}-sub-key-{{ $mPropCountSub }}" placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-prop-name']) !!}" value="{!! $mPropKeySub !!}" />
                                                  <label for="menu-item-prop-{{ $submenu['tbl_sys_menu_item_ID'] }}-sub-key-{{ $mPropCountSub }}">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-prop-name']) !!}</label>
                                                  
                                                </div>

                                              </div>
                                              <div class="col-12 col-md-5 mb-3">

                                                <div class="form-floating">

                                                  <input type="text" class="form-control" id="menu-item-prop-{{ $submenu['tbl_sys_menu_item_ID'] }}-sub-value-{{ $mPropCountSub }}" placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-prop-value']) !!}" value="{!! $mPropValueSub !!}" />
                                                  <label for="menu-item-prop-{{ $submenu['tbl_sys_menu_item_ID'] }}-sub-value-{{ $mPropCountSub }}">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-prop-value']) !!}</label>
                                                  
                                                </div>
                                                
                                              </div>
                                              <div class="col-12 col-md-2 mb-3"><button class="btn btn-danger btn-sm w-100 text-center h-100" data-bs-toggle="tooltip" data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-prop-remove']) !!}" onclick="removeMenuProp({{ $submenu['tbl_sys_menu_item_ID'] }}, {{ $mPropCountSub }}, this, true)"><i class="fa fa-trash"></i></button></div>

                                            </div>
                                              
                                            @php

                                              $mPropCountSub++;
                                              
                                            @endphp

                                          @endforeach

                                        @else

                                          <div class="row"><div class="col-12 text-center">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['no-props-found-in-menu-item']) !!}</div></div>

                                        @endif

                                      @else

                                        <div class="row"><div class="col-12 text-center">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['no-props-found-in-menu-item']) !!}</div></div>

                                      @endif

                                    </div>
                                  
                                  </div>
                                
                                </div>
                              
                              </div>
                            
                            </div>
                          
                          </div>
                        
                        @endforeach
                      
                      </div>



                    </div>

                  </div>

                @endforeach

              @else

                <div id="menu-sortable-list-empty" class="text-center fs-4">{!! SysAutomator::SysAutomatorGetTranslateWord('Nenhum item cadastrado!') !!}</div>

              @endif

            </div>

          </div>

        </div>

      </div>
      
    </div>

  </div>

</form>

<script type="text/javascript">


  function validateCurrentMenuSelection(formulario) {

    var form = $(formulario);

    AutomatorGetActionStatus(function() {

      AutomatorSetActionStatus(true, function() {

        AutomatorPageLoader('show', function() {

          $.ajax({

            url: form.attr('action'),
            type: form.attr('method'),
            data: form.serialize(),
            headers: {
              'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
              'Accept': 'application/json'
            },
            dataType: 'json',
            success: function(response) {

              console.log(response);
              if(response.status == true) {

                AutomatorSetActionStatus(false, function() {

                  if(response.redirect_url) {

                    window.location.href = response.redirect_url;

                  }

                });

              } else {

                if(xhr.status == 419) {

                  alert('Sua sessão expirou. A página será recarregada para atualizar o token de segurança.');

                  window.location.reload();

                  return;

                }

                var message = 'Não foi selecionar o menu.';

                if(xhr.responseJSON && xhr.responseJSON.message) {

                  message = xhr.responseJSON.message;

                } else if(xhr.responseText) {

                  message = xhr.responseText;

                }

                alert(message);

                AutomatorPageLoader('hide', function() {

                  AutomatorSetActionStatus(false);

                });

              }

              return false;

            },
            error: function(xhr) {

              var message = 'Não foi possível selecionar o menu.';

              if(xhr.responseJSON && xhr.responseJSON.message) {

                message = xhr.responseJSON.message;

              } else if(xhr.responseText) {

                message = xhr.responseText;

              }

              alert(message);

              AutomatorPageLoader('hide', function() {

                AutomatorSetActionStatus(false);

              });

            }

          });

          return false;


        });

      });

    });

    return false;

  }


  function enableCurrentMenuChangeSubmit(field, currentMenu) {


    var el = $(field);
    var valor = el.val();
    var form = $('#current-menu-form-change');
    var btn = form.find("button[type='submit']");

    if(valor != currentMenu) {

      btn.removeClass('disabled');

    } else {

      btn.addClass('disabled');

    }




  }


  // Lista de ícones FontAwesome comuns para o picker
  const faIcons = [

    'house', 'user', 'check', 'download', 'image', 'phone', 'bars', 'envelope', 'star', 'location-dot',
    'music', 'heart', 'arrow-right', 'circle-xmark', 'cloud', 'comment', 'gear', 'trash', 'calendar',
    'bolt', 'camera', 'bell', 'link', 'paperclip', 'lock', 'eye', 'magnifying-glass', 'pen', 'plus',
    'minus', 'circle-info', 'circle-question', 'cart-shopping', 'bag-shopping', 'credit-card', 'chart-line',
    'newspaper', 'book', 'bookmark', 'graduation-cap', 'laptop', 'display', 'mobile-screen', 'print',
    'database', 'code', 'terminal', 'bug', 'flask', 'earth-americas', 'globe', 'map', 'compass', 'flag', 'gauge', 'shield-halved'
  
  ];


  let menuChanged = false;


  function setMenuChanged() {

    menuChanged = true;
    document.getElementById('gerenciar-menu-save').disabled = false;
    document.getElementById('gerenciar-menu-save').classList.remove('disabled');
  
  }



  // Monitorar alterações em inputs e selects
  document.addEventListener('change', function(e) {
    
    if (e.target.closest('.menu-item-wrapper') || e.target.closest('#menu-sortable-list')) {
      setMenuChanged();
    }

  });



  document.addEventListener('input', function(e) {

    if (e.target.closest('.menu-item-wrapper') || e.target.closest('#menu-sortable-list')) {

      setMenuChanged();

    }

  });



  // Alerta de saída se houver alterações
  window.onbeforeunload = function() {
    
    if (menuChanged) {
      
      return "Você tem alterações não salvas. Se fechar ou atualizar a janela, as alterações podem ser perdidas.";
    
    }
  
  };


  function AutomatorMenuCurrentUserIsDeveloper() {


    @php

      $automatorMenuUserIsDeveloper = false;


      if(

        isset($user) &&

        is_array($user) &&

        isset($user['tbl_user_types_IDs']) &&

        is_array($user['tbl_user_types_IDs']) &&

        isset($usersTypes) &&

        is_array($usersTypes)

      ) {


        foreach($user['tbl_user_types_IDs'] as $automatorMenuUserTypeID) {


          if(!isset($usersTypes[$automatorMenuUserTypeID])) {

            continue;

          }


          $automatorMenuUserTypeName = mb_strtolower(

            trim(

              (string) $usersTypes[$automatorMenuUserTypeID]

            ),

            'UTF-8'

          );


          if($automatorMenuUserTypeName === 'desenvolvedor') {


            $automatorMenuUserIsDeveloper = true;

            break;


          }


        }


      }

    @endphp


    return {!! $automatorMenuUserIsDeveloper === true ? 'true' : 'false' !!};


  }



  function AutomatorMenuRemoveLockedFields(
    container = document
  ) {


    if(

      AutomatorMenuCurrentUserIsDeveloper() ===

      true

    ) {

      return true;

    }


    if(!container) {

      container = document;

    }


    var lockedFields = [];


    if(

      container.matches &&

      container.matches(

        'select[name="tbl_sys_menu_item_locked"]'

      )

    ) {


      lockedFields.push(

        container

      );


    }


    if(container.querySelectorAll) {


      container.querySelectorAll(

        'select[name="tbl_sys_menu_item_locked"]'

      ).forEach(function(lockedField) {


        if(!lockedFields.includes(lockedField)) {


          lockedFields.push(

            lockedField

          );


        }


      });


    }


    lockedFields.forEach(function(lockedField) {


      var fieldContainer = lockedField.closest(

        '.col-12'

      );


      if(fieldContainer) {


        fieldContainer.remove();


      } else {


        lockedField.remove();


      }


    });


    return true;


  }



  function AutomatorMenuObserveLockedFields() {


    AutomatorMenuRemoveLockedFields(

      document

    );


    if(

      AutomatorMenuCurrentUserIsDeveloper() ===

      true

    ) {

      return true;

    }


    if(

      window.AutomatorMenuLockedFieldsObserver

    ) {


      window.AutomatorMenuLockedFieldsObserver.disconnect();


    }


    window.AutomatorMenuLockedFieldsObserver =

      new MutationObserver(function(mutations) {


        mutations.forEach(function(mutation) {


          mutation.addedNodes.forEach(function(node) {


            if(

              !node ||

              node.nodeType !== 1

            ) {

              return;

            }


            AutomatorMenuRemoveLockedFields(

              node

            );


          });


        });


      });


    window.AutomatorMenuLockedFieldsObserver.observe(

      document.getElementById(

        'menu-sortable-list'

      )

      || document.body,

      {

        childList:

          true,

        subtree:

          true,

      }

    );


    return true;


  }


  document.addEventListener('DOMContentLoaded', function () {


    // Funções auxiliares devem ser definidas antes de serem chamadas
    function destroyAllSortables() {

      // Destruir lista principal
      const mainList = document.getElementById('menu-sortable-list');
      if (mainList && mainList.sortable) {

        mainList.sortable.destroy();
        mainList.sortable = null;

      }


      // Destruir todas as sublistas
      document.querySelectorAll('.submenu-list').forEach(list => {
      
        if (list.sortable) {
      
          list.sortable.destroy();
          list.sortable = null;
      
        }
      
      });

    }



    window.initAllSortables = function() {


      destroyAllSortables(); // Limpa tudo antes
      
      // Forçamos um pequeno delay para o navegador processar as mudanças de DOM 
      // antes de reinicializar os sortables, evitando conflitos de estado interno
      setTimeout(function() {

        const mainList = document.getElementById('menu-sortable-list');
        if (mainList) {

          // Sortable para MENUS (nível 0) - só entre menus
          mainList.sortable = new Sortable(mainList, {
            
            group: 'menus-only',
            animation: 150,
            ghostClass: 'ghost-item',
            chosenClass: 'chosen-item',
            handle: '.handle',
            onEnd: function () {

              refreshMenuStructure();
              setMenuChanged();
              window.initAllSortables();

            }

          });

        }


        // Sortable para SUBMENUS (nível 1) - só entre submenus do mesmo menu pai
        document.querySelectorAll('.submenu-list').forEach(list => {
          
          list.sortable = new Sortable(list, {

            group: { name: 'submenus-' + list.dataset.parentId, pull: false, put: false },
            animation: 150,
            ghostClass: 'ghost-item',
            chosenClass: 'chosen-item',
            handle: '.handle',
            onEnd: function () {

              refreshMenuStructure();
              setMenuChanged();
              window.initAllSortables();
            
            }

          });
        
        });

      }, 10);


    };



    // Agora chamamos as funções após suas definições
    window.initAllSortables();
    initIconPickers();
    AutomatorMenuObserveLockedFields();


    window.refreshMenuStructure = function () {


      // Função para atualizar recursivamente os parent_ids nos inputs
      const updateParentInputs = (container, parentId) => {
      
        const wrappers = Array.from(container.children).filter(el => el.classList.contains('menu-item-wrapper'));
        wrappers.forEach(wrapper => {

          // Atualiza o input hidden do parent_id para o item atual
          const parentInput = wrapper.querySelector(':scope > .menu-item > [id^="content-item-"] .menu-item-parent-val');
          if (parentInput) {

            parentInput.value = parentId;

          }

          // Se este item tiver uma lista de submenus, atualiza os filhos dele
          const subList = wrapper.querySelector('.submenu-list');
          if (subList) {

            updateParentInputs(subList, wrapper.dataset.id);

          }

        });
      
      };


      // Atualiza todos os itens a partir da lista principal (parent_id = 0)
      const mainList = document.getElementById('menu-sortable-list');
      if (mainList) {
        
        updateParentInputs(mainList, 0);

      }


      // Atualiza as classes visuais e botões
      document.querySelectorAll('.menu-item-wrapper').forEach(wrapper => {
        
        const menu = wrapper.querySelector(':scope > .menu-item');
        if (!menu) return;

        let submenuList = wrapper.querySelector('.submenu-list');
        const parentList = wrapper.parentElement;

        // MENU PRINCIPAL (Nível 0)
        if (parentList && parentList.id === 'menu-sortable-list') {
          
          menu.classList.remove('group-child');
          menu.classList.add('group-parent');
          
          const title = menu.querySelector('.menu-item-nome');
          if (title) {

            title.classList.remove('text-sm', 'text-gray-800');
            title.classList.add('text-base', 'font-bold', 'text-gray-900');

          }

          const menuId = wrapper.dataset.id;
          const chevronBtn = menu.querySelector('.chevron-btn-' + menuId);
          const banBtn = menu.querySelector('.ban-icon-' + menuId);
          
          if (chevronBtn && banBtn) {
            
            if (submenuList && submenuList.children.length > 0) {
            
              chevronBtn.classList.remove('d-none');
              banBtn.classList.add('d-none');
            
            } else {

              chevronBtn.classList.add('d-none');
              banBtn.classList.remove('d-none');

            }

          }


          // Se não tiver submenu-list, cria uma
          if (!submenuList) {

            submenuList = document.createElement('div');
            submenuList.className = 'submenu-list transition-transform duration-200 ml-12 mt-3 space-y-3';
            submenuList.dataset.parentId = wrapper.dataset.id;
            wrapper.appendChild(submenuList);

          }

        } else if (parentList && parentList.classList.contains('submenu-list')) {
          
          // SUBMENU (Nível 1)

          menu.classList.remove('group-parent');
          menu.classList.add('group-child');

          const title = menu.querySelector('.menu-item-nome');
          if (title) {

            title.classList.remove('text-base', 'font-bold', 'text-gray-900');
            title.classList.add('text-sm', 'font-bold', 'text-gray-800');

          }

          // Esconde botões de expandir em submenus (limite de 2 níveis)
          const chevronBtn = menu.querySelector('button[onclick*="toggleSubmenuDisplay"]');
          const banBtn = menu.querySelector('button[class*="ban-icon-"]');
          if (chevronBtn) chevronBtn.classList.add('d-none');
          if (banBtn) banBtn.classList.add('d-none');

          // Se um submenu tiver sua própria lista de submenus (nível 3+), removemos para manter compatibilidade com o controller
          if (submenuList) {

            if(submenuList.children.length > 0) {

              Array.from(submenuList.children).forEach(child => {

                // Move órfãos para a lista do avô (nível 1)
                parentList.appendChild(child);

              });

            }

            submenuList.remove();

          }

        }


      });


    };


    $(document).on(

      'change keyup',

      '[name="tbl_sys_menu_item_index"]',

      function() {

        updateMenuItemAdminState(

          $(this).closest('.menu-item-wrapper')

        );

      }

    );


    // Fechar picker ao clicar fora
    document.addEventListener('click', function(e) {
      
      if (!e.target.closest('.icon-picker-container')) {
        
        document.querySelectorAll('.icon-picker-dropdown').forEach(d => d.style.display = 'none');
      
      }

    });


  });




    function AutomatorMenuNormalizeIconValue(
      value = ''
    ) {


      value = String(

        value

        || ''

      ).trim();


      value = value.replace(

        /^(fa-solid|fa-regular|fa-brands|fa|fas|far|fab)\s+/,

        ''

      );


      value = value.replace(

        /^fa-/,

        ''

      );


      return value.trim();


    }



    function AutomatorMenuGetIconPickerElements(
      element = null
    ) {


      if(!element) {

        return null;

      }


      var container = element.closest(

        '.icon-picker-container'

      );


      if(!container) {

        return null;

      }


      return {

        container:

          container,

        searchInput:

          container.querySelector(

            '.icon-search-input'

          ),

        valueInput:

          container.querySelector(

            '.icon-picker-value'

          ),

        display:

          container.querySelector(

            '.current-icon-display'

          ),

        dropdown:

          container.querySelector(

            '.icon-picker-dropdown'

          ),

        grid:

          container.querySelector(

            '.icon-picker-grid'

          ),

      };


    }



    function AutomatorMenuUpdateIconPickerDisplay(
      container = null
    ) {


      if(!container) {

        return false;

      }


      var valueInput = container.querySelector(

        '.icon-picker-value'

      );


      var display = container.querySelector(

        '.current-icon-display'

      );


      if(!display) {

        return false;

      }


      var iconValue = AutomatorMenuNormalizeIconValue(

        valueInput

          ? valueInput.value

          : ''

      );


      display.className =

        'fa fa-' +

        (

          iconValue !== ''

            ? iconValue

            : 'magnifying-glass'

        ) +

        ' icon-search-prefix current-icon-display';


      return true;


    }



    function initIconPickers(
      container = document
    ) {


      if(!container) {

        container = document;

      }


      var iconPickers = [];


      if(

        container.matches &&

        container.matches(

          '.icon-picker-container'

        )

      ) {

        iconPickers.push(

          container

        );

      }


      if(container.querySelectorAll) {


        container

          .querySelectorAll(

            '.icon-picker-container'

          )

          .forEach(function(iconPicker) {


            if(!iconPickers.includes(iconPicker)) {

              iconPickers.push(

                iconPicker

              );

            }


          });


      }


      iconPickers.forEach(function(iconPicker) {


        var elements =

          AutomatorMenuGetIconPickerElements(

            iconPicker

          );


        if(!elements) {

          return;

        }


        if(elements.valueInput) {


          elements.valueInput.value =

            AutomatorMenuNormalizeIconValue(

              elements.valueInput.value

            );


        }


        if(elements.searchInput) {


          /*
          |--------------------------------------------------------------------------
          | O input visível serve somente para pesquisa
          |--------------------------------------------------------------------------
          */

          elements.searchInput.removeAttribute(

            'name'

          );


          elements.searchInput.value = '';


        }


        AutomatorMenuUpdateIconPickerDisplay(

          iconPicker

        );


        if(elements.grid) {


          renderIcons(

            elements.grid,

            faIcons

          );


        }


        iconPicker.setAttribute(

          'data-automator-icon-picker-initialized',

          'true'

        );


      });


      return true;


    }



    function renderIcons(
      grid = null,
      icons = []
    ) {


      if(!grid) {

        return false;

      }


      grid.innerHTML = '';


      if(!Array.isArray(icons)) {

        icons = [];

      }


      if(icons.length <= 0) {


        grid.innerHTML =

          '<div ' +

            'class="icon-picker-no-results" ' +

            'style="grid-column: 1 / -1;"' +

          '>' +

            'Nenhum ícone encontrado' +

          '</div>';


        return true;

      }


      icons.forEach(function(icon) {


        icon = AutomatorMenuNormalizeIconValue(

          icon

        );


        if(icon === '') {

          return;

        }


        var item = document.createElement(

          'button'

        );


        item.type = 'button';


        item.className =

          'icon-picker-item border-0 bg-transparent';


        item.setAttribute(

          'data-automator-icon-value',

          icon

        );


        item.setAttribute(

          'role',

          'option'

        );


        item.setAttribute(

          'aria-label',

          icon

        );


        item.innerHTML =

          '<i class="fa fa-' +

            icon +

          '"></i>' +

          '<span>' +

            icon +

          '</span>';


        item.addEventListener(

          'click',

          function(event) {


            event.preventDefault();

            event.stopPropagation();


            var elements =

              AutomatorMenuGetIconPickerElements(

                grid

              );


            if(!elements) {

              return false;

            }


            if(elements.valueInput) {


              elements.valueInput.value =

                icon;


              elements.valueInput.dispatchEvent(

                new Event(

                  'change',

                  {

                    bubbles: true,

                  }

                )

              );


            }


            if(elements.searchInput) {


              /*
              |--------------------------------------------------------------------------
              | Limpa o filtro após selecionar
              |--------------------------------------------------------------------------
              */

              elements.searchInput.value = '';


            }


            AutomatorMenuUpdateIconPickerDisplay(

              elements.container

            );


            if(elements.dropdown) {


              elements.dropdown.style.display =

                'none';


            }


            setMenuChanged();


            return false;


          }

        );


        grid.appendChild(

          item

        );


      });


      return true;


    }



    function showIconPicker(
      input = null
    ) {


      var elements =

        AutomatorMenuGetIconPickerElements(

          input

        );


      if(!elements) {

        return false;

      }


      /*
      |--------------------------------------------------------------------------
      | Fecha os demais pickers
      |--------------------------------------------------------------------------
      */

      document.querySelectorAll(

        '.icon-picker-dropdown'

      ).forEach(function(dropdown) {


        if(dropdown !== elements.dropdown) {


          dropdown.style.display =

            'none';


        }


      });


      /*
      |--------------------------------------------------------------------------
      | Toda vez que receber foco, começa sem filtro
      |--------------------------------------------------------------------------
      */

      if(elements.searchInput) {


        elements.searchInput.value = '';


      }


      if(elements.grid) {


        renderIcons(

          elements.grid,

          faIcons

        );


      }


      if(elements.dropdown) {


        elements.dropdown.style.display =

          'block';


      }


      return true;


    }



    function filterIcons(
      input = null
    ) {


      var elements =

        AutomatorMenuGetIconPickerElements(

          input

        );


      if(!elements || !elements.grid) {

        return false;

      }


      var term = String(

        elements.searchInput

          ? elements.searchInput.value

          : ''

      )
        .trim()
        .toLowerCase();


      var filteredIcons = faIcons.filter(

        function(icon) {


          return String(

            icon

          )
            .toLowerCase()
            .includes(

              term

            );


        }

      );


      renderIcons(

        elements.grid,

        filteredIcons

      );


      if(elements.dropdown) {


        elements.dropdown.style.display =

          'block';


      }


      return true;


    }



    function AutomatorMenuClearIcon(
      element = null
    ) {


      var elements =

        AutomatorMenuGetIconPickerElements(

          element

        );


      if(!elements) {

        return false;

      }


      if(elements.valueInput) {


        elements.valueInput.value = '';


        elements.valueInput.dispatchEvent(

          new Event(

            'change',

            {

              bubbles: true,

            }

          )

        );


      }


      if(elements.searchInput) {


        elements.searchInput.value = '';


      }


      AutomatorMenuUpdateIconPickerDisplay(

        elements.container

      );


      setMenuChanged();


      return true;


    }




  function toggleAccordion(id) {
    
    const content = document.getElementById('content-' + id);
    
    if (content.classList.contains('d-none')) {
    
      content.classList.remove('d-none');
    
    } else {
    
      content.classList.add('d-none');
    
    }
  
  }



  function toggleSubmenuDisplay(btn) {


    var el = $(btn);

    var pai = el.closest(

      '.menu-item-wrapper'

    );


    if(pai.length <= 0) {

      return false;

    }


    var submenuList = pai.find(

      '> .menu-item > .submenu-list'

    );


    if(submenuList.length <= 0) {


      submenuList = pai.find(

        '> .menu-item .submenu-list'

      ).first();


    }


    if(submenuList.length <= 0) {

      return false;

    }


    var icon = el.find(

      'i'

    ).first();


    if(

      submenuList.hasClass(

        'd-none'

      )

    ) {


      submenuList.removeClass(

        'd-none'

      );


      icon.removeClass(

        'fa-chevron-down rotate-180'

      );


      icon.addClass(

        'fa-chevron-up'

      );


      el.attr(

        'aria-expanded',

        'true'

      );


    } else {


      submenuList.addClass(

        'd-none'

      );


      icon.removeClass(

        'fa-chevron-up'

      );


      icon.addClass(

        'fa-chevron-down'

      );


      el.attr(

        'aria-expanded',

        'false'

      );


    }


    return false;


  }



  function atualizarTipoMenu(
    field
  ) {


    var el = $(field);

    var valor = String(

      el.val()

      || ''

    );


    var wrapper = el.closest(

      '.menu-item-wrapper'

    );


    var content = el.closest(

      '.menu-item-body'

    );


    var submenuList = wrapper.children(

      '.submenu-list'

    );


    var hasSubmenus = (

      submenuList.find(

        '> .menu-item-wrapper'

      ).length > 0

    );


    /*
    |--------------------------------------------------------------------------
    | Link não pode possuir submenu
    |--------------------------------------------------------------------------
    */

    if(

      (
        valor === 'link' ||
        valor === 'divider'
      ) &&
      
      hasSubmenus

    ) {


      alert(

        'Não é possível alterar um menu para o tipo "' +

        valor +

        '" quando ele possui submenus. Remova os submenus antes de alterar o tipo.'

      );


      el.val(

        el.attr(

          'data-automator-previous-value'

        )

        || 'route'

      );


      return false;

    }


    el.attr(

      'data-automator-previous-value',

      valor

    );


    var routeContainer = content.find(

      '.menu-itens-rota'

    );


    var linkContainer = content.find(

      '.menu-itens-link'

    );


    var routeSelect = routeContainer.find(

      'select[name="tbl_sys_route_ID"]'

    );


    var linkInput = linkContainer.find(

      'input[name="tbl_sys_menu_item_link"]'

    );


    if(valor === 'route') {


      routeContainer.removeClass(

        'd-none'

      );


      linkContainer.addClass(

        'd-none'

      );


      linkInput.val(

        ''

      );


    } else if(valor === 'link') {


      routeContainer.addClass(

        'd-none'

      );


      routeSelect.val(

        '0'

      );


      linkContainer.removeClass(

        'd-none'

      );


    } else {


      routeContainer.addClass(

        'd-none'

      );


      routeSelect.val(

        '0'

      );


      linkContainer.addClass(

        'd-none'

      );


      linkInput.val(

        ''

      );


    }


    setMenuChanged();


    return true;


  }



  function atualizarNomeMenu(field) {

    var el = $(field);
    var valor = el.val();
    var pai = el.closest('.menu-item-wrapper');
    var nome = pai.find('.menu-item-nome');

    if(valor.length <= 0) {
    
      alert("O Rotulo do menu não pode ser vazio");
      el.val(nome.html());
      return false;
    
    } else {
    
      nome.html(valor);
    
    }
    
    setMenuChanged();
  
  }



  function atualizarStatusMenu(field) {

    var el = $(field);
    var valor = el.val();
    var wrapper = el.closest('.menu-item-wrapper');
    var submenus = wrapper.find('.submenu-list');
    var subItens = submenus.find('.menu-item-wrapper');

    if(valor == 'inativo') {

      // Alterando de ativo para inativo
      if(subItens.length >= 1) {

        if(confirm("Este menu possui sub-menus vinculados a ele. Desativá-lo irá afetar todos os sub-menus. Tem certeza de que deseja realizar esta ação?") == false) {
        
          el.val('ativo');
          return;
        
        }
        
        // Desativar todos os submenus
        subItens.each(function() {
        
          const subSelect = $(this).find('select[name="tbl_sys_menu_item_status"]');
          subSelect.val('inativo');
          const subStatus = $(this).find('.menu-item-status');
          subStatus.html('Inativo').removeClass('text-bg-success').addClass('text-bg-danger');
        
        });
      
      }
      
      wrapper.find('.menu-item-status').first().html('Inativo').removeClass('text-bg-success').addClass('text-bg-danger');
    
    } else {
      
      // Alterando de inativo para ativo
      if(subItens.length >= 1) {
        
        if(confirm("Este menu possui sub-menus vinculados a ele. Deseja ativar também todos os sub-menus?") == false) {
          
          el.val('inativo');
          return;
        
        }
        
        // Ativar todos os submenus
        subItens.each(function() {
        
          const subSelect = $(this).find('select[name="tbl_sys_menu_item_status"]');
          subSelect.val('ativo');
          const subStatus = $(this).find('.menu-item-status');
          subStatus.html('Ativo').addClass('text-bg-success').removeClass('text-bg-danger');
        
        });
      
      }
      
      wrapper.find('.menu-item-status').first().html('Ativo').addClass('text-bg-success').removeClass('text-bg-danger');
    
    }
    
    setMenuChanged();
  
  }



  function deleteMenuItem(id, btn) {


    var wrapper = btn

      ? btn.closest(

          '.menu-item-wrapper'

        )

      : null;


    if(!wrapper) {

      return false;

    }


    var parentMenuWrapper = null;


    if(

      wrapper.classList.contains(

        'submenu-item'

      )

    ) {


      var parentList = wrapper.closest(

        '.submenu-list'

      );


      if(parentList) {


        parentMenuWrapper = parentList.closest(

          '.menu-item-wrapper'

        );


      }


    }


    var submenuList = wrapper.querySelector(

      ':scope > .menu-item > .submenu-list'

    );


    if(!submenuList) {


      submenuList = wrapper.querySelector(

        ':scope > .menu-item .submenu-list'

      );


    }


    var hasSubmenus = (

      submenuList &&

      submenuList.querySelectorAll(

        ':scope > .menu-item-wrapper.submenu-item'

      ).length > 0

    );


    var message =

      'Tem certeza que deseja remover este item?';


    if(hasSubmenus) {


      message =

        'Este menu possui sub-menus. Remover este item também irá remover todos os sub-menus existentes dentro dele. Deseja continuar?';


    }


    if(confirm(message) !== true) {

      return false;

    }


    /*
    |--------------------------------------------------------------------------
    | Remove tooltips do item
    |--------------------------------------------------------------------------
    */

    wrapper.querySelectorAll(

      '[data-bs-toggle="tooltip"]'

    ).forEach(function(element) {


      var tooltip =

        bootstrap.Tooltip.getInstance(

          element

        );


      if(tooltip) {

        tooltip.dispose();

      }


    });


    wrapper.remove();


    if(parentMenuWrapper) {


      AutomatorMenuUpdateSubmenuListState(

        parentMenuWrapper,

        false

      );


    }


    if(

      typeof window.refreshMenuStructure ===

      'function'

    ) {


      window.refreshMenuStructure();


    }


    if(

      typeof window.initAllSortables ===

      'function'

    ) {


      window.initAllSortables();


    }


    AutomatorMenuUpdateEmptyListState();


    setMenuChanged();


    return false;


  }


  function AutomatorMenuCreateTemporaryItemID() {


    return 'temp' +

      Date.now() +

      Math.floor(

        Math.random() *

        999999

      );


  }



  function AutomatorMenuUpdateSubmenuListState(
    menuWrapper,
    forceOpen = false
  ) {


    if(!menuWrapper) {

      return false;

    }


    var submenuList = menuWrapper.querySelector(

      ':scope > .menu-item > .submenu-list'

    );


    /*
    |--------------------------------------------------------------------------
    | Compatibilidade com a estrutura atual do Blade
    |--------------------------------------------------------------------------
    |
    | Atualmente a lista é filha direta de .menu-item.
    |
    */

    if(!submenuList) {

      submenuList = menuWrapper.querySelector(

        ':scope > .menu-item .submenu-list'

      );

    }


    if(!submenuList) {

      submenuList = document.createElement(

        'div'

      );


      submenuList.className =

        'submenu-list transition-transform duration-200 mx-3 my-0 d-none';


      submenuList.setAttribute(

        'data-parent-id',

        menuWrapper.dataset.id

        || ''

      );


      var menuItem = menuWrapper.querySelector(

        ':scope > .menu-item'

      );


      if(menuItem) {

        menuItem.appendChild(

          submenuList

        );

      }


    }


    var menuID = String(

      menuWrapper.dataset.id

      || ''

    );


    var submenuItems = submenuList.querySelectorAll(

      ':scope > .menu-item-wrapper.submenu-item'

    );


    var hasSubmenus =

      submenuItems.length > 0;


    var chevronButton = menuWrapper.querySelector(

      ':scope > .menu-item ' +

      '.chevron-btn-' +

      CSS.escape(

        menuID

      )

    );


    var banButton = menuWrapper.querySelector(

      ':scope > .menu-item ' +

      '.ban-icon-' +

      CSS.escape(

        menuID

      )

    );


    if(hasSubmenus === true) {


      if(chevronButton) {

        chevronButton.classList.remove(

          'd-none'

        );

      }


      if(banButton) {

        banButton.classList.add(

          'd-none'

        );

      }


      if(forceOpen === true) {


        submenuList.classList.remove(

          'd-none'

        );


        if(chevronButton) {


          var chevronIcon =

            chevronButton.querySelector(

              'i'

            );


          if(chevronIcon) {


            chevronIcon.classList.remove(

              'fa-chevron-down'

            );


            chevronIcon.classList.add(

              'fa-chevron-up'

            );


            chevronIcon.classList.remove(

              'rotate-180'

            );


          }


          chevronButton.setAttribute(

            'aria-expanded',

            'true'

          );


        }


      }


    } else {


      submenuList.classList.add(

        'd-none'

      );


      if(chevronButton) {


        chevronButton.classList.add(

          'd-none'

        );


        chevronButton.setAttribute(

          'aria-expanded',

          'false'

        );


      }


      if(banButton) {

        banButton.classList.remove(

          'd-none'

        );

      }


    }


    return submenuList;


  }


  function addSubmenu(menuId) {


    var menuWrapper = document.querySelector(

      '#menu-sortable-list ' +

      '> .menu-item-wrapper[data-id="' +

      CSS.escape(

        String(

          menuId

        )

      ) +

      '"]'

    );


    if(!menuWrapper) {

      return false;

    }


    /*
    |--------------------------------------------------------------------------
    | Verifica o tipo do menu principal
    |--------------------------------------------------------------------------
    */

    var contentMenu = menuWrapper.querySelector(

      ':scope > .menu-item > [id^="content-item-"]'

    );


    var tipoSelect = contentMenu

      ? contentMenu.querySelector(

          'select[name="tbl_sys_menu_item_type"]'

        )

      : null;


    if(

      tipoSelect &&

      (
        tipoSelect.value === 'link' ||
        tipoSelect.value === 'divider'
      )

    ) {


      alert(

        'Não é possível adicionar sub-menus a um menu do tipo "' +

        tipoSelect.value +

        '".'

      );


      return false;

    }


    /*
    |--------------------------------------------------------------------------
    | Localiza ou cria a lista
    |--------------------------------------------------------------------------
    */

    var submenuList = menuWrapper.querySelector(

      ':scope > .menu-item > .submenu-list'

    );


    if(!submenuList) {


      submenuList = menuWrapper.querySelector(

        ':scope > .menu-item .submenu-list'

      );


    }


    if(!submenuList) {


      submenuList = document.createElement(

        'div'

      );


      submenuList.className =

        'submenu-list transition-transform duration-200 mx-3 my-0 d-none';


      submenuList.setAttribute(

        'data-parent-id',

        menuId

      );


      var menuItem = menuWrapper.querySelector(

        ':scope > .menu-item'

      );


      if(!menuItem) {

        return false;

      }


      menuItem.appendChild(

        submenuList

      );


    }


    /*
    |--------------------------------------------------------------------------
    | ID temporário
    |--------------------------------------------------------------------------
    */

    var tempId =

      AutomatorMenuCreateTemporaryItemID();


    /*
    |--------------------------------------------------------------------------
    | HTML do submenu
    |--------------------------------------------------------------------------
    */

    var newSubmenuHTML = `

      <div class="menu-item-wrapper submenu-item" data-id="${tempId}">

        <div class="menu-item group group-child bg-white border rounded-2 card transition-all">

          <div class="card-body d-flex align-items-center py-2 px-3 cursor-move handle">

            <span class="text-secondary me-3">

              <i class="fa fa-grip-vertical"></i>

            </span>

            <div class="flex-grow-1 d-flex align-items-center gap-3">

              <span class="menu-item-nome fw-bold text-dark">
                Novo Submenu
              </span>

            </div>

            <div class="d-flex align-items-center gap-3">

              <span class="menu-item-status badge rounded-pill text-bg-success">
                {!! ucfirst(SysAutomator::SysAutomatorGetTranslateWord($textos['status-ativo'])) !!}
              </span>

              <button
                type="button"
                onclick="toggleAccordion('item-${tempId}')"
                class="btn btn-link btn-sm text-secondary p-1"
                data-bs-toggle="tooltip"
                data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['edit-menu']) !!}"
              >

                <i
                  id="icon-item-${tempId}"
                  class="fa fa-pencil transition-transform duration-200"
                ></i>

              </button>

              <button
                type="button"
                onclick="deleteMenuItem('${tempId}', this)"
                class="btn btn-link btn-sm text-danger p-1"
                data-bs-toggle="tooltip"
                data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['remove-menu']) !!}"
              >

                <i class="fa-solid fa-trash"></i>

              </button>

            </div>

          </div>

          <div id="content-item-${tempId}" class="menu-item-body">

            <input
              type="hidden"
              class="menu-item-parent-val"
              value="${menuId}"
            />

            <div class="row g-3">

              <div class="col-12 col-md-6">

                <label
                  for="tbl_sys_menu_item_title-${tempId}"
                  class="form-label fw-bold text-uppercase small mb-1"
                >
                  {!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-rotulo']) !!}
                </label>

                <input
                  type="text"
                  id="tbl_sys_menu_item_title-${tempId}"
                  name="tbl_sys_menu_item_title"
                  value="Novo Submenu"
                  class="form-control form-control-sm"
                  onkeyup="atualizarNomeMenu(this)"
                  placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-rotulo']) !!}"
                />

              </div>

              <div class="col-12 col-md-6">

                <label
                  for="tbl_sys_menu_item_status-${tempId}"
                  class="form-label fw-bold text-uppercase small mb-1"
                >
                  {!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-status']) !!}
                </label>

                <select
                  id="tbl_sys_menu_item_status-${tempId}"
                  name="tbl_sys_menu_item_status"
                  class="form-select form-select-sm"
                  onchange="return atualizarStatusMenu(this)"
                >

                  <option value="ativo" selected>
                    {!! ucfirst(SysAutomator::SysAutomatorGetTranslateWord($textos['status-ativo'])) !!}
                  </option>

                  <option value="inativo">
                    {!! ucfirst(SysAutomator::SysAutomatorGetTranslateWord($textos['status-inativo'])) !!}
                  </option>

                </select>

              </div>

              <div class="col-12 col-md-6">

                <label
                  for="tbl_sys_menu_item_index-${tempId}"
                  class="form-label fw-bold text-uppercase small mb-1"
                >
                  {!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-item-id']) !!}
                </label>

                <input
                  id="tbl_sys_menu_item_index-${tempId}"
                  type="text"
                  name="tbl_sys_menu_item_index"
                  value=""
                  placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-item-id']) !!}"
                  class="form-control form-control-sm"
                />

              </div>

              <div class="col-12 col-md-6">

                <label
                  for="tbl_sys_menu_item_class-${tempId}"
                  class="form-label fw-bold text-uppercase small mb-1"
                >
                  {!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-item-classes']) !!}
                </label>

                <input
                  id="tbl_sys_menu_item_class-${tempId}"
                  type="text"
                  name="tbl_sys_menu_item_class"
                  value=""
                  placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-item-classes']) !!}"
                  class="form-control form-control-sm"
                />

              </div>

              <div class="col-12 col-md-6">

                <label
                  for="tbl_sys_menu_item_type-${tempId}"
                  class="form-label fw-bold text-uppercase small mb-1"
                >
                  {!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-item-type']) !!}
                </label>

                <select
                  id="tbl_sys_menu_item_type-${tempId}"
                  name="tbl_sys_menu_item_type"
                  class="form-select form-select-sm"
                  data-automator-previous-value="route"
                  onchange="atualizarTipoMenu(this)"
                >

                  <option value="route" selected>
                    {!! SysAutomator::SysAutomatorGetTranslateWord($textos['page']) !!}
                  </option>

                  <option value="link">
                    {!! SysAutomator::SysAutomatorGetTranslateWord($textos['link']) !!}
                  </option>

                  <option value="button">
                    {!! SysAutomator::SysAutomatorGetTranslateWord($textos['button']) !!}
                  </option>

                  <option value="divider">
                    {!! SysAutomator::SysAutomatorGetTranslateWord($textos['divider']) !!}
                  </option>

                </select>

              </div>

              <div class="col-12 col-md-6 menu-itens-rota">

                <label
                  for="tbl_sys_route_ID-${tempId}"
                  class="form-label fw-bold text-uppercase small mb-1"
                >
                  {!! SysAutomator::SysAutomatorGetTranslateWord($textos['page']) !!}
                </label>

                <select
                  id="tbl_sys_route_ID-${tempId}"
                  name="tbl_sys_route_ID"
                  class="form-select form-select-sm"
                >

                  <option value="0" selected>
                    - {!! SysAutomator::SysAutomatorGetTranslateWord($textos['select']) !!} -
                  </option>

                  @foreach($paginas as $pagina)

                    <option value="{{ $pagina->tbl_sys_route_ID }}">
                      {{ $pagina->tbl_sys_route_title }}
                    </option>

                  @endforeach

                </select>

              </div>

              <div class="col-12 col-md-6 menu-itens-link d-none">

                <label
                  for="tbl_sys_menu_item_link-${tempId}"
                  class="form-label fw-bold text-uppercase small mb-1"
                >
                  {!! SysAutomator::SysAutomatorGetTranslateWord($textos['link']) !!}
                </label>

                <input
                  id="tbl_sys_menu_item_link-${tempId}"
                  type="text"
                  name="tbl_sys_menu_item_link"
                  value=""
                  placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['link']) !!}"
                  class="form-control form-control-sm"
                />

              </div>

              <div class="col-12 col-md-6">

                <label
                  for="tbl_sys_menu_item_locked-${tempId}"
                  class="form-label fw-bold text-uppercase small mb-1"
                >
                  {!! SysAutomator::SysAutomatorGetTranslateWord($textos['admin-locked']) !!}
                </label>

                <select
                  id="tbl_sys_menu_item_locked-${tempId}"
                  name="tbl_sys_menu_item_locked"
                  class="form-select form-select-sm"
                >

                  <option value="1">
                    {!! SysAutomator::SysAutomatorGetTranslateWord($textos['yes']) !!}
                  </option>

                  <option value="0" selected>
                    {!! SysAutomator::SysAutomatorGetTranslateWord($textos['no']) !!}
                  </option>

                </select>

              </div>

              <div class="col-12 m-0 p-0"></div>

              <div class="col-12 col-md-5">

                <label
                  for="tbl_sys_menu_item_admin-${tempId}"
                  class="form-label fw-bold text-uppercase small mb-1"
                >
                  {!! SysAutomator::SysAutomatorGetTranslateWord($textos['admin-area']) !!}
                </label>

                <select
                  id="tbl_sys_menu_item_admin-${tempId}"
                  name="tbl_sys_menu_item_admin"
                  class="form-select form-select-sm"
                  onchange="atualizarDisplayUsersTypes(this)"
                >

                  <option value="1" selected>
                    {!! SysAutomator::SysAutomatorGetTranslateWord($textos['yes']) !!}
                  </option>

                  <option value="0">
                    {!! SysAutomator::SysAutomatorGetTranslateWord($textos['no']) !!}
                  </option>

                </select>

              </div>

              <div
                id="tbl_sys_menu_item_users_types-${tempId}"
                class="col-12 col-md-7 menu-itens-users-types"
              >

                <div class="col-12">

                  <span class="form-label fw-bold text-uppercase small mb-1">
                    {!! SysAutomator::SysAutomatorGetTranslateWord($textos['permissions']) !!}
                  </span>

                </div>

                <div class="dropdown">

                  <button
                    id="tbl_sys_menu_item_access_${tempId}-btn"
                    type="button"
                    class="btn btn-sm dropdown-toggle form-select"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    aria-expanded="false"
                  >
                    {!! SysAutomator::SysAutomatorGetTranslateWord($textos['permissions']) !!}
                    -
                    <i>
                      <b>0</b>
                      {!! SysAutomator::SysAutomatorGetTranslateWord($textos['selected']) !!}
                    </i>
                  </button>

                  <div class="dropdown-menu p-2 shadow" style="min-width: 220px;">

                    @foreach($usersTypes as $_userTypeID => $_userTypeName)

                      <div class="form-check mb-2">

                        <label
                          for="tbl_sys_menu_item_access_${tempId}-{{ $_userTypeID }}"
                          class="form-check-label small w-100"
                        >

                          <input
                            id="tbl_sys_menu_item_access_${tempId}-{{ $_userTypeID }}"
                            onchange="atualizarContagemUserTypesCheckbox(this)"
                            name="tbl_sys_menu_item_access"
                            type="checkbox"
                            value="{{ $_userTypeID }}"
                            class="form-check-input"
                          />

                          {!! $_userTypeName !!}

                        </label>

                      </div>

                    @endforeach

                  </div>

                </div>

              </div>

              <div class="col-12 mt-4">

                <div class="col-12 mb-3">

                  <span class="form-label fw-bold text-uppercase small mb-1 me-2">
                    {!! SysAutomator::SysAutomatorGetTranslateWord($textos['props']) !!}
                  </span>

                  <button
                    type="button"
                    class="btn btn-secondary btn-sm"
                    style="font-size: 10px;"
                    data-bs-toggle="tooltip"
                    data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['add-prop']) !!}"
                    onclick="addMenuProp('${tempId}', this, true);"
                  >

                    <i class="fa fa-plus"></i>

                  </button>

                </div>

                <div
                  class="col-12 menu-item-props-subs"
                  data-item="${tempId}"
                  data-zero="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['no-props-found-in-menu-item']) !!}"
                >

                  <div class="row">

                    <div class="col-12 text-center">
                      {!! SysAutomator::SysAutomatorGetTranslateWord($textos['no-props-found-in-menu-item']) !!}
                    </div>

                  </div>

                </div>

              </div>

            </div>

          </div>

        </div>

      </div>

    `;


    /*
    |--------------------------------------------------------------------------
    | Insere no topo
    |--------------------------------------------------------------------------
    */

    submenuList.insertAdjacentHTML(

      'afterbegin',

      newSubmenuHTML

    );


    var newWrapper = submenuList.querySelector(

      ':scope > .menu-item-wrapper[data-id="' +

      CSS.escape(

        tempId

      ) +

      '"]'

    );

    updateMenuItemAdminState(

      $(newWrapper)

    );


    /*
    |--------------------------------------------------------------------------
    | Abre a lista e atualiza os controles do menu pai
    |--------------------------------------------------------------------------
    */

    AutomatorMenuUpdateSubmenuListState(

      menuWrapper,

      true

    );


    /*
    |--------------------------------------------------------------------------
    | Atualiza estrutura e ordenação
    |--------------------------------------------------------------------------
    */

    if(

      typeof window.refreshMenuStructure ===

      'function'

    ) {


      window.refreshMenuStructure();


    }


    if(

      typeof window.initAllSortables ===

      'function'

    ) {


      window.initAllSortables();


    }


    if(

      typeof AutomatorInitBootstrapTooltips ===

      'function' &&

      newWrapper

    ) {


      AutomatorInitBootstrapTooltips(

        newWrapper

      );


    }


    /*
    |--------------------------------------------------------------------------
    | Scroll e foco
    |--------------------------------------------------------------------------
    */

    window.requestAnimationFrame(

      function() {


        window.requestAnimationFrame(

          function() {


            if(!newWrapper) {

              return;

            }


            newWrapper.scrollIntoView({

              behavior:

                'smooth',

              block:

                'center',

              inline:

                'nearest',

            });


            var firstInput =

              newWrapper.querySelector(

                'input[name="tbl_sys_menu_item_title"]'

              );


            if(firstInput) {


              setTimeout(

                function() {


                  firstInput.focus();

                  firstInput.select();


                },

                350

              );


            }


          }

        );


      }

    );


    setMenuChanged();


    return false;


  }



  function validateMenuStructure() {

    // Todos os wrappers: top-level e submenus
    const wrappers = document.querySelectorAll('#menu-sortable-list .menu-item-wrapper');

    for (const wrapper of wrappers) {

      const id        = wrapper.dataset.id;
      const isSub     = wrapper.classList.contains('submenu-item');
      const contentEl = wrapper.querySelector(`:scope > .menu-item > [id^="content-item-"]`);

      if (!contentEl) continue;

      const nome   = contentEl.querySelector('input[name="tbl_sys_menu_item_title"]');
      const tipo   = contentEl.querySelector('select[name="tbl_sys_menu_item_type"]');
      const pagina = contentEl.querySelector('select[name="tbl_sys_route_ID"]');

      // ── Helper: abre accordion, faz scroll e foca o campo ────────────────────
      const focarItem = (campoEl = null) => {

        wrapper.querySelector('.menu-item').scrollIntoView({ behavior: 'smooth', block: 'center' });

        const content = document.getElementById('content-item-' + id);
        if (content && content.classList.contains('d-none')) {
          toggleAccordion('item-' + id);
        }

        if (campoEl) {
          setTimeout(() => {
            campoEl.focus();
            if (typeof campoEl.select === 'function') campoEl.select();
          }, 300);
        }

      };

      // ── Validação: campos obrigatórios ────────────────────────────────────────
      if (!nome || !nome.value.trim()) {
        focarItem(nome);
        alert('Erro: Configuração incompleta do menu!\n\n- Rótulo de Navegação é obrigatório\n\nPor favor, complete a configuração do menu destacado.');
        return false;
      }

      if (!tipo || !tipo.value) {
        focarItem(tipo);
        alert('Erro: Configuração incompleta do menu!\n\n- Tipo do Menu é obrigatório\n\nPor favor, complete a configuração do menu destacado.');
        return false;
      }

      if (tipo.value === 'route') {
        if (!pagina || pagina.value === '0' || !pagina.value) {
          focarItem(pagina);
          alert('Erro: Configuração incompleta do menu!\n\n- Página do Menu é obrigatória para menus do tipo "Página"\n\nPor favor, complete a configuração do menu destacado.');
          return false;
        }
      }

      // ── Validação: propriedades do item ───────────────────────────────────────
      // Prefixo exato do id conforme gerado pelo menuPropHTML:
      // principal: menu-item-prop-{id}-key-{n}
      // submenu:   menu-item-prop-{id}-sub-key-{n}
      const propKeyPrefix   = isSub ? `menu-item-prop-${id}-sub-key-`   : `menu-item-prop-${id}-key-`;
      const propValuePrefix = isSub ? `menu-item-prop-${id}-sub-value-` : `menu-item-prop-${id}-value-`;

      const propsClass     = isSub ? '.menu-item-props-subs' : '.menu-item-props';
      const propsContainer = contentEl.querySelector(`${propsClass}[data-item="${id}"]`);

      if (propsContainer) {

        const propItems  = propsContainer.querySelectorAll('.menu-item-props-item');
        const keysVistas = [];

        for (const propItem of propItems) {

          const keyInput   = propItem.querySelector(`input[id^="${propKeyPrefix}"]`);
          const valueInput = propItem.querySelector(`input[id^="${propValuePrefix}"]`);

          if (!keyInput || !valueInput) continue;

          const k = keyInput.value.trim();
          const v = valueInput.value.trim();

          // Regra 1: valor preenchido sem nome
          if (k === '' && v !== '') {
            focarItem(keyInput);
            alert(
              'Erro: Propriedade inválida no menu "' + nome.value.trim() + '"!\n\n' +
              '- A propriedade com valor "' + v + '" não possui nome definido.\n\n' +
              'Por favor, preencha o nome da propriedade destacada.'
            );
            return false;
          }

          // Regra 2: nome duplicado (só verifica props que têm nome)
          if (k !== '') {
            if (keysVistas.includes(k)) {
              focarItem(keyInput);
              alert(
                'Erro: Propriedade duplicada no menu "' + nome.value.trim() + '"!\n\n' +
                '- Já existe uma propriedade com o nome "' + k + '".\n\n' +
                'Cada propriedade deve ter um nome único.'
              );
              return false;
            }
            keysVistas.push(k);
          }

        }

      }

    }

    return true;

  }


  function AutomatorMenuCreateUsersTypesHTML(
    itemID
  ) {


    var retorno = '';


    retorno +=

      '<div ' +

        'id="tbl_sys_menu_item_users_types-' +

        itemID +

        '" ' +

        'class="col-12 col-md-8 menu-itens-users-types"' +

      '>' +

        "\n";


      retorno +=

        '<div class="col-12">' +

          '<span class="form-label fw-bold text-uppercase small mb-1">' +

            "{!! SysAutomator::SysAutomatorGetTranslateWord($textos['permissions']) !!}" +

          '</span>' +

        '</div>' +

        "\n";


      retorno +=

        '<div class="dropdown">' +

          "\n";


        retorno +=

          '<button ' +

            'id="tbl_sys_menu_item_access_' +

            itemID +

            '-btn" ' +

            'type="button" ' +

            'class="btn btn-sm dropdown-toggle form-select" ' +

            'data-bs-toggle="dropdown" ' +

            'data-bs-auto-close="outside" ' +

            'aria-expanded="false"' +

          '>' +

            "{!! SysAutomator::SysAutomatorGetTranslateWord($textos['permissions']) !!}" +

            ' - ' +

            '<i>' +

              '<b>0</b> ' +

              "{!! SysAutomator::SysAutomatorGetTranslateWord($textos['selected']) !!}" +

            '</i>' +

          '</button>' +

          "\n";


        retorno +=

          '<div class="dropdown-menu p-2 shadow" style="min-width: 220px;">' +

            "\n";


          @foreach($usersTypes as $_userTypeID => $_userTypeName)

            retorno +=

              '<div class="form-check mb-2">' +

                "\n";


              retorno +=

                '<label ' +

                  'for="tbl_sys_menu_item_access_' +

                  itemID +

                  '-{{ $_userTypeID }}" ' +

                  'class="form-check-label small w-100"' +

                '>' +

                  "\n";


                retorno +=

                  '<input ' +

                    'id="tbl_sys_menu_item_access_' +

                    itemID +

                    '-{{ $_userTypeID }}" ' +

                    'onchange="atualizarContagemUserTypesCheckbox(this)" ' +

                    'name="tbl_sys_menu_item_access" ' +

                    'type="checkbox" ' +

                    'value="{{ $_userTypeID }}" ' +

                    'class="form-check-input" ' +

                  '/>' +

                  "\n";


                retorno +=

                  "{!! addslashes($_userTypeName) !!}" +

                  "\n";


              retorno +=

                '</label>' +

                "\n";


            retorno +=

              '</div>' +

              "\n";

          @endforeach


        retorno +=

          '</div>' +

          "\n";


      retorno +=

        '</div>' +

        "\n";


    retorno +=

      '</div>' +

      "\n";


    return retorno;


  }


  function AutomatorMenuCreateRoutesOptionsHTML() {


    var retorno = '';


    retorno +=

      '<option value="0" selected>' +

        '- ' +

        "{!! SysAutomator::SysAutomatorGetTranslateWord($textos['select']) !!}" +

        ' -' +

      '</option>' +

      "\n";


    @foreach($paginas as $pagina)

      retorno +=

        '<option value="{{ $pagina->tbl_sys_route_ID }}">' +

          "{!! addslashes($pagina->tbl_sys_route_title) !!}" +

        '</option>' +

        "\n";

    @endforeach


    return retorno;


  }


  function updateMenuItemAdminState(item) {


    if(!item || !item.length) {

      item = $(item);

    }


    var indexField = item.find(
      '[name="tbl_sys_menu_item_index"]'
    );


    var adminField = item.find(
      '[name="tbl_sys_menu_item_admin"]'
    );


    if(
      !indexField.length ||
      !adminField.length
    ) {

      return;

    }


    var hasAdminIndex = $.trim(
      indexField.val()
    ) !== '';


    if(hasAdminIndex) {


      adminField
        .val('1')
        .trigger('change');


      adminField.find('option[value="0"]')
        .prop('disabled', true);


    } else {


      adminField.find('option[value="0"]')
        .prop('disabled', false);


    }


  }


  function AutomatorMenuUpdateEmptyListState() {


    var menuList = document.getElementById(

      'menu-sortable-list'

    );


    if(!menuList) {

      return false;

    }


    var emptyMessage = document.getElementById(

      'menu-sortable-list-empty'

    );


    var menuItems = menuList.querySelectorAll(

      ':scope > .menu-item-wrapper'

    );


    if(menuItems.length >= 1) {


      if(emptyMessage) {

        emptyMessage.remove();

      }


      return true;

    }


    if(!emptyMessage) {


      emptyMessage = document.createElement(

        'div'

      );


      emptyMessage.id =

        'menu-sortable-list-empty';


      emptyMessage.className =

        'text-center fs-4';


      emptyMessage.innerHTML =

        "{!! SysAutomator::SysAutomatorGetTranslateWord('Nenhum item cadastrado!') !!}";


      menuList.appendChild(

        emptyMessage

      );


    }


    return true;


  }


  function addMenuItem(
    btn = null
  ) {


    var menuList = document.getElementById(

      'menu-sortable-list'

    );


    if(!menuList) {

      return false;

    }


    if(btn) {


      var tooltipInstance =

        bootstrap.Tooltip.getInstance(

          btn

        );


      if(tooltipInstance) {

        tooltipInstance.hide();

      }


    }


    /*
    |--------------------------------------------------------------------------
    | ID temporário
    |--------------------------------------------------------------------------
    */

    var tempId =

      AutomatorMenuCreateTemporaryItemID();


    /*
    |--------------------------------------------------------------------------
    | HTML auxiliar
    |--------------------------------------------------------------------------
    */

    var routesOptionsHTML =

      AutomatorMenuCreateRoutesOptionsHTML();


    var usersTypesHTML =

      AutomatorMenuCreateUsersTypesHTML(

        tempId

      );


    /*
    |--------------------------------------------------------------------------
    | HTML do item principal
    |--------------------------------------------------------------------------
    */

    var newMenuItemHTML = `

      <div class="menu-item-wrapper" data-id="${tempId}">

        <div class="menu-item card border group-parent">

          <div class="card-body d-flex align-items-center py-2 px-3 handle">

            <span class="text-secondary me-3">

              <i class="fa fa-grip-vertical"></i>

            </span>

            <div class="flex-grow-1 d-flex align-items-center gap-3">

              <span class="menu-item-nome fw-bold text-dark">
                Novo Item
              </span>

            </div>

            <div class="d-flex align-items-center gap-3">

              <span class="menu-item-status badge rounded-pill text-bg-success">
                {!! ucfirst(SysAutomator::SysAutomatorGetTranslateWord($textos['status-ativo'])) !!}
              </span>

              <button
                type="button"
                onclick="toggleAccordion('item-${tempId}')"
                class="btn btn-link btn-sm text-secondary p-1"
                data-bs-toggle="tooltip"
                data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['edit-menu']) !!}"
              >

                <i
                  id="icon-item-${tempId}"
                  class="fa-solid fa-pencil"
                ></i>

              </button>

              <button
                type="button"
                onclick="addSubmenu('${tempId}')"
                class="btn btn-link btn-sm text-secondary p-1"
                data-bs-toggle="tooltip"
                data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['add-submenu-item']) !!}"
              >

                <i class="fa-solid fa-plus"></i>

              </button>

              <button
                type="button"
                onclick="toggleSubmenuDisplay(this)"
                class="btn btn-link btn-sm text-secondary p-1 chevron-btn chevron-btn-${tempId} d-none"
                data-bs-toggle="tooltip"
                data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['collapse-menu']) !!}"
                aria-expanded="false"
              >

                <i
                  id="icon2-item-${tempId}"
                  class="fa-solid fa-chevron-up"
                ></i>

              </button>

              <button
                type="button"
                class="btn btn-link btn-sm text-secondary p-1 ban-icon ban-icon-${tempId}"
                data-bs-toggle="tooltip"
                data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['no-submenus']) !!}"
              >

                <i
                  id="ban-icon2-item-${tempId}"
                  class="fa-solid fa-ban"
                ></i>

              </button>

              <button
                type="button"
                onclick="deleteMenuItem('${tempId}', this)"
                class="btn btn-link btn-sm text-danger p-1"
                data-bs-toggle="tooltip"
                data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['remove-menu']) !!}"
              >

                <i class="fa-solid fa-trash"></i>

              </button>

            </div>

          </div>

          <div id="content-item-${tempId}" class="menu-item-body">

            <input
              type="hidden"
              class="menu-item-parent-val"
              value="0"
            />

            <div class="row g-3">

              <div class="col-12 col-md-6">

                <label
                  for="tbl_sys_menu_item_title-${tempId}"
                  class="form-label fw-bold text-uppercase small mb-1"
                >
                  {!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-rotulo']) !!}
                </label>

                <input
                  type="text"
                  id="tbl_sys_menu_item_title-${tempId}"
                  name="tbl_sys_menu_item_title"
                  value="Novo Item"
                  class="form-control form-control-sm"
                  onkeyup="atualizarNomeMenu(this)"
                  placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-rotulo']) !!}"
                />

              </div>

              <div class="col-12 col-md-6">

                <label
                  for="tbl_sys_menu_item_status-${tempId}"
                  class="form-label fw-bold text-uppercase small mb-1"
                >
                  {!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-status']) !!}
                </label>

                <select
                  id="tbl_sys_menu_item_status-${tempId}"
                  name="tbl_sys_menu_item_status"
                  class="form-select form-select-sm"
                  onchange="return atualizarStatusMenu(this)"
                >

                  <option value="ativo" selected>
                    {!! ucfirst(SysAutomator::SysAutomatorGetTranslateWord($textos['status-ativo'])) !!}
                  </option>

                  <option value="inativo">
                    {!! ucfirst(SysAutomator::SysAutomatorGetTranslateWord($textos['status-inativo'])) !!}
                  </option>

                </select>

              </div>

              <div class="col-12 col-md-6">

                <label
                  for="tbl_sys_menu_item_index-${tempId}"
                  class="form-label fw-bold text-uppercase small mb-1"
                >
                  {!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-item-id']) !!}
                </label>

                <input
                  id="tbl_sys_menu_item_index-${tempId}"
                  type="text"
                  name="tbl_sys_menu_item_index"
                  value=""
                  placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-item-id']) !!}"
                  class="form-control form-control-sm"
                />

              </div>

              <div class="col-12 col-md-6">

                <label
                  for="tbl_sys_menu_item_class-${tempId}"
                  class="form-label fw-bold text-uppercase small mb-1"
                >
                  {!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-item-classes']) !!}
                </label>

                <input
                  id="tbl_sys_menu_item_class-${tempId}"
                  type="text"
                  name="tbl_sys_menu_item_class"
                  value=""
                  placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-item-classes']) !!}"
                  class="form-control form-control-sm"
                />

              </div>

              <div class="col-12 col-md-6">

                <label
                  for="tbl_sys_menu_item_type-${tempId}"
                  class="form-label fw-bold text-uppercase small mb-1"
                >
                  {!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-item-type']) !!}
                </label>

                <select
                  id="tbl_sys_menu_item_type-${tempId}"
                  name="tbl_sys_menu_item_type"
                  class="form-select form-select-sm"
                  data-automator-previous-value="route"
                  onchange="atualizarTipoMenu(this)"
                >

                  <option value="route" selected>
                    {!! SysAutomator::SysAutomatorGetTranslateWord($textos['page']) !!}
                  </option>

                  <option value="link">
                    {!! SysAutomator::SysAutomatorGetTranslateWord($textos['link']) !!}
                  </option>

                  <option value="button">
                    {!! SysAutomator::SysAutomatorGetTranslateWord($textos['button']) !!}
                  </option>

                  <option value="divider">
                    {!! SysAutomator::SysAutomatorGetTranslateWord($textos['divider']) !!}
                  </option>

                </select>

              </div>

              <div class="col-12 col-md-6 menu-itens-rota">

                <label
                  for="tbl_sys_route_ID-${tempId}"
                  class="form-label fw-bold text-uppercase small mb-1"
                >
                  {!! SysAutomator::SysAutomatorGetTranslateWord($textos['page']) !!}
                </label>

                <select
                  id="tbl_sys_route_ID-${tempId}"
                  name="tbl_sys_route_ID"
                  class="form-select form-select-sm"
                >

                  ${routesOptionsHTML}

                </select>

              </div>

              <div class="col-12 col-md-6 menu-itens-link d-none">

                <label
                  for="tbl_sys_menu_item_link-${tempId}"
                  class="form-label fw-bold text-uppercase small mb-1"
                >
                  {!! SysAutomator::SysAutomatorGetTranslateWord($textos['link']) !!}
                </label>

                <input
                  id="tbl_sys_menu_item_link-${tempId}"
                  type="text"
                  name="tbl_sys_menu_item_link"
                  value=""
                  placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['link']) !!}"
                  class="form-control form-control-sm"
                />

              </div>

              <div
                class="col-12 col-md-6 icon-picker-container"
                data-automator-icon-picker="true"
              >

                <label
                  for="tbl_sys_menu_item_icon_search-${tempId}"
                  class="form-label fw-bold text-uppercase small mb-1"
                >
                  {!! SysAutomator::SysAutomatorGetTranslateWord($textos['icon']) !!}
                </label>

                <input
                  type="hidden"
                  id="tbl_sys_menu_item_icon-${tempId}"
                  name="tbl_sys_menu_item_icon"
                  value=""
                  class="icon-picker-value"
                />

                <div class="icon-search-wrapper">

                  <i
                    class="fa fa-magnifying-glass icon-search-prefix current-icon-display"
                    aria-hidden="true"
                  ></i>

                  <input
                    id="tbl_sys_menu_item_icon_search-${tempId}"
                    type="text"
                    value=""
                    class="form-control form-control-sm icon-search-input"
                    placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['icon-search']) !!}"
                    autocomplete="off"
                    onfocus="showIconPicker(this)"
                    oninput="filterIcons(this)"
                  />

                </div>

                <div
                  class="icon-picker-dropdown"
                  role="listbox"
                  aria-label="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['icon']) !!}"
                >

                  <div class="icon-picker-grid"></div>

                </div>

              </div>

              <div class="col-12 col-md-6">

                <label
                  for="tbl_sys_menu_item_locked-${tempId}"
                  class="form-label fw-bold text-uppercase small mb-1"
                >
                  {!! SysAutomator::SysAutomatorGetTranslateWord($textos['admin-locked']) !!}
                </label>

                <select
                  id="tbl_sys_menu_item_locked-${tempId}"
                  name="tbl_sys_menu_item_locked"
                  class="form-select form-select-sm"
                >

                  <option value="1">
                    {!! SysAutomator::SysAutomatorGetTranslateWord($textos['yes']) !!}
                  </option>

                  <option value="0" selected>
                    {!! SysAutomator::SysAutomatorGetTranslateWord($textos['no']) !!}
                  </option>

                </select>

              </div>

              <div class="col-12 m-0 p-0"></div>

              <div class="col-12 col-md-4">

                <label
                  for="tbl_sys_menu_item_admin-${tempId}"
                  class="form-label fw-bold text-uppercase small mb-1"
                >
                  {!! SysAutomator::SysAutomatorGetTranslateWord($textos['admin-area']) !!}
                </label>

                <select
                  id="tbl_sys_menu_item_admin-${tempId}"
                  name="tbl_sys_menu_item_admin"
                  class="form-select form-select-sm"
                  onchange="atualizarDisplayUsersTypes(this)"
                >

                  @if( (isset($_nav['tbl_sys_nav_admin'])) && ($_nav['tbl_sys_nav_admin'] == true))

                    <option value="1" selected>
                      {!! SysAutomator::SysAutomatorGetTranslateWord($textos['yes']) !!}
                    </option>

                    <option value="0" disabled>
                      {!! SysAutomator::SysAutomatorGetTranslateWord($textos['no']) !!}
                    </option>

                  @else

                    <option value="1" selected>
                      {!! SysAutomator::SysAutomatorGetTranslateWord($textos['yes']) !!}
                    </option>

                    <option value="0">
                      {!! SysAutomator::SysAutomatorGetTranslateWord($textos['no']) !!}
                    </option>

                  @endif

                </select>

              </div>

              ${usersTypesHTML}

              <div class="col-12 mt-4">

                <div class="col-12 mb-3">

                  <span class="form-label fw-bold text-uppercase small mb-1 me-2">
                    {!! SysAutomator::SysAutomatorGetTranslateWord($textos['props']) !!}
                  </span>

                  <button
                    type="button"
                    class="btn btn-secondary btn-sm"
                    style="font-size: 10px;"
                    data-bs-toggle="tooltip"
                    data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['add-prop']) !!}"
                    onclick="addMenuProp('${tempId}', this);"
                  >

                    <i class="fa fa-plus"></i>

                  </button>

                </div>

                <div
                  class="col-12 menu-item-props"
                  data-item="${tempId}"
                  data-zero="{!! SysAutomator::SysAutomatorGetTranslateWord($textos['no-props-found-in-menu-item']) !!}"
                >

                  <div class="row">

                    <div class="col-12 text-center">
                      {!! SysAutomator::SysAutomatorGetTranslateWord($textos['no-props-found-in-menu-item']) !!}
                    </div>

                  </div>

                </div>

              </div>

            </div>

          </div>

          <div
            class="submenu-list transition-transform duration-200 mx-3 my-0 d-none"
            data-parent-id="${tempId}"
          ></div>

        </div>

      </div>

    `;


    /*
    |--------------------------------------------------------------------------
    | Remove mensagem vazia
    |--------------------------------------------------------------------------
    */

    var emptyMessage = document.getElementById(

      'menu-sortable-list-empty'

    );


    if(emptyMessage) {

      emptyMessage.remove();

    }


    /*
    |--------------------------------------------------------------------------
    | Insere no topo
    |--------------------------------------------------------------------------
    */

    menuList.insertAdjacentHTML(

      'afterbegin',

      newMenuItemHTML

    );


    var newWrapper = menuList.querySelector(

      ':scope > .menu-item-wrapper[data-id="' +

      CSS.escape(

        tempId

      ) +

      '"]'

    );


    if(!newWrapper) {

      return false;

    }

    updateMenuItemAdminState(
      $(newWrapper)
    );


    /*
    |--------------------------------------------------------------------------
    | Inicializa componentes do novo item
    |--------------------------------------------------------------------------
    */

    initIconPickers(

      newWrapper

    );


    if(

      typeof window.refreshMenuStructure ===

      'function'

    ) {


      window.refreshMenuStructure();


    }


    if(

      typeof window.initAllSortables ===

      'function'

    ) {


      window.initAllSortables();


    }


    if(

      typeof AutomatorInitBootstrapTooltips ===

      'function'

    ) {


      AutomatorInitBootstrapTooltips(

        newWrapper

      );


    } else {


      newWrapper.querySelectorAll(

        '[data-bs-toggle="tooltip"]'

      ).forEach(function(element) {


        var tooltip =

          bootstrap.Tooltip.getInstance(

            element

          );


        if(tooltip) {

          tooltip.dispose();

        }


        new bootstrap.Tooltip(

          element

        );


      });


    }


    /*
    |--------------------------------------------------------------------------
    | Scroll e foco
    |--------------------------------------------------------------------------
    */

    window.requestAnimationFrame(

      function() {


        window.requestAnimationFrame(

          function() {


            newWrapper.scrollIntoView({

              behavior:

                'smooth',

              block:

                'center',

              inline:

                'nearest',

            });


            var firstInput = newWrapper.querySelector(

              'input[name="tbl_sys_menu_item_title"]'

            );


            if(firstInput) {


              setTimeout(

                function() {


                  firstInput.focus();

                  firstInput.select();


                },

                350

              );


            }


          }

        );


      }

    );


    AutomatorMenuUpdateEmptyListState();


    setMenuChanged();


    return false;


  }


  function AutomatorMenuGetDatabaseItemID(
    clientID
  ) {


    clientID = String(

      clientID

      || ''

    ).trim();


    if(clientID === '') {

      return null;

    }


    /*
    |--------------------------------------------------------------------------
    | IDs temporários não existem no banco
    |--------------------------------------------------------------------------
    */

    if(

      clientID.indexOf(

        'temp'

      ) === 0

    ) {

      return null;

    }


    if(

      !/^[0-9]+$/.test(

        clientID

      )

    ) {

      return null;

    }


    var databaseID = parseInt(

      clientID,

      10

    );


    if(

      !Number.isInteger(

        databaseID

      ) ||

      databaseID <= 0

    ) {

      return null;

    }


    return databaseID;


  }


  function AutomatorMenuBuildPayload() {


    var menuTitle = String(

      document.getElementById(

        'current-menu-title'

      ).value

      || ''

    ).trim();


    var menuIndex = String(

      document.getElementById(

        'current-menu-index'

      ).value

      || ''

    ).trim();


    var menuClass = String(

      document.getElementById(

        'current-menu-class'

      ).value

      || ''

    ).trim();


    var menuNavID = String(

      document.getElementById(

        'current-menu-nav-id'

      ).value

      || ''

    ).trim();


    if(menuTitle === '') {


      var menuTitleField =

        document.getElementById(

          'current-menu-title'

        );


      menuTitleField.focus();

      menuTitleField.select();


      AutomatorCreateAutoCloseToastAlert(

        'automator-menu-title-required',

        'center',

        'middle',

        true,

        true,

        'Atenção',

        'O nome do menu é obrigatório.',

        null,

        false,

        null,

        5000

      );


      return null;


    }


    // if(menuNavID === '') {


    //   document.getElementById(

    //     'current-menu-nav-id'

    //   ).focus();


    //   AutomatorCreateAutoCloseToastAlert(

    //     'automator-menu-nav-required',

    //     'center',

    //     'middle',

    //     true,

    //     true,

    //     'Atenção',

    //     'Selecione a posição de navegação do menu.',

    //     null,

    //     false,

    //     null,

    //     5000

    //   );


    //   return null;


    // }


    var items = [];

    var globalOrder = 0;


    function processMenuWrapper(
      wrapper,
      parentClientID = null
    ) {


      if(!wrapper) {

        return false;

      }


      globalOrder++;


      var clientID = String(

        wrapper.dataset.id

        || ''

      );


      var itemData = extractItemData(

        wrapper,

        globalOrder,

        parentClientID

      );


      if(!itemData) {

        return false;

      }


      itemData.client_id =

        clientID;


      itemData.database_id =

        AutomatorMenuGetDatabaseItemID(

          clientID

        );


      itemData.parent_client_id =

        parentClientID;


      itemData.tbl_sys_menu_item_ordem =

        globalOrder;


      itemData.tbl_sys_menu_item_parent_id =

        parentClientID === null

          ? 0

          : parentClientID;


      items.push(

        itemData

      );


      var submenuList = wrapper.querySelector(

        ':scope > .menu-item > .submenu-list'

      );


      if(!submenuList) {


        submenuList = wrapper.querySelector(

          ':scope > .menu-item .submenu-list'

        );


      }


      if(submenuList) {


        var submenuWrappers = Array.from(

          submenuList.children

        ).filter(function(element) {


          return (

            element.classList.contains(

              'menu-item-wrapper'

            ) &&

            element.classList.contains(

              'submenu-item'

            )

          );


        });


        submenuWrappers.forEach(function(submenuWrapper) {


          processMenuWrapper(

            submenuWrapper,

            clientID

          );


        });


      }


      return true;


    }


    var mainList = document.getElementById(

      'menu-sortable-list'

    );


    if(!mainList) {

      return null;

    }


    var mainWrappers = Array.from(

      mainList.children

    ).filter(function(element) {


      return (

        element.classList.contains(

          'menu-item-wrapper'

        ) &&

        !element.classList.contains(

          'submenu-item'

        )

      );


    });


    mainWrappers.forEach(function(wrapper) {


      processMenuWrapper(

        wrapper,

        null

      );


    });


    return {

      _token:

        AutomatorGetCSRFToken(),

      menu: {

        tbl_sys_menu_ID:

          {{ (int) $currentMenu }},

        tbl_sys_menu_title:

          menuTitle,

        tbl_sys_menu_index:

          menuIndex,

        tbl_sys_menu_class:

          menuClass,

        tbl_sys_nav_ID:

          menuNavID,

      },

      items:

        items,

    };


  }


  function AutomatorMenuFinishRequest() {


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


    return true;


  }


  function AutomatorMenuSubmitPayload(
    payload
  ) {


    if(

      !payload ||

      typeof payload !== 'object'

    ) {


      AutomatorMenuFinishRequest();


      return false;

    }


    AutomatorSetActionStatus(

      true

    );


    $('#page-loader').css(

      'z-index',

      '1085'

    );


    AutomatorPageLoader(

      'show',

      function() {


        $.ajax({

          url:

            '{!! $routes["menu-update"] !!}',

          type:

            'POST',

          data:

            JSON.stringify(

              payload

            ),

          processData:

            false,

          contentType:

            'application/json; charset=UTF-8',

          dataType:

            'json',

          headers: {

            'X-CSRF-TOKEN':

              payload._token,

            'Accept':

              'application/json',

          },

          success: function(response) {


            var responseStatus = (

              response &&

              (

                response.status === true ||

                response.status === 1 ||

                response.status === '1' ||

                response.status === 'true'

              )

            );


            var responseTitle =

              response &&

              response.title

                ? response.title

                : (

                    responseStatus === true

                      ? 'Sucesso'

                      : 'Atenção'

                  );


            var responseMessage =

              response &&

              response.message

                ? response.message

                : (

                    responseStatus === true

                      ? 'As alterações do menu foram salvas com sucesso.'

                      : 'Não foi possível salvar as alterações do menu.'

                  );


            if(responseStatus === true) {


              /*
              |--------------------------------------------------------------------------
              | O commit foi concluído
              |--------------------------------------------------------------------------
              */

              menuChanged = false;

              window.onbeforeunload = null;


              AutomatorCreateAutoCloseToastAlert(

                'automator-menu-update-success-' +

                Date.now(),

                'center',

                'middle',

                true,

                true,

                responseTitle,

                responseMessage,

                null,

                false,

                function() {


                  AutomatorSetActionStatus(

                    false

                  );


                  var redirectURL =

                    response.redirect_url

                    || window.location.href;


                  window.location.href =

                    redirectURL;


                },

                5000

              );


              return false;


            }


            AutomatorCreateAutoCloseToastAlert(

              'automator-menu-update-error-' +

              Date.now(),

              'center',

              'middle',

              true,

              true,

              responseTitle,

              responseMessage,

              null,

              false,

              function() {


                AutomatorMenuFinishRequest();


              },

              5000

            );


            return false;


          },

          error: function(xhr) {


            if(

              typeof AutomatorSessionResponseIsExpired ===

              'function' &&

              AutomatorSessionResponseIsExpired(

                xhr

              ) === true

            ) {


              AutomatorSessionForceLogin(

                xhr

              );


              return false;

            }


            var responseTitle =

              'Erro';


            var responseMessage =

              'Não foi possível salvar as alterações do menu.';


            if(

              xhr.responseJSON &&

              xhr.responseJSON.title

            ) {


              responseTitle =

                xhr.responseJSON.title;


            }


            if(

              xhr.responseJSON &&

              xhr.responseJSON.message

            ) {


              responseMessage =

                xhr.responseJSON.message;


            } else if(xhr.responseText) {


              responseMessage =

                xhr.responseText;


            }


            AutomatorCreateAutoCloseToastAlert(

              'automator-menu-update-request-error-' +

              Date.now(),

              'center',

              'middle',

              true,

              true,

              responseTitle,

              responseMessage,

              null,

              false,

              function() {


                AutomatorMenuFinishRequest();


              },

              5000

            );


            return false;


          },

        });


      }

    );


    return true;


  }



  function AutomatorMenuCreateSecurityConfirmation(
    payload
  ) {


    if(

      typeof AutomatorCreateSecurityConfirmationModal !==

      'function'

    ) {


      AutomatorCreateAutoCloseToastAlert(

        'automator-menu-security-function-error',

        'center',

        'middle',

        true,

        true,

        'Erro',

        'A função de confirmação de segurança não foi localizada.',

        null,

        false,

        function() {


          AutomatorMenuFinishRequest();


        },

        5000

      );


      return false;

    }


    AutomatorCreateSecurityConfirmationModal({

      type:

        'menu-update',

      title:

        'Confirmação de Segurança',

      message:

        'Para salvar as alterações deste menu, confirme sua senha. Esta validação é necessária porque itens e permissões poderão ser alterados ou removidos.',

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


        $('#page-loader').css(

          'z-index',

          ''

        );


      },

      successCallback: function() {


        $('#page-loader').css(

          'z-index',

          '1085'

        );


        AutomatorMenuSubmitPayload(

          payload

        );


      },

    });


    return true;


  }


  function saveMenu() {


    if(

      validateMenuStructure() !==

      true

    ) {

      return false;

    }


    var payload =

      AutomatorMenuBuildPayload();


    if(!payload) {

      return false;

    }


    AutomatorGetActionStatus(function() {


      AutomatorSetActionStatus(

        true,

        function() {


          AutomatorMenuCreateSecurityConfirmation(

            payload

          );


        }

      );


    });


    return false;


  }

  // function saveMenu() {


  //   if(

  //     validateMenuStructure() !==

  //     true

  //   ) {

  //     return false;

  //   }


  //   var menuTitle = String(

  //     document.getElementById(

  //       'current-menu-title'

  //     ).value

  //     || ''

  //   ).trim();


  //   var menuIndex = String(

  //     document.getElementById(

  //       'current-menu-index'

  //     ).value

  //     || ''

  //   ).trim();


  //   var menuClass = String(

  //     document.getElementById(

  //       'current-menu-class'

  //     ).value

  //     || ''

  //   ).trim();


  //   var menuNavID = String(

  //     document.getElementById(

  //       'current-menu-nav-id'

  //     ).value

  //     || ''

  //   ).trim();


  //   if(menuTitle === '') {


  //     var menuTitleField =

  //       document.getElementById(

  //         'current-menu-title'

  //       );


  //     menuTitleField.focus();

  //     menuTitleField.select();


  //     alert(

  //       'O nome do menu é obrigatório.'

  //     );


  //     return false;

  //   }


  //   if(menuNavID === '') {


  //     document.getElementById(

  //       'current-menu-nav-id'

  //     ).focus();


  //     alert(

  //       'Selecione a posição de navegação do menu.'

  //     );


  //     return false;

  //   }


  //   var items = [];

  //   var globalOrder = 0;


  //   /*
  //   |--------------------------------------------------------------------------
  //   | Processa um item e seus submenus
  //   |--------------------------------------------------------------------------
  //   |
  //   | A ordem é global e segue exatamente o fluxo visual:
  //   |
  //   | menu principal;
  //   | submenus do menu principal;
  //   | próximo menu principal;
  //   | submenus do próximo menu principal.
  //   |
  //   */

  //   function processMenuWrapper(
  //     wrapper,
  //     parentClientID = null
  //   ) {


  //     if(!wrapper) {

  //       return false;

  //     }


  //     globalOrder++;


  //     var clientID = String(

  //       wrapper.dataset.id

  //       || ''

  //     );


  //     var itemData = extractItemData(

  //       wrapper,

  //       globalOrder,

  //       parentClientID

  //     );


  //     if(!itemData) {

  //       return false;

  //     }


  //     itemData.client_id =

  //       clientID;


  //     itemData.database_id =

  //       AutomatorMenuGetDatabaseItemID(

  //         clientID

  //       );


  //     itemData.parent_client_id =

  //       parentClientID;


  //     itemData.tbl_sys_menu_item_ordem =

  //       globalOrder;


  //     /*
  //     |--------------------------------------------------------------------------
  //     | O pai será resolvido no controller
  //     |--------------------------------------------------------------------------
  //     |
  //     | Isso é necessário quando um item principal e seus submenus são novos,
  //     | pois ainda não existe um ID real no banco.
  //     |
  //     */

  //     itemData.tbl_sys_menu_item_parent_id =

  //       parentClientID === null

  //         ? 0

  //         : parentClientID;


  //     items.push(

  //       itemData

  //     );


  //     var submenuList = wrapper.querySelector(

  //       ':scope > .menu-item > .submenu-list'

  //     );


  //     if(!submenuList) {


  //       submenuList = wrapper.querySelector(

  //         ':scope > .menu-item .submenu-list'

  //       );


  //     }


  //     if(submenuList) {


  //       var submenuWrappers = Array.from(

  //         submenuList.children

  //       ).filter(function(element) {


  //         return (

  //           element.classList.contains(

  //             'menu-item-wrapper'

  //           ) &&

  //           element.classList.contains(

  //             'submenu-item'

  //           )

  //         );


  //       });


  //       submenuWrappers.forEach(function(submenuWrapper) {


  //         processMenuWrapper(

  //           submenuWrapper,

  //           clientID

  //         );


  //       });


  //     }


  //     return true;


  //   }


  //   /*
  //   |--------------------------------------------------------------------------
  //   | Percorre os menus principais pela ordem atual do DOM
  //   |--------------------------------------------------------------------------
  //   */

  //   var mainList = document.getElementById(

  //     'menu-sortable-list'

  //   );


  //   var mainWrappers = Array.from(

  //     mainList.children

  //   ).filter(function(element) {


  //     return (

  //       element.classList.contains(

  //         'menu-item-wrapper'

  //       ) &&

  //       !element.classList.contains(

  //         'submenu-item'

  //       )

  //     );


  //   });


  //   mainWrappers.forEach(function(wrapper) {


  //     processMenuWrapper(

  //       wrapper,

  //       null

  //     );


  //   });


  //   var payload = {

  //     _token:

  //       document.querySelector(

  //         'meta[name="csrf-token"]'

  //       ).getAttribute(

  //         'content'

  //       ),

  //     menu: {

  //       tbl_sys_menu_ID:

  //         {{ (int) $currentMenu }},

  //       tbl_sys_menu_title:

  //         menuTitle,

  //       tbl_sys_menu_index:

  //         menuIndex,

  //       tbl_sys_menu_class:

  //         menuClass,

  //       tbl_sys_nav_ID:

  //         menuNavID,

  //     },

  //     items:

  //       items,

  //   };


  //   AutomatorGetActionStatus(function() {


  //     AutomatorSetActionStatus(

  //       true,

  //       function() {


  //         AutomatorPageLoader(

  //           'show',

  //           function() {


  //             $.ajax({

  //               url:

  //                 '{!! $routes["menu-update"] !!}',

  //               type:

  //                 'POST',

  //               data:

  //                 JSON.stringify(

  //                   payload

  //                 ),

  //               processData:

  //                 false,

  //               contentType:

  //                 'application/json; charset=UTF-8',

  //               dataType:

  //                 'json',

  //               headers: {

  //                 'X-CSRF-TOKEN':

  //                   payload._token,

  //                 'Accept':

  //                   'application/json',

  //               },

  //               success: function(response) {


  //                 if(

  //                   response &&

  //                   response.status === true

  //                 ) {


  //                   /*
  //                   |--------------------------------------------------------------------------
  //                   | Desativa o alerta de alterações somente após o commit
  //                   |--------------------------------------------------------------------------
  //                   */

  //                   menuChanged = false;


  //                   var redirectURL =

  //                     response.redirect_url

  //                     || window.location.href;


  //                   window.location.href =

  //                     redirectURL;


  //                   return false;

  //                 }


  //                 var message =

  //                   'Não foi possível salvar as alterações do menu.';


  //                 if(

  //                   response &&

  //                   response.message

  //                 ) {


  //                   message =

  //                     response.message;


  //                 }


  //                 alert(

  //                   message

  //                 );


  //                 AutomatorPageLoader(

  //                   'hide',

  //                   function() {


  //                     AutomatorSetActionStatus(

  //                       false

  //                     );


  //                   }

  //                 );


  //                 return false;


  //               },

  //               error: function(xhr) {


  //                 var message =

  //                   'Não foi possível salvar as alterações do menu.';


  //                 if(

  //                   xhr.responseJSON &&

  //                   xhr.responseJSON.message

  //                 ) {


  //                   message =

  //                     xhr.responseJSON.message;


  //                 } else if(xhr.responseText) {


  //                   message =

  //                     xhr.responseText;


  //                 }


  //                 alert(

  //                   message

  //                 );


  //                 AutomatorPageLoader(

  //                   'hide',

  //                   function() {


  //                     AutomatorSetActionStatus(

  //                       false

  //                     );


  //                   }

  //                 );


  //                 return false;


  //               },

  //             });


  //           }

  //         );


  //       }

  //     );


  //   });


  //   return false;


  // }


  function menuPropHTML(menuID, propID = 0, isSub = false) {


    var propName   = "{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-prop-name']) !!}";
    var propValue  = "{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-prop-value']) !!}";
    var propRemove = "{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-prop-remove']) !!}";


    menuID = String(

      menuID

      || ''

    );


    /*
    |--------------------------------------------------------------------------
    | Protege o ID utilizado dentro do atributo onclick
    |--------------------------------------------------------------------------
    |
    | O atributo HTML já utiliza aspas duplas. Por isso, o ID deve ser enviado
    | ao JavaScript entre aspas simples, escapando previamente qualquer barra
    | invertida ou aspas simples que possam existir no valor.
    |
    */

    var menuIDArgument = menuID

      .replace(

        /\\/g,

        '\\\\'

      )

      .replace(

        /'/g,

        "\\'"

      );


    var retorno  = '<div class="row menu-item-props-item" data-prop="' + propID + '">' + "\n";
          
          retorno += '<div class="col-12 col-md-5 mb-3">' + "\n";
            
            retorno += '<div class="form-floating">' + "\n";

              retorno += '<input type="text" class="form-control" id="menu-item-prop' + '-' + menuID + ( (isSub == true) ? '-sub' : '' ) + '-key-' + propID + '" placeholder="' + propName + '" value="" />' + "\n";
              retorno += '<label for="menu-item-prop' + '-' + menuID + ( (isSub == true) ? '-sub' : '' ) + '-key-' + propID + '">' + propName + '</label>' + "\n";

            retorno += '</div>' + "\n";

          retorno += '</div>' + "\n";

          retorno += '<div class="col-12 col-md-5 mb-3">' + "\n";
            
            retorno += '<div class="form-floating">' + "\n";

              retorno += '<input type="text" class="form-control" id="menu-item-prop' + '-' + menuID + ( (isSub == true) ? '-sub' : '' ) + '-value-' + propID + '" placeholder="' + propValue + '" value="" />' + "\n";
              retorno += '<label for="menu-item-prop' + '-' + menuID + ( (isSub == true) ? '-sub' : '' ) + '-value-' + propID + '">' + propValue + '</label>' + "\n";

            retorno += '</div>' + "\n";

          retorno += '</div>' + "\n";


          retorno += '<div class="col-12 col-md-2 mb-3">' + "\n";

            retorno += '<button type="button" class="btn btn-danger btn-sm w-100 text-center h-100" data-bs-toggle="tooltip" data-bs-title="' + propRemove + '" onclick="return removeMenuProp(\'' + menuIDArgument + '\', ' + propID + ', this, ' + ( (isSub == true) ? 'true' : 'false' ) + ');">' + "\n";

              retorno += '<i class="fa fa-trash"></i>' + "\n";

            retorno += '</button>' + "\n";

          retorno += '</div>' + "\n";

        retorno += '</div>' + "\n";


    return retorno;


  }



  function addMenuProp(menuID, btn = null, isSub = false) {

    if (btn) {

      var tooltipInstance = bootstrap.Tooltip.getInstance(btn);

      if (tooltipInstance) {

        tooltipInstance.hide();

      }

    }

    var menuType = ( (isSub == true) ? ".menu-item-props-subs" : ".menu-item-props" );
    var menuProps      = $(menuType + "[data-item='" + menuID + "']");
    var menuPropsItens = menuProps.find(".menu-item-props-item");
    var menuPropsTotal = menuPropsItens.length;
    var propID         = 0;

    if (menuPropsTotal >= 1) {

      var lastMenuProp = menuPropsItens.last();

      propID = parseInt(lastMenuProp.attr('data-prop')) + 1;

    }

    var propHTML = menuPropHTML(menuID, propID, isSub);

    if (menuPropsTotal <= 0) {

      menuProps.empty();
      menuProps.append(propHTML);

    } else {

      menuProps.append(propHTML);

    }

    /*
    |--------------------------------------------------------------------------
    | Inicializa tooltip do botão recém criado
    |--------------------------------------------------------------------------
    */

    var newMenuProp = menuProps.find(".menu-item-props-item[data-prop='" + propID + "']");

    var tooltipButton = newMenuProp.find('[data-bs-toggle="tooltip"]');

    if (tooltipButton.length > 0) {

      var tooltip = bootstrap.Tooltip.getInstance(tooltipButton[0]);

      if (tooltip) {

        tooltip.dispose();

      }

      new bootstrap.Tooltip(tooltipButton[0]);

    }

    setMenuChanged();

  }




  function removeMenuProp(menuID, propID, btn = null, isSub = false) {

      var menuProp = $(btn).closest('.menu-item-props-item');

      if(menuProp.length <= 0) {

          return false;

      }

      var menuProps = menuProp.closest(

          (isSub == true)

              ? '.menu-item-props-subs'

              : '.menu-item-props'

      );

      if(menuProps.length <= 0) {

          return false;

      }

      menuProp.remove();

      var menuPropsCount = menuProps.find('.menu-item-props-item');

      if(menuPropsCount.length <= 0) {

          menuProps.html(

              '<div class="row">' +

                  '<div class="col-12 text-center">' +

                      menuProps.attr('data-zero') +

                  '</div>' +

              '</div>'

          );

      }

      setMenuChanged();

      return false;

  }



  function atualizarContagemUserTypesCheckbox(btn) {


    var checkbox = $(btn);


    var dropdown = checkbox.closest(

      '.dropdown'

    );


    var countEl = dropdown.find(

      '> button.dropdown-toggle b'

    );


    if(countEl.length <= 0) {

      return false;

    }


    var checkedItems = dropdown.find(

      'input[name="tbl_sys_menu_item_access"]:checked'

    );


    countEl.html(

      checkedItems.length

    );


    setMenuChanged();


    return true;


  }



  function atualizarDisplayUsersTypes(btn) {


    var el = $(btn);

    var valor = el.val();


    var content = el.closest(

      '.menu-item-body'

    );


    var usersType = content.find(

      '.menu-itens-users-types'

    ).first();


    if(usersType.length <= 0) {

      return false;

    }


    usersType.find(

      'button.dropdown-toggle b'

    ).html(

      '0'

    );


    usersType.find(

      'input[type="checkbox"]'

    ).prop(

      'checked',

      false

    );


    if(valor == 1) {


      usersType.removeClass(

        'd-none'

      );


    } else {


      usersType.addClass(

        'd-none'

      );


    }


    setMenuChanged();


    return true;


  }


  function extractItemData(
    wrapper,
    order,
    parentId
  ) {


    if(!wrapper) {

      return null;

    }


    var id = String(

      wrapper.dataset.id

      || ''

    );


    var isSubmenu = wrapper.classList.contains(

      'submenu-item'

    );


    var contentEl = wrapper.querySelector(

      ':scope > .menu-item > [id^="content-item-"]'

    );


    if(!contentEl) {

      return null;

    }


    function findValue(
      name,
      selector = null,
      defaultValue = ''
    ) {


      if(!selector) {


        selector =

          '[name="' +

          name +

          '"]';


      }


      var field = contentEl.querySelector(

        selector

      );


      if(!field) {

        return defaultValue;

      }


      return field.value !== undefined

        ? field.value

        : defaultValue;


    }


    /*
    |--------------------------------------------------------------------------
    | Propriedades
    |--------------------------------------------------------------------------
    */

    var props = {};


    var propsContainer = contentEl.querySelector(

      isSubmenu === true

        ? '.menu-item-props-subs'

        : '.menu-item-props'

    );


    if(propsContainer) {


      propsContainer

        .querySelectorAll(

          '.menu-item-props-item'

        )

        .forEach(function(propItem) {


          var keyInput = propItem.querySelector(

            'input[id*="-key-"]'

          );


          var valueInput = propItem.querySelector(

            'input[id*="-value-"]'

          );


          var propKey = keyInput

            ? String(

                keyInput.value

                || ''

              ).trim()

            : '';


          if(propKey === '') {

            return;

          }


          props[propKey] = valueInput

            ? String(

                valueInput.value

                || ''

              )

            : '';


        });


    }


    /*
    |--------------------------------------------------------------------------
    | Permissões de acesso
    |--------------------------------------------------------------------------
    */

    var accessValues = Array.from(

      contentEl.querySelectorAll(

        'input[name="tbl_sys_menu_item_access"]:checked'

      )

    ).map(function(field) {


      return String(

        field.value

      );


    });


    /*
    |--------------------------------------------------------------------------
    | Ícone
    |--------------------------------------------------------------------------
    |
    | Submenus não utilizam ícone.
    |
    */

    var iconValue = '';


    if(isSubmenu !== true) {


      iconValue = AutomatorMenuNormalizeIconValue(

        findValue(

          'tbl_sys_menu_item_icon',

          'input[type="hidden"][name="tbl_sys_menu_item_icon"]',

          ''

        )

      );


    }


    var routeID = findValue(

      'tbl_sys_route_ID',

      'select[name="tbl_sys_route_ID"]',

      0

    );


    routeID = parseInt(

      routeID,

      10

    );


    if(

      !Number.isInteger(

        routeID

      ) ||

      routeID <= 0

    ) {


      routeID = null;


    }


    var itemData = {

      tbl_sys_menu_item_ID:

        id,

      tbl_sys_menu_item_title:

        String(

          findValue(

            'tbl_sys_menu_item_title'

          )

          || ''

        ).trim(),

      tbl_sys_menu_item_status:

        String(

          findValue(

            'tbl_sys_menu_item_status',

            'select[name="tbl_sys_menu_item_status"]',

            'ativo'

          )

          || 'ativo'

        ).trim(),

      tbl_sys_menu_item_index:

        String(

          findValue(

            'tbl_sys_menu_item_index'

          )

          || ''

        ).trim(),

      tbl_sys_menu_item_class:

        String(

          findValue(

            'tbl_sys_menu_item_class'

          )

          || ''

        ).trim(),

      tbl_sys_menu_item_type:

        String(

          findValue(

            'tbl_sys_menu_item_type',

            'select[name="tbl_sys_menu_item_type"]',

            'route'

          )

          || 'route'

        ).trim(),

      tbl_sys_route_ID:

        routeID,

      tbl_sys_menu_item_link:

        String(

          findValue(

            'tbl_sys_menu_item_link'

          )

          || ''

        ).trim(),

      tbl_sys_menu_item_props:

        props,

      tbl_sys_menu_item_icon:

        iconValue,

      tbl_sys_menu_item_admin:

        String(

          findValue(

            'tbl_sys_menu_item_admin',

            'select[name="tbl_sys_menu_item_admin"]',

            0

          )

        ),

      tbl_sys_menu_item_access:

        accessValues,

      tbl_sys_menu_item_parent_id:

        parentId === null

          ? 0

          : parentId,

      tbl_sys_menu_item_ordem:

        parseInt(

          order,

          10

        ),

    };


    var lockedEl = contentEl.querySelector(

      'select[name="tbl_sys_menu_item_locked"]'

    );


    if(lockedEl) {


      itemData.tbl_sys_menu_item_locked =

        String(

          lockedEl.value

        );


    }


    return itemData;


  }


  
</script>