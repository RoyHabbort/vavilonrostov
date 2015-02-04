<body>
    <header>
        <div class="row">
            <div class="content-width header-line bottom-line">
                <div class="head-line">
                    <div class="logo-admin">
                        <a href="/admin" class="">Административная панель</a>
                    </div>
                    <div class="exit-div">
                        <a href="/admin/logout/" class="btn btn-blue ">
                            Выход
                        </a>
                    </div>    
                </div>    
                
                <?php heretic::Widget('adminMenu', array(), 'hereticMenu');?>
                
            </div>    
        </div>    
    </header>