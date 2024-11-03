<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Auth\Authenticatable;

class GoogleUser extends Model implements AuthenticatableContract
{
    use Authenticatable;

    // Define your table and fillable attributes
    protected $table = 'google_users'; // Adjust as needed
    protected $fillable = ['google_id', 'name', 'email'];
}

