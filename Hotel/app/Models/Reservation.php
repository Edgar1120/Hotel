<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table= 'reservation';
    protected $primaryKey = "id";
    public $timestamps = false;
    protected $fillable = ['id','checkin','checkout','total','User_id','Room_id'];

    public function room(){
        return $this->belongsTo('App\Models\Room','Room_id');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','User_id');
    }

    public function bills(){
        return $this->hasMany('App\Models\bill');
    
    }



}
