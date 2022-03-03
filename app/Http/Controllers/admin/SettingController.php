<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'setting']);
            return $next($request);
        });
    }

    public function index () {
        return view('admin.setting.index');
    }



}
