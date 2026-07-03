$(document).on('click', '.btn-logout-system', function(e) {

  AutomatorGetActionStatus(function() {

    AutomatorSetActionStatus(true, function() {

      AutomatorPageLoader('show', function() {

        $.ajax({
          url: window.AutomatorRoutes.apiLogout,
          type: 'POST',
          data: {},
          headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
            'Accept': 'application/json'
          },
          dataType: 'json',
          success: function(response) {

            if(response.status == true) {

              AutomatorSetActionStatus(false, function() {

                if(response.redirect_url) {

                  window.location.href = response.redirect_url;

                } else {

                  window.location.href = '/admin';

                }

              });

            } else {

              var message = 'Não foi possível realizar o login.';

              if(response.message) {
                message = response.message;
              }

              alert(message);

              AutomatorPageLoader('hide', function() {
                AutomatorSetActionStatus(false);
              });

            }

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

      });

    });

  });

  return false;

});


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

  options = (options && typeof options === 'object') ? options : {};

  var acao        = options.acao      || null;
  var id          = options.id        || null;
  var size        = options.size      || 'lg';
  var centered    = (options.centered  !== undefined) ? options.centered  : true;
  var scrollable  = (options.scrollable !== undefined) ? options.scrollable : true;
  var backdrop    = (options.backdrop  !== undefined) ? options.backdrop  : 'static';
  var keyboard    = (options.keyboard  !== undefined) ? options.keyboard  : false;
  var callback    = (typeof options.callback === 'function') ? options.callback : null;
  var beforeShow  = (typeof options.beforeShow === 'function') ? options.beforeShow : null;
  var afterHideOn = (typeof options.afterHideOn === 'function') ? options.afterHideOn : null;

  var keepLoaderUntilCallback = options.keepLoaderUntilCallback === true;


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

    if(formEl && formEl.getAttribute('data-automator-form-changed') == 'true') {

      var confirmClose = confirm('Existem alterações não salvas. Deseja realmente fechar este formulário?');

      if(confirmClose == false) {
        return false;
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

      $(window).off('beforeunload.AutomatorModalViewChanged');

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

      $(window).off('beforeunload.AutomatorModalViewChanged');

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

  function _populateFields(modalEl, data) {

    if(!modalEl || !data || typeof data !== 'object') {
      return false;
    }

    function _normalizeValues(value) {

      var values = [];

      if(value === null || value === undefined || value === '') {
        return values;
      }

      if(Array.isArray(value)) {
        values = value;
      } else if(typeof value === 'object') {
        values = Object.keys(value);
      } else if(typeof value === 'string') {

        try {

          var decoded = JSON.parse(value);

          if(Array.isArray(decoded)) {
            values = decoded;
          } else if(decoded !== null && typeof decoded === 'object') {
            values = Object.keys(decoded);
          } else {
            values = value.split(',');
          }

        } catch(e) {
          values = value.split(',');
        }

      } else {
        values = [value];
      }

      return values.map(function(item) {
        return String(item).trim();
      });

    }

    Object.keys(data).forEach(function(fieldName) {

      var value  = data[fieldName];
      var fields = modalEl.querySelectorAll(
        '[name="' + fieldName + '"], [name="' + fieldName + '[]"], [data-automator-field-name="' + fieldName + '"]'
      );

      fields.forEach(function(field) {

        var tagName = field.tagName.toLowerCase();
        var type    = (field.getAttribute('type') || '').toLowerCase();

        if(type == 'checkbox') {

          var checkboxValues = _normalizeValues(value);

          field.checked = (checkboxValues.length > 0)
            ? checkboxValues.includes(String(field.value))
            : false;

        } else if(type == 'radio') {

          field.checked = (String(field.value) == String(value));

        } else if(tagName == 'select' && field.multiple) {

          var selectedValues = _normalizeValues(value);

          Array.from(field.options).forEach(function(option) {
            option.selected = selectedValues.includes(String(option.value));
          });

        } else if(tagName == 'textarea' && field.classList.contains('automator-editor')) {

          var editorContent = (value !== null && value !== undefined) ? String(value) : '';

          field.value = editorContent;

          var editorId = field.getAttribute('data-automator-editor-id') || field.getAttribute('id') || '';

          if(editorId && window.AutomatorEditors && window.AutomatorEditors[editorId]) {

            var editorInstance = window.AutomatorEditors[editorId];

            if(editorInstance.visual && editorInstance.visual.length) {
              editorInstance.visual.html(editorContent);
            }

            if(editorInstance.code && editorInstance.code.length) {
              editorInstance.code.val(editorContent);
            }

          }

        } else {

          field.value = (value !== null && value !== undefined) ? value : '';

        }

        field.dispatchEvent(new Event('change', { bubbles: true }));

      });

    });

    return true;

  }


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


function getSysAutomatorPageEditorData(
  response,
  recordData
) {

  const dados =
    response && response.dados
      ? response.dados
      : {};

  const page =
    recordData && Object.keys(recordData).length
      ? recordData
      : (
          dados.page
            ? dados.page
            : dados
        );

  return {
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
      {}
  };

}

function SysAutomatorConfigPageEditor(
  response,
  modalEl,
  modal,
  recordData
) {

  AutomatorPageLoader('show');

  const pageData = getSysAutomatorPageEditorData(
    response,
    recordData
  );

  SysAutomatorEditor.config({
    isNew: response.acao === 'store',
    editor: {
      settingsBlock: {
        collapsed: false,
        tab: 'page-settings'
      },
      content: response.acao === 'store'
        ? ''
        : pageData.content,
      css: response.acao === 'store'
        ? ''
        : pageData.css,
      blocks: pageData.blocks
    }
  }, function () {

    SysAutomatorEditor.init(function () {

      setSysAutomatorPageEditorInitialHeaderState(response);

      setTimeout(function () {

        AutomatorPageLoader('hide', function () {
          AutomatorSetActionStatus(false);
        });

      }, 350);

    });

  });

}

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

    SysAutomatorEditor.destroy();

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