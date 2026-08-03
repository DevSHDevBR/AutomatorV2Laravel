@if($render == 'formulario')

  @php

    $placeholder = $props['placeholder'] ?? $config['placeholder'] ?? $field_label;

    $options = [];

    $selectedValue = $field_value;


    if(!is_array($selectedValue)) {

      if($selectedValue === null || $selectedValue === '') {

        $selectedValue = [];

      } else {

        $decodedSelectedValue = json_decode($selectedValue, true);

        if(json_last_error() === JSON_ERROR_NONE && is_array($decodedSelectedValue)) {

          $selectedValue = $decodedSelectedValue;

        } else {

          $selectedValue = explode(',', $selectedValue);

        }

      }

    }


    $selectedValue = array_map('strval', $selectedValue);


    if( ( isset($props['relation']) ) && ( is_array($props['relation']) ) ) {

      $relation = $props['relation'];

      $optionsItems = SysAutomator::SysAutomatorPreperRelationFieldOptionsData($relation);

      if($optionsItems !== null) {

        foreach($optionsItems as $optionItem) {

          $optionItem = ( (array) $optionItem );

          if(isset($optionItem[$relation['value']]) && isset($optionItem[$relation['label']])) {

            if(!array_key_exists($optionItem[$relation['value']], $options)) {

              $options[$optionItem[$relation['value']]] = [
                'label' => $optionItem[$relation['label']],
              ];

            }

          }

        }

      }
    
    }


    $relationType = $props['type'] ?? 'checkbox';

  @endphp

  <div class="mb-3 {{ $props['wrapper_class'] ?? '' }}">

    @if($relationType != 'select')
    
      <div class="fs-4 mb-3">{!! $placeholder !!}</div>

      @if(isset($props['container']) && is_array($props['container']))
        
        @if(isset($props['container']['element']) && ($props['container']['element'] != ''))
          
          @php $conta = 0; @endphp

          @foreach($options as $optionValue => $optionLabel)

            @php

              $inputID = $field_id . '-' . $optionValue;

              $isChecked = in_array((string) $optionValue, $selectedValue);

            @endphp

            <{!! $props['container']['element'] !!} class="form-check btn btn-outline-dark mb-2 mr-2 {!! $props['container']['class'] ?? '' !!}">

              <input
                id="{{ $inputID }}"
                type="{!! $relationType !!}"
                name="{!! ( ($relationType == 'checkbox') ? $field_name . '[]' : $field_name ) !!}"
                value="{!! $optionValue !!}"
                class="form-check-input {{ $field_class }}"
                data-automator-field="true"
                data-automator-field-name="{{ $field_name }}"
                data-automator-field-id="{{ $field_id }}"
                {{ $field_required ? 'required' : '' }}
                {{ $isChecked ? 'checked' : '' }}
                {!! $field_attrs !!}
              />

              <label class="form-check-label" for="{{ $inputID }}">{!! $optionLabel['label'] !!}</label>
            
            </{!! $props['container']['element'] !!}>

            @php $conta++; @endphp

          @endforeach

        @endif

      @endif

    @endif

  </div>


@elseif($render == 'paginacao')

  

@endif
