<?php

namespace App\Policies;

use App\Models\Attachment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AttachmentPolicy
{
    use HandlesAuthorization;
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Attachment $attachment): bool
    {
        //
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user, Post $post): bool
    {
        return $user->id === $post->blog->user_id;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Attachment $attachment): bool
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Attachment $attachment): bool
    {
        return $user->id === $attachment->post->blog->user_id;
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Attachment $attachment): bool
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Attachment $attachment): bool
    {
        //
    }
}
