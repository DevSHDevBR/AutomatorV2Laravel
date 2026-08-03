@if($render == 'formulario')
  
  @php

    $placeholder = $props['placeholder'] 
      ?? $config['placeholder'] 
      ?? $field_label;

  @endphp
  <div class="mb-3 {{ $props['wrapper_class'] ?? '' }}">

    @if(isset($props['help']) && $props['help'] != '')

      <div class="input-group">

    @endif

      <div class="form-floating">

        <input type="text"
          id="{{ $field_id }}"
          name="{{ $field_name }}"
          value="{{ $field_value }}"
          class="form-control {{ $field_class }}"
          placeholder="{!! $placeholder !!}"
          data-automator-field="true"
          data-automator-field-name="{{ $field_name }}"
          data-automator-field-id="{{ $field_id }}"
          {{ $field_required ? 'required' : '' }}
          {!! $field_attrs !!} />


        @if($field_label != '')

          <label for="{{ $field_id }}">

            {{ $field_label }}

            @if($field_required)
              <span class="text-danger">*</span>
            @endif

          </label>

        @endif

      </div>

    @if(isset($props['help']) && $props['help'] != '')

        <span class="input-group-text">@</span>

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