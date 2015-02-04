/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
   
   $('.btn-add-text-slider').on('click', addTextSlider);
   $('.text-slide-del').on('click', delTextSlider);
   
});


function addTextSlider(){
    var error = 0;
    var title = $('#text-slider-create-title').val();
    var text = $('#text-slider-create-text').val();
    
    if (title == ''){
        console.log('title');
        error = 1;
        $('#text-slider-create-title').parents('.row-admin').find('.errors-text').text("Данное поле обязательно для заполнения");
    }
    if (text == ''){
        console.log('text');
        error = 1;
        $('#text-slider-create-text').parents('.row-admin').find('.errors-text').text("Данное поле обязательно для заполнения");
    }
    
    if (error) return false;
    
    $.ajax({
        url:"/ajax/addTextSlider",
        type: "POST",
        dataType: "JSON",
        data: {'title':title, 'text': text},
        success:function(e, data){
            if(e.errors){
                console.log('It so BaaaD'); 
                $('.ajax-errors').text('Ошибка добавления блока');
            }else{
                var append_html = '<div class="text-slide"><div class="text-slide-title">'+title+'</div><div class="text-slide-text">'+text+'</div><div id_text_slider="'+e.last_id+'" class="text-slide-del btn btn-red">Удалить</div></div>';
                $('.text-slider-append').append(append_html);
                $('.text-slide-del').on('click', delTextSlider);
                $('#text-slider-create-title').val('');
                $('#text-slider-create-text').val('');
                console.log('GoooD!');
            }
            
        },
        error: function(data){
            console.log('It so BaaaD'); 
            $('.ajax-errors').text('Ошибка добавления блока');
        }
    })
    
    
}



function delTextSlider(){
    var thisis = $(this);
    var id_text_slider = $(thisis).attr('id_text_slider');
    $(thisis).parents('.text-slide').find('.del-errors').text('');
    $('.del-success').text('');
    
    $.ajax({
        url:"/ajax/delTextSlider",
        type: "POST",
        dataType: "JSON",
        data: {'id_text_slider':id_text_slider},
        success:function(e, data){
            if(e.errors){
                console.log('It so BaaaD'); 
                $(thisis).parents('.text-slide').find('.del-errors').text('Ошибка удаления блока');
            }else{
                $('.del-success').text('Блок удалён');
                $(thisis).parents('.text-slide').animate({
                    opacity: 0,
                    height: 0,
                }, 500, function(){$(thisis).parents('.text-slide').remove()});
                console.log('GoooD!');
            }
            
        },
        error: function(data){
            console.log('It so BaaaD'); 
            $(thisis).parents('.text-slide').find('.del-errors').text('Ошибка удаления блока');
        }
    })
}
