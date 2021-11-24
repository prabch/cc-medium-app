<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use App\Models\Mediumtoken;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\UpdateRequest;
use Illuminate\Support\Facades\Auth;
use App\Services\MediumService;

class UserController extends Controller
{

    public function index()
    {
        $profile = User::with('token')->find(Auth::id());
        return response()->json($profile);
    }

    public function update(UpdateRequest $request)
    {
        $profile = User::with('token')->find(Auth::id());

        $profile->token()->update([
            'token'=> $request->validated()['token']
        ]);

        $profile->update([
            'name'=> $request->validated()['name']
        ]);

        if (!isset($profile->token['token']) || ($profile->token['token'] != $request->validated()['token'])) {

            $medium = new MediumService($request->validated()['token']);
            $mediumprofile = $medium->get_profile();

            Mediumtoken::updateOrCreate(
                ['user_id' => Auth::id()],
                [
                    'token' => $request->validated()['token'],
                    'medium_user_id' => $mediumprofile['response']['data']['id'],
                    'username' => $mediumprofile['response']['data']['username'],
                    'name' => $mediumprofile['response']['data']['name'],
                    'url' => $mediumprofile['response']['data']['url'],
                    'image_url' => $mediumprofile['response']['data']['imageUrl']
                ]
            );
            
            session(['token' => $request->validated()['token'], 'medium_user_id' => $mediumprofile['response']['data']['id']]);
        }

        return response()->json($profile);
    }
}
