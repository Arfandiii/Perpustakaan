<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $title = 'Dashboard Admin';
        return view('user.dashboard', compact('title')); // View untuk user dashboard
    }

    public function profile()
    {
        $title = 'Dashboard Admin';
        return view('user.profile', compact('title')); // View untuk profil pengguna
    }

    public function setting()
    {
        $title = 'Dashboard Admin';
        return view('user.setting', compact('title')); // View untuk setting pengguna
    }

    public function notification()
    {
        $title = 'Dashboard Admin';
        return view('user.notification', compact('title')); // View untuk notif pengguna
    }
}
