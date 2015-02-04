<div class="admin-login-form">
    
    <h1>Форма входа</h1>
    <form action="/heretic" method="post" name="login-admin-form">
        <div class="row-form">
            <div class="error-text">
                <?= (!empty($arguments['errors'])) ? $arguments['errors'] : '';?>
            </div>    
            <label>Логин</label>
            <input name="login" type="text" class="input-text">
        </div>
        <div class="row-form">
            <label>Пароль</label>
            <input name="password" type="password" class="input-text">
        </div>
        <button type="submit">Вход</button>
    </form>
</div>


<style>
    
    body{
        font-family: Arial;
        background: #f4f4f4;
    }
    
    .admin-login-form{
        background: #fff;
        display: block;
        width:400px;
        height:200px;
        border:solid 1px #a1a1a1;
        margin:150px auto;
        box-shadow: 0 0 5px 0 #a1a1a1;
    }
    
    .admin-login-form h1{
        font-size: 26px;
        line-height: 1.4;
        margin:10px 0px 20px;
        text-align: center;
    }
    
    .error-text{
        color:red;
        font-size: 12px;
    }
    
    .row-form{
        display: block;
        width:255px;
        margin:0 auto 10px;
    }
    
    .row-form label{
        display: inline-block;
        width:70px;
    }
    
    .row-form input{
        width:180px;
        border:solid 1px #a4a4a4;
        padding:4px;
        outline: none;
        box-shadow: none;
    }
    
    button[type="submit"]{
        display: inline-block;
        background: #0072BC;
        border:solid 1px #555;
        outline: none;
        color:#fff;
        font-size: 16px;
        padding:3px 8px;
        margin-left: 267px;
        cursor: pointer;
    }
    
</style>    