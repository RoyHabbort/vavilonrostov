            </div>
            <footer>

                <div class="footer row">

                    <div class="footer-advision content-width">
                        <div class="footer-menu-place">
                            <?php heretic::Widget('mainMenu', array(), 'footerMenu')?>
                        </div>    
                        <div class="footer-contacts">
                            <div class="footer-contacts-one">
                                <div class="map-f"></div>
                                <div class="text-right-col">
                                    <div class="fco-title">Как нас найти</div>
                                    <div class="fco-one">
                                        <div>Ростов-на-Дону</div>
                                        <div class="blue-text">пр. Малиновского, 17ж</div>
                                    </div>    
                                </div>
                            </div>
                            <div class="footer-contacts-one">
                                <div class="phone-f"></div>
                                <div class="text-right-col">
                                    <div class="fco-title">Наши телефоны</div>
                                    
                                    <div class="fco-one">
                                        <strong class="blue-text">Заказ столика</strong>
                                        <div>+7 863 237-85-76 </div>
                                    </div>   
                                        
                                    <div class="fco-one">
                                        <strong class="blue-text">Бронирование номеров</strong>
                                        <div>+7 863 2-900-600</div>
                                    </div>       
                                    
                                </div>
                            </div>    
                            <div class="footer-contacts-one">
                                <div class="studio-f"></div>
                                <div class="text-right-col">
                                    <div class="fco-title">Создание сайта</div>
                                    <div class="fco-one">
                                        <strong class="blue-text">Компания Джаст Милк</strong>
                                        <div>www.justmilk.ru</div>
                                    </div>   
                                </div>    
                            </div>    
                        </div>
                    </div>
                    
                    <?php /* ?>
                    <div class="footer-line content-width">
                        <div class="cooperait">
                            Copyright гостинично-ресторанный комплекс Седьмое Небо © 2014
                        </div>
                        
                        <div class="banner">
                            <img class="banner-one" src="/<?= heretic::$_path['template'] ?>img/banner/tripadvisor.png">
                            <img class="banner-one" src="/<?= heretic::$_path['template'] ?>img/banner/rambler.png">
                            <img class="banner-one" src="/<?= heretic::$_path['template'] ?>img/banner/mail.png">
                        </div>
                        <a href="/" class="studio">
                            <span>Сделано в 
                            <img src="/<?=  heretic::$_path['template']?>img/justmilk.png"> 
                            </span>
                        </a>
                    </div>    
                    <?php */?>
                    
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