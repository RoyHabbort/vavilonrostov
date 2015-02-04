        <footer>
            
            <div class="footer-line content-width">
                <div class="cooperait block-padding">
                    © 2008, Компания <a class="type-lnk" href="http://justmilk.ru/">JustMilk</a>
                </div> 
            </div>    
            
            
            <?php
                foreach (heretic::$_script as $key => $value) {
                    echo '<script type="text/javascript" src="/'.heretic::$_path['template'].$value.'"></script>';
                }

                foreach (heretic::$_config['extension'] as $extension => $option) {

                    foreach ($option['js'] as $key => $value) {
                        $dir = heretic::$_path['extension'] . $option['dir'] . $value;
                        echo '<script type="text/javascript" src="/'.$dir.'"></script>';
                    }

                    foreach ($option['css'] as $key => $value) {
                        $dir = heretic::$_path['extension'] . $option['dir'] . $value;
                        echo '<link rel="stylesheet" type="text/css" href="/'.$dir.'">';
                    }

                }
            ?>
        </footer>
    </body>
</html>