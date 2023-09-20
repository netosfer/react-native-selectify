<?php

namespace App\Http\Controllers\Backend;

use App\Models\Appointment;
use App\Models\Option;
use Illuminate\Http\Request;

class OptionsBackendController extends BackendController
{
    public function homepageOptions()
    {
        $options = Option::where('opt_key', 'homepage')->first();
        if ($options) {
            $options = json_decode($options->opt_val, true);
        }
        return $this->render('backend.options.homepage', ['options' => $options]);
    }

    public function contactOptions()
    {
        $options = Option::where('opt_key', 'contact')->first();
        if ($options) {
            $options = json_decode($options->opt_val, true);
        }
        return $this->render('backend.options.contact', ['options' => $options]);
    }

    public function appointmentOptions()
    {
        $options = Option::where('opt_key', 'appointment_hours')->first();
        if ($options) {
            $options = json_decode($options->opt_val, true);
        }
        $days = ["Pazar", "Pazartesi", "Salı", "Çarşamba", "Perşembe", "Cuma", "Cumartesi"];
        $day_start = 8;
        $day_end = 20;
        $hours = [];
        for ($i = $day_start; $i < $day_end; $i++) {
            array_push($hours, $i . ":00");
            array_push($hours, $i . ":30");
        }
        array_push($hours, "20:30");

        $closedAppointments = Appointment::where('closed', true)->get();

        foreach($closedAppointments as $key => $chours){
            $cdates[$chours->appointment_date] = [];
        }
        foreach($closedAppointments as $key => $chours){
           array_push($cdates[$chours->appointment_date], $chours->appointment_time);
        }
        return $this->render('backend.options.appointment', ['options' => $options, "days" => $days, "hours" => $hours, "closed_hours" => $cdates]);
    }

    public function saveOptions(Request $request, $key, $format = 'string')
    {
        $options = $request->toArray()['options'];
        if (is_array($options) && $format == 'json') {
            $json = json_encode($options);
            Option::updateOrCreate(['opt_key' => $key], ['opt_val' => $json, 'opt_key' => $key]);
        }
        session()->flash("flash_notification", [
            "level" => "success",
            "message" => __('options.stored_message')
        ]);
        return redirect()->back();
    }

    public function saveClosedHours(Request $request)
    {
        Appointment::where('closed', true)->delete();
        foreach($request->options as $option){
            $date = $option['close_date'];
            foreach($option['close_hours'] as $hour){
                $new_appointment = new Appointment();
                $new_appointment->appointment_date = $date;
                $new_appointment->service = 'diger';
                $new_appointment->appointment_time = $hour;
                $new_appointment->closed = true;
                $new_appointment->approve = true;
                $new_appointment->save();
            }
        }
        session()->flash("flash_notification", [
            "level" => "success",
            "message" => __('options.stored_message')
        ]);
        return redirect()->back();
    }
}
