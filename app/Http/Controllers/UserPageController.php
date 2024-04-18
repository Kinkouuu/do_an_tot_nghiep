<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserPageController extends Controller
{
    public function index()
    {
        return view('user.pages.home', [
            'page_title' => 'Welcome To Kinkou Resort',
            'page_description' => 'TRAVEL & VACATION',

        ]);
    }

    public function introduce()
    {
        return view('user.pages.introduce', [
            'page_title' => 'About Us',
            'page_description' => 'Inspirational Story'
        ]);
    }

    public function contact()
    {
        return view('user.pages.contact', [
            'page_title' => 'Get In Touch',
            'page_description' => 'Chat With Us'
        ]);
    }

    public function login()
    {
        return view('user.pages.login');
    }


    public function signup()
    {
        return view('user.pages.signup');
    }
}
