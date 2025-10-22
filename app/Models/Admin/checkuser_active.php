<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class checkuser_active extends Model
{
    use HasFactory;
    protected $table = 'vw_useractive';
    // protected $guarded = ['id'];
}