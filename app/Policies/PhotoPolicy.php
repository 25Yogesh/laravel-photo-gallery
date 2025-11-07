<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Photo;
use Illuminate\Auth\Access\HandlesAuthorization;

class PhotoPolicy
{
    use HandlesAuthorization;

    public function delete(User $user, Photo $photo)
    {
        return $user->id === $photo->user_id;
    }
}
