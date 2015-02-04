<div class='arend-brand-widget'>
    <div class="arend-brand">
        <form action="/admin/addArendBrand/<?=$arguments['page_id']?>/<?=$arguments['page_type']?>"  method="post" name="page-edit-material" class="edit-form">
            
            <div class='arend-brand-title'>Привязать якорных арендаторов</div>
            
            <?php if($arguments['result']) : ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Объект</th>
                            <th>Действие</th>
                        </tr>
                    </thead> 
                    <tbody>
                    <?php foreach ($arguments['result'] as $key => $value) : ?>
                        <tr>
                            <td><?=$value['title']?></td>
                            <td>
                                <a href="/admin/deleteArendBrand/<?=$value['id_page']?>/<?=$arguments['page_id']?>/<?=$arguments['page_type']?>" onClick="return confirm('Вы уверены в удалении?')">
                                    <i class="glyphicon glyphicon-trash"></i>
                                </a>
                            </td>
                        </tr>
                    <?php endforeach;?>
                    </tbody>    
                </table>    
            <?php endif;?>
            
            <?php if(!empty($arguments['allArend'])) : ?>
            <select name='id_page' class='admin-input text-input'>
                <?php foreach($arguments['allArend'] as $key => $value) : ?>
                <option value='<?=$value['id_page']?>'><?=$value['title']?></option>
                <?php endforeach;?>
            </select>
            <?php endif;?>
            
            <button type='submit' class='btn btn-success'>Добавить</button>

        </form>
            
    </div> 
</div>    