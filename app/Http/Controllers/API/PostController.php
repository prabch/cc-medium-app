<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\Post\AddRequest;
use App\Services\MediumService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{

    public function index()
    {
        $posts = Post::where('user_id', Auth::id())->get();

        if ($posts) {
            $_posts = [];
            foreach ($posts as $post) {
                $post['excerpt'] = self::makeExcerpt($post['content']);
                $_posts[] = $post;
            }
            $posts = $_posts;
        }

        return array_reverse($posts);
    }

    private static function makeExcerpt(string $string, int $start = 0, int $length = 200) : string
    {
        if (strlen($string) > $length) {
            $excerpt   = substr($string, $start, $length-3);
            $lastspace = strrpos($excerpt, ' ');
            $excerpt   = substr($excerpt, 0, $lastspace);
            $excerpt  .= '...';
        } else {
            $excerpt = $string;
        }
        
        return $excerpt;
    }

    public function save(AddRequest $request)
    {
        try {
            $tags = (isset($request->validated()['tags']) ? $request->validated()['tags'] : NULL);

            if ($tags) {
                $tags = json_encode(array_map('trim', explode(',', $tags)));
            }

            $post = new Post([
                'user_id' => Auth::id(),
                'title' => $request->validated()['title'],
                'content' => $request->validated()['content'],
                'canonicalUrl' => (isset($request->validated()['canonicalUrl']) ? $request->validated()['canonicalUrl'] : NULL),
                'tags' => $tags,
            ]);

            $post->save();

            $success = true;
            $message = 'Post saved';
            $errors = [];

        } catch (\Illuminate\Database\QueryException $ex) {
            $success = false;
            $message = 'Error occured';
            $errors[] = $ex->getMessage();
        }

        return [
            'success' => $success,
            'message' => $message,
            'errors' => $errors
        ];
    }

    public function publish($id)
    {
        $success = false;
        $message = '';
        $errors = [];

        if ($token = session('token')) {
            $post = Post::find($id);
            $medium = new MediumService(session('token'), session('medium_user_id'));
            $post = [
                'title' => $post['title'],
                'contentFormat' => 'html',
                'content' => $post['content'],
                'tags' => ($post['tags'] ? json_decode($post['tags']) : []),
                'canonicalUrl' => $post['canonicalUrl'],
                'publishStatus' => 'draft'
                ];

            $submit = $medium->create_post($post);

            if ($submit['status'] == 201) {
                Post::where('id', $id)->update(['medium_id' => $submit['data']['data']['id']]);
                $success = true;
                $message = 'Post pubmitted as draft';
            } else {
                $errors = $submit['errors'];
            }
        } else {
            $errors = (object)['Medium account not connected'];
        }

        return [
            'success' => $success,
            'message' => $message,
            'errors' => $errors
        ];
    }

    public function read($id)
    {
        return Post::find($id);
    }
}
