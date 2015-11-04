<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ecard extends Model {

    protected $table = 'upload_pic';
    public $timestamps = true ;
    protected $fillable = array(
        'gen_pic_path',
        'gen_pic_name',
        'status'
    );


     public static function createData($make_img_gen_path,$img_ori_name){
         $rs = static::where('gen_pic_name', '=', $img_ori_name)->first();
         if(is_null($rs)) {
             return static::create( [
                 'gen_pic_path'     => $make_img_gen_path,
                 'gen_pic_name'      => $img_ori_name
             ]);
         } else {
             return false;
         }
     }




}