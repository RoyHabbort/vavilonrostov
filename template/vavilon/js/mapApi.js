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
    
    HERETIC.modules.mapApi = function(){
        
        var myMap = {}, 
        initiateMap = function(){
            
            ymaps.ready(function(){
                myMap = new ymaps.Map("YaMapConteiner", {
                    center: [47.28030536, 39.71809213],
                    zoom: 15,
                    type: 'yandex#publicMap'
                });
                
                var myPlacemark = new ymaps.Placemark([47.28030536, 39.71809213], {
                    balloonContentHeader: '<b>ТРЦ Вавилон</b>',
                });             
                myMap.geoObjects.add(myPlacemark);

            })
        };       
       
        
        return {
            initiateMap : initiateMap
        }
        
    }
    
})
