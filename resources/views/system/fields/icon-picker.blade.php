@if($render == 'formulario')
  
  @php

    $placeholder = $props['placeholder'] 
      ?? $config['placeholder'] 
      ?? $field_label;

    /*
    |--------------------------------------------------------------------------
    | Valor inicial
    |--------------------------------------------------------------------------
    |
    | Normalmente, durante a edição, o valor também pode ser preenchido pelo
    | JavaScript responsável por carregar os dados do registro.
    |
    | Esta resolução mantém suporte para situações em que o valor já seja
    | informado diretamente durante a renderização da Blade.
    |
    */

    $field_value = $field_value
      ?? $props['value']
      ?? $config['value']
      ?? '';

  @endphp

  <div class="mb-3 {{ $props['wrapper_class'] ?? '' }}">

    <div
      class="input-group"
      data-automator-icon-picker-wrapper="true">

      {{--
      |--------------------------------------------------------------------------
      | Valor real do campo
      |--------------------------------------------------------------------------
      |
      | Este é o campo oficial do formulário.
      |
      | O name, required, disabled, readonly e demais atributos configurados
      | pertencem a este input, e não ao campo de pesquisa.
      |
      | O atributo required em inputs hidden não é processado nativamente pelo
      | navegador. Por esse motivo, o JavaScript do componente utiliza também
      | data-automator-icon-picker-required para aplicar a validação no campo
      | visível sem alterar o valor enviado pelo formulário.
      |
      --}}

      <input
        type="hidden"
        id="{{ $field_id }}-value"
        name="{{ $field_name }}"
        value="{{ $field_value }}"
        class="automator-input-icon-picker-value"
        data-automator-field="true"
        data-automator-field-name="{{ $field_name }}"
        data-automator-field-id="{{ $field_id }}"
        data-automator-icon-picker-required="{{ $field_required ? 'true' : 'false' }}"
        {{ $field_required ? 'required' : '' }}
        {!! $field_attrs !!} />

      {{--
      |--------------------------------------------------------------------------
      | Pré-visualização
      |--------------------------------------------------------------------------
      --}}

      <span
        id="{{ $field_id }}-icone"
        class="input-group-text p-0 text-center automator-input-icon-picker-preview"
        data-automator-selected-icon=""
        style="min-width: 50px;">

        <i
          class="fa fa-icons mx-auto"
          style="margin-left: auto; margin-right: auto;">
        </i>
      
      </span>

      <div class="form-floating">

        {{--
        |--------------------------------------------------------------------------
        | Campo visível de pesquisa
        |--------------------------------------------------------------------------
        |
        | Este campo não possui name nem required.
        |
        | Ele é usado apenas para:
        |
        | - pesquisar ícones;
        | - receber o foco da validação;
        | - exibir a lista de resultados.
        |
        --}}

        <input
          type="text"
          id="{{ $field_id }}"
          value=""
          class="form-control automator-input-icon-picker {{ $field_class }}"
          placeholder="{!! $placeholder !!}"
          autocomplete="off"
          spellcheck="false"
          role="combobox"
          aria-autocomplete="list"
          aria-expanded="false"
          aria-required="{{ $field_required ? 'true' : 'false' }}"
          data-automator-icon-picker-hidden="{{ $field_id }}-value"
          data-automator-icon-picker-preview="{{ $field_id }}-icone" />

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

        <span class="input-group-text">

          <i class="fa fa-info"></i>

        </span>

      @endif

    </div>

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