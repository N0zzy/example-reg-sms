<?php

namespace App\Http\Controllers\Registration;

use App\Http\Controllers\Controller;

use App\Models\Verify\SMS;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

final class RegistrationController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function request(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|unique:users|max:100",
            "phone" => "required|unique:users|regex:/^\+?\d{11}$/",
            "mail" => "required|unique:users|regex:/^(.+)@(.+)\.(.+)$/i",
            "inn" => "required|unique:users|regex:/^\d{12}$/",
            "type" => "required|regex:/^\d{1}$/",
        ]);

        if ($validator->fails()) {
            return Response::json([
                "error" => true,
                "text" => $validator->getMessageBag()
            ])->setStatusCode(400);
        }

        if (!in_array((int)$validator->validate()["type"], [1, 2])) {
            return Response::json([
                "error" => true,
                "text" => 'type not found',
            ])->setStatusCode(400);
        }

        $request->session()->put("name", $validator->validate()["name"]);
        $request->session()->put("phone", $validator->validate()["phone"]);
        $request->session()->put("inn", $validator->validate()["inn"]);
        $request->session()->put("mail", $validator->validate()["mail"]);
        $request->session()->put("type", $validator->validate()["type"]);
        $request->session()->put("reg", false);
        $request->session()->put("sms", rand(1000,9999));

        $sms = new SMS();
        $send = $sms->send(
            $validator->validate()["phone"],
            "Code registration: " . $request->session()->get('sms')
        );

        if(!isset($send["success"]) || $send["success"] !== true) {
            return Response::json([
                "error" => false,
                "text" => 'sms not send',
            ]);
        }

        return Response::json([
            "error" => false,
            "text" => 'sms send',
        ]);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|object
     * @throws \Illuminate\Validation\ValidationException
     */
    public function execute(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "sms" => "required|regex:/^\d{4}$/",
        ]);

        if ($validator->fails()) {
            return Response::json([
                "error" => true,
                "text" => $validator->getMessageBag()
            ]);
        }

        $sms = $request->session()->get("sms");
        if($sms != $validator->validate()['sms']){
            return Response::json([
                "error" => true,
                "reg" => false,
                "text" => 'sms is invalid'
            ])->setStatusCode(400);
        }

        $name = $request->session()->get("name");
        $phone = $request->session()->get("phone");
        $inn = $request->session()->get("inn");
        $mail = $request->session()->get("mail");
        $type = $request->session()->get("type");

        $id = DB::table('users')->insertGetId([
            'name' => $name,
            'phone' => $phone,
            'inn' => $inn,
            'mail' => $mail,
            'type' => $type,
        ]);

        if((int)$id < 1) {
            return Response::json([
                "error" => true,
                "reg" => false,
            ])->setStatusCode(400);
        }

        return Response::json([
            "error" => false,
            "reg" => true,
            "id" => $id
        ]);
    }
}
