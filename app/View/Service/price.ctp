<div class="article">
    <h1>Сколько стоит <?=mb_strtolower($service['Service']['title'], "utf-8")?>?</h1>
    <table class="prices">
    	<tr>
    		<td>Средняя цена (руб.)</td>
    		<td class="number"><?if ($service['Service']['review_count'] > 1):?><?=$this->Display->number($service['Service']['coast_avg'])?><?else:?>&mdash;<?endif;?></td>
    		<td class="specialist">
    			<?if ($service['Service']['review_count'] > 1):?>
    				по данным <a href="/service/info/<?=$service['Service']['alias']?>/"><?=$service['Service']['review_count']?> отзыв<?=$this->Display->cas($service['Service']['review_count'], array("а", "ов", "ов"))?></a>
    			<?else:?>&mdash;<?endif;?></td>
    	</tr>
    	<tr>
    		<td>Минимальная цена (руб.)</td>
    		<td class="number">
    			<?if ($service['Service']['review_count'] > 2 && !empty($price_min)):?>
    				<?=$this->Display->number($price_min['Review']['coast'])?>
    			<?else:?>&mdash;<?endif;?></td>
    		<td class="specialist">
    			<?if ($service['Service']['review_count'] > 2):?>
    				<?=$price_min['Region']['title']?>,
    				<?if (empty($price_min['Specialist']['id']) && !empty($price_min['Review']['specialist_name'])):?>
    					<a href="/service/review/<?=$price_min['Review']['id']?>/"><?=$price_min['Review']['specialist_name'];?></a>
    				<?elseif (!empty($price_min['Specialist']['id'])):?>
    					<a href="/specialist/profile/<?=$price_min['Specialist']['id']?>"><?=$price_min['Specialist']['name']?></a>
    				<?else:?>
    					<a href="/service/review/<?=$price_min['Review']['id']?>/">специалист не указан</a>
    				<?endif;?>
    			<?else:?>&mdash;<?endif;?>
    		</td>
    	</tr>
    	<tr>
    		<td>Максимальная цена (руб.)</td>
    		<td class="number">
    			<?if ($service['Service']['review_count'] > 2 && !empty($price_max)):?>
    				<?=$this->Display->number($price_max['Review']['coast'])?>
    			<?else:?>&mdash;<?endif;?></td>
    		<td class="specialist">
    			<?if ($service['Service']['review_count'] > 2):?>
    				<?=$price_max['Region']['title']?>,
    				<?if (empty($price_max['Specialist']['id']) && !empty($price_max['Review']['specialist_name'])):?>
    					<a href="/service/review/<?=$price_max['Review']['id']?>/"><?=$price_max['Review']['specialist_name'];?></a>
    				<?elseif (!empty($price_max['Specialist']['id'])):?>
    					<a href="/specialist/profile/<?=$price_max['Specialist']['id']?>"><?=$price_max['Specialist']['name']?></a>
    				<?else:?>
    					<a href="/service/review/<?=$price_max['Review']['id']?>/">специалист не указан</a>
    				<?endif;?>
    			<?else:?>&mdash;<?endif;?>
    		</td>
    	</tr>
    </table>
    <?if (!empty($reviews)):?>
	    <h2><?=$service['Service']['title']?> &mdash; новая информация о ценах:</h2><br><br>
	    <table class="prices_list">
	    	<?foreach ($reviews as $review):?>
	    		<tr>
	    			<td nowrap><?=$this->Display->number($review['Review']['coast'])?> руб.</td>
	    			<td><a href="/service/review/<?=$review['Review']['id']?>/"><?=$review['Review']['subject']?></a></td>
	    		</tr>
	    	<?endforeach;?>
	    </table>
	    <br><br>
	<?endif;?>
	<div class="add-review">
        <a href="/service/add_review/service:<?=$service['Service']['id']?>/">Добавить отзыв</a>
        <span class="ie7"><?=$service['Service']['title']?>: поделитесь своим опытом!</span>
    </div>
</div>