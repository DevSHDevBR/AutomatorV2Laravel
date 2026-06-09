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
        'tooltip'  => null,
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

          if(isset($filterProps['tooltip']) && $filterProps['tooltip'] != '') {

            $filterData['tooltip'] = [
              "title" => $filterProps['tooltip']
            ];

          }

        }

      }

      return $filterData;

    };


    if( ( isset($props['relation']) ) && ( is_array($props['relation']) ) ) {

      $relation = $props['relation'];


      /*
      |--------------------------------------------------------------------------
      | Suporte a label como array
      |--------------------------------------------------------------------------
      |
      | Quando "label" for um array com as chaves "table", "value" e "display",
      | é feita uma segunda query para buscar o valor de exibição real.
      |
      | IMPORTANTE: antes de chamar SysAutomatorPreperRelationFieldOptionsData,
      | substituímos o label array por uma string temporária (o próprio "value"),
      | pois a função interna usa stripos() e não aceita array.
      | O lookup real é feito depois, com o mapa construído abaixo.
      |
      */

      $labelIsArray   = isset($relation['label']) && is_array($relation['label']);
      $labelLookupMap = [];
      $relationForQuery = $relation;

      if($labelIsArray) {

        $labelConfig = $relation['label'];

        $labelTableOk   = isset($labelConfig['table'])   && $labelConfig['table']   != '';
        $labelValueOk   = isset($labelConfig['value'])   && $labelConfig['value']   != '';
        $labelDisplayOk = isset($labelConfig['display']) && $labelConfig['display'] != '';

        /*
        | Substitui o label array por uma string segura para a query principal.
        | Usamos o próprio campo "value" da relation como label temporário,
        | assim a função interna não quebra.
        */
        $relationForQuery['label'] = $relation['value'];

        if($labelTableOk && $labelValueOk && $labelDisplayOk) {

          $labelRows = \Illuminate\Support\Facades\DB::table($labelConfig['table'])
            ->select($labelConfig['value'], $labelConfig['display'])
            ->get();

          foreach($labelRows as $labelRow) {

            $labelRow = (array) $labelRow;

            $mapKey   = (string) ($labelRow[ $labelConfig['value']   ] ?? '');
            $mapValue =          ($labelRow[ $labelConfig['display'] ] ?? '');

            if($mapKey !== '') {

              $labelLookupMap[$mapKey] = $mapValue;

            }

          }

        }

      }


      $optionsItems = SysAutomator::SysAutomatorPreperRelationFieldOptionsData($relationForQuery);


      if($optionsItems !== null) {

        foreach($optionsItems as $optionItem) {

          $optionItem = ( (array) $optionItem );

          if(isset($optionItem[$relation['value']])) {

            $optionValue = $optionItem[$relation['value']];

            /*
            |--------------------------------------------------------------
            | Resolve o label de exibição
            |--------------------------------------------------------------
            |
            | Se label for array: usa o mapa construído acima (labelLookupMap)
            | para encontrar o display correto pelo value do item.
            | Se label for string: usa a coluna diretamente (comportamento original).
            |
            */

            if($labelIsArray) {

              $optionDisplayLabel = $labelLookupMap[(string) $optionValue] ?? $optionValue;

            } else {

              $optionDisplayLabel = isset($optionItem[$relation['label']]) ? $optionItem[$relation['label']] : $optionValue;

            }

            $filterData = $automatorRelationBuildFilterData($optionItem, $relation['filters'] ?? []);

            if($filterData['remove'] == true) {

              continue;

            }

            if(!array_key_exists($optionValue, $options)) {

              $options[$optionValue] = [
                'label'    => $optionDisplayLabel,
                'tooltip'  => $filterData['tooltip'],
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

    @if($relationType == 'checkbox')
    
      <div class="fs-5 mb-3">{!! $placeholder !!}</div>

      @if(isset($props['container']) && is_array($props['container']))
        
        @if(isset($props['container']['element']) && ($props['container']['element'] != ''))
          
          @php $conta = 0; @endphp

          @foreach($options as $optionValue => $optionLabel)

            @php

              $inputID = $field_id . '-' . $optionValue;

              $optionDisabled = isset($optionLabel['disabled']) && $optionLabel['disabled'] == true;


              $inputName = ( ($optionDisabled == true) ? '' : ( ($relationType == 'checkbox') ? $field_name . '[]' : $field_name ) );

              $isChecked = in_array((string) $optionValue, $selectedValue);

              $optionInputClass = trim('btn-check' . ( ($field_class != '') ? ' ' . $field_class : '' ) . '' . ($props['container']['class'] ?? '') . ' ' . ($optionLabel['class'] ?? ''));

              $isDisabledByClass = false;

              if(isset($optionInputClass) && str_contains(' ' . $optionInputClass . ' ', ' disabled ')) {
                $isDisabledByClass = true;
              }

              if($isDisabledByClass == true) {
                $optionInputClass = trim(str_replace('disabled', 'automator-disabled-selection', $optionInputClass));
              }


              $optionReadonly = isset($optionLabel['readonly']) && $optionLabel['readonly'] == true;
              
              $optionTooltip = ( ( isset($optionLabel['tooltip']) ) ? ( ( is_array($optionLabel['tooltip']) ) ? $optionLabel['tooltip'] : ( ($optionLabel['tooltip'] != '') ? $optionLabel['tooltip'] : null ) ) : null );
              $tooltip = '';
              if($optionTooltip != null) {
                $tooltip = ' data-bs-toggle="tooltip" data-bs-title="' . $optionTooltip['title'] . '"';
              }

            @endphp

              <input
                id="{{ $inputID }}"
                type="{!! $relationType !!}"
                name="{!! $inputName !!}"
                value="{!! $optionValue !!}"
                class="{{ $optionInputClass }}"
                data-automator-relation-disabled="{{ $isDisabledByClass ? 'true' : 'false' }}"
                data-automator-field="true"
                data-automator-field-name="{{ $field_name }}"
                data-automator-field-id="{{ $inputID }}"
                {{ $field_required ? 'required' : '' }}
                {{ $isChecked ? 'checked' : '' }}
                {{ $optionReadonly ? 'readonly' : '' }}
                {!! $field_attrs !!}
              />

              <label class="btn btn-outline-secondary mb-2 mr-2 {{ $isDisabledByClass ? 'automator-disabled-selection-label' : '' }}" for="{{ $inputID }}" {!! $tooltip !!}>{!! $optionLabel['label'] !!}</label>
            

            @php $conta++; @endphp

          @endforeach

        @endif

      @endif

    @endif

  </div>


@elseif($render == 'paginacao')

  @if($columnType == 'thead')

    <!-- <th scope="col" class="{{ $column['header']['class'] ?? ($column['header']['classes'] ?? '') }}"> -->
      {!! SysAutomator::SysAutomatorGetTranslateWord($column_label) !!}
    <!-- </th> -->

  @elseif($columnType == 'tbody')

    @php

      $props = ( ($column['tbl_sys_paginations_col_props'] != "") ? ( (is_array($column['tbl_sys_paginations_col_props'])) ? $column['tbl_sys_paginations_col_props'] : ( (array) json_decode($column['tbl_sys_paginations_col_props'], true) ) ) : [] );
      if(count($props) >= 1) {

        $_props = [

          'type'     => ( (isset($props['type']))     ? $props['type']     : 'single' ),
          'mode'     => ( (isset($props['mode']))     ? $props['mode']     : 'normal' ),
          'empty'    => ( (isset($props['empty']))    ? $props['empty']    : $column_value ),
          'table'    => ( (isset($props['table']))    ? $props['table']    : '' ),
          'column'   => ( (isset($props['column']))   ? $props['column']   : '' ),
          'display'  => ( (isset($props['display']))  ? $props['display']  : null ),
          'nullable' => ( (isset($props['nullable'])) ? $props['nullable'] : true ),

        ];

        if(($_props['table'] != '') && ($_props['column'] != '') ) {

          $column_value = SysAutomator::SysAutomatorGetRelationValues($_props, $column_value);

        } else {

          if($_props['nullable'] == true) {

            if($_props['display'] != '') {

              $column_value = $_props['display'];

            }

          }

        }

      }

    @endphp
    <td class="{{ $column['body']['class'] ?? ($column['body']['classes'] ?? '') }}">
      {!! $column_value !!}
    </td>

  @endif

@endif