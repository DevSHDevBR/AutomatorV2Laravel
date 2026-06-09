@if($render == 'formulario')

  @php

    /*
    |--------------------------------------------------------------------------
    | Opções do select
    |--------------------------------------------------------------------------
    |
    | Aceita opções vindas de:
    | - $props['options']
    | - $config['options']
    | - $field['options']
    |
    | Formatos aceitos:
    |
    | [
    |   'ativo' => 'Ativo',
    |   'inativo' => 'Inativo'
    | ]
    |
    | ou:
    |
    | [
    |   ['value' => 'ativo', 'label' => 'Ativo'],
    |   ['value' => 'inativo', 'label' => 'Inativo']
    | ]
    |
    */

    $options = [];

    if(isset($props['choices']) && is_array($props['choices'])) {

      $options = $props['choices'];

    } elseif(isset($config['options']) && is_array($config['options'])) {

      $options = $config['options'];

    } elseif(isset($field['options']) && is_array($field['options'])) {

      $options = $field['options'];

    }


    /*
    |--------------------------------------------------------------------------
    | Placeholder
    |--------------------------------------------------------------------------
    */

    $placeholder = $props['placeholder'] 
      ?? $config['placeholder'] 
      ?? 'Selecione uma opção';


    $showPlaceholder = $props['show_placeholder'] 
      ?? $config['show_placeholder'] 
      ?? true;


    /*
    |--------------------------------------------------------------------------
    | Multiple
    |--------------------------------------------------------------------------
    */

    $multiple = $props['multiple'] 
      ?? $config['multiple'] 
      ?? false;


    $multiple = (
      $multiple === true ||
      $multiple === 1 ||
      $multiple === '1' ||
      $multiple === 'true'
    );


    /*
    |--------------------------------------------------------------------------
    | Valor selecionado
    |--------------------------------------------------------------------------
    */

    $selectedValue = $field_value;


    if($multiple && !is_array($selectedValue)) {

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

  @endphp

  <div class="mb-3 {{ $props['wrapper_class'] ?? '' }}">

    <div class="form-floating">

      <select
        id="{{ $field_id }}"
        name="{{ $multiple ? $field_name . '[]' : $field_name }}"
        class="form-select {{ $field_class }}"
        data-automator-field="true"
        data-automator-field-name="{{ $field_name }}"
        data-automator-field-id="{{ $field_id }}"
        {{ $field_required ? 'required' : '' }}
        {{ $multiple ? 'multiple' : '' }}
        {!! $field_attrs !!}>

        @if(!$multiple && $showPlaceholder)

          <option value="" {!! ( ($field_required) ? 'disabled' : '' ) !!}>
            {{ $placeholder }}
          </option>

        @endif

        @foreach($options as $optionKey => $optionData)

          @php

            $optionValue = '';
            $optionLabel = '';
            $optionDisabled = false;

            if(is_array($optionData)) {

              $optionValue = $optionData['value'] ?? $optionKey;
              $optionLabel = $optionData['label'] ?? $optionData['text'] ?? $optionValue;
              $optionDisabled = $optionData['disabled'] ?? false;

            } else {

              $optionValue = $optionKey;
              $optionLabel = $optionData;

            }


            if(is_bool($optionValue)) {

              $optionValue = $optionValue ? 'true' : 'false';

            }


            if(is_bool($selectedValue)) {

              $compareValue = $selectedValue ? 'true' : 'false';

            } else {

              $compareValue = $selectedValue;

            }


            if($multiple) {

              $isSelected = in_array((string) $optionValue, array_map('strval', $selectedValue));

            } else {

              $isSelected = ((string) $compareValue === (string) $optionValue);

            }


            $optionDisabled = (
              $optionDisabled === true ||
              $optionDisabled === 1 ||
              $optionDisabled === '1' ||
              $optionDisabled === 'true'
            );

          @endphp

          <option value="{{ $optionValue }}" {{ $isSelected ? 'selected' : '' }} {{ $optionDisabled ? 'disabled' : '' }}>
            {{ $optionLabel }}
          </option>

        @endforeach

      </select>

      @if($field_label != '')

        <label for="{{ $field_id }}">

          {{ $field_label }}

          @if($field_required)
            <span class="text-danger">*</span>
          @endif

        </label>

      @endif
      
      @if(isset($props['help']) && $props['help'] != '')

        <div class="form-text">
          {{ $props['help'] }}
        </div>

      @endif

    </div>

  </div>

@elseif($render == 'paginacao')

  @if($columnType == 'thead')

    <th scope="col" class="{{ $column['header']['class'] ?? ($column['header']['classes'] ?? '') }}">
      {{ $column_label }}
    </th>

  @elseif($columnType == 'tbody')

    @php

      $options = [];

      var_dump($column);

      if(isset($column['props']['options']) && is_array($column['props']['options'])) {

        $options = $column['props']['options'];

      } elseif(isset($column['config']['options']) && is_array($column['config']['options'])) {

        $options = $column['config']['options'];

      }


      $displayValue = $column_value;


      foreach($options as $optionKey => $optionData) {

        if(is_array($optionData)) {

          $optionValue = $optionData['value'] ?? $optionKey;
          $optionLabel = $optionData['label'] ?? $optionData['text'] ?? $optionValue;

        } else {

          $optionValue = $optionKey;
          $optionLabel = $optionData;

        }


        if(is_bool($optionValue)) {

          $optionValue = $optionValue ? 'true' : 'false';

        }


        if(is_bool($column_value)) {

          $compareValue = $column_value ? 'true' : 'false';

        } else {

          $compareValue = $column_value;

        }


        if((string) $compareValue === (string) $optionValue) {

          $displayValue = $optionLabel;

          break;

        }

      }

    @endphp

    <td class="{{ $column['body']['class'] ?? ($column['body']['classes'] ?? '') }}">
      {!! $displayValue !!}
    </td>

  @endif

@endif