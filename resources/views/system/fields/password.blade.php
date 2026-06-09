@if($render == 'formulario')
  
  @php

    $placeholder = $props['placeholder'] 
      ?? $config['placeholder'] 
      ?? $field_label;

  @endphp
  <div class="mb-3 {{ $props['wrapper_class'] ?? '' }}">

    @if(isset($props['help']) && $props['help'] != '')

      <div class="input-group">

    @else

      @if(isset($props['hasButton']) && $props['hasButton'] != false)

        <div class="input-group">

      @endif

    @endif

      <div class="form-floating">

        <input type="text"
          id="{{ $field_id }}"
          name="{{ $field_name }}"
          value=""
          class="form-control automator-input-password {{ $field_class }}"
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

        <span class="input-group-text"><i class="fa fa-info"></i></span>
        @if(isset($props['hasButton']) && $props['hasButton'] != false)

          <span class="input-group-text p-0 text-center" style="min-width: 50px;">
      
            <button type="button" class="h-100 w-100 border-0" data-bs-toggle="tooltip" data-show="Exibir senha" data-hide="Ocultar senha" onclick="AutomatorPasswordInputBTN(this, '{{ $field_id }}')" data-bs-title="Exibir senha"><i class="fa fa-eye"></i></button>
          
          </span>

        @endif

      </div>

    @else

      @if(isset($props['hasButton']) && $props['hasButton'] != false)

          <span class="input-group-text p-0 text-center" style="min-width: 50px;">
      
            <button type="button" class="h-100 w-100 border-0" data-bs-toggle="tooltip" data-show="Exibir senha" data-hide="Ocultar senha" onclick="AutomatorPasswordInputBTN(this, '{{ $field_id }}')" data-bs-title="Exibir senha"><i class="fa fa-eye"></i></button>
          
          </span>

        </div>

      @endif

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