<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest',['except'=>'destroy']);
    }

    public function returnBack($message)
    {
        return back()->withInput()->with('flash_message', $message);
    }

    public function create(){
        return view('users.formPartial.login');
    }

    public function store(Request $request){
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required|min:8'
        ]);

        if(! auth()->attempt($request->only('email','password'),$request->has('remember'))){
            return $this->returnBack('이메일 또는 비밀번호가 맞지 않습니다');
        };

//        아이디 활성화 체크
        if(!auth()->user()->activated){
            auth()->logout();

            return $this->returnBack('해당 메일을 확인해 주세요');
        }

//        auth 미들웨어가 작동해서 로그인 페이지로 들어왔을 때 intend 메서드는 사용자가 원래 접근하려고 했던 url로 리디렉션
        return redirect()->intended('posts')->with('flash_message',auth()->user()->name.' 님 환영합니다');
    }

    public function destroy(){
        auth()->logout();
        
        return $this->returnBack('로그아웃 되었습니다.');
    }
}
