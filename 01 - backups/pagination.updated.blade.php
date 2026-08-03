<?php

  $cols          = 0;
  $actions       = $actions ?? [];
  $columns       = $columns ?? [];
  $header_actions = $header_actions ?? [];
  $list_actions  = $list_actions ?? [];
  $search_fields = $search_fields ?? [];
  $messages      = $messages ?? [];

  $itemsTotal = method_exists($items, 'total') ? $items->total() : count($items ?? []);
  $itemsCount = method_exists($items, 'count') ? $items->count() : count($items ?? []);

  $currentPerPage = (int) request('per_page', $per_page ?? 15);
  $perPageOptions = $per_page_options ?? [10, 15, 25, 50, 100];

  if(!in_array($currentPerPage, $perPageOptions)) {
    $perPageOptions[] = $currentPerPage;
    sort($perPageOptions);
  }

  $canDelete = false;
  $delRoles  = [];

  if(array_key_exists('delete', $actions)) {

    $delete = $actions['delete'];

    if(isset($delete['route']) && SysAutomator::SysAutomatorCheckUserAccess($delete['route'])) {

      $canDelete = true;

      if(array_key_exists('roles', $delete) && is_array($delete['roles'])) {
        $delRoles = $delete['roles'];
      }

    }

  }

  $getItemValue = function($item, $key, $default = null) {

    if(is_array($item)) {
      return $item[$key] ?? $default;
    }

    if(is_object($item)) {
      return $item->$key ?? $default;
    }

    return $default;

  };

  $compareValues = function($left, $operator, $right) {

    return match($operator) {
      '=='  => $left == $right,
      '===' => $left === $right,
      '!='  => $left != $right,
      '!==' => $left !== $right,
      '>'   => $left > $right,
      '>='  => $left >= $right,
      '<'   => $left < $right,
      '<='  => $left <= $right,
      default => false,
    };

  };

  $itemCanDelete = function($item) use ($delRoles, $getItemValue, $compareValues) {

    if(count($delRoles) <= 0) {
      return true;
    }

    foreach($delRoles as $delRole) {

      $delKey = $delRole['key'] ?? null;

      if($delKey == null) {
        continue;
      }

      $delArg  = $delRole['compare'] ?? '==';
      $delVal  = $delRole['value'] ?? null;
      $itemVal = $getItemValue($item, $delKey);

      if($compareValues($itemVal, $delArg, $delVal)) {
        return true;
      }

    }

    return false;

  };

  $selectableItemsCount = 0;

  if($canDelete) {

    foreach($items as $_selectableItem) {

      if($itemCanDelete($_selectableItem)) {
        $selectableItemsCount++;
      }

    }

  }

  $getColumnClass = function($config, $area = 'body') {

    if(!is_array($config)) {
      return '';
    }

    if(isset($config[$area]) && is_array($config[$area]) && isset($config[$area]['class'])) {
      return $config[$area]['class'];
    }

    if(isset($config['classes']) && is_array($config['classes']) && isset($config['classes'][$area])) {
      return $config['classes'][$area];
    }

    return '';

  };

  $renderIcon = function($icon = null) {

    if($icon == null || $icon == '') {
      return '';
    }

    return '<i class="fa fa-' . e($icon) . '"></i> ';

  };

  $renderValue = function($item, $col, $config) use ($getItemValue) {

    $value = $getItemValue($item, $col, '');

    if(isset($config['callback']) && is_callable($config['callback'])) {
      return $config['callback']($item);
    }

    if(isset($config['replaced']) && is_array($config['replaced']) && array_key_exists($value, $config['replaced'])) {
      return $config['replaced'][$value];
    }

    return e($value);

  };

  $deleteMessageConfirm = $messages['delete-message-confirm'] ?? 'Para realizar esta ação é necessário que seja realizado a confirmação de segurança informando sua senha. Esta ação é necessária pois é possivel que algumas informações não poderam ser restauradas depois.';
  $deleteMessageConfirm = SysAutomator::SysAutomatorGetTranslateWord($deleteMessageConfirm);

  $deleteActionURL = '';

  if($canDelete && isset($actions['delete']['route'])) {
    $deleteActionURL = SysAutomator::SysAutomatorGetRouteLinkByName($actions['delete']['route'], $actions['delete']['params'] ?? [], true);
  }

?>
<div class="page-card automator-pagination" data-automator-pagination="true">

  <div class="page-card-body">

    <div class="row g-3 align-items-end justify-content-between mb-4">

      @if(!empty($search_fields))
        <div class="col-12 col-sm-auto">
          <form method="GET" class="row g-3 align-items-end">

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

            @if(request('search') || request('where') || request('sort'))
              <div class="col-12 col-sm-auto">
                <a href="{{ request()->url() }}" class="btn btn-outline-danger d-inline-flex align-items-center justify-content-center gap-2 w-100"><i class="fa-solid fa-times"></i> {!! SysAutomator::SysAutomatorGetTranslateWord('Limpar') !!}</a>
              </div>
            @endif

            @foreach(request()->except(['search', 'search_in', 'page']) as $requestKey => $requestValue)
              @if(!is_array($requestValue))
                <input type="hidden" name="{{ $requestKey }}" value="{{ $requestValue }}" />
              @endif
            @endforeach

          </form>
        </div>
      @endif

      <div class="col-12 col-sm-auto">
        <form method="GET" class="row g-2 align-items-end">

          @foreach(request()->except(['per_page', 'page']) as $requestKey => $requestValue)
            @if(is_array($requestValue))
              @foreach($requestValue as $requestArrayValue)
                <input type="hidden" name="{{ $requestKey }}[]" value="{{ $requestArrayValue }}" />
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

      @php $headerButtons = []; @endphp

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
          <button type="button" id="automator-pagination-delete-selected" class="btn btn-danger js-automator-pagination-delete-selected" disabled onclick="return AutomatorPaginationSubmitDelete(this)">{!! SysAutomator::SysAutomatorGetTranslateWord('Excluir Selecionado(s)') !!}</button>
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
        <form method="POST" action="{{ $deleteActionURL }}" class="col-12 overflow-hidden js-automator-pagination-delete-form" onsubmit="return false;">
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
                    <input type="checkbox" id="pagination-select-all" class="js-automator-pagination-select-all" value="" {{ $selectableItemsCount >= 1 ? '' : 'disabled' }} />
                  </th>
                  @php $cols++; @endphp
                @endif

                @foreach($columns as $col => $config)
                  @php
                    $config        = is_array($config) ? $config : [];
                    $headerClasses = $getColumnClass($config, 'header');
                    $isSorted      = request('sort') == $col;
                    $nextDirection = ($isSorted && request('direction') == 'asc') ? 'desc' : 'asc';
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
                  $itemID = $getItemValue($item, $index);
                @endphp

                <tr>

                  @if($canDelete)
                    @php $delItem = $itemCanDelete($item); @endphp
                    <th scope="col" class="fw-semibold text-nowrap text-center align-middle">
                      @if($delItem)
                        <input type="checkbox" class="pagination-select-item js-automator-pagination-select-item" name="items[]" id="pagination-select-item-{{ $itemID }}" value="{{ $itemID }}" />
                      @else
                        <span data-bs-toggle="tooltip" data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord('Esta opção não pode ser selecionada!') !!}">
                          <input type="checkbox" class="pagination-select-item js-automator-pagination-select-item" id="pagination-select-item-{{ $itemID }}" value="{{ $itemID }}" disabled />
                        </span>
                      @endif
                    </th>
                  @endif

                  @foreach($columns as $col => $config)
                    @php
                      $config      = is_array($config) ? $config : [];
                      $bodyClasses = $getColumnClass($config, 'body');
                    @endphp
                    <td class="text-nowrap {{ $bodyClasses }}">
                      @if(isset($config['prefix'])){!! $config['prefix'] !!}@endif
                      {!! $renderValue($item, $col, $config) !!}
                      @if(isset($config['sufix'])){!! $config['sufix'] !!}@endif
                    </td>
                  @endforeach

                  @if(!empty($list_actions))
                    <td class="text-end text-nowrap">
                      <div class="d-flex justify-content-end gap-2">

                        @foreach($list_actions as $listAction)
                          @php
                            $actAdd = true;
                            $actOn  = true;

                            if(isset($listAction['action'])) {
                              $actAdd = false;
                              $listAct = $actions[$listAction['action']] ?? null;

                              if(is_array($listAct) && isset($listAct['route']) && SysAutomator::SysAutomatorCheckUserAccess($listAct['route'])) {
                                $actAdd = true;

                                if(isset($listAct['roles']) && is_array($listAct['roles'])) {
                                  $actOn = false;

                                  foreach($listAct['roles'] as $actRole) {
                                    $actKey = $actRole['key'] ?? null;

                                    if($actKey == null) {
                                      continue;
                                    }

                                    $actArg  = $actRole['compare'] ?? '==';
                                    $actVal  = $actRole['value'] ?? null;
                                    $itemVal = $getItemValue($item, $actKey);

                                    if($compareValues($itemVal, $actArg, $actVal)) {
                                      $actOn = true;
                                      break;
                                    }
                                  }
                                }
                              }
                            }

                            $listType    = $listAction['type'] ?? 'button';
                            $listActionKey = $listAction['action'] ?? '';
                            $listID      = ($listAction['id'] ?? 'btn-action') . '-' . $itemID;
                            $listClass   = ($listAction['class'] ?? '') . ' btn btn-sm d-inline-flex align-items-center py-2 text-center';
                            $listIcon    = $renderIcon($listAction['icon'] ?? null);
                            $listTitle   = SysAutomator::SysAutomatorGetTranslateWord($listAction['text'] ?? '');
                            $listOnclick = isset($listAction['onclick']) ? str_replace('{id}', $itemID, $listAction['onclick']) : '';

                            if($listActionKey === 'delete') {
                              $listOnclick = 'return AutomatorPaginationConfirmListDelete(this);';
                            }
                          @endphp

                          @if($actAdd)
                            @if(!$actOn)
                              <span class="d-inline-flex align-items-center" data-bs-toggle="tooltip" data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord('Esta ação não pode ser realizada!') !!}">
                                @if($listType === 'button')
                                  <button type="button" id="{{ $listID }}" class="{{ $listClass }} disabled" disabled><i class="fa fa-{{ $listAction['icon'] ?? 'ban' }}"></i></button>
                                @endif
                              </span>
                            @else
                              @if($listType === 'button')
                                <button type="button" id="{{ $listID }}" class="{{ $listClass }} {{ $listActionKey === 'delete' ? 'js-automator-pagination-delete-item' : '' }}" data-bs-toggle="tooltip" data-bs-title="{{ $listTitle }}" data-automator-pagination-action="{{ $listActionKey }}" data-automator-pagination-item-id="{{ $itemID }}" onclick="{{ $listOnclick }}">{!! $listIcon !!}</button>
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
                  <td colspan="{{ $cols > 0 ? $cols : 1 }}" class="py-5 text-center text-secondary">
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

    @if(method_exists($items, 'hasPages') && $items->hasPages())
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
        $_scripts .= 'AutomatorPaginationRoutes.' . $_actionKey . ' = "' . SysAutomator::SysAutomatorGetRouteLinkByName($_action['route'], $_action['params'] ?? []) . '";' . "\n";
      }
    }
  @endphp

  <script>
    window.AutomatorPaginationRoutes = window.AutomatorPaginationRoutes || {};
    window.AutomatorPaginationMessages = window.AutomatorPaginationMessages || {};
    window.AutomatorPaginationMessages.deleteMessageConfirm = @json($deleteMessageConfirm);
    {!! $_scripts !!}
  </script>
@endif
