
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">


</head>

<body>
<!-- Bootstrap Core CSS -->

<script src="{{url('scripts/jquery-1.11.1.min.js')}} "></script>
<div id="main">

    <link rel="stylesheet" href="{{url('scripts/bootstrap-3.3.2/css/bootstrap.min.css')}}">


    <style>
        html{
            min-height:100%;
            position:relative;
        }
        body { overflow-x:hidden; font-size:12px; background:#E9E9E9 repeat; font-family:Tahoma, Geneva, sans-serif; 	}
        #main	{ position:absolute; width:984px; margin:0 auto; background:#FFF; top:0;bottom:0;left:0;right:0;}
        .col-centered{
            float: none;
            margin: 0 auto;
        }

        form.form-horizontal label.error, label.error {
            /* remove the next line when you have trouble in IE6 with labels in list */
            color: red;
            font-style: italic
        }

        #upload_img_review .thumbnail{background:#EEEEEE;}
        .upload_img_row .btn_clear_img { position:absolute;margin:15px 0px 0px 175px; z-index:1;border-radius:50px;-moz-border-radius: 50px;
            -webkit-border-radius: 50px;border:1px solid #ccc; background:#ccc;color:#FFF; font-size:10px;font-weight:bold; padding:0px 5px 2px 5px; }
        .upload_img_row .btn_clear_img:hover {background:#f00;border:1px solid #f00;}

        .upload_img_row .cropit-image-preview {
            background-color: #f8f8f8;
            background-size: cover;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-top: 7px;
            width: 200px;
            height: 200px;
            cursor: move;
        }
        .upload_img_row input {
            display: block;
        }

        .upload_img_row input.cropit-image-input {
            visibility: hidden;
        }

    </style>
    <script>

        $(function() {
            $('#show-gen-img').hide();
            $('.cropit-image-preview').css("background-image", "url('images/broken_thumb.png')");
            $('#image-cropper').cropit({

//                initialZoom:'image',
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

//callback handler for form submit



//            $('#ecardform').submit(function(e) {
//                // Move cropped image data to hidden input
//                var mode_submit = $('#m').val() ;
//                if (mode_submit!="desc"&&mode_submit!="fb"){
//                    alert('กรุณาเลือกรูปค่ะ'); return false;
//                }
//                if(mode_submit=="desc"){
//                    $('#fbuid').val('');
//                }
//                var imageData = $('#image-cropper').cropit('export', {
//                    type: 'image/jpeg',
//                    quality: 1,
////                    originalSize: true
//                });
//                $('.hidden-image-data').val(imageData);
//
//                var ajax_url = "ecard-ajax" ;
//                var postData = $(this).serializeArray();
////                var from_data = {
////                    _token: $('#_token').val(),
////                    fbuid: $('#fbuid').val(),
////                    m: $('#m').val(),
////                    image_data: $('#image_data').val(),
////                    text_bless: $('#text_bless').val()
////                }
//                $.ajax({
//                    url: ajax_url ,
//                    data: postData ,
//                    type: "POST",
//                    async: false,
//
//                    success: function(html) {
//                        var str = html;
//                        console.log(html) ;
////
////                        if(str=="clear"){
////                            location.reload();
////                        }else{
////                            alert(str);
////                        }
//                    },
//                    error: function(request, status, errorThrown) {
//                        alert("เกิดข้อผิดพลาดกับระบบ!!!");
//                    }
//                });
//
//                e.preventDefault(); //STOP default action
//                e.unbind(); //unbind. to stop multiple form submit.
//
//
//            });
        });
        function checkLoginState() {



            FB.getLoginStatus(function(response) {
                if (response.status === 'connected') {
                    var uid = response.authResponse.userID;
                    var accessToken = response.authResponse.accessToken;
                    $('#m').val('fb');
                    $('#fbuid').val(uid);
//                    var img = "http://graph.facebook.com/"+uid+"/picture?width=320&height=320" ;
//                    $('.cropit-image-preview').css("background-image", "url(http://graph.facebook.com/"+uid+"/picture?width=320&height=320)");
//                    $('.cropit-image-preview').css("width","200px").css("height","200px");
//                    $('#image-cropper').cropit('imageSrc',img);
                    get_facebook_data();


//                    $('#imagePreview').css("background-image", "url(http://graph.facebook.com/"+uid+"/picture?width=320&height=320)");
//                    $('.upload_n').text(uid+'.jpg');
//                    $('#clear_img').show();

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
                // Move cropped image data to hidden input
                var mode_submit = $('#m').val() ;
                if (mode_submit!="desc"&&mode_submit!="fb"){
                    alert('กรุณาเลือกรูปค่ะ'); return false;
                }
                if(mode_submit=="desc"){
                    $('#fbuid').val('');
                    var imageData = $('#image-cropper').cropit('export', {
                        type: 'image/jpeg',
                        quality: 1,
//                    originalSize: true
                    });
                    $('.hidden-image-data').val(imageData);
                }

//
                var link_text = $('#image-cropper').cropit('imageSrc');
//                console.log(test);
//                return false;


//                var data_url_img =  getBase64Image(link_text) ;
//                console.log('data_url',data_url_img);
//                return false;


//                var test = $('#image-cropper').getContext("2d").toDataURL();
//                console.log(test);


                var  offset =  $('#image-cropper').cropit('offset');
                alert(offset.x+" : "+offset.y);


                var postData = $(this).serializeArray();

                var fbid = $('#fbuid').val();
                var c_data = "/"+fbid+"/photos" ;
                //console.log(c_data); return false;

//                FB.api(
//                        '/me/albums' ,
//                        function (response) {
//                            console.log((response)) ;
//                            console.log('count : ',(response.data.length)) ;
//                            if (response && !response.error) {
//                                /* handle the result */
//                                var album_data = "" ;
//
//
//                                for (var i =0 ; i<response.data.length ; i++){
//
//
//
//                                    if (response.data[i].name=="Profile Pictures"){
//                                        console.log( response.data[i].id+':'+response.data[i].name);
//                                        var album_id = response.data[i].id ;
//                                        cover_photo_in_album(album_data,response.data[i].id,response.data[i].name) ;
//
//                                    }
//                                    if (response.data[i].name=="Timeline Photos"){
//                                        var album_id = response.data[i].id ;
//                                        console.log(album_id+':'+response.data[i].name);
//                                        cover_photo_in_album(album_data,response.data[i].id,response.data[i].name) ;
////                                        FB.api(
////                                                "/"+album_id+"/picture",
////                                                function (response) {
////                                                    console.log(response.data.url);
////                                                    if (response && !response.error) {
////                                                        /* handle the result */
////                                                        pic_data +=  "<img src=\""+response.data.url+"\" onclick=\"photo_in_album("+album_id+")\"  ><BR>Timeline Photos<BR>" ;
////                                                        $('.gallery_fb').html(pic_data);
////                                                    }
////                                                }
////                                        );
//                                    }
//                                }
//
//
//
//
//                            }
//                        }
//                );


                $.ajax(
                        {
                            url : "ecard-ajax",
                            async:    false,
                            type: "POST",
                            data : postData,
                            success:function(data, textStatus, jqXHR)
                            {
                                var str = data;
                                console.log(data) ;
                                $('#show-gen-img').show();
                                $('#show-gen-img').attr("src", data);
                                // share_fb();



//                                FB.api(
//                                        "/me/albums",
//                                        function (response) {
//                                            console.log(response);
//                                            if (response && !response.error) {
//                                                /* handle the result */
//                                            }
//                                        }
//                                );




//                                FB.api(
//                                        "/me/feed",
//                                        "POST",
//                                        {
//                                            // work
//                                            "message": "This is a test message",
//                                            "link": "http://i.kapook.com/faiiya//24-1-54/asi19.jpg",
//                                            "privacy": {
//                                                "value" : 'SELF'
//                                            }
//                                        },
//                                        function (response) {
//                                            console.log(response);
//                                            if (response && !response.error) {
//                                                /* handle the result */
//
//                                            }
//                                        }
//                                );
                                return false;

                            },
                            error: function(jqXHR, textStatus, errorThrown)
                            {
                                //if fails
                                alert("error");
                            }
                        });
                e.preventDefault(); //STOP default action

            });

        });

        function get_facebook_data(){
            FB.api(
                    '/me',
                    'GET',
                    {"fields":"albums{name,cover_photo, photos{picture,source}}"},
                    function(response) {
                        // Insert your code here
                        console.log(response);

                        var album_data = "" ;

                        for(var i=0;i<response.albums.data.length;i++){
                            if (response.albums.data[i].name=="Profile Pictures"){
                                //set_show_photo(response,'profile_pic');
                                //console.log('name : '+response.albums.data[i].name);
                                //console.log('cover_id : '+response.albums.data[i].cover_photo.id);
                                var photo_in_album_data = "" ;
                                for (var y=0;y<response.albums.data[i].photos.data.length;y++){
                                    //console.log('pic : '+response.albums.data[i].photos.data[y].picture);
                                    photo_in_album_data += "<img src=\""+response.albums.data[i].photos.data[y].picture+"\" onclick=\"chose_photo('"+response.albums.data[i].photos.data[y].source+"')\" >" ;
                                    $('.gallery_fb_profile_pic').html(photo_in_album_data);
                                    if(response.albums.data[i].photos.data[y].id==response.albums.data[i].cover_photo.id){
                                        album_data += "<img src=\""+response.albums.data[i].photos.data[y].picture+"\" onclick=\"photo_in_album_show('profile_pic')\"><BR>"+response.albums.data[i].name+"<BR>" ;
                                        $('.gallery_fb').html(album_data);
                                    }
                                }
                            }
                            if (response.albums.data[i].name=="Timeline Photos"){
                                //set_show_photo(response,i,'timeline_pic',album_data);
//                                console.log('name : '+response.albums.data[i].name);
//                                console.log('cover_id : '+response.albums.data[i].cover_photo.id);
                                var photo_in_album_data = "" ;
                                for (var y=0;y<response.albums.data[i].photos.data.length;y++){
//                                    console.log('pic : '+response.albums.data[i].photos.data[y].picture);
                                    photo_in_album_data += "<img src=\""+response.albums.data[i].photos.data[y].picture+"\" onclick=\"chose_photo('"+response.albums.data[i].photos.data[y].source+"')\" >" ;
                                    $('.gallery_fb_timeline_pic').html(photo_in_album_data);

                                    if(response.albums.data[i].photos.data[y].id==response.albums.data[i].cover_photo.id){
                                        album_data += "<img src=\""+response.albums.data[i].photos.data[y].picture+"\" onclick=\"photo_in_album_show('timeline_pic')\"><BR>"+response.albums.data[i].name+"<BR>" ;
                                        $('.gallery_fb').html(album_data);
                                    }
                                }
                            }
                        }

                    }
            );
        }

        function getBase64Image(img) {
            // Create an empty canvas element

            var img = $('#image-cropper').cropit('imageSrc');

            var canvas = document.getElementById('canvas');
            var ctx = canvas.getContext('2d');


            //var canvas = document.createElement("canvas");
            canvas.width = img.width;
            canvas.height = img.height;


            console.log(canvas.width,canvas.height) ;

            ctx.drawImage(img, 200, 200);

            console.log('test2'); return false ;


            // Get the data-URL formatted image
            // Firefox supports PNG and JPEG. You could check img.src to
            // guess the original format, but be aware the using "image/jpg"
            // will re-encode the image.
            var dataURL = canvas.toDataURL("image/jpeg");

            return dataURL ;



            //return dataURL.replace(/^data:image\/(png|jpg);base64,/, "");
        }
        window.onload = init;
        function chose_photo(link){
            console.log(link);


            $('#image-cropper').cropit('imageSrc',link);
            $('#clear_img').show();
        }

        function set_show_photo(response,i,type_pic,album_data){
            console.log(response) ;
            console.log('name : '+response.albums.data[i].name);
            console.log('cover_id : '+response.albums.data[i].cover_photo.id);
            var photo_in_album_data = "" ;

            for (var y=0;y<response.albums.data[i].photos.data.length;y++){
                console.log('pic : '+response.albums.data[i].photos.data[y].picture);
                photo_in_album_data += "<img src=\""+response.albums.data[i].photos.data[y].picture+"\" >" ;
                va

                $('.gallery_fb_'+type_pic).html(photo_in_album_data);
                if(response.albums.data[i].photos.data[y].id==response.albums.data[i].cover_photo.id){
                    album_data += "<img src=\""+response.albums.data[i].photos.data[y].picture+"\" onclick=\"photo_in_album_show('"+type_pic+"')\"><BR>"+response.albums.data[i].name+"<BR>" ;
                    $('.gallery_fb').html(album_data);
                }
            }
        }

        function photo_in_album_show(album_name){
            var name = ".gallery_fb_"+album_name ;
            $('.gallery_fb_timeline_pic,.gallery_fb_profile_pic').hide();
            $(name).show();
        }



        function cover_photo_in_album(album_data,album_id,album_name){

            FB.api(
                    "/"+album_id+"/picture",
                    function (response) {
                        console.log(response);
                        console.log(response.data.url);
                        if (response && !response.error) {
                            /* handle the result */
                            album_data += "<img src=\""+response.data.url+"\" onclick=\"photo_in_album("+album_id+")\"><BR>"+album_name+"<BR>" ;
                            $('.gallery_fb').html(album_data);
                        }
                    }
            );
        }

        function photo_in_album(album_id){
            FB.api(
                    "/"+album_id+"/photos",
                    function (response) {
                        console.log(response);
                        if (response && !response.error) {
                            /* handle the result */
                            var photo_in_album = "";
                            for (var i = 0 ; i< response.data.length ; i++ ){
                                console.log( response.data[i].id );
                                var photo_id =  response.data[i].id ;
                                FB.api(
                                        "/"+photo_id+"/picture/width=100px",
                                        function (response) {
                                            console.log(response);
                                            if (response && !response.error) {
                                                /* handle the result */
                                                photo_in_album += "<img src=\""+response.data.url+"\" onclick=\"getphoto("+photo_id+")\"><BR>" ;
                                                $('.photo_in_album').html(photo_in_album);
                                            }
                                        }
                                );






                            }
                        }
                    }
            );
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

    </script>
    <canvas id="canvas"></canvas>
    <div id="page-content" class="t30d">
        <!--  Container -->
        <div class="container col-sm-12 col-centered main-page-content">
            <div >
                <div class="row">
                    <!--   ### Main content ###  -->
                    <div id="col-cen" class="col-sm-12 oh" >
                        <div class="row">
                            <div class="col-sm-12" style="margin-top:-20px;"><H3>เพิ่มร้าน</H3><h5>กรุณาระบุข้อมูลให้ครบถ้วน</h5>
                                <form id="ecardform" class="form-horizontal" method="post" role="form" action=""   enctype="multipart/form-data">
                                    <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="fbuid" id="fbuid" value="" />
                                    <input type="hidden" name="m" id="m" value="desc" />
                                    <input type="hidden" name="image_data" id="image_data" class="hidden-image-data" />



                                    <div class="row">
                                        <div class="col-sm-6 col-centered" id="upload_img_review">
                                            <div class="thumbnail" >
                                                <div class="caption" style="margin-top:0px;padding:10px 10px 0px 10px;">
                                                    <div class="upload_img_row">
                                                        <div class="row">
                                                            <div class="col-sm-12 col-centered">
                                                                <div class="col-sm-6">
                                                                    <div id="clear_img" style="display:none !important ;">
                                                                        <button type="button" class="btn_clear_img" >x</button>
                                                                    </div>

                                                                    <div id="image-cropper">
                                                                        <div class="cropit-image-preview"></div>
                                                                        <input type="range" class="cropit-image-zoom-input">
                                                                        <!-- The actual file input will be hidden -->
                                                                        <input type="file" class="cropit-image-input" />

                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <!-- And clicking on this button will open up select file dialog -->
                                                                    <div class="btn btn-primary select-image-btn">Select new image</div><BR><BR>

                                                                    <button type="button" class="btn btn-primary" onclick="checkLoginState()">Facebook</button>
                                                                </div>
                                                                <div class="form-group">
                                                                    <label class="col-xs-12">ข้อความ</label>
                                                                    <div class="pull-right" style="margin-top:-20px;margin-right:10px;"><span id="text_bless_len" style="color:#FF6600;">0 ตัวอักษร</span></div>
                                                                    <div class="col-xs-12 ">
                                                                        <input id="text_bless" name="text_bless" type="text" class="form-control" >

                                                                    </div>
                                                                </div>
                                                                <div class="form-group">

                                                                    <div class="col-xs-12 col-sm-5 col-centered ">
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


    <div class="gallery_fb" style="border:1px solid #F00;"></div>
    <div class="photo_in_album" style="border:1px solid #0F0;"></div>

    <div class="gallery_fb_profile_pic" style="border:1px solid #0F0;display:none;"></div>
    <div class="gallery_fb_timeline_pic" style="border:1px solid #0F0;display:none;"></div>








    <script src="{{url('scripts/bootstrap-3.3.2/js/bootstrap.min.js')}} "></script>
    <script src="{{url('scripts/cropit/jquery.cropit.js')}}"></script>

    <style>


    </style>


    <script>

    </script>






</div>
</body>

</html>


