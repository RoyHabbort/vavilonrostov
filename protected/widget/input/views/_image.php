<div class="image-download-wrap">
 
    <div class="row-admin row-input">

        <div class="errors-text error-input">
            <?= (!empty($arguments['errors'])) ? $arguments['errors'] : '';?>
        </div>

        <label><?=$arguments['label']?></label>
        <?php if(!empty($arguments['result']['option'])) : ?>
        <?php  heretic::Widget('editImage', $arguments['result']);?>
        <?php endif;?>
        <div class="edit-image-title">Новые изображения</div>
        <div id="image-preview-wrapper" class="image-preview-wrapper">
            
        </div>    

        <div id="image-download-btn">
            <div date-name="<?=$arguments['name']?>" class="image-download-btn">
                <div class="dashed-download">
                    <span class="download-text">Загрузить фото</span>
                </div>
            </div>    
        </div>
        <div class="clearfix"></div>

    </div>
</div>