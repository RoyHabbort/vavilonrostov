<div class="row-admin row-input">
    <div class="errors-text">
        <?= (!empty($arguments['errors'])) ? $arguments['errors']: '';?>
    </div>
    <label><?=$arguments['label']?></label>
    <select class="admin-select <?= (!empty($arguments['class'])) ? $arguments['class'] : '' ; ?>" name="<?=$arguments['name']?>">
        <?php foreach ($arguments['options'] as $key => $value) : ?>
        <option <?= ($key == $arguments['result']) ? 'selected="selected"' : '' ; ?> value="<?=$key?>"><?=$value;?></option>
        <?php endforeach;?>
    </select>
    <div class="clearfix"></div>
</div>