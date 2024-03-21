<?php

namespace App\Http\Controllers\Auth;

use App\Enums\Ability;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTokenRequest;
use Illuminate\Http\Request;
use Laravel\Sanctum\PersonalAccessToken;

class TokenController extends Controller
{
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
        return view('tokens.create', [
            'abilities' => Ability::cases()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTokenRequest $request)
    {
        $user = $request->user();
        $token = $user->createToken($request->name, $request->abilities);
        return back()->with('status', $token->plainTextToken);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request, PersonalAccessToken $token)
    {
        $user = $request->user();
        $user->tokens()->where('id', $token->id)->delete();

        return back();
    }
}
