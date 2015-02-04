<div class="row entertainment-page">
    <div class="content-width breadcrumbs">
        <?php heretic::Widget('breadCrumbs', $arguments['result']['link'])?>
    </div>   
    <div class="content-width template-page <?=$arguments['result']['link']?>-page">
        <div class="table-type">
            <div class="work-place">
                
                <div class="page-content">
                    <?= (!empty($arguments['result']['text'])) ? $arguments['result']['text'] : '' ;?>
                </div>
                
                <div class="entertainment-place">
                    <?php heretic::Widget('block', array(), 'entertainment') ?>
                </div>
                
            </div>
        </div>  
    </div>    
</div>    