<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use DB;
use Carbon\Carbon;
use App\Models\User;


class AccountsController extends Controller
{
    public function trocarSenha(Request $request,User $user)
    {
               
        $user = DB::table('telessaude.users')->where('email', '=', $request->email)->first();
        //Check if the user exists
        
        //Create Password Reset Token
        DB::table('telessaude.password_resets')->insert([
            'email' => auth()->user()->email,
            'token' => str_random(60),
            'created_at' => Carbon::now()
        ]);
        //Get the token just created above
        $tokenData = DB::table('telessaude.password_resets')
            ->where('token', $request->token)->first();

        $data = DB::select('select token as token from telessaude.password_resets LIMIT 1');
        return view('admin.senha.mudar',compact('tokenData'));
    }

    public function validatePasswordRequest(Request $request)
    {
        $user = DB::table('telessaude.users')->where('email', '=', $request->email)->first();
        //Check if the user exists
        
        //Create Password Reset Token
        DB::table('telessaude.password_resets')->insert([
            'email' => auth()->user()->email,
            'token' => str_random(60),
            'created_at' => Carbon::now()
        ]);
        //Get the token just created above
        $tokenData = DB::table('telessaude.password_resets')
            ->where('token', $request->email)->first();

        $data = DB::select('select token as token from telessaude.password_resets LIMIT 1');

        return view('admin.senha.resert',compact('data'));
         
        //if ($this->sendResetEmail($request->email, $tokenData->token)) {
        //    return redirect()->back()->with('status', trans('A reset link has been sent to your email address.'));
        //} else {
        //    return redirect()->back()->withErrors(['error' => trans('A Network Error occurred. Please try again.')]);
       // }
    }
}
