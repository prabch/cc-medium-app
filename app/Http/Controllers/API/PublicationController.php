<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MediumService;

class PublicationController extends Controller
{
    public function index()
    {
        $success = false;
        $message = '';
        $errors = $publications = [];

        if ($token = session('token')) {
            $medium = new MediumService(session('token'), session('medium_user_id'));
            $publications = $medium->get_publications();;

            if ($publications['status'] == 200) {
                $publications = $publications['data']['data'];
                $success = true;
            } else {
                $errors = $publications['errors'];
            }
        } else {
            $errors = (object)['Medium account not connected'];
        }

        return [
            'success' => $success,
            'data' => $publications,
            'message' => $message,
            'errors' => $errors
        ];
    }
}
