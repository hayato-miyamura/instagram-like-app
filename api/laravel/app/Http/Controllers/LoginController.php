<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Firebase\Auth\Token\Exception\InvalidToken;
use Illuminate\Support\Facades\Auth;
use Kreait\Firebase;
use Kreait\Laravel\Firebase\Facades\Firebase as FacadesFirebase;
use PhpParser\Node\Stmt\TryCatch;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    /**
     * @var Firebase
     */
    private $auth;

    /**
     * @param Firebase $firebase
     */
    public function __construct(\Kreait\Firebase\Auth $auth, FacadesFirebase $firebase)
    {
        $this->auth = $auth;
        $this->firebase = $firebase;
    }




    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $user_model = new User();
        $id_token = $request->input('idToken');

        // \Log::debug("#####");
        // \Log::debug($id_token);

        try {
            $verified_id_token = $this->auth->verifyIdToken($id_token);
        } catch (InvalidToken $e) {
            return response()->json([
                'error' => 'error'
            ]);
        }

        $uid = $verified_id_token->getClaim('sub');
        $firebase_user = $this->auth->getUser($uid);

        $user = User::where('firebase_uid', $uid)->first();

        if (is_null($user)) {
            $user_info_array = [
                'name' => $firebase_user->displayName,
                'email' => $firebase_user->email,
                'password' => \Hash::make(uniqid()),
                'firebase_uid' => $uid
            ];

            User::create($user_info_array);

            // メモ: 後ほど暗号化したuidを送るように実装
            return response()->json([
                'message' => 'created',
            ])->cookie('Cookie', "$firebase_user->displayName", 5);
        }

        if ($user) {

            return response()->json([
                'message' => 'existing',
            ])->cookie('Cookie', "$firebase_user->displayName", 5);
        }

    }
}
