/**
 * AUTOMATOR PAGE EDITOR SCRIPT - VERSION 4.3 (CRITICAL FIXES)
 * Sistema de blocos dinâmicos com suporte a aninhamento, persistência de propriedades e Sortable total.
 */

window.AutomatorPageEditor = (function() {

    let state = {
        activeBlock: null,
        isNew: true,
        hasChanges: false,
        previewBreakpoint: 'col-xxl-',
        argCount: 0,
        blockConfigs: {} // Cache de configurações e valores
    };

    const selectors = {
        title:           '#tbl_sys_route_title',
        name:            '#tbl_sys_route_name',
        canvas:          '#wp_canvas_content',
        settingsBlock:   '#block-settings-render',
        structureList:   '#wp_structure_list',
        saveBtn:         '.wp-btn-save',
        resolutionsBtns: '#automator-editor-dropdown-button',
        configsBtn:      '#wp-btn-configs',
        actionBtns:      '.wp-btn-action'
    };

    function init(isNew = true) {
        state.isNew = isNew;
        toggleInterface(false);
        
        $(selectors.title).on('input', function() {
            updateSlugs($(this).val());
            validateRequired();
        });

        $(selectors.name).on('input', function() {
            // updateSlugs($(this).val());
            validateRequired();
        });

        initSortable(document.querySelector(selectors.canvas));

        restoreCurrentResolutionSize();

        $(document).on('click', function(e) {
            if (!$(e.target).closest('.wp-block, .wp-aside, .wp-nav-header, .modal, .btn, .form-control, .accordion, .btn-group, .wp-editor-custom-color-picker').length) {
                deselectAll();
            }
        });

        setTimeout(() => $(selectors.title).focus(), 300);
    }

    // --- INTERFACE ---
    function toggleInterface(enabled, title = false, name = false) {

        const buttons = $(

            selectors.saveBtn +
            ', ' +
            selectors.actionBtns +
            ', ' +
            selectors.resolutionsBtns +
            ', ' +
            selectors.configsBtn

        );

        /**
         * disabled
         */
        buttons.prop(
            'disabled',
            !enabled
        );

        /**
         * wrappers com tooltip
         * (span que envolve botão disabled)
         */
        const tooltipWrappers = buttons.parent('[data-bs-toggle="tooltip"]');

        tooltipWrappers.each(function(){

            const el = this;

            let tooltip = bootstrap.Tooltip.getInstance(el);

            /**
             * COM TÍTULO
             * remove tooltip
             */
            if(enabled){

                if(tooltip){

                    tooltip.dispose();

                }

                return;
            }

            /**
             * SEM TÍTULO
             * ativa tooltip
             */
            if(tooltip){

              $(el).attr('data-bs-title', ( (title == false) ? $(el).attr('data-bs-title-error') : ( (name == false) ? $(el).attr('data-bs-name-error') : '' ) ));
              tooltip.dispose();

            }

            tooltip = new bootstrap.Tooltip(el);

        });
    }
    // function toggleInterface(enabled) {
    //     $(selectors.saveBtn + ', ' + selectors.actionBtns + ', ' + selectors.resolutionsBtns).prop('disabled', !enabled);
    // }

    function validateRequired() {

        const isValid  = $(selectors.title).val().trim() !== '';
        const isValid2 = $(selectors.name).val().trim() !== '';
        const isValidOK = ( (isValid && isValid2) ? true : false );
        // console.log(isValid);
        // console.log(isValid2);
        toggleInterface(isValidOK, isValid, isValid2);
        // const isValid = $(selectors.title).val().trim() !== '';
        // toggleInterface(isValid);
    }

    function toggleSidebar(side) {
        const id = '#wp_sidebar_' + side;
        $(id).toggleClass(window.innerWidth <= 991.98 ? 'show' : 'collapsed');
    }

    function switchLeftTab(tab) {
        const sidebar = $('#wp_sidebar_left');
        const isCollapsed = sidebar.hasClass('collapsed');

        if (isCollapsed) {
            sidebar.removeClass('collapsed');
            updateTabVisibility(tab);
        } else {
            const currentTabId = tab === 'inserter' ? '#left-tab-inserter' : '#left-tab-structure';
            if ($(currentTabId).hasClass('d-none')) {
                sidebar.addClass('collapsed');
                setTimeout(() => {
                    updateTabVisibility(tab);
                    sidebar.removeClass('collapsed');
                }, 310);
            } else {
                sidebar.addClass('collapsed');
            }
        }
    }

    function updateTabVisibility(tab) {
        if (tab === 'inserter') {
            $('#left-tab-inserter').removeClass('d-none');
            $('#left-tab-structure').addClass('d-none');
        } else {
            $('#left-tab-inserter').addClass('d-none');
            $('#left-tab-structure').removeClass('d-none');
            updateStructureList();
        }
    }

    function switchTab(tab) {
        $('.wp-tab-btn').removeClass('active');
        $(`#tab-btn-${tab}`).addClass('active');
        $(`#tab-content-page, #tab-content-block`).addClass('d-none');
        $(`#tab-content-${tab}`).removeClass('d-none');
    }

    // --- BLOCOS E AJAX ---

    function SysAutomatorEditorIncludeField(fieldID) {
        if (typeof AutomatorGetActionStatus === 'function') {
            AutomatorGetActionStatus(() => executeIncludeField(fieldID));
        } else {
            executeIncludeField(fieldID);
        }
    }

    function executeIncludeField(fieldID) {
        AutomatorSetActionStatus(true, () => {
            AutomatorPageLoader('show', () => {
                $.ajax({
                    url: window.AutomatorRoutes.apiEditor || '',
                    type: 'POST',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'), 'Accept': 'application/json' },
                    data: { fieldTypeID: fieldID },
                    success: function(response) {
                        AutomatorPageLoader('hide', () => {
                            AutomatorSetActionStatus(false, () => {
                                if(response.automator) injectBlock(response.automator);
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
        wrapper.className = 'wp-block';
        if (field.can_have_child) wrapper.classList.add('can-have-child', 'is-empty');
        wrapper.id = `block-${id}`;
        wrapper.setAttribute('data-id', id);
        wrapper.setAttribute('data-container-name', field.title);
        
        let toolbarHTML = '';
        if(field.toolbar) {
            field.toolbar.forEach(btn => {
                toolbarHTML += `<button type="${btn.type || 'button'}" class="${btn.class}" title="${btn.title}" onclick="${btn.onclick}">${btn.label}</button>`;
            });
        }

        const prefix = (field.prefix || '').replace('>', '');
        const sufix = field.sufix || '';
        const content = field.code || '';

        let renderArea = '';
        let classe = field.class || '';

        // if(field.rendered == true) {

        //   let renderBlock = onLoadRenderBlock(field);
        //   let prefix = renderBlock.prefix;
        //   let sufix  = renderBlock.sufix;

        //   // console.log(renderBlock);

        // }
        // console.log(prefix);
        // console.log(sufix);
        // alert(classe);
        if (field.can_have_child) {
          
          renderArea = `<div class="wp-block-child-area ${classe}"></div>`;

        } else {

            renderArea = `${prefix} class="block-content ${classe} wp-empty" contenteditable="true" data-placeholder="Escreva seu texto aqui">${content}${sufix}`;

        }
        
        wrapper.setAttribute('data-automator-class', classe);
        wrapper.setAttribute('data-automator-type', field.type);

        // if (classe) wrapper.classList.add(classe);

        let props = field.props;
        // console.log(props);
        if( (Object.keys(props).length) >= 1) {

          $.each(props, function(propKey, propVal) {

            // console.log(propVal);
            wrapper.setAttribute(propKey, propVal);

          });

        }

        wrapper.innerHTML = `
            <div class="wp-block-handle"><i class="fas fa-grip-vertical"></i></div>
            <div class="wp-toolbar">
                <button type="button" class="btn btn-xs btn-light border" onclick="AutomatorPageEditor.moveBlock('${id}', 'up')" title="Mover para cima"><i class="fas fa-chevron-up"></i></button>
                <button type="button" class="btn btn-xs btn-light border" onclick="AutomatorPageEditor.moveBlock('${id}', 'down')" title="Mover para baixo"><i class="fas fa-chevron-down"></i></button>
                <div class="vr mx-1"></div>
                ${toolbarHTML}
                <div class="vr mx-1"></div>
                <button type="button" id="lock-btn-${id}" onclick="AutomatorPageEditor.toggleLock('${id}')" class="btn btn-xs btn-light border lock-btn" title="Travar/Destravar Campo">
                    <i class="fas fa-lock-open"></i>
                </button>
                <button type="button" class="btn btn-xs btn-light border text-danger" onclick="AutomatorPageEditor.deleteBlock('${id}')" title="Excluir campo"><i class="fas fa-times"></i></button>
            </div>
            <div class="wp-block-render">
                ${renderArea}
            </div>
        `;

        wrapper.onclick = (e) => { 
            e.stopPropagation(); 
            selectBlock(wrapper); 
        };

        let targetContainer = $(selectors.canvas);
        if (state.activeBlock) {
            const activeId = state.activeBlock.getAttribute('data-id');
            const activeConfig = state.blockConfigs[activeId];
            if (activeConfig && activeConfig.can_have_child) {
                targetContainer = $(state.activeBlock).find('.wp-block-child-area').first();
                $(state.activeBlock).removeClass('is-empty');
            }
        }

        targetContainer.append(wrapper);
        
        if (field.can_have_child) {
            initSortable(wrapper.querySelector('.wp-block-child-area'));
        }

        selectBlock(wrapper);
        updateStructureList();
        state.hasChanges = true;
    }


    // function onLoadRenderBlock(field) {

    //   let tagName = (field.default).replace('<', '').replace('>', '');

    //   console.log('tagName');
    //   console.log(tagName);
    //   console.log('tagName - FIELD');
    //   console.log(field.prefix);
    //   console.log(field.sufix);
    //   console.log('tagName - FIELD');

    //   let prefix = (field.prefix).replace("[$tag]", tagName);
    //   let sufix  = (field.sufix).replace("[$tag]", tagName);

    //   return {

    //     prefix: '<' + prefix,
    //     sufix:  sufix,

    //   };
      

    // }


    function parseDynamicTags(field) {


      let prefix = field.prefix || '';
      let sufix  = field.sufix || '';

      if(Array.isArray(field.tag)){

        let currentTag = 'h1';

        try {

          currentTag =
              field.properties
                  ?.tipograph
                  ?.fields
                  ?.type
                  ?.default || 'h1';

        } catch(e){}

        prefix = prefix.replace('{$type}', `<${currentTag}>`);

        sufix = sufix.replace('{$type}', `${currentTag}>`);

        if(!sufix.startsWith('</')){
          
          sufix = '</' + sufix;

        }

      }


      return {

        prefix,
        sufix

      };


    }

    // --- SELEÇÃO E RENDERIZAÇÃO DE PROPRIEDADES ---

    function selectBlock(block) {
        if(state.activeBlock) state.activeBlock.classList.remove('is-active');
        state.activeBlock = block;
        state.activeBlock.classList.add('is-active');
        
        const id = block.getAttribute('data-id');
        const field = state.blockConfigs[id];
        
        if (field && field.can_have_child) {
            switchLeftTab('inserter');
        }
        
        renderBlockSettings(block, id, field);
    }

    function deselectAll() {
        if(state.activeBlock) state.activeBlock.classList.remove('is-active');
        state.activeBlock = null;
        $('#tab-btn-block').prop('disabled', true);
        switchTab('page');
    }

    function renderBlockSettings(block, blockID, field) {
        if(!field) return;
        
        $('#tab-btn-block').prop('disabled', false);
        var blocks = field['properties'];
        var blockHTML = `<div class="row">
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
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#block-settings-rendered-${blockID}-${blockKey}">
                            ${blockItem['label']}
                        </button>
                    </h2>
                    <div id="block-settings-rendered-${blockID}-${blockKey}" class="accordion-collapse collapse">
                        <div class="accordion-body">`;

            $.each(blockItem['fields'], function(fieldKey, fieldItem) {
                blockHTML += `<div class="col-12 mb-3">${renderBlockSettingsField(blockID, blockKey, fieldKey, fieldItem)}</div>`;
            });

            blockHTML += `</div></div></div>`;
        });

        blockHTML += `</div></div></div>`;
        
        $(selectors.settingsBlock).html(blockHTML);
        switchTab('block');
        
        initSettingsEvents(blockID);
    }

    function renderBlockSettingsField(blockID, blockKey, fieldKey, fieldItem) {
        const label = `<label class="form-label small fw-bold">${fieldItem.label}</label>`;
        const name = `${blockKey}.${fieldKey}`;
        const val = fieldItem.default || '';
        
        switch(fieldItem.field) {
            case 'color-picker':
                return `
                    <div class="d-flex align-items-center justify-content-between mb-2">
                        <label class="small fw-bold">${fieldItem.label}</label>
                        <div class="wp-editor-custom-color-picker">
                            <input type="color" name="${name}" value="${val}" data-block="${blockID}">
                        </div>
                    </div>`;
            case 'radio-buttons':
                let radios = `<div class="btn-group w-100" role="group">`;
                $.each(fieldItem.choices, function(k, v) {
                    radios += `<input type="radio" class="btn-check" name="${name}" id="btn-${blockID}-${k}" value="${k}" ${val === k ? 'checked' : ''} data-block="${blockID}">
                               <label class="btn btn-outline-secondary btn-sm" for="btn-${blockID}-${k}">${v}</label>`;
                });
                return `${label}${radios}</div>`;
            case 'select':
                let selects = `<div class="form-floating">`;
                selects += `<select name="${name}" class="form-select" data-block="${blockID}">`;
                  $.each(fieldItem.choices, function(k, v) {
                    selects += `<option value="${k}" ${val === k ? 'selected' : ''}>${v}</option>`;
                  });
                selects += `</select>`;
                return `${selects}${label}</div>`;
            case 'range':
                let oninput = 'AutomatorPageEditor.updateRangeInputViewValue(this)';
                if(fieldItem.oninput) {
                  oninput = '' + fieldItem.oninput;
                }
                return `<div class="row"><div class="col-8">${label}<input type="range" class="form-range" name="${name}" value="${val}" data-block="${blockID}" min="${fieldItem.minval}" max="${fieldItem.maxval}" oninput="${oninput}" /></div><div class="col-4"><input type="number" class="form-control form-control-sm" name="${name}-value" value="${val}" data-block="${name}-${blockID}-value" min="${fieldItem.minval}" max="${fieldItem.maxval}" /></div></div>`;
            case 'textarea':
                return `<div class="form-floating"><textarea class="form-control form-control-sm" name="${name}" rows="3" data-block="${blockID}">${val}</textarea>${label}</div>`;
            default:
                return `<div class="form-floating"><input type="text" class="form-control form-control-sm" name="${name}" value="${val}" data-block="${blockID}" />${label}</div>`;
        }
    }

    function initSettingsEvents(blockID) {
        $(selectors.settingsBlock).find('input, select, textarea').on('input change', function() {
            const name = $(this).attr('name');
            const val = $(this).val();
            
            const parts = name.split('.');
            if (parts.length === 2) {
                const blockKey = parts[0];
                const fieldKey = parts[1];
                if (state.blockConfigs[blockID] && state.blockConfigs[blockID].properties[blockKey]) {
                    state.blockConfigs[blockID].properties[blockKey].fields[fieldKey].default = val;
                }
            }

            applyStyleToBlock(blockID, name, val);
        });
    }

    function applyStyleToBlock(id, path, value) {
        const block = document.getElementById(`block-${id}`);
        if(!block) return;
        
        const target = block.querySelector('.block-content') || block.querySelector('.wp-block-render');
        if(!target) return;
        
        if(path.includes('color')) target.style.color = value;
        if(path.includes('background')) target.style.backgroundColor = value;
        if(path.includes('size')) {
            const sizes = { 'small': '12px', 'medium': '16px', 'large': '24px', 'extra-large': '32px' };
            target.style.fontSize = sizes[value] || value;
        }
        if(path.includes('style')) {
             target.style.cssText += ';' + value;
        }
        
        // Mantém as classes se existirem
        if(path.includes('class')) {
            // target.className = 'block-content ' + value;
          const originalClasses = block.getAttribute('data-automator-class') || '';

          const userClasses = value || '';

          target.className = `block-content wp-empty ${originalClasses} ${userClasses}`.replace(/\s+/g, ' ').trim();
        }
    }

    // --- SINCRONIZAÇÃO E ORDENAÇÃO ---

    function initSortable(el) {
        if(!el) return;
        new Sortable(el, {
            group: 'nested-blocks',
            animation: 150,
            fallbackOnBody: true,
            swapThreshold: 0.65,
            handle: '.wp-block-handle',
            draggable: '.wp-block',
            onEnd: (evt) => {
                if (evt.from.classList.contains('wp-block-child-area') && evt.from.children.length === 0) {
                    $(evt.from).closest('.wp-block').addClass('is-empty');
                }
                if (evt.to.classList.contains('wp-block-child-area')) {
                    $(evt.to).closest('.wp-block').removeClass('is-empty');
                }
                updateStructureList(); 
                state.hasChanges = true; 
            }
        });
    }

    function updateStructureList() {
        const list = $(selectors.structureList);
        list.empty();
        
        function buildTree(container, level = 0) {
            $(container).children('.wp-block').each(function() {
                const id = this.getAttribute('data-id');
                const isLocked = this.classList.contains('is-locked');
                const config = state.blockConfigs[id] || {};
                const title = config.title || `Bloco`;
                const icon = config.icon || 'cube';

                const item = $(`
                    <div class="structure-item d-flex align-items-center p-2 border-bottom" data-id="${id}" data-container-name="${config.title}" style="padding-left: ${level * 20 + 10}px !important;">
                        <i class="fas fa-grip-vertical structure-handle me-2 text-muted"></i>
                        <i class="fa fa-${icon} me-2 small text-primary"></i>
                        <span class="small flex-grow-1 text-truncate cursor-pointer" onclick="AutomatorPageEditor.scrollToBlock('${id}')">
                            ${title} ${isLocked ? '<i class="fas fa-lock ms-1 text-warning"></i>' : ''}
                        </span>
                        <button type="button" class="btn btn-xs btn-light" onclick="AutomatorPageEditor.toggleLock('${id}'); event.stopPropagation();">
                            <i class="fas ${isLocked ? 'fa-lock' : 'fa-lock-open'}"></i>
                        </button>
                        <button type="button" class="btn btn-xs btn-light text-danger ms-1" onclick="AutomatorPageEditor.deleteBlock('${id}'); event.stopPropagation();">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                `);
                list.append(item);

                const childArea = $(this).find('.wp-block-child-area').first();
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
                handle: '.structure-handle',
                onEnd: function() {
                    const order = Array.from(list[0].children).map(el => el.dataset.id);
                    syncCanvasOrder(order);
                }
            });
            list.addClass('sortable-initialized');
        }
    }

    function syncCanvasOrder(order) {
        const canvas = $(selectors.canvas);
        order.forEach(id => {
            const block = document.getElementById(`block-${id}`);
            if (block) canvas.append(block);
        });
        updateStructureList();
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

    function toggleLock(id) {
        const block = document.getElementById(`block-${id}`);
        if(!block) return;
        
        const isLocked = block.classList.toggle('is-locked');
        
        // Toolbar Update
        $(`#lock-btn-${id} i`).attr('class', `fas ${isLocked ? 'fa-lock' : 'fa-lock-open'}`);
        
        // ContentEditable Update
        const content = block.querySelector('.block-content');
        if(content) content.setAttribute('contenteditable', !isLocked);
        
        updateStructureList();
    }

    function deleteBlock(id) {
        const block = document.getElementById(`block-${id}`);
        if(!block) return;

        // Se o bloco estiver bloqueado, não exclui
        if(block.classList.contains('is-locked')) {
            alert('Este bloco está bloqueado e não pode ser excluído.');
            return;
        }

        // Se algum pai estiver bloqueado, também não exclui (opcional, mas seguro)
        if($(block).parents('.is-locked').length > 0) {
            alert('Um container superior está bloqueado. Desbloqueie-o para excluir este item.');
            return;
        }

        if(confirm('Deseja excluir este bloco?')) {
            const parent = block.parentNode;
            $(block).remove();
            delete state.blockConfigs[id];
            
            if (parent && parent.classList.contains('wp-block-child-area') && parent.children.length === 0) {
                $(parent).closest('.wp-block').addClass('is-empty');
            }
            
            updateStructureList();
            deselectAll();
        }
    }


    function updateRangeInputViewValue(item) {

      var el = $(item);
      var nome = el.attr('name');
      var id = el.attr('data-block');
      var campo = id + '-value';
      var valor = el.val();

      $("input[data-block='"+ nome + "-" + campo + "']").val(valor)

    }


    function changeColClassSize(item, size) {

        var el     = $(item);
        var nome   = el.attr('name');
        var id     = el.attr('data-block');
        var campo  = id + '-value';
        var valor  = el.val();

        /**
         * Atualiza input auxiliar
         */
        $("input[data-block='" + nome + "-" + campo + "']")
            .val(valor);

        /**
         * Bloco alvo
         */
        var bloco = $(selectors.canvas)
            .find(".wp-block[data-id='" + id + "']");

        if(!bloco.length) return;

        /**
         * Prefixo -> atributo
         */
        var attrMap = {
            'col-'     : 'data-col',
            'col-sm-'  : 'data-col-sm',
            'col-md-'  : 'data-col-md',
            'col-lg-'  : 'data-col-lg',
            'col-xl-'  : 'data-col-xl',
            'col-xxl-' : 'data-col-xxl'
        };

        var attr =
            attrMap[size];

        if(!attr) return;

        /**
         * Salva valor no atributo
         *
         * ex:
         * data-col-sm="6"
         */
        bloco.attr(
            attr,
            valor
        );

        /**
         * Atualiza visualização atual
         */
        refreshCanvasBreakpoint();

        state.hasChanges = true;
    }
    // function changeColClassSize(item, size) {

    //     var el     = $(item);
    //     var nome   = el.attr('name');
    //     var id     = el.attr('data-block');
    //     var campo  = id + '-value';
    //     var valor  = el.val();

    //     /**
    //      * Atualiza input auxiliar
    //      */
    //     $("input[data-block='" + nome + "-" + campo + "']")
    //         .val(valor);

    //     /**
    //      * Bloco alvo
    //      */
    //     var bloco = $(selectors.canvas)
    //         .find(".wp-block[data-id='" + id + "']");

    //     if(!bloco.length) return;

    //     /**
    //      * Classe final
    //      * ex: col-md-6
    //      */
    //     var newClass = size + valor;

    //     /**
    //      * Remove classe existente do mesmo prefixo
    //      *
    //      * ex:
    //      * col-md-1
    //      * col-md-2
    //      * col-md-12
    //      */
    //     bloco.removeClass(function(index, className){

    //         return className
    //             .split(/\s+/)
    //             .filter(function(cls){

    //                 return cls.indexOf(size) === 0;

    //             })
    //             .join(' ');

    //     });

    //     /**
    //      * Adiciona nova classe
    //      */
    //     bloco.addClass(newClass);

    // }



    function refreshCanvasBreakpoint() {

        const map = [

            {
                prefix: 'col-xxl-',
                attr: 'data-col-xxl'
            },

            {
                prefix: 'col-xl-',
                attr: 'data-col-xl'
            },

            {
                prefix: 'col-lg-',
                attr: 'data-col-lg'
            },

            {
                prefix: 'col-md-',
                attr: 'data-col-md'
            },

            {
                prefix: 'col-sm-',
                attr: 'data-col-sm'
            },

            {
                prefix: 'col-',
                attr: 'data-col'
            }

        ];

        const current =
            state.previewBreakpoint;

        $(selectors.canvas)
            .find('.wp-block')
            .each(function(){

                const block =
                    $(this);

                /**
                 * remove classes bootstrap antigas
                 */
                block.removeClass(function(i, c){

                    return (
                        c.match(
                            /\bcol(?:-(?:sm|md|lg|xl|xxl))?-\d+\b/g
                        ) || []
                    ).join(' ');

                });

                /**
                 * descobrir breakpoint atual
                 */
                let currentIndex =
                    map.findIndex(
                        x => x.prefix === current
                    );

                if(currentIndex < 0){

                    currentIndex = 0;
                }

                let size = null;

                /**
                 * fallback bootstrap
                 *
                 * ex:
                 * xxl -> xl -> lg -> md -> sm -> col
                 */
                for(
                    let i = currentIndex;
                    i < map.length;
                    i++
                ){

                    const attr =
                        map[i].attr;

                    const value =
                        block.attr(attr);

                    if(value){

                        size = value;
                        break;
                    }
                }

                /**
                 * fallback final
                 */
                size = size || 12;

                /**
                 * aplica somente classe visual ativa
                 */
                block.addClass(
                    'col-' + size
                );

            });

    }


    function updateCurrentResolutionSize(item){

        const el =
            $(item);

        const value =
            el.attr('data-value');


        if(!value) return;

        /**
         * mesmo item selecionado
         * apenas fechar dropdown
         */
        if(
            state.previewBreakpoint ===
            value
        ){

            const dropdown =
                bootstrap.Dropdown
                    .getOrCreateInstance(
                        $('#automator-editor-dropdown .dropdown-toggle')[0]
                    );

            dropdown.hide();

            return;
        }

        state.previewBreakpoint =
            value;

        /**
         * remover ativo
         */
        $('#automator-editor-dropdown .dropdown-item')
            .removeClass('active');

        /**
         * novo ativo
         */
        el.addClass('active');

        /**
         * atualizar botão
         */
        const icon =
            el.find('i')[0]
            ?.outerHTML || '';

        const text =
            el.text().trim();

        const buttonSpan =
            $('#automator-editor-dropdown')
                .find('span[data-bs-toggle="tooltip"]');

        buttonSpan.html(icon);

        buttonSpan.attr(
            'data-bs-title',
            text
        );

        /**
         * recriar tooltip
         */
        const tooltip =
            bootstrap.Tooltip
                .getInstance(
                    buttonSpan[0]
                );

        if(tooltip){

            tooltip.dispose();
        }

        new bootstrap.Tooltip(
            buttonSpan[0]
        );

        /**
         * atualizar preview
         */
        refreshCanvasBreakpoint();

        /**
         * fechar dropdown
         */
        const dropdown =
            bootstrap.Dropdown
                .getOrCreateInstance(
                    $('#automator-editor-dropdown .dropdown-toggle')[0]
                );

        dropdown.hide();
    }


    function restoreCurrentResolutionSize(){

        const active =
            $('#automator-editor-dropdown .dropdown-item.active');

        if(!active.length){

            updateCurrentResolutionSize(
                $('#automator-editor-dropdown .dropdown-item')
                    .first()[0]
            );

            return;
        }

        const value =
            active.data('value');

        state.previewBreakpoint =
            value;

        const icon =
            active.find('i')[0]
            ?.outerHTML || '';

        const text =
            active.text().trim();

        const buttonSpan =
            $('#automator-editor-dropdown')
                .find('span[data-bs-toggle="tooltip"]');

        buttonSpan.html(icon);

        buttonSpan.attr(
            'data-bs-title',
            text
        );

        const tooltip =
            bootstrap.Tooltip
                .getInstance(
                    buttonSpan[0]
                );

        if(tooltip){

            tooltip.dispose();
        }

        new bootstrap.Tooltip(
            buttonSpan[0]
        );

        refreshCanvasBreakpoint();
    }


    function injectPreviewCSS() {

        $('#automator-editor-preview-css')
            .remove();

        let css = '';

        for(let i = 1; i <= 12; i++){

            css += `

                .preview-col-${i}{
                    flex:0 0 auto;
                    width:${(100 / 12) * i}%;
                }

                .preview-col-sm-${i}{
                    flex:0 0 auto;
                    width:${(100 / 12) * i}%;
                }

                .preview-col-md-${i}{
                    flex:0 0 auto;
                    width:${(100 / 12) * i}%;
                }

                .preview-col-lg-${i}{
                    flex:0 0 auto;
                    width:${(100 / 12) * i}%;
                }

                .preview-col-xl-${i}{
                    flex:0 0 auto;
                    width:${(100 / 12) * i}%;
                }

                .preview-col-xxl-${i}{
                    flex:0 0 auto;
                    width:${(100 / 12) * i}%;
                }

            `;
        }

        $('head').append(`

            <style id="automator-editor-preview-css">
                ${css}
            </style>

        `);
    }

    // --- AUXILIARES ---

    function updateSlugs(val) {
        // const slug = val.toString().toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/\s+/g, '-').replace(/[^\w\-]+/g, '').replace(/\-\-+/g, '-').replace(/^-+/, '').replace(/-+$/, '');
        // $('#tbl_sys_route_name, #tbl_sys_route_permalink').val(slug);

      const slug = val.toString().toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '').replace(/\s+/g, '-').replace(/[^\w\-]+/g, '').replace(/\-\-+/g, '-').replace(/^-+/, '').replace(/-+$/, '');
      const sync = $('#tbl_sys_route_title_sync');
      const name = $('#tbl_sys_route_name');
      const permalink = $('#tbl_sys_route_permalink');

      if(sync.is(':checked')) {
        
        $('#tbl_sys_route_name').val(slug);

      }

    }

    function save() {
        console.log("Saving Content HTML:", $(selectors.canvas).html());
        alert("Conteúdo salvo com sucesso!");
    }

    return {
        init,
        toggleSidebar,
        switchLeftTab,
        updateRangeInputViewValue,
        SysAutomatorEditorIncludeField,
        updateCurrentResolutionSize,
        restoreCurrentResolutionSize,
        refreshCanvasBreakpoint,
        injectPreviewCSS,
        moveBlock,
        toggleLock,
        deleteBlock,
        selectBlock,
        deselectAll,
        switchTab,
        changeColClassSize,
        formatButton: (btn, cmd) => document.execCommand(cmd, false, null),
        save,
        scrollToBlock: (id) => {
            const block = document.getElementById(`block-${id}`);
            if(block) { 
                block.scrollIntoView({ behavior: 'smooth', block: 'center' }); 
                selectBlock(block); 
            }
        }
    };

})();
