/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
   /*
    * 5-09-2014
    * Подключаем CKeditor
    * Олег Байгулов
    */
    
    if ($('#CKeditor').length){
        
        CKEDITOR.replace('CKeditor');
        
    } 
});