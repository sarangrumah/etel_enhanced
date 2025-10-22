<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class vw_Helpdesk extends Model
{
    protected $table = 'vw_helpdesk';
    protected $primaryKey = 'id';
    // protected $fillable = [''];
    protected $guarded = [];
    public $timestamps = false;
}