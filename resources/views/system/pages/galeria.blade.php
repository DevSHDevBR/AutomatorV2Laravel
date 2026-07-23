<div
  id="automator-galeria-uploads-wrapper"
  data-automator-upload-store-route="{{ e($routes['store'] ?? '') }}"
  data-automator-upload-get-route="{{ e($routes['get'] ?? '') }}"
  data-automator-upload-load-route="{{ e($routes['load'] ?? '') }}"
  data-automator-upload-update-route="{{ e($routes['update'] ?? '') }}"
  data-automator-upload-delete-route="{{ e($routes['delete'] ?? '') }}"
  data-automator-upload-current-page="{{ e($page ?? 1) }}"
  data-automator-upload-has-more="{{ !empty($hasMore) ? 'true' : 'false' }}"
  data-automator-upload-per-page="{{ e($currentPerPage ?? 4) }}"
  data-automator-current-user-id="{{ e($currentUserID ?? '') }}"
  data-automator-default-directory="{{ e($defaultUploadsDirectory ?? 'uploads') }}"
>
  <div class="page-card mb-4">

    <div class="page-card-body">

      <div class="row g-3 align-items-end justify-content-between mb-4">

        <div class="col-12 col-sm-auto">

          <form
            method="GET"
            action="{{ request()->url() }}"
            class="row g-3 align-items-end automator-ajax-ignore"
          >

            <div class="col-12 col-sm-auto">

              <label for="search" class="small fw-medium mb-1">
                {!! SysAutomator::SysAutomatorGetTranslateWord('Buscar') !!}
              </label>

              <input
                type="text"
                name="search"
                id="search"
                value="{{ request('search') }}"
                class="form-control"
                placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord('Digite para buscar...') !!}"
              />

            </div>

            @if(count($search_fields) >= 2)

              <div class="col-12 col-sm-auto">

                <div class="dropdown">

                  <button
                    type="button"
                    class="btn btn-outline-secondary dropdown-toggle"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    aria-expanded="false"
                  >
                    {!! SysAutomator::SysAutomatorGetTranslateWord('Buscar por') !!}
                  </button>

                  <div class="dropdown-menu p-2 shadow" style="min-width: 220px;">

                    @foreach($search_fields as $field => $label)

                      <div class="form-check mb-2">

                        <label for="search_in_{{ $field }}" class="form-check-label small w-100">

                          <input
                            id="search_in_{{ $field }}"
                            name="search_in[]"
                            type="checkbox"
                            value="{{ $field }}"
                            {{ in_array($field, request('search_in', array_keys($search_fields))) ? 'checked' : '' }}
                            class="form-check-input"
                          />

                          {!! SysAutomator::SysAutomatorGetTranslateWord($label) !!}

                        </label>

                      </div>

                    @endforeach

                  </div>

                </div>

              </div>

            @endif

            <div class="col-12 col-sm-auto">

              <button
                type="submit"
                class="btn btn-light border d-inline-flex align-items-center justify-content-center gap-2 w-100"
              >
                <i class="fa fa-filter text-secondary"></i>
                {!! SysAutomator::SysAutomatorGetTranslateWord('Filtrar') !!}
              </button>

            </div>

            @if(request('search') || request('where') || request('sort') || request('direction'))

              <div class="col-12 col-sm-auto">

                <a
                  href="{{ request()->url() }}"
                  class="btn btn-outline-danger d-inline-flex align-items-center justify-content-center gap-2 w-100"
                >
                  <i class="fa-solid fa-times"></i>
                  {!! SysAutomator::SysAutomatorGetTranslateWord('Limpar') !!}
                </a>

              </div>

            @endif

          </form>

        </div>

        <div class="col-12 col-sm-auto">

          <form method="GET" class="row g-2 align-items-end automator-ajax-ignore">

            @foreach(request()->except(['per_page', 'page']) as $requestKey => $requestValue)

              @if(is_array($requestValue))

                @foreach($requestValue as $subValue)

                  <input type="hidden" name="{{ $requestKey }}[]" value="{{ $subValue }}" />

                @endforeach

              @else

                <input type="hidden" name="{{ $requestKey }}" value="{{ $requestValue }}" />

              @endif

            @endforeach

            <div class="col-12">

              <label for="per_page" class="form-label small fw-medium mb-1">
                {!! SysAutomator::SysAutomatorGetTranslateWord('Registros/Página') !!}
              </label>

              <select
                name="per_page"
                id="per_page"
                onchange="this.form.submit()"
                class="form-select"
              >

                @foreach($perPageOptions as $perPageOption)

                  <option
                    value="{{ $perPageOption }}"
                    {{ (int) $currentPerPage === (int) $perPageOption ? 'selected' : '' }}
                  >
                    {{ $perPageOption }}
                  </option>

                @endforeach

              </select>

            </div>

          </form>

        </div>

      </div>

      <div class="row g-3 align-items-end justify-content-between">

        <div class="col-12 col-sm-auto">

          <button
            type="button"
            class="btn btn-success d-inline-flex align-items-center justify-content-center gap-2 w-100"
            id="automator-galeria-uploads-send"
          >
            <span class="fa fa-plus"></span>
            {!! SysAutomator::SysAutomatorGetTranslateWord('Novo Upload') !!}
          </button>

        </div>

        <div class="col-12 col-sm-auto">

          <div class="d-flex flex-wrap gap-2">

            <button
              type="button"
              class="btn btn-outline-primary d-inline-flex align-items-center gap-2"
              id="automator-galeria-uploads-select-items"
              aria-pressed="false"
            >
              <span class="fa fa-check"></span>
              {!! SysAutomator::SysAutomatorGetTranslateWord('Selecionar Itens') !!}
            </button>

            <button
              type="button"
              id="automator-galeria-uploads-delete-selected"
              class="btn btn-danger js-automator-galeria-uploads-delete-selected"
              disabled
              data-delete-message-confirm="{{ e($deleteMessageConfirm) }}"
              onclick="return AutomatorGaleriaUploadsSubmitDelete(this)"
            >
              {!! SysAutomator::SysAutomatorGetTranslateWord('Excluir Selecionado(s)') !!}
            </button>

          </div>

        </div>

      </div>

    </div>

  </div>

  <div class="page-card mb-4">

    <div
      id="automator-galeria-uploads-area"
      class="page-card-body position-relative automator-galeria-uploads-dropzone"
      tabindex="0"
      role="button"
      aria-label="{!! SysAutomator::SysAutomatorGetTranslateWord('Arraste um arquivo para esta área') !!}"
    >

      <div
        id="automator-galeria-uploads-dropzone-overlay"
        class="automator-galeria-uploads-dropzone-overlay position-absolute top-0 start-0 w-100 h-100 d-none align-items-center justify-content-center text-center"
      >

        <div class="p-4">
          <i class="fa fa-cloud-arrow-up fa-3x mb-3"></i>
          <div class="fs-5 fw-semibold">
            {!! SysAutomator::SysAutomatorGetTranslateWord('Solte o arquivo para continuar') !!}
          </div>
        </div>

      </div>

      <form
        id="automator-galeria-uploads-delete-form"
        method="POST"
        action="{{ e($routes['delete'] ?? '') }}"
        class="automator-ajax-ignore"
        data-automator-ignore-ajax="true"
      >

        @csrf

        <div
          id="automator-galeria-uploads-area-itens"
          class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-3"
        >

          @foreach($itens as $item)

            @php

              $uploadType = $item['upload_type'] ?? null;

              $uploadMime = is_array($uploadType)
                ? ($uploadType['tbl_sys_uploads_type_mine'] ?? '')
                : '';

              $uploadIcon = is_array($uploadType)
                ? ($uploadType['tbl_sys_uploads_type_icon'] ?? 'file')
                : 'file';

              $uploadURL = $item['file_url'] ?? '';

              $isImage = str_starts_with(
                strtolower((string) $uploadMime),
                'image/'
              );

            @endphp

            <div
              class="col automator-galeria-upload-item"
              data-automator-upload-id="{{ e($item['tbl_sys_upload_ID'] ?? '') }}"
            >

              <input
                type="checkbox"
                name="uploads[]"
                value="{{ e($item['tbl_sys_upload_ID'] ?? '') }}"
                class="d-none automator-galeria-upload-checkbox"
              />

              <div class="automator-galeria-upload-square">

                <div class="card rounded-3 h-100 overflow-hidden automator-galeria-upload-card">

                  <div class="card-header text-truncate automator-galeria-upload-card-header">
                    {{ $item['tbl_sys_upload_title'] ?? '' }}
                  </div>

                  <div
                    class="card-body p-0 d-flex align-items-center justify-content-center bg-light automator-galeria-upload-preview {{ $isImage ? 'automator-galeria-upload-preview-image' : '' }}"
                    @if($isImage && $uploadURL !== '')
                      style="background-image: url('{{ e($uploadURL) }}');"
                    @endif
                  >

                    @if(!$isImage || $uploadURL === '')

                      <div class="text-center px-3">

                        <i class="fa fa-{{ e($uploadIcon) }} fa-4x text-secondary"></i>

                        <div class="small text-muted mt-3">
                          {{ strtoupper(pathinfo($item['tbl_sys_upload_file'] ?? '', PATHINFO_EXTENSION)) }}
                        </div>

                      </div>

                    @endif

                  </div>

                  <div class="card-footer text-center automator-galeria-upload-card-footer">

                    <button
                      type="button"
                      data-bs-toggle="tooltip"
                      data-bs-placement="top"
                      data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord('Visualizar arquivo') !!}"
                      class="btn btn-primary d-inline-flex mx-2 automator-galeria-upload-view"
                      data-automator-upload-view="{{ e($item['tbl_sys_upload_ID'] ?? '') }}"
                    >
                      <i class="fa fa-eye"></i>
                    </button>

                    <button
                      type="button"
                      data-bs-toggle="tooltip"
                      data-bs-placement="bottom"
                      data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord('Excluir arquivo') !!}"
                      class="btn btn-danger d-inline-flex mx-2"
                      data-automator-upload-delete="{{ e($item['tbl_sys_upload_ID'] ?? '') }}"
                    >
                      <i class="fa fa-trash"></i>
                    </button>

                  </div>

                </div>

              </div>

            </div>

          @endforeach

        </div>

      </form>

      <div
        id="automator-galeria-uploads-empty"
        class="row {{ count($itens) >= 1 ? 'd-none' : '' }}"
      >

        <div class="col-12 text-center py-5">
          <i class="fa fa-cloud-arrow-up fa-3x text-secondary mb-3"></i>
          <div class="fs-3">
            {!! SysAutomator::SysAutomatorGetTranslateWord('Nenhum arquivo encontrado') !!}
          </div>
          <div class="text-muted mt-2">
            {!! SysAutomator::SysAutomatorGetTranslateWord('Clique em Novo Upload ou arraste um arquivo para esta área.') !!}
          </div>
        </div>

      </div>

      @if(!empty($hasMore))

        <div class="row mt-3">

          <div class="col-12 text-center">
            <button
              type="button"
              class="btn btn-secondary btn-block mx-auto"
              id="automator-galeria-uploads-load-more"
            >
              {!! SysAutomator::SysAutomatorGetTranslateWord('Carregar Mais') !!}
            </button>
          </div>

        </div>

      @endif

    </div>

  </div>

  <input
    type="file"
    id="automator-galeria-uploads-file-selector"
    class="d-none"
    tabindex="-1"
  />

  <div
    class="modal fade"
    id="automator-galeria-upload-modal"
    tabindex="-1"
    aria-labelledby="automator-galeria-upload-modal-title"
    aria-hidden="true"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
  >

    <div class="modal-dialog modal-dialog-centered modal-lg">

      <div class="modal-content">

        <div class="modal-header">

          <h5 class="modal-title w-100 text-center" id="automator-galeria-upload-modal-title">
            {!! SysAutomator::SysAutomatorGetTranslateWord('Enviar arquivo') !!}
          </h5>

          <button
            type="button"
            class="btn-close automator-galeria-upload-close"
            aria-label="{!! SysAutomator::SysAutomatorGetTranslateWord('Fechar') !!}"
          ></button>

        </div>

        <form
          id="automator-galeria-upload-form"
          action="{{ e($routes['store'] ?? '') }}"
          method="POST"
          enctype="multipart/form-data"
          class="automator-ajax-ignore"
          data-automator-ignore-ajax="true"
          novalidate
        >

          @csrf

          <div class="modal-body">

            <input
              type="hidden"
              name="tbl_user_ID"
              id="automator-galeria-upload-user-id"
              value="{{ e($currentUserID ?? '') }}"
            />

            <input
              type="hidden"
              name="tbl_sys_uploads_type_ID"
              id="automator-galeria-upload-type-id"
              value=""
            />

            <div class="row g-3">

              <div class="col-12">

                <div class="border rounded p-3 bg-light">

                  <div class="d-flex align-items-center gap-3">

                    <div
                      class="d-flex align-items-center justify-content-center bg-white border rounded"
                      style="width: 54px; height: 54px;"
                    >
                      <i
                        id="automator-galeria-upload-file-icon"
                        class="fa fa-file fa-2x text-secondary"
                      ></i>
                    </div>

                    <div class="flex-grow-1 overflow-hidden">
                      <div id="automator-galeria-upload-file-name" class="fw-semibold text-truncate"></div>
                      <div id="automator-galeria-upload-file-info" class="small text-muted"></div>
                    </div>

                    <button
                      type="button"
                      class="btn btn-outline-secondary automator-galeria-upload-change-file"
                    >
                      {!! SysAutomator::SysAutomatorGetTranslateWord('Alterar') !!}
                    </button>

                  </div>

                </div>

              </div>

              <div class="col-12">

                <div class="form-floating">

                  <input
                    type="text"
                    name="tbl_sys_upload_title"
                    id="automator-galeria-upload-title"
                    class="form-control"
                    value=""
                    placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord('Título') !!}"
                    maxlength="255"
                    required
                  />

                  <label for="automator-galeria-upload-title">
                    {!! SysAutomator::SysAutomatorGetTranslateWord('Título') !!}
                    <span class="text-danger">*</span>
                  </label>

                </div>

              </div>

              <div class="col-12 col-md-8">

                <div class="form-floating">

                  <input
                    type="text"
                    name="tbl_sys_upload_directory"
                    id="automator-galeria-upload-directory"
                    class="form-control"
                    value="{{ e($defaultUploadsDirectory ?? 'uploads') }}"
                    placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord('Diretório') !!}"
                    maxlength="255"
                    required
                  />

                  <label for="automator-galeria-upload-directory">
                    {!! SysAutomator::SysAutomatorGetTranslateWord('Diretório') !!}
                    <span class="text-danger">*</span>
                  </label>

                </div>

              </div>

              <div class="col-12 col-md-4">

                <div class="form-floating">

                  <select
                    name="tbl_sys_upload_access"
                    id="automator-galeria-upload-access"
                    class="form-select"
                    required
                  >
                    <option value="public" selected>
                      {!! SysAutomator::SysAutomatorGetTranslateWord('Público') !!}
                    </option>
                    <option value="restrict">
                      {!! SysAutomator::SysAutomatorGetTranslateWord('Restrito') !!}
                    </option>
                  </select>

                  <label for="automator-galeria-upload-access">
                    {!! SysAutomator::SysAutomatorGetTranslateWord('Acesso') !!}
                    <span class="text-danger">*</span>
                  </label>

                </div>

              </div>

            </div>

          </div>

          <div class="modal-footer">

            <div class="row g-2 w-100">

              <div class="col-12 col-md-6 order-2 order-md-1">
                <button
                  type="button"
                  class="btn btn-secondary w-100 automator-galeria-upload-cancel"
                >
                  {!! SysAutomator::SysAutomatorGetTranslateWord('Cancelar') !!}
                </button>
              </div>

              <div class="col-12 col-md-6 order-1 order-md-2">
                <button
                  type="submit"
                  class="btn btn-primary w-100"
                  id="automator-galeria-upload-submit"
                >
                  <span class="automator-galeria-upload-submit-normal">
                    <i class="fa fa-upload me-2"></i>
                    {!! SysAutomator::SysAutomatorGetTranslateWord('Enviar') !!}
                  </span>
                  <span class="automator-galeria-upload-submit-running d-none">
                    <span class="spinner-border spinner-border-sm me-2" aria-hidden="true"></span>
                    {!! SysAutomator::SysAutomatorGetTranslateWord('Enviando...') !!}
                  </span>
                </button>
              </div>

            </div>

          </div>

        </form>

      </div>

    </div>

  </div>

  <div
    class="modal fade"
    id="automator-galeria-view-modal"
    tabindex="-1"
    aria-labelledby="automator-galeria-view-modal-title"
    aria-hidden="true"
    data-bs-backdrop="static"
    data-bs-keyboard="false"
  >

    <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">

      <div class="modal-content">

        <div class="modal-header">

          <h5 class="modal-title w-100 text-center" id="automator-galeria-view-modal-title">
            {!! SysAutomator::SysAutomatorGetTranslateWord('Visualizar arquivo') !!}
          </h5>

          <button
            type="button"
            class="btn-close"
            data-bs-dismiss="modal"
            aria-label="{!! SysAutomator::SysAutomatorGetTranslateWord('Fechar') !!}"
          ></button>

        </div>

        <div class="modal-body">

          <form
            id="automator-galeria-view-form"
            action="{{ e($routes['update'] ?? '') }}"
            method="POST"
            class="row g-3 automator-ajax-ignore"
            data-automator-ignore-ajax="true"
            data-submit="false"
            onsubmit="return AutomatorGaleriaUploadsSubmitViewUpdate(this);"
            novalidate
          >

            @csrf

            <div class="col-12">

              <div
                id="automator-galeria-view-preview"
                class="text-center border rounded bg-light p-3"
              ></div>

            </div>

            <div class="col-12 col-md-4">

              <div class="form-floating">

                <input
                  type="text"
                  name="tbl_sys_upload_ID"
                  id="automator-galeria-view-id"
                  class="form-control"
                  value=""
                  placeholder="ID"
                  readonly
                  disabled
                />

                <label for="automator-galeria-view-id">

                  ID

                </label>

              </div>

            </div>

            <div class="col-12 col-md-8">

              <div class="form-floating">

                <input
                  type="text"
                  name="tbl_sys_upload_title"
                  id="automator-galeria-view-title"
                  class="form-control"
                  value=""
                  placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord('Título') !!}"
                  maxlength="255"
                  required
                />

                <label for="automator-galeria-view-title">

                  {!! SysAutomator::SysAutomatorGetTranslateWord('Título') !!}

                  <span class="text-danger">*</span>

                </label>

              </div>

            </div>

            <div class="col-12 col-md-6">

              <div class="form-floating">

                <input
                  type="text"
                  name="tbl_sys_upload_directory"
                  id="automator-galeria-view-directory"
                  class="form-control"
                  value=""
                  placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord('Diretório') !!}"
                  readonly
                  disabled
                />

                <label for="automator-galeria-view-directory">

                  {!! SysAutomator::SysAutomatorGetTranslateWord('Diretório') !!}

                </label>

              </div>

            </div>

            <div class="col-12 col-md-6">

              <div class="form-floating">

                <select
                  name="tbl_sys_upload_access"
                  id="automator-galeria-view-access"
                  class="form-select"
                  disabled
                >

                  <option value="public">

                    {!! SysAutomator::SysAutomatorGetTranslateWord('Público') !!}

                  </option>

                  <option value="restrict">

                    {!! SysAutomator::SysAutomatorGetTranslateWord('Restrito') !!}

                  </option>

                </select>

                <label for="automator-galeria-view-access">

                  {!! SysAutomator::SysAutomatorGetTranslateWord('Acesso') !!}

                </label>

              </div>

            </div>

            <button
              type="submit"
              class="d-none"
              id="automator-galeria-view-form-submit"
              tabindex="-1"
              aria-hidden="true"
            ></button>

          </form>

        </div>

        <div class="modal-footer">

          <div class="row g-2 w-100">

            <div class="col-12 order-2 col-md-6 order-md-1">

              <button
                type="button"
                class="btn btn-secondary w-100"
                data-bs-dismiss="modal"
              >

                {!! SysAutomator::SysAutomatorGetTranslateWord('Fechar') !!}

              </button>

            </div>

            <div class="col-12 order-1 col-md-6 order-md-2">

              <button
                type="button"
                class="btn btn-primary w-100"
                id="automator-galeria-view-save"
                onclick="return AutomatorGaleriaUploadsSubmitViewForm(this);"
              >

                {!! SysAutomator::SysAutomatorGetTranslateWord('Salvar') !!}

              </button>

            </div>

          </div>

        </div>

      </div>

    </div>

  </div>

</div>

<style>

  #automator-galeria-uploads-area {

    min-height: 280px;

    transition:
      border-color 0.2s ease,
      background-color 0.2s ease,
      box-shadow 0.2s ease;

  }


  #automator-galeria-uploads-area.automator-galeria-uploads-drag-active {

    border: 2px dashed var(--bs-primary);

    background-color: rgba(
      var(--bs-primary-rgb),
      0.05
    );

    box-shadow: inset 0 0 0 1px rgba(
      var(--bs-primary-rgb),
      0.15
    );

  }


  .automator-galeria-uploads-dropzone-overlay {

    z-index: 10;

    color: var(--bs-primary);

    background-color: rgba(
      255,
      255,
      255,
      0.94
    );

    border: 2px dashed var(--bs-primary);

    pointer-events: none;

  }


  #automator-galeria-uploads-area.automator-galeria-uploads-drag-active
  .automator-galeria-uploads-dropzone-overlay {

    display: flex !important;

  }


  .automator-galeria-upload-square {

    width: 100%;

    aspect-ratio: 1 / 1;

  }


  .automator-galeria-upload-card {

    min-width: 0;

    transition:
      border-color 0.2s ease,
      box-shadow 0.2s ease,
      transform 0.2s ease;

  }


  .automator-galeria-upload-preview {

    min-height: 0;

    flex: 1 1 auto;

    overflow: hidden;

  }


  .automator-galeria-upload-preview-image {

    background-repeat: no-repeat;

    background-position: center center;

    /*background-size: cover;*/
    background-size: auto;

  }


  .automator-galeria-selection-active
  .automator-galeria-upload-item {

    cursor: pointer;

  }


  .automator-galeria-upload-item-selected
  .automator-galeria-upload-card {

    border-color: var(--bs-primary) !important;

    border-width: 2px !important;

    box-shadow: 0 0 0 0.2rem rgba(
      var(--bs-primary-rgb),
      0.2
    );

  }


  .automator-galeria-upload-item-selected
  .automator-galeria-upload-card-header,
  .automator-galeria-upload-item-selected
  .automator-galeria-upload-card-footer {

    color: #FFFFFF !important;

    background-color: rgba(
      var(--bs-primary-rgb),
      0.5
    ) !important;

  }


  .automator-galeria-upload-preview-content video,
  .automator-galeria-upload-preview-content audio {

    width: 100%;

    max-width: 100%;

  }


  .automator-galeria-upload-preview-link {

    overflow-wrap: anywhere;

    word-break: break-word;

  }


  #page-loader {

    z-index: 3000 !important;

  }


  .automator-toast-backdrop {

    z-index: 3990 !important;

  }


  .automator-toast-container {

    z-index: 4000 !important;

  }


  .automator-toast-alert {

    position: relative;

    z-index: 4010 !important;

  }

  .automator-galeria-upload-item {

    cursor: default;

  }


  .automator-galeria-upload-card-header {

    text-align: center;

  }


  .automator-galeria-selection-active
  .automator-galeria-upload-item {

    cursor: pointer;

  }


</style>

<script>

  window.AutomatorGaleriaUploadTypes = @json(

    $uploadTypes

    ?? []

  );


  window.AutomatorGaleriaUploadState =

    window.AutomatorGaleriaUploadState

    || {

      file: null,

      type: null,

      uploading: false,

      modal: null,

      viewModal: null,

      initialized: false,

      dragCounter: 0,

      xhr: null,

      selectionMode: false,

      hidingForUpload: false,

      restoringAfterError: false,

      progressToastName: null,

      viewOriginalTitle: '',

    };


  function AutomatorGaleriaUploadsDelay(
    time = 1000,
    callback = null
  ) {


    time = Math.max(

      0,

      Number(time)

      || 0

    );


    return setTimeout(

      function() {


        if(typeof callback === 'function') {

          callback();

        }


      },

      time

    );


  }


  function AutomatorGaleriaUploadsEscapeHTML(
    value = ''
  ) {


    return String(

      value

      ?? ''

    )
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');


  }


  function AutomatorGaleriaUploadsGetFileExtension(
    fileName = ''
  ) {


    fileName = String(

      fileName

      || ''

    );


    var lastDot = fileName.lastIndexOf('.');


    if(

      lastDot < 0 ||

      lastDot >= fileName.length - 1

    ) {

      return '';

    }


    return fileName
      .substring(lastDot + 1)
      .trim()
      .toLowerCase();


  }


  function AutomatorGaleriaUploadsGetFileTitle(
    fileName = ''
  ) {


    fileName = String(

      fileName

      || ''

    );


    var lastDot = fileName.lastIndexOf('.');


    if(lastDot > 0) {

      fileName = fileName.substring(0, lastDot);

    }


    return fileName
      .replace(/[_-]+/g, ' ')
      .replace(/\s+/g, ' ')
      .trim();


  }


  function AutomatorGaleriaUploadsFormatFileSize(
    size = 0
  ) {


    size = Number(size || 0);


    if(size <= 0) {

      return '0 B';

    }


    var units = [

      'B',
      'KB',
      'MB',
      'GB',
      'TB',

    ];


    var unitIndex = Math.floor(

      Math.log(size) /

      Math.log(1024)

    );


    unitIndex = Math.min(

      unitIndex,

      units.length - 1

    );


    var result = size / Math.pow(1024, unitIndex);


    return (

      result.toFixed(unitIndex == 0 ? 0 : 2) +

      ' ' +

      units[unitIndex]

    );


  }


  function AutomatorGaleriaUploadsResolveType(
    file = null
  ) {


    if(!file) {

      return null;

    }


    var types = Array.isArray(

      window.AutomatorGaleriaUploadTypes

    )

      ? window.AutomatorGaleriaUploadTypes

      : [];


    var fileMime = String(file.type || '')
      .trim()
      .toLowerCase();


    var fileExtension = AutomatorGaleriaUploadsGetFileExtension(

      file.name

    );


    var type = null;


    if(fileMime != '') {


      type = types.find(

        function(currentType) {


          return String(currentType.mime || '')
            .trim()
            .toLowerCase() == fileMime;


        }

      );


    }


    if(!type && fileExtension != '') {


      type = types.find(

        function(currentType) {


          return String(currentType.extension || '')
            .trim()
            .toLowerCase() == fileExtension;


        }

      );


    }


    return type || null;


  }


  function AutomatorGaleriaUploadsResolveTypeByData(
    item = {}
  ) {


    if(

      !item ||

      typeof item !== 'object'

    ) {

      return {};

    }


    var rawType = null;


    if(

      item.type &&

      typeof item.type === 'object'

    ) {

      rawType = item.type;

    } else if(

      item.upload_type &&

      typeof item.upload_type === 'object'

    ) {

      rawType = item.upload_type;

    }


    if(rawType) {


      return {

        id:

          rawType.id

          || rawType.tbl_sys_uploads_type_ID

          || item.tbl_sys_uploads_type_ID

          || '',

        mime:

          String(

            rawType.mime

            || rawType.tbl_sys_uploads_type_mine

            || ''

          )
            .trim()
            .toLowerCase(),

        extension:

          String(

            rawType.extension

            || rawType.tbl_sys_uploads_type_name

            || ''

          )
            .trim()
            .toLowerCase(),

        title:

          rawType.title

          || rawType.tbl_sys_uploads_type_title

          || '',

        description:

          rawType.description

          || rawType.tbl_sys_uploads_type_description

          || '',

        icon:

          rawType.icon

          || rawType.tbl_sys_uploads_type_icon

          || 'file',

      };


    }


    /*
    |--------------------------------------------------------------------------
    | Compatibilidade com respostas antigas
    |--------------------------------------------------------------------------
    */

    var types = Array.isArray(

      window.AutomatorGaleriaUploadTypes

    )

      ? window.AutomatorGaleriaUploadTypes

      : [];


    var typeID = String(

      item.tbl_sys_uploads_type_ID

      || ''

    ).trim();


    var extension =

      AutomatorGaleriaUploadsGetFileExtension(

        item.tbl_sys_upload_file

        || ''

      );


    var matchedType = types.find(

      function(currentType) {


        var currentID = String(

          currentType.id

          || currentType.tbl_sys_uploads_type_ID

          || ''

        );


        var currentExtension = String(

          currentType.extension

          || currentType.tbl_sys_uploads_type_name

          || ''

        )
          .trim()
          .toLowerCase();


        return (

          (
            typeID != '' &&

            currentID == typeID
          ) ||

          (
            extension != '' &&

            currentExtension == extension
          )

        );


      }

    );


    if(!matchedType) {


      return {

        id: typeID,

        mime: '',

        extension: extension,

        title: '',

        description: '',

        icon: 'file',

      };


    }


    return {

      id:

        matchedType.id

        || matchedType.tbl_sys_uploads_type_ID

        || typeID,

      mime:

        String(

          matchedType.mime

          || matchedType.tbl_sys_uploads_type_mine

          || ''

        )
          .trim()
          .toLowerCase(),

      extension:

        String(

          matchedType.extension

          || matchedType.tbl_sys_uploads_type_name

          || extension

        )
          .trim()
          .toLowerCase(),

      title:

        matchedType.title

        || matchedType.tbl_sys_uploads_type_title

        || '',

      description:

        matchedType.description

        || matchedType.tbl_sys_uploads_type_description

        || '',

      icon:

        matchedType.icon

        || matchedType.tbl_sys_uploads_type_icon

        || 'file',

    };


  }


  function AutomatorGaleriaUploadsBuildFileURL(
    item = {}
  ) {


    var directURL = String(

      item.file_url

      || item.url

      || ''

    ).trim();


    if(directURL != '') {

      return directURL;

    }


    var directory = String(

      item.tbl_sys_upload_directory

      || item.directory

      || ''

    )
      .replace(/\\/g, '/')
      .replace(/^\/+|\/+$/g, '');


    var fileName = String(

      item.tbl_sys_upload_file

      || item.file

      || ''

    )
      .replace(/^\/+|\/+$/g, '');


    if(fileName == '') {

      return '';

    }


    var path = directory != ''

      ? directory + '/' + fileName

      : fileName;


    return window.location.origin + '/' + path;


  }


  function AutomatorGaleriaUploadsBuildRoute(
    route = '',
    uploadID = ''
  ) {


    route = String(route || '').trim();

    uploadID = String(uploadID || '').trim();


    if(route == '') {

      return '';

    }


    if(uploadID == '') {

      return route;

    }


    if(route.indexOf('#ID#') >= 0) {

      return route.replace('#ID#', encodeURIComponent(uploadID));

    }


    route = route.replace(/\/+$/, '');


    return route + '/' + encodeURIComponent(uploadID);


  }


  function AutomatorGaleriaUploadsGetInitialItems() {


    var items = @json(

      $itens

      ?? []

    );


    return Array.isArray(items)

      ? items

      : [];


  }

  function AutomatorGaleriaUploadsFindLocalItem(
    uploadID = ''
  ) {


    uploadID = String(

      uploadID

      || ''

    ).trim();


    if(uploadID == '') {

      return null;

    }


    var items =

      AutomatorGaleriaUploadsGetInitialItems();


    var item = items.find(

      function(currentItem) {


        if(

          !currentItem ||

          typeof currentItem !== 'object'

        ) {

          return false;

        }


        return String(

          currentItem.tbl_sys_upload_ID

          || currentItem.id

          || ''

        ) == uploadID;


      }

    );


    if(!item) {


      var card = document.querySelector(

        '.automator-galeria-upload-item' +

        '[data-automator-upload-id="' +

        CSS.escape(

          uploadID

        ) +

        '"]'

      );


      if(!card) {

        return null;

      }


      var header = card.querySelector(

        '.automator-galeria-upload-card-header'

      );


      var preview = card.querySelector(

        '.automator-galeria-upload-preview'

      );


      var backgroundImage = preview

        ? String(

            window.getComputedStyle(

              preview

            ).backgroundImage

            || ''

          )

        : '';


      var fileURL = '';


      if(

        backgroundImage != '' &&

        backgroundImage != 'none'

      ) {


        fileURL = backgroundImage
          .replace(
            /^url\(["']?/,
            ''
          )
          .replace(
            /["']?\)$/,
            ''
          );


      }


      return {

        tbl_sys_upload_ID:

          uploadID,

        tbl_sys_upload_title:

          header

            ? header.textContent.trim()

            : '',

        tbl_sys_upload_directory:

          '',

        tbl_sys_upload_access:

          'public',

        file_url:

          fileURL,

      };


    }


    /*
    |--------------------------------------------------------------------------
    | Clona para não alterar o array original
    |--------------------------------------------------------------------------
    */

    return Object.assign(

      {},

      item

    );


  }


  function AutomatorGaleriaUploadsExtractResponseItem(
    value = null,
    uploadID = '',
    depth = 0
  ) {


    if(

      value === null ||

      value === undefined ||

      depth > 8

    ) {

      return null;

    }


    uploadID = String(

      uploadID

      || ''

    );


    /*
    |--------------------------------------------------------------------------
    | Array
    |--------------------------------------------------------------------------
    */

    if(Array.isArray(value)) {


      for(

        var arrayIndex = 0;

        arrayIndex < value.length;

        arrayIndex++

      ) {


        var arrayItem =

          AutomatorGaleriaUploadsExtractResponseItem(

            value[arrayIndex],

            uploadID,

            depth + 1

          );


        if(arrayItem) {

          return arrayItem;

        }


      }


      return null;


    }


    if(typeof value !== 'object') {

      return null;

    }


    /*
    |--------------------------------------------------------------------------
    | Verifica se o objeto atual é um upload
    |--------------------------------------------------------------------------
    */

    var currentID = String(

      value.tbl_sys_upload_ID

      || value.upload_ID

      || value.upload_id

      || ''

    );


    var hasUploadFields = (

      value.tbl_sys_upload_file !== undefined ||

      value.tbl_sys_upload_title !== undefined ||

      value.tbl_sys_upload_directory !== undefined ||

      value.tbl_sys_uploads_type_ID !== undefined

    );


    if(

      hasUploadFields === true &&

      (
        uploadID == '' ||

        currentID == uploadID
      )

    ) {

      return value;

    }


    /*
    |--------------------------------------------------------------------------
    | Prioriza chaves normalmente usadas pelas respostas do sistema
    |--------------------------------------------------------------------------
    */

    var preferredKeys = [

      'data',

      'result',

      'results',

      'item',

      'items',

      'record',

      'records',

      'content',

      'response',

    ];


    for(

      var preferredIndex = 0;

      preferredIndex < preferredKeys.length;

      preferredIndex++

    ) {


      var preferredKey =

        preferredKeys[preferredIndex];


      if(

        value[preferredKey] === undefined

      ) {

        continue;

      }


      var preferredItem =

        AutomatorGaleriaUploadsExtractResponseItem(

          value[preferredKey],

          uploadID,

          depth + 1

        );


      if(preferredItem) {

        return preferredItem;

      }


    }


    /*
    |--------------------------------------------------------------------------
    | Percorre as demais propriedades
    |--------------------------------------------------------------------------
    */

    var keys = Object.keys(

      value

    );


    for(

      var keyIndex = 0;

      keyIndex < keys.length;

      keyIndex++

    ) {


      var key = keys[keyIndex];


      if(

        preferredKeys.indexOf(

          key

        ) >= 0

      ) {

        continue;

      }


      var currentValue = value[key];


      if(

        !currentValue ||

        typeof currentValue !== 'object'

      ) {

        continue;

      }


      var nestedItem =

        AutomatorGaleriaUploadsExtractResponseItem(

          currentValue,

          uploadID,

          depth + 1

        );


      if(nestedItem) {

        return nestedItem;

      }


    }


    return null;


  }


  function AutomatorGaleriaUploadsNormalizeResponseItem(
    response = null,
    uploadID = ''
  ) {


    uploadID = String(

      uploadID

      || ''

    ).trim();


    var item = null;


    /*
    |--------------------------------------------------------------------------
    | Resposta padronizada do novo endpoint
    |--------------------------------------------------------------------------
    */

    if(

      response &&

      typeof response === 'object' &&

      response.data &&

      typeof response.data === 'object' &&

      !Array.isArray(response.data)

    ) {

      item = response.data;

    } else if(

      response &&

      typeof response === 'object' &&

      (
        response.tbl_sys_upload_ID !== undefined ||

        response.tbl_sys_upload_file !== undefined
      )

    ) {

      item = response;

    } else {


      item =

        AutomatorGaleriaUploadsExtractResponseItem(

          response,

          uploadID

        );


    }


    if(

      !item ||

      typeof item !== 'object'

    ) {

      return null;

    }


    item = Object.assign(

      {},

      item

    );


    item.tbl_sys_upload_ID =

      item.tbl_sys_upload_ID

      || item.id

      || uploadID

      || '';


    item.tbl_sys_uploads_type_ID =

      item.tbl_sys_uploads_type_ID

      || (

        item.type &&

        (
          item.type.id

          || item.type.tbl_sys_uploads_type_ID
        )

      )

      || (

        item.upload_type &&

        (
          item.upload_type.id

          || item.upload_type.tbl_sys_uploads_type_ID
        )

      )

      || '';


    item.tbl_sys_upload_file =

      item.tbl_sys_upload_file

      || item.file

      || item.filename

      || '';


    item.tbl_sys_upload_title =

      item.tbl_sys_upload_title

      || item.title

      || '';


    item.tbl_sys_upload_directory =

      item.tbl_sys_upload_directory

      || item.directory

      || '';


    item.tbl_sys_upload_access =

      item.tbl_sys_upload_access

      || item.access

      || 'public';


    item.type =

      AutomatorGaleriaUploadsResolveTypeByData(

        item

      );


    item.upload_type =

      item.type;


    item.file_url =

      AutomatorGaleriaUploadsBuildFileURL(

        item

      );


    return item;


  }


  function AutomatorGaleriaUploadsShowMessage(
    title = '',
    message = '',
    time = 3000,
    callback = null
  ) {


    if(

      typeof window.AutomatorCreateAutoCloseToastAlert ===

      'function'

    ) {


      return AutomatorCreateAutoCloseToastAlert(

        'automator-galeria-upload-message-' + Date.now(),

        'center',

        'middle',

        true,

        true,

        title,

        message,

        null,

        false,

        callback,

        time

      );


    }


    alert(title + '\n\n' + message);


    if(typeof callback === 'function') {

      callback();

    }


    return true;


  }


  function AutomatorGaleriaUploadsSetUnsavedWarning(
    enabled = true
  ) {


    $(window).off(

      'beforeunload.AutomatorGaleriaUploadsUnsaved'

    );


    if(enabled !== true) {

      return true;

    }


    $(window).on(

      'beforeunload.AutomatorGaleriaUploadsUnsaved',

      function(event) {


        var state = window.AutomatorGaleriaUploadState;


        if(!state.file && state.uploading !== true) {

          return;

        }


        var message =

          'Existe um arquivo ainda não enviado. Ao sair desta página, os dados poderão ser perdidos.';


        event.preventDefault();

        event.returnValue = message;


        return message;


      }

    );


    return true;


  }


  function AutomatorGaleriaUploadsSetPageScrollLocked(
    locked = true
  ) {


    var state =

      window.AutomatorGaleriaUploadState;


    state.pageScrollLockCount = Number(

      state.pageScrollLockCount

      || 0

    );


    if(locked === true) {


      state.pageScrollLockCount++;


      if(state.pageScrollLockCount > 1) {

        return true;

      }


      state.pageScrollPrevious = {

        htmlOverflow:

          document.documentElement.style.overflow

          || '',

        bodyOverflow:

          document.body.style.overflow

          || '',

        bodyPaddingRight:

          document.body.style.paddingRight

          || '',

      };


      var scrollbarWidth = Math.max(

        0,

        window.innerWidth -

        document.documentElement.clientWidth

      );


      document.documentElement.style.setProperty(

        'overflow',

        'hidden',

        'important'

      );


      document.body.style.setProperty(

        'overflow',

        'hidden',

        'important'

      );


      if(scrollbarWidth > 0) {


        var currentPaddingRight = parseFloat(

          window.getComputedStyle(

            document.body

          ).paddingRight

        ) || 0;


        document.body.style.setProperty(

          'padding-right',

          (

            currentPaddingRight +

            scrollbarWidth

          ) +

          'px',

          'important'

        );


      }


      return true;


    }


    state.pageScrollLockCount = Math.max(

      0,

      state.pageScrollLockCount - 1

    );


    if(state.pageScrollLockCount > 0) {

      return true;

    }


    var previous =

      state.pageScrollPrevious

      || {};


    document.documentElement.style.removeProperty(

      'overflow'

    );


    document.body.style.removeProperty(

      'overflow'

    );


    document.body.style.removeProperty(

      'padding-right'

    );


    if(previous.htmlOverflow) {


      document.documentElement.style.overflow =

        previous.htmlOverflow;


    }


    if(previous.bodyOverflow) {


      document.body.style.overflow =

        previous.bodyOverflow;


    }


    if(previous.bodyPaddingRight) {


      document.body.style.paddingRight =

        previous.bodyPaddingRight;


    }


    state.pageScrollPrevious = null;


    return true;


  }


  function AutomatorGaleriaUploadsSetUploadingState(
    uploading = false
  ) {


    var state =

      window.AutomatorGaleriaUploadState;


    state.uploading =

      uploading === true;


    var form = document.getElementById(

      'automator-galeria-upload-form'

    );


    var submitButton = document.getElementById(

      'automator-galeria-upload-submit'

    );


    /*
    |--------------------------------------------------------------------------
    | Mantém o texto original do botão
    |--------------------------------------------------------------------------
    */

    if(submitButton) {


      var normalLabel = submitButton.querySelector(

        '.automator-galeria-upload-submit-normal'

      );


      var runningLabel = submitButton.querySelector(

        '.automator-galeria-upload-submit-running'

      );


      if(normalLabel) {


        normalLabel.classList.remove(

          'd-none'

        );


      }


      if(runningLabel) {


        runningLabel.classList.add(

          'd-none'

        );


      }


    }


    /*
    |--------------------------------------------------------------------------
    | Bloqueia os campos durante o envio
    |--------------------------------------------------------------------------
    */

    if(form) {


      form.querySelectorAll(

        'input, select, textarea, button'

      ).forEach(

        function(field) {


          field.disabled =

            uploading === true;


        }

      );


    }


    return true;


  }


  function AutomatorGaleriaUploadsPrepareModal(
    file = null
  ) {


    if(!file) {

      return false;

    }


    var state = window.AutomatorGaleriaUploadState;

    var uploadType = AutomatorGaleriaUploadsResolveType(file);


    if(!uploadType) {


      AutomatorGaleriaUploadsShowMessage(

        'Tipo de arquivo não permitido',

        'O tipo ou a extensão deste arquivo não está cadastrado na galeria.'

      );


      return false;

    }


    state.file = file;

    state.type = uploadType;


    var typeInput = document.getElementById(

      'automator-galeria-upload-type-id'

    );


    var titleInput = document.getElementById(

      'automator-galeria-upload-title'

    );


    var directoryInput = document.getElementById(

      'automator-galeria-upload-directory'

    );


    var accessInput = document.getElementById(

      'automator-galeria-upload-access'

    );


    var fileName = document.getElementById(

      'automator-galeria-upload-file-name'

    );


    var fileInfo = document.getElementById(

      'automator-galeria-upload-file-info'

    );


    var fileIcon = document.getElementById(

      'automator-galeria-upload-file-icon'

    );


    var wrapper = document.getElementById(

      'automator-galeria-uploads-wrapper'

    );


    if(typeInput) {

      typeInput.value = uploadType.id || '';

    }


    if(titleInput) {

      titleInput.value = AutomatorGaleriaUploadsGetFileTitle(file.name);

      titleInput.setCustomValidity('');

    }


    if(directoryInput) {


      directoryInput.value = wrapper

        ? (
            wrapper.getAttribute(
              'data-automator-default-directory'
            )
            || 'uploads'
          )

        : 'uploads';


      directoryInput.setCustomValidity('');


    }


    if(accessInput) {

      accessInput.value = 'public';

      accessInput.setCustomValidity('');

    }


    if(fileName) {

      fileName.textContent = file.name || 'Arquivo';

    }


    if(fileInfo) {


      fileInfo.textContent =

        (
          uploadType.title
          || uploadType.extension
          || file.type
          || 'Arquivo'
        )
        + ' · '
        + AutomatorGaleriaUploadsFormatFileSize(file.size);


    }


    if(fileIcon) {


      fileIcon.className =

        'fa fa-' +

        (uploadType.icon || 'file') +

        ' fa-2x text-secondary';


    }


    return true;


  }


  function AutomatorGaleriaUploadsOpenModal(
    file = null
  ) {


    if(

      !file ||

      AutomatorGaleriaUploadsPrepareModal(file) !== true

    ) {

      return false;

    }


    var modalElement = document.getElementById(

      'automator-galeria-upload-modal'

    );


    if(

      !modalElement ||

      typeof bootstrap === 'undefined' ||

      typeof bootstrap.Modal === 'undefined'

    ) {


      AutomatorGaleriaUploadsShowMessage(

        'Erro',

        'Não foi possível abrir o formulário de upload.'

      );


      return false;

    }


    var state = window.AutomatorGaleriaUploadState;


    state.hidingForUpload = false;

    state.restoringAfterError = false;


    state.modal = bootstrap.Modal.getOrCreateInstance(

      modalElement,

      {
        backdrop: 'static',
        keyboard: false,
      }

    );


    AutomatorGaleriaUploadsSetUnsavedWarning(true);


    if(typeof window.AutomatorPageLoader === 'function') {


      AutomatorPageLoader(

        'show',

        function() {


          AutomatorGaleriaUploadsDelay(

            1000,

            function() {

              state.modal.show();

            }

          );


        },

        150

      );


    } else {

      state.modal.show();

    }


    return true;


  }


  function AutomatorGaleriaUploadsCloseModal(
    force = false
  ) {


    var state = window.AutomatorGaleriaUploadState;


    if(state.uploading === true) {


      AutomatorGaleriaUploadsShowMessage(

        'Upload em andamento',

        'Aguarde o término do envio antes de fechar esta janela.'

      );


      return false;

    }


    if(force !== true && state.file) {


      var confirmClose = window.confirm(

        'O arquivo selecionado ainda não foi enviado. Deseja realmente fechar?'

      );


      if(confirmClose !== true) {

        return false;

      }


    }


    if(state.modal) {

      state.modal.hide();

    }


    return true;


  }


  function AutomatorGaleriaUploadsValidateForm(
    form = null
  ) {


    var state = window.AutomatorGaleriaUploadState;


    if(!form) {

      return false;

    }


    var typeInput = document.getElementById(

      'automator-galeria-upload-type-id'

    );


    if(

      !state.file ||

      !state.type ||

      !typeInput ||

      String(typeInput.value || '').trim() == ''

    ) {


      AutomatorGaleriaUploadsShowMessage(

        'Arquivo inválido',

        'Selecione um arquivo permitido para realizar o upload.'

      );


      return false;

    }


    if(

      typeof form.checkValidity === 'function' &&

      form.checkValidity() !== true

    ) {


      form.classList.add('was-validated');


      var invalidField = form.querySelector(':invalid');


      if(invalidField) {

        invalidField.focus();

      }


      return false;

    }


    form.classList.remove('was-validated');


    return true;


  }


  function AutomatorGaleriaUploadsBuildFormData(
    form = null
  ) {


    var state = window.AutomatorGaleriaUploadState;


    if(!form || !state.file) {

      return null;

    }


    var formData = new FormData(form);


    formData.set(

      'file',

      state.file,

      state.file.name

    );


    formData.set(

      'tbl_sys_uploads_type_ID',

      state.type ? state.type.id : ''

    );


    return formData;


  }


  function AutomatorGaleriaUploadsHideModalForUpload(
    callback = null
  ) {


    var state =

      window.AutomatorGaleriaUploadState;


    var modalElement = document.getElementById(

      'automator-galeria-upload-modal'

    );


    if(

      !modalElement ||

      !state.modal

    ) {


      if(typeof callback === 'function') {

        callback();

      }


      return false;

    }


    state.hidingForUpload = true;


    if(

      typeof window.AutomatorClearModalFocus ===

      'function'

    ) {


      AutomatorClearModalFocus(

        modalElement

      );


    }


    modalElement.addEventListener(

      'hidden.bs.modal',

      function() {


        /*
        |--------------------------------------------------------------------------
        | Aguarda o navegador concluir a pintura sem o modal
        |--------------------------------------------------------------------------
        */

        window.requestAnimationFrame(

          function() {


            window.requestAnimationFrame(

              function() {


                if(typeof callback === 'function') {

                  callback();

                }


              }

            );


          }

        );


      },

      {

        once: true,

      }

    );


    state.modal.hide();


    return true;


  }


  function AutomatorGaleriaUploadsGetProgressHTML() {


    var html = '';


    html += '<div class="automator-galeria-upload-toast-progress">';

      html += '<div class="d-flex justify-content-between small mb-2">';

        html += '<span>Enviando arquivo...</span>';

        html += '<span id="automator-galeria-upload-toast-percent">0%</span>';

      html += '</div>';

      html += '<div class="progress" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0" style="height: 24px; min-width: 280px;">';

        html += '<div id="automator-galeria-upload-toast-progress-bar" class="progress-bar progress-bar-striped progress-bar-animated" style="width: 0%;">0%</div>';

      html += '</div>';

    html += '</div>';


    return html;


  }


  function AutomatorGaleriaUploadsCreateProgressToast(
    callback = null
  ) {


    var state =

      window.AutomatorGaleriaUploadState;


    state.progressToastName =

      'automator-galeria-upload-progress-' +

      Date.now();


    AutomatorGaleriaUploadsSetPageScrollLocked(

      true

    );


    var toast = null;


    if(

      typeof window.AutomatorCreateToastAlert ===

      'function'

    ) {


      toast = AutomatorCreateToastAlert(

        state.progressToastName,

        'center',

        'middle',

        true,

        false,

        'ENVIANDO',

        AutomatorGaleriaUploadsGetProgressHTML(),

        null,

        false,

        null

      );


    }


    if(

      !toast ||

      !toast.element

    ) {


      state.progressToastName = null;


      AutomatorGaleriaUploadsSetPageScrollLocked(

        false

      );


      if(typeof callback === 'function') {

        callback(false);

      }


      return false;

    }


    /*
    |--------------------------------------------------------------------------
    | Garante que o toast seja desenhado antes do XMLHttpRequest
    |--------------------------------------------------------------------------
    */

    window.requestAnimationFrame(

      function() {


        window.requestAnimationFrame(

          function() {


            AutomatorGaleriaUploadsSetProgress(

              0

            );


            if(typeof callback === 'function') {


              callback(

                true

              );


            }


          }

        );


      }

    );


    return state.progressToastName;


  }


  function AutomatorGaleriaUploadsSetProgress(
    percent = 0
  ) {


    percent = Number(

      percent

      || 0

    );


    if(!Number.isFinite(percent)) {

      percent = 0;

    }


    percent = Math.max(

      0,

      Math.min(

        100,

        percent

      )

    );


    /*
    |--------------------------------------------------------------------------
    | Mantém duas casas internamente e exibe inteiro
    |--------------------------------------------------------------------------
    */

    var roundedPercent = Math.round(

      percent

    );


    var progressBar = document.getElementById(

      'automator-galeria-upload-toast-progress-bar'

    );


    var progressPercent = document.getElementById(

      'automator-galeria-upload-toast-percent'

    );


    var progressElement = progressBar

      ? progressBar.closest(

          '.progress'

        )

      : null;


    if(progressBar) {


      progressBar.style.width =

        percent.toFixed(2) +

        '%';


      progressBar.textContent =

        roundedPercent +

        '%';


      progressBar.setAttribute(

        'data-automator-upload-progress',

        percent.toFixed(2)

      );


      if(percent >= 100) {


        progressBar.classList.remove(

          'progress-bar-animated'

        );


      } else {


        progressBar.classList.add(

          'progress-bar-animated'

        );


      }


    }


    if(progressPercent) {


      progressPercent.textContent =

        roundedPercent +

        '%';


    }


    if(progressElement) {


      progressElement.setAttribute(

        'aria-valuenow',

        percent.toFixed(2)

      );


    }


    return percent;


  }


  function AutomatorGaleriaUploadsCloseProgressToast(
    callback = null
  ) {


    var state =

      window.AutomatorGaleriaUploadState;


    var toastName =

      state.progressToastName;


    state.progressToastName = null;


    function finish() {


      AutomatorGaleriaUploadsSetPageScrollLocked(

        false

      );


      window.requestAnimationFrame(

        function() {


          window.requestAnimationFrame(

            function() {


              if(typeof callback === 'function') {

                callback();

              }


            }

          );


        }

      );


    }


    if(!toastName) {


      finish();


      return true;

    }


    if(

      typeof window.AutomatorCloseToastAlert !==

      'function'

    ) {


      finish();


      return true;

    }


    AutomatorCloseToastAlert(

      toastName,

      finish

    );


    return true;


  }


  function AutomatorGaleriaUploadsShowResultToast(
    success = false,
    message = '',
    callback = null
  ) {


    var completed = false;


    AutomatorGaleriaUploadsSetPageScrollLocked(

      true

    );


    function finish() {


      if(completed === true) {

        return;

      }


      completed = true;


      AutomatorGaleriaUploadsSetPageScrollLocked(

        false

      );


      window.requestAnimationFrame(

        function() {


          window.requestAnimationFrame(

            function() {


              if(typeof callback === 'function') {

                callback();

              }


            }

          );


        }

      );


    }


    if(

      typeof window.AutomatorCreateAutoCloseToastAlert ===

      'function'

    ) {


      var toast =

        AutomatorCreateAutoCloseToastAlert(

          'automator-galeria-upload-result-' +

          Date.now(),

          'center',

          'middle',

          true,

          true,

          success === true

            ? 'SUCESSO'

            : 'ERRO',

          message,

          null,

          false,

          finish,

          3000

        );


      if(!toast) {

        finish();

      }


      return toast;

    }


    alert(

      (

        success === true

          ? 'SUCESSO'

          : 'ERRO'

      ) +

      '\n\n' +

      message

    );


    finish();


    return true;


  }


  function AutomatorGaleriaUploadsResetUploadForm() {


    var state = window.AutomatorGaleriaUploadState;

    var form = document.getElementById(

      'automator-galeria-upload-form'

    );


    var fileSelector = document.getElementById(

      'automator-galeria-uploads-file-selector'

    );


    var typeInput = document.getElementById(

      'automator-galeria-upload-type-id'

    );


    var fileName = document.getElementById(

      'automator-galeria-upload-file-name'

    );


    var fileInfo = document.getElementById(

      'automator-galeria-upload-file-info'

    );


    var fileIcon = document.getElementById(

      'automator-galeria-upload-file-icon'

    );


    if(form) {

      form.reset();

      form.classList.remove('was-validated');

    }


    if(typeInput) {

      typeInput.value = '';

    }


    if(fileSelector) {

      fileSelector.value = '';

    }


    if(fileName) {

      fileName.textContent = '';

    }


    if(fileInfo) {

      fileInfo.textContent = '';

    }


    if(fileIcon) {

      fileIcon.className = 'fa fa-file fa-2x text-secondary';

    }


    state.file = null;

    state.type = null;

    state.uploading = false;

    state.xhr = null;

    state.hidingForUpload = false;

    state.restoringAfterError = false;


    AutomatorGaleriaUploadsSetUploadingState(false);


    return true;


  }


  function AutomatorGaleriaUploadsRestoreUploadModalAfterError() {


    var state =

      window.AutomatorGaleriaUploadState;


    var modalElement = document.getElementById(

      'automator-galeria-upload-modal'

    );


    if(

      !modalElement ||

      typeof bootstrap === 'undefined' ||

      typeof bootstrap.Modal === 'undefined'

    ) {


      state.uploading = false;

      state.hidingForUpload = false;

      state.restoringAfterError = false;


      AutomatorGaleriaUploadsSetUploadingState(

        false

      );


      if(

        typeof window.AutomatorPageLoader ===

        'function'

      ) {


        AutomatorPageLoader(

          'hide',

          function() {


            AutomatorGaleriaUploadsSetPageScrollLocked(

              false

            );


          },

          150

        );


      } else {


        AutomatorGaleriaUploadsSetPageScrollLocked(

          false

        );


      }


      return false;

    }


    state.uploading = false;

    state.hidingForUpload = false;

    state.restoringAfterError = true;


    AutomatorGaleriaUploadsSetUploadingState(

      false

    );


    state.modal =

      bootstrap.Modal.getOrCreateInstance(

        modalElement,

        {

          backdrop: 'static',

          keyboard: false,

        }

      );


    modalElement.addEventListener(

      'shown.bs.modal',

      function() {


        /*
        |--------------------------------------------------------------------------
        | O modal já está visível; agora o loader pode desaparecer
        |--------------------------------------------------------------------------
        */

        state.restoringAfterError = false;


        AutomatorGaleriaUploadsSetUnsavedWarning(

          true

        );


        if(

          typeof window.AutomatorSetActionStatus ===

          'function'

        ) {


          AutomatorSetActionStatus(

            false

          );


        }


        if(

          typeof window.AutomatorPageLoader ===

          'function'

        ) {


          AutomatorPageLoader(

            'hide',

            function() {


              AutomatorGaleriaUploadsSetPageScrollLocked(

                false

              );


              var titleInput = document.getElementById(

                'automator-galeria-upload-title'

              );


              if(titleInput) {

                titleInput.focus();

              }


            },

            150

          );


        } else {


          AutomatorGaleriaUploadsSetPageScrollLocked(

            false

          );


        }


      },

      {

        once: true,

      }

    );


    state.modal.show();


    return true;


  }


  function AutomatorGaleriaUploadsFinalizeUpload(
    success = false,
    response = {}
  ) {


    var state =

      window.AutomatorGaleriaUploadState;


    var message =

      response &&

      response.message

        ? response.message

        : (

            success === true

              ? 'O arquivo foi enviado com sucesso.'

              : 'Não foi possível enviar o arquivo.'

          );


    /*
    |--------------------------------------------------------------------------
    | Primeiro fecha o toast de progresso
    |--------------------------------------------------------------------------
    */

    AutomatorGaleriaUploadsCloseProgressToast(

      function() {


        /*
        |--------------------------------------------------------------------------
        | Depois exibe o toast de resultado
        |--------------------------------------------------------------------------
        */

        AutomatorGaleriaUploadsShowResultToast(

          success,

          message,

          function() {


            state.xhr = null;


            if(success === true) {


              /*
              |--------------------------------------------------------------------------
              | Insere o novo item somente após o toast desaparecer
              |--------------------------------------------------------------------------
              */

              if(

                response.data &&

                typeof response.data === 'object'

              ) {


                AutomatorGaleriaUploadsAppendItem(

                  response.data,

                  {

                    position: 'before',

                  }

                );


              }


              /*
              |--------------------------------------------------------------------------
              | Remove os observadores somente agora
              |--------------------------------------------------------------------------
              */

              AutomatorGaleriaUploadsSetUnsavedWarning(

                false

              );


              if(

                typeof window.AutomatorSetActionStatus ===

                'function'

              ) {


                AutomatorSetActionStatus(

                  false

                );


              }


              /*
              |--------------------------------------------------------------------------
              | Reseta o formulário oculto
              |--------------------------------------------------------------------------
              */

              AutomatorGaleriaUploadsResetUploadForm();


              state.uploading = false;

              state.hidingForUpload = false;

              state.restoringAfterError = false;


              /*
              |--------------------------------------------------------------------------
              | Por último oculta o page-loader
              |--------------------------------------------------------------------------
              */

              if(

                typeof window.AutomatorPageLoader ===

                'function'

              ) {


                AutomatorPageLoader(

                  'hide',

                  function() {


                    AutomatorGaleriaUploadsSetPageScrollLocked(

                      false

                    );


                  },

                  150

                );


              } else {


                AutomatorGaleriaUploadsSetPageScrollLocked(

                  false

                );


              }


            } else {


              /*
              |--------------------------------------------------------------------------
              | Em caso de erro mantém todos os dados e o observador
              |--------------------------------------------------------------------------
              */

              state.uploading = false;


              AutomatorGaleriaUploadsSetUnsavedWarning(

                true

              );


              AutomatorGaleriaUploadsRestoreUploadModalAfterError();


            }


          }

        );


      }

    );


    return true;


  }


  function AutomatorGaleriaUploadsBuildItemElement(
    item = null
  ) {


    item =

      AutomatorGaleriaUploadsNormalizeResponseItem(

        item

      );


    if(!item) {

      return null;

    }


    var type = item.type || {};


    var mime = String(

      type.mime

      || ''

    )
      .trim()
      .toLowerCase();


    var isImage = (

      mime.indexOf(

        'image/'

      ) === 0

    );


    var fileURL = String(

      item.file_url

      || ''

    );


    var title =

      AutomatorGaleriaUploadsEscapeHTML(

        item.tbl_sys_upload_title

        || ''

      );


    var icon =

      AutomatorGaleriaUploadsEscapeHTML(

        type.icon

        || 'file'

      );


    var extension =

      AutomatorGaleriaUploadsEscapeHTML(

        type.extension

        || AutomatorGaleriaUploadsGetFileExtension(

          item.tbl_sys_upload_file

          || ''

        )

      ).toUpperCase();


    var uploadID =

      AutomatorGaleriaUploadsEscapeHTML(

        item.tbl_sys_upload_ID

        || ''

      );


    var previewHTML = '';

    var previewClass = '';

    var previewStyle = '';


    if(

      isImage === true &&

      fileURL != ''

    ) {


      previewClass =

        ' automator-galeria-upload-preview-image';


      previewStyle =

        ' style="background-image: url(\'' +

        AutomatorGaleriaUploadsEscapeHTML(

          fileURL

        ) +

        '\');"';


    } else {


      previewHTML =

        '<div class="text-center px-3">' +

          '<i class="fa fa-' +

            icon +

            ' fa-4x text-secondary"></i>' +

          '<div class="small text-muted mt-3">' +

            extension +

          '</div>' +

        '</div>';


    }


    var element = document.createElement(

      'div'

    );


    element.className =

      'col automator-galeria-upload-item';


    element.setAttribute(

      'data-automator-upload-id',

      uploadID

    );


    element.innerHTML =

      '<input ' +

        'type="checkbox" ' +

        'name="uploads[]" ' +

        'value="' +

          uploadID +

        '" ' +

        'class="d-none automator-galeria-upload-checkbox" ' +

      '/>' +

      '<div class="automator-galeria-upload-square">' +

        '<div class="card rounded-3 h-100 overflow-hidden automator-galeria-upload-card">' +

          '<div class="card-header text-truncate automator-galeria-upload-card-header">' +

            title +

          '</div>' +

          '<div ' +

            'class="card-body p-0 d-flex align-items-center justify-content-center bg-light automator-galeria-upload-preview' +

              previewClass +

            '"' +

            previewStyle +

          '>' +

            previewHTML +

          '</div>' +

          '<div class="card-footer text-center automator-galeria-upload-card-footer">' +

            '<button ' +

              'type="button" ' +

              'data-bs-toggle="tooltip" ' +

              'data-bs-placement="top" ' +

              'data-bs-title="Visualizar arquivo" ' +

              'class="btn btn-primary d-inline-flex mx-2 automator-galeria-upload-view" ' +

              'data-automator-upload-view="' +

                uploadID +

              '">' +

              '<i class="fa fa-eye"></i>' +

            '</button>' +

            '<button ' +

              'type="button" ' +

              'data-bs-toggle="tooltip" ' +

              'data-bs-placement="bottom" ' +

              'data-bs-title="Excluir arquivo" ' +

              'class="btn btn-danger d-inline-flex mx-2" ' +

              'data-automator-upload-delete="' +

                uploadID +

              '">' +

              '<i class="fa fa-trash"></i>' +

            '</button>' +

          '</div>' +

        '</div>' +

      '</div>';


    return element;


  }


  function AutomatorGaleriaUploadsAppendItem(
    item = null,
    options = {}
  ) {


    var itemsContainer = document.getElementById(

      'automator-galeria-uploads-area-itens'

    );


    var emptyContainer = document.getElementById(

      'automator-galeria-uploads-empty'

    );


    if(!itemsContainer) {

      return null;

    }


    item =

      AutomatorGaleriaUploadsNormalizeResponseItem(

        item

      );


    if(!item) {

      return null;

    }


    var uploadID = String(

      item.tbl_sys_upload_ID

      || ''

    ).trim();


    /*
    |--------------------------------------------------------------------------
    | Impede duplicação no DOM
    |--------------------------------------------------------------------------
    */

    if(

      uploadID == '' ||

      AutomatorGaleriaUploadsItemExists(

        uploadID

      ) === true

    ) {

      return null;

    }


    var element =

      AutomatorGaleriaUploadsBuildItemElement(

        item

      );


    if(!element) {

      return null;

    }


    if(

      options &&

      options.hidden === true

    ) {


      element.style.display = 'none';


    }


    if(

      options &&

      options.position === 'before'

    ) {


      itemsContainer.prepend(

        element

      );


    } else {


      itemsContainer.appendChild(

        element

      );


    }


    if(emptyContainer) {


      emptyContainer.classList.add(

        'd-none'

      );


    }


    AutomatorGaleriaUploadsUpdateSelectionMode();


    if(

      typeof window.AutomatorInitBootstrapTooltips ===

      'function'

    ) {


      AutomatorInitBootstrapTooltips(

        element

      );


    }


    AutomatorGaleriaUploadsScheduleTitleTooltips();


    return element;


  }


  function AutomatorGaleriaUploadsGetCurrentFilters() {


    var searchInput = document.getElementById(

      'search'

    );


    var perPageInput = document.getElementById(

      'per_page'

    );


    var searchFields = [];


    document.querySelectorAll(

      'input[name="search_in[]"]:checked'

    ).forEach(

      function(field) {


        searchFields.push(

          field.value

        );


      }

    );


    return {

      search:

        searchInput

          ? String(

              searchInput.value

              || ''

            ).trim()

          : '',

      search_in:

        searchFields,

      per_page:

        perPageInput

          ? Number(

              perPageInput.value

              || 4

            )

          : 4,

    };


  }


  function AutomatorGaleriaUploadsUpdateLoadMoreButton(
    hasMore = false
  ) {


    var button = document.getElementById(

      'automator-galeria-uploads-load-more'

    );


    var wrapper = document.getElementById(

      'automator-galeria-uploads-wrapper'

    );


    if(!button) {

      return false;

    }


    var loading = (

      wrapper &&

      String(

        wrapper.getAttribute(

          'data-automator-upload-loading'

        )

        || ''

      ).toLowerCase() === 'true'

    );


    button.classList.toggle(

      'd-none',

      hasMore !== true

    );


    button.disabled = (

      loading === true ||

      hasMore !== true

    );


    button.setAttribute(

      'aria-disabled',

      button.disabled === true

        ? 'true'

        : 'false'

    );


    return hasMore === true;


  }


  function AutomatorGaleriaUploadsGetLoadedIDs() {


    var loadedIDs = [];


    document.querySelectorAll(

      '#automator-galeria-uploads-area-itens ' +

      '.automator-galeria-upload-item' +

      '[data-automator-upload-id]'

    ).forEach(

      function(item) {


        var uploadID = String(

          item.getAttribute(

            'data-automator-upload-id'

          )

          || ''

        ).trim();


        if(

          uploadID == '' ||

          loadedIDs.indexOf(

            uploadID

          ) >= 0

        ) {

          return;

        }


        loadedIDs.push(

          uploadID

        );


      }

    );


    return loadedIDs;


  }


  function AutomatorGaleriaUploadsItemExists(
    uploadID = ''
  ) {


    uploadID = String(

      uploadID

      || ''

    ).trim();


    if(uploadID == '') {

      return false;

    }


    return document.querySelector(

      '#automator-galeria-uploads-area-itens ' +

      '.automator-galeria-upload-item' +

      '[data-automator-upload-id="' +

      CSS.escape(

        uploadID

      ) +

      '"]'

    ) !== null;


  }


  function AutomatorGaleriaUploadsLoadMore(
    button = null
  ) {


    var wrapper = document.getElementById(

      'automator-galeria-uploads-wrapper'

    );


    if(

      !wrapper ||

      !button ||

      button.disabled === true

    ) {

      return false;

    }


    var route = String(

      wrapper.getAttribute(

        'data-automator-upload-load-route'

      )

      || ''

    ).trim();


    if(route == '') {


      AutomatorGaleriaUploadsShowMessage(

        'Erro',

        'A rota para carregar mais arquivos não foi configurada.'

      );


      return false;

    }


    var filters =

      AutomatorGaleriaUploadsGetCurrentFilters();


    var loadedIDs =

      AutomatorGaleriaUploadsGetLoadedIDs();


    button.disabled = true;


    wrapper.setAttribute(

      'data-automator-upload-loading',

      'true'

    );


    function normalizeBoolean(
      value = false
    ) {


      if(

        typeof window.AutomatorNormalizeBoolean ===

        'function'

      ) {


        return AutomatorNormalizeBoolean(

          value

        );


      }


      return (

        value === true ||

        value === 1 ||

        value === '1' ||

        value === 'true'

      );


    }


    function finishLoader(
      hasMore = null
    ) {


      wrapper.setAttribute(

        'data-automator-upload-loading',

        'false'

      );


      if(hasMore !== null) {


        AutomatorGaleriaUploadsUpdateLoadMoreButton(

          hasMore === true

        );


      } else {


        button.disabled = false;


      }


      if(

        typeof window.AutomatorPageLoader ===

        'function'

      ) {


        AutomatorPageLoader(

          'hide',

          null,

          150

        );


      }


    }


    function showRequestError(
      message = ''
    ) {


      AutomatorGaleriaUploadsShowMessage(

        'Erro',

        message

        || 'Não foi possível carregar mais arquivos.',

        3000,

        function() {


          finishLoader(

            null

          );


        }

      );


    }


    function executeRequest() {


      $.ajax({

        url: route,

        type: 'POST',

        cache: false,

        dataType: 'json',

        data: {

          per_page:

            filters.per_page,

          search:

            filters.search,

          search_in:

            filters.search_in,

          loaded_ids:

            loadedIDs,

        },

        headers: {

          'X-CSRF-TOKEN':

            typeof window.AutomatorGetCSRFToken ===

            'function'

              ? AutomatorGetCSRFToken()

              : '',

          'Accept':

            'application/json',

        },


        success: function(
          response
        ) {


          var success = normalizeBoolean(

            response &&

            response.status

          );


          if(

            success !== true ||

            !response.data ||

            !Array.isArray(

              response.data.items

            )

          ) {


            showRequestError(

              response &&

              response.message

                ? response.message

                : 'A resposta recebida ao carregar os arquivos é inválida.'

            );


            return;

          }


          var addedElements = [];


          response.data.items.forEach(

            function(item) {


              if(

                !item ||

                typeof item !== 'object'

              ) {

                return;

              }


              var uploadID = String(

                item.tbl_sys_upload_ID

                || item.id

                || ''

              ).trim();


              /*
              |--------------------------------------------------------------------------
              | Proteção adicional contra repetição
              |--------------------------------------------------------------------------
              */

              if(

                uploadID == '' ||

                AutomatorGaleriaUploadsItemExists(

                  uploadID

                ) === true

              ) {

                return;

              }


              var element =

                AutomatorGaleriaUploadsAppendItem(

                  item,

                  {

                    hidden: true,

                    position: 'after',

                  }

                );


              if(element) {


                addedElements.push(

                  element

                );


              }


            }

          );


          var hasMore = normalizeBoolean(

            response.data.has_more

          );


          wrapper.setAttribute(

            'data-automator-upload-has-more',

            hasMore === true

              ? 'true'

              : 'false'

          );


          wrapper.setAttribute(

            'data-automator-upload-loaded-count',

            String(

              AutomatorGaleriaUploadsGetLoadedIDs().length

            )

          );


          /*
          |--------------------------------------------------------------------------
          | Exibe os itens adicionados simultaneamente
          |--------------------------------------------------------------------------
          */

          if(addedElements.length >= 1) {


            var completedAnimations = 0;


            $(addedElements).fadeIn(

              300,

              function() {


                completedAnimations++;


                if(

                  completedAnimations <

                  addedElements.length

                ) {

                  return;

                }


                AutomatorGaleriaUploadsScheduleTitleTooltips();


                finishLoader(

                  hasMore

                );


              }

            );


          } else {


            /*
            |--------------------------------------------------------------------------
            | Nenhum elemento novo
            |--------------------------------------------------------------------------
            |
            | Se o backend informou que ainda há registros, mantém o botão ativo.
            | Caso contrário, oculta definitivamente o botão.
            |
            */

            finishLoader(

              hasMore

            );


          }


        },


        error: function(
          xhr
        ) {


          var message =

            xhr.responseJSON &&

            xhr.responseJSON.message

              ? xhr.responseJSON.message

              : 'Não foi possível carregar mais arquivos.';


          showRequestError(

            message

          );


        },

      });


    }


    /*
    |--------------------------------------------------------------------------
    | Apenas exibe o page-loader
    |--------------------------------------------------------------------------
    |
    | Não utiliza AutomatorSetActionStatus, pois esta consulta não altera dados
    | e não deve ativar o aviso de saída da página.
    |
    */

    if(

      typeof window.AutomatorPageLoader ===

      'function'

    ) {


      AutomatorPageLoader(

        'show',

        function() {


          AutomatorGaleriaUploadsDelay(

            500,

            executeRequest

          );


        },

        150

      );


    } else {


      executeRequest();


    }


    return true;


  }


  function AutomatorGaleriaUploadsSubmit(
    form = null
  ) {


    if(

      !form ||

      AutomatorGaleriaUploadsValidateForm(

        form

      ) !== true

    ) {

      return false;

    }


    var state =

      window.AutomatorGaleriaUploadState;


    if(state.uploading === true) {

      return false;

    }


    var route = String(

      form.getAttribute(

        'action'

      )

      || ''

    ).trim();


    var formData =

      AutomatorGaleriaUploadsBuildFormData(

        form

      );


    if(

      route == '' ||

      !formData

    ) {

      return false;

    }


    /*
    |--------------------------------------------------------------------------
    | Mantém observadores ativos durante todo o processo
    |--------------------------------------------------------------------------
    */

    state.uploading = true;

    state.hidingForUpload = false;

    state.restoringAfterError = false;


    AutomatorGaleriaUploadsSetUnsavedWarning(

      true

    );


    AutomatorGaleriaUploadsSetUploadingState(

      true

    );


    if(

      typeof window.AutomatorSetActionStatus ===

      'function'

    ) {


      AutomatorSetActionStatus(

        true

      );


    }


    /*
    |--------------------------------------------------------------------------
    | Oculta barras de rolagem durante loader e toasts
    |--------------------------------------------------------------------------
    */

    AutomatorGaleriaUploadsSetPageScrollLocked(

      true

    );


    function parseResponse(
      xhr
    ) {


      var response = null;


      try {


        response = JSON.parse(

          xhr.responseText

          || '{}'

        );


      } catch(error) {


        response = {

          status: false,

          message:

            xhr.responseText

            || 'A resposta recebida do servidor é inválida.',

        };


      }


      if(

        response &&

        response.errors &&

        typeof response.errors === 'object'

      ) {


        var errorMessages = [];


        Object.keys(

          response.errors

        ).forEach(

          function(errorField) {


            var messages =

              response.errors[errorField];


            if(!Array.isArray(messages)) {

              return;

            }


            messages.forEach(

              function(message) {


                errorMessages.push(

                  message

                );


              }

            );


          }

        );


        if(errorMessages.length >= 1) {


          response.message =

            errorMessages.join(

              '<br>'

            );


        }


      }


      return response;


    }


    function startUploadRequest() {


      var xhr = new XMLHttpRequest();


      state.xhr = xhr;


      xhr.open(

        'POST',

        route,

        true

      );


      xhr.setRequestHeader(

        'X-CSRF-TOKEN',

        typeof window.AutomatorGetCSRFToken ===

        'function'

          ? AutomatorGetCSRFToken()

          : ''

      );


      xhr.setRequestHeader(

        'Accept',

        'application/json'

      );


      /*
      |--------------------------------------------------------------------------
      | Progresso real de envio
      |--------------------------------------------------------------------------
      |
      | Este evento representa somente os bytes transmitidos pelo navegador.
      |
      */

      xhr.upload.addEventListener(

        'loadstart',

        function() {


          AutomatorGaleriaUploadsSetProgress(

            0

          );


        }

      );


      xhr.upload.addEventListener(

        'progress',

        function(event) {


          if(

            event.lengthComputable !== true ||

            event.total <= 0

          ) {

            return;

          }


          var percent = (

            event.loaded /

            event.total

          ) * 100;


          AutomatorGaleriaUploadsSetProgress(

            percent

          );


        }

      );


      /*
      |--------------------------------------------------------------------------
      | Todos os bytes foram enviados
      |--------------------------------------------------------------------------
      |
      | A resposta do servidor ainda pode estar sendo processada, mas o upload
      | real já alcançou 100%.
      |
      */

      xhr.upload.addEventListener(

        'load',

        function() {


          AutomatorGaleriaUploadsSetProgress(

            100

          );


        }

      );


      xhr.addEventListener(

        'load',

        function() {


          var response =

            parseResponse(

              xhr

            );


          var success = (

            xhr.status >= 200 &&

            xhr.status < 300 &&

            response &&

            (
              response.status === true ||

              response.status === 1 ||

              response.status === '1' ||

              response.status === 'true'
            )

          );


          state.xhr = null;


          AutomatorGaleriaUploadsFinalizeUpload(

            success,

            response

            || {}

          );


        }

      );


      xhr.addEventListener(

        'error',

        function() {


          state.xhr = null;


          AutomatorGaleriaUploadsFinalizeUpload(

            false,

            {

              message:

                'Não foi possível estabelecer uma conexão com o servidor para enviar o arquivo.',

            }

          );


        }

      );


      xhr.addEventListener(

        'timeout',

        function() {


          state.xhr = null;


          AutomatorGaleriaUploadsFinalizeUpload(

            false,

            {

              message:

                'O tempo limite para realizar o upload foi excedido.',

            }

          );


        }

      );


      xhr.addEventListener(

        'abort',

        function() {


          state.xhr = null;


          AutomatorGaleriaUploadsFinalizeUpload(

            false,

            {

              message:

                'O envio do arquivo foi cancelado.',

            }

          );


        }

      );


      xhr.send(

        formData

      );


    }


    function createProgressAndStartUpload() {


      AutomatorGaleriaUploadsCreateProgressToast(

        function(created) {


          if(created !== true) {


            AutomatorGaleriaUploadsFinalizeUpload(

              false,

              {

                message:

                  'Não foi possível criar o indicador de progresso do upload.',

              }

            );


            return;

          }


          /*
          |--------------------------------------------------------------------------
          | O toast já foi desenhado; agora inicia a transferência
          |--------------------------------------------------------------------------
          */

          startUploadRequest();


        }

      );


    }


    function hideModalAfterLoader() {


      AutomatorGaleriaUploadsHideModalForUpload(

        createProgressAndStartUpload

      );


    }


    /*
    |--------------------------------------------------------------------------
    | 1. Exibe somente o page-loader
    |--------------------------------------------------------------------------
    |
    | O texto do botão não é alterado.
    |
    */

    if(

      typeof window.AutomatorPageLoader ===

      'function'

    ) {


      AutomatorPageLoader(

        'show',

        function() {


          /*
          |--------------------------------------------------------------------------
          | 2. Depois que o loader estiver visível, oculta o modal
          |--------------------------------------------------------------------------
          */

          window.requestAnimationFrame(

            function() {


              window.requestAnimationFrame(

                hideModalAfterLoader

              );


            }

          );


        },

        150

      );


    } else {


      hideModalAfterLoader();


    }


    return true;


  }


  function AutomatorGaleriaUploadsSetItemSelected(
    item = null,
    selected = false
  ) {


    if(!item) {

      return false;

    }


    var checkbox = item.querySelector(

      '.automator-galeria-upload-checkbox'

    );


    var card = item.querySelector(

      '.automator-galeria-upload-card'

    );


    if(checkbox) {


      checkbox.checked =

        selected === true;


    }


    item.classList.toggle(

      'automator-galeria-upload-item-selected',

      selected === true

    );


    if(card) {


      /*
      |--------------------------------------------------------------------------
      | Mantém a largura da borda constante
      |--------------------------------------------------------------------------
      |
      | O destaque é realizado por cor e box-shadow, sem alterar as dimensões.
      |
      */

      card.style.setProperty(

        'box-sizing',

        'border-box',

        'important'

      );


      card.style.setProperty(

        'border-width',

        '1px',

        'important'

      );


      if(selected === true) {


        card.style.setProperty(

          'border-color',

          'var(--bs-primary)',

          'important'

        );


        card.style.setProperty(

          'box-shadow',

          '0 0 0 0.2rem rgba(var(--bs-primary-rgb), 0.20)',

          'important'

        );


      } else {


        card.style.removeProperty(

          'border-color'

        );


        card.style.removeProperty(

          'box-shadow'

        );


      }


    }


    return true;


  }

  function AutomatorGaleriaUploadsRefreshTitleTooltips(
    container = document
  ) {


    if(!container) {

      container = document;

    }


    var headers = container.querySelectorAll(

      '.automator-galeria-upload-card-header'

    );


    headers.forEach(

      function(header) {


        var fullTitle = String(

          header.textContent

          || ''

        ).trim();


        /*
        |--------------------------------------------------------------------------
        | Regras necessárias para truncamento responsivo
        |--------------------------------------------------------------------------
        */

        header.style.display = 'block';

        header.style.width = '100%';

        header.style.maxWidth = '100%';

        header.style.minWidth = '0';

        header.style.overflow = 'hidden';

        header.style.whiteSpace = 'nowrap';

        header.style.textOverflow = 'ellipsis';


        var truncated = (

          header.scrollWidth >

          header.clientWidth +

          1

        );


        var tooltipInstance = null;


        if(

          typeof bootstrap !== 'undefined' &&

          typeof bootstrap.Tooltip !== 'undefined'

        ) {


          tooltipInstance =

            bootstrap.Tooltip.getInstance(

              header

            );


        }


        if(

          truncated === true &&

          fullTitle != ''

        ) {


          header.setAttribute(

            'title',

            fullTitle

          );


          header.setAttribute(

            'data-bs-title',

            fullTitle

          );


          header.setAttribute(

            'data-bs-toggle',

            'tooltip'

          );


          header.setAttribute(

            'data-bs-placement',

            'top'

          );


          if(tooltipInstance) {


            tooltipInstance.dispose();


          }


          if(

            typeof bootstrap !== 'undefined' &&

            typeof bootstrap.Tooltip !== 'undefined'

          ) {


            new bootstrap.Tooltip(

              header,

              {

                title:

                  fullTitle,

                placement:

                  'top',

                trigger:

                  'hover focus',

              }

            );


          }


        } else {


          if(tooltipInstance) {


            tooltipInstance.dispose();


          }


          header.removeAttribute(

            'title'

          );


          header.removeAttribute(

            'data-bs-title'

          );


          header.removeAttribute(

            'data-bs-toggle'

          );


          header.removeAttribute(

            'data-bs-placement'

          );


        }


      }

    );


    return true;


  }


  function AutomatorGaleriaUploadsScheduleTitleTooltips() {


    if(

      window.AutomatorGaleriaUploadsTitleTooltipTimer

    ) {


      clearTimeout(

        window.AutomatorGaleriaUploadsTitleTooltipTimer

      );


    }


    window.AutomatorGaleriaUploadsTitleTooltipTimer =

      setTimeout(

        function() {


          window.AutomatorGaleriaUploadsTitleTooltipTimer =

            null;


          AutomatorGaleriaUploadsRefreshTitleTooltips(

            document

          );


        },

        150

      );


    return true;


  }


  function AutomatorGaleriaUploadsInitializeTitleTooltips() {


    AutomatorGaleriaUploadsScheduleTitleTooltips();


    window.removeEventListener(

      'resize',

      AutomatorGaleriaUploadsScheduleTitleTooltips

    );


    window.addEventListener(

      'resize',

      AutomatorGaleriaUploadsScheduleTitleTooltips

    );


    var itemsContainer = document.getElementById(

      'automator-galeria-uploads-area-itens'

    );


    if(

      itemsContainer &&

      typeof MutationObserver !== 'undefined'

    ) {


      if(

        window.AutomatorGaleriaUploadsTitleObserver

      ) {


        window.AutomatorGaleriaUploadsTitleObserver.disconnect();


      }


      window.AutomatorGaleriaUploadsTitleObserver =

        new MutationObserver(

          function() {


            AutomatorGaleriaUploadsScheduleTitleTooltips();


          }

        );


      window.AutomatorGaleriaUploadsTitleObserver.observe(

        itemsContainer,

        {

          childList: true,

          subtree: true,

          characterData: true,

        }

      );


    }


    return true;


  }


  function AutomatorGaleriaUploadsSetCardActionsDisabled(
    item = null,
    disabled = false
  ) {


    if(!item) {

      return false;

    }


    item.querySelectorAll('.card-footer button, .card-footer a').forEach(

      function(action) {


        if(action.tagName.toLowerCase() == 'button') {

          action.disabled = disabled === true;

        } else {


          action.classList.toggle('disabled', disabled === true);

          action.setAttribute(

            'aria-disabled',

            disabled === true ? 'true' : 'false'

          );


          if(disabled === true) {

            action.setAttribute('tabindex', '-1');

          } else {

            action.removeAttribute('tabindex');

          }


        }


      }

    );


    return true;


  }


  function AutomatorGaleriaUploadsUpdateDeleteButton() {


    var deleteButton = document.getElementById(

      'automator-galeria-uploads-delete-selected'

    );


    var checkedItems = document.querySelectorAll(

      '.automator-galeria-upload-checkbox:checked'

    );


    if(deleteButton) {

      deleteButton.disabled = checkedItems.length <= 0;

    }


    return checkedItems.length;


  }


  function AutomatorGaleriaUploadsUpdateSelectionMode() {


    var state = window.AutomatorGaleriaUploadState;

    var selectionMode = state.selectionMode === true;


    var itemsContainer = document.getElementById(

      'automator-galeria-uploads-area-itens'

    );


    if(itemsContainer) {

      itemsContainer.classList.toggle(

        'automator-galeria-selection-active',

        selectionMode

      );

    }


    document.querySelectorAll('.automator-galeria-upload-item').forEach(

      function(item) {


        AutomatorGaleriaUploadsSetCardActionsDisabled(

          item,

          selectionMode

        );


        if(selectionMode !== true) {

          AutomatorGaleriaUploadsSetItemSelected(item, false);

        }


      }

    );


    AutomatorGaleriaUploadsUpdateDeleteButton();


    return true;


  }


  function AutomatorGaleriaUploadsToggleSelectionMode() {


    var state = window.AutomatorGaleriaUploadState;

    var button = document.getElementById(

      'automator-galeria-uploads-select-items'

    );


    state.selectionMode = state.selectionMode !== true;


    if(button) {


      button.classList.toggle('active', state.selectionMode);

      button.setAttribute(

        'aria-pressed',

        state.selectionMode ? 'true' : 'false'

      );


    }


    AutomatorGaleriaUploadsUpdateSelectionMode();


    return state.selectionMode;


  }


  function AutomatorGaleriaUploadsToggleItemSelection(
    item = null
  ) {


    var state = window.AutomatorGaleriaUploadState;


    if(!item || state.selectionMode !== true) {

      return false;

    }


    var checkbox = item.querySelector(

      '.automator-galeria-upload-checkbox'

    );


    AutomatorGaleriaUploadsSetItemSelected(

      item,

      checkbox ? checkbox.checked !== true : true

    );


    AutomatorGaleriaUploadsUpdateDeleteButton();


    return true;


  }


  window.AutomatorGaleriaUploadsSubmitDelete = function(
    button = null
  ) {


    var form = document.getElementById(

      'automator-galeria-uploads-delete-form'

    );


    if(!form || !button || button.disabled === true) {

      return false;

    }


    return false;


  };


  function AutomatorGaleriaUploadsBuildPreview(
    item = {}
  ) {


    var type = item.type || {};

    var mime = String(type.mime || '').toLowerCase();

    var fileURL = String(item.file_url || '');

    var icon = AutomatorGaleriaUploadsEscapeHTML(type.icon || 'file');

    var title = AutomatorGaleriaUploadsEscapeHTML(

      item.tbl_sys_upload_title || 'Arquivo'

    );


    var safeURL = AutomatorGaleriaUploadsEscapeHTML(fileURL);

    var link = fileURL != ''

      ? '<div class="mt-3 automator-galeria-upload-preview-link"><a href="' + safeURL + '" target="_blank" rel="noopener noreferrer">' + safeURL + '</a></div>'

      : '';


    if(mime.indexOf('image/') === 0 && fileURL != '') {


      return '<div class="automator-galeria-upload-preview-content">' +
        '<a href="' + safeURL + '" target="_blank" rel="noopener noreferrer">' +
          '<img src="' + safeURL + '" alt="' + title + '" class="img-fluid" />' +
        '</a>' +
      '</div>';


    }


    if(mime.indexOf('video/') === 0 && fileURL != '') {


      return '<div class="automator-galeria-upload-preview-content">' +
        '<video controls preload="metadata">' +
          '<source src="' + safeURL + '" type="' + AutomatorGaleriaUploadsEscapeHTML(mime) + '" />' +
        '</video>' +
        link +
      '</div>';


    }


    if(mime.indexOf('audio/') === 0 && fileURL != '') {


      return '<div class="automator-galeria-upload-preview-content py-3">' +
        '<audio controls preload="metadata">' +
          '<source src="' + safeURL + '" type="' + AutomatorGaleriaUploadsEscapeHTML(mime) + '" />' +
        '</audio>' +
        link +
      '</div>';


    }


    return '<div class="automator-galeria-upload-preview-content py-4">' +
      '<i class="fa fa-' + icon + ' fa-5x text-secondary"></i>' +
      link +
    '</div>';


  }


  function AutomatorGaleriaUploadsPrepareViewModalElement() {


    var modalElement = document.getElementById(

      'automator-galeria-view-modal'

    );


    if(!modalElement) {

      return null;

    }


    /*
    |--------------------------------------------------------------------------
    | Mantém o modal diretamente no body
    |--------------------------------------------------------------------------
    |
    | Os modais globais do sistema são adicionados diretamente ao body.
    | Isso evita que overflow, position ou transform de containers da página
    | impeçam o Bootstrap de controlar corretamente a rolagem do modal.
    |
    | appendChild apenas move o elemento existente, preservando:
    |
    | - campos e valores;
    | - listeners já registrados;
    | - instância futura do Bootstrap;
    | - IDs e referências usadas pelas demais funções.
    |
    */

    if(modalElement.parentNode !== document.body) {


      document.body.appendChild(

        modalElement

      );


    }


    var modalDialog = modalElement.querySelector(

      '.modal-dialog'

    );


    if(modalDialog) {


      modalDialog.classList.add(

        'modal-dialog-scrollable'

      );


      modalDialog.classList.add(

        'modal-dialog-centered'

      );


    }


    return modalElement;


  }

  function AutomatorGaleriaUploadsViewHasChanges() {


    var state =

      window.AutomatorGaleriaUploadState;


    var titleInput = document.getElementById(

      'automator-galeria-view-title'

    );


    if(!titleInput) {

      return false;

    }


    var currentTitle = String(

      titleInput.value

      || ''

    ).trim();


    var originalTitle = String(

      state.viewOriginalTitle

      || ''

    ).trim();


    return (

      currentTitle !== originalTitle

    );


  }


  function AutomatorGaleriaUploadsSetViewUnsavedWarning(
    enabled = true
  ) {


    $(window).off(

      'beforeunload.AutomatorGaleriaUploadsViewUnsaved'

    );


    if(enabled !== true) {

      return true;

    }


    $(window).on(

      'beforeunload.AutomatorGaleriaUploadsViewUnsaved',

      function(event) {


        var state =

          window.AutomatorGaleriaUploadState;


        if(

          state.viewUpdating === true ||

          AutomatorGaleriaUploadsViewHasChanges() !== true

        ) {

          return;

        }


        var message =

          'Existem alterações não salvas neste arquivo. Ao sair desta página, os dados serão perdidos.';


        event.preventDefault();

        event.returnValue = message;


        return message;


      }

    );


    return true;


  }


  function AutomatorGaleriaUploadsUpdateViewChangedState() {


    var form = document.getElementById(

      'automator-galeria-view-form'

    );


    var changed =

      AutomatorGaleriaUploadsViewHasChanges();


    if(form) {


      form.setAttribute(

        'data-submit',

        changed === true

          ? 'true'

          : 'false'

      );


      form.setAttribute(

        'data-automator-form-changed',

        changed === true

          ? 'true'

          : 'false'

      );


    }


    AutomatorGaleriaUploadsSetViewUnsavedWarning(

      changed

    );


    AutomatorGaleriaUploadsUpdateViewSaveButtonState();


    return changed;


  }


  function AutomatorGaleriaUploadsHideViewModalForSubmit(
    callback = null
  ) {


    var state =

      window.AutomatorGaleriaUploadState;


    var modalElement = document.getElementById(

      'automator-galeria-view-modal'

    );


    if(

      !modalElement ||

      !state.viewModal

    ) {


      if(typeof callback === 'function') {

        callback();

      }


      return false;

    }


    state.viewHidingForSubmit = true;


    if(

      typeof window.AutomatorClearModalFocus ===

      'function'

    ) {


      AutomatorClearModalFocus(

        modalElement

      );


    }


    modalElement.addEventListener(

      'hidden.bs.modal',

      function() {


        AutomatorGaleriaUploadsDelay(

          500,

          callback

        );


      },

      {

        once: true,

      }

    );


    state.viewModal.hide();


    return true;


  }


  function AutomatorGaleriaUploadsRestoreViewModalAfterError() {


    var state =

      window.AutomatorGaleriaUploadState;


    var modalElement = document.getElementById(

      'automator-galeria-view-modal'

    );


    if(

      !modalElement ||

      typeof bootstrap === 'undefined' ||

      typeof bootstrap.Modal === 'undefined'

    ) {


      if(

        typeof window.AutomatorPageLoader ===

        'function'

      ) {


        AutomatorPageLoader(

          'hide',

          null,

          150

        );


      }


      return false;

    }


    state.viewHidingForSubmit = false;

    state.viewRestoringAfterError = true;

    state.viewUpdating = false;


    state.viewModal =

      bootstrap.Modal.getOrCreateInstance(

        modalElement,

        {

          backdrop: 'static',

          keyboard: false,

          focus: true,

        }

      );


    modalElement.addEventListener(

      'shown.bs.modal',

      function() {


        state.viewRestoringAfterError = false;


        AutomatorGaleriaUploadsUpdateViewChangedState();


        if(

          typeof window.AutomatorSetActionStatus ===

          'function'

        ) {


          AutomatorSetActionStatus(

            false

          );


        }


        if(

          typeof window.AutomatorPageLoader ===

          'function'

        ) {


          AutomatorPageLoader(

            'hide',

            function() {


              var titleInput = document.getElementById(

                'automator-galeria-view-title'

              );


              if(titleInput) {

                titleInput.focus();

              }


            },

            150

          );


        }


      },

      {

        once: true,

      }

    );


    state.viewModal.show();


    return true;


  }


  function AutomatorGaleriaUploadsResetViewModal() {


    var state =

      window.AutomatorGaleriaUploadState;


    var form = document.getElementById(

      'automator-galeria-view-form'

    );


    var preview = document.getElementById(

      'automator-galeria-view-preview'

    );


    var idInput = document.getElementById(

      'automator-galeria-view-id'

    );


    var titleInput = document.getElementById(

      'automator-galeria-view-title'

    );


    var directoryInput = document.getElementById(

      'automator-galeria-view-directory'

    );


    var accessInput = document.getElementById(

      'automator-galeria-view-access'

    );


    if(form) {


      form.reset();


      form.classList.remove(

        'was-validated'

      );


      form.setAttribute(

        'data-submit',

        'false'

      );


      form.setAttribute(

        'data-automator-form-changed',

        'false'

      );


    }


    if(preview) {

      preview.innerHTML = '';

    }


    if(idInput) {

      idInput.value = '';

    }


    if(titleInput) {


      titleInput.value = '';

      titleInput.setCustomValidity('');


    }


    if(directoryInput) {

      directoryInput.value = '';

    }


    if(accessInput) {

      accessInput.value = 'public';

    }


    state.viewOriginalTitle = '';

    state.viewUpdating = false;

    state.viewHidingForSubmit = false;

    state.viewRestoringAfterError = false;

    state.viewModal = null;


    AutomatorGaleriaUploadsSetViewUnsavedWarning(

      false

    );


    AutomatorGaleriaUploadsUpdateViewSaveButtonState(

      true

    );


    return true;


  }


  function AutomatorGaleriaUploadsShowViewResultToast(
    success = false,
    message = '',
    callback = null
  ) {


    var finished = false;


    function finish() {


      if(finished === true) {

        return;

      }


      finished = true;


      AutomatorGaleriaUploadsDelay(

        500,

        callback

      );


    }


    if(

      typeof window.AutomatorCreateAutoCloseToastAlert ===

      'function'

    ) {


      var toast =

        AutomatorCreateAutoCloseToastAlert(

          'automator-galeria-view-result-' +

          Date.now(),

          'center',

          'middle',

          true,

          true,

          success === true

            ? 'SUCESSO'

            : 'ERRO',

          message,

          null,

          false,

          finish,

          3000

        );


      if(!toast) {

        finish();

      }


      return toast;

    }


    alert(

      (

        success === true

          ? 'SUCESSO'

          : 'ERRO'

      ) +

      '\n\n' +

      message

    );


    finish();


    return true;


  }



  function AutomatorGaleriaUploadsUpdateViewSaveButtonState(
    forceDisabled = null
  ) {


    var state =

      window.AutomatorGaleriaUploadState;


    var titleInput = document.getElementById(

      'automator-galeria-view-title'

    );


    var saveButton = document.getElementById(

      'automator-galeria-view-save'

    );


    if(!saveButton) {

      return false;

    }


    /*
    |--------------------------------------------------------------------------
    | Desabilitação forçada
    |--------------------------------------------------------------------------
    |
    | Utilizada durante:
    |
    | - carregamento inicial do modal;
    | - requisição de atualização;
    | - finalização bem-sucedida.
    |
    */

    if(forceDisabled === true) {


      saveButton.disabled = true;

      saveButton.setAttribute(

        'aria-disabled',

        'true'

      );


      return false;


    }


    /*
    |--------------------------------------------------------------------------
    | Habilitação forçada
    |--------------------------------------------------------------------------
    */

    if(forceDisabled === false) {


      saveButton.disabled = false;

      saveButton.setAttribute(

        'aria-disabled',

        'false'

      );


      return true;


    }


    /*
    |--------------------------------------------------------------------------
    | Estado automático
    |--------------------------------------------------------------------------
    |
    | O botão será habilitado somente quando:
    |
    | - o campo de título existir;
    | - o título não estiver vazio;
    | - o título for diferente do valor originalmente carregado.
    |
    */

    if(!titleInput) {


      saveButton.disabled = true;

      saveButton.setAttribute(

        'aria-disabled',

        'true'

      );


      return false;


    }


    var currentTitle = String(

      titleInput.value

      || ''

    ).trim();


    var originalTitle = String(

      state.viewOriginalTitle

      || ''

    ).trim();


    var enabled = (

      currentTitle != '' &&

      currentTitle !== originalTitle

    );


    saveButton.disabled =

      enabled !== true;


    saveButton.setAttribute(

      'aria-disabled',

      enabled === true

        ? 'false'

        : 'true'

    );


    return enabled;


  }


  function AutomatorGaleriaUploadsPopulateViewModal(
    item = {}
  ) {


    var state =

      window.AutomatorGaleriaUploadState;


    var modalElement =

      AutomatorGaleriaUploadsPrepareViewModalElement();


    if(!modalElement) {

      return false;

    }


    var preview = modalElement.querySelector(

      '#automator-galeria-view-preview'

    );


    var idInput = modalElement.querySelector(

      '#automator-galeria-view-id'

    );


    var titleInput = modalElement.querySelector(

      '#automator-galeria-view-title'

    );


    var directoryInput = modalElement.querySelector(

      '#automator-galeria-view-directory'

    );


    var accessInput = modalElement.querySelector(

      '#automator-galeria-view-access'

    );


    var form = modalElement.querySelector(

      '#automator-galeria-view-form'

    );


    if(preview) {


      preview.innerHTML =

        AutomatorGaleriaUploadsBuildPreview(

          item

        );


    }


    if(idInput) {


      idInput.value =

        item.tbl_sys_upload_ID

        || '';


      idInput.readOnly = true;

      idInput.disabled = true;


    }


    if(titleInput) {


      titleInput.value =

        item.tbl_sys_upload_title

        || '';


      titleInput.readOnly = false;

      titleInput.disabled = false;

      titleInput.setCustomValidity('');


    }


    if(directoryInput) {


      directoryInput.value =

        item.tbl_sys_upload_directory

        || '';


      directoryInput.readOnly = true;

      directoryInput.disabled = true;


    }


    if(accessInput) {


      accessInput.value =

        item.tbl_sys_upload_access

        || 'public';


      accessInput.disabled = true;


    }


    state.viewOriginalTitle = String(

      item.tbl_sys_upload_title

      || ''

    ).trim();


    state.viewUpdating = false;

    state.viewHidingForSubmit = false;

    state.viewRestoringAfterError = false;


    if(form) {


      form.classList.remove(

        'was-validated'

      );


      form.setAttribute(

        'data-submit',

        'false'

      );


      form.setAttribute(

        'data-automator-form-changed',

        'false'

      );


    }


    AutomatorGaleriaUploadsSetViewUnsavedWarning(

      false

    );


    AutomatorGaleriaUploadsUpdateViewSaveButtonState(

      true

    );


    return true;


  }


  function AutomatorGaleriaUploadsOpenViewModal(
    uploadID = ''
  ) {


    uploadID = String(

      uploadID

      || ''

    ).trim();


    if(uploadID == '') {

      return false;

    }


    var wrapper = document.getElementById(

      'automator-galeria-uploads-wrapper'

    );


    var route = wrapper

      ? wrapper.getAttribute(

          'data-automator-upload-get-route'

        )

      : '';


    route = AutomatorGaleriaUploadsBuildRoute(

      route,

      uploadID

    );


    if(route == '') {


      AutomatorGaleriaUploadsShowMessage(

        'Erro',

        'A rota de consulta do arquivo não foi configurada.'

      );


      return false;

    }


    var modalElement =

      AutomatorGaleriaUploadsPrepareViewModalElement();


    if(

      !modalElement ||

      typeof bootstrap === 'undefined' ||

      typeof bootstrap.Modal === 'undefined'

    ) {


      AutomatorGaleriaUploadsShowMessage(

        'Erro',

        'Não foi possível preparar o modal de visualização.'

      );


      return false;

    }


    if(

      typeof window.AutomatorSetActionStatus ===

      'function'

    ) {


      AutomatorSetActionStatus(

        true

      );


    }


    function finish(
      item = null
    ) {


      if(!item) {


        AutomatorGaleriaUploadsShowMessage(

          'Erro',

          'Não foi possível carregar as informações do arquivo.',

          3000,

          function() {


            if(

              typeof window.AutomatorPageLoader ===

              'function'

            ) {

              AutomatorPageLoader('hide');

            }


            if(

              typeof window.AutomatorSetActionStatus ===

              'function'

            ) {

              AutomatorSetActionStatus(false);

            }


          }

        );


        return false;

      }


      AutomatorGaleriaUploadsPopulateViewModal(

        item

      );


      var state =

        window.AutomatorGaleriaUploadState;


      state.viewModal =

        bootstrap.Modal.getOrCreateInstance(

          modalElement,

          {

            backdrop: 'static',

            keyboard: false,

            focus: true,

          }

        );


      AutomatorGaleriaUploadsDelay(

        500,

        function() {


          state.viewModal.show();


        }

      );


      return true;


    }


    function executeRequest() {


      $.ajax({

        url: route,

        type: 'GET',

        cache: false,

        headers: {

          'X-CSRF-TOKEN':

            typeof window.AutomatorGetCSRFToken ===

            'function'

              ? AutomatorGetCSRFToken()

              : '',

          'Accept':

            'application/json',

        },

        dataType: 'json',


        success: function(
          response
        ) {


          var success = (

            response &&

            (
              response.status === true ||

              response.status === 1 ||

              response.status === '1' ||

              response.status === 'true'
            )

          );


          var item = success

            ? AutomatorGaleriaUploadsNormalizeResponseItem(

                response,

                uploadID

              )

            : null;


          finish(

            item

          );


        },


        error: function(
          xhr
        ) {


          var message =

            xhr.responseJSON &&

            xhr.responseJSON.message

              ? xhr.responseJSON.message

              : 'Não foi possível carregar os dados do arquivo.';


          AutomatorGaleriaUploadsShowMessage(

            'Erro',

            message,

            3000,

            function() {


              if(

                typeof window.AutomatorPageLoader ===

                'function'

              ) {

                AutomatorPageLoader('hide');

              }


              if(

                typeof window.AutomatorSetActionStatus ===

                'function'

              ) {

                AutomatorSetActionStatus(false);

              }


            }

          );


        },

      });


    }


    if(

      typeof window.AutomatorPageLoader ===

      'function'

    ) {


      AutomatorPageLoader(

        'show',

        function() {


          AutomatorGaleriaUploadsDelay(

            500,

            executeRequest

          );


        },

        150

      );


    } else {


      executeRequest();


    }


    return true;


  }


  window.AutomatorGaleriaUploadsSubmitViewForm = function(
    button = null
  ) {


    var form = document.getElementById(

      'automator-galeria-view-form'

    );


    if(

      !form ||

      !button ||

      button.disabled === true

    ) {

      return false;

    }


    /*
    |--------------------------------------------------------------------------
    | Confirma novamente o estado antes do submit
    |--------------------------------------------------------------------------
    */

    if(

      AutomatorGaleriaUploadsUpdateViewSaveButtonState()

      !== true

    ) {

      return false;

    }


    /*
    |--------------------------------------------------------------------------
    | Validação
    |--------------------------------------------------------------------------
    */

    if(

      typeof form.checkValidity === 'function' &&

      form.checkValidity() !== true

    ) {


      form.classList.add(

        'was-validated'

      );


      var invalidField = form.querySelector(

        ':invalid'

      );


      if(invalidField) {

        invalidField.focus();

      }


      return false;

    }


    form.classList.remove(

      'was-validated'

    );


    /*
    |--------------------------------------------------------------------------
    | Evita novos cliques enquanto o submit é iniciado
    |--------------------------------------------------------------------------
    */

    AutomatorGaleriaUploadsUpdateViewSaveButtonState(

      true

    );


    /*
    |--------------------------------------------------------------------------
    | Executa o submit do formulário presente na modal-body
    |--------------------------------------------------------------------------
    */

    if(typeof form.requestSubmit === 'function') {


      var hiddenSubmit = document.getElementById(

        'automator-galeria-view-form-submit'

      );


      form.requestSubmit(

        hiddenSubmit || undefined

      );


    } else {


      var submitEvent = new Event(

        'submit',

        {

          bubbles: true,

          cancelable: true,

        }

      );


      form.dispatchEvent(

        submitEvent

      );


    }


    return false;


  };


  function AutomatorGaleriaUploadsSubmitViewUpdate(
    form = null
  ) {


    if(!form) {

      return false;

    }


    var state =

      window.AutomatorGaleriaUploadState;


    if(state.viewUpdating === true) {

      return false;

    }


    var wrapper = document.getElementById(

      'automator-galeria-uploads-wrapper'

    );


    var idInput = document.getElementById(

      'automator-galeria-view-id'

    );


    var titleInput = document.getElementById(

      'automator-galeria-view-title'

    );


    var uploadID = idInput

      ? String(

          idInput.value

          || ''

        ).trim()

      : '';


    var title = titleInput

      ? String(

          titleInput.value

          || ''

        ).trim()

      : '';


    if(uploadID == '') {


      AutomatorGaleriaUploadsShowMessage(

        'Erro',

        'Não foi possível identificar o arquivo que será atualizado.'

      );


      AutomatorGaleriaUploadsUpdateViewChangedState();


      return false;

    }


    if(title == '') {


      if(titleInput) {


        titleInput.setCustomValidity(

          'Informe o título do arquivo.'

        );


        titleInput.reportValidity();

        titleInput.focus();


      }


      AutomatorGaleriaUploadsUpdateViewChangedState();


      return false;

    }


    if(titleInput) {

      titleInput.setCustomValidity('');

    }


    if(

      AutomatorGaleriaUploadsViewHasChanges() !==

      true

    ) {


      AutomatorGaleriaUploadsUpdateViewSaveButtonState(

        true

      );


      return false;

    }


    var route = wrapper

      ? wrapper.getAttribute(

          'data-automator-upload-update-route'

        )

      : '';


    route = AutomatorGaleriaUploadsBuildRoute(

      route,

      uploadID

    );


    if(route == '') {


      AutomatorGaleriaUploadsShowMessage(

        'Erro',

        'A rota responsável pela atualização não foi configurada.'

      );


      AutomatorGaleriaUploadsUpdateViewChangedState();


      return false;

    }


    var formData = new FormData();


    formData.append(

      'tbl_sys_upload_ID',

      uploadID

    );


    formData.append(

      'tbl_sys_upload_title',

      title

    );


    state.viewUpdating = true;


    AutomatorGaleriaUploadsUpdateViewSaveButtonState(

      true

    );


    if(

      typeof window.AutomatorSetActionStatus ===

      'function'

    ) {


      AutomatorSetActionStatus(

        true

      );


    }


    function handleResult(
      success = false,
      response = {}
    ) {


      var message =

        response &&

        response.message

          ? response.message

          : (

              success === true

                ? 'O arquivo foi atualizado com sucesso.'

                : 'Não foi possível atualizar o arquivo.'

            );


      AutomatorGaleriaUploadsShowViewResultToast(

        success,

        message,

        function() {


          if(success === true) {


            var cardHeader = document.querySelector(

              '.automator-galeria-upload-item' +

              '[data-automator-upload-id="' +

              CSS.escape(

                String(uploadID)

              ) +

              '"] ' +

              '.automator-galeria-upload-card-header'

            );


            if(cardHeader) {


              cardHeader.textContent = title;


              AutomatorGaleriaUploadsScheduleTitleTooltips();


            }


            state.viewOriginalTitle = title;

            state.viewUpdating = false;

            state.viewHidingForSubmit = false;


            form.setAttribute(

              'data-submit',

              'false'

            );


            form.setAttribute(

              'data-automator-form-changed',

              'false'

            );


            AutomatorGaleriaUploadsSetViewUnsavedWarning(

              false

            );


            if(

              typeof window.AutomatorSetActionStatus ===

              'function'

            ) {


              AutomatorSetActionStatus(

                false

              );


            }


            AutomatorGaleriaUploadsResetViewModal();


            if(

              typeof window.AutomatorPageLoader ===

              'function'

            ) {


              AutomatorPageLoader(

                'hide',

                null,

                150

              );


            }


          } else {


            state.viewUpdating = false;


            /*
            |--------------------------------------------------------------------------
            | Preserva os dados alterados
            |--------------------------------------------------------------------------
            */

            AutomatorGaleriaUploadsSetViewUnsavedWarning(

              true

            );


            AutomatorGaleriaUploadsRestoreViewModalAfterError();


          }


        }

      );


    }


    function executeRequest() {


      AutomatorGaleriaUploadsDelay(

        500,

        function() {


          $.ajax({

            url: route,

            type: 'POST',

            data: formData,

            processData: false,

            contentType: false,

            headers: {

              'X-CSRF-TOKEN':

                typeof window.AutomatorGetCSRFToken ===
                'function'

                  ? AutomatorGetCSRFToken()

                  : '',

              'Accept':

                'application/json',

            },

            dataType: 'json',


            success: function(
              response
            ) {


              var success =

                typeof window.AutomatorNormalizeBoolean ===
                'function'

                  ? AutomatorNormalizeBoolean(

                      response &&

                      response.status

                    )

                  : (

                      response &&

                      (
                        response.status === true ||

                        response.status === 1 ||

                        response.status === '1' ||

                        response.status === 'true'
                      )

                    );


              handleResult(

                success,

                response

                || {}

              );


            },


            error: function(
              xhr
            ) {


              var response =

                xhr.responseJSON &&

                typeof xhr.responseJSON === 'object'

                  ? xhr.responseJSON

                  : {};


              if(!response.message) {


                response.message =

                  'Não foi possível atualizar o arquivo.';


              }


              handleResult(

                false,

                response

              );


            },

          });


        }

      );


    }


    /*
    |--------------------------------------------------------------------------
    | Exibe o loader e oculta o modal sem resetá-lo
    |--------------------------------------------------------------------------
    */

    if(

      typeof window.AutomatorPageLoader ===

      'function'

    ) {


      AutomatorPageLoader(

        'show',

        function() {


          AutomatorGaleriaUploadsHideViewModalForSubmit(

            executeRequest

          );


        },

        150

      );


    } else {


      AutomatorGaleriaUploadsHideViewModalForSubmit(

        executeRequest

      );


    }


    return false;


  }


  function AutomatorGaleriaUploadsInitialize() {


    var state = window.AutomatorGaleriaUploadState;


    if(state.initialized === true) {

      return true;

    }


    var wrapper = document.getElementById(

      'automator-galeria-uploads-wrapper'

    );


    var uploadButton = document.getElementById(

      'automator-galeria-uploads-send'

    );


    var selectionButton = document.getElementById(

      'automator-galeria-uploads-select-items'

    );


    var loadMoreButton = document.getElementById(

      'automator-galeria-uploads-load-more'

    );


    var fileSelector = document.getElementById(

      'automator-galeria-uploads-file-selector'

    );


    var dropzone = document.getElementById(

      'automator-galeria-uploads-area'

    );


    var modalElement = document.getElementById(

      'automator-galeria-upload-modal'

    );


    var viewModalElement = document.getElementById(

      'automator-galeria-view-modal'

    );


    var uploadForm = document.getElementById(

      'automator-galeria-upload-form'

    );


    var viewForm = document.getElementById(

      'automator-galeria-view-form'

    );


    if(

      !wrapper ||
      !uploadButton ||
      !fileSelector ||
      !dropzone ||
      !modalElement ||
      !uploadForm

    ) {

      return false;

    }


    state.initialized = true;


    uploadButton.addEventListener(

      'click',

      function(event) {


        event.preventDefault();


        if(state.uploading === true) {

          return false;

        }


        fileSelector.value = '';

        fileSelector.click();


        return false;


      }

    );


    if(selectionButton) {


      selectionButton.addEventListener(

        'click',

        function(event) {


          event.preventDefault();

          event.stopPropagation();


          AutomatorGaleriaUploadsToggleSelectionMode();


          return false;


        }

      );


    }


    if(loadMoreButton) {


      loadMoreButton.addEventListener(

        'click',

        function(event) {


          event.preventDefault();

          event.stopPropagation();


          AutomatorGaleriaUploadsLoadMore(

            this

          );


          return false;


        }

      );


      AutomatorGaleriaUploadsUpdateLoadMoreButton(

        String(

          wrapper.getAttribute(

            'data-automator-upload-has-more'

          )

          || ''

        ).toLowerCase() === 'true'

      );


    }


    document.addEventListener(

      'click',

      function(event) {


        var viewButton = event.target.closest(

          '.automator-galeria-upload-view'

        );


        if(viewButton && state.selectionMode !== true) {


          event.preventDefault();

          event.stopPropagation();


          AutomatorGaleriaUploadsOpenViewModal(

            viewButton.getAttribute('data-automator-upload-view')

          );


          return;


        }


        var item = event.target.closest(

          '.automator-galeria-upload-item'

        );


        if(!item || state.selectionMode !== true) {

          return;

        }


        event.preventDefault();

        event.stopPropagation();


        AutomatorGaleriaUploadsToggleItemSelection(item);


      }

    );


    document.querySelectorAll(

      '.automator-galeria-upload-change-file'

    ).forEach(

      function(button) {


        button.addEventListener(

          'click',

          function(event) {


            event.preventDefault();


            if(state.uploading === true) {

              return false;

            }


            fileSelector.value = '';

            fileSelector.click();


            return false;


          }

        );


      }

    );


    fileSelector.addEventListener(

      'change',

      function() {


        var file = this.files && this.files.length >= 1

          ? this.files[0]

          : null;


        if(!file) {

          return;

        }


        if(modalElement.classList.contains('show')) {

          AutomatorGaleriaUploadsPrepareModal(file);

        } else {

          AutomatorGaleriaUploadsOpenModal(file);

        }


      }

    );


    [
      'dragenter',
      'dragover',
      'dragleave',
      'drop',
    ].forEach(

      function(eventName) {


        dropzone.addEventListener(

          eventName,

          function(event) {

            event.preventDefault();

            event.stopPropagation();

          }

        );


      }

    );


    dropzone.addEventListener(

      'dragenter',

      function() {


        if(state.uploading === true) {

          return;

        }


        state.dragCounter++;

        dropzone.classList.add(

          'automator-galeria-uploads-drag-active'

        );


      }

    );


    dropzone.addEventListener(

      'dragover',

      function(event) {


        if(event.dataTransfer) {

          event.dataTransfer.dropEffect = 'copy';

        }


      }

    );


    dropzone.addEventListener(

      'dragleave',

      function() {


        state.dragCounter = Math.max(

          0,

          state.dragCounter - 1

        );


        if(state.dragCounter <= 0) {

          dropzone.classList.remove(

            'automator-galeria-uploads-drag-active'

          );

        }


      }

    );


    dropzone.addEventListener(

      'drop',

      function(event) {


        state.dragCounter = 0;

        dropzone.classList.remove(

          'automator-galeria-uploads-drag-active'

        );


        if(state.uploading === true) {

          return;

        }


        var files = event.dataTransfer

          ? event.dataTransfer.files

          : null;


        var file = files && files.length >= 1

          ? files[0]

          : null;


        if(file) {

          AutomatorGaleriaUploadsOpenModal(file);

        }


      }

    );


    uploadForm.addEventListener(

      'submit',

      function(event) {


        event.preventDefault();

        event.stopPropagation();

        event.stopImmediatePropagation();


        AutomatorGaleriaUploadsSubmit(uploadForm);


        return false;


      },

      true

    );


    document.querySelectorAll(

      '.automator-galeria-upload-close, .automator-galeria-upload-cancel'

    ).forEach(

      function(button) {


        button.addEventListener(

          'click',

          function(event) {


            event.preventDefault();

            AutomatorGaleriaUploadsCloseModal(false);


          }

        );


      }

    );


    modalElement.addEventListener(

      'hide.bs.modal',

      function(event) {


        if(

          state.uploading === true &&

          state.hidingForUpload !== true

        ) {

          event.preventDefault();

          return false;

        }


      }

    );


    modalElement.addEventListener(

      'shown.bs.modal',

      function() {


        AutomatorPageLoader(

          'hide',

          function() {


            if(state.restoringAfterError === true) {

              state.restoringAfterError = false;

              state.hidingForUpload = false;

              return;

            }


            var titleInput = document.getElementById(

              'automator-galeria-upload-title'

            );


            if(titleInput) {

              titleInput.focus();

              titleInput.select();

            }


          },

          150

        );


      }

    );


    modalElement.addEventListener(

      'hidden.bs.modal',

      function() {


        if(state.hidingForUpload === true) {

          return;

        }


        AutomatorGaleriaUploadsSetUnsavedWarning(false);

        AutomatorGaleriaUploadsResetUploadForm();

        state.modal = null;


        if(typeof window.AutomatorSetActionStatus === 'function') {

          AutomatorSetActionStatus(false);

        }


      }

    );


    if(viewModalElement) {


      /*
      |--------------------------------------------------------------------------
      | Tentativa de fechamento
      |--------------------------------------------------------------------------
      */

      viewModalElement.addEventListener(

        'hide.bs.modal',

        function(event) {


          /*
          |--------------------------------------------------------------------------
          | Ocultação necessária para realizar o submit
          |--------------------------------------------------------------------------
          */

          if(state.viewHidingForSubmit === true) {

            return;

          }


          /*
          |--------------------------------------------------------------------------
          | Atualização em andamento
          |--------------------------------------------------------------------------
          */

          if(state.viewUpdating === true) {


            event.preventDefault();

            return false;


          }


          /*
          |--------------------------------------------------------------------------
          | Alterações não salvas
          |--------------------------------------------------------------------------
          */

          if(

            AutomatorGaleriaUploadsViewHasChanges() ===

            true

          ) {


            var confirmClose = window.confirm(

              'Existem alterações não salvas. Deseja realmente fechar este modal e perder as alterações?'

            );


            if(confirmClose !== true) {


              event.preventDefault();

              return false;


            }


            AutomatorGaleriaUploadsSetViewUnsavedWarning(

              false

            );


          }


        }

      );


      /*
      |--------------------------------------------------------------------------
      | Modal exibido
      |--------------------------------------------------------------------------
      */

      viewModalElement.addEventListener(

        'shown.bs.modal',

        function() {


          /*
          |--------------------------------------------------------------------------
          | A restauração após erro possui seu próprio callback
          |--------------------------------------------------------------------------
          */

          if(state.viewRestoringAfterError === true) {

            return;

          }


          if(

            typeof window.AutomatorPageLoader ===

            'function'

          ) {


            AutomatorPageLoader(

              'hide',

              function() {


                if(

                  typeof window.AutomatorSetActionStatus ===

                  'function'

                ) {


                  AutomatorSetActionStatus(

                    false

                  );


                }


              },

              150

            );


          }


        }

      );


      /*
      |--------------------------------------------------------------------------
      | Modal completamente ocultado
      |--------------------------------------------------------------------------
      */

      viewModalElement.addEventListener(

        'hidden.bs.modal',

        function() {


          /*
          |--------------------------------------------------------------------------
          | Ocultado somente para executar o POST
          |--------------------------------------------------------------------------
          |
          | Nenhum campo pode ser resetado neste momento.
          |
          */

          if(state.viewHidingForSubmit === true) {

            return;

          }


          /*
          |--------------------------------------------------------------------------
          | Fechamento normal realizado pelo usuário
          |--------------------------------------------------------------------------
          */

          AutomatorGaleriaUploadsSetViewUnsavedWarning(

            false

          );


          AutomatorGaleriaUploadsResetViewModal();


        }

      );


    }


    var viewTitleInput = document.getElementById(

      'automator-galeria-view-title'

    );


    if(viewTitleInput) {


      viewTitleInput.addEventListener(

        'input',

        function() {


          this.setCustomValidity('');


          AutomatorGaleriaUploadsUpdateViewChangedState();


        }

      );


      AutomatorGaleriaUploadsUpdateViewSaveButtonState(

        true

      );


    }


    if(viewForm) {


      viewForm.addEventListener(

        'submit',

        function(event) {


          event.preventDefault();

          event.stopPropagation();

          event.stopImmediatePropagation();


          AutomatorGaleriaUploadsSubmitViewUpdate(viewForm);


          return false;


        },

        true

      );


    }


    AutomatorGaleriaUploadsUpdateSelectionMode();


    if(typeof window.AutomatorInitBootstrapTooltips === 'function') {

      AutomatorInitBootstrapTooltips(wrapper);

    }


    return true;


  }


  if(document.readyState === 'loading') {


    document.addEventListener(

      'DOMContentLoaded',

      AutomatorGaleriaUploadsInitialize

    );


  } else {

    AutomatorGaleriaUploadsInitialize();

  }

  /*
  |--------------------------------------------------------------------------
  | Inicialização dos tooltips dos títulos
  |--------------------------------------------------------------------------
  */

  if(

    document.readyState ===

    'loading'

  ) {


    document.addEventListener(

      'DOMContentLoaded',

      AutomatorGaleriaUploadsInitializeTitleTooltips

    );


  } else {


    AutomatorGaleriaUploadsInitializeTitleTooltips();


  }

</script>