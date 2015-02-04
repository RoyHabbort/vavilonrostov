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
    
    
    HERETIC.modules.filter = function(){
        
        var categoryOnClick = function($callback){
                $('.category-tags-one').on('click', $callback);
            },
            letterOnClick = function($callback){
                $('.alfavit-one').on('click', $callback);
            },
            paginationOnClick = function($callback){
                $('.page-pagination-link').parents('li').on('click', $callback)
            },
            giveCurrentItems = function(filterArray){
                var filterItems = {},
                    resultItems = {};
                filterArray.splice(0, 1);
                
                filterArray.forEach(function(item) {
                    item = item.split('=');
                    filterItems[item[0]] = item[1];
                });
                
                resultItems.category = (filterItems.category) ? filterItems.category : '';
                resultItems.letter = (filterItems.letter) ? filterItems.letter : '';
                
                return resultItems;
                
            },
            applyFilter = function(currentFilter){
                
                var resulthref = '/shop';
                
                for(var key in currentFilter){
                    resulthref = resulthref + '&' + key + '=' + currentFilter[key];
                }
                
                document.location = resulthref;
            },
            movePageWithFilter = function(currentFilter, pagination){
                var resulthref = '/shop';
                
                for(var key in currentFilter){
                    resulthref = resulthref + '&' + key + '=' + currentFilter[key];
                }
                
                document.location = resulthref + '&page=' + pagination;
            }        
            
        
        return {
            categoryOnClick : categoryOnClick,
            letterOnClick : letterOnClick,
            paginationOnClick : paginationOnClick,
            giveCurrentItems : giveCurrentItems,
            applyFilter : applyFilter,
            movePageWithFilter : movePageWithFilter
        }
        
    }
    
    
    
});