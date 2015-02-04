            </div>
            <footer>
                
                <?php /*
                <div class="footer-menu content-width">
                    <?php heretic::Widget('mainMenu', array(), 'footerMenu');?>
                </div>
                */?>
                
                <div class="footer-line content-width">
                    
                    <div class="footer-menu">
                        
                        <div class="footer-menu-list">
                            <a href="/about">Компания</a>
                            
                            <a href="/Pravovyie_aspektyi">Правовые аспекты</a>
                        </div>    
                        
                    </div>    
                    
                    <div class='block-signup'>
                        <?php heretic::Widget('signup')?>
                    </div>
                    
                    <div class="footer-table">
                        <div class="f-contact">
                            <div class="">© Торгово-развлекательный центр «Вавилон» </div>
                        </div>

                        <div class="f-time">
                            <div class="">Ростов-на-Дону пр.Космонавтов, 2/2</div>
                        </div>

                        <div class="f-search">
                            <div class="f-logotip-wraper">
                                <a href="http://www.justmilk.ru" class="milk-logo">
                                    <img src="/<?=heretic::$_path['template']?>img/justmilk2.png">
                                </a>    
                                <div class="f-logo-text">
                                    Создание сайта<br />
                                    <a href="http://justmilk.ru">Компания Джаст Милк</a>
                                </div>    
                            </div>    
                        </div>
                    </div>
                    
                </div>    
            </footer>
        </div>
        
        <div class="script-position">
            
            <?php
                foreach (heretic::$_script as $key => $value) {
                    echo '<script type="text/javascript" src="/'.heretic::$_path['template'].$value.'"></script>';
                }

                foreach (heretic::$_config['extension'] as $extension => $option) {

                    if(($option['template'] == 'all')||($option['template'] == heretic::$_config['template_name'])){

                        foreach ($option['js'] as $key => $value) {
                            $dir = heretic::$_path['extension'] . $option['dir'] . $value;
                            echo '<script type="text/javascript" src="/'.$dir.'"></script>';
                        }

                        foreach ($option['css'] as $key => $value) {
                            $dir = heretic::$_path['extension'] . $option['dir'] . $value;
                            echo '<link rel="stylesheet" type="text/css" href="/'.$dir.'">';
                        }

                    }

                }

            ?>
        </div>
    </body>
</html>