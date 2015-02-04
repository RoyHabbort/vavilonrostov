/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
   
    
    if(typeof HERETIC  === "undifined"){
        HERETIC = {};
    }
    HERETIC.modules = HERETIC.modules || {};
    
    HERETIC.modules.arendApi = function(){
        
        var
        currentForm = '',
        showForm = function(){
            
            $('.wraper-form-arend').css('display', 'block');
            $('.form-arend').css('display', 'block');
            
        },
        unshowForm = function(){
            $('.wraper-form-arend').css('display', 'none');
            $('.form-arend').css('display', 'none');
            clearForm();
        },
        clearForm = function(){
            $('.form-arend-input-row input').val('');
            $('.form-arend-input-row textarea').val('');
            
        },
        orderForm = function(){
            var order = {};
            
            order.famaly = $('.form-arend-input-row input[name="famaly"]').val();
            order.name = $('.form-arend-input-row input[name="name"]').val();
            order.date = $('.form-arend-input-row input[name="date"]').val();
            order.phone = $('.form-arend-input-row input[name="phone"]').val();
            order.description = $('.form-arend-input-row textarea[name="description"]').val();
            
            $.ajax({
               
                url : 'ajax/orderArend',
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
                                    case 'description' : $('.form-arend-input-row textarea[name="description"]').addClass('error-class');
                                        break;
                                    case 'famaly' : $('.form-arend-input-row input[name="famaly"]').addClass('error-class');
                                        break;
                                    case 'name' : $('.form-arend-input-row input[name="name"]').addClass('error-class');
                                        break;
                                    case 'date' : $('.form-arend-input-row input[name="date"]').addClass('error-class');
                                        break;
                                    case 'phone' : $('.form-arend-input-row input[name="phone"]').addClass('error-class');
                                        break;
                                    default:
                                        break;
                                    
                                }
                            }
                        }
                    }
                    
                    if(e.success){
                        alert(e.success);
                        unshowForm();
                    }
                    
                },
                errors : function(e){
                    alert('Ошибка связи с сервером! Попробуйте обновить страницу');
                }
            });
        },
        changeForm = function(){
            $(this).removeClass('error-class');
        };        
        
        return {
            showForm : showForm,
            unshowForm: unshowForm,
            orderForm : orderForm,
            changeForm: changeForm
        }
        
    }
    
});