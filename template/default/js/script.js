/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    
    
    
    
    //Переключение на вкладку заказа столика
    $('.booking-apartament-icon').on('click', function(){
        $('.booking-apartament').css('display', 'none');
        $('.booking-apartament-section').css('display', 'none');
        $('.booking-table').css('display', 'block');
        $('.booking-restoraunt-section').css('display', 'block');
    });
    
    //Переключение на вкладку заказа номера
    $('.booking-table-icon').on('click', function(){
        $('.booking-apartament').css('display', 'block');
        $('.booking-apartament-section').css('display', 'block');
        $('.booking-table').css('display', 'none');
        $('.booking-restoraunt-section').css('display', 'none');
    });
    
    //Установка датапикеров
    $('.date-input').datepicker({
        dateFormat: "yy-mm-dd" 
    });
    
    //маска телефона
    $('.phone-input').mask("+7 (999) 999-99-99");
    
    
    //Маска времени
    $.mask.definitions['H']='[012]';
    $.mask.definitions['M']='[012345]';
    $.mask.definitions['G'] = '[0123456789]';
    
    $(".time-input").on('keyup', function(){
        var value = $(this).val(),
            el = $(this),
            range = document.createRange(),
            sel = window.getSelection(),
            position = $(this).getCaret(this);
        
        if((value[0] == 2)&&(value[1] > 3)){
            var newValue = value[0] + '3' + value[2] + value[3] + value[4]; 
            $(this).val(newValue);
            
            this.setSelectionRange(position, position);
            
        }
    });

    //Клик на иконке вызывает датапикер
    $('.calendar-icon').on('click', function(){
        $(this).parents('.input-row').find('.date-input').focus();
    });
    
    
    //фансибокс
    $('.fancybox').fancybox();
    
});

