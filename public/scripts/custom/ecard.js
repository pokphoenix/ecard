$(function() {
    if (screen.width < 640) {
        var mvp = document.getElementById('myViewport');
        mvp.setAttribute('content','width=640, initial-scale=1');
    }




    var wh = '-'+(($('.loading').height()/2))+'px' ;
    var ww  = '-'+(($('.loading').width()/2))+'px' ;
//            console.log($(window).height(),wh,ww) ;
    $('.loading').css({
        'position' : 'fixed',
        'top' : '50%',
        'margin-top' : wh,
        'left' : '50%',
        'margin-left' : ww

    });
    counter = 0;
    $('.loading').show();
    myInterval = setInterval(function (e) {
//                console.log('count',counter);
        ++counter;
        if (counter==1){
            $('#main-wrapper').hide();
            clearInterval(myInterval);
        }
    }, 1000);


    $('#show-gen-img').hide();

    $(".hover_img").click(function() {
        //var img = $(this).find(".header_pic img"); // use a variable to store your image element in case you have to change the container class
        console.log('click');
        //var img = $(this).attr("src"); // not necessary to store it, could be use as it in the if statement
        //console.log(img);
        //$("#show_hover_img").attr("src",img) ;
        //$('#hover_pic_popup').modal('toggle');
    });



    //$('col-centered')
    $('.modal-vcenter').on('show.bs.modal', function(e) {
        centerModals($(this));
    });
    $(window).on('resize', centerModals);

    $('.cropit-image-preview').css("background-image", "url('images/ecard_main/photo_blank.png')");
    $('#image-cropper').cropit({

        //initialZoom:'image',
        smallImage:'stretch',
        allowCrossOrigin:true
    });
    $('.select-image-btn').click(function() {
        $('.cropit-image-input').click();
    });
    $('.cropit-image-input').on("change", function()
    {
        if (this.files[0].size > 5242880 ){ alert("รูปขนาดใหญ่เกิน 5 Mb ค่ะ"); return ;}
        $('#image-cropper').cropit('initialZoom', 'image');
        $('#fbuid').val('');
        $('#m').val('desc');
    });
    var afloadpage = $('#name').val().length;
    $("#name_len").html(afloadpage+' ตัวอักษร');
    $('#name').keyup(function() {
        var keyed = $(this).val().length;
        $("#name_len").html(keyed+' ตัวอักษร');
    });
    var afloadpage = $('#text_rest').val().length;
    $("#text_rest_len").html(afloadpage+' ตัวอักษร');
    $('#text_rest').keyup(function() {
        var keyed = $(this).val().length;
        $("#text_rest_len").html(keyed+' ตัวอักษร');
    });


    $('#howtoplay').click(function(){
        window.location.href="#page-howto";
    });

    $("#ecardform").submit(function(e)
    {
        $('.loading').show();
        var mode_submit = $('#m').val() ;
        if (mode_submit!="desc"&&mode_submit!="fb"){
            $('#error_popup').modal('toggle');
            return false;
        }

        if(mode_submit=="desc"){
            $('#fbuid').val('');
            var exzoom =  $('#image-cropper').cropit('exportZoom',2); //--- เซ็ตให้รูปที่ส่งค่าไปขนาดเท่ารูปจริง (แก้ปัญหารูปที่ส่งไปเล็กแล้วไป resize ให้ใหญ่แล้วรูปแตก)
            var imageData = $('#image-cropper').cropit('export', {
                type: 'image/jpeg',
                quality: 1,
                originalSize: true
            });
            $('.hidden-image-data').val(imageData);
            ajaxData();
        }else if(mode_submit=="fb"){
            //--- ถ้าเป็นรูปจาก faceboook จะต้อง gen รูปใหม่
            //var imgFB = $('.cropit-image-loaded').css('background-image');
            //imgFB = imgFB.replace('url(','').replace(')','');
            var imgFB = $("#fb-img").val();
            getBase64ImageExport(imgFB,function () {
                ajaxData();
            }) ;
        }



        //html2canvas($("#image-cropper"), {
        //
        //    proxy: "html2canvasproxy.php",
        //    useCORS:true,
        //
        //    onrendered: function(canvas) {
        //        theCanvas = canvas;
        //        theCanvas.id = "canvas_image" ;
        //        document.body.appendChild(canvas);
        //        var canvas = document.getElementById('canvas_image');
        //        var dataURL = canvas.toDataURL("image/jpeg",100);
        //        console.log(dataURL);
        //        getBase64ImageExportJS(dataURL,function () {
        //                ajaxData();
        //        }) ;
        //
        //    }
        //});


        e.preventDefault(); //STOP default action
    });



});



function detectPopupBlocker() {
    var myTest = window.open("about:blank","","directories=no,height=100,width=100,menubar=no,resizable=no,scrollbars=no,status=no,titlebar=no,top=0,location=no");
    if (!myTest) {
        alert("A popup blocker was detected.");
    } else {
        myTest.close();
        alert("No popup blocker was detected.");
    }
}

function getBase64ImageExportJS(img,callback) {
    var image = new Image();
    image.crossOrigin = 'Anonymous';
    image.onload = function() {
        imgPosX = 0 ;
        imgPosY = 0 ;
        imgSizeX = $('#canvas_image').width() ;
        imgSizeY = $('#canvas_image').height() ;
        var exportZoom = 1.25 ;
        var previewSizeW = 500 ;
        var previewSizeH = 500 ;
        $('canvas').remove();
        var canvas = document.createElement("canvas");
        canvas.width = previewSizeW*exportZoom;
        canvas.height = previewSizeH*exportZoom;
        var ctx = canvas.getContext("2d");
        ctx.fillStyle = '#fff' ;
        ctx.fillRect(imgPosX, imgPosY, previewSizeW, previewSizeH);
        ctx.drawImage(this, imgPosX*exportZoom, imgPosY*exportZoom,  imgSizeX*exportZoom,  imgSizeY*exportZoom);
        var dataURL = canvas.toDataURL("image/jpeg",100);
        $('.hidden-image-data').val(dataURL);
        console.log('afgen',dataURL);
        callback.call(this, dataURL);
    };
    image.src = img ;
}

function fb_reload(){
    $('#call_ang').click();
    $('#fb_popup').modal('hide');
    $("#fb_popup").on("hidden.bs.modal",function(e){
        $('#first-page').slideUp('fast');
        $('#play-page').show();
    });
}



function hover_img(img){
    $("#show_hover_img").attr("src",img.src) ;
    $('#call_ang').click();
    $('#hover_pic_popup').modal('toggle');
}

function page_reload(){
    $('#call_ang').click();
    $('#success_popup').modal('toggle');
    $("#success_popup").on("hidden.bs.modal",function(e){
        $('#first-page').slideUp('fast');
        $('#play-page').show();
    });
}
function see_gallery(){
    $('#success_popup').modal('toggle');
    $("#success_popup").on("hidden.bs.modal",function(e){
        window.location.href="#page-gallery";
    });
}

function ajaxData(){
    console.log( $('#image_data').val());

    var postData = $("#ecardform").serializeArray();


    $.ajax({
        url : "ecard-ajax",
        async: false,
        type: "POST",
        data : postData,
        success:function(data)
        {
            if(data =="error"){ alert("การอัพโหลดรูป ผิดพลาด") ; return false; }
            var str = data;
            success_upload();
            $('#image-cropper').cropit('imageSrc','images/ecard_main/photo_blank.png');
            //$('.cropit-image-preview').css("background-image", "url('images/ecard_main/photo_blank.png')");

                            //$('#show-gen-img').show();
                            //$('#show-gen-img').attr("src", data);
            //console.log(data);
            $('.loading').show();
            $('#img_gen').val(data);
            $('#call_ang').click();
            $('#m,#text_rest,#name').val('');

            return false;
        },
        error: function(jqXHR, textStatus, errorThrown)
        {
            alert("error");
        }
    });
}

function centerModals($element) {
    var $modals;
    if ($element.length) {
        $modals = $element;
    } else {
        $modals = $('.modal-vcenter:visible');
    }
    $modals.each( function(i) {
        var $clone = $(this).clone().css('display', 'block').appendTo('body');
        var top = Math.round(($clone.height() - $clone.find('.modal-content').height()) / 2);
        top = top > 0 ? top : 0;
        $clone.remove();
        $(this).find('.modal-content').css("margin-top", top);
    });
}




function getBase64ImageExport(img,callback) {
    console.log('base 64');

        //imgPos = $('.cropit-image-loaded').css("background-position").split(" ");
        //imgPosX = parseInt(imgPos[0],10) ;
        //imgPosY = parseInt(imgPos[1],10) ;
        ////console.log(imgPosX ,imgPosY);
        //imgSize = $('.cropit-image-loaded').css("background-size").split(" ")
        //imgSizeX = parseInt(imgSize[0],10) ;
        //imgSizeY = parseInt(imgSize[1],10) ;
        ////console.log(imgSizeX,imgSizeY);
        //var exportZoom = 2 ;
        //var previewSizeW = 300 ;
        //var previewSizeH = 300 ;
        //$('canvas').remove();
        //var canvas = document.createElement("canvas");
        //canvas.width = previewSizeW*exportZoom;
        //canvas.height = previewSizeH*exportZoom;
        //var ctx = canvas.getContext("2d");
        //ctx.fillStyle = '#fff' ;
        //ctx.fillRect(imgPosX, imgPosY, previewSizeW, previewSizeH);
        //ctx.drawImage(img, imgPosX*exportZoom, imgPosY*exportZoom, exportZoom * imgSizeX, exportZoom * imgSizeY);
        //var dataURL = canvas.toDataURL("image/jpeg",100);
        //$('.hidden-image-data').val(dataURL);
        //console.log('afgen',dataURL);
        //callback.call(this, dataURL);

    var image = new Image() ;
    image.crossOrigin = 'Anonymous';
    image.onload = function() {
        imgPos = $('.cropit-image-loaded').css("background-position").split(" ");
        imgPosX = parseInt(imgPos[0],10) ;
        imgPosY = parseInt(imgPos[1],10) ;
        //console.log(imgPosX ,imgPosY);
        imgSize = $('.cropit-image-loaded').css("background-size").split(" ")
        imgSizeX = parseInt(imgSize[0],10) ;
        imgSizeY = parseInt(imgSize[1],10) ;
        //console.log(imgSizeX,imgSizeY);
        var exportZoom = 2 ;
        var previewSizeW = 300 ;
        var previewSizeH = 300 ;
        $('canvas').remove();

        var canvas = document.createElement("canvas");
        canvas.width = previewSizeW*exportZoom;
        canvas.height = previewSizeH*exportZoom;
        var ctx = canvas.getContext("2d");
        ctx.fillStyle = '#fff' ;
        ctx.fillRect(imgPosX, imgPosY, previewSizeW, previewSizeH);
        ctx.drawImage(this, imgPosX*exportZoom, imgPosY*exportZoom, exportZoom * imgSizeX, exportZoom * imgSizeY);
        var dataURL = canvas.toDataURL("image/jpeg",100);
        $('.hidden-image-data').val(dataURL);
        //console.log('afgen',dataURL);
        callback.call(this, dataURL);
    };
    image.src = img ;
    // make sure the load event fires for cached images too
    //if ( img.complete || img.complete === undefined ) {
    //    img.src = "data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///ywAAAAAAQABAAACAUwAOw==";
    //    img.src = src;
    //}

}

function getBase64ImageExportOld(img,callback) {
    var image = new Image();
    image.crossOrigin = 'Anonymous';
    image.onload = function() {
        imgPos = $('.cropit-image-loaded').css("background-position").split(" ");
        imgPosX = parseInt(imgPos[0],10) ;
        imgPosY = parseInt(imgPos[1],10) ;
        //console.log(imgPosX ,imgPosY);
        imgSize = $('.cropit-image-loaded').css("background-size").split(" ")
        imgSizeX = parseInt(imgSize[0],10) ;
        imgSizeY = parseInt(imgSize[1],10) ;
        //console.log(imgSizeX,imgSizeY);
        var exportZoom = 2 ;
        var previewSizeW = 300 ;
        var previewSizeH = 300 ;
        $('canvas').remove();
        var canvas = document.createElement("canvas");
        canvas.width = previewSizeW*exportZoom;
        canvas.height = previewSizeH*exportZoom;
        var ctx = canvas.getContext("2d");
        ctx.fillStyle = '#fff' ;
        ctx.fillRect(imgPosX, imgPosY, previewSizeW, previewSizeH);
        ctx.drawImage(this, imgPosX*exportZoom, imgPosY*exportZoom, exportZoom * imgSizeX, exportZoom * imgSizeY);
        var dataURL = canvas.toDataURL("image/jpeg",100);
        $('.hidden-image-data').val(dataURL);
        console.log('afgen',dataURL);
        callback.call(this, dataURL);
    };
    image.src = img ;
}
function getBase64Image(img,callback) {
    var image = new Image();
           console.log(img);


    image.crossOrigin = 'Anonymous';
    image.onload = function() {
        $('canvas').remove();
        var canvas = document.createElement("canvas");
        canvas.width = this.width;
        canvas.height = this.height;
        var ctx = canvas.getContext("2d");
        ctx.fillStyle = '#fff' ;
        ctx.fillRect(0, 0, canvas.width, canvas.height);
        ctx.drawImage(this, 0, 0);
        var dataURL = canvas.toDataURL("image/jpeg",100);
        $('#image-cropper').cropit('imageSrc',dataURL);
        callback.call(this, dataURL);
    };
    image.src = img ;
}
function chose_photo(link){
    //console.log(link);
    $("#fb-img").val(link);
    getBase64Image(link,function () {}) ;
    fn_close()
}
function photo_in_album_show(album_name){
    var name = ".gallery_fb_"+album_name ;
    $('.fb_list_gallery,.gallery_fb_timeline_pic,.gallery_fb_profile_pic').hide();
    $('.fb_list_photo_in_gallery,.btn-fb-gall-back').show();
    $(name).show();
}
function fb_popup_back(){
    $('.fb_list_photo_in_gallery,.btn-fb-gall-back').hide();
    $('.fb_list_gallery').show();
}
function success_upload(){
    $('#success_popup').modal({
        show: true,
        keyboard: false,
        backdrop: 'static'
    });
}
function fn_login(){
    $('#fb_popup').modal({
        show: true,
        keyboard: false,
        backdrop: 'static'
    });
}
function fn_close(){
    $('#fb_popup').modal('toggle');
}
function play_ecard(){

    $('#first-page').slideUp('fast');

    $('#play-page').show()     ;

    //$('#play-page').show().animate({ top: 305 }, {duration: 1000, easing: 'easeOutBounce'});
}
function change_frame(int_number){
    switch (int_number){
        case "1" :
            $('#frame_image').val('1');
            $('#frame_ecard').attr('src','images/ecard/201511_frame1.png');
            $('#frame_ecard_star').hide();
            break;
        case "2" :
            $('#frame_image').val('2');
            $('#frame_ecard').attr('src','images/ecard/201511_frame2.png');
            $('#frame_ecard_star').show();
            break;
    }
}
function album_list(response){
    $('#main-wrapper,.loading').show();
    var album_data = "" ;
    if(response.albums!==undefined){
        for(var i=0;i<response.albums.data.length;i++){
            if (response.albums.data[i].name=="Profile Pictures"){
                var photo_in_album_data = "" ;
                for (var y=0;y<response.albums.data[i].photos.data.length;y++){
                    photo_in_album_data +=  "<div class=\"center-cropped\" onclick=\" chose_photo('"+response.albums.data[i].photos.data[y].source+"') \" style=\" background-image: url('"+response.albums.data[i].photos.data[y].picture+"'); \" ></div>" ;
                    $('.gallery_fb_profile_pic').html(photo_in_album_data);
                    if(response.albums.data[i].photos.data[y].id==response.albums.data[i].cover_photo.id){
                        album_data += "<div class=\"col-xs-3\" ><div class=\"thumbnail thumbnail-noborder pd mg center-block\"><div class=\"center-cropped\" onclick=\"photo_in_album_show('profile_pic')\" style=\" background-image: url('"+response.albums.data[i].photos.data[y].picture+"'); \" ></div><div class=\"caption\"><p>"+response.albums.data[i].name+"</p></div></div></div>" ;
                        $('.gallery_fb').html(album_data);
                    }
                }
            }
            if (response.albums.data[i].name=="Timeline Photos"){
                var photo_in_album_data = "" ;
                for (var y=0;y<response.albums.data[i].photos.data.length;y++){
                    photo_in_album_data += "<div class=\"center-cropped\" onclick=\" chose_photo('"+response.albums.data[i].photos.data[y].source+"') \" style=\" background-image: url('"+response.albums.data[i].photos.data[y].picture+"'); \" ></div>" ;
                    $('.gallery_fb_timeline_pic').html(photo_in_album_data);
                    if(response.albums.data[i].photos.data[y].id==response.albums.data[i].cover_photo.id){
                        album_data += "<div class=\"col-xs-3\" ><div class=\"thumbnail thumbnail-noborder pd mg center-block \"><div class=\"center-cropped\" onclick=\"photo_in_album_show('timeline_pic')\" style=\" background-image: url('"+response.albums.data[i].photos.data[y].picture+"'); \" ></div><div class=\"caption\"><p>"+response.albums.data[i].name+"</p></div></div></div>" ;
                        $('.gallery_fb').html(album_data);
                    }
                }
            }
        }
    }else{
        $('.gallery_fb').html('ไม่พบรูปภาพของคุณ');
    }
    $('#main-wrapper,.loading').hide();
}
