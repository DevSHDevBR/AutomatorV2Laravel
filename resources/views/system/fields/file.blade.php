@if($render == 'formulario')
  
  @php

    $placeholder = $props['placeholder']
      ?? $config['placeholder']
      ?? $field_label;

    $uploadURL = SysAutomator::SysAutomatorGetRouteLinkByName(
      'admin-api-functions',
      [],
      true
    );

    $currentValue = SysAutomator::SysAutomatorResolveSysFunctionsValue(
      $field_value
    );

    /*
    |--------------------------------------------------------------------------
    | Tipo opcional do upload
    |--------------------------------------------------------------------------
    |
    | Caso sua tabela exija tbl_sys_uploads_type_ID, você pode informar:
    |
    | 'upload_type_id' => 1
    |
    | nas configurações do campo.
    |
    */

    $uploadTypeID = $props['upload_type_id']
      ?? $config['upload_type_id']
      ?? null;

  @endphp

  <style>

    #data-file-preview > div {
      margin-left: auto !important;
      margin-right: auto !important;
      background-repeat: no-repeat !important;
      background-size: contain !important;
    }
    
  </style>

  <div class="mb-3 {{ $props['wrapper_class'] ?? 'col-12' }}" data-automator-file-upload >

    <input
      type="hidden"
      id="{{ $field_id }}"
      name="{{ $field_name }}"
      value="{{ $currentValue }}"
      class="{{ $field_class }}"
      data-file-hidden
      data-automator-field="true"
      data-automator-field-name="{{ $field_name }}"
      data-automator-field-id="{{ $field_id }}"
      {!! $field_attrs !!}
    >

    <input
      type="file"
      id="{{ $field_id }}-arquivo"
      name="arquivo123"
      class="form-control d-none"
      data-file-input
      data-upload-url="{{ $uploadURL }}"
      data-upload-type-id="{{ $uploadTypeID }}"
      {!! $field_required && empty($currentValue) ? 'required' : '' !!}
    />
    <div class="d-table w-100 fs-5 mb-3">

      {!! $placeholder !!}

      {!! $field_required
        ? '<span class="text-danger">*</span>'
        : ''
      !!}

    </div>
    <div id="automator-file-row" class="row">

      <div class="col-12 col-md-5">

        <div class="col-12 mb-3"><button onclick="AutomatorFileInputSendFile(this, '{!! $field_id !!}-arquivo')" type="button" class="btn btn-success w-100">Enviar Arquivo</button></div>
        <div class="col-12 mb-3"><button onclick="AutomatorFileSelectLibFile(this, '{!! $field_id !!}')" type="button" class="btn btn-primary w-100">Utilizar Galeria</button></div>

      </div>

      <div class="col-12 col-md-7">
        
        <div class="row">
          <div class="col-12 col-sm-8 col-md-9">
          
            <div id="data-file-preview" data-field="{!! $field_id !!}" data-file-preview style="height: 100%;">

              <div class="border rounded d-flex align-items-center justify-content-center overflow-hidden bg-light mx-auto text-center h-100 p-2">Nenhum arquivo selecionado</div>
          
            </div>

          </div>
          <div class="col-12 col-sm-4 col-md-3">

            <div class="upload-actions mt-2 {{ empty($currentValue) ? 'd-none' : '' }}" data-file-actions>
              
              <div class="d-none d-md-table">
                
                <button type="button" onclick="AutomatorViewSelectedFile(this, '{!! $field_id !!}')" class="btn btn-secondary" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-title="Visualizar Arquivo"><i class="fa fa-eye"></i></button>
                <button type="button" onclick="AutomatorDeleteSelectedFile(this, '{!! $field_id !!}')" class="btn btn-danger mt-2" data-bs-toggle="tooltip" data-bs-trigger="hover" data-bs-title="Remover Arquivo"><i class="fa fa-trash"></i></button>

              </div>
              <div class="d-table w-100 d-md-none">

                <button type="button" class="btn btn-secondary w-100" onclick="AutomatorViewSelectedFile(this, '{!! $field_id !!}')">Visualizar Arquivo</button>
                <button type="button" class="btn btn-danger w-100 mt-2" onclick="AutomatorDeleteSelectedFile(this, '{!! $field_id !!}')">Remover Arquivo</button>

              </div>

            </div>
          </div>
        </div>

      </div>

    </div>

    <div class="progress mt-2" data-file-progress style="height: 22px; display: none;">

      <div

        class="progress-bar progress-bar-striped progress-bar-animated"
        data-file-progress-bar
        role="progressbar"
        style="width: 0%;"
        aria-valuemin="0"
        aria-valuemax="100"
        aria-valuenow="0"
      
      >
        0%
      </div>

    </div>

    <div class="small mt-2 d-none" data-file-message></div>

  </div>

  @once

    <script>

      class AutomatorTemporaryFileUploader {

        constructor(container) {

          this.container = container;

          this.fileInput = container.querySelector(
            '[data-file-input]'
          );

          this.hiddenInput = container.querySelector(
            '[data-file-hidden]'
          );

          this.progress = container.querySelector(
            '[data-file-progress]'
          );

          this.progressBar = container.querySelector(
            '[data-file-progress-bar]'
          );

          this.message = container.querySelector(
            '[data-file-message]'
          );

          this.actions = container.querySelector(
            '[data-file-actions]'
          );

          this.preview = container.querySelector(
            '[data-file-preview]'
          );

          this.fileRow = container.querySelector(
            '#automator-file-row'
          );

          this.uploadURL =
            this.fileInput?.dataset.uploadUrl || '';

          this.uploadTypeID =
            this.fileInput?.dataset.uploadTypeId || '';

          this.currentFile = null;

          this.xhr = null;

          this.bindEvents();

          this.loadExistingValue();

          /*
          |--------------------------------------------------------------------------
          | Guarda a instância no elemento
          |--------------------------------------------------------------------------
          */

          this.container.automatorUploaderInstance = this;

        }


        getCsrfToken() {

          return document
            .querySelector('meta[name="csrf-token"]')
            ?.getAttribute('content') || '';

        }


        bindEvents() {

          if(!this.fileInput) {

            return;

          }

          this.fileInput.addEventListener(
            'change',
            event => {

              if(
                this.fileInput.dataset.automatorFileGlobalUpload === 'true' ||
                this.fileInput.dataset.automatorFileGlobalUpload === 'processing'
              ) {

                return;

              }

              event.preventDefault();
              event.stopPropagation();

              const file =
                event.target.files?.[0] || null;

              if(!file) {

                return;

              }

              this.upload(file);

            }
          );

        }


        loadExistingValue() {

          const value = String(
            this.hiddenInput?.value || ''
          ).trim();

          if(value === '') {

            this.renderButtons();

            return;

          }

          try {

            const parsedValue = JSON.parse(value);

            if(
              parsedValue &&
              typeof parsedValue === 'object'
            ) {

              this.currentFile = parsedValue;

            }

          } catch(error) {

            /*
            |--------------------------------------------------------------------------
            | Compatibilidade com valores antigos
            |--------------------------------------------------------------------------
            |
            | Valores antigos continuam funcionando e não são considerados
            | temporários. Portanto, não serão excluídos fisicamente ao limpar.
            |
            */

            this.currentFile = {

              name: value.split('/').pop() || 'Arquivo',
              path: value,
              url: value,
              temporary: false

            };

          }

          this.renderButtons();

          this.renderPreview();

        }


        upload(file) {

          if(!this.uploadURL) {

            this.showMessage(
              'A URL de upload não foi definida.',
              'error'
            );

            return;

          }

          if(this.xhr) {

            this.xhr.abort();

          }

          const formData = new FormData();

          formData.append(
            'acao',
            'upload-temporario'
          );

          formData.append(
            'action',
            'upload'
          );

          formData.append(
            'arquivo',
            file
          );

          if(this.uploadTypeID !== '') {

            formData.append(
              'upload_type_id',
              this.uploadTypeID
            );

          }

          const xhr = new XMLHttpRequest();

          this.xhr = xhr;

          this.fileInput.disabled = true;

          this.showMessage(
            'Enviando arquivo...',
            'info'
          );

          xhr.open(
            'POST',
            this.uploadURL,
            true
          );

          xhr.setRequestHeader(
            'Accept',
            'application/json'
          );

          xhr.setRequestHeader(
            'X-Requested-With',
            'XMLHttpRequest'
          );

          const csrfToken = this.getCsrfToken();

          if(csrfToken) {

            xhr.setRequestHeader(
              'X-CSRF-TOKEN',
              csrfToken
            );

          }

          xhr.upload.addEventListener(
            'progress',
            event => {

              if(!event.lengthComputable) {

                return;

              }

              const percentage = Math.round(
                (
                  event.loaded /
                  event.total
                ) * 100
              );

              this.updateProgress(
                percentage
              );

            }
          );

          xhr.addEventListener(
            'load',
            () => {

              this.fileInput.disabled = false;

              let response = null;

              try {

                response = JSON.parse(
                  xhr.responseText
                );

              } catch(error) {

                this.showMessage(
                  'O servidor retornou uma resposta inválida.',
                  'error'
                );

                this.fileInput.value = '';

                this.resetProgress();

                return;

              }

              if(
                xhr.status < 200 ||
                xhr.status >= 300 ||
                response.status !== true
              ) {

                this.showMessage(
                  response.message ||
                  'Não foi possível enviar o arquivo.',
                  'error'
                );

                this.fileInput.value = '';

                this.resetProgress();

                return;

              }

              this.currentFile =
                response.file || null;

              if(!this.currentFile) {

                this.showMessage(
                  'Os dados do arquivo não foram retornados.',
                  'error'
                );

                this.fileInput.value = '';

                this.resetProgress();

                return;

              }

              this.updateHiddenValue();

              this.updateProgress(100);

              this.showMessage(
                response.message ||
                'Arquivo enviado com sucesso.',
                'success'
              );

              this.renderButtons();

              this.renderPreview();

              setTimeout(
                () => {

                  this.hideProgress();
                  this.showFileResult();

                },
                800
              );

            }
          );

          xhr.addEventListener(
            'error',
            () => {

              this.fileInput.disabled = false;
              this.fileInput.value = '';

              this.showMessage(
                'Não foi possível conectar ao servidor.',
                'error'
              );

              this.resetProgress();

            }
          );

          xhr.addEventListener(
            'abort',
            () => {

              this.fileInput.disabled = false;

              this.showMessage(
                'O envio do arquivo foi cancelado.',
                'error'
              );

              this.resetProgress();

            }
          );

          this.hideFileRow(
            () => {

              this.showProgress();
              this.updateProgress(0);

              xhr.send(
                formData
              );

            }
          );

        }


        hideFileRow(callback = null) {

          const finish = () => {

            if(typeof callback === 'function') {
              callback();
            }

          };

          if(this.preview && typeof window.jQuery !== 'undefined') {

            window.jQuery(this.preview)
              .stop(true, true)
              .fadeOut(150);

          } else {

            this.preview?.classList.add(
              'd-none'
            );

          }

          if(this.fileRow && typeof window.jQuery !== 'undefined') {

            window.jQuery(this.fileRow)
              .stop(true, true)
              .fadeOut(150, finish);

            return;

          }

          if(this.fileRow) {
            this.fileRow.classList.add('d-none');
          }

          finish();

        }


        showFileRow() {

          if(!this.fileRow) {
            return;
          }

          if(typeof window.jQuery !== 'undefined') {

            window.jQuery(this.fileRow)
              .stop(true, true)
              .fadeIn(150);

            return;

          }

          this.fileRow.classList.remove('d-none');

        }


        showFileResult() {

          if(this.preview) {

            if(typeof window.jQuery !== 'undefined') {

              window.jQuery(this.preview)
                .stop(true, true)
                .hide()
                .removeClass('d-none')
                .fadeIn(150);

            } else {

              this.preview.classList.remove('d-none');

            }

          }

          this.showFileRow();

        }


        updateHiddenValue() {

          if(!this.hiddenInput) {

            return;

          }

          this.hiddenInput.value = this.currentFile
            ? JSON.stringify(this.currentFile)
            : '';

          this.hiddenInput.dispatchEvent(
            new Event(
              'input',
              {
                bubbles: true
              }
            )
          );

          this.hiddenInput.dispatchEvent(
            new Event(
              'change',
              {
                bubbles: true
              }
            )
          );

        }


        renderButtons() {

          if(!this.actions) {

            return;

          }

          this.actions.innerHTML = '';

          if(!this.currentFile) {

            return;

          }

          const fileURL =
            this.currentFile.url ||
            this.currentFile.path ||
            '';

          const fileName =
            this.currentFile.original_name ||
            this.currentFile.name ||
            this.currentFile.stored_name ||
            'Arquivo';

          if(fileURL !== '') {

            const viewButton =
              document.createElement('a');

            viewButton.href = fileURL;
            viewButton.target = '_blank';
            viewButton.rel = 'noopener noreferrer';

            viewButton.className =
              'btn btn-success btn-sm';

            viewButton.textContent =
              'Visualizar';

            this.actions.appendChild(
              viewButton
            );

          }

          const clearButton =
            document.createElement('button');

          clearButton.type = 'button';

          clearButton.className =
            'btn btn-danger btn-sm ms-2';

          clearButton.textContent =
            'Limpar';

          clearButton.addEventListener(
            'click',
            async event => {

              event.preventDefault();
              event.stopPropagation();

              const confirmed = window.confirm(
                `Deseja remover o arquivo "${fileName}"?`
              );

              if(!confirmed) {

                return;

              }

              await this.remove();

            }
          );

          this.actions.appendChild(
            clearButton
          );

        }


        async remove() {

          /*
          |--------------------------------------------------------------------------
          | Arquivo já definitivo/antigo
          |--------------------------------------------------------------------------
          |
          | Apenas limpa o campo. Não exclui fisicamente nem remove registros.
          |
          */

          if(
            !this.currentFile?.temporary ||
            !this.currentFile?.temp_id
          ) {

            this.clearLocal();

            this.showMessage(
              'Arquivo removido do campo.',
              'success'
            );

            return true;

          }

          this.fileInput.disabled = true;

          this.showMessage(
            'Excluindo arquivo temporário...',
            'info'
          );

          try {

            const response = await fetch(
              this.uploadURL,
              {
                method: 'POST',

                credentials: 'same-origin',

                headers: {

                  'Accept': 'application/json',

                  'Content-Type': 'application/json',

                  'X-Requested-With': 'XMLHttpRequest',

                  'X-CSRF-TOKEN': this.getCsrfToken()

                },

                body: JSON.stringify({

                  acao: 'upload-temporario',

                  action: 'delete',

                  temp_id: this.currentFile.temp_id

                })

              }
            );

            const result = await response.json();

            if(
              !response.ok ||
              result.status !== true
            ) {

              throw new Error(
                result.message ||
                'Não foi possível excluir o arquivo temporário.'
              );

            }

            this.clearLocal();

            this.showMessage(
              result.message ||
              'Arquivo temporário excluído.',
              'success'
            );

            return true;

          } catch(error) {

            this.showMessage(
              error.message ||
              'Não foi possível excluir o arquivo temporário.',
              'error'
            );

            return false;

          } finally {

            this.fileInput.disabled = false;

          }

        }


        clearLocal() {

          this.currentFile = null;

          if(this.fileInput) {

            this.fileInput.value = '';

          }

          this.updateHiddenValue();

          this.renderButtons();

          this.renderPreview();

        }


        renderPreview() {

          if(!this.preview) {

            return;

          }

          this.preview.innerHTML = '';

          if(!this.currentFile) {

            this.preview.classList.add(
              'd-none'
            );

            return;

          }

          const fileURL =
            this.currentFile.url ||
            this.currentFile.path ||
            '';

          const mimeType = String(
            this.currentFile.mime_type ||
            ''
          ).toLowerCase();

          const extension = String(
            this.currentFile.extension ||
            this.currentFile.type_name ||
            ''
          ).toLowerCase();

          const preview = document.createElement('div');

          preview.className =
            'border rounded d-flex align-items-center justify-content-center overflow-hidden bg-light mx-auto';

          preview.style.width = '110px';
          preview.style.height = '110px';
          preview.style.backgroundRepeat = 'no-repeat';
          preview.style.backgroundSize = 'contain';
          preview.style.backgroundPosition = 'center';

          if(
            mimeType.indexOf('image/') === 0 ||
            ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg', 'bmp', 'avif'].includes(extension)
          ) {

            if(fileURL !== '') {

              preview.style.backgroundImage =
                'url("' + fileURL.replace(/"/g, '%22') + '")';

            }

          } else {

            const icon = document.createElement('i');

            icon.className =
              ['pdf'].includes(extension)
                ? 'fa fa-file-pdf-o fa-3x text-danger'
                : ['zip', 'rar', '7z'].includes(extension)
                  ? 'fa fa-file-archive-o fa-3x text-warning'
                  : ['doc', 'docx', 'odt'].includes(extension)
                    ? 'fa fa-file-word-o fa-3x text-primary'
                    : ['xls', 'xlsx', 'csv'].includes(extension)
                      ? 'fa fa-file-excel-o fa-3x text-success'
                      : 'fa fa-file-o fa-3x text-secondary';

            preview.appendChild(icon);

          }

          this.preview.appendChild(preview);

          this.preview.classList.remove(
            'd-none'
          );

          this.fileInput?.classList.add(
            'd-none'
          );

        }


        /*
        |--------------------------------------------------------------------------
        | Move o temporário para uploads definitivos
        |--------------------------------------------------------------------------
        */

        async finalize() {

          if(
            !this.currentFile?.temporary ||
            !this.currentFile?.temp_id
          ) {

            return true;

          }

          this.fileInput.disabled = true;

          this.showMessage(
            'Finalizando arquivo...',
            'info'
          );

          try {

            const response = await fetch(
              this.uploadURL,
              {
                method: 'POST',

                credentials: 'same-origin',

                headers: {

                  'Accept': 'application/json',

                  'Content-Type': 'application/json',

                  'X-Requested-With': 'XMLHttpRequest',

                  'X-CSRF-TOKEN': this.getCsrfToken()

                },

                body: JSON.stringify({

                  acao: 'upload-temporario',

                  action: 'finalize',

                  temp_id: this.currentFile.temp_id

                })

              }
            );

            const result = await response.json();

            if(
              !response.ok ||
              result.status !== true ||
              !result.file
            ) {

              throw new Error(
                result.message ||
                'Não foi possível finalizar o arquivo.'
              );

            }

            this.currentFile = result.file;

            this.updateHiddenValue();

            this.renderButtons();

            this.showMessage(
              result.message ||
              'Arquivo finalizado com sucesso.',
              'success'
            );

            return true;

          } catch(error) {

            this.showMessage(
              error.message ||
              'Não foi possível finalizar o arquivo.',
              'error'
            );

            return false;

          } finally {

            this.fileInput.disabled = false;

          }

        }


        showProgress() {

          this.progress?.classList.remove(
            'd-none'
          );

        }


        hideProgress() {

          this.progress?.classList.add(
            'd-none'
          );

          this.updateProgress(0);

        }


        updateProgress(percentage) {

          if(!this.progressBar) {

            return;

          }

          const safePercentage = Math.max(
            0,
            Math.min(
              100,
              Number(percentage) || 0
            )
          );

          this.progressBar.style.width =
            `${safePercentage}%`;

          this.progressBar.textContent =
            `${safePercentage}%`;

          this.progressBar.setAttribute(
            'aria-valuenow',
            String(safePercentage)
          );

        }


        resetProgress() {

          setTimeout(
            () => {

              this.hideProgress();
              this.showFileRow();

            },
            1200
          );

        }


        showMessage(
          text,
          type = 'info'
        ) {

          if(!this.message) {

            return;

          }

          this.message.classList.remove(
            'd-none',
            'text-success',
            'text-danger',
            'text-muted'
          );

          if(type === 'success') {

            this.message.classList.add(
              'text-success'
            );

          } else if(type === 'error') {

            this.message.classList.add(
              'text-danger'
            );

          } else {

            this.message.classList.add(
              'text-muted'
            );

          }

          this.message.textContent = text;

        }

      }


      window.AutomatorFileInputSendFile = function(
        button,
        inputID
      ) {

        if(!button || !inputID) {
          return false;
        }

        const fileInput = document.getElementById(inputID);


        if(!fileInput) {
          return false;
        }

        const container = button.closest(
          '[data-automator-file-upload]'
        );


        if(
          !container ||
          !container.automatorUploaderInstance
        ) {
          return false;
        }

        fileInput.click();

        return true;

      };


      function initializeAutomatorTemporaryFileUploads(
        root = document
      ) {

        root
          .querySelectorAll(
            '[data-automator-file-upload]'
          )
          .forEach(
            container => {

              if(
                container.dataset
                  .automatorFileUploadInitialized === 'true'
              ) {

                return;

              }

              container.dataset
                .automatorFileUploadInitialized = 'true';

              new AutomatorTemporaryFileUploader(
                container
              );

            }
          );

      }


      /*
      |--------------------------------------------------------------------------
      | Finalização antes do submit original
      |--------------------------------------------------------------------------
      |
      | Não altera a função responsável pelo submit. Apenas aguarda a promoção
      | dos temporários e, em seguida, dispara novamente o mesmo submit.
      |
      */

      document.addEventListener(
        'submit',
        async event => {

          const form = event.target;

          if(
            !(form instanceof HTMLFormElement) ||
            form.dataset.automatorFilesFinalized === 'true' ||
            form.dataset.automatorFilesFinalizing === 'true'
          ) {

            return;

          }

          const uploaders = Array
            .from(
              form.querySelectorAll(
                '[data-automator-file-upload]'
              )
            )
            .map(
              container =>
                container.automatorUploaderInstance
            )
            .filter(Boolean);

          const temporaryUploaders =
            uploaders.filter(
              uploader =>
                uploader.currentFile?.temporary === true &&
                uploader.currentFile?.temp_id
            );

          if(temporaryUploaders.length === 0) {

            return;

          }

          event.preventDefault();
          event.stopImmediatePropagation();

          form.dataset.automatorFilesFinalizing =
            'true';

          try {

            const results = await Promise.all(
              temporaryUploaders.map(
                uploader => uploader.finalize()
              )
            );

            const allFinalized = results.every(
              result => result === true
            );

            if(!allFinalized) {

              form.dataset.automatorFilesFinalizing =
                'false';

              return;

            }

            form.dataset.automatorFilesFinalized =
              'true';

            form.dataset.automatorFilesFinalizing =
              'false';

            /*
            |--------------------------------------------------------------------------
            | Continua o submit normal
            |--------------------------------------------------------------------------
            */

            form.requestSubmit();

          } catch(error) {

            form.dataset.automatorFilesFinalizing =
              'false';

            console.error(
              'Erro ao finalizar arquivos:',
              error
            );

          }

        },
        true
      );


      document.addEventListener(
        'DOMContentLoaded',
        () => {

          initializeAutomatorTemporaryFileUploads();

        }
      );


      window.initializeAutomatorTemporaryFileUploads =
        initializeAutomatorTemporaryFileUploads;

    </script>

  @endonce

@elseif($render == 'paginacao')

  @if($columnType == 'thead')



  @elseif($columnType == 'tbody')



  @endif

@endif
