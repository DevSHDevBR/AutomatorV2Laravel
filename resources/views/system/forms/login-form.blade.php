<form class="js-login-form" method="POST" action="{{ $action ?? '#' }}" autocomplete="off" data-automator-ignore-ajax="true">


  @csrf

  <div class="form-floating mb-3">

    <input type="text" class="form-control" id="js-login-form-login" name="login" placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord('Usuário / E-mail') !!}" value="developer" autocomplete="username" required />
    <label for="js-login-form-login">{!! SysAutomator::SysAutomatorGetTranslateWord('Usuário / E-mail') !!}</label>

  </div>

  <div class="input-group mb-3">

    <div class="form-floating">

      <input type="text" class="form-control automator-input-password" id="js-login-form-password" placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord('Senha') !!}" name="password" value="dev" autocomplete="current-password" required />
      <label for="js-login-form-password">{!! SysAutomator::SysAutomatorGetTranslateWord('Senha') !!}</label>

    </div>
    <span class="input-group-text p-0 text-center" style="min-width: 50px;">
      
      <button type="button" class="h-100 w-100 border-0" data-bs-toggle="tooltip" data-show="{!! SysAutomator::SysAutomatorGetTranslateWord('Exibir senha') !!}" data-hide="{!! SysAutomator::SysAutomatorGetTranslateWord('Ocultar senha') !!}" onclick="AutomatorPasswordInputBTN(this, 'js-login-form-password')" data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord('Exibir senha') !!}"><i class="fa fa-eye"></i></button>
    
    </span>

  </div>

  <div class="form-check mb-2">

    <input class="form-check-input" type="checkbox" value="true" id="js-login-form-remember" name="remember" />
    <label class="form-check-label" for="js-login-form-remember">{!! SysAutomator::SysAutomatorGetTranslateWord('Lembrar') !!}</label>

  </div>

  <a class="mb-4 link-secondary w-100 d-table link-offset-2" href="{!! SysAutomator::SysAutomatorGetRouteLinkByName('admin-esqueci-minha-senha', [], true) !!}">{!! SysAutomator::SysAutomatorGetTranslateWord('Esqueci minha senha') !!}</a>

  <button type="submit" class="btn btn-primary w-100 mt-1">{!! SysAutomator::SysAutomatorGetTranslateWord('Entrar') !!}</button>

</form>

@once
  @push('scripts')

    <script>

      window.AutomatorRoutes = window.AutomatorRoutes || {};

      window.AutomatorRoutes.apiLogin = "{{ route('api.admin-api-login') }}";
      
    </script>

    <script src="{{ asset('assets/system/painel-login.js') }}" type="text/javascript"></script>

  @endpush
@endonce