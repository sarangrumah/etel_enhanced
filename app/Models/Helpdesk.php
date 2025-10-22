<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Helpdesk extends Model
{
    protected $table = 'tb_trx_helpdesk';
    protected $primaryKey = 'id';
    // protected $fillable = [''];
    protected $guarded = [];
    public $timestamps = false;
}