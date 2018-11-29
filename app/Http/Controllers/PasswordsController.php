<?php

namespace App\Http\Controllers;

use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

class PasswordsController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getRemind()
    {
        return view('passwords.remind');
    }

    public function postRemind(Request $request)
    {
        $this->validate($request, ['email' => 'required|email|exists:users']);

        $email = $request->get('email');
        $token = str_random(64);

        $user = DB::table('password_resets')->insert([
            'email' => $email,
            'token' => $token,
            'created_at' => Carbon::now()->toDateTimeString()
        ]);

        Mail::send('emails.passwords.reset', compact('token'), function ($message) use ($email) {
            $message->to($email);
            $message->subject(
                sprintf('[%s] 비밀번호 초기화 메일입니다', config('app.name'))
            );
        });

        return redirect('posts')->with('flash_message', '비밀번호 변경 이메일을 발신하였습니다');
    }

    public function getReset($token = null)
    {
        return view('passwords.reset', compact('token'));
    }

    public function postReset(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users',
            'password' => 'required|confirmed',
            'token' => 'required'
        ]);

        $token = $request->get('token');

        if(! DB::table('password_resets')->whereToken($token)->first()){
            return back()->withInput()->with('flash_message','URL이 정확하지 않습니다');
        };

        User::whereEmail($request->input('email'))->first()->update([
            'password'=>bcrypt($request->input('password'))
        ]);

        DB::table('password_resets')->whereToken($token)->delete();

        return redirect('posts')->with('flash_message','비밀번호 변경이 완료되었습니다. 새로운 비밀번호로 로그인 해주세요');
    }
}
