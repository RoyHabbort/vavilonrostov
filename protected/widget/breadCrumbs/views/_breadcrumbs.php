<div class="breadcrumbs-widget">
    <div class="breadcrumbs-one breadcrumbs-link">
        <a href="/">
            Главная
        </a>    
    </div>
    <?php if(!empty($arguments['result'])) : ?>
    <?php foreach ($arguments['result'] as $key => $value) : ?>
        <?php if($key == count($arguments['result']) - 1) : ?>
        <div class="breadcrumbs-one">
            <span>
                <?=$value['title']?>
            </span>  
        </div> 
        <?php else : ?>
        <div class="breadcrumbs-one breadcrumbs-link">
            <a href="/<?=Page::getLink($value)?>">
                <?=$value['title']?>
            </a> 
        </div>
        <?php endif;?>
    <?php endforeach;?>
    <?php endif;?>
    <div class="clearfix"></div>
</div>    