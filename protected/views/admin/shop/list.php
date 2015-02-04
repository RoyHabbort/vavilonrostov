<div class="row" data-controller="shopController">
    <div class="content-width page-admin">

        <div class="admin-title block-padding">
            <div>Редактирование магазинов</div>
            
            <div class='btn-add-page'>
                <a href='/admin/addShop/' class='btn btn-success'>Добавить магазин</a>  
            </div>
        </div>    

        <div class='admin-result-flash-place'>
            <?= admin::getresultFlash();?>
        </div>    
        
        <div class="search-div-shop">
            <div class="search-div-shop-title">Поиск по названию</div>
            <input type="text" name="search" class="form-control">
        </div>    

        <div class="admin-page-block">
        <?php if(!empty($arguments['result'])) : ?>  
            <div class="block-padding">
                <table class="table tablesorter">
                    <thead>
                        <tr>
                            <th>Название магазина</th>
                            <th>Адрес</th>
                            <th>Категория</th>
                            <th>Действия</th>
                        </tr>    
                    </thead>
                    <tbody>
                    <?php foreach ($arguments['result'] as $key => $value) : ?>
                        <tr>
                            <td class="table-title"><?=$value['title']?></td>
                            <td>/<?=$value['link']?></td>
                            <td><?=magazine::getCategoryNameById($value['id_page'])?></td>
                            <td class="edit-tools">
                                <a href="/admin/editShop/<?=$value['id_page']?>/<?=$value['page_type']?>"
                                   ><i class="glyphicon glyphicon-pencil"></i>
                                </a>
                                <a href="/admin/delete/<?=$value['id_page']?>/shop" onClick="return confirm('Вы уверены в удалении?')">
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
                В данный момент нет существующих магазинов
            </div>    
        <?php endif;?>    
        </div>    
    </div>
</div>