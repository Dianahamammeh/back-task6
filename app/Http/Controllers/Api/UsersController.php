<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $user = User::create([
                'name' => $request->name,
                'dec'  => $request->dec,
            ]);
            return response()->json(new UserResource($user),"status",200);
        } catch (\Throwable $th) {
            Log::error($th);
            return response()->json("Error", 201);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
       
        try {
            return  response()->json(new UserResource($user),"status",200);
        } catch (\Throwable $th) {
            Log::error($th);
            return  response()->json(null,"user not found",404);
        }
    }
    

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUserRequest $request, User $user)
    {
        try {
            if ($request->has('name')) {
                $user->title = $request->name;
            }
            if ($request->has('dec')) {
                $user->dec = $request->dec;
            }
            $user->save();
        return  response()->json(new UserResource($user),"User updated successfully",200);
    } catch (\Throwable $th) {
        Log::error($th);
        return  response()->json(null,"Error!!,there is something not correct",500);
    }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
