<h2><?=isset($sliderTitle) ? $sliderTitle : 'Другие полезные статьи по теме'?></h2>
<?php $chunk = array_chunk($useFullArticlesSlider, 7) ?>
<div class="other-articles-slider">
  <?php foreach ($chunk as $item): ?>
    <?php //Debugger::dump($item[0]['Post']) ?>
    <div>
      <?php if (isset($item[0])): ?>
        <a href="/article/<?= $item[0]['Post']['alias'] ?>" class="big-article">
          <img src="<?= $this->Element("image",
            array(
              "model"   => "post",
              "id"      => $item[0]['Post']['id'],
              "alias"   => "image",
              "type"    => "main",
              "onlyurl" => true,
            )) ?>" style="height: 410px" alt="">
          <div class="text">
            <div class="theme"><?= $item[0]['PostCategory']['title'] ?></div>
            <div class="title"><?= $item[0]['Post']['title'] ?></div>
            <p><?= $item[0]['Post']['description'] ?></p>
          </div>
        </a>
      <?php endif; ?>
      <?php if (isset($item[1])): ?>
        <div class="medium-article">
          <div class="item">
            <div class="theme"><?= $item[1]['PostCategory']['title'] ?></div>
            <div class="link" style="max-width: 100%">
              <a href="/article/<?= $item[1]['Post']['alias'] ?>"><?= DisplayHelper::short($item[1]['Post']['title'],13) ?></a>
            </div>
            <p><?= DisplayHelper::short($item[1]['Post']['description'], 14) ?></p>
          </div>

          <?php if (isset($item[2])): ?>
            <div class="item">
              <div class="theme"><?= $item[2]['PostCategory']['title'] ?></div>
              <div class="link" style="max-width: 100%">
                <a href="/article/<?= $item[2]['Post']['alias'] ?>"><?= DisplayHelper::short($item[2]['Post']['title'], 10) ?></a>
              </div>
              <p><?= DisplayHelper::short($item[2]['Post']['description'], 13) ?></p>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
      <?php if (isset($item[3])): ?>
        <div class="small-article">
          <div class="item">
            <div class="theme"><?= $item[3]['PostCategory']['title'] ?></div>
            <a href="/article/<?= $item[3]['Post']['alias'] ?>">
              <?=  DisplayHelper::short($item[3]['Post']['title']) ?>
            </a>
          </div>
          <?php if (isset($item[4])): ?>
            <div class="item">
              <div class="theme"><?= $item[4]['PostCategory']['title'] ?></div>
              <a href="/article/<?= $item[4]['Post']['alias'] ?>">
                <?=  DisplayHelper::short($item[4]['Post']['title']) ?>
              </a>
            </div>
          <?php endif; ?>
          <?php if (isset($item[5])): ?>
            <div class="item">
              <div class="theme"><?= $item[5]['PostCategory']['title'] ?></div>
              <a href="/article/<?= $item[5]['Post']['alias'] ?>">
                <?=  DisplayHelper::short($item[5]['Post']['title']) ?>
              </a>
            </div>
          <?php endif; ?>
          <?php if (isset($item[6])): ?>
            <div class="item">
              <div class="theme"><?= $item[6]['PostCategory']['title'] ?></div>
              <a href="/article/<?= $item[6]['Post']['alias'] ?>">
                <?=  DisplayHelper::short($item[6]['Post']['title']) ?>
              </a>
            </div>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    </div>
  <?php endforeach; ?>
</div>
