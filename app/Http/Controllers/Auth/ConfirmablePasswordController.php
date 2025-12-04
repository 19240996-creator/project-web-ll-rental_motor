<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;

class ConfirmablePasswordController extends Controller
{
    public function show()
    {
        return view('auth.confirm-password');
    }

    public function store()
    {
        // Simple implementation
    }
}
