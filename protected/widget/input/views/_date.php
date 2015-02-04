<div class="row-admin row-input">
    <div class="errors-text error-input">
        <?= (!empty($arguments['errors'])) ? $arguments['errors'] : '';?>
    </div>
    <label><?=$arguments['label']?></label>
    <input type="text" name="<?=$arguments['name']?>" class="admin-input text-input date-input <?= (!empty($arguments['class'])) ? $arguments['class'] : '' ; ?>" value="<?= (!empty($arguments['result']))? $this->converteDate($arguments['result'], 'onlyDate') : '';?>">
    <div class="clearfix"></div>
</div>