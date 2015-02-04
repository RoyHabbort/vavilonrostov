<div class="row">
    <div class="content-width breadcrumbs">
        <?php heretic::Widget('breadCrumbs', $arguments['result']['link'])?>
    </div>   
    <div class="content-width template-page <?=$arguments['result']['link']?>-page">
        <div class="table-type">
            <?php heretic::widget('innerMenu', array('page' => $arguments['result'], 'condition' => 2), 'standartMenu')?>    
            <div class="work-place">
                <h1><?=$arguments['result']['title']?></h1>
                <div class="page-content">
                    <?= (!empty($arguments['result']['text'])) ? $arguments['result']['text'] : '' ;?>
                </div>
                
                <?php if($arguments['result']['id_page'] == 176) : ?>
                    <div class='block-all-news'>
                        <?=heretic::hvar_dump('block', array(), 'newsAll')?>
                    </div>    
                <?php endif;?>
            </div>
        </div>  
    </div>    
</div>    