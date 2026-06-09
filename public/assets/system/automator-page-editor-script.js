/**
 * AUTOMATOR PAGE EDITOR SCRIPT - VERSION 4.3 (CRITICAL FIXES)
 * Sistema de blocos dinâmicos com suporte a aninhamento, persistência de propriedades e Sortable total.
 */

window.SysAutomatorEditor = (function() {



  const defaultState = {

    activeBlock:       null,
    isNew:             true,
    hasChanges:        false,
    previewBreakpoint: 'col-xxl-',
    argCount:          0,
    blockConfigs:      {}

  };



  let state = {

    activeBlock:       null,
    isNew:             true,
    hasChanges:        false,
    previewBreakpoint: 'col-xxl-',
    argCount:          0,
    blockConfigs:      {}

  };


  const defaultEditor = {

    defalutEmpty:  {
      placeholder: 'Digite um conteudo para o bloco',
      editor:     '',
      block:       'Adicione um conteudo ao bloco',
    },
    defalutAdd:  {
      text:   'Digite o texto para o bloco',
      editor: 'Adicione o conteudo para o bloco',
      block:  'Adicionar conteudo ao bloco',
    },
    addBlockBTN:   'Adicionar bloco',
    settingsBlock: {

        collapsed: false,
        tab: 'page-settings'

    },

    content: ''


  };



  let editor = $.extend(
      true,
      {},
      defaultEditor
  );



  const selectors = {

    resolutionsBtns: '#automator-editor-header-resolutions-dropdown',
    configsBtn:      '#automator-editor-header-configs-button',
    saveBtn:         '#automator-editor-header-save-button',
    inserterBlock:   '#automator-editor-body-aside-left-inserter',
    inserterList:    '#automator-editor-body-aside-left-inserter-list',
    structureBlock:  '#automator-editor-body-aside-left-structure',
    structureList:   '#automator-editor-body-aside-left-structure-list',
    settingsBlock:   '#automator-editor-body-aside-right-tabs-container-block-render',
    rightArea:       '#automator-editor-body-aside-right',
    canvas:          '#automator-editor-body-canvas-content-container-render-area',
    actionsBtn:      '.automator-editor-actions-button'
  
  };



  let interfaceInitialized = false;


  function isHierarchyLocked(block) {
    if (!block) return false;
    if (block.classList.contains('is-locked')) return true;
    
    // Verifica recursivamente nos filhos
    const lockedChildren = block.querySelectorAll('.automator-editor-block.is-locked');
    return lockedChildren.length > 0;
  }



  function destroy() {

    $(selectors.canvas).empty();

    
    $(selectors.settingsBlock).html('<p class="text-muted text-center py-5 small">Selecione um bloco para editar.</p>');

    
    $(selectors.structureList).html('<div class="text-muted text-center py-5 small">Nenhum bloco adicionado.</div>');

    
    state = $.extend(
        true,
        {},
        defaultState
    );

    
    editor = $.extend(
        true,
        {},
        defaultEditor
    );


    console.log('Editor destruído');

    interfaceInitialized = false;


  }



  function config(data = {}) {

    
    editor = $.extend(
      true,
      {},
      defaultEditor
    );

 

    if(typeof data.isNew !== 'undefined') {

      state.isNew = data.isNew;

    }

    
    if(data.editor) {

      $.extend(
        true,
        editor,
        data.editor
      );

    }


  }


  function init(callback = null) {
    const id = Date.now();
    const wrapper = document.createElement('div');
    wrapper.id = `block-${id}`;
    wrapper.className = 'automator-editor-block is-active automator-editor-block-can-have-child automator-editor-block-is-empty';
    
    wrapper.setAttribute('data-block-id', id);
    wrapper.setAttribute('data-block-name', "Conteúdo");
    wrapper.setAttribute('data-automator-default', "true"); // Marca como ROOT
    wrapper.setAttribute('data-block-add', editor.defalutAdd.block);

    wrapper.innerHTML = `
      <div class="automator-editor-block-render-area automator-editor-block-child-area" data-block-empty="${editor.defalutEmpty.block || ''}"></div>
    `;

    // O Root não tem clique de seleção para evitar confusão, ele é o container base
    $(selectors.canvas).html(wrapper);
    state.activeBlock = wrapper;
    state.blockConfigs[id] = { can_have_child: true, is_root: true, title: 'Conteúdo', properties: {} };

    // Inicializa sortable APENAS na área interna do root
    initSortable(wrapper.querySelector('.automator-editor-block-render-area'));
  }
  // function init(callback = null) {


  //   const id = Date.now();


  //   const wrapper = document.createElement('div');

  //   wrapper.id = `block-${id}`;

  //   wrapper.className = 'automator-editor-block';
    
  //   wrapper.classList.add('is-active', 'automator-editor-block-can-have-child');


  //   if(editor.content == '') wrapper.classList.add('automator-editor-block-is-empty');


  //   wrapper.setAttribute('data-block-id', id);
  //   wrapper.setAttribute('data-block-name', "Conteúdo");
  //   wrapper.setAttribute('data-automator-default', "true");
  //   wrapper.setAttribute('data-block-add', editor.defalutAdd.block);

  //   let wrapperElement = `
  //     <div class="automator-editor-block-render-area automator-editor-block-child-area" data-block-empty="` + (editor.defalutEmpty.block || '') + `">` + (editor.content || '') + `</div>
  //   `;

  //   wrapper.innerHTML = wrapperElement;

  //   wrapper.onclick = (e) => {

  //     e.stopPropagation();
  //     selectBlock(wrapper);

  //   };

  //   $(selectors.canvas).html(wrapper);


  //   state.activeBlock = wrapper;

  //   state.blockConfigs[id] = {

  //     can_have_child: true,

  //     is_root: true,

  //     title: 'Conteúdo',

  //     description: '',

  //     icon: '',

  //     properties: {}

  //   };


  //   initSortable(document.querySelector(selectors.canvas));


  // }


  function initSortable(el) {
    if (!el) return;
    if ($(el).data('sortable')) return;

    new Sortable(el, {
      group: 'nested-blocks',
      animation: 150,
      fallbackOnBody: true,
      swapThreshold: 0.65,
      handle: '.automator-editor-block-handle',
      draggable: '.automator-editor-block',
      ghostClass: 'automator-editor-sortable-placeholder',
      
      onMove: function (evt) {
        const draggedEl = evt.dragged;
        const targetArea = evt.to; 
        const targetBlock = $(targetArea).closest('.automator-editor-block');

        // 1. Root não move
        if (draggedEl.getAttribute('data-automator-default') === 'true') return false;

        // 2. BLOQUEIO HIERÁRQUICO: Não move se ele ou algum filho estiver bloqueado
        if (isHierarchyLocked(draggedEl)) return false;

        // 3. Não move para o canvas principal (fora do root)
        if (targetArea.id === selectors.canvas.replace('#', '')) return false;

        // 4. Não permite mover para dentro de blocos bloqueados
        if (targetBlock.length && targetBlock.hasClass('is-locked')) return false;

        // 5. Validação de can_have_child
        if (targetBlock.length) {
          const targetId = targetBlock.attr('data-block-id');
          const config = state.blockConfigs[targetId];
          if (config && !config.can_have_child) return false;
        }

        return true;
      },

      onEnd: function(evt) {
        updateStructureList();
      }
    });

    $(el).data('sortable', true);
  }
  // function initSortable(el) {


  //   if (!el) return;

  //   if ($(el).data('sortable')) {
      
  //     return;

  //   }

  //   new Sortable(el, {

  //     group:          'nested-blocks',
  //     animation:      150,
  //     fallbackOnBody: true,
  //     swapThreshold:  0.65,
  //     handle:         '.automator-editor-block-handle',
  //     draggable:      '.automator-editor-block',
  //     onEnd: function(evt) {


  //       const fromBlock = $(evt.from).closest('.automator-editor-block');

  //       const toBlock = $(evt.to).closest('.automator-editor-block');

  //       if (fromBlock.length) {

  //         const area = fromBlock.find('> .automator-editor-block-render-area');

  //         if ( area.children('.automator-editor-block').length === 0 ) {
  //           fromBlock.addClass('automator-editor-block-is-empty');
  //         }

  //       }


  //       if (toBlock.length) {

  //         toBlock.removeClass('automator-editor-block-is-empty');

  //       }

  //       updateStructureList();
  //       state.hasChanges = true;


  //     }

  //   });


  //   $(el).data('sortable', true);


  // }



  function initInterface(callback = null) {


    console.log('Editor interface start!');
    
    if(interfaceInitialized){ return; }

    interfaceInitialized = true;

    const popoverTriggerList = document.querySelectorAll('[data-bs-toggle="popover"]')
    const popoverList = [...popoverTriggerList].map(popoverTriggerEl => new bootstrap.Popover(popoverTriggerEl))

    if(typeof callback === 'function') {

      callback({
        
        state,
        editor,
        selectors

      });

    }


  }



  function switchLeftTab(tab) {


    const sidebar = $('#automator-editor-body-aside-left');
    const isCollapsed = sidebar.hasClass('collapsed');

    if (isCollapsed) {

      sidebar.removeClass('collapsed');
      updateLeftTabVisibility(tab);

    } else {

      const currentTabId = tab === 'inserter' ? '#automator-editor-body-aside-left-inserter' : '#automator-editor-body-aside-left-structure';
      if ($(currentTabId).hasClass('d-none')) {
        
        sidebar.addClass('collapsed');
        setTimeout(() => {

          updateLeftTabVisibility(tab);
          sidebar.removeClass('collapsed');

        }, 350);

      } else {
        
        sidebar.addClass('collapsed');
      
      }
    
    }
  

  }



  function updateLeftTabVisibility(tab) {


    if (tab === 'inserter') {

      $('#automator-editor-body-aside-left-inserter').removeClass('d-none');
      $('#automator-editor-body-aside-left-structure').addClass('d-none');

    } else {

      $('#automator-editor-body-aside-left-inserter').addClass('d-none');
      $('#automator-editor-body-aside-left-structure').removeClass('d-none');
    
    }


  }



  function toggleSidebar(side) {


    const id = '#automator-editor-body-aside-' + side;
    $(id).toggleClass(window.innerWidth <= 991.98 ? 'show' : 'collapsed');


  }



  function switchTab(tab) {


    $('.automator-editor-body-aside-right-tabs-button').removeClass('active');
    $(`#automator-editor-body-aside-right-tabs-button-${tab}`).addClass('active');

    $(`.automator-editor-body-aside-right-tabs-container-items`).addClass('d-none');
    $(`#automator-editor-body-aside-right-tabs-container-${tab}`).removeClass('d-none');


  }



  function insertField(fieldID) {
    

    if (typeof AutomatorGetActionStatus === 'function') {
    
      AutomatorGetActionStatus(() => includeField(fieldID));
    
    } else {
    
      includeField(fieldID);
    
    }


  }



  function includeField(fieldID) {


    AutomatorSetActionStatus(true, () => {
      
      AutomatorPageLoader('show', () => {
        
        $.ajax({

          url:     window.AutomatorRoutes.apiEditor || '',
          type:    'POST',
          headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), 'Accept': 'application/json' },
          data:    { fieldTypeID: fieldID },
          success: function(response) {
            
            AutomatorPageLoader('hide', () => {

              AutomatorSetActionStatus(false, () => {

                if(response.status == true) {

                  if(response.automator) injectBlock(response.automator);

                }

              });

            });


          },
          error: function() {

            AutomatorPageLoader('hide', () => AutomatorSetActionStatus(false));
            alert('Erro ao carregar campo.');

          }

        });

      });

    });


  }


  function injectBlock(field) {
    const id = Date.now();
    state.blockConfigs[id] = JSON.parse(JSON.stringify(field));

    const wrapper = document.createElement('div');
    wrapper.id = `block-${id}`;
    wrapper.className = 'automator-editor-block';

    if (field.can_have_child) {
      wrapper.classList.add('automator-editor-block-can-have-child', 'automator-editor-block-is-empty');
    }

    if (field.class) wrapper.classList.add(field.class);

    wrapper.setAttribute('data-block-id', id);
    wrapper.setAttribute('data-block-name', field.title);
    wrapper.setAttribute('data-block-add', (field.can_have_child ? editor.defalutAdd.block : (field.editor ? editor.defalutAdd.editor : editor.defalutAdd.text)));

    // Lógica de clique corrigida
    wrapper.onclick = (e) => {
      e.stopPropagation();
      
      const rect = wrapper.getBoundingClientRect();
      const clickY = e.clientY - rect.top;
      // Detecta clique na área do :after para blocos que aceitam filhos
      const isAfterArea = field.can_have_child && (clickY > (rect.height - 60)); 

      selectBlock(wrapper);

      if (isAfterArea) {
        switchLeftTab('inserter');
      }
    };

    let wrapperElement = renderFieldElement(id, field);
    wrapper.innerHTML = wrapperElement;

    // Determina destino correto: Se houver ativo e aceitar filhos, insere nele.
    let targetContainer;
    if (state.activeBlock) {
      const activeId = state.activeBlock.getAttribute('data-block-id');
      const activeConfig = state.blockConfigs[activeId];
      if (activeConfig && activeConfig.can_have_child) {
        targetContainer = $(state.activeBlock).children('.automator-editor-block-render-area').first();
      }
    }

    // Fallback para o root
    if (!targetContainer || targetContainer.length === 0) {
      const root = $(selectors.canvas).find('.automator-editor-block[data-automator-default="true"]').first();
      targetContainer = root.children('.automator-editor-block-render-area').first();
    }

    targetContainer.append(wrapper);
    targetContainer.closest('.automator-editor-block').removeClass('automator-editor-block-is-empty');
    
    if (field.can_have_child) {
      const sortableArea = wrapper.querySelector('.automator-editor-block-render-area');
      if (sortableArea) initSortable(sortableArea);
    }

    selectBlock(wrapper);
    updateStructureList();
    state.hasChanges = true;
  }
  // function injectBlock(field) {


  //   const id = Date.now();
  //   state.blockConfigs[id] = JSON.parse(JSON.stringify(field));

  //   const wrapper = document.createElement('div');
  //   wrapper.id = `block-${id}`;
  //   wrapper.className = 'automator-editor-block';

  //   if (field.can_have_child) {
      
  //     wrapper.classList.add('automator-editor-block-can-have-child', 'automator-editor-block-is-empty');

  //   }

  //   if (field.class) {
  //     wrapper.classList.add('' + field.class);
  //   }

  //   wrapper.setAttribute('data-block-id', id);
  //   wrapper.setAttribute('data-block-name', field.title);
  //   wrapper.setAttribute('data-block-add', ( (field.can_have_child == true) ? editor.defalutAdd.block : ( (field.editor == true) ? editor.defalutAdd.editor : editor.defalutAdd.text ) ));

  //   let props = field.props;
  //   if(Object.keys(props).length >= 1) {
  //     $.each(props, function(propKey, propVal) {
  //       wrapper.setAttribute('data-block-' + propKey, propVal);
  //     });
  //   }

  //   let wrapperElement = renderFieldElement(id, field);
  //   wrapper.innerHTML = wrapperElement;

  //   wrapper.onclick = (e) => {

  //     e.stopPropagation();

  //     const current = e.currentTarget;

  //     selectBlock(current);
  //     // e.stopPropagation();
  //     // selectBlock(wrapper);
  //   };

  //   // Determina o container de destino correto
  //   let targetContainer;

  //   if (state.activeBlock) {

  //     const activeId     = state.activeBlock.getAttribute('data-block-id');
  //     const activeConfig = state.blockConfigs[activeId];

  //     if (activeConfig && activeConfig.can_have_child) {

  //       // Busca o render-area DIRETO do bloco ativo (não de todos do canvas)
  //       targetContainer = $(state.activeBlock).children('.automator-editor-block-render-area').first();
  //       $(state.activeBlock).removeClass('automator-editor-block-is-empty');

  //     } else {

  //       // Bloco ativo não aceita filhos — insere no container raiz
  //       // targetContainer = $(selectors.canvas);
  //       targetContainer = $(selectors.canvas).children('.automator-editor-block').first().children('.automator-editor-block-render-area').first();

  //     }

  //   } else {

  //     // Sem bloco ativo — insere no container raiz
  //     // targetContainer = $(selectors.canvas);
  //     targetContainer = $(selectors.canvas).children('.automator-editor-block').first().children('.automator-editor-block-render-area').first();

  //   }

  //   targetContainer.append(wrapper);

  //   AutomatorInitBootstrapTooltips();
  //   switchLeftTab('inserter');

  //   if (field.can_have_child) {

  //     const sortableArea = wrapper.querySelector('.automator-editor-block-render-area');

  //     if (sortableArea) {
        
  //       initSortable(sortableArea);

  //     }

  //   }

  //   selectBlock(wrapper);
  //   if(field.editor == true) {

  //     // focusEditor(id, field.tag);

  //   }

  //   // console.log(state);
  //   updateStructureList();
  //   state.hasChanges = true;

  // }



  function renderFieldElement(id, field) {



    let toolbarHTML = '';
    let toolbarHTMLC = 0;

    field.toolbar.forEach(btn => {
      
      toolbarHTML += `<button type="${btn.type || 'button'}" class="${btn.class}" data-bs-toggle="tooltip" data-bs-title="${btn.title}" onclick="${btn.onclick}">${btn.label}</button>`;
      toolbarHTMLC++;

    });

    
    var renderArea  = '<div class="automator-editor-block-handle"><i class="fas fa-grip-vertical"></i></div>' + "\n";
        renderArea += '<div class="automator-editor-block-toolbar">' + "\n";
          
          if(toolbarHTMLC >= 1) {

            renderArea += `${toolbarHTML}` + "\n";
            renderArea += '<div class="vr mx-1"></div>' + "\n";

          }
          renderArea += `<button type="button" class="btn btn-xs btn-light border" onclick="SysAutomatorEditor.moveBlock('${id}', 'up')" data-bs-toggle="tooltip" data-bs-title="Mover para cima"><i class="fas fa-chevron-up"></i></button>` + "\n";
          renderArea += `<button type="button" class="btn btn-xs btn-light border" onclick="SysAutomatorEditor.moveBlock('${id}', 'down')" data-bs-toggle="tooltip" data-bs-title="Mover para baixo"><i class="fas fa-chevron-down"></i></button>` + "\n";
          renderArea += '<div class="vr mx-1"></div>' + "\n";
          renderArea += `<button type="button" id="automator-editor-lock-btn-${id}" onclick="SysAutomatorEditor.toggleLock('${id}')" class="btn btn-xs btn-light border lock-btn" data-bs-toggle="tooltip" data-bs-title="Travar/Destravar Campo"><i class="fas fa-lock-open"></i></button>` + "\n";
          renderArea += `<button type="button" class="btn btn-xs btn-light border text-danger" onclick="SysAutomatorEditor.deleteBlock('${id}')" data-bs-toggle="tooltip" data-bs-title="Excluir campo"><i class="fas fa-trash"></i></button>` + "\n";
          // renderArea += '<div class="vr mx-1"></div>' + "\n";
          // renderArea += `<button type="button" class="btn btn-xs btn-light border" onclick="SysAutomatorEditor.addBlock('${id}', 'before')" data-bs-toggle="tooltip" data-bs-title="Adicionar antes"><i class="fa fa-plus"></i><span style="font-size: 10px; position: relative; top: -6px; right: -5px;"><i class="fa fa-angle-up"></i></span></button>` + "\n";
          // renderArea += `<button type="button" class="btn btn-xs btn-light border" onclick="SysAutomatorEditor.addBlock('${id}', 'after')" data-bs-toggle="tooltip" data-bs-title="Adicionar antes"><i class="fa fa-plus"></i><span style="font-size: 10px; position: relative; top: -6px; right: -5px;"><i class="fa fa-angle-down"></i></span></button>` + "\n";


        renderArea += '</div>' + "\n";
        renderArea += '<div class="automator-editor-block-render-area' + ( (field.can_have_child) ? ' automator-editor-block-child-area' : '' ) + '' + ( (field.class) ? ' ' + field.class : '' ) + '" data-block-empty="' + ( (field.can_have_child) ? editor.defalutEmpty.block : ( (field.editor == true) ? editor.defalutEmpty.content : editor.defalutEmpty.placeholder ) )  + '" data-block-add="' + ( (field.can_have_child) ? editor.defalutAdd.block : ( (field.editor == true) ? editor.defalutAdd.editor : editor.defalutAdd.text ) ) + '">' + "\n";
        


    if (field.can_have_child) {

      renderArea += '</div>' + "\n";

    } else {

        renderArea += field.prefix + "\n";
        renderArea += field.sufix + "\n";

      renderArea += '</div>' + "\n";

    }

    return renderArea;
    

  }



  function selectBlock(block) {


    if(!block) { return; }
    
    if(state.activeBlock) {
      state.activeBlock.classList.remove('is-active');
    }

    state.activeBlock = block;
    state.activeBlock.classList.add('is-active');
    
    const id = block.getAttribute('data-block-id');
    const field = state.blockConfigs[id];
    
    if(
        field &&
        field.properties
    ) {

      if (field && field.can_have_child) {
        switchLeftTab('inserter');
      } else {

      }

      renderBlockSettings(block, id, field);

    } else {

      const defaultButton = $(selectors.rightArea).find('.automator-editor-body-aside-right-tabs-button[data-automator-default="true"]');
      defaultButton.trigger('click');

    }
    
    // renderBlockSettings(block, id, field);


  }



  function deselectAll(event = null) {


    if (event && $(event.target).closest('.automator-editor-block').length) {
      
      return;

    }


    $('.automator-editor-block').removeClass('is-active');


    state.activeBlock = null;


    const defaultButton  = $(selectors.rightArea).find('.automator-editor-body-aside-right-tabs-button[data-automator-default="true"]');
    const defaultContent = $(selectors.rightArea).find('.automator-editor-body-aside-right-tabs-container-items[data-automator-default="true"]');

    $(selectors.rightArea).find('.automator-editor-body-aside-right-tabs-button').removeClass('active').prop('disabled', true);

    $(selectors.rightArea).find('.automator-editor-body-aside-right-tabs-container-items').removeClass('active').addClass('d-none');

    if (defaultButton.length && defaultContent.length) {

      defaultButton.addClass('active').prop('disabled', false);
      defaultContent.removeClass('d-none').addClass('active');
      $('#automator-editor-body-aside-right-tabs-container-block').addClass('d-none');

    } else {

      $('#automator-editor-body-aside-right-tabs-container-block').removeClass('d-none');
      $(selectors.settingsBlock).html('<p class="text-muted text-center py-5 small">' + $(selectors.settingsBlock).attr('data-default') + '</p>');

    }


  }



  function renderBlockSettings(block, blockID, field) {


    if(!field) return;

    if(field.is_root) {

        switchTab(
            $('.automator-editor-body-aside-right-tabs-button[data-automator-default="true"]')
                .attr('id')
                .replace(
                    'automator-editor-body-aside-right-tabs-button-',
                    ''
                )
        );

        return;
    }
    
    $('#automator-editor-body-aside-right-tabs-button-block').prop('disabled', false);
    var blocks = field['properties'];

    var blockHTML = `

      <div class="row">
        
        <div class="col-12 m-3">
          
          <h6 class="fw-bold"><i class="fa fa-${field['icon'] || 'cube'} me-2 d-inline-block small"></i> ${field['title']}</h6>

        </div>
        <div class="col-12 m-3 mt-0 small text-muted">${field['description'] || ''}</div>
        <div class="col-12 mb-3">
          
          <div class="accordion" id="block-settings-rendered-${blockID}">`;

            $.each(blocks, function(blockKey, blockItem) {
              
              blockHTML += `
              <div class="accordion-item" style="border-radius: 0px !important;">
                <h2 class="accordion-header">

                  <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#block-settings-rendered-${blockID}-${blockKey}">${blockItem['label']}</button>
                
                </h2>
                <div id="block-settings-rendered-${blockID}-${blockKey}" class="accordion-collapse collapse">
                  <div class="accordion-body">`;

                    $.each(blockItem['fields'], function(fieldKey, fieldItem) {

                      blockHTML += `<div class="col-12 mb-3">${renderBlockSettingsField(blockID, blockKey, fieldKey, fieldItem)}</div>`;

                    });

                  blockHTML += `</div>`;

                blockHTML += `</div>`;

              blockHTML += `</div>`;

            });

          blockHTML += `</div>`;
      
      blockHTML += `</div>`;

    blockHTML += `</div>`;
    
    $(selectors.settingsBlock).html(blockHTML);
    switchTab('block');
  

  }



  function renderBlockSettingsField(blockID, blockKey, fieldKey, fieldItem) {


    const label = `<label class="form-label small fw-bold">${fieldItem.label}</label>`;
    const name  = `${blockKey}.${fieldKey}`;
    const val   = fieldItem.default || '';
    

    switch(fieldItem.field) {

      case 'color-picker':


        return `
          
          <div class="d-flex align-items-center justify-content-between mb-2">

            <label class="small fw-bold">${fieldItem.label}</label>
            <div class="automator-editor-custom-color-picker">

              <input type="color" name="${name}" value="${val}" data-block-id="${blockID}" />

            </div>

          </div>

        `;


      case 'radio-buttons':
        

        let radios = `<div class="btn-group w-100" role="group">`;
          
          $.each(fieldItem.choices, function(k, v) {
            
            radios += `<input type="radio" class="btn-check" name="${name}" id="btn-${blockID}-${k}" value="${k}" ${val === k ? 'checked' : ''} data-block-id="${blockID}" />
                       <label class="btn btn-outline-secondary btn-sm" for="btn-${blockID}-${k}">${v}</label>`;
          
          });

        return `${label}${radios}</div>`;


      case 'select':
        

        let selects = `<div class="form-floating">`;
          
          selects += `<select name="${name}" class="form-select" data-block-id="${blockID}">`;
          
            $.each(fieldItem.choices, function(k, v) {
          
              selects += `<option value="${k}" ${val === k ? 'selected' : ''}>${v}</option>`;
          
            });
          
          selects += `</select>`;

        return `${selects}${label}</div>`;


      case 'range':
        

        let oninput = 'SysAutomatorEditor.updateRangeInputViewValue(this)';
        if(fieldItem.oninput) {

          oninput = '' + fieldItem.oninput;

        }

        return `

          <div class="row">

            <div class="col-8">

              ${label}
              <input type="range" class="form-range" name="${name}" value="${val}" data-block-id="${blockID}" min="${fieldItem.minval}" max="${fieldItem.maxval}" oninput="${oninput}" />

            </div>
            <div class="col-4">

              <input type="number" class="form-control form-control-sm" name="${name}-value" value="${val}" data-block-id="${name}-${blockID}-value" min="${fieldItem.minval}" max="${fieldItem.maxval}" />

            </div>

          </div>

        `;


      case 'textarea':
      

        return `

          <div class="form-floating">
        
            <textarea class="form-control form-control-sm" name="${name}" rows="5" data-block-id="${blockID}" placeholder="${fieldItem.label}">${val}</textarea>
            ${label}

          </div>

        `;
      
      default:
        

        return `

          <div class="form-floating">

            <input type="text" class="form-control form-control-sm" name="${name}" value="${val}" data-block-id="${blockID}" placeholder="${fieldItem.label}" />
            ${label}

          </div>

        `;


    }


  }



  function updateStructureList() {
    

    const list = $(selectors.structureList);
    list.empty();
    

    function buildTree(container, level = 0) {


      $(container).children('.automator-editor-block').each(function() {

        const id       = this.getAttribute('data-block-id');
        const isLocked = this.classList.contains('automator-editor-block-is-locked');
        const config   = state.blockConfigs[id] || {};

        if (config.is_root === true || this.getAttribute('data-automator-default') === 'true') {

          const rootArea = $(this).children('.automator-editor-block-render-area').first();

          if(rootArea.length) {
            buildTree(rootArea[0], level);
          }

          return;

        }

        const title    = config.title || `Bloco`;
        const icon     = config.icon || 'cube';

        const item = $(`

          <div class="automator-editor-body-aside-left-structure-item d-flex align-items-center p-2 border-bottom" data-id="${id}" data-container-name="${config.title}" style="padding-left: ${level * 20 + 10}px !important;">
            
            <i class="fas fa-grip-vertical automator-editor-body-aside-left-structure-item-structure-handle me-2 text-muted"></i>
            <i class="fa fa-${icon} me-2 small text-primary"></i>
            <span class="small flex-grow-1 text-truncate cursor-pointer" onclick="SysAutomatorEditor.scrollToBlock('${id}')">
              ${title} ${isLocked ? '<i class="fas fa-lock ms-1 text-warning"></i>' : ''}
            </span>
            <button type="button" class="btn btn-xs btn-light" onclick="SysAutomatorEditor.toggleLock('${id}'); event.stopPropagation();">
              
              <i class="fas ${isLocked ? 'fa-lock' : 'fa-lock-open'}"></i>

            </button>
            <button type="button" class="btn btn-xs btn-light text-danger ms-1" onclick="AutomatorPageEditor.deleteBlock('${id}'); event.stopPropagation();">
              
              <i class="fas fa-trash"></i>

            </button>

          </div>

        `);
        list.append(item);

        const childArea = $(this).children('.automator-editor-block-render-area').first();
        if (childArea.length > 0) {

          buildTree(childArea, level + 1);

        }


      });


    }


    buildTree(document.querySelector(selectors.canvas));

    // Habilita Sortable na lista de estrutura para reordenação linear
    if (list[0] && !list.hasClass('sortable-initialized')) {
      

      new Sortable(list[0], {

        animation: 150,
        handle:    '.automator-editor-body-aside-left-structure-item-structure-handle',
        onEnd:     function() {

          // const order = Array.from(list[0].children).map(el => el.dataset.id);
          // syncCanvasOrder(order);
          updateStructureList();

        }

      });
      
      list.addClass('sortable-initialized');

    
    }
  

  }



  function moveBlock(id, direction) {
    

    const block = document.getElementById(`block-${id}`);
    if (!block || block.classList.contains('is-locked')) return;
    
    if (direction === 'up') {

      const prev = block.previousElementSibling;
      if (prev && prev.classList.contains('wp-block')) {
        
        block.parentNode.insertBefore(block, prev);

      }

    } else {

      const next = block.nextElementSibling;
      if (next && next.classList.contains('wp-block')) {
      
        block.parentNode.insertBefore(next, block);
      
      }
    
    }

    updateStructureList();
  

  }



  function syncCanvasOrder(order) {


    const root = $(selectors.canvas).find('.automator-editor-block[data-automator-default="true"]').first();

    if (!root.length) {

      return;

    }


    const target = root.children('.automator-editor-block-render-area').first();

    order.forEach(id => {

      const block = document.getElementById(`block-${id}`);

      if (block && block.parentNode === target[0]) {

        target.append(block);

      }

    });


    updateStructureList();


  }


  function toggleLock(id) {
    const block = document.getElementById(`block-${id}`);
    if(!block) return;
    
    const isLocked = block.classList.contains('is-locked');
    const newLockState = !isLocked;

    // Função recursiva para bloquear sub-itens
    const setLockRecursive = (el, lock) => {
      el.classList.toggle('is-locked', lock);
      const bid = el.getAttribute('data-block-id');
      $(`#automator-editor-lock-btn-${bid} i`).attr('class', `fas ${lock ? 'fa-lock' : 'fa-lock-open'}`);
      
      // Bloqueia edição de conteúdo
      const content = el.querySelector('.automator-editor-block-render-area');
      if(content) content.setAttribute('contenteditable', !lock);

      // Se estiver bloqueando, bloqueia todos os filhos
      if (lock) {
        $(el).find('.automator-editor-block').each(function() {
          setLockRecursive(this, true);
        });
      }
    };

    setLockRecursive(block, newLockState);
    updateStructureList();
  }
  // function toggleLock(id) {
    

  //   const block = document.getElementById(`block-${id}`);
  //   if(!block) return;
    
  //   const isLocked = block.classList.toggle('is-locked');
    
  //   // Toolbar Update
  //   $(`#automator-editor-lock-btn-${id} i`).attr('class', `fas ${isLocked ? 'fa-lock' : 'fa-lock-open'}`);
    
  //   // ContentEditable Update
  //   const content = block.querySelector('.automator-editor-block-render-area');

  //   var blockConfig = state.blockConfigs[id];
  //   if(blockConfigs.can_have_child) {

  //   } else {

  //     if(blockConfigs.editor == true) {

  //       content = content.find('textarea').fisrt();

  //     } else {

  //       content = content.find(blockConfigs.tag).fisrt();

  //     }

  //   }

  //   if(content) content.setAttribute('contenteditable', !isLocked);
    
  //   updateStructureList();


  // }

  function deleteBlock(id) {
    const block = document.getElementById(`block-${id}`);
    
    // Bloqueio hierárquico na exclusão
    if (!block || isHierarchyLocked(block)) {
      alert("Este bloco ou um de seus sub-itens está bloqueado e não pode ser excluído.");
      return;
    }
    
    if (confirm("Deseja realmente excluir este bloco?")) {
      const parent = $(block).parent();
      $(block).remove();
      delete state.blockConfigs[id];
      
      if (parent.children('.automator-editor-block').length === 0) {
        parent.closest('.automator-editor-block').addClass('automator-editor-block-is-empty');
      }
      
      deselectAll();
      updateStructureList();
      state.hasChanges = true;
    }
  }




  return {


    destroy,
    config,
    init,
    initInterface,
    initSortable,
    switchLeftTab,
    updateLeftTabVisibility,
    toggleSidebar,
    switchTab,
    insertField,
    includeField,
    injectBlock,
    renderFieldElement,
    selectBlock,
    deselectAll,
    renderBlockSettings,
    renderBlockSettingsField,
    updateStructureList,
    moveBlock,
    syncCanvasOrder,
    toggleLock,
    deleteBlock,
    scrollToBlock: (id) => {


      const block = document.getElementById(`block-${id}`);
      if(block) {

        block.scrollIntoView({ behavior: 'smooth', block: 'center' }); 
        selectBlock(block); 

      }


    }



  };




})();