<div class="row-admin row-input">
    
    <?php if(!empty($arguments['result'])) : ?>
    <div class="preview-single-image">
        <img src="/assets/images/<?=$arguments['filter']['thumb_dir'] . '/' . $arguments['result']?>" >
    </div>    
    <?php endif;?>
    
    <div class="errors-text">
        <?= (!empty($arguments['errors'])) ? $arguments['errors']: '';?>
    </div>
    <label><?=$arguments['label']?></label>
    
    <input type="file" name="<?=$arguments['name']?>" class="admin-input text-input <?= (!empty($arguments['class'])) ? $arguments['class'] : '' ; ?>">
    
    <div class="clearfix"></div>
</div>
