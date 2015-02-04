<div class="row-admin row-input">
    <div class="errors-text">
        <?= (!empty($arguments['errors'])) ? $arguments['errors']: '';?>
    </div>
    <label><?=$arguments['label']?></label>
    <textarea <?= ($arguments['no-CK'] == 1) ? '' : 'id="CKeditor"' ;?>
        class="admin-input <?= (!empty($arguments['class'])) ? $arguments['class'] : '' ; ?>"
        name="<?=$arguments['name']?>"><?= (!empty($arguments['result']))? $arguments['result'] : '';?>
    </textarea>
    <div class="clearfix"></div>
</div>