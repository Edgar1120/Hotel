<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use SebastianBergmann\Type\VoidType;

class RoomPhoto extends Model
{
    use HasFactory;

    protected $table= 'roomphotos';
    protected $primaryKey= "id";
    public $timestamps = false;

    protected $fillable = ['id','photos','Room_id'];


    public function room(){
        return $this->belongsTo('App\Models\Room','Room_id');
    }


}





