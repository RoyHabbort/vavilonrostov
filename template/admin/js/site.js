$(document).ready(function(){"undifined"==typeof HERETIC&&(HERETIC={}),HERETIC.modules=HERETIC.modules||{},HERETIC.modules.shopMapApi=function(){var t="",e=function(){var t=$(this).attr("data-floor");a(t)},a=function(t){$(".floor-wrap").removeClass("active"),$(".shop-map-menu-one").removeClass("active"),$("."+t+"-floor").addClass("active"),$(".shop-map-menu-one").each(function(){$(this).attr("data-floor")==t&&$(this).addClass("active")})},i=function(){var t=$(this).attr("inkscape:label"),e=$(".id-for-map").text();$.ajax({url:"/admin/setShopOnMap",method:"POST",dataType:"JSON",data:{page_id:e,shop_path:t},success:function(t){t.errors?console.log(t.errors):t.success&&(console.log(t.success),location.reload())},error:function(t){console.log(t)}})},n=function(t){var e;return $(".svg-object").find(".shop").each(function(){var a=$(this).attr("inkscape:label");t==a&&(e=$(this))}),e},o=function(t){var e=$(t).parents(".floor-inner").attr("class"),a=e.replace(/\D/g,"");return console.log(a),a},s=function(t){$(t).attr("data-shop","activated"),$(t).attr("activated","true");var e=$(t),a=$(e).find(".hidden-text text").attr("data-y"),i=$(e).find(".hidden-text text").attr("data-x"),n=$(e).find(".hidden-text .title").text(),o=$(e).find(".hidden-text .category").text(),s=$(e).find(".hidden-text .time").text();$(e).parents(".floor-inner").append('<div class="activated-shop-magazine"><div class="text-info-svg"></div><div class="text-info-svg-triangle"></div></div>'),$(e).parents(".floor-inner").find(".activated-shop-magazine .text-info-svg").append('<div class="shop-info-svg-title">'+n+"</div>"),$(e).parents(".floor-inner").find(".activated-shop-magazine .text-info-svg").append('<div class="shop-info-svg-category">'+o+"</div>"),$(e).parents(".floor-inner").find(".activated-shop-magazine .text-info-svg").append('<div class="shop-info-svg-time">'+s+"</div>"),a-=$(e).parents(".floor-inner").find(".activated-shop-magazine").height(),i-=100,$(e).parents(".floor-inner").find(".activated-shop-magazine").css({display:"block",top:a+"px",left:i+"px"})},d=function(){var e=$(this).parents(".floor-inner").find(".text-info-for-magazine-svg"),a=$(this),i=$(a).find(".hidden-text text").attr("data-y"),n=$(a).find(".hidden-text text").attr("data-x"),o=$(a).find(".hidden-text .title").text(),s=$(a).find(".hidden-text .category").text(),d=$(a).find(".hidden-text .time").text();o.length||(o="Помещение не занято."),$(e).find(".shop-info-svg-title").text(o),$(e).find(".shop-info-svg-category").text(s),$(e).find(".shop-info-svg-time").text(d),i-=$(e).height(),n-=100,$(e).css({display:"block",top:i+"px",left:n+"px"}),t=a,$(a).attr("activated","true")},r=function(){var e=$(this),a=$(e).parents(".floor-inner").find(".text-info-for-magazine-svg");$(a).css("display","none"),$(t).attr("activated","false")},f=function(){$(this).css("display","block"),$(t).attr("activated","true")},c=function(){$(this).css("display","none"),$(t).attr("activated","false")};return{chosedFloor:a,chooseFloor:e,changeOnMap:i,searchActiveShop:n,getFloorShop:o,activatedShop:s,hoverPath:d,offHoverPath:r,hoverPathWrap:f,offHoverPathWrap:c}}});
function addTextSlider(){var e=0,t=$("#text-slider-create-title").val(),d=$("#text-slider-create-text").val();return""==t&&(console.log("title"),e=1,$("#text-slider-create-title").parents(".row-admin").find(".errors-text").text("Данное поле обязательно для заполнения")),""==d&&(console.log("text"),e=1,$("#text-slider-create-text").parents(".row-admin").find(".errors-text").text("Данное поле обязательно для заполнения")),e?!1:void $.ajax({url:"/ajax/addTextSlider",type:"POST",dataType:"JSON",data:{title:t,text:d},success:function(e){if(e.errors)console.log("It so BaaaD"),$(".ajax-errors").text("Ошибка добавления блока");else{var l='<div class="text-slide"><div class="text-slide-title">'+t+'</div><div class="text-slide-text">'+d+'</div><div id_text_slider="'+e.last_id+'" class="text-slide-del btn btn-red">Удалить</div></div>';$(".text-slider-append").append(l),$(".text-slide-del").on("click",delTextSlider),$("#text-slider-create-title").val(""),$("#text-slider-create-text").val(""),console.log("GoooD!")}},error:function(){console.log("It so BaaaD"),$(".ajax-errors").text("Ошибка добавления блока")}})}function delTextSlider(){var e=$(this),t=$(e).attr("id_text_slider");$(e).parents(".text-slide").find(".del-errors").text(""),$(".del-success").text(""),$.ajax({url:"/ajax/delTextSlider",type:"POST",dataType:"JSON",data:{id_text_slider:t},success:function(t){t.errors?(console.log("It so BaaaD"),$(e).parents(".text-slide").find(".del-errors").text("Ошибка удаления блока")):($(".del-success").text("Блок удалён"),$(e).parents(".text-slide").animate({opacity:0,height:0},500,function(){$(e).parents(".text-slide").remove()}),console.log("GoooD!"))},error:function(){console.log("It so BaaaD"),$(e).parents(".text-slide").find(".del-errors").text("Ошибка удаления блока")}})}$(document).ready(function(){$(".btn-add-text-slider").on("click",addTextSlider),$(".text-slide-del").on("click",delTextSlider)});
$(document).ready(function(){$("#CKeditor").length&&CKEDITOR.replace("CKeditor")});
$(document).ready(function(){$(".date-input").datepicker({dateFormat:"yy-mm-dd"})});
!function(){HERETIC={},HERETIC.modules=HERETIC.modules||{},HERETIC.modules.facechange=function(e){"none"==$(e).css("display")?$(e).animate({height:"show"},400):$(e).animate({height:"hide"},200)}}();
$(document).ready(function(){!function(){if($("#image-download-btn").length){var e=$(".image-download-btn").attr("date-name");$("#image-download-btn").uploadFile({url:"/ajax/jqueryUpload",fileName:e,showQueueDiv:"image-preview-wrapper",showPreview:!0,returnType:"json",multiple:!1,showDone:!1,showCancel:!1,showAbort:!1,showDelete:!0,deletelStr:"<img class='img-close' src='/template/heretic/img/icons/icon-close.png'>",dragDropStr:"",onSuccess:function(a,t,o,i){$(i.statusbar).addClass("success-photo "),$(i.statusbar).append('<input type="hidden" name="h_h_h_'+e+'[]" value="'+t.file_name+'" />')}})}}(),function(){$(".edit-image-one .img-close").on("click",function(){var e=$(this).attr("data-del"),a=$(this).attr("data-field"),t=$(this);$.ajax({url:"/ajax/deleteImage",method:"POST",dataType:"JSON",data:{id:e,field:a},success:function(e){e.errors||$(t).parent(".edit-image-one").remove()}})})}()});
function shopController(){$(".search-div-shop .form-control").on("keyup",function(){var o=$(this).val();$(".table-title").each(function(){$(this).text().indexOf(o)+1?$(this).parent("tr").css("display","table-row"):$(this).parent("tr").css("display","none")})})}function shopOnMapController(){var o=new HERETIC.modules.shopMapApi;$(".shop-on-map-btn").on("click",function(){HERETIC.modules.facechange(".block-shop-on-map");var e=o.searchActiveShop(t),n=o.getFloorShop(e);o.chosedFloor(n),o.activatedShop(e)}),$(".shop-map-menu-one").on("click",o.chooseFloor),$(".shop").on("click",o.changeOnMap);var t=$(".hash-for-map").text();console.log(t)}$(document).ready(function(){$("div[data-controller]").each(function(){var o=$(this).attr("data-controller"),t=new Function(o+"()");t.apply(null,[])}),$(".phone-edit").mask("+7 (999) 999-99-99"),$(".tablesorter").tablesorter({headers:{1:{sorter:!1},2:{sorter:!1}}})});