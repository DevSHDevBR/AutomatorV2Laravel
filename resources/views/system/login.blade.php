<div class="container py-5">

  <div class="row justify-content-center">

    <div class="col-12 col-md-6 col-lg-4">

      <div class="card text-bg-light shadow">

        <div class="card-body">

          <h1 class="h4 mb-4 text-center">{!! SysAutomator::SysAutomatorGetTranslateWord('Login') !!}</h1>

          @include('system.forms.login-form', [
            'action' => route('api.admin-api-login')
          ])

        </div>

      </div>

    </div>

  </div>

</div>