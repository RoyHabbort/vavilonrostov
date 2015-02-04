/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    
    
    
    browserInfo = (function(){
        var ua = navigator.userAgent;
        if (ua.match(/MSIE/)) return 'IE';
        if (ua.match(/Firefox/)) return 'Firefox';
        if (ua.match(/Opera/)) return 'Opera';
        if (ua.match(/Chrome/)) return 'Chrome';
        if (ua.match(/Safari/)) return 'Safari';
    })();
    
    
    var locationPath = document.location.pathname;
    var locationArray = locationPath.split('&');
    
    if(locationArray[0] === '/shop'){
        shopController(locationArray);
    }
    
    if($('.shop-main-content-page').length){
        shopInnerController();
    }
    
    if($('.index-page').length){
        mainController();
    }
    
    
    if($('.full-map-wrap').length){
        fullMapController();
    }
    
    if($('.about-page').length){
        aboutController();
    }
    
    if($('.arend-options-widget').length){
        arendWidgetController();
    }
    
    if($('.stock-slider-initiate').length){
        stockSliderController();
    }
    
    if($('.news-slider-initiate').length){
        newsSliderController();
    }
    
    
    $('.i-check').iCheck({
        checkboxClass: 'icheckbox_square-blue',
        radioClass: 'iradio_square-blue',
        increaseArea: '20%' // optional
    });
    
    
    $('.fancybox').fancybox();
    
    $('.input-phone').mask('+7 (999) 999-99-99');
    
    $('.input-date').datepicker({
        dateFormat: "yy-mm-dd",
    });
    
    
    signupController();
    
    
});



/*
 * 12-01-2015
 * контроллер главной страницы
 * roy
 */

function mainController(){
    var sliderApi = new HERETIC.modules.sliderApi(),
        functionApi = new HERETIC.modules.functionApi();    
    
    sliderApi.stockMainSliderInitiate();
    sliderApi.mainSlider();
    sliderApi.newsSlider();
    
    $('.fancybox').fancybox();
    
    $('.span-a').on('click', functionApi.otherMenu);
    
}


/*
 * 12-01-2015
 * контроллер страницы списка магазинов
 * roy
 */

function shopController(filterArray){
    
    var filter = new HERETIC.modules.filter();
    
    var currentFilterItems = filter.giveCurrentItems(filterArray);
    
    console.log(currentFilterItems);
    
    /*
     * навешиваем события на фильтры
     */
    
    filter.categoryOnClick(function(){
        currentFilterItems.category = $(this).attr('data-tags');
        filter.applyFilter(currentFilterItems);
    });
    
    filter.letterOnClick(function(){
        currentFilterItems.letter = $(this).text();
        filter.applyFilter(currentFilterItems);
    });
    
    filter.paginationOnClick(function(){
        var pagination = $(this).find('.page-pagination-link').attr('data-page');
        filter.movePageWithFilter(currentFilterItems, pagination); 
    });
    
}


/*
 * 12-01-2015
 * контроллер внутренней страницы магазина
 * roy
 */

function shopInnerController(){
    var sliderApi = new HERETIC.modules.sliderApi();
    
    sliderApi.shopSlider();
    
    var shopMapApi = new HERETIC.modules.shopMapApi();
    $('.svg-object .mark-wrap').on('mouseover', shopMapApi.onHoverMark);
    $('body').on('mouseout', '.wrapper-text-floor', shopMapApi.offHoverMark);
    $('body').on('click', '.inner-wraper-map', shopMapApi.gotoPage);
    
    /*
     * навешиваем события на карту
     */
    
    var shop = $('.shop-activated-find').text().trim();
    var x = $('.shop-relative').width();
    var y = $('.shop-relative').height();
    
    
    $('.shop-to-map').on('click', function(){
        var redirect = 'http://' + document.location.host + '/shop/shopMap#' +  shop;
        document.location = redirect;
        
        return false;
    })
    
    if(shop){
    
        shopMapApi.centeredShop(shop, x, y);
    
        $('body').on('click', '.wrapper-text-floor', shopMapApi.gotoPage);
        $('body').on('click', '.wrapper-text-floor-activated', shopMapApi.gotoPage);
        
        
        $('.shop').on('mouseover', shopMapApi.hoverPath);
        $('.shop').on('mouseout', shopMapApi.offHoverPath);
        $('body').on('mouseover', '.text-info-for-magazine-svg', shopMapApi.hoverPathWrap);
        $('body').on('mouseout', '.text-info-for-magazine-svg', shopMapApi.offHoverPathWrap);
        
        if( (!browserInfo) || (browserInfo === 'IE') ){
            IEController();
        }
        
        
    }
    
    
}


/*
 * 14-01-2015
 * контроллер карты центра. Полный.
 * roy
 */

function fullMapController(){
    
    var shopMapApi = new HERETIC.modules.shopMapApi();
    
    $('.shop-map-menu-one').on('click', shopMapApi.chooseFloor);
    
    
    $('body').on('click', '.shop', shopMapApi.gotoPage);
    
    $('.shop').on('mouseover', shopMapApi.hoverPath);
    $('.shop').on('mouseout', shopMapApi.offHoverPath);
    $('body').on('mouseover', '.text-info-for-magazine-svg', shopMapApi.hoverPathWrap);
    $('body').on('mouseout', '.text-info-for-magazine-svg', shopMapApi.offHoverPathWrap);
    
    
    
    
    
    
    
    
    console.log(browserInfo);
    
    
    if( (!browserInfo) || (browserInfo === 'IE') ){
        IEController();
    }
    
    
    if(document.location.hash){
        var shop = document.location.hash;
        
        shop = shop.replace('#', "");
        
        var activeShop = shopMapApi.searchActiveShop(shop)
        
  
        var floor = shopMapApi.getFloorShop(activeShop);
        
        shopMapApi.chosedFloor(floor);
        shopMapApi.activatedShop(activeShop);
    }
    
}


/*
 * 21-01-2015
 * Контроллер страницы "О нас"
 * roy
 */

function aboutController(){
    var mapApi = new HERETIC.modules.mapApi;
    
    mapApi.initiateMap();
    
}


/*
 * 21-01-2015
 * контроллер аренды
 * roy
 */

function arendWidgetController(){
    
    var arendApi = new HERETIC.modules.arendApi();
    
    $('.arend-options-btn').on('click', arendApi.showForm);
    $('.wraper-form-arend').on('click', arendApi.unshowForm);
    $('.close-form').on('click', arendApi.unshowForm);
    $('.form-arend-input-row .clear-input').on('change', arendApi.changeForm);
    
    $('.form-arend-btn').on('click', arendApi.orderForm);
    
}


/*
 * 22-01-2015
 * Обратная связь
 * roy
 */

function signupController(){
    
    var signupApi = new HERETIC.modules.signupApi();
    
    $('.signup-call').on('click', signupApi.showSignup);
    $('.signup-wrapper').on('click', signupApi.unshowSignup);
    $('.close-form-signup').on('click', signupApi.unshowSignup);
    
    $('.signup-body .clear-input').on('change', signupApi.changeForm);
    $('.inner-singup-btn').on('click', signupApi.orderForm);
}



/*
 * 28-01-2015
 * Инициализация слайдера акций
 * roy
 */

function stockSliderController(){
    
    var object = $('.stock-slider-initiate');
    $(object).bxSlider({
        pager: false,
        slideWidth: 300,
        moveSlides: 1,
        minSlides: 1,
        prevText: "<div class='prev-arrow'></div>",
        nextText: "<div class='next-arrow'></div>"
    })
    
}


/*
 * 28-01-2015
 * Инициализация слайдера новости
 * roy
 */

function newsSliderController(){
    var object = $('.news-slider-initiate');
    $(object).bxSlider({
        pager: false,
        slideWidth: 600,
        moveSlides: 1,
        minSlides: 1,
        prevText: "<div class='prev-arrow'></div>",
        nextText: "<div class='next-arrow'></div>"
    })
}



/*
 * 2-02-2015
 * Правка для IE 10-11
 * roy
 */

function IEController(){
    var i = 0;
    $('.svg-object .shop').each(function(){
        
        
        var condition = $(this).find('.text-svg-title').length;
        
        
        if(condition){
            
            var title = $(this).find('.hidden-text .title').text();
            var coordX = $(this).find('.hidden-text text').attr('data-x');
            var coordY = $(this).find('.hidden-text text').attr('data-y');

            $(this).parents('.floor-inner')
                    .append('<div class="ie-map-title num-'+i+'" style="position:absolute; color:#FFF; font-size:18px; font-weight:bold;"><span>' + title + '</span></div>');


            var width = $('.num-'+i+'').width();
            var height = $('.num-'+i+'').height();

            coordX = coordX - width / 2;
            
            
            if($(this).attr('inkscape:label') == 'shop-15'){
                coordX = coordX - 60;
            }
            
            if($(this).attr('inkscape:label') == 'shop-7'){
                coordX = coordX - 15;
            }
            
            
            $('.num-'+i+'').css({
                top: coordY + 'px',
                left: coordX + 'px'
            });


            var text = $('.num-'+i+'').html();

            console.log(condition);
            i++;
            
        }
        
    });
    
}