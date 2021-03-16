<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

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
    public function update(Request $requset, User $user){
        return view('users.edit',compact('user'));
    }

    
}
