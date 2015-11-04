
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
        /*.upload_img_row .title{ padding:10px 0px 10px 0px;font-weight:bold;}*/
        /*.upload_img_row .upload_n { max-width:157px;text-overflow:ellipsis;white-space:nowrap;overflow:hidden; }*/
        /*.upload_img_row #clear_img{ }*/
        /*.upload_img_row .btn_clear_img { position:absolute;margin:-195px 0px 0px 175px; z-index:1;border-radius:50px;-moz-border-radius: 50px;*/
        /*-webkit-border-radius: 50px;border:1px solid #ccc; background:#ccc;color:#FFF; font-size:10px;font-weight:bold; padding:0px 5px 2px 5px; }*/
        /*.upload_img_row .btn_clear_img:hover {background:#f00;border:1px solid #f00;}*/

        .upload_img_row .btn_clear_img { position:absolute;margin:15px 0px 0px 175px; z-index:1;border-radius:50px;-moz-border-radius: 50px;
            -webkit-border-radius: 50px;border:1px solid #ccc; background:#ccc;color:#FFF; font-size:10px;font-weight:bold; padding:0px 5px 2px 5px; }
        .upload_img_row .btn_clear_img:hover {background:#f00;border:1px solid #f00;}

        /*#upload_img_review #imagePreview {*/
        /*width: 200px;*/
        /*height: 200px;*/
        /*border-radius:10px;*/
        /*-webkit-border-radius: 10px;*/
        /*-moz-border-radius: 10px;*/
        /*/!*background-position: center center;*!/*/
        /*/!*background-size: cover;*!/*/
        /*/!*-webkit-box-shadow: 0 0 1px 1px rgba(0, 0, 0, .3);*!/*/
        /*/!*display: inline-block;*!/*/
        /*}*/
        /*div.upload {*/
        /*width: 157px;*/
        /*height: 35px;*/
        /*overflow: hidden;*/
        /*color: #515151;*/
        /*font-weight: bold;*/
        /*border: 1px solid #A3A3A3;*/
        /*border-radius: 3px;*/
        /*text-align:center;*/
        /*padding-top:8px;*/
        /*background-image: -moz-linear-gradient(-90deg, #FCFBFB, #F3F2F0);*/
        /*}*/

        /*div.upload input {*/
        /*display: block !important;*/
        /*width: 157px !important;*/
        /*height: 35px !important;*/
        /*opacity: 0 !important;*/
        /*overflow: hidden !important;*/
        /*margin-top:-20px;*/
        /*cursor: pointer;*/
        /*}*/

        /*@media (max-width:500px){*/
        /*.upload_img_row .media-left{ width:100%; }*/
        /*}*/




    </style>
    <script>
        $(function() {

//            $('.btn_clear_img').click(function() {
//                $(this).closest('.upload_img_row').find('#imagePreview').css("background-image", "url('images/broken_thumb.png')");
//                $(this).closest('.upload_img_row').find('#clear_img').hide();
//                $fileInput = $(this).closest('.upload_img_row').find('#uploadfiles') ;
//                $fileInput.val('');
//                $fileInput.replaceWith( $fileInput = $fileInput.clone( true ) ); // for IE
//                $(this).closest('.upload_img_row').find('.upload_n').text('no file chosen');
//                $('#fbuid').val('');
//                $('#m').val('desc');
//            });
//                $('#imagePreview').css("background-image", "url('images/broken_thumb.png')");
//                var $ulf = $('#imagePreview') ;
//                var $uln = $('.upload_n') ;
//                var $ulc = $('#clear_img') ;
//
//                $('#uploadfiles').on("change", function()
//                {
//                    $('#fbuid').val('');
//                    $('#m').val('desc');
//                    //alert(this.files[0].name+" type : "+this.files[0].type+" size : "+this.files[0].size) ;
//                    if (this.files[0].size > 1048576 ){ alert("รูปขนาดใหญ่เกิน 1 Mb ค่ะ"); return ;}
//
//                    var files = !!this.files ? this.files : [];
//                    if (!files.length || !window.FileReader) return; // no file selected, or no FileReader support
//
//                    if (/^image/.test( files[0].type)){ // only image file
//                        var reader = new FileReader(); // instance of the FileReader
//                        reader.readAsDataURL(files[0]); // read the local file
//                        reader.onloadend = function(){ // set image data as background of div
//                            $ulf.css("background-image", "url("+this.result+")");
//                            $uln.text(files[0].name);
//                            $ulc.show();
//                            //$("#imagePreview").attr("src", this.result);
//                        }
//                    }
//                });

        });
        $(function() {

            $('.cropit-image-preview').css("background-image", "url('images/broken_thumb.png')");
            $('#image-cropper').cropit({

                initialZoom:'image',
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


            $('form').submit(function() {
                // Move cropped image data to hidden input
                var mode_submit = $('#m').val() ;
                if (mode_submit!="desc"||mode_submit!="fb"){
                    alert('กรุณาเลือกรูปค่ะ'); return false;
                }
                if(mode_submit=="desc"){
                    $('#fbuid').val('');
                }
                var imageData = $('#image-cropper').cropit('export', {
                    type: 'image/jpeg',
                    quality: 1,
                    originalSize: true
                });
                $('.hidden-image-data').val(imageData);
            });
        });
        function checkLoginState() {
            FB.getLoginStatus(function(response) {
                if (response.status === 'connected') {
                    var uid = response.authResponse.userID;
                    var accessToken = response.authResponse.accessToken;
                    $('#m').val('fb');
                    $('#fbuid').val(uid);
                    var img = "http://graph.facebook.com/"+uid+"/picture?width=320&height=320" ;
//                    $('.cropit-image-preview').css("background-image", "url(http://graph.facebook.com/"+uid+"/picture?width=320&height=320)");
//                    $('.cropit-image-preview').css("width","200px").css("height","200px");
                    $('#image-cropper').cropit('imageSrc',img);


//                    $('#imagePreview').css("background-image", "url(http://graph.facebook.com/"+uid+"/picture?width=320&height=320)");
//                    $('.upload_n').text(uid+'.jpg');
                    $('#clear_img').show();

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
                scope: 'publish_actions',
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


        //        $(document).ready(function(){
        //            $('.changeInputButton').on('click', function () {
        //                $('#imagePreview').css("background-image", "url(http://graph.facebook.com/100001018085587/picture?width=320&height=320)");
        //                $('.upload_n').text('100001018085587.jpg');
        //                $('#clear_img').show();
        //                $('#m').val('fb');
        //                $('#fbuid').val('100001018085587');
        //
        //
        ////                $("#createrestform").attr("action", "ecard-facebook");
        ////                $('#createrestform').submit();
        //            });
        //        });
    </script>

    <div id="page-content" class="t30d">
        <!--  Container -->
        <div class="container col-sm-12 col-centered main-page-content">
            <div >
                <div class="row">
                    <!--   ### Main content ###  -->
                    <div id="col-cen" class="col-sm-12 oh" >
                        <div class="row">
                            <div class="col-sm-12" style="margin-top:-20px;"><H3>เพิ่มร้าน</H3><h5>กรุณาระบุข้อมูลให้ครบถ้วน</h5>
                                <form id="createrestform" class="form-horizontal" method="post" role="form" action="ecard"   enctype="multipart/form-data">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="hidden" name="fbuid" id="fbuid" value="100001018085587" />
                                    <input type="hidden" name="m" id="m" value="desc" />
                                    <input type="hidden" name="image_data" class="hidden-image-data" />



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


                                                    {{--<div class="upload_img_row">--}}
                                                    {{--<div class="row">--}}
                                                    {{--<div class="col-sm-6">--}}
                                                    {{--<div class="col-sm-12 pd mg title" >รูปภาพ</div>--}}
                                                    {{--<div class="col-sm-6 pd mg">--}}
                                                    {{--<div id="imagePreview"></div>--}}
                                                    {{--<div id="clear_img" style="display:none !important ;">--}}
                                                    {{--<button type="button" class="btn_clear_img" >x</button>--}}
                                                    {{--</div>--}}
                                                    {{--</div>--}}
                                                    {{--<div class="col-sm-6">--}}
                                                    {{--<div class="upload">Choose file--}}
                                                    {{--<input id="uploadfiles" name="uploadfiles" type="file" >--}}
                                                    {{--</div>--}}
                                                    {{--<div class="upload_n">--}}
                                                    {{--no file chosen--}}
                                                    {{--</div>--}}
                                                    {{--<div>--}}
                                                    {{--ไฟล์ GIF, JPG หรือ PNG ขนาดต่ำกว่า 1 Mb--}}
                                                    {{--</div>--}}
                                                    {{--<div>--}}
                                                    {{--<a href="#" class="btn btn-primary changeInputButton">facebook</a>--}}

                                                    {{--<button type="button" class="btn btn-primary" onclick="checkLoginState()">Facebook</button>--}}

                                                    {{--</div>--}}
                                                    {{--</div>--}}

                                                    {{--</div>--}}

                                                    {{--</div>--}}
                                                    {{--</div>--}}




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








    <script src="{{url('scripts/bootstrap-3.3.2/js/bootstrap.min.js')}} "></script>
    <script src="{{url('scripts/cropit/jquery.cropit.js')}}"></script>

    <style>
        .cropit-image-preview {
            background-color: #f8f8f8;
            background-size: cover;
            border: 1px solid #ccc;
            border-radius: 3px;
            margin-top: 7px;
            width: 200px;
            height: 200px;
            cursor: move;
        }

        .cropit-image-background {
            opacity: .2;
            cursor: auto;
        }

        .image-size-label {
            margin-top: 10px;
        }

        input {
            display: block;
        }

        button[type="submit"] {
            margin-top: 10px;
        }

        #result {
            margin-top: 10px;
            width: 900px;
        }

        #result-data {
            display: block;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            word-wrap: break-word;
        }


        input.cropit-image-input {
            visibility: hidden;
        }

    </style>


    <script>

    </script>






</div>
</body>

</html>


