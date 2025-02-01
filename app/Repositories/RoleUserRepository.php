<?php

namespace App\Repositories;

use App\Models\RoleUser;
use App\Models\User;

class RoleUserRepository {
    
    public function newRoleUser(int $userId, int $roleId) {
        return RoleUser::create([
            'id_role' => $roleId,
            'id_user' => $userId
        ]);
    }

    public function validationRoleUser (int $userId, int $roleId) {
        return RoleUser::where('id_role', $roleId)
                        ->where('id_user', $userId)
                        ->exists();
    }

    public function updateRoleUserStatus(int $roleUserId, string $newRoleUserStatus) {
        return RoleUser::where('id', $roleUserId)
                        ->update(['status' => $newRoleUserStatus]);
    }

    public function deleteRoleUser(int $roleUserId) {
        return RoleUser::where('id', $roleUserId)->delete();
    }

    public function allRoleUser() {
        $allUserWhitRole = User::with('roles')->get();
        $allUserWhitRoleFormat = [];

        foreach ($allUserWhitRole as $userWhitRole) {

            $roles = $userWhitRole->roles->map(function($role) {
                return [
                    'idRoleUse' => $role->pivot->id,
                    'role' => $role->role,
                    'status' => $role->pivot->status,
                ];
            });

            $user = [
                'user' => [
                    'id' => $userWhitRole->id,
                    'user' => $userWhitRole->user,
                    'fullName' => $userWhitRole->name . ' ' . $userWhitRole->lastname
                    ],
                'roles' => $roles
            ];

            $allUserWhitRoleFormat[] = $user;
        }

        return $allUserWhitRoleFormat;
    }

    public function allRoleUserByUserId(int $userId) {
        return User::with('roles')->select('id', 'user', 'name', 'lastname', 'email')->find($userId);
    }

    public function roleUserById(int $roleUserId) {
        return RoleUser::with('role', 'user')->find($roleUserId);
    }
}
