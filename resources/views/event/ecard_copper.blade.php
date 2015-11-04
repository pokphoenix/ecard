<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="A basic demo of Cropper.">
    <meta name="keywords" content="HTML, CSS, JS, JavaScript, jQuery plugin, image cropping, image crop, image move, image zoom, image rotate, image scale, front-end, frontend, web development">
    <meta name="author" content="Fengyuan Chen">
    <title>Cropper</title>
    <link rel="stylesheet" href="{{url('scripts/cropper/assets/css/font-awesome.min.css')}}">
    <link rel="stylesheet" href="{{url('scripts/cropper/assets/css/bootstrap.min.css')}}">
    <link rel="stylesheet" href="{{url('scripts/cropper/assets/css/tooltip.min.css')}}">
    <link rel="stylesheet" href="{{url('scripts/cropper/dist/cropper.css')}}">
    <link rel="stylesheet" href="{{url('scripts/cropper/css/main.css')}} ">
    <script src="{{url('scripts/jquery-1.11.1.min.js')}} "></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<!-- header -->
<header class="navbar navbar-inverse navbar-static-top docs-header" id="top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-target="#navbar-collapse-1" data-toggle="collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="./">Cropper</a>
        </div>
        <nav class="collapse navbar-collapse" id="navbar-collapse-1" role="navigation">
            <p class="navbar-text">A simple jQuery image cropping plugin.</p>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="https://github.com/fengyuanchen/cropper/blob/master/README.md">Docs</a></li>
                <li><a href="https://github.com/fengyuanchen/cropper">Github</a></li>
                <li><a href="https://chenfengyuan.com">About</a></li>
                <li><a href="https://fengyuanchen.github.io">More</a></li>
            </ul>
        </nav>
    </div>
</header>




<!-- Content -->
<div class="container">
    <div class="row">
        <div class="col-md-9">
            <!-- <h3 class="page-header">Demo:</h3> -->
            <div class="img-container">
                {{--<img src="{{url('scripts/cropper/assets/img/picture.jpg')}}" id="image-cropper" alt="Picture">--}}
                <img src="" id="image-cropper" alt="Picture">
            </div>
        </div>
        <div class="col-md-3">
            <!-- <h3 class="page-header">Preview:</h3> -->
            <div class="docs-preview clearfix">
                <div class="img-preview preview-lg"></div>
                <div class="img-preview preview-md"></div>
                <div class="img-preview preview-sm"></div>
                <div class="img-preview preview-xs"></div>
            </div>

            <!-- <h3 class="page-header">Data:</h3> -->
            <div class="docs-data">
                <div class="input-group input-group-sm">
                    <label class="input-group-addon" for="dataX">X</label>
                    <input type="text" class="form-control" id="dataX" placeholder="x">
                    <span class="input-group-addon">px</span>
                </div>
                <div class="input-group input-group-sm">
                    <label class="input-group-addon" for="dataY">Y</label>
                    <input type="text" class="form-control" id="dataY" placeholder="y">
                    <span class="input-group-addon">px</span>
                </div>
                <div class="input-group input-group-sm">
                    <label class="input-group-addon" for="dataWidth">Width</label>
                    <input type="text" class="form-control" id="dataWidth" placeholder="width">
                    <span class="input-group-addon">px</span>
                </div>
                <div class="input-group input-group-sm">
                    <label class="input-group-addon" for="dataHeight">Height</label>
                    <input type="text" class="form-control" id="dataHeight" placeholder="height">
                    <span class="input-group-addon">px</span>
                </div>
                <div class="input-group input-group-sm">
                    <label class="input-group-addon" for="dataRotate">Rotate</label>
                    <input type="text" class="form-control" id="dataRotate" placeholder="rotate">
                    <span class="input-group-addon">deg</span>
                </div>
                <div class="input-group input-group-sm">
                    <label class="input-group-addon" for="dataScaleX">ScaleX</label>
                    <input type="text" class="form-control" id="dataScaleX" placeholder="scaleX">
                </div>
                <div class="input-group input-group-sm">
                    <label class="input-group-addon" for="dataScaleY">ScaleY</label>
                    <input type="text" class="form-control" id="dataScaleY" placeholder="scaleY">
                </div>
            </div>
        </div>
    </div>
    <div class="row docs-actions">
        <div class="col-md-9 docs-buttons">
            <!-- <h3 class="page-header">Toolbar:</h3> -->
            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="move" title="Move">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setDragMode&quot;, &quot;move&quot;)">
              <span class="fa fa-arrows"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="setDragMode" data-option="crop" title="Crop">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setDragMode&quot;, &quot;crop&quot;)">
              <span class="fa fa-crop"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="zoom" data-option="0.1" title="Zoom In">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;zoom&quot;, 0.1)">
              <span class="fa fa-search-plus"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="zoom" data-option="-0.1" title="Zoom Out">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;zoom&quot;, -0.1)">
              <span class="fa fa-search-minus"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="move" data-option="-10" data-second-option="0" title="Move Left">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;move&quot;, -10, 0)">
              <span class="fa fa-arrow-left"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="10" data-second-option="0" title="Move Right">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;move&quot;, 10, 0)">
              <span class="fa fa-arrow-right"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="-10" title="Move Up">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;move&quot;, 0, -10)">
              <span class="fa fa-arrow-up"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="move" data-option="0" data-second-option="10" title="Move Down">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;move&quot;, 0, 10)">
              <span class="fa fa-arrow-down"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="rotate" data-option="-45" title="Rotate Left">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;rotate&quot;, -45)">
              <span class="fa fa-rotate-left"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="rotate" data-option="45" title="Rotate Right">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;rotate&quot;, 45)">
              <span class="fa fa-rotate-right"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="scaleX" data-option="-1" title="Flip Horizontal">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;scaleX&quot;, -1)">
              <span class="fa fa-arrows-h"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="scaleY" data-option="-1" title="Flip Vertical">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;scaleY&quot;-1)">
              <span class="fa fa-arrows-v"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="crop" title="Crop">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;crop&quot;)">
              <span class="fa fa-check"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="clear" title="Clear">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;clear&quot;)">
              <span class="fa fa-remove"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="disable" title="Disable">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;disable&quot;)">
              <span class="fa fa-lock"></span>
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="enable" title="Enable">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;enable&quot;)">
              <span class="fa fa-unlock"></span>
            </span>
                </button>
            </div>

            <div class="btn-group">
                <button type="button" class="btn btn-primary" data-method="reset" title="Reset">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;reset&quot;)">
              <span class="fa fa-refresh"></span>
            </span>
                </button>
                <label class="btn btn-primary btn-upload" for="inputImage" title="Upload image file">
                    <input type="file" class="sr-only" id="inputImage" name="file" accept="image/*">
            <span class="docs-tooltip" data-toggle="tooltip" title="Import image with Blob URLs">
              <span class="fa fa-upload"></span>
            </span>
                </label>
                <button type="button" class="btn btn-primary" data-method="destroy" title="Destroy">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;destroy&quot;)">
              <span class="fa fa-power-off"></span>
            </span>
                </button>
            </div>

            <div class="btn-group btn-group-crop">
                <button type="button" class="btn btn-primary" data-method="getCroppedCanvas">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getCroppedCanvas&quot;)">
              Get Cropped Canvas
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 160, &quot;height&quot;: 90 }">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getCroppedCanvas&quot;, { width: 160, height: 90 })">
              160&times;90
            </span>
                </button>
                <button type="button" class="btn btn-primary" data-method="getCroppedCanvas" data-option="{ &quot;width&quot;: 320, &quot;height&quot;: 180 }">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getCroppedCanvas&quot;, { width: 320, height: 180 })">
              320&times;180
            </span>
                </button>
            </div>

            <!-- Show the cropped image in modal -->
            <div class="modal fade docs-cropped" id="getCroppedCanvasModal" aria-hidden="true" aria-labelledby="getCroppedCanvasTitle" role="dialog" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title" id="getCroppedCanvasTitle">Cropped</h4>
                        </div>
                        <div class="modal-body"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                            <a class="btn btn-primary" id="download" download="cropped.png" href="javascript:void(0);">Download</a>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal -->

            <button type="button" class="btn btn-primary" data-method="getData" data-option data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getData&quot;)">
            Get Data
          </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="setData" data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setData&quot;, data)">
            Set Data
          </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="getContainerData" data-option data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getContainerData&quot;)">
            Get Container Data
          </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="getImageData" data-option data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getImageData&quot;)">
            Get Image Data
          </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="getCanvasData" data-option data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getCanvasData&quot;)">
            Get Canvas Data
          </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="setCanvasData" data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setCanvasData&quot;, data)">
            Set Canvas Data
          </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="getCropBoxData" data-option data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;getCropBoxData&quot;)">
            Get Crop Box Data
          </span>
            </button>
            <button type="button" class="btn btn-primary" data-method="setCropBoxData" data-target="#putData">
          <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setCropBoxData&quot;, data)">
            Set Crop Box Data
          </span>
            </button>
            <input type="text" class="form-control" id="putData" placeholder="Get data to here or set data with this value">

        </div><!-- /.docs-buttons -->

        <div class="col-md-3 docs-toggles">
            <!-- <h3 class="page-header">Toggles:</h3> -->
            <div class="btn-group btn-group-justified" data-toggle="buttons">
                <label class="btn btn-primary active" data-method="setAspectRatio" data-option="1.7777777777777777" title="Set Aspect Ratio">
                    <input type="radio" class="sr-only" id="aspestRatio1" name="aspestRatio" value="1.7777777777777777">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setAspectRatio&quot;, 16 / 9)">
              16:9
            </span>
                </label>
                <label class="btn btn-primary" data-method="setAspectRatio" data-option="1.3333333333333333" title="Set Aspect Ratio">
                    <input type="radio" class="sr-only" id="aspestRatio2" name="aspestRatio" value="1.3333333333333333">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setAspectRatio&quot;, 4 / 3)">
              4:3
            </span>
                </label>
                <label class="btn btn-primary" data-method="setAspectRatio" data-option="1" title="Set Aspect Ratio">
                    <input type="radio" class="sr-only" id="aspestRatio3" name="aspestRatio" value="1">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setAspectRatio&quot;, 1 / 1)">
              1:1
            </span>
                </label>
                <label class="btn btn-primary" data-method="setAspectRatio" data-option="0.6666666666666666" title="Set Aspect Ratio">
                    <input type="radio" class="sr-only" id="aspestRatio4" name="aspestRatio" value="0.6666666666666666">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setAspectRatio&quot;, 2 / 3)">
              2:3
            </span>
                </label>
                <label class="btn btn-primary" data-method="setAspectRatio" data-option="NaN" title="Set Aspect Ratio">
                    <input type="radio" class="sr-only" id="aspestRatio5" name="aspestRatio" value="NaN">
            <span class="docs-tooltip" data-toggle="tooltip" title="$().cropper(&quot;setAspectRatio&quot;, NaN)">
              Free
            </span>
                </label>
            </div>

            <div class="dropdown dropup docs-options">
                <button type="button" class="btn btn-primary btn-block btn-fb"  >
                    Facebook
                </button>


                <button type="button" class="btn btn-primary btn-block btn-submit"   >
                    Submit
                </button>
                <button type="button" class="btn btn-primary btn-block dropdown-toggle" id="toggleOptions" data-toggle="dropdown" aria-expanded="true">
                    Toggle Options
                    <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" aria-labelledby="toggleOptions" role="menu">
                    <li role="presentation">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="option" value="strict" checked>
                            strict
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="option" value="responsive" checked>
                            responsive
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="option" value="checkImageOrigin" checked>
                            checkImageOrigin
                        </label>
                    </li>

                    <li role="presentation">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="option" value="modal" checked>
                            modal
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="option" value="guides" checked>
                            guides
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="option" value="center" checked>
                            center
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="option" value="highlight" checked>
                            highlight
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="option" value="background" checked>
                            background
                        </label>
                    </li>

                    <li role="presentation">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="option" value="autoCrop" checked>
                            autoCrop
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="option" value="dragCrop" checked>
                            dragCrop
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="option" value="movable" checked>
                            movable
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="option" value="rotatable" checked>
                            rotatable
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="option" value="scalable" checked>
                            scalable
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="option" value="zoomable" checked>
                            zoomable
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="option" value="mouseWheelZoom" checked>
                            mouseWheelZoom
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="option" value="touchDragZoom" checked>
                            touchDragZoom
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="option" value="cropBoxMovable" checked>
                            cropBoxMovable
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="option" value="cropBoxResizable" checked>
                            cropBoxResizable
                        </label>
                    </li>
                    <li role="presentation">
                        <label class="checkbox-inline">
                            <input type="checkbox" name="option" value="doubleClickToggle" checked>
                            doubleClickToggle
                        </label>
                    </li>
                </ul>
            </div><!-- /.dropdown -->
        </div><!-- /.docs-toggles -->
    </div>
</div>

<!-- Scripts -->
<script src="{{url('scripts/cropper/assets/js/jquery.min.js')}}"></script>
<script src="{{url('scripts/cropper/assets/js/tooltip.min.js')}}"></script>
<script src="{{url('scripts/cropper/assets/js/bootstrap.min.js')}}"></script>
<script src="{{url('scripts/cropper/dist/cropper.js')}}"></script>
<script src="{{url('scripts/cropper/js/main.js')}}"></script>
<script>
        $(function () {

            $('.btn-fb').click(function() {
                var url = 'https://fbcdn-sphotos-e-a.akamaihd.net/hphotos-ak-xft1/t31.0-8/s720x720/10293823_712694978774432_7532230261156398949_o.jpg' ;
//                $('#image-cropper').attr("src",url);
                $('#inputImage').replaceWith(url);



            });


            $('.btn-submit').click(function() {
                var imageData = $('#image-cropper').cropper('getCroppedCanvas').toDataURL("image/jpeg",100) ;
                console.log(imageData);
                $('.hidden-image-data').val(imageData);

            });
        });






</script>
</body>
</html>
