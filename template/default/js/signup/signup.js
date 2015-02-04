/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
   
    var signupApi = {};
    if(typeof HERETIC === "undifined"){
        HERETIC = {};
    }
    HERETIC.modules = HERETIC.modules || {};
    
    ({
        form:{},
        init:function(){
            signupApi = this;
            signupApi.form = signupApi.getObject();
            signupApi.setEvents();
        },
        getObject:function(){
            return{
                's_sign':$('.signup-widget .s-sign'),
                'po_sign':$('.signup-widget .po-sign'),
                'date':$('.signup-widget .date-input'),
                'phone':$('.signup-widget .phone-input')
            }
        },
        getValue:function(){
            return {
                's_sign':$(signupApi.form.s_sign).val(),
                'po_sign':$(signupApi.form.po_sign).val(),
                'date':$(signupApi.form.date).val(),
                'phone':$(signupApi.form.phone).val()
            }
        },
        addSignup:function(){
            var value = signupApi.getValue();
            
            $.ajax({
                url: "/ajax/addSignup",
                type: "POST",
                dataType: "JSON",
                data: {'data':value},
                success: function(resp){
                    if(resp.errors){
                        signupApi.errors(resp.errors);
                    }else{
                        
                        if(resp.success){
                            signupApi.successForm(resp.success);
                        }else{
                            signupApi.errors({'public_error' : 'Произошла непредвиденая ошибка. Попробуйте обновить страницу'});
                        }
                    }
                },
                errors: function(err){
                    signupApi.errors({'public_error' : 'Ошибка соединения с сервером'});
                }
                
            });  
            
            
        },
        successForm:function(success){
            $('.signup-widget .public-error').text('');
            $(signupApi.form.phone).css('border-color', '#9c9c9c');
            
            $(signupApi.form.s_sign).val('');
            $(signupApi.form.po_sign).val('');
            $(signupApi.form.date).val('');
            $(signupApi.form.phone).val('');
            
            alert(success);
        },
        setEvents:function(){
            $('.inner-singup-btn').on('click', signupApi.addSignup);
            $(".time-input").mask('HG:M9');
            
            $('.call-cell').on('click', function(){
                $(this).toggleClass('active');
                HERETIC.modules.facechange($('.signup-widget'));
            });

            $('.signup-close').on('click', function(){
                $(this).parents('.call-cell').toggleClass('active');
                HERETIC.modules.facechange($('.signup-widget'));
            });

            $('.signup-widget').on('click', function(e){
                e.stopPropagation();
            });
            
            
            
        },
        errors:function(err){
            
            if(err.public_error){
                $('.signup-widget .public-error').text(err.public_error);
            }
            if(err.phone){
                $(signupApi.form.phone).css('border-color', '#ee322b');
            }
            
        }
    }).init();
    
    HERETIC.modules.signupApi = signupApi;
    
    
});