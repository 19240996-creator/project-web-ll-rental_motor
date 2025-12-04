<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class PasswordResetLinkController extends Controller
{
    public function create()
    {
        return view('auth.forgot-password');
    }

    public function store()
    {
        // Simple implementation
    }
}
