<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Laravel\Scout\Searchable;

class MstUsers extends Authenticatable
{
    use HasFactory,Searchable;
    protected $table = "mst_users";
    protected $fillable = ['id ', 'name', 'email', 'password', 'remember_token', 'verify_email', 'is_active', 'is_delete', 'group_role', 'last_login_at', 'last_login_ip', 'created_at', 'updated_at'];

}
