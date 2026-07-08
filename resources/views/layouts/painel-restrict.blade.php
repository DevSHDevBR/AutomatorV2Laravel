<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  class="h-100 w-100 m-0 p-0">
  
  <head>
    
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ SysAutomator::SysAutomatorGetConfigValue('site-title', 'Automator') }} - {!! $title !!}</title>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    <!-- Scripts -->
    
    <script data-automator-editor-asset="jquery" src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
    <script data-automator-editor-asset="mask" src="{{ asset('assets/vendor/jquery-inputmask/jquery.inputmask.min.js') }}"></script>
    <script data-automator-editor-asset="validate" src="{{ asset('assets/vendor/jquery-validate/jquery.validate.min.js') }}"></script>
    <script data-automator-editor-asset="sortable" src="{{ asset('assets/vendor/jquery/Sortable.min.js') }}"></script>
    <script src="{{ asset('assets/system/painel-scripts.js') }}?data=<?php echo md5(date('YmdHis')); ?>" type="text/javascript"></script>

    <script>

      window.AutomatorRoutes = window.AutomatorRoutes || {};

      window.AutomatorRoutes.apiLogout = "{!! SysAutomator::SysAutomatorGetRouteLinkByName('admin-api-logout', [], true) !!}";
      window.AutomatorRoutes.apiForms  = "{!! SysAutomator::SysAutomatorGetRouteLinkByName('admin-api-forms-get', ['id' => '#ID#'], true) !!}";
      window.AutomatorRoutes.apiAdmin  = "{!! SysAutomator::SysAutomatorGetRouteLinkByName('admin-api-functions', true) !!}";
      window.AutomatorRoutes.apiView   = "{!! SysAutomator::SysAutomatorGetRouteLinkByName('admin-api-view-get', [], true) !!}";
      window.AutomatorRoutes.apiEditor = "{!! SysAutomator::SysAutomatorGetRouteLinkByName('admin-api-forms-editor-field', [], true) !!}";
      
      
    </script>

    <script src="{{ asset('assets/system/painel-restrict-scripts.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/system/automator-page-editor-script.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/system/automator-form-editor-script.js') }}?data=<?php echo md5(date('YmdHis')); ?>" type="text/javascript"></script>
    

    <!-- Font Awesome for Icons -->
    <link data-automator-editor-asset="fontawesome" rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/all.min.css') }}" />
    <link data-automator-editor-asset="bootstrap" data-automator-editor-href="{{ asset('assets/system/bootstrap.min.css') }}" hidden />
    <link rel="stylesheet" href="{{ asset('assets/system/painel-style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/system/painel-restrict-style.css') }}">

  </head>
  <body>
    
    <aside class="app-sidebar d-none d-lg-flex">

      <div class="app-sidebar-header">

        <div class="app-logo">A</div>

        <div class="app-brand-info">

          <h1 class="app-brand-title">{!! SysAutomator::SysAutomatorGetConfigValue('site-title', 'Automator') !!}</h1>

        </div>

      </div>

      {!! SysAutomator::SysAutomatorGenerateNavMenu('admin-sidebar', 'nav') !!}
    
    </aside>

    <!-- Botão Desktop para recolher/exibir menu -->
    <button type="button" class="sidebar-toggle-desktop d-none d-lg-flex" id="sidebarToggleDesktop">
      <i class="fa fa-chevron-left" id="sidebarToggleIcon"></i>
    </button>


    <!-- Offcanvas Mobile -->
    <div class="offcanvas offcanvas-start offcanvas-sidebar" tabindex="-1" id="mobileSidebar" aria-labelledby="mobileSidebarLabel">

      <div class="offcanvas-header">

        <div class="d-flex align-items-center">

          <div class="app-logo">A</div>
          <div>

            <h5 class="app-brand-title mb-0" id="mobileSidebarLabel">{!! SysAutomator::SysAutomatorGetConfigValue('site-title', 'Automator') !!}</h5>

          </div>

        </div>

        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Fechar"></button>

      </div>
      <div class="offcanvas-body">

        {!! SysAutomator::SysAutomatorGenerateNavMenu('admin-sidebar', 'nav') !!}

      </div>
    
    </div>

    <!-- Área principal -->
    <main class="app-main">

      <!-- Topbar -->
      <header class="app-topbar">

        <!-- Botão mobile para abrir offcanvas -->
        <button class="btn btn-outline-primary mobile-sidebar-button me-3" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileSidebar" aria-controls="mobileSidebar">

          <i class="fa fa-list"></i>

        </button>

        <div class="d-flex align-items-center justify-content-between w-100 gap-3">

          <div class="d-block fw-semibold mx-auto mx-md-0 flex-fill">{!! $title !!}</div>

          <div id="notifications" class="dropdown">

            <button class="notifications-dropdown-button dropdown-toggle" type="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">

              <span data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord('Notificações') !!}">

                <span class="user-avatar"><i class="fa fa-bell"></i></span>
                @if( SysAutomator::SysAutomatorGetUserNotificationsUnopedNumber(SysAutomator::SysAutomatorGetCurrentUserData('tbl_user_ID')) >= 1)
                  
                  <span class="position-absolute translate-middle p-2 bg-danger border border-light rounded-circle" style="left: 75%; top: 15px;"></span>

                @endif

              </span>

            </button>

            <ul class="dropdown-menu dropdown-menu-end shadow" data-popper-placement="bottom-end" style="position: absolute; inset: 0px 0px auto auto; margin: 0px; transform: translate(0px, 54px);">
              
              <li class="text-center"><div class="dropdown-item p-2" style="background: #3b82f6; color: #FFFFFF;"><b>{!! SysAutomator::SysAutomatorGetTranslateWord('Notificações') !!}</b></div></li>
              <li><hr class="dropdown-divider"></li>
              <li id="notifications-list">
                
                {!! SysAutomator::SysAutomatorGetUserNotificationsListHTML(SysAutomator::SysAutomatorGetCurrentUserData('tbl_user_ID')) !!}
              
              </li>

              @if( SysAutomator::SysAutomatorGetUserNotificationsUnopedNumber(SysAutomator::SysAutomatorGetCurrentUserData('tbl_user_ID')) >= 1)

                <li><hr class="dropdown-divider"></li>
                <li class="text-center list-group-item list-group-item-primary">
                  
                  <a href="{!! SysAutomator::SysAutomatorGetRouteLinkByName('admin-notificacoes', [], true) !!}" class="dropdown-item bg-info-subtle fw-semibold link-underline-opacity-100-hover p-2 fs-6"><span>{!! SysAutomator::SysAutomatorGetTranslateWord('Ver todas as notificações') !!}</span></a>

                
                </li>
              @endif
            
            </ul>

          </div>

          <div class="dropdown">

            <button class="user-dropdown-button dropdown-toggle" type="button" data-bs-toggle="dropdown" aria-expanded="false">

              <span class="user-avatar"><i class="fa fa-user"></i></span>
              <span class="user-info">

                <span class="user-name">{!! SysAutomator::SysAutomatorGetCurrentUserData('tbl_user_name') !!}</span>
                <!-- <span class="user-role">Minha Conta</span> -->

              </span>

            </button>

            {!! SysAutomator::SysAutomatorGenerateNavMenu('admin-header', 'ul') !!}

          </div>

        </div>
      
      </header>
      
      <section class="app-content">

        @hasSection('content')

          @yield('content')

        @else

          @if(isset($contentView))

            @include($contentView, $contentData ?? [])

          @else

            {!! $content ?? '' !!}

          @endif

        @endif

      </section>

    </main>

    @include('system.page-loader')

    @stack('scripts')
  
  </body>

</html>