<?php

namespace App\Models;

use App\Notifications\AdminResetPasswordNotification;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;


class Admin extends Authenticatable
{
    use Notifiable;
    protected $table = 'tb_mst_user_bo';
    protected $guarded = [];

}
