<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleUser extends Model
{
    protected $table = 'role_user';

    protected $fillable = [
        'id_role',
        'id_user',
    ];

    public function role () {
        return $this->belongsTo(Roles::class, 'id_role');
    }

    public function user () {
        return $this->belongsTo(User::class, 'id_user');
    }
}
