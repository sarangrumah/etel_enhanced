<?php
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    use HasFactory;

    // Define the table associated with the model
    protected $table = 'tb_mst_uloschedule';

    // Allow mass assignment for these fields
    protected $fillable = [
        'title',
        'start',
        'end',
        'locate',
        'is_active', // Add this field to allow mass assignment// You can add this if you want to manage the activation status
    ];

    // You can define any relationships if necessary
    // For example, if there's a User model associated with the Agenda
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}