<?php

namespace App\Http\Controllers\API;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\MediumService;

class PostController extends Controller
{

    public function sync()
    {
        if ($token = session('token')) {
            $medium = new MediumService($token, session('medium_user_id'));
            $posts = $medium->get_posts();;
            if ($posts['status'] == 200 && $posts['data']['data']) {
                foreach ($posts['data']['data'] as $post) {
                    Post::updateOrCreate(
                        ['medium_id' => $post['id']],
                        [
                            'name' => $post['name'],
                            'description' => $post['description'],
                            'url' => $post['url'],
                            'imageUrl' => $post['imageUrl'],
                        ]
                    );
                }
            }
        }

        return $this->index();
    }

    public function index()
    {
        $books = Post::all()->toArray();
        return array_reverse($books);
    }

    public function publish(Request $request)
    {
        $book = new Post([
            'name' => $request->name,
            'author' => $request->author
        ]);
        $book->save();

        return response()->json('The book successfully added');
    }

}
