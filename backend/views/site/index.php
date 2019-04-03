<?php
/**
 * @var $this yii\web\View
 * @var $users \uztelecom\readModels\UserReadRepository
 * @var $orders \uztelecom\readModels\OrderReadRepository
 * @var $cars \uztelecom\readModels\CarReadRepository
 */
$this->title = 'Панель управления, TelecomCar';
?>
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-teal"><i class="ion-ios-location"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Заказов</span>
                    <span class="info-box-number"><?= $cars->totalCount ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="ion-model-s"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Автомобилей</span>
                    <span class="info-box-number"><?= $cars->totalCount ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-blue"><i class="ion-ios-people"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Водителей</span>
                    <span class="info-box-number"><?= $users->getAllDriverCount() ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-orange"><i class="ion-ios-people"></i></span>
                <div class="info-box-content">
                    <span class="info-box-text">Пользователей</span>
                    <span class="info-box-number"><?= $users->getAllUsersCount() ?></span>
                </div>
            </div>
        </div>
        <div class="col-md-12">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        <i id="online-mark" class="fa fa-circle text-red"></i>
                        отчет в реальном времени
                    </h3>
                    <div class="box-title" style="margin-left: 10px; border-left: 1px solid #ccc; padding-left: 10px;">
                        <i class="ion ion-model-s text-green"></i>
                        <span class="description-header" id="onlineDrivers">0</span>
                        <i class="ion ion-model-s text-red"></i>
                        <span id="offlineDrivers"><?= $users->getAllDriverCount() ?></span>
                        <i class="ion ion-ios-people text-green"></i>
                        <span id="onlineUsers">0</span>
                        <i class="ion ion-ios-people text-red"></i>
                        <span id="offlineUsers"><?= $users->getAllUsersCount() ?></span>
                    </div>
                    <div class="box-tools pull-right">
                        <button type="button" class="btn btn-box-tool" data-widget="collapse"><i
                                    class="fa fa-minus"></i>
                        </button>
                        <button type="button" class="btn btn-box-tool" data-widget="remove"><i class="fa fa-times"></i>
                        </button>
                    </div>
                </div>
                <!-- /.box-header -->
                <div class="box-body no-padding">
                    <div class="row">
                        <div class="col-md-12 col-sm-12">
                            <div class="pad">
                                <div class="map-container">
                                    <div class="map-marker-centered"></div>
                                    <div class="map">
                                        <div id="map" style="height: 325px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.box-body -->
            </div>
        </div>
    </div>

<?php
$userId = Yii::$app->user ? Yii::$app->user->getId() : null;
$script = <<<JS
$('#map').css('height','500px');
let icons = { user:null, driver:null};
let map;
let userId = $userId;
let markers = [];
initMap();

let ws = new WebSocket('ws://telecom-car.test/ws?user_id='+userId);
  ws.addEventListener('open',function(e){
    setInterval(function(){
        ws.send(prepareMessage("ping",null))
    },10000)
    
    setInterval(function(){
          ws.send(prepareMessage("onlineUsers",null))
    },10000)
    
    onlineMark()
  });
  ws.addEventListener('error', function(){offlineMark()});
  
  ws.addEventListener('message', function(e){
      let response = JSON.parse(e.data);
      
      if(isEqualTo(response.status,'success')){
            if(isEqualTo(response.action,'onlineUsers'))
            {
              let onlineUsers = response.data.online.users;
              let onlineDrivers = response.data.online.drivers;
              
              $('#offlineDrivers').text(response.data.offline.drivers);
              $('#offlineUsers').text(response.data.offline.users);
              $('#onlineDrivers').text(onlineDrivers.length);
              $('#onlineUsers').text(onlineUsers.length);
              for (let i=0; i < onlineUsers.length; i++){
                  for(let l=0; l < markers.length; l++){
                      if(isEqualTo(markers[l].id,onlineUsers[i].id)){
                          map.removeLayer(markers[l].marker);
                      }
                  }
                  let userMarker = L.Marker.movingMarker([[41.275548, 69.270124]],[20000],{icon: icons.user}).addTo(map);
                  markers.push({
                     id: onlineUsers[i].id,
                     marker: userMarker
                  });
              }
              for (let i=0; i < onlineDrivers.length; i++){
                  for(let l=0; l < markers.length; l++){
                      if(isEqualTo(markers[l].id,onlineDrivers[i].id)){
                          map.removeLayer(markers[l].marker);
                      }
                  }
                  let driverMarker = L.Marker.movingMarker([[41.275548, 69.270124]],[20000],{icon: icons.driver}).addTo(map);
                  markers.push({
                     id: onlineDrivers[i].id,
                     marker: driverMarker
                  });
              }
            }
            if(isEqualTo(response.action,'coordinates')) 
            {
                let data = response.data;
                for(let j=0; j < markers.length; j++){
                    if(markers[j].id === data.userId){
                        markers[j].marker.moveTo([data.coordinates.lat, data.coordinates.lng],500);
                    }
                }
            }
      }
  });
  
  
  function initMap()
  {
      icons.user = L.icon({
          iconUrl: '/img/user.svg',
          iconSize: [50, 65],
          iconAnchor: [0, 65],
          popupAnchor: [0, 0]
        });
      
      icons.driver = L.icon({
        iconUrl: '/img/driver.svg',
        iconSize: [50, 65],
        iconAnchor: [0, 65],
        popupAnchor: [0, 0]
      });
      
      map = L.map('map', {
        center: [41.275548,69.270124],
        zoom: 11
      });
    L.tileLayer('https://map.uztelecom.uz/hot/{z}/{x}/{y}.png').addTo(map);
  }
  
  function offlineMark(){
      $('#online-mark').removeClass('text-green').addClass('text-red');
  }
  function onlineMark() {
    $('#online-mark').removeClass('text-red').addClass('text-green');  
  }
  
  function isEqualTo(paramOne,paramTwo){
      return paramOne === paramTwo;
  }
  
  
  function prepareMessage(actionName, sendData)
  {
      return JSON.stringify({
            action: actionName,
            data: sendData
      });
  }
  
  var user1 = new WebSocket('ws://telecom-car.test/ws?user_id=2');
  var user2 = new WebSocket('ws://telecom-car.test/ws?user_id=3');
  var driver1 = new WebSocket('ws://telecom-car.test/ws?user_id=4');
  
  var coordinatesDriver = [
      {lat: 41.275548, lng:69.270124},
      {lat: 41.281911, lng:69.276368},
      {lat: 41.283494, lng:69.277802},
      {lat: 41.286748, lng:69.280648},
      {lat: 41.290151, lng:69.282962},
      {lat: 41.291537, lng:69.285736},
  ];
 setTimeout(function() {
   driver1.close();
   setTimeout(function() {
        var driver1 = new WebSocket('ws://telecom-car.test/ws?user_id=4');
        setInterval(function(){
            for (var i=0; i<coordinatesDriver.length;i++){
                driver1.send(prepareMessage("coordinates",coordinatesDriver[i]))
            }
        },10000)
   },4000)
 },4000)
 
   for (var i=0; i<coordinatesDriver.length;i++){
       setTimeout(function(){
           user1.send(prepareMessage("coordinates",coordinatesDriver[i]))
       },50000);
   }
JS;

$this->registerJs($script);