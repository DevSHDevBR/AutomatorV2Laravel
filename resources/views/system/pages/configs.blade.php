<div class="container-fluid">

  <div class="row">

    <div class="col-12 mb-3">

      <h3>Utilize o formulário abaixo para realizar as configurações do sistema.</h3>
      
    </div>
    
  </div>
  <form class="row" method="POST" action="">

    @foreach($configs as $config)

      @php
        //var_dump($config);
        $props = json_decode($config['tbl_sys_config_props'], true);
      @endphp
      <div class="{!! $props['wrapper_class'] !!} mb-3">

        <div class="form-floating">

          @if($config['tbl_sys_field_type_ID'] == 15)

            <select class="form-select" name="{!! $config['tbl_sys_config_name'] !!}" id="{!! $config['tbl_sys_config_name'] !!}" {!! ($config['tbl_sys_config_required'] == true) ? 'required' : '' !!}>
              
              @foreach($props['choices'] as $choiceKey => $choiceLabel)

                <option value="{!! $choiceKey !!}">{!! $choiceLabel !!}</option>

              @endforeach

            </select>
            
          @else

            <input type="text" class="form-control" name="{!! $config['tbl_sys_config_name'] !!}" id="{!! $config['tbl_sys_config_name'] !!}" value="{!! $config['tbl_sys_config_value'] !!}" {!! ($config['tbl_sys_config_required'] == true) ? 'required' : '' !!} />

          @endif
          <label for="{!! $config['tbl_sys_config_name'] !!}">{!! $config['tbl_sys_config_description'] !!} {!! ($config['tbl_sys_config_required'] == true) ? '<span class="text-danger">*</span>' : '' !!}</label>
          
        </div>
        
      </div>

    @endforeach
    
  </form>
  
</div>