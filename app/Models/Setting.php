<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = ["uniq_key", "lang", "logo", "footer_logo", "favicon", "site_title", "site_description", "admin_email", "copyright", "cookie_alert", "color", "html_codes", "social_links", "smtp_configurations", "google_recaptcha"];

    protected $casts = [
        "html_codes" => "array",
        "social_links" => "array",
        "smtp_configurations" => "array",
        "google_recaptcha" => "array"
    ];

    public function getHtmlCodesAttribute($val){
        return json_decode($val, true);
    }

    public function getSocialLinksAttribute($val){
        return json_decode($val, true);
    }

    public function getSmtpConfigurationsAttribute($val){
        return json_decode($val, true);
    }

    public function getGoogleRecaptchaAttribute($val){
        return json_decode($val, true);
    }
}
