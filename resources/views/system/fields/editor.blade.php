@if($render == 'formulario')

  @php

    $placeholder = $props['placeholder'] 
      ?? $config['placeholder'] 
      ?? $field_label;

  @endphp

  <div class="mb-3 {{ $props['wrapper_class'] ?? '' }}">

    @if($field_label != '')

      <label for="{{ $field_id }}" class="form-label fw-bold text-uppercase small mb-1">

        {{ $field_label }}

        @if($field_required)
          <span class="text-danger">*</span>
        @endif

      </label>

    @endif
    <textarea
      id="{{ $field_id }}"
      name="{{ $field_name }}"
      class="automator-editor"
      data-height="200"
      placeholder="{!! $placeholder !!}"
      data-placeholder="{!! $placeholder !!}"
      data-automator-field="true"
      data-automator-field-name="{{ $field_name }}"
      data-automator-field-id="{{ $field_id }}"
      {{ $field_required ? 'required' : '' }}
      {!! $field_attrs !!}>{!! $field_value !!}</textarea>


    @if(isset($props['help']) && $props['help'] != '')

      <div class="form-text">
        {{ $props['help'] }}
      </div>

    @endif

  </div>

@elseif($render == 'paginacao')

  @if($columnType == 'thead')

    <!-- <th scope="col" class="{{ $column['header']['class'] ?? ($column['header']['classes'] ?? '') }}"> -->
      {{ $column_label }}
    <!-- </th> -->

  @elseif($columnType == 'tbody')

    <td class="{{ $column['body']['class'] ?? ($column['body']['classes'] ?? '') }}">
      {!! $column_value !!}
    </td>

  @endif

@endif