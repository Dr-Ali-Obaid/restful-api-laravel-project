<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function __construct(){
        $this->middleware('auth:sanctum')->except(['index']);
    }
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->input('limit');
        $limit = ($limit > 5) ? 5 : $limit;
        $users = UserResource::collection(User::paginate($limit));
        return $users->response()->setStatusCode(200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    // تحقق أولاً من المصادقة أو الصلاحية إذا أردت
    $this->authorize('create', User::class);

    // إنشاء المستخدم مباشرة
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'role' => $request->role,
    ]);

    // تحقق من أن المستخدم تم إنشاؤه
    if (!$user) {
        return response()->json([
            'message' => 'Failed to create user'
        ], 500);
    }

    // الرد النهائي باستخدام Resource بطريقة صحيحة
    return (new UserResource($user))
    ->additional([
        'message' => 'The User Created Successfully'
    ])
    ->response()->setStatusCode(201);
}

  

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $user = new UserResource(User::findOrFail($id));
        return $user->response()->setStatusCode(200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $this->authorize('update', $user); 
        $user->update($request->all());
        return (new UserResource($user))
        ->additional(['message' => 'The User Updated Successfully'])
        ->response()->setStatusCode(200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $this->authorize('delete', $user);
        $user->delete();
        return response(['message' => "the user deleted successfully"], 201);
    }
}
