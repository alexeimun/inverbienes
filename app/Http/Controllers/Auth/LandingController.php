<?php

namespace Rhemo\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Rhemo\Http\Controllers\Controller;
use Rhemo\Mail\Mailers;
use Rhemo\Models\LandingModel;

class LandingController extends Controller {

    public function __construct(Request $request) {
        $this->request = $request;
    }

    public function register(Mailers $mailers) {
        if(!LandingModel::where('correo', $this->request['email'])->exists()) {
            LandingModel::create([
                'nombre' => $this->request['name'],
                'correo' => $this->request['email'],
                'rol' => $this->request['rol'],
            ]);
            $mailers->sendEmailLanding($this->request->all());
            return $this->response(['code' => '200', 'msg' => 'Muchas gracias por tu participación']);
        }

        return $this->response(['code' => '300', 'msg' => 'Tu cuenta ya se encuentra en nuestro sistema. Muchas gracias por tu participacion']);
    }

    public function version() {
        return $this->response([
            'version' => config('constants.api.API_VER'),
            'brand' => config('constants.api.API_BRAND')
        ]);
    }
}

