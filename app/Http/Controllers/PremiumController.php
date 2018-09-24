<?php

namespace Rhemo\Http\Controllers;

use Auth;
use Mail;
use redirect;
use Rhemo\Http\Requests\RhemoRequests\LinkingRequest;
use Rhemo\Http\Requests\RhemoRequests\LoginApiRequest;
use Rhemo\Http\Requests\RhemoRequests\SaveRequest;
use Rhemo\Models\Horse;
use Rhemo\Models\Media;
use Rhemo\Models\Premium;
use Rhemo\Models\SensoModel;

//request
//models

class PremiumController extends Controller {

    public function linking(LinkingRequest $request) {

        if(Auth::check()) {
            $user = \Auth::user();
            if($user['estado'] == 'AD' or $user['estado'] == 'FD' or $user['estado'] == 'GD') return ['code' => '300', 'msg' => 'El usuario se encuentra desactivado actualmente'];
            if($user['estado'] == 'AB' or $user['estado'] == 'FB' or $user['estado'] == 'GB') return ['code' => '300', 'msg' => 'El usuario se encuentra bloqueado actualmente'];
        } else return ['code' => '300', 'msg' => 'Usuario no registrado'];

        $id_device = Premium::where('id_dispositivo', $request['dispositivo'])->value('id');

        if($dispositivo = Premium::find($id_device)) {
            if($dispositivo['id_propietario'] != '0') return ['code' => '300', 'msg' => 'Este dispositivo ya esta vinculado a un usuario'];

            $dispositivo['id_propietario'] = $user['id'];
            $dispositivo->save();
            return ['code' => '200', 'msg' => 'Este dispositivo se ha vinculado correctamente'];

        } else return ['code' => 300, 'msg' => 'el dispositivo no existe'];
    }

    public function list( $request) {

        if(Auth::check()) {
            $user = \Auth::user();
            if($user['estado'] == 'AD' or $user['estado'] == 'FD' or $user['estado'] == 'GD') return ['code' => '300', 'msg' => 'El usuario se encuentra desactivado actualmente'];
            if($user['estado'] == 'AB' or $user['estado'] == 'FB' or $user['estado'] == 'GB') return ['code' => '300', 'msg' => 'El usuario se encuentra bloqueado actualmente'];
        } else return ['code' => '300', 'msg' => 'Usuario no registrado'];
        $device_list = Premium::where('id_propietario', $user['id'])->where('estado', '1')->pluck('id')->toArray();
        if(count($device_list) == 0) return ['code' => '300', 'msg' => 'El usuario no cuenta con dispositivos actualmente'];
        $device_list = PremiumListModel::findmany($device_list)->toArray();
        return ['code' => '200', 'dispositivos' => $device_list];

    }

    public function _save(SaveRequest $request) {
        $user = \Auth::user();

        if($user['estado'] == 'AD' or $user['estado'] == 'FD' or $user['estado'] == 'GD') return ['code' => '300', 'msg' => 'El usuario se encuentra desactivado actualmente'];

        if($user['estado'] == 'AB' or $user['estado'] == 'FB' or $user['estado'] == 'GB') return ['code' => '300', 'msg' => 'El usuario se encuentra bloqueado actualmente'];

        $intervalos = $request['intervalos'];
        $grafica = $request['grafica'];
        if($id = Horse::where('registry', $request['registry'])->where('user_id', $user['id'])->value('id')) {
            if($request['hora_inicial'] >= $request['hora_final']) return ['code' => 300, 'msg' => 'error en los datos suministrados,fechas incosistentes'];
            if(!$caballo = Horse::where('registry', $request['registry'])->where('user_id', $user['id'])->where('estado', '1')->pluck('id')->toArray()) return ['code' => 300, 'msg' => 'caballo no registrado'];
            if(!$dispositivo = Premium::where('id_propietario', $user['id'])->where('estado', '1')->where('id_dispositivo', $request['dispositivo'])->pluck('id')->toArray()) return ['code' => 300, 'msg' => 'dispositivo no registrado'];
            $caballo = $caballo[0];
            $dispositivo = $dispositivo[0];
            if($valor = SensoModel::where('id_dispositivo', $dispositivo)->where('id_caballo', $caballo)->where('fecha', $request['fecha'])->where('hora_inicial', $request['hora_inicial'])->where('hora_final', $request['hora_final'])->value('id')) return ['code' => 210, 'msg' => 'El Dato ya existe en nuestra base de datos'];
            if(SensoModel::create([
                'id_caballo' => $caballo,
                'id_dispositivo' => $dispositivo,
                'fecha' => $request['fecha'],
                'hora_inicial' => $request['hora_inicial'],
                'hora_final' => $request['hora_final'],
                'intervalos' => $intervalos,
                'grafica' => $grafica,
            ])) return ['code' => 200, 'msg' => 'datos guardados exitosamente'];
            else return ['code' => 300, 'msg' => 'Fallo al registrar los valores'];
        } else return ['code' => 300, 'msg' => 'el caballo no existe'];
    }

    public function show($request) {
        $user = \Auth::user();
        if($user['estado'] == 'AD' or $user['estado'] == 'FD' or $user['estado'] == 'GD') return ['code' => '300', 'msg' => 'El usuario se encuentra desactivado actualmente'];
        if($user['estado'] == 'AB' or $user['estado'] == 'FB' or $user['estado'] == 'GB') return ['code' => '300', 'msg' => 'El usuario se encuentra bloqueado actualmente'];
        if(!$dispositivos = Premium::where('estado', '1')->where('id_propietario', $user['id'])->pluck('id')->toArray()) return ['code' => '300', 'msg' => 'El usuario no cuenta con dispositivos registrados'];

        if(!$datos = SensoModel::wherein('id_dispositivo', $dispositivos)->where('estado', '1')->pluck('id')->toArray()) return ['code' => '300', 'msg' => 'El usuario no cuenta con datos registrados'];
        $caballos = SensoModel::wherein('id_dispositivo', $dispositivos)->where('estado', '1')->pluck('id_caballo')->toArray();
        $caballos = Horse::findmany($caballos)->toArray();
        $fotos = Horse::whereIn('id', $caballos)->pluck('foto')->toArray();
        $fotos = Media::WhereIn('id', $fotos)->pluck('url', 'id')->toArray();
        $datos = SensoModel::findmany($datos);
        $horse_count = count($caballos);
        $data_count = count($datos);
        //$picture_count=count($fotos);
        for ($i = 0; $i < $data_count; $i++) {
            for ($r = 0; $r < $horse_count; $r++) {
                if($datos[$i]['id_caballo'] == $caballos[$r]['id']) {
                    $datos[$i]['id_caballo'] = $caballos[$r]['registry'];
                    $datos[$i]['nombre'] = $caballos[$r]['nombre'];
                    $id_foto = $caballos[$r]['foto'];
                    if(array_key_exists($id_foto, $fotos)) $datos[$i]['foto'] = $fotos[$id_foto];
                    else $datos[$i]['foto'] = "https://f001.backblazeb2.com/file/rhemo-app/16_2017_07_13_08_05_12.jpg";
                    $r = $horse_count;
                }
            }
        }

        return ['code' => '200', 'data' => $datos];
    }

}
