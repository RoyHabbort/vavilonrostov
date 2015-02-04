<div class="content-width page-admin">
    
    <div class="admin-title block-padding">
        <div>Редактирование отзывов</div>
    </div>    
    
    <div class='success-flash padding-left-20'>
        <?= heretic::getFlash('success');?>
    </div>    
    
    
    <div class="margin-bottom-50">
        <h3 class="padding-left-20">На модерацию</h3>

        <div class="admin-page-block padding-left-right-20">
        <?php if(!empty($arguments['result']['moder'])) : ?>    
            <?php foreach ($arguments['result']['moder'] as $key => $value) : ?>
                <div class="one-block block-padding margin-bottom-20">
                    <div class="title">
                        <?=$value['name'];?>
                        <span class="grey-sub padding-left-20"><?= $value['date'] ?></span>
                    </div>
                    <div class="email grey-sub"><?=$value['email']?></div>
                    <div class="text">
                        <?=$value['text']?>
                    </div>
                    <div class="button-position">
                        <a class="btn btn-green" href="/heretic/reviewSuccess/<?=$value['id_reviews']?>">
                            Одобрить
                        </a>    
                        <a class="btn btn-red" href="/heretic/deleteItems/reviews/<?=$value['id_reviews']?>/review">
                            Удалить
                        </a>
                    </div>    
                </div>    
            <?php endforeach;?>  
        <?php else :?>
            <div class="one-block block-padding">
                В данный момент нет отзывов на модерацию
            </div>    
        <?php endif;?>  
        </div>    
    </div>
    
    <div class="margin-bottom-50">
        <h3 class="padding-left-20">Одобренные</h3>    

        <div class="admin-page-block padding-left-right-20">
        <?php if(!empty($arguments['result']['success'])) : ?>    
            <?php foreach ($arguments['result']['success'] as $key => $value) : ?>
                <div class="one-block block-padding margin-bottom-20">
                    <div class="title">
                        <?=$value['name'];?>
                        <span class="grey-sub padding-left-20"><?= $value['date'] ?></span>
                    </div>
                    <div class="email grey-sub"><?=$value['email']?></div>
                    <div class="text">
                        <?=$value['text']?>
                    </div>
                    <div class="button-position">
                        <a class="btn btn-red" href="/heretic/deleteItems/reviews/<?=$value['id_reviews']?>/review">
                            Удалить
                        </a>
                    </div>    
                </div>    
            <?php endforeach;?>  
        <?php else :?>
            <div class="one-block block-padding">
                В данный момент нет одобренных отзывов
            </div>    
        <?php endif;?>  
        </div>    
    </div>
    
    
</div>