<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HotelPhoto extends Model
{
    use HasFactory;
    protected $table = 'hotelphoto';

    protected $fillable = [
        'id',
        'Hotel_id',
        'photo',
    ];

    public function hotel(){
        return $this->belongsTo('App\Models\Hotel','Hotel_id');
    }

}
