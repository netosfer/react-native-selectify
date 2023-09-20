<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Option;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AppointmentsController extends Controller
{
    public function index()
    {
        return $this->view('auth.online-appointment');
    }

    public function hours(Request $request)
    {
        $date_names = ['Monday' => 'Pazartesi', 'Tuesday' => 'Salı', 'Wednesday' => 'Çarşamba', 'Thursday' => 'Perşembe', 'Friday' => 'Cuma', 'Saturday' => 'Cumartesi', 'Sunday' => 'Pazar'];
        try {
            $date = $request->get('date');
            $date_name = new \DateTime($date);
            $date_name = $date_name->format('l');
            $dntr = $date_names[$date_name];
            $hours = Option::where('opt_key', 'appointment_hours')->first();
            $hours = json_decode($hours->opt_val, true);
            $hours = isset($hours[$dntr]) ? $hours[$dntr] : [];
            $notAvailableHours = Appointment::where('appointment_date', $date)->get();
            foreach($notAvailableHours as $nhour){
                foreach($hours as $k => $h){
                    if($h == $nhour->appointment_time){
                        unset($hours[$k]);
                    }
                }
            }
            return response()->json($hours, 200);
        } catch (\Exception $e){
            return response()->json($e->getMessage(), 403);
        }
    }

    public function makeAppointment(Request $request)
    {
        $validate = $request->validate([
            'service' => 'required',
            'appointment_date' => 'required',
            'appointment_time' => 'required',
        ]);

        try {
            $appointment = new Appointment();
            $appointment->service = $request->get('service');
            $appointment->appointment_date = $request->get('appointment_date');
            $appointment->appointment_time = $request->get('appointment_time');
            $appointment->user = Auth::user()->id;
            $appointment->save();
            return redirect()->route('auth.dashboard');
        } catch (\Exception $e) {
            session()->flash("flash_notification", [
                "level"     => "danger",
                "message"   => __('appointments.error_message')
            ]);
            return redirect()->route('auth.dashboard');
        }
    }
}
