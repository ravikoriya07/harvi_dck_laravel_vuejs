<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactCard extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'designation',
        'company_name',
        'email',
        'phone',
        'website',
        'office_address',
        'profile_image',
        'slug',
    ];
}
