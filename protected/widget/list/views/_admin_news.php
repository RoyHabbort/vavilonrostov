<?php if($arguments['result']) :?>
    <?php foreach ($arguments['result'] as $key => $value) : ?>
        <div class="admin-page block-padding">
            <div class="page-title">
                <?=$value['title'];?>
            </div>
            <div class="admin-page-btn">
                <a href="<?=$arguments['element_href']?><?=$value['id_news']?>" class="btn btn-blue">Редактировать</a>
            </div>    
        </div>    
    <?php endforeach;?>  
<?php else : ?>
    <div>На данный момент нет новостей.</div>
<?php endif; ?>