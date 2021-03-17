<?php

namespace App\Http\Controllers;

use App\Handlers\ImageUploadHandler;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;

class UsersController extends Controller
{

    //个人页面
    public function show(User $user){
      
        return view('users.show',compact('user'));
    }

    //个人信息编辑页面
    public function edit(User $user){
        return view('users.edit',compact('user'));
    }

    //个人信息更新提交
    public function update(UserRequest $request, ImageUploadHandler $images, User $user){
        $data = $request->all();
        if($request->avatar){
            $result = $images->save($request->avatar,'avatar',$user->id);
            if($result){
                $data['avatar'] = $result['path'];
            }
        }
        $user->update($data);
        return redirect()->route('users.show',$user)->with('success','个人资料更新成功');
    }

    
}
