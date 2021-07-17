<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone'
    ];

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'employees';

    /**
     * Get the company associated with the user.
     */
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
