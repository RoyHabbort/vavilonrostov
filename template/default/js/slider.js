/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    
    var sliderApi = {
        mainSlider : {},
        appartSlider : {},
        appartThumbSlider : {}
    };
    
    if(typeof HERETIC  === "undifined"){
        HERETIC = {};
    }
    HERETIC.modules = HERETIC.modules || {};
    
    sliderApi.mainSlider.initiate = function(){
        
        sliderApi.mainSlider.API = $('.slider-appartament-initiate').bxSlider({
            pager: true,
            controls: false,
            moveSlides: 1
        });
        
    };
    
    sliderApi.mainSlider.reload = function(){
        sliderApi.mainSlider.API.destroySlider();
        
        setTimeout(function(){
            
            sliderApi.mainSlider.API = $('.slider-appartament-initiate').bxSlider({
                pager: true,
                controls: false,
                moveSlides: 1
            });
            
        }, 100)
        
    };
    
    
    sliderApi.appartSlider.initiate = function(){
        $('.appartaments-slider-main').bxSlider({
            controls: false,
            pagerCustom: '.appartaments-slider-thumb' 
        });
    };
    
    sliderApi.appartThumbSlider.initiate = function(){
        $('.appartaments-slider-thumb').bxSlider({
            pager: false,
            minSlides: 3,
            maxSlides: 4,
            slideWidth: 160,
            slideMargin: 0,
            moveSlides: 1,
            nextText: '&#9658;',
            prevText: '&#9668;',
        });
        
        $('.appartaments-slider-thumb .slide:not(.bx-clone):eq(0)').addClass('activeSlide');
    
    
        $('.appartaments-slider-thumb .slide').on('click', function(){
            $('.appartaments-slider-thumb .slide').removeClass('activeSlide');
            $(this).addClass('activeSlide');
        });
        
    };
    
    sliderApi.appartSlider.initiate();
    sliderApi.appartThumbSlider.initiate();
    HERETIC.modules.sliderApi = sliderApi;
    
});