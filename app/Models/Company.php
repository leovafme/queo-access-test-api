<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'logo',
        'website',
    ];

    /**
    * The table associated with the model.
    *
    * @var string
    */
    protected $table = 'companies';

    /**
    * Get the employees associated with the company.
    */
   public function employees()
   {
       return $this->hasMany(Employee::class);
   }
}
