<?php

namespace App\Http\Controllers\API;
use App\Http\Controllers\Controller;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Traits\ApiResponse;
class UserController extends Controller
{
    use ApiResponse;

    public function index()
    {
        return $this->responseSuccess(
            UserResource::collection(
                User::with(['articles','articles.articleImages'])->get()
            )
        );
    }


    public function store(Request $request)
    {
 //

    }


    public function show(User $user)
    {
        $user->load('articles');
        return $this->responseSuccess(new UserResource($user));
    }

    public function update(Request $request, User $user)
    {
        $user->fill($request->all());
        $user->save();
        return $this->responseSuccess(new UserResource($user));
    }

    public function destroy(User $user)
    {
        $user->delete();
        return $this->responseSuccess(null, [], 204);
    }

}
