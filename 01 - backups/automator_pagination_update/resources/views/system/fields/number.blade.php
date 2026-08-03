@if($render == 'formulario')

  <div class="mb-3 {{ $props['wrapper_class'] ?? '' }}">

    @if($field_label != '')

      <label for="{{ $field_id }}" class="form-label">

        {{ $field_label }}

        @if($field_required)
          <span class="text-danger">*</span>
        @endif

      </label>

    @endif

    <input type="number"
      id="{{ $field_id }}"
      name="{{ $field_name }}"
      value="{{ $field_value }}"
      class="form-control {{ $field_class }}"
      data-automator-field="true"
      data-automator-field-name="{{ $field_name }}"
      data-automator-field-id="{{ $field_id }}"
      {{ $field_required ? 'required' : '' }}
      {!! $field_attrs !!} />

    @if(isset($props['help']) && $props['help'] != '')

      <div class="form-text">
        {{ $props['help'] }}
      </div>

    @endif

  </div>

@elseif($render == 'paginacao')

  @if($columnType == 'thead')

    <th scope="col" class="{{ $column['header']['class'] ?? ($column['header']['classes'] ?? '') }}">
      {{ $column_label }}
    </th>

  @elseif($columnType == 'tbody')

    <td class="{{ $column['body']['class'] ?? ($column['body']['classes'] ?? '') }}">
      {!! $column_value !!}
    </td>

  @endif

@endif