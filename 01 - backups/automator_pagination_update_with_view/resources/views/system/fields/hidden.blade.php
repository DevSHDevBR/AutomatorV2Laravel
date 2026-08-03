@if($render == 'formulario')

  <input type="hidden"
    id="{{ $field_id }}"
    name="{{ $field_name }}"
    value="{{ $field_value }}"
    class="{{ $field_class }}"
    data-automator-field="true"
    data-automator-field-name="{{ $field_name }}"
    data-automator-field-id="{{ $field_id }}"
    {!! $field_attrs !!} />

@elseif($render == 'paginacao')

  @if($columnType == 'thead')

    

  @elseif($columnType == 'tbody')

    

  @endif

@endif