<body ng-app="app">
    <div class="content-wrapper">
        <header>
            
            <div class="head-line">
                <div class="logo">
                    <div class="div-logo">
                        <a href="/" class="logo-line">
                            <div class="logo-img">
                                <img src="/<?= heretic::$_path['template'] ?>img/logo.png">
                            </div>
                            <div class="logo-title">
                                Седьмое небо
                            </div>
                            <div class="logo-sub">
                                Гостинично-ресторанный комплекс
                            </div>
                            <div class="clearfix"></div>
                        </a>
                    </div>    
                </div>
                <?php heretic::Widget('mainMenu')?>
                <div class="call-cell">
                    <div class="call-line">
                        <div class="call-img">
                            <img src="/<?= heretic::$_path['template']?>img/icons/phone.png">
                        </div>
                        <div class="call-text">
                            <div class="call-title">Заказать звонок</div>
                            <div class="call-sub">Мы вам перезвоним</div>
                        </div>
                    </div>    
                    
                    <?php heretic::Widget('singup')?>
                    
                </div>
            </div>
            
            <div class="topic-line">
                <div class="left-menu" ng-controller="bookingCtrl">
                    <div class="booking-block">
                        <?php heretic::Widget('booking', array(), 'bookingMain')?>
                    </div> 
                    <div class="appartament-slider">
                        <?php heretic::Widget('slider', array(), 'appartament')?>
                    </div>  
                </div>
                <div class="topic-image">
                    <div class="one-topic-img">
                        <img src="/<?=heretic::$_path['template']?>img/bg_main.jpg">
                    </div>
                </div>   
                <div class="clearfix"></div>
            </div> 
            
        </header>
        <div class="page">
      