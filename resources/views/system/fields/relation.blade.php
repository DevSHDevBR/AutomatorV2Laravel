@if($render == 'formulario')

  @php

    $props = SysAutomator::SysAutomatorNormalizeRelationFieldProps($props);

    
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

    $relationType = $props['type'] ?? 'select';

    if(!in_array($relationType, ['select', 'checkbox', 'radio', 'hidden'])) {

      $relationType = 'select';

    }


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
              'title' => $filterProps['tooltip']
            ];

          }

        }

      }

      return $filterData;

    };


    if(isset($props['relation']) && is_array($props['relation'])) {

      $relation = $props['relation'];

      $relationTable = $relation['table'] ?? '';
      $relationValue = $relation['value'] ?? '';
      $relationLabel = $relation['label'] ?? '';

      if($relationTable != '' && $relationValue != '' && $relationLabel != '') {

        $relationForQuery = $relation;

        $labelIsArray = is_array($relationLabel);

        $labelLookupMap = [];

        if($labelIsArray) {

          $labelConfig = $relationLabel;

          $relationForQuery['label'] = $relationValue;

          if(
            isset($labelConfig['table']) &&
            isset($labelConfig['value']) &&
            isset($labelConfig['display']) &&
            $labelConfig['table'] != '' &&
            $labelConfig['value'] != '' &&
            $labelConfig['display'] != ''
          ) {

            $labelRows = \Illuminate\Support\Facades\DB::table($labelConfig['table'])
              ->select($labelConfig['value'], $labelConfig['display'])
              ->get();

            foreach($labelRows as $labelRow) {

              $labelRow = (array) $labelRow;

              $mapKey = (string) ($labelRow[$labelConfig['value']] ?? '');

              $mapValue = $labelRow[$labelConfig['display']] ?? '';

              if($mapKey !== '') {

                $labelLookupMap[$mapKey] = $mapValue;

              }

            }

          }

        }


        $optionsItems = SysAutomator::SysAutomatorPreperRelationFieldOptionsData($relationForQuery);


        if($optionsItems !== null) {

          foreach($optionsItems as $optionItem) {

            $optionItem = (array) $optionItem;

            if(isset($optionItem[$relationValue])) {

              $optionValue = $optionItem[$relationValue];

              if($labelIsArray) {

                $optionDisplayLabel = $labelLookupMap[(string) $optionValue] ?? $optionValue;

              } else {

                $optionDisplayLabel = $optionItem[$relationLabel] ?? $optionValue;

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

    }

  @endphp
  
  @if($relationType == 'hidden')

    <input
      
      type="hidden"
      id="{{ $field_id }}"
      name="{{ $field_name }}"
      data-automator-field="true"
      data-automator-field-name="{{ $field_name }}"
      data-automator-field-id="{{ $field_id }}"
      {{ $field_required ? 'required' : '' }}
      {!! $field_attrs !!}

    />

  @else
    <div class="mb-3 {{ $props['wrapper_class'] ?? 'col-12' }}">

      @if($relationType == 'select')

        <div class="form-floating">

          <select
            id="{{ $field_id }}"
            name="{{ $field_name }}"
            class="form-select {{ $field_class }}"
            data-automator-field="true"
            data-automator-field-name="{{ $field_name }}"
            data-automator-field-id="{{ $field_id }}"
            {{ $field_required ? 'required' : '' }}
            {!! $field_attrs !!}
          >

            @if(
              isset($props['has_empty']) &&
              (
                $props['has_empty'] === true ||
                $props['has_empty'] === 1 ||
                $props['has_empty'] === '1' ||
                $props['has_empty'] === 'true'
              )
            )

              <option value="">
                {{ $props['empty_value'] ?? $props['empty_text'] ?? 'Selecione uma opção' }}
              </option>

            @endif

            @foreach($options as $optionValue => $optionData)

              <option
                value="{{ $optionValue }}"
                {{ in_array((string) $optionValue, $selectedValue) ? 'selected' : '' }}
                {{ isset($optionData['disabled']) && $optionData['disabled'] ? 'disabled' : '' }}
              >
                {{ $optionData['label'] }}
              </option>

            @endforeach

          </select>

          <label for="{{ $field_id }}">
            {!! $placeholder !!}
            {!! $field_required ? '<span class="text-danger">*</span>' : '' !!}
          </label>

        </div>

      @elseif($relationType == 'checkbox' || $relationType == 'radio')

        @if($placeholder != '')
          <div class="fs-5 mb-3">
            {!! $placeholder !!}
            {!! $field_required ? '<span class="text-danger">*</span>' : '' !!}
          </div>
        @endif

        @foreach($options as $optionValue => $optionData)

          @php

            $inputID = $field_id . '-' . $optionValue;

            $optionDisabled = isset($optionData['disabled']) && $optionData['disabled'] == true;

            $inputName = $optionDisabled
              ? ''
              : (($relationType == 'checkbox') ? $field_name . '[]' : $field_name);

            $isChecked = in_array((string) $optionValue, $selectedValue);

            $optionInputClass = trim(
              'btn-check ' .
              (($field_class != '') ? $field_class . ' ' : '') .
              ($props['container']['class'] ?? '') . ' ' .
              ($optionData['class'] ?? '')
            );

            $isDisabledByClass = false;

            if(isset($optionInputClass) && str_contains(' ' . $optionInputClass . ' ', ' disabled ')) {

              $isDisabledByClass = true;

            }

            if($isDisabledByClass == true) {

              $optionInputClass = trim(str_replace('disabled', 'automator-disabled-selection', $optionInputClass));

            }

            $optionReadonly = isset($optionData['readonly']) && $optionData['readonly'] == true;

            $optionTooltip = isset($optionData['tooltip'])
              ? (
                is_array($optionData['tooltip'])
                  ? $optionData['tooltip']
                  : (($optionData['tooltip'] != '') ? ['title' => $optionData['tooltip']] : null)
              )
              : null;

            $tooltip = '';

            if($optionTooltip != null && isset($optionTooltip['title'])) {

              $tooltip = ' data-bs-toggle="tooltip" data-bs-title="' . e($optionTooltip['title']) . '"';

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

          <label
            class="btn btn-outline-secondary mb-2 me-2 {{ $isDisabledByClass ? 'automator-disabled-selection-label' : '' }}"
            for="{{ $inputID }}"
            {!! $tooltip !!}
          >
            {!! $optionData['label'] !!}
          </label>

        @endforeach

      @endif

    </div>
  @endif


@elseif($render == 'paginacao')

  @if($columnType == 'thead')

    {!! SysAutomator::SysAutomatorGetTranslateWord($column_label) !!}

  @elseif($columnType == 'tbody')

    @php

      $props = (($column['tbl_sys_paginations_col_props'] != "")
        ? (
          is_array($column['tbl_sys_paginations_col_props'])
            ? $column['tbl_sys_paginations_col_props']
            : ((array) json_decode($column['tbl_sys_paginations_col_props'], true))
        )
        : []
      );

      if(count($props) >= 1) {

        $_props = [

          'type'     => ((isset($props['type']))     ? $props['type']     : 'single'),
          'mode'     => ((isset($props['mode']))     ? $props['mode']     : 'normal'),
          'empty'    => ((isset($props['empty']))    ? $props['empty']    : $column_value),
          'table'    => ((isset($props['table']))    ? $props['table']    : ''),
          'column'   => ((isset($props['column']))   ? $props['column']   : ''),
          'display'  => ((isset($props['display']))  ? $props['display']  : null),
          'nullable' => ((isset($props['nullable'])) ? $props['nullable'] : true),

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


