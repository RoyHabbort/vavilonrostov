<div class="admin-menu-widget">
    
    <ul class="nav nav-tabs">
        <?php if(!empty($arguments['adminMenu'])) : ?>
        <?php foreach($arguments['adminMenu'] as $key => $value) : ?>
        <li class="<?=($key == heretic::$active_page) ? 'active' : ''?>">
            <a href="/admin/<?=$value['link']?>"><?=$value['title']?></a>
        </li>
        <?php endforeach;?>
        <?php endif;?>
        <li>
            <a href="/" target="_blank">На сайт</a>
        </li>
    </ul>   
</div>
