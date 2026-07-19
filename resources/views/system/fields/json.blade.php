@if($render == 'formulario')
  
  @php

    $placeholder = $props['placeholder'] 
      ?? $config['placeholder'] 
      ?? $field_label;

    $jsonValue = $field_value;

    if(is_array($jsonValue) || is_object($jsonValue)) {

      $jsonValue = json_encode(

        $jsonValue,

        JSON_UNESCAPED_UNICODE |
        JSON_UNESCAPED_SLASHES

      );

    }

    if($jsonValue === null || $jsonValue === '') {

      $jsonValue = '{}';

    }

    $jsonEditorID = 'automator-json-editor-' . $field_id;

  @endphp

  <div class="mb-3 {{ $props['wrapper_class'] ?? '' }}">

    @if($field_label != '')

      <label
        for="{{ $field_id }}"
        class="form-label fw-semibold"
      >

        {{ $field_label }}

        @if($field_required)

          <span class="text-danger">*</span>

        @endif

      </label>

    @endif

    <div
      id="{{ $jsonEditorID }}"
      class="automator-json-editor border rounded bg-white"
      data-automator-json-editor="true"
      data-automator-json-field-id="{{ $field_id }}"
      data-automator-json-field-name="{{ $field_name }}"
      data-automator-json-required="{{ $field_required ? 'true' : 'false' }}"
    >

      <input
        type="hidden"
        id="{{ $field_id }}"
        name="{{ $field_name }}"
        value="{{ e($jsonValue) }}"
        class="automator-json-editor-value {{ $field_class }}"
        placeholder="{!! $placeholder !!}"
        data-automator-field="true"
        data-automator-field-name="{{ $field_name }}"
        data-automator-field-id="{{ $field_id }}"
        data-automator-json-value="true"
        {{ $field_required ? 'required' : '' }}
        {!! $field_attrs !!}
      />

      <div class="automator-json-editor-toolbar border-bottom p-2">

        <div class="row g-2 align-items-center">

          <div class="col">

            <div class="small text-muted">

              Adicione propriedades e estruturas aninhadas ao documento JSON.

            </div>

          </div>

          <div class="col-auto">

            <button
              type="button"
              class="btn btn-sm btn-outline-secondary automator-json-editor-format"
              title="Formatar JSON"
            >

              <i class="fa fa-code me-1"></i>

              Formatar

            </button>

          </div>

        </div>

      </div>

      <div class="automator-json-editor-content p-2">

        <div class="automator-json-editor-tree"></div>

      </div>

      <div class="automator-json-editor-error alert alert-danger rounded-0 rounded-bottom mb-0 d-none"></div>

    </div>

  </div>

@elseif($render == 'paginacao')

  {{--
  |--------------------------------------------------------------------------
  | Paginação
  |--------------------------------------------------------------------------
  |
  | O editor JSON está disponível somente em formulários nesta etapa.
  | A renderização anterior da paginação é mantida para compatibilidade.
  |
  --}}

  @if($columnType == 'thead')

    {!! SysAutomator::SysAutomatorGetTranslateWord($column_label) !!}

  @elseif($columnType == 'tbody')

    <td class="{{ $column['body']['class'] ?? ($column['body']['classes'] ?? '') }}">

      {!! $column_value !!}

    </td>

  @endif

@endif