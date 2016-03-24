
<!DOCTYPE html>
<html lang="en" ng-app="ecard.gallery" >

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" id="myViewport" content="width=device-width">
    {{--<meta id="myViewport" name="viewport" content="width = 768,initial-scale=1">--}}
    <meta name="description" content="">
    <meta name="author" content="">
    <meta property="fb:app_id" content="546857855463355" />
    <meta property="og:title" content="Ecard Memoprint"/>
    <meta property="og:description" content="เทศกาลลอยกระทงนี้ มาส่งการ์ดอวยพรให้คนที่คุณรักกันเถอะ" />
    {{--<meta property="og:url" content="http://memoprint.me/" />--}}
    <meta property="og:type" content="website"/>
    <meta property="og:image"  content="{{asset('images/ecard_main/main_img.png')}}" />

    <meta property="og:image:width" content="600"/>
    <meta property="og:image:height" content="600"/>


    <meta property="og:site_name" content="Memoprint"/>
    <meta property="og:locale" content="th_TH" />

    <link rel="stylesheet" href="{{asset('scripts/bootstrap-3.3.2/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{asset('scripts/font-awesome/css/font-awesome.min.css')}}">

    <link rel="stylesheet" href="{{asset('memoprint/fonts/arabica2/stylesheet.css')}}">
    {{--<link rel="stylesheet" href="{{asset('memoprint/fonts/sukhumvit/style.css')}}">--}}
    {{--<link rel="stylesheet" href="{{asset('memoprint/fonts/thaisans_neue/style.css')}}">--}}
    {{--<link rel="stylesheet" href="{{asset('memoprint/fonts/quark2/style.css')}}">--}}
    <link rel="stylesheet" href="{{asset('memoprint/fonts/quark/stylesheet.css')}}">
    <link rel="stylesheet" href="{{asset('memoprint/css/ecard.css')}}">
    {{--<link rel="stylesheet" href="{{asset('scripts/jscrollpane/jquery.jscrollpane.css')}}" >--}}

    <script src="{{asset('scripts/jquery-1.11.1.min.js')}}"></script>
    {{--<script src="{{asset('scripts/jscrollpane/jquery.mousewheel.js')}} "></script>--}}
    {{--<script src="{{asset('scripts/jscrollpane/jquery.jscrollpane.min.js')}} "></script>--}}

    <script src="{{asset('scripts/html2canvas/html2canvas.js')}}"></script>
</head>

<body>
<div>

    <script>
        function checkLoginState() {
            FB.getLoginStatus(function(response) {
                if (response.status === 'connected') {
                    var uid = response.authResponse.userID;
                    var accessToken = response.authResponse.accessToken;
                    $('#m').val('fb');
                    $('#fbuid').val(uid);
                    get_facebook_data();
                }
            });
        }
        function fblogin(){
            $('#main-wrapper,.loading').show();
            FB.login(function (response) {
                if (response.authResponse != null && response.authResponse != undefined) {
                    checkLoginState()
                }
            }, { scope: 'publish_actions,user_photos' });
            return false;
        }
        window.fbAsyncInit = function() {
            FB.init({
                appId      : '546857855463355',
                status:true,
                cookie     : true,
                xfbml      : true,
                version    : 'v2.5'
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
//            console.log(pic);
            FB.ui({
                method: 'feed',
                link: 'http://www.memoprint.me/',
                name: 'memoprint ecard',
                description :'เทศกาลลอยกระทงนี้ มาส่งการ์ดอวยพรให้คนที่คุณรักกันเถอะ',
                picture: 'http://103.245.167.79/ecard/public/'+pic
            }, function (response) {
                if (response && response != null) {
                    fb_reload();
                }
            });
        }

    </script>
    <div id="fb-root"></div>

    {{--<input class="btn-ecard" type="button" id="btnSave" value="Save PNG"/>--}}

    {{--<button  onclick="canpic()" >--}}
    {{--test1--}}
    {{--</button>--}}

    {{--<button class="btn-ecard" onclick="window.open('', document.getElementById('canpic').toDataURL());" >--}}
    {{--test2--}}
    {{--</button>--}}
    {{--<a class="btn-ecard" onclick="return fblogin()" href="https://www.facebook.com/dialog/oauth?client_id=546857855463355&amp;client_secret=c4bf06cd95121e6014b4d2d30f76e85c&amp;redirect_uri=http://192.168.1.3/ecard/public/ecard&amp;response_type=code&amp;scope=email,user_photos,publish_actions"></a>--}}


    {{--<button class="btn-ecard"  data-toggle="modal" data-target="#success_popup">--}}
    {{--Modal--}}
    {{--</button>--}}
    <div class="main-wrapper" id="main-wrapper"  style="width:100%;height:100%;position:absolute;background: #1a1a1a;z-index:20;">
        <img src="{{asset('images/ecard_main/loading.gif')}}" class="loading" style="display:none;">
    </div>

    <div id="page-content" ng-controller="ecard-gallery">
        <!--  Container -->
        <div class="container-fluid col-md-12 col-centered">
            <section id="first-page"  style="  background: url('{{asset('images/ecard_main/bg_home.png')}}');" >
                <div class="main">
                    <div class="row-fluid">
                        <div class="col-xs-12 col-md-3 pull-right first-page-content" >
                            <span class="fst-keep" >KEEP YOUR </span><br>
                            <span class="fst-memory" >MEMORY</span><br>
                            <span class="fst-intime" >IN TIME</span><br>
                            <div class="h20"></div>
                            <span class="fst-content">"แชร์ทุกความประทับใจของคุณ"</span>
                            <div class="h20"></div>
                            <button class="btn-ecard fs36 btn-playnow" onclick="play_ecard()" style="padding:10px 34px 10px 34px;"> <i class="glyphicon glyphicon-camera" ></i> เล่นเลย!!</button>
                            <div class="h20"></div>
                            <button class="btn-ecard btn-e-green btn-playnow"  id="howtoplay" > วิธีการร่วมสนุก</button>
                        </div>
                        <div class="col-xs-12 col-md-9">
                            <img src="{{asset('images/ecard_main/main_img.png')}}" class="img-responsive" >
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </section>


            <section id="play-page"  style="overflow-x: hidden; display: none;background:url('{{asset('images/ecard_main/bg_upload.png')}}');"  >
                <div class="main" style="margin-bottom:50px;" >
                    {{--<div class="col-md-12" style="height:50px;"></div>--}}
                    <form id="ecardform" class="form-horizontal" method="post" role="form" action="" enctype="multipart/form-data">
                        <input type="hidden" name="img_gen" id="img_gen" value="" />
                        <input type="hidden" name="_token" id="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="fbuid" id="fbuid" value="" />
                        <input type="hidden" name="m" id="m" value="" />
                        <input type="hidden" name="image_data" id="image_data" class="hidden-image-data" />
                        <input type="hidden" name="call_ang" id="call_ang" ng-click="getPosts(1)" >
                        <div class="row-fluid" style="margin-top:0px;" >
                            <div class="col-md-12" align="center">
                                <div class="ecard-page-header play_header">
                                    อัพโหลดรูปภาพของคุณ
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12" style="height:50px;"></div>
                        <div class="row-fluid upload_img_row" >
                            <div class="col-md-8 img-crop-layer" >
                                <div class="r" style="z-index:0;">
                                    <img src="{{asset('images/ecard_main/play_frame_stamp.png')}}" >
                                </div>
                                <div id="gen-image">
                                    <div class="r" style="margin-top:-615px; margin-left:45px;z-index:2;pointer-events:none;">
                                        <img src="{{asset('images/ecard/201511_frame1.png')}}" id="frame_ecard" >
                                    </div>
                                    <div class="r" style="margin-top:-445px;margin-left:123px;z-index:1;">
                                        <div id="image-cropper">
                                            <div class="cropit-image-preview"></div>
                                            <input type="range" class="cropit-image-zoom-input" style="margin-top:140px;margin-left:-75px;width:200px;" >
                                            <input type="file" class="cropit-image-input" />
                                        </div>
                                    </div>
                                    <div class="a play_font_text_name" style="@if(Ecad::chkBrowser("Edge")==1){{ "margin-top:-240px;"  }}@elseif(Ecad::chkBrowser("Firefox")==1) {{ "margin-top:-245px;" }}  @elseif(Ecad::chkBrowser("Chrome")==1) {{ "margin-top:-220px;" }} @elseif(Ecad::chkBrowser("MSIE")==1) {{ "margin-top:-240px;" }} @endif  }}"> @{{ name }}</div>
                                    <div class="a play_font_message" style="@if(Ecad::chkBrowser("Edge")==1){{ "margin-top:-200px;"  }}@elseif(Ecad::chkBrowser("Firefox")==1) {{ "margin-top:-205px;" }}  @elseif(Ecad::chkBrowser("Chrome")==1) {{ "margin-top:-180px;" }} @elseif(Ecad::chkBrowser("MSIE")==1) {{ "margin-top:-200px;" }} @endif  }}"> @{{ text }}</div>
                                    <div class="a play_keep_memory" style="@if(Ecad::chkBrowser("Edge")==1){{ "margin-top:-170px;"  }}@elseif(Ecad::chkBrowser("Firefox")==1) {{ "margin-top:-177px;" }}  @elseif(Ecad::chkBrowser("Chrome")==1) {{ "margin-top:-150px;" }} @elseif(Ecad::chkBrowser("MSIE")==1) {{ "margin-top:-170px;" }} @endif  }}" >#keepmemoryintime</div>
                                </div>
                                <div class="row">
                                    <div class="col-xs-4 col-md-4 pd mg pagination pagination-crop-img" style="@if(Ecad::chkBrowser("Edge")==1){{ "margin-top:-80px;"  }}@elseif(Ecad::chkBrowser("Firefox")==1) {{ "margin-top:-83px;" }}  @elseif(Ecad::chkBrowser("Chrome")==1) {{ "margin-top:-65px;" }} @elseif(Ecad::chkBrowser("MSIE")==1) {{ "margin-top:-65px;" }} @endif  }} z-index:10;">
                                        <button type="button" class="r fl btn-ecard btn-e-green " style="padding: 0px 10px;" onclick="change_frame('1')" ><i class="glyphicon glyphicon-arrow-left" style="font-size:20px;" ></i></button>
                                        <input type="text" id="frame_image" name="frame_image" value="1" class="input_pagination" >&nbsp;
                                        <span class="a" style="margin-top:5px;" >OF 2</span>
                                        <button type="button" class="r fl btn-ecard btn-e-green pull-right " style="padding: 0px 10px;" onclick="change_frame('2')"><i class="glyphicon glyphicon-arrow-right" style="font-size:20px;"></i></button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-4 play-form-input">
                                <div class="col-xs-6">
                                    <a class="btn-ecard btn-e-blue btn-e-30 center-block btn-a" style="text-decoration: none;" onclick="return fblogin()" href="https://www.facebook.com/dialog/oauth?client_id=546857855463355&amp;client_secret=c4bf06cd95121e6014b4d2d30f76e85c&amp;redirect_uri=http://103.245.167.79/ecard/public/ecard&amp;response_type=code&amp;scope=email,user_photos,publish_actions">
                                        <i class="fa fa-facebook-square" style="font-size: 44px;"></i><BR><span style="font-weight: normal;">FACEBOOK</span>
                                    </a>
                                    {{--<button type="button" class="btn-ecard btn-e-blue btn-e-30 center-block" style="margin-right:10px; padding:20px 30px 20px 30px;" onclick="checkLoginState()"><i class="fa fa-facebook-square" style="font-size: 44px;"></i><BR><span style="font-weight: normal;">FACEBOOK</span></button>--}}
                                </div>
                                <div class="col-xs-6">
                                    <button type="button" class="btn-ecard btn-e-blue btn-e-30 select-image-btn center-block"  ><i class="glyphicon glyphicon-folder-open" style="font-size: 40px;"></i><BR><span style="font-weight: normal;padding-top:-10px;">UPLOAD</span></button>
                                </div>
                                <div class="col-md-12" style="height:50px;"></div>
                                <div class="form-group">
                                    <label class="col-xs-12" style="font-weight:normal;font-size: 32px;" >ชื่อของคุณ :</label>
                                    <div class="pull-right" style="margin-top:-45px;margin-right:10px;"><span id="name_len" style="color:#FF6600;">0 ตัวอักษร</span></div>
                                    <div class="col-xs-12 ">
                                        <input id="name" name="name" ng-model="name"  type="text" class="form-control"  placeholder="เช่น memoprint">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-xs-12" style="font-weight:normal;font-size: 32px;">ข้อความโดนใจ :</label>
                                    <div class="pull-right" style="margin-top:-45px;margin-right:10px;"><span id="text_rest_len" style="color:#FF6600;">0 ตัวอักษร</span></div>
                                    <div class="col-xs-12 ">
                                        <textarea id="text_rest" name="text_rest" ng-model="text" class="form-control" rows="3" cols="80"  placeholder="memoprint" ></textarea>
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
                        <div class="col-md-12" align="center">
                            <div class="ecard-page-header howto-header">
                                วิธีการร่วมสนุก
                            </div>
                            <BR>
                            ร่วมแชร์ภาพง่ายๆ เพียงขั้นตอนดังต่อไปนี้
                        </div>
                    </div>
                    <ul class="row-fluid howto-page">
                        <li class="col-xs-12 col-md-3">
                            <button type="button" class="btn-tran"  >1</button>
                            <img src="images/ecard_main/how_to_pic_box_1.png" class="img-responsive center-block" style="margin-top:70px;" >
                            <BR>
                            <p >กดที่ปุ่ม “เล่นเลย” ในหน้าแรก</p>
                        </li>
                        <li class="col-xs-12 col-md-3 img_smoth">
                            <button type="button" class="btn-tran"  >2</button>
                            <img src="images/ecard_main/how_to_pic_box_2.png" class="img-responsive center-block " >
                            <p >เลือกรูปภาพ<BR>จาก Facebook<BR>หรือจากในเครื่องของคุณ</p>
                        </li>
                        <li class="col-xs-12 col-md-3 img_smoth">
                            <button type="button" class="btn-tran"  >3</button>
                            <img src="images/ecard_main/how_to_pic_box_3.png" class="img-responsive center-block " >
                            <p >จัดตำแหน่งรูปภาพ<BR>พิมพ์ข้อความ ตามที่ต้องการ</p>
                        </li>
                        <li class="col-xs-12 col-md-3">
                            <button type="button" class="btn-tran"  >4</button>
                            <img src="images/ecard_main/how_to_pic_box_4.png" class="img-responsive center-block" style="margin-top:70px;" >
                            <BR>
                            <p style="margin-top:10px;" >กดปุ่ม “แชร์เลย”<BR>
                                เพื่อแชร์ภาพของคุณลง<BR>
                                Facebook</p>
                        </li>
                    </ul>
                    {{--<div class="col-md-12" align="center" style="margin-top:50px;">--}}
                    {{--<button class="btn-ecard" onclick="play_ecard()" style="font-size:36px;padding:10px 34px 10px 34px;"> <i class="glyphicon glyphicon-camera" ></i> เล่นเลย!!</button>--}}
                    {{--</div>--}}
                </div>
                <div class="clearfix"></div>
            </section>


            <section id="page-gallery"  style="margin-bottom:100px; background: url('{{asset('images/ecard_main/bg_Gallery.png')}}')  ; " >
                <div class="main">
                    <div class="row-fluid" >
                        <div class="col-md-12" align="center">
                            <div class="ecard-page-header gallery_header">
                                รวมภาพความประทับใจ
                            </div>
                            <div class="col-md-3 col-centered" style="margin:50px;">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="search_name" id="search_name" placeholder="Search Name" ng-model="search_name" ng-keyup="complete()" aria-describedby="basic-addon2">
                                    <span ng-if="!sts_selectpic" class="input-group-addon" id="basic-addon2"><i class="glyphicon glyphicon-search"></i></span>
                                      <span class="input-group-btn" ng-if="sts_selectpic" >
                                        <button  class="btn btn-default" type="button" ng-click="close_search()" ><i class="glyphicon glyphicon-remove"></i></button>
                                      </span>
                                </div><!-- /input-group -->
                                <ul ng-if="autocomplete" class="a input-block-level " style="z-index:10;margin-left:-30px;" >
                                    <li ng-repeat="s in searchs"  ng-click="selectpic(s.id)"  class="autocomplete_box" >
                                        @{{ s.name }}
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <ul class="row-fluid pd mg" >
                        <li class="col-xs-12 col-sm-6 col-md-3" style="margin:15px 0px;" ng-repeat=" rs in data "  >
                            <img src="@{{ rs.gen_pic_path+rs.gen_pic_name }}" class="img-responsive" >
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                    <div class="row" >
                        <div class="col-xs-4 col-md-4 pd mg pagination" style="width:270px;line-height: 35px;left:50%; margin-top:50px;margin-left:-135px; ">
                            <button type="button" class="r fl btn-ecard btn-e-green btn-pagination" style=""  ng-click="getPosts(currentPage-1)" ><i class="glyphicon glyphicon-arrow-left" style="font-size:20px;" ></i></button>
                            <div class="r col-centered" style="margin-top:0px;">
                                <input type="text" id="gallery_image_page" name="gallery_image_page"  ng-model="gallery_image_page" ng-change="getPosts(gallery_image_page)" class="input_pagination" style="width:70px;">
                                <span class="a" style="margin-top:5px;line-height:50px;" >OF @{{ totalPages }}</span>
                            </div>
                            <button type="button" class="r fl btn-ecard btn-e-green pull-right btn-pagination" style="" ng-click="getPosts(currentPage+1)"><i class="glyphicon glyphicon-arrow-right" style="font-size:20px;"></i></button>
                        </div>
                    </div>
                </div>
            </section>



        </div>


        <!-- Modal -->
        <div class="modal modal-vcenter fade" id="fb_popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-body ">
                        <div class="a" style="margin-top:-50px; margin-left:-50px;">
                            <button type="button" class="btn_close" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="glyphicon glyphicon-remove" style="margin-top:10px;"></i>
                            </button>
                        </div>
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
                        <div class="a" style="margin-top:-50px; margin-left:-50px;">
                            <button type="button" class="btn_close" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="glyphicon glyphicon-remove" style="margin-top:10px;"></i>
                            </button>
                        </div>
                        <div align="center" >
                            <div class="ecard-page-header success_header" >
                                ได้รับภาพของคุณเรียบร้อย
                            </div>
                            <BR>
                            <button type="button" class="btn-ecard center-block"  style="width:250px;" onclick="share_fb()"><i class="fa fa-facebook-square" ></i>  แชร์เลย</button>
                            <br>
                            <button class="btn-ecard btn-e-green center-block btn-upload-new"  style="width:250px;font-size:26px; " onclick="page_reload()" ><i class="glyphicon glyphicon-download-alt" ></i>  UPLOAD ภาพใหม่ </button>
                            <br>
                            <button class="btn-ecard btn-e-green center-block" style="width:250px;" onclick="see_gallery();"> ไปที่ Gallery&nbsp;<i class="glyphicon glyphicon-arrow-right"></i></button>
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
                        <div class="a" style="margin-top:-50px; margin-left:-50px;">
                            <button type="button" class="btn_close" class="close" data-dismiss="modal" aria-label="Close">
                                <i class="glyphicon glyphicon-remove" style="margin-top:10px;"></i>
                            </button>
                        </div>
                        <div align="center" style="font-size: 72px;line-height: 390px;">
                            กรุณาเลือกรูป
                        </div>
                    </div>
                    <div class="modal-footer" >
                    </div>

                </div>
            </div>
        </div>


    </div>

    <img id="show-gen-img" src="">


    <script src="{{asset('scripts/bootstrap-3.3.2/js/bootstrap.min.js')}} "></script>
    <script src="{{asset('scripts/cropit/jquery.cropit.js')}}"></script>
    <script src="{{asset('scripts/angular.min.js')}} "></script>



    <script src="{{asset('scripts/custom/angular.ecard.js')}} "></script>
    <script src="{{asset('scripts/custom/ecard.js')}} "></script>





</div>
</body>

</html>


