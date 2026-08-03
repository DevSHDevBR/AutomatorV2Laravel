function AutomatorPageLoader(action = 'show', callback = null, time = 500) {

  if(action == 'show') {

    $('#page-loader').fadeIn(time, function() {

      if(callback != null) {
        callback();
      }

    });

  } else {

    $('#page-loader').fadeOut(time, function() {

      if(callback != null) {
        callback();
      }

    });

  }

}



function AutomatorGetActionStatus(callback = null) {

  var actionStatus = $('body').attr('data-action-in-progress');

  if(actionStatus == 'true') {

    AutomatorCreateToastAlert(
      '',
      'center',
      'middle',
      true,
      true,
      'Atenção',
      'Já existe um processo em andamento. Aguarde a finalização antes de executar uma nova ação.',
      null,
      true
    );

    return false;

  }

  if(callback != null) {
    callback();
  }

  return true;

}



function AutomatorSetActionStatus(actionStatus = true, callback = null) {

  if(actionStatus == true) {

    $('body').attr('data-action-in-progress', 'true');

    $(window).off('beforeunload.AutomatorSetActionStatus').on('beforeunload.AutomatorSetActionStatus', function(e) {

      if($('body').attr('data-action-in-progress') == 'true') {

        var message = 'Existe um processo em andamento. Ao fechar a janela, as informações poderão ser perdidas.';

        e.preventDefault();
        e.returnValue = message;

        return message;

      }

    });

  } else {

    $('body').removeAttr('data-action-in-progress');

    $(window).off('beforeunload.AutomatorSetActionStatus');

  }

  if(callback != null) {
    callback();
  }

}



function AutomatorPasswordInputBTN(btn, el) {

  var btn = $(btn);
  var el  = $('#' + el);

  var show = btn.attr('data-show');
  var hide = btn.attr('data-hide');

  if(el.hasClass('automator-input-password')) {

    el.removeClass('automator-input-password');
    btn.find('i').removeClass('fa-eye').addClass('fa-eye-slash');
    btn.attr('data-bs-title', hide);

  } else {

    el.addClass('automator-input-password');
    btn.find('i').removeClass('fa-eye-slash').addClass('fa-eye');
    btn.attr('data-bs-title', show);

  }

}



function AutomatorCreateToastAlert(name = '', horizontal = 'center', vertical = 'middle', translucent = false, close = false, title = '', message = '', callback = null, closeOnBackdrop = false, closeCallback = null) {

  if(typeof bootstrap === 'undefined' || typeof bootstrap.Toast === 'undefined') {

    console.error('Bootstrap Toast não foi encontrado.');

    return false;

  }

  if(name == '' || name == null) {

    name = 'automator-toast-' + Date.now() + '-' + Math.floor(Math.random() * 999999);

  }

  if(document.querySelector('[data-automator-toast-name="' + name + '"]')) {

    name = name + '-' + Date.now() + '-' + Math.floor(Math.random() * 999999);

  }

  horizontal = horizontal ?? 'center';
  vertical   = vertical ?? 'middle';

  if(horizontal == 'start') {
    horizontal = 'left';
  }

  if(horizontal == 'end') {
    horizontal = 'right';
  }

  if(vertical == 'center') {
    vertical = 'middle';
  }

  const horizontalClasses = {
    'left': 'start-0',
    'center': 'automator-toast-container-center-x',
    'right': 'end-0'
  };

  const verticalClasses = {
    'top': 'top-0',
    'middle': 'automator-toast-container-center-y',
    'bottom': 'bottom-0'
  };

  const horizontalClass = horizontalClasses[horizontal] ?? horizontalClasses['center'];
  const verticalClass   = verticalClasses[vertical] ?? verticalClasses['middle'];

  const positionKey = horizontal + '-' + vertical;

  let animationClass = 'automator-toast-animation-fade';

  if(vertical == 'middle' && horizontal == 'center') {
    animationClass = 'automator-toast-animation-fade';
  } else if(vertical == 'top' && horizontal == 'center') {
    animationClass = 'automator-toast-animation-top-center';
  } else if(vertical == 'bottom' && horizontal == 'center') {
    animationClass = 'automator-toast-animation-bottom-center';
  } else if(vertical == 'top' && horizontal == 'left') {
    animationClass = 'automator-toast-animation-top-left';
  } else if(vertical == 'top' && horizontal == 'right') {
    animationClass = 'automator-toast-animation-top-right';
  } else if(vertical == 'bottom' && horizontal == 'left') {
    animationClass = 'automator-toast-animation-bottom-left';
  } else if(vertical == 'bottom' && horizontal == 'right') {
    animationClass = 'automator-toast-animation-bottom-right';
  } else if(vertical == 'bottom') {
    animationClass = 'automator-toast-animation-bottom';
  }

  let toastContainer = document.querySelector('[data-automator-toast-container="' + positionKey + '"]');

  if(!toastContainer) {

    toastContainer = document.createElement('div');
    toastContainer.setAttribute('data-automator-toast-container', positionKey);
    toastContainer.className = 'toast-container automator-toast-container position-fixed p-3 ' + horizontalClass + ' ' + verticalClass;
    toastContainer.style.zIndex = '1090';

    document.body.appendChild(toastContainer);

  }

  let toastBackdrop = null;

  if(translucent == true || closeOnBackdrop == true) {

    toastBackdrop = document.createElement('div');

    if(translucent == true) {
      toastBackdrop.className = 'automator-toast-backdrop automator-toast-backdrop-translucent position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 automator-toast-backdrop-hidden';
    } else {
      toastBackdrop.className = 'automator-toast-backdrop automator-toast-backdrop-transparent position-fixed top-0 start-0 w-100 h-100 automator-toast-backdrop-hidden';
    }

    toastBackdrop.setAttribute('data-automator-toast-backdrop', name);
    toastBackdrop.style.zIndex = '1080';

    document.body.appendChild(toastBackdrop);

    if(closeOnBackdrop == true) {

      toastBackdrop.addEventListener('click', function(e) {

        e.preventDefault();

        AutomatorCloseToastAlert(name);

      });

    }

    setTimeout(function() {
      toastBackdrop.classList.add('automator-toast-backdrop-show');
    }, 10);

  }

  const toastEl = document.createElement('div');

  toastEl.id = name;
  toastEl.className = 'toast automator-toast-alert ' + animationClass;
  toastEl.setAttribute('role', 'alert');
  toastEl.setAttribute('aria-live', 'assertive');
  toastEl.setAttribute('aria-atomic', 'true');
  toastEl.setAttribute('data-automator-toast-name', name);
  toastEl.setAttribute('data-automator-toast-position', positionKey);

  toastEl.AutomatorToastCloseCallbacks = [];

  if(closeCallback != null && typeof closeCallback === 'function') {
    toastEl.AutomatorToastCloseCallbacks.push(closeCallback);
  }

  let toastHtml = '';

  if(title != '' || close == true) {

    toastHtml += '<div class="toast-header automator-toast-header">';
      toastHtml += '<span class="automator-toast-header-spacer"></span>';

      if(title != '') {
        toastHtml += '<strong class="automator-toast-title">' + title + '</strong>';
      } else {
        toastHtml += '<strong class="automator-toast-title"></strong>';
      }

      if(close == true) {
        toastHtml += '<button type="button" class="btn-close js-automator-toast-close" aria-label="Fechar"></button>';
      } else {
        toastHtml += '<span class="automator-toast-header-spacer"></span>';
      }

    toastHtml += '</div>';

  }

  toastHtml += '<div class="toast-body automator-toast-body">';
    toastHtml += '<div class="automator-toast-message">';
      toastHtml += message;
    toastHtml += '</div>';

    if(close == true && title == '') {
      toastHtml += '<div class="mt-3 text-end automator-toast-footer">';
        toastHtml += '<button type="button" class="btn btn-sm btn-secondary js-automator-toast-close">Fechar</button>';
      toastHtml += '</div>';
    }

  toastHtml += '</div>';

  toastEl.innerHTML = toastHtml;

  if(vertical == 'top' && toastContainer.firstChild) {
    toastContainer.insertBefore(toastEl, toastContainer.firstChild);
  } else {
    toastContainer.appendChild(toastEl);
  }

  const toast = new bootstrap.Toast(toastEl, {
    autohide: false,
    animation: false
  });

  toastEl.AutomatorToastInstance = toast;

  toastEl.querySelectorAll('.js-automator-toast-close').forEach(function(btn) {

    btn.addEventListener('click', function(e) {

      e.preventDefault();

      AutomatorCloseToastAlert(name);

    });

  });

  toastEl.addEventListener('hidden.bs.toast', function() {

    if(toastBackdrop != null) {
      toastBackdrop.remove();
    }

    toastEl.remove();

    if(toastContainer.children.length <= 0) {
      toastContainer.remove();
    }

    if(toastEl.AutomatorToastCloseCallbacks && toastEl.AutomatorToastCloseCallbacks.length > 0) {

      toastEl.AutomatorToastCloseCallbacks.forEach(function(fn) {

        if(typeof fn === 'function') {
          fn(name, toastEl, toast);
        }

      });

    }

  });

  toast.show();

  setTimeout(function() {
    toastEl.classList.add('automator-toast-show');
  }, 10);

  if(callback != null && typeof callback === 'function') {
    callback(name, toastEl, toast);
  }

  return {
    name: name,
    element: toastEl,
    toast: toast
  };

}



function AutomatorCloseToastAlert(name = '', callback = null) {

  if(name == '' || name == null) {
    return false;
  }

  const toastEl = document.querySelector('[data-automator-toast-name="' + name + '"]');

  if(!toastEl) {
    return false;
  }

  if(toastEl.getAttribute('data-automator-toast-closing') == 'true') {
    return false;
  }

  toastEl.setAttribute('data-automator-toast-closing', 'true');

  if(callback != null && typeof callback === 'function') {

    if(!toastEl.AutomatorToastCloseCallbacks) {
      toastEl.AutomatorToastCloseCallbacks = [];
    }

    toastEl.AutomatorToastCloseCallbacks.push(callback);

  }

  const toastBackdrop  = document.querySelector('[data-automator-toast-backdrop="' + name + '"]');
  const toast          = toastEl.AutomatorToastInstance ?? bootstrap.Toast.getInstance(toastEl);

  toastEl.classList.remove('automator-toast-show');
  toastEl.classList.add('automator-toast-hiding');

  if(toastBackdrop != null) {
    toastBackdrop.classList.remove('automator-toast-backdrop-show');
  }

  setTimeout(function() {

    if(toast) {
      toast.hide();
    } else {
      toastEl.dispatchEvent(new Event('hidden.bs.toast'));
    }

  }, 300);

  return true;

}



function AutomatorCreateAutoCloseToastAlert(name = '', horizontal = 'center', vertical = 'middle', translucent = true, close = true, title = '', message = '', callback = null, closeOnBackdrop = false, closeCallback = null, time = 5000) {

  var toast = AutomatorCreateToastAlert(
    name,
    horizontal,
    vertical,
    translucent,
    close,
    title,
    message,
    null,
    closeOnBackdrop,
    function(toastName, toastEl, toastInstance) {

      if(callback != null && typeof callback === 'function') {
        callback(toastName, toastEl, toastInstance);
      }

      if(closeCallback != null && typeof closeCallback === 'function') {
        closeCallback(toastName, toastEl, toastInstance);
      }

    }
  );

  if(toast && toast.name) {

    setTimeout(function() {
      AutomatorCloseToastAlert(toast.name);
    }, time);

  }

  return toast;

}



function AutomatorGetCSRFToken() {

  var token = document.querySelector('meta[name="csrf-token"]');

  if(token) {
    return token.getAttribute('content');
  }

  return '';

}



function AutomatorNormalizeBoolean(value) {

  return (
    value === true ||
    value === 1 ||
    value === '1' ||
    value === 'true' ||
    value === 'TRUE' ||
    value === 'sim' ||
    value === 'SIM'
  );

}


function AutomatorInitBootstrapTooltips(container = document) {

  if(typeof bootstrap === 'undefined' || typeof bootstrap.Tooltip === 'undefined') {
    return false;
  }

  if(!container) {
    container = document;
  }

  var tooltipTriggerList = container.querySelectorAll('[data-bs-toggle="tooltip"]');

  tooltipTriggerList.forEach(function(tooltipTriggerEl) {

    var currentTooltip = bootstrap.Tooltip.getInstance(tooltipTriggerEl);

    if(currentTooltip) {
      currentTooltip.dispose();
    }

    new bootstrap.Tooltip(tooltipTriggerEl);

  });

  return true;

}



function AutomatorSystemFormGetValidateStatus(formEl = null) {

  if(!formEl) {
    return false;
  }

  if(formEl.hasAttribute('data-form-validade')) {
    return AutomatorNormalizeBoolean(formEl.getAttribute('data-form-validade'));
  }

  if(formEl.hasAttribute('data-form-validate')) {
    return AutomatorNormalizeBoolean(formEl.getAttribute('data-form-validate'));
  }

  return false;

}



function AutomatorSystemFormGetAjaxStatus(formEl = null) {

  if(!formEl) {
    return false;
  }

  if(formEl.hasAttribute('data-automator-ajax')) {
    return AutomatorNormalizeBoolean(formEl.getAttribute('data-automator-ajax'));
  }

  if(formEl.hasAttribute('data-automator-ignore-ajax')) {
    return !AutomatorNormalizeBoolean(formEl.getAttribute('data-automator-ignore-ajax'));
  }

  if(formEl.classList.contains('automator-ajax-ignore')) {
    return false;
  }

  return true;

}



function AutomatorSystemFormGetSubmitter(formEl = null, event = null) {

  if(!formEl) {
    return null;
  }

  if(event && event.originalEvent && event.originalEvent.submitter) {
    return event.originalEvent.submitter;
  }

  if(event && event.submitter) {
    return event.submitter;
  }

  if(document.activeElement && document.activeElement.form == formEl) {
    return document.activeElement;
  }

  return null;

}



function AutomatorSystemFormBuildFormData(formEl = null, submitterEl = null) {

  if(!formEl) {
    return null;
  }

  var formData = new FormData(formEl);

  if(submitterEl) {

    var submitterName  = submitterEl.getAttribute('name') || '';
    var submitterValue = submitterEl.getAttribute('value') || '';

    if(submitterName != '' && !formData.has(submitterName)) {
      formData.append(submitterName, submitterValue);
    }

  }

  return formData;

}



function AutomatorSystemFormGetResponseData(response = null, defaultTitle = 'Erro', defaultMessage = 'Não foi possível realizar esta ação.') {

  var title   = defaultTitle;
  var message = defaultMessage;

  if(response && typeof response === 'object') {

    if(response.title !== undefined && response.title !== null && response.title !== '') {
      title = response.title;
    }

    if(response.message !== undefined && response.message !== null && response.message !== '') {
      message = response.message;
    }

  } else if(response !== null && response !== undefined && response !== '') {
    message = String(response);
  }

  return {
    title: title,
    message: message
  };

}



function AutomatorSystemFormGetErrorData(xhr = null, defaultTitle = 'Erro', defaultMessage = 'Não foi possível realizar esta ação.') {

  var title   = defaultTitle;
  var message = defaultMessage;

  if(xhr && xhr.responseJSON) {

    if(xhr.responseJSON.title !== undefined && xhr.responseJSON.title !== null && xhr.responseJSON.title !== '') {
      title = xhr.responseJSON.title;
    }

    if(xhr.responseJSON.message !== undefined && xhr.responseJSON.message !== null && xhr.responseJSON.message !== '') {
      message = xhr.responseJSON.message;
    }

  } else if(xhr && xhr.responseText) {
    message = xhr.responseText;
  }

  return {
    title: title,
    message: message
  };

}



function AutomatorSystemFormCreateResponseToast(name = '', title = '', message = '', closeCallback = null, time = 5000) {

  return AutomatorCreateAutoCloseToastAlert(
    name,
    'center',
    'middle',
    true,
    true,
    title,
    message,
    null,
    false,
    closeCallback,
    time
  );

}



function AutomatorSystemFormReloadPageAfterToast() {

  AutomatorSetActionStatus(false);

  $(window).off('beforeunload.AutomatorModalFormChanged');

  window.location.reload();

}



function AutomatorSystemFormPrepareAjaxRequest(formEl = null, submitterEl = null) {

  if(!formEl) {
    return null;
  }

  var action = formEl.getAttribute('action') || window.location.href;
  var method = formEl.getAttribute('method') || 'POST';

  method = String(method).toUpperCase();

  if(action == '') {
    action = window.location.href;
  }

  var formData = AutomatorSystemFormBuildFormData(formEl, submitterEl);

  if(method == 'GET') {

    var queryString = new URLSearchParams(formData).toString();

    if(queryString != '') {
      action += (action.indexOf('?') >= 0 ? '&' : '?') + queryString;
    }

    return {
      url: action,
      type: 'GET',
      data: null,
      processData: true,
      contentType: true
    };

  }

  return {
    url: action,
    type: method,
    data: formData,
    processData: false,
    contentType: false
  };

}



function AutomatorSystemFormSubmitAjax(formEl = null, submitterEl = null, options = {}) {

  if(!formEl) {

    AutomatorPageLoader('hide', function() {
      AutomatorSetActionStatus(false);
    });

    return false;

  }

  var startedActionStatus = AutomatorNormalizeBoolean(options.startedActionStatus ?? false);
  var keepLoaderVisible   = AutomatorNormalizeBoolean(options.keepLoaderVisible ?? true);
  var reloadOnSuccess     = AutomatorNormalizeBoolean(options.reloadOnSuccess ?? true);

  var submitButtons = formEl.querySelectorAll('button[type="submit"], input[type="submit"]');

  submitButtons.forEach(function(btn) {
    btn.disabled = true;
  });

  function AutomatorSystemFormResetSubmitButtons() {

    submitButtons.forEach(function(btn) {
      btn.disabled = false;
    });

  }

  function AutomatorSystemFormExecuteAjax() {

    $('#page-loader').css('z-index', '1085');

    var ajaxRequest = AutomatorSystemFormPrepareAjaxRequest(formEl, submitterEl);

    if(!ajaxRequest) {

      $('#page-loader').css('z-index', '');

      AutomatorPageLoader('hide', function() {
        AutomatorSetActionStatus(false);
      });

      AutomatorSystemFormResetSubmitButtons();

      return false;

    }

    $.ajax({
      url: ajaxRequest.url,
      type: ajaxRequest.type,
      data: ajaxRequest.data,
      processData: ajaxRequest.processData,
      contentType: ajaxRequest.contentType,
      headers: {
        'X-CSRF-TOKEN': AutomatorGetCSRFToken(),
        'Accept': 'application/json'
      },
      dataType: 'json',
      success: function(response) {

        var responseStatus = AutomatorNormalizeBoolean(response && response.status !== undefined ? response.status : false);
        var responseData   = null;

        if(responseStatus == true) {

          responseData = AutomatorSystemFormGetResponseData(response, 'Sucesso', 'Ação realizada com sucesso.');

          formEl.setAttribute('data-submit', 'true');
          formEl.setAttribute('data-automator-form-changed', 'false');

          $(window).off('beforeunload.AutomatorModalFormChanged');

          if(keepLoaderVisible == false) {
            AutomatorPageLoader('hide');
          }

          var reloadExecuted = false;

          AutomatorSystemFormCreateResponseToast(
            'automator-form-submit-success-' + Date.now(),
            responseData.title,
            responseData.message,
            function() {

              if(reloadExecuted == true) {
                return;
              }

              reloadExecuted = true;

              if(reloadOnSuccess == true) {
                AutomatorSystemFormReloadPageAfterToast();
              } else {

                $('#page-loader').css('z-index', '');

                AutomatorPageLoader('hide', function() {
                  AutomatorSetActionStatus(false);
                });

                AutomatorSystemFormResetSubmitButtons();

              }

            },
            5000
          );

        } else {

          responseData = AutomatorSystemFormGetResponseData(response, 'Atenção', 'Não foi possível realizar esta ação.');

          formEl.setAttribute('data-submit', 'false');

          AutomatorSystemFormCreateResponseToast(
            'automator-form-submit-error-' + Date.now(),
            responseData.title,
            responseData.message,
            function() {

              $('#page-loader').css('z-index', '');

              AutomatorPageLoader('hide', function() {
                AutomatorSetActionStatus(false);
              });

              AutomatorSystemFormResetSubmitButtons();

            },
            5000
          );

        }

      },
      error: function(xhr) {

        var responseData = AutomatorSystemFormGetErrorData(xhr, 'Erro', 'Não foi possível realizar esta ação.');

        formEl.setAttribute('data-submit', 'false');

        AutomatorSystemFormCreateResponseToast(
          'automator-form-submit-request-error-' + Date.now(),
          responseData.title,
          responseData.message,
          function() {

            $('#page-loader').css('z-index', '');

            AutomatorPageLoader('hide', function() {
              AutomatorSetActionStatus(false);
            });

            AutomatorSystemFormResetSubmitButtons();

          },
          5000
        );

      }

    });

  }

  if(startedActionStatus == true) {

    AutomatorPageLoader('show', function() {
      AutomatorSystemFormExecuteAjax();
    });

  } else {

    AutomatorGetActionStatus(function() {

      AutomatorSetActionStatus(true, function() {

        AutomatorPageLoader('show', function() {
          AutomatorSystemFormExecuteAjax();
        });

      });

    });

  }

  return true;

}



function AutomatorPaginationGetWrapper(el = null) {

  if(el != null) {

    var wrapper = el.closest('.automator-pagination-wrapper');

    if(wrapper) {
      return wrapper;
    }

  }

  return document.querySelector('.automator-pagination-wrapper');

}



function AutomatorPaginationGetEnabledItems(wrapper = null) {

  wrapper = wrapper || AutomatorPaginationGetWrapper();

  if(!wrapper) {
    return [];
  }

  return Array.from(wrapper.querySelectorAll('.pagination-select-item:not(:disabled)'));

}



function AutomatorPaginationGetCheckedItems(wrapper = null) {

  wrapper = wrapper || AutomatorPaginationGetWrapper();

  if(!wrapper) {
    return [];
  }

  return Array.from(wrapper.querySelectorAll('.pagination-select-item:not(:disabled):checked'));

}



function AutomatorPaginationUpdateSelectionStatus(wrapper = null) {

  wrapper = wrapper || AutomatorPaginationGetWrapper();

  if(!wrapper) {
    return false;
  }

  var selectAll = wrapper.querySelector('#pagination-select-all');
  var btnDelete = wrapper.querySelector('.js-automator-pagination-delete-selected');

  var enabledItems = AutomatorPaginationGetEnabledItems(wrapper);
  var checkedItems = AutomatorPaginationGetCheckedItems(wrapper);

  if(selectAll) {

    if(enabledItems.length <= 0) {

      selectAll.checked = false;
      selectAll.indeterminate = false;
      selectAll.disabled = true;

    } else {

      selectAll.disabled = false;
      selectAll.checked = (checkedItems.length == enabledItems.length);
      selectAll.indeterminate = (checkedItems.length > 0 && checkedItems.length < enabledItems.length);

    }

  }

  if(btnDelete) {
    btnDelete.disabled = (checkedItems.length <= 0);
  }

  return true;

}



function AutomatorPaginationSelectAll(checkbox) {

  if(!checkbox) {
    return false;
  }

  var wrapper = AutomatorPaginationGetWrapper(checkbox);

  if(!wrapper) {
    return false;
  }

  var enabledItems = AutomatorPaginationGetEnabledItems(wrapper);

  if(enabledItems.length <= 0) {

    checkbox.checked = false;
    checkbox.indeterminate = false;
    checkbox.disabled = true;

    AutomatorPaginationUpdateSelectionStatus(wrapper);

    return false;

  }

  enabledItems.forEach(function(item) {
    item.checked = checkbox.checked;
  });

  AutomatorPaginationUpdateSelectionStatus(wrapper);

  return true;

}



function AutomatorPaginationDeleteValidatedCallback(context = {}) {

  console.log('Confirmação de senha validada para exclusão:', context);

  AutomatorSetActionStatus(false);

  return true;

}



function AutomatorSecurityConfirmationDestroy(modalEl, callback = null) {

  if(!modalEl) {

    if(callback != null && typeof callback === 'function') {
      callback();
    }

    return false;

  }

  var modalInstance = bootstrap.Modal.getInstance(modalEl);

  modalEl.addEventListener('hidden.bs.modal', function() {

    if(modalInstance) {
      modalInstance.dispose();
    }

    modalEl.remove();

    if(document.querySelectorAll('.modal.show').length <= 0) {

      document.body.classList.remove('modal-open');

      document.querySelectorAll('.modal-backdrop').forEach(function(backdrop) {
        backdrop.remove();
      });

    }

    if(callback != null && typeof callback === 'function') {
      callback();
    }

  }, { once: true });

  if(modalInstance) {
    modalInstance.hide();
  } else {

    modalEl.remove();

    if(callback != null && typeof callback === 'function') {
      callback();
    }

  }

  return true;

}



function AutomatorCreateSecurityConfirmationModal(context = {}) {

  if(typeof bootstrap === 'undefined' || typeof bootstrap.Modal === 'undefined') {

    AutomatorCreateToastAlert(
      'automator-security-confirmation-bootstrap-error',
      'center',
      'middle',
      true,
      true,
      'Erro',
      'Bootstrap Modal não foi encontrado.',
      null,
      true
    );

    AutomatorSetActionStatus(false);

    return false;

  }

  if(typeof window.AutomatorRoutes === 'undefined' || !window.AutomatorRoutes.apiAdmin) {

    AutomatorCreateToastAlert(
      'automator-security-confirmation-route-error',
      'center',
      'middle',
      true,
      true,
      'Erro',
      'A rota administrativa não foi encontrada.',
      null,
      true
    );

    AutomatorSetActionStatus(false);

    return false;

  }

  var confirmModalID = 'automator-security-confirmation-modal-' + Date.now() + '-' + Math.floor(Math.random() * 999999);

  var title = context.title || 'Confirmação de Segurança';

  var message = context.message || 'Para realizar esta ação é necessário que seja realizado a confirmação de segurança informando sua senha. Esta ação é necessária pois é possivel que algumas informações não poderam ser restauradas depois.';

  var keepPageLoaderOnSuccess = AutomatorNormalizeBoolean(context.keepPageLoaderOnSuccess ?? false);
  var keepPageLoaderOnCancel  = AutomatorNormalizeBoolean(context.keepPageLoaderOnCancel ?? false);
  var resetActionStatusOnCancel = (context.resetActionStatusOnCancel !== undefined) ? AutomatorNormalizeBoolean(context.resetActionStatusOnCancel) : true;
  var resetActionStatusOnSuccess = (context.resetActionStatusOnSuccess !== undefined) ? AutomatorNormalizeBoolean(context.resetActionStatusOnSuccess) : false;

  var confirmModalHTML = '';

  confirmModalHTML += '<div class="modal fade automator-security-confirmation-modal" id="' + confirmModalID + '" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">';
    confirmModalHTML += '<div class="modal-dialog modal-dialog-centered">';
      confirmModalHTML += '<div class="modal-content">';

        confirmModalHTML += '<div class="modal-header">';
          confirmModalHTML += '<h5 class="modal-title w-100 text-center">' + title + '</h5>';
        confirmModalHTML += '</div>';

        confirmModalHTML += '<div class="modal-body">';
          confirmModalHTML += '<form id="' + confirmModalID + '-form" method="POST" action="' + window.AutomatorRoutes.apiAdmin + '" data-submit="false" class="row">';
            confirmModalHTML += '<p class="mb-3">';
              confirmModalHTML += message;
            confirmModalHTML += '</p>';

            confirmModalHTML += '<div class="mb-3">';
              confirmModalHTML += '<div class="input-group">';
                confirmModalHTML += '<div class="form-floating">';
                  confirmModalHTML += '<input type="text" id="' + confirmModalID + '-password" name="password" class="form-control automator-input-password" autocomplete="off" />';
                  confirmModalHTML += '<label for="' + confirmModalID + '-password" class="form-label">Senha</label>';
                confirmModalHTML += '</div>';
                confirmModalHTML += '<span class="input-group-text p-0 text-center" style="min-width: 50px;">';
                  confirmModalHTML += '<button type="button" class="h-100 w-100 border-0 automator-tooltip-hover" data-tooltip="Exibir senha" data-show="Exibir senha" data-hide="Ocultar Senha" onclick="AutomatorPasswordInputBTN(this, ' + "'" + confirmModalID + "-password'" + ')"><i class="fa fa-eye"></i></button>';
                confirmModalHTML += '</span>';
              confirmModalHTML += '</div>';
            confirmModalHTML += '</div>';
          confirmModalHTML += '</form>';
        confirmModalHTML += '</div>';

        confirmModalHTML += '<div class="modal-footer">';
          confirmModalHTML += '<div class="row g-2 w-100">';
            confirmModalHTML += '<div class="col-12 order-2 col-md-6 order-md-1">';
              confirmModalHTML += '<button type="button" class="btn btn-secondary w-100 js-automator-security-confirmation-cancel">';
                confirmModalHTML += 'Cancelar confirmação';
              confirmModalHTML += '</button>';
            confirmModalHTML += '</div>';

            confirmModalHTML += '<div class="col-12 order-1 col-md-6 order-md-2">';
              confirmModalHTML += '<button type="submit" form="' + confirmModalID + '-form" class="btn btn-primary w-100 js-automator-security-confirmation-submit">';
                confirmModalHTML += 'Confirmar';
              confirmModalHTML += '</button>';
            confirmModalHTML += '</div>';
          confirmModalHTML += '</div>';
        confirmModalHTML += '</div>';

      confirmModalHTML += '</div>';
    confirmModalHTML += '</div>';
  confirmModalHTML += '</div>';

  document.body.insertAdjacentHTML('beforeend', confirmModalHTML);

  var confirmModalEl = document.getElementById(confirmModalID);
  var confirmFormEl  = document.getElementById(confirmModalID + '-form');
  var passwordEl     = document.getElementById(confirmModalID + '-password');
  var submitBtn      = confirmModalEl.querySelector('.js-automator-security-confirmation-submit');

  var confirmModal = new bootstrap.Modal(confirmModalEl, {
    backdrop: 'static',
    keyboard: false,
    focus: true
  });

  confirmModalEl.addEventListener('shown.bs.modal', function() {

    confirmModalEl.style.zIndex = '1070';

    var backdrops = document.querySelectorAll('.modal-backdrop');

    if(backdrops.length > 0) {
      backdrops[backdrops.length - 1].style.zIndex = '1065';
    }

    if(passwordEl) {
      passwordEl.focus();
    }

  }, { once: true });

  confirmModalEl.querySelector('.js-automator-security-confirmation-cancel').addEventListener('click', function(e) {

    e.preventDefault();

    AutomatorSecurityConfirmationDestroy(confirmModalEl, function() {

      $('#page-loader').css('z-index', '');

      if(keepPageLoaderOnCancel == false) {
        AutomatorPageLoader('hide');
      }

      if(resetActionStatusOnCancel == true) {
        AutomatorSetActionStatus(false);
      }

      if(context.cancelCallback != null && typeof context.cancelCallback === 'function') {
        context.cancelCallback(context);
      }

    });

  });

  confirmFormEl.addEventListener('submit', function(e) {

    e.preventDefault();

    var password = passwordEl ? passwordEl.value : '';

    if(password == '') {

      AutomatorCreateAutoCloseToastAlert(
        'automator-security-confirmation-empty-password',
        'center',
        'middle',
        true,
        true,
        'Atenção',
        'Informe sua senha para continuar.',
        function() {

          if(passwordEl) {
            passwordEl.focus();
          }

        },
        false,
        null,
        5000
      );

      return false;

    }

    if(submitBtn) {
      submitBtn.disabled = true;
    }

    AutomatorPageLoader('show', function() {
      $('#page-loader').css('z-index', '1085');
    });

    $.ajax({
      url: window.AutomatorRoutes.apiAdmin,
      type: 'POST',
      data: {
        acao: 'validar-senha',
        password: password
      },
      headers: {
        'X-CSRF-TOKEN': AutomatorGetCSRFToken(),
        'Accept': 'application/json'
      },
      dataType: 'json',
      success: function(response) {

        var responseTitle   = response.title || '';
        var responseMessage = response.message || '';

        if(response.status == true || response.status == 'true' || response.status == 1 || response.status == '1') {

          if(AutomatorNormalizeBoolean(context.skipSuccessToast ?? false) == true) {

            AutomatorSecurityConfirmationDestroy(confirmModalEl, function() {

              if(keepPageLoaderOnSuccess == false) {
                $('#page-loader').css('z-index', '');
              }

              if(resetActionStatusOnSuccess == true) {
                AutomatorSetActionStatus(false);
              }

              if(context.successCallback != null && typeof context.successCallback === 'function') {
                context.successCallback(context, response);
              }

            });

          } else {

            AutomatorCreateAutoCloseToastAlert(
              'automator-security-confirmation-success',
              'center',
              'middle',
              true,
              true,
              responseTitle,
              responseMessage,
              function() {

                AutomatorSecurityConfirmationDestroy(confirmModalEl, function() {

                  if(keepPageLoaderOnSuccess == false) {
                    $('#page-loader').css('z-index', '');
                  }

                  if(resetActionStatusOnSuccess == true) {
                    AutomatorSetActionStatus(false);
                  }

                  if(context.successCallback != null && typeof context.successCallback === 'function') {
                    context.successCallback(context, response);
                  }

                });

              },
              false,
              null,
              5000
            );

          }

        } else {

          AutomatorCreateAutoCloseToastAlert(
            'automator-security-confirmation-error',
            'center',
            'middle',
            true,
            true,
            responseTitle,
            responseMessage,
            function() {

              $('#page-loader').css('z-index', '');

              AutomatorPageLoader('hide', function() {

                if(passwordEl) {
                  passwordEl.focus();
                }

              });

              if(submitBtn) {
                submitBtn.disabled = false;
              }

            },
            false,
            null,
            5000
          );

        }

      },
      error: function(xhr) {

        var responseTitle   = 'Erro';
        var responseMessage = 'Não foi possível validar sua senha.';

        if(xhr.responseJSON && xhr.responseJSON.title) {
          responseTitle = xhr.responseJSON.title;
        }

        if(xhr.responseJSON && xhr.responseJSON.message) {
          responseMessage = xhr.responseJSON.message;
        } else if(xhr.responseText) {
          responseMessage = xhr.responseText;
        }

        AutomatorCreateAutoCloseToastAlert(
          'automator-security-confirmation-request-error',
          'center',
          'middle',
          true,
          true,
          responseTitle,
          responseMessage,
          function() {

            $('#page-loader').css('z-index', '');

            AutomatorPageLoader('hide', function() {

              if(passwordEl) {
                passwordEl.focus();
              }

            });

            if(submitBtn) {
              submitBtn.disabled = false;
            }

          },
          false,
          null,
          5000
        );

      }

    });

    return false;

  });

  confirmModal.show();

  return {
    id: confirmModalID,
    element: confirmModalEl,
    modal: confirmModal,
    form: confirmFormEl,
    password: passwordEl,
    context: context
  };

}



function AutomatorPaginationConfirmDeleteItem(btn) {

  if(!btn) {
    return false;
  }

  AutomatorGetActionStatus(function() {

    AutomatorSetActionStatus(true, function() {

      var wrapper = AutomatorPaginationGetWrapper(btn);
      var message = btn.getAttribute('data-delete-message-confirm');

      if(!message && wrapper) {
        message = wrapper.getAttribute('data-delete-message-confirm');
      }

      AutomatorCreateSecurityConfirmationModal({
        type: 'pagination-delete-item',
        button: btn,
        wrapper: wrapper,
        item_id: btn.getAttribute('data-automator-item-id'),
        original_onclick: btn.getAttribute('data-original-onclick') || '',
        original_href: btn.getAttribute('data-original-href') || '',
        message: message,
        resetActionStatusOnCancel: true,
        resetActionStatusOnSuccess: false,
        successCallback: function(context) {
          AutomatorPaginationDeleteValidatedCallback(context);
        }
      });

    });

  });

  return false;

}



function AutomatorPaginationSubmitDelete(btn = null) {

  var wrapper = AutomatorPaginationGetWrapper(btn);

  if(!wrapper) {
    return false;
  }

  var checkedItems = AutomatorPaginationGetCheckedItems(wrapper);

  if(checkedItems.length <= 0) {

    AutomatorPaginationUpdateSelectionStatus(wrapper);

    return false;

  }

  AutomatorGetActionStatus(function() {

    AutomatorSetActionStatus(true, function() {

      var message = '';

      if(btn) {
        message = btn.getAttribute('data-delete-message-confirm') || '';
      }

      if(!message) {
        message = wrapper.getAttribute('data-delete-message-confirm') || '';
      }

      AutomatorCreateSecurityConfirmationModal({
        type: 'pagination-delete-selected',
        button: btn,
        wrapper: wrapper,
        items: checkedItems.map(function(item) {
          return item.value;
        }),
        message: message,
        resetActionStatusOnCancel: true,
        resetActionStatusOnSuccess: false,
        successCallback: function(context) {
          AutomatorPaginationDeleteValidatedCallback(context);
        }
      });

    });

  });

  return false;

}



function AutomatorFormSerializeCurrentState(formEl) {

  if(!formEl) {
    return '';
  }

  var fields = formEl.querySelectorAll('input, select, textarea');
  var data   = [];

  fields.forEach(function(field) {

    if(field.disabled) {
      return;
    }

    var name = field.getAttribute('name') || field.getAttribute('id') || '';

    if(name == '') {
      return;
    }

    var type = (field.getAttribute('type') || '').toLowerCase();

    if(type == 'checkbox' || type == 'radio') {

      data.push(name + '=' + (field.checked ? '1' : '0') + ':' + field.value);

    } else if(field.tagName.toLowerCase() == 'select' && field.multiple) {

      var values = [];

      Array.from(field.options).forEach(function(option) {

        if(option.selected) {
          values.push(option.value);
        }

      });

      data.push(name + '=' + values.join(','));

    } else {

      data.push(name + '=' + field.value);

    }

  });

  return data.join('&');

}



function AutomatorFormHasChanged(formEl) {

  if(!formEl) {
    return false;
  }

  var initialState = formEl.getAttribute('data-automator-initial-state') || '';
  var currentState = AutomatorFormSerializeCurrentState(formEl);

  return initialState !== currentState;

}



function AutomatorUpdateModalFormChangedStatus(formEl, submitBtn = null) {

  if(!formEl) {
    return false;
  }

  var changed = AutomatorFormHasChanged(formEl);

  formEl.setAttribute('data-automator-form-changed', changed ? 'true' : 'false');

  if(submitBtn) {
    submitBtn.disabled = !changed;
  }

  return changed;

}



function AutomatorInitModalFormChangeObserver(modalEl, formEl, submitBtn = null) {

  if(!modalEl || !formEl) {
    return false;
  }

  formEl.setAttribute('data-automator-initial-state', AutomatorFormSerializeCurrentState(formEl));
  formEl.setAttribute('data-automator-form-changed', 'false');

  if(submitBtn) {
    submitBtn.disabled = true;
  }

  $(window).off('beforeunload.AutomatorModalFormChanged').on('beforeunload.AutomatorModalFormChanged', function(e) {

    if(formEl.getAttribute('data-automator-form-changed') == 'true') {

      var message = 'Existem alterações não salvas. Ao sair, as informações alteradas poderão ser perdidas.';

      e.preventDefault();
      e.returnValue = message;

      return message;

    }

  });

  formEl.addEventListener('input', function() {
    AutomatorUpdateModalFormChangedStatus(formEl, submitBtn);
  });

  formEl.addEventListener('change', function() {
    AutomatorUpdateModalFormChangedStatus(formEl, submitBtn);
  });

  formEl.addEventListener('keyup', function() {
    AutomatorUpdateModalFormChangedStatus(formEl, submitBtn);
  });

  return true;

}



function AutomatorPaginationCreateModalForm(size, titulo, formulario, acao = '', id = null, callback = null) {

  function AutomatorPaginationModalShowError(message = 'Solicitação inválida!') {

    AutomatorPageLoader('hide', function() {

      AutomatorCreateToastAlert(
        'automator-pagination-form-error',
        'center',
        'middle',
        true,
        true,
        'Erro',
        message,
        null,
        true,
        function() {
          AutomatorSetActionStatus(false);
        }
      );

    });

  }

  function AutomatorPaginationModalGetErrorMessage(xhr, defaultMessage = 'Solicitação inválida!') {

    var message = defaultMessage;

    if(xhr && xhr.responseJSON && xhr.responseJSON.message) {
      message = xhr.responseJSON.message;
    } else if(xhr && xhr.responseText) {
      message = xhr.responseText;
    }

    return message;

  }

  function AutomatorPaginationModalIsTrue(value) {
    return AutomatorNormalizeBoolean(value);
  }

  function AutomatorPaginationModalGetCSRFToken() {
    return AutomatorGetCSRFToken();
  }

  function AutomatorPaginationModalPopulateFields(modalEl, data = {}) {

    if(!modalEl || !data || typeof data !== 'object') {
      return false;
    }

    function AutomatorPaginationModalNormalizeFieldValues(value) {

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

          var decodedValue = JSON.parse(value);

          if(Array.isArray(decodedValue)) {
            values = decodedValue;
          } else if(decodedValue !== null && typeof decodedValue === 'object') {
            values = Object.keys(decodedValue);
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

      var value = data[fieldName];

      var fields = modalEl.querySelectorAll('[name="' + fieldName + '"], [name="' + fieldName + '[]"], [data-automator-field-name="' + fieldName + '"]');

      fields.forEach(function(field) {

        var tagName = field.tagName.toLowerCase();
        var type    = (field.getAttribute('type') || '').toLowerCase();

        if(type == 'checkbox') {

          var checkboxValues = AutomatorPaginationModalNormalizeFieldValues(value);

          if(checkboxValues.length > 0) {
            field.checked = checkboxValues.includes(String(field.value));
          } else {
            field.checked = false;
          }

        } else if(type == 'radio') {

          field.checked = (String(field.value) == String(value));

        } else if(tagName == 'select' && field.multiple) {

          var selectedValues = AutomatorPaginationModalNormalizeFieldValues(value);

          Array.from(field.options).forEach(function(option) {
            option.selected = selectedValues.includes(String(option.value));
          });

        } else {

          field.value = (value !== null && value !== undefined) ? value : '';

        }

        field.dispatchEvent(new Event('change', { bubbles: true }));

      });

    });

    return true;

  }

  function AutomatorPaginationModalDestroy(modalEl, resetActionStatus = true, callbackDestroy = null) {

    if(!modalEl) {

      if(resetActionStatus == true) {
        AutomatorSetActionStatus(false);
      }

      if(callbackDestroy != null && typeof callbackDestroy === 'function') {
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
        window.AutomatorPaginationCurrentModalForm &&
        window.AutomatorPaginationCurrentModalForm.modalEl &&
        window.AutomatorPaginationCurrentModalForm.modalEl.id == modalEl.id
      ) {
        window.AutomatorPaginationCurrentModalForm = null;
      }

      if(document.querySelectorAll('.modal.show').length <= 0) {

        document.body.classList.remove('modal-open');

        document.querySelectorAll('.modal-backdrop').forEach(function(backdrop) {
          backdrop.remove();
        });

      }

      $(window).off('beforeunload.AutomatorModalFormChanged');

      if(resetActionStatus == true) {
        AutomatorSetActionStatus(false);
      }

      if(callbackDestroy != null && typeof callbackDestroy === 'function') {
        callbackDestroy();
      }

    }, { once: true });

    if(modalInstance) {
      modalInstance.hide();
    } else {

      modalEl.remove();

      $(window).off('beforeunload.AutomatorModalFormChanged');

      if(resetActionStatus == true) {
        AutomatorSetActionStatus(false);
      }

    }

    return true;

  }

  function AutomatorPaginationModalCreateSecurityConfirmation(parentModalEl = null) {

    var parentFormEl = null;

    if(parentModalEl) {
      parentFormEl = parentModalEl.querySelector('form');
    }

    var message = 'Para realizar esta ação é necessário que seja realizado a confirmação de segurança informando sua senha. Esta ação é necessária pois é possivel que algumas informações não poderam ser restauradas depois.';

    AutomatorCreateSecurityConfirmationModal({
      type: 'modal-form-submit',
      parentModalEl: parentModalEl,
      parentFormEl: parentFormEl,
      message: message,
      keepPageLoaderOnSuccess: true,
      keepPageLoaderOnCancel: false,
      skipSuccessToast: true,
      resetActionStatusOnCancel: true,
      resetActionStatusOnSuccess: false,
      cancelCallback: function() {
        $('#page-loader').css('z-index', '');
      },
      successCallback: function(context) {

        $('#page-loader').css('z-index', '1085');

        if(context.parentFormEl) {

          context.parentFormEl.setAttribute('data-submit', 'false');
          context.parentFormEl.setAttribute('data-automator-form-changed', 'false');

          $(window).off('beforeunload.AutomatorModalFormChanged');

          AutomatorSystemFormSubmitAjax(context.parentFormEl, null, {
            startedActionStatus: true,
            keepLoaderVisible: true,
            reloadOnSuccess: true
          });

        }

      }
    });

  }

  function AutomatorPaginationModalCreateForm(response, recordData = {}) {

    var modalID = 'automator-pagination-form-modal-' + Date.now() + '-' + Math.floor(Math.random() * 999999);

    var formHTML = response.html || '';
    var formData = response.form || {};

    var formValidate = AutomatorPaginationModalIsTrue(formData.tbl_sys_form_validate ?? false);

    var modalHTML = '';

    modalHTML += '<div class="modal fade automator-pagination-form-modal" id="' + modalID + '" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">';
      modalHTML += '<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">';
        modalHTML += '<div class="modal-content">';

          modalHTML += '<div class="modal-header">';
            modalHTML += '<h5 class="modal-title w-100 text-center">' + titulo + '</h5>';
            modalHTML += '<button type="button" class="btn-close js-automator-pagination-modal-close" aria-label="Fechar"></button>';
          modalHTML += '</div>';

          modalHTML += '<div class="modal-body">';
            modalHTML += '<form id="' + modalID + '-form" class="row" method="" action="" data-submit="false" data-form-validate="' + (formValidate ? 'true' : 'false') + '">';
              modalHTML += formHTML;
            modalHTML += '</form>';
          modalHTML += '</div>';

          modalHTML += '<div class="modal-footer">';
            modalHTML += '<div class="row g-2 w-100">';
              modalHTML += '<div class="col-12 order-2 col-md-6 order-md-1">';
                modalHTML += '<button type="button" class="btn btn-secondary w-100 js-automator-pagination-modal-cancel">Cancelar</button>';
              modalHTML += '</div>';

              modalHTML += '<div class="col-12 order-1 col-md-6 order-md-2">';
                modalHTML += '<button type="submit" form="' + modalID + '-form" class="btn btn-primary w-100 js-automator-pagination-modal-submit" disabled>Salvar</button>';
              modalHTML += '</div>';
            modalHTML += '</div>';
          modalHTML += '</div>';

        modalHTML += '</div>';
      modalHTML += '</div>';
    modalHTML += '</div>';

    document.body.insertAdjacentHTML('beforeend', modalHTML);

    var modalEl  = document.getElementById(modalID);
    var formEl   = document.getElementById(modalID + '-form');
    var submitEl = modalEl.querySelector('.js-automator-pagination-modal-submit');

    var modal = new bootstrap.Modal(modalEl, {
      backdrop: 'static',
      keyboard: false,
      focus: true
    });

    modalEl.querySelector('.js-automator-pagination-modal-close').addEventListener('click', function(e) {

      e.preventDefault();

      AutomatorPaginationModalDestroy(modalEl, true);

    });

    modalEl.querySelector('.js-automator-pagination-modal-cancel').addEventListener('click', function(e) {

      e.preventDefault();

      AutomatorPaginationModalDestroy(modalEl, true);

    });

    formEl.addEventListener('submit', function(e) {

      if(formEl.getAttribute('data-submit') == 'true') {
        return true;
      }

      e.preventDefault();

      if(!AutomatorFormHasChanged(formEl)) {

        if(submitEl) {
          submitEl.disabled = true;
        }

        return false;

      }

      if(formValidate == true) {

        AutomatorSetActionStatus(true, function() {

          AutomatorPageLoader('show', function() {

            $('#page-loader').css('z-index', '1060');

            AutomatorPaginationModalCreateSecurityConfirmation(modalEl);

          });

        });

        return false;

      }

      AutomatorSystemFormSubmitAjax(formEl, null, {
        startedActionStatus: false,
        keepLoaderVisible: true,
        reloadOnSuccess: true
      });

      return false;

    });

    modalEl.addEventListener('shown.bs.modal', function() {

      if(recordData && typeof recordData === 'object') {
        AutomatorPaginationModalPopulateFields(modalEl, recordData);
      }

      if(callback != null && typeof callback === 'function') {

        window.AutomatorPaginationCurrentModalForm = {
          modalID: modalID,
          formID: modalID + '-form',
          modalEl: modalEl,
          formEl: formEl,
          modal: modal,
          response: response,
          recordData: recordData
        };

        callback(response, modalEl, modal, recordData);

      }

      AutomatorInitBootstrapTooltips(modalEl);

      setTimeout(function() {

        AutomatorInitBootstrapTooltips(modalEl);

        AutomatorInitModalFormChangeObserver(modalEl, formEl, submitEl);

        AutomatorSetActionStatus(false);

      }, 100);

    }, { once: true });

    modal.show();

    return {
      id: modalID,
      element: modalEl,
      modal: modal,
      response: response,
      data: recordData
    };

  }

  function AutomatorPaginationModalGetRecordData(response) {

    var hasAction = (acao !== null && acao !== undefined && acao !== '');
    var hasID     = (id !== null && id !== undefined && id !== '');

    if(hasAction == false || hasID == false) {

      AutomatorPageLoader('hide', function() {
        AutomatorPaginationModalCreateForm(response, {});
      });

      return;

    }

    if(typeof window.AutomatorPaginationRoutes === 'undefined' || !window.AutomatorPaginationRoutes[acao]) {

      AutomatorPaginationModalShowError('A rota da ação "' + acao + '" não foi encontrada.');

      return;

    }

    var actionURL = window.AutomatorPaginationRoutes[acao];

    actionURL = actionURL.replace('#ID#', id);

    $.ajax({
      url: actionURL,
      type: 'GET',
      headers: {
        'X-CSRF-TOKEN': AutomatorPaginationModalGetCSRFToken()
      },
      dataType: 'json',
      success: function(recordResponse) {

        if(recordResponse.status == true) {

          var recordData = {};

          if(recordResponse.data && typeof recordResponse.data === 'object') {
            recordData = recordResponse.data;
          } else if(recordResponse.item && typeof recordResponse.item === 'object') {
            recordData = recordResponse.item;
          } else if(recordResponse.values && typeof recordResponse.values === 'object') {
            recordData = recordResponse.values;
          }

          AutomatorPageLoader('hide', function() {
            AutomatorPaginationModalCreateForm(response, recordData);
          });

        } else {

          var message = 'Solicitação inválida!';

          if(recordResponse.message) {
            message = recordResponse.message;
          }

          AutomatorPaginationModalShowError(message);

        }

      },
      error: function(xhr) {
        AutomatorPaginationModalShowError(AutomatorPaginationModalGetErrorMessage(xhr));
      }
    });

  }

  AutomatorGetActionStatus(function() {

    AutomatorSetActionStatus(true, function() {

      AutomatorPageLoader('show', function() {

        if(typeof bootstrap === 'undefined' || typeof bootstrap.Modal === 'undefined') {

          AutomatorPaginationModalShowError('Bootstrap Modal não foi encontrado.');

          return;

        }

        if(typeof window.AutomatorRoutes === 'undefined' || !window.AutomatorRoutes.apiForms) {

          AutomatorPaginationModalShowError('A rota de formulários não foi encontrada.');

          return;

        }

        var formURL = window.AutomatorRoutes.apiForms;

        formURL = formURL.replace('#ID#', formulario);

        $.ajax({
          url: formURL,
          type: 'GET',
          headers: {
            'X-CSRF-TOKEN': AutomatorPaginationModalGetCSRFToken()
          },
          dataType: 'json',
          success: function(response) {

            if(response.status == true) {
              AutomatorPaginationModalGetRecordData(response);
            } else {

              var message = 'Solicitação inválida!';

              if(response.message) {
                message = response.message;
              }

              AutomatorPaginationModalShowError(message);

            }

          },
          error: function(xhr) {
            AutomatorPaginationModalShowError(AutomatorPaginationModalGetErrorMessage(xhr));
          }
        });

      });

    });

  });

}



function AutomatorPaginationCreateModalFormCallBack(args = []) {

  if((args.length) >= 1) {

    var vars = args[0];

    var currentForm = window.AutomatorPaginationCurrentModalForm ?? null;

    if(currentForm == null || !currentForm.formEl) {

      console.error('Nenhum formulário de modal foi encontrado para executar o callback.');

      return false;

    }

    var formEl  = currentForm.formEl;
    var modalEl = currentForm.modalEl;

    if(vars.method) {
      formEl.setAttribute('method', vars.method);
    }

    if(vars.action !== undefined) {
      formEl.setAttribute('action', window.AutomatorPaginationRoutes[vars.action]);
    }

    formEl.setAttribute('data-automator-modal-id', currentForm.modalID);
    formEl.setAttribute('data-automator-form-id', currentForm.formID);

    $.each(vars, function(index, value) {

      if(index == 'method' || index == 'action') {
        return;
      }

      var input = formEl.querySelector('[name="' + index + '"]');

      if(!input) {

        input = document.createElement('input');

        input.type = 'hidden';
        input.name = index;

        formEl.appendChild(input);

      }

      input.value = value;

    });

    formEl.setAttribute('data-automator-initial-state', AutomatorFormSerializeCurrentState(formEl));
    formEl.setAttribute('data-automator-form-changed', 'false');

    var submitBtn = modalEl.querySelector('.js-automator-pagination-modal-submit');

    if(submitBtn) {
      submitBtn.disabled = true;
    }

    console.log('Formulário afetado:', formEl);
    console.log('Modal afetado:', modalEl);
    console.log('Argumentos:', vars);

    return {
      vars: vars,
      formEl: formEl,
      modalEl: modalEl,
      currentForm: currentForm
    };

  }

  return false;

}



function AutomatorSystemPageFormCreateSecurityConfirmation(formEl = null, submitterEl = null) {

  if(!formEl) {
    return false;
  }

  var message = formEl.getAttribute('data-security-confirmation-message') || formEl.getAttribute('data-confirmation-message') || 'Para realizar esta ação é necessário que seja realizado a confirmação de segurança informando sua senha. Esta ação é necessária pois é possivel que algumas informações não poderam ser restauradas depois.';

  AutomatorCreateSecurityConfirmationModal({
    type: 'page-form-submit',
    parentFormEl: formEl,
    submitterEl: submitterEl,
    message: message,
    keepPageLoaderOnSuccess: true,
    keepPageLoaderOnCancel: false,
    skipSuccessToast: true,
    resetActionStatusOnCancel: true,
    resetActionStatusOnSuccess: false,
    cancelCallback: function(context) {

      $('#page-loader').css('z-index', '');

      if(context.parentFormEl) {
        context.parentFormEl.setAttribute('data-submit', 'false');
      }

    },
    successCallback: function(context) {

      $('#page-loader').css('z-index', '1085');

      if(context.parentFormEl) {

        context.parentFormEl.setAttribute('data-submit', 'false');

        AutomatorSystemFormSubmitAjax(context.parentFormEl, context.submitterEl, {
          startedActionStatus: true,
          keepLoaderVisible: true,
          reloadOnSuccess: true
        });

      }

    }
  });

  return true;

}



function AutomatorInitSystemAjaxForms() {

  var selector = 'form:not(.automator-ajax-ignore):not([data-automator-ignore-ajax="true"])';

  $(document).off('submit.AutomatorSystemAjaxForms', selector).on('submit.AutomatorSystemAjaxForms', selector, function(e) {

    var formEl = this;

    if(formEl.closest('.automator-security-confirmation-modal')) {
      return true;
    }

    if(formEl.closest('.automator-pagination-form-modal')) {
      return true;
    }

    if(AutomatorSystemFormGetAjaxStatus(formEl) == false) {
      return true;
    }

    e.preventDefault();

    var submitterEl  = AutomatorSystemFormGetSubmitter(formEl, e);
    var formValidate = AutomatorSystemFormGetValidateStatus(formEl);

    if(formValidate == true) {

      AutomatorGetActionStatus(function() {

        AutomatorSetActionStatus(true, function() {

          AutomatorPageLoader('show', function() {

            $('#page-loader').css('z-index', '1060');

            AutomatorSystemPageFormCreateSecurityConfirmation(formEl, submitterEl);

          });

        });

      });

      return false;

    }

    AutomatorSystemFormSubmitAjax(formEl, submitterEl, {
      startedActionStatus: false,
      keepLoaderVisible: true,
      reloadOnSuccess: true
    });

    return false;

  });

  return true;

}



$(document).on('click change', '#pagination-select-all', function() {

  AutomatorPaginationSelectAll(this);

});



$(document).on('change', '.pagination-select-item', function() {

  var wrapper = AutomatorPaginationGetWrapper(this);

  AutomatorPaginationUpdateSelectionStatus(wrapper);

});



$(document).on('click', '.automator-disabled-selection-label', function(e) {


  e.preventDefault();
  e.stopPropagation();

  return false;


});



$(document).on('change', '.automator-disabled-selection', function(e) {


  e.preventDefault();

  var originalChecked = this.getAttribute('data-automator-original-checked');

  this.checked = (originalChecked == 'true');

  return false;


});



$(function() {


  AutomatorInitBootstrapTooltips(document);

  AutomatorInitSystemAjaxForms();

  document.querySelectorAll('.automator-pagination-wrapper').forEach(function(wrapper) {

    AutomatorPaginationUpdateSelectionStatus(wrapper);

  });


});