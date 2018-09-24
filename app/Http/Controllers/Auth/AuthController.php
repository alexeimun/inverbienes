<?php

namespace Rhemo\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Rhemo\Http\Controllers\Controller;
use Rhemo\Jobs\SendVerificationEmail;
use Rhemo\Models\UserConfirmation;
use Rhemo\Repositories\Auth\AuthRepository;

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
        $this->request->merge(['account_type' => $this->request->input('account_type', 0)]);
        $credentials = $this->request->only(['email', 'password', 'account_type']);

        $this->repository->checkActiveAccount($credentials);

        if(!$token = app('auth')->attempt($credentials))
            return response()->json(['error' => 'Unauthorized'], 401);

        if(!$this->repository->checkEmailVerified($credentials))
            return $this->response(['msg' => 'Este correo aún no ha sido validado, 
            te hemos enviado un nuevo link de valdición a tu correo.'], 422);

        return $this->respondWithToken($token);
    }

    /**
     * Register a new user
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */

    public function signup() {
        $this->validate($this->request, [
            'name' => 'required|string|max:60',
            'email' => 'bail|required|email|unique:users',
            'password' => 'required|string|min:6'
        ]);

        $user = $this->repository->register($this->request->all());

        $this->repository->sendEmailVerification($user);
        return response()->json(['msg' => 'correo de confirmación enviado']);
    }

    public function authFB() {
        $this->validate($this->request, [
            'name' => 'required|string',
            'id' => 'required',
            'email' => 'required'
        ]);

        $this->request->merge([
            'account_type' => 1,
            'password' => $this->request->email,
            'picture' => "https://graph.facebook.com/{$this->request->id}/picture?type=large"
        ]);
        $data = $this->request->all();

        if($this->repository->accountExists($data['email']))
            return $this->response(['msg' => 'Este correo ya ha sido registrado antes'], 422);

        if($this->repository->accountExists($data['email'], 'fb'))
            $this->repository->checkUserPicture($data);

        $this->repository->saveFacebookUser($data);
        return $this->login();
    }

    /**
     * Verifies the email
     *
     * @param $token
     * @return \Illuminate\View\View
     */
    public function verifyEmail($token) {
        $name = $this->repository->verifyEmail($token);
        $msg = $name ? '¡Correo validado exitosamente!' :
            'El código de validación es inválido, por favor repita el proceso.';
        return view('auth.verifyEmail', ['name' => $name, 'msg' => $msg]);
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