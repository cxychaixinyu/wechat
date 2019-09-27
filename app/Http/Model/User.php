<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
	protected $table = 'user';
    protected $pk="user_id";
}
