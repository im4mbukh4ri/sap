<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AnnouncementPicture extends Model
{
    //
    protected $fillable=['announcement_id','file_name','url'];

    public $timestamps=false;
    public function announcement(){
        return $this->belongsTo('App\Announcement');
    }
}
