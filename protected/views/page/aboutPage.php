<div class="row about-page">
    <div class="content-width breadcrumbs">
        <?php heretic::Widget('breadCrumbs', $arguments['result']['link'])?>
    </div>   
    <div class="content-width template-page <?=$arguments['result']['link']?>-page">
        <div class="table-type">
            <?php heretic::widget('innerMenu', array('page' => $arguments['result'], 'condition' => 2), 'standartMenu')?>    
            <div class="work-place">
                
                <div class="map-place">
                    <?php heretic::Widget('block', array(), 'map') ?>
                </div>
                    
                <div class="page-content">
                    <?= (!empty($arguments['result']['text'])) ? $arguments['result']['text'] : '' ;?>
                </div>
            </div>
        </div>  
    </div>    
</div>    