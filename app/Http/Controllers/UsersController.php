<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Mail;

class UsersController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function create()
    {
        return view('users.formPartial.register');
    }

    public function returnPosts($message)
    {
        return redirect('posts')->with('flash_message', $message);
    }

    public function store(Request $request)
    {
        $socialUser = User::wehreEmail($request->input('email'))->whereNull('password')->first();

        if($socialUser){
            return $this->updateSocialAccount($request, $socialUser);
        };

        return $this->createNativeAccount($request);

    }

    public function confirm($code)
    {
        $user = User::whereConfirmCode($code)->first();

        if (!$user) {
            return $this->returnPosts("URL이 정확하지 않습니다");
        }

        $user->activated = 1;
        $user->confirm_code = null;
        $user->save();

        auth()->login($user);
        return $this->returnPosts("가입이 완료되었습니다.");
    }

    public function edit(User $user)
    {

        $list = User::whereEmail($user->email)->first();

        if (auth()->user() != $list)
            return $this->returnPosts('본인 계정만 수정할 수 있습니다');
        else
            return view('users.formPartial.edit', compact('list'));
    }

    protected function updateSocialAccount(Request $request, User $user)
    {
        $this->validate($request, [
            'name' => 'required|max:20',
            'email' => 'required|max:255|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $user->update($request, [
            'name'=>$request->input('name'),
            'password'=>bcrypt($request->input('password')),
        ]);

        auth()->login($user);

        return $this->returnPosts($user->name. "님 환영합니다");
    }

    public function createNativeAccount(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|max:20',
            'email' => 'required|max:255|email|unique:users',
            'password' => 'required|min:8|confirmed',
        ]);

        $confirmCode = str_random(60);

        $user = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'confirm_code' => $confirmCode,
        ]);

        Mail::send('emails.auth.confirm', compact('user'), function ($message) use ($user) {
            $message->to($user->email);
            $message->subject(
                sprintf('[%s] 회원 가입을 확인해 주세요.', config('app.name'))
            );
        });

        return $this->returnPosts("메일이 발송되었습니다. 메일을 확인해 주세요");
    }

}
