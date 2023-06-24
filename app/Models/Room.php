<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    use HasFactory;

    protected $table= 'room';
    protected $primaryKey= "id";
    public $timestamps = false;

    protected $fillable = ['id','description','num','type','state','price','image','Hotel_id'];

    public function hotel(){
        return $this->belongsTo('App\Models\Hotel','Hotel_id');
    }

    public function reservations(){
        return $this->hasMany('App\Models\Reservation');
    }

   

}
