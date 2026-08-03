<?php
  
  $cols      = 0;
  $canDelete = false;
  $delRoles  = [];

  $can_delete = array_key_exists('delete', $actions);
  if($can_delete == true) {

    $delete = $actions['delete'];
    if(SysAutomator::SysAutomatorCheckUserAccess($delete['route'])) {

      $canDelete = true;
      if(array_key_exists('roles', $delete)) {

        $delRoles = $delete['roles'];

      }

    }

  }

?>
<div class="page-card">
  
  <div class="page-card-body">
    
    <div class="row g-3 align-items-end justify-content-between mb-4">

      @if(!empty($search_fields))

        <div class="col-12 col-sm-auto">
          
          <form method="GET" class="row g-3 align-items-end">

            <div class="col-12 col-sm-auto">

              <label for="search" class="form-label small fw-medium mb-1">Buscar</label>
              <input type="text" name="search" id="search" value="{{ request('search') }}" class="form-control" placeholder="Digite para buscar..." />

            </div>

            @if(count($search_fields) >= 2)

              <div class="col-12 col-sm-auto">

                <label class="form-label small fw-medium mb-1 d-block">Buscar por</label>

                <div class="dropdown">

                  <button type="button" class="btn btn-outline-secondary dropdown-toggle" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">Buscar por</button>

                  <div class="dropdown-menu p-2 shadow" style="min-width: 220px;">

                    @foreach($search_fields as $field => $label)

                      <div class="form-check mb-2">

                        <label for="search_in_{{ $field }}" class="form-check-label small w-100">
                          <input id="search_in_{{ $field }}" name="search_in[]" type="checkbox" value="{{ $field }}" {{ in_array($field, request('search_in', array_keys($search_fields))) ? 'checked' : '' }} class="form-check-input" />
                          {{ $label }}
                        </label>

                      </div>

                    @endforeach

                  </div>

                </div>

              </div>

            @endif

            <div class="col-12 col-sm-auto">

              <button type="submit" class="btn btn-light border d-inline-flex align-items-center justify-content-center gap-2 w-100"><i class="fa fa-filter text-secondary"></i> Filtrar</button>

            </div>

            @if(request('search') || request('where') || request('sort'))

              <div class="col-12 col-sm-auto">

                <a href="{{ request()->url() }}" class="btn btn-outline-danger d-inline-flex align-items-center justify-content-center gap-2 w-100"><i class="fa-solid fa-times"></i> Limpar</a>

              </div>

            @endif

          </form>

        </div>

      @endif

      <div class="col-12 col-sm-auto">

        <form method="GET" class="row g-2 align-items-end">

          <div class="col-12">

            <label for="per_page" class="form-label small fw-medium mb-1">Registros/Página</label>

            <select name="per_page" id="per_page" onchange="this.form.submit()" class="form-select">

              <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
              <option value="15" {{ request('per_page', 15) == 15 ? 'selected' : '' }}>15</option>
              <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
              <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
              <option value="100" {{ request('per_page') == 100 ? 'selected' : '' }}>100</option>

            </select>

          </div>

        </form>

      </div>
      
    </div>

    
    <div class="row g-3 align-items-end justify-content-between mb-3">
      
      <?php

        if(!empty($header_actions)) {

          if(count($header_actions) >= 1) {

            $header_acts    = '';
            $header_actionC = 0;
            foreach($header_actions as $headerAction) {

              $headerAdd = false;
              if(array_key_exists('action', $headerAction)) {

                if(array_key_exists($headerAction['action'], $actions)) {

                  $headerAct = $actions[$headerAction['action']];
                  if(SysAutomator::SysAutomatorCheckUserAccess($headerAct['route'])) {

                    $headerAdd = true;

                  }

                }

              } else {

                $headerAdd = true;

              }


              if($headerAdd == true) {

                if($headerAction['type'] == 'button') {

                  $header_acts .= '<button' . ( (isset($headerAction['id'])) ? ' id="' . $headerAction['id'] . '"' : '' ) . ' class="btn d-inline-flex align-items-center gap-2' . ( (isset($headerAction['class'])) ? ' ' . $headerAction['class'] : '' ) . '"' . ( (isset($headerAction['onclick'])) ? ' onclick="' . $headerAction['onclick'] . '"' : '' ) . '>' . ( (isset($headerAction['icon'])) ? '<i class="fa fa-' . $headerAction['icon'] . '"></i> ' : '' ) . SysAutomator::SysAutomatorGetTranslateWord($headerAction['text']) . '</button>' . "\n";

                } else {

                  $header_acts .= '<a' . ( (isset($headerAction['id'])) ? ' id="' . $headerAction['id'] . '"' : '' ) . ( (isset($headerAction['href'])) ? ' href="' . $headerAction['href'] . '"' : '' ) . ( (isset($headerAction['target'])) ? ' target="' . $headerAction['target'] . '"' : '' ) . ' class="btn d-inline-flex align-items-center gap-2' . ( (isset($headerAction['class'])) ? ' ' . $headerAction['class'] : '' ) . '"' . ( (isset($headerAction['onclick'])) ? ' onclick="' . $headerAction['onclick'] . '"' : '' ) . '>' . ( (isset($headerAction['icon'])) ? '<i class="fa fa-' . $headerAction['icon'] . '"></i> ' : '' ) . SysAutomator::SysAutomatorGetTranslateWord($headerAction['text']) . '</a>' . "\n";

                }

                $header_actionC++;

              }

            }

            if($header_actionC >= 1) {

              echo '<div class="col-12 col-sm-auto">' . "\n";

                echo '<div class="d-flex flex-wrap gap-2">' . "\n";
                  
                  echo $header_acts;

                echo '</div>' . "\n";

              echo '</div>' . "\n";

            }

          }

        }



        if($canDelete == true) {

          echo '<div class="col-12 col-sm-auto">' . "\n";
            
            echo '<button type="button" class="btn btn-danger" disabled onclick="return AutomatorPaginationSubmitDelete()">' . SysAutomator::SysAutomatorGetTranslateWord('Excluir Selecionado(s)') . '</button>' . "\n";

          echo '</div>' . "\n";

        }


      ?>

    </div>

    <div class="row">

      @if($items->total() > 0)

        <div class="col-12 mb-4 text-muted">
          Exibindo <b>{{ $items->count() }}</b> de <b>{{ $items->total() }}</b> resultado(s).
        </div>

      @endif
      @if($canDelete == true)

        <form method="DELETE" class="col-12 overflow-hidden" onsubmit="return false;">
          
          @csrf

      @else

        <div class="col-12 overflow-hidden">

      @endif

        <div class="table-responsive shadow">

          <table class="table table-hover align-middle mb-0">

            <thead class="table-light">

              <tr>

                @if($canDelete == true)

                  <th scope="col" class="fw-semibold text-nowrap text-center align-middle" style="width: 80px;">

                    <input type="checkbox" id="pagination-select-all" value="" <?php echo ( ( $items->count() >= 1 ) ? '' : 'disabled' ); ?> />
                    
                  </th>
                  <?php $cols++; ?>

                @endif

                @foreach($columns as $col => $config)

                  @php

                    $_classes = '';
                    if(isset($config['header'])) {

                      if(isset($config['header']['class'])) {

                        $_classes = $config['header']['class'];

                      }

                    }

                  @endphp

                  <th scope="col" class="fw-semibold text-nowrap {!! ( ($_classes != '') ? $_classes : '' ) !!}">

                    @if($config['sortable'] ?? false)

                      @php

                        $isSorted = request('sort') == $col;
                        $nextDirection = ($isSorted && request('direction') == 'asc') ? 'desc' : 'asc';

                      @endphp

                      <a href="{{ request()->fullUrlWithQuery(['sort' => $col, 'direction' => $nextDirection]) }}" class="d-inline-flex align-items-center gap-2 text-decoration-none text-dark">

                        {!! SysAutomator::SysAutomatorGetTranslateWord($config['label']) !!}

                        <span class="d-inline-flex align-items-center text-secondary">

                          @if($isSorted && request('direction') == 'asc')

                            <i class="fa fa-arrow-down"></i>

                          @else

                            <i class="fa fa-arrow-up"></i>

                          @endif

                        </span>

                      </a>

                    @else

                      {!! SysAutomator::SysAutomatorGetTranslateWord($config['label']) !!}

                    @endif

                  </th>

                  <?php $cols++; ?>

                @endforeach

                @if(!empty($list_actions))

                  <th scope="col" class="text-end text-nowrap">

                    <span class="visually-hidden">Ações</span>

                  </th>
                  <?php $cols++; ?>

                @endif

              </tr>

            </thead>



            <tbody>


              @forelse($items as $item)

                <tr>

                  @if($canDelete == true)

                    <th scope="col" class="fw-semibold text-nowrap text-center align-middle">

                      @if(count($delRoles) >= 1)
                        
                        <?php

                          $delItem = false;
                          foreach($delRoles as $delRole) {

                            if($delItem == false) {

                              $delKey = $delRole['key'];
                              $delArg = ( (isset($delRole['compare'])) ? $delRole['compare'] : '==' );
                              $delVal = $delRole['value'];

                              $itemVal = $item->$delKey ?? null;

                              $match = match($delArg) {

                                '=='  => $itemVal == $delVal,
                                '===' => $itemVal === $delVal,
                                '!='  => $itemVal != $delVal,
                                '!==' => $itemVal !== $delVal,
                                '>'   => $itemVal > $delVal,
                                '>='  => $itemVal >= $delVal,
                                '<'   => $itemVal < $delVal,
                                '<='  => $itemVal <= $delVal,

                                default => false,

                              };

                              if($match) {

                                $delItem = true;

                              }

                            }

                          }

                        ?>

                        @if($delItem == false)
                          
                          <span data-bs-toggle="tooltip" data-bs-title="{!! SysAutomator::SysAutomatorGetTranslateWord('Esta opção não pode ser selecionada!') !!}">

                            <input type="checkbox" class="pagination-select-item" id="pagination-select-item-{!! $item->$index !!}" value="{!! $item->$index !!}" disabled />

                          </span>

                        @else
                          
                          <input type="checkbox" class="pagination-select-item" name="items[]" id="pagination-select-item-{!! $item->$index !!}" value="{!! $item->$index !!}" />

                        @endif

                      @else
                        
                        <input type="checkbox" class="pagination-select-item" name="items[]" id="pagination-select-item-{!! $item->$index !!}" value="{!! $item->$index !!}" />

                      @endif
                      
                    </th>

                  @endif

                  @foreach($columns as $col => $config)
                    
                    @php

                      $_classes = '';
                      if(isset($config['body'])) {

                        if(isset($config['body']['class'])) {

                          $_classes = $config['body']['class'];

                        }

                      }

                    @endphp

                    <td class="text-nowrap {!! ( ($_classes != '') ? $_classes : '' ) !!}">

                      @if(isset($config['prefix']))

                        {!! $config['prefix'] !!}

                      @endif

                        @if(isset($config['callback']))

                          {!! $config['callback']($item) !!}

                        @else

                          @if(isset($config['replaced']))

                            {!! $config['replaced'][$item->$col] !!}

                          @else

                            {{ $item->$col }}

                          @endif

                        @endif

                      @if(isset($config['sufix']))

                        {!! $config['sufix'] !!}

                      @endif

                    </td>

                  @endforeach

                  @if(!empty($list_actions))

                    <td class="text-end text-nowrap">

                      <div class="d-flex justify-content-end gap-2">

                        <?php

                          $listActionsC = 0;
                          foreach ($list_actions as $listAction) {
                            
                            $actAdd = false;
                            $actOn  = true;
                            if(array_key_exists('action', $listAction)) {

                              if(array_key_exists($listAction['action'], $actions)) {

                                $listAct = $actions[$listAction['action']];
                                if(SysAutomator::SysAutomatorCheckUserAccess($listAct['route'])) {

                                  $actAdd = true;
                                  if(array_key_exists('roles', $listAct)) {

                                    $actOn = false;
                                    $actRoles = $listAct['roles'];
                                    foreach($actRoles as $actRole) {

                                      if($actOn == false) {

                                        $actKey = $actRole['key'];
                                        $actArg = ( (isset($actRole['compare'])) ? $actRole['compare'] : '==' );
                                        $actVal = $actRole['value'];

                                        $itemVal = $item->$actKey ?? null;

                                        $match = match($actArg) {

                                          '=='  => $itemVal == $actVal,
                                          '===' => $itemVal === $actVal,
                                          '!='  => $itemVal != $actVal,
                                          '!==' => $itemVal !== $actVal,
                                          '>'   => $itemVal > $actVal,
                                          '>='  => $itemVal >= $actVal,
                                          '<'   => $itemVal < $actVal,
                                          '<='  => $itemVal <= $actVal,

                                          default => false,

                                        };

                                        if($match) {

                                          $actOn = true;

                                        }

                                      }

                                    }

                                  }

                                }

                              }

                            } else {

                              $actAdd = true;

                            }

                            if($actAdd == true) {

                              if($actOn == false) {

                                echo '<span class="d-inline-flex align-items-center" data-bs-toggle="tooltip" data-bs-title="' . SysAutomator::SysAutomatorGetTranslateWord('Esta ação não pode ser realizada!') . '">' . "\n";
                                  
                                  if($listAction['type'] == 'button') {

                                    echo '<button type="button" id="' . ( (isset($listAction['id'])) ? $listAction['id'] : '' ) . '-' . $item->$index . '" class="' . ( (isset($listAction['class'])) ? $listAction['class'] : '' ) . ' disabled btn btn-sm text-center"><i class="fa fa-' . $listAction['icon'] . '"></i></button>' . "\n";

                                  }

                                echo '</span>' . "\n";

                              } else {

                                if($listAction['type'] == 'button') {

                                  echo '<button' . ( (isset($listAction['onclick'])) ? ' onclick="' . str_replace('{id}', $item->$index, $listAction['onclick']) . '"' : '' ) . ' data-bs-toggle="tooltip" data-bs-title="' . SysAutomator::SysAutomatorGetTranslateWord($listAction['text']) . '" type="button" id="' . ( (isset($listAction['id'])) ? $listAction['id'] : '' ) . '-' . $item->$index . '" class="' . ( (isset($listAction['class'])) ? $listAction['class'] : '' ) . ' btn btn-sm d-inline-flex align-items-center py-2 text-center"><i class="fa fa-' . $listAction['icon'] . '"></i></button>' . "\n";

                                }

                              }

                            }

                          }

                        ?>

                      </div>

                    </td>

                  @endif

                </tr>


              @empty

                <tr>

                  <td colspan="{{ $cols }}" class="py-5 text-center text-secondary">

                    <div class="d-flex flex-column align-items-center justify-content-center">

                      <i class="fa-solid fa-inbox display-6 text-muted mb-3"></i>
                      <p class="mb-0">Nenhum registro encontrado.</p>

                    </div>

                  </td>

                </tr>

              @endforelse

            </tbody>


          </table>

        </div>


      @if($canDelete == true)
        
        </form>

      @else

        </div>

      @endif
      
    </div>


    @if($items->hasPages())

      <div class="row mt-4">

        {{ $items->links() }}

      </div>
    
    @endif
    

  </div>

</div>
@if(!empty($actions))
  @if(count($actions) >= 1)
    
    <?php

      $_scripts = '';
      foreach ($actions as $_actionKey => $_action) {
        
        if(isset($_action['show'])) {

          if($_action['show'] == true) {

            $_scripts .= 'AutomatorPaginationRoutes.' . $_actionKey . ' = "' . SysAutomator::SysAutomatorGetRouteLinkByName($_action['route'], $_action['params']) . '";' . "\n";
          }

        }

      }

    ?>

    @if($_scripts != '')


        
      <script>

        window.AutomatorPaginationRoutes = window.AutomatorPaginationRoutes || {};

        <?php echo $_scripts; ?>

        console.log(window.AutomatorPaginationRoutes);
        
      </script>

    @endif

  @endif

@endif