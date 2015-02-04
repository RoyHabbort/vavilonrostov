/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){


    $('div[data-controller]').each(function(){
        
        var controllerName = $(this).attr('data-controller');
        var controller = new Function(controllerName + '()');
        controller.apply(null, []);
    });
    
    
    
    
    //маска телефонов
    $('.phone-edit').mask("+7 (999) 999-99-99");
    $('.tablesorter').tablesorter({
        headers: { 
            1: { sorter: false }, 
            2: { sorter: false } 
        } 
    }); 
    
});


/*
 * 19-01-2015
 * контроллер магазинов
 * roy
 */
function shopController(){
    $('.search-div-shop .form-control').on('keyup', function(){
        var search = $(this).val();
        
        $('.table-title').each(function(){
            if($(this).text().indexOf(search) + 1){
                $(this).parent('tr').css('display', 'table-row');
            }else{
                $(this).parent('tr').css('display', 'none');
            }
        })
        
    });
    
}


/*
 * 20-01-2015
 * контроллер отметки на карте
 * roy
 */

function shopOnMapController(){
    
    var shopMapApi = new HERETIC.modules.shopMapApi();
    
    $('.shop-on-map-btn').on('click', function(){
        HERETIC.modules.facechange('.block-shop-on-map');
        
        var activeShop = shopMapApi.searchActiveShop(shop);    
  
        var floor = shopMapApi.getFloorShop(activeShop);
        shopMapApi.chosedFloor(floor);
        shopMapApi.activatedShop(activeShop);
        
    });
    
    $('.shop-map-menu-one').on('click', shopMapApi.chooseFloor);
    
    $('.shop').on('click', shopMapApi.changeOnMap)
    
    var shop = $('.hash-for-map').text();
    
    console.log(shop);
    
    
    
    
    
}