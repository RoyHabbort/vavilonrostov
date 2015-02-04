<div class="row-admin row-input">
    <div class="errors-text error-input">
        <?= (!empty($arguments['errors'])) ? $arguments['errors'] : '';?>
    </div>
    <label><?=$arguments['label']?></label>
    <input 
        class="admin-input <?= (!empty($arguments['class'])) ? $arguments['class'] : '' ; ?>" 
        type="checkbox" 
        name="<?=$arguments['name']?>" <?= (!empty($arguments['result']))? "checked" : '';?>>
    <div class="clearfix"></div>
</div>