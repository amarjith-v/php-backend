<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class RootController extends Controller
{
    protected function apiResponse($response = [], $message = "", $error_code = 200)
    {

        switch ($error_code) {
            case 200:
                if ($message == "") {
                    $message = config('constants.SUCCESS_MSG_OK');
                }
                $success = true;
                break;

            case 201:
                if ($message == "") {
                    $message = config('constants.SUCCESS_MSG_REG');
                }
                $success = true;
                break;

            case 400:
                if (array_key_exists('message', $response)) {
                    $message = $response["message"];
                }
                if ($message == "") {
                    $message = config('constants.ERROR_MSG_VALIDATION');
                }
                $success = false;
                break;

            case 401:
                if ($message == "") {
                    $message = config('constants.ERROR_MSG_UNAUTH');
                }
                $success = false;
                break;

            case 404:
                if ($message == "") {
                    $message = config('constants.ERROR_MSG_NOT_FOUND');
                }
                $success = false;
                break;

            case 500:
                if ($message == "") {
                    $message = config('constants.ERROR_MSG_INTERNAL');
                }
                $success = false;
                break;

            default:
                if ($message == "") {
                    $message = config('constants.ERROR_MSG_INTERNAL');
                }
                $success = false;
                break;
        }
        return response()->json(
            [
                'success' => $success,
                'message' => $message,
                'data' => $response,
            ],
            $error_code
        );
    }
}
