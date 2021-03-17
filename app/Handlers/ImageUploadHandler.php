<?php
namespace App\Handlers;

use Illuminate\Support\Str;

class ImageUploadHandler
{
    //允许上传的格式
    protected $allowtext = ['jpg','png','gif','jpeg'];

    //
    public function save($file,$folder,$file_prefix){
        // 构建存储的文件夹规则，值如：uploads/images/avatars/201709/21/
        $file_folder = "uploads/images/".$folder."/".date('Ym/d',time());

        // 文件具体存储的物理路径，`public_path()` 获取的是 `public` 文件夹的物理路径。
        // 值如：/home/vagrant/Code/larabbs/public/uploads/images/avatars/201709/21/
        $upload_path = public_path().'/'.$file_folder;

        // 获取文件的后缀名，因图片从剪贴板里黏贴时后缀名为空，所以此处确保后缀一直存在
        $extension = strtolower($file->getClientOriginalExtension()) ?: 'png';

        // 拼接文件名，加前缀是为了增加辨析度，前缀可以是相关数据模型的 ID 
        // 值如：1_1493521050_7BVc9v9ujP.png
        $file_name = $file_prefix . '_' .time(). '_'. Str::random(10) .'.'.$extension;

        // 验证文件后缀合法性
        if(!in_array($extension,$this->allowtext)){
            return false;
        }

        //移动文件到指定路径
        $file->move($upload_path,$file_name);

        return [
            'path' => config('app.url') . "/$file_folder/$file_name"
        ];
    }
}
