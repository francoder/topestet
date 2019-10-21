<div class="surlist2-page">
    <?=$this->Element("specialists_filter");?>
    
    <?if (!empty($region) && !empty($service) &&  $this->Paginator->param('page') == 1): ?>
    	<div id="map" style=" height: 400px"></div>
		<div id="nearest" style="display:none;">
			<h2>Ближайшие объекты</h2>
			<span>Поиск ближайших клиник (специалистов)...</span>
			<ul>
				<li  style="display:none;">
					<h3></h3>
					<span class="adress"></span></br>
					Расстояние &mdash; <span class="distance"></span><br>
				</li>
			</ul>
		</div>
    	<script type="text/javascript">
    		 ymaps.ready(function(){
    		 	 var map = new ymaps.Map("map", {
		            center: [55.76, 37.64], 
		            zoom: 7,
		            controls: ['typeSelector', 'zoomControl']
		        });
		        //map.controls.remove('trafficControl');

		        //расставляем метки объектов
		        p = new Array();
		        allObjects = new ymaps.Clusterer();
		        <?foreach ($clinics_for_map as $i => $object):?>
		        	<?$coor = explode(' ', $object['User']['coor']);?>
		        	t_obj = p[<?=$i?>] = new ymaps.GeoObject({
					    geometry: {
					    	type: "Point",
					    	coordinates: [<?=$coor[1]?>, <?=$coor[0]?>]
					    },
					    properties: {
					    	hintContent: '<?=$object['User']['name']?>',
					    	balloonContentHeader: '<?=$object['User']['name']?>',
					    	balloonContentBody: '<p align="center"><?=$object['User']['profession']?><br><img src="<?=$this->Element("image", array("model" => "user", "type" => "mini", "alias" => "avatar", "id" => $object['User']['id'], "onlyurl" => true))?>"><br><a href="/<?=(($object['User']['is_specialist'] == 1)?'specialist':'clinic')?>/profile/<?=$object['User']['id']?>/" target="_blanc">перейти &rarr;</a></p>',
					    	clusterCaption: '<?=$object['User']['name']?>',
					    	elAdress: '<?=$object['User']['address']?>'
						}
		    		});
		    		
		    		allObjects.add(t_obj);
		    		
		        <?endforeach;?>
		       			        
		        map.geoObjects.add(allObjects);
		        
		        //ищем наш город
		        var city_search = ymaps.geocode("<?=$region['Region']['title']?>").then(function (res){
			    	map.setCenter(res.geoObjects.get(0).geometry.getCoordinates(), 10);
			    	
			    	<?if (count($specialists) < 3):?>
				    	//определяем есть ли объекты на карте
				    	visibleZone = new ymaps.GeoObject({
						    geometry: {
						        type: "Rectangle",
						        coordinates: map.getBounds()
						    }
						}, {visible: false});
						map.geoObjects.add(visibleZone);
						
						objects = ymaps.geoQuery(allObjects);			
								
						objectsInsideCircle = objects.searchInside(visibleZone);
						if (objectsInsideCircle.getLength() == 0){
							//маршруты расстояния до ближайших мест
							$('#nearest').show();
							routes = new Array();
							make_route(0);
						}
			    	<?endif;?>
			    });
		        
		        function make_route(id){
		        	console.log('Строим маршрут ' + id);
		        	ymaps.route([map.getCenter(), p[id].geometry.getCoordinates()]).then(function(route){
		        		routes[id] = [id, route.getLength(), route.getHumanLength()];
		        		if (id < p.length - 1){
		        			make_route(id + 1);
		        		} else {
		        			//поиск ближайших трех
		        			for (k = 0; k < routes.length; k++){
								min_val = routes[k][1];
								min_id = k;
		        				for (j = k + 1; j < routes.length; j++){
		        					if (routes[j][1] < min_val){
		        						min_val = routes[j][1]
										min_id = j;
		        					}
		        				}
		        				chaise = routes[k];
		        				routes[k] = routes[min_id];
		        				routes[min_id] = chaise;
		        			}
		        			
		        			for (j = 0; j <3; j++){
		        				if (j != 0){
		        					$('#nearest > ul').append($('#nearest > ul li:first').clone());
		        				}
								$('#nearest ul li:eq(' + j + ')').show();
		        				$('#nearest ul li:eq(' + j + ') h3').text(p[routes[j][0]].properties.get('hintContent'));
		        				$('#nearest ul li:eq(' + j + ') .adress').text(p[routes[j][0]].properties.get('elAdress'));
		        				$('#nearest ul li:eq(' + j + ') .distance').html(routes[j][2]);
		        			}
		        			$('#nearest > span').hide();
		        		}
		        	});
		        }
    		 });

    	</script>
    <?endif;?>
    <?foreach ($specialists as $i => $specialist):?>
        <?=$this->Element("specialist", array("specialist" => $specialist, "first" => ($i == 0)?true:false));?>
    <?endforeach;?>

    <?/*
    <?if ($specialist_type == 1):?>
    	<?$url = str_replace('/catalog/', '/catalog/clinic/', $this->here);?>
    	<a href="<?=$url?>">Каталог клиник</a>
    <?else:?>
    	<a href="<?=str_replace('', '', str_replace('/clinic/', '/', $this->here))?>">Каталог специалистов</a>
    <?endif;?>
    */?>
    <?$url_parts = array_filter(explode('/', $current_url));
		unset($url_parts[array_search($this->params['controller'], $url_parts)]);
		unset($url_parts[array_search($this->params['action'], $url_parts)]);
		unset($url_parts[array_search('clinic', $url_parts)]);
	?>

	<?
		$this->Paginator->options(array(
			'url' => array_merge(array(
				'controller' => $this->params['controller'],
				'action' => (($specialist_type == 2)?'clinic/':'') . $this->params['action']
			), $url_parts)
		));
	?>
    <?$pages = $this->Paginator->numbers(array("separator" => "", "model" => "User", "modulus" => 6, "first" => 1, "last" => 1));?>
    <?if ($pages):?>
        <div class="pagination">
            <?=$this->Element("clear_first_page", array('pages' => $this->Paginator->prev("Предыдущая", array("model" => "User"), " ")));?>
            <?=$this->Element("clear_first_page", array('pages' => $pages));?>
            <?=$this->Paginator->next("Следующая", array("model" => "User"), " ")?>
        </div>
    <?endif;?>
    
    <?$params = $this->Paginator->params();?>
    <?if (!empty($service) && !empty($region) && $params['page'] == 1):?>
	    <div class="comments">
	        <a name="comments"></a>
	        <h2>Комментарии:</h2>
	        <?=$this->Element('comments_block', array('comments' => $comments, 'belongs' => 'RegionService', 'belongs_id' => $region['Region']['id'] . '-' . $service['Service']['id']));?>
	    </div>
	<?endif;?>
    
    <div class="block_border hint">
        Статус «Топ» свидетельствует о высокой оценке работы данного специалиста со стороны пациентов. Им награждаются специалисты, получившие наибольшее количество положительных оценок в отзывах, благодарностей за ответы на вопросы, а также регулярно посвящающие время консультированию пользователей нашего сайта.
    </div>
    <br><br>
    <?if ($specialist_type == 1):?>
    	<?$url = str_replace('/catalog/', '/catalog/clinic/', $this->here);?>
    	<a href="<?=$url?>">Каталог клиник</a>
    <?else:?>
    	<a href="<?=str_replace('', '', str_replace('/clinic/', '/', $this->here))?>">Каталог специалистов</a>
    <?endif;?>
    
    <!-- <div class="article">
         <div class="h1 last">Сео-текст</div>
        <p>
            В этом разделе вы сможете подобрать пластического хирурга в Москве для консультаций и возможного проведения
            операции. Информация о хирургах отсортирована в алфавитном порядке, для каждого специалиста указана краткая
            биография и контакты (адрес, телефон, сайт).
            <br><br>
            Согласно статистике, в столице практикует более 100 специалистов, выполняющих пластические операции. Стоимость услуг
            пластических хирургов Москвы в среднем выше, чем в других российских городах, однако именно здесь работают одни из
            лучших представителей отрасли. При выборе хирурга обратите внимание на его опыт, количество проведенных операций и
            членство в профессиональных организациях.
        </p>
 </div> 
-->    
</div> 