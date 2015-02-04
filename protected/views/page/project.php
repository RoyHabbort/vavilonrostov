<div class="row">
    <div class="content-width breadcrumbs">
        <?php heretic::Widget('breadCrumbs', $arguments['result']['link'])?>
    </div>    
    <div class="content-width">
        
        <h1><?=$arguments['result']['title']?></h1>
        <div class="page-content">
            <?= (!empty($arguments['result']['text'])) ? $arguments['result']['text'] : '' ;?>
        </div>
    </div>    
</div>    