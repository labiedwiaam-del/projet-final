<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NotificationRecord extends Model
{
    use HasFactory;

    protected $table = 'notifications';

    protected $fillable = [
        'user_id',
        'type',
        'sujet',
        'message',
        'envoye_le',
        'statut',
    ];

    protected $casts = [
        'envoye_le' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
