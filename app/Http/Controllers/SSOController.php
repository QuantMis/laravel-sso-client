<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

class SSOController extends Controller
{
    public function getLogin(Request $request)
    {

        $request->session()->put('state', $state = Str::random(40));

        $query = http_build_query([
            'client_id' => '9bb65888-6275-447c-b979-f9ea003fdad8',
            'redirect_uri' => 'http://127.0.0.1:3000/sso/auth/callback',
            'response_type' => 'code',
            'scope' => 'view-user',
            'state' => $state
        ]);

        return redirect('http://127.0.0.1:8000/oauth/authorize?' . $query);
    }

    public function getCallback(Request $request)
    {

        $state = $request->session()->pull('state');
        
        throw_unless(
                strlen($state) > 0 && $state === $request->state,
                InvalidArgumentException::class,
                'Invalid state value.'
        );
            
        
        $response = Http::asForm()->post('http://127.0.0.1:8000/oauth/token', [
            'grant_type' => 'authorization_code',
            'client_id' => '9bb65888-6275-447c-b979-f9ea003fdad8',
            'client_secret' => 'WvXrIy1GG8UZQZXooGToJF16T4sniH5v3tbPrsBv',
            'redirect_uri' => 'http://127.0.0.1:3000/sso/auth/callback',
            'code' => $request->code,
        ]);

        // dd($response->json());

        $request->session()->put($response->json());

        return redirect(route('sso.connect'));
    }

    public function connectUser(Request $request)
    {
        $access_token = $request->session()->get('access_token');

        $response = Http::withHeaders([
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $access_token,

        ])->get('http://127.0.0.1:8000/api/user-sso');

        $userArray = $response->json();
        // dd($userArray);

        try {
            $email = $userArray['email'];
        } catch (\Throwable $th) {
            return redirect('login')->withErrors('failed to login');
        }

        $user = User::where('email', $email)->first();

        if (!$user) {
            $user = new User;
            $user->name = $userArray['name'];
            $user->email = $userArray['email'];
            $user->password = '123456789';
            $user->save();
        }
        Auth::login($user);
        return redirect('/home');
    }
}
