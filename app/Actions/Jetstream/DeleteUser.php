<?php

namespace App\Actions\Jetstream;

use App\Models\User;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * Delete the given user.
     *
     * @param User $user
     * @return void
     */
    public function delete(User $user): void
    {
        $user->deleteProfilePhoto();

        $user->delete();
    }
}
