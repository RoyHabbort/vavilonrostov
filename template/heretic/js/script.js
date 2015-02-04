/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    
    var initFieldAdd = function(){
        var index = $('select[name="field_type_id"]').val();
        if((index == 6) || (index == 9) ){
            $('.section-image-filter').css('display', 'block');
        }else{
            $('.section-image-filter').css('display', 'none');
        }
        
        if(index == 7){
            $('.section-selecter-filter').css('display', 'block');
        }else{
            $('.section-selecter-filter').css('display', 'none');
        }
        
    };
    initFieldAdd();
    
    $('select[name="field_type_id"]').on('change', function(e){
        initFieldAdd();
    });
    
    
    $('input[type="checkbox"]').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
    
    
    
    
    //секции на page
    
    if($('.page-list').length){
        $('.page-list-container').css('display', 'none');
        $('.page-list-btn').on('click', function(){
           HERETIC.modules.facechange($(this).parents('.page-list').find('.page-list-container')); 
        });
    }
    
    
    //маска телефонов
    $('.phone-edit').mask("+7 (999) 999-99-99");
    
    
});


