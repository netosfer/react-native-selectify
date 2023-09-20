<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
    use HasFactory;
	protected $fillable = ["company_name", "city", "address", "related_person", "phone_number"];

    protected $appends = ['name'];

    public function getNameAttribute(){
        return $this->company_name;
    }
}
