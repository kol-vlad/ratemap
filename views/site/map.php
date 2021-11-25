<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $searchModel app\models\BanksSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отделения';

$this->params['breadcrumbs'][] = $this->title;
?>
 <script src="https://api-maps.yandex.ru/2.0/?load=package.standard&amp;lang=ru-RU&amp;apikey=82b5b05e-231a-4035-9248-9e917e089fb9" type="text/javascript"></script>
    <script src="https://yandex.st/jquery/1.6.4/jquery.min.js" type="text/javascript"></script>
   
   
 <script>// Группы объектов
var groups = [
        
		<?php 

foreach ($model as $office) {?>
		
		{ name: "<? echo $office->addres; ?>",
            style: "twirl#blueIcon",
            items: [
                {
                    center: [<? echo $office->lat; ?>, <? echo $office->lon; ?>],
                    name: "<? echo '<b>Название:</b>'.$office->addfield1.'<br/><b>Адрес:</b> '.$office->addres.'<br/><b>Тел.:</b> '.$office->bank->tel.'<br/><b>Часы работы:</b><br/>'.$office->wclocks; ?>"
                },
                
            ]},
			
			<? } ?>
      
    ];</script>  
   
   
   
<div class="banks-map">

    <h1>Карта отделений (<?= Html::encode($name) ?>)</h1>
    


<div id="map" style="width:100%;height:700px;"></div>


<script> ymaps.ready(init);

function init() {

    // Создание экземпляра карты.
    var myMap = new ymaps.Map('map', {
            center: [55.740502, 37.712048],
            zoom: 17
        }),
		
		
        // Контейнер для меню.
        menu = $('<ul class="menu"></ul>');

    // Перебираем все группы.
    for (var i = 0, l = groups.length; i < l; i++) {
        createMenuGroup(groups[i]);
    }

    function createMenuGroup (group) {
        // Пункт меню.
        var menuItem = $('<li><a href="#">' + group.name + '</a></li>'),
        // Коллекция для геообъектов группы.
            collection = new ymaps.GeoObjectCollection(null, { preset: group.style }),
        // Контейнер для подменю.
            submenu = $('<ul class="submenu"></ul>');

        // Добавляем коллекцию на карту.
        myMap.geoObjects.add(collection);

        // Добавляем подменю.
        menuItem
            .append(submenu)
            // Добавляем пункт в меню.
            .appendTo(menu)
            // По клику удаляем/добавляем коллекцию на карту и скрываем/отображаем подменю.
            .find('a')
            .toggle(function () {
                myMap.geoObjects.remove(collection);
                submenu.hide();
            }, function () {
                myMap.geoObjects.add(collection);
                submenu.show();
            });

        // Перебираем элементы группы.
        for (var j = 0, m = group.items.length; j < m; j++) {
            createSubMenu(group.items[j], collection, submenu);
        }
    }

    function createSubMenu (item, collection, submenu) {
        // Пункт подменю.
        var submenuItem = $('<li><a href="#">' + item.name + '</a></li>'),
        // Создаем метку.
            placemark = new ymaps.Placemark(item.center, { balloonContent: item.name });

        // Добавляем метку в коллекцию.
        collection.add(placemark);
        // Добавляем пункт в подменю.
        submenuItem
            .appendTo(submenu)
            // При клике по пункту подменю открываем/закрываем баллун у метки.
            .find('a')
            .toggle(function () {
                placemark.balloon.open();
            }, function () {
                placemark.balloon.close();
            });

    }

    // Добавляем меню в тэг BODY.
    menu.appendTo($('body'));
    // Выставляем масштаб карты чтобы были видны все группы.
    myMap.setBounds(myMap.geoObjects.getBounds());
	 myMap.controls
        // Кнопка изменения масштаба.
        .add('zoomControl', { left: 5, top: 5 })
        // Список типов карты
        .add('typeSelector')
        // Стандартный набор кнопок
        .add('mapTools', { left: 35, top: 5 });
}</script>

</div>
