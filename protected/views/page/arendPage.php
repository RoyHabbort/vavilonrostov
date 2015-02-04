<div class="row">
    <div class="content-width breadcrumbs">
        <?php heretic::Widget('breadCrumbs', $arguments['result']['link'])?>
    </div>   
    <div class="content-width template-page <?=$arguments['result']['link']?>-page">
        <div class="table-type">
            <?php heretic::widget('innerMenu', array('page' => $arguments['result'], 'condition' => 2), 'standartMenu')?>    
            <div class="work-place">
                
                <div class="page-content">
                    <?= (!empty($arguments['result']['text'])) ? $arguments['result']['text'] : '' ;?>
                    <div class="clearfix"></div>
                </div>
                
                <div class="arend-options">
                    <?php heretic::Widget('block', array(), 'arendOptions')?>
                </div> 
                
                <div class="arend-brand">
                    <?php heretic::Widget('block', array(), 'arendBrand')?>
                </div>    
                
            </div>
        </div>  
    </div>    
</div>    