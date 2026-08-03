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


    $relationType = $props['type'] ?? 'checkbox';


    $automatorRelationIsTruthy = function($value) {

      return (
        $value === true ||
        $value === 1 ||
        $value === '1' ||
        $value === 'true' ||
        $value === 'TRUE' ||
        $value === 'sim' ||
        $value === 'SIM'
      );

    };


    $automatorRelationGetItemValue = function($item, $key, $default = null) {

      if(is_array($item)) {

        return $item[$key] ?? $default;

      }

      if(is_object($item)) {

        return $item->$key ?? $default;

      }

      return $default;

    };


    $automatorRelationBuildFilterData = function($optionItem, $filters) use ($automatorRelationIsTruthy, $automatorRelationGetItemValue) {

      $filterData = [
        'class'    => '',
        'remove'   => false,
        'disabled' => false,
        'readonly' => false,
      ];

      if(!is_array($filters) || count($filters) <= 0) {

        return $filterData;

      }

      foreach($filters as $columnName => $columnFilters) {

        if(!is_array($columnFilters)) {

          continue;

        }

        $itemColumnValue = $automatorRelationGetItemValue($optionItem, $columnName, null);

        if($itemColumnValue === null) {

          continue;

        }

        foreach($columnFilters as $filterValue => $filterProps) {

          if((string) $itemColumnValue !== (string) $filterValue) {

            continue;

          }

          if(!is_array($filterProps)) {

            continue;

          }

          if(isset($filterProps['class']) && $filterProps['class'] != '') {

            $filterData['class'] = trim($filterData['class'] . ' ' . $filterProps['class']);

          }

          if(isset($filterProps['remove']) && $automatorRelationIsTruthy($filterProps['remove'])) {

            $filterData['remove'] = true;

          }

          if(isset($filterProps['disabled']) && $automatorRelationIsTruthy($filterProps['disabled'])) {

            $filterData['disabled'] = true;

          }

          if(isset($filterProps['readonly']) && $automatorRelationIsTruthy($filterProps['readonly'])) {

            $filterData['readonly'] = true;

          }

        }

      }

      return $filterData;

    };


    if( ( isset($props['relation']) ) && ( is_array($props['relation']) ) ) {

      $relation = $props['relation'];

      $optionsItems = SysAutomator::SysAutomatorPreperRelationFieldOptionsData($relation);

      if($optionsItems !== null) {

        foreach($optionsItems as $optionItem) {

          $optionItem = ( (array) $optionItem );

          if(isset($optionItem[$relation['value']]) && isset($optionItem[$relation['label']])) {

            $optionValue = $optionItem[$relation['value']];

            $filterData = $automatorRelationBuildFilterData($optionItem, $relation['filters'] ?? []);

            if($filterData['remove'] == true) {

              continue;

            }

            if(!array_key_exists($optionValue, $options)) {

              $options[$optionValue] = [
                'label'    => $optionItem[$relation['label']],
                'class'    => $filterData['class'],
                'disabled' => $filterData['disabled'],
                'readonly' => $filterData['readonly'],
              ];

            }

          }

        }

      }
    
    }

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

              $optionInputClass = trim('btn-check ' . $field_class . ' ' . ($props['container']['class'] ?? '') . ' ' . ($optionLabel['class'] ?? ''));

              $optionDisabled = isset($optionLabel['disabled']) && $optionLabel['disabled'] == true;

              $optionReadonly = isset($optionLabel['readonly']) && $optionLabel['readonly'] == true;

            @endphp


              <input
                id="{{ $inputID }}"
                type="{!! $relationType !!}"
                name="{!! ( ($relationType == 'checkbox') ? $field_name . '[]' : $field_name ) !!}"
                value="{!! $optionValue !!}"
                class="{{ $optionInputClass }}"
                data-automator-field="true"
                data-automator-field-name="{{ $field_name }}"
                data-automator-field-id="{{ $field_id }}"
                {{ $field_required ? 'required' : '' }}
                {{ $isChecked ? 'checked' : '' }}
                {{ $optionDisabled ? 'disabled' : '' }}
                {{ $optionReadonly ? 'readonly' : '' }}
                {!! $field_attrs !!}
              />

              <label class="btn btn-outline-secondary mb-2 mr-2" for="{{ $inputID }}">{!! $optionLabel['label'] !!}</label>
            

            @php $conta++; @endphp

          @endforeach

        @endif

      @endif

    @endif

  </div>


@elseif($render == 'paginacao')

  

@endif
