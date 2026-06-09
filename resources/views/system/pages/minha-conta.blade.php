@php
  
  $form = SysAutomator::SysAutomatorRenderFormByID(SysAutomator::SysAutomatorGetFormIDByName('admin-minha-conta'), $currentUser);

  echo $form['html'];

@endphp