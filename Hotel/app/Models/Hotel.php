<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hotel extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table= 'hotel';
    protected $primaryKey = "id";

    protected $fillable = [
        'id',
        'name',
        'description',
        'location',
        'rooms'];

    public function hotelPhoto(){
        return $this->hasMany('App\Models\HotelPhoto');
    
    }

}