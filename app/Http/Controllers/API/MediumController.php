<?php

namespace App\Http\Controllers\API;

use App\Models\Mediumtoken;
use App\Http\Controllers\Controller;
use App\Http\Requests\Medium\UpdateRequest;
use App\Services\MediumService;
use Illuminate\Support\Facades\Auth;

class MediumController extends Controller
{
    public function index()
    {
        return Mediumtoken::where('user_id', Auth::id())->first();
    }

    public function update(UpdateRequest $request)
    {
        $success = false;
        $message = '';
        $errors = $medium = [];

        $medium = new MediumService($request->validated()['token']);
        $medium_profile = $medium->get_profile();

        try {
            $medium = Mediumtoken::updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'token' => $request->validated()['token'],
                    'medium_user_id' => $medium_profile['data']['data']['id'],
                    'username' => $medium_profile['data']['data']['username'],
                    'name' => $medium_profile['data']['data']['name'],
                    'url' => $medium_profile['data']['data']['url'],
                    'image_url' => $medium_profile['data']['data']['imageUrl']
                ]
            );

            session(['token' => $request->validated()['token'], 'medium_user_id' => $medium_profile['data']['data']['id']]);

            $success = true;
            $message = 'Medium account connected !';
            $errors = [];

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = 'Error occured';
            $errors[] = $ex->getMessage();
        }

        return [
            'success' => $success,
            'message' => $message,
            'data' => $medium,
            'errors' => $errors
        ];
    }
}
