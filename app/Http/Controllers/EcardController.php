<?php namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Models\Ecard ;
//use App\custom\custom ;
use Ecad ;

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
////		$this->middleware('auth');
//		header("Access-Control-Allow-Origin: *");
//
//	}

	/**
	 * Show the application dashboard to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
//		dd($_SERVER['HTTP_USER_AGENT']);
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

		$name = $request->name ;
		$text_rest = $request->text_rest ;
		$frame_img = $request->frame_image ;

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
		$filesize = file_put_contents($urlimage, $data);
		if ($filesize>5242880) { echo "error" ; exit(); }





		$make_img_fb_path 				= "upload/ecard/fb/$folder_date/" ;
		if(!is_dir($make_img_fb_path)) {
			mkdir($make_img_fb_path, 0777 , true) ;
		}

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



		$frame_img_text =   "images/ecard/201511_frame_".$frame_img."_old.png" ;

		$frame_image = imagecreatefrompng($frame_img_text);
		$background = imagecolorallocate($frame_image, 0, 0, 0);
		imagecolortransparent($frame_image, $background);
		imagealphablending($frame_image, false);
		imagesavealpha($frame_image, true);

		$nWidth = 600 ;
		$nHeight = 600 ;

		$new_frame_Img = imagecreatetruecolor($nWidth, $nHeight);
		imagealphablending($new_frame_Img, false);
		imagesavealpha($new_frame_Img,true);
		$transparent = imagecolorallocatealpha($new_frame_Img, 255, 255, 255, 127);
		imagefilledrectangle($new_frame_Img, 0, 0, $nWidth, $nHeight, $transparent);
		imagecopyresampled($new_frame_Img, $frame_image, 0, 0, 0, 0, $nWidth, $nHeight, 1200, 1200);




		//$font_path = "fonts/SukhumvitSet_3.ttf";

		$font_path =  "memoprint/fonts/quark/quark-lightquark.ttf" ;
		$font_angle = 0 ;
		$font_size_1 = "22" ;
		$font_size_2 = "20" ;
		$font_width = strlen($name) ;

		//--- สร้างแถบข้อความขึ้นมา
		//$image = imagecreatetruecolor ($font_layout_1_width,$font_layout_1_height);
		$text_3_color_orange = imagecolorallocate ($new_frame_Img,243,160,0);
		$text_2_color_white = imagecolorallocate ($new_frame_Img,255,255,255);
		$text_1_color_black = imagecolorallocate ($new_frame_Img,0,0,0);
		imagealphablending($new_frame_Img,true);
		//--- ใส่ข้อความให้รูป
		$name = Ecad::substr($name,20) ;   //--- ปัญหา ภาษาไทย จำนวนตัวอักษร * 3
		$text_rest = Ecad::substr($text_rest,33) ;

		//imagettftext( image , font size , angle(องศาของตัวอักษร) , ตำแหน่ง x , ตำแหน่ง y  , color , fontfile , text );
		imagettftext($new_frame_Img, $font_size_1, $font_angle , 122, 485, $text_1_color_black, $font_path, $name);
		imagettftext($new_frame_Img, $font_size_2, $font_angle , 122, 525, $text_2_color_white, $font_path, $text_rest);
		imagettftext($new_frame_Img, $font_size_2, $font_angle , 122, 555, $text_3_color_orange, $font_path, '#keepmemoryintime');





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




		$sharefbimg = $make_img_fb_path.$img_ori_name ;
		//--- resize รูปภาพ สำหรับ share fb
		$nw2=315;
		$nh2=($img_height/$img_width)*$nw2;
		$img_share_fb = imagecreatetruecolor($nw2, $nh2);
		imagecopyresampled ($img_share_fb, $cut, 0, 0, 0, 0, $nw2, $nh2, $src_w, $src_h);

		$img_logo = imagecreatefromjpeg('images/ecard_main/fb-share-background.jpg');

		imagecopymerge($img_logo, $img_share_fb, 143, 0, 0, 0, $nw2, $nh2, 100);

		imagejpeg($cut, $gen_url, 100) ;
		imagejpeg($img_logo, $sharefbimg, 100) ;
		imagedestroy($gen_image);
		imagedestroy($new_frame_Img);
		imagedestroy($frame_image);
		imagedestroy($cut);
		imagedestroy($images_fin);
		imagedestroy($img_logo);
		if (file_exists($urlimage)) {
			//---  ขั้นตอนการลบรูป original ออกจาก server
			chmod($urlimage, 0644);
			unlink($urlimage);
			Ecad::rrmdir("upload/ecard/original/$folder_date/");
			Ecad::rrmdir("upload/ecard/original/");
		}
		$rs  =  $sharefbimg ;

		$create =  Ecard::createData($make_img_gen_path,$img_ori_name,$name,$frame_img) ;
		if(!$create){
			//--- ถ้าซ้ำจะทำยังไง
		}

		return  $rs ;


	}


	public function postAjaxBackup(Request $request){
		$mode = $request->m ;
		$fbuid = $request->fbuid ;
		$name = $request->name ;
		$text_rest = $request->text_rest ;
		$frame_img = $request->frame_image ;

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
		$newwidth=600;
		$newheight=($img_height/$img_width)*$newwidth;
		$images_fin = imagecreatetruecolor($newwidth, $newheight);
		imagecopyresampled ($images_fin, $gen_image, 0, 0, 0, 0, $newwidth, $newheight, $img_width, $img_height);


		$frame_img_text =   "images/ecard/201511_frame_".$frame_img.".png" ;

		$frame_image = imagecreatefrompng($frame_img_text);
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




		$font_path = "fonts/SukhumvitSet_3.ttf";
		$font_angle = 0 ;
		$font_size_1 = "22" ;
		$font_size_2 = "20" ;
		$font_width = strlen($name) ;

		$font_layout_1_width = 200 ;
		$font_layout_1_height = 70 ;

		//--- สร้างแถบข้อความขึ้นมา
		//$image = imagecreatetruecolor ($font_layout_1_width,$font_layout_1_height);
		$text_3_color_orange = imagecolorallocate ($new_frame_Img,243,160,0);
		$text_2_color_white = imagecolorallocate ($new_frame_Img,255,255,255);
		$text_1_color_black = imagecolorallocate ($new_frame_Img,0,0,0);
		//imagefill($image,0,0,$black);
		//--- คำนวนขนาดตัวอักษร
//		$bbox = imagettfbbox($font_size,$font_angle,$font_path, $name);
//		$text_width = $bbox[2]-$bbox[0];
//		$text_height = $bbox[6]-$bbox[0];
//		//--- ทำให้ ตัวอักษรอยู่ตรงกลาง แถบข้อความ
//		$posx = ceil(($font_layout_1_width-$text_width)/2);
//		$posy = ceil(($font_layout_1_height-$text_height)/2)+2;
		//$posy = $font_layout_height-$text_height;   //--- ตัวอักษรอยู่ขอบล่าง

		imagealphablending($new_frame_Img,true);
		//--- ใส่ข้อความให้รูป
		$name = Ecad::substr($name,20) ;
		$text_rest = Ecad::substr($text_rest,30) ;
		//imagettftext( image , font size , angle(องศาของตัวอักษร) , ตำแหน่ง x , ตำแหน่ง y  , color , fontfile , text );
		imagettftext($new_frame_Img, $font_size_1, $font_angle , 102, 485, $text_1_color_black, $font_path, $name);
		imagettftext($new_frame_Img, $font_size_2, $font_angle , 102, 525, $text_2_color_white, $font_path, $text_rest);
		imagettftext($new_frame_Img, $font_size_2, $font_angle , 102, 555, $text_3_color_orange, $font_path, '#keepmemoryintime');





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
		if (file_exists($urlimage)) {
			//---  ขั้นตอนการลบรูป original ออกจาก server
			chmod($urlimage, 0644);
			unlink($urlimage);
			Ecad::rrmdir("upload/ecard/original/$folder_date/");
			Ecad::rrmdir("upload/ecard/original/");
		}
		$rs  =  $make_img_gen_path.$img_ori_name ;

		$create =  Ecard::createData($make_img_gen_path,$img_ori_name,$name,$frame_img) ;
		if(!$create){
			//--- ถ้าซ้ำจะทำยังไง
		}

		return  $rs ;


//		if ($img_type==1){
//			$status_gen_img =  imagegif($gen_image, "$gen_url", 100) ;
//		}elseif ($img_type==2){
//			$status_gen_img =  imagejpeg($gen_image, "$gen_url", 100) ;
//		}elseif ($img_type==3){
//			$status_gen_img =  imagepng($gen_image, "$gen_url", 9) ;
//		}

	}

	public function postAjax_backup_html2canvas(Request $request){


		$name = $request->name ;
		$frame_img = $request->frame_image ;
		$folder_date 					= date("Ym") ;
		$image_data = $request->image_data ;
		if (empty($image_data)){
			dd('ไม่มีการอัพโหลดรูป');
		}
		list($type, $exp) = explode(';', $image_data);
		list(, $data)      = explode(',', $exp);
		$data = base64_decode($data);
		$make_img_ori_path 				= "upload/ecard/original/$folder_date/" ;
		$img_ori_name  					= time().".jpg" ;
		if(!is_dir($make_img_ori_path)) {
			mkdir($make_img_ori_path, 0777 , true) ;
		}
		$urlimage						= $make_img_ori_path.$img_ori_name ;
		$filesize = file_put_contents($urlimage, $data);
		if ($filesize>5242880) { echo "error" ; exit(); }

		$make_img_gen_path 				= "upload/ecard/generate/$folder_date/" ;
		if(!is_dir($make_img_gen_path)) {
			mkdir($make_img_gen_path, 0777 , true) ;
		}

		$make_img_fb_path 				= "upload/ecard/fb/$folder_date/" ;
		if(!is_dir($make_img_fb_path)) {
			mkdir($make_img_fb_path, 0777 , true) ;
		}



		$gen_url = $make_img_gen_path.$img_ori_name ;
		$sharefbimg = $make_img_fb_path.$img_ori_name ;

		list($img_width, $img_height,$img_type) = getimagesize($urlimage);
		//img_type 1 =  GIF ,
		//img_type 2 =  JPG ,
		//img_type 3 =  PNG ,
		if($img_type!=1&&$img_type!=2&&$img_type!=3){
			echo "error" ; exit();
		}
		$gen_image = imagecreatefromjpeg($urlimage);
		//--- resize รูปภาพ
		$newwidth=600;
		$newheight=($img_height/$img_width)*$newwidth;
		$images_fin = imagecreatetruecolor($newwidth, $newheight);
		imagecopyresampled ($images_fin, $gen_image, 0, 0, 0, 0, $newwidth, $newheight, $img_width, $img_height);


		//--- resize รูปภาพ สำหรับ share fb
		$nw2=315;
		$nh2=($img_height/$img_width)*$nw2;
		$img_share_fb = imagecreatetruecolor($nw2, $nh2);
		imagecopyresampled ($img_share_fb, $gen_image, 0, 0, 0, 0, $nw2, $nh2, $img_width, $img_height);

		$img_logo = imagecreatefromjpeg('images/ecard_main/fb-share-background.jpg');
		// removing the black from the placeholder
//		$background = imagecolorallocate($img_logo, 0, 0, 0);
//		imagecolortransparent($img_logo, $background);
//		imagealphablending($img_logo, false);
//		imagesavealpha($img_logo, true);


//		//--- resize โลโก สำหรับ share fb
//		$img_logo_w = 887;
//		$img_logo_h = 679;
//		$nlgw=300;
//		$nlgh=($img_logo_h/$img_logo_w)*$nlgw;
//		$img_logo_share_fb = imagecreatetruecolor($nlgw, $nlgh);
//		imagecopyresampled ($img_logo_share_fb, $img_logo, 0, 0, 0, 0, $nlgw, $nlgh, $img_logo_w, $img_logo_h);


//		$src_w = 600 ;
//		$src_h = 315 ;
		// creating a cut resource
		//$cut = imagecreatetruecolor($src_w, $src_h);
//		$white = imagecolorallocate ($cut,255,255,255);
//		imagefill($cut, 0, 0, $white);


		// copying relevant section from watermark to the cut resource
//		imagecopy($cut, $img_share_fb, 150, 7, 0, 0, $nw2, $nh2);
		// copying relevant section from background to the cut resource
//		imagecopy($cut, $img_logo, 315, 0, 0, 0, 285, 315);
		//imagecopyresampled($img_logo, $img_share_fb, 150, 7, 0, 0, 300, 300, 600, 315);

		imagecopymerge($img_logo, $img_share_fb, 143, 0, 0, 0, $nw2, $nh2, 100);

		imagejpeg($images_fin, $gen_url, 100) ;
		imagejpeg($img_logo, $sharefbimg, 100) ;
		imagedestroy($images_fin);
		imagedestroy($img_logo);
		imagedestroy($img_share_fb);
//		$rs  =  $make_img_gen_path.$img_ori_name ;
//		return  $rs ;


//		imagejpeg($images_fin, "$gen_url", 100) ;
//		imagedestroy($images_fin);
		if (file_exists($urlimage)) {
			//---  ขั้นตอนการลบรูป original ออกจาก server
			chmod($urlimage, 0644);
			unlink($urlimage);
			Ecad::rrmdir("upload/ecard/original/$folder_date/");
			Ecad::rrmdir("upload/ecard/original/");
		}
//		$rs  =  $make_img_gen_path.$img_ori_name ;
		$rs  = $sharefbimg ;
		$create =  Ecard::createData($make_img_gen_path,$img_ori_name,$name,$frame_img) ;
		if(!$create){
			//--- ถ้าซ้ำจะทำยังไง
		}

		return  $rs ;
		exit();

	}

	public function gallery(){
		$data = Ecard::getPaginatedData(8);
		return ($data);
	}

	public function gallerySearch($txt){
		$txtsearch = addslashes($txt);

		$data = Ecard::getSearchData($txtsearch);
//		dd($data);
		return ($data);
	}

	public function gallerySelect($id){

		$chk = Ecad::chkformatNumber($id);
		if(!$chk){
			return "error" ;
		}
		$data = Ecard::getSelectData($id);
		return ($data);
	}



}
