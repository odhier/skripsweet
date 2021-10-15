<?php

namespace App\Http\Controllers;

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
        return view('home');
    }
}
