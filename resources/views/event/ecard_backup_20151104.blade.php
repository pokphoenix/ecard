
<!DOCTYPE html>
<html lang="en" ng-app>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" href="{{url('scripts/bootstrap-3.3.2/css/bootstrap.min.css')}}">

    <link rel="stylesheet" href="{{url('memoprint/fonts/arabica/style.css')}}">
    <link rel="stylesheet" href="{{url('memoprint/fonts/sukhumvit/style.css')}}">
    <link rel="stylesheet" href="{{url('memoprint/fonts/quark2/style.css')}}">
    <link rel="stylesheet" href="{{url('memoprint/fonts/thaisans_neue/style.css')}}">
    <link rel="stylesheet" href="{{url('memoprint/css/ecard.css')}}">

    <script src="{{url('scripts/jquery-1.11.1.min.js')}} "></script>
</head>

<body>
<div id="main">


    <script>
        $(function() {
            $('#show-gen-img').hide();
            $('.cropit-image-preview').css("background-image", "url('images/broken_thumb.png')");
            $('#image-cropper').cropit({
                initialZoom:'image',
                smallImage:'stretch',
//                allowCrossOrigin:true
//
//                imageBackground: true,
//                imageBackgroundBorderWidth: 15, // Width of background border
//                imageState: {  //--- เหมือนจะเรียกใช้ได้แค่ลิ้งที่ public
//                    src: 'http://localhost/ecard/public/images/broken_thumb.png',
//                }
            });

            $('.select-image-btn').click(function() {
                $('.cropit-image-input').click();
            });
            $('.cropit-image-input').on("change", function()
            {
                $('#image-cropper').cropit('initialZoom', 'image');
                $('.cropit-image-zoom-input').show();
                $('#fbuid').val('');
                $('#m').val('desc');
                $('#clear_img').show();
            });
            $('.btn_clear_img').click(function() {
                $('.cropit-image-preview').css("background-image", "url('images/broken_thumb.png')");
                $('#clear_img').hide();
                $('#image-cropper').cropit('imageSrc');
                $('#fbuid').val('');
                $('#m').val('');
            });
            var afloadpage = $('#text_bless').val().length;
            $("#text_bless_len").html(afloadpage+' ตัวอักษร');
            $('#text_bless').keyup(function() {
                var keyed = $(this).val().length;
                $("#text_bless_len").html(keyed+' ตัวอักษร');
            });
        });
        function checkLoginState() {
            FB.getLoginStatus(function(response) {
                if (response.status === 'connected') {
                    var uid = response.authResponse.userID;
                    var accessToken = response.authResponse.accessToken;
                    $('#m').val('fb');
                    $('#fbuid').val(uid);
                    get_facebook_data();
                } else if (response.status === 'not_authorized') {
                    fblogin()
                } else {
                    fblogin()
                }
            });
        }
        function fblogin(){
            FB.login(function(response) {
                checkLoginState()
            }, {
                scope: 'publish_actions,user_photos',
                return_scopes: true
            });
        }
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '546857855463355',
                cookie     : true,
                xfbml      : true,  // parse social plugins on this page
                version    : 'v2.2'
            });
        };

        // Load the SDK asynchronously
        (function(d, s, id){
            var js, fjs = d.getElementsByTagName(s)[0];
            if (d.getElementById(id)) {return;}
            js = d.createElement(s); js.id = id;
            js.src = "//connect.facebook.net/en_US/sdk.js";
            fjs.parentNode.insertBefore(js, fjs);
        }(document, 'script', 'facebook-jssdk'));


        $(document).ready(function() {

            $("#ecardform").submit(function(e)
            {
                var mode_submit = $('#m').val() ;
                if (mode_submit!="desc"&&mode_submit!="fb"){
                    alert('กรุณาเลือกรูปค่ะ'); return false;
                }
                if(mode_submit=="desc"){
                    $('#fbuid').val('');
                    var exzoom =  $('#image-cropper').cropit('exportZoom',2); //--- เซ็ตให้รูปที่ส่งค่าไปขนาดเท่ารูปจริง (แก้ปัญหารูปที่ส่งไปเล็กแล้วไป resize ให้ใหญ่แล้วรูปแตก)
                    var imageData = $('#image-cropper').cropit('export', {
                        type: 'image/jpeg',
                        quality: 1,
                        originalSize: true
                    });
                    //console.log(imageData);
                    $('.hidden-image-data').val(imageData);
                    ajaxData();
                }else if(mode_submit=="fb"){
                    //--- ถ้าเป็นรูปจาก faceboook จะต้อง gen รูปใหม่
                    var imgFB = $('.cropit-image-loaded').css('background-image');
                    imgFB = imgFB.replace('url(','').replace(')','');
                    getBase64ImageExport(imgFB,function () {
                        //console.log($('.hidden-image-data').val());
                        ajaxData();
                    }) ;
                }
                e.preventDefault(); //STOP default action
            });
        });

        function ajaxData(){
            var postData = $("#ecardform").serializeArray();
            $.ajax({
                        url : "ecard-ajax",
                        async:    false,
                        type: "POST",
                        data : postData,
                        success:function(data, textStatus, jqXHR)
                        {
                            var str = data;
                            //console.log(data) ;
                            $('#show-gen-img').show();
                            $('#show-gen-img').attr("src", data);
                            // share_fb();
                            return false;

                        },
                        error: function(jqXHR, textStatus, errorThrown)
                        {
                            alert("error");
                        }
            });
        }

        function get_facebook_data(){
            FB.api(
                    '/me',
                    'GET',
                    {"fields":"albums{name,cover_photo, photos{picture,source}}"},
                    function(response) {
                       // console.log(response);
                        var album_data = "" ;
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
                                        album_data += "<div class=\"col-xs-3\" ><div class=\"thumbnail thumbnail-noborder pd mg center-block\"><div class=\"center-cropped\" onclick=\"photo_in_album_show('timeline_pic')\" style=\" background-image: url('"+response.albums.data[i].photos.data[y].picture+"'); \" ></div><div class=\"caption\"><p>"+response.albums.data[i].name+"</p></div></div></div>" ;
                                        $('.gallery_fb').html(album_data);
                                    }
                                }
                            }
                        }
                        fn_login();
                    }
            );
        }

        function getBase64ImageExport(img,callback) {
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
                //console.log(dataURL);
                callback.call(this, dataURL);
            };
            image.src = img ;
        }


        function getBase64Image(img,callback) {
            var image = new Image();
            image.crossOrigin = 'Anonymous';
            image.onload = function() {
                $('canvas').remove();
                var canvas = document.createElement("canvas");
                canvas.width = this.width;
                canvas.height = this.height;
//                console.log( canvas.width+" x "+canvas.height );
                var ctx = canvas.getContext("2d");
                ctx.fillStyle = '#fff' ;
                ctx.fillRect(0, 0, canvas.width, canvas.height);
                ctx.drawImage(this, 0, 0);
                var dataURL = canvas.toDataURL("image/jpeg",100);
                $('#image-cropper').cropit('imageSrc',dataURL);
//                console.log(dataURL);
                callback.call(this, dataURL);
                // alert(dataURL.replace(/^data:image\/(png|jpg);base64,/, ""));
            };
            image.src = img ;
        }

        function chose_photo(link){
            console.log(link);
            getBase64Image(link,function () {}) ;
            $('#clear_img').show();
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
        function share_fb(){

            FB.ui({
                method: 'feed',
                name: 'test',
                description: 'test',
                // link: 'www.google.com',
                picture: 'http://i.kapook.com/faiiya//24-1-54/asi19.jpg'
            }, function (response) {
                console.log(response);
                if (response && response != null) {
                }
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
    </script>

    <!-- Modal -->
    <div class="modal fade" id="fb_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="fb_list_gallery" >
                        <div class=" row gallery_fb" style="border:1px solid #F00;"></div>
                    </div>
                    <div class="fb_list_photo_in_gallery" style="display:none;">
                        <div class="gallery_fb_profile_pic" style="border:1px solid #0F0;display:none;"></div>
                        <div class="gallery_fb_timeline_pic" style="border:1px solid #0F0;display:none;"></div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger btn-fb-gall-back" onclick="fb_popup_back()" style="float: left; margin-right:10px;" >back</button>
                    <button type="button" class="btn btn-danger" class="close" data-dismiss="modal" aria-label="Close" >cancel</button>
                </div>
            </div>
        </div>
    </div>

    <div id="page-content" >
        <!--  Container -->
        <div class="container col-sm-12 col-centered main-page-content">
            <div >
                <div class="row">
                    <!--   ### Main content ###  -->
                    <div id="col-cen" class="col-sm-12 oh" >
                        <div class="row">
                            <div class="col-sm-12" style="margin-top:-20px;">
                                <p>&nbsp</p>

                                <form id="ecardform" class="form-horizontal" method="post" role="form" action=""   enctype="multipart/form-data">
                                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="fbuid" id="fbuid" value="" />
                                    <input type="hidden" name="m" id="m" value="desc" />
                                    <input type="hidden" name="image_data" id="image_data" class="hidden-image-data" />
                                    <div >

                                    </div>



                                    <div class="row">
                                        <div class="col-sm-12 col-centered " id="upload_img_review">
                                            <div class="thumbnail thumbnail-noborder">
                                                <div class="caption" style="margin-top:0px;padding:10px 10px 0px 10px;">
                                                    <div class="row">
                                                        <div class="col-sm-12 col-centered ">
                                                            <div class="col-xs-12 col-sm-8">
                                                                <img src="images/main/main-img.png" class="img-responsive" >
                                                            </div>
                                                            <div class="col-xs-12 col-sm-4 main-text " >
                                                                <span style="font-size:40px; font-weight: bold;">KEEP YOUR </span><br>
                                                                <span style="color:#3fb3a7;font-size:50px;font-weight: bold;">MEMORY</span><br>
                                                                <span style="font-size:40px;font-weight: bold;">IN TIME</span><br>
                                                                <span>"แชร์ทุกความประทับใจของคุณ"</span>
                                                                <BR>
                                                                <button class="btn-ecard" > <i class="glyphicon glyphicon-camera" ></i> เล่นเลย!!</button>
                                                                <BR><BR>
                                                                <button class="btn-ecard" > วิธีการร่วมสนุก</button>

                                                            </div>


                                                        </div>

                                                    </div>


                                                    <div class="upload_img_row">
                                                        <div class="row">
                                                            <div class="col-sm-12 col-centered">
                                                                <div class="col-sm-7">


                                                                    <div id="clear_img" style="display:none !important ;">
                                                                        <button type="button" class="btn_clear_img" >x</button>
                                                                    </div>
                                                                    <div id="image-cropper">
                                                                        <div class="cropit-image-preview"></div>
                                                                        <input type="range" class="cropit-image-zoom-input" style="width:300px;">
                                                                        <input type="file" class="cropit-image-input" />
                                                                    </div>
                                                                    <div style="border:1px solid #F00;position:absolute; margin-top:-70px; "></div>

                                                                </div>
                                                                <div class="col-sm-5">
                                                                    <div class="btn btn-primary select-image-btn">Select new image</div><BR><BR>
                                                                    <button type="button" class="btn btn-primary" onclick="checkLoginState()">Facebook</button>
                                                                </div>

                                                                <div class="form-group">
                                                                    <label class="col-xs-12">ข้อความ 1</label>
                                                                    <div class="pull-right" style="margin-top:-20px;margin-right:10px;"><span id="text_bless_len" style="color:#FF6600;">0 ตัวอักษร</span></div>
                                                                    <div class="col-xs-12 ">
                                                                        <input id="text_bless" name="text_bless" ng-model="text"  type="text" class="form-control" >
                                                                        @{{ text }}
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-xs-12">ข้อความ 2</label>
                                                                    <div class="pull-right" style="margin-top:-20px;margin-right:10px;"><span id="text_bless_2_len" style="color:#FF6600;">0 ตัวอักษร</span></div>
                                                                    <div class="col-xs-12 ">
                                                                        <input id="text_bless_2" name="text_bless_2" type="text" class="form-control" >
                                                                    </div>
                                                                </div>
                                                                <div class="form-group">
                                                                    <div class="col-xs-12 col-sm-5 col-centered">
                                                                        <input class="btn btn-success btn-block" type="submit" value="Submit">
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>

                                                </div>
                                            </div>
                                        </div><!--<div id="upload_img_review" > -->
                                    </div>
                                    <div class="row">

                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <img scr="" id="show-gen-img"  >










    <script src="{{url('scripts/bootstrap-3.3.2/js/bootstrap.min.js')}} "></script>
    <script src="{{url('scripts/cropit/jquery.cropit.js')}}"></script>
    <script src="{{url('scripts/angular.min.js')}} "></script>
    {{--<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.12/angular.min.js"></script>--}}







</div>
</body>

</html>


