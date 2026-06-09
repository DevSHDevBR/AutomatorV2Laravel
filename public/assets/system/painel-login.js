$(document).on('submit', '.js-login-form', function(e) {

  e.preventDefault();

  const form = $(this);


  AutomatorGetActionStatus(function() {

    AutomatorSetActionStatus(true, function() {

      AutomatorPageLoader('show', function() {

        $.ajax({
          url: window.AutomatorRoutes.apiLogin,
          type: 'POST',
          data: form.serialize(),
          headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
          },
          // headers: {
          //   'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
          //   'Accept': 'application/json'
          // },
          dataType: 'json',
          success: function(response) {

            console.log(response);
            if(response.status == true) {

              AutomatorSetActionStatus(false, function() {

                if(response.redirect_url) {

                  window.location.href = response.redirect_url;

                } else {

                  window.location.href = '/admin';

                }

              });

            } else {

              if(xhr.status == 419) {

                alert('Sua sessão expirou. A página será recarregada para atualizar o token de segurança.');

                window.location.reload();

                return;

              }

              var message = 'Não foi possível realizar o login.';

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

            var message = 'Não foi possível realizar o login.';

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

      return false;

    });

    return false;

  });

  return false;

});