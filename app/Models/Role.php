<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = ['role'];

    public function users() {
        return $this->belongsToMany(User::class , 'id', 'id_role', 'id_user', 'status');
    }
}
