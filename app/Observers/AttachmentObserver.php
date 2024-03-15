<?php

namespace App\Observers;

use App\Models\Attachment;
use Illuminate\Support\Facades\Storage;

class AttachmentObserver
{
    public function deleted(Attachment $attachment)
    {
        Storage::disk('public')->delete($attachment->name);
    }
}
