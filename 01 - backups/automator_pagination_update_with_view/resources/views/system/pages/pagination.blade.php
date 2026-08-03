@php

  use App\Helpers\SysAutomator;

  $items          = $items ?? collect();
  $columns        = (isset($columns) && is_array($columns)) ? $columns : [];
  $actions        = (isset($actions) && is_array($actions)) ? $actions : [];
  $header_actions = (isset($header_actions) && is_array($header_actions)) ? $header_actions : [];
  $list_actions   = (isset($list_actions) && is_array($list_actions)) ? $list_actions : [];
  $search_fields  = (isset($search_fields) && is_array($search_fields)) ? $search_fields : [];
  $action_urls    = (isset($action_urls) && is_array($action_urls)) ? $action_urls : [];

  $index          = $index ?? null;
  $table          = $table ?? 'automator';
  $page_name      = $page_name ?? null;
  $canDelete      = false;
  $delRoles       = [];
  $cols           = 0;

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

@endphp

<div class="page-card">
  <div class="page-card-body">

    @if($page_name)
      <div class="row mb-3">
        <div class="col-12">
          <h2 class="h5 mb-0">{!! SysAutomator::SysAutomatorGetTranslateWord($page_name) !!}</h2>
        </div>
      </div>
    @endif

    <div class="row g-3 align-items-end justify-content-between mb-4">

      @if(!empty($search_fields))

        <div class="col-12 col-sm-auto">
          <form method="GET" class="row g-3 align-items-end">

            @foreach(request()->except(['search', 'search_in', 'page']) as $requestKey => $requestValue)
              @if(!is_array($requestValue))
                <input type="hidden" name="{{ $requestKey }}" value="{{ $requestValue }}" />
              @endif
            @endforeach

            <div class="col-12 col-sm-auto">
              <label for="search" class="form-label small fw-medium mb-1">{!! SysAutomator::SysAutomatorGetTranslateWord('Buscar') !!}</label>
              <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-control" placeholder="{!! SysAutomator::SysAutomatorGetTranslateWord('Digite para buscar...') !!}" />
            </div>

            @if(count($search_fields) >= 2)

              <div class="col-12 col-sm-auto">
                <label class="form-label small fw-medium mb-1 d-block">{!! SysAutomator::SysAutomatorGetTranslateWord('Buscar por') !!}</label>

                <div class="dropdown">
                  <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">{!! SysAutomator::SysAutomatorGetTranslateWord('Buscar por') !!}</button>

                  <div class="dropdown-menu p-2 shadow" style="min-width: 220px;">
                    @foreach($search_fields as $field => $label)
                      <div class="form-check mb-2">
                        <label for="search_in_{{ $field }}" class="form-check-label small w-100">
                          <input id="search_in_{{ $field }}" name="search_in[]" type="checkbox" value="{{ $field }}" {{ in_array($field, request('search_in', array_keys($search_fields))) ? 'checked' : '' }} class="form-check-input" />
                          {!! SysAutomator::SysAutomatorGetTranslateWord($label) !!}
                        </label>
                      </div>
                    @endforeach
                  </div>
                </div>
              </div>

            @endif

            <div class="col-12 col-sm-auto">
              <button type="submit" class="btn btn-light border d-inline-flex align-items-center justify-content-center gap-2 w-100"><i class="fa fa-filter text-secondary"></i> {!! SysAutomator::SysAutomatorGetTranslateWord('Filtrar') !!}</button>
            </div>

            @if(request('search') || request('where') || request('sort') || request('direction'))
              <div class="col-12 col-sm-auto">
                <a href="{{ request()->url() }}" class="btn btn-outline-danger d-inline-flex align-items-center justify-content-center gap-2 w-100"><i class="fa-solid fa-times"></i> {!! SysAutomator::SysAutomatorGetTranslateWord('Limpar') !!}</a>
              </div>
            @endif

          </form>
        </div>

      @endif

      <div class="col-12 col-sm-auto">
        <form method="GET" class="row g-2 align-items-end">

          @foreach(request()->except(['per_page', 'page']) as $requestKey => $requestValue)
            @if(is_array($requestValue))
              @foreach($requestValue as $subValue)
                <input type="hidden" name="{{ $requestKey }}[]" value="{{ $subValue }}" />
              @endforeach
            @else
              <input type="hidden" name="{{ $requestKey }}" value="{{ $requestValue }}" />
            @endif
          @endforeach

          <div class="col-12">
            <label for="per_page" class="form-label small fw-medium mb-1">{!! SysAutomator::SysAutomatorGetTranslateWord('Registros/Página') !!}</label>

            <select name="per_page" id="per_page" onchange="this.form.submit()" class="form-select">
              @foreach($perPageOptions as $perPageOption)
                <option value="{{ $perPageOption }}" {{ (int) $currentPerPage === (int) $perPageOption ? 'selected' : '' }}>{{ $perPageOption }}</option>
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

            if(is_array($headerAct) && isset($headerAct['route']) && SysAutomator::SysAutomatorCheckUserAccess($headerAct['route'])) {

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

              $headerButtons[] = '<button type="button"' . $headerID . ' class="' . e($headerClass) . '"' . $headerOnclick . '>' . $headerIcon . $headerText . '</button>';

            } else {

              $headerHref   = isset($headerAction['href']) ? ' href="' . e($headerAction['href']) . '"' : ' href="#"';
              $headerTarget = isset($headerAction['target']) ? ' target="' . e($headerAction['target']) . '"' : '';

              $headerButtons[] = '<a' . $headerID . $headerHref . $headerTarget . ' class="' . e($headerClass) . '"' . $headerOnclick . '>' . $headerIcon . $headerText . '</a>';

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
          <button type="button" class="btn btn-danger" disabled onclick="return AutomatorPaginationSubmitDelete()">{!! SysAutomator::SysAutomatorGetTranslateWord('Excluir Selecionado(s)') !!}</button>
        </div>
      @endif

    </div>

    <div class="row">

      @if($itemsTotal > 0)
        <div class="col-12 mb-4 text-muted">
          {!! SysAutomator::SysAutomatorGetTranslateWord('Exibindo') !!} <b>{{ $itemsCount }}</b> {!! SysAutomator::SysAutomatorGetTranslateWord('de') !!} <b>{{ $itemsTotal }}</b> {!! SysAutomator::SysAutomatorGetTranslateWord('resultado(s).') !!}
        </div>
      @endif

      @if($canDelete)
        <form method="POST" class="col-12 overflow-hidden" onsubmit="return false;">
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
                  <th scope="col" class="fw-semibold text-nowrap text-center align-middle" style="width: 80px;">
                    <input type="checkbox" id="pagination-select-all" value="" {{ $itemsCount >= 1 ? '' : 'disabled' }} />
                  </th>
                  @php $cols++; @endphp
                @endif

                @foreach($columns as $col => $config)

                  @php
                    $config         = is_array($config) ? $config : [];
                    $headerClasses  = $getColumnClass($config, 'header');
                    $isSorted       = request('sort') == $col;
                    $nextDirection  = ($isSorted && request('direction') == 'asc') ? 'desc' : 'asc';
                  @endphp

                  <th scope="col" class="fw-semibold text-nowrap {{ $headerClasses }}">

                    @if($config['sortable'] ?? false)
                      <a href="{{ request()->fullUrlWithQuery(['sort' => $col, 'direction' => $nextDirection, 'page' => null]) }}" class="d-inline-flex align-items-center gap-2 text-decoration-none text-dark">
                        {!! SysAutomator::SysAutomatorGetTranslateWord($config['label'] ?? $col) !!}
                        <span class="d-inline-flex align-items-center text-secondary">
                          @if($isSorted && request('direction') == 'asc')
                            <i class="fa fa-arrow-down"></i>
                          @else
                            <i class="fa fa-arrow-up"></i>
                          @endif
                        </span>
                      </a>
                    @else
                      {!! SysAutomator::SysAutomatorGetTranslateWord($config['label'] ?? $col) !!}
                    @endif

                  </th>

                  @php $cols++; @endphp

                @endforeach

                @if(!empty($list_actions))
                  <th scope="col" class="text-end text-nowrap">
                    <span class="visually-hidden">{!! SysAutomator::SysAutomatorGetTranslateWord('Ações') !!}</span>
                  </th>
                  @php $cols++; @endphp
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
                        <span data-bs-toggle="tooltip" data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord('Esta opção não pode ser selecionada!') !!}">
                          <input type="checkbox" class="pagination-select-item" id="pagination-select-item-{{ $itemID }}" value="{{ $itemID }}" disabled />
                        </span>
                      @else
                        <input type="checkbox" class="pagination-select-item" name="items[]" id="pagination-select-item-{{ $itemID }}" value="{{ $itemID }}" />
                      @endif
                    </th>
                  @endif

                  @foreach($columns as $col => $config)

                    @php

                      $config       = is_array($config) ? $config : [];
                      $bodyClasses  = $getColumnClass($config, 'body');
                      $value        = $getItemValue($item, $col, '');
                      $prefix       = $config['prefix'] ?? '';
                      $suffix       = $config['suffix'] ?? ($config['sufix'] ?? '');
                      $cellContent  = '';

                      if(isset($config['callback']) && is_callable($config['callback'])) {

                        $cellContent = $config['callback']($item);

                      } elseif(isset($config['replaced']) && is_array($config['replaced']) && array_key_exists($value, $config['replaced'])) {

                        $cellContent = $config['replaced'][$value];

                      } else {

                        $cellContent = e($value);

                      }

                    @endphp

                    <td class="text-nowrap {{ $bodyClasses }}">
                      {!! $prefix !!}{!! $cellContent !!}{!! $suffix !!}
                    </td>

                  @endforeach

                  @if(!empty($list_actions))
                    <td class="text-end text-nowrap">
                      <div class="d-flex justify-content-end gap-2">

                        @foreach($list_actions as $listAction)

                          @php

                            $actAdd = true;
                            $actOn  = true;
                            $listAct = null;

                            if(isset($listAction['action'])) {

                              $actAdd = false;
                              $listAct = $actions[$listAction['action']] ?? null;

                              if(is_array($listAct) && isset($listAct['route']) && SysAutomator::SysAutomatorCheckUserAccess($listAct['route'])) {

                                $actAdd = true;
                                $actOn  = $checkActionRoles($item, $listAct['roles'] ?? []);

                              }

                            }

                            $listType    = $listAction['type'] ?? 'button';
                            $listID      = ($listAction['id'] ?? 'btn-action') . '-' . $itemID;
                            $listClass   = ($listAction['class'] ?? '') . ' btn btn-sm d-inline-flex align-items-center py-2 text-center';
                            $listIcon    = $renderIcon($listAction['icon'] ?? null);
                            $listText    = SysAutomator::SysAutomatorGetTranslateWord($listAction['text'] ?? '');
                            $listOnclick = isset($listAction['onclick']) ? $replaceActionVars($listAction['onclick'], $item) : '';
                            $listHref    = isset($listAction['href']) ? $replaceActionVars($listAction['href'], $item) : '#';

                          @endphp

                          @if($actAdd)

                            @if(!$actOn)
                              <span class="d-inline-flex align-items-center" data-bs-toggle="tooltip" data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord('Esta ação não pode ser realizada!') !!}">
                                <button type="button" id="{{ $listID }}" class="{{ $listClass }} disabled" disabled>{!! $listIcon !!}</button>
                              </span>
                            @else
                              @if($listType === 'button')
                                <button type="button" id="{{ $listID }}" class="{{ $listClass }}" data-bs-toggle="tooltip" data-bs-title="{{ $listText }}" @if($listOnclick !== '') onclick="{{ $listOnclick }}" @endif>{!! $listIcon !!}</button>
                              @else
                                <a id="{{ $listID }}" href="{{ $listHref }}" class="{{ $listClass }}" data-bs-toggle="tooltip" data-bs-title="{{ $listText }}" @if(isset($listAction['target'])) target="{{ $listAction['target'] }}" @endif @if($listOnclick !== '') onclick="{{ $listOnclick }}" @endif>{!! $listIcon !!}</a>
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
                  <td colspan="{{ max($cols, 1) }}" class="py-5 text-center text-secondary">
                    <div class="d-flex flex-column align-items-center justify-content-center">
                      <i class="fa-solid fa-inbox display-6 text-muted mb-3"></i>
                      <p class="mb-0">{!! SysAutomator::SysAutomatorGetTranslateWord('Nenhum registro encontrado.') !!}</p>
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

    @if($items && method_exists($items, 'hasPages') && $items->hasPages())
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

      if(isset($_action['show']) && $_action['show'] == true && isset($_action['route'])) {

        $_actionParams = $_action['params'] ?? [];
        $_scripts .= 'AutomatorPaginationRoutes.' . $_actionKey . ' = "' . SysAutomator::SysAutomatorGetRouteLinkByName($_action['route'], $_actionParams) . '";' . "\n";

      }

    }
  @endphp

  @if($_scripts != '')
    <script>
      window.AutomatorPaginationRoutes = window.AutomatorPaginationRoutes || {};
      {!! $_scripts !!}
    </script>
  @endif
@endif
