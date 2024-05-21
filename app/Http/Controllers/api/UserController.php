<?php

namespace App\Http\Controllers\api;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    function create(Request $request) {
        try {
            $user = User::create($request->all());
            return $user;
        } catch (\Exception $e) {
            return $e->getMessage();
            \Log::info($e->getMessage());
        }
    }

    function list(Request $request) {
        try {
            return User::get();
        } catch (\Exception $e) {
            \Log::info($e->getMessage());
        }
    }
}