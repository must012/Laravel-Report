<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;


class SocialController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function execute(Request $request, $provider){
        if(! $request->has('code')){
            return $this->redirectToProvider($provider);
        }

        return $this->handleProvidercallback($provider);
    }

    public function redirectToProvider($provider){
        return Socialite::driver($provider)->redirect();
    }

    public function handleProvidercallback($provier){
        $user = Socialite::driver($provier)->user();

        $user = (User::whereEmail($user->getEmail())->first())?:User::create([
            'name'=>$user->getName()?:'이름을 추가해주세요',
            'email'=>$user->getEmail(),
            'activated'=>1,
        ]);

        auth()->login($user);

        return redirect('posts')->with('flash_message',auth()->user()->name. '님 환영합니다');
    }
}
