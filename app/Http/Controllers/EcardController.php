<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Ecard ;
use App\custom\custom ;

class EcardController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders your application's "dashboard" for users that
	| are authenticated. Of course, you are free to change or remove the
	| controller as you wish. It is just here to get your app started!
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
//	public function __construct()
//	{
//		$this->middleware('auth');
//	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		return view('event.ecard');
	}

	public function postIndex(Request $request){

		$gen_url =  custom::create_image($request);

		list($make_img_gen_path,$img_ori_name) = explode(",",$gen_url);

		echo "<img src='$make_img_gen_path$img_ori_name' >" . '<br>';


		$create =  Ecard::createData($make_img_gen_path,$img_ori_name) ;
		if(!$create){
			dd('ข้อมูลซ้ำ');
		}



		exit();
	}

	public function postAjax(Request $request){
		$mode = $request->m ;
		$fbuid = $request->fbuid ;
		$text_bless = $request->text_bless ;
		$text_bless_2 = $request->text_bless_2 ;
		$folder_date 					= date("Ym") ;
//		if ($mode=="desc"){
			$image_data = $request->image_data ;
			if (empty($image_data)){
				dd('ไม่มีการอัพโหลดรูป');
			}
			list($type, $exp) = explode(';', $image_data);
			list(, $data)      = explode(',', $exp);
			$data = base64_decode($data);
			$img_ori_path 					= "/upload/ecard/original/$folder_date/" ;
			$make_img_ori_path 				= "upload/ecard/original/$folder_date/" ;
//			$img_ori_name  					= time()."_".$_FILES['uploadfiles']['name'];
			$img_ori_name  					= time().".jpg" ;
			if(!is_dir($make_img_ori_path)) {
				mkdir($make_img_ori_path, 0777 , true) ;
			}
			$urlimage						= $make_img_ori_path.$img_ori_name ;
			file_put_contents($urlimage, $data);
//		}else{
//			$urlimage = "https://graph.facebook.com/$fbuid/picture?width=200&height=200" ;
//			$img_ori_name = "$fbuid.jpg" ;
////			copy($urlimage,"/path/on/server/img.jpg");
//		}

		$make_img_gen_path 				= "upload/ecard/generate/$folder_date/" ;
		if(!is_dir($make_img_gen_path)) {
			mkdir($make_img_gen_path, 0777 , true) ;
		}
		$gen_url = $make_img_gen_path.$img_ori_name ;




		list($img_width, $img_height,$img_type) = getimagesize($urlimage);
		//img_type 1 =  GIF ,
		//img_type 2 =  JPG ,
		//img_type 3 =  PNG ,
		if($img_type!=1&&$img_type!=2&&$img_type!=3){
			echo "error" ; exit();
		}
		if ($img_type==1){
			$gen_image = imagecreatefromgif($urlimage);
			$background = imagecolorallocate($gen_image, 0, 0, 0);
			imagecolortransparent($gen_image, $background);

		}elseif ($img_type==2){

			$gen_image = imagecreatefromjpeg($urlimage);

		}elseif ($img_type==3){

			$gen_image = imagecreatefrompng($urlimage);
			// removing the black from the placeholder
			$background = imagecolorallocate($gen_image, 0, 0, 0);
			imagecolortransparent($gen_image, $background);
			imagealphablending($gen_image, false);
			imagesavealpha($gen_image, true);
		}
		    //--- resize รูปภาพ
			$newwidth=415;
			$newheight=($img_height/$img_width)*$newwidth;
			$images_fin = imagecreatetruecolor($newwidth, $newheight);
			imagecopyresampled ($images_fin, $gen_image, 0, 0, 0, 0, $newwidth, $newheight, $img_width, $img_height);




		$frame_image = imagecreatefrompng('images/ecard/201511_frame_1.png');
		$background = imagecolorallocate($frame_image, 0, 0, 0);
		imagecolortransparent($frame_image, $background);
		imagealphablending($frame_image, false);
		imagesavealpha($frame_image, true);

		//---- resize กรอบที่ใส่ข้อความเรียบร้อยแล้วลงมา
//		$newwidth=600;
//		$newheight=(1200/1200)*$newwidth;
//		$tmp=imagecreatetruecolor($newwidth,$newheight);
//		$frame_image_fin = imagecreatetruecolor($newwidth, $newheight);
//		imagecopyresampled ($frame_image_fin, $frame_image, 0, 0, 0, 0, $newwidth, $newheight, 1200, 1200);
//		$background = imagecolorallocate($frame_image_fin, 0, 0, 0);
//		imagecolortransparent($frame_image_fin, $background);
//		imagealphablending($frame_image_fin, false);
//		imagesavealpha($frame_image_fin, true);

		$nWidth = 600 ;
		$nHeight = 600 ;

		$new_frame_Img = imagecreatetruecolor($nWidth, $nHeight);
		imagealphablending($new_frame_Img, false);
		imagesavealpha($new_frame_Img,true);
		$transparent = imagecolorallocatealpha($new_frame_Img, 255, 255, 255, 127);
		imagefilledrectangle($new_frame_Img, 0, 0, $nWidth, $nHeight, $transparent);
		imagecopyresampled($new_frame_Img, $frame_image, 0, 0, 0, 0, $nWidth, $nHeight, 1200, 1200);




		$font_path = "fonts/SukhumvitSet.ttc";
		$font_angle = 0 ;
		$font_size_1 = "22" ;
		$font_size_2 = "20" ;
		$font_width = strlen($text_bless) ;
//		if($font_width>55){
//			$font_size = '10';
//		}elseif($font_width>50){
//			$font_size = '12';
//		}elseif($font_width>45){
//			$font_size = '14';
//		}elseif($font_width>40){
//			$font_size = '16';
//		}elseif($font_width>35){
//			$font_size = '18';
//		}elseif($font_width>30){
//			$font_size = '20';
//		}elseif($font_width>25){
//			$font_size = '22';
//		}elseif($font_width>20){
//			$font_size = '24';
//		}
		$font_layout_1_width = 200 ;
		$font_layout_1_height = 70 ;

		//--- สร้างแถบข้อความขึ้นมา
		//$image = imagecreatetruecolor ($font_layout_1_width,$font_layout_1_height);
		$text_2_color_white = imagecolorallocate ($new_frame_Img,255,255,255);
		$text_1_color_black = imagecolorallocate ($new_frame_Img,0,0,0);
		//imagefill($image,0,0,$black);
		//--- คำนวนขนาดตัวอักษร
//		$bbox = imagettfbbox($font_size,$font_angle,$font_path, $text_bless);
//		$text_width = $bbox[2]-$bbox[0];
//		$text_height = $bbox[6]-$bbox[0];
//		//--- ทำให้ ตัวอักษรอยู่ตรงกลาง แถบข้อความ
//		$posx = ceil(($font_layout_1_width-$text_width)/2);
//		$posy = ceil(($font_layout_1_height-$text_height)/2)+2;
		//$posy = $font_layout_height-$text_height;   //--- ตัวอักษรอยู่ขอบล่าง

		imagealphablending($new_frame_Img,true);
		//--- ใส่ข้อความให้รูป
		//imagettftext( image , font size , angle(องศาของตัวอักษร) , ตำแหน่ง x , ตำแหน่ง y  , color , fontfile , text );
		imagettftext($new_frame_Img, $font_size_1, $font_angle , 102, 485, $text_1_color_black, $font_path, $text_bless);
		imagettftext($new_frame_Img, $font_size_2, $font_angle , 102, 525, $text_2_color_white, $font_path, $text_bless_2);





		//imagepng ($image);
//		imagealphablending($gen_image,true);
//		imagecopymerge($frame_image , $gen_image, 450, 400, 0, 0, 298, 298, 0);

		$src_w = 600 ;
		$src_h = 600 ;
		// creating a cut resource
		$cut = imagecreatetruecolor($src_w, $src_h);

		// copying relevant section from watermark to the cut resource
		imagecopy($cut, $images_fin, 95, 75, 0, 0, 415, 415);
		// copying relevant section from background to the cut resource
		imagecopy($cut, $new_frame_Img, 0, 0, 0, 0, $src_w, $src_h);
		imagepng($cut, "$gen_url", 9) ;
		imagedestroy($gen_image);
		imagedestroy($new_frame_Img);
		imagedestroy($frame_image);
		imagedestroy($cut);
		imagedestroy($images_fin);

		$rs  =  $make_img_gen_path.$img_ori_name ;

		return  $rs ;

		// insert cut resource to destination image
		//imagecopymerge($frame_image, $cut, 0, 0, 0, 0, $src_w, $src_h, 100);





//		if ($img_type==1){
//			$status_gen_img =  imagegif($gen_image, "$gen_url", 100) ;
//		}elseif ($img_type==2){
//			$status_gen_img =  imagejpeg($gen_image, "$gen_url", 100) ;
//		}elseif ($img_type==3){
//			$status_gen_img =  imagepng($gen_image, "$gen_url", 9) ;
//		}

		//imagedestroy($gen_image);
		imagedestroy($gen_image);
//		imagedestroy($image);
		imagedestroy($frame_image);
		imagedestroy($cut);
		if (file_exists($urlimage)) {
			//---  ขั้นตอนการลบรูป original ออกจาก server
//			chmod($urlimage, 0644);
//			unlink($urlimage);
//			custom::rrmdir("upload/ecard/original/$folder_date/");
//			custom::rrmdir("upload/ecard/original/");
		}
		$rs  =  $make_img_gen_path.$img_ori_name ;

		return  $rs ;
	}



	public function postFacebook(Request $request){
		//		$img_type   = exif_imagetype($_FILES['uploadfiles']['tmp_name']);
//		if($img_type!=1&&$img_type!=2&&$img_type!=3){
//			echo "error" ; exit();
//		}
		$mode = $request->m ;
		$fbuid = $request->fbuid ;
		$text_bless = $request->text_bless ;
		$folder_date 					= date("Ym") ;
		echo "mode : $mode<BR>" ;
		echo "fbuid : $fbuid<BR>" ;





		//--- Crop image
		$x = $request->x ;
		$y = $request->y ;
		$w = $request->w ;
		$h = $request->h ;

		echo "x : $x<BR>" ;	   //--- ตำแหน่ง x ที่เริ่ม crop
		echo "y : $y<BR>" ;	   //--- ตำแหน่ง y ที่เริ่ม crop
		echo "w : $w<BR>" ;    //--- ความกว้างของ crop
		echo "h : $h<BR>" ;		//--- ความสูงของ crop






		if ($mode=="desc"){
			$img_ori_path = "" ; $img_ori_name = "" ; $status_img_ori = 0 ;
			### เก็บ Original image เข้า server เพื่อเรียกใช้สำหรับสร้างไฟล์ใหม่ ###
			if(file_exists($_FILES['uploadfiles']['tmp_name']) || is_uploaded_file($_FILES['uploadfiles']['tmp_name'])) {
				$img_ori_path 					= "/upload/ecard/original/$folder_date/" ;
				$make_img_ori_path 				= "upload/ecard/original/$folder_date/" ;
//			$img_ori_name  					= time()."_".$_FILES['uploadfiles']['name'];
				$img_ori_name  					= time()."_".$_FILES['uploadfiles']['name'];
				if(!is_dir($make_img_ori_path)) {
					mkdir($make_img_ori_path, 0777 , true) ;
				}
				$urlimage						= $make_img_ori_path.$img_ori_name ;
				$move							= move_uploaded_file($_FILES['uploadfiles']['tmp_name'], $urlimage);
				if(!$move)
				{
					echo ("การอัพโหลดรูปผิดพลาด!!! ") ;
				}
				$status_img_ori = 1 ;
			}
		}else{
			$urlimage = "https://graph.facebook.com/$fbuid/picture?width=320&height=320" ;
			$img_ori_name = "$fbuid.jpg" ;
//			copy($urlimage,"/path/on/server/img.jpg");
		}






		function create_image($urlimage,$text_bless,$gen_url,$x,$y,$w,$h){

			list($img_width, $img_height,$img_type) = getimagesize($urlimage);
			//img_type 1 =  GIF ,
			//img_type 2 =  JPG ,
			//img_type 3 =  PNG ,
			if($img_type!=1&&$img_type!=2&&$img_type!=3){
				echo "error" ; exit();
			}
			echo "Item Type : $img_type<BR>";

			if ($img_type==1){
				$gen_image = imagecreatefromgif($urlimage);
				$background = imagecolorallocate($gen_image, 0, 0, 0);
				imagecolortransparent($gen_image, $background);

			}elseif ($img_type==2){

				$gen_image = imagecreatefromjpeg($urlimage);

			}elseif ($img_type==3){

				$gen_image = imagecreatefrompng($urlimage);
				// removing the black from the placeholder
				$background = imagecolorallocate($gen_image, 0, 0, 0);
				imagecolortransparent($gen_image, $background);
				imagealphablending($gen_image, false);
				imagesavealpha($gen_image, true);
			}

			$targ_w = $targ_h = 100;
			$jpeg_quality = 90;


			$images_fin = imagecreatetruecolor( $targ_w, $targ_h );
			imagecopyresampled($images_fin,$gen_image,0,0,$x,$y,$targ_w,$targ_h,$w,$h);





//			//--- resize รูปภาพ
//			$newwidth=200;
//			$newheight=($img_height/$img_width)*$newwidth;
//			$tmp=imagecreatetruecolor($newwidth,$newheight);
//			$images_fin = imagecreatetruecolor($newwidth, $newheight);
//			imagecopyresampled ($images_fin, $gen_image, 0, 0, 0, 0, $newwidth, $newheight, $img_width, $img_height);
//			$images_fin = $gen_image ;
			$transparent = imagecolorallocatealpha($images_fin, 255,255,255, 127);
			$white = imagecolorallocate($images_fin, 255, 255, 255);
			$font_path = "fonts/PSL-Omyim.TTF";
			$font_size = "26" ;
			$font_angle = 0 ;

			//---- คำนวนขนาดตัวอักษร
			$bbox = imagettfbbox($font_size,$font_angle,$font_path, $text_bless);
			$text_width = $bbox[2]-$bbox[0];
			$text_height = $bbox[6]-$bbox[0];
			$posx = ceil(($img_width-$text_width)/2);
			$posy = ceil(($img_height-$text_height)/2);
			$posy = $img_height-$text_height-10;    //---  ตั้งค่าให้ข้อความอยุ่ตรง footer ของรูป
			echo "img_size : $img_width x $img_height<BR>" ;
			echo "text_size : $text_width x $text_height<BR>" ;
			echo "posxy : $posx x $posy <BR>" ;

			imagealphablending($images_fin,true);

			//--- ใส่ข้อความให้รูป
			//imagettftext( image , font size , angle(องศาของตัวอักษร) , ตำแหน่ง x , ตำแหน่ง y  , color , fontfile , text );
			imagettftext($images_fin, $font_size, $font_angle , $posx, $posy, $white, $font_path, $text_bless);


			if ($img_type==1){
				$status_gen_img =  imagegif($images_fin, "$gen_url", 100) ;
			}elseif ($img_type==2){
				$status_gen_img =  imagejpeg($images_fin, "$gen_url", 100) ;
			}elseif ($img_type==3){
				$status_gen_img =  imagepng($images_fin, "$gen_url", 9) ;
			}

			//imagedestroy($gen_image);
			imagedestroy($images_fin);
			return $status_gen_img ;
		}

		$make_img_gen_path 				= "upload/ecard/generate/$folder_date/" ;
		if(!is_dir($make_img_gen_path)) {
			mkdir($make_img_gen_path, 0777 , true) ;
		}
		$gen_url = $make_img_gen_path.$img_ori_name ;
		$gen_img =  create_image($urlimage,$text_bless,$gen_url,$x,$y,$w,$h);
		echo "<img src='$gen_url' >" . '<br>';

		if (file_exists($urlimage)) {

// last resort setting
// chmod($oldPicture, 0777);
			chmod($urlimage, 0644);
			unlink($urlimage);
			rmdir("upload/ecard/original/$folder_date/");
			rmdir("upload/ecard/original/");
		}

//		if ($mode=="desc") {
//			//---  ขั้นตอนการลบรูป original ออกจาก server
//			unlink($urlimage);
//
//		}
		exit();

	}


	public function copperIndex()
	{
		return view('event.ecard_copper');
	}

	public function postAjaxCopper(Request $request)
	{

		dd($request) ;

	}

}
