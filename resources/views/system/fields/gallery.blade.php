@if($render == 'formulario')
  


  @php

    $canUpload = $props['canUpload'] 
      ?? $config['canUpload'] 
      ?? false;

  @endphp
  <div class="mb-3 {!! $props['wrapper_class'] !!}">
    
    <input type="hidden"
      id="{{ $field_id }}"
      name="{{ $field_name }}"
      value="{!! SysAutomator::SysAutomatorResolveSysFunctionsValue($field_value) !!}"
      class="{{ $field_class }}"
      data-automator-field="true"
      data-automator-field-name="{{ $field_name }}"
      data-automator-field-id="{{ $field_id }}"
      {!! $field_attrs !!} />

    <label class="form-label">

      {!! $field_label !!}

      @if($field_required)
        <span class="text-danger">*</span>
      @endif

      @if(isset($props['help']) && $props['help'] != '')

        <span class="ms-2 fa fa-info"></span>

      @endif

    </label>

  </div>

@elseif($render == 'paginacao')

  @if($columnType == 'thead')

    

  @elseif($columnType == 'tbody')

    

  @endif

@endif