/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).ready(function(){
    
    var sliderApi = {
        stockMainSlider : {api:{}},
        mainSlider: {api:{}},
        newsSlider:{api:{}}
    };
    
    if(typeof HERETIC  === "undifined"){
        HERETIC = {};
    }
    HERETIC.modules = HERETIC.modules || {};

    HERETIC.modules.sliderApi = function(){
        
        var 
        //слайдер акций на главной
        stockMainSliderInitiate = function(){
            var object = $('.stock-main-slider');
            $(object).bxSlider({
                pager: false,
                controls: true,
                minSlides: 5,
                maxSlides: 5,
                slideWidth: 198,
                slideMargin: 40,
                moveSlides: 1
            });
        },
        //главный слайдер
        mainSlider = function(){
            var object = $('.main-slider-list');
            $(object).bxSlider({
                pager: true,
                controls: false,
                moveSlides: 1,
                slideWidth: 800
            });
        },
        //слайдер новостей на главной
        newsSlider = function(){
            var object = $('.news-slider');
            $(object).bxSlider({
                pager: false,
                controls: false,
                moveSlides: 1,
                slideWidth: 200,
                slideMargin: 40,
                minSlides: 3,
                maxSlides: 3,
            });
        },
        //слайдер фотографий магазина
        shopSlider = function(){
            var object = $('.shop-slider-initiate');
            $(object).bxSlider({
                pager: false,
                moveSlides: 1,
                slideWidth: 460,
                minSlides: 1,
                prevText: "<div class='prev-arrow'></div>",
                nextText: "<div class='next-arrow'></div>"
            })
        }
        
        return {
            stockMainSliderInitiate : stockMainSliderInitiate,
            mainSlider : mainSlider,
            newsSlider : newsSlider,
            shopSlider : shopSlider
        }
        
    };
    
});