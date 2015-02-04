<div class="row">
    <div class="content-width breadcrumbs">
        <?php heretic::Widget('breadCrumbs', $arguments['link'])?>
    </div>   
    <div class="content-width template-page">
        <div class="table-type">
            <div class="work-place">
                
                <div class="category-magazin">
                    <?php heretic::widget('block', array('filter' => $arguments['filter']), 'categoryTags')?>
                </div>    
                
                <div class="alfavit-search">
                    <?php heretic::widget('block', array('filter' => $arguments['filter']), 'alfavitSearch')?>
                </div>
                
                <div class="list-functional-row">
                    <div class="shop-on-map shop-on-map-list">
                        <div class="shop-map-icon"></div>
                        <a href="/shop/shopMap" class="shop-contact-content">Посмотреть на карте</a>
                    </div>
                    
                    
                    <div class="clearfix"></div>
                    
                </div>    
                
                <div class="list-magazine">
                    
                    <?php heretic::Widget('list', array(
                        'data' => $arguments['result'],
                        'views' => '_magazine',
                        'count_elment' => 10,
                        'pagination_cout' => 9999,
                        'pagination_type' => 3,
                        'page' => $arguments['pagination'],
                        'paginationTemplate' => '_paginMagaz',
                        'href' => ''
                    ));?>
                    
                </div>
                
            </div>
        </div>    
    </div>    
</div>    