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

    public function getLogoAttribute($value)
    {
        if ($value && env('USE_S3', false)) {
            $value = env('AWS_S3_URL') . $value;
        } else if ($value) {
            $value = 'storage/' . $value;
        }

        return $value;
    }
}
