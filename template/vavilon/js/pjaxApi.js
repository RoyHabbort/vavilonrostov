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
    
            
    HERETIC.modules.pjax = (function(){
        
        $('a[data-pjax]').on('click', function(event){
            var target = $(this).attr('href');
            event.stopPropagation();
            $.pjax({
               'url' : target,
               'container' : '#pjax-conteiner'
            });
            return false;

        });
        
        $(document).on('pjax:end', function() {
            HERETIC.modules.pjax.loadPage();
        }); 
        
        
        return {
            loadPage : function(){
                HERETIC.modules.sliderApi.stockMainSlider.api.initiate();
                HERETIC.modules.sliderApi.mainSlider.api.initiate();
                HERETIC.modules.sliderApi.newsSlider.api.initiate();
            }
        }
        
    })();        
            
            
    
});