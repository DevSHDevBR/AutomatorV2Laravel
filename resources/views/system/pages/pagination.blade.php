@php
  
  $items          = $items ?? collect();
  $columns        = (isset($columns) && is_array($columns)) ? $columns : [];
  $actions        = (isset($actions) && is_array($actions)) ? $actions : [];
  $header_actions = (isset($header_actions) && is_array($header_actions)) ? $header_actions : [];
  $list_actions   = (isset($list_actions) && is_array($list_actions)) ? $list_actions : [];
  $search_fields  = (isset($search_fields) && is_array($search_fields)) ? $search_fields : [];
  $action_urls    = (isset($action_urls) && is_array($action_urls)) ? $action_urls : [];
  $messages       = (isset($messages) && is_array($messages)) ? $messages : [];

  $index          = $index ?? null;
  $table          = $table ?? 'automator';
  $page_name      = $page_name ?? null;
  $canDelete      = false;
  $delRoles       = [];
  $cols           = 0;

  $_defaultSort = ['col' => $index, 'direction' => 'asc'];

  $deleteMessageConfirmDefault = 'Para realizar esta ação é necessário que seja realizado a confirmação de segurança informando sua senha. Esta ação é necessária pois é possivel que algumas informações não poderam ser restauradas depois.';
  $deleteMessageConfirm        = $messages['delete-message-confirm'] ?? $deleteMessageConfirmDefault;
  $deleteMessageConfirm        = SysAutomator::SysAutomatorGetTranslateWord($deleteMessageConfirm);

  $getItemValue = function($item, $key, $default = null) {

    if($key === null || $key === '') {

      return $default;

    }

    if(is_array($item)) {

      return $item[$key] ?? $default;

    }

    if(is_object($item)) {

      return $item->{$key} ?? $default;

    }

    return $default;

  };

  $compareValue = function($itemValue, $operator, $expectedValue) {

    return match($operator) {

      '=='  => $itemValue == $expectedValue,
      '===' => $itemValue === $expectedValue,
      '!='  => $itemValue != $expectedValue,
      '!==' => $itemValue !== $expectedValue,
      '>'   => $itemValue > $expectedValue,
      '>='  => $itemValue >= $expectedValue,
      '<'   => $itemValue < $expectedValue,
      '<='  => $itemValue <= $expectedValue,

      default => false,

    };

  };

  $checkActionRoles = function($item, $roles = []) use ($getItemValue, $compareValue) {

    if(!is_array($roles) || count($roles) <= 0) {

      return true;

    }

    foreach($roles as $role) {

      if(!is_array($role)) {

        continue;

      }

      $roleKey = $role['key'] ?? null;
      $roleArg = $role['compare'] ?? '==';
      $roleVal = $role['value'] ?? null;
      $itemVal = $getItemValue($item, $roleKey);

      if($compareValue($itemVal, $roleArg, $roleVal)) {

        return true;

      }

    }

    return false;

  };

  $renderIcon = function($icon = null) {

    if($icon === null || $icon === '') {

      return '';

    }

    if(str_contains($icon, 'fa-')) {

      return '<i class="' . e($icon) . '"></i> ';

    }

    return '<i class="fa fa-' . e($icon) . '"></i> ';

  };

  $replaceActionVars = function($value, $item = null) use ($index, $getItemValue) {

    if($value === null) {

      return '';

    }

    $value = (string) $value;

    if($item !== null) {

      $itemID = $getItemValue($item, $index, '');
      $value  = str_replace(['{id}', '#ID#'], $itemID, $value);

    }

    return $value;

  };

  $getColumnClass = function($config, $section) {

    if(!is_array($config)) {

      return '';

    }

    $sectionConfig = $config[$section] ?? [];

    if(!is_array($sectionConfig)) {

      return '';

    }

    return $sectionConfig['class'] ?? $sectionConfig['classes'] ?? '';

  };

  /*
  |--------------------------------------------------------------------------
  | Resolve funções dinâmicas registradas em tbl_sys_functions
  |--------------------------------------------------------------------------
  |
  | Sintaxe suportada:
  |
  | @SysFunctions('sysGetRouteData', ['data' => 'tbl_sys_route_name'])
  |
  | Somente os parâmetros marcados como true em tbl_sys_function_params são
  | enviados para o método registrado em tbl_sys_function_fn.
  |
  | Parâmetros marcados como false são opcionais e não são enviados.
  |
  */

  $normalizeSysFunctionBoolean = function($value) {

    return in_array(

      $value,

      [

        true,
        1,
        '1',
        'true',
        'TRUE',

      ],

      true

    );

  };


  $parseSysFunctionParamsDefinition = function($definition) use ($normalizeSysFunctionBoolean) {

    $params = [];


    if(is_object($definition)) {

      $definition = (array) $definition;

    }


    if(is_array($definition)) {

      foreach($definition as $paramName => $required) {

        if(
          !is_scalar($paramName) ||
          trim((string) $paramName) === ''
        ) {

          continue;

        }


        $params[trim((string) $paramName)] =

          $normalizeSysFunctionBoolean($required);

      }


      return $params;

    }


    if(
      !is_string($definition) ||
      trim($definition) === ''
    ) {

      return $params;

    }


    $definition = trim($definition);


    $decodedDefinition = json_decode(

      $definition,

      true

    );


    if(is_array($decodedDefinition)) {

      foreach($decodedDefinition as $paramName => $required) {

        if(
          !is_scalar($paramName) ||
          trim((string) $paramName) === ''
        ) {

          continue;

        }


        $params[trim((string) $paramName)] =

          $normalizeSysFunctionBoolean($required);

      }


      return $params;

    }


    preg_match_all(

      '/[\'"]([^\'"]+)[\'"]\s*:\s*(true|false|1|0)/i',

      $definition,

      $matches,

      PREG_SET_ORDER

    );


    foreach($matches as $match) {

      $paramName = trim(

        (string) (

          $match[1]

          ?? ''

        )

      );


      if($paramName === '') {

        continue;

      }


      $params[$paramName] =

        $normalizeSysFunctionBoolean(

          strtolower(

            (string) (

              $match[2]

              ?? 'false'

            )

          )

        );

    }


    return $params;

  };


  $parseSysFunctionInvocationParams = function($paramsExpression) {

    $params = [];


    if(
      $paramsExpression === null ||
      !is_scalar($paramsExpression)
    ) {

      return $params;

    }


    $paramsExpression = trim(

      (string) $paramsExpression

    );


    if(
      $paramsExpression === '' ||
      $paramsExpression === '[]'
    ) {

      return $params;

    }


    preg_match_all(

      '/[\'"]([^\'"]+)[\'"]\s*=>\s*(?:[\'"]((?:\\\\.|[^\'"\\\\])*)[\'"]|(-?\d+(?:\.\d+)?)|(true|false|null))/i',

      $paramsExpression,

      $matches,

      PREG_SET_ORDER

    );


    foreach($matches as $match) {

      $paramName = trim(

        (string) (

          $match[1]

          ?? ''

        )

      );


      if($paramName === '') {

        continue;

      }


      if(
        isset($match[2]) &&
        $match[2] !== ''
      ) {

        $paramValue = stripcslashes(

          $match[2]

        );

      } elseif(
        isset($match[3]) &&
        $match[3] !== ''
      ) {

        $paramValue = str_contains(

          $match[3],

          '.'

        )
          ? (float) $match[3]
          : (int) $match[3];

      } else {

        $normalizedValue = strtolower(

          (string) (

            $match[4]

            ?? 'null'

          )

        );


        $paramValue = match($normalizedValue) {

          'true'  => true,
          'false' => false,

          default => null,

        };

      }


      $params[$paramName] = $paramValue;

    }


    return $params;

  };


  $executeSysFunction = function(

    $functionName,

    $invocationParams = []

  ) use (

    $parseSysFunctionParamsDefinition

  ) {

    $functionName = trim(

      (string) $functionName

    );


    if($functionName === '') {

      return [

        'executed' => false,
        'value'    => null,

      ];

    }


    try {

      $functionConfig = \App\Models\SysFunction::where(

        'tbl_sys_function_name',

        $functionName

      )->first();


      if($functionConfig === null) {

        return [

          'executed' => false,
          'value'    => null,

        ];

      }


      $methodName = trim(

        (string) (

          $functionConfig->tbl_sys_function_fn

          ?? ''

        )

      );


      if($methodName === '') {

        return [

          'executed' => false,
          'value'    => null,

        ];

      }


      $controller = app(

        \App\Http\Controllers\AutomatorController::class

      );


      if(!method_exists($controller, $methodName)) {

        return [

          'executed' => false,
          'value'    => null,

        ];

      }


      $methodReflection = new \ReflectionMethod(

        $controller,

        $methodName

      );


      if(!$methodReflection->isPublic()) {

        return [

          'executed' => false,
          'value'    => null,

        ];

      }


      $paramsDefinition =

        $parseSysFunctionParamsDefinition(

          $functionConfig->tbl_sys_function_params

          ?? []

        );


      $methodParams = [];


      foreach($paramsDefinition as $paramName => $required) {

        if($required !== true) {

          continue;

        }


        if(!array_key_exists($paramName, $invocationParams)) {

          return [

            'executed' => false,
            'value'    => null,

          ];

        }


        $methodParams[$paramName] =

          $invocationParams[$paramName];

      }


      $value = $controller->{$methodName}(

        ...$methodParams

      );


      return [

        'executed' => true,
        'value'    => $value,

      ];


    } catch(\Throwable $exception) {

      report($exception);


      \Illuminate\Support\Facades\Log::error(

        'Falha ao executar função dinâmica da paginação.',

        [

          'function'   => $functionName,
          'parameters' => $invocationParams,
          'exception'  => $exception->getMessage(),
          'file'       => $exception->getFile(),
          'line'       => $exception->getLine(),

        ]

      );


      return [

        'executed' => false,
        'value'    => null,

      ];

    }

  };


  $resolveSysFunctionsValue = null;


  $resolveSysFunctionsValue = function($value) use (

    &$resolveSysFunctionsValue,

    $parseSysFunctionInvocationParams,

    $executeSysFunction

  ) {

    if(is_array($value)) {

      foreach($value as $valueKey => $valueItem) {

        $value[$valueKey] =

          $resolveSysFunctionsValue(

            $valueItem

          );

      }


      return $value;

    }


    if(is_object($value)) {

      foreach(get_object_vars($value) as $valueKey => $valueItem) {

        $value->{$valueKey} =

          $resolveSysFunctionsValue(

            $valueItem

          );

      }


      return $value;

    }


    if(!is_string($value)) {

      return $value;

    }


    $originalValue = $value;

    $trimmedValue = trim($value);


    if(
      !str_starts_with($trimmedValue, '@SysFunctions(') ||
      !str_ends_with($trimmedValue, ')')
    ) {

      return $value;

    }


    if(

      !preg_match(

        '/^@SysFunctions\(\s*([\'"])([^\'"]+)\1\s*(?:,\s*(\[.*\]))?\s*\)$/s',

        $trimmedValue,

        $matches

      )

    ) {

      return $value;

    }


    $functionName = trim(

      (string) (

        $matches[2]

        ?? ''

      )

    );


    $paramsExpression =

      $matches[3]

      ?? '[]';


    $invocationParams =

      $parseSysFunctionInvocationParams(

        $paramsExpression

      );


    $execution = $executeSysFunction(

      $functionName,

      $invocationParams

    );


    if(

      !is_array($execution) ||
      ($execution['executed'] ?? false) !== true

    ) {

      return $originalValue;

    }


    return $execution['value']

      ?? null;

  };


  /*
  |--------------------------------------------------------------------------
  | Resolve somente configurações da paginação
  |--------------------------------------------------------------------------
  |
  | Os registros retornados pelo banco não são processados para impedir que
  | um valor comum de uma tabela seja interpretado como função do sistema.
  |
  */

  $columns = $resolveSysFunctionsValue(

    $columns

  );


  $actions = $resolveSysFunctionsValue(

    $actions

  );


  $header_actions = $resolveSysFunctionsValue(

    $header_actions

  );


  $list_actions = $resolveSysFunctionsValue(

    $list_actions

  );


  $search_fields = $resolveSysFunctionsValue(

    $search_fields

  );


  $action_urls = $resolveSysFunctionsValue(

    $action_urls

  );


  $messages = $resolveSysFunctionsValue(

    $messages

  );


  $page_name = $resolveSysFunctionsValue(

    $page_name

  );


  if(isset($actions['delete']) && is_array($actions['delete'])) {

    $delete = $actions['delete'];

    if(isset($delete['route']) && SysAutomator::SysAutomatorCheckUserAccess($delete['route'])) {

      $canDelete = true;
      $delRoles  = (isset($delete['roles']) && is_array($delete['roles'])) ? $delete['roles'] : [];

    }

  }

  $itemsTotal      = ($items && method_exists($items, 'total')) ? $items->total() : 0;
  $itemsCount      = ($items && method_exists($items, 'count')) ? $items->count() : 0;
  $currentPerPage  = ($items && method_exists($items, 'perPage')) ? $items->perPage() : (int) request('per_page', 15);
  $perPageOptions  = [10, 15, 25, 50, 100];

  if(!in_array($currentPerPage, $perPageOptions)) {

    $perPageOptions[] = $currentPerPage;
    sort($perPageOptions);

  }

  $selectableItemsCount = 0;

  if($canDelete) {

    foreach($items as $item) {

      if($checkActionRoles($item, $delRoles)) {

        $selectableItemsCount++;

      }

    }

  }


@endphp

<div
  class="page-card automator-pagination-wrapper"
  data-automator-pagination="true"
  data-delete-message-confirm="{{ e($deleteMessageConfirm) }}"
>
  <div class="page-card-body">

    <div class="row g-3 align-items-end justify-content-between mb-4">

      @if(!empty($search_fields))

        <div class="col-12 col-sm-auto">
          
          <form method="GET" class="row g-3 align-items-end automator-ajax-ignore">

            @foreach(request()->except(['search', 'search_in', 'page']) as $requestKey => $requestValue)

              @if(!is_array($requestValue))

                <input type="hidden" name="{{ $requestKey }}" value="{{ $requestValue }}" />

              @endif

            @endforeach

            <div class="col-12 col-sm-auto">

              <label for="search" class="small fw-medium mb-1">{!! SysAutomator::SysAutomatorGetTranslateWord('Buscar') !!}</label>

              <input
                type="text"
                name="search"
                id="search"
                value="{{ request('search') }}"
                class="form-control"
                placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord('Digite para buscar...') !!}"
              />
            
            </div>

            
            @if(count($search_fields) >= 2)

              <div class="col-12 col-sm-auto">

                <div class="dropdown">

                  <button
                    type="button"
                    class="btn btn-outline-secondary dropdown-toggle"
                    data-bs-toggle="dropdown"
                    data-bs-auto-close="outside"
                    aria-expanded="false"
                  >
                    {!! SysAutomator::SysAutomatorGetTranslateWord('Buscar por') !!}
                  </button>

                  <div class="dropdown-menu p-2 shadow" style="min-width: 220px;">

                    @foreach($search_fields as $field => $label)

                      <div class="form-check mb-2">

                        <label for="search_in_{{ $field }}" class="form-check-label small w-100">

                          <input
                            id="search_in_{{ $field }}"
                            name="search_in[]"
                            type="checkbox"
                            value="{{ $field }}"
                            {{ in_array($field, request('search_in', array_keys($search_fields))) ? 'checked' : '' }}
                            class="form-check-input"
                          />

                          {!! SysAutomator::SysAutomatorGetTranslateWord($label) !!}

                        </label>

                      </div>

                    @endforeach

                  </div>

                </div>

              </div>

            @endif

            <div class="col-12 col-sm-auto">

              <button
                type="submit"
                class="btn btn-light border d-inline-flex align-items-center justify-content-center gap-2 w-100"
              >
                <i class="fa fa-filter text-secondary"></i>

                {!! SysAutomator::SysAutomatorGetTranslateWord('Filtrar') !!}
              </button>

            </div>

            @if(request('search') || request('where') || request('sort') || request('direction'))

              <div class="col-12 col-sm-auto">

                <a
                  href="{{ request()->url() }}"
                  class="btn btn-outline-danger d-inline-flex align-items-center justify-content-center gap-2 w-100"
                >
                  <i class="fa-solid fa-times"></i>

                  {!! SysAutomator::SysAutomatorGetTranslateWord('Limpar') !!}
                </a>

              </div>

            @endif

          </form>

        </div>

      @endif

      <div class="col-12 col-sm-auto">
        
        <form method="GET" class="row g-2 align-items-end automator-ajax-ignore">

          @foreach(request()->except(['per_page', 'page']) as $requestKey => $requestValue)

            @if(is_array($requestValue))

              @foreach($requestValue as $subValue)

                <input
                  type="hidden"
                  name="{{ $requestKey }}[]"
                  value="{{ $subValue }}"
                />

              @endforeach

            @else

              <input
                type="hidden"
                name="{{ $requestKey }}"
                value="{{ $requestValue }}"
              />

            @endif

          @endforeach

          <div class="col-12">

            <label for="per_page" class="form-label small fw-medium mb-1">
              {!! SysAutomator::SysAutomatorGetTranslateWord('Registros/Página') !!}
            </label>

            <select
              name="per_page"
              id="per_page"
              onchange="this.form.submit()"
              class="form-select"
            >

              @foreach($perPageOptions as $perPageOption)

                <option
                  value="{{ $perPageOption }}"
                  {{ (int) $currentPerPage === (int) $perPageOption ? 'selected' : '' }}
                >
                  {{ $perPageOption }}
                </option>
              
              @endforeach
            
            </select>
          
          </div>
        
        </form>
      
      </div>

    </div>

    <div class="row g-3 align-items-end justify-content-between mb-3">

      @php

        $headerButtons = [];

      @endphp

      @foreach($header_actions as $headerAction)

        @php

          $headerAdd = true;

          if(isset($headerAction['action'])) {

            $headerAdd = false;
            $headerAct = $actions[$headerAction['action']] ?? null;

            if(
              is_array($headerAct) &&
              isset($headerAct['route']) &&
              SysAutomator::SysAutomatorCheckUserAccess($headerAct['route'])
            ) {

              $headerAdd = true;

            }

          }

          if($headerAdd) {

            $headerType    = $headerAction['type'] ?? 'button';
            $headerID      = isset($headerAction['id']) ? ' id="' . e($headerAction['id']) . '"' : '';
            $headerClass   = 'btn d-inline-flex align-items-center gap-2' . (isset($headerAction['class']) ? ' ' . $headerAction['class'] : '');
            $headerOnclick = isset($headerAction['onclick']) ? ' onclick="' . e($headerAction['onclick']) . '"' : '';
            $headerIcon    = $renderIcon($headerAction['icon'] ?? null);
            $headerText    = SysAutomator::SysAutomatorGetTranslateWord($headerAction['text'] ?? '');

            if($headerType === 'button') {

              $headerButtons[] =
                '<button type="button"' .
                $headerID .
                ' class="' . e($headerClass) . '"' .
                $headerOnclick .
                '>' .
                $headerIcon .
                $headerText .
                '</button>';

            } else {

              $headerHref   = isset($headerAction['href']) ? ' href="' . e($headerAction['href']) . '"' : ' href="#"';
              $headerTarget = isset($headerAction['target']) ? ' target="' . e($headerAction['target']) . '"' : '';

              $headerButtons[] =
                '<a' .
                $headerID .
                $headerHref .
                $headerTarget .
                ' class="' . e($headerClass) . '"' .
                $headerOnclick .
                '>' .
                $headerIcon .
                $headerText .
                '</a>';

            }

          }

        @endphp

      @endforeach

      @if(count($headerButtons) >= 1)

        <div class="col-12 col-sm-auto">

          <div class="d-flex flex-wrap gap-2">

            {!! implode("\n", $headerButtons) !!}

          </div>

        </div>

      @endif

      @if($canDelete)

        <div class="col-12 col-sm-auto">

          <button
            type="button"
            id="automator-pagination-delete-selected"
            class="btn btn-danger js-automator-pagination-delete-selected"
            disabled
            data-delete-message-confirm="{{ e($deleteMessageConfirm) }}"
            onclick="return AutomatorPaginationSubmitDelete(this)"
          >
            {!! SysAutomator::SysAutomatorGetTranslateWord('Excluir Selecionado(s)') !!}
          </button>
        
        </div>

      @endif

    </div>

    <div class="row">

      @if($itemsTotal > 0)

        <div class="col-12 mb-4 text-muted">

          {!! SysAutomator::SysAutomatorGetTranslateWord('Exibindo') !!}

          <b>{{ $itemsCount }}</b>

          {!! SysAutomator::SysAutomatorGetTranslateWord('de') !!}

          <b>{{ $itemsTotal }}</b>

          {!! SysAutomator::SysAutomatorGetTranslateWord('resultado(s).') !!}
        
        </div>
      
      @endif

      @if($canDelete)

        <form
          method="POST"
          class="col-12 overflow-hidden automator-pagination-delete-form"
          onsubmit="return false;"
        >

          @csrf
          @method('DELETE')

      @else

        <div class="col-12 overflow-hidden">
      
      @endif

        <div class="table-responsive shadow">

          <table class="table table-hover align-middle mb-0">

            <thead class="table-light">

              <tr>

                @if($canDelete)

                  <th
                    scope="col"
                    class="fw-semibold text-nowrap text-center align-middle"
                    style="width: 80px;"
                  >

                    <input
                      type="checkbox"
                      id="pagination-select-all"
                      value=""
                      {{ $selectableItemsCount >= 1 ? '' : 'disabled' }}
                    />
                  
                  </th>
                  
                  @php

                    $cols++;

                  @endphp
                
                @endif

                @foreach($columns as $col => $config)

                  @php

                    $config        = is_array($config) ? $config : [];
                    $fieldType     = $config['field_type'] ?? [];
                    $headerClasses = $getColumnClass($config, 'header');

                    $isSorted = (

                      request('sort') !== null

                        ? request('sort') == $col

                        : $_defaultSort['col'] == $col

                    );

                    $nextDirection = (

                      request('direction') !== null

                        ? request('direction')

                        : $_defaultSort['direction']

                    );
                  
                  @endphp

                  <th scope="col" class="fw-semibold text-nowrap {{ $headerClasses }}">

                    @if($config['sortable'] ?? false)

                      <span class="me-1">
                        {!! SysAutomator::SysAutomatorGetTranslateWord($config['label'] ?? $col) !!}
                      </span>

                      @if($isSorted && $nextDirection == 'asc')

                        <a class="p-1" style="color: #0a58ca; text-decoration: none !important;">

                          <i
                            class="fa fa-sort-down"
                            style="position: relative; top: -3px;"
                          ></i>

                        </a>

                      @else

                        <a
                          style="text-decoration: none !important;"
                          class="p-1 link-secondary"
                          href="{{ request()->fullUrlWithQuery(['sort' => $col, 'direction' => 'asc', 'page' => null]) }}"
                        >

                          <i
                            class="fa fa-sort-down"
                            style="position: relative; top: -3px;"
                          ></i>

                        </a>

                      @endif


                      @if($isSorted && request('direction') == 'desc')
                        
                        <a class="p-1" style="color: #0a58ca; text-decoration: none !important;">

                          <i
                            class="fa fa-sort-up"
                            style="position: relative; top: 5px;"
                          ></i>

                        </a>

                      @else

                        <a
                          style=" text-decoration: none !important;"
                          class="p-1 link-secondary"
                          href="{{ request()->fullUrlWithQuery(['sort' => $col, 'direction' => 'desc', 'page' => null]) }}"
                        >

                          <i
                            class="fa fa-sort-up"
                            style="position: relative; top: 5px;"
                          ></i>

                        </a>

                      @endif
                    
                    @else
                      
                      {!! SysAutomator::SysAutomatorGetTranslateWord($config['label'] ?? $col) !!}
                    
                    @endif

                  </th>

                  @php

                    $cols++;

                  @endphp

                @endforeach

                @if(!empty($list_actions))

                  <th scope="col" class="text-end text-nowrap">

                    <span class="visually-hidden">
                      {!! SysAutomator::SysAutomatorGetTranslateWord('Ações') !!}
                    </span>
                  
                  </th>

                  @php

                    $cols++;

                  @endphp

                @endif

              </tr>

            </thead>

            <tbody>

              @forelse($items as $item)

                @php
                  
                  $itemID = $getItemValue($item, $index, '');
                
                @endphp

                <tr>

                  @if($canDelete)
                    
                    <th scope="col" class="fw-semibold text-nowrap text-center align-middle">
                      
                      @if(!$checkActionRoles($item, $delRoles))
                        
                        <span
                          data-bs-toggle="tooltip"
                          data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord('Esta opção não pode ser selecionada!') !!}"
                        >
                          
                          <input
                            type="checkbox"
                            class="pagination-select-item"
                            id="pagination-select-item-{{ $itemID }}"
                            value="{{ $itemID }}"
                            disabled
                          />
                        
                        </span>
                      
                      @else
                        
                        <input
                          type="checkbox"
                          class="pagination-select-item"
                          name="items[]"
                          id="pagination-select-item-{{ $itemID }}"
                          value="{{ $itemID }}"
                        />
                      
                      @endif
                    
                    </th>
                  
                  @endif

                  @foreach($columns as $col => $config)

                    @php

                      $config    = is_array($config) ? $config : [];
                      $fieldType = $config['field_type'] ?? [];

                    @endphp

                    @if(
                      !empty($fieldType) &&
                      ($fieldType['tbl_sys_field_type_name'] == 'relation')
                    )

                      {!! \App\Automator\AutomatorFields::renderPaginationColumn('tbody', [

                        'column'      => $config,
                        'column_name' => $col,
                        'field_type'  => $fieldType,
                        'props'       => $config['props']  ?? [],
                        'attrs'       => $config['attrs']  ?? [],
                        'config'      => $config['config'] ?? $config,
                        'pagination'  => $pagination ?? [],
                        'columns'     => $columns,
                        'item'        => $item,
                        'request'     => request()->all(),

                      ]) !!}

                    @else

                      @php

                        $bodyClasses = $getColumnClass($config, 'body');

                        $bodyAttrs = (

                          $config['tbl_sys_paginations_col_attrs'] != ''

                            ? (array) json_decode(

                              $config['tbl_sys_paginations_col_attrs']

                            )

                            : []

                        );

                        $value       = $getItemValue($item, $col, '');
                        $prefix      = $config['prefix'] ?? '';
                        $suffix      = $config['suffix'] ?? ($config['sufix'] ?? '');
                        $cellContent = '';


                        if(
                          isset($config['callback']) &&
                          is_callable($config['callback'])
                        ) {

                          $cellContent = $config['callback']($item);

                        } elseif(
                          isset($config['replaced']) &&
                          is_array($config['replaced']) &&
                          array_key_exists($value, $config['replaced'])
                        ) {

                          $cellContent = $config['replaced'][$value];

                        } elseif(count($bodyAttrs) >= 1) {

                          if(isset($bodyAttrs['replaced'])) {

                            $replaced = [];


                            if(is_array($bodyAttrs['replaced'])) {

                              $replaced = $bodyAttrs['replaced'];

                            } elseif(is_object($bodyAttrs['replaced'])) {

                              foreach($bodyAttrs['replaced'] as $replacedKey => $replacedValue) {

                                $replaced[$replacedKey] = $replacedValue;

                              }

                            }


                            if(array_key_exists($value, $replaced)) {

                              $cellContent = $replaced[$value];

                            } else {

                              $cellContent = e($value);

                            }

                          } else {

                            $cellContent = e($value);

                          }

                        } else {

                          $cellContent = e($value);

                        }


                      @endphp

                      <td class="text-nowrap {{ $bodyClasses }}">

                        {!! $prefix !!}{!! $cellContent !!}{!! $suffix !!}

                      </td>

                    @endif

                  @endforeach

                  @if(!empty($list_actions))

                    <td class="text-end text-nowrap">

                      <div class="d-flex justify-content-end gap-2">

                        @foreach($list_actions as $listAction)

                          @php

                            $actAdd  = true;
                            $actOn   = true;
                            $listAct = null;


                            if(isset($listAction['action'])) {

                              $actAdd  = false;
                              $listAct = $actions[$listAction['action']] ?? null;


                              if(
                                is_array($listAct) &&
                                isset($listAct['route']) &&
                                SysAutomator::SysAutomatorCheckUserAccess($listAct['route'])
                              ) {

                                $actAdd = true;
                                $actOn  = $checkActionRoles(

                                  $item,

                                  $listAct['roles'] ?? []

                                );

                              }

                            }


                            $listType       = $listAction['type'] ?? 'button';
                            $listActionName = $listAction['action'] ?? '';
                            $isDeleteAction = ($listActionName === 'delete');
                            $listID         = ($listAction['id'] ?? 'btn-action') . '-' . $itemID;
                            $listClass      = ($listAction['class'] ?? '') . ' btn btn-sm d-inline-flex align-items-center py-2 text-center';
                            $listIcon       = $renderIcon($listAction['icon'] ?? null);
                            $listText       = SysAutomator::SysAutomatorGetTranslateWord($listAction['text'] ?? '');

                            $listOnclick = isset($listAction['onclick'])

                              ? $replaceActionVars(

                                $listAction['onclick'],

                                $item

                              )

                              : '';

                            $listHref = isset($listAction['href'])

                              ? $replaceActionVars(

                                $listAction['href'],

                                $item

                              )

                              : '#';


                            if($isDeleteAction) {

                              $listClass .= ' js-automator-pagination-delete-item';

                            }

                          @endphp

                          @if($actAdd)

                            @if(!$actOn)

                              <span
                                class="d-inline-flex align-items-center"
                                data-bs-toggle="tooltip"
                                data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord('Esta ação não pode ser realizada!') !!}"
                              >
                                
                                <button
                                  type="button"
                                  id="{{ $listID }}"
                                  class="{{ $listClass }} disabled"
                                  disabled
                                >
                                  {!! $listIcon !!}
                                </button>
                              
                              </span>
                            
                            @else
                              
                              @if($listType === 'button')
                                
                                <button
                                  type="button"
                                  id="{{ $listID }}"
                                  class="{{ $listClass }}"
                                  data-bs-toggle="tooltip"
                                  data-bs-title="{{ $listText }}"
                                  data-automator-action="{{ $listActionName }}"
                                  data-automator-item-id="{{ $itemID }}"
                                  data-delete-message-confirm="{{ e($deleteMessageConfirm) }}"

                                  @if($isDeleteAction)

                                    data-original-onclick="{{ e($listOnclick) }}"
                                    onclick="return AutomatorPaginationConfirmDeleteItem(this)"

                                  @elseif($listOnclick !== '')

                                    onclick="{{ $listOnclick }}"

                                  @endif
                                >
                                  {!! $listIcon !!}
                                </button>

                              @else

                                <a
                                  id="{{ $listID }}"
                                  href="{{ $isDeleteAction ? '#' : $listHref }}"
                                  class="{{ $listClass }}"
                                  data-bs-toggle="tooltip"
                                  data-bs-title="{{ $listText }}"
                                  data-automator-action="{{ $listActionName }}"
                                  data-automator-item-id="{{ $itemID }}"
                                  data-delete-message-confirm="{{ e($deleteMessageConfirm) }}"

                                  @if(isset($listAction['target']) && !$isDeleteAction)

                                    target="{{ $listAction['target'] }}"

                                  @endif

                                  @if($isDeleteAction)

                                    data-original-href="{{ e($listHref) }}"
                                    data-original-onclick="{{ e($listOnclick) }}"
                                    onclick="return AutomatorPaginationConfirmDeleteItem(this)"

                                  @elseif($listOnclick !== '')

                                    onclick="{{ $listOnclick }}"

                                  @endif
                                >
                                  {!! $listIcon !!}
                                </a>
                                
                              @endif

                            @endif

                          @endif

                        @endforeach

                      </div>

                    </td>

                  @endif

                </tr>

              @empty

                <tr>

                  <td
                    colspan="{{ max($cols, 1) }}"
                    class="py-5 text-center text-secondary"
                  >

                    <div class="d-flex flex-column align-items-center justify-content-center">

                      <i class="fa-solid fa-inbox display-6 text-muted mb-3"></i>

                      <p class="mb-0">
                        {!! SysAutomator::SysAutomatorGetTranslateWord('Nenhum registro encontrado.') !!}
                      </p>

                    </div>

                  </td>

                </tr>

              @endforelse

            </tbody>

          </table>

        </div>

      @if($canDelete)

        </form>

      @else

        </div>

      @endif

    </div>

    @if(
      $items &&
      method_exists($items, 'hasPages') &&
      $items->hasPages()
    )

      <div class="row mt-4">

        {{ $items->links() }}

      </div>

    @endif

  </div>

</div>

@if(!empty($actions))

  @php

    $_scripts = '';


    foreach($actions as $_actionKey => $_action) {

      if(
        isset($_action['show']) &&
        $_action['show'] == true &&
        isset($_action['route'])
      ) {

        $_actionParams = $_action['params'] ?? [];

        $_scripts .=

          'AutomatorPaginationRoutes.' .

          $_actionKey .

          ' = "' .

          SysAutomator::SysAutomatorGetRouteLinkByName(

            $_action['route'],

            $_actionParams

          ) .

          '";' .

          "\n";

      }

    }

  @endphp

  @if($_scripts != '')

    <script>

      window.AutomatorPaginationRoutes =
        window.AutomatorPaginationRoutes || {};

      {!! $_scripts !!}

    </script>

  @endif

@endif