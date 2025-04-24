<?php

namespace App\Policies;

use App\Models\Temployee;
use App\Models\Circular;

class CircularPolicy
{
    // This runs BEFORE any other policy method
    public function before(Temployee $user, $ability)
    {
        if ($user->role === 'admin') {
            return true; // Admin can do anything
        }
    }

    // Normal users can only view
    public function view(Temployee $user, Circular $circular)
    {
        return in_array($user->role, ['admin', 'user']);
    }

    // Only admin (handled in `before`) can update/delete
    public function update(Temployee $user, Circular $circular)
    {
        return false;
    }

    public function delete(Temployee $user, Circular $circular)
    {
        return false;
    }
}
