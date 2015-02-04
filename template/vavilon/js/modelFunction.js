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

    HERETIC.modules.functionApi = function(){
    
        var otherMenu = function(){
            
            HERETIC.modules.facechange($('.other-menu'));
            
        }
        
        
        return {
            otherMenu : otherMenu
        }
        
    }
    
    
    
});