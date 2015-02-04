<div class="admin-menu-widget">

    <ul class="admin-menu">
        <?php if(!empty($arguments['adminMenu'])) : ?>
        <?php foreach($arguments['adminMenu'] as $key => $value) : ?>
        <li>
            <a href="/heretic/<?=$value['link']?>"><?=$value['title']?></a>
        </li>
        <?php endforeach;?>
        <?php endif;?>
        <li>
            <a href="/" target="_blank">На сайт</a>
        </li>
    </ul>   
</div>
