<button
  type="button"
  id="btn-add-route"
  class="btn d-inline-flex align-items-center gap-2 btn-success"
  onclick="AutomatorCreateViewModal(
    { view: 'system-page-editor' },
    {
      size: 'fullscreen',
      backdrop: true,
      keyboard: false,
      keepLoaderUntilCallback: true,

      callback: function(response, modalEl, modal, recordData) {
        SysAutomatorConfigPageEditor(response, modalEl, modal, recordData);
      },

      afterHideOn: function(response, modalEl, modal, recordData) {
        SysAutomatorDestroyPageEditor(response, modalEl, modal, recordData);
      }
    }
  );"
>
  <i class="fa fa-plus"></i>
  Nova Página
</button>


<button type="button"
        id="btn-add-form"
        class="btn d-inline-flex align-items-center gap-2 btn-success"
        onclick="AutomatorCreateViewModal(
          { view: 'system-form-editor' },
          {
            size: 'fullscreen',
            backdrop: true,
            keyboard: false,
            scrollable: false,
            keepLoaderUntilCallback: true,

            callback: function(response, modalEl, modal, recordData) {
              SysAutomatorConfigFormEditor(response, modalEl, modal, recordData);
            },

            afterHideOn: function(response, modalEl, modal, recordData) {
              SysAutomatorDestroyFormEditor(response, modalEl, modal, recordData);
            }
          }
        );">
  <i class="fa fa-plus"></i>
  Novo Formulário
</button>

<button type="button" id="btn-add-pagination" class="btn d-inline-flex align-items-center gap-2 btn btn-success" onclick="AutomatorCreateViewModal(
                      {
                        view: 'system-pagination-editor',
                        editorAction: 'store'
                      },
                      {
                        editorAction: 'store',
                        size: 'fullscreen',
                        backdrop: true,
                        keyboard: false,
                        scrollable: true,
                        keepLoaderUntilCallback: true,

                        callback: function(response, modalEl, modal, recordData) {

                          response.acao = 'store';
                          response.editorAction = 'store';
                          response.paginationID = null;
                          response.pagination_id = null;
                          response.tbl_sys_pagination_ID = null;

                          SysAutomatorConfigPaginationEditor(
                            response,
                            modalEl,
                            modal,
                            {}
                          );

                        },

                        afterHideOn: function(response, modalEl, modal, recordData) {

                          SysAutomatorDestroyPaginationEditor(
                            response,
                            modalEl,
                            modal,
                            recordData
                          );

                        }
                      }
                    );"><i class="fa fa-plus"></i> Nova Paginação</button>
<!-- <button type="button" id="btn-add-route" class="btn d-inline-flex align-items-center gap-2 btn btn-success" onclick="AutomatorCreateViewModal({ view: 'system-page-editor' }, { size: 'fullscreen', backdrop: true, keyboard: false, beforeShow: function(response, modalEl, modal, recordData){ SysAutomatorConfigPageEditor(response, modalEl, modal, recordData); }, callback: function(response, modalEl, modal, recordData ){ SysAutomatorInitPageEditor(response, modalEl, modal, recordData); }, afterHideOn: function(response, modalEl, modal, recordData) { SysAutomatorDestroyPageEditor(response, modalEl, modal, recordData); }});"><i class="fa fa-plus"></i> Nova Página</button> -->
