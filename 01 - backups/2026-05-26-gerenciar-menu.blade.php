@php
  

  $currentMenuData = [];
  foreach($menus as $_menu) {

    if(count($currentMenuData) <= 0) {

      if($currentMenu == $_menu['tbl_sys_menu_ID']) {

        $currentMenuData = SysAutomator::SysAutomatorGetMenuItemsByMenuID($_menu['tbl_sys_menu_ID']);

      }

    }

  }

@endphp



<style>

  #menu-sortable-list > .menu-item-wrapper {
    --tw-space-y-reverse: 0;
    margin-top: calc(.75rem * calc(1 - var(--tw-space-y-reverse)));
    margin-bottom: calc(.75rem * var(--tw-space-y-reverse));
  }

  .ghost-item {

    background: #ebf5ff !important;
    opacity:    0.4;
    border:     2px dashed #3b82f6 !important;
  
  }


  .chosen-item {
    box-shadow: 0 10px 15px -3px rgba(0,0,0,.1),
                0 4px 6px -2px rgba(0,0,0,.05) !important;
  }

  /* ── Icon Picker ─────────────────────────────────────────── */
  .icon-picker-container { position: relative; }
  .icon-picker-dropdown {
    position: absolute;
    top: 100%; left: 0;
    z-index: 1050;
    width: 100%;
    max-height: 250px;
    overflow-y: auto;
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: .5rem;
    box-shadow: 0 10px 15px -3px rgba(0,0,0,.1);
    display: none;
    padding: .5rem;
  }
  .icon-picker-grid {
    display: grid;
    grid-template-columns: repeat(5, 1fr);
    gap: .5rem;
  }
  .icon-picker-item {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: .5rem;
    border-radius: .375rem;
    cursor: pointer;
    transition: background-color .2s;
  }
  .icon-picker-item:hover { background-color: #f8f9fa; }
  .icon-picker-item i {
    font-size: 1.25rem;
    margin-bottom: .25rem;
    width: 20px; height: 20px;
    display: flex; align-items: center; justify-content: center;
  }
  .icon-picker-item span {
    font-size: .625rem;
    color: #6c757d;
    text-align: center;
    word-break: break-all;
  }
  .icon-picker-no-results {
    padding: 1rem;
    text-align: center;
    color: #adb5bd;
    font-size: .875rem;
  }

  /* ── Icon search prefix ──────────────────────────────────── */
  .icon-search-wrapper { position: relative; }
  .icon-search-wrapper .icon-search-prefix,
  .icon-search-wrapper .current-icon-display {
    position: absolute;
    top: 50%; left: .75rem;
    transform: translateY(-50%);
    pointer-events: none;
    color: #6c757d;
  }
  .icon-search-wrapper .icon-search-input { padding-left: 2.25rem; }


  /* ── Estrutura de itens ──────────────────────────────────── */
  .submenu-item { margin-bottom: 10px; }
  .submenu-list > .submenu-item:first-child { margin-top: 20px; }
  .submenu-list > .submenu-item:last-child  { margin-bottom: 20px; }

  .menu-item { transition: border-color .2s; }
  .menu-item:hover { border-color: #0d6efd !important; }

  .menu-item-body {
    border-top: 1px solid #f0f0f0;
    background-color: #f8f9fa;
    border-bottom-left-radius: .5rem;
    border-bottom-right-radius: .5rem;
    padding: 1rem;
  }

  .handle { cursor: grab; }
  .handle:active { cursor: grabbing; }

  #menu-sortable-list { min-height: 60px; }


  .menu-itens-users-types button,
  .menu-itens-users-types button:hover {
    border-radius: var(--bs-border-radius-sm);
    padding-top: .25rem;
    padding-bottom: .25rem;
    padding-left: .5rem;
    font-size: .875rem;
    border: 1px solid #dee2e6;
    background-color: #FFFFFF !important;
    text-align: left;
    width: 100%;
  }

  .menu-itens-users-types button:after {

    visibility: hidden;

  }


</style>



<div class="page-card mb-4">
  
  <div class="page-card-body">

    <div class="row g-3 align-items-end justify-content-between">

      <div class="col-12 col-sm-auto">

        <button type="button" class="btn btn-success border d-inline-flex align-items-center justify-content-center gap-2 w-100">{!! SysAutomator::SysAutomatorGetTranslateWord($textos['create-new-menu']) !!}</button>

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

            <button type="button" class="btn btn-info border d-inline-flex align-items-center justify-content-center gap-2 text-white"><i class="fa fa-plus text-white"></i> {!! SysAutomator::SysAutomatorGetTranslateWord($textos['add-menu-item']) !!}</button>
            
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

                        <!-- <pre><?php //var_dump($menuItem); ?></pre> -->
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

                          <div class="col-12 col-md-6 icon-picker-container">
                            
                            <label for="tbl_sys_menu_item_icon-{{ $mID }}" class="form-label fw-bold text-uppercase small mb-1">{{ SysAutomator::SysAutomatorGetTranslateWord($textos['icon']) }}</label>
                            <div class="icon-search-wrapper">
                              
                              <i class="fa fa-{{ $mIcone ?: 'search' }} icon-search-prefix current-icon-display"></i>
                              <input id="tbl_sys_menu_item_icon-{{ $mID }}" type="text" name="tbl_sys_menu_item_icon" value="{{ str_replace('fa-solid fa-', '', $mIcone) }}" class="form-control form-control-sm icon-search-input" placeholder="{{ SysAutomator::SysAutomatorGetTranslateWord($textos['icon-search']) }}" onfocus="showIconPicker(this)" onkeyup="filterIcons(this)" />
                            
                            </div>
                            <div class="icon-picker-dropdown">
                              
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
                              
                              <option value="1"   {{ $mAdmin == '1'   ? 'selected' : '' }}>{!! SysAutomator::SysAutomatorGetTranslateWord($textos['yes']) !!}</option>
                              <option value="0" {{ $mAdmin == '0' ? 'selected' : '' }}>{!! SysAutomator::SysAutomatorGetTranslateWord($textos['no']) !!}</option>
                            
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
                          <!-- <pre><?php //var_dump($submenu); ?></pre> -->
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

                <div class="text-center fs-4">{!! SysAutomator::SysAutomatorGetTranslateWord('Nenhum item cadastrado!') !!}</div>

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



    // Fechar picker ao clicar fora
    document.addEventListener('click', function(e) {
      
      if (!e.target.closest('.icon-picker-container')) {
        
        document.querySelectorAll('.icon-picker-dropdown').forEach(d => d.style.display = 'none');
      
      }

    });


  });




  // Funções do Icon Picker
  function initIconPickers() {
    
    document.querySelectorAll('.icon-picker-grid').forEach(grid => {
      
      renderIcons(grid, faIcons);
    
    });
  
  }



  function renderIcons(grid, icons) {
    
    grid.innerHTML = '';
    
    if (icons.length === 0) {

      grid.innerHTML = '<div class="icon-picker-no-results" style="grid-column: 1 / -1;">Nenhum ícone encontrado</div>';
      return;

    }
    
    icons.forEach(icon => {

      const item = document.createElement('div');
      item.className = 'icon-picker-item';
      item.innerHTML = `<i class="fa fa-${icon}"></i><span>${icon}</span>`;
      item.onclick = function() {

        const container = grid.closest('.icon-picker-container');
        const input = container.querySelector('.icon-search-input');
        const display = container.querySelector('.current-icon-display');
        input.value = icon;
        display.className = `fa fa-${icon} text-gray-400 current-icon-display`;
        container.querySelector('.icon-picker-dropdown').style.display = 'none';
        setMenuChanged();

      };

      grid.appendChild(item);

    });

  }



  function showIconPicker(input) {

    const container = input.closest('.icon-picker-container');
    const dropdown = container.querySelector('.icon-picker-dropdown');
    document.querySelectorAll('.icon-picker-dropdown').forEach(d => d.style.display = 'none');
    dropdown.style.display = 'block';
    filterIcons(input);

  }



  function filterIcons(input) {

    const term = input.value.toLowerCase();
    const container = input.closest('.icon-picker-container');
    const grid = container.querySelector('.icon-picker-grid');
    const filtered = faIcons.filter(icon => icon.includes(term));
    renderIcons(grid, filtered);

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
    var icon = el.find('i');
    var pai = el.closest('.menu-item-wrapper');
    var submenus = pai.find('.submenu-list');
    if(submenus.hasClass('d-none')) {
    
      submenus.removeClass('d-none');
      icon.removeClass('rotate-180');
    
    } else {
    
      submenus.addClass('d-none');
      icon.addClass('rotate-180');
    
    }
  
  }



  function atualizarTipoMenu(field) {

    var el = $(field);
    var valor = el.val();
    var wrapper = el.closest('.menu-item-wrapper');
    var submenus = wrapper.find('.submenu-list');
    var hasSubmenus = submenus.find('.menu-item-wrapper').length > 0;

    // Regra: Não permitir alterar para link se tiver sub-menus
    if (valor === 'link' && hasSubmenus) {

      alert('Não é possível alterar um menu para o tipo "Link" quando ele tiver sub-menus incluídos nele. Por favor, remova todos os sub-menus primeiro.');
      el.val('route'); 
      return;

    }

    var pai = el.parent().parent();
    var paginas = pai.find('.menu-itens-pagina');
    var link = pai.find('.menu-itens-link');

    if(valor == 'route') {
      
      paginas.removeClass('d-none');
      link.addClass('d-none');
      link.find('input').val('');
    
    } else if(valor == 'link') {

      paginas.addClass('d-none');
      paginas.find('select').val('0');
      link.removeClass('d-none');
    
    } else {
      
      paginas.addClass('d-none');
      paginas.find('select').val('0');
      link.addClass('d-none');
      link.find('input').val('');
    
    }
    
    setMenuChanged();
  
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
    
    const wrapper = btn.closest('.menu-item-wrapper');
    const hasSubmenus = wrapper.querySelector('.submenu-list') && wrapper.querySelector('.submenu-list').children.length > 0;
    let message = "Tem certeza que deseja remover este item?";
    
    if (hasSubmenus) {

      message = "Este menu possui sub-menus. Remover este item também irá remover todos os sub-menus existentes dentro dele. Deseja continuar?";

    }

    if (confirm(message)) {

      wrapper.remove();
      window.refreshMenuStructure();
      setMenuChanged();
  
    }

  }



  function addSubmenu(menuId) {

    const menuWrapper = document.querySelector(`[data-id="${menuId}"]`);
    if (!menuWrapper) return;

    // Verificar se o menu é do tipo link
    const tipoSelect = menuWrapper.querySelector('select[name="tbl_menu_type"]');
    if (tipoSelect && tipoSelect.value === 'link') {
        alert('Não é possível adicionar sub-menus a um menu do tipo "Link".');
        return;
    }

    let submenuList = menuWrapper.querySelector('.submenu-list');
    if (!submenuList) {
        submenuList = document.createElement('div');
        submenuList.className = 'submenu-list transition-transform duration-200 ml-12 mt-3 space-y-3';
        submenuList.dataset.parentId = menuId;
        menuWrapper.appendChild(submenuList);
    }

    menuWrapper.querySelector('.chevron-btn').classList.remove('d-none');
    menuWrapper.querySelector('.ban-icon').classList.add('d-none');

    // Gera um ID temporário para o novo submenu
    const tempId = 'temp-' + Date.now();
    
    const newSubmenuHTML = `
        <div class="menu-item-wrapper submenu-item" data-id="${tempId}">
            <div class="menu-item group group-child bg-white border border-gray-200 rounded-lg shadow-sm hover:border-blue-400 transition-all">
                <div class="flex items-center p-3 cursor-move handle">
                    <div class="mr-3 text-gray-400" style="margin-right: 10px;">
                        <i class="fa-solid fa-grip-vertical"></i>
                    </div>
                    <div class="flex-1 flex items-center gap-3">
                        <div>
                            <span class="menu-item-nome font-bold text-gray-800 text-sm">Novo Submenu</span>
                        </div>
                    </div>
                    <div class="flex items-center gap-4">
                        <span class="menu-item-status text-xs font-medium px-2 py-1 rounded-full bg-green-100 text-green-700">
                            Ativo
                        </span>
                        <button type="button" onclick="toggleAccordion('item-${tempId}')" class="text-gray-400 hover:text-blue-600 p-1 tooltip-icon" data-tooltip="Editar">
                            <i id="icon-item-${tempId}" class="fa-solid fa-pencil transition-transform duration-200"></i>
                        </button>
                        <button type="button" onclick="deleteMenuItem(null, this)" class="text-gray-400 hover:text-red-600 p-1 tooltip-icon" data-tooltip="Remover">
                            <i class="fa-solid fa-trash transition-transform duration-200"></i>
                        </button>
                    </div>
                </div>

                <div id="content-item-${tempId}" class="border-t border-gray-100 p-4 bg-gray-50 rounded-b-lg">
                    <input type="hidden" class="menu-item-parent-val" value="${menuId}" />
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Rótulo de Navegação</label>
                            <input type="text" name="tbl_menu_nome" value="Novo Submenu" class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" onkeyup="atualizarNomeMenu(this)" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Status do Menu</label>
                            <select name="tbl_menu_status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" onchange="return atualizarStatusMenu(this)">
                                <option value="ativo" selected>Ativo</option>
                                <option value="inativo">Inativo</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">ID do Menu</label>
                            <input type="text" name="tbl_menu_index" value="" class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Classes do Menu</label>
                            <input type="text" name="tbl_menu_class" value="" class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Tipo do Menu</label>
                            <select name="tbl_menu_type" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" onchange="atualizarTipoMenu(this)">
                                <option value="pagina" selected>Pagina</option>
                                <option value="link">Link</option>
                                <option value="button">Botão</option>
                            </select>
                        </div>
                        <div class="menu-itens-pagina">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Pagina do Menu</label>
                            <select name="tbl_menu_pagina_ID" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                                <option value="0" selected>- Selecione -</option>
                                @foreach($paginas as $pagina)
                                    <option value="{{ $pagina->tbl_pagina_ID }}">{{ $pagina->tbl_pagina_titulo }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="menu-itens-link d-none">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Link do Menu</label>
                            <input type="text" name="tbl_menu_link" value="" class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Propriedades do Menu</label>
                            <input type="text" name="tbl_menu_props" value="" class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
                        </div>
                        <div class="icon-picker-container">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Icone do Menu</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fa-solid fa-search text-gray-400 current-icon-display"></i>
                                </div>
                                <input type="text" name="tbl_menu_icone" value="" class="icon-search-input w-full pl-10 text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Pesquisar ícone..." onfocus="showIconPicker(this)" onkeyup="filterIcons(this)" />
                            </div>
                            <div class="icon-picker-dropdown">
                                <div class="icon-picker-grid">
                                    <!-- Ícones serão carregados via JS -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;

    submenuList.insertAdjacentHTML('afterbegin', newSubmenuHTML);
    
    // Reinicializar os icon pickers para o novo elemento
    initIconPickers();
    
    // Reinicializar os sortables
    window.initAllSortables();
    
    // Abrir o accordion do novo submenu com scroll suave e foco
    setTimeout(() => {
        const newWrapper = document.querySelector(`[data-id="${tempId}"]`);
        if (newWrapper) {
            // Scroll suave até o novo item
            newWrapper.scrollIntoView({ behavior: 'smooth', block: 'center' });
            // Abrir o accordion
            // toggleAccordion('item-' + tempId);
            // Dar foco ao campo de nome
            const nomeInput = newWrapper.querySelector('input[name="tbl_menu_nome"]');
            if (nomeInput) {
                setTimeout(() => {
                    nomeInput.focus();
                    nomeInput.select();
                }, 300);
            }
        }
    }, 100);
    
    setMenuChanged();
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
  

  // Atualização 26-05
  // function validateMenuStructure() {

  //   const wrappers = document.querySelectorAll('#menu-sortable-list > .menu-item-wrapper');
    
  //   for (const wrapper of wrappers) {

  //     const nome = wrapper.querySelector('input[name="tbl_menu_nome"]');
  //     const tipo = wrapper.querySelector('select[name="tbl_menu_type"]');
  //     const pagina = wrapper.querySelector('select[name="tbl_menu_pagina_ID"]');
  //     const link = wrapper.querySelector('input[name="tbl_menu_link"]');
      
  //     let isValid = true;
  //     let errorMsg = '';
      
  //     // Validar nome
  //     if (!nome || !nome.value.trim()) {

  //       isValid = false;
  //       errorMsg += '- Rótulo de Navegação é obrigatório\n';

  //     }
      
  //     // Validar tipo
  //     if (!tipo || !tipo.value) {

  //       isValid = false;
  //       errorMsg += '- Tipo do Menu é obrigatório\n';

  //     }
      
  //     // Validar conforme o tipo - APENAS para tipo "pagina"
  //     if (tipo && tipo.value === 'pagina') {

  //       if (!pagina || pagina.value === '0' || !pagina.value) {

  //         isValid = false;
  //         errorMsg += '- Página do Menu é obrigatória para menus do tipo "Página"\n';
        
  //       }
      
  //     }
      
  //     if (!isValid) {

  //       // Scroll animado até o item
  //       const menuItem = wrapper.querySelector('.menu-item');
  //       menuItem.scrollIntoView({ behavior: 'smooth', block: 'center' });
        
  //       // Abrir o accordion se estiver fechado
  //       const contentId = 'content-item-' + wrapper.dataset.id;
  //       const content = document.getElementById(contentId);
  //       if (content && content.classList.contains('d-none')) {
          
  //         toggleAccordion('item-' + wrapper.dataset.id);
        
  //       }
        
  //       // Dar foco ao primeiro campo obrigatório vazio
  //       setTimeout(() => {

  //         if (!nome || !nome.value.trim()) {

  //           nome.focus();
  //           nome.select();

  //         } else if (!tipo || !tipo.value) {
            
  //           tipo.focus();

  //         } else if (tipo.value === 'pagina' && (!pagina || pagina.value === '0')) {
            
  //           pagina.focus();

  //         }
  //       }, 300);
        
  //       // Exibir mensagem de erro
  //       alert('Erro: Configuração incompleta do menu!\n\n' + errorMsg + '\nPor favor, complete a configuração do menu destacado.');
  //       return false;

  //     }

  //   }
    
  //   return true;

  // }



  // function saveMenu() {

    // return;
      // // Validar estrutura dos menus
      // if (!validateMenuStructure()) {
      //     return;
      // }

      // if (!confirm("Deseja salvar as alterações realizadas no menu?")) {
      //     return;
      // }

      // const loader = document.getElementById('page-loader');
      // loader.style.display = 'flex';

      // const menuData = [];
      
      // /* 
      //    RECONSTRUÇÃO COMPLETA DA HIERARQUIA
      //    Como o Controller original faz truncate e usa os IDs enviados no POST para os parent_ids,
      //    precisamos garantir que os IDs que enviamos sejam consistentes entre si.
         
      //    Vamos mapear cada item para um novo ID sequencial (1, 2, 3...) 
      //    e usar esses novos IDs para definir a relação pai/filho.
      // */
      
      // const idMapping = new Map();
      // let nextId = 1;

      // // Primeiro passo: Mapear todos os wrappers para novos IDs sequenciais
      // const allWrappers = document.querySelectorAll('.menu-item-wrapper');
      // allWrappers.forEach(wrapper => {
      //     idMapping.set(wrapper, nextId++);
      // });

      // // Segundo passo: Processar a estrutura recursivamente usando o mapeamento
      // const processWrapper = (wrapper, order, parentId) => {
      //     const currentNewId = idMapping.get(wrapper);
      //     const data = extractItemData(wrapper, order, parentId);
          
      //     // Substituímos o ID original pelo nosso novo ID sequencial
      //     data.id = currentNewId;
      //     // O parentId já vem correto da chamada recursiva (é o novo ID do pai)
      //     data.tbl_menu_parent = parentId;

      //     menuData.push(data);
          
      //     const subList = wrapper.querySelector('.submenu-list');
      //     if (subList) {
      //         const children = Array.from(subList.children).filter(child => child.classList.contains('menu-item-wrapper'));
      //         children.forEach((subWrapper, subIndex) => {
      //             // Passamos o novo ID do pai para os filhos
      //             processWrapper(subWrapper, subIndex + 1, currentNewId);
      //         });
      //     }
      // };

      // // Começar pelos itens de nível superior (parent_id = 0)
      // const topLevelItems = Array.from(document.querySelectorAll('#menu-sortable-list > .menu-item-wrapper'));
      // topLevelItems.forEach((menuWrapper, index) => {
      //     processWrapper(menuWrapper, index + 1, 0);
      // });

      // $.ajax({
      //     url: "{!! $routes['menu-update'] !!}",
      //     method: 'POST',
      //     data: {
      //         _token: "{{ csrf_token() }}",
      //         menus: menuData
      //     },
      //     success: function(response) {
      //         if (response.success) {
      //             menuChanged = false;
      //             document.getElementById('gerenciar-menu-save').disabled = true;
      //             alert(response.message || 'Menu atualizado com sucesso!');
      //             setTimeout(function() {
      //                 location.reload();
      //             }, 500);
      //         } else {
      //             alert(response.message || 'Erro ao salvar o menu. Por favor, tente novamente.');
      //         }
      //     },
      //     error: function(xhr) {
      //         let errorMessage = 'Erro ao salvar o menu. Por favor, tente novamente.';
      //         if (xhr.responseJSON && xhr.responseJSON.message) {
      //             errorMessage = xhr.responseJSON.message;
      //         }
      //         alert(errorMessage);
      //         console.error(xhr);
      //     },
      //     complete: function() {
      //         loader.style.display = 'none';
      //     }
      // });
  // }


  function saveMenu() {

    const menuData = [];

    const idMapping = new Map();
    let nextId = 1;

    const allWrappers = document.querySelectorAll('.menu-item-wrapper');
    allWrappers.forEach(wrapper => {
      idMapping.set(wrapper, nextId++);
    });

    // ── Helper: abre accordion, faz scroll e foca o campo ──────────────────────
    const focarItem = (wrapper, campoEl = null) => {

      const id = wrapper.dataset.id;

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

    const processWrapper = (wrapper, order, parentId) => {

      const currentNewId = idMapping.get(wrapper);

      // ── extractItemData inline com validação ──────────────────────────────────
      const id        = wrapper.dataset.id;
      const isSub     = wrapper.classList.contains('submenu-item');
      const contentEl = wrapper.querySelector(`:scope > .menu-item > [id^="content-item-"]`);

      const findVal = (name, type = 'input') => {
        const el         = contentEl ? contentEl.querySelector(`${type}[name="${name}"]`) : null;
        const fallbackEl = wrapper.querySelector(`:scope > .menu-item > [id^="content-item-"] ${type}[name="${name}"]`);
        return (el || fallbackEl)?.value ?? '';
      };

      // ── Validação: campos obrigatórios ────────────────────────────────────────
      const nome  = contentEl?.querySelector('input[name="tbl_sys_menu_item_title"]');
      const tipo  = contentEl?.querySelector('select[name="tbl_sys_menu_item_type"]');
      const pag   = contentEl?.querySelector('select[name="tbl_sys_route_ID"]');

      if (!nome || !nome.value.trim()) {
        focarItem(wrapper, nome);
        alert('Erro: Configuração incompleta do menu!\n\n- Rótulo de Navegação é obrigatório\n\nPor favor, complete a configuração do menu destacado.');
        return false;
      }

      if (!tipo || !tipo.value) {
        focarItem(wrapper, tipo);
        alert('Erro: Configuração incompleta do menu!\n\n- Tipo do Menu é obrigatório\n\nPor favor, complete a configuração do menu destacado.');
        return false;
      }

      if (tipo.value === 'route' && (!pag || !pag.value || pag.value === '0')) {
        focarItem(wrapper, pag);
        alert('Erro: Configuração incompleta do menu!\n\n- Página do Menu é obrigatória para menus do tipo "Página"\n\nPor favor, complete a configuração do menu destacado.');
        return false;
      }

      // ── Validação + captura de props ──────────────────────────────────────────
      const propKeyPrefix   = isSub ? `menu-item-prop-${id}-sub-key-`   : `menu-item-prop-${id}-key-`;
      const propValuePrefix = isSub ? `menu-item-prop-${id}-sub-value-` : `menu-item-prop-${id}-value-`;
      const propsClass      = isSub ? '.menu-item-props-subs' : '.menu-item-props';
      const propsContainer  = contentEl?.querySelector(`${propsClass}[data-item="${id}"]`);

      let propsProcessado = '';

      if (propsContainer) {

        const propItems  = propsContainer.querySelectorAll('.menu-item-props-item');
        const keysVistas = [];
        const propsObj   = {};

        for (const propItem of propItems) {

          const keyInput   = propItem.querySelector(`input[id^="${propKeyPrefix}"]`);
          const valueInput = propItem.querySelector(`input[id^="${propValuePrefix}"]`);

          if (!keyInput || !valueInput) continue;

          const k = keyInput.value.trim();
          const v = valueInput.value.trim();

          // Regra 1: valor preenchido sem nome
          if (k === '' && v !== '') {
            focarItem(wrapper, keyInput);
            alert(
              'Erro: Propriedade inválida no menu "' + nome.value.trim() + '"!\n\n' +
              '- A propriedade com valor "' + v + '" não possui nome definido.\n\n' +
              'Por favor, preencha o nome da propriedade destacada.'
            );
            return false;
          }

          // Regra 2: nome duplicado
          if (k !== '') {
            if (keysVistas.includes(k)) {
              focarItem(wrapper, keyInput);
              alert(
                'Erro: Propriedade duplicada no menu "' + nome.value.trim() + '"!\n\n' +
                '- Já existe uma propriedade com o nome "' + k + '".\n\n' +
                'Cada propriedade deve ter um nome único.'
              );
              return false;
            }
            keysVistas.push(k);
            propsObj[k] = v;
          }

        }

        if (Object.keys(propsObj).length > 0) {
          propsProcessado = JSON.stringify(propsObj);
        }

      }

      // ── Ícone ─────────────────────────────────────────────────────────────────
      let iconeRaw      = findVal('tbl_sys_menu_item_icon');
      let iconeStripped = iconeRaw.replace(/^fa(-solid)?\s+fa-/, '').trim();
      let iconeProcessado = iconeStripped ? 'fa fa-' + iconeStripped : '';

      // ── Access ────────────────────────────────────────────────────────────────
      const accessInputs = contentEl
        ? contentEl.querySelectorAll('input[name="tbl_sys_menu_item_access"]:checked')
        : [];
      const accessValues = Array.from(accessInputs).map(el => el.value);

      // ── Monta objeto do item ──────────────────────────────────────────────────
      const data = {
        tbl_sys_menu_item_ID:        currentNewId,
        tbl_sys_menu_item_title:     findVal('tbl_sys_menu_item_title'),
        tbl_sys_menu_item_status:    findVal('tbl_sys_menu_item_status', 'select'),
        tbl_sys_menu_item_index:     findVal('tbl_sys_menu_item_index'),
        tbl_sys_menu_item_class:     findVal('tbl_sys_menu_item_class'),
        tbl_sys_menu_item_type:      findVal('tbl_sys_menu_item_type', 'select'),
        tbl_sys_route_ID:            findVal('tbl_sys_route_ID', 'select') || 0,
        tbl_sys_menu_item_link:      findVal('tbl_sys_menu_item_link'),
        tbl_sys_menu_item_props:     propsProcessado,
        tbl_sys_menu_item_icon:      iconeProcessado,
        tbl_sys_menu_item_admin:     findVal('tbl_sys_menu_item_admin', 'select'),
        tbl_sys_menu_item_access:    accessValues,
        tbl_sys_menu_item_parent_id: parentId,
        tbl_sys_menu_item_ordem:     order
      };

      // Campo condicional: só existe no DOM quando deleteON == true no PHP
      const lockedEl = contentEl?.querySelector(`select[name="tbl_sys_menu_item_locked"]`);
      if (lockedEl) {
        data.tbl_sys_menu_item_locked = lockedEl.value;
      }

      menuData.push(data);

      // ── Processa filhos ───────────────────────────────────────────────────────
      const subList  = wrapper.querySelector('.submenu-list');
      if (subList) {
        const children = Array.from(subList.children).filter(c => c.classList.contains('menu-item-wrapper'));
        for (let i = 0; i < children.length; i++) {
          const result = processWrapper(children[i], i + 1, currentNewId);
          if (result === false) return false;
        }
      }

      return true;

    };

    // ── Percorre os itens de nível superior ─────────────────────────────────────
    const topLevelItems = Array.from(document.querySelectorAll('#menu-sortable-list > .menu-item-wrapper'));
    for (let i = 0; i < topLevelItems.length; i++) {
      const result = processWrapper(topLevelItems[i], i + 1, 0);
      if (result === false) return;
    }

    // ── Payload que seria enviado ao AJAX ────────────────────────────────────────
    const payload = {
      _token: document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}',
      menus: menuData
    };

    console.group('saveMenu — payload que seria enviado ao AJAX');
    console.log('URL destino :', '{!! $routes["menu-update"] !!}');
    console.log('Método      :', 'POST');
    console.log('Total itens :', menuData.length);
    console.table(menuData);
    console.log('Payload completo:', payload);
    console.groupEnd();

    return false;

  }

  // Atualização 26-05
  // function saveMenu() {

  //   // Monta os dados exatamente como seriam enviados ao AJAX, sem disparar requisição

  //   const menuData = [];

  //   const idMapping = new Map();
  //   let nextId = 1;

  //   // Primeiro passo: mapeia todos os wrappers para IDs sequenciais
  //   const allWrappers = document.querySelectorAll('.menu-item-wrapper');
  //   allWrappers.forEach(wrapper => {
  //     idMapping.set(wrapper, nextId++);
  //   });

  //   // Segundo passo: processa a hierarquia recursivamente
  //   const processWrapper = (wrapper, order, parentId) => {
  //     const currentNewId = idMapping.get(wrapper);
  //     const data = extractItemData(wrapper, order, parentId);

  //     data.tbl_sys_menu_item_ID    = currentNewId;
  //     data.tbl_sys_menu_item_parent_id = parentId;

  //     menuData.push(data);

  //     const subList = wrapper.querySelector('.submenu-list');
  //     if (subList) {
  //       const children = Array.from(subList.children).filter(child =>
  //         child.classList.contains('menu-item-wrapper')
  //       );
  //       children.forEach((subWrapper, subIndex) => {
  //         processWrapper(subWrapper, subIndex + 1, currentNewId);
  //       });
  //     }
  //   };

  //   // Itens de nível superior (parent = 0)
  //   const topLevelItems = Array.from(
  //     document.querySelectorAll('#menu-sortable-list > .menu-item-wrapper')
  //   );
  //   topLevelItems.forEach((menuWrapper, index) => {
  //     processWrapper(menuWrapper, index + 1, 0);
  //   });

  //   // Payload que seria enviado ao AJAX
  //   const payload = {
  //     _token: document.querySelector('meta[name="csrf-token"]')?.content ?? '{{ csrf_token() }}',
  //     menus: menuData
  //   };

  //   console.group('saveMenu — payload que seria enviado ao AJAX');
  //   console.log('URL destino :', '{!! $routes["menu-update"] !!}');
  //   console.log('Método      :', 'POST');
  //   console.log('Total itens :', menuData.length);
  //   console.table(menuData);
  //   console.log('Payload completo:', payload);
  //   console.groupEnd();

  //   return false;

  // }


  // function extractItemData(wrapper, order, parentId) {

  //   const id = wrapper.dataset.id;
  //   const findVal = (name, type = 'input') => {

  //     // Usamos :scope para garantir que pegamos o input do item atual e não de um submenu
  //     const el = wrapper.querySelector(`:scope > .menu-item > [id^="content-item-"] ${type}[name="${name}"]`);
  //     // Fallback caso a estrutura mude ligeiramente
  //     const fallbackEl = wrapper.querySelector(`${type}[name="${name}"]`);
  //     const finalEl = el || fallbackEl;
  //     return finalEl ? finalEl.value : '';
    
  //   };

    
  //   // Limpeza do ícone: removemos o prefixo se já existir para não duplicar
  //   let iconeRaw = findVal('tbl_menu_icone');
  //   let iconeProcessado = iconeRaw.replace('fa-solid fa-', '').replace('fa-regular fa-', '').replace('fa-brands fa-', '').trim();
  //   if (iconeProcessado && !iconeProcessado.startsWith('fa-')) {
      
  //     iconeProcessado = 'fa-solid fa-' + iconeProcessado;

  //   }
    
  //   return {

  //     id: id,
  //     tbl_menu_nome: findVal('tbl_menu_nome'),
  //     tbl_menu_status: findVal('tbl_menu_status', 'select'),
  //     tbl_menu_index: findVal('tbl_menu_index'),
  //     tbl_menu_class: findVal('tbl_menu_class'),
  //     tbl_menu_type: findVal('tbl_menu_type', 'select'),
  //     tbl_menu_pagina_ID: findVal('tbl_menu_pagina_ID', 'select') || 0,
  //     tbl_menu_link: findVal('tbl_menu_link'),
  //     tbl_menu_props: findVal('tbl_menu_props'),
  //     tbl_menu_icone: iconeProcessado,
  //     tbl_menu_parent: parentId,
  //     tbl_menu_ordem: order

  //   };

  // }


  function menuPropHTML(menuID, propID = 0, isSub = false) {


    var propName   = "{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-prop-name']) !!}";
    var propValue  = "{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-prop-value']) !!}";
    var propRemove = "{!! SysAutomator::SysAutomatorGetTranslateWord($textos['menu-prop-remove']) !!}";

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


          retorno += '<div class="col-12 col-md-2 mb-3"><button class="btn btn-danger btn-sm w-100 text-center h-100" data-bs-toggle="tooltip" data-bs-title="' + propRemove + '" onclick="removeMenuProp(' + menuID + ', ' + propID + ', this' + ( (isSub == true) ? ', true' : '' ) + ')"><i class="fa fa-trash"></i></button></div>' + "\n";

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

      menuProps.html(propHTML);

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

    if (btn) {

      var tooltipInstance = bootstrap.Tooltip.getInstance(btn);

      if (tooltipInstance) {

        tooltipInstance.hide();
        // tooltipInstance.dispose();

      }

    }

    var menuType = ( (isSub == true) ? ".menu-item-props-subs" : ".menu-item-props" );
    var menuProps = $(menuType + "[data-item='" + menuID + "']");
    var menuProp  = menuProps.find(".menu-item-props-item[data-prop='" + propID + "']");

    menuProp.remove();

    var menuPorpsCount = menuProps.find(".menu-item-props-item");

    if (menuPorpsCount.length <= 0) {

      menuProps.html(
        '<div class="row">' +
          '<div class="col-12 text-center">' +
              '{{ SysAutomator::SysAutomatorGetTranslateWord($textos["no-props-found-in-menu-item"]) }}' +
          '</div>' +
        '</div>'
      );

    }

    setMenuChanged();

  }



  function atualizarContagemUserTypesCheckbox(btn) {

    var el     = $(btn);
    var elID   = el.attr('id');
    var quebra = elID.split('-');

    var drop      = '#' + quebra[0] + '-btn';
    var dropdown  = $(drop);
    var countEl   = dropdown.find('b');

    var total = parseInt(countEl.html()) || 0;

    if (el.is(':checked')) {

        total++;

    } else {

        total--;

    }

    if (total < 0) {
        total = 0;
    }

    countEl.html(total);

  }



  function atualizarDisplayUsersTypes(btn) {
    
    var el = $(btn);
    var valor = el.val()
    var elID  = el.attr('id');
    var quebra = elID.split('-');
    var usersType = $('#tbl_sys_menu_item_users_types-' + quebra[1]);

    usersType.find('button.dropdown-toggle').find('b').html('0');
    usersType.find('input[type="checkbox"]').prop('checked', false);

    if(valor == 1) {

      usersType.removeClass('d-none');

    } else {
      
      usersType.addClass('d-none');

    }

  }


  function extractItemData(wrapper, order, parentId) {

    const id    = wrapper.dataset.id;
    const isSub = wrapper.classList.contains('submenu-item');

    // Container do conteúdo do item atual (evita capturar campos de submenus filhos)
    const contentEl = wrapper.querySelector(`:scope > .menu-item > [id^="content-item-"]`);

    const findVal = (name, type = 'input') => {
      const el = contentEl
        ? contentEl.querySelector(`${type}[name="${name}"]`)
        : null;
      const fallbackEl = wrapper.querySelector(`:scope > .menu-item > [id^="content-item-"] ${type}[name="${name}"]`);
      const finalEl = el || fallbackEl;
      return finalEl ? finalEl.value : '';
    };

    // ── Ícone: normaliza prefixo para não duplicar ────────────────────────────
    let iconeRaw      = findVal('tbl_sys_menu_item_icon');
    let iconeStripped = iconeRaw.replace(/^fa(-solid)?\s+fa-/, '').trim();
    let iconeProcessado = iconeStripped ? 'fa fa-' + iconeStripped : '';

    // ── Props: captura pares key/value com seletor preciso por tipo ───────────
    const propsClass     = isSub ? '.menu-item-props-subs' : '.menu-item-props';
    const propsContainer = contentEl
      ? contentEl.querySelector(propsClass + `[data-item="${id}"]`)
      : wrapper.querySelector(propsClass + `[data-item="${id}"]`);

    let propsProcessado = '';
    if (propsContainer) {
      const propItems = propsContainer.querySelectorAll('.menu-item-props-item');
      if (propItems.length > 0) {
        const propsObj = {};
        propItems.forEach(propItem => {
          // Seletor via fragmento de id para diferenciar item principal de submenu:
          // principal: menu-item-prop-{id}-key-{n}
          // submenu:   menu-item-prop-{id}-sub-key-{n}
          const keyInput   = isSub
            ? propItem.querySelector(`input[id^="menu-item-prop-${id}-sub-key-"]`)
            : propItem.querySelector(`input[id^="menu-item-prop-${id}-key-"]`);
          const valueInput = isSub
            ? propItem.querySelector(`input[id^="menu-item-prop-${id}-sub-value-"]`)
            : propItem.querySelector(`input[id^="menu-item-prop-${id}-value-"]`);
          if (keyInput && valueInput) {
            const k = keyInput.value.trim();
            const v = valueInput.value.trim();
            if (k !== '') {
              propsObj[k] = v;
            }
          }
        });
        if (Object.keys(propsObj).length > 0) {
          propsProcessado = JSON.stringify(propsObj);
        }
      }
    }

    // ── Access: captura checkboxes marcados de tipos de usuário ──────────────
    const accessInputs = contentEl
      ? contentEl.querySelectorAll('input[name="tbl_sys_menu_item_access"]:checked')
      : [];
    const accessValues = Array.from(accessInputs).map(el => el.value);

    // ── Dados base do item ────────────────────────────────────────────────────
    const itemData = {
      tbl_sys_menu_item_ID:        id,
      tbl_sys_menu_item_title:     findVal('tbl_sys_menu_item_title'),
      tbl_sys_menu_item_status:    findVal('tbl_sys_menu_item_status', 'select'),
      tbl_sys_menu_item_index:     findVal('tbl_sys_menu_item_index'),
      tbl_sys_menu_item_class:     findVal('tbl_sys_menu_item_class'),
      tbl_sys_menu_item_type:      findVal('tbl_sys_menu_item_type', 'select'),
      tbl_sys_route_ID:            findVal('tbl_sys_route_ID', 'select') || 0,
      tbl_sys_menu_item_link:      findVal('tbl_sys_menu_item_link'),
      tbl_sys_menu_item_props:     propsProcessado,
      tbl_sys_menu_item_icon:      iconeProcessado,
      tbl_sys_menu_item_admin:     findVal('tbl_sys_menu_item_admin', 'select'),
      tbl_sys_menu_item_access:    accessValues,
      tbl_sys_menu_item_parent_id: parentId,
      tbl_sys_menu_item_ordem:     order
    };

    // ── Campos condicionais: só existem no DOM quando deleteON == true no PHP ─
    const lockedEl = contentEl
      ? contentEl.querySelector(`select[name="tbl_sys_menu_item_locked"]`)
      : null;
    if (lockedEl) {
      itemData.tbl_sys_menu_item_locked = lockedEl.value;
    }

    return itemData;

  }

  // Atualização 26-05
  // function extractItemData(wrapper, order, parentId) {

  //   const id = wrapper.dataset.id;
  //   const isSub = wrapper.classList.contains('submenu-item');

  //   // Busca o container de conteúdo do item atual (evita capturar campos de submenus filhos)
  //   const contentEl = wrapper.querySelector(`:scope > .menu-item > [id^="content-item-"]`);

  //   const findVal = (name, type = 'input') => {
  //     // Tenta primeiro com escopo restrito ao content do item atual
  //     const el = contentEl
  //       ? contentEl.querySelector(`${type}[name="${name}"]`)
  //       : null;
  //     // Fallback: busca direto no wrapper, mas limitado ao primeiro nível (sem descer em submenu-list)
  //     const fallbackEl = wrapper.querySelector(`:scope > .menu-item > [id^="content-item-"] ${type}[name="${name}"]`);
  //     const finalEl = el || fallbackEl;
  //     return finalEl ? finalEl.value : '';
  //   };

  //   // ── Ícone: normaliza prefixo para não duplicar ────────────────────────────
  //   let iconeRaw       = findVal('tbl_sys_menu_item_icon');
  //   let iconeStripped  = iconeRaw.replace(/^fa(-solid)?\s+fa-/, '').trim();
  //   let iconeProcessado = iconeStripped
  //     ? 'fa fa-' + iconeStripped
  //     : '';

  //   // ── Props: captura pares key/value dos .menu-item-props-item ─────────────
  //   // Para submenus usa '.menu-item-props-subs', para itens principais '.menu-item-props'
  //   const propsClass   = isSub ? '.menu-item-props-subs' : '.menu-item-props';
  //   const propsContainer = contentEl
  //     ? contentEl.querySelector(propsClass + `[data-item="${id}"]`)
  //     : wrapper.querySelector(propsClass + `[data-item="${id}"]`);

  //   let propsProcessado = '';
  //   if (propsContainer) {
  //     const propItems = propsContainer.querySelectorAll('.menu-item-props-item');
  //     if (propItems.length > 0) {
  //       const propsObj = {};
  //       propItems.forEach(propItem => {
  //         // Os inputs de key e value não têm name, são identificados pelo id:
  //         // menu-item-prop-{id}-key-{n} e menu-item-prop-{id}-value-{n}
  //         const keyInput   = propItem.querySelector(`input[id^="menu-item-prop-${id}-key-"]`);
  //         const valueInput = propItem.querySelector(`input[id^="menu-item-prop-${id}-value-"]`);
  //         if (keyInput && valueInput) {
  //           const k = keyInput.value.trim();
  //           const v = valueInput.value.trim();
  //           if (k !== '') {
  //             propsObj[k] = v;
  //           }
  //         }
  //       });
  //       // Salva como JSON se houver ao menos uma propriedade válida
  //       if (Object.keys(propsObj).length > 0) {
  //         propsProcessado = JSON.stringify(propsObj);
  //       }
  //     }
  //   }

  //   // ── Dados base do item ────────────────────────────────────────────────────
  //   const itemData = {
  //     tbl_sys_menu_item_ID:        id,
  //     tbl_sys_menu_item_title:     findVal('tbl_sys_menu_item_title'),
  //     tbl_sys_menu_item_status:    findVal('tbl_sys_menu_item_status', 'select'),
  //     tbl_sys_menu_item_index:     findVal('tbl_sys_menu_item_index'),
  //     tbl_sys_menu_item_class:     findVal('tbl_sys_menu_item_class'),
  //     tbl_sys_menu_item_type:      findVal('tbl_sys_menu_item_type', 'select'),
  //     tbl_sys_route_ID:            findVal('tbl_sys_route_ID', 'select') || 0,
  //     tbl_sys_menu_item_link:      findVal('tbl_sys_menu_item_link'),
  //     tbl_sys_menu_item_props:     propsProcessado,
  //     tbl_sys_menu_item_icon:      iconeProcessado,
  //     tbl_sys_menu_item_admin:     findVal('tbl_sys_menu_item_admin', 'select'),
  //     tbl_sys_menu_item_parent_id: parentId,
  //     tbl_sys_menu_item_ordem:     order
  //   };

  //   // ── Campos condicionais de acesso (só existem no DOM quando permitido) ────
  //   // tbl_sys_menu_item_locked só é renderizado quando deleteON == true no PHP
  //   const lockedEl = contentEl
  //     ? contentEl.querySelector(`select[name="tbl_sys_menu_item_locked"]`)
  //     : null;
  //   if (lockedEl) {
  //     itemData.tbl_sys_menu_item_locked = lockedEl.value;
  //   }

  //   return itemData;

  // }


  // function extractItemData(wrapper, order, parentId) {

  //   const id = wrapper.dataset.id;
  //   const findVal = (name, type = 'input') => {
  //     // Usamos :scope para garantir que pegamos o input do item atual e não de um submenu
  //     const el = wrapper.querySelector(`:scope > .menu-item > [id^="content-item-"] ${type}[name="${name}"]`);
  //     // Fallback caso a estrutura mude ligeiramente
  //     const fallbackEl = wrapper.querySelector(`${type}[name="${name}"]`);
  //     const finalEl = el || fallbackEl;
  //     return finalEl ? finalEl.value : '';
  //   };

  //   // Limpeza do ícone: removemos o prefixo se já existir para não duplicar
  //   let iconeRaw = findVal('tbl_sys_menu_item_icon');
  //   let iconeProcessado = iconeRaw.replace('fa fa-', '').trim();
  //   if (iconeProcessado && !iconeProcessado.startsWith('fa-')) {
  //     iconeProcessado = 'fa fa-' + iconeProcessado;
  //   }

  //   let propsProcessado = '';
    
  //   return {

  //     tbl_sys_menu_item_ID: id,
  //     tbl_sys_menu_item_title: findVal('tbl_sys_menu_item_title'),
  //     tbl_sys_menu_item_status: findVal('tbl_sys_menu_item_status', 'select'),
  //     tbl_sys_menu_item_index: findVal('tbl_sys_menu_item_index'),
  //     tbl_sys_menu_item_class: findVal('tbl_sys_menu_item_class'),
  //     tbl_sys_menu_item_type: findVal('tbl_sys_menu_item_type', 'select'),
  //     tbl_sys_route_ID: findVal('tbl_sys_route_ID', 'select') || 0,
  //     tbl_sys_menu_item_link: findVal('tbl_sys_menu_item_link'),
  //     tbl_sys_menu_item_props: propsProcessado,
  //     tbl_sys_menu_item_icon: iconeProcessado,
  //     tbl_sys_menu_item_admin: findVal('tbl_sys_menu_item_admin', 'select'),
  //     tbl_sys_menu_item_parent_id: parentId,
  //     tbl_sys_menu_item_ordem: order
  //   };
  
  // }



  // function addMenuItem() {
  //     // Gera um ID temporário para o novo menu
  //     const tempId = 'temp-' + Date.now();
      
  //     const newMenuHTML = `
  //         <div class="menu-item-wrapper" data-id="${tempId}">
  //             <div class="menu-item group group-parent bg-white border border-gray-200 rounded-lg shadow-sm hover:border-blue-400 transition-all">
  //                 <div class="flex items-center p-3 cursor-move handle">
  //                     <div class="mr-3 text-gray-400" style="margin-right: 10px;">
  //                         <i class="fa-solid fa-grip-vertical"></i>
  //                     </div>
  //                     <div class="flex-1 flex items-center gap-3">
  //                         <div>
  //                             <span class="menu-item-nome font-bold text-gray-900">Novo Menu</span>
  //                         </div>
  //                     </div>
  //                     <div class="flex items-center gap-4">
  //                         <span class="menu-item-status text-xs font-medium px-2 py-1 rounded-full bg-green-100 text-green-700">
  //                             Ativo
  //                         </span>
  //                         <button type="button" onclick="toggleAccordion('item-${tempId}')" class="text-gray-400 hover:text-blue-600 p-1 tooltip-icon" data-tooltip="Editar">
  //                             <i id="icon-item-${tempId}" class="fa-solid fa-pencil transition-transform duration-200"></i>
  //                         </button>
  //                         <button type="button" onclick="addSubmenu('${tempId}')" class="text-gray-400 hover:text-green-600 p-1 tooltip-icon" data-tooltip="Adicionar submenu">
  //                             <i class="fa-solid fa-plus transition-transform duration-200"></i>
  //                         </button>
  //                         <button type="button" onclick="toggleSubmenuDisplay(this)" class="text-gray-400 hover:text-blue-600 p-1 tooltip-icon chevron-btn chevron-btn-${tempId} d-none" data-tooltip="Expandir/Recolher">
  //                             <i id="icon2-item-${tempId}" class="fa-solid fa-chevron-up transition-transform duration-200"></i>
  //                         </button>
  //                         <button type="button" class="text-gray-400 hover:text-blue-600 p-1 tooltip-icon ban-icon ban-icon-${tempId}" data-tooltip="Sem submenus">
  //                             <i id="ban-icon2-item-${tempId}" class="fa-solid fa-ban transition-transform duration-200"></i>
  //                         </button>
  //                         <button type="button" onclick="deleteMenuItem(null, this)" class="text-gray-400 hover:text-red-600 p-1 tooltip-icon" data-tooltip="Remover">
  //                             <i class="fa-solid fa-trash transition-transform duration-200"></i>
  //                         </button>
  //                     </div>
  //                 </div>

  //                 <div id="content-item-${tempId}" class="border-t border-gray-100 p-4 bg-gray-50 rounded-b-lg">
  //                     <input type="hidden" class="menu-item-parent-val" value="0" />
  //                     <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
  //                         <div>
  //                             <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Rótulo de Navegação</label>
  //                             <input type="text" name="tbl_menu_nome" value="Novo Menu" class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" onkeyup="atualizarNomeMenu(this)" />
  //                         </div>
  //                         <div>
  //                             <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Status do Menu</label>
  //                             <select name="tbl_menu_status" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" onchange="return atualizarStatusMenu(this)">
  //                                 <option value="ativo" selected>Ativo</option>
  //                                 <option value="inativo">Inativo</option>
  //                             </select>
  //                         </div>
  //                         <div>
  //                             <label class="block text-xs font-bold text-gray-700 uppercase mb-1">ID do Menu</label>
  //                             <input type="text" name="tbl_menu_index" value="" class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
  //                         </div>
  //                         <div>
  //                             <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Classes do Menu</label>
  //                             <input type="text" name="tbl_menu_class" value="" class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
  //                         </div>
  //                         <div>
  //                             <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Tipo do Menu</label>
  //                             <select name="tbl_menu_type" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" onchange="atualizarTipoMenu(this)">
  //                                 <option value="pagina" selected>Pagina</option>
  //                                 <option value="link">Link</option>
  //                                 <option value="button">Botão</option>
  //                             </select>
  //                         </div>
  //                         <div class="menu-itens-pagina">
  //                             <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Pagina do Menu</label>
  //                             <select name="tbl_menu_pagina_ID" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
  //                                 <option value="0" selected>- Selecione -</option>
  //                                 @foreach($paginas as $pagina)
  //                                     <option value="{{ $pagina->tbl_pagina_ID }}">{{ $pagina->tbl_pagina_titulo }}</option>
  //                                 @endforeach
  //                             </select>
  //                         </div>
  //                         <div class="menu-itens-link d-none">
  //                             <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Link do Menu</label>
  //                             <input type="text" name="tbl_menu_link" value="" class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
  //                         </div>
  //                         <div>
  //                             <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Propriedades do Menu</label>
  //                             <input type="text" name="tbl_menu_props" value="" class="w-full text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" />
  //                         </div>
  //                         <div class="icon-picker-container">
  //                             <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Icone do Menu</label>
  //                             <div class="relative">
  //                                 <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
  //                                     <i class="fa-solid fa-search text-gray-400 current-icon-display"></i>
  //                                 </div>
  //                                 <input type="text" name="tbl_menu_icone" value="" class="icon-search-input w-full pl-10 text-sm border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500" placeholder="Pesquisar ícone..." onfocus="showIconPicker(this)" onkeyup="filterIcons(this)" />
  //                             </div>
  //                             <div class="icon-picker-dropdown">
  //                                 <div class="icon-picker-grid">
  //                                     <!-- Ícones serão carregados via JS -->
  //                                 </div>
  //                             </div>
  //                         </div>
  //                     </div>
  //                 </div>
  //             </div>
  //         </div>
  //     `;

  //     document.getElementById('menu-sortable-list').insertAdjacentHTML('afterbegin', newMenuHTML);
      
  //     // Reinicializar os icon pickers para o novo elemento
  //     initIconPickers();
      
  //     // Reinicializar os sortables
  //     window.initAllSortables();
      
  //     // Abrir o accordion do novo menu com scroll suave e foco
  //     setTimeout(() => {
  //         const newWrapper = document.querySelector(`[data-id="${tempId}"]`);
  //         if (newWrapper) {
  //             // Scroll suave até o novo item
  //             newWrapper.scrollIntoView({ behavior: 'smooth', block: 'center' });
  //             // Abrir o accordion
  //             // toggleAccordion('item-' + tempId);
  //             // Dar foco ao campo de nome
  //             const nomeInput = newWrapper.querySelector('input[name="tbl_menu_nome"]');
  //             if (nomeInput) {
  //                 setTimeout(() => {
  //                     nomeInput.focus();
  //                     nomeInput.select();
  //                 }, 300);
  //             }
  //         }
  //     }, 100);
      
  //     setMenuChanged();
  // }


  
</script>