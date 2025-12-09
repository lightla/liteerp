<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class NotificationModel extends Model
{
    //
    use HasFactory, SoftDeletes;

    protected $table = 'notifications';

    /**
     * Mass assignable fields
     */
    protected $fillable = [
        'user_id',
        'type',
        'title',
        'message',
        'entity_type',
        'is_read',
        'link'
    ];
}
