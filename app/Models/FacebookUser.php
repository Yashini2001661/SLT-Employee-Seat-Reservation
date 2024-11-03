<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class FacebookUser extends Model implements AuthenticatableContract
{
    use Authenticatable;

    // Define your table and fillable attributes
    protected $table = 'facebook_users'; // Adjust as needed
    protected $fillable = ['facebook_id', 'name', 'email'];
}
