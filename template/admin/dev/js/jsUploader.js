/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function(){
    
    (function(){
        
        if($('#image-download-btn').length){
           var nameFile = $('.image-download-btn').attr('date-name');
           
           $('#image-download-btn').uploadFile({
                url:"/ajax/jqueryUpload",
                fileName:nameFile,
                showQueueDiv: 'image-preview-wrapper',
                showPreview:true,
                returnType:"json",
                multiple: false,
                showDone: false,
                showCancel:false,
                showAbort: false,
                showDelete:true,
                deletelStr: "<img class='img-close' src='/template/heretic/img/icons/icon-close.png'>",
                dragDropStr: "",
                onSuccess: function (files, response, xhr, pd){
                    
                    $(pd.statusbar).addClass('success-photo ');
                    $(pd.statusbar).append('<input type="hidden" name="h_h_h_' + nameFile + '[]" value="' + response.file_name + '" />');
                    
                    
                    
                    /*
                    $('.block-add-photo').removeClass('hidden-photo');

                    var uniq = randomInt(1000000, 9999999);
                    $(pd.statusbar).addClass('success-photo ');
                    $(pd.statusbar).attr('uniq', uniq);
                    $('.upload-hide').append('<input name="collection-'+ii+'" type="text" class="hidden collect-'+uniq+'" value="' + response[0] + '" >');

                    ii++;*/
                },
            });
            
        }
        
    })();
    
    
    (function(){
        $('.edit-image-one .img-close').on('click', function(){
            var idDel =$(this).attr('data-del'),
                fieldDel = $(this).attr('data-field'),
                thisIs = $(this);
           
           $.ajax({
              url:'/ajax/deleteImage',
              method: 'POST',
              dataType: 'JSON',
              data: {'id' : idDel, 'field':fieldDel},
              success : function(e){
                  if(!e.errors){
                      $(thisIs).parent('.edit-image-one').remove();
                  }
              }
           });
        });
    })();
   
    
});

