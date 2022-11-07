<?php

namespace App\Http\Controllers;

use App\Events\Models\User\UserCreated as UserUserCreated;
use App\Http\Resources\OffersResource;
use App\Http\Resources\UserResource;
use App\Models\Offers;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;
use Illuminate\Support\Facades\Auth;

/**
 * @group User Management
 *
 * APIs to manage the user resource.
 * */

class UserController extends Controller
{
    /**
     * Display a listing of users.
     *
     * Gets a list of users.
     *
     * @queryParam page_size int Size per page. Defaults to 20. Example: 20
     * @queryParam page int Page to view. Example: 1
     *
     * @apiResourceCollection App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     * @return ResourceCollection
     */

    public function index(Request $request)
    {
        //event(new UserUserCreated(User::factory()->make()));
        $users = User::query()->paginate($request->page_size ?? 20);

        return UserResource::collection($users);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @bodyParam name string required Name of the user. Example: John Doe
     * @bodyParam email string required Email of the user. Example: doe@doe.com
     * @apiResource App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     *
     * @param \Illuminate\Http\Request $request
     * @return UserResource
     */
    public function store(Request $request, UserRepository $repository)
    {
        $created = $repository->create($request->only([
            'name',
            'email',
        ]));

        return new UserResource($created);
    }

    /**
     * Display the specified user.
     *
     * @urlParam id int required User ID
     * @apiResource App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     *
     * @param \App\Models\User $user
     * @return UserResource
     */
    public function show(User $user)
    {
        return new UserResource($user);
    }

    public function profile()
    {
        if (Auth::check()) {
            //The user is logged in...
            return Auth::user();
        }
        else{
            return new JsonResponse([
                'message' => "unauthenticated res"
            ]);
        }
    }

    /**
     * Update the specified user in storage.
     *
     * @bodyParam name string Name of the user. Example: John Doe
     * @bodyParam email string Email of the user. Example: doe@doe.com
     * @apiResource App\Http\Resources\UserResource
     * @apiResourceModel App\Models\User
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return UserResource | JsonResponse
     */
    public function update(Request $request, User $user, UserRepository $repository)
    {
        $user = $repository->update($user, $request->only([
            'name',
            'email',
        ]));

        return new UserResource($user);
    }

    /**
     * Remove the specified user from storage.
     *
     * @response 200 {
        "data": "success"
     * }
     *
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user, UserRepository $repository)
    {
        $deleted = $repository->forceDelete($user);
        return new JsonResponse([
            'data' => $deleted,
        ]);
    }

    public function web(Request $request)
    {
        $pageSize = $request->page_size ?? 20;
        $offers = User::query()->paginate($pageSize);
        return view('web.users.index', compact('offers'));
    }

    public function edit(Request $request, User $user)
    {
        return view('web.users.edit', compact('user'));
    }

    public function create()
    {

        return view('web.users.create');
    }

     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function userfavorites()
    {
        if (Auth::check()) {
            // The user is logged in...
            $user_id = Auth::id();
            $user = User::find($user_id);
            $items = $user->users_favorites()->with(['images']);

            return OffersResource::collection($items->get())->response();
            // return $items;
        }
        else{
            return response('{"message":"not authenticated"}', 200);
        }
    }

      /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function useroffers()
    {
        if (Auth::check()) {
            // The user is logged in...
            $user_id = Auth::id();
            $offers = Offers::where("user_id","=", $user_id)->with(['images']);

            return OffersResource::collection($offers->get())->response();
            // return $items;
        }
        else{
            return response('{"message":"not authenticated"}', 200);
        }

    }

}
