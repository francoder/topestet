<?if (isset($best_reviews)):?>
	<div class="b-img">
		<div style="padding:5px;">
			<div class="title"><h4><?=$best_reviews_title?></h4></div>
			<div class="bannershadow">
			<?foreach ($best_reviews as $review):?>
				<div class="review">
					<a href="/service/review/<?=$review['Review']['id']?>/"><div class="user left">
			            <img src="/img/<?if ($review['Review']['note_result'] == 1):?>th_ora<?elseif ($review['Review']['note_result'] == 2 || $review['Review']['note_result'] == 0):?>undecided<?else:?>th_gre<?endif;?>.png" alt="" >
			            <span>
			            	<?$notes = @$review_notes;?>
			            	<?=$notes[$review['Review']['note_result']];?>
			            </span><br>
			            <span class="count <?if($review['Review']['thank_all_count'] > 0):?>pos<?endif;?>"><?if($review['Review']['thank_all_count'] > 0):?>+<?endif;?><span itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating"><span itemprop="ratingValue" content="<?=$review['Review']['thank_all_count']?>"><?=$review['Review']['thank_all_count']?></span></span></span>
			        </div></a>
			        <div class="other">
				        <h3 itemprop="name"><a itemprop="url" href="/service/review/<?=$review['Review']['id']?>/"><?=$review['Review']['subject']?></a></h3>
	    				<span><meta itemprop="datePublished" content="<?=$this->Display->date("Y-m-d", strtotime($review['Review']['edited']))?>"><?=$this->Display->date("d %m Y", strtotime($review['Review']['edited']))?> | <span itemprop="author"><?=$review['User']['name']?></span>, <span class="marked"><?=$review['Region']['title']?></span> | Стоимость: <span itemprop="offers" itemscope itemtype="http://schema.org/Offer"><span itemprop="price" class="marked"><?=$this->Display->number($review['Review']['coast'])?> руб.</span></span></span>
			        </div>
			        <div class="clear"></div>
				</div>
			<?endforeach;?>
			<a href="/reviews/" class="more">Все отзывы</a>
			</div>
		</div>
	</div>
<?endif;?>
