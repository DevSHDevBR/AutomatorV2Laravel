<button
  type="button"
  id="btn-add-route"
  class="btn d-inline-flex align-items-center gap-2 btn-success"
  onclick="AutomatorCreateViewModal(
    { view: 'system-page-editor' },
    {
      size: 'fullscreen',
      backdrop: true,
      keyboard: false,
      keepLoaderUntilCallback: true,

      callback: function(response, modalEl, modal, recordData) {
        SysAutomatorConfigPageEditor(response, modalEl, modal, recordData);
      },

      afterHideOn: function(response, modalEl, modal, recordData) {
        SysAutomatorDestroyPageEditor(response, modalEl, modal, recordData);
      }
    }
  );"
>
  <i class="fa fa-plus"></i>
  Nova Página
</button>
<!-- <button type="button" id="btn-add-route" class="btn d-inline-flex align-items-center gap-2 btn btn-success" onclick="AutomatorCreateViewModal({ view: 'system-page-editor' }, { size: 'fullscreen', backdrop: true, keyboard: false, beforeShow: function(response, modalEl, modal, recordData){ SysAutomatorConfigPageEditor(response, modalEl, modal, recordData); }, callback: function(response, modalEl, modal, recordData ){ SysAutomatorInitPageEditor(response, modalEl, modal, recordData); }, afterHideOn: function(response, modalEl, modal, recordData) { SysAutomatorDestroyPageEditor(response, modalEl, modal, recordData); }});"><i class="fa fa-plus"></i> Nova Página</button> -->
<!-- 

<style>

    textarea{
        width:100%;
        height:300px;
        padding:15px;
        border:1px solid #ccc;
        border-radius:10px;
        resize:none;
        font-size:14px;
    }


    .formulario{
        margin-top:30px;
        background:#fff;
        padding:20px;
        border-radius:10px;
    }

    .campo{
        margin-bottom:15px;
    }

    .campo label{
        display:block;
        margin-bottom:5px;
        font-weight:bold;
    }

    .campo input{
        width:100%;
        padding:10px;
        border:1px solid #ccc;
        border-radius:8px;
    }
</style>

<h2>Mensagem WhatsApp</h2>

<textarea id="mensagem"></textarea>

<button class="btn btn-primary" id="processar">
    Processar Mensagem
</button>

<div class="formulario">

    <h2>Dados Extraídos</h2>

    <div class="campo">
        <label>Nome Completo</label>
        <input type="text" id="nome_completo">
    </div>

    <div class="campo">
        <label>Endereço</label>
        <input type="text" id="endereco">
    </div>

    <div class="campo">
        <label>Cidade</label>
        <input type="text" id="cidade">
    </div>

    <div class="campo">
        <label>Bairro</label>
        <input type="text" id="bairro">
    </div>

    <div class="campo">
        <label>CEP</label>
        <input type="text" id="cep">
    </div>

    <div class="campo">
        <label>RG</label>
        <input type="text" id="rg">
    </div>

    <div class="campo">
        <label>CPF</label>
        <input type="text" id="cpf">
    </div>

    <div class="campo">
        <label>Telefone</label>
        <input type="text" id="telefone">
    </div>

    <div class="campo">
        <label>E-mail</label>
        <input type="text" id="email">
    </div>

    <div class="campo">
        <label>Nome Animal</label>
        <input type="text" id="animal_nome">
    </div>

    <div class="campo">
        <label>Raça</label>
        <input type="text" id="animal_raca">
    </div>

    <div class="campo">
        <label>Espécie</label>
        <input type="text" id="animal_especie">
    </div>

    <div class="campo">
        <label>Sexo</label>
        <input type="text" id="animal_sexo">
    </div>

    <div class="campo">
        <label>Cor</label>
        <input type="text" id="animal_cor">
    </div>

    <div class="campo">
        <label>Data Óbito</label>
        <input type="text" id="animal_obito">
    </div>

    <div class="campo">
        <label>Causa Contagiosa</label>
        <input type="text" id="contagiosa">
    </div>

    <div class="campo">
        <label>Marca-passo</label>
        <input type="text" id="marca_passo">
    </div>

    <div class="campo">
        <label>Tipo Cremação</label>
        <input type="text" id="cremacao">
    </div>

    <div class="campo">
        <label>Endereço Retirada</label>
        <input type="text" id="retirada_endereco">
    </div>

    <div class="campo">
        <label>Cidade Retirada</label>
        <input type="text" id="retirada_cidade">
    </div>

    <div class="campo">
        <label>Bairro Retirada</label>
        <input type="text" id="retirada_bairro">
    </div>

    <div class="campo">
        <label>Forma Pagamento</label>
        <input type="text" id="pagamento">
    </div>

    <div class="campo">
        <label>Origem</label>
        <input type="text" id="origem">
    </div>

</div>

<script>

function obterCampo(texto, campo){

    let regex = new RegExp(campo + "\\s*:\\s*(.*)", "i");

    let resultado = texto.match(regex);

    return resultado ? resultado[1].trim() : '';
}

$('#processar').on('click', function(){

    let texto = $('#mensagem').val();

    $('#nome_completo').val(
        obterCampo(texto, 'Nome Completo')
    );

    $('#endereco').val(
        obterCampo(texto, 'Endereço')
    );

    $('#cidade').val(
        obterCampo(texto, 'Cidade')
    );

    $('#bairro').val(
        obterCampo(texto, 'Bairro')
    );

    $('#cep').val(
        obterCampo(texto, 'CEP')
    );

    $('#rg').val(
        obterCampo(texto, 'RG')
    );

    $('#cpf').val(
        obterCampo(texto, 'CPF')
    );

    $('#telefone').val(
        obterCampo(texto, 'Telefone e Celular')
    );

    $('#email').val(
        obterCampo(texto, 'E-mail')
    );

    $('#animal_nome').val(
        obterCampo(texto, 'Nome')
    );

    $('#animal_raca').val(
        obterCampo(texto, 'Raça')
    );

    $('#animal_especie').val(
        obterCampo(texto, 'Espécie')
    );

    $('#animal_sexo').val(
        obterCampo(texto, 'Sexo')
    );

    $('#animal_cor').val(
        obterCampo(texto, 'Cor')
    );

    $('#animal_obito').val(
        obterCampo(texto, 'Data Óbito')
    );

    $('#contagiosa').val(
        obterCampo(texto, 'Causa da Morte é contagiosa\\?')
    );

    $('#marca_passo').val(
        obterCampo(texto, 'Possui marca-passo\\?')
    );

    $('#cremacao').val(
        obterCampo(texto, 'Tipo de cremação')
    );

    $('#retirada_endereco').val(
        obterCampo(texto, 'Endereço de retirada')
    );

    $('#retirada_cidade').val(
        obterCampo(texto, 'Cidade')
    );

    $('#retirada_bairro').val(
        obterCampo(texto, 'Bairro')
    );

    $('#pagamento').val(
        obterCampo(texto, 'Forma de Pagamento')
    );

    $('#origem').val(
        obterCampo(texto, 'Como você ficou sabendo de nossos serviços\\?')
    );

});

</script> -->
<?php
  
  // $form = SysAutomator::SysAutomatorRenderFormByID(1);
  // echo $form['html'];
  // echo '<pre>';
  // echo ($form['html']);
  // echo '</pre>';

?>