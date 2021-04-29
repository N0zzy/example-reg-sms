<?php

namespace App\Http\Controllers\Check;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Validator;

/**
 * Class CheckController
 * @package App\Http\Controllers\Check
 */
class CheckController extends Controller
{
    private $token = '66a07181188c4cbf45b221ec38d4af9031eb044e';
    private $secret = '4d8bdd717cd3d521e3d547f1da6188a41dd9c388';

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function personal(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "name" => "required|max:100",
            "mail" => "required|regex:/^(.+)@(.+)\.(.+)$/i",
        ]);

        if ($validator->fails()) {
            return Response::json([
                "error" => true,
                "text" => $validator->getMessageBag()
            ]);
        }

        /*************************************/
        /* здесь не поулчить id пользователя *******************************
        $dadata = new \Dadata\DadataClient($this->token, $this->secret);
        $result = $dadata->clean("email", $validator->validate()["mail"]);
        return Response::json(["result" => $result]);
        ********************************************************************/

        $where =

        $user = DB::table('users')
            ->where([
                ['name', '=', $validator->validate()["name"]],
                ['mail', '=', $validator->validate()["mail"]],
            ])
            ->get(["id","name","mail"]);

        $result = $user->toArray();
        if(empty($result)) {
            return Response::json([
                'error' => true,
                'text' => 'user not found'
            ]);
        }


        return response()->json($result, 200, [], JSON_UNESCAPED_UNICODE);

    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|object
     * @throws \Illuminate\Validation\ValidationException
     */
    public function company(Request $request)
    {
        $validator = Validator::make($request->all(), [
            "inn" => "required|regex:/^\d{12}$/",
        ]);

        if ($validator->fails()) {
            return Response::json([
                "error" => true,
                "text" => $validator->getMessageBag()
            ]);
        }

        $dadata = new \Dadata\DadataClient($this->token, null);
        $result = $dadata->findById("party", 7707083893, 1);

        if (empty($result)) {
            return Response::json(["result" => 'not found']);
        }

        return Response::json([
            "result" => [
                "name" => $result[0]["value"],
                "adddress" => $result[0]["data"]["address"]["unrestricted_value"],
            ]
        ]);
    }
}
