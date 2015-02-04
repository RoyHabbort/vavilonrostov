<div class="row">
    <div class="content-width page-admin">

        <div class="admin-title block-padding">
            <div>Редактирование ресторанов</div>
            
            <div class='btn-add-page'>
                <a href='/admin/addRestoraunt/' class='btn btn-success'>Добавить ресторан</a>  
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
                            <th>Название ресторана</th>
                            <th>Адрес</th>
                            <th>Действия</th>
                        </tr>    
                    </thead>
                    <tbody>
                    <?php foreach ($arguments['result'] as $key => $value) : ?>
                        <tr>
                            <td class="table-title"><?=$value['title']?></td>
                            <td>/<?=$value['link']?></td>
                            <td class="edit-tools">
                                <a href="/admin/editRestoraunt/<?=$value['id_page']?>/<?=$value['page_type']?>"
                                   ><i class="glyphicon glyphicon-pencil"></i>
                                </a>
                                <a href="/admin/delete/<?=$value['id_page']?>/restoraunt" onClick="return confirm('Вы уверены в удалении?')">
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