<div class='row'>

    
    <div class="content-width template-page <?=$arguments['result']['link']?>-page">
        <div class="table-type">
           
            <div class="work-place">
                
                <h1>Подписка на рассылку</h1>
                
                
                <?php if(!empty($_SESSION['success'])) : ?>
                <div class="page-content padding-bottom-40">
                    <div class="success-subscrib"><?=heretic::getFlash('success')?></div>
                    <a href="/" class="blue-lnk">Вернуться на главную</a>
                </div>
             
                <?php else : ?>
                
                <div class='subscrib-place'>
                    <form name='subscrib' action='/page/subsсrib' method='post'>
                        
                        <div class="form-arend-input-row">
                            <label class="clear-label">Фамилия</label>
                            <div class="error-text"><?= (!empty($arguments['errors']['s_famaly'])) ? $arguments['errors']['s_famaly'] : '' ; ?></div>
                            <input name="s_famaly" 
                                   class="clear-input" 
                                   type="text"
                                   value="<?= (!empty($arguments['post']['s_famaly'])) ? $arguments['post']['s_famaly'] : '' ; ?>">
                        </div> 
                        
                        
                        <div class="form-arend-input-row">
                            <label class="clear-label">Имя</label>
                            <div class="error-text"><?= (!empty($arguments['errors']['s_name'])) ? $arguments['errors']['s_name'] : '' ; ?></div>
                            <input name="s_name" 
                                   class="clear-input" 
                                   type="text"
                                   value="<?= (!empty($arguments['post']['s_name'])) ? $arguments['post']['s_name'] : '' ; ?>">
                        </div>
                        
                        <div class="form-arend-input-row">
                            <label class="clear-label">Отчество</label>
                            <div class="error-text"><?= (!empty($arguments['errors']['s_sename'])) ? $arguments['errors']['s_sename'] : '' ; ?></div>
                            <input name="s_sename" 
                                   class="clear-input" 
                                   type="text"
                                   value="<?= (!empty($arguments['post']['s_sename'])) ? $arguments['post']['s_sename'] : '' ; ?>">
                        </div>
                        
                        <div class="form-arend-input-row">
                            <label class="clear-label">Дата рождения</label>
                            <div class="error-text"><?= (!empty($arguments['errors']['s_date_bthd'])) ? $arguments['errors']['s_date_bthd'] : '' ; ?></div>
                            <input name="s_date_bthd" 
                                   class="clear-input input-date" 
                                   type="text"
                                   value="<?= (!empty($arguments['post']['s_date_bthd'])) ? $arguments['post']['s_date_bthd'] : '' ; ?>">
                        </div>
                        
                        
                        <div class="form-arend-input-row">
                            <div class="clear-label">Пол</div>
                            <div class="error-text"><?= (!empty($arguments['errors']['sex'])) ? $arguments['errors']['sex'] : '' ; ?></div>
                            <label for="male" class="radio-label check-line">
                                <input id="male" 
                                       class="i-check" 
                                       type="radio" 
                                       name="sex" 
                                       value="male"
                                       <?= ($arguments['post']['sex'] == 'male') ? 'checked': '' ; ?>>
                                <span class="padding-left-10">мужской</span>
                            </label>
                            <label for="female" class="radio-label check-line">
                                <input id="female" 
                                       class="i-check" 
                                       type="radio" 
                                       name="sex" 
                                       value="female"
                                       <?= ($arguments['post']['sex'] == 'female') ? 'checked': '' ; ?>>
                                <span class="padding-left-10">женский</span>
                            </label>
                        </div>
                        
                        
                        <div class="form-arend-input-row">
                            <label class="clear-label">Email</label>
                            <div class="error-text"><?= (!empty($arguments['errors']['s_email'])) ? $arguments['errors']['s_email'] : '' ; ?></div>
                            <input name="s_email" 
                                   class="clear-input" 
                                   type="text"
                                   value="<?= (!empty($arguments['post']['s_email'])) ? $arguments['post']['s_email'] : '' ; ?>">
                        </div>
                        
                        <div class="form-arend-input-row">
                            <label class="clear-label">Телефон</label>
                            <div class="error-text"><?= (!empty($arguments['errors']['s_phone'])) ? $arguments['errors']['s_phone'] : '' ; ?></div>
                            <input name="s_phone" 
                                   class="clear-input input-phone" 
                                   type="text"
                                   value="<?= (!empty($arguments['post']['s_phone'])) ? $arguments['post']['s_phone'] : '' ; ?>">
                        </div>
                                               
                        <div class="form-arend-input-row">
                            <div class="clear-label">Есть ли у вас дети до 12 лет?</div>
                            <div class="error-text"><?= (!empty($arguments['errors']['s_child'])) ? $arguments['errors']['s_child'] : '' ; ?></div>
                            <label for="yes" class="radio-label check-line">
                                <input id="yes" 
                                       class="i-check" 
                                       type="radio" 
                                       name="s_child" 
                                       value="yes" 
                                       <?= ($arguments['post']['s_child'] == 'yes') ? 'checked': '' ; ?>>
                                <span class="padding-left-10">да</span>
                            </label>
                            <label for="no" class="radio-label check-line">
                                <input id="no" 
                                       class="i-check" 
                                       type="radio" 
                                       name="s_child" 
                                       value="no"
                                       <?= ($arguments['post']['s_child'] == 'no') ? 'checked': '' ; ?>>
                                <span class="padding-left-10">нет</span>
                            </label>
                        </div>                        
                        
                        <div class="form-arend-input-row">
                            <label class="clear-label">Город</label>
                            <div class="error-text"><?= (!empty($arguments['errors']['s_city'])) ? $arguments['errors']['s_city'] : '' ; ?></div>
                            <input name="s_city"
                                   class="clear-input" 
                                   type="text"
                                   value="<?= (!empty($arguments['post']['s_city'])) ? $arguments['post']['s_city'] : '' ; ?>">
                        </div>
                        
                        <div class="form-arend-input-row">
                            <label class="clear-label">Адрес</label>
                            <div class="error-text"><?= (!empty($arguments['errors']['s_adress'])) ? $arguments['errors']['s_adress'] : '' ; ?></div>
                            <input name="s_adress" 
                                   class="clear-input" 
                                   type="text"
                                   value="<?= (!empty($arguments['post']['s_adress'])) ? $arguments['post']['s_adress'] : '' ; ?>">
                        </div>
                        
                        
                        <div class="form-arend-input-row">
                            <div class="clear-label">Передача перс.данных </div>
                            <div class="error-text"><?= (!empty($arguments['errors']['pers_data'])) ? $arguments['errors']['pers_data'] : '' ; ?></div>
                            <label for="pers_data" class="radio-label check-line">
                                <input id="pers_data" class="i-check" type="radio" name="pers_data" value="yes">
                                <span class="padding-left-10">согласие на передачу, обработку и хранение персональных данных, указанных выше</span>
                            </label>
                        </div>
                        
                        
                        <?php if(!empty($arguments['category'])) : ?>
                        
                            <div class="form-arend-input-row">
                                <div class="clear-label">Меня интересует</div>
                                <div class="error-text"><?= (!empty($arguments['errors']['integesting'])) ? $arguments['errors']['integesting'] : '' ; ?></div>
                            <?php foreach($arguments['category'] as $key => $value) : ?>
                                <label for="key-<?=$key?>" class="check-line">
                                    <input id="key-<?=$key?>" 
                                           name="integesting[<?=$value['title']?>]" 
                                           class="i-check" 
                                           type="checkbox"
                                           <?= (in_array($value['title'], $arguments['post']['integesting'])) ? 'checked' : '' ;?>
                                           >
                                    <span class="padding-left-10"><?=$value['title']?></span>
                                </label>
                            <?php endforeach;?>
                            </div>
                        <?php endif;?>
                        
                        
                        <button class="yellow-btn" type="submit">Подписаться</button>
                        
                    </form>
                </div>    
                
                <?php endif;?>
                
            </div>
        </div>  
    </div> 
    
</div>    