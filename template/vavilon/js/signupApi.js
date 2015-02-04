

$(document).ready(function(){
   
    if(typeof HERETIC  === "undifined"){
        HERETIC = {};
    }
    HERETIC.modules = HERETIC.modules || {};
    
    HERETIC.modules.signupApi = function(){
        
        var
            showSignup = function(){
                $('.signup-wrapper').css('display', 'block');
                $('.signup-widget').css('display', 'block');
            },
            unshowSignup = function(){
                $('.signup-wrapper').css('display', 'none');
                $('.signup-widget').css('display', 'none');
                clearForm();
            },
            clearForm = function(){
                $('.signup-body input').val('');
                $('.signup-body textarea').val('');
            },
            changeForm = function(){
                $(this).removeClass('error-class');
            },
            orderForm = function(){
                var order = {};
                
                order.fio = $('.form-arend-input-row input[name="fio"]').val();
                order.email = $('.form-arend-input-row input[name="email"]').val();
                order.question = $('.form-arend-input-row textarea[name="question"]').val();
                
                $.ajax({
                    
                    url : 'ajax/addSignup',
                    method : 'POST',
                    dataType : 'JSON',
                    data : {order : order},
                    success : function(e){


                        if(e.errors){
                            if(e.errors.public_error){
                                alert(e.errors.public_error);
                            }
                            if(e.valid_errors){

                                for(var key in e.valid_errors){
                                    switch(key){
                                        case 'question' : $('.form-arend-input-row textarea[name="question"]').addClass('error-class');
                                            break;
                                        case 'fio' : $('.form-arend-input-row input[name="fio"]').addClass('error-class');
                                            break;
                                        case 'email' : $('.form-arend-input-row input[name="email"]').addClass('error-class');
                                            break;
                                        default:
                                            break;

                                    }
                                }
                            }
                        }

                        if(e.success){
                            alert(e.success);
                            unshowSignup();
                        }
                    },
                    errors : function(e){
                        alert('Ошибка связи с сервером! Попробуйте обновить страницу');
                    }
                    
                });
                
            }
            
        
        return {
            showSignup : showSignup,
            unshowSignup : unshowSignup,
            changeForm : changeForm,
            orderForm : orderForm
        }
        
    }
    
});