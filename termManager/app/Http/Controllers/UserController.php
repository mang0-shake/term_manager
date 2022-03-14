<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\PersonalAccessToken;
use App\Models\Privilege;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * @return Response
     */
    public function index(): Response
    {
        return response(UserResource::collection(User::all()), 200);
    }


    /**
     * @param Request $request
     * @return Response
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'status' => 'required',
        ]);

        $userSequence = DB::select("select nextval('users_id_seq')");
        $userId = intval($userSequence['0']->nextval);

        $newUser = User::create([
            'id' => $userId,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'status' => $request->status,
        ]);

        $role = Privilege::whereIn('name', $request->privileges)->get();
        if ($request->exists('privileges')) {
            $newUser->roles()->attach($role);
        }

        return response($newUser, 200);

    }

    /**
     * @param User $user
     * @return Response
     */
    public function show(User $user): Response
    {
        return response(new UserResource($user), 200);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return Response
     */
    public function update(Request $request, User $user): Response
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            'firstName' => 'required',
            'lastName' => 'required',
            'status' => 'required',
        ]);

        $user->update([
            'email' => $request->email,
            'password' => $request->password,
            'first_name' => $request->firstName,
            'last_name' => $request->lastName,
            'status' => $request->status,
        ]);

        if ($request->exists('privileges')) {
            $userPrivileges = Privilege::whereIn('name', $request->privileges)->get();
            $user->roles()->sync($userPrivileges);
        }

        return response(new UserResource($user), 201);
    }

    /**
     * @param User $user
     * @return Response
     */
    public function destroy(User $user): Response
    {
        $user->roles()->detach();
        $user->delete();

        return response(null, 204);
    }

    /**
     * @param Request $request
     * @return Response
     */
    public function getUserPrivileges(Request $request): Response
    {
        [$id, $token] = explode('|', $request->header('authorization'), 2);
        [,$id] = explode(' ', $id, 2);
        $accessToken = PersonalAccessToken::find($id);

        $userPrivileges = [];
        if (!empty($accessToken) && hash_equals($accessToken->token, hash('sha256', $token))) {
            $userPrivileges = User::where('id', $accessToken->tokenable_id)->first()->roles()->pluck('name');
        }

        return response($userPrivileges,200);
    }
}
