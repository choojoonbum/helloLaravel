<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAttachmentRequest;
use App\Http\Requests\StorePostRequest;
use App\Models\Attachment;
use App\Models\Post;
use Illuminate\Http\Request;

class AttachmentController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Attachment::class, 'attachment', [
            'except' => ['store'],
        ]);

        $this->middleware('can:create,App\Models\Attachment,post')
            ->only('store');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePostRequest $request, Post $post)
    {
        foreach ($request->file('attachments') as $attachment) {
            $attachment->storePublicly('attachments', 'public');
            $post->attachments()->create([
                'original_name' => $attachment->getClientOriginalName(),
                'name' => $attachment->hashName('attachments')
            ]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Attachment $attachment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Attachment $attachment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Attachment $attachment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Attachment $attachment)
    {
        $attachment->delete();
        return back();
    }
}
