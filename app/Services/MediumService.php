<?php

namespace App\Services;
use Illuminate\Support\Facades\Http;
use App\Services\MediumService;

class MediumService
{

    public const API_URL = 'https://api.medium.com/v1/';

    public function __construct(string $token, string $user_id = '')
    {
        $this->token = $token;
        $this->user_id = $user_id;
    }

    public static function post(string $endpoint, array $params = [], string $token = NULL) : array
    {
        $errors = [];
        $response = Http::accept('application/json');
        if ($token) $response = $response->withToken($token);

        try{
            $response = $response->asForm()->post(self::API_URL . $endpoint, $params);
            $status = $response->status();
            $response = $response->json();
        } catch(\Illuminate\Http\Client\ConnectionException $exception){
            $status = 500;
            $errors[] = $exception->getMessage();
        }

        if (isset($response['errors'])) {
            $_errors = $response['errors'];
            if ($_errors) {
                foreach ($_errors as $error) {
                    $errors[$error['code']] = $error['message'];
                }
            }
        }
        return ['status' => $status, 'data' => $response, 'errors' => $errors];
    }
    
    public static function get(string $endpoint, array $params = [], string $token = NULL) : array
    {
        $errors = [];
        $response = Http::accept('application/json');
        if ($token) $response = $response->withToken($token);

        try{
            $response = $response->get(self::API_URL . $endpoint, $params);
            $status = $response->status();
            $response = $response->json();
        }catch(\Illuminate\Http\Client\ConnectionException $exception){
            $status = 500;
            $errors[] = $exception->getMessage();
        }

        if (isset($response['data']['errors'])) {
            $_errors = $response['data']['errors'];
            if ($_errors) {
                foreach ($_errors as $error) {
                    $errors[$error['code']] = $error['message'];
                }
            }
        }
        
        return ['status' => $status, 'data' => $response, 'errors' => $errors];
    }

    public function create_post($params = [])
    {
        return self::post("users/{$this->user_id}/posts", $params, $this->token);
    }

    public function get_publications()
    {
        return self::get("users/{$this->user_id}/publications", [], $this->token);
    }

    public function get_profile()
    {
        return self::get('me', [], $this->token);
    }
}