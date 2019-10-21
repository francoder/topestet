<?php ?>
<div class="surlist-page">1
  <? $here = $this->here; ?>
  <? $here = preg_replace("/\/page:[0-9]+/", '', $here); ?>

  <div class="catalog_toptab">
    <? if ($specialist_type == 1): ?>
      <a href="<?= str_replace('', '', str_replace('/clinic/', '/', $here)) ?>" class="active">Каталог
        специалистов</a> <? $url = str_replace('/catalog/', '/catalog/clinic/', $here); ?>
      <a href="<?= $url ?>">Каталог клиник</a>
    <? else: ?>
      <a href="<?= str_replace('', '', str_replace('/clinic/', '/', $here)) ?>">Каталог
        специалистов</a>  <? $url = str_replace('/catalog/', '/catalog/', $here); ?>
      <a href="<?= $url ?>" class="active">Каталог клиник</a>
    <? endif; ?>
    <br class="clear">
  </div>

  <? if ($this->params['action'] == 'index' && $this->Paginator->param('page') == 1): ?>
    <div id="map_loader" style="text-align:center;">
      Идет загрузка объектов, пожалуйста подождите...
    </div>
    <div id="map" style=" height: 400px; margin-top:0 !important;"></div>
    <script type="text/javascript">
      ymaps.ready( function () {
        var map = new ymaps.Map( "map", {
          center: [55.76, 37.64],
          zoom: 7,
          controls: ['typeSelector', 'zoomControl']
        } );

        p = new Array();
        allObjects = new ymaps.Clusterer();

        $.ajax( {
          url: '<?=$this->here?>',
          success: function ( response ) {
            for ( i in response ) {
              rr = response[i];
              t_obj = new ymaps.GeoObject( response[i] );
              allObjects.add( t_obj );
            }
            map.geoObjects.add( allObjects );
            $( '#map_loader' ).hide();
          },
          dataType: 'json'
        } );


        //определяем наше положение
        ymaps.geolocation.get( { provider: 'yandex' } ).then( function ( res ) {
          rr = res;
          position = res.geoObjects.get( 0 ).geometry.getCoordinates();
          map.setCenter( position, 12 );
        } );
      } );


    </script>
  <? endif; ?>

  <h3>Город и регион<span id="regions_title"></span></h3>
  <div id="regions" style="display:none;">
    <? foreach ($catalog as $i => $item): ?>
      <?
      $without_child = array();
      $with_child    = array();
      $column_count  = 0;
      if ( ! empty($item['Region']['childs'])) {
        foreach ($item['Region']['childs'] as $subitem) {
          if ( ! empty($subitem['Region']['childs'])) {
            $with_child[] = $subitem;
          } else {
            $without_child[] = $subitem;
          }
        }
      }
      ?>
      <? if (count($with_child) < 2): ?>
        <div class="block">
      <? endif; ?>
      <div class="country"><? if (empty($item['Region']['childs'])): ?><a
            href="/catalog<?= (($specialist_type == 2) ? "/clinic" : "") ?>/region/<?= $item['Region']['alias'] ?>/"><? endif; ?><?= $item['Region']['title'] ?><? if (empty($item['Region']['childs'])): ?></a><? endif; ?>
      </div>
      <div class="direct">
        <? foreach ($without_child as $item): ?>
          <a href="/catalog<?= (($specialist_type == 2) ? "/clinic" : "") ?>/region/<?= $item['Region']['alias'] ?>/"><b><?= $item['Region']['title'] ?></b></a>
          <br>
        <? endforeach; ?>
      </div>
      <? foreach ($with_child as $i => $item): ?>
        <div class="block">
          <h3><?= $item['Region']['title'] ?></h3>
          <? foreach ($item['Region']['childs'] as $subsubitem): ?>
            <a href="/catalog<?= (($specialist_type == 2) ? "/clinic" : "") ?>/region/<?= $subsubitem['Region']['alias'] ?>"><?= $subsubitem['Region']['title'] ?></a>
            <br>
          <? endforeach; ?>
        </div>
        <? if (($i + 1) % 2 == 0): ?>
          <div class="clear"></div>
        <? endif; ?>
      <? endforeach; ?>
      <? if (count($with_child) < 2): ?>
        </div>
      <? else: ?>
        <div class="clear"></div>
      <? endif; ?>
    <? endforeach; ?>
    <div style="clear:both"></div>
  </div>
  <br><br>
  <?= $this->Element("specialists_filter", array("region" => false)); ?>
  <div class="surlist2-page">
    <? if ( ! empty($regions)): ?>
      <div id="specialist_regionbox">
        Выберите город:
        <?= $this->Form->select("region_id", $regions, array("id" => "specialist_region")) ?>
        <script type="text/javascript">
          specialist_type = '<?=($specialist_type == 2) ? "clinic/" : ""?>';
        </script>
        <?= $this->Form->hidden("specialization",
          array("id" => "specialization", "value" => $specialization['Specialization']['alias'])) ?>
        <? if (isset($service) && ! empty($service)): ?>
          <?= $this->Form->hidden("service", array("id" => "service", "value" => $service['Service']['alias'])) ?>
        <? endif; ?>
      </div>
    <? endif; ?>
    <? foreach ($specialists as $i => $specialist): ?>
      <?= $this->Element("specialist", array("specialist" => $specialist, "first" => ($i == 0) ? true : false)); ?>
    <? endforeach; ?>
    <div class="block_border hint">
      Статус «Топ» свидетельствует о высокой оценке работы данного специалиста со стороны пациентов. Им награждаются
      специалисты, получившие наибольшее количество положительных оценок в отзывах, благодарностей за ответы на вопросы,
      а также регулярно посвящающие время консультированию пользователей нашего сайта.
    </div>
    <div class="empt"><!-- Яндекс.Директ -->
      <script type="text/javascript">
        //<![CDATA[
        yandex_partner_id = 116479;
        yandex_site_bg_color = 'FFFFFF';
        yandex_site_charset = 'utf-8';
        yandex_ad_format = 'direct';
        yandex_font_size = 1.2;
        yandex_font_family = 'tahoma';
        yandex_direct_type = 'flat';
        yandex_direct_limit = 2;
        yandex_direct_title_font_size = 3;
        yandex_direct_title_color = '3B5998';
        yandex_direct_url_color = '777777';
        yandex_direct_text_color = '000000';
        yandex_direct_hover_color = 'CC0000';
        yandex_direct_favicon = true;
        yandex_stat_id = 2;
        document.write( '<sc' + 'ript type="text/javascript" src="http://an.yandex.ru/system/context.js"></sc' + 'ript>' );
        //]]>
      </script>
    </div>
    <? $url_parts = array_filter(explode('/', $current_url));
    unset($url_parts[array_search($this->params['controller'], $url_parts)]);
    unset($url_parts[array_search($this->params['action'], $url_parts)]);
    unset($url_parts[array_search('clinic', $url_parts)]);
    ?>

    <?
    $this->Paginator->options(array(
      'url' => array_merge(array(
        'controller' => $this->params['controller'],
        'action'     => (($specialist_type == 2) ? 'clinic/' : '').$this->params['action'],
      ), $url_parts),
    ));
    ?>

    <? $pages = $this->Paginator->numbers(array(
      "separator" => "",
      "model"     => "User",
      "modulus"   => 6,
      "first"     => 1,
      "last"      => 1,
    )); ?>
    <? if ($pages): ?>
      <div class="pagination">
        <?= $this->Element("clear_first_page",
          array('pages' => $this->Paginator->prev("Предыдущая", array("model" => "User"), " "))); ?>
        <?= $this->Element("clear_first_page", array('pages' => $pages)); ?>
        <?= $this->Paginator->next("Следующая", array("model" => "User"), " ") ?>
      </div>
    <? endif; ?>
    <br><br>


  </div>
</div>
