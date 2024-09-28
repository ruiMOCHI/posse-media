<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

class UserController extends Controller
{
    public function index()
    {
        return view('user.index');
    }
    public function destroyUser(User $user)
    {
        $user->delete(); // これでソフトデリートが実行されます
        return redirect()->route('articles.admin.users.listUser')->with('status', 'ユーザーを削除しました！');
    }
}
