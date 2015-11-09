


<!DOCTYPE html>
<html lang="en" ng-app="ecard.gallery" >

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <link rel="stylesheet" href="{{url('scripts/bootstrap-3.3.2/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="{{url('memoprint/fonts/arabica/style.css')}}">
    {{--<link rel="stylesheet" href="{{url('memoprint/fonts/sukhumvit/style.css')}}">--}}
    {{--<link rel="stylesheet" href="{{url('memoprint/fonts/thaisans_neue/style.css')}}">--}}
    <link rel="stylesheet" href="{{url('memoprint/fonts/quark2/style.css')}}">
    <link rel="stylesheet" href="{{url('memoprint/css/ecard.css')}}">

    <script src="{{url('scripts/jquery-1.11.1.min.js')}}"></script>
    <script src="{{url('scripts/html2canvas/html2canvas.js')}}"></script>
</head>

<body >
<div  >


    <script>
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
        function get_facebook_data(){
            FB.api(
                    '/me',
                    'GET',
                    {"fields":"albums{name,cover_photo, photos{picture,source}}"},
                    function(response) {
                       // console.log(response);
                        album_list(response);

                        fn_login();
                    }
            );
        }
        function share_fb(){
            var pic =  $('#img_gen').val();
            FB.ui({
                method: 'feed',
                name: 'test',
                description: 'test',
                picture: pic
            }, function (response) {
                console.log(response);
                if (response && response != null) {
                }
            });
        }

        function canpic(){
            var c = document.getElementById('canpic');
            var t = c.getContext('2d');


            console.log(t) ;

        }


//        $(function() {
//            $("#btnSave").click(function() {
//                html2canvas($("#gen-image"), {
//                    onrendered: function(canvas) {
//                        theCanvas = canvas;
//                        theCanvas.id = "canvas_image" ;
//                        document.body.appendChild(canvas);
//                        //console.log(canvas);
//
//
//
//                        var canvas = document.getElementById('canvas_image');
//                        var dataURL = canvas.toDataURL("image/jpeg",100);
//                        //console.log(dataURL);
//                        getBase64ImageExportJS(dataURL);
//
//                        // Convert and download as image
//                        //Canvas2Image.saveAsPNG(canvas);
//                        $("#img-out").append(canvas);
//                        // Clean up
//                        //document.body.removeChild(canvas);
//                    }
//                });
//            });
//        });




    </script>


    {{--<input class="btn-ecard" type="button" id="btnSave" value="Save PNG"/>--}}

    {{--<button  onclick="canpic()" >--}}
        {{--test1--}}
    {{--</button>--}}

    {{--<button class="btn-ecard" onclick="window.open('', document.getElementById('canpic').toDataURL());" >--}}
        {{--test2--}}
    {{--</button>--}}


    {{--<button class="btn-ecard"  data-toggle="modal" data-target="#success_popup">--}}
        {{--Modal--}}
    {{--</button>--}}


    <div id="page-content" ng-controller="ecard-gallery">
        <!--  Container -->
        <div class="container-fluid col-sm-12 col-centered">
            <section id="first-page"  style="  background: url('{{url('images/ecard_main/bg_home.png')}}');" >
                <div class="main">
                    <div class="row-fluid">
                        <div class="col-xs-12 col-sm-3 pull-right first-page-content" >
                            <span style="font:bold 60px Arabica;">KEEP YOUR </span><br>
                            <span style="color:#3fb3a7;font:bold 80px Arabica;">MEMORY</span><br>
                            <span style="font:bold 60px Arabica;">IN TIME</span><br>
                            <div class="h20"></div>
                            <span>"แชร์ทุกความประทับใจของคุณ"</span>
                            <div class="h20"></div>
                            <button class="btn-ecard fs36" onclick="play_ecard()" style="font-size:36px;padding:10px 34px 10px 34px;"> <i class="glyphicon glyphicon-camera" ></i> เล่นเลย!!</button>
                            <div class="h20"></div>
                            <button class="btn-ecard btn-e-green" style="font-size:36px;" id="howtoplay" > วิธีการร่วมสนุก</button>
                        </div>
                        <div class="col-xs-12 col-sm-9">
                            <img src="images/ecard_main/main_img.png" class="img-responsive" >
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </section>


            <section id="play-page"  style="display: none;background:url('{{url('images/ecard_main/bg_home.png')}}');"  >
                <div class="main">
                    {{--<div class="col-sm-12" style="height:50px;"></div>--}}
                    <form id="ecardform" class="form-horizontal" method="post" role="form" action=""   enctype="multipart/form-data">
                        <input type="hidden" name="img_gen" id="img_gen" value="" />
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="fbuid" id="fbuid" value="" />
                        <input type="hidden" name="m" id="m" value="" />
                        <input type="hidden" name="image_data" id="image_data" class="hidden-image-data" />
                        <input type="hidden" name="call_ang" id="call_ang" ng-click="getPosts(1)" >

                        <div class="row-fluid" style="margin-top:50px;" >
                            <div class="col-sm-12" align="center">
                                <div class="ecard-page-header play_header">
                                    อัพโหลดรูปภาพของคุณ
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12" style="height:50px;"></div>
                        <div class="row-fluid upload_img_row" >
                            <div class="col-sm-8 img-crop-layer" >

                                <div class="r" style="z-index:0;">
                                    <img src="{{url('images/ecard_main/play_frame_stamp.png')}}" >
                                </div>
                                <div id="gen-image">
                                    <div class="r" style="margin-top:-615px; margin-left:45px;z-index:1;">
                                        <img src="{{url('images/ecard_main/play_frame_1.png')}}" id="frame_ecard" >
                                    </div>
                                    <div class="r" style="margin-top:-445px;margin-left:122px;z-index:2;">
                                        <div id="image-cropper">
                                            <div class="cropit-image-preview"></div>
                                            <input type="range" class="cropit-image-zoom-input" style="margin-top:140px;margin-left:-75px;width:200px;" >
                                            <input type="file" class="cropit-image-input" />
                                        </div>
                                    </div>
                                    {{--<div id="clear_img" style="display:none !important ;">--}}
                                        {{--<button type="button" class="btn_clear_img" >x</button>--}}
                                    {{--</div>--}}
                                    <div class="a play_loy_txt" style="@if(Ecad::chkBrowser("Edge")==1){{ "margin-top:-600px;"  }}@elseif(Ecad::chkBrowser("Firefox")==1) {{ "margin-top:-605px;" }}  @elseif(Ecad::chkBrowser("Chrome")==1) {{ "margin-top:-578px;" }}  @endif  }}"></div>
                                    <div class="a play_text_name" style="@if(Ecad::chkBrowser("Edge")==1){{ "margin-top:-245px;"  }}@elseif(Ecad::chkBrowser("Firefox")==1) {{ "margin-top:-250px;" }}  @elseif(Ecad::chkBrowser("Chrome")==1) {{ "margin-top:-225px;" }} @endif  }}"></div>
                                    <div class="a play_font_text_name" style="@if(Ecad::chkBrowser("Edge")==1){{ "margin-top:-240px;"  }}@elseif(Ecad::chkBrowser("Firefox")==1) {{ "margin-top:-245px;" }}  @elseif(Ecad::chkBrowser("Chrome")==1) {{ "margin-top:-220px;" }}  @endif  }}"> @{{ name }}</div>
                                    <div class="a play_font_message" style="@if(Ecad::chkBrowser("Edge")==1){{ "margin-top:-200px;"  }}@elseif(Ecad::chkBrowser("Firefox")==1) {{ "margin-top:-205px;" }}  @elseif(Ecad::chkBrowser("Chrome")==1) {{ "margin-top:-180px;" }}  @endif  }}"> @{{ text }}</div>

                                    <div id="frame_ecard_star" class="a play_frame_2_star" style="@if(Ecad::chkBrowser("Edge")==1){{ "margin-top:-575px;"  }}@elseif(Ecad::chkBrowser("Firefox")==1) {{ "margin-top:-580px;" }}  @elseif(Ecad::chkBrowser("Chrome")==1) {{ "margin-top:-555px;" }}  @endif  }}"></div>
                                    <div class="a play_frame_border_top" style="@if(Ecad::chkBrowser("Edge")==1){{ "margin-top:-559px;"  }}@elseif(Ecad::chkBrowser("Firefox")==1) {{ "margin-top:-566px;" }}  @elseif(Ecad::chkBrowser("Chrome")==1) {{ "margin-top:-539px;" }}  @endif  }}"></div>
                                    <div class="a play_frame_border_bottom" style="@if(Ecad::chkBrowser("Edge")==1){{ "margin-top:-214px;"  }}@elseif(Ecad::chkBrowser("Firefox")==1) {{ "margin-top:-221px;" }}  @elseif(Ecad::chkBrowser("Chrome")==1) {{ "margin-top:-194px;" }}  @endif  }}"></div>
                                    <div class="a play_frame_border_left" style="@if(Ecad::chkBrowser("Edge")==1){{ "margin-top:-563px;"  }}@elseif(Ecad::chkBrowser("Firefox")==1) {{ "margin-top:-570px;" }}  @elseif(Ecad::chkBrowser("Chrome")==1) {{ "margin-top:-540px;" }}  @endif  }}"></div>
                                    <div class="a play_frame_border_right" style="@if(Ecad::chkBrowser("Edge")==1){{ "margin-top:-561px;"  }}@elseif(Ecad::chkBrowser("Firefox")==1) {{ "margin-top:-568px;" }}  @elseif(Ecad::chkBrowser("Chrome")==1) {{ "margin-top:-541px;" }}  @endif  }}"></div>
                                    <div class="a play_keep_memory" style="@if(Ecad::chkBrowser("Edge")==1){{ "margin-top:-170px;"  }}@elseif(Ecad::chkBrowser("Firefox")==1) {{ "margin-top:-177px;" }}  @elseif(Ecad::chkBrowser("Chrome")==1) {{ "margin-top:-150px;" }}  @endif  }}" >#keepmemoryintime</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-4 pd mg pagination" style="@if(Ecad::chkBrowser("Edge")==1){{ "margin-top:-80px;"  }}@elseif(Ecad::chkBrowser("Firefox")==1) {{ "margin-top:-83px;" }}  @elseif(Ecad::chkBrowser("Chrome")==1) {{ "margin-top:-65px;" }}  @endif  }}width:235px;z-index:10;margin-left:300px;">
                                        <button type="button" class="r fl btn-ecard btn-e-green" style="padding: 5px 10px;" onclick="change_frame('1')" ><i class="glyphicon glyphicon-arrow-left" style="font-size:20px;" ></i></button>
                                        <input type="text" id="frame_image" name="frame_image" value="1" class="input_pagination" >&nbsp;
                                        <span class="a" style="margin-top:5px;" >OF 2</span>
                                        <button type="button" class="r fl btn-ecard btn-e-green pull-right" style="padding: 5px 10px;" onclick="change_frame('2')"><i class="glyphicon glyphicon-arrow-right" style="font-size:20px;"></i></button>
                                    </div>
                                </div>


                            </div>
                            <div class="col-sm-4 play-form-input">
                                <div class="col-xs-6">
                                    <button type="button" class="btn-ecard btn-e-blue btn-e-30" style="margin-right:10px; padding:20px 30px 20px 30px;" onclick="checkLoginState()"><i class="fa fa-facebook-square" style="font-size: 44px;"></i><BR><span style="font-weight: normal;">FACEBOOK</span></button>
                                </div>
                                <div class="col-xs-6">
                                    <button type="button" class="btn-ecard btn-e-blue btn-e-30 select-image-btn"  ><i class="glyphicon glyphicon-folder-open" style="font-size: 40px;"></i><BR><span style="font-weight: normal;padding-top:-10px;">UPLOAD</span></button>
                                </div>


                                <div class="col-sm-12" style="height:50px;"></div>
                                <div class="form-group">
                                    <label class="col-xs-12" style="font-weight:normal;font-size: 32px;" >ชื่อของคุณ :</label>
                                    <div class="pull-right" style="margin-top:-45px;margin-right:10px;"><span id="name_len" style="color:#FF6600;">0 ตัวอักษร</span></div>
                                    <div class="col-xs-12 ">
                                        <input id="name" name="name" ng-model="name"  type="text" class="form-control" style="font-size: 24px;" placeholder="เช่น memoprint">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12" style="font-weight:normal;font-size: 32px;">ข้อความโดนใจ :</label>
                                    <div class="pull-right" style="margin-top:-45px;margin-right:10px;"><span id="text_rest_len" style="color:#FF6600;">0 ตัวอักษร</span></div>
                                    <div class="col-xs-12 ">

                                        <textarea id="text_rest" name="text_rest" ng-model="text" class="form-control" rows="3" cols="80" style="font-size: 24px;" placeholder="memoprint" ></textarea>
                                    </div>
                                </div>
                                <div class="h20"></div>
                                <button type="submit" class="btn-ecard btn-e-green" style="width:100%;">ตกลง</button>
                            </div>
                        </div>
                    </form>
                    <div class="clearfix"></div>
                </div>


            </section>


            <section id="page-howto" >
                <div class="main">
                    <div class="row-fluid" >
                        <div class="col-sm-12" align="center">
                            <div class="ecard-page-header howto-header">
                                วิธีการร่วมสนุก
                            </div>
                            <BR>
                            ร่วมแชร์ภาพง่ายๆ เพียงขั้นตอนดังต่อไปนี้
                        </div>
                    </div>
                    <ul class="row-fluid howto-page">
                        <li class="col-xs-12 col-sm-3">
                            <button type="button" class="btn-tran"  >1</button>
                            <img src="images/ecard_main/how_to_pic_box_1.png" class="img-responsive center-block" style="margin-top:70px;" >
                            <BR>
                            <p >กดที่ปุ่ม “เล่นเลย” ในหน้าแรก</p>
                        </li>
                        <li class="col-xs-12 col-sm-3 img_smoth">
                            <button type="button" class="btn-tran"  >2</button>
                            <img src="images/ecard_main/how_to_pic_box_2.png" class="img-responsive center-block " >
                            <p >เลือกรูปภาพ<BR>จาก Facebook<BR>หรือจากในเครื่องของคุณ</p>
                        </li>
                        <li class="col-xs-12 col-sm-3 img_smoth">
                            <button type="button" class="btn-tran"  >3</button>
                            <img src="images/ecard_main/how_to_pic_box_3.png" class="img-responsive center-block " >
                            <p >จัดตำแหน่งรูปภาพ<BR>พิมพ์ข้อความ ตามที่ต้องการ</p>
                        </li>
                        <li class="col-xs-12 col-sm-3">
                            <button type="button" class="btn-tran"  >4</button>
                            <img src="images/ecard_main/how_to_pic_box_4.png" class="img-responsive center-block" style="margin-top:70px;" >
                            <BR>
                            <p style="margin-top:10px;" >กดปุ่ม “แชร์เลย”<BR>
                                เพื่อแชร์ภาพของคุณลง<BR>
                                Facebook</p>
                        </li>
                    </ul>
                    {{--<div class="col-sm-12" align="center" style="margin-top:50px;">--}}
                    {{--<button class="btn-ecard" onclick="play_ecard()" style="font-size:36px;padding:10px 34px 10px 34px;"> <i class="glyphicon glyphicon-camera" ></i> เล่นเลย!!</button>--}}
                    {{--</div>--}}
                </div>

                <div class="clearfix"></div>
            </section>


            <section id="page-gallery"  style="margin-bottom:100px; background: url('{{url('images/ecard_main/bg_gallery.png')}}')  ; " >
                <div class="main">
                    <div class="row-fluid" >
                        <div class="col-sm-12" align="center">
                            <div class="ecard-page-header gallery_header">
                                รวมภาพความประทับใจ
                            </div>
                            <div class="col-sm-3 col-centered" style="margin:50px;">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search_name" id="search_name" placeholder="Search Name" ng-model="search_name" ng-keyup="complete()" aria-describedby="basic-addon2">

                                    <span ng-if="!sts_selectpic" class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-search"></i></span>

                                      <span class="input-group-btn" ng-if="sts_selectpic" >
                                        <button  class="btn btn-default" type="button" ng-click="close_search()" ><i class="glyphicon glyphicon-remove"></i></button>
                                      </span>
                                </div><!-- /input-group -->




                                <ul ng-if="autocomplete" class="a input-block-level " style="z-index:10;margin-left:-40px;" >
                                    <li ng-repeat="s in searchs"  ng-click="selectpic(s.id)"  class="autocomplete_box" >
                                        @{{ s.name }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <ul class="row-fluid " >
                        <li class="col-xs-6 col-sm-3" style="margin:15px 0px;" ng-repeat=" rs in data "  >
                            <img src="@{{ rs.gen_pic_path+rs.gen_pic_name }}" class="img-responsive" >
                        </li>

                    </ul>
                    <div class="clearfix"></div>
                    <div class="col-sm-12" align="center" style="margin-top:50px;">
                        <div class="col-xs-12 col-sm-3 pd mg col-centered pagination" >
                            <button type="button" class="r fl btn-ecard btn-e-green" style="padding: 5px 10px;" ng-click="getPosts(currentPage-1)" ><i class="glyphicon glyphicon-arrow-left" style="font-size:20px;" ></i></button>
                            <div>
                                <input type="text" id="gallery_image_page" name="gallery_image_page"  ng-model="gallery_image_page" ng-change="getPosts(gallery_image_page)" class="input_pagination" style="width:80px;">
                                <span class="a" style="margin-top:5px; margin-left: -60px;" >OF @{{ totalPages }}</span>
                            </div>

                            <button type="button" class="r fl btn-ecard btn-e-green pull-right" style="padding: 5px 10px;" ng-click="getPosts(currentPage+1)" ><i class="glyphicon glyphicon-arrow-right" style="font-size:20px;"></i></button>
                        </div>
                    </div>
                </div>

            </section>



        </div>


        <!-- Modal -->
        <div class="modal modal-vcenter fade" id="fb_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body">
                        <div align="center">
                            <div class="ecard-page-header facebook_album_header" >
                                เลือกภาพจาก FACEBOOK
                            </div>
                        </div>
                        <div class="modal-content-in-body" >

                            <div class="fb_list_gallery" align="center" >
                                <div class=" row gallery_fb"></div>
                            </div>
                            <div class="fb_list_photo_in_gallery" style="display:none;">
                                <div class="gallery_fb_profile_pic" style="display:none;"></div>
                                <div class="gallery_fb_timeline_pic" style="display:none;"></div>

                            </div>
                        </div>

                        <div class="a" style="margin-top:-470px; margin-left:-50px;">
                            <button type="button" class="btn_close" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="glyphicon glyphicon-remove" style="margin-top:10px;"></i>
                            </button>
                        </div>

                    </div>
                    <div class="modal-footer" >
                        <button type="button" class="btn-ecard btn-ecard-white btn-fb-gall-back" onclick="fb_popup_back()" style="display: none;"  >back</button>
                    </div>
                </div>
            </div>
        </div>

        <div class="modal modal-vcenter fade" id="success_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-body" >
                        <div align="center" >
                            <div class="ecard-page-header success_header" >
                                ได้รับภาพของคุณเรียบร้อย
                            </div>
                            <BR>
                            <button type="button" class="btn-ecard center-block"  style="width:250px;" onclick="share_fb()"><i class="fa fa-facebook-square" ></i>  แชร์เลย</button>
                            <br>
                            <button class="btn-ecard btn-e-green center-block"  style="width:250px;" onclick="page_reload()" ><i class="glyphicon glyphicon-download-alt" ></i>  UPLOAD ภาพใหม่ </button>
                            <br>
                            <button class="btn-ecard btn-e-green center-block" style="width:250px;" onclick="see_gallery();"> ไปที่ Gallery&nbsp;<i class="glyphicon glyphicon-arrow-right"></i></button>
                        </div>
                        <div class="a" style="margin-top:-430px; margin-left:-50px;">
                            <button type="button" class="btn_close" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="glyphicon glyphicon-remove" style="margin-top:10px;"></i>
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer" >

                    </div>
                </div>
            </div>
        </div>

        <div class="modal modal-vcenter fade" id="error_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content" >
                    <div class="modal-body" >
                        <div align="center" style="font-size: 72px;line-height: 390px;">
                            กรุณาเลือกรูป
                        </div>
                        <div class="a" style="margin-top:-435px; margin-left:-50px;">
                            <button type="button" class="btn_close" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="glyphicon glyphicon-remove" style="margin-top:10px;"></i>
                            </button>
                        </div>
                    </div>
                    <div class="modal-footer" >

                    </div>

                </div>
            </div>
        </div>


    </div>







    {{--<img scr="" id="show-gen-img"  >--}}

    <div id="img-out"></div>







    <script src="{{url('scripts/bootstrap-3.3.2/js/bootstrap.min.js')}} "></script>
    <script src="{{url('scripts/cropit/jquery.cropit.js')}}"></script>
    <script src="{{url('scripts/angular.min.js')}} "></script>
    <script src="{{url('scripts/custom/angular.ecard.js')}} "></script>
    <script src="{{url('scripts/custom/ecard.js')}} "></script>
    {{--<script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script>--}}
    {{--<script src="https://ajax.googleapis.com/ajax/libs/angularjs/1.3.12/angular.min.js"></script>--}}







</div>
</body>

</html>


