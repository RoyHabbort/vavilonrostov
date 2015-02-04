/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */




$(document).ready(function(){
    var reviewApi = {};
    if(typeof HERETIC  === "undifined"){
        HERETIC = {};
    }
    HERETIC.modules = HERETIC.modules || {};
    
    ({
        form:{},
        init:function(){
            reviewApi = this;
            reviewApi.setEvents();
            
            
        },
        addReview:function(){
            var that = this,
                form = $(that).parents('.review-form-list'),
                review = {
                    'name' : $(form).find('input[name="name"]').val(),
                    'email' : $(form).find('input[name="email"]').val(),
                    'text' : $(form).find('textarea[name="text"]').val()
                }
                
                
            $.ajax({
                url: "/review/addReview",
                type: "POST",
                dataType: "JSON",
                data: {'name':review.name, 'email':review.email, 'text' :review.text},
                success: function(resp){
                    if(resp.errors){
                        reviewApi.errors(form, resp.errors);
                    }else{
                        
                        if(resp.success){
                            reviewApi.successForm(form, resp.success);
                        }else{
                            reviewApi.errors(form, {'public_error' : 'Произошла непредвиденая ошибка. Попробуйте обновить страницу'});
                        }
                    }
                },
                errors: function(err){
                    reviewApi.errors(form, {'public_error' : 'Ошибка соединения с сервером'});
                }
                
            });  
                
        },
        setEvents: function(){
            $('.review-btn').on('click', reviewApi.addReview);
        },
        successForm:function(form, message){
           reviewApi.clearForm(form);
           alert(message);
        },
        clearForm:function(form){
             var errors = {
                fields:{
                    errorName : $(form).find('input[name="name"]').parents('.row-input').find('.errors-text'),
                    errorEmail : $(form).find('input[name="email"]').parents('.row-input').find('.errors-text'),
                    errorText : $(form).find('textarea[name="text"]').parents('.row-input').find('.errors-text')
                },
            };
              
            
            $(form).find('input[name="name"]').val('');
            $(form).find('input[name="email"]').val('');
            $(form).find('textarea[name="text"]').val('');
            
            $(errors.fields.errorName).text('');
            $(errors.fields.errorEmail).text('');
            $(errors.fields.errorText).text('');
            
        },
        errors:function(form, err){
            var errors = {
                fields:{
                    errorName : $(form).find('input[name="name"]').parents('.row-input').find('.errors-text'),
                    errorEmail : $(form).find('input[name="email"]').parents('.row-input').find('.errors-text'),
                    errorText : $(form).find('textarea[name="text"]').parents('.row-input').find('.errors-text')
                },
                result:{
                    name: err.name,
                    email: err.email,
                    text: err.text
                }
            }
            
            if(err.public_error){
                errors.result.name = errors.result.name + ' ' +err.public_error;  
            }
            
            $(errors.fields.errorName).text(errors.result.name);
            $(errors.fields.errorEmail).text(errors.result.email);
            $(errors.fields.errorText).text(errors.result.text);
            
        }
    }.init());
    
    
    HERETIC.modules.reviewApi = reviewApi;
    
});
