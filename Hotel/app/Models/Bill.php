<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    use HasFactory; 
    
    protected $table= 'bill';
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = ['id','date','Reservation_id'];

    public function reservations(){
        return $this->belongsTo('App\Models\Reservation','Reservation_id');
    }

    
}

