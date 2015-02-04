<div class="main-menu-list">
    <?php foreach($arguments['menu'] as $key => $value) : ?>
    <a data-pjax class="<?= ($value['link'] == $arguments['active_page']) ? 'active' : '' ;?> main-menu-link dec-lnk" href="/<?=Page::getLink($value)?>"><span><?=$value['title']?></span></a>
    <?php /* if($key != count($arguments['menu'])-1) : ?><span class="hr-nav-img"><span class="hr-hr"></span><span class="hr-hl"></span></span><?php endif; */?>
    <?php endforeach; ?>
</div>
