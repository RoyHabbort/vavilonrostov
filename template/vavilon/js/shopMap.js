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

    HERETIC.modules.shopMapApi = function(){
        
        var 
        globalAvtivatedShop = '',
        _constructor = function(){
            
        },
        _sizeRect = function sizeRect(text){
                    
            if(!text.length){
                return {width:0, height:0}
            }        
                    
            return {
                width : text.length * 12 + 10,
                height : 40
            }

        },
        getFloorShop = function(shop){
            var floorWrap = $(shop).parents('.floor-inner').attr('class');

            var floor = floorWrap.replace(/\D/g, '');

            return floor;
            
        },
        chosedFloor = function(floor){
            $('.floor-wrap').removeClass('active');
            $('.shop-map-menu-one').removeClass('active');
            
            $('.' + floor + '-floor').addClass('active');
            $('.shop-map-menu-one').each(function(){
                if($(this).attr('data-floor') == floor){
                    $(this).addClass('active');
                }
            })
            
        },        
        searchActiveShop = function(shop){
            var activeShop;
            $('.svg-object').find('.shop').each(function(){
                var currentShop = $(this).attr('inkscape:label');
                if(shop == currentShop){
                     activeShop = $(this);
                }
            });
            
            return activeShop;
        },
        
        chooseFloor = function(){
            var floor = $(this).attr('data-floor');
            chosedFloor(floor);
        },
        
        onHoverMark = function(){
            
            $(this).attr('class', 'mark-wrap, active');
            
            var object = $(this).parents('.shop');
            var layer = $(object).attr('inkscape:label')
            var layerX, layerY;
            var link = $(object).attr('link');
            
            layerX = $(object).find('image').attr('x');
            layerY = $(object).find('image').attr('y');
            var attr = "x = " + layerX + ' y = ' + layerY;

            var shopName = $(object).find('text').find('tspan').text();

            var rectSize = _sizeRect(shopName);
            
            var wrapper = $(object).parents('.floor-inner');
            
            $(wrapper).find('.wrapper-text-floor').remove();
            
            if(shopName){
               $(wrapper).append('<div class="wrapper-text-floor"><div class="inner-wraper-map"> <span>' + shopName + '</span> </div></div>'); 
            }
            
            
            var div = $(wrapper).find('.wrapper-text-floor');
            
            $(div).find('.inner-wraper-map').attr('link', link);
            
            $(div).css('top', layerY-27 + 'px');
            $(div).css('left', layerX-2 + 'px');

        },
                
        offHoverMark = function(){
            $('.shop').find('g').attr('class', 'mark-wrap');
            $(this).remove();
        },
                
        gotoPage = function(){
            var link = $(this).attr('link');
            
            if(link){
                var redirect = 'http://' + document.location.host + '/' + link;
            
                document.location = redirect;
            }
            
            
        },
                
        centeredShop = function(shop, x, y){
            var activeShop = '';
          
            var activeShop = searchActiveShop(shop);
            
            console.log(activeShop);
            
            
            var centredX = $(activeShop).find('.hidden-text text').attr('data-x');
            var centredY = $(activeShop).find('.hidden-text text').attr('data-y');
            
            var resultX = - (centredX - x/2);
            var resultY = - (centredY - y/2);
            
            $('.floor-inner').css({
                position : 'absolute',
                top : resultY,
                left: resultX
            });
            
            activatedShop(activeShop);
      
        },
        
        activatedShop = function(activatedShop){
            $(activatedShop).attr('data-shop', 'activated');
            $(activatedShop).attr('activated', 'true');;
            
            var shop = $(activatedShop);
            
            var topY = $(shop).find('.hidden-text text').attr('data-y');
            var topX = $(shop).find('.hidden-text text').attr('data-x');
            
            var title = $(shop).find('.hidden-text .title').text();
            var category = $(shop).find('.hidden-text .category').text();
            var time = $(shop).find('.hidden-text .time').text();
            
            
            $(shop).parents('.floor-inner').append('<div class="activated-shop-magazine"><div class="text-info-svg"></div><div class="text-info-svg-triangle"></div></div>')
            $(shop).parents('.floor-inner').find('.activated-shop-magazine .text-info-svg').append('<div class="shop-info-svg-title">'+title+'</div>');
            $(shop).parents('.floor-inner').find('.activated-shop-magazine .text-info-svg').append('<div class="shop-info-svg-category">'+category+'</div>');
            $(shop).parents('.floor-inner').find('.activated-shop-magazine .text-info-svg').append('<div class="shop-info-svg-time">'+time+'</div>');
            
            
            topY = topY - $(shop).parents('.floor-inner').find('.activated-shop-magazine').height();
            topX = topX - 100;
            
            $(shop).parents('.floor-inner').find('.activated-shop-magazine').css({
                display: 'block',
                top: topY + 'px',
                left: topX + 'px'
            });
            
            
        },
        hoverPath = function(){
            
            var wrapWindow = $(this).parents('.floor-inner').find('.text-info-for-magazine-svg');
            
            
            
            var shop = $(this);
            
            var topY = $(shop).find('.hidden-text text').attr('data-y');
            var topX = $(shop).find('.hidden-text text').attr('data-x');
            
            var link = $(shop).attr('link');
            var title = $(shop).find('.hidden-text .title').text();
            var category = $(shop).find('.hidden-text .category').text();
            var time = $(shop).find('.hidden-text .time').text();
            
            if(!title.length){
                title = "Помещение не занято.";
            }
            
            $(wrapWindow).find('.shop-info-svg-title').attr('href', '/' + link);
            $(wrapWindow).find('.shop-info-svg-title').text(title);
            $(wrapWindow).find('.shop-info-svg-category').text(category);
            $(wrapWindow).find('.shop-info-svg-time').text(time);
            
            topY = topY - $(wrapWindow).height();
            topX = topX - 100;
            
            $(wrapWindow).css({
                display: 'block',
                top: topY + 'px',
                left: topX + 'px'
            });
            
            
            globalAvtivatedShop = shop;
            $(shop).attr('activated', 'true');
           
        },
        offHoverPath = function(){
            var thisis = $(this);
            
            var wrapWindow = $(thisis).parents('.floor-inner').find('.text-info-for-magazine-svg');
            $(wrapWindow).css('display', 'none');
            $(globalAvtivatedShop).attr('activated', 'false');
            
        },
        hoverPathWrap = function(){
            $(this).css('display', 'block');
            $(globalAvtivatedShop).attr('activated', 'true');
        },
        offHoverPathWrap = function(){
            $(this).css('display', 'none');
            $(globalAvtivatedShop).attr('activated', 'false');
        }        
         
        
        _constructor();      
        
        return {
            chooseFloor : chooseFloor,
            onHoverMark : onHoverMark,
            offHoverMark : offHoverMark,
            gotoPage : gotoPage,
            centeredShop : centeredShop, 
            activatedShop : activatedShop,
            searchActiveShop: searchActiveShop,
            chosedFloor : chosedFloor,
            getFloorShop: getFloorShop,
            hoverPath : hoverPath,
            offHoverPath : offHoverPath,
            hoverPathWrap : hoverPathWrap,
            offHoverPathWrap : offHoverPathWrap
        }
        
    }
    
});