<div class="row">
    <div class="content-width page-admin">

        <div class="admin-title block-padding">
            <div>Редактирование новостей</div>
            
            <div class='btn-add-page'>
                <a href='/admin/addNews/' class='btn btn-success'>Добавить новость</a>  
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
                            <th>Название новости</th>
                            <th>Адрес</th>
                            <th>Дата</th>
                            <th>Действия</th>
                        </tr>    
                    </thead>
                    <tbody>
                    <?php foreach ($arguments['result'] as $key => $value) : ?>
                        <tr>
                            <td class="table-title"><?=$value['title']?></td>
                            <td>/<?=$value['link']?></td>
                            <td><?=$this->converteDate($value['date_create'])?></td>
                            <td class="edit-tools">
                                <a href="/admin/editNews/<?=$value['id_page']?>/<?=$value['page_type']?>"
                                   ><i class="glyphicon glyphicon-pencil"></i>
                                </a>
                                <a href="/admin/delete/<?=$value['id_page']?>/news" onClick="return confirm('Вы уверены в удалении?')">
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
                В данный момент нет существующих новостей
            </div>    
        <?php endif;?>    
        </div>    
    </div>
</div>