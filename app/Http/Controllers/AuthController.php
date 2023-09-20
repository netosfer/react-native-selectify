<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login()
    {
        $meta['title'] = __('frontend.login');
        $meta['description'] = __('frontend.login');
        return $this->view('login', ['meta' => $meta]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }

    public function index()
    {
        $appointments = Appointment::with('services')->where('user', Auth::user()->id)->get();
        return $this->view('auth.dashboard', ['appointments' => $appointments]);
    }

    public function informations()
    {
        return $this->view('auth.informations');
    }



    public function update(Request $request)
    {
        if ($request->has('name')) {
            try {
                $arr = $request->only(['name', 'email_address', 'phone_number']);
                $update = User::find(Auth::user()->id);
                $update->name = $arr['name'];
                $update->email = $arr['email_address'];
                $update->phone_number = $arr['phone_number'];
                $update->save();
                return redirect()->back(302);
            } catch (\Exception $e) {
                return redirect()->back(302);
            }
        } elseif ($request->has('password')) {
            try {
                $arr = $request->only(['password', 'confirm_password']);
                if ($arr['password'] != $arr['confirm_password']) {
                    return redirect()->back(302);
                } else {
                    $update = User::find(Auth::user()->id);
                    $update->password = Hash::make($arr['password']);
                    $update->save();
                    return redirect()->back(302);
                }
            } catch (\Exception $e){
                return redirect()->back(302);
            }
        }
    }
}
