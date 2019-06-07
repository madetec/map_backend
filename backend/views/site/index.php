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
                <a href="<?= \yii\helpers\Url::to('/order/index') ?>">
                    <span class="info-box-icon bg-teal"><i class="ion-ios-location"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-black">Заказов</span>
                        <span class="info-box-number text-black"><?= $orders->totalCount ?></span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <a href="<?= \yii\helpers\Url::to('/car/index') ?>">
                    <span class="info-box-icon bg-aqua"><i class="ion-model-s"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-black">Автомобилей</span>
                        <span class="info-box-number text-black"><?= $cars->totalCount ?></span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <a href="<?= \yii\helpers\Url::to(['/user/index','UserSearch[role]' => 'driver']) ?>">
                    <span class="info-box-icon bg-blue"><i class="ion-ios-people"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-black">Водителей</span>
                        <span class="info-box-number text-black"><?= $users->allDriverCount ?></span>
                    </div>
                </a>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <a href="<?= \yii\helpers\Url::to(['/user/index','UserSearch[role]' => 'user']) ?>">
                    <span class="info-box-icon bg-orange"><i class="ion-ios-people"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text text-black">Пользователей</span>
                        <span class="info-box-number text-black"><?= $users->allUsersCount ?></span>
                    </div>
                </a>
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
$wsUrl = "'" . Yii::$app->params['wsHostInfo'] . "?user_id=" . Yii::$app->user->getId() . "'";
$script = <<<JS
$('#map').css('height','500px');
let icons = { user:null, driver:null};
let map;
let markers = [];
initMap();
let ws = new WebSocket($wsUrl);
  ws.addEventListener('open',function(e){
    ws.send(prepareMessage("onlineUsers",null))
    
    setInterval(function(){
        ws.send(prepareMessage("ping",null))
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
             
              markers = setMarkers(onlineUsers, markers, {icon: icons.user});
              markers = setMarkers(onlineDrivers, markers, {icon: icons.driver});
             
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
  
  //imitation 


  // let lat1= 41.344794,
  //     lng1= 69.257859,
  //     lat2= 41.281911,
  //     lng2= 69.276368,
  //     lat3= 41.275548,
  //     lng3= 69.270124;
  //
  // let user1 = new WebSocket('ws://telecom-car.test/ws?user_id=2&lat='+lat1+'&lng='+lng1);
  // let user2 = new WebSocket('ws://telecom-car.test/ws?user_id=3&lat='+lat2+'&lng='+lng2);
  // let driver1 = new WebSocket('ws://telecom-car.test/ws?user_id=4&lat='+lat3+'&lng='+lng3);
  //
  // driver1.onopen = function(){
  //     setInterval(function(){
  //           driver1.send(prepareMessage("coordinates",{lat: lat1, lng: lng1}))
  //           user2.send(prepareMessage("coordinates",{lat: lat2, lng: lng2}))
  //           user1.send(prepareMessage("coordinates",{lat: lat3, lng: lng3}))
  //           lat1 -= .00005;
  //           lng1 -= .00005;
  //           lat2 += .00005;
  //           lng2 -= .00005;
  //           lat3 += .00005;
  //           lng3 += .00005;
  //     },1000)
  // }

  
  
  
  function setMarkers(users, inputMarkers, icon)
  {
      let Marker=null;
      for (let i=0; i < users.length; i++){
          if(isEqualTo(inputMarkers.length, 0)){
              Marker = L.Marker.movingMarker([
                  [
                      users[i].coordinates.lat,
                      users[i].coordinates.lng
                  ],
                  [
                      users[i].coordinates.lat,
                      users[i].coordinates.lng
                  ],
              ],[20000],icon).addTo(map);
              Marker.start();
              inputMarkers.push({
                 id: users[i].id,
                 marker: Marker
              });
          }else{
              let equal = inputMarkers.find(function(element, index, array){
                  return element.id === users[i].id;
              })
              
              if(equal === undefined){
                   Marker = L.Marker.movingMarker([
                          [
                              users[i].coordinates.lat,
                              users[i].coordinates.lng
                          ],
                      ],[20000],icon).addTo(map);
                      // Marker.start();
                      inputMarkers.push({
                         id: users[i].id,
                         marker: Marker
                      });
              }else{
                  inputMarkers.forEach(function(element) {
                      if(element.id === users[i].id){
                          element.marker.moveTo([users[i].coordinates.lat,users[i].coordinates.lng],1000);
                      }
                  })
              }
              
          }
      }
      
      return inputMarkers;
  }
JS;

$this->registerJs($script);
