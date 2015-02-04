<div class="row news-page">
    <div class="content-width breadcrumbs">
        <?php heretic::Widget('breadCrumbs', $arguments['result']['link'])?>
    </div>   
    <div class="content-width template-page <?=$arguments['result']['link']?>-page">
        <div class="table-type">
           
            <div class="work-place">
                
                <div class="stock-title-list content-width">
                    <div class="stock-menu">
                        <a href="/stock" class="stock-menu-one <?= ($arguments['stockOpt'] != 'archive') ? 'active' : '' ;?>">Действующие<a>    
                        <a href="/stock/archive" class="stock-menu-one <?= ($arguments['stockOpt'] == 'archive') ? 'active' : '' ;?>">Архив<a>    
                    </div>
                    <div class="clearfix"></div>
                </div>
                
                
                <?php heretic::Widget('block', array('opt' => $arguments['stockOpt']), 'allStock')?>
                
            </div>
        </div>
        
    </div> 
</div>    