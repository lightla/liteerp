<?php

namespace Extensions\Smtp\Models;

use Illuminate\Database\Eloquent\Model;

class SmtpModel extends Model
{
    protected $table = 'smtps';
    protected $fillable = [
        'from_name',
        'host',
        'from_email',
        'port',
        'encryption',
        'username',
        'password'
    ];
}