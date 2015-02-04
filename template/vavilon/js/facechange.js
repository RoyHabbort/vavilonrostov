/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


(function(){
    
    if(typeof HERETIC){
        HERETIC = {};
    }
    HERETIC.modules = HERETIC.modules || {};
    
    HERETIC.modules.facechange = function(objName) {
        if ( $(objName).css('display') == 'none' ) {
            $(objName).animate({height: 'show'}, 400);
        } else {
            $(objName).animate({height: 'hide'}, 200);
        }
    }
    
})();

