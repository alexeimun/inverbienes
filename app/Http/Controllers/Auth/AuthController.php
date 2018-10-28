<?php

namespace Bienes\Http\Controllers\Auth;

use Bienes\Http\Controllers\Controller;
use Bienes\Repositories\Auth\AuthRepository;
use Illuminate\Http\Request;

class AuthController extends Controller {

    /**
     * Create a new AuthController instance.
     *
     * @param AuthRepository $repository
     * @param Request $request
     */
    public function __construct(AuthRepository $repository, Request $request) {
        $this->request = $request;
        $this->repository = $repository;
    }

    /**
     * Get a JWT via given credentials.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function login() {
        $credentials = $this->request->only(['email', 'password']);

        if(!$token = app('auth')->attempt($credentials))
            return response()->json(['error' => 'Unauthorized'], 401);

        return $this->respondWithToken($token);
    }

    /**
     * Get the authenticated User.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function me() {
        return $this->request->user();
    }

    /**
     * Log the user out (Invalidate the token).
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function logout() {
        app('auth')->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function signup() {
        $this->validate($this->request, [
            'name' => 'required|string|max:60',
            'email' => 'bail|required|email|unique:users',
            'password' => 'required|string|min:6'
        ]);

        return response()->json($this->repository->register($this->request->all()));
    }

    /**
     * Refresh a token.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function refresh() {
        return $this->respondWithToken(app('auth')->refresh());
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token) {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => (time() + ((app('auth')->factory()->getTTL()) * 60)) * 1000
        ]);
    }
}