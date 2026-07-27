<style>

  .automator-module-upload-dropzone {

    border: 2px dashed #0d6efd;
    border-radius: .75rem;
    cursor: pointer;
    padding: 2rem 1.25rem;
    text-align: center;
    transition: background-color .15s ease, border-color .15s ease;

  }


  .automator-module-upload-dropzone:hover,
  .automator-module-upload-dropzone.is-dragover {

    background: rgba(13, 110, 253, .06);
    border-color: #0a58ca;

  }

</style>


<form
  class="p-2"
  data-automator-module-upload
  data-upload-url="{!! SysAutomator::SysAutomatorGetRouteLinkByName('admin-api-modulos-upload', [], true) !!}"
>

  <input
    class="d-none"
    type="file"
    accept=".zip,application/zip,application/x-zip-compressed"
    data-module-upload-input
  >

  <input
    type="hidden"
    name="module_upload_selected"
    value=""
    data-module-upload-selected
  >

  <div
    class="automator-module-upload-dropzone"
    data-module-upload-dropzone
    role="button"
    tabindex="0"
    aria-label="Selecionar arquivo ZIP para instalação"
  >

    <i class="fa fa-cloud-upload fa-2x text-primary mb-3" aria-hidden="true"></i>

    <p class="mb-1 fw-semibold">Arraste o arquivo ZIP aqui</p>

    <p class="mb-0 text-muted small">ou clique para selecionar o módulo</p>

  </div>

  <div class="mt-3 d-none" data-module-upload-progress-wrap>

    <div class="d-flex justify-content-between small mb-1">

      <span class="text-truncate me-2" data-module-upload-name></span>
      <span data-module-upload-percent>0%</span>

    </div>

    <div
      class="progress"
      role="progressbar"
      aria-label="Progresso do envio"
      aria-valuemin="0"
      aria-valuemax="100"
      aria-valuenow="0"
    >

      <div
        class="progress-bar progress-bar-striped progress-bar-animated"
        data-module-upload-progress
        style="width: 0%"
      ></div>

    </div>

  </div>

  <div class="alert alert-danger mt-3 mb-0 d-none" role="alert" data-module-upload-error></div>

</form>
