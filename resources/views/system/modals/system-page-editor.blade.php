@php
  
  $editor = [

    'texts' => [

      //'title-error'     => SysAutomator::SysAutomatorGetTranslateWord('Adicione um titulo para a página para liberar esta ação.'),
      //'name-error'      => SysAutomator::SysAutomatorGetTranslateWord('Adicione um nome para a página para liberar esta ação.'),
      'add-block'       => SysAutomator::SysAutomatorGetTranslateWord('Adicionar bloco.'),
      'structure'       => SysAutomator::SysAutomatorGetTranslateWord('Estrutura'),
      'configs'         => SysAutomator::SysAutomatorGetTranslateWord('Configurações'),
      'resolutions'     => SysAutomator::SysAutomatorGetTranslateWord('Resoluções'),
      'select-block'    => SysAutomator::SysAutomatorGetTranslateWord('Selecione um bloco para editar.'),
      'proprieties'     => SysAutomator::SysAutomatorGetTranslateWord('Propriedades'),
      'blocks'          => SysAutomator::SysAutomatorGetTranslateWord('Blocos'),
      'block'           => SysAutomator::SysAutomatorGetTranslateWord('Bloco'),
      'no-blocks-added' => SysAutomator::SysAutomatorGetTranslateWord('Nenhum bloco adicionado'),
      'computer'        => SysAutomator::SysAutomatorGetTranslateWord('Computador'),
      'large-tablet'    => SysAutomator::SysAutomatorGetTranslateWord('Large Tablet'),
      'tablet'          => SysAutomator::SysAutomatorGetTranslateWord('Tablet'),
      'cellphone'       => SysAutomator::SysAutomatorGetTranslateWord('Celular'),
      'save'            => SysAutomator::SysAutomatorGetTranslateWord('Salvar'),
    
    ],
    'header' => ( (isset($header)) ? ( (is_array($header)) ? $header : [] ) : [] ),
    'fields'  => [
    ],
    'configs' => ( (isset($configs)) ? ( (is_array($configs)) ? $configs : [] ) : [] )

  ];

@endphp
<style type="text/css">



  #automator-editor-modal {

    flex-direction: column;
    background:     #FFFFFF;
    position:       relative;
    overflow:       hidden;
    display:        flex;
    height:         100vh;
    color:          #1E1E1E;

  }


  
</style>



<div id="automator-editor-modal">



  @include('system.components.system-automator-editor', $editor)



</div>