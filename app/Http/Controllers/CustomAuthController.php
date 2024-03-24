<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Hash;
use Session;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Log;
use DB;

use Illuminate\Support\Facades\Mail;
use App\Mail\UserCredential;
use App\Mail\ResetPassword;

class CustomAuthController extends Controller
{
    
    public function index()
    {
    	return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
        	if (Auth::user()->role == 'peserta') {
        		return redirect()->intended('/');
        	} else {
	            // return redirect()->route('admin.user.index', ['role' => Auth::user()->role]);
                return redirect()->route('admin.dashboard');
	        }
        }
  
        return redirect("login")->withSuccess('Login details are not valid');
    }

    public function registration()
    {
        return view('auth.register');
    }
      
    public function customRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("dashboard")->withSuccess('You have signed-in');
    }

    public function create(array $data)
    {
      return User::create([
        'name' => $data['name'],
        'email' => $data['email'],
        'password' => Hash::make($data['password'])
      ]);
    } 

    public function resetPasswordView()
    {
        return view('auth.reset-password');
    }   

    public function resetPassword(Request $request)
    {
        try {
            DB::beginTransaction();

            $password = generateRandomString(6, '0123456789');

            $data = User::where('email', $request->email)->update([
                'password' => Hash::make($password)
            ]);

            DB::commit();
            Session::flash('success', 'Password berhasil direset');

            $mail = User::where('email', $request->email)->first();

            Mail::send(new ResetPassword([
                'recipient' => $mail->email,
                'name' => $mail->name,
                'password' => $password
            ]));

            return redirect()->route('resetpwdview');

        } catch(\Exception $e) {
            Log::error(__METHOD__." Failed reset Password : ". $e->getMessage());

            DB::rollback();
            Session::flash('error', 'Password gagal direset');
            return redirect()->route('resetpwdview');
        }
    }
    
    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }
  
        return redirect("login")->withSuccess('You are not allowed to access');
    }
    
    public function signOut() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}
