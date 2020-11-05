<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'path',
        'announcement_id',
        'is_uploaded'
    ];

    public function announcement()
    {
        return $this->belongsTo(Announcement::class);
    }
}
