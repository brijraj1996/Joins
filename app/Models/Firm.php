<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Firm extends Model
{
    use HasFactory;

    protected $fillable = ['f_name', 'employee_id', 'address','user_id'];

    public function users()
    {
        return $this->hasMany(User::class);
    }
    
}
