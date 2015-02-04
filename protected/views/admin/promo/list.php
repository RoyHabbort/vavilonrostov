<div class="row">
    <div class="content-width page-admin">

        <div class="admin-title block-padding">
            <div>Редактирование промоблока на главной</div>
            
            <div class='btn-add-page'>
                <a href='/admin/addPromo/' class='btn btn-success'>Добавить промослайд</a>  
            </div>
        </div>    

        <div class='admin-result-flash-place'>
            <?= admin::getresultFlash();?>
        </div>    

        <div class="admin-page-block">
        <?php if(!empty($arguments['result'])) : ?>  
            <div class="block-padding">
                <table class="table">
                    <thead>
                        <tr>
                            <th>Изображение</th>
                            <th>Название слайда</th>
                            <th>Ссылка на страницу</th>
                            <th>Действия</th>
                        </tr>    
                    </thead>
                    <tbody>
                    <?php foreach ($arguments['result'] as $key => $value) : ?>
                        <tr>
                            <td class="promo-img"><img src="/<?=$value['promo_banner'][0]['thumb_path']?>"></td>
                            <td class="table-title"><?=$value['title']?></td>
                            <td>/<?=$value['link_promo']?></td>
                            <td class="edit-tools">
                                <a href="/admin/editPromo/<?=$value['id_page']?>/12"
                                   ><i class="glyphicon glyphicon-pencil"></i>
                                </a>
                                <a href="/admin/delete/<?=$value['id_page']?>/promo" onClick="return confirm('Вы уверены в удалении?')">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </a>    
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>    
                </table> 
            </div>    
        <?php else :?>
            <div class="block-padding">
                В данный момент нет существующих ресторанов
            </div>    
        <?php endif;?>    
        </div>    
    </div>
</div>