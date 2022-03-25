<?php

namespace App\Http\Controllers\client;

use App\Http\Controllers\Controller;
use App\Models\message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            session(['module_active' => 'contact']);
            return $next($request);
        });
    }

    function index() {
        return view('client.contact_us.index');
    }
    function send(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required'
        ], [
            'required' => 'Không được để trống',
        ]);
        if($validator->fails()) {
            $error = $validator->errors()->toArray();
            return response()->json(['code' => 0, 'error' => $error]);
        } else {
            message::create($request->all());
            return response()->json(['code' => 1, 'msg' => 'Cảm ơn bạn đã gửi phản hồi cho chúng tôi']);
        }
    }
}
