function AutomatorReloadBootstrapPopovers(container = document) {

    // Remove instâncias antigas
    $(container)
        .find('[data-bs-toggle="popover"]')
        .each(function () {

            const instance = bootstrap.Popover.getInstance(this);

            if (instance) {
                instance.dispose();
            }

        });

    // Recria os popovers
    $(container)
        .find('[data-bs-toggle="popover"]')
        .each(function () {

            new bootstrap.Popover(this);

        });

}

// function AutomatorPageLoader(action = 'show', callback = null, time = 500) {

//   if(action == 'show') {

//     $('#page-loader').fadeIn(time, function() {

//       if(callback != null) {
//         callback();
//       }

//     });

//   } else {

//     $('#page-loader').fadeOut(time, function() {

//       if(callback != null) {
//         callback();
//       }

//     });

//   }

// }



// function AutomatorGetActionStatus(callback = null) {

//   var actionStatus = $('body').attr('data-action-in-progress');

//   if(actionStatus == 'true') {

//     AutomatorCreateToastAlert(
//       '',
//       'center',
//       'middle',
//       true,
//       true,
//       'Atenção',
//       'Já existe um processo em andamento. Aguarde a finalização antes de executar uma nova ação.',
//       null,
//       true
//     );

//     return false;

//   }

//   if(callback != null) {
//     callback();
//   }

//   return true;

// }



// function AutomatorSetActionStatus(actionStatus = true, callback = null) {

//   if(actionStatus == true) {

//     $('body').attr('data-action-in-progress', 'true');

//     $(window).off('beforeunload.AutomatorSetActionStatus').on('beforeunload.AutomatorSetActionStatus', function(e) {

//       if($('body').attr('data-action-in-progress') == 'true') {

//         var message = 'Existe um processo em andamento. Ao fechar a janela, as informações poderão ser perdidas.';

//         e.preventDefault();
//         e.returnValue = message;

//         return message;

//       }

//     });

//   } else {

//     $('body').removeAttr('data-action-in-progress');

//     $(window).off('beforeunload.AutomatorSetActionStatus');

//   }

//   if(callback != null) {
//     callback();
//   }

// }


// function AutomatorPasswordInputBTN(btn, el) {

//   var btn = $(btn);
//   var el  = $('#' + el);

//   var show = btn.attr('data-show');
//   var hide = btn.attr('data-hide');

//   var tooltipText = '';

//   if (el.hasClass('automator-input-password')) {

//     el.removeClass('automator-input-password');

//     btn.find('i')
//       .removeClass('fa-eye')
//       .addClass('fa-eye-slash');

//     tooltipText = hide;

//   } else {

//     el.addClass('automator-input-password');

//     btn.find('i')
//       .removeClass('fa-eye-slash')
//       .addClass('fa-eye');

//     tooltipText = show;

//   }

//   btn.attr('data-bs-title', tooltipText);
//   btn.attr('title', tooltipText);

//   var tooltipInstance = bootstrap.Tooltip.getInstance(btn[0]);

//   if (tooltipInstance) {

//     tooltipInstance.setContent({
//       '.tooltip-inner': tooltipText
//     });

//   } else {

//     new bootstrap.Tooltip(btn[0]);

//   }

// }
// // function AutomatorPasswordInputBTN(btn, el) {

// //   var btn = $(btn);
// //   var el  = $('#' + el);

// //   var show = btn.attr('data-show');
// //   var hide = btn.attr('data-hide');

// //   if(el.hasClass('automator-input-password')) {

// //     el.removeClass('automator-input-password');
// //     btn.find('i').removeClass('fa-eye').addClass('fa-eye-slash');
// //     btn.attr('data-bs-title', hide);

// //   } else {

// //     el.addClass('automator-input-password');
// //     btn.find('i').removeClass('fa-eye-slash').addClass('fa-eye');
// //     btn.attr('data-bs-title', show);

// //   }

// // }



// function AutomatorCreateToastAlert(name = '', horizontal = 'center', vertical = 'middle', translucent = false, close = false, title = '', message = '', callback = null, closeOnBackdrop = false, closeCallback = null) {

//   if(typeof bootstrap === 'undefined' || typeof bootstrap.Toast === 'undefined') {

//     console.error('Bootstrap Toast não foi encontrado.');

//     return false;

//   }

//   if(name == '' || name == null) {

//     name = 'automator-toast-' + Date.now() + '-' + Math.floor(Math.random() * 999999);

//   }

//   if(document.querySelector('[data-automator-toast-name="' + name + '"]')) {

//     name = name + '-' + Date.now() + '-' + Math.floor(Math.random() * 999999);

//   }

//   horizontal = horizontal ?? 'center';
//   vertical   = vertical ?? 'middle';

//   if(horizontal == 'start') {
//     horizontal = 'left';
//   }

//   if(horizontal == 'end') {
//     horizontal = 'right';
//   }

//   if(vertical == 'center') {
//     vertical = 'middle';
//   }

//   const horizontalClasses = {
//     'left': 'start-0',
//     'center': 'automator-toast-container-center-x',
//     'right': 'end-0'
//   };

//   const verticalClasses = {
//     'top': 'top-0',
//     'middle': 'automator-toast-container-center-y',
//     'bottom': 'bottom-0'
//   };

//   const horizontalClass = horizontalClasses[horizontal] ?? horizontalClasses['center'];
//   const verticalClass   = verticalClasses[vertical] ?? verticalClasses['middle'];

//   const positionKey = horizontal + '-' + vertical;

//   let animationClass = 'automator-toast-animation-fade';

//   if(vertical == 'middle' && horizontal == 'center') {
//     animationClass = 'automator-toast-animation-fade';
//   } else if(vertical == 'top' && horizontal == 'center') {
//     animationClass = 'automator-toast-animation-top-center';
//   } else if(vertical == 'bottom' && horizontal == 'center') {
//     animationClass = 'automator-toast-animation-bottom-center';
//   } else if(vertical == 'top' && horizontal == 'left') {
//     animationClass = 'automator-toast-animation-top-left';
//   } else if(vertical == 'top' && horizontal == 'right') {
//     animationClass = 'automator-toast-animation-top-right';
//   } else if(vertical == 'bottom' && horizontal == 'left') {
//     animationClass = 'automator-toast-animation-bottom-left';
//   } else if(vertical == 'bottom' && horizontal == 'right') {
//     animationClass = 'automator-toast-animation-bottom-right';
//   } else if(vertical == 'bottom') {
//     animationClass = 'automator-toast-animation-bottom';
//   }

//   let toastContainer = document.querySelector('[data-automator-toast-container="' + positionKey + '"]');

//   if(!toastContainer) {

//     toastContainer = document.createElement('div');
//     toastContainer.setAttribute('data-automator-toast-container', positionKey);
//     toastContainer.className = 'toast-container automator-toast-container position-fixed p-3 ' + horizontalClass + ' ' + verticalClass;
//     toastContainer.style.zIndex = '3000';

//     document.body.appendChild(toastContainer);

//   }

//   let toastBackdrop = null;

//   if(translucent == true || closeOnBackdrop == true) {

//     toastBackdrop = document.createElement('div');

//     if(translucent == true) {
//       toastBackdrop.className = 'automator-toast-backdrop automator-toast-backdrop-translucent position-fixed top-0 start-0 w-100 h-100 bg-dark bg-opacity-50 automator-toast-backdrop-hidden';
//     } else {
//       toastBackdrop.className = 'automator-toast-backdrop automator-toast-backdrop-transparent position-fixed top-0 start-0 w-100 h-100 automator-toast-backdrop-hidden';
//     }

//     toastBackdrop.setAttribute('data-automator-toast-backdrop', name);
//     toastBackdrop.style.zIndex = '2990';

//     document.body.appendChild(toastBackdrop);

//     if(closeOnBackdrop == true) {

//       toastBackdrop.addEventListener('click', function(e) {

//         e.preventDefault();

//         AutomatorCloseToastAlert(name);

//       });

//     }

//     setTimeout(function() {
//       toastBackdrop.classList.add('automator-toast-backdrop-show');
//     }, 10);

//   }

//   const toastEl = document.createElement('div');

//   toastEl.id = name;
//   toastEl.className = 'toast automator-toast-alert ' + animationClass;
//   toastEl.setAttribute('role', 'alert');
//   toastEl.setAttribute('aria-live', 'assertive');
//   toastEl.setAttribute('aria-atomic', 'true');
//   toastEl.setAttribute('data-automator-toast-name', name);
//   toastEl.setAttribute('data-automator-toast-position', positionKey);

//   toastEl.AutomatorToastCloseCallbacks = [];

//   if(closeCallback != null && typeof closeCallback === 'function') {
//     toastEl.AutomatorToastCloseCallbacks.push(closeCallback);
//   }

//   let toastHtml = '';

//   if(title != '' || close == true) {

//     toastHtml += '<div class="toast-header automator-toast-header">';
//       toastHtml += '<span class="automator-toast-header-spacer"></span>';

//       if(title != '') {
//         toastHtml += '<strong class="automator-toast-title">' + title + '</strong>';
//       } else {
//         toastHtml += '<strong class="automator-toast-title"></strong>';
//       }

//       if(close == true) {
//         toastHtml += '<button type="button" class="btn-close js-automator-toast-close" aria-label="Fechar"></button>';
//       } else {
//         toastHtml += '<span class="automator-toast-header-spacer"></span>';
//       }

//     toastHtml += '</div>';

//   }

//   toastHtml += '<div class="toast-body automator-toast-body">';
//     toastHtml += '<div class="automator-toast-message">';
//       toastHtml += message;
//     toastHtml += '</div>';

//     if(close == true && title == '') {
//       toastHtml += '<div class="mt-3 text-end automator-toast-footer">';
//         toastHtml += '<button type="button" class="btn btn-sm btn-secondary js-automator-toast-close">Fechar</button>';
//       toastHtml += '</div>';
//     }

//   toastHtml += '</div>';

//   toastEl.innerHTML = toastHtml;

//   if(vertical == 'top' && toastContainer.firstChild) {
//     toastContainer.insertBefore(toastEl, toastContainer.firstChild);
//   } else {
//     toastContainer.appendChild(toastEl);
//   }

//   const toast = new bootstrap.Toast(toastEl, {
//     autohide: false,
//     animation: false
//   });

//   toastEl.AutomatorToastInstance = toast;

//   toastEl.querySelectorAll('.js-automator-toast-close').forEach(function(btn) {

//     btn.addEventListener('click', function(e) {

//       e.preventDefault();

//       AutomatorCloseToastAlert(name);

//     });

//   });

//   toastEl.addEventListener('hidden.bs.toast', function() {

//     if(toastBackdrop != null) {
//       toastBackdrop.remove();
//     }

//     toastEl.remove();

//     if(toastContainer.children.length <= 0) {
//       toastContainer.remove();
//     }

//     if(toastEl.AutomatorToastCloseCallbacks && toastEl.AutomatorToastCloseCallbacks.length > 0) {

//       toastEl.AutomatorToastCloseCallbacks.forEach(function(fn) {

//         if(typeof fn === 'function') {
//           fn(name, toastEl, toast);
//         }

//       });

//     }

//   });

//   toast.show();

//   setTimeout(function() {
//     toastEl.classList.add('automator-toast-show');
//   }, 10);

//   if(callback != null && typeof callback === 'function') {
//     callback(name, toastEl, toast);
//   }

//   return {
//     name: name,
//     element: toastEl,
//     toast: toast
//   };

// }



// function AutomatorCloseToastAlert(name = '', callback = null) {

//   if(name == '' || name == null) {
//     return false;
//   }

//   const toastEl = document.querySelector('[data-automator-toast-name="' + name + '"]');

//   if(!toastEl) {
//     return false;
//   }

//   if(toastEl.getAttribute('data-automator-toast-closing') == 'true') {
//     return false;
//   }

//   toastEl.setAttribute('data-automator-toast-closing', 'true');

//   if(callback != null && typeof callback === 'function') {

//     if(!toastEl.AutomatorToastCloseCallbacks) {
//       toastEl.AutomatorToastCloseCallbacks = [];
//     }

//     toastEl.AutomatorToastCloseCallbacks.push(callback);

//   }

//   const toastBackdrop  = document.querySelector('[data-automator-toast-backdrop="' + name + '"]');
//   const toast          = toastEl.AutomatorToastInstance ?? bootstrap.Toast.getInstance(toastEl);

//   toastEl.classList.remove('automator-toast-show');
//   toastEl.classList.add('automator-toast-hiding');

//   if(toastBackdrop != null) {
//     toastBackdrop.classList.remove('automator-toast-backdrop-show');
//   }

//   setTimeout(function() {

//     if(toast) {
//       toast.hide();
//     } else {
//       toastEl.dispatchEvent(new Event('hidden.bs.toast'));
//     }

//   }, 300);

//   return true;

// }



// function AutomatorCreateAutoCloseToastAlert(name = '', horizontal = 'center', vertical = 'middle', translucent = true, close = true, title = '', message = '', callback = null, closeOnBackdrop = false, closeCallback = null, time = 5000) {

//   var toast = AutomatorCreateToastAlert(
//     name,
//     horizontal,
//     vertical,
//     translucent,
//     close,
//     title,
//     message,
//     null,
//     closeOnBackdrop,
//     function(toastName, toastEl, toastInstance) {

//       if(callback != null && typeof callback === 'function') {
//         callback(toastName, toastEl, toastInstance);
//       }

//       if(closeCallback != null && typeof closeCallback === 'function') {
//         closeCallback(toastName, toastEl, toastInstance);
//       }

//     }
//   );

//   if(toast && toast.name) {

//     setTimeout(function() {
//       AutomatorCloseToastAlert(toast.name);
//     }, time);

//   }

//   return toast;

// }



// function AutomatorGetCSRFToken() {

//   var token = document.querySelector('meta[name="csrf-token"]');

//   if(token) {
//     return token.getAttribute('content');
//   }

//   return '';

// }



// function AutomatorNormalizeBoolean(value) {

//   return (
//     value === true ||
//     value === 1 ||
//     value === '1' ||
//     value === 'true' ||
//     value === 'TRUE' ||
//     value === 'sim' ||
//     value === 'SIM'
//   );

// }


// function AutomatorInitBootstrapTooltips(container = document) {

//   if(typeof bootstrap === 'undefined' || typeof bootstrap.Tooltip === 'undefined') {
//     return false;
//   }

//   if(!container) {
//     container = document;
//   }

//   var tooltipTriggerList = container.querySelectorAll('[data-bs-toggle="tooltip"]');

//   tooltipTriggerList.forEach(function(tooltipTriggerEl) {

//     var currentTooltip = bootstrap.Tooltip.getInstance(tooltipTriggerEl);

//     if(currentTooltip) {
//       currentTooltip.dispose();
//     }

//     new bootstrap.Tooltip(tooltipTriggerEl);

//   });

//   return true;

// }



// function AutomatorClearModalFocus(modalEl = null) {

//   if(!modalEl) {
//     return false;
//   }

//   var activeElement = document.activeElement;

//   if(activeElement && modalEl.contains(activeElement) && typeof activeElement.blur === 'function') {
//     activeElement.blur();
//   }

//   if(document.activeElement && modalEl.contains(document.activeElement) && document.body && typeof document.body.focus === 'function') {
//     document.body.focus();
//   }

//   return true;

// }



// document.addEventListener('hide.bs.modal', function(e) {

//   if(e && e.target) {
//     AutomatorClearModalFocus(e.target);
//   }

// }, true);



// function AutomatorSystemFormGetValidateStatus(formEl = null) {

//   if(!formEl) {
//     return false;
//   }

//   if(formEl.hasAttribute('data-form-validade')) {
//     return AutomatorNormalizeBoolean(formEl.getAttribute('data-form-validade'));
//   }

//   if(formEl.hasAttribute('data-form-validate')) {
//     return AutomatorNormalizeBoolean(formEl.getAttribute('data-form-validate'));
//   }

//   return false;

// }



// function AutomatorSystemFormGetAjaxStatus(formEl = null) {

//   if(!formEl) {
//     return false;
//   }

//   if(formEl.hasAttribute('data-automator-ajax')) {
//     return AutomatorNormalizeBoolean(formEl.getAttribute('data-automator-ajax'));
//   }

//   if(formEl.hasAttribute('data-automator-ignore-ajax')) {
//     return !AutomatorNormalizeBoolean(formEl.getAttribute('data-automator-ignore-ajax'));
//   }

//   if(formEl.classList.contains('automator-ajax-ignore')) {
//     return false;
//   }

//   return true;

// }



// function AutomatorSystemFormGetSubmitter(formEl = null, event = null) {

//   if(!formEl) {
//     return null;
//   }

//   if(event && event.originalEvent && event.originalEvent.submitter) {
//     return event.originalEvent.submitter;
//   }

//   if(event && event.submitter) {
//     return event.submitter;
//   }

//   if(document.activeElement && document.activeElement.form == formEl) {
//     return document.activeElement;
//   }

//   return null;

// }



// function AutomatorSystemFormBuildFormData(formEl = null, submitterEl = null) {

//   if(!formEl) {
//     return null;
//   }

//   var formData = new FormData(formEl);

//   if(submitterEl) {

//     var submitterName  = submitterEl.getAttribute('name') || '';
//     var submitterValue = submitterEl.getAttribute('value') || '';

//     if(submitterName != '' && !formData.has(submitterName)) {
//       formData.append(submitterName, submitterValue);
//     }

//   }

//   return formData;

// }



// function AutomatorSystemFormGetResponseData(response = null, defaultTitle = 'Erro', defaultMessage = 'Não foi possível realizar esta ação.') {

//   var title   = defaultTitle;
//   var message = defaultMessage;

//   if(response && typeof response === 'object') {

//     if(response.title !== undefined && response.title !== null && response.title !== '') {
//       title = response.title;
//     }

//     if(response.message !== undefined && response.message !== null && response.message !== '') {
//       message = response.message;
//     }

//   } else if(response !== null && response !== undefined && response !== '') {
//     message = String(response);
//   }

//   return {
//     title: title,
//     message: message
//   };

// }



// function AutomatorSystemFormGetErrorData(xhr = null, defaultTitle = 'Erro', defaultMessage = 'Não foi possível realizar esta ação.') {

//   var title   = defaultTitle;
//   var message = defaultMessage;

//   if(xhr && xhr.responseJSON) {

//     if(xhr.responseJSON.title !== undefined && xhr.responseJSON.title !== null && xhr.responseJSON.title !== '') {
//       title = xhr.responseJSON.title;
//     }

//     if(xhr.responseJSON.message !== undefined && xhr.responseJSON.message !== null && xhr.responseJSON.message !== '') {
//       message = xhr.responseJSON.message;
//     }

//   } else if(xhr && xhr.responseText) {
//     message = xhr.responseText;
//   }

//   return {
//     title: title,
//     message: message
//   };

// }



// function AutomatorSystemFormCreateResponseToast(name = '', title = '', message = '', closeCallback = null, time = 5000) {

//   return AutomatorCreateAutoCloseToastAlert(
//     name,
//     'center',
//     'middle',
//     true,
//     true,
//     title,
//     message,
//     null,
//     false,
//     closeCallback,
//     time
//   );

// }



// function AutomatorSystemFormReloadPageAfterToast() {

//   AutomatorSetActionStatus(false);

//   $(window).off('beforeunload.AutomatorModalFormChanged');

//   window.location.reload();

// }



// function AutomatorSystemFormPrepareAjaxRequest(formEl = null, submitterEl = null) {

//   if(!formEl) {
//     return null;
//   }

//   var action = formEl.getAttribute('action') || window.location.href;
//   var method = formEl.getAttribute('method') || 'POST';

//   method = String(method).toUpperCase();

//   if(action == '') {
//     action = window.location.href;
//   }

//   var formData = AutomatorSystemFormBuildFormData(formEl, submitterEl);

//   if(method == 'GET') {

//     var queryString = new URLSearchParams(formData).toString();

//     if(queryString != '') {
//       action += (action.indexOf('?') >= 0 ? '&' : '?') + queryString;
//     }

//     return {
//       url: action,
//       type: 'GET',
//       data: null,
//       processData: true,
//       contentType: true
//     };

//   }

//   return {
//     url: action,
//     type: method,
//     data: formData,
//     processData: false,
//     contentType: false
//   };

// }



// function AutomatorSystemFormSubmitAjax(formEl = null, submitterEl = null, options = {}) {

//   if(!formEl) {

//     AutomatorPageLoader('hide', function() {
//       AutomatorSetActionStatus(false);
//     });

//     return false;

//   }

//   var startedActionStatus = AutomatorNormalizeBoolean(options.startedActionStatus ?? false);
//   var keepLoaderVisible   = AutomatorNormalizeBoolean(options.keepLoaderVisible ?? true);
//   var reloadOnSuccess     = AutomatorNormalizeBoolean(options.reloadOnSuccess ?? true);

//   var submitButtons = formEl.querySelectorAll('button[type="submit"], input[type="submit"]');

//   submitButtons.forEach(function(btn) {
//     btn.disabled = true;
//   });

//   function AutomatorSystemFormResetSubmitButtons() {

//     submitButtons.forEach(function(btn) {
//       btn.disabled = false;
//     });

//   }

//   function AutomatorSystemFormExecuteAjax() {

//     AutomatorSetActionStatus(true);

//     $('#page-loader').css('z-index', '1085');

//     var ajaxRequest = AutomatorSystemFormPrepareAjaxRequest(formEl, submitterEl);

//     if(!ajaxRequest) {

//       $('#page-loader').css('z-index', '');

//       AutomatorPageLoader('hide', function() {
//         AutomatorSetActionStatus(false);
//       });

//       AutomatorSystemFormResetSubmitButtons();

//       return false;

//     }

//     $.ajax({
//       url: ajaxRequest.url,
//       type: ajaxRequest.type,
//       data: ajaxRequest.data,
//       processData: ajaxRequest.processData,
//       contentType: ajaxRequest.contentType,
//       headers: {
//         'X-CSRF-TOKEN': AutomatorGetCSRFToken(),
//         'Accept': 'application/json'
//       },
//       dataType: 'json',
//       success: function(response) {

//         var responseStatus = AutomatorNormalizeBoolean(response && response.status !== undefined ? response.status : false);
//         var responseData   = null;

//         if(responseStatus == true) {

//           responseData = AutomatorSystemFormGetResponseData(response, 'Sucesso', 'Ação realizada com sucesso.');

//           formEl.setAttribute('data-submit', 'true');
//           formEl.setAttribute('data-automator-form-changed', 'false');

//           $(window).off('beforeunload.AutomatorModalFormChanged');

//           if(keepLoaderVisible == false) {
//             AutomatorPageLoader('hide');
//           }

//           var reloadExecuted = false;

//           AutomatorSystemFormCreateResponseToast(
//             'automator-form-submit-success-' + Date.now(),
//             responseData.title,
//             responseData.message,
//             function() {

//               if(reloadExecuted == true) {
//                 return;
//               }

//               reloadExecuted = true;

//               if(reloadOnSuccess == true) {
//                 AutomatorSystemFormReloadPageAfterToast();
//               } else {

//                 $('#page-loader').css('z-index', '');

//                 AutomatorPageLoader('hide', function() {
//                   AutomatorSetActionStatus(false);
//                 });

//                 AutomatorSystemFormResetSubmitButtons();

//               }

//             },
//             5000
//           );

//         } else {

//           responseData = AutomatorSystemFormGetResponseData(response, 'Atenção', 'Não foi possível realizar esta ação.');

//           formEl.setAttribute('data-submit', 'false');

//           AutomatorSystemFormCreateResponseToast(
//             'automator-form-submit-error-' + Date.now(),
//             responseData.title,
//             responseData.message,
//             function() {

//               $('#page-loader').css('z-index', '');

//               AutomatorPageLoader('hide', function() {
//                 AutomatorSetActionStatus(false);
//               });

//               AutomatorSystemFormResetSubmitButtons();

//             },
//             5000
//           );

//         }

//       },
//       error: function(xhr) {

//         var responseData = AutomatorSystemFormGetErrorData(xhr, 'Erro', 'Não foi possível realizar esta ação.');

//         formEl.setAttribute('data-submit', 'false');

//         AutomatorSystemFormCreateResponseToast(
//           'automator-form-submit-request-error-' + Date.now(),
//           responseData.title,
//           responseData.message,
//           function() {

//             $('#page-loader').css('z-index', '');

//             AutomatorPageLoader('hide', function() {
//               AutomatorSetActionStatus(false);
//             });

//             AutomatorSystemFormResetSubmitButtons();

//           },
//           5000
//         );

//       }

//     });

//   }

//   if(startedActionStatus == true) {

//     AutomatorPageLoader('show', function() {
//       AutomatorSystemFormExecuteAjax();
//     });

//   } else {

//     AutomatorGetActionStatus(function() {

//       AutomatorSetActionStatus(true, function() {

//         AutomatorPageLoader('show', function() {
//           AutomatorSystemFormExecuteAjax();
//         });

//       });

//     });

//   }

//   return true;

// }



// function AutomatorPaginationGetWrapper(el = null) {

//   if(el != null) {

//     var wrapper = el.closest('.automator-pagination-wrapper');

//     if(wrapper) {
//       return wrapper;
//     }

//   }

//   return document.querySelector('.automator-pagination-wrapper');

// }



// function AutomatorPaginationGetEnabledItems(wrapper = null) {

//   wrapper = wrapper || AutomatorPaginationGetWrapper();

//   if(!wrapper) {
//     return [];
//   }

//   return Array.from(wrapper.querySelectorAll('.pagination-select-item:not(:disabled)'));

// }



// function AutomatorPaginationGetCheckedItems(wrapper = null) {

//   wrapper = wrapper || AutomatorPaginationGetWrapper();

//   if(!wrapper) {
//     return [];
//   }

//   return Array.from(wrapper.querySelectorAll('.pagination-select-item:not(:disabled):checked'));

// }



// function AutomatorPaginationUpdateSelectionStatus(wrapper = null) {

//   wrapper = wrapper || AutomatorPaginationGetWrapper();

//   if(!wrapper) {
//     return false;
//   }

//   var selectAll = wrapper.querySelector('#pagination-select-all');
//   var btnDelete = wrapper.querySelector('.js-automator-pagination-delete-selected');

//   var enabledItems = AutomatorPaginationGetEnabledItems(wrapper);
//   var checkedItems = AutomatorPaginationGetCheckedItems(wrapper);

//   if(selectAll) {

//     if(enabledItems.length <= 0) {

//       selectAll.checked = false;
//       selectAll.indeterminate = false;
//       selectAll.disabled = true;

//     } else {

//       selectAll.disabled = false;
//       selectAll.checked = (checkedItems.length == enabledItems.length);
//       selectAll.indeterminate = (checkedItems.length > 0 && checkedItems.length < enabledItems.length);

//     }

//   }

//   if(btnDelete) {
//     btnDelete.disabled = (checkedItems.length <= 0);
//   }

//   return true;

// }



// function AutomatorPaginationSelectAll(checkbox) {

//   if(!checkbox) {
//     return false;
//   }

//   var wrapper = AutomatorPaginationGetWrapper(checkbox);

//   if(!wrapper) {
//     return false;
//   }

//   var enabledItems = AutomatorPaginationGetEnabledItems(wrapper);

//   if(enabledItems.length <= 0) {

//     checkbox.checked = false;
//     checkbox.indeterminate = false;
//     checkbox.disabled = true;

//     AutomatorPaginationUpdateSelectionStatus(wrapper);

//     return false;

//   }

//   enabledItems.forEach(function(item) {
//     item.checked = checkbox.checked;
//   });

//   AutomatorPaginationUpdateSelectionStatus(wrapper);

//   return true;

// }



// function AutomatorPaginationDeleteValidatedCallback(context = {}) {

//   console.log('Confirmação de senha validada para exclusão:', context);

//   AutomatorSetActionStatus(false);

//   return true;

// }



// function AutomatorSecurityConfirmationDestroy(modalEl, callback = null) {

//   if(!modalEl) {

//     if(callback != null && typeof callback === 'function') {
//       callback();
//     }

//     return false;

//   }

//   var modalInstance = bootstrap.Modal.getInstance(modalEl);

//   modalEl.addEventListener('hidden.bs.modal', function() {

//     if(modalInstance) {
//       modalInstance.dispose();
//     }

//     modalEl.remove();

//     if(document.querySelectorAll('.modal.show').length <= 0) {

//       document.body.classList.remove('modal-open');

//       document.querySelectorAll('.modal-backdrop').forEach(function(backdrop) {
//         backdrop.remove();
//       });

//     }

//     if(callback != null && typeof callback === 'function') {
//       callback();
//     }

//   }, { once: true });

//   if(modalInstance) {
//     AutomatorClearModalFocus(modalEl);
//     modalInstance.hide();
//   } else {

//     modalEl.remove();

//     if(callback != null && typeof callback === 'function') {
//       callback();
//     }

//   }

//   return true;

// }



// function AutomatorCreateSecurityConfirmationModal(context = {}) {

//   if(typeof bootstrap === 'undefined' || typeof bootstrap.Modal === 'undefined') {

//     AutomatorCreateToastAlert(
//       'automator-security-confirmation-bootstrap-error',
//       'center',
//       'middle',
//       true,
//       true,
//       'Erro',
//       'Bootstrap Modal não foi encontrado.',
//       null,
//       true
//     );

//     AutomatorSetActionStatus(false);

//     return false;

//   }

//   if(typeof window.AutomatorRoutes === 'undefined' || !window.AutomatorRoutes.apiAdmin) {

//     AutomatorCreateToastAlert(
//       'automator-security-confirmation-route-error',
//       'center',
//       'middle',
//       true,
//       true,
//       'Erro',
//       'A rota administrativa não foi encontrada.',
//       null,
//       true
//     );

//     AutomatorSetActionStatus(false);

//     return false;

//   }

//   var confirmModalID = 'automator-security-confirmation-modal-' + Date.now() + '-' + Math.floor(Math.random() * 999999);

//   var title = context.title || 'Confirmação de Segurança';

//   var message = context.message || 'Para realizar esta ação é necessário que seja realizado a confirmação de segurança informando sua senha. Esta ação é necessária pois é possivel que algumas informações não poderam ser restauradas depois.';

//   var keepPageLoaderOnSuccess = AutomatorNormalizeBoolean(context.keepPageLoaderOnSuccess ?? false);
//   var keepPageLoaderOnCancel  = AutomatorNormalizeBoolean(context.keepPageLoaderOnCancel ?? false);
//   var resetActionStatusOnShown = (context.resetActionStatusOnShown !== undefined) ? AutomatorNormalizeBoolean(context.resetActionStatusOnShown) : false;
//   var resetActionStatusOnCancel = (context.resetActionStatusOnCancel !== undefined) ? AutomatorNormalizeBoolean(context.resetActionStatusOnCancel) : true;
//   var resetActionStatusOnSuccess = (context.resetActionStatusOnSuccess !== undefined) ? AutomatorNormalizeBoolean(context.resetActionStatusOnSuccess) : false;

//   var confirmModalHTML = '';

//   confirmModalHTML += '<div class="modal fade automator-security-confirmation-modal" id="' + confirmModalID + '" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">';
//     confirmModalHTML += '<div class="modal-dialog modal-dialog-centered">';
//       confirmModalHTML += '<div class="modal-content">';

//         confirmModalHTML += '<div class="modal-header">';
//           confirmModalHTML += '<h5 class="modal-title w-100 text-center">' + title + '</h5>';
//         confirmModalHTML += '</div>';

//         confirmModalHTML += '<div class="modal-body">';
//           confirmModalHTML += '<form id="' + confirmModalID + '-form" method="POST" action="' + window.AutomatorRoutes.apiAdmin + '" data-submit="false" class="row">';
//             confirmModalHTML += '<p class="mb-3">';
//               confirmModalHTML += message;
//             confirmModalHTML += '</p>';

//             confirmModalHTML += '<div class="mb-3">';
//               confirmModalHTML += '<div class="input-group">';
//                 confirmModalHTML += '<div class="form-floating">';
//                   confirmModalHTML += '<input type="text" id="' + confirmModalID + '-password" name="password" class="form-control automator-input-password" autocomplete="off" />';
//                   confirmModalHTML += '<label for="' + confirmModalID + '-password" class="form-label">Senha</label>';
//                 confirmModalHTML += '</div>';
//                 confirmModalHTML += '<span class="input-group-text p-0 text-center" style="min-width: 50px;">';
//                   confirmModalHTML += '<button type="button" class="h-100 w-100 border-0 automator-tooltip-hover" data-tooltip="Exibir senha" data-show="Exibir senha" data-hide="Ocultar Senha" onclick="AutomatorPasswordInputBTN(this, ' + "'" + confirmModalID + "-password'" + ')"><i class="fa fa-eye"></i></button>';
//                 confirmModalHTML += '</span>';
//               confirmModalHTML += '</div>';
//             confirmModalHTML += '</div>';
//           confirmModalHTML += '</form>';
//         confirmModalHTML += '</div>';

//         confirmModalHTML += '<div class="modal-footer">';
//           confirmModalHTML += '<div class="row g-2 w-100">';
//             confirmModalHTML += '<div class="col-12 order-2 col-md-6 order-md-1">';
//               confirmModalHTML += '<button type="button" class="btn btn-secondary w-100 js-automator-security-confirmation-cancel">';
//                 confirmModalHTML += 'Cancelar confirmação';
//               confirmModalHTML += '</button>';
//             confirmModalHTML += '</div>';

//             confirmModalHTML += '<div class="col-12 order-1 col-md-6 order-md-2">';
//               confirmModalHTML += '<button type="submit" form="' + confirmModalID + '-form" class="btn btn-primary w-100 js-automator-security-confirmation-submit">';
//                 confirmModalHTML += 'Confirmar';
//               confirmModalHTML += '</button>';
//             confirmModalHTML += '</div>';
//           confirmModalHTML += '</div>';
//         confirmModalHTML += '</div>';

//       confirmModalHTML += '</div>';
//     confirmModalHTML += '</div>';
//   confirmModalHTML += '</div>';

//   document.body.insertAdjacentHTML('beforeend', confirmModalHTML);

//   var confirmModalEl = document.getElementById(confirmModalID);
//   var confirmFormEl  = document.getElementById(confirmModalID + '-form');
//   var passwordEl     = document.getElementById(confirmModalID + '-password');
//   var submitBtn      = confirmModalEl.querySelector('.js-automator-security-confirmation-submit');

//   var confirmModal = new bootstrap.Modal(confirmModalEl, {
//     backdrop: 'static',
//     keyboard: false,
//     focus: true
//   });

//   confirmModalEl.addEventListener('shown.bs.modal', function() {

//     confirmModalEl.style.zIndex = '1070';

//     var backdrops = document.querySelectorAll('.modal-backdrop');

//     if(backdrops.length > 0) {
//       backdrops[backdrops.length - 1].style.zIndex = '1065';
//     }

//     $('#page-loader').css('z-index', '1060');

//     if(resetActionStatusOnShown == true) {
//       AutomatorSetActionStatus(false);
//     }

//     if(passwordEl) {
//       passwordEl.focus();
//     }

//   }, { once: true });

//   confirmModalEl.querySelector('.js-automator-security-confirmation-cancel').addEventListener('click', function(e) {

//     e.preventDefault();

//     AutomatorSecurityConfirmationDestroy(confirmModalEl, function() {

//       $('#page-loader').css('z-index', '');

//       if(keepPageLoaderOnCancel == false) {
//         AutomatorPageLoader('hide');
//       }

//       if(resetActionStatusOnCancel == true) {
//         AutomatorSetActionStatus(false);
//       }

//       if(context.cancelCallback != null && typeof context.cancelCallback === 'function') {
//         context.cancelCallback(context);
//       }

//     });

//   });

//   confirmFormEl.addEventListener('submit', function(e) {

//     e.preventDefault();

//     var password = passwordEl ? passwordEl.value : '';

//     if(password == '') {

//       AutomatorCreateAutoCloseToastAlert(
//         'automator-security-confirmation-empty-password',
//         'center',
//         'middle',
//         true,
//         true,
//         'Atenção',
//         'Informe sua senha para continuar.',
//         function() {

//           if(passwordEl) {
//             passwordEl.focus();
//           }

//         },
//         false,
//         null,
//         5000
//       );

//       return false;

//     }

//     if(submitBtn) {
//       submitBtn.disabled = true;
//     }

//     AutomatorSetActionStatus(true);

//     AutomatorPageLoader('show', function() {
//       $('#page-loader').css('z-index', '1085');
//     });

//     $.ajax({
//       url: window.AutomatorRoutes.apiAdmin,
//       type: 'POST',
//       data: {
//         acao: 'validar-senha',
//         password: password
//       },
//       headers: {
//         'X-CSRF-TOKEN': AutomatorGetCSRFToken(),
//         'Accept': 'application/json'
//       },
//       dataType: 'json',
//       success: function(response) {

//         var responseTitle   = response.title || '';
//         var responseMessage = response.message || '';

//         if(response.status == true || response.status == 'true' || response.status == 1 || response.status == '1') {

//           if(AutomatorNormalizeBoolean(context.skipSuccessToast ?? false) == true) {

//             AutomatorSecurityConfirmationDestroy(confirmModalEl, function() {

//               if(keepPageLoaderOnSuccess == false) {
//                 $('#page-loader').css('z-index', '');
//               } else {
//                 $('#page-loader').css('z-index', '1085');
//               }

//               if(resetActionStatusOnSuccess == true) {
//                 AutomatorSetActionStatus(false);
//               } else {
//                 AutomatorSetActionStatus(true);
//               }

//               if(context.successCallback != null && typeof context.successCallback === 'function') {
//                 context.successCallback(context, response);
//               }

//             });

//           } else {

//             AutomatorCreateAutoCloseToastAlert(
//               'automator-security-confirmation-success',
//               'center',
//               'middle',
//               true,
//               true,
//               responseTitle,
//               responseMessage,
//               function() {

//                 AutomatorSecurityConfirmationDestroy(confirmModalEl, function() {

//                   if(keepPageLoaderOnSuccess == false) {
//                     $('#page-loader').css('z-index', '');
//                   }

//                   if(resetActionStatusOnSuccess == true) {
//                     AutomatorSetActionStatus(false);
//                   }

//                   if(context.successCallback != null && typeof context.successCallback === 'function') {
//                     context.successCallback(context, response);
//                   }

//                 });

//               },
//               false,
//               null,
//               5000
//             );

//           }

//         } else {

//           AutomatorCreateAutoCloseToastAlert(
//             'automator-security-confirmation-error',
//             'center',
//             'middle',
//             true,
//             true,
//             responseTitle,
//             responseMessage,
//             function() {

//               $('#page-loader').css('z-index', '');

//               AutomatorPageLoader('hide', function() {

//                 AutomatorSetActionStatus(false);

//                 if(passwordEl) {
//                   passwordEl.focus();
//                 }

//               });

//               if(submitBtn) {
//                 submitBtn.disabled = false;
//               }

//             },
//             false,
//             null,
//             5000
//           );

//         }

//       },
//       error: function(xhr) {

//         var responseTitle   = 'Erro';
//         var responseMessage = 'Não foi possível validar sua senha.';

//         if(xhr.responseJSON && xhr.responseJSON.title) {
//           responseTitle = xhr.responseJSON.title;
//         }

//         if(xhr.responseJSON && xhr.responseJSON.message) {
//           responseMessage = xhr.responseJSON.message;
//         } else if(xhr.responseText) {
//           responseMessage = xhr.responseText;
//         }

//         AutomatorCreateAutoCloseToastAlert(
//           'automator-security-confirmation-request-error',
//           'center',
//           'middle',
//           true,
//           true,
//           responseTitle,
//           responseMessage,
//           function() {

//             $('#page-loader').css('z-index', '');

//             AutomatorPageLoader('hide', function() {

//               AutomatorSetActionStatus(false);

//               if(passwordEl) {
//                 passwordEl.focus();
//               }

//             });

//             if(submitBtn) {
//               submitBtn.disabled = false;
//             }

//           },
//           false,
//           null,
//           5000
//         );

//       }

//     });

//     return false;

//   });

//   confirmModal.show();

//   return {
//     id: confirmModalID,
//     element: confirmModalEl,
//     modal: confirmModal,
//     form: confirmFormEl,
//     password: passwordEl,
//     context: context
//   };

// }



// function AutomatorPaginationConfirmDeleteItem(btn) {

//   if(!btn) {
//     return false;
//   }

//   AutomatorGetActionStatus(function() {

//     AutomatorSetActionStatus(true, function() {

//       var wrapper = AutomatorPaginationGetWrapper(btn);
//       var message = btn.getAttribute('data-delete-message-confirm');

//       if(!message && wrapper) {
//         message = wrapper.getAttribute('data-delete-message-confirm');
//       }

//       AutomatorCreateSecurityConfirmationModal({
//         type: 'pagination-delete-item',
//         button: btn,
//         wrapper: wrapper,
//         item_id: btn.getAttribute('data-automator-item-id'),
//         original_onclick: btn.getAttribute('data-original-onclick') || '',
//         original_href: btn.getAttribute('data-original-href') || '',
//         message: message,
//         resetActionStatusOnCancel: true,
//         resetActionStatusOnSuccess: false,
//         successCallback: function(context) {
//           AutomatorPaginationDeleteValidatedCallback(context);
//         }
//       });

//     });

//   });

//   return false;

// }



// function AutomatorPaginationSubmitDelete(btn = null) {

//   var wrapper = AutomatorPaginationGetWrapper(btn);

//   if(!wrapper) {
//     return false;
//   }

//   var checkedItems = AutomatorPaginationGetCheckedItems(wrapper);

//   if(checkedItems.length <= 0) {

//     AutomatorPaginationUpdateSelectionStatus(wrapper);

//     return false;

//   }

//   AutomatorGetActionStatus(function() {

//     AutomatorSetActionStatus(true, function() {

//       var message = '';

//       if(btn) {
//         message = btn.getAttribute('data-delete-message-confirm') || '';
//       }

//       if(!message) {
//         message = wrapper.getAttribute('data-delete-message-confirm') || '';
//       }

//       AutomatorCreateSecurityConfirmationModal({
//         type: 'pagination-delete-selected',
//         button: btn,
//         wrapper: wrapper,
//         items: checkedItems.map(function(item) {
//           return item.value;
//         }),
//         message: message,
//         resetActionStatusOnCancel: true,
//         resetActionStatusOnSuccess: false,
//         successCallback: function(context) {
//           AutomatorPaginationDeleteValidatedCallback(context);
//         }
//       });

//     });

//   });

//   return false;

// }



// function AutomatorFormSerializeCurrentState(formEl) {

//   if(!formEl) {
//     return '';
//   }

//   var fields = formEl.querySelectorAll('input, select, textarea');
//   var data   = [];

//   fields.forEach(function(field) {

//     if(field.disabled) {
//       return;
//     }

//     var name = field.getAttribute('name') || field.getAttribute('id') || '';

//     if(name == '') {
//       return;
//     }

//     var type = (field.getAttribute('type') || '').toLowerCase();

//     if(type == 'checkbox' || type == 'radio') {

//       data.push(name + '=' + (field.checked ? '1' : '0') + ':' + field.value);

//     } else if(field.tagName.toLowerCase() == 'select' && field.multiple) {

//       var values = [];

//       Array.from(field.options).forEach(function(option) {

//         if(option.selected) {
//           values.push(option.value);
//         }

//       });

//       data.push(name + '=' + values.join(','));

//     } else {

//       data.push(name + '=' + field.value);

//     }

//   });

//   return data.join('&');

// }



// function AutomatorFormHasChanged(formEl) {

//   if(!formEl) {
//     return false;
//   }

//   var initialState = formEl.getAttribute('data-automator-initial-state') || '';
//   var currentState = AutomatorFormSerializeCurrentState(formEl);

//   return initialState !== currentState;

// }



// function AutomatorUpdateModalFormChangedStatus(formEl, submitBtn = null) {

//   if(!formEl) {
//     return false;
//   }

//   var changed = AutomatorFormHasChanged(formEl);

//   formEl.setAttribute('data-automator-form-changed', changed ? 'true' : 'false');

//   if(submitBtn) {
//     submitBtn.disabled = !changed;
//   }

//   return changed;

// }



// function AutomatorInitModalFormChangeObserver(modalEl, formEl, submitBtn = null) {

//   if(!modalEl || !formEl) {
//     return false;
//   }

//   formEl.setAttribute('data-automator-initial-state', AutomatorFormSerializeCurrentState(formEl));
//   formEl.setAttribute('data-automator-form-changed', 'false');

//   if(submitBtn) {
//     submitBtn.disabled = true;
//   }

//   $(window).off('beforeunload.AutomatorModalFormChanged').on('beforeunload.AutomatorModalFormChanged', function(e) {

//     if(formEl.getAttribute('data-automator-form-changed') == 'true') {

//       var message = 'Existem alterações não salvas. Ao sair, as informações alteradas poderão ser perdidas.';

//       e.preventDefault();
//       e.returnValue = message;

//       return message;

//     }

//   });

//   formEl.addEventListener('input', function() {
//     AutomatorUpdateModalFormChangedStatus(formEl, submitBtn);
//   });

//   formEl.addEventListener('change', function() {
//     AutomatorUpdateModalFormChangedStatus(formEl, submitBtn);
//   });

//   formEl.addEventListener('keyup', function() {
//     AutomatorUpdateModalFormChangedStatus(formEl, submitBtn);
//   });

//   return true;

// }



// function AutomatorPaginationCreateModalForm(size, titulo, formulario, acao = '', id = null, callback = null) {

//   function AutomatorPaginationModalShowError(message = 'Solicitação inválida!') {

//     AutomatorPageLoader('hide', function() {

//       AutomatorCreateToastAlert(
//         'automator-pagination-form-error',
//         'center',
//         'middle',
//         true,
//         true,
//         'Erro',
//         message,
//         null,
//         true,
//         function() {
//           AutomatorSetActionStatus(false);
//         }
//       );

//     });

//   }

//   function AutomatorPaginationModalGetErrorMessage(xhr, defaultMessage = 'Solicitação inválida!') {

//     var message = defaultMessage;

//     if(xhr && xhr.responseJSON && xhr.responseJSON.message) {
//       message = xhr.responseJSON.message;
//     } else if(xhr && xhr.responseText) {
//       message = xhr.responseText;
//     }

//     return message;

//   }

//   function AutomatorPaginationModalIsTrue(value) {
//     return AutomatorNormalizeBoolean(value);
//   }

//   function AutomatorPaginationModalGetCSRFToken() {
//     return AutomatorGetCSRFToken();
//   }

//   function AutomatorPaginationModalPopulateFields(modalEl, data = {}) {

//     if(!modalEl || !data || typeof data !== 'object') {
//       return false;
//     }

//     function AutomatorPaginationModalNormalizeFieldValues(value) {

//       var values = [];

//       if(value === null || value === undefined || value === '') {
//         return values;
//       }

//       if(Array.isArray(value)) {
//         values = value;
//       } else if(typeof value === 'object') {
//         values = Object.keys(value);
//       } else if(typeof value === 'string') {

//         try {

//           var decodedValue = JSON.parse(value);

//           if(Array.isArray(decodedValue)) {
//             values = decodedValue;
//           } else if(decodedValue !== null && typeof decodedValue === 'object') {
//             values = Object.keys(decodedValue);
//           } else {
//             values = value.split(',');
//           }

//         } catch(e) {
//           values = value.split(',');
//         }

//       } else {
//         values = [value];
//       }

//       return values.map(function(item) {
//         return String(item).trim();
//       });

//     }

//     Object.keys(data).forEach(function(fieldName) {

//       var value = data[fieldName];

//       var fields = modalEl.querySelectorAll('[name="' + fieldName + '"], [name="' + fieldName + '[]"], [data-automator-field-name="' + fieldName + '"]');

//       fields.forEach(function(field) {

//         var tagName = field.tagName.toLowerCase();
//         var type    = (field.getAttribute('type') || '').toLowerCase();

//         if(type == 'checkbox') {

//           var checkboxValues = AutomatorPaginationModalNormalizeFieldValues(value);

//           if(checkboxValues.length > 0) {
//             field.checked = checkboxValues.includes(String(field.value));
//           } else {
//             field.checked = false;
//           }

//         } else if(type == 'radio') {

//           field.checked = (String(field.value) == String(value));

//         } else if(tagName == 'select' && field.multiple) {

//           var selectedValues = AutomatorPaginationModalNormalizeFieldValues(value);

//           Array.from(field.options).forEach(function(option) {
//             option.selected = selectedValues.includes(String(option.value));
//           });

//         } else if(tagName == 'textarea' && field.classList.contains('automator-editor')) {

//           /*
//           |--------------------------------------------------------------------------
//           | Editor field — set value on the hidden textarea AND update the
//           | live editor instance (visual + code panes) so the content is not lost.
//           |
//           | Two scenarios are handled:
//           |   A) Editor already rendered: instance exists in window.AutomatorEditors
//           |      → update visual/code panes directly via the stored references.
//           |   B) Editor not yet rendered (populate ran before AutomatorEditorRender):
//           |      → just set the textarea value; AutomatorEditorRender will pick it
//           |        up normally when it runs afterwards.
//           |--------------------------------------------------------------------------
//           */

//           var editorContent = (value !== null && value !== undefined) ? String(value) : '';

//           // Always keep the source textarea in sync so AutomatorEditorRender can
//           // read the correct value if the editor has not been initialised yet.
//           field.value = editorContent;

//           // If the editor instance is already live, push the content into it.
//           var editorId = field.getAttribute('data-automator-editor-id') || field.getAttribute('id') || '';

//           if(editorId && window.AutomatorEditors && window.AutomatorEditors[editorId]) {

//             var editorInstance = window.AutomatorEditors[editorId];

//             if(editorInstance.visual && editorInstance.visual.length) {
//               editorInstance.visual.html(editorContent);
//             }

//             if(editorInstance.code && editorInstance.code.length) {
//               editorInstance.code.val(editorContent);
//             }

//           }

//         } else {

//           field.value = (value !== null && value !== undefined) ? value : '';

//         }

//         field.dispatchEvent(new Event('change', { bubbles: true }));

//       });

//     });

//     return true;

//   }

//   function AutomatorPaginationModalDestroy(modalEl, resetActionStatus = true, callbackDestroy = null) {

//     if(!modalEl) {

//       if(resetActionStatus == true) {
//         AutomatorSetActionStatus(false);
//       }

//       if(callbackDestroy != null && typeof callbackDestroy === 'function') {
//         callbackDestroy();
//       }

//       return false;

//     }

//     var formEl = modalEl.querySelector('form');

//     if(formEl && formEl.getAttribute('data-automator-form-changed') == 'true') {

//       var confirmClose = confirm('Existem alterações não salvas. Deseja realmente fechar este formulário?');

//       if(confirmClose == false) {
//         return false;
//       }

//     }

//     var modalInstance = bootstrap.Modal.getInstance(modalEl);

//     modalEl.addEventListener('hidden.bs.modal', function() {

//       if(modalInstance) {
//         modalInstance.dispose();
//       }

//       modalEl.remove();

//       if(
//         window.AutomatorPaginationCurrentModalForm &&
//         window.AutomatorPaginationCurrentModalForm.modalEl &&
//         window.AutomatorPaginationCurrentModalForm.modalEl.id == modalEl.id
//       ) {
//         window.AutomatorPaginationCurrentModalForm = null;
//       }

//       if(document.querySelectorAll('.modal.show').length <= 0) {

//         document.body.classList.remove('modal-open');

//         document.querySelectorAll('.modal-backdrop').forEach(function(backdrop) {
//           backdrop.remove();
//         });

//       }

//       $(window).off('beforeunload.AutomatorModalFormChanged');

//       if(resetActionStatus == true) {
//         AutomatorSetActionStatus(false);
//       }

//       if(callbackDestroy != null && typeof callbackDestroy === 'function') {
//         callbackDestroy();
//       }

//     }, { once: true });

//     if(modalInstance) {
//       modalInstance.hide();
//     } else {

//       modalEl.remove();

//       $(window).off('beforeunload.AutomatorModalFormChanged');

//       if(resetActionStatus == true) {
//         AutomatorSetActionStatus(false);
//       }

//     }

//     return true;

//   }

//   function AutomatorPaginationModalCreateSecurityConfirmation(parentModalEl = null) {

//     var parentFormEl = null;

//     if(parentModalEl) {
//       parentFormEl = parentModalEl.querySelector('form');
//     }

//     var message = 'Para realizar esta ação é necessário que seja realizado a confirmação de segurança informando sua senha. Esta ação é necessária pois é possivel que algumas informações não poderam ser restauradas depois.';

//     AutomatorCreateSecurityConfirmationModal({
//       type: 'modal-form-submit',
//       parentModalEl: parentModalEl,
//       parentFormEl: parentFormEl,
//       message: message,
//       keepPageLoaderOnSuccess: true,
//       keepPageLoaderOnCancel: false,
//       skipSuccessToast: true,
//       resetActionStatusOnShown: true,
//       resetActionStatusOnCancel: true,
//       resetActionStatusOnSuccess: false,
//       cancelCallback: function() {
//         $('#page-loader').css('z-index', '');
//       },
//       successCallback: function(context) {

//         $('#page-loader').css('z-index', '1085');

//         if(context.parentFormEl) {

//           context.parentFormEl.setAttribute('data-submit', 'false');
//           context.parentFormEl.setAttribute('data-automator-form-changed', 'false');

//           $(window).off('beforeunload.AutomatorModalFormChanged');

//           AutomatorSystemFormSubmitAjax(context.parentFormEl, null, {
//             startedActionStatus: true,
//             keepLoaderVisible: true,
//             reloadOnSuccess: true
//           });

//         }

//       }
//     });

//   }

//   function AutomatorPaginationModalCreateForm(response, recordData = {}) {

//     var modalID = 'automator-pagination-form-modal-' + Date.now() + '-' + Math.floor(Math.random() * 999999);

//     var formHTML = response.html || '';
//     var formData = response.form || {};

//     var formValidate = AutomatorPaginationModalIsTrue(formData.tbl_sys_form_validate ?? false);

//     var modalHTML = '';

//     modalHTML += '<div class="modal fade automator-pagination-form-modal" id="' + modalID + '" tabindex="-1" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">';
//       modalHTML += '<div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">';
//         modalHTML += '<div class="modal-content">';

//           modalHTML += '<div class="modal-header">';
//             modalHTML += '<h5 class="modal-title w-100 text-center">' + titulo + '</h5>';
//             modalHTML += '<button type="button" class="btn-close js-automator-pagination-modal-close" aria-label="Fechar"></button>';
//           modalHTML += '</div>';

//           modalHTML += '<div class="modal-body">';
//             modalHTML += '<form id="' + modalID + '-form" class="row" method="" action="" data-submit="false" data-form-validate="' + (formValidate ? 'true' : 'false') + '">';
//               modalHTML += formHTML;
//             modalHTML += '</form>';
//           modalHTML += '</div>';

//           modalHTML += '<div class="modal-footer">';
//             modalHTML += '<div class="row g-2 w-100">';
//               modalHTML += '<div class="col-12 order-2 col-md-6 order-md-1">';
//                 modalHTML += '<button type="button" class="btn btn-secondary w-100 js-automator-pagination-modal-cancel">Cancelar</button>';
//               modalHTML += '</div>';

//               modalHTML += '<div class="col-12 order-1 col-md-6 order-md-2">';
//                 modalHTML += '<button type="submit" form="' + modalID + '-form" class="btn btn-primary w-100 js-automator-pagination-modal-submit" disabled>Salvar</button>';
//               modalHTML += '</div>';
//             modalHTML += '</div>';
//           modalHTML += '</div>';

//         modalHTML += '</div>';
//       modalHTML += '</div>';
//     modalHTML += '</div>';

//     document.body.insertAdjacentHTML('beforeend', modalHTML);

//     var modalEl  = document.getElementById(modalID);
//     var formEl   = document.getElementById(modalID + '-form');
//     var submitEl = modalEl.querySelector('.js-automator-pagination-modal-submit');

//     var modal = new bootstrap.Modal(modalEl, {
//       backdrop: 'static',
//       keyboard: false,
//       focus: true
//     });

//     modalEl.querySelector('.js-automator-pagination-modal-close').addEventListener('click', function(e) {

//       e.preventDefault();

//       AutomatorPaginationModalDestroy(modalEl, true);

//     });

//     modalEl.querySelector('.js-automator-pagination-modal-cancel').addEventListener('click', function(e) {

//       e.preventDefault();

//       AutomatorPaginationModalDestroy(modalEl, true);

//     });

//     formEl.addEventListener('submit', function(e) {

//       if(formEl.getAttribute('data-submit') == 'true') {
//         return true;
//       }

//       e.preventDefault();

//       if(!AutomatorFormHasChanged(formEl)) {

//         if(submitEl) {
//           submitEl.disabled = true;
//         }

//         return false;

//       }

//       if(formValidate == true) {

//         AutomatorSetActionStatus(true, function() {

//           AutomatorPageLoader('show', function() {

//             $('#page-loader').css('z-index', '1060');

//             AutomatorPaginationModalCreateSecurityConfirmation(modalEl);

//           });

//         });

//         return false;

//       }

//       AutomatorSystemFormSubmitAjax(formEl, null, {
//         startedActionStatus: false,
//         keepLoaderVisible: true,
//         reloadOnSuccess: true
//       });

//       return false;

//     });

//     modalEl.addEventListener('shown.bs.modal', function() {

//       /*
//       |--------------------------------------------------------------------------
//       | Populate fields FIRST, before AutomatorEditorAutoRender runs.
//       |
//       | AutomatorEditorRender reads the textarea value at init time.
//       | If populate runs after the editor is already rendered the visual pane
//       | will be blank because the editor hides the original textarea and only
//       | the editor API can update the visual content afterwards.
//       |
//       | Correct order:
//       |   1. Populate fields (textarea.value = recordData value)
//       |   2. Render editors (reads the now-correct textarea value)
//       |   3. Everything else (tooltips, change observer, action status)
//       |--------------------------------------------------------------------------
//       */

//       if(recordData && typeof recordData === 'object') {
//         AutomatorPaginationModalPopulateFields(modalEl, recordData);
//       }

//       // Render editors AFTER populate so they read the correct textarea values.
//       AutomatorEditorAutoRender(modalEl);

//       if(callback != null && typeof callback === 'function') {

//         window.AutomatorPaginationCurrentModalForm = {
//           modalID: modalID,
//           formID: modalID + '-form',
//           modalEl: modalEl,
//           formEl: formEl,
//           modal: modal,
//           response: response,
//           recordData: recordData
//         };

//         callback(response, modalEl, modal, recordData);

//       }

//       AutomatorInitBootstrapTooltips(modalEl);

//       setTimeout(function() {

//         AutomatorInitBootstrapTooltips(modalEl);

//         AutomatorInitModalFormChangeObserver(modalEl, formEl, submitEl);

//         AutomatorSetActionStatus(false);

//       }, 100);

//     }, { once: true });

//     modal.show();

//     return {
//       id: modalID,
//       element: modalEl,
//       modal: modal,
//       response: response,
//       data: recordData
//     };

//   }

//   function AutomatorPaginationModalGetRecordData(response) {

//     var hasAction = (acao !== null && acao !== undefined && acao !== '');
//     var hasID     = (id !== null && id !== undefined && id !== '');

//     if(hasAction == false || hasID == false) {

//       AutomatorPageLoader('hide', function() {
//         AutomatorPaginationModalCreateForm(response, {});
//       });

//       return;

//     }

//     if(typeof window.AutomatorPaginationRoutes === 'undefined' || !window.AutomatorPaginationRoutes[acao]) {

//       AutomatorPaginationModalShowError('A rota da ação "' + acao + '" não foi encontrada.');

//       return;

//     }

//     var actionURL = window.AutomatorPaginationRoutes[acao];

//     actionURL = actionURL.replace('#ID#', id);

//     $.ajax({
//       url: actionURL,
//       type: 'GET',
//       headers: {
//         'X-CSRF-TOKEN': AutomatorPaginationModalGetCSRFToken()
//       },
//       dataType: 'json',
//       success: function(recordResponse) {

//         if(recordResponse.status == true) {

//           var recordData = {};

//           if(recordResponse.data && typeof recordResponse.data === 'object') {
//             recordData = recordResponse.data;
//           } else if(recordResponse.item && typeof recordResponse.item === 'object') {
//             recordData = recordResponse.item;
//           } else if(recordResponse.values && typeof recordResponse.values === 'object') {
//             recordData = recordResponse.values;
//           }

//           AutomatorPageLoader('hide', function() {
//             AutomatorPaginationModalCreateForm(response, recordData);
//           });

//         } else {

//           var message = 'Solicitação inválida!';

//           if(recordResponse.message) {
//             message = recordResponse.message;
//           }

//           AutomatorPaginationModalShowError(message);

//         }

//       },
//       error: function(xhr) {
//         AutomatorPaginationModalShowError(AutomatorPaginationModalGetErrorMessage(xhr));
//       }
//     });

//   }

//   AutomatorGetActionStatus(function() {

//     AutomatorSetActionStatus(true, function() {

//       AutomatorPageLoader('show', function() {

//         if(typeof bootstrap === 'undefined' || typeof bootstrap.Modal === 'undefined') {

//           AutomatorPaginationModalShowError('Bootstrap Modal não foi encontrado.');

//           return;

//         }

//         console.log(window.AutomatorRoutes);
//         if(typeof window.AutomatorRoutes === 'undefined' || !window.AutomatorRoutes.apiForms) {

//           AutomatorPaginationModalShowError('A rota de formulários não foi encontrada.');

//           return;

//         }

//         var formURL = window.AutomatorRoutes.apiForms;

//         formURL = formURL.replace('#ID#', formulario);

//         $.ajax({
//           url: formURL,
//           type: 'GET',
//           headers: {
//             'X-CSRF-TOKEN': AutomatorPaginationModalGetCSRFToken()
//           },
//           dataType: 'json',
//           success: function(response) {

//             if(response.status == true) {
//               AutomatorPaginationModalGetRecordData(response);
//             } else {

//               var message = 'Solicitação inválida!';

//               if(response.message) {
//                 message = response.message;
//               }

//               AutomatorPaginationModalShowError(message);

//             }

//           },
//           error: function(xhr) {
//             AutomatorPaginationModalShowError(AutomatorPaginationModalGetErrorMessage(xhr));
//           }
//         });

//       });

//     });

//   });

// }



// function AutomatorPaginationCreateModalFormCallBack(args = []) {

//   if((args.length) >= 1) {

//     var vars = args[0];

//     var currentForm = window.AutomatorPaginationCurrentModalForm ?? null;

//     if(currentForm == null || !currentForm.formEl) {

//       console.error('Nenhum formulário de modal foi encontrado para executar o callback.');

//       return false;

//     }

//     var formEl  = currentForm.formEl;
//     var modalEl = currentForm.modalEl;

//     if(vars.method) {
//       formEl.setAttribute('method', vars.method);
//     }

//     if(vars.action !== undefined) {
//       formEl.setAttribute('action', window.AutomatorPaginationRoutes[vars.action]);
//     }

//     formEl.setAttribute('data-automator-modal-id', currentForm.modalID);
//     formEl.setAttribute('data-automator-form-id', currentForm.formID);

//     $.each(vars, function(index, value) {

//       if(index == 'method' || index == 'action') {
//         return;
//       }

//       var input = formEl.querySelector('[name="' + index + '"]');

//       if(!input) {

//         input = document.createElement('input');

//         input.type = 'hidden';
//         input.name = index;

//         formEl.appendChild(input);

//       }

//       input.value = value;

//     });

//     formEl.setAttribute('data-automator-initial-state', AutomatorFormSerializeCurrentState(formEl));
//     formEl.setAttribute('data-automator-form-changed', 'false');

//     var submitBtn = modalEl.querySelector('.js-automator-pagination-modal-submit');

//     if(submitBtn) {
//       submitBtn.disabled = true;
//     }

//     console.log('Formulário afetado:', formEl);
//     console.log('Modal afetado:', modalEl);
//     console.log('Argumentos:', vars);

//     return {
//       vars: vars,
//       formEl: formEl,
//       modalEl: modalEl,
//       currentForm: currentForm
//     };

//   }

//   return false;

// }



// function AutomatorSystemPageFormCreateSecurityConfirmation(formEl = null, submitterEl = null) {

//   if(!formEl) {
//     return false;
//   }

//   var message = formEl.getAttribute('data-security-confirmation-message') || formEl.getAttribute('data-confirmation-message') || 'Para realizar esta ação é necessário que seja realizado a confirmação de segurança informando sua senha. Esta ação é necessária pois é possivel que algumas informações não poderam ser restauradas depois.';

//   AutomatorCreateSecurityConfirmationModal({
//     type: 'page-form-submit',
//     parentFormEl: formEl,
//     submitterEl: submitterEl,
//     message: message,
//     keepPageLoaderOnSuccess: true,
//     keepPageLoaderOnCancel: false,
//     skipSuccessToast: true,
//     resetActionStatusOnShown: true,
//     resetActionStatusOnCancel: true,
//     resetActionStatusOnSuccess: false,
//     cancelCallback: function(context) {

//       $('#page-loader').css('z-index', '');

//       if(context.parentFormEl) {
//         context.parentFormEl.setAttribute('data-submit', 'false');
//       }

//     },
//     successCallback: function(context) {

//       $('#page-loader').css('z-index', '1085');

//       if(context.parentFormEl) {

//         context.parentFormEl.setAttribute('data-submit', 'false');

//         AutomatorSystemFormSubmitAjax(context.parentFormEl, context.submitterEl, {
//           startedActionStatus: true,
//           keepLoaderVisible: true,
//           reloadOnSuccess: true
//         });

//       }

//     }
//   });

//   return true;

// }



// function AutomatorInitSystemAjaxForms() {

//   var selector = 'form:not(.automator-ajax-ignore):not([data-automator-ignore-ajax="true"])';

//   $(document).off('submit.AutomatorSystemAjaxForms', selector).on('submit.AutomatorSystemAjaxForms', selector, function(e) {

//     var formEl = this;

//     if(formEl.closest('.automator-security-confirmation-modal')) {
//       return true;
//     }

//     if(formEl.closest('.automator-pagination-form-modal')) {
//       return true;
//     }

//     if(AutomatorSystemFormGetAjaxStatus(formEl) == false) {
//       return true;
//     }

//     e.preventDefault();

//     var submitterEl  = AutomatorSystemFormGetSubmitter(formEl, e);
//     var formValidate = AutomatorSystemFormGetValidateStatus(formEl);

//     if(formValidate == true) {

//       AutomatorGetActionStatus(function() {

//         AutomatorSetActionStatus(true, function() {

//           AutomatorPageLoader('show', function() {

//             $('#page-loader').css('z-index', '1060');

//             AutomatorSystemPageFormCreateSecurityConfirmation(formEl, submitterEl);

//           });

//         });

//       });

//       return false;

//     }

//     AutomatorSystemFormSubmitAjax(formEl, submitterEl, {
//       startedActionStatus: false,
//       keepLoaderVisible: true,
//       reloadOnSuccess: true
//     });

//     return false;

//   });

//   return true;

// }



// $(document).on('click change', '#pagination-select-all', function() {

//   AutomatorPaginationSelectAll(this);

// });



// $(document).on('change', '.pagination-select-item', function() {

//   var wrapper = AutomatorPaginationGetWrapper(this);

//   AutomatorPaginationUpdateSelectionStatus(wrapper);

// });



// $(document).on('click', '.automator-disabled-selection-label', function(e) {


//   e.preventDefault();
//   e.stopPropagation();

//   return false;


// });



// $(document).on('change', '.automator-disabled-selection', function(e) {


//   e.preventDefault();

//   var originalChecked = this.getAttribute('data-automator-original-checked');

//   this.checked = (originalChecked == 'true');

//   return false;


// });



// $(function() {


//   AutomatorInitBootstrapTooltips(document);

//   AutomatorInitSystemAjaxForms();

//   document.querySelectorAll('.automator-pagination-wrapper').forEach(function(wrapper) {

//     AutomatorPaginationUpdateSelectionStatus(wrapper);

//   });


// });


// (function ($) {

//     window.AutomatorEditors = window.AutomatorEditors || {};

//     window.AutomatorEditorDefaults = {

//         height: 350,
//         minHeight: 200,
//         maxHeight: null,

//         mode: 'visual',

//         placeholder: 'Digite aqui...',

//         toolbar: [],

//         debug: false,

//         allowHtml: true,

//         fullscreen: true,

//         callbacks: {

//             onInit: null,
//             onChange: null,
//             onModeChange: null,
//             onSelectionChange: null,
//             beforeCommand: null,
//             afterCommand: null
//         }
//     };

//     /**
//      * Renderiza um ou vários editores
//      *
//      * @param selector
//      * @param options
//      * @returns {*}
//      */
//     window.AutomatorEditorRender = function (
//         selector = '.automator-editor',
//         options = {}
//     ) {

//         let elements = $();

//         /*
//         |--------------------------------------------------------------------------
//         | Resolve selector
//         |--------------------------------------------------------------------------
//         */


//         if (
//             selector instanceof jQuery
//         ) {

//             if (
//                 selector.hasClass(
//                     'automator-editor'
//                 )
//             ) {

//                 elements = selector;

//             } else {

//                 elements =
//                     selector.find(
//                         '.automator-editor'
//                     );
//             }

//         } else if (
//             selector instanceof HTMLElement
//         ) {

//             let $el =
//                 $(selector);

//             if (
//                 $el.hasClass(
//                     'automator-editor'
//                 )
//             ) {

//                 elements = $el;

//             } else {

//                 elements =
//                     $el.find(
//                         '.automator-editor'
//                     );
//             }

//         } else if (
//             typeof selector ===
//             'string'
//         ) {

//             elements =
//                 $(selector);

//         } else {

//             elements =
//                 $('.automator-editor');
//         }

//         if (!elements.length) {

//             return [];
//         }

//         let instances = [];

//         /*
//         |--------------------------------------------------------------------------
//         | Multi instance
//         |--------------------------------------------------------------------------
//         */

//         elements.each(function () {

//             let $source = $(this);

//             /*
//             |--------------------------------------------------------------------------
//             | Prevent double render
//             |--------------------------------------------------------------------------
//             */

//             if (
//                 $source.data(
//                     'automator-editor-loaded'
//                 )
//             ) {
//                 return true;
//             }

//             /*
//             |--------------------------------------------------------------------------
//             | Unique ID
//             |--------------------------------------------------------------------------
//             */

//             let editorId =
//                 $source.attr('id')
//                 ||
//                 'automator-editor-' +
//                 Math.random()
//                     .toString(36)
//                     .substring(2, 15);

//             $source.attr(
//                 'data-automator-editor-id',
//                 editorId
//             );

//             /*
//             |--------------------------------------------------------------------------
//             | Config
//             |--------------------------------------------------------------------------
//             */

//             let config = $.extend(
//                 true,
//                 {},
//                 window.AutomatorEditorDefaults,
//                 options
//             );

//             /*
//             |--------------------------------------------------------------------------
//             | Read data attributes
//             |--------------------------------------------------------------------------
//             */

//             if (
//                 $source.data('height')
//             ) {

//                 config.height =
//                     parseInt(
//                         $source.data('height')
//                     );
//             }

//             if (
//                 $source.data('mode')
//             ) {

//                 config.mode =
//                     $source.data('mode');
//             }

//             if (
//                 $source.data('placeholder')
//             ) {

//                 config.placeholder =
//                     $source.data(
//                         'placeholder'
//                     );
//             }

//             /*
//             |--------------------------------------------------------------------------
//             | Original value
//             |--------------------------------------------------------------------------
//             */

//             let originalContent = '';

//             if (
//                 $source.is('textarea')
//             ) {

//                 /*
//                 |--------------------------------------------------------------------------
//                 | Try jQuery value
//                 |--------------------------------------------------------------------------
//                 */

//                 originalContent =
//                     $source.val();

//                 /*
//                 |--------------------------------------------------------------------------
//                 | Fallback textarea innerHTML/text
//                 |--------------------------------------------------------------------------
//                 */

//                 if (
//                     originalContent ===
//                     null
//                     ||
//                     originalContent ===
//                     undefined
//                     ||
//                     String(
//                         originalContent
//                     ).trim() === ''
//                 ) {

//                     originalContent =
//                         $source[0]
//                         ?.value
//                         ||
//                         $source.text()
//                         ||
//                         $source.html()
//                         ||
//                         '';
//                 }

//             } else {

//                 originalContent =
//                     $source.html()
//                     ||
//                     $source.text()
//                     ||
//                     '';
//             }

//             /*
//             |--------------------------------------------------------------------------
//             | Normalize
//             |--------------------------------------------------------------------------
//             */

//             originalContent =
//                 String(
//                     originalContent
//                 );


//             /*
//             |--------------------------------------------------------------------------
//             | Wrapper
//             |--------------------------------------------------------------------------
//             */

//             let $wrapper = $(`
//                 <div 
//                     class="automator-editor-wrapper card"
//                     data-editor-id="${editorId}"
//                 >
//                     <div 
//                         class="automator-editor-toolbar border-bottom"
//                     ></div>

//                     <div 
//                         class="automator-editor-body"
//                     >
//                         <div
//                             class="automator-editor-visual"
//                             contenteditable="true"
//                         ></div>

//                         <textarea
//                             class="automator-editor-code form-control d-none"
//                         ></textarea>
//                     </div>
//                 </div>
//             `);

//             /*
//             |--------------------------------------------------------------------------
//             | Apply height
//             |--------------------------------------------------------------------------
//             */

//             $wrapper.find(
//                 '.automator-editor-body'
//             ).css({

//                 height:
//                     config.height +
//                     'px',

//                 minHeight:
//                     config.minHeight +
//                     'px'
//             });

//             if (
//                 config.maxHeight
//             ) {

//                 $wrapper.find(
//                     '.automator-editor-body'
//                 ).css({
//                     maxHeight:
//                         config.maxHeight +
//                         'px'
//                 });
//             }

//             /*
//             |--------------------------------------------------------------------------
//             | Replace DOM
//             |--------------------------------------------------------------------------
//             */

//             $source.after(
//                 $wrapper
//             );

//             /*
//             |--------------------------------------------------------------------------
//             | Hide original element
//             |--------------------------------------------------------------------------
//             */

//             $source.hide();

//             /*
//             |--------------------------------------------------------------------------
//             | References
//             |--------------------------------------------------------------------------
//             */

//             let $visual =
//                 $wrapper.find(
//                     '.automator-editor-visual'
//                 );

//             let $code =
//                 $wrapper.find(
//                     '.automator-editor-code'
//                 );

//             let $toolbar =
//                 $wrapper.find(
//                     '.automator-editor-toolbar'
//                 );

//             /*
//             |--------------------------------------------------------------------------
//             | Set content
//             |--------------------------------------------------------------------------
//             */

//             $visual.html(
//                 originalContent
//             );

//             $code.val(
//                 originalContent
//             );

//             /*
//             |--------------------------------------------------------------------------
//             | Placeholder
//             |--------------------------------------------------------------------------
//             */

//             $visual.attr(
//                 'data-placeholder',
//                 config.placeholder
//             );

//             /*
//             |--------------------------------------------------------------------------
//             | Initial mode
//             |--------------------------------------------------------------------------
//             */

//             if (
//                 config.mode ===
//                 'code'
//             ) {

//                 $visual.addClass(
//                     'd-none'
//                 );

//                 $code.removeClass(
//                     'd-none'
//                 );

//             } else {

//                 $code.addClass(
//                     'd-none'
//                 );

//                 $visual.removeClass(
//                     'd-none'
//                 );
//             }

//             /*
//             |--------------------------------------------------------------------------
//             | Registry
//             |--------------------------------------------------------------------------
//             */

//             let editorObject = {

//                 id: editorId,

//                 config: config,

//                 source: $source,

//                 wrapper: $wrapper,

//                 toolbar: $toolbar,

//                 visual: $visual,

//                 code: $code,

//                 mode:
//                     config.mode,

//                 isRendered: true,

//                 selection:
//                     null
//             };

//             window.AutomatorEditors[
//                 editorId
//             ] = editorObject;

//             /*
//             |--------------------------------------------------------------------------
//             | Flag initialized
//             |--------------------------------------------------------------------------
//             */

//             $source.data(
//                 'automator-editor-loaded',
//                 true
//             );

//             /*
//             |--------------------------------------------------------------------------
//             | Trigger init callback
//             |--------------------------------------------------------------------------
//             */

//             if (
//                 typeof config
//                     .callbacks
//                     .onInit ===
//                 'function'
//             ) {

//                 config.callbacks
//                     .onInit(
//                         editorObject
//                     );
//             }

//             /*
//             |--------------------------------------------------------------------------
//             | Debug
//             |--------------------------------------------------------------------------
//             */

//             if (
//                 config.debug
//             ) {

//                 console.log(
//                     'AutomatorEditor initialized:',
//                     editorObject
//                 );
//             }

//             instances.push(
//                 editorObject
//             );

//             $(document).trigger(
//               'automator-editor-rendered',
//               [editorObject]
//             );

//         });

//         return instances;
//     };

// })(jQuery);


// (function ($) {

//     /*
//     |--------------------------------------------------------------------------
//     | Default toolbar
//     |--------------------------------------------------------------------------
//     */

//     // window.AutomatorEditorToolbarDefaults = [

//     //     {
//     //         type: 'group',
//     //         items: [

//     //             {
//     //                 type: 'button',
//     //                 command: 'bold',
//     //                 icon: 'fa fa-bold',
//     //                 title: 'Negrito'
//     //             },

//     //             {
//     //                 type: 'button',
//     //                 command: 'italic',
//     //                 icon: 'fa fa-italic',
//     //                 title: 'Itálico'
//     //             },

//     //             {
//     //                 type: 'button',
//     //                 command: 'underline',
//     //                 icon: 'fa fa-underline',
//     //                 title: 'Sublinhado'
//     //             },

//     //             {
//     //                 type: 'button',
//     //                 command: 'strikeThrough',
//     //                 icon: 'fa fa-strikethrough',
//     //                 title: 'Tachado'
//     //             }
//     //         ]
//     //     },

//     //     {
//     //         type: 'group',
//     //         items: [

//     //             {
//     //                 type: 'select',
//     //                 command: 'formatBlock',
//     //                 title: 'Formato',

//     //                 options: [
//     //                     {
//     //                         label: 'Parágrafo',
//     //                         value: 'P'
//     //                     },
//     //                     {
//     //                         label: 'Título H1',
//     //                         value: 'H1'
//     //                     },
//     //                     {
//     //                         label: 'Título H2',
//     //                         value: 'H2'
//     //                     },
//     //                     {
//     //                         label: 'Título H3',
//     //                         value: 'H3'
//     //                     },
//     //                     {
//     //                         label: 'Título H4',
//     //                         value: 'H4'
//     //                     }
//     //                 ]
//     //             },

//     //             {
//     //                 type: 'select',
//     //                 command: 'fontSize',
//     //                 title: 'Tamanho',

//     //                 options: [
//     //                     { label: '10px', value: '1' },
//     //                     { label: '12px', value: '2' },
//     //                     { label: '14px', value: '3' },
//     //                     { label: '18px', value: '4' },
//     //                     { label: '24px', value: '5' },
//     //                     { label: '32px', value: '6' },
//     //                     { label: '48px', value: '7' }
//     //                 ]
//     //             }
//     //         ]
//     //     },

//     //     {
//     //         type: 'group',
//     //         items: [

//     //             {
//     //                 type: 'button',
//     //                 command: 'justifyLeft',
//     //                 icon: 'fa fa-align-left',
//     //                 title: 'Alinhar esquerda'
//     //             },

//     //             {
//     //                 type: 'button',
//     //                 command: 'justifyCenter',
//     //                 icon: 'fa fa-align-center',
//     //                 title: 'Centralizar'
//     //             },

//     //             {
//     //                 type: 'button',
//     //                 command: 'justifyRight',
//     //                 icon: 'fa fa-align-right',
//     //                 title: 'Alinhar direita'
//     //             }
//     //         ]
//     //     },

//     //     {
//     //         type: 'group',
//     //         items: [

//     //             {
//     //                 type: 'button',
//     //                 command: 'insertUnorderedList',
//     //                 icon: 'fa fa-list',
//     //                 title: 'Lista'
//     //             },

//     //             {
//     //                 type: 'button',
//     //                 command: 'insertOrderedList',
//     //                 icon: 'fa fa-list-ol',
//     //                 title: 'Lista numerada'
//     //             }
//     //         ]
//     //     },

//     //     {
//     //         type: 'group',
//     //         items: [

//     //             {
//     //                 type: 'button',
//     //                 command: 'undo',
//     //                 icon: 'fa fa-rotate-left',
//     //                 title: 'Desfazer'
//     //             },

//     //             {
//     //                 type: 'button',
//     //                 command: 'redo',
//     //                 icon: 'fa fa-rotate-right',
//     //                 title: 'Refazer'
//     //             }
//     //         ]
//     //     },

//     //     {
//     //         type: 'group',
//     //         items: [

//     //             {
//     //                 type: 'button',
//     //                 command: 'toggleCode',
//     //                 icon: 'fa fa-code',
//     //                 title: 'Modo código'
//     //             }
//     //         ]
//     //     }
//     // ];

//     window.AutomatorEditorToolbarDefaults = [

//         /*
//         |--------------------------------------------------------------------------
//         | TEXT STYLE
//         |--------------------------------------------------------------------------
//         */

//         {
//             type: 'group',
//             items: [

//                 {
//                     type: 'button',
//                     command: 'bold',
//                     icon: 'fas fa-bold',
//                     title: 'Negrito'
//                 },

//                 {
//                     type: 'button',
//                     command: 'italic',
//                     icon: 'fas fa-italic',
//                     title: 'Itálico'
//                 },

//                 {
//                     type: 'button',
//                     command: 'underline',
//                     icon: 'fas fa-underline',
//                     title: 'Sublinhado'
//                 },

//                 {
//                     type: 'button',
//                     command: 'strikeThrough',
//                     icon: 'fas fa-strikethrough',
//                     title: 'Tachado'
//                 }
//             ]
//         },

//         /*
//         |--------------------------------------------------------------------------
//         | FONT
//         |--------------------------------------------------------------------------
//         */

//         {
//             type: 'group',
//             items: [

//                 {
//                     type: 'select',
//                     command: 'fontFamily',
//                     title: 'Fonte',

//                     options: [

//                         {
//                             label: 'Arial',
//                             value: 'Arial'
//                         },

//                         {
//                             label: 'Verdana',
//                             value: 'Verdana'
//                         },

//                         {
//                             label: 'Tahoma',
//                             value: 'Tahoma'
//                         },

//                         {
//                             label: 'Georgia',
//                             value: 'Georgia'
//                         },

//                         {
//                             label: 'Times New Roman',
//                             value: 'Times New Roman'
//                         },

//                         {
//                             label: 'Courier New',
//                             value: 'Courier New'
//                         }
//                     ]
//                 },

//                 {
//                     type: 'select',
//                     command: 'fontSize',
//                     title: 'Tamanho',

//                     options: [

//                         {
//                             label: '10px',
//                             value: '10px'
//                         },

//                         {
//                             label: '12px',
//                             value: '12px'
//                         },

//                         {
//                             label: '14px',
//                             value: '14px'
//                         },

//                         {
//                             label: '16px',
//                             value: '16px'
//                         },

//                         {
//                             label: '18px',
//                             value: '18px'
//                         },

//                         {
//                             label: '22px',
//                             value: '22px'
//                         },

//                         {
//                             label: '28px',
//                             value: '28px'
//                         },

//                         {
//                             label: '36px',
//                             value: '36px'
//                         }
//                     ]
//                 }
//             ]
//         },

//         /*
//         |--------------------------------------------------------------------------
//         | COLORS
//         |--------------------------------------------------------------------------
//         */

//         {
//             type: 'group',
//             items: [

//                 {
//                     type: 'color',
//                     command: 'foreColor',
//                     title: 'Cor do texto',
//                     default: '#000000'
//                 },

//                 {
//                     type: 'color',
//                     command: 'hiliteColor',
//                     title: 'Cor de fundo',
//                     default: '#ffff00'
//                 }
//             ]
//         },

//         /*
//         |--------------------------------------------------------------------------
//         | FORMAT
//         |--------------------------------------------------------------------------
//         */

//         {
//             type: 'group',
//             items: [

//                 {
//                     type: 'select',
//                     command: 'formatBlock',
//                     title: 'Formato',

//                     options: [

//                         {
//                             label: 'Parágrafo',
//                             value: 'P'
//                         },

//                         {
//                             label: 'Título H1',
//                             value: 'H1'
//                         },

//                         {
//                             label: 'Título H2',
//                             value: 'H2'
//                         },

//                         {
//                             label: 'Título H3',
//                             value: 'H3'
//                         },

//                         {
//                             label: 'Título H4',
//                             value: 'H4'
//                         }
//                     ]
//                 }
//             ]
//         },

//         /*
//         |--------------------------------------------------------------------------
//         | ALIGN
//         |--------------------------------------------------------------------------
//         */

//         {
//             type: 'group',
//             items: [

//                 {
//                     type: 'button',
//                     command: 'justifyLeft',
//                     icon: 'fas fa-align-left',
//                     title: 'Alinhar esquerda'
//                 },

//                 {
//                     type: 'button',
//                     command: 'justifyCenter',
//                     icon: 'fas fa-align-center',
//                     title: 'Centralizar'
//                 },

//                 {
//                     type: 'button',
//                     command: 'justifyRight',
//                     icon: 'fas fa-align-right',
//                     title: 'Alinhar direita'
//                 }
//             ]
//         },

//         /*
//         |--------------------------------------------------------------------------
//         | LISTS
//         |--------------------------------------------------------------------------
//         */

//         {
//             type: 'group',
//             items: [

//                 {
//                     type: 'button',
//                     command: 'insertUnorderedList',
//                     icon: 'fas fa-list-ul',
//                     title: 'Lista'
//                 },

//                 {
//                     type: 'button',
//                     command: 'insertOrderedList',
//                     icon: 'fas fa-list-ol',
//                     title: 'Lista numerada'
//                 }
//             ]
//         },

//         /*
//         |--------------------------------------------------------------------------
//         | MEDIA
//         |--------------------------------------------------------------------------
//         */

//         {
//             type: 'group',
//             items: [

//                 {
//                     type: 'button',
//                     command: 'insertLink',
//                     icon: 'fas fa-link',
//                     title: 'Inserir link'
//                 },

//                 {
//                     type: 'button',
//                     command: 'insertImage',
//                     icon: 'fas fa-image',
//                     title: 'Inserir imagem'
//                 }
//             ]
//         },

//         /*
//         |--------------------------------------------------------------------------
//         | ACTIONS
//         |--------------------------------------------------------------------------
//         */

//         {
//             type: 'group',
//             items: [

//                 {
//                     type: 'button',
//                     command: 'removeFormat',
//                     icon: 'fas fa-eraser',
//                     title: 'Limpar formatação'
//                 },

//                 {
//                     type: 'button',
//                     command: 'undo',
//                     icon: 'fas fa-undo',
//                     title: 'Desfazer'
//                 },

//                 {
//                     type: 'button',
//                     command: 'redo',
//                     icon: 'fas fa-redo',
//                     title: 'Refazer'
//                 }
//             ]
//         },

//         /*
//         |--------------------------------------------------------------------------
//         | VIEW
//         |--------------------------------------------------------------------------
//         */

//         {
//             type: 'group',
//             items: [

//                 {
//                     type: 'button',
//                     command: 'fullscreen',
//                     icon: 'fas fa-expand',
//                     title: 'Tela cheia'
//                 },

//                 {
//                     type: 'button',
//                     command: 'toggleCode',
//                     icon: 'fas fa-code',
//                     title: 'Modo código'
//                 }
//             ]
//         }
//     ];

//     /*
//     |--------------------------------------------------------------------------
//     | Toolbar render
//     |--------------------------------------------------------------------------
//     */

//     window.AutomatorEditorBuildToolbar =
//         function (editor) {

//             let toolbar =
//                 editor.config.toolbar;

//             if (
//                 !toolbar ||
//                 !toolbar.length
//             ) {

//                 toolbar =
//                     window
//                     .AutomatorEditorToolbarDefaults;
//             }

//             editor.toolbar.empty();

//             let html = '';

//             toolbar.forEach(
//                 function (group) {

//                     html += `
//                         <div 
//                             class="btn-group me-2 automator-editor-group"
//                             role="group"
//                         >
//                     `;

//                     if (
//                         group.items
//                     ) {

//                         group.items.forEach(
//                             function (item) {

//                                 html +=
//                                     window
//                                     .AutomatorEditorRenderToolbarItem(
//                                         item,
//                                         editor
//                                     );
//                             }
//                         );
//                     }

//                     html += `
//                         </div>
//                     `;
//                 }
//             );

//             editor.toolbar.html(
//                 html
//             );

//             window
//                 .AutomatorEditorBindToolbarEvents(
//                     editor
//                 );
//         };

//     /*
//     |--------------------------------------------------------------------------
//     | Render toolbar item
//     |--------------------------------------------------------------------------
//     */

//     // window.AutomatorEditorRenderToolbarItem =
//     //     function (
//     //         item,
//     //         editor
//     //     ) {

//     //         /*
//     //         |--------------------------------------------------------------------------
//     //         | BUTTON
//     //         |--------------------------------------------------------------------------
//     //         */

//     //         if (
//     //             item.type ===
//     //             'button'
//     //         ) {

//     //             return `
//     //                 <button
//     //                     type="button"
//     //                     class="btn btn-light automator-editor-btn"
//     //                     title="${item.title || ''}"
//     //                     data-command="${item.command || ''}"
//     //                 >
//     //                     <i class="${item.icon || 'fas fa-square'}"></i>
//     //                 </button>
//     //             `;
//     //         }

//     //         /*
//     //         |--------------------------------------------------------------------------
//     //         | SELECT
//     //         |--------------------------------------------------------------------------
//     //         */

//     //         if (
//     //             item.type ===
//     //             'select'
//     //         ) {

//     //             let options =
//     //                 '';

//     //             if (
//     //                 item.options
//     //             ) {

//     //                 item.options.forEach(
//     //                     function (
//     //                         option
//     //                     ) {

//     //                         options += `
//     //                             <option 
//     //                                 value="${option.value}"
//     //                             >
//     //                                 ${option.label}
//     //                             </option>
//     //                         `;
//     //                     }
//     //                 );
//     //             }

//     //             return `
//     //                 <select
//     //                     class="form-select form-select-sm automator-editor-select"
//     //                     data-command="${item.command || ''}"
//     //                     title="${item.title || ''}"
//     //                 >
//     //                     ${options}
//     //                 </select>
//     //             `;
//     //         }

//     //         return '';
//     //     };

//     window.AutomatorEditorRenderToolbarItem =
//     function(item, editor)
//     {
//         /*
//         |--------------------------------------------------------------------------
//         | BUTTON
//         |--------------------------------------------------------------------------
//         */

//         if(item.type === 'button')
//         {
//             return `
//                 <button
//                     type="button"
//                     class="btn btn-light automator-editor-btn"
//                     title="${item.title || ''}"
//                     data-command="${item.command || ''}"
//                 >
//                     <i class="${item.icon || ''}"></i>
//                 </button>
//             `;
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | SELECT
//         |--------------------------------------------------------------------------
//         */

//         if(item.type === 'select')
//         {
//             let options = '';

//             if(item.options)
//             {
//                 item.options.forEach(function(option){

//                     options += `
//                         <option
//                             value="${option.value}"
//                         >
//                             ${option.label}
//                         </option>
//                     `;
//                 });
//             }

//             return `
//                 <select
//                     class="form-select form-select-sm automator-editor-select"
//                     data-command="${item.command || ''}"
//                     title="${item.title || ''}"
//                 >
//                     ${options}
//                 </select>
//             `;
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | COLOR PICKER
//         |--------------------------------------------------------------------------
//         */

//         if(item.type === 'color')
//         {
//             return `
//                 <input
//                     type="color"
//                     class="form-control form-control-color automator-editor-color"
//                     data-command="${item.command || ''}"
//                     value="${item.default || '#000000'}"
//                     title="${item.title || ''}"
//                 >
//             `;
//         }

//         return '';
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | Bind toolbar events
//     |--------------------------------------------------------------------------
//     */

//     window.AutomatorEditorBindToolbarEvents =
//         function (
//             editor
//         ) {

//             /*
//             |--------------------------------------------------------------------------
//             | Buttons
//             |--------------------------------------------------------------------------
//             */

//             editor.toolbar
//                 .find(
//                     '.automator-editor-btn'
//                 )
//                 .off(
//                     'click'
//                 )
//                 .on(
//                     'click',
//                     function () {

//                         let btn =
//                             $(this);

//                         let command =
//                             btn.data(
//                                 'command'
//                             );

//                         if (
//                             typeof window
//                                 .AutomatorEditorExecCommand
//                             ===
//                             'function'
//                         ) {

//                             window
//                                 .AutomatorEditorExecCommand(
//                                     editor,
//                                     command,
//                                     null,
//                                     btn
//                                 );
//                         }
//                     }
//                 );

//             /*
//             |--------------------------------------------------------------------------
//             | Selects
//             |--------------------------------------------------------------------------
//             */

//             editor.toolbar
//                 .find(
//                     '.automator-editor-select'
//                 )
//                 .off(
//                     'change'
//                 )
//                 .on(
//                     'change',
//                     function () {

//                         let select =
//                             $(this);

//                         let command =
//                             select.data(
//                                 'command'
//                             );

//                         let value =
//                             select.val();

//                         if (
//                             typeof window
//                                 .AutomatorEditorExecCommand
//                             ===
//                             'function'
//                         ) {

//                             window
//                                 .AutomatorEditorExecCommand(
//                                     editor,
//                                     command,
//                                     value,
//                                     select
//                                 );
//                         }
//                     }
//                 );

//             /*
//             |--------------------------------------------------------------------------
//             | Colors
//             |--------------------------------------------------------------------------
//             */

//             editor.toolbar
//                 .find(
//                     '.automator-editor-color'
//                 )
//                 .off('change')
//                 .on(
//                     'change',
//                     function()
//                     {
//                         let el =
//                             $(this);

//                         let command =
//                             el.data(
//                                 'command'
//                             );

//                         let value =
//                             el.val();

//                         if(
//                             typeof window
//                                 .AutomatorEditorExecCommand
//                             ===
//                             'function'
//                         ) {

//                             window
//                             .AutomatorEditorExecCommand(
//                                 editor,
//                                 command,
//                                 value,
//                                 el
//                             );
//                         }
//                     }
//                 );
//         };

//     /*
//     |--------------------------------------------------------------------------
//     | Init toolbar on editor render
//     |--------------------------------------------------------------------------
//     */

//     $(document).on(
//         'automator-editor-rendered',
//         function (
//             e,
//             editor
//         ) {

//             window
//                 .AutomatorEditorBuildToolbar(
//                     editor
//                 );
//         }
//     );

// })(jQuery);



// (function($){

//     /*
//     |--------------------------------------------------------------------------
//     | Auto Render
//     |--------------------------------------------------------------------------
//     */

//     window.AutomatorEditorAutoRender =
//     function(root = document)
//     {

//         var $root =
//             $(root);

//         if(
//             !$root.length
//         ) {
//             return false;
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Current root editors
//         |--------------------------------------------------------------------------
//         */

//         if(
//             $root.hasClass(
//                 'automator-editor'
//             )
//         ) {

//             AutomatorEditorRender(
//                 $root
//             );

//         } else {

//             AutomatorEditorRender(
//                 $root.find(
//                     '.automator-editor'
//                 )
//             );
//         }

//         return true;
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | DOM Ready
//     |--------------------------------------------------------------------------
//     */

//     $(function(){

//         AutomatorEditorAutoRender(
//             document
//         );

//     });

//     /*
//     |--------------------------------------------------------------------------
//     | Bootstrap modal shown
//     |--------------------------------------------------------------------------
//     */

//     $(document).on(
//         'shown.bs.modal',
//         '.modal',
//         function(){

//             AutomatorEditorAutoRender(
//                 this
//             );

//         }
//     );

//     /*
//     |--------------------------------------------------------------------------
//     | Mutation Observer
//     |--------------------------------------------------------------------------
//     */

//     // const observer =
//     //     new MutationObserver(
//     //         function(mutations)
//     //         {

//     //             mutations.forEach(
//     //                 function(
//     //                     mutation
//     //                 ){

//     //                     mutation
//     //                     .addedNodes
//     //                     .forEach(
//     //                         function(
//     //                             node
//     //                         ){

//     //                             if(
//     //                                 !node ||
//     //                                 node.nodeType !== 1
//     //                             ){
//     //                                 return;
//     //                             }

//     //                             var $node =
//     //                                 $(node);

//     //                             /*
//     //                             |--------------------------------------------------------------------------
//     //                             | textarea/div editor
//     //                             |--------------------------------------------------------------------------
//     //                             */

//     //                             if(
//     //                                 $node.hasClass(
//     //                                     'automator-editor'
//     //                                 )
//     //                             ){

//     //                                 AutomatorEditorRender(
//     //                                     $node
//     //                                 );

//     //                                 return;
//     //                             }

//     //                             /*
//     //                             |--------------------------------------------------------------------------
//     //                             | nested editors
//     //                             |--------------------------------------------------------------------------
//     //                             */

//     //                             if(
//     //                                 $node.find(
//     //                                     '.automator-editor'
//     //                                 ).length
//     //                             ){

//     //                                 AutomatorEditorRender(
//     //                                     $node
//     //                                 );
//     //                             }

//     //                         }
//     //                     );

//     //                 }
//     //             );

//     //         }
//     //     );

//     // observer.observe(
//     //     document.body,
//     //     {
//     //         childList: true,
//     //         subtree: true
//     //     }
//     // );


//     /*
//     |--------------------------------------------------------------------------
//     | Mutation Observer
//     |--------------------------------------------------------------------------
//     */

//     window.AutomatorEditorStartObserver =
//     function()
//     {
//         /*
//         |--------------------------------------------------------------------------
//         | Prevent duplicate observer
//         |--------------------------------------------------------------------------
//         */

//         if(
//             window.AutomatorEditorObserverStarted
//         ){
//             return;
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Wait body
//         |--------------------------------------------------------------------------
//         */

//         if(
//             !document.body
//         ){

//             setTimeout(
//                 function(){

//                     window
//                     .AutomatorEditorStartObserver();

//                 },
//                 100
//             );

//             return;
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Create observer
//         |--------------------------------------------------------------------------
//         */

//         const observer =
//             new MutationObserver(
//                 function(
//                     mutations
//                 ){

//                     mutations.forEach(
//                         function(
//                             mutation
//                         ){

//                             mutation
//                             .addedNodes
//                             .forEach(
//                                 function(
//                                     node
//                                 ){

//                                     if(
//                                         !node ||
//                                         node.nodeType !== 1
//                                     ){
//                                         return;
//                                     }

//                                     let $node =
//                                         $(node);

//                                     /*
//                                     |--------------------------------------------------------------------------
//                                     | Single editor
//                                     |--------------------------------------------------------------------------
//                                     */

//                                     if(
//                                         $node.hasClass(
//                                             'automator-editor'
//                                         )
//                                     ){

//                                         AutomatorEditorRender(
//                                             $node
//                                         );

//                                         return;
//                                     }

//                                     /*
//                                     |--------------------------------------------------------------------------
//                                     | Nested editors
//                                     |--------------------------------------------------------------------------
//                                     */

//                                     if(
//                                         $node.find(
//                                             '.automator-editor'
//                                         ).length
//                                     ){

//                                         AutomatorEditorRender(
//                                             $node
//                                         );
//                                     }

//                                 }
//                             );

//                         }
//                     );

//                 }
//             );

//         /*
//         |--------------------------------------------------------------------------
//         | Observe body
//         |--------------------------------------------------------------------------
//         */

//         observer.observe(
//             document.body,
//             {
//                 childList: true,
//                 subtree: true
//             }
//         );

//         /*
//         |--------------------------------------------------------------------------
//         | Registry
//         |--------------------------------------------------------------------------
//         */

//         window.AutomatorEditorObserver =
//             observer;

//         window
//         .AutomatorEditorObserverStarted =
//             true;
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | Start observer
//     |--------------------------------------------------------------------------
//     */

//     $(function(){

//         window
//         .AutomatorEditorStartObserver();

//     });

// })(jQuery);


// (function ($) {

//     /*
//     |--------------------------------------------------------------------------
//     | Sync editor to source
//     |--------------------------------------------------------------------------
//     */

//     window.AutomatorEditorSyncToSource =
//     function(editor)
//     {
//         if(!editor)
//         {
//             return false;
//         }

//         let html = '';

//         if(
//             editor.mode ===
//             'code'
//         ) {

//             html =
//                 editor.code.val();

//             editor.visual.html(
//                 html
//             );

//         } else {

//             html =
//                 editor.visual.html();

//             editor.code.val(
//                 html
//             );
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Update original field
//         |--------------------------------------------------------------------------
//         */

//         if(
//             editor.source.is(
//                 'textarea'
//             )
//         ) {

//             editor.source.val(
//                 html
//             );

//         } else {

//             editor.source.html(
//                 html
//             );
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Trigger change
//         |--------------------------------------------------------------------------
//         */

//         editor.source.trigger(
//             'change'
//         );

//         if(
//             typeof editor
//                 .config
//                 .callbacks
//                 .onChange ===
//             'function'
//         ) {

//             editor
//                 .config
//                 .callbacks
//                 .onChange(
//                     editor,
//                     html
//                 );
//         }

//         return html;
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | Focus current mode
//     |--------------------------------------------------------------------------
//     */

//     window.AutomatorEditorFocus =
//     function(editor)
//     {
//         if(
//             editor.mode ===
//             'code'
//         ) {

//             editor.code.focus();

//         } else {

//             editor.visual.focus();
//         }
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | Toggle mode
//     |--------------------------------------------------------------------------
//     */

//     window.AutomatorEditorToggleMode =
//     function(editor)
//     {
//         if(!editor)
//         {
//             return false;
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Sync before toggle
//         |--------------------------------------------------------------------------
//         */

//         AutomatorEditorSyncToSource(
//             editor
//         );

//         /*
//         |--------------------------------------------------------------------------
//         | Code -> Visual
//         |--------------------------------------------------------------------------
//         */

//         if(
//             editor.mode ===
//             'code'
//         ) {

//             editor.mode =
//                 'visual';

//             editor.wrapper
//                 .removeClass(
//                     'is-code-mode'
//                 )
//                 .addClass(
//                     'is-visual-mode'
//                 );

//             editor.code
//                 .addClass(
//                     'd-none'
//                 );

//             editor.visual
//                 .removeClass(
//                     'd-none'
//                 )
//                 .html(
//                     editor.code.val()
//                 );

//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Visual -> Code
//         |--------------------------------------------------------------------------
//         */

//         else {

//             editor.mode =
//                 'code';

//             editor.wrapper
//                 .removeClass(
//                     'is-visual-mode'
//                 )
//                 .addClass(
//                     'is-code-mode'
//                 );

//             editor.visual
//                 .addClass(
//                     'd-none'
//                 );

//             editor.code
//                 .removeClass(
//                     'd-none'
//                 )
//                 .val(
//                     editor.visual.html()
//                 );
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Focus
//         |--------------------------------------------------------------------------
//         */

//         setTimeout(
//             function(){

//                 AutomatorEditorFocus(
//                     editor
//                 );

//             },
//             10
//         );

//         /*
//         |--------------------------------------------------------------------------
//         | Callback
//         |--------------------------------------------------------------------------
//         */

//         if(
//             typeof editor
//                 .config
//                 .callbacks
//                 .onModeChange ===
//             'function'
//         ) {

//             editor
//                 .config
//                 .callbacks
//                 .onModeChange(
//                     editor,
//                     editor.mode
//                 );
//         }

//         return true;
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | Apply visual command
//     |--------------------------------------------------------------------------
//     */

//     // window.AutomatorEditorApplyVisualCommand =
//     // function(
//     //     editor,
//     //     command,
//     //     value = null
//     // )
//     // {
//     //     AutomatorEditorFocus(
//     //         editor
//     //     );

//     //     /*
//     //     |--------------------------------------------------------------------------
//     //     | formatBlock fix
//     //     |--------------------------------------------------------------------------
//     //     */

//     //     if(
//     //         command ===
//     //         'formatBlock'
//     //     ) {

//     //         document.execCommand(
//     //             command,
//     //             false,
//     //             '<' + value + '>'
//     //         );

//     //     } else {

//     //         document.execCommand(
//     //             command,
//     //             false,
//     //             value
//     //         );
//     //     }

//     //     AutomatorEditorSyncToSource(
//     //         editor
//     //     );

//     //     return true;
//     // };

//     window.AutomatorEditorApplyVisualCommand =
//     function(
//         editor,
//         command,
//         value = null
//     )
//     {
//         if(!editor)
//         {
//             return false;
//         }

//         AutomatorEditorFocus(
//             editor
//         );

//         /*
//         |--------------------------------------------------------------------------
//         | Open modals
//         |--------------------------------------------------------------------------
//         */

//         if(
//             command ===
//             'insertLink'
//         ) {

//             AutomatorEditorOpenLinkModal(
//                 editor
//             );

//             return true;
//         }

//         if(
//             command ===
//             'insertImage'
//         ) {

//             AutomatorEditorOpenImageModal(
//                 editor
//             );

//             return true;
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Fullscreen
//         |--------------------------------------------------------------------------
//         */

//         if(
//             command ===
//             'fullscreen'
//         ) {

//             AutomatorEditorToggleFullscreen(
//                 editor
//             );

//             return true;
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Font size
//         |--------------------------------------------------------------------------
//         */

//         if(
//             command ===
//             'fontSize'
//         ) {

//             document.execCommand(
//                 'styleWithCSS',
//                 false,
//                 true
//             );

//             document.execCommand(
//                 'fontSize',
//                 false,
//                 7
//             );

//             editor.visual.find(
//                 'font[size="7"]'
//             )
//             .removeAttr(
//                 'size'
//             )
//             .css(
//                 'font-size',
//                 value
//             );

//             AutomatorEditorSyncToSource(
//                 editor
//             );

//             return true;
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Font family
//         |--------------------------------------------------------------------------
//         */

//         if(
//             command ===
//             'fontFamily'
//         ) {

//             document.execCommand(
//                 'fontName',
//                 false,
//                 value
//             );

//             AutomatorEditorSyncToSource(
//                 editor
//             );

//             return true;
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Text color
//         |--------------------------------------------------------------------------
//         */

//         if(
//             command ===
//             'foreColor'
//         ) {

//             document.execCommand(
//                 'styleWithCSS',
//                 false,
//                 true
//             );

//             document.execCommand(
//                 'foreColor',
//                 false,
//                 value
//             );

//             AutomatorEditorSyncToSource(
//                 editor
//             );

//             return true;
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Background color
//         |--------------------------------------------------------------------------
//         */

//         if(
//             command ===
//             'hiliteColor'
//         ) {

//             document.execCommand(
//                 'styleWithCSS',
//                 false,
//                 true
//             );

//             document.execCommand(
//                 'hiliteColor',
//                 false,
//                 value
//             );

//             AutomatorEditorSyncToSource(
//                 editor
//             );

//             return true;
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Remove formatting
//         |--------------------------------------------------------------------------
//         */

//         if(
//             command ===
//             'removeFormat'
//         ) {

//             document.execCommand(
//                 'removeFormat',
//                 false,
//                 null
//             );

//             AutomatorEditorSyncToSource(
//                 editor
//             );

//             return true;
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | formatBlock fix
//         |--------------------------------------------------------------------------
//         */

//         if(
//             command ===
//             'formatBlock'
//         ) {

//             document.execCommand(
//                 command,
//                 false,
//                 '<' + value + '>'
//             );

//         } else {

//             document.execCommand(
//                 command,
//                 false,
//                 value
//             );
//         }

//         AutomatorEditorSyncToSource(
//             editor
//         );

//         return true;
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | Apply code command
//     |--------------------------------------------------------------------------
//     */

//     // window.AutomatorEditorApplyCodeCommand =
//     // function(
//     //     editor,
//     //     command,
//     //     value = null
//     // )
//     // {
//     //     let textarea =
//     //         editor.code[0];

//     //     if(!textarea)
//     //     {
//     //         return false;
//     //     }

//     //     let start =
//     //         textarea.selectionStart;

//     //     let end =
//     //         textarea.selectionEnd;

//     //     let text =
//     //         textarea.value;

//     //     let selected =
//     //         text.substring(
//     //             start,
//     //             end
//     //         );

//     //     let before =
//     //         text.substring(
//     //             0,
//     //             start
//     //         );

//     //     let after =
//     //         text.substring(
//     //             end
//     //         );

//     //     let newText =
//     //         selected;

//     //     /*
//     //     |--------------------------------------------------------------------------
//     //     | Command map
//     //     |--------------------------------------------------------------------------
//     //     */

//     //     switch(command)
//     //     {
//     //         case 'bold':

//     //             newText =
//     //                 `<strong>${selected}</strong>`;
//     //         break;

//     //         case 'italic':

//     //             newText =
//     //                 `<em>${selected}</em>`;
//     //         break;

//     //         case 'underline':

//     //             newText =
//     //                 `<u>${selected}</u>`;
//     //         break;

//     //         case 'strikeThrough':

//     //             newText =
//     //                 `<strike>${selected}</strike>`;
//     //         break;

//     //         case 'justifyLeft':

//     //             newText =
//     //                 `<div style="text-align:left;">${selected}</div>`;
//     //         break;

//     //         case 'justifyCenter':

//     //             newText =
//     //                 `<div style="text-align:center;">${selected}</div>`;
//     //         break;

//     //         case 'justifyRight':

//     //             newText =
//     //                 `<div style="text-align:right;">${selected}</div>`;
//     //         break;

//     //         case 'insertUnorderedList':

//     //             newText =
//     //                 `<ul><li>${selected}</li></ul>`;
//     //         break;

//     //         case 'insertOrderedList':

//     //             newText =
//     //                 `<ol><li>${selected}</li></ol>`;
//     //         break;

//     //         case 'formatBlock':

//     //             newText =
//     //                 `<${value}>${selected}</${value}>`;
//     //         break;

//     //         default:
//     //             return false;
//     //     }

//     //     textarea.value =
//     //         before +
//     //         newText +
//     //         after;

//     //     textarea.focus();

//     //     textarea.selectionStart =
//     //         start;

//     //     textarea.selectionEnd =
//     //         start +
//     //         newText.length;

//     //     editor.visual.html(
//     //         textarea.value
//     //     );

//     //     AutomatorEditorSyncToSource(
//     //         editor
//     //     );

//     //     return true;
//     // };

//     window.AutomatorEditorApplyCodeCommand =
//     function(
//         editor,
//         command,
//         value = null
//     )
//     {
//         let textarea =
//             editor.code[0];

//         if(!textarea)
//         {
//             return false;
//         }

//         let start =
//             textarea.selectionStart;

//         let end =
//             textarea.selectionEnd;

//         let text =
//             textarea.value;

//         let selected =
//             text.substring(
//                 start,
//                 end
//             );

//         let before =
//             text.substring(
//                 0,
//                 start
//             );

//         let after =
//             text.substring(
//                 end
//             );

//         let newText =
//             selected;

//         switch(command)
//         {
//             case 'bold':

//                 newText =
//                     `<strong>${selected}</strong>`;
//             break;

//             case 'italic':

//                 newText =
//                     `<em>${selected}</em>`;
//             break;

//             case 'underline':

//                 newText =
//                     `<u>${selected}</u>`;
//             break;

//             case 'strikeThrough':

//                 newText =
//                     `<strike>${selected}</strike>`;
//             break;

//             case 'justifyLeft':

//                 newText =
//                     `<div style="text-align:left;">${selected}</div>`;
//             break;

//             case 'justifyCenter':

//                 newText =
//                     `<div style="text-align:center;">${selected}</div>`;
//             break;

//             case 'justifyRight':

//                 newText =
//                     `<div style="text-align:right;">${selected}</div>`;
//             break;

//             case 'insertUnorderedList':

//                 newText =
//                     `<ul><li>${selected}</li></ul>`;
//             break;

//             case 'insertOrderedList':

//                 newText =
//                     `<ol><li>${selected}</li></ol>`;
//             break;

//             case 'formatBlock':

//                 newText =
//                     `<${value}>${selected}</${value}>`;
//             break;

//             case 'fontSize':

//                 newText =
//                     `<span style="font-size:${value};">${selected}</span>`;
//             break;

//             case 'fontFamily':

//                 newText =
//                     `<span style="font-family:${value};">${selected}</span>`;
//             break;

//             case 'foreColor':

//                 newText =
//                     `<span style="color:${value};">${selected}</span>`;
//             break;

//             case 'hiliteColor':

//                 newText =
//                     `<span style="background-color:${value};">${selected}</span>`;
//             break;

//             case 'removeFormat':

//                 newText =
//                     selected
//                     .replace(
//                         /<[^>]*>/g,
//                         ''
//                     );
//             break;

//             case 'insertLink':

//                 AutomatorEditorOpenLinkModal(
//                     editor
//                 );

//                 return true;

//             case 'insertImage':

//                 AutomatorEditorOpenImageModal(
//                     editor
//                 );

//                 return true;

//             case 'fullscreen':

//                 AutomatorEditorToggleFullscreen(
//                     editor
//                 );

//                 return true;

//             default:
//                 return false;
//         }

//         textarea.value =
//             before +
//             newText +
//             after;

//         textarea.focus();

//         textarea.selectionStart =
//             start;

//         textarea.selectionEnd =
//             start +
//             newText.length;

//         editor.visual.html(
//             textarea.value
//         );

//         AutomatorEditorSyncToSource(
//             editor
//         );

//         return true;
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | Execute command
//     |--------------------------------------------------------------------------
//     */

//     // window.AutomatorEditorExecCommand =
//     // function(
//     //     editor,
//     //     command,
//     //     value = null,
//     //     trigger = null
//     // )
//     // {
//     //     if(
//     //         !editor ||
//     //         !command
//     //     ) {
//     //         return false;
//     //     }

//     //     /*
//     //     |--------------------------------------------------------------------------
//     //     | beforeCommand
//     //     |--------------------------------------------------------------------------
//     //     */

//     //     if(
//     //         typeof editor
//     //             .config
//     //             .callbacks
//     //             .beforeCommand ===
//     //         'function'
//     //     ) {

//     //         editor
//     //             .config
//     //             .callbacks
//     //             .beforeCommand(
//     //                 editor,
//     //                 command,
//     //                 value,
//     //                 trigger
//     //             );
//     //     }

//     //     /*
//     //     |--------------------------------------------------------------------------
//     //     | Toggle mode
//     //     |--------------------------------------------------------------------------
//     //     */

//     //     if(
//     //         command ===
//     //         'toggleCode'
//     //     ) {

//     //         AutomatorEditorToggleMode(
//     //             editor
//     //         );

//     //         return true;
//     //     }

//     //     /*
//     //     |--------------------------------------------------------------------------
//     //     | Undo / Redo
//     //     |--------------------------------------------------------------------------
//     //     */

//     //     if(
//     //         command ===
//     //         'undo'
//     //         ||
//     //         command ===
//     //         'redo'
//     //     ) {

//     //         if(
//     //             editor.mode ===
//     //             'visual'
//     //         ) {

//     //             document.execCommand(
//     //                 command,
//     //                 false,
//     //                 null
//     //             );

//     //             AutomatorEditorSyncToSource(
//     //                 editor
//     //             );
//     //         }

//     //         return true;
//     //     }

//     //     /*
//     //     |--------------------------------------------------------------------------
//     //     | Apply command
//     //     |--------------------------------------------------------------------------
//     //     */

//     //     if(
//     //         editor.mode ===
//     //         'code'
//     //     ) {

//     //         AutomatorEditorApplyCodeCommand(
//     //             editor,
//     //             command,
//     //             value
//     //         );

//     //     } else {

//     //         AutomatorEditorApplyVisualCommand(
//     //             editor,
//     //             command,
//     //             value
//     //         );
//     //     }

//     //     /*
//     //     |--------------------------------------------------------------------------
//     //     | afterCommand
//     //     |--------------------------------------------------------------------------
//     //     */

//     //     if(
//     //         typeof editor
//     //             .config
//     //             .callbacks
//     //             .afterCommand ===
//     //         'function'
//     //     ) {

//     //         editor
//     //             .config
//     //             .callbacks
//     //             .afterCommand(
//     //                 editor,
//     //                 command,
//     //                 value,
//     //                 trigger
//     //             );
//     //     }

//     //     return true;
//     // };

//     window.AutomatorEditorExecCommand =
//     function(
//         editor,
//         command,
//         value = null,
//         trigger = null
//     )
//     {
//         if(
//             !editor
//             ||
//             !command
//         ) {
//             return false;
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | beforeCommand
//         |--------------------------------------------------------------------------
//         */

//         if(
//             typeof editor
//                 .config
//                 .callbacks
//                 .beforeCommand ===
//             'function'
//         ) {

//             editor
//                 .config
//                 .callbacks
//                 .beforeCommand(
//                     editor,
//                     command,
//                     value,
//                     trigger
//                 );
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Toggle mode
//         |--------------------------------------------------------------------------
//         */

//         if(
//             command ===
//             'toggleCode'
//         ) {

//             AutomatorEditorToggleMode(
//                 editor
//             );

//             return true;
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Undo / Redo
//         |--------------------------------------------------------------------------
//         */

//         if(
//             command ===
//             'undo'
//             ||
//             command ===
//             'redo'
//         ) {

//             if(
//                 editor.mode ===
//                 'visual'
//             ) {

//                 document.execCommand(
//                     command,
//                     false,
//                     null
//                 );

//                 AutomatorEditorSyncToSource(
//                     editor
//                 );
//             }

//             return true;
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Apply command
//         |--------------------------------------------------------------------------
//         */

//         if(
//             editor.mode ===
//             'code'
//         ) {

//             AutomatorEditorApplyCodeCommand(
//                 editor,
//                 command,
//                 value
//             );

//         } else {

//             AutomatorEditorApplyVisualCommand(
//                 editor,
//                 command,
//                 value
//             );
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Refresh toolbar state
//         |--------------------------------------------------------------------------
//         */

//         setTimeout(
//             function(){

//                 if(
//                     typeof
//                     AutomatorEditorUpdateToolbarState
//                     ===
//                     'function'
//                 ) {

//                     AutomatorEditorUpdateToolbarState(
//                         editor
//                     );
//                 }

//             },
//             5
//         );

//         /*
//         |--------------------------------------------------------------------------
//         | afterCommand
//         |--------------------------------------------------------------------------
//         */

//         if(
//             typeof editor
//                 .config
//                 .callbacks
//                 .afterCommand ===
//             'function'
//         ) {

//             editor
//                 .config
//                 .callbacks
//                 .afterCommand(
//                     editor,
//                     command,
//                     value,
//                     trigger
//                 );
//         }

//         return true;
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | Auto sync typing
//     |--------------------------------------------------------------------------
//     */

//     $(document).on(
//         'input keyup paste',
//         '.automator-editor-visual, .automator-editor-code',
//         function(){

//             let wrapper =
//                 $(this)
//                 .closest(
//                     '.automator-editor-wrapper'
//                 );

//             let id =
//                 wrapper.data(
//                     'editor-id'
//                 );

//             if(
//                 !id
//             ){
//                 return;
//             }

//             let editor =
//                 window
//                 .AutomatorEditors[id];

//             if(
//                 !editor
//             ){
//                 return;
//             }

//             AutomatorEditorSyncToSource(
//                 editor
//             );
//         }
//     );

// })(jQuery);

// (function ($) {

//     /*
//     |--------------------------------------------------------------------------
//     | Active commands map
//     |--------------------------------------------------------------------------
//     */

//     window.AutomatorEditorActiveCommands = [

//         'bold',
//         'italic',
//         'underline',
//         'strikeThrough',
//         'justifyLeft',
//         'justifyCenter',
//         'justifyRight',
//         'insertOrderedList',
//         'insertUnorderedList'
//     ];

//     /*
//     |--------------------------------------------------------------------------
//     | Code mode tag map
//     |--------------------------------------------------------------------------
//     */

//     window.AutomatorEditorCodeTagMap = {

//         bold: [
//             'strong',
//             'b'
//         ],

//         italic: [
//             'em',
//             'i'
//         ],

//         underline: [
//             'u'
//         ],

//         strikeThrough: [
//             'strike',
//             's',
//             'del'
//         ],

//         justifyLeft: [
//             'text-align:left'
//         ],

//         justifyCenter: [
//             'text-align:center'
//         ],

//         justifyRight: [
//             'text-align:right'
//         ],

//         insertUnorderedList: [
//             'ul'
//         ],

//         insertOrderedList: [
//             'ol'
//         ]
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | Remove toolbar active states
//     |--------------------------------------------------------------------------
//     */

//     window.AutomatorEditorClearToolbarState =
//     function(editor)
//     {
//         editor.toolbar
//             .find(
//                 '.automator-editor-btn'
//             )
//             .removeClass(
//                 'active is-active btn-primary'
//             );
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | Set active button
//     |--------------------------------------------------------------------------
//     */

//     window.AutomatorEditorSetButtonState =
//     function(
//         editor,
//         command,
//         active = false
//     )
//     {
//         let button =
//             editor.toolbar.find(
//                 '[data-command="' +
//                 command +
//                 '"]'
//             );

//         if(!button.length)
//         {
//             return;
//         }

//         if(active)
//         {
//             button.addClass(
//                 'active is-active btn-primary'
//             );
//         }
//         else
//         {
//             button.removeClass(
//                 'active is-active btn-primary'
//             );
//         }
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | Get visual selection state
//     |--------------------------------------------------------------------------
//     */

//     window.AutomatorEditorGetVisualState =
//     function(editor)
//     {
//         let state = {};

//         window
//             .AutomatorEditorActiveCommands
//             .forEach(
//                 function(command)
//                 {
//                     try {

//                         state[
//                             command
//                         ] =
//                             document.queryCommandState(
//                                 command
//                             );

//                     } catch(e) {

//                         state[
//                             command
//                         ] = false;
//                     }
//                 }
//             );

//         return state;
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | Detect code mode selection state
//     |--------------------------------------------------------------------------
//     */

//     window.AutomatorEditorGetCodeState =
//     function(editor)
//     {
//         let textarea =
//             editor.code[0];

//         let start =
//             textarea.selectionStart;

//         let end =
//             textarea.selectionEnd;

//         let value =
//             textarea.value;

//         let selected =
//             value.substring(
//                 start,
//                 end
//             );

//         /*
//         |--------------------------------------------------------------------------
//         | Fallback around cursor
//         |--------------------------------------------------------------------------
//         */

//         if(
//             !selected.length
//         ) {

//             let before =
//                 value.substring(
//                     Math.max(
//                         0,
//                         start - 300
//                     ),
//                     start
//                 );

//             let after =
//                 value.substring(
//                     start,
//                     Math.min(
//                         value.length,
//                         start + 300
//                     )
//                 );

//             selected =
//                 before + after;
//         }

//         let state = {};

//         Object.keys(
//             window
//             .AutomatorEditorCodeTagMap
//         )
//         .forEach(
//             function(command)
//             {
//                 state[
//                     command
//                 ] = false;

//                 let tags =
//                     window
//                     .AutomatorEditorCodeTagMap[
//                         command
//                     ];

//                 tags.forEach(
//                     function(tag)
//                     {
//                         if(
//                             selected
//                             .toLowerCase()
//                             .indexOf(
//                                 tag.toLowerCase()
//                             ) !== -1
//                         ) {
//                             state[
//                                 command
//                             ] = true;
//                         }
//                     }
//                 );
//             }
//         );

//         return state;
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | Update toolbar state
//     |--------------------------------------------------------------------------
//     */

//     window.AutomatorEditorUpdateToolbarState =
//     function(editor)
//     {
//         if(!editor)
//         {
//             return false;
//         }

//         let state = {};

//         if(
//             editor.mode ===
//             'code'
//         ) {

//             state =
//                 AutomatorEditorGetCodeState(
//                     editor
//                 );

//         } else {

//             state =
//                 AutomatorEditorGetVisualState(
//                     editor
//                 );
//         }

//         AutomatorEditorClearToolbarState(
//             editor
//         );

//         Object.keys(
//             state
//         )
//         .forEach(
//             function(command)
//             {
//                 AutomatorEditorSetButtonState(
//                     editor,
//                     command,
//                     state[
//                         command
//                     ]
//                 );
//             }
//         );

//         /*
//         |--------------------------------------------------------------------------
//         | Callback
//         |--------------------------------------------------------------------------
//         */

//         if(
//             typeof editor
//                 .config
//                 .callbacks
//                 .onSelectionChange ===
//             'function'
//         ) {

//             editor
//                 .config
//                 .callbacks
//                 .onSelectionChange(
//                     editor,
//                     state
//                 );
//         }

//         // return state;

//         /*
//         |--------------------------------------------------------------------------
//         | Sync toolbar controls
//         |--------------------------------------------------------------------------
//         */

//         if(
//             typeof
//             AutomatorEditorSyncToolbarControls
//             ===
//             'function'
//         ) {

//             AutomatorEditorSyncToolbarControls(
//                 editor
//             );
//         }

//         return state;
//     };



//     window.AutomatorEditorSyncToolbarControls =
//     function(editor)
//     {
//         if(!editor)
//         {
//             return false;
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | References
//         |--------------------------------------------------------------------------
//         */

//         let formatSelect =
//             editor.toolbar.find(
//                 '[data-command="formatBlock"]'
//             );

//         let fontFamilySelect =
//             editor.toolbar.find(
//                 '[data-command="fontFamily"]'
//             );

//         let fontSizeSelect =
//             editor.toolbar.find(
//                 '[data-command="fontSize"]'
//             );

//         let foreColor =
//             editor.toolbar.find(
//                 '[data-command="foreColor"]'
//             );

//         let hiliteColor =
//             editor.toolbar.find(
//                 '[data-command="hiliteColor"]'
//             );

//         /*
//         |--------------------------------------------------------------------------
//         | CODE MODE
//         |--------------------------------------------------------------------------
//         */

//         if(
//             editor.mode ===
//             'code'
//         ) {
//             return true;
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Selection
//         |--------------------------------------------------------------------------
//         */

//         let selection =
//             window.getSelection();

//         if(
//             !selection.rangeCount
//         ) {
//             return false;
//         }

//         let node =
//             selection.anchorNode;

//         if(!node)
//         {
//             return false;
//         }

//         if(
//             node.nodeType ===
//             3
//         ) {
//             node =
//                 node.parentNode;
//         }

//         let $node =
//             $(node);

//         /*
//         |--------------------------------------------------------------------------
//         | Format block
//         |--------------------------------------------------------------------------
//         */

//         let heading =
//             $node.closest(
//                 'h1,h2,h3,h4,p'
//             );

//         if(
//             heading.length
//         ) {

//             formatSelect.val(
//                 heading
//                 .prop(
//                     'tagName'
//                 )
//                 .toUpperCase()
//             );

//         } else {

//             formatSelect.val(
//                 'P'
//             );
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Font family
//         |--------------------------------------------------------------------------
//         */

//         let family =
//             $node.css(
//                 'font-family'
//             );

//         if(
//             family
//         ) {

//             family =
//                 family
//                 .split(',')
//                 [0]
//                 .replace(/["']/g,'');

//             fontFamilySelect.val(
//                 family
//             );
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Font size
//         |--------------------------------------------------------------------------
//         */

//         let size =
//             $node.css(
//                 'font-size'
//             );

//         if(
//             size
//         ) {

//             fontSizeSelect.val(
//                 size
//             );
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Text color
//         |--------------------------------------------------------------------------
//         */

//         let color =
//             $node.css(
//                 'color'
//             );

//         if(
//             color
//         ) {

//             foreColor.val(
//                 AutomatorEditorRgbToHex(
//                     color
//                 )
//             );
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | Highlight color
//         |--------------------------------------------------------------------------
//         */

//         let bg =
//             $node.css(
//                 'background-color'
//             );

//         if(
//             bg
//             &&
//             bg !==
//             'rgba(0, 0, 0, 0)'
//         ) {

//             hiliteColor.val(
//                 AutomatorEditorRgbToHex(
//                     bg
//                 )
//             );
//         }

//         return true;
//     };


//     window.AutomatorEditorRgbToHex =
//     function(rgb)
//     {
//         if(!rgb)
//         {
//             return '#000000';
//         }

//         if(
//             rgb.indexOf('#')
//             ===
//             0
//         ) {
//             return rgb;
//         }

//         let result =
//             rgb.match(/\d+/g);

//         if(
//             !result
//         ) {
//             return '#000000';
//         }

//         return '#'
//             +
//             (
//                 (1 << 24)
//                 +
//                 (
//                     parseInt(
//                         result[0]
//                     ) << 16
//                 )
//                 +
//                 (
//                     parseInt(
//                         result[1]
//                     ) << 8
//                 )
//                 +
//                 parseInt(
//                     result[2]
//                 )
//             )
//             .toString(16)
//             .slice(1);
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | Bind editor selection events
//     |--------------------------------------------------------------------------
//     */

//     window.AutomatorEditorBindSelectionEvents =
//     function(editor)
//     {
//         if(!editor)
//         {
//             return false;
//         }

//         let selector =
//             '.automator-editor-visual, ' +
//             '.automator-editor-code';

//         editor.wrapper
//             .off(
//                 'keyup.mouseup.selection click focus',
//                 selector
//             );

//         editor.wrapper
//             .on(
//                 'keyup mouseup click focus',
//                 selector,
//                 function()
//                 {
//                     setTimeout(
//                         function(){

//                             AutomatorEditorUpdateToolbarState(
//                                 editor
//                             );

//                         },
//                         5
//                     );
//                 }
//             );
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | Global selection change
//     |--------------------------------------------------------------------------
//     */

//     $(document).on(
//         'selectionchange',
//         function()
//         {
//             Object.values(
//                 window
//                 .AutomatorEditors
//             )
//             .forEach(
//                 function(editor)
//                 {
//                     if(
//                         !editor
//                     ){
//                         return;
//                     }

//                     if(
//                         editor.wrapper
//                         .find(':focus')
//                         .length
//                     ) {

//                         AutomatorEditorUpdateToolbarState(
//                             editor
//                         );
//                     }
//                 }
//             );
//         }
//     );

//     /*
//     |--------------------------------------------------------------------------
//     | Toggle buttons (remove/apply)
//     |--------------------------------------------------------------------------
//     */

//     let originalExec =
//         window
//         .AutomatorEditorExecCommand;

//     window.AutomatorEditorExecCommand =
//     function(
//         editor,
//         command,
//         value = null,
//         trigger = null
//     )
//     {
//         let result =
//             originalExec(
//                 editor,
//                 command,
//                 value,
//                 trigger
//             );

//         setTimeout(
//             function(){

//                 AutomatorEditorUpdateToolbarState(
//                     editor
//                 );

//             },
//             5
//         );

//         return result;
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | Bind after render
//     |--------------------------------------------------------------------------
//     */

//     $(document).on(
//         'automator-editor-rendered',
//         function(
//             e,
//             editor
//         )
//         {
//             AutomatorEditorBindSelectionEvents(
//                 editor
//             );

//             setTimeout(
//                 function(){

//                     AutomatorEditorUpdateToolbarState(
//                         editor
//                     );

//                 },
//                 50
//             );
//         }
//     );

// })(jQuery);


// (function ($) {

//     /*
//     |--------------------------------------------------------------------------
//     | Wrap selection HTML
//     |--------------------------------------------------------------------------
//     */

//     window.AutomatorEditorWrapSelection =
//     function(
//         editor,
//         before,
//         after = ''
//     )
//     {
//         if(
//             !editor
//         ){
//             return false;
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | CODE MODE
//         |--------------------------------------------------------------------------
//         */

//         if(
//             editor.mode ===
//             'code'
//         ) {

//             let textarea =
//                 editor.code[0];

//             let start =
//                 textarea.selectionStart;

//             let end =
//                 textarea.selectionEnd;

//             let text =
//                 textarea.value;

//             let selected =
//                 text.substring(
//                     start,
//                     end
//                 );

//             textarea.value =
//                 text.substring(
//                     0,
//                     start
//                 )
//                 +
//                 before
//                 +
//                 selected
//                 +
//                 after
//                 +
//                 text.substring(
//                     end
//                 );

//             textarea.focus();

//             textarea.selectionStart =
//                 start;

//             textarea.selectionEnd =
//                 start
//                 +
//                 before.length
//                 +
//                 selected.length
//                 +
//                 after.length;

//             editor.visual.html(
//                 textarea.value
//             );

//             AutomatorEditorSyncToSource(
//                 editor
//             );

//             return true;
//         }

//         /*
//         |--------------------------------------------------------------------------
//         | VISUAL MODE
//         |--------------------------------------------------------------------------
//         */

//         AutomatorEditorFocus(
//             editor
//         );

//         let selection =
//             window.getSelection();

//         if(
//             !selection.rangeCount
//         ) {
//             return false;
//         }

//         let range =
//             selection.getRangeAt(
//                 0
//             );

//         let content =
//             range.extractContents();

//         let wrapper =
//             document.createElement(
//                 'span'
//             );

//         wrapper.innerHTML =
//             before +
//             content.textContent +
//             after;

//         range.insertNode(
//             wrapper
//         );

//         AutomatorEditorSyncToSource(
//             editor
//         );

//         return true;
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | Open modal hook
//     |--------------------------------------------------------------------------
//     */

//     window.AutomatorEditorOpenActionModal =
//     function(
//         editor,
//         type = 'link'
//     )
//     {
//         let modalId =
//             'automator-editor-modal-' +
//             Date.now();

//         let title =
//             type === 'image'
//             ?
//             'Inserir imagem'
//             :
//             'Inserir link';

//         $('body').append(`
//             <div
//                 class="modal fade"
//                 id="${modalId}"
//                 tabindex="-1"
//             >
//                 <div
//                     class="modal-dialog modal-dialog-centered"
//                 >
//                     <div
//                         class="modal-content"
//                     >

//                         <div
//                             class="modal-header"
//                         >

//                             <h5
//                                 class="modal-title w-100 text-center"
//                             >
//                                 ${title}
//                             </h5>

//                             <button
//                                 type="button"
//                                 class="btn-close"
//                                 data-bs-dismiss="modal"
//                             ></button>

//                         </div>

//                         <div
//                             class="modal-body"
//                         >
//                             Inserir campos aqui
//                         </div>

//                         <div
//                             class="modal-footer"
//                         >

//                             <button
//                                 type="button"
//                                 class="btn btn-secondary"
//                                 data-bs-dismiss="modal"
//                             >
//                                 Cancelar
//                             </button>

//                             <button
//                                 type="button"
//                                 class="btn btn-primary automator-editor-modal-submit"
//                             >
//                                 Aplicar
//                             </button>

//                         </div>

//                     </div>
//                 </div>
//             </div>
//         `);

//         let modalEl =
//             document.getElementById(
//                 modalId
//             );

//         let modal =
//             new bootstrap.Modal(
//                 modalEl,
//                 {
//                     backdrop: true,
//                     keyboard: true
//                 }
//             );

//         /*
//         |--------------------------------------------------------------------------
//         | Layer over modal
//         |--------------------------------------------------------------------------
//         */

//         $(modalEl)
//             .css(
//                 'z-index',
//                 999999
//             );

//         $(modalEl)
//             .on(
//                 'shown.bs.modal',
//                 function()
//                 {
//                     $('.modal-backdrop')
//                         .last()
//                         .css(
//                             'z-index',
//                             999998
//                         );
//                 }
//             );

//         /*
//         |--------------------------------------------------------------------------
//         | Submit hook
//         |--------------------------------------------------------------------------
//         */

//         $(modalEl)
//             .find(
//                 '.automator-editor-modal-submit'
//             )
//             .on(
//                 'click',
//                 function()
//                 {
//                     console.log(
//                         'implementar depois'
//                     );
//                 }
//             );

//         /*
//         |--------------------------------------------------------------------------
//         | Destroy
//         |--------------------------------------------------------------------------
//         */

//         $(modalEl)
//             .on(
//                 'hidden.bs.modal',
//                 function()
//                 {
//                     $(this)
//                         .remove();
//                 }
//             );

//         modal.show();

//         return modal;
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | Link modal hook
//     |--------------------------------------------------------------------------
//     */

//     window.AutomatorEditorOpenLinkModal =
//     function(editor)
//     {
//         return AutomatorEditorOpenActionModal(
//             editor,
//             'link'
//         );
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | Image modal hook
//     |--------------------------------------------------------------------------
//     */

//     window.AutomatorEditorOpenImageModal =
//     function(editor)
//     {
//         return AutomatorEditorOpenActionModal(
//             editor,
//             'image'
//         );
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | Public API
//     |--------------------------------------------------------------------------
//     */

//     window.AutomatorEditorInsertLink =
//     function(
//         editor,
//         html
//     )
//     {
//         if(
//             !editor
//         ){
//             return false;
//         }

//         if(
//             editor.mode ===
//             'code'
//         ) {

//             editor.code
//                 .val(
//                     editor.code.val()
//                     + html
//                 );

//         } else {

//             document.execCommand(
//                 'insertHTML',
//                 false,
//                 html
//             );
//         }

//         AutomatorEditorSyncToSource(
//             editor
//         );

//         return true;
//     };

//     window.AutomatorEditorInsertImage =
//     function(
//         editor,
//         html
//     )
//     {
//         return window
//             .AutomatorEditorInsertLink(
//                 editor,
//                 html
//             );
//     };

//     /*
//     |--------------------------------------------------------------------------
//     | Fullscreen
//     |--------------------------------------------------------------------------
//     */

//     window.AutomatorEditorToggleFullscreen =
//     function(editor)
//     {
//         if(!editor)
//         {
//             return false;
//         }

//         editor.wrapper.toggleClass(
//             'automator-editor-fullscreen'
//         );

//         return true;
//     };

// })(jQuery);


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

  var tooltipText = '';

  if (el.hasClass('automator-input-password')) {

    el.removeClass('automator-input-password');

    btn.find('i')
      .removeClass('fa-eye')
      .addClass('fa-eye-slash');

    tooltipText = hide;

  } else {

    el.addClass('automator-input-password');

    btn.find('i')
      .removeClass('fa-eye-slash')
      .addClass('fa-eye');

    tooltipText = show;

  }

  btn.attr('data-bs-title', tooltipText);
  btn.attr('title', tooltipText);

  var tooltipInstance = bootstrap.Tooltip.getInstance(btn[0]);

  if (tooltipInstance) {

    tooltipInstance.setContent({
      '.tooltip-inner': tooltipText
    });

  } else {

    new bootstrap.Tooltip(btn[0]);

  }

}
// function AutomatorPasswordInputBTN(btn, el) {

//   var btn = $(btn);
//   var el  = $('#' + el);

//   var show = btn.attr('data-show');
//   var hide = btn.attr('data-hide');

//   if(el.hasClass('automator-input-password')) {

//     el.removeClass('automator-input-password');
//     btn.find('i').removeClass('fa-eye').addClass('fa-eye-slash');
//     btn.attr('data-bs-title', hide);

//   } else {

//     el.addClass('automator-input-password');
//     btn.find('i').removeClass('fa-eye-slash').addClass('fa-eye');
//     btn.attr('data-bs-title', show);

//   }

// }



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
    toastContainer.style.zIndex = '3000';

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
    toastBackdrop.style.zIndex = '2990';

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



function AutomatorClearModalFocus(modalEl = null) {

  if(!modalEl) {
    return false;
  }

  var activeElement = document.activeElement;

  if(activeElement && modalEl.contains(activeElement) && typeof activeElement.blur === 'function') {
    activeElement.blur();
  }

  if(document.activeElement && modalEl.contains(document.activeElement) && document.body && typeof document.body.focus === 'function') {
    document.body.focus();
  }

  return true;

}



document.addEventListener('hide.bs.modal', function(e) {

  if(e && e.target) {
    AutomatorClearModalFocus(e.target);
  }

}, true);



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

    AutomatorSetActionStatus(true);

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
    AutomatorClearModalFocus(modalEl);
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
  var resetActionStatusOnShown = (context.resetActionStatusOnShown !== undefined) ? AutomatorNormalizeBoolean(context.resetActionStatusOnShown) : false;
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

    $('#page-loader').css('z-index', '1060');

    if(resetActionStatusOnShown == true) {
      AutomatorSetActionStatus(false);
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

    AutomatorSetActionStatus(true);

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
              } else {
                $('#page-loader').css('z-index', '1085');
              }

              if(resetActionStatusOnSuccess == true) {
                AutomatorSetActionStatus(false);
              } else {
                AutomatorSetActionStatus(true);
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

                AutomatorSetActionStatus(false);

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

              AutomatorSetActionStatus(false);

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

// ========================================


  /*
  |--------------------------------------------------------------------------
  | Localiza o botão submit de um formulário renderizado na página
  |--------------------------------------------------------------------------
  */

  function AutomatorGetSystemPageFormSubmitButton(formEl = null) {


    if(!formEl) {

      return null;

    }


    /*
    |--------------------------------------------------------------------------
    | Primeiro procura dentro do próprio formulário
    |--------------------------------------------------------------------------
    */

    var submitBtn = formEl.querySelector(

      '.js-automator-pagination-modal-submit[type="submit"],' +
      'button[type="submit"],' +
      'input[type="submit"]'

    );


    if(submitBtn) {

      return submitBtn;

    }


    /*
    |--------------------------------------------------------------------------
    | Procura botão externo vinculado pelo atributo form
    |--------------------------------------------------------------------------
    */

    var formID = formEl.getAttribute('id') || '';


    if(formID === '') {

      return null;

    }


    return document.querySelector(

      '[type="submit"][form="' + CSS.escape(formID) + '"]'

    );


  }


/*
  |--------------------------------------------------------------------------
  | Atualiza o status de alteração do formulário de página
  |--------------------------------------------------------------------------
  */

  function AutomatorUpdateSystemPageFormChangedStatus(

    formEl = null,

    submitBtn = null

  ) {


    if(!formEl) {

      return false;

    }


    if(!submitBtn) {

      submitBtn = AutomatorGetSystemPageFormSubmitButton(

        formEl

      );

    }


    var changed = AutomatorFormHasChanged(formEl);


    formEl.setAttribute(

      'data-automator-form-changed',

      changed ? 'true' : 'false'

    );


    if(submitBtn) {

      submitBtn.disabled = !changed;

    }


    return changed;


  }


  /*
  |--------------------------------------------------------------------------
  | Verifica alterações pendentes em formulários não modais
  |--------------------------------------------------------------------------
  */

  function AutomatorSystemPageFormsHaveChanges() {


    var forms = document.querySelectorAll(

      'form[data-automator-system-form="true"]'

    );


    for(var index = 0; index < forms.length; index++) {


      if(

        forms[index].getAttribute(

          'data-automator-form-changed'

        ) === 'true'

      ) {

        return true;

      }


    }


    return false;


  }


  /*
  |--------------------------------------------------------------------------
  | Aviso ao sair da página com alterações não salvas
  |--------------------------------------------------------------------------
  */

  function AutomatorBindSystemPageFormsBeforeUnload() {


    $(window)

      .off('beforeunload.AutomatorSystemPageForms')

      .on(

        'beforeunload.AutomatorSystemPageForms',

        function(e) {


          if(

            AutomatorSystemPageFormsHaveChanges() !== true

          ) {

            return;

          }


          var message =

            'Existem alterações não salvas. Ao sair, as informações alteradas poderão ser perdidas.';


          e.preventDefault();

          e.returnValue = message;


          return message;


        }

      );


    return true;


  }



  /*
  |--------------------------------------------------------------------------
  | Inicializa observação de um formulário não modal
  |--------------------------------------------------------------------------
  */

  function AutomatorInitSystemPageFormChangeObserver(

    formEl = null

  ) {


    if(!formEl) {

      return false;

    }


    if(

      formEl.getAttribute(

        'data-automator-system-form'

      ) !== 'true'

    ) {

      return false;

    }


    /*
    |--------------------------------------------------------------------------
    | Evita cadastrar os eventos mais de uma vez
    |--------------------------------------------------------------------------
    */

    if(

      formEl.getAttribute(

        'data-automator-change-observer-initialized'

      ) === 'true'

    ) {

      return true;

    }


    var submitBtn =

      AutomatorGetSystemPageFormSubmitButton(

        formEl

      );


    /*
    |--------------------------------------------------------------------------
    | Registra o estado inicial
    |--------------------------------------------------------------------------
    */

    formEl.setAttribute(

      'data-automator-initial-state',

      AutomatorFormSerializeCurrentState(formEl)

    );


    formEl.setAttribute(

      'data-automator-form-changed',

      'false'

    );


    formEl.setAttribute(

      'data-automator-change-observer-initialized',

      'true'

    );


    if(submitBtn) {

      submitBtn.disabled = true;

    }


    /*
    |--------------------------------------------------------------------------
    | Função comum de atualização
    |--------------------------------------------------------------------------
    */

    var updateChangedStatus = function() {


      AutomatorUpdateSystemPageFormChangedStatus(

        formEl,

        submitBtn

      );


    };


    /*
    |--------------------------------------------------------------------------
    | Eventos nativos
    |--------------------------------------------------------------------------
    */

    formEl.addEventListener(

      'input',

      updateChangedStatus

    );


    formEl.addEventListener(

      'change',

      updateChangedStatus

    );


    formEl.addEventListener(

      'keyup',

      updateChangedStatus

    );


    /*
    |--------------------------------------------------------------------------
    | Reset
    |--------------------------------------------------------------------------
    |
    | O evento reset ocorre antes dos campos voltarem aos valores originais.
    | O setTimeout permite comparar depois que o navegador concluir o reset.
    |
    */

    formEl.addEventListener(

      'reset',

      function() {


        setTimeout(

          function() {


            AutomatorUpdateSystemPageFormChangedStatus(

              formEl,

              submitBtn

            );


          },

          0

        );


      }

    );


    /*
    |--------------------------------------------------------------------------
    | Eventos customizados usados por componentes e editores
    |--------------------------------------------------------------------------
    */

    $(formEl)

      .off(

        '.AutomatorSystemPageFormChanges'

      )

      .on(

        'automator:change.AutomatorSystemPageFormChanges ' +

        'automator:editor-change.AutomatorSystemPageFormChanges ' +

        'select2:select.AutomatorSystemPageFormChanges ' +

        'select2:unselect.AutomatorSystemPageFormChanges',

        function() {


          updateChangedStatus();


        }

      );


    AutomatorBindSystemPageFormsBeforeUnload();


    return true;


  }



  /*
  |--------------------------------------------------------------------------
  | Inicializa todos os formulários não modais da página
  |--------------------------------------------------------------------------
  */

  function AutomatorInitSystemPageFormChangeObservers(

    container = document

  ) {


    if(!container) {

      container = document;

    }


    var forms = [];


    /*
    |--------------------------------------------------------------------------
    | O próprio container pode ser um formulário
    |--------------------------------------------------------------------------
    */

    if(

      container.matches &&

      container.matches(

        'form[data-automator-system-form="true"]'

      )

    ) {

      forms.push(container);

    }


    /*
    |--------------------------------------------------------------------------
    | Formulários descendentes
    |--------------------------------------------------------------------------
    */

    if(container.querySelectorAll) {


      container

        .querySelectorAll(

          'form[data-automator-system-form="true"]'

        )

        .forEach(function(formEl) {


          if(!forms.includes(formEl)) {

            forms.push(formEl);

          }


        });


    }


    forms.forEach(function(formEl) {


      AutomatorInitSystemPageFormChangeObserver(

        formEl

      );


    });


    return forms.length;


  }


  /*
  |--------------------------------------------------------------------------
  | Redefine o estado inicial do formulário não modal
  |--------------------------------------------------------------------------
  */

  function AutomatorResetSystemPageFormChangedState(

    formEl = null

  ) {


    if(!formEl) {

      return false;

    }


    var submitBtn =

      AutomatorGetSystemPageFormSubmitButton(

        formEl

      );


    formEl.setAttribute(

      'data-automator-initial-state',

      AutomatorFormSerializeCurrentState(formEl)

    );


    formEl.setAttribute(

      'data-automator-form-changed',

      'false'

    );


    if(submitBtn) {

      submitBtn.disabled = true;

    }


    return true;


  }


// ========================================


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

        } else if(tagName == 'textarea' && field.classList.contains('automator-editor')) {

          /*
          |--------------------------------------------------------------------------
          | Editor field — set value on the hidden textarea AND update the
          | live editor instance (visual + code panes) so the content is not lost.
          |
          | Two scenarios are handled:
          |   A) Editor already rendered: instance exists in window.AutomatorEditors
          |      → update visual/code panes directly via the stored references.
          |   B) Editor not yet rendered (populate ran before AutomatorEditorRender):
          |      → just set the textarea value; AutomatorEditorRender will pick it
          |        up normally when it runs afterwards.
          |--------------------------------------------------------------------------
          */

          var editorContent = (value !== null && value !== undefined) ? String(value) : '';

          // Always keep the source textarea in sync so AutomatorEditorRender can
          // read the correct value if the editor has not been initialised yet.
          field.value = editorContent;

          // If the editor instance is already live, push the content into it.
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
      resetActionStatusOnShown: true,
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

      /*
      |--------------------------------------------------------------------------
      | Populate fields FIRST, before AutomatorEditorAutoRender runs.
      |
      | AutomatorEditorRender reads the textarea value at init time.
      | If populate runs after the editor is already rendered the visual pane
      | will be blank because the editor hides the original textarea and only
      | the editor API can update the visual content afterwards.
      |
      | Correct order:
      |   1. Populate fields (textarea.value = recordData value)
      |   2. Render editors (reads the now-correct textarea value)
      |   3. Everything else (tooltips, change observer, action status)
      |--------------------------------------------------------------------------
      */

      if(recordData && typeof recordData === 'object') {
        AutomatorPaginationModalPopulateFields(modalEl, recordData);
      }

      // Render editors AFTER populate so they read the correct textarea values.
      AutomatorEditorAutoRender(modalEl);

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

        console.log(window.AutomatorRoutes);
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
    resetActionStatusOnShown: true,
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


(function ($) {

    window.AutomatorEditors = window.AutomatorEditors || {};

    window.AutomatorEditorDefaults = {

        height: 350,
        minHeight: 200,
        maxHeight: null,

        mode: 'visual',

        placeholder: 'Digite aqui...',

        toolbar: [],

        debug: false,

        allowHtml: true,

        fullscreen: true,

        callbacks: {

            onInit: null,
            onChange: null,
            onModeChange: null,
            onSelectionChange: null,
            beforeCommand: null,
            afterCommand: null
        }
    };

    /**
     * Renderiza um ou vários editores
     *
     * @param selector
     * @param options
     * @returns {*}
     */
    window.AutomatorEditorRender = function (
        selector = '.automator-editor',
        options = {}
    ) {

        let elements = $();

        /*
        |--------------------------------------------------------------------------
        | Resolve selector
        |--------------------------------------------------------------------------
        */


        if (
            selector instanceof jQuery
        ) {

            if (
                selector.hasClass(
                    'automator-editor'
                )
            ) {

                elements = selector;

            } else {

                elements =
                    selector.find(
                        '.automator-editor'
                    );
            }

        } else if (
            selector instanceof HTMLElement
        ) {

            let $el =
                $(selector);

            if (
                $el.hasClass(
                    'automator-editor'
                )
            ) {

                elements = $el;

            } else {

                elements =
                    $el.find(
                        '.automator-editor'
                    );
            }

        } else if (
            typeof selector ===
            'string'
        ) {

            elements =
                $(selector);

        } else {

            elements =
                $('.automator-editor');
        }

        if (!elements.length) {

            return [];
        }

        let instances = [];

        /*
        |--------------------------------------------------------------------------
        | Multi instance
        |--------------------------------------------------------------------------
        */

        elements.each(function () {

            let $source = $(this);

            /*
            |--------------------------------------------------------------------------
            | Prevent double render
            |--------------------------------------------------------------------------
            */

            if (
                $source.data(
                    'automator-editor-loaded'
                )
            ) {
                return true;
            }

            /*
            |--------------------------------------------------------------------------
            | Unique ID
            |--------------------------------------------------------------------------
            */

            let editorId =
                $source.attr('id')
                ||
                'automator-editor-' +
                Math.random()
                    .toString(36)
                    .substring(2, 15);

            $source.attr(
                'data-automator-editor-id',
                editorId
            );

            /*
            |--------------------------------------------------------------------------
            | Config
            |--------------------------------------------------------------------------
            */

            let config = $.extend(
                true,
                {},
                window.AutomatorEditorDefaults,
                options
            );

            /*
            |--------------------------------------------------------------------------
            | Read data attributes
            |--------------------------------------------------------------------------
            */

            if (
                $source.data('height')
            ) {

                config.height =
                    parseInt(
                        $source.data('height')
                    );
            }

            if (
                $source.data('mode')
            ) {

                config.mode =
                    $source.data('mode');
            }

            if (
                $source.data('placeholder')
            ) {

                config.placeholder =
                    $source.data(
                        'placeholder'
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | Original value
            |--------------------------------------------------------------------------
            */

            let originalContent = '';

            if (
                $source.is('textarea')
            ) {

                /*
                |--------------------------------------------------------------------------
                | Try jQuery value
                |--------------------------------------------------------------------------
                */

                originalContent =
                    $source.val();

                /*
                |--------------------------------------------------------------------------
                | Fallback textarea innerHTML/text
                |--------------------------------------------------------------------------
                */

                if (
                    originalContent ===
                    null
                    ||
                    originalContent ===
                    undefined
                    ||
                    String(
                        originalContent
                    ).trim() === ''
                ) {

                    originalContent =
                        $source[0]
                        ?.value
                        ||
                        $source.text()
                        ||
                        $source.html()
                        ||
                        '';
                }

            } else {

                originalContent =
                    $source.html()
                    ||
                    $source.text()
                    ||
                    '';
            }

            /*
            |--------------------------------------------------------------------------
            | Normalize
            |--------------------------------------------------------------------------
            */

            originalContent =
                String(
                    originalContent
                );


            /*
            |--------------------------------------------------------------------------
            | Wrapper
            |--------------------------------------------------------------------------
            */

            let $wrapper = $(`
                <div 
                    class="automator-editor-wrapper card"
                    data-editor-id="${editorId}"
                >
                    <div 
                        class="automator-editor-toolbar border-bottom"
                    ></div>

                    <div 
                        class="automator-editor-body"
                    >
                        <div
                            class="automator-editor-visual"
                            contenteditable="true"
                        ></div>

                        <textarea
                            class="automator-editor-code form-control d-none"
                        ></textarea>
                    </div>
                </div>
            `);

            /*
            |--------------------------------------------------------------------------
            | Apply height
            |--------------------------------------------------------------------------
            */

            $wrapper.find(
                '.automator-editor-body'
            ).css({

                height:
                    config.height +
                    'px',

                minHeight:
                    config.minHeight +
                    'px'
            });

            if (
                config.maxHeight
            ) {

                $wrapper.find(
                    '.automator-editor-body'
                ).css({
                    maxHeight:
                        config.maxHeight +
                        'px'
                });
            }

            /*
            |--------------------------------------------------------------------------
            | Replace DOM
            |--------------------------------------------------------------------------
            */

            $source.after(
                $wrapper
            );

            /*
            |--------------------------------------------------------------------------
            | Hide original element
            |--------------------------------------------------------------------------
            */

            $source.hide();

            /*
            |--------------------------------------------------------------------------
            | References
            |--------------------------------------------------------------------------
            */

            let $visual =
                $wrapper.find(
                    '.automator-editor-visual'
                );

            let $code =
                $wrapper.find(
                    '.automator-editor-code'
                );

            let $toolbar =
                $wrapper.find(
                    '.automator-editor-toolbar'
                );

            /*
            |--------------------------------------------------------------------------
            | Set content
            |--------------------------------------------------------------------------
            */

            $visual.html(
                originalContent
            );

            $code.val(
                originalContent
            );

            /*
            |--------------------------------------------------------------------------
            | Placeholder
            |--------------------------------------------------------------------------
            */

            $visual.attr(
                'data-placeholder',
                config.placeholder
            );

            /*
            |--------------------------------------------------------------------------
            | Initial mode
            |--------------------------------------------------------------------------
            */

            if (
                config.mode ===
                'code'
            ) {

                $visual.addClass(
                    'd-none'
                );

                $code.removeClass(
                    'd-none'
                );

            } else {

                $code.addClass(
                    'd-none'
                );

                $visual.removeClass(
                    'd-none'
                );
            }

            /*
            |--------------------------------------------------------------------------
            | Registry
            |--------------------------------------------------------------------------
            */

            let editorObject = {

                id: editorId,

                config: config,

                source: $source,

                wrapper: $wrapper,

                toolbar: $toolbar,

                visual: $visual,

                code: $code,

                mode:
                    config.mode,

                isRendered: true,

                selection:
                    null
            };

            window.AutomatorEditors[
                editorId
            ] = editorObject;

            /*
            |--------------------------------------------------------------------------
            | Flag initialized
            |--------------------------------------------------------------------------
            */

            $source.data(
                'automator-editor-loaded',
                true
            );

            /*
            |--------------------------------------------------------------------------
            | Trigger init callback
            |--------------------------------------------------------------------------
            */

            if (
                typeof config
                    .callbacks
                    .onInit ===
                'function'
            ) {

                config.callbacks
                    .onInit(
                        editorObject
                    );
            }

            /*
            |--------------------------------------------------------------------------
            | Debug
            |--------------------------------------------------------------------------
            */

            if (
                config.debug
            ) {

                console.log(
                    'AutomatorEditor initialized:',
                    editorObject
                );
            }

            instances.push(
                editorObject
            );

            $(document).trigger(
              'automator-editor-rendered',
              [editorObject]
            );

        });

        return instances;
    };

})(jQuery);


(function ($) {

    /*
    |--------------------------------------------------------------------------
    | Default toolbar
    |--------------------------------------------------------------------------
    */

    // window.AutomatorEditorToolbarDefaults = [

    //     {
    //         type: 'group',
    //         items: [

    //             {
    //                 type: 'button',
    //                 command: 'bold',
    //                 icon: 'fa fa-bold',
    //                 title: 'Negrito'
    //             },

    //             {
    //                 type: 'button',
    //                 command: 'italic',
    //                 icon: 'fa fa-italic',
    //                 title: 'Itálico'
    //             },

    //             {
    //                 type: 'button',
    //                 command: 'underline',
    //                 icon: 'fa fa-underline',
    //                 title: 'Sublinhado'
    //             },

    //             {
    //                 type: 'button',
    //                 command: 'strikeThrough',
    //                 icon: 'fa fa-strikethrough',
    //                 title: 'Tachado'
    //             }
    //         ]
    //     },

    //     {
    //         type: 'group',
    //         items: [

    //             {
    //                 type: 'select',
    //                 command: 'formatBlock',
    //                 title: 'Formato',

    //                 options: [
    //                     {
    //                         label: 'Parágrafo',
    //                         value: 'P'
    //                     },
    //                     {
    //                         label: 'Título H1',
    //                         value: 'H1'
    //                     },
    //                     {
    //                         label: 'Título H2',
    //                         value: 'H2'
    //                     },
    //                     {
    //                         label: 'Título H3',
    //                         value: 'H3'
    //                     },
    //                     {
    //                         label: 'Título H4',
    //                         value: 'H4'
    //                     }
    //                 ]
    //             },

    //             {
    //                 type: 'select',
    //                 command: 'fontSize',
    //                 title: 'Tamanho',

    //                 options: [
    //                     { label: '10px', value: '1' },
    //                     { label: '12px', value: '2' },
    //                     { label: '14px', value: '3' },
    //                     { label: '18px', value: '4' },
    //                     { label: '24px', value: '5' },
    //                     { label: '32px', value: '6' },
    //                     { label: '48px', value: '7' }
    //                 ]
    //             }
    //         ]
    //     },

    //     {
    //         type: 'group',
    //         items: [

    //             {
    //                 type: 'button',
    //                 command: 'justifyLeft',
    //                 icon: 'fa fa-align-left',
    //                 title: 'Alinhar esquerda'
    //             },

    //             {
    //                 type: 'button',
    //                 command: 'justifyCenter',
    //                 icon: 'fa fa-align-center',
    //                 title: 'Centralizar'
    //             },

    //             {
    //                 type: 'button',
    //                 command: 'justifyRight',
    //                 icon: 'fa fa-align-right',
    //                 title: 'Alinhar direita'
    //             }
    //         ]
    //     },

    //     {
    //         type: 'group',
    //         items: [

    //             {
    //                 type: 'button',
    //                 command: 'insertUnorderedList',
    //                 icon: 'fa fa-list',
    //                 title: 'Lista'
    //             },

    //             {
    //                 type: 'button',
    //                 command: 'insertOrderedList',
    //                 icon: 'fa fa-list-ol',
    //                 title: 'Lista numerada'
    //             }
    //         ]
    //     },

    //     {
    //         type: 'group',
    //         items: [

    //             {
    //                 type: 'button',
    //                 command: 'undo',
    //                 icon: 'fa fa-rotate-left',
    //                 title: 'Desfazer'
    //             },

    //             {
    //                 type: 'button',
    //                 command: 'redo',
    //                 icon: 'fa fa-rotate-right',
    //                 title: 'Refazer'
    //             }
    //         ]
    //     },

    //     {
    //         type: 'group',
    //         items: [

    //             {
    //                 type: 'button',
    //                 command: 'toggleCode',
    //                 icon: 'fa fa-code',
    //                 title: 'Modo código'
    //             }
    //         ]
    //     }
    // ];

    window.AutomatorEditorToolbarDefaults = [

        /*
        |--------------------------------------------------------------------------
        | TEXT STYLE
        |--------------------------------------------------------------------------
        */

        {
            type: 'group',
            items: [

                {
                    type: 'button',
                    command: 'bold',
                    icon: 'fas fa-bold',
                    title: 'Negrito'
                },

                {
                    type: 'button',
                    command: 'italic',
                    icon: 'fas fa-italic',
                    title: 'Itálico'
                },

                {
                    type: 'button',
                    command: 'underline',
                    icon: 'fas fa-underline',
                    title: 'Sublinhado'
                },

                {
                    type: 'button',
                    command: 'strikeThrough',
                    icon: 'fas fa-strikethrough',
                    title: 'Tachado'
                }
            ]
        },

        /*
        |--------------------------------------------------------------------------
        | FONT
        |--------------------------------------------------------------------------
        */

        {
            type: 'group',
            items: [

                {
                    type: 'select',
                    command: 'fontFamily',
                    title: 'Fonte',

                    options: [

                        {
                            label: 'Arial',
                            value: 'Arial'
                        },

                        {
                            label: 'Verdana',
                            value: 'Verdana'
                        },

                        {
                            label: 'Tahoma',
                            value: 'Tahoma'
                        },

                        {
                            label: 'Georgia',
                            value: 'Georgia'
                        },

                        {
                            label: 'Times New Roman',
                            value: 'Times New Roman'
                        },

                        {
                            label: 'Courier New',
                            value: 'Courier New'
                        }
                    ]
                },

                {
                    type: 'select',
                    command: 'fontSize',
                    title: 'Tamanho',

                    options: [

                        {
                            label: '10px',
                            value: '10px'
                        },

                        {
                            label: '12px',
                            value: '12px'
                        },

                        {
                            label: '14px',
                            value: '14px'
                        },

                        {
                            label: '16px',
                            value: '16px'
                        },

                        {
                            label: '18px',
                            value: '18px'
                        },

                        {
                            label: '22px',
                            value: '22px'
                        },

                        {
                            label: '28px',
                            value: '28px'
                        },

                        {
                            label: '36px',
                            value: '36px'
                        }
                    ]
                }
            ]
        },

        /*
        |--------------------------------------------------------------------------
        | COLORS
        |--------------------------------------------------------------------------
        */

        {
            type: 'group',
            items: [

                {
                    type: 'color',
                    command: 'foreColor',
                    title: 'Cor do texto',
                    default: '#000000'
                },

                {
                    type: 'color',
                    command: 'hiliteColor',
                    title: 'Cor de fundo',
                    default: '#ffff00'
                }
            ]
        },

        /*
        |--------------------------------------------------------------------------
        | FORMAT
        |--------------------------------------------------------------------------
        */

        {
            type: 'group',
            items: [

                {
                    type: 'select',
                    command: 'formatBlock',
                    title: 'Formato',

                    options: [

                        {
                            label: 'Parágrafo',
                            value: 'P'
                        },

                        {
                            label: 'Título H1',
                            value: 'H1'
                        },

                        {
                            label: 'Título H2',
                            value: 'H2'
                        },

                        {
                            label: 'Título H3',
                            value: 'H3'
                        },

                        {
                            label: 'Título H4',
                            value: 'H4'
                        }
                    ]
                }
            ]
        },

        /*
        |--------------------------------------------------------------------------
        | ALIGN
        |--------------------------------------------------------------------------
        */

        {
            type: 'group',
            items: [

                {
                    type: 'button',
                    command: 'justifyLeft',
                    icon: 'fas fa-align-left',
                    title: 'Alinhar esquerda'
                },

                {
                    type: 'button',
                    command: 'justifyCenter',
                    icon: 'fas fa-align-center',
                    title: 'Centralizar'
                },

                {
                    type: 'button',
                    command: 'justifyRight',
                    icon: 'fas fa-align-right',
                    title: 'Alinhar direita'
                }
            ]
        },

        /*
        |--------------------------------------------------------------------------
        | LISTS
        |--------------------------------------------------------------------------
        */

        {
            type: 'group',
            items: [

                {
                    type: 'button',
                    command: 'insertUnorderedList',
                    icon: 'fas fa-list-ul',
                    title: 'Lista'
                },

                {
                    type: 'button',
                    command: 'insertOrderedList',
                    icon: 'fas fa-list-ol',
                    title: 'Lista numerada'
                }
            ]
        },

        /*
        |--------------------------------------------------------------------------
        | MEDIA
        |--------------------------------------------------------------------------
        */

        {
            type: 'group',
            items: [

                {
                    type: 'button',
                    command: 'insertLink',
                    icon: 'fas fa-link',
                    title: 'Inserir link'
                },

                {
                    type: 'button',
                    command: 'insertImage',
                    icon: 'fas fa-image',
                    title: 'Inserir imagem'
                }
            ]
        },

        /*
        |--------------------------------------------------------------------------
        | ACTIONS
        |--------------------------------------------------------------------------
        */

        {
            type: 'group',
            items: [

                {
                    type: 'button',
                    command: 'removeFormat',
                    icon: 'fas fa-eraser',
                    title: 'Limpar formatação'
                },

                {
                    type: 'button',
                    command: 'undo',
                    icon: 'fas fa-undo',
                    title: 'Desfazer'
                },

                {
                    type: 'button',
                    command: 'redo',
                    icon: 'fas fa-redo',
                    title: 'Refazer'
                }
            ]
        },

        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */

        {
            type: 'group',
            items: [

                {
                    type: 'button',
                    command: 'fullscreen',
                    icon: 'fas fa-expand',
                    title: 'Tela cheia'
                },

                {
                    type: 'button',
                    command: 'toggleCode',
                    icon: 'fas fa-code',
                    title: 'Modo código'
                }
            ]
        }
    ];

    /*
    |--------------------------------------------------------------------------
    | Toolbar render
    |--------------------------------------------------------------------------
    */

    window.AutomatorEditorBuildToolbar =
        function (editor) {

            let toolbar =
                editor.config.toolbar;

            if (
                !toolbar ||
                !toolbar.length
            ) {

                toolbar =
                    window
                    .AutomatorEditorToolbarDefaults;
            }

            editor.toolbar.empty();

            let html = '';

            toolbar.forEach(
                function (group) {

                    html += `
                        <div 
                            class="btn-group me-2 automator-editor-group"
                            role="group"
                        >
                    `;

                    if (
                        group.items
                    ) {

                        group.items.forEach(
                            function (item) {

                                html +=
                                    window
                                    .AutomatorEditorRenderToolbarItem(
                                        item,
                                        editor
                                    );
                            }
                        );
                    }

                    html += `
                        </div>
                    `;
                }
            );

            editor.toolbar.html(
                html
            );

            window
                .AutomatorEditorBindToolbarEvents(
                    editor
                );
        };

    /*
    |--------------------------------------------------------------------------
    | Render toolbar item
    |--------------------------------------------------------------------------
    */

    // window.AutomatorEditorRenderToolbarItem =
    //     function (
    //         item,
    //         editor
    //     ) {

    //         /*
    //         |--------------------------------------------------------------------------
    //         | BUTTON
    //         |--------------------------------------------------------------------------
    //         */

    //         if (
    //             item.type ===
    //             'button'
    //         ) {

    //             return `
    //                 <button
    //                     type="button"
    //                     class="btn btn-light automator-editor-btn"
    //                     title="${item.title || ''}"
    //                     data-command="${item.command || ''}"
    //                 >
    //                     <i class="${item.icon || 'fas fa-square'}"></i>
    //                 </button>
    //             `;
    //         }

    //         /*
    //         |--------------------------------------------------------------------------
    //         | SELECT
    //         |--------------------------------------------------------------------------
    //         */

    //         if (
    //             item.type ===
    //             'select'
    //         ) {

    //             let options =
    //                 '';

    //             if (
    //                 item.options
    //             ) {

    //                 item.options.forEach(
    //                     function (
    //                         option
    //                     ) {

    //                         options += `
    //                             <option 
    //                                 value="${option.value}"
    //                             >
    //                                 ${option.label}
    //                             </option>
    //                         `;
    //                     }
    //                 );
    //             }

    //             return `
    //                 <select
    //                     class="form-select form-select-sm automator-editor-select"
    //                     data-command="${item.command || ''}"
    //                     title="${item.title || ''}"
    //                 >
    //                     ${options}
    //                 </select>
    //             `;
    //         }

    //         return '';
    //     };

    window.AutomatorEditorRenderToolbarItem =
    function(item, editor)
    {
        /*
        |--------------------------------------------------------------------------
        | BUTTON
        |--------------------------------------------------------------------------
        */

        if(item.type === 'button')
        {
            return `
                <button
                    type="button"
                    class="btn btn-light automator-editor-btn"
                    title="${item.title || ''}"
                    data-command="${item.command || ''}"
                >
                    <i class="${item.icon || ''}"></i>
                </button>
            `;
        }

        /*
        |--------------------------------------------------------------------------
        | SELECT
        |--------------------------------------------------------------------------
        */

        if(item.type === 'select')
        {
            let options = '';

            if(item.options)
            {
                item.options.forEach(function(option){

                    options += `
                        <option
                            value="${option.value}"
                        >
                            ${option.label}
                        </option>
                    `;
                });
            }

            return `
                <select
                    class="form-select form-select-sm automator-editor-select"
                    data-command="${item.command || ''}"
                    title="${item.title || ''}"
                >
                    ${options}
                </select>
            `;
        }

        /*
        |--------------------------------------------------------------------------
        | COLOR PICKER
        |--------------------------------------------------------------------------
        */

        if(item.type === 'color')
        {
            return `
                <input
                    type="color"
                    class="form-control form-control-color automator-editor-color"
                    data-command="${item.command || ''}"
                    value="${item.default || '#000000'}"
                    title="${item.title || ''}"
                >
            `;
        }

        return '';
    };

    /*
    |--------------------------------------------------------------------------
    | Bind toolbar events
    |--------------------------------------------------------------------------
    */

    window.AutomatorEditorBindToolbarEvents =
        function (
            editor
        ) {

            /*
            |--------------------------------------------------------------------------
            | Buttons
            |--------------------------------------------------------------------------
            */

            editor.toolbar
                .find(
                    '.automator-editor-btn'
                )
                .off(
                    'click'
                )
                .on(
                    'click',
                    function () {

                        let btn =
                            $(this);

                        let command =
                            btn.data(
                                'command'
                            );

                        if (
                            typeof window
                                .AutomatorEditorExecCommand
                            ===
                            'function'
                        ) {

                            window
                                .AutomatorEditorExecCommand(
                                    editor,
                                    command,
                                    null,
                                    btn
                                );
                        }
                    }
                );

            /*
            |--------------------------------------------------------------------------
            | Selects
            |--------------------------------------------------------------------------
            */

            editor.toolbar
                .find(
                    '.automator-editor-select'
                )
                .off(
                    'change'
                )
                .on(
                    'change',
                    function () {

                        let select =
                            $(this);

                        let command =
                            select.data(
                                'command'
                            );

                        let value =
                            select.val();

                        if (
                            typeof window
                                .AutomatorEditorExecCommand
                            ===
                            'function'
                        ) {

                            window
                                .AutomatorEditorExecCommand(
                                    editor,
                                    command,
                                    value,
                                    select
                                );
                        }
                    }
                );

            /*
            |--------------------------------------------------------------------------
            | Colors
            |--------------------------------------------------------------------------
            */

            editor.toolbar
                .find(
                    '.automator-editor-color'
                )
                .off('change')
                .on(
                    'change',
                    function()
                    {
                        let el =
                            $(this);

                        let command =
                            el.data(
                                'command'
                            );

                        let value =
                            el.val();

                        if(
                            typeof window
                                .AutomatorEditorExecCommand
                            ===
                            'function'
                        ) {

                            window
                            .AutomatorEditorExecCommand(
                                editor,
                                command,
                                value,
                                el
                            );
                        }
                    }
                );
        };

    /*
    |--------------------------------------------------------------------------
    | Init toolbar on editor render
    |--------------------------------------------------------------------------
    */

    $(document).on(
        'automator-editor-rendered',
        function (
            e,
            editor
        ) {

            window
                .AutomatorEditorBuildToolbar(
                    editor
                );
        }
    );

})(jQuery);



(function($){

    /*
    |--------------------------------------------------------------------------
    | Auto Render
    |--------------------------------------------------------------------------
    */

    window.AutomatorEditorAutoRender =
    function(root = document)
    {

        var $root =
            $(root);

        if(
            !$root.length
        ) {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Current root editors
        |--------------------------------------------------------------------------
        */

        if(
            $root.hasClass(
                'automator-editor'
            )
        ) {

            AutomatorEditorRender(
                $root
            );

        } else {

            AutomatorEditorRender(
                $root.find(
                    '.automator-editor'
                )
            );
        }

        return true;
    };

    /*
    |--------------------------------------------------------------------------
    | DOM Ready
    |--------------------------------------------------------------------------
    */

    $(function(){

        AutomatorEditorAutoRender(
            document
        );

    });

    /*
    |--------------------------------------------------------------------------
    | Bootstrap modal shown
    |--------------------------------------------------------------------------
    */

    $(document).on(
        'shown.bs.modal',
        '.modal',
        function(){

            AutomatorEditorAutoRender(
                this
            );

        }
    );

    /*
    |--------------------------------------------------------------------------
    | Mutation Observer
    |--------------------------------------------------------------------------
    */

    // const observer =
    //     new MutationObserver(
    //         function(mutations)
    //         {

    //             mutations.forEach(
    //                 function(
    //                     mutation
    //                 ){

    //                     mutation
    //                     .addedNodes
    //                     .forEach(
    //                         function(
    //                             node
    //                         ){

    //                             if(
    //                                 !node ||
    //                                 node.nodeType !== 1
    //                             ){
    //                                 return;
    //                             }

    //                             var $node =
    //                                 $(node);

    //                             /*
    //                             |--------------------------------------------------------------------------
    //                             | textarea/div editor
    //                             |--------------------------------------------------------------------------
    //                             */

    //                             if(
    //                                 $node.hasClass(
    //                                     'automator-editor'
    //                                 )
    //                             ){

    //                                 AutomatorEditorRender(
    //                                     $node
    //                                 );

    //                                 return;
    //                             }

    //                             /*
    //                             |--------------------------------------------------------------------------
    //                             | nested editors
    //                             |--------------------------------------------------------------------------
    //                             */

    //                             if(
    //                                 $node.find(
    //                                     '.automator-editor'
    //                                 ).length
    //                             ){

    //                                 AutomatorEditorRender(
    //                                     $node
    //                                 );
    //                             }

    //                         }
    //                     );

    //                 }
    //             );

    //         }
    //     );

    // observer.observe(
    //     document.body,
    //     {
    //         childList: true,
    //         subtree: true
    //     }
    // );


    /*
    |--------------------------------------------------------------------------
    | Mutation Observer
    |--------------------------------------------------------------------------
    */

    window.AutomatorEditorStartObserver =
    function()
    {
        /*
        |--------------------------------------------------------------------------
        | Prevent duplicate observer
        |--------------------------------------------------------------------------
        */

        if(
            window.AutomatorEditorObserverStarted
        ){
            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Wait body
        |--------------------------------------------------------------------------
        */

        if(
            !document.body
        ){

            setTimeout(
                function(){

                    window
                    .AutomatorEditorStartObserver();

                },
                100
            );

            return;
        }

        /*
        |--------------------------------------------------------------------------
        | Create observer
        |--------------------------------------------------------------------------
        */

        const observer =
            new MutationObserver(
                function(
                    mutations
                ){

                    mutations.forEach(
                        function(
                            mutation
                        ){

                            mutation
                            .addedNodes
                            .forEach(
                                function(
                                    node
                                ){

                                    if(
                                        !node ||
                                        node.nodeType !== 1
                                    ){
                                        return;
                                    }

                                    let $node =
                                        $(node);

                                    /*
                                    |--------------------------------------------------------------------------
                                    | Single editor
                                    |--------------------------------------------------------------------------
                                    */

                                    if(
                                        $node.hasClass(
                                            'automator-editor'
                                        )
                                    ){

                                        AutomatorEditorRender(
                                            $node
                                        );

                                        return;
                                    }

                                    /*
                                    |--------------------------------------------------------------------------
                                    | Nested editors
                                    |--------------------------------------------------------------------------
                                    */

                                    if(
                                        $node.find(
                                            '.automator-editor'
                                        ).length
                                    ){

                                        AutomatorEditorRender(
                                            $node
                                        );
                                    }

                                }
                            );

                        }
                    );

                }
            );

        /*
        |--------------------------------------------------------------------------
        | Observe body
        |--------------------------------------------------------------------------
        */

        observer.observe(
            document.body,
            {
                childList: true,
                subtree: true
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Registry
        |--------------------------------------------------------------------------
        */

        window.AutomatorEditorObserver =
            observer;

        window
        .AutomatorEditorObserverStarted =
            true;
    };

    /*
    |--------------------------------------------------------------------------
    | Start observer
    |--------------------------------------------------------------------------
    */

    $(function(){

        window
        .AutomatorEditorStartObserver();

    });

})(jQuery);


(function ($) {

    /*
    |--------------------------------------------------------------------------
    | Sync editor to source
    |--------------------------------------------------------------------------
    */

    window.AutomatorEditorSyncToSource =
    function(editor)
    {
        if(!editor)
        {
            return false;
        }

        let html = '';

        if(
            editor.mode ===
            'code'
        ) {

            html =
                editor.code.val();

            editor.visual.html(
                html
            );

        } else {

            html =
                editor.visual.html();

            editor.code.val(
                html
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Update original field
        |--------------------------------------------------------------------------
        */

        if(
            editor.source.is(
                'textarea'
            )
        ) {

            editor.source.val(
                html
            );

        } else {

            editor.source.html(
                html
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Trigger change
        |--------------------------------------------------------------------------
        */

        editor.source.trigger(
            'change'
        );

        if(
            typeof editor
                .config
                .callbacks
                .onChange ===
            'function'
        ) {

            editor
                .config
                .callbacks
                .onChange(
                    editor,
                    html
                );
        }

        return html;
    };

    /*
    |--------------------------------------------------------------------------
    | Focus current mode
    |--------------------------------------------------------------------------
    */

    window.AutomatorEditorFocus =
    function(editor)
    {
        if(
            editor.mode ===
            'code'
        ) {

            editor.code.focus();

        } else {

            editor.visual.focus();
        }
    };

    /*
    |--------------------------------------------------------------------------
    | Toggle mode
    |--------------------------------------------------------------------------
    */

    window.AutomatorEditorToggleMode =
    function(editor)
    {
        if(!editor)
        {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Sync current pane before toggling so content is never lost
        |--------------------------------------------------------------------------
        */

        AutomatorEditorSyncToSource(
            editor
        );

        /*
        |--------------------------------------------------------------------------
        | Code → Visual
        |--------------------------------------------------------------------------
        */

        if(editor.mode === 'code')
        {
            editor.mode = 'visual';

            editor.wrapper
                .removeClass('is-code-mode')
                .addClass('is-visual-mode');

            /*
             * Push the raw HTML from the code textarea into the visual pane so
             * the user sees the rendered result of what they typed.
             */
            editor.visual
                .html(editor.code.val())
                .removeClass('d-none');

            editor.code.addClass('d-none');
        }

        /*
        |--------------------------------------------------------------------------
        | Visual → Code
        |--------------------------------------------------------------------------
        */

        else
        {
            editor.mode = 'code';

            editor.wrapper
                .removeClass('is-visual-mode')
                .addClass('is-code-mode');

            /*
             * Push the current visual innerHTML into the code textarea so the
             * user can edit the underlying markup.
             */
            editor.code
                .val(editor.visual.html())
                .removeClass('d-none');

            editor.visual.addClass('d-none');
        }

        /*
        |--------------------------------------------------------------------------
        | Update toggleCode button icon to reflect the new mode
        |--------------------------------------------------------------------------
        */

        let toggleBtn =
            editor.toolbar.find('[data-command="toggleCode"]');

        if(toggleBtn.length)
        {
            if(editor.mode === 'code')
            {
                toggleBtn
                    .addClass('active is-active btn-primary')
                    .attr('title', 'Modo visual');
            }
            else
            {
                toggleBtn
                    .removeClass('active is-active btn-primary')
                    .attr('title', 'Modo código');
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Focus the now-visible pane
        |--------------------------------------------------------------------------
        */

        setTimeout(
            function(){
                AutomatorEditorFocus(editor);
            },
            10
        );

        /*
        |--------------------------------------------------------------------------
        | onModeChange callback
        |--------------------------------------------------------------------------
        */

        if(
            typeof editor
                .config
                .callbacks
                .onModeChange ===
            'function'
        ) {
            editor.config.callbacks.onModeChange(
                editor,
                editor.mode
            );
        }

        return true;
    };

    /*
    |--------------------------------------------------------------------------
    | Apply visual command
    |--------------------------------------------------------------------------
    */

    // window.AutomatorEditorApplyVisualCommand =
    // function(
    //     editor,
    //     command,
    //     value = null
    // )
    // {
    //     AutomatorEditorFocus(
    //         editor
    //     );

    //     /*
    //     |--------------------------------------------------------------------------
    //     | formatBlock fix
    //     |--------------------------------------------------------------------------
    //     */

    //     if(
    //         command ===
    //         'formatBlock'
    //     ) {

    //         document.execCommand(
    //             command,
    //             false,
    //             '<' + value + '>'
    //         );

    //     } else {

    //         document.execCommand(
    //             command,
    //             false,
    //             value
    //         );
    //     }

    //     AutomatorEditorSyncToSource(
    //         editor
    //     );

    //     return true;
    // };

    window.AutomatorEditorApplyVisualCommand =
    function(
        editor,
        command,
        value = null
    )
    {
        if(!editor)
        {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | Commands that do NOT need visual focus (non-execCommand)
        |--------------------------------------------------------------------------
        */

        if(command === 'fullscreen')
        {
            AutomatorEditorToggleFullscreen(editor);
            return true;
        }

        if(command === 'toggleCode')
        {
            AutomatorEditorToggleMode(editor);
            return true;
        }

        if(command === 'insertLink')
        {
            AutomatorEditorOpenLinkModal(editor);
            return true;
        }

        if(command === 'insertImage')
        {
            AutomatorEditorOpenImageModal(editor);
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | Commands that require the visual contenteditable to be focused.
        | Save the current selection first so toolbar click doesn't lose it.
        |--------------------------------------------------------------------------
        */

        AutomatorEditorFocus(editor);

        /*
        |--------------------------------------------------------------------------
        | Font size — use a sentinel font[size=7] trick then replace with CSS
        |--------------------------------------------------------------------------
        */

        if(command === 'fontSize')
        {
            document.execCommand('styleWithCSS', false, true);
            document.execCommand('fontSize', false, 7);

            editor.visual
                .find('font[size="7"]')
                .removeAttr('size')
                .css('font-size', value);

            AutomatorEditorSyncToSource(editor);
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | Font family
        |--------------------------------------------------------------------------
        */

        if(command === 'fontFamily')
        {
            document.execCommand('fontName', false, value);
            AutomatorEditorSyncToSource(editor);
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | Text color
        |--------------------------------------------------------------------------
        */

        if(command === 'foreColor')
        {
            document.execCommand('styleWithCSS', false, true);
            document.execCommand('foreColor', false, value);
            AutomatorEditorSyncToSource(editor);
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | Background / highlight color
        |--------------------------------------------------------------------------
        */

        if(command === 'hiliteColor')
        {
            document.execCommand('styleWithCSS', false, true);
            document.execCommand('hiliteColor', false, value);
            AutomatorEditorSyncToSource(editor);
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | Remove formatting
        |--------------------------------------------------------------------------
        */

        if(command === 'removeFormat')
        {
            document.execCommand('removeFormat', false, null);
            AutomatorEditorSyncToSource(editor);
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | formatBlock — browser requires the value wrapped in angle brackets
        |--------------------------------------------------------------------------
        */

        if(command === 'formatBlock')
        {
            document.execCommand(command, false, '<' + value + '>');
            AutomatorEditorSyncToSource(editor);
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | Generic execCommand (bold, italic, underline, justifyLeft, etc.)
        |--------------------------------------------------------------------------
        */

        document.execCommand(command, false, value);
        AutomatorEditorSyncToSource(editor);
        return true;
    };

    /*
    |--------------------------------------------------------------------------
    | Apply code command
    |--------------------------------------------------------------------------
    */

    // window.AutomatorEditorApplyCodeCommand =
    // function(
    //     editor,
    //     command,
    //     value = null
    // )
    // {
    //     let textarea =
    //         editor.code[0];

    //     if(!textarea)
    //     {
    //         return false;
    //     }

    //     let start =
    //         textarea.selectionStart;

    //     let end =
    //         textarea.selectionEnd;

    //     let text =
    //         textarea.value;

    //     let selected =
    //         text.substring(
    //             start,
    //             end
    //         );

    //     let before =
    //         text.substring(
    //             0,
    //             start
    //         );

    //     let after =
    //         text.substring(
    //             end
    //         );

    //     let newText =
    //         selected;

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Command map
    //     |--------------------------------------------------------------------------
    //     */

    //     switch(command)
    //     {
    //         case 'bold':

    //             newText =
    //                 `<strong>${selected}</strong>`;
    //         break;

    //         case 'italic':

    //             newText =
    //                 `<em>${selected}</em>`;
    //         break;

    //         case 'underline':

    //             newText =
    //                 `<u>${selected}</u>`;
    //         break;

    //         case 'strikeThrough':

    //             newText =
    //                 `<strike>${selected}</strike>`;
    //         break;

    //         case 'justifyLeft':

    //             newText =
    //                 `<div style="text-align:left;">${selected}</div>`;
    //         break;

    //         case 'justifyCenter':

    //             newText =
    //                 `<div style="text-align:center;">${selected}</div>`;
    //         break;

    //         case 'justifyRight':

    //             newText =
    //                 `<div style="text-align:right;">${selected}</div>`;
    //         break;

    //         case 'insertUnorderedList':

    //             newText =
    //                 `<ul><li>${selected}</li></ul>`;
    //         break;

    //         case 'insertOrderedList':

    //             newText =
    //                 `<ol><li>${selected}</li></ol>`;
    //         break;

    //         case 'formatBlock':

    //             newText =
    //                 `<${value}>${selected}</${value}>`;
    //         break;

    //         default:
    //             return false;
    //     }

    //     textarea.value =
    //         before +
    //         newText +
    //         after;

    //     textarea.focus();

    //     textarea.selectionStart =
    //         start;

    //     textarea.selectionEnd =
    //         start +
    //         newText.length;

    //     editor.visual.html(
    //         textarea.value
    //     );

    //     AutomatorEditorSyncToSource(
    //         editor
    //     );

    //     return true;
    // };

    window.AutomatorEditorApplyCodeCommand =
    function(
        editor,
        command,
        value = null
    )
    {
        /*
        |--------------------------------------------------------------------------
        | Commands that do not manipulate the textarea text
        |--------------------------------------------------------------------------
        */

        if(command === 'fullscreen')
        {
            AutomatorEditorToggleFullscreen(editor);
            return true;
        }

        if(command === 'toggleCode')
        {
            AutomatorEditorToggleMode(editor);
            return true;
        }

        if(command === 'insertLink')
        {
            AutomatorEditorOpenLinkModal(editor);
            return true;
        }

        if(command === 'insertImage')
        {
            AutomatorEditorOpenImageModal(editor);
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | Text-manipulation commands — wrap / replace selected HTML in textarea
        |--------------------------------------------------------------------------
        */

        let textarea =
            editor.code[0];

        if(!textarea)
        {
            return false;
        }

        let start =
            textarea.selectionStart;

        let end =
            textarea.selectionEnd;

        let text =
            textarea.value;

        let selected =
            text.substring(
                start,
                end
            );

        let before =
            text.substring(
                0,
                start
            );

        let after =
            text.substring(
                end
            );

        let newText =
            selected;

        switch(command)
        {
            case 'bold':

                newText =
                    `<strong>${selected}</strong>`;
            break;

            case 'italic':

                newText =
                    `<em>${selected}</em>`;
            break;

            case 'underline':

                newText =
                    `<u>${selected}</u>`;
            break;

            case 'strikeThrough':

                newText =
                    `<strike>${selected}</strike>`;
            break;

            case 'justifyLeft':

                newText =
                    `<div style="text-align:left;">${selected}</div>`;
            break;

            case 'justifyCenter':

                newText =
                    `<div style="text-align:center;">${selected}</div>`;
            break;

            case 'justifyRight':

                newText =
                    `<div style="text-align:right;">${selected}</div>`;
            break;

            case 'insertUnorderedList':

                newText =
                    `<ul><li>${selected}</li></ul>`;
            break;

            case 'insertOrderedList':

                newText =
                    `<ol><li>${selected}</li></ol>`;
            break;

            case 'formatBlock':

                newText =
                    `<${value}>${selected}</${value}>`;
            break;

            case 'fontSize':

                newText =
                    `<span style="font-size:${value};">${selected}</span>`;
            break;

            case 'fontFamily':

                newText =
                    `<span style="font-family:${value};">${selected}</span>`;
            break;

            case 'foreColor':

                newText =
                    `<span style="color:${value};">${selected}</span>`;
            break;

            case 'hiliteColor':

                newText =
                    `<span style="background-color:${value};">${selected}</span>`;
            break;

            case 'removeFormat':

                newText =
                    selected
                    .replace(
                        /<[^>]*>/g,
                        ''
                    );
            break;

            case 'undo':
            case 'redo':
                /* undo/redo not applicable in raw textarea — silently ignore */
                return false;

            default:
                return false;
        }

        let newValue =
            before +
            newText +
            after;

        textarea.value =
            newValue;

        textarea.focus();

        textarea.selectionStart =
            start;

        textarea.selectionEnd =
            start +
            newText.length;

        /*
        |--------------------------------------------------------------------------
        | Sync code textarea → source textarea (do NOT push raw code into visual)
        |--------------------------------------------------------------------------
        */

        AutomatorEditorSyncToSource(
            editor
        );

        return true;
    };

    /*
    |--------------------------------------------------------------------------
    | Execute command
    |--------------------------------------------------------------------------
    */

    // window.AutomatorEditorExecCommand =
    // function(
    //     editor,
    //     command,
    //     value = null,
    //     trigger = null
    // )
    // {
    //     if(
    //         !editor ||
    //         !command
    //     ) {
    //         return false;
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | beforeCommand
    //     |--------------------------------------------------------------------------
    //     */

    //     if(
    //         typeof editor
    //             .config
    //             .callbacks
    //             .beforeCommand ===
    //         'function'
    //     ) {

    //         editor
    //             .config
    //             .callbacks
    //             .beforeCommand(
    //                 editor,
    //                 command,
    //                 value,
    //                 trigger
    //             );
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Toggle mode
    //     |--------------------------------------------------------------------------
    //     */

    //     if(
    //         command ===
    //         'toggleCode'
    //     ) {

    //         AutomatorEditorToggleMode(
    //             editor
    //         );

    //         return true;
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Undo / Redo
    //     |--------------------------------------------------------------------------
    //     */

    //     if(
    //         command ===
    //         'undo'
    //         ||
    //         command ===
    //         'redo'
    //     ) {

    //         if(
    //             editor.mode ===
    //             'visual'
    //         ) {

    //             document.execCommand(
    //                 command,
    //                 false,
    //                 null
    //             );

    //             AutomatorEditorSyncToSource(
    //                 editor
    //             );
    //         }

    //         return true;
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | Apply command
    //     |--------------------------------------------------------------------------
    //     */

    //     if(
    //         editor.mode ===
    //         'code'
    //     ) {

    //         AutomatorEditorApplyCodeCommand(
    //             editor,
    //             command,
    //             value
    //         );

    //     } else {

    //         AutomatorEditorApplyVisualCommand(
    //             editor,
    //             command,
    //             value
    //         );
    //     }

    //     /*
    //     |--------------------------------------------------------------------------
    //     | afterCommand
    //     |--------------------------------------------------------------------------
    //     */

    //     if(
    //         typeof editor
    //             .config
    //             .callbacks
    //             .afterCommand ===
    //         'function'
    //     ) {

    //         editor
    //             .config
    //             .callbacks
    //             .afterCommand(
    //                 editor,
    //                 command,
    //                 value,
    //                 trigger
    //             );
    //     }

    //     return true;
    // };

    window.AutomatorEditorExecCommand =
    function(
        editor,
        command,
        value = null,
        trigger = null
    )
    {
        if(
            !editor
            ||
            !command
        ) {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | beforeCommand callback
        |--------------------------------------------------------------------------
        */

        if(
            typeof editor
                .config
                .callbacks
                .beforeCommand ===
            'function'
        ) {
            editor.config.callbacks.beforeCommand(
                editor,
                command,
                value,
                trigger
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Toggle mode (visual ↔ code) — mode-agnostic
        |--------------------------------------------------------------------------
        */

        if(command === 'toggleCode')
        {
            AutomatorEditorToggleMode(editor);
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | Fullscreen — mode-agnostic
        |--------------------------------------------------------------------------
        */

        if(command === 'fullscreen')
        {
            AutomatorEditorToggleFullscreen(editor);
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | Undo / Redo — only meaningful in visual mode
        |--------------------------------------------------------------------------
        */

        if(command === 'undo' || command === 'redo')
        {
            if(editor.mode === 'visual')
            {
                document.execCommand(command, false, null);
                AutomatorEditorSyncToSource(editor);
            }

            setTimeout(function(){
                AutomatorEditorUpdateToolbarState(editor);
            }, 5);

            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | Route to the correct apply function based on current mode
        |--------------------------------------------------------------------------
        */

        let result = false;

        if(editor.mode === 'code')
        {
            result = AutomatorEditorApplyCodeCommand(editor, command, value);
        }
        else
        {
            result = AutomatorEditorApplyVisualCommand(editor, command, value);
        }

        /*
        |--------------------------------------------------------------------------
        | Refresh toolbar state after command
        |--------------------------------------------------------------------------
        */

        setTimeout(function(){
            AutomatorEditorUpdateToolbarState(editor);
        }, 5);

        /*
        |--------------------------------------------------------------------------
        | afterCommand callback
        |--------------------------------------------------------------------------
        */

        if(
            typeof editor
                .config
                .callbacks
                .afterCommand ===
            'function'
        ) {
            editor.config.callbacks.afterCommand(
                editor,
                command,
                value,
                trigger
            );
        }

        return result;
    };

    /*
    |--------------------------------------------------------------------------
    | Auto sync typing
    |--------------------------------------------------------------------------
    */

    $(document).on(
        'input keyup paste',
        '.automator-editor-visual, .automator-editor-code',
        function(){

            let wrapper =
                $(this)
                .closest(
                    '.automator-editor-wrapper'
                );

            let id =
                wrapper.data(
                    'editor-id'
                );

            if(
                !id
            ){
                return;
            }

            let editor =
                window
                .AutomatorEditors[id];

            if(
                !editor
            ){
                return;
            }

            AutomatorEditorSyncToSource(
                editor
            );
        }
    );

})(jQuery);

(function ($) {

    /*
    |--------------------------------------------------------------------------
    | Active commands map
    |--------------------------------------------------------------------------
    */

    window.AutomatorEditorActiveCommands = [

        'bold',
        'italic',
        'underline',
        'strikeThrough',
        'justifyLeft',
        'justifyCenter',
        'justifyRight',
        'insertOrderedList',
        'insertUnorderedList'
    ];

    /*
    |--------------------------------------------------------------------------
    | Code mode tag map
    |--------------------------------------------------------------------------
    */

    window.AutomatorEditorCodeTagMap = {

        bold: [
            'strong',
            'b'
        ],

        italic: [
            'em',
            'i'
        ],

        underline: [
            'u'
        ],

        strikeThrough: [
            'strike',
            's',
            'del'
        ],

        justifyLeft: [
            'text-align:left'
        ],

        justifyCenter: [
            'text-align:center'
        ],

        justifyRight: [
            'text-align:right'
        ],

        insertUnorderedList: [
            'ul'
        ],

        insertOrderedList: [
            'ol'
        ]
    };

    /*
    |--------------------------------------------------------------------------
    | Remove toolbar active states
    |--------------------------------------------------------------------------
    */

    window.AutomatorEditorClearToolbarState =
    function(editor)
    {
        editor.toolbar
            .find(
                '.automator-editor-btn'
            )
            .removeClass(
                'active is-active btn-primary'
            );
    };

    /*
    |--------------------------------------------------------------------------
    | Set active button
    |--------------------------------------------------------------------------
    */

    window.AutomatorEditorSetButtonState =
    function(
        editor,
        command,
        active = false
    )
    {
        let button =
            editor.toolbar.find(
                '[data-command="' +
                command +
                '"]'
            );

        if(!button.length)
        {
            return;
        }

        if(active)
        {
            button.addClass(
                'active is-active btn-primary'
            );
        }
        else
        {
            button.removeClass(
                'active is-active btn-primary'
            );
        }
    };

    /*
    |--------------------------------------------------------------------------
    | Get visual selection state
    |--------------------------------------------------------------------------
    */

    window.AutomatorEditorGetVisualState =
    function(editor)
    {
        let state = {};

        window
            .AutomatorEditorActiveCommands
            .forEach(
                function(command)
                {
                    try {

                        state[
                            command
                        ] =
                            document.queryCommandState(
                                command
                            );

                    } catch(e) {

                        state[
                            command
                        ] = false;
                    }
                }
            );

        return state;
    };

    /*
    |--------------------------------------------------------------------------
    | Detect code mode selection state
    |--------------------------------------------------------------------------
    */

    window.AutomatorEditorGetCodeState =
    function(editor)
    {
        let textarea =
            editor.code[0];

        let start =
            textarea.selectionStart;

        let end =
            textarea.selectionEnd;

        let value =
            textarea.value;

        let selected =
            value.substring(
                start,
                end
            );

        /*
        |--------------------------------------------------------------------------
        | Fallback around cursor
        |--------------------------------------------------------------------------
        */

        if(
            !selected.length
        ) {

            let before =
                value.substring(
                    Math.max(
                        0,
                        start - 300
                    ),
                    start
                );

            let after =
                value.substring(
                    start,
                    Math.min(
                        value.length,
                        start + 300
                    )
                );

            selected =
                before + after;
        }

        let state = {};

        Object.keys(
            window
            .AutomatorEditorCodeTagMap
        )
        .forEach(
            function(command)
            {
                state[
                    command
                ] = false;

                let tags =
                    window
                    .AutomatorEditorCodeTagMap[
                        command
                    ];

                tags.forEach(
                    function(tag)
                    {
                        if(
                            selected
                            .toLowerCase()
                            .indexOf(
                                tag.toLowerCase()
                            ) !== -1
                        ) {
                            state[
                                command
                            ] = true;
                        }
                    }
                );
            }
        );

        return state;
    };

    /*
    |--------------------------------------------------------------------------
    | Update toolbar state
    |--------------------------------------------------------------------------
    */

    window.AutomatorEditorUpdateToolbarState =
    function(editor)
    {
        if(!editor)
        {
            return false;
        }

        let state = {};

        if(
            editor.mode ===
            'code'
        ) {

            state =
                AutomatorEditorGetCodeState(
                    editor
                );

        } else {

            state =
                AutomatorEditorGetVisualState(
                    editor
                );
        }

        AutomatorEditorClearToolbarState(
            editor
        );

        Object.keys(
            state
        )
        .forEach(
            function(command)
            {
                AutomatorEditorSetButtonState(
                    editor,
                    command,
                    state[
                        command
                    ]
                );
            }
        );

        /*
        |--------------------------------------------------------------------------
        | Callback
        |--------------------------------------------------------------------------
        */

        if(
            typeof editor
                .config
                .callbacks
                .onSelectionChange ===
            'function'
        ) {

            editor
                .config
                .callbacks
                .onSelectionChange(
                    editor,
                    state
                );
        }

        // return state;

        /*
        |--------------------------------------------------------------------------
        | Sync toolbar controls
        |--------------------------------------------------------------------------
        */

        if(
            typeof
            AutomatorEditorSyncToolbarControls
            ===
            'function'
        ) {

            AutomatorEditorSyncToolbarControls(
                editor
            );
        }

        return state;
    };



    window.AutomatorEditorSyncToolbarControls =
    function(editor)
    {
        if(!editor)
        {
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | References
        |--------------------------------------------------------------------------
        */

        let formatSelect =
            editor.toolbar.find(
                '[data-command="formatBlock"]'
            );

        let fontFamilySelect =
            editor.toolbar.find(
                '[data-command="fontFamily"]'
            );

        let fontSizeSelect =
            editor.toolbar.find(
                '[data-command="fontSize"]'
            );

        let foreColor =
            editor.toolbar.find(
                '[data-command="foreColor"]'
            );

        let hiliteColor =
            editor.toolbar.find(
                '[data-command="hiliteColor"]'
            );

        /*
        |--------------------------------------------------------------------------
        | CODE MODE
        |--------------------------------------------------------------------------
        */

        if(
            editor.mode ===
            'code'
        ) {
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | Selection
        |--------------------------------------------------------------------------
        */

        let selection =
            window.getSelection();

        if(
            !selection.rangeCount
        ) {
            return false;
        }

        let node =
            selection.anchorNode;

        if(!node)
        {
            return false;
        }

        if(
            node.nodeType ===
            3
        ) {
            node =
                node.parentNode;
        }

        let $node =
            $(node);

        /*
        |--------------------------------------------------------------------------
        | Format block
        |--------------------------------------------------------------------------
        */

        let heading =
            $node.closest(
                'h1,h2,h3,h4,p'
            );

        if(
            heading.length
        ) {

            formatSelect.val(
                heading
                .prop(
                    'tagName'
                )
                .toUpperCase()
            );

        } else {

            formatSelect.val(
                'P'
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Font family
        |--------------------------------------------------------------------------
        */

        let family =
            $node.css(
                'font-family'
            );

        if(
            family
        ) {

            family =
                family
                .split(',')
                [0]
                .replace(/["']/g,'');

            fontFamilySelect.val(
                family
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Font size
        |--------------------------------------------------------------------------
        */

        let size =
            $node.css(
                'font-size'
            );

        if(
            size
        ) {

            fontSizeSelect.val(
                size
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Text color
        |--------------------------------------------------------------------------
        */

        let color =
            $node.css(
                'color'
            );

        if(
            color
        ) {

            foreColor.val(
                AutomatorEditorRgbToHex(
                    color
                )
            );
        }

        /*
        |--------------------------------------------------------------------------
        | Highlight color
        |--------------------------------------------------------------------------
        */

        let bg =
            $node.css(
                'background-color'
            );

        if(
            bg
            &&
            bg !==
            'rgba(0, 0, 0, 0)'
        ) {

            hiliteColor.val(
                AutomatorEditorRgbToHex(
                    bg
                )
            );
        }

        return true;
    };


    window.AutomatorEditorRgbToHex =
    function(rgb)
    {
        if(!rgb)
        {
            return '#000000';
        }

        if(
            rgb.indexOf('#')
            ===
            0
        ) {
            return rgb;
        }

        let result =
            rgb.match(/\d+/g);

        if(
            !result
        ) {
            return '#000000';
        }

        return '#'
            +
            (
                (1 << 24)
                +
                (
                    parseInt(
                        result[0]
                    ) << 16
                )
                +
                (
                    parseInt(
                        result[1]
                    ) << 8
                )
                +
                parseInt(
                    result[2]
                )
            )
            .toString(16)
            .slice(1);
    };

    /*
    |--------------------------------------------------------------------------
    | Bind editor selection events
    |--------------------------------------------------------------------------
    */

    window.AutomatorEditorBindSelectionEvents =
    function(editor)
    {
        if(!editor)
        {
            return false;
        }

        let selector =
            '.automator-editor-visual, ' +
            '.automator-editor-code';

        editor.wrapper
            .off(
                'keyup.mouseup.selection click focus',
                selector
            );

        editor.wrapper
            .on(
                'keyup mouseup click focus',
                selector,
                function()
                {
                    setTimeout(
                        function(){

                            AutomatorEditorUpdateToolbarState(
                                editor
                            );

                        },
                        5
                    );
                }
            );
    };

    /*
    |--------------------------------------------------------------------------
    | Global selection change
    |--------------------------------------------------------------------------
    */

    $(document).on(
        'selectionchange',
        function()
        {
            Object.values(
                window
                .AutomatorEditors
            )
            .forEach(
                function(editor)
                {
                    if(
                        !editor
                    ){
                        return;
                    }

                    if(
                        editor.wrapper
                        .find(':focus')
                        .length
                    ) {

                        AutomatorEditorUpdateToolbarState(
                            editor
                        );
                    }
                }
            );
        }
    );

    /*
    |--------------------------------------------------------------------------
    | Bind after render
    |--------------------------------------------------------------------------
    */

    $(document).on(
        'automator-editor-rendered',
        function(
            e,
            editor
        )
        {
            AutomatorEditorBindSelectionEvents(
                editor
            );

            setTimeout(
                function(){

                    AutomatorEditorUpdateToolbarState(
                        editor
                    );

                },
                50
            );
        }
    );

})(jQuery);


(function ($) {

    /*
    |--------------------------------------------------------------------------
    | Wrap selection HTML
    |--------------------------------------------------------------------------
    */

    window.AutomatorEditorWrapSelection =
    function(
        editor,
        before,
        after = ''
    )
    {
        if(
            !editor
        ){
            return false;
        }

        /*
        |--------------------------------------------------------------------------
        | CODE MODE
        |--------------------------------------------------------------------------
        */

        if(
            editor.mode ===
            'code'
        ) {

            let textarea =
                editor.code[0];

            let start =
                textarea.selectionStart;

            let end =
                textarea.selectionEnd;

            let text =
                textarea.value;

            let selected =
                text.substring(
                    start,
                    end
                );

            textarea.value =
                text.substring(
                    0,
                    start
                )
                +
                before
                +
                selected
                +
                after
                +
                text.substring(
                    end
                );

            textarea.focus();

            textarea.selectionStart =
                start;

            textarea.selectionEnd =
                start
                +
                before.length
                +
                selected.length
                +
                after.length;

            editor.visual.html(
                textarea.value
            );

            AutomatorEditorSyncToSource(
                editor
            );

            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | VISUAL MODE
        |--------------------------------------------------------------------------
        */

        AutomatorEditorFocus(
            editor
        );

        let selection =
            window.getSelection();

        if(
            !selection.rangeCount
        ) {
            return false;
        }

        let range =
            selection.getRangeAt(
                0
            );

        let content =
            range.extractContents();

        let wrapper =
            document.createElement(
                'span'
            );

        wrapper.innerHTML =
            before +
            content.textContent +
            after;

        range.insertNode(
            wrapper
        );

        AutomatorEditorSyncToSource(
            editor
        );

        return true;
    };

    /*
    |--------------------------------------------------------------------------
    | Open modal hook
    |--------------------------------------------------------------------------
    */

    window.AutomatorEditorOpenActionModal =
    function(
        editor,
        type = 'link'
    )
    {
        /*
        |--------------------------------------------------------------------------
        | Save the current selection BEFORE the modal opens and steals focus.
        | We will restore it when the user confirms the insertion.
        |--------------------------------------------------------------------------
        */

        let savedSelection = null;

        if(editor.mode === 'visual')
        {
            let sel = window.getSelection();

            if(sel && sel.rangeCount)
            {
                savedSelection = sel.getRangeAt(0).cloneRange();
            }
        }
        else
        {
            /* In code mode, save textarea cursor positions */
            let ta = editor.code[0];

            savedSelection = {
                start: ta ? ta.selectionStart : 0,
                end:   ta ? ta.selectionEnd   : 0
            };
        }

        let isImage  = (type === 'image');
        let modalId  = 'automator-editor-action-modal-' + Date.now();
        let title    = isImage ? 'Inserir imagem' : 'Inserir link';

        /*
        |--------------------------------------------------------------------------
        | Build modal body fields
        |--------------------------------------------------------------------------
        */

        let bodyHtml = '';

        if(isImage)
        {
            bodyHtml = `
                <div class="mb-3">
                    <label class="form-label">URL da imagem <span class="text-danger">*</span></label>
                    <input type="url" id="${modalId}-url" class="form-control" placeholder="https://..." />
                </div>
                <div class="mb-3">
                    <label class="form-label">Texto alternativo (alt)</label>
                    <input type="text" id="${modalId}-alt" class="form-control" placeholder="Descrição da imagem" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Largura (opcional)</label>
                    <input type="text" id="${modalId}-width" class="form-control" placeholder="ex: 100% ou 300px" />
                </div>
            `;
        }
        else
        {
            bodyHtml = `
                <div class="mb-3">
                    <label class="form-label">URL do link <span class="text-danger">*</span></label>
                    <input type="url" id="${modalId}-url" class="form-control" placeholder="https://..." />
                </div>
                <div class="mb-3">
                    <label class="form-label">Texto do link</label>
                    <input type="text" id="${modalId}-text" class="form-control" placeholder="Deixe em branco para usar o texto selecionado" />
                </div>
                <div class="mb-3">
                    <label class="form-label">Abrir em</label>
                    <select id="${modalId}-target" class="form-select">
                        <option value="_self">Mesma aba</option>
                        <option value="_blank">Nova aba</option>
                    </select>
                </div>
            `;
        }

        $('body').append(`
            <div
                class="modal fade automator-editor-action-modal"
                id="${modalId}"
                tabindex="-1"
                data-bs-backdrop="static"
                data-bs-keyboard="false"
            >
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">

                        <div class="modal-header">
                            <h5 class="modal-title w-100 text-center">${title}</h5>
                            <button type="button" class="btn-close js-editor-modal-cancel" aria-label="Fechar"></button>
                        </div>

                        <div class="modal-body">
                            ${bodyHtml}
                            <div id="${modalId}-error" class="alert alert-danger d-none mb-0 mt-2"></div>
                        </div>

                        <div class="modal-footer">
                            <div class="row g-2 w-100">
                                <div class="col-12 col-md-6 order-2 order-md-1">
                                    <button type="button" class="btn btn-secondary w-100 js-editor-modal-cancel">Cancelar</button>
                                </div>
                                <div class="col-12 col-md-6 order-1 order-md-2">
                                    <button type="button" class="btn btn-primary w-100 automator-editor-modal-submit">Inserir</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        `);

        let $modalEl = $('#' + modalId);
        let modalEl  = $modalEl[0];

        let modal = new bootstrap.Modal(modalEl, {
            backdrop: 'static',
            keyboard: false,
            focus: true
        });

        /*
        |--------------------------------------------------------------------------
        | Ensure this modal always renders above any parent modal (z-index stack)
        |--------------------------------------------------------------------------
        */

        $modalEl.on('shown.bs.modal', function(){

            let zBase = 1060;

            let existingModals =
                document.querySelectorAll('.modal.show');

            $modalEl.css('z-index', zBase + existingModals.length * 10);

            $('.modal-backdrop')
                .last()
                .css('z-index', zBase + existingModals.length * 10 - 5);

            /* Auto-focus the URL field */
            let urlField = document.getElementById(modalId + '-url');
            if(urlField) { urlField.focus(); }
        });

        /*
        |--------------------------------------------------------------------------
        | Cancel — close without inserting anything
        |--------------------------------------------------------------------------
        */

        $modalEl.find('.js-editor-modal-cancel').on('click', function(){
            modal.hide();
        });

        $modalEl.on('hidden.bs.modal', function(){
            $modalEl.remove();
        });

        /*
        |--------------------------------------------------------------------------
        | Submit — validate, build HTML, insert into editor
        |--------------------------------------------------------------------------
        */

        $modalEl.find('.automator-editor-modal-submit').on('click', function(){

            let $errorBox = $('#' + modalId + '-error');
            $errorBox.addClass('d-none').text('');

            let url = (document.getElementById(modalId + '-url') || {}).value || '';
            url = url.trim();

            if(!url)
            {
                $errorBox
                    .text('Informe a URL ' + (isImage ? 'da imagem.' : 'do link.'))
                    .removeClass('d-none');
                return;
            }

            let html = '';

            if(isImage)
            {
                let alt   = ((document.getElementById(modalId + '-alt')   || {}).value || '').trim();
                let width = ((document.getElementById(modalId + '-width') || {}).value || '').trim();

                let styleAttr = width ? ` style="max-width:${width};"` : '';

                html = `<img src="${url}" alt="${alt}"${styleAttr} />`;
            }
            else
            {
                let linkText   = ((document.getElementById(modalId + '-text')   || {}).value || '').trim();
                let linkTarget = ((document.getElementById(modalId + '-target') || {}).value || '_self').trim();

                let targetAttr = linkTarget === '_blank'
                    ? ` target="_blank" rel="noopener noreferrer"`
                    : '';

                if(!linkText)
                {
                    /*
                     * If the user left the text field empty, try to use the
                     * text that was selected in the editor before opening the modal.
                     */
                    if(
                        editor.mode === 'visual' &&
                        savedSelection
                    ) {
                        let tempDiv = document.createElement('div');
                        let frag    = savedSelection.cloneContents();
                        tempDiv.appendChild(frag);
                        linkText = tempDiv.textContent || url;
                    }
                    else if(
                        editor.mode === 'code' &&
                        savedSelection
                    ) {
                        let ta  = editor.code[0];
                        linkText = ta
                            ? ta.value.substring(savedSelection.start, savedSelection.end)
                            : url;
                    }

                    if(!linkText) { linkText = url; }
                }

                html = `<a href="${url}"${targetAttr}>${linkText}</a>`;
            }

            /*
            |--------------------------------------------------------------------------
            | Insert into the editor — restore selection first
            |--------------------------------------------------------------------------
            */

            modal.hide();

            $modalEl.on('hidden.bs.modal', function insertAfterClose(){

                $modalEl.off('hidden.bs.modal', insertAfterClose);

                if(editor.mode === 'visual')
                {
                    /*
                     * Restore the saved selection range so insertHTML lands in
                     * the right place, even though focus was stolen by the modal.
                     */
                    if(savedSelection)
                    {
                        let sel = window.getSelection();
                        sel.removeAllRanges();
                        sel.addRange(savedSelection);
                    }

                    editor.visual.focus();

                    document.execCommand('insertHTML', false, html);

                    AutomatorEditorSyncToSource(editor);
                }
                else
                {
                    /* Code mode — insert at the saved cursor position */
                    let ta = editor.code[0];

                    if(ta && savedSelection)
                    {
                        let start = savedSelection.start;
                        let end   = savedSelection.end;
                        let val   = ta.value;

                        ta.value =
                            val.substring(0, start) +
                            html +
                            val.substring(end);

                        ta.selectionStart =
                        ta.selectionEnd   = start + html.length;

                        ta.focus();
                    }
                    else if(ta)
                    {
                        ta.value += html;
                        ta.focus();
                    }

                    AutomatorEditorSyncToSource(editor);
                }
            });
        });

        modal.show();

        return modal;
    };

    /*
    |--------------------------------------------------------------------------
    | Link modal hook
    |--------------------------------------------------------------------------
    */

    window.AutomatorEditorOpenLinkModal =
    function(editor)
    {
        return AutomatorEditorOpenActionModal(
            editor,
            'link'
        );
    };

    /*
    |--------------------------------------------------------------------------
    | Image modal hook
    |--------------------------------------------------------------------------
    */

    window.AutomatorEditorOpenImageModal =
    function(editor)
    {
        return AutomatorEditorOpenActionModal(
            editor,
            'image'
        );
    };

    /*
    |--------------------------------------------------------------------------
    | Public API
    |--------------------------------------------------------------------------
    */

    window.AutomatorEditorInsertLink =
    function(
        editor,
        html
    )
    {
        if(
            !editor
        ){
            return false;
        }

        if(
            editor.mode ===
            'code'
        ) {

            editor.code
                .val(
                    editor.code.val()
                    + html
                );

        } else {

            document.execCommand(
                'insertHTML',
                false,
                html
            );
        }

        AutomatorEditorSyncToSource(
            editor
        );

        return true;
    };

    window.AutomatorEditorInsertImage =
    function(
        editor,
        html
    )
    {
        return window
            .AutomatorEditorInsertLink(
                editor,
                html
            );
    };

    /*
    |--------------------------------------------------------------------------
    | Fullscreen
    |--------------------------------------------------------------------------
    */

    window.AutomatorEditorToggleFullscreen =
    function(editor)
    {
        if(!editor)
        {
            return false;
        }

        let isFullscreen =
            editor.wrapper.hasClass(
                'automator-editor-fullscreen'
            );

        /*
        |--------------------------------------------------------------------------
        | Enter fullscreen
        |--------------------------------------------------------------------------
        */

        if(!isFullscreen)
        {
            editor.wrapper.addClass(
                'automator-editor-fullscreen'
            );

            /*
             * Prevent body scroll while editor is fullscreen so the editor
             * occupies the full viewport without the page scrolling behind it.
             */
            $('body').addClass(
                'automator-editor-fullscreen-active'
            );

            /*
             * Update toolbar button icon to "compress"
             */
            editor.toolbar
                .find('[data-command="fullscreen"] i')
                .removeClass('fa-expand')
                .addClass('fa-compress');

            editor.toolbar
                .find('[data-command="fullscreen"]')
                .attr('title', 'Sair da tela cheia');

            /*
             * Close fullscreen on ESC — registered once per instance
             */
            if(!editor._fullscreenEscHandler)
            {
                editor._fullscreenEscHandler = function(e)
                {
                    if(
                        e.key === 'Escape' &&
                        editor.wrapper.hasClass(
                            'automator-editor-fullscreen'
                        )
                    ) {
                        AutomatorEditorToggleFullscreen(editor);
                    }
                };

                document.addEventListener(
                    'keydown',
                    editor._fullscreenEscHandler
                );
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Exit fullscreen
        |--------------------------------------------------------------------------
        */

        else
        {
            editor.wrapper.removeClass(
                'automator-editor-fullscreen'
            );

            $('body').removeClass(
                'automator-editor-fullscreen-active'
            );

            editor.toolbar
                .find('[data-command="fullscreen"] i')
                .removeClass('fa-compress')
                .addClass('fa-expand');

            editor.toolbar
                .find('[data-command="fullscreen"]')
                .attr('title', 'Tela cheia');
        }

        return true;
    };

    /*
    |--------------------------------------------------------------------------
    | Content sanitizer
    |--------------------------------------------------------------------------
    |
    | Strips dangerous tags and attributes before the content is sent to the
    | server.  Call this on the value of every .automator-editor field
    | before submitting a form.
    |
    | Usage (JS):
    |   var clean = AutomatorEditorSanitizeContent(rawHtml);
    |
    | What it does:
    |   1. Removes <script>, <style>, <iframe>, <object>, <embed>, <form>,
    |      <input>, <button>, <meta>, <link>, <base> and their full contents.
    |   2. Strips all event handler attributes (on*=) and javascript: / data:
    |      URI schemes from href / src / action.
    |   3. Strips CSS expression() injection.
    |   4. Uses DOMParser to fix unclosed / malformed tags so the markup saved
    |      to the DB is always well-formed.
    |   5. Enforces an attribute allow-list on every remaining element.
    |
    | IMPORTANT: this is a client-side first line of defence only.
    | Always run server-side sanitisation (e.g. HTMLPurifier for PHP) before
    | persisting the value — never trust client-side validation alone.
    |
    |--------------------------------------------------------------------------
    */

    window.AutomatorEditorSanitizeContent =
    function(html)
    {
        if(!html || typeof html !== 'string')
        {
            return '';
        }

        /*
        |--------------------------------------------------------------------------
        | 1. Strip whole dangerous elements (tag + children + closing tag)
        |--------------------------------------------------------------------------
        */

        var dangerousTagsPattern =
            /<(script|style|iframe|frame|frameset|object|embed|applet|form|input|button|select|textarea|meta|link|base|noscript|template|svg|math)[^>]*>[\s\S]*?<\/\1>/gi;

        var prev = '';
        var sanitized = html;

        while(sanitized !== prev)
        {
            prev = sanitized;
            sanitized = sanitized.replace(dangerousTagsPattern, '');
        }

        /*
        |--------------------------------------------------------------------------
        | 2. Strip self-closing / unclosed dangerous tags
        |--------------------------------------------------------------------------
        */

        sanitized = sanitized.replace(
            /<(script|style|iframe|frame|frameset|object|embed|applet|form|input|button|select|textarea|meta|link|base|noscript|template|svg|math)[^>]*\/?>/gi,
            ''
        );

        /*
        |--------------------------------------------------------------------------
        | 3. Strip event handler attributes (onclick, onload, onerror, on*, …)
        |--------------------------------------------------------------------------
        */

        sanitized = sanitized.replace(
            /\s+on\w+\s*=\s*(?:"[^"]*"|'[^']*'|[^\s>]*)/gi,
            ''
        );

        /*
        |--------------------------------------------------------------------------
        | 4. Strip javascript: / vbscript: / data: URI schemes
        |--------------------------------------------------------------------------
        */

        sanitized = sanitized.replace(
            /(href|src|action|formaction|poster|background)\s*=\s*["']\s*(javascript|vbscript|data)\s*:/gi,
            '$1="#"'
        );

        /*
        |--------------------------------------------------------------------------
        | 5. Strip CSS expression() injection (IE)
        |--------------------------------------------------------------------------
        */

        sanitized = sanitized.replace(
            /style\s*=\s*["'][^"']*expression\s*\([^)]*\)[^"']*["']/gi,
            ''
        );

        /*
        |--------------------------------------------------------------------------
        | 6. Use DOMParser to fix malformed / unclosed tags and enforce
        |    an attribute allow-list on every element node
        |--------------------------------------------------------------------------
        */

        try
        {
            var parser = new DOMParser();

            var doc = parser.parseFromString(
                '<div id="__automator_sanitize_root__">' + sanitized + '</div>',
                'text/html'
            );

            var root = doc.getElementById('__automator_sanitize_root__');

            if(root)
            {
                var allowedAttributes = [
                    'href', 'src', 'alt', 'title', 'class', 'id',
                    'style', 'width', 'height', 'target', 'rel',
                    'colspan', 'rowspan', 'align', 'valign',
                    'type', 'start', 'reversed',
                    'data-automator-field',
                    'data-automator-field-name',
                    'data-automator-field-id'
                ];

                var walker = document.createTreeWalker(
                    root,
                    NodeFilter.SHOW_ELEMENT,
                    null,
                    false
                );

                var node;

                while((node = walker.nextNode()))
                {
                    var attrsToRemove = [];

                    for(var i = 0; i < node.attributes.length; i++)
                    {
                        var attr = node.attributes[i];

                        if(allowedAttributes.indexOf(attr.name.toLowerCase()) === -1)
                        {
                            attrsToRemove.push(attr.name);
                        }
                    }

                    attrsToRemove.forEach(function(attrName){
                        node.removeAttribute(attrName);
                    });

                    /* Double-check URI-scheme attributes after allow-list enforcement */
                    ['href', 'src', 'action', 'formaction'].forEach(function(a){

                        if(node.hasAttribute(a))
                        {
                            var val = (node.getAttribute(a) || '').trim().toLowerCase();

                            if(
                                val.indexOf('javascript:') === 0 ||
                                val.indexOf('vbscript:')   === 0 ||
                                val.indexOf('data:')       === 0
                            ) {
                                node.setAttribute(a, '#');
                            }
                        }
                    });
                }

                sanitized = root.innerHTML;
            }
        }
        catch(e)
        {
            /* DOMParser unavailable — fall back to the regex-sanitized string */
            console.warn('AutomatorEditorSanitizeContent: DOMParser failed.', e);
        }

        return sanitized;
    };

    /*
    |--------------------------------------------------------------------------
    | Auto-sanitize editor content on form submit
    |--------------------------------------------------------------------------
    */

    $(document).on(
        'submit',
        'form',
        function()
        {
            var $form = $(this);

            $form
                .find('textarea.automator-editor')
                .each(function(){

                    var $ta    = $(this);
                    var edId   = $ta.attr('data-automator-editor-id') || $ta.attr('id') || '';
                    var editor = edId ? (window.AutomatorEditors[edId] || null) : null;

                    if(editor)
                    {
                        AutomatorEditorSyncToSource(editor);
                    }

                    $ta.val(
                        AutomatorEditorSanitizeContent($ta.val())
                    );
                });
        }
    );

})(jQuery);


/*
|--------------------------------------------------------------------------
| Inicialização dos formulários renderizados diretamente na página
|--------------------------------------------------------------------------
*/

$(document).ready(function() {


  setTimeout(function() {


    AutomatorInitSystemPageFormChangeObservers(

      document

    );


  }, 100);


});


  /*
  |--------------------------------------------------------------------------
  | AUTOMATOR JSON EDITOR
  |--------------------------------------------------------------------------
  |
  | Editor hierárquico para campos JSON em formulários.
  |
  | O valor final permanece armazenado em um input hidden como JSON válido,
  | preservando o funcionamento atual dos formulários, do AJAX e do backend.
  |
  */


  function AutomatorJsonEditorNormalizeType(
    type = ''
  ) {


    type = String(

      type || ''

    )
      .trim()
      .toLowerCase();


    const allowedTypes = [

      'string',
      'number',
      'boolean',
      'null',
      'object',
      'array',

    ];


    if(

      allowedTypes.indexOf(

        type

      ) < 0

    ) {

      return 'string';

    }


    return type;


  }



  function AutomatorJsonEditorDetectType(
    value
  ) {


    if(value === null) {

      return 'null';

    }


    if(Array.isArray(value)) {

      return 'array';

    }


    if(

      typeof value === 'object'

    ) {

      return 'object';

    }


    if(

      typeof value === 'number'

    ) {

      return 'number';

    }


    if(

      typeof value === 'boolean'

    ) {

      return 'boolean';

    }


    return 'string';


  }



  function AutomatorJsonEditorCreateDefaultValue(
    type = 'string'
  ) {


    type = AutomatorJsonEditorNormalizeType(

      type

    );


    if(type == 'number') {

      return 0;

    }


    if(type == 'boolean') {

      return false;

    }


    if(type == 'null') {

      return null;

    }


    if(type == 'object') {

      return {};

    }


    if(type == 'array') {

      return [];

    }


    return '';


  }



  function AutomatorJsonEditorEscapeHtml(
    value = ''
  ) {


    return String(

      value === null ||
      value === undefined

        ? ''

        : value

    )
      .replace(
        /&/g,
        '&amp;'
      )
      .replace(
        /</g,
        '&lt;'
      )
      .replace(
        />/g,
        '&gt;'
      )
      .replace(
        /"/g,
        '&quot;'
      )
      .replace(
        /'/g,
        '&#039;'
      );


  }



  function AutomatorJsonEditorGenerateNodeID() {


    return (

      'automator-json-node-' +

      Date.now() +

      '-' +

      Math.floor(

        Math.random() * 999999

      )

    );


  }


  /*
  |--------------------------------------------------------------------------
  | Retorna o prefixo configurado no editor JSON
  |--------------------------------------------------------------------------
  */


  function AutomatorJsonEditorGetPrefix(
    editor
  ) {


    editor = $(editor);


    if(!editor.length) {

      return '';

    }


    return String(

      editor.attr(

        'data-automator-json-prefix'

      ) || ''

    );


  }


  /*
  |--------------------------------------------------------------------------
  | Retorna o sufixo configurado no editor JSON
  |--------------------------------------------------------------------------
  */


  function AutomatorJsonEditorGetSuffix(
    editor
  ) {


    editor = $(editor);


    if(!editor.length) {

      return '';

    }


    return String(

      editor.attr(

        'data-automator-json-suffix'

      ) || ''

    );


  }


  /*
  |--------------------------------------------------------------------------
  | Remove prefixo e sufixo configurados do valor
  |--------------------------------------------------------------------------
  */


  function AutomatorJsonEditorStripAffixes(
    editor,
    value = ''
  ) {


    editor = $(editor);


    value = String(

      value === null ||

      value === undefined

        ? ''

        : value

    );


    const prefix =

      AutomatorJsonEditorGetPrefix(

        editor

      );


    const suffix =

      AutomatorJsonEditorGetSuffix(

        editor

      );


    if(

      prefix != '' &&

      value.indexOf(prefix) === 0

    ) {

      value = value.substring(

        prefix.length

      );

    }


    if(

      suffix != '' &&

      value.length >= suffix.length &&

      value.substring(

        value.length -

        suffix.length

      ) == suffix

    ) {

      value = value.substring(

        0,

        value.length -

        suffix.length

      );

    }


    value = value.trim();


    if(value == '') {

      value = '{}';

    }


    return value;


  }


  function AutomatorJsonEditorParseValue(
    value = '',
    editor = null
  ) {


    if(

      editor !== null &&

      $(editor).length

    ) {


      value = AutomatorJsonEditorStripAffixes(

        editor,

        value

      );


    }


    if(

      value === null ||

      value === undefined ||

      value === ''

    ) {

      return {};

    }


    if(

      typeof value === 'object'

    ) {

      return value;

    }


    try {

      return JSON.parse(

        String(value)

      );

    } catch(error) {

      return {

        value: String(value),

      };

    }


  }


  /*
  |--------------------------------------------------------------------------
  | Retorna o identificador visual de um nó
  |--------------------------------------------------------------------------
  */


  function AutomatorJsonEditorGetNodeLabel(
    node
  ) {


    node = $(node);


    if(!node.length) {

      return 'Raiz';

    }


    if(

      node.attr(

        'data-root'

      ) == 'true'

    ) {

      return 'Raiz';

    }


    let key = String(

      node
        .children(
          '.automator-json-editor-node-header'
        )
        .find(
          '.automator-json-editor-node-key'
        )
        .first()
        .val() || ''

    ).trim();


    if(key == '') {

      key = 'Item sem nome';

    }


    return key;


  }


  /*
  |--------------------------------------------------------------------------
  | Atualiza os marcadores dos containers filhos
  |--------------------------------------------------------------------------
  */


  function AutomatorJsonEditorRefreshChildMarkers(
    container
  ) {


    container = $(container);


    if(!container.length) {

      return false;

    }


    let nodes = $();


    if(

      container.is(

        '.automator-json-editor-node'

      )

    ) {

      nodes = container.add(

        container.find(

          '.automator-json-editor-node'

        )

      );

    } else {

      nodes = container.find(

        '.automator-json-editor-node'

      );

    }


    nodes.each(function() {


      const node = $(this);


      const body = node
        .children(
          '.automator-json-editor-node-body'
        )
        .first();


      const childrenContainer = body
        .children(
          '.automator-json-editor-node-children'
        )
        .first();


      const marker = body
        .children(
          '.automator-json-editor-children-marker'
        )
        .first();


      if(

        !childrenContainer.length ||

        !marker.length

      ) {

        return;

      }


      const nodeType =

        AutomatorJsonEditorNormalizeType(

          node.attr(

            'data-node-type'

          )

        );


      const nodeLabel =

        AutomatorJsonEditorGetNodeLabel(

          node

        );


      marker.find(

        '.automator-json-editor-children-marker-name'

      ).text(

        nodeLabel

      );


      marker.find(

        '.automator-json-editor-children-marker-type'

      ).text(

        nodeType == 'array'

          ? 'Array'

          : 'Objeto'

      );


    });


    return true;


  }



  function AutomatorJsonEditorGetTypeOptions(
    selectedType = 'string'
  ) {


    selectedType = AutomatorJsonEditorNormalizeType(

      selectedType

    );


    const types = {

      string:  'Texto',
      number:  'Número',
      boolean: 'Booleano',
      null:    'Nulo',
      object:  'Objeto',
      array:   'Array',

    };


    let html = '';


    Object.keys(

      types

    ).forEach(function(type) {


      html +=

        '<option value="' +

          AutomatorJsonEditorEscapeHtml(type) +

        '"' +

        (

          type == selectedType

            ? ' selected'

            : ''

        ) +

        '>' +

          AutomatorJsonEditorEscapeHtml(

            types[type]

          ) +

        '</option>';


    });


    return html;


  }



  function AutomatorJsonEditorRenderScalarInput(
    type = 'string',
    value = ''
  ) {


    type = AutomatorJsonEditorNormalizeType(

      type

    );


    if(type == 'boolean') {


      return (

        '<select class="' +

          'form-select form-select-sm ' +

          'automator-json-editor-node-value' +

        '">' +

          '<option value="true"' +

          (

            value === true

              ? ' selected'

              : ''

          ) +

          '>true</option>' +

          '<option value="false"' +

          (

            value !== true

              ? ' selected'

              : ''

          ) +

          '>false</option>' +

        '</select>'

      );

    }


    if(type == 'null') {


      return (

        '<input ' +

          'type="text" ' +

          'class="' +

            'form-control form-control-sm ' +

            'automator-json-editor-node-value' +

          '" ' +

          'value="null" ' +

          'disabled ' +

        '/>'

      );

    }


    if(type == 'number') {


      return (

        '<input ' +

          'type="number" ' +

          'step="any" ' +

          'class="' +

            'form-control form-control-sm ' +

            'automator-json-editor-node-value' +

          '" ' +

          'value="' +

            AutomatorJsonEditorEscapeHtml(

              value

            ) +

          '" ' +

        '/>'

      );

    }


    return (

      '<input ' +

        'type="text" ' +

        'class="' +

          'form-control form-control-sm ' +

          'automator-json-editor-node-value' +

        '" ' +

        'value="' +

          AutomatorJsonEditorEscapeHtml(

            value

          ) +

        '" ' +

      '/>'

    );


  }



  function AutomatorJsonEditorRenderNode(
    key = '',
    value = '',
    options = {}
  ) {


    options =

      options &&

      typeof options === 'object'

        ? options

        : {};


    const isRoot =

      options.isRoot === true;


    const parentType =

      AutomatorJsonEditorNormalizeType(

        options.parentType || 'object'

      );


    const nodeType =

      AutomatorJsonEditorDetectType(

        value

      );


    const nodeID =

      AutomatorJsonEditorGenerateNodeID();


    const keyDisabled =

      isRoot === true ||

      parentType == 'array';


    const nodeLabel =

      isRoot === true

        ? 'Raiz'

        : String(

            key || ''

          ).trim() != ''

          ? String(key)

          : 'Item sem nome';


    let html = '';


    html +=

      '<div ' +

        'class="' +

          'automator-json-editor-node ' +

          'border rounded mb-2 bg-light' +

        '" ' +

        'data-automator-json-node="true" ' +

        'data-node-id="' +

          AutomatorJsonEditorEscapeHtml(

            nodeID

          ) +

        '" ' +

        'data-node-type="' +

          AutomatorJsonEditorEscapeHtml(

            nodeType

          ) +

        '" ' +

        'data-root="' +

          (

            isRoot === true

              ? 'true'

              : 'false'

          ) +

        '" ' +

      '>';


      html +=

        '<div class="' +

          'automator-json-editor-node-header ' +

          'p-2 border-bottom bg-white' +

        '">';


        html +=

          '<div class="row g-2 align-items-center">';


          html +=

            '<div class="col-12 col-md">';


            html +=

              '<input ' +

                'type="text" ' +

                'class="' +

                  'form-control form-control-sm ' +

                  'automator-json-editor-node-key' +

                '" ' +

                'placeholder="' +

                  (

                    parentType == 'array'

                      ? 'Índice automático'

                      : 'Nome da variável'

                  ) +

                '" ' +

                'value="' +

                  AutomatorJsonEditorEscapeHtml(

                    key

                  ) +

                '" ' +

                (

                  keyDisabled === true

                    ? 'disabled '

                    : ''

                ) +

              '/>';


          html += '</div>';


          html +=

            '<div class="col-8 col-md-auto">';


            html +=

              '<select class="' +

                'form-select form-select-sm ' +

                'automator-json-editor-node-type' +

              '">';


              html +=

                AutomatorJsonEditorGetTypeOptions(

                  nodeType

                );


            html += '</select>';


          html += '</div>';


          html +=

            '<div class="col-4 col-md-auto">';


            if(isRoot !== true) {


              html +=

                '<button ' +

                  'type="button" ' +

                  'class="' +

                    'btn btn-sm btn-outline-danger w-100 ' +

                    'automator-json-editor-node-delete' +

                  '" ' +

                  'title="Excluir variável"' +

                '>' +

                  '<i class="fa fa-trash"></i>' +

                '</button>';


            }


          html += '</div>';


        html += '</div>';


      html += '</div>';


      html +=

        '<div class="' +

          'automator-json-editor-node-body p-2' +

        '">';


        if(

          nodeType == 'object' ||

          nodeType == 'array'

        ) {


          html +=

            '<div class="' +

              'automator-json-editor-children-marker ' +

              'd-flex align-items-center gap-2 ' +

              'small text-muted mb-2 px-2 py-1 ' +

              'border-start border-3 border-primary bg-white' +

            '">';


            html +=

              '<span>Itens pertencentes a:</span>';


            html +=

              '<strong class="' +

                'automator-json-editor-children-marker-name ' +

                'text-dark text-break' +

              '">' +

                AutomatorJsonEditorEscapeHtml(

                  nodeLabel

                ) +

              '</strong>';


            html +=

              '<span class="' +

                'badge text-bg-secondary ' +

                'automator-json-editor-children-marker-type' +

              '">' +

                (

                  nodeType == 'array'

                    ? 'Array'

                    : 'Objeto'

                ) +

              '</span>';


          html += '</div>';


          html +=

            '<div class="' +

              'automator-json-editor-node-children' +

            '" ' +

            'data-container-type="' +

              AutomatorJsonEditorEscapeHtml(

                nodeType

              ) +

            '"' +

            '>';


            if(nodeType == 'array') {


              value.forEach(function(

                childValue,

                childIndex

              ) {


                html +=

                  AutomatorJsonEditorRenderNode(

                    String(childIndex),

                    childValue,

                    {

                      parentType: 'array',
                      isRoot: false,

                    }

                  );


              });


            } else {


              Object.keys(

                value || {}

              ).forEach(function(childKey) {


                html +=

                  AutomatorJsonEditorRenderNode(

                    childKey,

                    value[childKey],

                    {

                      parentType: 'object',
                      isRoot: false,

                    }

                  );


              });


            }


          html += '</div>';


          html +=

            '<button ' +

              'type="button" ' +

              'class="' +

                'btn btn-sm btn-outline-primary w-100 ' +

                'automator-json-editor-node-add' +

              '" ' +

              'data-container-type="' +

                AutomatorJsonEditorEscapeHtml(

                  nodeType

                ) +

              '"' +

            '>' +

              '<i class="fa fa-plus me-1"></i>' +

              (

                nodeType == 'array'

                  ? 'Adicionar item'

                  : 'Adicionar variável'

              ) +

            '</button>';


        } else {


          html +=

            '<div class="automator-json-editor-node-scalar">';


            html +=

              AutomatorJsonEditorRenderScalarInput(

                nodeType,

                value

              );


          html += '</div>';


        }


      html += '</div>';


    html += '</div>';


    return html;


  }



  function AutomatorJsonEditorReadScalarValue(
    node,
    type = 'string'
  ) {


    node = $(node);


    type = AutomatorJsonEditorNormalizeType(

      type

    );


    const input = node
      .children(
        '.automator-json-editor-node-body'
      )
      .find(
        '> .automator-json-editor-node-scalar ' +
        '> .automator-json-editor-node-value'
      )
      .first();


    if(type == 'null') {

      return null;

    }


    if(type == 'boolean') {

      return String(

        input.val()

      ) == 'true';

    }


    if(type == 'number') {


      const rawValue = String(

        input.val() || ''

      ).trim();


      if(rawValue == '') {

        return 0;

      }


      const numberValue = Number(

        rawValue

      );


      return isNaN(numberValue)

        ? 0

        : numberValue;

    }


    return String(

      input.val() || ''

    );


  }



  function AutomatorJsonEditorReadNode(
    node
  ) {


    node = $(node);


    const nodeType =

      AutomatorJsonEditorNormalizeType(

        node.attr(

          'data-node-type'

        )

      );


    if(

      nodeType != 'object' &&

      nodeType != 'array'

    ) {

      return AutomatorJsonEditorReadScalarValue(

        node,

        nodeType

      );

    }


    const childrenContainer = node
      .children(
        '.automator-json-editor-node-body'
      )
      .children(
        '.automator-json-editor-node-children'
      )
      .first();


    const childNodes = childrenContainer
      .children(
        '.automator-json-editor-node'
      );


    if(nodeType == 'array') {


      const result = [];


      childNodes.each(function() {


        result.push(

          AutomatorJsonEditorReadNode(

            this

          )

        );


      });


      return result;

    }


    const result = {};


    childNodes.each(function(index) {


      const childNode = $(this);


      let childKey = String(

        childNode
          .children(
            '.automator-json-editor-node-header'
          )
          .find(
            '.automator-json-editor-node-key'
          )
          .first()
          .val() || ''

      ).trim();


      if(childKey == '') {

        childKey =

          'variavel_' +

          (

            index + 1

          );

      }


      result[childKey] =

        AutomatorJsonEditorReadNode(

          childNode

        );


    });


    return result;


  }



  function AutomatorJsonEditorShowError(
    editor,
    message = ''
  ) {


    editor = $(editor);


    const errorContainer = editor.find(

      '.automator-json-editor-error'

    ).first();


    if(message == '') {


      errorContainer
        .addClass(
          'd-none'
        )
        .empty();


      return true;

    }


    errorContainer
      .removeClass(
        'd-none'
      )
      .text(
        message
      );


    return true;


  }



  function AutomatorJsonEditorTriggerFormChange(
    editor
  ) {


    editor = $(editor);


    const valueInput = editor.find(

      '.automator-json-editor-value'

    ).first();


    valueInput.trigger(

      'input'

    );


    valueInput.trigger(

      'change'

    );


    const form = editor.closest(

      'form'

    );


    if(form.length) {


      form.attr(

        'data-automator-form-changed',

        'true'

      );


      form.find(

        'button[type="submit"], input[type="submit"]'

      ).prop(

        'disabled',

        false

      );


    }


    return true;


  }



  function AutomatorJsonEditorSyncValue(
    editor,
    triggerChange = true
  ) {


    editor = $(editor);


    const rootNode = editor
      .find(
        '> .automator-json-editor-content ' +
        '> .automator-json-editor-tree ' +
        '> .automator-json-editor-node'
      )
      .first();


    const valueInput = editor.find(

      '.automator-json-editor-value'

    ).first();


    if(

      !rootNode.length ||

      !valueInput.length

    ) {

      return false;

    }


    try {


      const value =

        AutomatorJsonEditorReadNode(

          rootNode

        );


      const jsonValue = JSON.stringify(

        value

      );


      const finalValue =

        AutomatorJsonEditorJoinAffixes(

          editor,

          jsonValue

        );


      valueInput.val(

        finalValue

      );


      valueInput.attr(

        'data-automator-json-internal-value',

        jsonValue

      );


      AutomatorJsonEditorRefreshChildMarkers(

        editor

      );


      AutomatorJsonEditorShowError(

        editor,

        ''

      );


      if(triggerChange === true) {


        AutomatorJsonEditorTriggerFormChange(

          editor

        );


      }


      return true;


    } catch(error) {


      AutomatorJsonEditorShowError(

        editor,

        'Não foi possível gerar o JSON: ' +

        error.message

      );


      return false;


    }


  }



  function AutomatorJsonEditorRefreshArrayIndexes(
    container
  ) {


    container = $(container);


    if(

      container.attr(

        'data-container-type'

      ) != 'array'

    ) {

      return false;

    }


    container
      .children(
        '.automator-json-editor-node'
      )
      .each(function(index) {


        $(this)
          .children(
            '.automator-json-editor-node-header'
          )
          .find(
            '.automator-json-editor-node-key'
          )
          .first()
          .val(
            index
          );


      });


    return true;


  }



  function AutomatorJsonEditorChangeNodeType(
    node,
    newType = 'string'
  ) {


    node = $(node);


    newType = AutomatorJsonEditorNormalizeType(

      newType

    );


    let currentValue;


    try {

      currentValue = AutomatorJsonEditorReadNode(

        node

      );

    } catch(error) {

      currentValue = null;

    }


    let newValue =

      AutomatorJsonEditorCreateDefaultValue(

        newType

      );


    if(newType == 'string') {


      if(

        currentValue !== null &&

        typeof currentValue !== 'object'

      ) {

        newValue = String(

          currentValue

        );

      }


    } else if(newType == 'number') {


      const parsedNumber = Number(

        currentValue

      );


      newValue = isNaN(parsedNumber)

        ? 0

        : parsedNumber;


    } else if(newType == 'boolean') {


      newValue = (

        currentValue === true ||

        currentValue === 1 ||

        currentValue === '1' ||

        currentValue === 'true'

      );


    } else if(newType == 'object') {


      if(

        currentValue &&

        typeof currentValue === 'object' &&

        !Array.isArray(currentValue)

      ) {

        newValue = currentValue;

      }


    } else if(newType == 'array') {


      if(Array.isArray(currentValue)) {

        newValue = currentValue;

      }


    }


    const body = node
      .children(
        '.automator-json-editor-node-body'
      )
      .first();


    node.attr(

      'data-node-type',

      newType

    );


    let bodyHtml = '';


    if(

      newType == 'object' ||

      newType == 'array'

    ) {


      bodyHtml +=

        '<div class="' +

          'automator-json-editor-children-marker ' +

          'd-flex align-items-center gap-2 ' +

          'small text-muted mb-2 px-2 py-1 ' +

          'border-start border-3 border-primary bg-white' +

        '">';


        bodyHtml +=

          '<span>Itens pertencentes a:</span>';


        bodyHtml +=

          '<strong class="' +

            'automator-json-editor-children-marker-name ' +

            'text-dark text-break' +

          '">' +

            AutomatorJsonEditorEscapeHtml(

              AutomatorJsonEditorGetNodeLabel(

                node

              )

            ) +

          '</strong>';


        bodyHtml +=

          '<span class="' +

            'badge text-bg-secondary ' +

            'automator-json-editor-children-marker-type' +

          '">' +

            (

              newType == 'array'

                ? 'Array'

                : 'Objeto'

            ) +

          '</span>';


      bodyHtml += '</div>';


      bodyHtml +=

        '<div ' +

          'class="automator-json-editor-node-children" ' +

          'data-container-type="' +

            AutomatorJsonEditorEscapeHtml(

              newType

            ) +

          '"' +

        '>';

        if(newType == 'array') {


          newValue.forEach(function(

            childValue,

            childIndex

          ) {


            bodyHtml +=

              AutomatorJsonEditorRenderNode(

                String(childIndex),

                childValue,

                {

                  parentType: 'array',

                }

              );


          });


        } else {


          Object.keys(

            newValue

          ).forEach(function(childKey) {


            bodyHtml +=

              AutomatorJsonEditorRenderNode(

                childKey,

                newValue[childKey],

                {

                  parentType: 'object',

                }

              );


          });


        }


      bodyHtml += '</div>';


      bodyHtml +=

        '<button ' +

          'type="button" ' +

          'class="' +

            'btn btn-sm btn-outline-primary w-100 ' +

            'automator-json-editor-node-add' +

          '" ' +

          'data-container-type="' +

            AutomatorJsonEditorEscapeHtml(

              newType

            ) +

          '"' +

        '>' +

          '<i class="fa fa-plus me-1"></i>' +

          (

            newType == 'array'

              ? 'Adicionar item'

              : 'Adicionar variável'

          ) +

        '</button>';


    } else {


      bodyHtml +=

        '<div class="automator-json-editor-node-scalar">';


        bodyHtml +=

          AutomatorJsonEditorRenderScalarInput(

            newType,

            newValue

          );


      bodyHtml += '</div>';


    }


    body.html(

      bodyHtml

    );


    AutomatorJsonEditorRefreshChildMarkers(

      node

    );


    return true;


  }



  function AutomatorJsonEditorBindEvents(
    editor
  ) {


    editor = $(editor);


    editor
      .off(
        '.automator-json-editor'
      );


    editor
      .on(
        'click.automator-json-editor',
        '.automator-json-editor-node-add',
        function(event) {


          event.preventDefault();

          event.stopPropagation();


          const button = $(this);


          const node = button.closest(

            '.automator-json-editor-node'

          );


          const childrenContainer = node
            .children(
              '.automator-json-editor-node-body'
            )
            .children(
              '.automator-json-editor-node-children'
            )
            .first();


          const containerType =

            AutomatorJsonEditorNormalizeType(

              childrenContainer.attr(

                'data-container-type'

              )

            );


          const childIndex = childrenContainer
            .children(
              '.automator-json-editor-node'
            )
            .length;


          const childKey =

            containerType == 'array'

              ? String(childIndex)

              : 'variavel_' +

                (

                  childIndex + 1

                );


          childrenContainer.append(

            AutomatorJsonEditorRenderNode(

              childKey,

              '',

              {

                parentType:

                  containerType,

              }

            )

          );


          AutomatorJsonEditorRefreshArrayIndexes(

            childrenContainer

          );


          AutomatorJsonEditorRefreshChildMarkers(

            editor

          );


          AutomatorJsonEditorSyncValue(

            editor,

            true

          );


          const lastNode = childrenContainer
            .children(
              '.automator-json-editor-node'
            )
            .last();


          lastNode
            .find(
              '.automator-json-editor-node-key:not(:disabled)'
            )
            .first()
            .trigger(
              'focus'
            );


          return false;


        }
      );


    editor
      .on(
        'click.automator-json-editor',
        '.automator-json-editor-node-delete',
        function(event) {


          event.preventDefault();

          event.stopPropagation();


          const node = $(this).closest(

            '.automator-json-editor-node'

          );


          const parentContainer = node.parent(

            '.automator-json-editor-node-children'

          );


          node.remove();


          AutomatorJsonEditorRefreshArrayIndexes(

            parentContainer

          );


          AutomatorJsonEditorRefreshChildMarkers(

            editor

          );


          AutomatorJsonEditorSyncValue(

            editor,

            true

          );


          return false;


        }
      );


    editor
      .on(
        'change.automator-json-editor',
        '.automator-json-editor-node-type',
        function() {


          const node = $(this).closest(

            '.automator-json-editor-node'

          );


          AutomatorJsonEditorChangeNodeType(

            node,

            $(this).val()

          );


          AutomatorJsonEditorRefreshChildMarkers(

            editor

          );


          AutomatorJsonEditorSyncValue(

            editor,

            true

          );


        }
      );


    editor
      .on(
        'input.automator-json-editor ' +
        'change.automator-json-editor',
        '.automator-json-editor-node-key, ' +
        '.automator-json-editor-node-value',
        function() {


          AutomatorJsonEditorRefreshChildMarkers(

            editor

          );


          AutomatorJsonEditorSyncValue(

            editor,

            true

          );


        }
      );


    editor
      .on(
        'click.automator-json-editor',
        '.automator-json-editor-format',
        function(event) {


          event.preventDefault();

          event.stopPropagation();


          AutomatorJsonEditorSyncValue(

            editor,

            false

          );


          const valueInput = editor.find(

            '.automator-json-editor-value'

          ).first();


          let currentValue = {};


          try {


            currentValue =

              AutomatorJsonEditorParseValue(

                valueInput.val(),

                editor

              );


          } catch(error) {


            AutomatorJsonEditorShowError(

              editor,

              'O valor atual não contém um JSON válido.'

            );


            return false;


          }


          const rootTree = editor.find(

            '.automator-json-editor-tree'

          ).first();


          rootTree.html(

            AutomatorJsonEditorRenderNode(

              '',

              currentValue,

              {

                isRoot: true,
                parentType: 'object',

              }

            )

          );


          AutomatorJsonEditorRefreshChildMarkers(

            editor

          );


          AutomatorJsonEditorSyncValue(

            editor,

            true

          );


          return false;


        }
      );


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Atualiza o valor e a árvore visual de um editor JSON já renderizado
  |--------------------------------------------------------------------------
  */


  function AutomatorJsonEditorSetValue(
    target,
    value = {},
    triggerChange = false
  ) {


    target = $(target);


    if(!target.length) {

      return false;

    }


    let editor = $();


    if(
      target.is(
        '[data-automator-json-editor="true"]'
      )
    ) {

      editor = target.first();

    } else {


      editor = target.closest(

        '[data-automator-json-editor="true"]'

      ).first();


      if(!editor.length) {


        editor = target.find(

          '[data-automator-json-editor="true"]'

        ).first();


      }


    }


    if(!editor.length) {

      return false;

    }


    const valueInput = editor.find(

      '.automator-json-editor-value'

    ).first();


    const rootTree = editor.find(

      '.automator-json-editor-tree'

    ).first();


    if(

      !valueInput.length ||

      !rootTree.length

    ) {

      return false;

    }


    let parsedValue = {};


    try {


      parsedValue =

        AutomatorJsonEditorParseValue(

          value,

          editor

        );


    } catch(error) {


      parsedValue = {};


      AutomatorJsonEditorShowError(

        editor,

        'O valor informado não contém um JSON válido.'

      );


    }


    if(

      parsedValue === undefined ||

      typeof parsedValue === 'function'

    ) {

      parsedValue = {};

    }


    let jsonValue = '{}';


    try {


      jsonValue = JSON.stringify(

        parsedValue

      );


      if(

        jsonValue === undefined ||

        jsonValue === null ||

        jsonValue === ''

      ) {

        jsonValue = '{}';

      }


    } catch(error) {


      parsedValue = {};


      jsonValue = '{}';


      AutomatorJsonEditorShowError(

        editor,

        'Não foi possível converter o valor informado para JSON.'

      );


    }


    valueInput.val(

      AutomatorJsonEditorJoinAffixes(

        editor,

        jsonValue

      )

    );


    valueInput.attr(

      'data-automator-json-internal-value',

      jsonValue

    );


    rootTree.html(

      AutomatorJsonEditorRenderNode(

        '',

        parsedValue,

        {

          isRoot: true,

          parentType: 'object',

        }

      )

    );


    AutomatorJsonEditorBindEvents(

      editor

    );


    AutomatorJsonEditorRefreshChildMarkers(

      editor

    );


    editor.attr(

      'data-automator-json-initialized',

      'true'

    );


    AutomatorJsonEditorSyncValue(

      editor,

      triggerChange === true

    );


    if(triggerChange !== true) {


      AutomatorJsonEditorShowError(

        editor,

        ''

      );


    }


    return true;


  }



  function AutomatorJsonEditorInitialize(
    editor
  ) {


    editor = $(editor);


    if(

      !editor.length ||

      editor.attr(

        'data-automator-json-initialized'

      ) == 'true'

    ) {

      return false;

    }


    const valueInput = editor.find(

      '.automator-json-editor-value'

    ).first();


    let initialValue = {};


    try {


      initialValue =

        AutomatorJsonEditorParseValue(

          valueInput.val(),

          editor

        );


    } catch(error) {


      initialValue = {};


      AutomatorJsonEditorShowError(

        editor,

        'O valor salvo não contém um JSON válido.'

      );


    }


    editor.find(

      '.automator-json-editor-tree'

    ).first().html(

      AutomatorJsonEditorRenderNode(

        '',

        initialValue,

        {

          isRoot: true,
          parentType: 'object',

        }

      )

    );


    AutomatorJsonEditorBindEvents(

      editor

    );


    AutomatorJsonEditorRefreshChildMarkers(

      editor

    );


    AutomatorJsonEditorSyncValue(

      editor,

      false

    );


    editor.attr(

      'data-automator-json-initialized',

      'true'

    );


    return true;


  }



  function AutomatorJsonEditorInitializeAll(
    container = document
  ) {


    $(container)
      .find(
        '[data-automator-json-editor="true"]'
      )
      .addBack(
        '[data-automator-json-editor="true"]'
      )
      .each(function() {


        AutomatorJsonEditorInitialize(

          this

        );


      });


    return true;


  }


  /*
  |--------------------------------------------------------------------------
  | Une prefixo, valor interno e sufixo
  |--------------------------------------------------------------------------
  */


  function AutomatorJsonEditorJoinAffixes(
    editor,
    value = ''
  ) {


    editor = $(editor);


    value = String(

      value === null ||

      value === undefined ||

      value === ''

        ? '{}'

        : value

    );


    return (

      AutomatorJsonEditorGetPrefix(

        editor

      ) +

      value +

      AutomatorJsonEditorGetSuffix(

        editor

      )

    );


  }


  function AutomatorJsonEditorObserveDOM() {


    if(

      window.__automatorJsonEditorObserver

    ) {

      return window.__automatorJsonEditorObserver;

    }


    const observer = new MutationObserver(

      function(mutations) {


        mutations.forEach(function(mutation) {


          mutation.addedNodes.forEach(function(node) {


            if(

              !node ||

              node.nodeType !== 1

            ) {

              return;

            }


            AutomatorJsonEditorInitializeAll(

              node

            );


          });


        });


      }

    );


    observer.observe(

      document.body,

      {

        childList: true,
        subtree: true,

      }

    );


    window.__automatorJsonEditorObserver =

      observer;


    return observer;


  }



  document.addEventListener(

    'DOMContentLoaded',

    function() {


      AutomatorJsonEditorInitializeAll(

        document

      );


      AutomatorJsonEditorObserveDOM();


    }

  );


/*
|--------------------------------------------------------------------------
| AUTOMATOR LOGIN RETURN URL
|--------------------------------------------------------------------------
|
| Recupera a URL salva antes do redirecionamento causado pela expiração da
| sessão e a aplica ao retorno da API de login.
|
*/


function AutomatorLoginGetStoredReturnURL() {


  var returnURL = '';

  var createdAt = 0;


  try {


    returnURL = String(

      sessionStorage.getItem(

        'automator.return.url'

      ) || ''

    );


    createdAt = Number(

      sessionStorage.getItem(

        'automator.return.created'

      ) || 0

    );


  } catch(error) {


    return '';


  }


  if(returnURL == '') {

    return '';

  }


  /*
  |--------------------------------------------------------------------------
  | Expiração do cache da URL
  |--------------------------------------------------------------------------
  |
  | O endereço é aceito por até 2 horas.
  |
  */

  if(

    createdAt > 0 &&

    Date.now() - createdAt > 7200000

  ) {


    AutomatorLoginClearStoredReturnURL();

    return '';


  }


  /*
  |--------------------------------------------------------------------------
  | Aceita somente URL relativa interna
  |--------------------------------------------------------------------------
  */

  if(

    returnURL.charAt(0) != '/' ||

    returnURL.indexOf('//') == 0

  ) {


    AutomatorLoginClearStoredReturnURL();

    return '';


  }


  return returnURL;


}



function AutomatorLoginClearStoredReturnURL() {


  try {


    sessionStorage.removeItem(

      'automator.return.url'

    );


    sessionStorage.removeItem(

      'automator.return.created'

    );


  } catch(error) {}


  return true;


}



function AutomatorLoginApplyStoredReturnURL(
  response = null
) {


  if(

    !response ||

    typeof response !== 'object'

  ) {

    return response;

  }


  var authenticated = (

    response.auth_check === true ||

    response.auth_check === 1 ||

    response.auth_check === '1' ||

    response.auth_check === 'true'

  );


  if(

    response.status !== true ||

    authenticated !== true

  ) {

    return response;

  }


  var returnURL =

    AutomatorLoginGetStoredReturnURL();


  if(returnURL == '') {

    return response;

  }


  response.redirect_url =

    returnURL;


  AutomatorLoginClearStoredReturnURL();


  return response;


}



/*
|--------------------------------------------------------------------------
| Intercepta o retorno do AJAX de login
|--------------------------------------------------------------------------
|
| O prefilter envolve o callback success antes da requisição ser executada.
| Dessa forma, o código atual do login recebe o redirect_url já corrigido.
|
*/

if(

  typeof jQuery !== 'undefined' &&

  typeof jQuery.ajaxPrefilter === 'function'

) {


  jQuery.ajaxPrefilter(function(

    options,

    originalOptions,

    jqXHR

  ) {


    var originalSuccess =

      options.success;


    options.success = function(

      response,

      textStatus,

      currentXHR

    ) {


      response =

        AutomatorLoginApplyStoredReturnURL(

          response

        );


      if(

        typeof originalSuccess === 'function'

      ) {

        return originalSuccess.call(

          this,

          response,

          textStatus,

          currentXHR

        );

      }


    };


  });


}