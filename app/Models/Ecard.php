<?php namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use DB;
class Ecard extends Model {

    protected $table = 'upload_pic';
    public $timestamps = true ;
    protected $fillable = array(
        'name',
        'gen_pic_path',
        'gen_pic_name',
        'frame_img_number',
        'status'
    );


     public static function createData($make_img_gen_path,$img_ori_name,$name,$frame_img){
         $rs = static::where('gen_pic_name', '=', $img_ori_name)->first();
         if(is_null($rs)) {
             return static::create( [
                 'gen_pic_path'     => $make_img_gen_path,
                 'gen_pic_name'      => $img_ori_name,
                 'name' => $name,
                 'frame_img_number'=>$frame_img
             ]);
         } else {
             return false;
         }
     }

    public static function getPaginatedData($page)
    {
        $data = static::select('id','gen_pic_path','gen_pic_name')
            ->where('status','=',1)
            ->orderBy('id','DESC')
            ->paginate($page);
        return $data;
    }

    public static function getSearchData($txt)
    {

        $data = static::whereStatus(1)->where('name', 'LIKE', '%'.$txt.'%')->get();
        return $data;
    }

    public static function getSelectData($id)
    {
        $data = static::select('id','gen_pic_path','gen_pic_name')
            ->whereIdAndStatus($id,1)
            ->get();
        return $data;
    }




}