<div class="row">
    <div class="content-width breadcrumbs">
        <?php heretic::Widget('breadCrumbs', $arguments['link'])?>
    </div>   
    <div class="content-width template-page <?=$arguments['link']?>-page">
        
        <div class="work-place">
            
            <h1>Новости и события</h1>
        
            <div class='news-all-list'>
        
            <?php heretic::Widget('list', array(
                'data' => $arguments['result'],
                'views' => '_news',
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
