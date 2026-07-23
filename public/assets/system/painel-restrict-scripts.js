/*
|--------------------------------------------------------------------------
| Logout manual
|--------------------------------------------------------------------------
*/

$(document)
  .off('click.AutomatorManualLogout')
  .on(
    'click.AutomatorManualLogout',
    '.btn-logout-system',
    function(e) {


      e.preventDefault();


      /*
      |--------------------------------------------------------------------------
      | Logout manual não deve restaurar a página anterior
      |--------------------------------------------------------------------------
      */

      window.__automatorManualLogout = true;


      try {

        sessionStorage.removeItem(

          'automator.return.url'

        );

      } catch(error) {}


      AutomatorGetActionStatus(function() {


        AutomatorSetActionStatus(true, function() {


          AutomatorPageLoader('show', function() {


            $.ajax({

              url: window.AutomatorRoutes.apiLogout,

              type: 'POST',

              data: {},

              headers: {

                'X-CSRF-TOKEN':

                  $('meta[name="csrf-token"]')
                    .attr('content'),

                'Accept': 'application/json',

              },

              dataType: 'json',

              success: function(response) {


                if(response.status == true) {


                  AutomatorSetActionStatus(false, function() {


                    if(response.redirect_url) {

                      window.location.href =

                        response.redirect_url;

                    } else {

                      window.location.href =

                        '/admin';

                    }


                  });


                } else {


                  window.__automatorManualLogout = false;


                  var message =

                    'Não foi possível realizar o logout.';


                  if(response.message) {

                    message = response.message;

                  }


                  alert(

                    message

                  );


                  AutomatorPageLoader('hide', function() {

                    AutomatorSetActionStatus(false);

                  });


                }


              },

              error: function(xhr) {


                window.__automatorManualLogout = false;


                /*
                |--------------------------------------------------------------------------
                | A sessão já pode ter expirado durante o logout
                |--------------------------------------------------------------------------
                */

                if(

                  typeof AutomatorSessionResponseIsExpired === 'function' &&

                  AutomatorSessionResponseIsExpired(xhr)

                ) {

                  AutomatorSessionForceLogin(xhr);

                  return;

                }


                var message =

                  'Não foi possível realizar o logout.';


                if(

                  xhr.responseJSON &&

                  xhr.responseJSON.message

                ) {

                  message =

                    xhr.responseJSON.message;

                } else if(xhr.responseText) {

                  message = xhr.responseText;

                }


                alert(

                  message

                );


                AutomatorPageLoader('hide', function() {

                  AutomatorSetActionStatus(false);

                });


              },

            });


          });


        });


      });


      return false;


    }
  );

// $(document).on('click', '.btn-logout-system', function(e) {

//   AutomatorGetActionStatus(function() {

//     AutomatorSetActionStatus(true, function() {

//       AutomatorPageLoader('show', function() {

//         $.ajax({
//           url: window.AutomatorRoutes.apiLogout,
//           type: 'POST',
//           data: {},
//           headers: {
//             'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
//             'Accept': 'application/json'
//           },
//           dataType: 'json',
//           success: function(response) {

//             if(response.status == true) {

//               AutomatorSetActionStatus(false, function() {

//                 if(response.redirect_url) {

//                   window.location.href = response.redirect_url;

//                 } else {

//                   window.location.href = '/admin';

//                 }

//               });

//             } else {

//               var message = 'Não foi possível realizar o login.';

//               if(response.message) {
//                 message = response.message;
//               }

//               alert(message);

//               AutomatorPageLoader('hide', function() {
//                 AutomatorSetActionStatus(false);
//               });

//             }

//           },
//           error: function(xhr) {

//             var message = 'Não foi possível realizar o login.';

//             if(xhr.responseJSON && xhr.responseJSON.message) {

//               message = xhr.responseJSON.message;

//             } else if(xhr.responseText) {

//               message = xhr.responseText;

//             }

//             alert(message);

//             AutomatorPageLoader('hide', function() {
//               AutomatorSetActionStatus(false);
//             });

//           }

//         });

//       });

//     });

//   });

//   return false;

// });


/*
|--------------------------------------------------------------------------
| AUTOMATOR SESSION MANAGER
|--------------------------------------------------------------------------
|
| Controla a expiração da sessão na área restrita.
|
| A verificação acontece:
|
| - ao carregar a página;
| - por intervalo;
| - após interação do usuário;
| - quando uma requisição AJAX retorna 401 ou 419;
| - quando uma requisição AJAX é redirecionada para o login.
|
*/


window.AutomatorSessionManager = window.AutomatorSessionManager || {

  checking: false,

  redirecting: false,

  initialized: false,

  interval: null,

  interactionTimer: null,

  lastInteractionCheck: 0,

  intervalTime: 60000,

  interactionThrottle: 5000,

};



function AutomatorSessionGetLoginURL(
  response = null
) {


  var loginURL = '';


  if(

    response &&

    response.responseJSON &&

    response.responseJSON.login_url

  ) {

    loginURL = String(

      response.responseJSON.login_url

    );

  }


  if(

    loginURL == '' &&

    response &&

    response.login_url

  ) {

    loginURL = String(

      response.login_url

    );

  }


  if(

    loginURL == '' &&

    typeof window.AutomatorRoutes !== 'undefined'

  ) {

    loginURL = String(

      window.AutomatorRoutes.login ||

      window.AutomatorRoutes.adminLogin ||

      window.AutomatorRoutes.pageLogin ||

      ''

    );

  }


  if(loginURL == '') {


    var adminPath =

      window.location.pathname
        .split('/')
        .filter(Boolean)[0] ||

      'admin';


    loginURL =

      window.location.origin +

      '/' +

      adminPath +

      '/login';


  }


  return loginURL;


}



function AutomatorSessionIsLoginURL(
  url = ''
) {


  url = String(

    url || ''

  );


  if(url == '') {

    return false;

  }


  try {


    var parsedURL = new URL(

      url,

      window.location.origin

    );


    var path = String(

      parsedURL.pathname || ''

    )
      .replace(
        /\/+$/,
        ''
      )
      .toLowerCase();


    return (

      path.endsWith('/login') ||

      path.endsWith('/entrar')

    );


  } catch(error) {

    return false;

  }


}



function AutomatorSessionGetCurrentURL() {


  return (

    window.location.pathname +

    window.location.search +

    window.location.hash

  );


}



function AutomatorSessionRememberCurrentURL() {


  if(window.__automatorManualLogout === true) {

    return false;

  }


  if(

    AutomatorSessionIsLoginURL(

      window.location.href

    )

  ) {

    return false;

  }


  var currentURL =

    AutomatorSessionGetCurrentURL();


  if(

    currentURL == '' ||

    currentURL == '/'

  ) {

    return false;

  }


  try {


    sessionStorage.setItem(

      'automator.return.url',

      currentURL

    );


    sessionStorage.setItem(

      'automator.return.created',

      String(

        Date.now()

      )

    );


  } catch(error) {


    console.warn(

      'Não foi possível armazenar a URL atual.',

      error

    );


  }


  return true;


}



function AutomatorSessionClearUnloadWarnings() {


  /*
  |--------------------------------------------------------------------------
  | Remove bloqueios de navegação existentes
  |--------------------------------------------------------------------------
  |
  | O redirecionamento por sessão expirada não pode exibir uma confirmação
  | de alterações não salvas, pois o usuário já não possui uma sessão válida.
  |
  */

  $(window).off(

    'beforeunload.AutomatorSetActionStatus'

  );


  $(window).off(

    'beforeunload.AutomatorModalFormChanged'

  );


  $(window).off(

    'beforeunload.AutomatorModalViewChanged'

  );


  $(window).off(

    'beforeunload.AutomatorFormEditorChanged'

  );


  $(window).off(

    'beforeunload.AutomatorPaginationEditorChanged'

  );


  if(

    window.__automatorFormEditorBeforeUnloadHandler

  ) {

    window.removeEventListener(

      'beforeunload',

      window.__automatorFormEditorBeforeUnloadHandler

    );


    window.__automatorFormEditorBeforeUnloadHandler =

      null;

  }


  return true;


}



function AutomatorSessionBuildLoginRedirectURL(
  loginURL = ''
) {


  loginURL = String(

    loginURL || ''

  );


  if(loginURL == '') {

    loginURL = AutomatorSessionGetLoginURL();

  }


  try {


    var parsedURL = new URL(

      loginURL,

      window.location.origin

    );


    parsedURL.searchParams.set(

      'session_expired',

      '1'

    );


    return parsedURL.toString();


  } catch(error) {


    return loginURL;


  }


}



function AutomatorSessionForceLogin(
  response = null
) {


  var manager =

    window.AutomatorSessionManager;


  if(

    manager.redirecting === true ||

    window.__automatorManualLogout === true

  ) {

    return false;

  }


  manager.redirecting = true;

  manager.checking = false;


  if(manager.interval) {


    clearInterval(

      manager.interval

    );


    manager.interval = null;


  }


  if(manager.interactionTimer) {


    clearTimeout(

      manager.interactionTimer

    );


    manager.interactionTimer = null;


  }


  AutomatorSessionRememberCurrentURL();

  AutomatorSessionClearUnloadWarnings();


  try {

    AutomatorSetActionStatus(false);

  } catch(error) {}


  try {

    $('#page-loader').stop(true, true).show();

  } catch(error) {}


  var loginURL =

    AutomatorSessionGetLoginURL(

      response

    );


  loginURL =

    AutomatorSessionBuildLoginRedirectURL(

      loginURL

    );


  window.location.replace(

    loginURL

  );


  return true;


}



function AutomatorSessionResponseIsExpired(
  xhr = null
) {


  if(!xhr) {

    return false;

  }


  var status = Number(

    xhr.status || 0

  );


  if(

    status == 401 ||

    status == 419

  ) {

    return true;

  }


  if(

    xhr.responseJSON &&

    (
      xhr.responseJSON.session_expired === true ||

      xhr.responseJSON.authenticated === false
    )

  ) {

    return true;

  }


  var responseURL = String(

    xhr.responseURL || ''

  );


  if(

    responseURL != '' &&

    AutomatorSessionIsLoginURL(

      responseURL

    )

  ) {

    return true;

  }


  var responseText = String(

    xhr.responseText || ''

  );


  if(

    responseText != '' &&

    (
      responseText.indexOf(

        'name="login"'

      ) >= 0 &&

      responseText.indexOf(

        'name="password"'

      ) >= 0
    )

  ) {

    return true;

  }


  return false;


}



function AutomatorSessionCheck(
  source = 'manual'
) {


  var manager =

    window.AutomatorSessionManager;


  if(

    manager.checking === true ||

    manager.redirecting === true ||

    window.__automatorManualLogout === true

  ) {

    return false;

  }


  if(

    typeof window.AutomatorRoutes === 'undefined' ||

    !window.AutomatorRoutes.apiAdmin

  ) {

    return false;

  }


  manager.checking = true;


  $.ajax({

    url: window.AutomatorRoutes.apiAdmin,

    type: 'POST',

    data: {

      acao: 'check-session',

      source: source,

    },

    headers: {

      'X-CSRF-TOKEN':

        $('meta[name="csrf-token"]')
          .attr('content'),

      'Accept': 'application/json',

      'X-Automator-Session-Check': 'true',

    },

    dataType: 'json',

    global: false,

    success: function(response) {


      manager.checking = false;


      if(

        !response ||

        response.authenticated === false ||

        response.session_expired === true

      ) {

        AutomatorSessionForceLogin(

          response

        );

      }


    },

    error: function(xhr) {


      manager.checking = false;


      if(

        AutomatorSessionResponseIsExpired(

          xhr

        )

      ) {

        AutomatorSessionForceLogin(

          xhr

        );

      }


    },

  });


  return true;


}



function AutomatorSessionScheduleInteractionCheck() {


  var manager =

    window.AutomatorSessionManager;


  if(

    manager.redirecting === true ||

    manager.checking === true ||

    window.__automatorManualLogout === true

  ) {

    return false;

  }


  var currentTime = Date.now();


  if(

    currentTime -

    manager.lastInteractionCheck

    < manager.interactionThrottle

  ) {

    return false;

  }


  manager.lastInteractionCheck =

    currentTime;


  if(manager.interactionTimer) {

    clearTimeout(

      manager.interactionTimer

    );

  }


  manager.interactionTimer = setTimeout(

    function() {


      manager.interactionTimer = null;


      AutomatorSessionCheck(

        'interaction'

      );


    },

    100

  );


  return true;


}



function AutomatorSessionBindInteractionEvents() {


  $(document)
    .off(
      '.AutomatorSessionInteraction'
    )
    .on(
      'click.AutomatorSessionInteraction ' +
      'keydown.AutomatorSessionInteraction ' +
      'submit.AutomatorSessionInteraction ' +
      'change.AutomatorSessionInteraction',
      function(event) {


        if(

          $(event.target).closest(

            '.btn-logout-system'

          ).length

        ) {

          return;

        }


        AutomatorSessionScheduleInteractionCheck();


      }
    );


  return true;


}



function AutomatorSessionBindAjaxError() {


  $(document)
    .off(
      'ajaxError.AutomatorSession'
    )
    .on(
      'ajaxError.AutomatorSession',
      function(

        event,

        xhr,

        settings

      ) {


        if(

          window.__automatorManualLogout === true ||

          window.AutomatorSessionManager.redirecting === true

        ) {

          return;

        }


        if(

          settings &&

          settings.headers &&

          settings.headers['X-Automator-Session-Check']

        ) {

          return;

        }


        if(

          AutomatorSessionResponseIsExpired(

            xhr

          )

        ) {

          AutomatorSessionForceLogin(

            xhr

          );

        }


      }
    );


  return true;


}



function AutomatorSessionInitialize() {


  var manager =

    window.AutomatorSessionManager;


  if(manager.initialized === true) {

    return false;

  }


  manager.initialized = true;


  AutomatorSessionBindInteractionEvents();

  AutomatorSessionBindAjaxError();


  /*
  |--------------------------------------------------------------------------
  | Verificação inicial
  |--------------------------------------------------------------------------
  */

  AutomatorSessionCheck(

    'page-load'

  );


  /*
  |--------------------------------------------------------------------------
  | Verificação periódica
  |--------------------------------------------------------------------------
  */

  manager.interval = setInterval(

    function() {


      AutomatorSessionCheck(

        'interval'

      );


    },

    manager.intervalTime

  );


  /*
  |--------------------------------------------------------------------------
  | Retorno à aba
  |--------------------------------------------------------------------------
  */

  document.addEventListener(

    'visibilitychange',

    function() {


      if(document.visibilityState == 'visible') {

        AutomatorSessionCheck(

          'visibility'

        );

      }


    }

  );


  /*
  |--------------------------------------------------------------------------
  | Foco na janela
  |--------------------------------------------------------------------------
  */

  window.addEventListener(

    'focus',

    function() {


      AutomatorSessionCheck(

        'focus'

      );


    }

  );


  return true;


}



document.addEventListener(

  'DOMContentLoaded',

  function() {


    AutomatorSessionInitialize();


  }

);



document.addEventListener('DOMContentLoaded', function () {

    const sidebarToggleDesktop = document.getElementById('sidebarToggleDesktop');
    const sidebarToggleIcon = document.getElementById('sidebarToggleIcon');
    const mobileSidebarEl = document.getElementById('mobileSidebar');

    function AutomatorUpdateSidebarToggleIcon() {

        if (!sidebarToggleIcon) {
            return false;
        }

        if (document.body.classList.contains('sidebar-collapsed')) {

            sidebarToggleIcon.classList.remove('fa-chevron-left');
            sidebarToggleIcon.classList.add('fa-chevron-right');

        } else {

            sidebarToggleIcon.classList.remove('fa-chevron-right');
            sidebarToggleIcon.classList.add('fa-chevron-left');

        }

    }

    function AutomatorCloseMobileSidebar(withoutAnimation = false) {

        if (!mobileSidebarEl) {
            return false;
        }

        if (typeof bootstrap === 'undefined' || !bootstrap.Offcanvas) {
            return false;
        }

        var mobileSidebarInstance = bootstrap.Offcanvas.getInstance(mobileSidebarEl);

        if (!mobileSidebarInstance) {
            return false;
        }

        if (withoutAnimation === true) {

            mobileSidebarEl.classList.add('offcanvas-no-transition');

            mobileSidebarInstance.hide();

            setTimeout(function() {

                mobileSidebarEl.classList.remove('offcanvas-no-transition');

                document.body.classList.remove('offcanvas-backdrop');
                document.body.classList.remove('modal-open');
                document.body.style.removeProperty('overflow');
                document.body.style.removeProperty('padding-right');

                var offcanvasBackdrops = document.querySelectorAll('.offcanvas-backdrop');

                offcanvasBackdrops.forEach(function(backdrop) {
                    backdrop.remove();
                });

            }, 10);

        } else {

            mobileSidebarInstance.hide();

        }

    }

    function AutomatorPositionCollapsedSubmenus() {

        if (!document.body.classList.contains('sidebar-collapsed')) {
            return false;
        }

        if (window.innerWidth <= 991.98) {
            return false;
        }

        var submenuButtons = document.querySelectorAll('.app-sidebar .sidebar-link[data-bs-toggle="collapse"]');

        submenuButtons.forEach(function(button) {

            var targetSelector = button.getAttribute('data-bs-target');

            if (!targetSelector) {
                return;
            }

            var submenu = document.querySelector(targetSelector);

            if (!submenu) {
                return;
            }

            var buttonRect = button.getBoundingClientRect();

            submenu.style.top = buttonRect.top + 'px';

        });

    }

    function AutomatorCloseCollapsedSubmenus() {

        if (typeof bootstrap === 'undefined' || !bootstrap.Collapse) {
            return false;
        }

        var openedSubmenus = document.querySelectorAll('.app-sidebar .sidebar-submenu.show');

        openedSubmenus.forEach(function(submenu) {

            var collapseInstance = bootstrap.Collapse.getInstance(submenu);

            if (collapseInstance) {

                collapseInstance.hide();

            } else {

                submenu.classList.remove('show');

            }

        });

    }

    function AutomatorNormalizeSidebarByScreenSize() {

        if (window.innerWidth <= 991.98) {

            document.body.classList.remove('sidebar-collapsed');

            AutomatorCloseCollapsedSubmenus();

        } else {

            AutomatorCloseMobileSidebar(true);

        }

        AutomatorUpdateSidebarToggleIcon();

        AutomatorPositionCollapsedSubmenus();

    }

    if (sidebarToggleDesktop) {

        sidebarToggleDesktop.addEventListener('click', function () {

            document.body.classList.toggle('sidebar-collapsed');

            AutomatorCloseCollapsedSubmenus();

            AutomatorUpdateSidebarToggleIcon();

            AutomatorPositionCollapsedSubmenus();

        });

    }

    document.addEventListener('shown.bs.collapse', function(event) {

        if (!document.body.classList.contains('sidebar-collapsed')) {
            return false;
        }

        if (!event.target.classList.contains('sidebar-submenu')) {
            return false;
        }

        AutomatorPositionCollapsedSubmenus();

    });

    window.addEventListener('resize', function() {

        AutomatorNormalizeSidebarByScreenSize();

        AutomatorPositionCollapsedSubmenus();

    });

    AutomatorNormalizeSidebarByScreenSize();

});



/*
|--------------------------------------------------------------------------
| FORM BUILDER - HELPERS
|--------------------------------------------------------------------------
*/

function AutomatorFormBuilderSlugify(text = '') {

    text = String(text || '');

    text = text.normalize('NFD').replace(/[\u0300-\u036f]/g, '');

    text = text.toLowerCase();

    text = text.replace(/[^a-z0-9\s-]/g, '');

    text = text.replace(/\s+/g, '-');

    text = text.replace(/-+/g, '-');

    text = text.replace(/^-|-$/g, '');

    return text;

}



function AutomatorFormBuilderGetModalId() {

    return 'automator-form-builder-modal';

}



function AutomatorFormBuilderGetFieldsContainerSelector() {

    return '#automator-form-builder-editor-container';

}



function AutomatorFormBuilderDestroyModal(callback = null) {

    var modalEl = document.getElementById(
        AutomatorFormBuilderGetModalId()
    );

    if(!modalEl) {

        if(typeof callback === 'function') {
            callback();
        }

        return false;

    }

    var modalInstance = bootstrap.Modal.getInstance(modalEl);

    if(modalInstance) {
        modalInstance.hide();
    }

    $(modalEl).remove();

    $('.modal-backdrop').remove();

    $('body').removeClass('modal-open');
    $('body').css('overflow', '');
    $('body').css('padding-right', '');

    if(typeof callback === 'function') {
        callback();
    }

    return true;

}



function AutomatorFormBuilderSetChangedState(
    modalEl = null,
    status = false
) {

    if(!modalEl) {
        return false;
    }

    status = !!status;

    modalEl.setAttribute(
        'data-automator-form-changed',
        status ? 'true' : 'false'
    );

    var saveBtn = modalEl.querySelector(
        '.btn-automator-form-builder-save'
    );

    if(saveBtn) {

        saveBtn.disabled = !status;

    }

    if(status == true) {

        $(window).off(
            'beforeunload.AutomatorModalFormChanged'
        );

        $(window).on(
            'beforeunload.AutomatorModalFormChanged',
            function() {

                return 'Existem alterações não salvas.';

            }
        );

    } else {

        $(window).off(
            'beforeunload.AutomatorModalFormChanged'
        );

    }

    return true;

}



function AutomatorFormBuilderObserveChanges(
    modalEl = null
) {

    if(!modalEl) {
        return false;
    }

    $(document)
        .off(
            'input.AutomatorFormBuilder change.AutomatorFormBuilder',
            '#' + AutomatorFormBuilderGetModalId() + ' input, #' + AutomatorFormBuilderGetModalId() + ' textarea, #' + AutomatorFormBuilderGetModalId() + ' select'
        )
        .on(
            'input.AutomatorFormBuilder change.AutomatorFormBuilder',
            '#' + AutomatorFormBuilderGetModalId() + ' input, #' + AutomatorFormBuilderGetModalId() + ' textarea, #' + AutomatorFormBuilderGetModalId() + ' select',
            function() {

                AutomatorFormBuilderSetChangedState(
                    modalEl,
                    true
                );

            }
        );

    return true;

}



function AutomatorFormBuilderSerialize() {

    var modalEl = document.getElementById(
        AutomatorFormBuilderGetModalId()
    );

    if(!modalEl) {
        return {};
    }

    var response = {
        id: '',
        title: '',
        slug: '',
        fields: []
    };

    var idInput = modalEl.querySelector(
        'input[name="id"]'
    );

    var titleInput = modalEl.querySelector(
        'input[name="title"]'
    );

    var slugInput = modalEl.querySelector(
        'input[name="slug"]'
    );

    if(idInput) {
        response.id = idInput.value;
    }

    if(titleInput) {
        response.title = titleInput.value;
    }

    if(slugInput) {
        response.slug = slugInput.value;
    }

    modalEl.querySelectorAll(
        '.automator-form-builder-field-container'
    ).forEach(function(container) {

        var item = {};

        container.querySelectorAll(
            'input, select, textarea'
        ).forEach(function(input) {

            var fieldName =
                input.getAttribute('name');

            if(!fieldName) {
                return;
            }

            if(
                input.type == 'checkbox'
            ) {

                item[fieldName] =
                    input.checked;

            } else {

                item[fieldName] =
                    input.value;

            }

        });

        response.fields.push(item);

    });

    return response;

}


/*
|--------------------------------------------------------------------------
| FORM BUILDER - MODAL WINDOW
|--------------------------------------------------------------------------
*/

function AutomatorOpenFormBuilderWindow(
    formId = null,
    title = ''
) {

    AutomatorGetActionStatus(function(actionStatus) {

        if(
            actionStatus == true ||
            actionStatus == 'true'
        ) {

            AutomatorCreateAutoCloseToastAlert(
                'automator-action-running',
                'center',
                'middle',
                true,
                true,
                'Ação em andamento',
                'Já existe uma ação sendo executada no momento.',
                null,
                false,
                null,
                5000
            );

            return false;

        }

        AutomatorSetActionStatus(true, function() {

            AutomatorPageLoader('show', function() {

                var route =
                    window.AutomatorRoutes
                    .apiFormBuilder || '';

                if(formId != null) {

                    route = route.replace(
                        '#ID#',
                        formId
                    );

                } else {

                    route = route.replace(
                        '/#ID#',
                        ''
                    );

                    route = route.replace(
                        '#ID#',
                        ''
                    );

                }

                $.ajax({
                    url: route,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN':
                            $('meta[name="csrf-token"]')
                            .attr('content'),
                        'Accept':
                            'application/json'
                    },
                    dataType: 'json',

                    success: function(
                        response
                    ) {

                        if(
                            !response ||
                            response.status != true
                        ) {

                            AutomatorPageLoader(
                                'hide',
                                function() {

                                    AutomatorSetActionStatus(
                                        false
                                    );

                                }
                            );

                            AutomatorCreateAutoCloseToastAlert(
                                'automator-builder-error',
                                'center',
                                'middle',
                                true,
                                true,
                                response.title ||
                                'Erro',
                                response.message ||
                                'Não foi possível carregar o formulário.',
                                null,
                                false,
                                null,
                                5000
                            );

                            return false;

                        }

                        AutomatorFormBuilderCreateModal(
                            response
                        );

                    },

                    error: function(xhr) {

                        var message =
                            'Não foi possível carregar o formulário.';

                        if(
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {

                            message =
                                xhr.responseJSON
                                .message;

                        }

                        AutomatorPageLoader(
                            'hide',
                            function() {

                                AutomatorSetActionStatus(
                                    false
                                );

                            }
                        );

                        AutomatorCreateAutoCloseToastAlert(
                            'automator-builder-request-error',
                            'center',
                            'middle',
                            true,
                            true,
                            'Erro',
                            message,
                            null,
                            false,
                            null,
                            5000
                        );

                    }

                });

            });

        });

    });

    return false;

}



function AutomatorFormBuilderCreateModal(
    response = {}
) {

    AutomatorFormBuilderDestroyModal();

    var modalId =
        AutomatorFormBuilderGetModalId();

    var modalTitle =
        response.id
        ? 'Editar Formulário'
        : 'Novo Formulário';

    var html = `
    <div class="modal fade"
         id="${modalId}"
         tabindex="-1"
         data-bs-backdrop="static"
         data-bs-keyboard="false">

      <div class="modal-dialog modal-fullscreen">

        <div class="modal-content border-0 rounded-0">

          <div class="modal-header border-bottom py-3">

            <div class="container-fluid">

              <div class="row align-items-center g-2 d-none d-md-flex">

                <div class="col-md-4 text-start">

                  <button type="button"
                          class="btn btn-primary btn-open-add-builder-field">

                    <i class="fa fa-plus me-2"></i>
                    Adicionar novo campo

                  </button>

                </div>

                <div class="col-md-4 text-center">

                  <h4 class="m-0 fw-bold">
                    ${modalTitle}
                  </h4>

                </div>

                <div class="col-md-4 text-end">

                  <button type="button"
                          class="btn-close btn-form-builder-close"></button>

                </div>

              </div>

              <div class="d-flex d-md-none flex-column text-center position-relative">

                <button type="button"
                        class="btn-close position-absolute top-0 end-0 btn-form-builder-close">
                </button>

                <h5 class="fw-bold mb-3">
                  ${modalTitle}
                </h5>

                <div class="text-center">

                  <button type="button"
                          class="btn btn-primary btn-open-add-builder-field">

                    <i class="fa fa-plus me-2"></i>
                    Adicionar novo campo

                  </button>

                </div>

              </div>

            </div>

          </div>

          <div class="modal-body p-0 d-flex flex-column overflow-hidden">

            <form id="automator-form-builder-form"
                  class="d-flex flex-column h-100">

              <input type="hidden"
                     name="id"
                     value="${response.id || ''}">

              <div class="border-bottom bg-white p-3">

                <div class="container-fluid">

                  <div class="row">

                    <div class="col-12">

                      <input type="text"
                             class="form-control form-control-lg fw-bold"
                             name="title"
                             placeholder="Título do formulário"
                             value="${response.title_value || ''}">

                    </div>

                    <div class="col-12 mt-2">

                      <input type="text"
                             class="form-control"
                             name="slug"
                             placeholder="nome-amigavel-formulario"
                             value="${response.slug || ''}">

                    </div>

                  </div>

                </div>

              </div>

              <div class="flex-grow-1 overflow-auto p-3"
                   id="automator-form-builder-scroll-container">

                <div class="container-fluid">

                  <div class="row">

                    <div class="col-12">

                      ${response.html || ''}

                    </div>

                  </div>

                </div>

              </div>

            </form>

          </div>

          <div class="modal-footer">

            <button type="button"
                    class="btn btn-outline-secondary btn-form-builder-close">

              Cancelar

            </button>

            <button type="button"
                    disabled
                    class="btn btn-primary btn-automator-form-builder-save">

              Salvar alterações

            </button>

          </div>

        </div>

      </div>

    </div>`;

    $('body').append(html);

    var modalEl =
        document.getElementById(
            modalId
        );

    var modal =
        new bootstrap.Modal(
            modalEl
        );

    modal.show();

    AutomatorPageLoader(
        'hide',
        function() {

            AutomatorSetActionStatus(
                false
            );

        }
    );

    AutomatorFormBuilderObserveChanges(
        modalEl
    );

    AutomatorFormBuilderBindSlugBehavior(
        modalEl
    );

    $(document)
        .off(
            'click.AutomatorFormBuilderClose'
        )
        .on(
            'click.AutomatorFormBuilderClose',
            '.btn-form-builder-close',
            function() {

                var changed =
                    modalEl.getAttribute(
                        'data-automator-form-changed'
                    );

                if(
                    changed ==
                    'true'
                ) {

                    if(
                        confirm(
                            'Existem alterações não salvas. Deseja realmente sair?'
                        )
                    ) {

                        AutomatorFormBuilderDestroyModal();

                    }

                } else {

                    AutomatorFormBuilderDestroyModal();

                }

            }
        );

    return true;

}



function AutomatorFormBuilderBindSlugBehavior(
    modalEl = null
) {

    if(!modalEl) {
        return false;
    }

    var titleInput =
        modalEl.querySelector(
            'input[name="title"]'
        );

    var slugInput =
        modalEl.querySelector(
            'input[name="slug"]'
        );

    if(
        !titleInput ||
        !slugInput
    ) {
        return false;
    }

    $(titleInput)
        .off(
            'input.AutomatorSlug'
        )
        .on(
            'input.AutomatorSlug',
            function() {

                if(
                    String(
                        slugInput.value
                    ).trim() != ''
                ) {

                    return false;

                }

                slugInput.value =
                    AutomatorFormBuilderSlugify(
                        this.value
                    );

            }
        );

    return true;

}


/*
|--------------------------------------------------------------------------
| FORM BUILDER - ADD FIELD MODAL
|--------------------------------------------------------------------------
*/

function AutomatorFormBuilderOpenAddFieldModal() {

    AutomatorGetActionStatus(function(actionStatus) {

        if(
            actionStatus == true ||
            actionStatus == 'true'
        ) {

            AutomatorCreateAutoCloseToastAlert(
                'automator-action-running',
                'center',
                'middle',
                true,
                true,
                'Ação em andamento',
                'Já existe uma ação sendo executada no momento.',
                null,
                false,
                null,
                5000
            );

            return false;

        }

        AutomatorSetActionStatus(true, function() {

            AutomatorPageLoader('show', function() {

                $.ajax({
                    url: window.AutomatorRoutes.apiFormBuilderFields,
                    type: 'GET',
                    headers: {
                        'X-CSRF-TOKEN':
                            $('meta[name="csrf-token"]')
                            .attr('content'),
                        'Accept':
                            'application/json'
                    },
                    dataType: 'json',

                    success: function(response) {

                        if(
                            !response ||
                            response.status != true
                        ) {

                            AutomatorPageLoader(
                                'hide',
                                function() {

                                    AutomatorSetActionStatus(
                                        false
                                    );

                                }
                            );

                            AutomatorCreateAutoCloseToastAlert(
                                'automator-builder-fields-error',
                                'center',
                                'middle',
                                true,
                                true,
                                response.title ||
                                'Erro',
                                response.message ||
                                'Não foi possível carregar os campos.',
                                null,
                                false,
                                null,
                                5000
                            );

                            return false;

                        }

                        AutomatorFormBuilderCreateFieldModal(
                            response.data || response
                        );

                    },

                    error: function(xhr) {

                        var message =
                            'Não foi possível carregar os campos.';

                        if(
                            xhr.responseJSON &&
                            xhr.responseJSON.message
                        ) {

                            message =
                                xhr.responseJSON.message;

                        }

                        AutomatorPageLoader(
                            'hide',
                            function() {

                                AutomatorSetActionStatus(
                                    false
                                );

                            }
                        );

                        AutomatorCreateAutoCloseToastAlert(
                            'automator-builder-fields-request-error',
                            'center',
                            'middle',
                            true,
                            true,
                            'Erro',
                            message,
                            null,
                            false,
                            null,
                            5000
                        );

                    }

                });

            });

        });

    });

    return false;

}



function AutomatorFormBuilderCreateFieldModal(
    groups = []
) {

    $('#automator-form-builder-add-field-modal').remove();

    var tabs = '';
    var content = '';

    groups.forEach(function(group, index) {

        var tabId =
            'automator-builder-group-' +
            group.id;

        tabs += `
        <li class="nav-item">
            <button
                class="nav-link ${index == 0 ? 'active' : ''}"
                data-bs-toggle="tab"
                data-bs-target="#${tabId}"
                type="button">

                ${group.titulo || 'Grupo'}

            </button>
        </li>`;

        var fieldsHtml = '';

        (group.fields || []).forEach(function(field) {

            fieldsHtml += `
            <div class="col-md-6 col-xl-4 mb-3">

                <div class="card border automator-field-card h-100 cursor-pointer"
                     data-field='${JSON.stringify(field)}'>

                    <div class="card-body">

                        <div class="d-flex align-items-start">

                            <div class="me-3 fs-3">

                                <i class="fa fa-${field.icon || 'square'}"></i>

                            </div>

                            <div>

                                <h6 class="fw-bold mb-1">
                                    ${field.titulo || ''}
                                </h6>

                                <small class="text-muted">
                                    ${field.descricao || ''}
                                </small>

                            </div>

                        </div>

                    </div>

                </div>

            </div>`;
        });

        content += `
        <div class="tab-pane fade ${index == 0 ? 'show active' : ''}"
             id="${tabId}">

            <div class="row mt-3">

                ${fieldsHtml}

            </div>

        </div>`;
    });

    var html = `
    <div class="modal fade"
         id="automator-form-builder-add-field-modal"
         tabindex="-1"
         data-bs-backdrop="static"
         data-bs-keyboard="false">

        <div class="modal-dialog modal-lg modal-dialog-centered">

            <div class="modal-content">

                <div class="modal-header">

                    <h5 class="modal-title w-100 text-center fw-bold">
                        Adicionar novo campo
                    </h5>

                    <button type="button"
                            class="btn-close btn-close-builder-field-modal">
                    </button>

                </div>

                <div class="modal-body">

                    <div class="row">

                        <div class="col-lg-8">

                            <ul class="nav nav-tabs">

                                ${tabs}

                            </ul>

                            <div class="tab-content">

                                ${content}

                            </div>

                        </div>

                        <div class="col-lg-4 border-start">

                            <div class="sticky-top">

                                <h5 class="fw-bold selected-field-title">
                                    Nenhum campo selecionado
                                </h5>

                                <p class="text-muted selected-field-description">
                                    Selecione um campo para visualizar sua descrição.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>

                <div class="modal-footer justify-content-between">

                    <button type="button"
                            class="btn btn-outline-secondary btn-close-builder-field-modal">

                        Cancelar

                    </button>

                    <button type="button"
                            disabled
                            class="btn btn-primary btn-builder-add-selected-field">

                        Selecionar campo

                    </button>

                </div>

            </div>

        </div>

    </div>`;

    $('body').append(html);

    var modalEl =
        document.getElementById(
            'automator-form-builder-add-field-modal'
        );

    var modal =
        new bootstrap.Modal(
            modalEl
        );

    modal.show();

    AutomatorSetActionStatus(false);

    $(document)
        .off(
            'click.AutomatorBuilderSelectField'
        )
        .on(
            'click.AutomatorBuilderSelectField',
            '.automator-field-card',
            function() {

                $('.automator-field-card')
                    .removeClass(
                        'border-primary shadow'
                    );

                $(this)
                    .addClass(
                        'border-primary shadow'
                    );

                var field =
                    $(this)
                    .data('field');

                $('#automator-form-builder-add-field-modal')
                    .data(
                        'selected-field',
                        field
                    );

                $('.selected-field-title')
                    .text(
                        field.titulo || ''
                    );

                $('.selected-field-description')
                    .text(
                        field.descricao || ''
                    );

                $('.btn-builder-add-selected-field')
                    .prop(
                        'disabled',
                        false
                    );

            }
        );

    $(document)
        .off(
            'click.AutomatorBuilderCancelField'
        )
        .on(
            'click.AutomatorBuilderCancelField',
            '.btn-close-builder-field-modal',
            function() {

                AutomatorSetActionStatus(
                    true,
                    function() {

                        bootstrap.Modal
                            .getInstance(
                                modalEl
                            )
                            .hide();

                        $(modalEl)
                            .remove();

                        AutomatorPageLoader(
                            'hide',
                            function() {

                                AutomatorSetActionStatus(
                                    false
                                );

                            }
                        );

                    }
                );

            }
        );

    $(document)
        .off(
            'click.AutomatorBuilderCreateField'
        )
        .on(
            'click.AutomatorBuilderCreateField',
            '.btn-builder-add-selected-field',
            function() {

                var selectedField =
                    $('#automator-form-builder-add-field-modal')
                    .data(
                        'selected-field'
                    );

                if(
                    !selectedField
                ) {
                    return false;
                }

                AutomatorSetActionStatus(
                    true,
                    function() {

                        bootstrap.Modal
                            .getInstance(
                                modalEl
                            )
                            .hide();

                        $(modalEl)
                            .remove();

                        AutomatorFormBuilderAppendField(
                            selectedField
                        );

                    }
                );

            }
        );

    return true;

}



/*
|--------------------------------------------------------------------------
| FORM BUILDER - APPEND FIELD
|--------------------------------------------------------------------------
*/

function AutomatorFormBuilderAppendField(
    field = {}
) {

    var uniqueId =
        'builder-field-' +
        Date.now();

    var html = `
    <div class="col-12 mb-3 automator-form-builder-field-container"
         data-field-id="${field.id || ''}">

        <div class="accordion"
             id="${uniqueId}">

            <div class="accordion-item border rounded">

                <h2 class="accordion-header">

                    <button
                        class="accordion-button"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#${uniqueId}-collapse">

                        ${field.titulo || 'Campo'}

                    </button>

                </h2>

                <div id="${uniqueId}-collapse"
                     class="accordion-collapse collapse show">

                    <div class="accordion-body">

                        <input type="hidden"
                               name="field_id"
                               value="${field.id || ''}">

                        <input type="hidden"
                               name="field_type"
                               value="${field.name || ''}">

                        <div class="mb-3">

                            <label class="form-label">

                                Título do campo

                            </label>

                            <input type="text"
                                   class="form-control"
                                   name="title"
                                   placeholder="Digite o título do campo">

                        </div>

                    </div>

                </div>

            </div>

        </div>

    </div>`;

    var container =
        $(
            AutomatorFormBuilderGetFieldsContainerSelector()
        );

    container.append(
        html
    );

    var lastField =
        container.find(
            '.automator-form-builder-field-container:last'
        );

    var scrollContainer =
        $('#automator-form-builder-scroll-container');

    scrollContainer.animate(
        {
            scrollTop:
                scrollContainer.scrollTop() +
                lastField.position().top -
                10
        },
        300
    );

    AutomatorFormBuilderSetChangedState(
        document.getElementById(
            AutomatorFormBuilderGetModalId()
        ),
        true
    );

    AutomatorPageLoader(
        'hide',
        function() {

            AutomatorSetActionStatus(
                false
            );

        }
    );

}



/*
|--------------------------------------------------------------------------
| EVENTS
|--------------------------------------------------------------------------
*/

$(document)
    .off(
        'click.AutomatorOpenFieldModal'
    )
    .on(
        'click.AutomatorOpenFieldModal',
        '.btn-open-add-builder-field',
        function() {

            AutomatorFormBuilderOpenAddFieldModal();

        }
    );

/*
|--------------------------------------------------------------------------
| FORM BUILDER - SAVE / SUBMIT
|--------------------------------------------------------------------------
*/

function AutomatorFormBuilderSubmit() {

    var modalEl =
        document.getElementById(
            AutomatorFormBuilderGetModalId()
        );

    if(!modalEl) {
        return false;
    }

    AutomatorGetActionStatus(function(actionStatus) {

        if(
            actionStatus == true ||
            actionStatus == 'true'
        ) {

            AutomatorCreateAutoCloseToastAlert(
                'automator-builder-action-running',
                'center',
                'middle',
                true,
                true,
                'Ação em andamento',
                'Já existe uma ação sendo executada.',
                null,
                false,
                null,
                5000
            );

            return false;

        }

        AutomatorSetActionStatus(
            true,
            function() {

                AutomatorPageLoader(
                    'show',
                    function() {

                        var payload =
                            AutomatorFormBuilderSerialize();

                        payload.form_validate =
                            true;

                        AutomatorFormBuilderValidateAndSubmit(
                            payload
                        );

                    }
                );

            }
        );

    });

    return false;

}



/*
|--------------------------------------------------------------------------
| FORM BUILDER - SECURITY VALIDATION
|--------------------------------------------------------------------------
*/

function AutomatorFormBuilderValidateAndSubmit(
    payload = {}
) {

    var modalValidate =
        $('#automator-security-modal');

    /*
    |---------------------------------------------------------------
    | Reaproveita fluxo existente do painel
    |---------------------------------------------------------------
    |
    | Espera existir a função global de validação já criada
    | no painel-scripts.js
    |
    */

    if(
        typeof AutomatorOpenValidatePasswordModal
        !== 'function'
    ) {

        AutomatorFormBuilderPerformSubmit(
            payload
        );

        return true;

    }

    AutomatorOpenValidatePasswordModal(
        function(success, response) {

            if(success !== true) {

                AutomatorCreateAutoCloseToastAlert(
                    'automator-builder-password-error',
                    'center',
                    'middle',
                    true,
                    true,
                    response?.title ||
                    'Falha de validação',
                    response?.message ||
                    'Senha inválida.',
                    null,
                    false,
                    function() {

                        AutomatorPageLoader(
                            'hide',
                            function() {

                                AutomatorSetActionStatus(
                                    false
                                );

                                $('#automator-security-modal')
                                    .find(
                                        'input[type=password]'
                                    )
                                    .trigger(
                                        'focus'
                                    );

                            }
                        );

                    },
                    5000
                );

                return false;

            }

            $('#automator-security-modal')
                .modal('hide');

            AutomatorFormBuilderPerformSubmit(
                payload
            );

        }
    );

    return true;

}



/*
|--------------------------------------------------------------------------
| FORM BUILDER - AJAX SUBMIT
|--------------------------------------------------------------------------
*/

function AutomatorFormBuilderPerformSubmit(
    payload = {}
) {

    $.ajax({

        url:
            window.AutomatorRoutes
            .apiFormBuilderSave,

        type: 'POST',

        data: JSON.stringify(
            payload
        ),

        contentType:
            'application/json',

        headers: {

            'X-CSRF-TOKEN':
                $('meta[name="csrf-token"]')
                .attr('content'),

            'Accept':
                'application/json'

        },

        dataType: 'json',

        success: function(response) {

            var status =
                response?.status === true;

            AutomatorCreateAutoCloseToastAlert(
                'automator-builder-submit-toast',
                'center',
                'middle',
                true,
                true,
                response?.title ||
                (
                    status
                    ? 'Sucesso'
                    : 'Erro'
                ),
                response?.message ||
                (
                    status
                    ? 'Operação realizada com sucesso.'
                    : 'Não foi possível concluir a ação.'
                ),
                null,
                false,
                function() {

                    if(status === true) {

                        window.location.reload();

                        return true;

                    }

                    AutomatorPageLoader(
                        'hide',
                        function() {

                            AutomatorSetActionStatus(
                                false
                            );

                        }
                    );

                },
                5000
            );

        },

        error: function(xhr) {

            var message =
                'Não foi possível salvar o formulário.';

            if(
                xhr.responseJSON &&
                xhr.responseJSON.message
            ) {

                message =
                    xhr.responseJSON
                    .message;

            }

            AutomatorCreateAutoCloseToastAlert(
                'automator-builder-submit-error',
                'center',
                'middle',
                true,
                true,
                'Erro',
                message,
                null,
                false,
                function() {

                    AutomatorPageLoader(
                        'hide',
                        function() {

                            AutomatorSetActionStatus(
                                false
                            );

                        }
                    );

                },
                5000
            );

        }

    });

}



/*
|--------------------------------------------------------------------------
| EVENTS - SAVE BUTTON
|--------------------------------------------------------------------------
*/

$(document)
    .off(
        'click.AutomatorFormBuilderSave'
    )
    .on(
        'click.AutomatorFormBuilderSave',
        '.btn-automator-form-builder-save',
        function(e) {

            e.preventDefault();

            AutomatorFormBuilderSubmit();

            return false;

        }
    );



/*
|--------------------------------------------------------------------------
| CLEANUP
|--------------------------------------------------------------------------
*/

$(document)
    .off(
        'hidden.bs.modal.AutomatorBuilderCleanup'
    )
    .on(
        'hidden.bs.modal.AutomatorBuilderCleanup',
        '#' + AutomatorFormBuilderGetModalId(),
        function() {

            $(window).off(
                'beforeunload.AutomatorModalFormChanged'
            );

            $(document).off(
                '.AutomatorFormBuilder'
            );

        }
    );



    

/*
|--------------------------------------------------------------------------
| AutomatorCreateViewModal
|--------------------------------------------------------------------------
|
| Abre um modal Bootstrap cujo title, content e footer são carregados
| dinamicamente via POST para window.AutomatorRoutes.apiView.
|
| Após receber a resposta da API, opcionalmente faz um segundo request
| (GET) para buscar dados de um registro e preencher os campos do
| formulário que possa estar presente no content.
|
| Assinatura:
|   AutomatorCreateViewModal(payload, options)
|
| @param {object} payload
|   Dados enviados no POST para window.AutomatorRoutes.apiView.
|   Exemplo: { view: 'admin-routes-apis-access', route_id: 5 }
|
| @param {object} options
|   Configurações opcionais do modal e do callback de dados:
|
|   acao       {string}   Chave em AutomatorPaginationRoutes para o
|                          segundo request de dados (GET). Requer "id".
|
|   id         {mixed}    ID substituído em '#ID#' na URL da ação acima.
|
|   size       {string}   Tamanho do dialog Bootstrap:
|                          'sm'  → modal-sm
|                          'md'  → (sem classe extra, padrão Bootstrap)
|                          'lg'  → modal-lg          ← default
|                          'xl'  → modal-xl
|                          'fullscreen'              → modal-fullscreen
|                          'fullscreen-sm-down'      → modal-fullscreen-sm-down
|                          'fullscreen-md-down'      → modal-fullscreen-md-down
|                          'fullscreen-lg-down'      → modal-fullscreen-lg-down
|                          'fullscreen-xl-down'      → modal-fullscreen-xl-down
|                          'fullscreen-xxl-down'     → modal-fullscreen-xxl-down
|
|   centered   {boolean}  Centraliza verticalmente. Default: true.
|
|   scrollable {boolean}  Habilita scroll interno. Default: true.
|
|   backdrop   {mixed}    'static' | true | false. Default: 'static'.
|
|   keyboard   {boolean}  Fecha com ESC. Default: false.
|
|   callback   {function} Chamado após shown.bs.modal com a assinatura:
|                          (response, modalEl, modal, recordData)
|
| O servidor deve retornar no POST para apiView:
|   {
|     "status"  : true,
|     "title"   : "Título do modal",           // string
|     "content" : "<div>...</div>",            // HTML do corpo
|     "footer"  : "<div>...</div>"             // HTML do footer (opcional)
|   }
|
| Se "footer" não vier (ou vier nulo/vazio), o modal-footer não é
| renderizado. O botão X no header sempre existe e é a forma de fechar.
|
*/
function AutomatorCreateViewModal(payload, options) {

  payload = (
    payload &&
    typeof payload === 'object'
  )
    ? payload
    : {};

  options = (
    options &&
    typeof options === 'object'
  )
    ? options
    : {};

  var acao        = options.acao || null;
  var id          = options.id || null;
  var pageID      = options.pageID || payload.pageID || id || null;

  var editorAction =
    options.editorAction ||
    payload.editorAction ||
    (
      pageID
        ? 'update'
        : 'store'
    );

  var size        = options.size || 'lg';

  var centered    =
    options.centered !== undefined
      ? options.centered
      : true;

  var scrollable  =
    options.scrollable !== undefined
      ? options.scrollable
      : true;

  var backdrop    =
    options.backdrop !== undefined
      ? options.backdrop
      : 'static';

  var keyboard    =
    options.keyboard !== undefined
      ? options.keyboard
      : false;

  var callback =
    typeof options.callback === 'function'
      ? options.callback
      : null;

  var beforeShow =
    typeof options.beforeShow === 'function'
      ? options.beforeShow
      : null;

  var afterHideOn =
    typeof options.afterHideOn === 'function'
      ? options.afterHideOn
      : null;

  var keepLoaderUntilCallback =
    options.keepLoaderUntilCallback === true;


  /*
  |--------------------------------------------------------------------------
  | Resolve a classe de tamanho do modal-dialog
  |--------------------------------------------------------------------------
  */

  function _resolveSizeClass(sizeValue) {

    var sizeMap = {
      'sm'               : 'modal-sm',
      'md'               : '',
      'lg'               : 'modal-lg',
      'xl'               : 'modal-xl',
      'fullscreen'       : 'modal-fullscreen',
      'fullscreen-sm-down'  : 'modal-fullscreen-sm-down',
      'fullscreen-md-down'  : 'modal-fullscreen-md-down',
      'fullscreen-lg-down'  : 'modal-fullscreen-lg-down',
      'fullscreen-xl-down'  : 'modal-fullscreen-xl-down',
      'fullscreen-xxl-down' : 'modal-fullscreen-xxl-down'
    };

    return (sizeValue && sizeMap[sizeValue] !== undefined) ? sizeMap[sizeValue] : 'modal-lg';

  }


  /*
  |--------------------------------------------------------------------------
  | Helpers internos
  |--------------------------------------------------------------------------
  */

  function _showError(message) {

    AutomatorPageLoader('hide', function() {

      AutomatorCreateToastAlert(
        'automator-view-modal-error',
        'center',
        'middle',
        true,
        true,
        'Erro',
        message || 'Solicitação inválida!',
        null,
        true,
        function() {
          AutomatorSetActionStatus(false);
        }
      );

    });

  }

  function _getErrorMessage(xhr, defaultMessage) {

    defaultMessage = defaultMessage || 'Solicitação inválida!';

    if(xhr && xhr.responseJSON && xhr.responseJSON.message) {
      return xhr.responseJSON.message;
    }

    if(xhr && xhr.responseText) {
      return xhr.responseText;
    }

    return defaultMessage;

  }

  function _getCSRFToken() {
    return AutomatorGetCSRFToken();
  }


  /*
  |--------------------------------------------------------------------------
  | Destrói o modal
  |--------------------------------------------------------------------------
  */

  // function _destroyModal(modalEl, resetActionStatus, callbackDestroy) {

  //   if(resetActionStatus === undefined) {
  //     resetActionStatus = true;
  //   }

  //   if(!modalEl) {

  //     if(resetActionStatus) {
  //       AutomatorSetActionStatus(false);
  //     }

  //     if(typeof callbackDestroy === 'function') {
  //       callbackDestroy();
  //     }

  //     return false;

  //   }

  //   var formEl = modalEl.querySelector('form');

  //   if(formEl && formEl.getAttribute('data-automator-form-changed') == 'true') {

  //     var confirmClose = confirm('Existem alterações não salvas. Deseja realmente fechar este formulário?');

  //     if(confirmClose == false) {
  //       return false;
  //     }

  //   }

  //   var modalInstance = bootstrap.Modal.getInstance(modalEl);

  //   modalEl.addEventListener('hidden.bs.modal', function() {

  //     if(modalInstance) {
  //       modalInstance.dispose();
  //     }

  //     modalEl.remove();

  //     if(
  //       window.AutomatorPaginationCurrentModalView &&
  //       window.AutomatorPaginationCurrentModalView.modalEl &&
  //       window.AutomatorPaginationCurrentModalView.modalEl.id == modalEl.id
  //     ) {
  //       window.AutomatorPaginationCurrentModalView = null;
  //     }

  //     if(document.querySelectorAll('.modal.show').length <= 0) {

  //       document.body.classList.remove('modal-open');

  //       document.querySelectorAll('.modal-backdrop').forEach(function(backdrop) {
  //         backdrop.remove();
  //       });

  //     }

  //     $(window).off('beforeunload.AutomatorModalViewChanged');

  //     if(resetActionStatus) {
  //       AutomatorSetActionStatus(false);
  //     }

  //     if(typeof callbackDestroy === 'function') {
  //       callbackDestroy();
  //     }

  //   }, { once: true });

  //   if(modalInstance) {
  //     modalInstance.hide();
  //   } else {

  //     modalEl.remove();

  //     $(window).off('beforeunload.AutomatorModalViewChanged');

  //     if(resetActionStatus) {
  //       AutomatorSetActionStatus(false);
  //     }

  //   }

  //   return true;

  // }

  function _destroyModal(modalEl, resetActionStatus, callbackDestroy) {

    if(resetActionStatus === undefined) {
      resetActionStatus = true;
    }

    if(!modalEl) {

      if(resetActionStatus) {
        AutomatorSetActionStatus(false);
      }

      if(typeof callbackDestroy === 'function') {
        callbackDestroy();
      }

      return false;

    }

    var formEl = modalEl.querySelector('form');
    var discardConfirmed = false;

    if(formEl && formEl.getAttribute('data-automator-form-changed') == 'true') {

      var confirmClose = confirm('Existem alterações não salvas. Deseja realmente fechar este formulário?');

      if(confirmClose == false) {
        return false;
      }

      discardConfirmed = true;

      formEl.setAttribute('data-automator-form-changed', 'false');

      if(typeof AutomatorFormSerializeCurrentState === 'function') {
        formEl.setAttribute('data-automator-initial-state', AutomatorFormSerializeCurrentState(formEl));
      }

      $(window).off('beforeunload.AutomatorModalFormChanged');
      $(window).off('beforeunload.AutomatorModalViewChanged');

      if(
        window.SysAutomatorEditor &&
        typeof window.SysAutomatorEditor.discardEditorUnsavedChanges === 'function'
      ) {
        window.SysAutomatorEditor.discardEditorUnsavedChanges();
      }

    }

    var modalInstance = bootstrap.Modal.getInstance(modalEl);

    modalEl.addEventListener('hidden.bs.modal', function() {

      if(modalInstance) {
        modalInstance.dispose();
      }

      modalEl.remove();

      if(
        window.AutomatorPaginationCurrentModalView &&
        window.AutomatorPaginationCurrentModalView.modalEl &&
        window.AutomatorPaginationCurrentModalView.modalEl.id == modalEl.id
      ) {
        window.AutomatorPaginationCurrentModalView = null;
      }

      if(document.querySelectorAll('.modal.show').length <= 0) {

        document.body.classList.remove('modal-open');

        document.querySelectorAll('.modal-backdrop').forEach(function(backdrop) {
          backdrop.remove();
        });

      }

      if(discardConfirmed === true) {
        $(window).off('beforeunload.AutomatorModalFormChanged');
        $(window).off('beforeunload.AutomatorModalViewChanged');
      }

      if(resetActionStatus) {
        AutomatorSetActionStatus(false);
      }

      if(typeof callbackDestroy === 'function') {
        callbackDestroy();
      }

    }, { once: true });

    if(modalInstance) {
      modalInstance.hide();
    } else {

      modalEl.remove();

      if(discardConfirmed === true) {
        $(window).off('beforeunload.AutomatorModalFormChanged');
        $(window).off('beforeunload.AutomatorModalViewChanged');
      }

      if(resetActionStatus) {
        AutomatorSetActionStatus(false);
      }

    }

    return true;

  }


  /*
  |--------------------------------------------------------------------------
  | Preenche campos do formulário interno
  |--------------------------------------------------------------------------
  */

  function _populateFields(
    modalEl,
    data
  ) {

    if(
      !modalEl ||
      !data ||
      typeof data !== 'object'
    ) {

      return false;

    }


    /*
    |--------------------------------------------------------------------------
    | Normaliza valores de campos múltiplos
    |--------------------------------------------------------------------------
    */

    function _normalizeValues(
      value
    ) {

      var values = [];


      if(
        value === null ||
        value === undefined ||
        value === ''
      ) {

        return values;

      }


      if(Array.isArray(value)) {

        values = value;

      } else if(typeof value === 'object') {

        values = Object.keys(value);

      } else if(typeof value === 'string') {


        try {


          var decoded = JSON.parse(

            value

          );


          if(Array.isArray(decoded)) {

            values = decoded;

          } else if(
            decoded !== null &&
            typeof decoded === 'object'
          ) {

            values = Object.keys(

              decoded

            );

          } else {

            values = value.split(',');

          }


        } catch(error) {


          values = value.split(',');


        }


      } else {

        values = [value];

      }


      return values.map(function(item) {

        return String(item).trim();

      });

    }


    /*
    |--------------------------------------------------------------------------
    | Percorre todos os valores retornados pelo request
    |--------------------------------------------------------------------------
    */

    Object.keys(data).forEach(function(fieldName) {


      var value = data[fieldName];


      var fields = modalEl.querySelectorAll(

        '[name="' + fieldName + '"], ' +

        '[name="' + fieldName + '[]"], ' +

        '[data-automator-field-name="' + fieldName + '"]'

      );


      fields.forEach(function(field) {


        var tagName = field.tagName.toLowerCase();

        var type = String(

          field.getAttribute('type') || ''

        ).toLowerCase();


        /*
        |--------------------------------------------------------------------------
        | ICON PICKER
        |--------------------------------------------------------------------------
        |
        | O valor não deve permanecer no campo text.
        |
        | AutomatorIconPickerSetValue transfere o valor para o hidden, limpa o
        | campo visível e atualiza o ícone exibido à esquerda.
        |
        */

        if(
          field.classList.contains(
            'automator-input-icon-picker'
          )
        ) {


          if(
            typeof window.AutomatorIconPickerInitialize ===
            'function'
          ) {


            window.AutomatorIconPickerInitialize(

              field

            );


          }


          if(
            typeof window.AutomatorIconPickerSetValue ===
            'function'
          ) {


            window.AutomatorIconPickerSetValue(

              field,

              value !== null &&
              value !== undefined

                ? String(value)

                : '',

              false

            );


          } else {


            /*
            |--------------------------------------------------------------------------
            | Fallback para carregamento fora de ordem
            |--------------------------------------------------------------------------
            */

            field.value =

              value !== null &&
              value !== undefined

                ? String(value)

                : '';


          }


          return;

        }


        /*
        |--------------------------------------------------------------------------
        | Hidden criado pelo icon-picker
        |--------------------------------------------------------------------------
        */

        if(
          type === 'hidden' &&
          field.classList.contains(
            'automator-input-icon-picker-value'
          )
        ) {


          field.value =

            value !== null &&
            value !== undefined

              ? String(value)

              : '';


          return;

        }


        /*
        |--------------------------------------------------------------------------
        | Checkbox
        |--------------------------------------------------------------------------
        */

        if(type === 'checkbox') {


          var checkboxValues =

            _normalizeValues(

              value

            );


          field.checked =

            checkboxValues.length > 0

              ? checkboxValues.includes(
                  String(field.value)
                )

              : false;


        /*
        |--------------------------------------------------------------------------
        | Radio
        |--------------------------------------------------------------------------
        */

        } else if(type === 'radio') {


          field.checked = (

            String(field.value) ===
            String(value)

          );


        /*
        |--------------------------------------------------------------------------
        | Select múltiplo
        |--------------------------------------------------------------------------
        */

        } else if(
          tagName === 'select' &&
          field.multiple
        ) {


          var selectedValues =

            _normalizeValues(

              value

            );


          Array.from(field.options).forEach(function(option) {


            option.selected = selectedValues.includes(

              String(option.value)

            );


          });


        /*
        |--------------------------------------------------------------------------
        | Editor
        |--------------------------------------------------------------------------
        */

        } else if(
          tagName === 'textarea' &&
          field.classList.contains(
            'automator-editor'
          )
        ) {


          var editorContent =

            value !== null &&
            value !== undefined

              ? String(value)

              : '';


          field.value = editorContent;


          var editorId =

            field.getAttribute(
              'data-automator-editor-id'
            ) ||

            field.getAttribute('id') ||

            '';


          if(
            editorId &&
            window.AutomatorEditors &&
            window.AutomatorEditors[editorId]
          ) {


            var editorInstance =

              window.AutomatorEditors[editorId];


            if(
              editorInstance.visual &&
              editorInstance.visual.length
            ) {


              editorInstance.visual.html(

                editorContent

              );


            }


            if(
              editorInstance.code &&
              editorInstance.code.length
            ) {


              editorInstance.code.val(

                editorContent

              );


            }


          }


        /*
        |--------------------------------------------------------------------------
        | Campos comuns
        |--------------------------------------------------------------------------
        */

        } else {


          field.value =

            value !== null &&
            value !== undefined

              ? value

              : '';


        }


        /*
        |--------------------------------------------------------------------------
        | Dispara alteração somente para campos comuns
        |--------------------------------------------------------------------------
        */

        field.dispatchEvent(

          new Event(
            'change',
            {
              bubbles: true
            }
          )

        );


      });


    });


    /*
    |--------------------------------------------------------------------------
    | Inicializa novamente os icon-pickers do modal
    |--------------------------------------------------------------------------
    */

    if(
      typeof window.AutomatorIconPickerInitializeAll ===
      'function'
    ) {


      window.AutomatorIconPickerInitializeAll(

        modalEl

      );


    }


    return true;

  }
  
  // function _populateFields(modalEl, data) {

  //   if(!modalEl || !data || typeof data !== 'object') {
  //     return false;
  //   }

  //   function _normalizeValues(value) {

  //     var values = [];

  //     if(value === null || value === undefined || value === '') {
  //       return values;
  //     }

  //     if(Array.isArray(value)) {
  //       values = value;
  //     } else if(typeof value === 'object') {
  //       values = Object.keys(value);
  //     } else if(typeof value === 'string') {

  //       try {

  //         var decoded = JSON.parse(value);

  //         if(Array.isArray(decoded)) {
  //           values = decoded;
  //         } else if(decoded !== null && typeof decoded === 'object') {
  //           values = Object.keys(decoded);
  //         } else {
  //           values = value.split(',');
  //         }

  //       } catch(e) {
  //         values = value.split(',');
  //       }

  //     } else {
  //       values = [value];
  //     }

  //     return values.map(function(item) {
  //       return String(item).trim();
  //     });

  //   }

  //   Object.keys(data).forEach(function(fieldName) {

  //     var value  = data[fieldName];
  //     var fields = modalEl.querySelectorAll(
  //       '[name="' + fieldName + '"], [name="' + fieldName + '[]"], [data-automator-field-name="' + fieldName + '"]'
  //     );

  //     fields.forEach(function(field) {

  //       var tagName = field.tagName.toLowerCase();
  //       var type    = (field.getAttribute('type') || '').toLowerCase();

  //       if(type == 'checkbox') {

  //         var checkboxValues = _normalizeValues(value);

  //         field.checked = (checkboxValues.length > 0)
  //           ? checkboxValues.includes(String(field.value))
  //           : false;

  //       } else if(type == 'radio') {

  //         field.checked = (String(field.value) == String(value));

  //       } else if(tagName == 'select' && field.multiple) {

  //         var selectedValues = _normalizeValues(value);

  //         Array.from(field.options).forEach(function(option) {
  //           option.selected = selectedValues.includes(String(option.value));
  //         });

  //       } else if(tagName == 'textarea' && field.classList.contains('automator-editor')) {

  //         var editorContent = (value !== null && value !== undefined) ? String(value) : '';

  //         field.value = editorContent;

  //         var editorId = field.getAttribute('data-automator-editor-id') || field.getAttribute('id') || '';

  //         if(editorId && window.AutomatorEditors && window.AutomatorEditors[editorId]) {

  //           var editorInstance = window.AutomatorEditors[editorId];

  //           if(editorInstance.visual && editorInstance.visual.length) {
  //             editorInstance.visual.html(editorContent);
  //           }

  //           if(editorInstance.code && editorInstance.code.length) {
  //             editorInstance.code.val(editorContent);
  //           }

  //         }

  //       } else {

  //         field.value = (value !== null && value !== undefined) ? value : '';

  //       }

  //       field.dispatchEvent(new Event('change', { bubbles: true }));

  //     });

  //   });

  //   return true;

  // }


  /*
  |--------------------------------------------------------------------------
  | Monta e exibe o modal
  |--------------------------------------------------------------------------
  */

  function _createModal(response, recordData) {

    var modalID = 'automator-view-modal-' + Date.now() + '-' + Math.floor(Math.random() * 999999);

    var modalTitle   = response.title   || '';
    var modalContent = response.content || '';
    var modalClasses = response.classes || [];

    /*
    | footer — renderiza apenas quando a API retornar um valor não-vazio.
    | O botão X no header sempre existe e garante o fechamento do modal.
    */

    var hasFooter   = (response.footer !== undefined && response.footer !== null && String(response.footer).trim() !== '');
    var modalFooter = hasFooter ? response.footer : null;

    /*
    | Monta as classes do modal-dialog com base nas opções recebidas.
    */

    var dialogClasses = 'modal-dialog';

    var sizeClass = _resolveSizeClass(size);

    if(sizeClass !== '') {
      dialogClasses += ' ' + sizeClass;
    }

    if(centered) {
      dialogClasses += ' modal-dialog-centered';
    }

    if(scrollable) {
      dialogClasses += ' modal-dialog-scrollable';
    }

    /*
    | data-bs-backdrop aceita 'static', 'true' ou 'false'.
    | Converte boolean para string para o atributo HTML.
    */

    var backdropAttr = (backdrop === true)  ? 'true'   :
                       (backdrop === false) ? 'false'  :
                       'static';

    var keyboardAttr = keyboard ? 'true' : 'false';

    var modalHTML = '';

    modalHTML += '<div class="modal fade automator-view-modal" id="' + modalID + '" tabindex="-1" aria-hidden="true" data-bs-backdrop="' + backdropAttr + '" data-bs-keyboard="' + keyboardAttr + '">';
      modalHTML += '<div class="' + dialogClasses + '">';
        modalHTML += '<div class="modal-content">';

          /*
          | Header — título centralizado + botão X fixo à direita.
          | O X sempre existe independente de qualquer configuração.
          */

          modalHTML += '<div class="modal-header">';
            modalHTML += '<h5 class="modal-title w-100 text-center">' + modalTitle + '</h5>';
            modalHTML += '<button type="button" class="btn-close js-automator-view-modal-close" aria-label="Fechar"></button>';
          modalHTML += '</div>';

          /*
          | Body — HTML completo vindo da API.
          | Pode conter um <form> que será interceptado abaixo.
          */

          modalHTML += '<div class="modal-body ' + modalClasses['modal-body'] + '">';
            modalHTML += modalContent;
          modalHTML += '</div>';

          /*
          | Footer — renderizado apenas quando a API retornar conteúdo.
          */

          if(hasFooter) {
            modalHTML += '<div class="modal-footer">';
              modalHTML += modalFooter;
            modalHTML += '</div>';
          }

        modalHTML += '</div>';
      modalHTML += '</div>';
    modalHTML += '</div>';

    document.body.insertAdjacentHTML('beforeend', modalHTML);

    var modalEl = document.getElementById(modalID);
    var formEl  = modalEl.querySelector('form') || null;

    var modal = new bootstrap.Modal(modalEl, {
      backdrop: backdrop,
      keyboard: keyboard,
      focus   : true
    });

    /*
    | Fecha ao clicar no X do header ou em qualquer elemento
    | com a classe js-automator-view-modal-close que o footer possa ter.
    */

    modalEl.querySelectorAll('.js-automator-view-modal-close').forEach(function(btn) {

      btn.addEventListener('click', function(e) {

        e.preventDefault();

        _destroyModal(modalEl, true);

      });

    });

    /*
    | Se o content trouxer um <form>, intercepta o submit via AJAX
    | da mesma forma que AutomatorPaginationCreateModalForm faz.
    */

    if(formEl) {

      formEl.addEventListener('submit', function(e) {

        if(formEl.getAttribute('data-submit') == 'true') {
          return true;
        }

        e.preventDefault();

        if(!AutomatorFormHasChanged(formEl)) {
          return false;
        }

        AutomatorSystemFormSubmitAjax(formEl, null, {
          startedActionStatus: false,
          keepLoaderVisible  : true,
          reloadOnSuccess    : true
        });

        return false;

      });

    }

    /*
    | shown.bs.modal — populate → editors → callback → tooltips → observer
    | Mesma ordem garantida pela função original.
    */

    modalEl.addEventListener('shown.bs.modal', function() {

      if(recordData && typeof recordData === 'object' && Object.keys(recordData).length > 0) {
        _populateFields(modalEl, recordData);
      }

      AutomatorEditorAutoRender(modalEl);

      if(typeof callback === 'function') {

        window.AutomatorPaginationCurrentModalView = {
          modalID   : modalID,
          formID    : formEl ? (formEl.id || modalID + '-form') : null,
          modalEl   : modalEl,
          formEl    : formEl,
          modal     : modal,
          response  : response,
          recordData: recordData
        };

        callback(response, modalEl, modal, recordData);

      }

      AutomatorInitBootstrapTooltips(modalEl);

      setTimeout(function() {

        AutomatorInitBootstrapTooltips(modalEl);

        if(formEl) {
          AutomatorInitModalFormChangeObserver(
            modalEl,
            formEl,
            modalEl.querySelector('[type="submit"]')
          );
        }

        AutomatorSetActionStatus(false);

      }, 100);

    }, { once: true });


    modalEl.addEventListener('hidden.bs.modal', function() {

      if(typeof afterHideOn === 'function') {

        afterHideOn(
          response,
          modalEl,
          modal,
          recordData
        );

      }

    }, { once: true });


    if(typeof beforeShow === 'function') {

      beforeShow(
        response,
        modalEl,
        modal,
        recordData
      );

    }

    modal.show();

    return {

      id      : modalID,
      element : modalEl,
      modal   : modal,
      response: response,
      data    : recordData
    };

  }


  /*
  |--------------------------------------------------------------------------
  | Segundo request — busca dados do registro para preencher o formulário
  |--------------------------------------------------------------------------
  */

  function _fetchRecordData(response) {

    var hasAction = (acao !== null && acao !== undefined && acao !== '');
    var hasID     = (id   !== null && id   !== undefined && id   !== '');

    // if(!hasAction || !hasID) {

    //   AutomatorPageLoader('hide', function() {
    //     _createModal(response, {});
    //   });

    //   return;

    // }

    if(!hasAction || !hasID) {

      if(keepLoaderUntilCallback) {

        _createModal(response, {});

      } else {

        AutomatorPageLoader('hide', function() {
          _createModal(response, {});
        });

      }

      return;

    }

    if(typeof window.AutomatorPaginationRoutes === 'undefined' || !window.AutomatorPaginationRoutes[acao]) {

      _showError('A rota da ação "' + acao + '" não foi encontrada.');

      return;

    }

    var actionURL = window.AutomatorPaginationRoutes[acao];

    actionURL = actionURL.replace('#ID#', id);

    $.ajax({
      url     : actionURL,
      type    : 'GET',
      headers : { 'X-CSRF-TOKEN': _getCSRFToken() },
      dataType: 'json',
      success : function(recordResponse) {

        if(recordResponse.status == true) {

          var recordData = {};

          if(recordResponse.data && typeof recordResponse.data === 'object') {
            recordData = recordResponse.data;
          } else if(recordResponse.item && typeof recordResponse.item === 'object') {
            recordData = recordResponse.item;
          } else if(recordResponse.values && typeof recordResponse.values === 'object') {
            recordData = recordResponse.values;
          }

          if(keepLoaderUntilCallback) {

            _createModal(response, recordData);

          } else {

            AutomatorPageLoader('hide', function() {
              _createModal(response, recordData);
            });

          }
          // AutomatorPageLoader('hide', function() {
          //   _createModal(response, recordData);
          // });

        } else {

          _showError(recordResponse.message || 'Solicitação inválida!');

        }

      },
      error: function(xhr) {
        _showError(_getErrorMessage(xhr));
      }
    });

  }


  /*
  |--------------------------------------------------------------------------
  | Ponto de entrada
  |--------------------------------------------------------------------------
  */

  AutomatorGetActionStatus(function() {

    AutomatorSetActionStatus(true, function() {

      AutomatorPageLoader('show', function() {

        if(typeof bootstrap === 'undefined' || typeof bootstrap.Modal === 'undefined') {

          _showError('Bootstrap Modal não foi encontrado.');

          return;

        }

        if(typeof window.AutomatorRoutes === 'undefined' || !window.AutomatorRoutes.apiView) {

          _showError('A rota de visualização (apiView) não foi encontrada.');

          return;

        }

        var postData = (payload && typeof payload === 'object') ? payload : {};

        $.ajax({
          url     : window.AutomatorRoutes.apiView,
          type    : 'POST',
          headers : {
            'X-CSRF-TOKEN': _getCSRFToken(),
            'Accept'      : 'application/json'
          },
          data    : postData,
          dataType: 'json',
          success : function(response) {

            if(response.status == true) {

              response.editorAction = editorAction;
              response.acao = editorAction;
              response.pageID = pageID || '';
              response.modalRequestAction = acao || '';

              _fetchRecordData(response);

            } else {

              _showError(response.message || 'Solicitação inválida!');

            }

          },
          error: function(xhr) {
            _showError(_getErrorMessage(xhr));
          }
        });

      });

    });

  });

}


window.wp_fn = window.wp_fn || {
  activeBlock: null,

  toggleSidebar: function(side) {
      const el = document.getElementById('wp_sidebar_' + side);
      if(el) el.classList.toggle('collapsed');
  },

  addBlock: function(type) {
      const container = document.getElementById('wp_canvas_container');
      const wrapper = document.createElement('div');
      wrapper.className = 'wp-block';
      wrapper.dataset.type = type;

      const toolbar = document.createElement('div');
      toolbar.className = 'wp-toolbar';
      toolbar.innerHTML = `
          <button type="button" onclick="wp_fn.format('bold')" class="btn btn-sm btn-light border p-1 px-2"><i class="fas fa-bold"></i></button>
          <button type="button" onclick="wp_fn.format('italic')" class="btn btn-sm btn-light border p-1 px-2"><i class="fas fa-italic"></i></button>
          <div class="vr mx-1"></div>
          <button type="button" onclick="wp_fn.deleteBlock(this)" class="btn btn-sm btn-light border p-1 px-2 text-danger"><i class="fas fa-trash-alt"></i></button>
      `;

      let html = '';
      switch(type) {
          case 'paragraph': html = `<div contenteditable="true" class="wp-empty fs-5" data-placeholder="Comece a escrever..."></div>`; break;
          case 'heading': html = `<h2 contenteditable="true" class="wp-empty fw-bold" data-placeholder="Título"></h2>`; break;
          case 'image': html = `<div class="bg-light p-4 text-center border rounded small text-muted"><i class="fas fa-image fa-2x d-block mb-2"></i>Enviar Imagem</div>`; break;
          case 'list': html = `<ul contenteditable="true"><li>Item da lista</li></ul>`; break;
          case 'quote': html = `<blockquote contenteditable="true" class="border-start border-4 border-dark ps-3 fst-italic">Citação</blockquote>`; break;
      }

      wrapper.innerHTML = html;
      wrapper.prepend(toolbar);

      wrapper.onclick = (e) => {
          e.stopPropagation();
          wp_fn.selectBlock(wrapper);
      };

      container.appendChild(wrapper);
      wp_fn.selectBlock(wrapper);
      
      const editable = wrapper.querySelector('[contenteditable="true"]');
      if(editable) editable.focus();
  },

  selectBlock: function(block) {
      if (this.activeBlock) this.activeBlock.classList.remove('is-active');
      this.activeBlock = block;
      this.activeBlock.classList.add('is-active');
      this.renderSettings(block.dataset.type);
  },

  deleteBlock: function(btn) {
      btn.closest('.wp-block').remove();
      document.getElementById('wp_settings_area').innerHTML = '<div class="text-center py-5 text-muted small">Bloco removido</div>';
      this.activeBlock = null;
  },

  format: function(cmd) {
      document.execCommand(cmd, false, null);
  },

  renderSettings: function(type) {
      const area = document.getElementById('wp_settings_area');
      area.innerHTML = `
          <div class="mb-4">
              <label class="form-label small fw-bold">Cor do Texto</label>
              <div class="d-flex gap-2">
                  <button type="button" onclick="wp_fn.applyStyle('color', '#000')" class="btn btn-sm border-0 rounded-circle" style="background:#000; width:22px; height:22px"></button>
                  <button type="button" onclick="wp_fn.applyStyle('color', '#dc3545')" class="btn btn-sm border-0 rounded-circle" style="background:#dc3545; width:22px; height:22px"></button>
                  <button type="button" onclick="wp_fn.applyStyle('color', '#0d6efd')" class="btn btn-sm border-0 rounded-circle" style="background:#0d6efd; width:22px; height:22px"></button>
                  <input type="color" onchange="wp_fn.applyStyle('color', this.value)" class="form-control form-control-color p-0 border-0" style="width:22px; height:22px">
              </div>
          </div>
          <div class="mb-4">
              <label class="form-label small fw-bold">Cor de Fundo</label>
              <div class="d-flex gap-2">
                  <button type="button" onclick="wp_fn.applyStyle('backgroundColor', 'transparent')" class="btn btn-sm border bg-white rounded-circle d-flex align-items-center justify-content-center" style="width:22px; height:22px"><i class="fas fa-times text-danger" style="font-size:10px"></i></button>
                  <button type="button" onclick="wp_fn.applyStyle('backgroundColor', '#f8f9fa')" class="btn btn-sm border-0 rounded-circle" style="background:#f8f9fa; width:22px; height:22px"></button>
                  <input type="color" onchange="wp_fn.applyStyle('backgroundColor', this.value)" class="form-control form-control-color p-0 border-0" style="width:22px; height:22px">
              </div>
          </div>
          <div class="mb-4">
              <label class="form-label small fw-bold">Tamanho da Fonte</label>
              <select class="form-select form-select-sm" onchange="wp_fn.applyStyle('fontSize', this.value)">
                  <option value="1rem">Normal</option>
                  <option value="1.25rem">Médio</option>
                  <option value="1.5rem">Grande</option>
                  <option value="2rem">Título G</option>
              </select>
          </div>
      `;
  },

  applyStyle: function(prop, val) {
      if (!this.activeBlock) return;
      const target = this.activeBlock.querySelector('[contenteditable="true"]') || this.activeBlock;
      target.style[prop] = val;
      if (prop === 'backgroundColor' && val !== 'transparent') {
          target.style.padding = '15px';
          target.style.borderRadius = '6px';
      }
  },

  init: function() {
      // Limpa canvas anterior se houver
      const container = document.getElementById('wp_canvas_container');
      if(container) {
          container.innerHTML = '';
          this.addBlock('paragraph');
      }
  }
};

// Auto-inicialização ao carregar o fragmento
setTimeout(() => wp_fn.init(), 100);

// Clique global para desmarcar blocos
document.addEventListener('click', function(e) {
  if (!e.target.closest('.wp-block') && !e.target.closest('.wp-aside') && !e.target.closest('.wp-nav-header')) {
      if (wp_fn.activeBlock) wp_fn.activeBlock.classList.remove('is-active');
      wp_fn.activeBlock = null;
      const settings = document.getElementById('wp_settings_area');
      if(settings) settings.innerHTML = '<div class="text-center py-5 text-muted small">Selecione um bloco</div>';
  }
});



// function SysAutomatorConfigPageEditor(response, modalEl, modal, recordData) {

//   // console.log(response);
//   // console.log(modalEl);
//   // console.log(modal);
//   // console.log(recordData);
//   // var editor = {

//   //   isNew: ( (response.acao == 'store') ? true : false ),
//   //   editor: {

//   //     settingsBlock: {

//   //       collapsed: false,
//   //       tab:      'page-settings'

//   //     },
//   //     content: ( (response.acao == 'store') ? '' : response.dados.tbl_sys_route_content ),
    
//   //   }

//   // };


//   SysAutomatorEditor.config({

//     isNew: (response.acao === 'store'),
//     editor: {

//       settingsBlock: {

//         collapsed: false,
//         tab:       'page-settings'

//       },

//       content: (response.acao === 'store') ? '' : (response.dados ?.tbl_sys_route_content || '' )

//     },

//     callback: function(
//       state,
//       editor,
//       selectors
//     ) {

//       console.log('Editor pronto');

//       $(selectors.canvas)
//         .html(
//           editor.content
//         );

//     }

//   });

//   SysAutomatorEditor.init(editor);

// }


// function SysAutomatorInitPageEditor(response, modalEl, modal, recordData) {

//   SysAutomatorEditor.initInterface();

// }

// function SysAutomatorConfigPageEditor(
//     response,
//     modalEl,
//     modal,
//     recordData
// ) {


//     // SysAutomatorEditor.config({

//     //     isNew:
//     //         (
//     //             response.acao === 'store'
//     //         ),

//     //     editor: {

//     //         settingsBlock: {

//     //             collapsed: false,
//     //             tab: 'page-settings'

//     //         },

//     //         content:
//     //             (
//     //                 response.acao === 'store'
//     //             )
//     //             ? ''
//     //             : (
//     //                 response.dados['page']
//     //                 ?.tbl_sys_route_content
//     //                 || ''
//     //             ),
//     //         blocks: (response.dados['blocks'] ? response.dados['blocks'] : {})

//     //     }

//     // });

//     // /**
//     //  * Aplica configuração
//     //  */
//     // SysAutomatorEditor.init(function(retorno) {

//     //   if(response.acao === 'store') {

//     //     $('#tbl_sys_route_title-sync').prop('checked', true);

//     //   }

//     //   return retorno;

//     // });

//   SysAutomatorEditor.config({
//     isNew: response.acao === 'store',
//     editor: {
//       content: response.acao === 'store'
//         ? ''
//         : (response.dados['page']?.tbl_sys_route_content || ''),
//       css: response.dados['page']?.tbl_sys_route_css || '',
//       blocks: response.dados['blocks'] || {}
//     }
//   }, function () {

//     SysAutomatorEditor.init(function () {

//       if (response.acao === 'store') {
//         $('#tbl_sys_route_title-sync').prop('checked', true);
//       }

//     });

//   });


// }

function AutomatorPaginationCreateModalViewCallBack(
  args = []
) {

  if (
    !Array.isArray(args) ||
    args.length < 1
  ) {
    return false;
  }

  const vars =
    args[0] &&
    typeof args[0] === 'object'
      ? args[0]
      : {};

  let currentView =
    window.AutomatorPaginationCurrentModalView ||
    null;

  let modalEl =
    currentView &&
    currentView.modalEl
      ? currentView.modalEl
      : document.querySelector(
          '.automator-view-modal.show'
        );

  let formEl =
    document.getElementById(
      'automator-editor-change-observer-form'
    );

  if (
    !formEl &&
    currentView &&
    currentView.formEl
  ) {

    formEl =
      currentView.formEl;

  }

  if (
    !formEl &&
    modalEl
  ) {

    formEl =
      modalEl.querySelector(
        '#automator-editor-change-observer-form'
      ) ||
      modalEl.querySelector(
        '#automator-editor-modal form'
      ) ||
      modalEl.querySelector('form');

  }

  if (!formEl) {

    console.error(
      'Nenhum formulário do editor de páginas foi encontrado para configurar o envio.'
    );

    return false;

  }

  if (!currentView) {

    currentView = {
      modalID:
        modalEl
          ? modalEl.id
          : '',

      formID:
        formEl.id ||
        '',

      modalEl:
        modalEl,

      formEl:
        formEl,

      modal:
        modalEl
          ? bootstrap.Modal.getInstance(
              modalEl
            )
          : null
    };

    window.AutomatorPaginationCurrentModalView =
      currentView;

  } else {

    currentView.formEl =
      formEl;

    currentView.formID =
      formEl.id ||
      '';

  }

  /*
  |--------------------------------------------------------------------------
  | Método
  |--------------------------------------------------------------------------
  */

  formEl.setAttribute(
    'method',
    String(
      vars.method ||
      'POST'
    ).toUpperCase()
  );

  /*
  |--------------------------------------------------------------------------
  | Action da paginação
  |--------------------------------------------------------------------------
  */

  const actionName =
    String(
      vars.action ||
      ''
    );

  if (
    actionName === '' ||
    typeof window.AutomatorPaginationRoutes === 'undefined' ||
    !window.AutomatorPaginationRoutes[actionName]
  ) {

    console.error(
      'A rota da ação "' +
      actionName +
      '" não foi encontrada.'
    );

    return false;

  }

  let actionURL =
    String(
      window.AutomatorPaginationRoutes[
        actionName
      ] ||
      ''
    );

  /*
  |--------------------------------------------------------------------------
  | ID da página
  |--------------------------------------------------------------------------
  */

  let recordID =
    vars.tbl_sys_route_ID ||
    vars.pageID ||
    vars.id ||
    '';

  recordID =
    String(recordID || '').trim();

  if (
    recordID !== '' &&
    !/^\d+$/.test(recordID)
  ) {

    console.error(
      'O ID informado para edição não é válido:',
      recordID
    );

    return false;

  }

  if (
    recordID !== '' &&
    actionURL.indexOf('#ID#') !== -1
  ) {

    actionURL =
      actionURL.replace(
        '#ID#',
        recordID
      );

  }

  formEl.setAttribute(
    'action',
    actionURL
  );

  formEl.setAttribute(
    'data-automator-editor-action',
    actionName
  );

  formEl.setAttribute(
    'data-automator-modal-id',
    currentView.modalID ||
    ''
  );

  formEl.setAttribute(
    'data-automator-form-id',
    currentView.formID ||
    formEl.id ||
    ''
  );

  /*
  |--------------------------------------------------------------------------
  | Registra o ID da rota no formulário
  |--------------------------------------------------------------------------
  */

  if (
    actionName === 'edit' &&
    recordID !== ''
  ) {

    let routeIDInput =
      formEl.querySelector(
        'input[type="hidden"][name="tbl_sys_route_ID"]'
      );

    if (!routeIDInput) {

      routeIDInput =
        document.createElement('input');

      routeIDInput.type =
        'hidden';

      routeIDInput.name =
        'tbl_sys_route_ID';

      formEl.appendChild(
        routeIDInput
      );

    }

    routeIDInput.value =
      recordID;

  }

  /*
  |--------------------------------------------------------------------------
  | Adiciona os demais argumentos
  |--------------------------------------------------------------------------
  */

  $.each(
    vars,
    function(index, value) {

      if (
        index === 'method' ||
        index === 'action' ||
        index === 'tbl_sys_route_ID' ||
        index === 'pageID' ||
        index === 'id'
      ) {
        return;
      }

      let input =
        formEl.querySelector(
          'input[type="hidden"][name="' +
          index +
          '"]'
        );

      if (!input) {

        input =
          document.createElement('input');

        input.type =
          'hidden';

        input.name =
          index;

        formEl.appendChild(
          input
        );

      }

      input.value =
        value !== null &&
        typeof value !== 'undefined'
          ? String(value)
          : '';

    }
  );

  if (
    typeof AutomatorFormSerializeCurrentState ===
    'function'
  ) {

    formEl.setAttribute(
      'data-automator-initial-state',
      AutomatorFormSerializeCurrentState(
        formEl
      )
    );

  }

  formEl.setAttribute(
    'data-automator-form-changed',
    'false'
  );

  return {
    vars: vars,
    formEl: formEl,
    modalEl: modalEl,
    currentView: currentView,
    method: formEl.getAttribute('method'),
    action: formEl.getAttribute('action'),
    recordID: recordID
  };

}


function getSysAutomatorPageEditorData(
  response,
  recordData
) {

  response =
    response &&
    typeof response === 'object'
      ? response
      : {};

  recordData =
    recordData &&
    typeof recordData === 'object'
      ? recordData
      : {};

  const dados =
    response.dados &&
    typeof response.dados === 'object'
      ? response.dados
      : {};

  let page = {};

  /*
  |--------------------------------------------------------------------------
  | Resolve os dados reais da página retornados pelo GET
  |--------------------------------------------------------------------------
  */

  if (
    recordData.data &&
    typeof recordData.data === 'object'
  ) {

    page =
      recordData.data;

  } else if (
    recordData.page &&
    typeof recordData.page === 'object'
  ) {

    page =
      recordData.page;

  } else if (
    recordData.item &&
    typeof recordData.item === 'object'
  ) {

    page =
      recordData.item;

  } else if (
    recordData.values &&
    typeof recordData.values === 'object'
  ) {

    page =
      recordData.values;

  } else if (
    Object.keys(recordData).length > 0
  ) {

    page =
      recordData;

  } else if (
    dados.page &&
    typeof dados.page === 'object'
  ) {

    page =
      dados.page;

  }

  /*
  |--------------------------------------------------------------------------
  | Resolve o ID sem usar response.id
  |--------------------------------------------------------------------------
  |
  | response.id pode ser o identificador interno da view ou da rota da API,
  | por exemplo "page-admin-api-routes-update". Ele não representa o ID
  | numérico da página.
  |
  */

  let pageID =
    page.tbl_sys_route_ID ||
    page.pageID ||
    response.pageID ||
    '';

  pageID =
    String(pageID || '').trim();

  if (
    pageID !== '' &&
    !/^\d+$/.test(pageID)
  ) {

    pageID =
      '';

  }

  const editorAction =
    response.editorAction ||
    response.acao ||
    (
      pageID !== ''
        ? 'update'
        : 'store'
    );

  return {
    id: pageID,

    action: editorAction,

    isNew:
      editorAction === 'store' ||
      editorAction === 'add',

    content:
      page.tbl_sys_route_content ||
      page.content ||
      '',

    css:
      page.tbl_sys_route_css ||
      page.css ||
      '',

    blocks:
      dados.blocks ||
      response.blocks ||
      {},

    page:
      page
  };

}


function SysAutomatorConfigPageEditor(
  response,
  modalEl,
  modal,
  recordData,
  submitConfig = {}
) {

  AutomatorPageLoader('show');


  response = (
    response &&
    typeof response === 'object'
  )
    ? response
    : {};


  submitConfig = (
    submitConfig &&
    typeof submitConfig === 'object'
  )
    ? submitConfig
    : {};


  const pageData =
    getSysAutomatorPageEditorData(
      response,
      recordData
    );


  const isNew =
    pageData.isNew === true;


  /*
  |--------------------------------------------------------------------------
  | Mantém o contexto correto da operação
  |--------------------------------------------------------------------------
  */

  const editorAction =
    isNew
      ? 'store'
      : 'update';


  response.editorAction =
    editorAction;

  response.acao =
    editorAction;

  response.pageID =
    pageData.id || '';


  /*
  |--------------------------------------------------------------------------
  | Ajusta os dados visuais e de contexto do modal
  |--------------------------------------------------------------------------
  */

  if (modalEl) {

    const modalTitle =
      modalEl.querySelector(
        '.modal-title'
      );


    if (modalTitle) {

      modalTitle.textContent =
        isNew
          ? 'Nova Página'
          : 'Editar Página';

    }


    modalEl.setAttribute(
      'data-automator-editor-action',
      editorAction
    );


    modalEl.setAttribute(
      'data-automator-editor-page-id',
      pageData.id || ''
    );

  }


  /*
  |--------------------------------------------------------------------------
  | Inicializa o editor
  |--------------------------------------------------------------------------
  */

  SysAutomatorEditor.config({

    isNew: isNew,

    editor: {

      pageID:
        pageData.id || '',

      action:
        editorAction,

      settingsBlock: {

        collapsed: false,

        tab: 'page-settings'

      },

      content:
        isNew
          ? ''
          : pageData.content,

      css:
        isNew
          ? ''
          : pageData.css,

      blocks:
        pageData.blocks

    }

  }, function() {


    SysAutomatorEditor.init(function() {


      /*
      |--------------------------------------------------------------------------
      | Restaura título, slug e configurações da página
      |--------------------------------------------------------------------------
      */

      setSysAutomatorPageEditorInitialHeaderState(
        response
      );


      /*
      |--------------------------------------------------------------------------
      | Completa as configurações de submit
      |--------------------------------------------------------------------------
      */

      const finalSubmitConfig =
        $.extend(
          {},
          submitConfig
        );


      if (!finalSubmitConfig.method) {

        finalSubmitConfig.method =
          'POST';

      }


      if (!finalSubmitConfig.action) {

        finalSubmitConfig.action =
          isNew
            ? 'add'
            : 'edit';

      }


      if (
        !isNew &&
        pageData.id
      ) {

        finalSubmitConfig.tbl_sys_route_ID =
          finalSubmitConfig.tbl_sys_route_ID ||
          pageData.id;

      }


      /*
      |--------------------------------------------------------------------------
      | Configura o formulário interno de envio
      |--------------------------------------------------------------------------
      */

      const submitContext =
        AutomatorPaginationCreateModalViewCallBack([
          finalSubmitConfig
        ]);


      if (
        !submitContext ||
        !submitContext.formEl
      ) {

        console.error(
          'Não foi possível configurar o formulário de envio do editor de páginas.'
        );


        AutomatorPageLoader(
          'hide',
          function() {

            AutomatorSetActionStatus(
              false
            );

          }
        );


        return;

      }


      /*
      |--------------------------------------------------------------------------
      | Registra o ID da rota em edição
      |--------------------------------------------------------------------------
      */

      if (
        !isNew &&
        pageData.id
      ) {

        let routeIDField =
          submitContext.formEl.querySelector(
            '[name="tbl_sys_route_ID"]'
          );


        if (!routeIDField) {

          routeIDField =
            document.createElement(
              'input'
            );

          routeIDField.type =
            'hidden';

          routeIDField.name =
            'tbl_sys_route_ID';

          submitContext.formEl.appendChild(
            routeIDField
          );

        }


        routeIDField.value =
          pageData.id;

      }


      /*
      |--------------------------------------------------------------------------
      | Sincroniza os campos da página com o formulário
      |--------------------------------------------------------------------------
      */

      if (
        window.SysAutomatorEditor &&
        typeof SysAutomatorEditor.syncEditorRouteFieldsToForm ===
        'function'
      ) {

        SysAutomatorEditor.syncEditorRouteFieldsToForm(
          submitContext.formEl
        );

      }


      /*
      |--------------------------------------------------------------------------
      | Atualiza o estado inicial do formulário de envio
      |--------------------------------------------------------------------------
      */

      if (
        typeof AutomatorFormSerializeCurrentState ===
        'function'
      ) {

        submitContext.formEl.setAttribute(
          'data-automator-initial-state',
          AutomatorFormSerializeCurrentState(
            submitContext.formEl
          )
        );

      }


      submitContext.formEl.setAttribute(
        'data-automator-form-changed',
        'false'
      );


      /*
      |--------------------------------------------------------------------------
      | Registra o estado completo já carregado como estado inicial
      |--------------------------------------------------------------------------
      |
      | Esta chamada precisa ocorrer depois:
      |
      | - do título ser preenchido;
      | - do slug ser preenchido;
      | - das configurações da página serem carregadas;
      | - do ID da página ser definido;
      | - da action e method do formulário serem configurados.
      |
      */

      if (
        window.SysAutomatorEditor &&
        typeof SysAutomatorEditor.resetEditorChangeObserverState ===
        'function'
      ) {

        SysAutomatorEditor.resetEditorChangeObserverState();

      }


      /*
      |--------------------------------------------------------------------------
      | Finaliza o carregamento
      |--------------------------------------------------------------------------
      */

      setTimeout(function() {

        /*
        |--------------------------------------------------------------------------
        | Reforça o estado inicial após eventos assíncronos dos campos
        |--------------------------------------------------------------------------
        */

        if (
          window.SysAutomatorEditor &&
          typeof SysAutomatorEditor.resetEditorChangeObserverState ===
          'function'
        ) {

          SysAutomatorEditor.resetEditorChangeObserverState();

        }


        AutomatorPageLoader(
          'hide',
          function() {

            AutomatorSetActionStatus(
              false
            );

          }
        );

      }, 350);


    });


  });

}

// function SysAutomatorConfigPageEditor(
//   response,
//   modalEl,
//   modal,
//   recordData
// ) {

//   AutomatorPageLoader('show');

//   const pageData = getSysAutomatorPageEditorData(
//     response,
//     recordData
//   );

//   SysAutomatorEditor.config({
//     isNew: response.acao === 'store',
//     editor: {
//       settingsBlock: {
//         collapsed: false,
//         tab: 'page-settings'
//       },
//       content: response.acao === 'store'
//         ? ''
//         : pageData.content,
//       css: response.acao === 'store'
//         ? ''
//         : pageData.css,
//       blocks: pageData.blocks
//     }
//   }, function () {

//     SysAutomatorEditor.init(function () {

//       setSysAutomatorPageEditorInitialHeaderState(response);

//       setTimeout(function () {

//         AutomatorPageLoader('hide', function () {
//           AutomatorSetActionStatus(false);
//         });

//       }, 350);

//     });

//   });

// }

function SysAutomatorInitPageEditor(
    response,
    modalEl,
    modal,
    recordData
) {

  //   const editor = grapesjs.init({

  //       container:'#gjs',

  //       height:'100%',

  //       storageManager:false,

  //       fromElement:false

  //   });

  //   editor.BlockManager.add('titulo',{

  //     label:'Título',

  //     category:'Texto',

  //     content:`
  //         <h2>
  //             Novo título
  //         </h2>
  //     `

  // });
    // console.trace(
    //     'SysAutomatorInitPageEditor'
    // );

    // SysAutomatorEditor.initInterface(function() {

    //   $('#tbl_sys_route_title').focus()

    // });
  return true;

}


function SysAutomatorDestroyPageEditor(
  response,
  modalEl,
  modal,
  recordData
) {

  if (
    typeof window.SysAutomatorEditor === 'undefined' ||
    !window.SysAutomatorEditor
  ) {
    return true;
  }

  try {

    const editor =
      typeof SysAutomatorEditor.getEditor === 'function'
        ? SysAutomatorEditor.getEditor()
        : null;

    if (
      editor &&
      editor.Canvas &&
      typeof editor.Canvas.getFrameEl === 'function' &&
      editor.Canvas.getFrameEl()
    ) {
      SysAutomatorEditor.destroy();
    }

  } catch (e) {

    console.warn('Editor de páginas já estava destruído ou incompleto.', e);

  }

  return true;

}


function setSysAutomatorPageEditorInitialHeaderState(response) {

  const isStore =
    response &&
    response.acao === 'store';

  const titleInput =
    $('#tbl_sys_route_title');

  const syncCheckbox =
    $('#tbl_sys_route_title-sync');

  if (syncCheckbox.length) {

    syncCheckbox.prop('checked', isStore === true);

    if (isStore === true && titleInput.length && window.SysAutomatorEditor) {
      SysAutomatorEditor.syncHeaderInputSlug(titleInput[0]);
    }

  }

  if (titleInput.length) {

    setTimeout(function () {
      titleInput.trigger('focus');
    }, 100);

  }

}



/*
|--------------------------------------------------------------------------
| AUTOMATOR SYS FUNCTIONS AUTOCOMPLETE
|--------------------------------------------------------------------------
*/


window.AutomatorSysFunctionsAutocomplete =

  window.AutomatorSysFunctionsAutocomplete || {

    loaded: false,

    loading: false,

    functions: [],

    callbacks: [],

    activeField: null,

    activeItems: [],

    activeIndex: -1,

  };



function AutomatorSysFunctionsEscapeHTML(
  value = ''
) {


  return String(

    value === null ||
    value === undefined

      ? ''

      : value

  )
    .replace(/&/g, '&amp;')
    .replace(/</g, '&lt;')
    .replace(/>/g, '&gt;')
    .replace(/"/g, '&quot;')
    .replace(/'/g, '&#039;');


}



function AutomatorSysFunctionsGetContainer() {


  let container = $(

    '#automator-sysfunctions-autocomplete'

  );


  if(container.length) {

    return container;

  }


  container = $(

    '<div ' +

      'id="automator-sysfunctions-autocomplete" ' +

      'class="' +

        'automator-sysfunctions-autocomplete ' +

        'position-fixed bg-white border rounded shadow d-none' +

      '" ' +

      'style="' +

        'z-index: 5000;' +

        'max-height: 280px;' +

        'overflow-y: auto;' +

        'min-width: 280px;' +

      '"' +

    '></div>'

  );


  $('body').append(

    container

  );


  return container;


}



function AutomatorSysFunctionsHide() {


  const autocomplete =

    window.AutomatorSysFunctionsAutocomplete;


  autocomplete.activeField = null;

  autocomplete.activeItems = [];

  autocomplete.activeIndex = -1;


  AutomatorSysFunctionsGetContainer()
    .addClass('d-none')
    .empty();


  return true;


}



function AutomatorSysFunctionsLoad(
  callback = null
) {


  const autocomplete =

    window.AutomatorSysFunctionsAutocomplete;


  if(autocomplete.loaded === true) {


    if(typeof callback === 'function') {

      callback(

        autocomplete.functions

      );

    }


    return true;

  }


  if(typeof callback === 'function') {

    autocomplete.callbacks.push(

      callback

    );

  }


  if(autocomplete.loading === true) {

    return true;

  }


  if(
    typeof window.AutomatorRoutes === 'undefined' ||
    !window.AutomatorRoutes.apiAdmin
  ) {

    return false;

  }


  autocomplete.loading = true;


  $.ajax({

    url: window.AutomatorRoutes.apiAdmin,

    type: 'POST',

    data: {

      acao: 'get-sys-functions-autocomplete',

    },

    headers: {

      'X-CSRF-TOKEN':

        $('meta[name="csrf-token"]')
          .attr('content'),

      'Accept': 'application/json',

    },

    dataType: 'json',

    success: function(response) {


      autocomplete.loading = false;


      if(
        response &&
        response.status === true &&
        Array.isArray(
          response.functions
        )
      ) {

        autocomplete.functions =

          response.functions;

      } else {

        autocomplete.functions = [];

      }


      autocomplete.loaded = true;


      const callbacks =

        autocomplete.callbacks.slice();


      autocomplete.callbacks = [];


      callbacks.forEach(function(currentCallback) {


        if(typeof currentCallback === 'function') {

          currentCallback(

            autocomplete.functions

          );

        }


      });


    },

    error: function(xhr) {


      autocomplete.loading = false;

      autocomplete.loaded = true;

      autocomplete.functions = [];


      const callbacks =

        autocomplete.callbacks.slice();


      autocomplete.callbacks = [];


      callbacks.forEach(function(currentCallback) {


        if(typeof currentCallback === 'function') {

          currentCallback([]);

        }


      });


      if(
        typeof AutomatorSessionResponseIsExpired === 'function' &&
        AutomatorSessionResponseIsExpired(xhr)
      ) {

        AutomatorSessionForceLogin(

          xhr

        );

      }


    },

  });


  return true;


}



function AutomatorSysFunctionsGetCursorPosition(
  field
) {


  field = $(field);


  if(!field.length) {

    return 0;

  }


  const fieldElement = field[0];


  if(
    typeof fieldElement.selectionStart === 'number'
  ) {

    return fieldElement.selectionStart;

  }


  return String(

    field.val() || ''

  ).length;


}



function AutomatorSysFunctionsGetContext(
  field
) {


  field = $(field);


  if(!field.length) {

    return null;

  }


  const value = String(

    field.val() || ''

  );


  const cursorPosition =

    AutomatorSysFunctionsGetCursorPosition(

      field

    );


  const valueBeforeCursor = value.substring(

    0,

    cursorPosition

  );


  /*
  |--------------------------------------------------------------------------
  | Localiza o início do gatilho
  |--------------------------------------------------------------------------
  |
  | A versão anterior utilizava:
  |
  | valueBeforeCursor.lastIndexOf('@SysFunctions')
  |
  | Isso fazia com que o autocomplete fosse aberto somente depois que o
  | usuário terminasse de escrever todo o texto "@SysFunctions".
  |
  | Agora também são reconhecidos os valores parciais:
  |
  | @
  | @S
  | @Sys
  | @SysFun
  | @SysFunctions
  |--------------------------------------------------------------------------
  */


  const partialTriggerMatch =

    valueBeforeCursor.match(

      /@(?:S(?:y(?:s(?:F(?:u(?:n(?:c(?:t(?:i(?:o(?:n(?:s)?)?)?)?)?)?)?)?)?)?)?)?$/i

    );


  let triggerPosition = -1;


  if(partialTriggerMatch) {


    triggerPosition =

      valueBeforeCursor.length -

      String(

        partialTriggerMatch[0] || ''

      ).length;


  } else {


    triggerPosition =

      valueBeforeCursor.lastIndexOf(

        '@SysFunctions'

      );


  }


  if(triggerPosition < 0) {

    return null;

  }


  const expressionBeforeCursor =

    valueBeforeCursor.substring(

      triggerPosition

    );


  /*
  |--------------------------------------------------------------------------
  | Gatilho sendo digitado parcialmente
  |--------------------------------------------------------------------------
  */


  if(

    /^@(?:S(?:y(?:s(?:F(?:u(?:n(?:c(?:t(?:i(?:o(?:n(?:s)?)?)?)?)?)?)?)?)?)?)?)?$/i.test(

      expressionBeforeCursor

    )

  ) {


    return {

      type: 'function',

      query: '',

      start: triggerPosition,

      end: cursorPosition,

    };


  }


  /*
  |--------------------------------------------------------------------------
  | Função sendo pesquisada
  |--------------------------------------------------------------------------
  |
  | Exemplos:
  |
  | @SysFunctions(
  | @SysFunctions('
  | @SysFunctions('sys
  |--------------------------------------------------------------------------
  */


  const functionMatch =

    expressionBeforeCursor.match(

      /^@SysFunctions\s*\(\s*['"]?([^'"]*)$/i

    );


  if(functionMatch) {


    return {

      type: 'function',

      query: String(

        functionMatch[1] || ''

      ),

      start: triggerPosition,

      end: cursorPosition,

    };


  }


  /*
  |--------------------------------------------------------------------------
  | Parâmetro sendo preenchido
  |--------------------------------------------------------------------------
  |
  | Exemplo:
  |
  | @SysFunctions(
  |   'sysGetRouteData',
  |   [
  |     'data' => 'tbl_sys_
  |   ]
  | )
  |--------------------------------------------------------------------------
  */


  const completeFunctionMatch =

    expressionBeforeCursor.match(

      /^@SysFunctions\s*\(\s*['"]([^'"]+)['"]\s*,\s*\[([\s\S]*)$/i

    );


  if(completeFunctionMatch) {


    const functionName = String(

      completeFunctionMatch[1] || ''

    ).trim();


    const paramsContent = String(

      completeFunctionMatch[2] || ''

    );


    const paramMatch = paramsContent.match(

      /['"]([^'"]+)['"]\s*=>\s*['"]([^'"]*)$/i

    );


    if(paramMatch) {


      const currentParamValue = String(

        paramMatch[2] || ''

      );


      return {

        type: 'param-value',

        functionName: functionName,

        paramName: String(

          paramMatch[1] || ''

        ).trim(),

        query: currentParamValue,

        start:

          cursorPosition -

          currentParamValue.length,

        end: cursorPosition,

      };


    }


  }


  return null;


}



function AutomatorSysFunctionsGetFunctionByName(
  functionName = ''
) {


  functionName = String(

    functionName || ''

  ).trim();


  const functions =

    window
      .AutomatorSysFunctionsAutocomplete
      .functions;


  return functions.find(function(functionData) {


    return String(

      functionData.name || ''

    ).trim() == functionName;


  }) || null;


}



function AutomatorSysFunctionsGetItems(
  context
) {


  if(!context) {

    return [];

  }


  const query = String(

    context.query || ''

  )
    .trim()
    .toLowerCase();


  if(context.type == 'function') {


    return window
      .AutomatorSysFunctionsAutocomplete
      .functions
      .filter(function(functionData) {


        const functionName = String(

          functionData.name || ''

        ).toLowerCase();


        const functionMethod = String(

          functionData.method || ''

        ).toLowerCase();


        return (

          query == '' ||

          functionName.indexOf(query) >= 0 ||

          functionMethod.indexOf(query) >= 0

        );


      })
      .map(function(functionData) {


        return {

          type: 'function',

          value: String(

            functionData.syntax ||

            "@SysFunctions('" +

              functionData.name +

            "')"

          ),

          title: String(

            functionData.name || ''

          ),

          description: String(

            functionData.method || ''

          ),

        };


      });

  }


  if(context.type == 'param-value') {


    const functionData =

      AutomatorSysFunctionsGetFunctionByName(

        context.functionName

      );


    if(!functionData) {

      return [];

    }


    const params = Array.isArray(

      functionData.params

    )
      ? functionData.params
      : [];


    const paramData = params.find(function(currentParamData) {


      return String(

        currentParamData.name || ''

      ).trim() == context.paramName;


    });


    if(
      !paramData ||
      !Array.isArray(
        paramData.options
      )
    ) {

      return [];

    }


    return paramData.options
      .filter(function(optionData) {


        const optionValue = String(

          optionData.value || ''

        ).toLowerCase();


        const optionLabel = String(

          optionData.label || ''

        ).toLowerCase();


        return (

          query == '' ||

          optionValue.indexOf(query) >= 0 ||

          optionLabel.indexOf(query) >= 0

        );


      })
      .map(function(optionData) {


        return {

          type: 'param-value',

          value: String(

            optionData.value || ''

          ),

          title: String(

            optionData.label ||

            optionData.value ||

            ''

          ),

          description: String(

            optionData.value || ''

          ),

        };


      });

  }


  return [];


}



function AutomatorSysFunctionsPosition(
  field
) {


  field = $(field);


  if(!field.length) {

    return false;

  }


  const fieldRect =

    field[0].getBoundingClientRect();


  const container =

    AutomatorSysFunctionsGetContainer();


  const availableWidth = Math.max(

    280,

    Math.min(

      fieldRect.width,

      window.innerWidth - 30

    )

  );


  let top = fieldRect.bottom + 4;

  let left = fieldRect.left;


  if(
    top + 280 >
    window.innerHeight
  ) {

    top = Math.max(

      10,

      fieldRect.top -

      Math.min(
        280,
        container.outerHeight() || 280
      ) -

      4

    );

  }


  if(left + availableWidth > window.innerWidth - 10) {

    left = Math.max(

      10,

      window.innerWidth -

      availableWidth -

      10

    );

  }


  container.css({

    top: top + 'px',

    left: left + 'px',

    width: availableWidth + 'px',

  });


  return true;


}



function AutomatorSysFunctionsRender(
  field,
  context
) {


  const autocomplete =

    window.AutomatorSysFunctionsAutocomplete;


  const items =

    AutomatorSysFunctionsGetItems(

      context

    );


  if(items.length <= 0) {

    AutomatorSysFunctionsHide();

    return false;

  }


  autocomplete.activeField = $(field);

  autocomplete.activeItems = items;

  autocomplete.activeIndex = 0;


  let html = '';


  items.forEach(function(item, index) {


    html +=

      '<button ' +

        'type="button" ' +

        'class="' +

          'automator-sysfunctions-autocomplete-item ' +

          'btn btn-light border-0 rounded-0 text-start w-100 ' +

          (

            index === 0

              ? 'active'

              : ''

          ) +

        '" ' +

        'data-automator-sysfunctions-index="' +

          index +

        '"' +

      '>' +

        '<span class="d-block fw-semibold text-truncate">' +

          AutomatorSysFunctionsEscapeHTML(

            item.title

          ) +

        '</span>' +

        (

          item.description != ''

            ? '<span class="d-block small text-muted text-truncate">' +

                AutomatorSysFunctionsEscapeHTML(

                  item.description

                ) +

              '</span>'

            : ''

        ) +

      '</button>';


  });


  AutomatorSysFunctionsGetContainer()
    .html(html)
    .removeClass('d-none');


  AutomatorSysFunctionsPosition(

    field

  );


  return true;


}



function AutomatorSysFunctionsRefresh(
  field
) {


  field = $(field);


  if(!field.length) {

    return false;

  }


  const context =

    AutomatorSysFunctionsGetContext(

      field

    );


  if(!context) {

    AutomatorSysFunctionsHide();

    return false;

  }


  AutomatorSysFunctionsLoad(function() {


    AutomatorSysFunctionsRender(

      field,

      context

    );


  });


  return true;


}



function AutomatorSysFunctionsInsert(
  field,
  item
) {


  field = $(field);


  if(
    !field.length ||
    !item
  ) {

    return false;

  }


  const context =

    AutomatorSysFunctionsGetContext(

      field

    );


  if(!context) {

    return false;

  }


  const currentValue = String(

    field.val() || ''

  );


  const replacementValue = String(

    item.value || ''

  );


  const updatedValue =

    currentValue.substring(

      0,

      context.start

    ) +

    replacementValue +

    currentValue.substring(

      context.end

    );


  const newCursorPosition =

    context.start +

    replacementValue.length;


  field.val(

    updatedValue

  );


  field.trigger(

    'input'

  );


  field.trigger(

    'change'

  );


  if(field[0].setSelectionRange) {

    field[0].setSelectionRange(

      newCursorPosition,

      newCursorPosition

    );

  }


  field.trigger(

    'focus'

  );


  AutomatorSysFunctionsHide();


  return true;


}



function AutomatorSysFunctionsUpdateActiveItem() {


  const autocomplete =

    window.AutomatorSysFunctionsAutocomplete;


  const container =

    AutomatorSysFunctionsGetContainer();


  container
    .find(
      '.automator-sysfunctions-autocomplete-item'
    )
    .removeClass('active');


  const activeItem = container.find(

    '[data-automator-sysfunctions-index="' +

      autocomplete.activeIndex +

    '"]'

  );


  activeItem.addClass(

    'active'

  );


  if(activeItem.length) {

    activeItem[0].scrollIntoView({

      block: 'nearest',

    });

  }


  return true;


}



function AutomatorSysFunctionsBindEvents() {


  $(document)
    .off(
      '.AutomatorSysFunctionsAutocomplete'
    );


  $(document)
    .on(
      'input.AutomatorSysFunctionsAutocomplete ' +
      'click.AutomatorSysFunctionsAutocomplete ' +
      'focus.AutomatorSysFunctionsAutocomplete',
      'input.automator-sysfunctions, ' +
      'textarea.automator-sysfunctions',
      function() {


        AutomatorSysFunctionsRefresh(

          this

        );


      }
    );


  $(document)
    .on(
      'keydown.AutomatorSysFunctionsAutocomplete',
      'input.automator-sysfunctions, ' +
      'textarea.automator-sysfunctions',
      function(event) {


        const autocomplete =

          window.AutomatorSysFunctionsAutocomplete;


        if(
          autocomplete.activeItems.length <= 0 ||
          AutomatorSysFunctionsGetContainer()
            .hasClass('d-none')
        ) {

          return;

        }


        if(event.key == 'ArrowDown') {


          event.preventDefault();


          autocomplete.activeIndex = Math.min(

            autocomplete.activeItems.length - 1,

            autocomplete.activeIndex + 1

          );


          AutomatorSysFunctionsUpdateActiveItem();


        } else if(event.key == 'ArrowUp') {


          event.preventDefault();


          autocomplete.activeIndex = Math.max(

            0,

            autocomplete.activeIndex - 1

          );


          AutomatorSysFunctionsUpdateActiveItem();


        } else if(
          event.key == 'Enter' ||
          event.key == 'Tab'
        ) {


          event.preventDefault();


          const activeItem =

            autocomplete.activeItems[

              autocomplete.activeIndex

            ];


          AutomatorSysFunctionsInsert(

            this,

            activeItem

          );


        } else if(event.key == 'Escape') {


          event.preventDefault();


          AutomatorSysFunctionsHide();


        }


      }
    );


  $(document)
    .on(
      'mousedown.AutomatorSysFunctionsAutocomplete',
      '.automator-sysfunctions-autocomplete-item',
      function(event) {


        event.preventDefault();


        const autocomplete =

          window.AutomatorSysFunctionsAutocomplete;


        const itemIndex = Number(

          $(this).attr(

            'data-automator-sysfunctions-index'

          )

        );


        const item =

          autocomplete.activeItems[

            itemIndex

          ];


        AutomatorSysFunctionsInsert(

          autocomplete.activeField,

          item

        );


      }
    );


  $(document)
    .on(
      'mousedown.AutomatorSysFunctionsAutocomplete',
      function(event) {


        if(
          $(event.target).closest(
            '#automator-sysfunctions-autocomplete, ' +
            '.automator-sysfunctions'
          ).length
        ) {

          return;

        }


        AutomatorSysFunctionsHide();


      }
    );


  $(window)
    .off(
      'resize.AutomatorSysFunctionsAutocomplete ' +
      'scroll.AutomatorSysFunctionsAutocomplete'
    )
    .on(
      'resize.AutomatorSysFunctionsAutocomplete ' +
      'scroll.AutomatorSysFunctionsAutocomplete',
      function() {


        const autocomplete =

          window.AutomatorSysFunctionsAutocomplete;


        if(
          autocomplete.activeField &&
          autocomplete.activeField.length
        ) {

          AutomatorSysFunctionsPosition(

            autocomplete.activeField

          );

        }


      }
    );


  return true;


}



$(function() {


  AutomatorSysFunctionsBindEvents();


});