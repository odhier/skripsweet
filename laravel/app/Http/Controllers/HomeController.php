<?php

namespace App\Http\Controllers;

use App\Decryption;
use App\Encryption;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\{Route, Auth};

class HomeController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }

    public function index()
    {
        if (!Auth::check()) {

            return $this->indexForGuestUser();
        } else {
            $user = Auth::user();
            if ($user->hasVerifiedEmail())
                return $this->indexForLoggedUser();
            else
                return view('auth.verify')->with('email', $user->email);
        }
    }

    public function indexForGuestUser()
    {

        return view('welcome');
    }
    public function indexForLoggedUser()
    {
        $encrypt = Encryption::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')->orderBy('updated_at', 'desc')
            ->get();
        $decrypt = Decryption::where('user_id', Auth::user()->id)
            ->orderBy('created_at', 'desc')->orderBy('updated_at', 'desc')
            ->get();
        $data = [
            'recent_encrypt' => $encrypt->take(4),
            'count_encrypt' => count($encrypt),
            'recent_decrypt' => $decrypt->take(4),
            'count_decrypt' => count($decrypt),
        ];
        return view('home', ['data' => $data]);
    }
}
