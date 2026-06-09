<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}"  class="h-100 w-100 m-0 p-0">
  
  <head>
    
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    <title>{{ SysAutomator::SysAutomatorGetConfigValue('site-title', 'Automator') }} - {!! $title !!}</title>

    @vite(['resources/scss/app.scss', 'resources/js/app.js'])

    <!-- Scripts -->
    
    <script src="{{ asset('assets/vendor/jquery/jquery-3.7.1.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-inputmask/jquery.inputmask.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/jquery-validate/jquery.validate.min.js') }}"></script>
    <script src="{{ asset('assets/system/painel-scripts.js') }}" type="text/javascript"></script>
    

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="{{ asset('assets/vendor/fontawesome/all.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/system/painel-style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/system/painel-public-style.css') }}">

  </head>
  <body class="h-100 w-100 m-0 p-0 d-table bg-gray-50">
    
    <main>
      
      @hasSection('content')
        @yield('content')
      @else
        @if(isset($contentView))
          @include($contentView, $contentData ?? [])
        @else
          {!! $content ?? '' !!}
        @endif
      @endif

    </main>

    @include('system.page-loader')

    @stack('scripts')
  
  </body>

</html>