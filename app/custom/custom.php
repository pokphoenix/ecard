<?php namespace App\custom;



class custom  {




    public static function create_image($request){
        $mode = $request->m ;
        $fbuid = $request->fbuid ;
        $text_bless = $request->text_bless ;

        echo "mode : $mode<BR>" ;
        echo "fbuid : $fbuid<BR>" ;

        $folder_date 					= date("Ym") ;
        if ($mode=="desc"){
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
        }else{
            $urlimage = "https://graph.facebook.com/$fbuid/picture?width=320&height=320" ;
            $img_ori_name = "$fbuid.jpg" ;
//			copy($urlimage,"/path/on/server/img.jpg");
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








        $transparent = imagecolorallocatealpha($gen_image, 255,255,255, 127);
        $white = imagecolorallocate($gen_image, 255, 255, 255);
        $font_path = "fonts/PSL-Omyim.TTF";
        $font_angle = 0 ;
        $font_size = "26" ;
        $font_width = strlen($text_bless) ;
        if($font_width>55){
            $font_size = '10';
        }elseif($font_width>50){
            $font_size = '12';
        }elseif($font_width>45){
            $font_size = '14';
        }elseif($font_width>40){
            $font_size = '16';
        }elseif($font_width>35){
            $font_size = '18';
        }elseif($font_width>30){
            $font_size = '20';
        }elseif($font_width>25){
            $font_size = '22';
        }elseif($font_width>20){
            $font_size = '24';
        }
        echo "font_width : $font_width <BR>" ;
        echo "font_size : $font_size <BR>" ;



        $font_layout_width = 200 ;
        $font_layout_height = 30 ;

        //--- สร้างแถบข้อความขึ้นมา
        $image = imagecreatetruecolor ($font_layout_width,$font_layout_height);
        $white = imagecolorallocate ($image,255,255,255);
        $black = imagecolorallocate ($image,0,0,0);
        imagefill($image,0,0,$black);
        //--- คำนวนขนาดตัวอักษร
        $bbox = imagettfbbox($font_size,$font_angle,$font_path, $text_bless);
        $text_width = $bbox[2]-$bbox[0];
        $text_height = $bbox[6]-$bbox[0];
        //--- ทำให้ ตัวอักษรอยู่ตรงกลาง แถบข้อความ
        $posx = ceil(($font_layout_width-$text_width)/2);
        $posy = ceil(($font_layout_height-$text_height)/2)+2;
        //$posy = $font_layout_height-$text_height;   //--- ตัวอักษรอยู่ขอบล่าง

        imagealphablending($gen_image,true);
        //--- ใส่ข้อความให้รูป
        //imagettftext( image , font size , angle(องศาของตัวอักษร) , ตำแหน่ง x , ตำแหน่ง y  , color , fontfile , text );
        imagettftext($image, $font_size, $font_angle , $posx, $posy, $white, $font_path, $text_bless);
        //imagepng ($image);
        echo "img_size : $img_width x $img_height<BR>" ;
        echo "text_size : $text_width x $text_height<BR>" ;
        echo "posxy : $posx x $posy <BR>" ;

        imagecopymerge($gen_image, $image, 0, 170, 0, 0, 200, 200, 100);


        if ($img_type==1){
            $status_gen_img =  imagegif($gen_image, "$gen_url", 100) ;
        }elseif ($img_type==2){
            $status_gen_img =  imagejpeg($gen_image, "$gen_url", 100) ;
        }elseif ($img_type==3){
            $status_gen_img =  imagepng($gen_image, "$gen_url", 9) ;
        }

        //imagedestroy($gen_image);
        imagedestroy($gen_image);
        imagedestroy($image);
        if (file_exists($urlimage)) {
            //---  ขั้นตอนการลบรูป original ออกจาก server
            chmod($urlimage, 0644);
            unlink($urlimage);
            custom::rrmdir("upload/ecard/original/$folder_date/");
            custom::rrmdir("upload/ecard/original/");
        }
        $rs  =  $make_img_gen_path.",".$img_ori_name ;

        return  $rs ;
    }

    public static function rrmdir($dir) {
        if (is_dir($dir)) {
            $objects = scandir($dir);
            foreach ($objects as $object) {
                if ($object != "." && $object != "..") {
                    if (filetype($dir."/".$object) == "dir") rrmdir($dir."/".$object); else unlink($dir."/".$object);
                }
            }
            reset($objects);
            rmdir($dir);
        }
    }
}