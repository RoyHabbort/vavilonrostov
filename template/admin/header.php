<body>
    <header>
        <div class="row">
            <div class="content-width header-line">
                <div class="head-line">
                    <div class="logo-admin">
                        <a href="/admin" class="">Административная панель</a>
                    </div>
                    <div class="exit-div">
                        <button type="button" onClick="document.location = '/admin/logout'" class="btn btn-primary ">
                            Выход
                        </button>
                    </div>    
                </div>    
                
                <?php heretic::Widget('adminMenu', array(), 'adminMenu');?>
                
            </div>    
        </div>    
    </header>