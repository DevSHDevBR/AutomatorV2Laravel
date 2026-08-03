<?php


  $WPNonce = ( (is_user_logged_in()) ? wp_create_nonce('wp_rest') : '' );
  $WPAPI   = get_rest_url() . 'grupo-anjos/api/restricted';


?>
<div id="modal-atribuir-fundo">

  <table id="modal-atribuir-loading" class="w-100 h-100">

    <tbody class="w-100 h-100 d-table">
      
      <tr class="w-100 h-100">

        <td class="text-center align-middle w-100 h-100">

          <div class="spinner-border text-light" role="status">

            <span class="visually-hidden">Loading...</span>

          </div>
          
        </td>
        
      </tr>

    </tbody>
    
  </table>



  <div class="modal fade" id="modal-pedidos" tabindex="-1" aria-labelledby="modal-pedidosLabel" aria-hidden="true">

    <div class="modal-dialog modal-fullscreen">

      <div class="modal-content">

        <div class="modal-header">

          <h1 class="modal-title d-inline-block w-100 text-center fs-5" id="modal-pedidosLabel" style="padding-left: 32px;">PEDIDOS DO MOTORISTA</h1>
          <button type="button" class="btn-close" onclick="RemocaoPetFecharModalPedidos()"></button>

        </div>

        <div class="modal-body">

          <div class="container-fluid p-0">

            <div class="row">

              <div class="col-12 col-lg-5">
                
                <div class="w-100 h-100" style="overflow-y: scroll; max-height: 400px;">
                  
                  <div class="card mb-3">

                    <div class="card-header text-uppercase">Informações do dispositivo</div>
                    <div id="modal-pedidos-dispositivo" class="card-body"></div>
                    
                  </div>

                  <div class="card">
                    
                    <div class="card-body p-0">
                      
                      <div id="modal-pedidos-lista" class="accordion accordion-flush"></div>

                    </div>

                  </div>

                </div>
                
              </div>
              <div class="col-12 col-lg-7">

                <div class="card h-100 w-100">
                  
                  <div class="card-body">
                    
                    <div id="modal-pedidos-mapa"></div>
                    
                  </div>

                </div>
                
              </div>
              
            </div>

          </div>
          
        </div>

        <div class="modal-footer">

          <div class="container-fluid px-0">
            
            <div class="row">
              
              <div class="col-12"><button type="button" class="btn btn-danger w-100 text-center text-uppercase" onclick="RemocaoPetFecharModalPedidos()">Fechar</button></div>
              
            </div>

          </div>
          
        </div>

      </div>

    </div>

  </div>



  <div class="modal fade" id="modal-atribuir" tabindex="-1" aria-labelledby="modal-atribuirLabel" aria-hidden="true">

    <div class="modal-dialog modal-fullscreen">

      <div class="modal-content">

        <div class="modal-header">

          <h1 class="modal-title d-inline-block w-100 text-center fs-5" id="modal-atribuirLabel" style="padding-left: 32px;">DEFINIR MOTORISTA</h1>
          <button type="button" class="btn-close" onclick="RemocaoPetFecharModalAtribuir()"></button>

        </div>

        <div class="modal-body">

          <div class="container-fluid p-0">

            <div class="row">

              <div class="col-12 col-lg-5">

                <form id="modal-atribuir-form" class="container-fluid px-0" onsubmit="return false;">
            
                  <button type="submit" class="d-none">Definir Motorista</button>
                  <input type="hidden" name="pedido" id="modal-atribuir-pedidoID" value="" />
                  <input type="hidden" name="token" id="modal-atribuir-token" value="" />
                  <input type="hidden" name="usuario" id="modal-atribuir-usuario" value="" />
                  <div class="row">

                    <div class="col-12" id="modal-atribuir-pedido"></div>

                  </div>
                  <div class="row">

                    <div class="col-12 mt-1">
                      
                      <div class="d-table w-75 mx-auto"><hr /></div>

                    </div>
                    
                  </div>
                  <div class="row">

                    <div class="col-12">
                      
                      <div class="d-table w-100 fw-bold text-center mb-2" style="font-size: 17px;">Dispositivos / Motoristas:</div>
                      <div id="modal-atribuir-lista" class="row row-cols-1 row-cols-md-3 g-3"></div>

                    </div>

                  </div>

                </form>
                
              </div>
              <div class="col-12 col-lg-7">

                <div class="card h-100 w-100">
                  
                  <div class="card-body">

                    <div id="modal-atribuir-mapa"></div>

                  </div>

                </div>
                
              </div>
              
            </div>

          </div>
          
        </div>

        <div class="modal-footer">

          <div class="container-fluid px-0">
            
            <div class="row">
              
              <div class="col-12 order-2 col-md-6 order-md-1"><button type="button" class="btn btn-danger w-100 text-center text-uppercase" onclick="RemocaoPetFecharModalAtribuir()">Cancelar</button></div>
              <div class="col-12 order-1 col-md-6 order-md-2 mb-3 mb-md-0"><button id="modal-atribuir-submit" onclick="RemocaoPetAtribuirMotoristaPedido(this)" type="button" class="btn btn-primary w-100 text-center text-uppercase" disabled>Definir Motorista</button></div>
              
            </div>

          </div>
          
        </div>

      </div>

    </div>

  </div>

</div>

<div class="container-fluid px-0">
  
  <div class="row">
  
    <div id="painel-mod-rm-dashboard-left" class="col-12 col-md-4 col-lg-4 mb-3">

      <div class="row">

        <div class="col-12">

          <div class="d-flex flex-wrap mb-3">
            <div class="p-2 ps-0"><h4 class="mb-0">Pedidos</h4></div>
            <div class="ms-auto p-2 pe-0">
              <button type="button" id="painel-mod-rm-dashboard-pedidos-list-atualizar" class="btn btn-secondary btn-sm" onclick="RemocaoPetAtualizarPedidos(this);" disabled>Atualizar</button>
            </div>
          </div>

        </div>

        <div class="col-12 mb-3">

          <div id="painel-mod-rm-dashboard-pedidos-list">
            
            <div id="painel-mod-rm-dashboard-pedidos-list-itens" class="d-block text-center w-100"><span class="alert alert-info w-100 p-3 d-block">Carregando...</span></div>

          </div>

        </div>

      </div>

    </div>

    <div id="painel-mod-rm-dashboard-right" class="col-12 col-md-8 col-lg-8 mb-3">
      
      <div class="row">

        <div class="col-12 mb-3">

          <div class="d-flex flex-wrap">

            <div class="p-2 ps-0"><h4 class="mb-0">Dispositivos / Motoristas</h4></div>
            <div class="ms-auto p-2 pe-0">

              <button type="button" id="painel-mod-rm-dashboard-devices-list-atualizar" class="btn btn-primary btn-sm d-none">Atualizar</button>

            </div>

          </div>

        </div>

        <div class="col-12 mb-2">
          
          <div id="painel-mod-rm-dashboard-devices-list">
            
            <div class="d-table text-center w-100"><span class="alert alert-info w-100 p-3 d-block">Carregando...</span></div>

          </div>

        </div>

      </div>
      <div class="row">
        
        <div class="col-12 mb-3">

          <div class="d-table w-75 mx-auto"><hr class="m-0" /></div>

        </div>

      </div>
      <div class="row">
        
        <div class="col-12">
          
          <div id="map"></div>

        </div>
    
    </div>

  </div>

</div>


<style>


  * { margin: 0; padding: 0; box-sizing: border-box; }

  #map {

    height: 100vh;
    width:  100%;
  
  }


  .marker-label-title { margin-top: 40px; }

  /* Adicione um estilo para indicar que o item da lista é clicável */
  .device-list-item {

    transition: background-color 0.2s ease;

  }


  .device-list-item-em-trajeto {

    background-color: #3D8BFD !important;
    border-color:     #0d6efd !important;
    color:            #FFFFFF;
  
  }


  .device-list-item-no-local {
    
    background-color: #ffc107;
    color:            #FFFFFF;

  }


  #painel-mod-rm-dashboard-pedidos-list > div {

    padding-right: 5px;
    padding-left:  5px;
    overflow-y:    auto;
  
  }


  #modal-atribuir-fundo {

    background-color: rgba(0, 0, 0, .5);
    position:         fixed;
    display:          none;
    z-index:          99999;
    height:           100%;
    width:            100%;
    left:             0;
    top:              0;

  }


  #modal-atribuir-loading { display: none; }
  
  #modal-atribuir-mapa,
  #modal-pedidos-mapa {
    height: 100%;
    width: 100%;
  }

</style>

<script src="https://www.gstatic.com/firebasejs/10.12.0/firebase-app-compat.js"></script>
<script src="https://www.gstatic.com/firebasejs/10.12.0/firebase-database-compat.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBcOz25um9tbXGYKHvUBUIyPFgR_lHg45c"></script>


<script>



  // 🔧 Substitua pelas suas credenciais do Firebase
  const firebaseConfig = {

    apiKey:            "AIzaSyBcOz25um9tbXGYKHvUBUIyPFgR_lHg45c",
    authDomain:        "remocaopet-e18f1.firebaseapp.com",
    databaseURL:       "https://remocaopet-e18f1-default-rtdb.firebaseio.com",
    projectId:         "remocaopet-e18f1",
    storageBucket:     "remocaopet-e18f1.firebasestorage.app",
    messagingSenderId: "517347651221",
    appId:             "1:517347651221:web:309371a486b4d0a5caf59c",
    measurementId:     "G-77HZDKRFPT"
  
  };

  firebase.initializeApp(firebaseConfig);
  const db = firebase.database();

  let map;
  let pedidosMap; // Novo objeto de mapa para o modal de pedidos
  const markers         = {}; // Objeto para armazenar os marcadores do Google Maps
  const pedidosMarkers  = {}; // Novo objeto para marcadores de pedidos
  const atribuirMarkers = {}; // Novo objeto para marcadores de atruibuir pedidos
  const devices         = {}; // Objeto para armazenar informações básicas dos dispositivos (nome/UID)
  let infoWindow        = null; // Para controlar a InfoWindow aberta
  let pedidosInfoWindow = null; // Nova InfoWindow para o mapa de pedidos
  let directionsService;
  let routes             = {};
  let destinationMarkers = {};




  function getRandomColor() {


    const letters = '0123456789ABCDEF';
    let color     = '#';

    for (let i = 0; i < 6; i++) {
      color += letters[Math.floor(Math.random() * 16)];
    }


    return color;
  

  }





  function initMap() {


    map = new google.maps.Map(document.getElementById("map"), {

      center: { lat: 0, lng: 0 },
      zoom:   3

    });


    // Inicializa o DirectionsService
    directionsService = new google.maps.DirectionsService();


    // Cria InfoWindows reutilizáveis
    infoWindow = new google.maps.InfoWindow();
    pedidosInfoWindow = new google.maps.InfoWindow();


    const locationsRef = db.ref("dispositivos");
    const devicesListDiv = document.getElementById("painel-mod-rm-dashboard-devices-list");


    locationsRef.on("value", (snapshot) => {


      const data = snapshot.val();
      
      const currentValidUids = new Set();
      
      devicesListDiv.innerHTML = '';
      devicesListDiv.innerHTML = '<span class="alert alert-info w-100 p-3 d-block">Carregando...</span>';

      if (!data) {
        
        devicesListDiv.innerHTML = '<div class="alert alert-warning d-block p-3 text-start w-100" role="alert">Nenhum dispositivo encontrado.</div>';

        for (const uid in markers) {

          markers[uid].setMap(null);
          delete markers[uid];
          delete devices[uid];

        }

        // Limpa todas as rotas e marcadores de destino
        for (const uid in routes) {

          routes[uid].setMap(null);
          delete routes[uid];
          if (destinationMarkers[uid]) {

            destinationMarkers[uid].setMap(null);
            delete destinationMarkers[uid];

          }

        }

        return;
      
      }


      devicesListDiv.innerHTML = '';

      const bounds = new google.maps.LatLngBounds();

      for (const [uid, info] of Object.entries(data)) {

        if (!info.latitude || !info.longitude || !Number.isFinite(parseFloat(info.latitude)) || !Number.isFinite(parseFloat(info.longitude))) {

          // console.warn(`Dispositivo ${uid} sem coordenadas válidas. Será removido da lista/mapa.`);
          continue;

        }

        currentValidUids.add(uid);

        const pos   = { lat: info.latitude, lng: info.longitude };
        const title = info.usuarioNome || `Dispositivo ${uid.substring(0, 8)}...`;
        
        devices[uid] = title;


        // --- Lógica para Marcadores no Mapa ---
        if (markers[uid]) {

          // Atualiza a posição do marcador no mapa
          markers[uid].setPosition(pos);

        } else {

          const routeColor = getRandomColor();
          markers[uid] = new google.maps.Marker({
            position: pos,
            map: map,
            title: title,
            icon: {
              url: ( ( ( info.cor == 'undefined' ) || ( info.cor == undefined ) ) ? "https://clientes.grupoanjos.com.br/wp-content/uploads/carros/icone-carro.png" : "https://clientes.grupoanjos.com.br/wp-content/uploads/carros/" + info.cor + ".png" ),
              scaledSize: new google.maps.Size(32, 19)
            },
            label: {
              text: title,
              color: "#000",
              fontWeight: "bold",
              fontSize: "12px",
              className: "marker-label-title",
            },
            routeColor: routeColor
          });

          markers[uid].addListener("click", () => {
            let routeInfoContent = '';
            if (routes[uid] && routes[uid].getDirections()) {
                const route = routes[uid].getDirections().routes[0];
                const leg = route.legs[0];
                routeInfoContent = `
                    <br>
                    <strong>Rota para o Pedido</strong><br>
                    Distância: ${leg.distance.text}<br>
                    Duração: ${leg.duration.text}
                `;
            }

            infoWindow.setContent(`<strong>${title}</strong><br>
                                  Lat: ${info.latitude}<br>
                                  Lng: ${info.longitude}
                                  ${routeInfoContent}`);
            infoWindow.open(map, markers[uid]);
          });
        }
        
        // --- Lógica para Geração de Rotas ---
        const currentPedidoCoordsString = info.CurrentPedidoCoords || '';
        const currentPedidoStatus = info.CurrentPedidoStatus || '';

        if (currentPedidoCoordsString && currentPedidoStatus !== 'no-local') {
          try {
            const coordsArray = currentPedidoCoordsString.split(',').map(Number);
            const destinationCoords = { lat: coordsArray[0], lng: coordsArray[1] };
            
            if (Number.isFinite(destinationCoords.lat) && Number.isFinite(destinationCoords.lng)) {
              // Remove a rota e o marcador de destino antigos antes de criar o novo
              if (routes[uid]) {
                  routes[uid].setMap(null);
              }
              if (destinationMarkers[uid]) {
                  destinationMarkers[uid].setMap(null);
              }

              const request = {
                origin: pos,
                destination: destinationCoords,
                travelMode: google.maps.TravelMode.DRIVING,
              };

              const polylineColor = markers[uid].routeColor;

              directionsService.route(request, (result, status) => {
                if (status === "OK") {
                  const newRouteRenderer = new google.maps.DirectionsRenderer({
                    // Desabilita os marcadores padrão da rota
                    suppressMarkers: true,
                    polylineOptions: {
                      strokeColor: polylineColor,
                      strokeOpacity: 0.8,
                      strokeWeight: 4
                    }
                  });
                  newRouteRenderer.setMap(map);
                  newRouteRenderer.setDirections(result);
                  
                  routes[uid] = newRouteRenderer;

                  // Cria um novo marcador para o destino do pedido
                  const destinationMarker = new google.maps.Marker({
                      position: destinationCoords,
                      map: map,
                      title: `Destino do Pedido de ${title}`,
                      icon: {
                        url: "https://maps.google.com/mapfiles/ms/icons/red-dot.png", // Icone de ponto vermelho
                        scaledSize: new google.maps.Size(32, 32)
                      },
                      label: {
                          text: "Pedido",
                          color: "#fff",
                          fontWeight: "bold"
                      }
                  });

                  // Adiciona um listener de clique ao marcador de destino
                  destinationMarker.addListener("click", () => {
                      const pedidoID = info.CurrentPedidoID || 'Não disponível';
                      infoWindow.setContent(`<strong>Destino do Pedido</strong><br>
                                              ID do Pedido: ${pedidoID}<br>
                                              Dispositivo: ${title}<br>
                                              Lat: ${destinationCoords.lat}<br>
                                              Lng: ${destinationCoords.lng}`);
                      infoWindow.open(map, destinationMarker);
                  });
                  
                  destinationMarkers[uid] = destinationMarker;
                  
                } else {
                  console.error("Erro ao gerar a rota para o dispositivo " + uid + ": " + status);
                  // Em caso de falha, garante que a rota antiga seja removida
                  if (routes[uid]) {
                      routes[uid].setMap(null);
                      delete routes[uid];
                  }
                  if (destinationMarkers[uid]) {
                      destinationMarkers[uid].setMap(null);
                      delete destinationMarkers[uid];
                  }
                }
              });
            } else {
              console.warn(`Coordenadas de destino inválidas para o dispositivo ${uid}: ${currentPedidoCoordsString}`);
            }
          } catch (e) {
            console.error(`Falha ao processar as coordenadas de rota para o dispositivo ${uid}:`, e);
          }
        } else if ((currentPedidoCoordsString === '' || currentPedidoStatus === 'no-local') && routes[uid]) {
          // Se a coordenada de destino foi removida ou o status é 'no-local', remove a rota e o marcador de destino
          routes[uid].setMap(null);
          delete routes[uid];
          if (destinationMarkers[uid]) {
              destinationMarkers[uid].setMap(null);
              delete destinationMarkers[uid];
          }
        }

        bounds.extend(pos);

        // --- Lógica para a Lista HTML de Dispositivos ---
        let statusClass = '';
        if (currentPedidoStatus === 'em-trajeto') {
            statusClass = 'device-list-item-em-trajeto';
        } else if (currentPedidoStatus === 'no-local') {
            statusClass = 'device-list-item-no-local';
        }

        let statusCor = '';
        if (info.cor == 'undefined' || info.cor == undefined) {
          statusCor = 'https://clientes.grupoanjos.com.br/wp-content/uploads/carros/icone-carro.png';
        } else {
          statusCor = 'https://clientes.grupoanjos.com.br/wp-content/uploads/carros/' + info.cor + '.png';
        }

        const deviceItemHtml = `
          <div class="card mb-2 device-list-item d-inline-block ${statusClass}" data-pedido-coords="${currentPedidoCoordsString}" id="device-item-${uid}" data-uid="${uid}" data-latitude="${info.latitude}" data-longitude="${info.longitude}" data-token="${info.FCMToken}" data-usuario="${info.usuarioID}">
            <div class="card-body py-2 px-3">
              <div class="device-list-item-cor d-table w-100 text-center" data-cor="${info.cor}"><img src="${statusCor}" /></div>
              <strong class="device-list-item-name d-table w-100 text-center">${title}</strong>
              <hr class="d-table w-100 mt-1 mb-2" />
              <div class="d-flex align-items-center">
                <button type="button" class="btn btn-sm btn-secondary me-2" onclick="RemocaoPetGetPedidosByDeviceUID('${uid}', '${info.latitude}', '${info.longitude}')">
                  <i class="fas fa-list"></i>
                  <br />
                  Pedidos
                </button>
                <button type="button" class="btn btn-sm btn-success" onclick="focusMapOnMarker('${uid}')">
                  <i class="fas fa-map-marker-alt"></i>
                  <br />
                  Posição
                </button>
              </div>
            </div>
          </div>
        `;
        devicesListDiv.innerHTML += deviceItemHtml;
      }

      // --- Limpeza de Marcadores e Itens da Lista Antigos/Removidos ---
      for (const uid in markers) {
        if (!currentValidUids.has(uid)) {
          console.log(`Removendo dispositivo ${uid} do mapa e da lista.`);
          markers[uid].setMap(null);
          delete markers[uid];
          delete devices[uid];
          
          if (routes[uid]) {
            routes[uid].setMap(null);
            delete routes[uid];
          }
          if (destinationMarkers[uid]) {
              destinationMarkers[uid].setMap(null);
              delete destinationMarkers[uid];
          }

          const oldDeviceItem = document.getElementById(`device-item-${uid}`);
          if (oldDeviceItem) {
            oldDeviceItem.remove();
          }
        }
      }
    });
  }



  /**
   * Função para focar o mapa em um marcador específico.
   * @param {string} uid O UID do dispositivo/marcador.
   */
  function focusMapOnMarker(uid) {


    const marker = markers[uid];
    if (marker) {

      map.panTo(marker.getPosition()); // Centraliza o mapa na posição do marcador
      map.setZoom(15); // Define um nível de zoom mais próximo
      
      // Opcional: Faz o marcador "saltar" para destaque
      if (marker.getAnimation() !== null) {
          marker.setAnimation(null);
      } else {
          marker.setAnimation(google.maps.Animation.BOUNCE);
          setTimeout(() => {
              marker.setAnimation(null); // Para o salto após um tempo
          }, 1400); // 1.4 segundos (duas "saltadas")
      }

      // Opcional: Abre a InfoWindow ao focar
      infoWindow.setContent(`<strong>${marker.getTitle()}</strong><br>
                             Lat: ${marker.getPosition().lat()}<br>
                             Lng: ${marker.getPosition().lng()}`);
      infoWindow.open(map, marker);

    } else {

      console.warn(`Marcador para UID ${uid} não encontrado.`);

    }


  }


  window.onload = initMap;



  function RemocaoPetCarregarPedidos(callSuccess = null, callError = null) {


    var itens   = new Array();
    var pedidos = $('.painel-mod-rm-dashboard-pedidos-list-item');
    var total   = pedidos.length;

    if(total >= 1) {

      var conta = 0;

      $.each(pedidos, function(pedidoKey, pedido) {

        itens[conta] = $(this).attr('data-pedido');

        conta++;
        if(conta >= total) {

          var ajaxData = {

            classe: 'RemocaoPetPedidos',
            funcao: 'RemocaoPetPedidosAPI',
            data:   { acao: 'mod-rm-pedidos-list', data: { pedidos: itens } }

          };


          jQuery.ajax({


            url:      "<?php echo $WPAPI; ?>",
            type:     'POST',
            dataType: 'json',
            data:     ajaxData,
            beforeSend: function ( xhr ) {
              
              xhr.setRequestHeader( 'X-WP-Nonce', "<?php echo $WPNonce; ?>" );
            
            },
            success:  function(response) {


              if(callSuccess != null) {

                callSuccess(response);

              }

            
            },
            error: function(e) {


              if(callError != null) {

                callError(e);

              }


            }


          });

        }

      });

    } else {

      var ajaxData = {

        classe: 'RemocaoPetPedidos',
        funcao: 'RemocaoPetPedidosAPI',
        data:   { acao: 'mod-rm-pedidos-list', data: { pedidos: itens } }

      };


      jQuery.ajax({


        url:      "<?php echo $WPAPI; ?>",
        type:     'POST',
        dataType: 'json',
        data:     ajaxData,
        beforeSend: function ( xhr ) {
          
          xhr.setRequestHeader( 'X-WP-Nonce', "<?php echo $WPNonce; ?>" );
        
        },
        success:  function(response) {


          if(callSuccess != null) {

            callSuccess(response);

          }

        
        },
        error: function(e) {


          if(callError != null) {

            callError(e);

          }


        }


      });

    }

    


  }




  function RemocaoPetCarregarLocalizacaoAtualDispostivosAtivos( callback ) {


    var dispositivos = jQuery('.device-list-item');
    var total = dispositivos.length;


    if(total >= 1) {

      var devices = new Array();
      var conta = 0;
      $.each(dispositivos, function(deviceKey, dispositivo) {

        var device = $(this);
        devices[conta] = {

          uid:       device.attr('data-uid'),
          icone:     device.find('.device-list-item-cor').find('img').attr('src'),
          name:      device.find('.device-list-item-name').html(),
          usuario:   device.attr('data-usuario'),
          latitude:  device.attr('data-latitude'),
          longitude: device.attr('data-longitude')

        };

        conta++;
        if(conta >= total) {

          callback(devices);

        }


      });


    } else {

      callback([]);

    }

  }




  function RemocaoPetDefinirMotorista( pedido ) {

    var lista = jQuery('#painel-mod-rm-dashboard-pedidos-list');
    var loading = lista.attr('data-loading');

    if( loading == "false" || loading == false) {

      lista.attr('data-loading', true);

      $('#modal-atribuir-loading').css('display', 'block');
      $('#modal-atribuir-fundo').css('display', 'table');

      RemocaoPetCarregarLocalizacaoAtualDispostivosAtivos(function(dispositivos) {

        if(dispositivos.length >= 1) {

          var ajaxData = {
            classe: 'RemocaoPetPedidos',
            funcao: 'RemocaoPetPedidosAPI',
            data: {
              acao: 'mod-rm-pedidos-set-device',
              data: {
                pedido: pedido,
                dispositivos: dispositivos
              }
            }
          };

          jQuery.ajax({
            url:      "<?php echo $WPAPI; ?>",
            type:     'POST',
            dataType: 'json',
            data:     ajaxData,
            beforeSend: function ( xhr ) {
              xhr.setRequestHeader( 'X-WP-Nonce', "<?php echo $WPNonce; ?>" );
            },
            success:  function(response) {

              if(response['result'] == true) {

                var _dispositivos = response['dispositivos'];
                var _total        = _dispositivos.length;

                if(_total >= 1) {

                  var _destino = response['destino'];

                  var _html  = '';
                  var _conta = 0;

                  const lat           = parseFloat(_destino['latitude']);
                  const lng           = parseFloat(_destino['longitude']);
                  const defaultCenter = { lat: -23.5186, lng: -46.1963 };
                  const mapCenter     = (Number.isFinite(lat) && Number.isFinite(lng)) ? { lat, lng } : defaultCenter;

                  atribuirMap = new google.maps.Map(document.getElementById("modal-atribuir-mapa"), {
                    center: mapCenter,
                    zoom: 15
                  });

                  const directionsService = new google.maps.DirectionsService();
                  window.atribuirRenderers = [];

                  const bounds = new google.maps.LatLngBounds();

                  // marcador do pedido
                  atribuirMarkers[pedido] = new google.maps.Marker({
                    position: { lat: parseFloat(_destino['latitude']), lng: parseFloat(_destino['longitude']) },
                    map: atribuirMap,
                    title: 'Pedido ' + pedido.toString(),
                    label: {
                      text: 'Pedido ' + pedido.toString(),
                      color: "#000",
                      fontWeight: "bold",
                      fontSize: "12px",
                    }
                  });
                  bounds.extend({ lat: parseFloat(_destino['latitude']), lng: parseFloat(_destino['longitude']) });

                  // paleta de cores distintas
                  const palette = ["#FF0000","#0000FF","#008000","#FFA500","#800080",
                                   "#00CED1","#FFD700","#A52A2A","#FF1493","#708090"];
                  const usedColors = [];

                  function nextColor(idx){
                    if(idx < palette.length) return palette[idx];
                    // se passar do limite, gera cor aleatória diferente
                    let c;
                    do {
                      c = '#' + Math.floor(Math.random()*16777215).toString(16).padStart(6,'0');
                    } while(usedColors.includes(c));
                    return c;
                  }

                  $.each(_dispositivos, function(i, _device) {

                    const dispPos = { lat: parseFloat(_device['latitude']), lng: parseFloat(_device['longitude']) };

                    atribuirMarkers[_device['uid']] = new google.maps.Marker({
                      position: dispPos,
                      map: atribuirMap,
                      title: _device['name'],
                      icon: {
                          url: _device['icone'],
                          scaledSize: new google.maps.Size(32, 19)
                      },
                      label: {
                          text: _device['name'],
                          color: "#000",
                          fontWeight: "bold",
                          fontSize: "12px",
                          className: "marker-label-title",
                      }
                    });

                    bounds.extend(dispPos);

                    // cor única por dispositivo
                    const color = nextColor(i);
                    usedColors.push(color);

                    // rota dispositivo -> pedido
                    const renderer = new google.maps.DirectionsRenderer({
                      map: atribuirMap,
                      suppressMarkers: true,
                      preserveViewport: true,
                      polylineOptions: {
                        strokeColor: color,
                        strokeOpacity: 0.95,
                        strokeWeight: 5
                      }
                    });
                    window.atribuirRenderers.push(renderer);

                    directionsService.route({
                      origin: dispPos,
                      destination: { lat: parseFloat(_destino['latitude']), lng: parseFloat(_destino['longitude']) },
                      travelMode: google.maps.TravelMode.DRIVING
                    }, function(result, status) {
                      if (status === 'OK') {
                        renderer.setDirections(result);
                        if (result.routes && result.routes[0] && result.routes[0].bounds) {
                          bounds.union(result.routes[0].bounds);
                          atribuirMap.fitBounds(bounds);
                        }
                      }
                    });

                    // cards html
                    _html += '<div class="col">\n';
                    _html += '  <div class="d-table w-100 h-100 text-center">\n';
                    _html += '    <input type="radio" onclick="RemocaoPetDesbloquearAtrubuirSubmit(\'' + _device['uid'] + '\')" class="btn-check" name="dispositivo" id="modal-atribuir-lista-' + _device['id'] + '" autocomplete="off" value="' + _device['id'] + '" />\n';
                    _html += '    <label class="btn btn-outline-secondary w-100 py-3" for="modal-atribuir-lista-' + _device['id'] + '">\n';
                    _html += '      <b>' + _device['name'] + '</b>\n';
                    _html += '      <br />\n';
                    _html += '      Distancia: ' + RemocaoPetConverterMetrosParaKilometragem( _device['calculo']['distancia'] ) + '\n';
                    _html += '      <br />\n';
                    _html += '      Tempo: ' +  _device['calculo']['duracao'] + '\n';
                    _html += '    </label>\n';
                    _html += '  </div>\n';
                    _html += '</div>\n';

                    _conta++;
                    if(_conta >= _total) {
                      if(_total == 1) {
                        $('#modal-atribuir-lista').prop('class', 'row row-cols-1 g-3');
                      } else if(_total == 2) {
                        $('#modal-atribuir-lista').prop('class', 'row row-cols-1 row-cols-md-2 g-3');
                      }

                      atribuirMap.fitBounds(bounds);

                      $('#modal-atribuir-submit').prop('disabled', true);
                      $('#modal-atribuir-pedidoID').val(pedido);
                      $('#modal-atribuir-token').val("");
                      $('#modal-atribuir-usuario').val("");
                      $('#modal-atribuir-pedido').html($('#painel-mod-rm-dashboard-pedidos-list-' + pedido).find('div.painel-mod-rm-dashboard-pedidos-list-item-data').html());
                      $('#modal-atribuir-lista').html(_html);

                      $('#modal-atribuir-loading').css('display', 'none');
                      $('#modal-atribuir').addClass('show').css('display', 'block');
                      $('body').css('overflow', 'hidden');
                    }

                  });

                } else {
                  alert("Não foram encontrados motoristas disponiveis para serem atribuidos ao pedido!");
                }

              }

            },
            error: function(e) { }

          });

        } else {

          alert("Não existem motoristas ativos no momento para realizar esta ação!");
          lista.attr('data-loading', false);

          $('#modal-atribuir-fundo').css('display', 'none');
          $('#modal-atribuir-loading').removeAttr('style');

        }

      });

    } else {

      alert("Existe um processo em execução, aguarde que ele seja finalizado e tente novamente!");

    }

  }





  function RemocaoPetDesbloquearAtrubuirSubmit( uid ) {


    var usuario = $('#device-item-' + uid).attr('data-usuario');
    var token = $('#device-item-' + uid).attr('data-token');
    var botao = $('#modal-atribuir-submit');
    if(botao.prop('disabled') == true) {

      botao.prop('disabled', false);
      $('#modal-atribuir-token').val(token);
      $('#modal-atribuir-usuario').val(usuario);

    } else {

      $('#modal-atribuir-token').val(token);
      $('#modal-atribuir-usuario').val(usuario);

    }


  }




  function RemocaoPetFecharModalAtribuir() {


    $('#modal-atribuir-fundo').css('display', 'none');
    $('#modal-atribuir').removeClass('show').removeAttr('style');
    $('body').removeAttr('style');
    $('#modal-atribuir-pedidoID').val("");
    $('#modal-atribuir-token').val("");
    $('#modal-atribuir-usuario').val("");
    $('#modal-atribuir-pedido').html("");
    $('#modal-atribuir-lista').html('');
    $('#modal-atribuir-mapa').html('');
    $('#modal-atribuir-lista').attr('class', 'row row-cols-1 row-cols-md-3 g-3');
    $('#painel-mod-rm-dashboard-pedidos-list').attr('data-loading', false);
    RemocaoPetAutoLoadingPedidos();


  }




  function RemocaoPetAtribuirMotoristaPedido( el ) {

    var btn = $(el);
    if(btn.prop('disabled') == true) {

      alert("Selecione um 'Dispositivo / Motorista' para atribui-lo a este pedido!");

    } else {

      var lista = jQuery('#painel-mod-rm-dashboard-pedidos-list');
      lista.attr('data-loading', true);

      $('#modal-atribuir-loading').css('display', 'block');

      $('#modal-atribuir').fadeOut(250, function() {

        $(this).removeClass('show');


        var formulario = $('#modal-atribuir-form');

        var pedido  = formulario.find("input[name='pedido']").val();
        var device  = formulario.find("input[name='dispositivo']:checked").val();
        var token   = formulario.find("input[name='token']").val();
        var usuario = formulario.find("input[name='usuario']").val();
        

        var ajaxData = {

          classe: 'RemocaoPetPedidos',
          funcao: 'RemocaoPetPedidosAPI',
          data:   { acao: 'mod-rm-pedidos-update-device', data: { pedido: pedido, dispositivo: device, token: token, usuario: usuario } }

        };


        jQuery.ajax({


          url:      "<?php echo $WPAPI; ?>",
          type:     'POST',
          dataType: 'json',
          data:     ajaxData,
          beforeSend: function ( xhr ) {
            
            xhr.setRequestHeader( 'X-WP-Nonce', "<?php echo $WPNonce; ?>" );
          
          },
          success:  function(response) {

            console.log(response);
            alert(response['message']);
            if(response['result'] == true) {

              $('#painel-mod-rm-dashboard-pedidos-list-' + pedido).remove();

              if( ( $('#painel-mod-rm-dashboard-pedidos-list > div').find('div.painel-mod-rm-dashboard-pedidos-list-item').length ) <= 0 ) {

                $('#painel-mod-rm-dashboard-pedidos-list > div').html('<span class="alert alert-primary w-100 p-3 d-block">Nenhum novo pedido encontrado!</span>');

              }

              $('#modal-atribuir-fundo').css('display', 'none');
              $('#modal-atribuir').removeClass('show').removeAttr('style');
              $('body').removeAttr('style');
              $('#modal-atribuir-pedidoID').val("");
              $('#modal-atribuir-token').val("");
              $('#modal-atribuir-usuario').val("");
              $('#modal-atribuir-pedido').html("");
              $('#modal-atribuir-lista').html('');
              lista.attr('data-loading', false);


            } else {

              if(response['remover'] == true) {

                $('#painel-mod-rm-dashboard-pedidos-list-' + pedido).remove();

                if( ( $('#painel-mod-rm-dashboard-pedidos-list > div').find('div.painel-mod-rm-dashboard-pedidos-list-item').length ) <= 0 ) {

                  $('#painel-mod-rm-dashboard-pedidos-list > div').html('<span class="alert alert-primary w-100 p-3 d-block">Nenhum novo pedido encontrado!</span>');

                }

                $('#modal-atribuir-fundo').css('display', 'none');
                $('#modal-atribuir').removeClass('show').removeAttr('style');
                $('body').removeAttr('style');
                $('#modal-atribuir-pedidoID').val("");
                $('#modal-atribuir-token').val("");
                $('#modal-atribuir-usuario').val("");
                $('#modal-atribuir-pedido').html("");
                $('#modal-atribuir-lista').html('');
                lista.attr('data-loading', false);

              }

            }

            RemocaoPetAutoLoadingPedidos();
          
          },
          error: function(e) {


          }


        });

      });

    }


  }



  function RemocaoPetGerarCardPedido( pedido ) {


    var card = '';


    card += '<div id="painel-mod-rm-dashboard-pedidos-list-' + pedido['ID'] + '" data-pedido="' + pedido['ID'] + '" class="painel-mod-rm-dashboard-pedidos-list-item card mb-3">' + "\n";
              
      card += '<div class="card-body p-2 text-start" style="line-height: 18px; font-size: 14px;">' + "\n";

        card += '<div class="painel-mod-rm-dashboard-pedidos-list-item-data">' + "\n";

          card += '<span style="font-size: 12px;">' + pedido['data'] + '</span>' + "\n";
          card += '<br />' + "\n";
          card += '<b>[ <small>' + pedido['ID'] + '</small> ] ' + pedido['OS'] + '</b>' + "\n";
          card += '<br />' + "\n";
          card += '<hr class="my-1" />' + "\n";
          card += '<b>TOTVS ID:</b> ' + pedido['cliente']['totvsID'] + "\n";
          card += '<br />' + "\n";
          card += '<span style="font-size: 16px;">[ <small>' + pedido['cliente']['ID'] + '</small> ] ' + pedido['cliente']['nome'] + '</span>' + "\n";
          card += '<br />' + "\n";
          card += '<small>' + pedido['cliente']['cpf'] + '</small>' + "\n";
          card += '<br />' + "\n";
          card += '<hr class="my-1" />' + "\n";
          card += '<b>CEP:</b> ' + pedido['endereco']['cep'] + "\n";
          card += '<br />' + "\n";
          card += '<b>End.:</b> ' + pedido['endereco']['local'] + "\n";
          card += '<br />' + "\n";
          card += '<b>Bairro:</b> ' + pedido['endereco']['bairro'] + "\n";
          card += '<br />' + "\n";
          card += '<b>Cidade/UF:</b> ' + pedido['endereco']['cidade'] + ' / ' + pedido['endereco']['estado'] + "\n";
          if(pedido['endereco']['complemento'] != '') {
            
            card += '<br />' + "\n";
            card += '<b>Complemento:</b> ' + pedido['endereco']['complemento'] + "\n";

          }

        card += '</div>' + "\n";
        card += '<hr class="my-1" />' + "\n";
        card += '<button onclick="RemocaoPetDefinirMotorista(' + pedido['ID'] + ');" class="btn btn-primary btn-sm text-center w-100 text-uppercase">Definir Motorista</button>' + "\n";

      card += '</div>' + "\n";

    card += '</div>' + "\n";


    return card;


  }




  function RemocaoPetAtualizarPedidos( el ) {


    var btn = $(el);

    if( btn.hasClass('btn-secondary') ) {

      alert("Existe um processo em execução, aguarde que ele seja finalizado e tente novamente!");

    } else {

      var lista = jQuery('#painel-mod-rm-dashboard-pedidos-list');
      var loading = lista.attr('data-loading');
      if(loading == "false" || loading == false) {
        
        lista.attr('data-loading', true);
        btn.removeClass('btn-primary').prop('disabled', true).addClass('btn-secondary');
        lista.find('div#painel-mod-rm-dashboard-pedidos-list-itens').fadeOut(250, function() {

          $(this).html('<span class="alert alert-info w-100 p-3 d-block">Carregando...</span>');
          $(this).fadeIn(250, function() {

            RemocaoPetCarregarPedidos(function(response) {

              if(response['result'] == true) {

                var novos   = response['novos'];
                if(novos == true) {

                  var pedidos = response['pedidos'];
                  var total   = pedidos.length;

                  if(total >= 1) {

                    var html  = '';
                    var conta = 0;
                    $.each(pedidos, function(pedidoKey, pedido) {

                      html += RemocaoPetGerarCardPedido(pedido);

                      conta++;
                      if(conta >= total) {

                        lista.find('div#painel-mod-rm-dashboard-pedidos-list-itens').fadeOut(250, function() {

                          $(this).html(html);
                          $(this).fadeIn(250, function() {

                            lista.attr('data-loading', false);
                            btn.removeClass('btn-secondary').removeAttr('disabled').addClass('btn-primary');

                          });

                        });

                      }

                    });

                  } else {

                    lista.find('div#painel-mod-rm-dashboard-pedidos-list-itens').fadeOut(250, function() {

                      $(this).html('<span class="alert alert-primary w-100 p-3 d-block">Nenhum novo pedido encontrado!</span>');
                      $(this).fadeIn(250, function() {

                        lista.attr('data-loading', false);
                        btn.removeClass('btn-secondary').removeAttr('disabled').addClass('btn-primary');

                      });

                    });

                  }

                } else {

                  var pedidos = response['pedidos'];
                  var total   = pedidos.length;

                  if(total >= 1) {

                    var html  = '';
                    var conta = 0;
                    $.each(pedidos, function(pedidoKey, pedido) {

                      html += RemocaoPetGerarCardPedido(pedido);

                      conta++;
                      if(conta >= total) {

                        lista.find('div#painel-mod-rm-dashboard-pedidos-list-itens').fadeOut(250, function() {

                          $(this).html(html);
                          $(this).fadeIn(250, function() {

                            lista.attr('data-loading', false);
                            btn.removeClass('btn-secondary').removeAttr('disabled').addClass('btn-primary');

                          });

                        });

                      }

                    });

                  } else {

                    lista.find('div#painel-mod-rm-dashboard-pedidos-list-itens').fadeOut(250, function() {

                      $(this).html('<span class="alert alert-primary w-100 p-3 d-block">Nenhum novo pedido encontrado!</span>');
                      $(this).fadeIn(250, function() {

                        lista.attr('data-loading', false);
                        btn.removeClass('btn-secondary').removeAttr('disabled').addClass('btn-primary');

                      });

                    });

                  }

                }

              } else {

                lista.find('div#painel-mod-rm-dashboard-pedidos-list-itens').fadeOut(250, function() {

                  $(this).html('Falha ao tentar carregar os pedidos!');
                  $(this).fadeIn(250, function() {

                    lista.attr('data-loading', false);
                    btn.removeClass('btn-secondary').removeAttr('disabled').addClass('btn-primary');

                  });

                });

              }

            });  

          });

        });

      } else {

        alert("Existe um processo em execução, aguarde que ele seja finalizado e tente novamente!");

      }
      

    }

  }



  function RemocaoPetAutoLoadingPedidos( intervalo = 120000 ) {


    setTimeout(function() {

      var lista = jQuery('#painel-mod-rm-dashboard-pedidos-list');
      var loading = lista.attr('data-loading');
      if(loading == "true" || loading == true) {

        console.log('Existe uma operação em andamento, aguardando a conclusão para ativar a função novamente.');

      } else {

        console.log("Verificando novos pedidos");
        RemocaoPetCarregarPedidos(function(response) {

          console.log(response);
          // lista.attr('data-loading', true);
          if(response['result'] == true) {

            var novos   = response['novos'];

            if(novos == true) {

              var pedidos = response['pedidos'];
              var total   = pedidos.length;

              if(total >= 1) {

                lista.attr('data-loading', true);

                $('#painel-mod-rm-dashboard-pedidos-list-atualizar').addClass('btn-secondary').prop('disabled', true).removeClass('btn-primary');

                var html = '';
                var conta = 0;
                $.each(pedidos, function(pedidoKey, pedido) {

                  html += RemocaoPetGerarCardPedido(pedido);

                  conta++;
                  if(conta >= total) {

                    lista.find('div#painel-mod-rm-dashboard-pedidos-list-itens').fadeOut(250, function() {

                      $(this).html(html);
                      $(this).fadeIn(250, function() {

                        $('#painel-mod-rm-dashboard-pedidos-list-atualizar').removeClass('btn-secondary').removeAttr('disabled').addClass('btn-primary');
                        lista.attr('data-loading', false);
                        RemocaoPetAutoLoadingPedidos(intervalo);

                      });

                    });

                  }

                });

              } else {

                if( ( $('#painel-mod-rm-dashboard-pedidos-list > div').find('div.painel-mod-rm-dashboard-pedidos-list-item').length ) >= 1 ) {

                  lista.find('div#painel-mod-rm-dashboard-pedidos-list-itens').fadeOut(250, function() {

                    $(this).html('<span class="alert alert-primary w-100 p-3 d-block">Nenhum novo pedido encontrado!</span>');
                    $(this).fadeIn(250, function() {

                      RemocaoPetAutoLoadingPedidos(intervalo);

                    });

                  });

                }

              }

            } else {

              RemocaoPetAutoLoadingPedidos(intervalo);

            }

          } else {

            alert("Falha ao carregar os pedidos automaticamente, para reativar esta função utilize o botão atualizar.");

          }

        });

      }

    }, intervalo);


  }




  function RemocaoPetConverterMetrosParaKilometragem(valorEmMetros) {
    

    // Valida se o valor é um número inteiro
    if (typeof valorEmMetros !== 'number' || !Number.isInteger(valorEmMetros) || valorEmMetros < 0) {
      console.error("Entrada inválida: O valor deve ser um número inteiro não negativo.");
      return "Valor inválido";
    }

    const kilometragem = Math.floor(valorEmMetros / 1000); // Obtém a parte inteira dos quilômetros
    const metros = valorEmMetros % 1000; // Obtém o restante em metros

    let resultado = '';

    if (kilometragem > 0 && metros > 0) {
      resultado = `${kilometragem}Km ${metros}m`;
    } else if (kilometragem > 0) {
      resultado = `${kilometragem}Km`;
    } else if (metros > 0) {
      resultado = `${metros}m`;
    } else {
      resultado = '0m'; // Caso o valor seja 0
    }

    return resultado;


  }




  function RemocaoPetGetPedidosByDeviceUID(deviceUID, latitude, longitude) {

    var lista = jQuery('#painel-mod-rm-dashboard-pedidos-list');
    var loading = lista.attr('data-loading');

    if( loading == "false" || loading == false) {

      lista.attr('data-loading', true);

      $('#modal-atribuir-loading').css('display', 'block');
      $('#modal-atribuir-fundo').css('display', 'table');

      var ajaxData = {

        classe: 'RemocaoPetPedidos',
        funcao: 'RemocaoPetPedidosAPI',
        data:   { acao: 'mod-rm-pedidos-get-pedidos-by-device-uid-dashboard', data: { deviceUID: deviceUID } }

      };


      jQuery.ajax({


        url:      "<?php echo $WPAPI; ?>",
        type:     'POST',
        dataType: 'json',
        data:     ajaxData,
        beforeSend: function ( xhr ) {
          
          xhr.setRequestHeader( 'X-WP-Nonce', "<?php echo $WPNonce; ?>" );
        
        },
        success:  function(response) {


          console.log(response);

          if(response.result == true) {

            var pedidos = response.pedidos;
            var total   = pedidos.length;
            if(total >= 1) {
              
              var dispositivo = response.dispositivo;
              dispositivo['latitude'] = parseFloat(latitude);
              dispositivo['longitude'] = parseFloat(longitude);
              var conta       = 0;
              var _lista      = '';
              var _device     = '';
              $.each(pedidos, function(pedidoKey, pedido) {


                _lista += '<div class="accordion-item">' + "\n";
                  
                  _lista += '<h2 class="accordion-header">' + "\n";
                    
                    _lista += '<button class="fw-bold text-black accordion-button' + ( (pedidoKey >= 1) ? ' collapsed' : '' ) + '" type="button" data-bs-toggle="collapse" data-bs-target="#modal-pedidos-lista-' + pedidoKey + '" aria-expanded="' + ( (pedidoKey >= 1) ? 'false' : 'true') + '" aria-controls="modal-atribuir-lista-' + pedidoKey + '">[ <span style="font-size: 13px; padding-top: 1.5px;" class="px-1">' + pedido['ID'] + '</span> ] ' + pedido['OS'] + '</button>' + "\n";

                  _lista += '</h2>' + "\n";

                  _lista += '<div id="modal-pedidos-lista-' + pedidoKey + '" class="accordion-collapse collapse' + ( (pedidoKey >= 1) ? '' : ' show' ) + '" data-bs-parent="#modal-pedidos-lista" data-latitude="' + pedido['endereco']['latitude'] + '" data-longitude="' + pedido['endereco']['longitude'] + '" data-marker="' + pedido['ID'] + '-' + pedido['OS'] + '">' + "\n";
                    
                    _lista += '<div class="accordion-body">' + "\n";
                      
                      _lista += '<div class="container-fluid p-0">' + "\n";
                        
                        _lista += '<div class="row">' + "\n";
                          
                          _lista += '<div class="col-12 order-2 col-md-10 order-md-1">' + "\n";

                            _lista += '<span style="font-size: 12px;">' + pedido['data'] + '</span>' + "\n";
                            _lista += '<br />' + "\n";
                            _lista += '<b>Status:</b> ' + pedido['status'] + "\n";
                            _lista += '<br />' + "\n";
                            _lista += '<hr class="my-1">' + "\n";
                            _lista += '<b>Cliente</b>' + "\n";
                            _lista += '<br />' + "\n";
                            _lista += '<b>TOTVS ID:</b> ' + pedido['cliente']['totvsID'] + "\n";
                            _lista += '<br />' + "\n";
                            _lista += '<span style="font-size: 16px;">[ <small>' + pedido['cliente']['ID'] + '</small> ] ' + pedido['cliente']['nome'] + '</span>' + "\n";
                            _lista += '<br />' + "\n";
                            _lista += '<small>' + pedido['cliente']['cpf'] + '</small>' + "\n";
                            _lista += '<br />' + "\n";
                            _lista += '<hr class="my-1">' + "\n";
                            _lista += '<b>Endereço</b>' + "\n";
                            _lista += '<br />' + "\n";
                            _lista += '<b>CEP:</b> ' + pedido['endereco']['cep'] + "\n";
                            _lista += '<br />' + "\n";
                            _lista += '<b>End.:</b> ' + pedido['endereco']['local'] + "\n";
                            _lista += '<br />' + "\n";
                            _lista += '<b>Bairro:</b> ' + pedido['endereco']['bairro'] + "\n";
                            _lista += '<br />' + "\n";
                            _lista += '<b>Cidade/UF:</b> ' + pedido['endereco']['cidade'] + ' / ' + pedido['endereco']['estado'] + "\n";

                          _lista += '</div>' + "\n";

                          _lista += '<div class="col-12 order-1 col-md-2 order-md-2 text-center">' + "\n";
                            
                            _lista += '<div class="d-flex justify-content-center w-100 h-100">' + "\n";
                              
                              _lista += '<div class="align-self-center"><button type="button" class="btn btn-primary btn-lg" onclick="RemocaoPetGoToPedidoOnMap(\'' + pedido['ID'] + '-' + pedido['OS'] + '\')"><i class="fas fa-map-pin"></i></button></div>' + "\n";
                            
                            _lista += '</div>' + "\n";

                          _lista += '</div>' + "\n";

                        _lista += '</div>' + "\n";

                      _lista += '</div>' + "\n";

                    _lista += '</div>' + "\n";

                  _lista += '</div>' + "\n";

                _lista += '</div>' + "\n";


                conta++;
                if(conta >= total) {

                  _device += '<div class="container-fluid p-0">' + "\n";
                        
                    _device += '<div class="row">' + "\n";
                      
                      _device += '<div class="col-12 order-2 col-md-10 order-md-1">' + "\n";

                        _device += '<b style="font-size: 16px;">[ <small>' + dispositivo['ID'] + '</small> ] ' + dispositivo['metas']['mod-rm-dispositivo-motorista']['user_firstname'] + '</b>' + "\n";
                        _device += '<br />' + "\n";
                        _device += '<span style="font-size: 12px;">' + dispositivo['metas']['mod-rm-dispositivo-uid'] + '</span>' + "\n";
                        _device += '<br />' + "\n";
                        _device += '<hr class="my-1">' + "\n";
                        _device += '<b>Nome:</b> ' + dispositivo['post_title'] + "\n";
                        _device += '<br />' + "\n";
                        _device += '<b>Numero:</b> ' + dispositivo['metas']['mod-rm-dispositivo-numero'] + "\n";
                        _device += '<br />' + "\n";
                        _device += '<b>Status:</b> ' + dispositivo['metas']['mod-rm-dispositivo-status'] + "\n";
                  
                      _device += '</div>' + "\n";

                      _device += '<div class="col-12 order-1 col-md-2 order-md-2 text-center">' + "\n";
                            
                        _device += '<div class="d-flex justify-content-center w-100 h-100">' + "\n";
                          
                          _device += '<div class="align-self-center"><button type="button" class="btn btn-primary btn-lg" onclick="RemocaoPetGoToDeviceOnPedidoOnMap(\'' + dispositivo['metas']['mod-rm-dispositivo-uid'] + '\')"><i class="fas fa-map-pin"></i></button></div>' + "\n";
                        
                        _device += '</div>' + "\n";

                      _device += '</div>' + "\n";

                    _device += '</div>' + "\n";

                  _device += '</div>' + "\n";

                  $('#modal-pedidos-dispositivo').html(_device);
                  $('#modal-pedidos-lista').html(_lista);
                  
                  // Início da correção
                  const lat = parseFloat(latitude);
                  const lng = parseFloat(longitude);
                  const defaultCenter = { lat: -23.5186, lng: -46.1963 }; // Coordenadas de Mogi das Cruzes, SP, Brazil
                  const mapCenter = (Number.isFinite(lat) && Number.isFinite(lng)) ? { lat, lng } : defaultCenter;
                  
                  // Initialize the new map and add markers
                  pedidosMap = new google.maps.Map(document.getElementById("modal-pedidos-mapa"), {
                    center: mapCenter,
                    zoom: 15
                  });
                  // Fim da correção
                  const bounds = new google.maps.LatLngBounds();
                  pedidosMarkers[deviceUID] = new google.maps.Marker({
                      position: { lat: parseFloat(dispositivo.latitude), lng: parseFloat(dispositivo.longitude) },
                      map: pedidosMap,
                      title: dispositivo['metas']['mod-rm-dispositivo-motorista']['user_firstname'],
                      icon: {
                          url: "https://clientes.grupoanjos.com.br/wp-content/uploads/2025/07/icone-carro-novo.png",
                          scaledSize: new google.maps.Size(32, 19)
                      },
                      label: {
                          text: dispositivo['metas']['mod-rm-dispositivo-motorista']['user_firstname'],
                          color: "#000",
                          fontWeight: "bold",
                          fontSize: "12px",
                          className: "marker-label-title",
                      }
                  });
                  bounds.extend({ lat: parseFloat(dispositivo.latitude), lng: parseFloat(dispositivo.longitude) });

                  $.each(pedidos, function(pedidoKey, pedido) {
                    const pedidoPos = { lat: parseFloat(pedido['endereco']['latitude']), lng: parseFloat(pedido['endereco']['longitude']) };
                    const markerId = pedido['ID'] + '-' + pedido['OS'];
                    pedidosMarkers[markerId] = new google.maps.Marker({
                      position: pedidoPos,
                      map: pedidosMap,
                      title: pedido['OS'],
                      label: {
                        text: pedido['ID'].toString(),
                        color: "#000",
                        fontWeight: "bold",
                        fontSize: "12px",
                      }
                    });
                    bounds.extend(pedidoPos);
                    pedidosMarkers[markerId].addListener("click", () => {
                      pedidosInfoWindow.setContent(`<strong>Pedido: ${pedido.OS}</strong><br>
                                                   Endereço: ${pedido['endereco']['local']}<br>
                                                   Cidade: ${pedido['endereco']['cidade']}`);
                      pedidosInfoWindow.open(pedidosMap, pedidosMarkers[markerId]);
                    });
                  });

                  pedidosMap.fitBounds(bounds);


                  $('#modal-atribuir-loading').css('display', 'none');
                  $('#modal-pedidos').addClass('show').css('display', 'block');
                  $('body').css('overflow', 'hidden');
                }

              });

            } else {

              alert("Este dispositivo não possui nenhum pedido no momento!");
              lista.attr('data-loading', false);

              $('#modal-atribuir-fundo').css('display', 'none');
              $('#modal-atribuir-loading').removeAttr('style');

            }

          } else {

            alert("Falha ao tentar carregaar a lista de pedidos do dispostivo.");
            lista.attr('data-loading', false);

            $('#modal-atribuir-fundo').css('display', 'none');
            $('#modal-atribuir-loading').removeAttr('style');


          }

        
        },
        error: function(e) {

          console.log(e);
          alert("Falha ao tentar carregaar a lista de pedidos do dispostivo.");
          lista.attr('data-loading', false);

          $('#modal-atribuir-fundo').css('display', 'none');
          $('#modal-atribuir-loading').removeAttr('style');


        }


      });

    } else {

      alert("Existe um processo em execução, aguarde que ele seja finalizado e tente novamente!");

    }

  }




  function RemocaoPetFecharModalPedidos() {


    $('#modal-atribuir-fundo').css('display', 'none');
    $('#modal-pedidos').removeClass('show').removeAttr('style');
    $('body').removeAttr('style');
    // pedidosMarkers = {}; // Clear markers
    // pedidosMap = null; // Clear map object
    $('#modal-pedidos-dispositivo').html("");
    $('#modal-pedidos-lista').html('');
    $('#modal-pedidos-mapa').html('');
    $('#painel-mod-rm-dashboard-pedidos-list').attr('data-loading', false);

  }


  /**
   * Move o foco do mapa de pedidos para um marcador específico.
   * @param {string} markerId O ID do marcador do pedido.
   */
  function RemocaoPetGoToPedidoOnMap(markerId) {
    const marker = pedidosMarkers[markerId];
    if (marker && pedidosMap) {
      pedidosMap.panTo(marker.getPosition());
      pedidosMap.setZoom(15);
      pedidosInfoWindow.setContent(`<strong>Pedido: ${marker.getTitle()}</strong><br>
                                   Lat: ${marker.getPosition().lat()}<br>
                                   Lng: ${marker.getPosition().lng()}`);
      pedidosInfoWindow.open(pedidosMap, marker);
    } else {
      console.warn(`Marcador para o pedido com ID ${markerId} não encontrado.`);
    }
  }


  /**
   * Move o foco do mapa de pedidos para o marcador do motorista.
   * @param {string} deviceUID O UID do dispositivo do motorista.
   */
  function RemocaoPetGoToDeviceOnPedidoOnMap(deviceUID) {
    const marker = pedidosMarkers[deviceUID];
    if (marker && pedidosMap) {
      pedidosMap.panTo(marker.getPosition());
      pedidosMap.setZoom(15);
      pedidosInfoWindow.setContent(`<strong>Motorista: ${marker.getTitle()}</strong><br>
                                   Lat: ${marker.getPosition().lat()}<br>
                                   Lng: ${marker.getPosition().lng()}`);
      pedidosInfoWindow.open(pedidosMap, marker);
    } else {
      console.warn(`Marcador para o dispositivo com UID ${deviceUID} não encontrado.`);
    }
  }



  function RemocaoPetGetDevicePedidoAtivo( deviceUID, pedidoID ) {


    var ajaxData = {

      classe: 'RemocaoPetPedidos',
      funcao: 'RemocaoPetPedidosAPI',
      data:   { acao: 'mod-rm-pedidos-get-device-pedido-ativo', data: { deviceUID: deviceUID, pedido: pedidoID } }

    };


    jQuery.ajax({


      url:      "<?php echo $WPAPI; ?>",
      type:     'POST',
      dataType: 'json',
      data:     ajaxData,
      beforeSend: function ( xhr ) {
        
        xhr.setRequestHeader( 'X-WP-Nonce', "<?php echo $WPNonce; ?>" );
      
      },
      success:  function(response) {


        console.log(response);

        

      
      },
      error: function(e) {

        console.log(e);
        


      }


    });


  }


  $(function() {


    // var tempo = 120000;
    var tempo = 12000;

    RemocaoPetCarregarPedidos(function(response) {

      var altura = jQuery('#painel-mod-rm-dashboard-right').css('height');
          altura = altura.replace('px', '');
          altura = (altura - 18);
      
      jQuery('#painel-mod-rm-dashboard-pedidos-list-itens').attr('data-altura', altura + "px")
      // alert(altura);

      var lista  = jQuery('#painel-mod-rm-dashboard-pedidos-list');

      lista.attr('data-loading', true);

      if(response['result'] == true) {

        var pedidos = response['pedidos'];
        var total   = pedidos.length;
        
        // console.log(pedidos);

        if(total >= 1) {
          
          var html = '';
          var conta = 0;
          $.each(pedidos, function(pedidoKey, pedido) {

            html += RemocaoPetGerarCardPedido(pedido);

            conta++;
            if(conta >= total) {

              lista.find('div#painel-mod-rm-dashboard-pedidos-list-itens').fadeOut(250, function() {

                $(this).html(html);
                $(this).fadeIn(250, function() {

                  $('#painel-mod-rm-dashboard-pedidos-list-atualizar').removeClass('btn-secondary').removeAttr('disabled').addClass('btn-primary');
                  lista.attr('data-loading', false);
                  $(this).css('max-height', altura);
                  RemocaoPetAutoLoadingPedidos(tempo);

                });

              });

            }

          });

        } else {

          lista.find('div#painel-mod-rm-dashboard-pedidos-list-itens').fadeOut(250, function() {

            $(this).html('<span class="alert alert-primary w-100 p-3 d-block">Nenhum novo pedido encontrado!</span>');
            $(this).fadeIn(250, function() {

              $('#painel-mod-rm-dashboard-pedidos-list-atualizar').removeClass('btn-secondary').removeAttr('disabled').addClass('btn-primary');
              lista.attr('data-loading', false);
              RemocaoPetAutoLoadingPedidos(tempo);

            });

          });

        }

      } else {

        lista.find('div#painel-mod-rm-dashboard-pedidos-list-itens').fadeOut(250, function() {

          $(this).html('Falha ao tentar carregar os pedidos!');
          $(this).fadeIn(250, function() {

            $('#painel-mod-rm-dashboard-pedidos-list-atualizar').removeClass('btn-secondary').removeAttr('disabled').addClass('btn-primary');
            lista.attr('data-loading', false);
            RemocaoPetAutoLoadingPedidos(tempo);

          });

        });

      }

    }, function(err) {

      console.log(err);

      var lista = jQuery('#painel-mod-rm-dashboard-pedidos-list');

      lista.attr('data-loading', true);

      lista.find('div#painel-mod-rm-dashboard-pedidos-list-itens').fadeOut(250, function() {

        $(this).html('Falha ao tentar carregar os pedidos!');
        $(this).fadeIn(250, function() {

          lista.attr('data-loading', false);

          $('#painel-mod-rm-dashboard-pedidos-list-atualizar').removeClass('btn-secondary').removeAttr('disabled').addClass('btn-primary');

        });

      });

    });


  });

</script>