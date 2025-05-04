<?php

require_once __DIR__ . '/../services/PostService.class.php';

Flight::set('postService', new PostService());

Flight::group('/posts', function(){

    /**
     * @OA\Get(
     *      path="/posts",
     *      tags={"posts"},
     *      summary="Get all posts",
     *      @OA\Response(
     *           response=200,
     *           description="Get all posts"
     *      )
     * )
     */
    Flight::route('GET /', function(){
        $data = Flight::get('postService')->getPosts();
        Flight::json($data);
    });

    /**
     * @OA\Get(
     *      path="/posts/post",
     *      tags={"posts"},
     *      summary="Get post by id",

     *      @OA\Response(
     *           response=200,
     *           description="Post data, or false if post doesn't exist"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="query", name="post_id", example="1", description="Post ID")
     * )
     */
    Flight::route('GET /post', function(){
        $params = Flight::request()->query;
        $post = Flight::get('postService')->getPostById($params['post_id']);
        Flight::json($post);
    });

    /**
     * @OA\Post(
     *      path="/posts/add",
     *      tags={"posts"},
     *      summary="Add post data to the database",
     *      @OA\Response(
     *           response=200,
     *           description="Post data, or exception if post is not added properly"
     *      ),
     *      @OA\RequestBody(
     *          description="Post data payload",
     *          @OA\JsonContent(
     *              required={"title","content"},
     *              @OA\Property(property="id", type="integer", example="1", description="Post ID"),
     *              @OA\Property(property="title", type="string", example="Some post title", description="Post title"),
     *              @OA\Property(property="content", type="string", example="Some post content", description="Post content")
     *          )
     *      )
     * )
     */
    Flight::route('POST /add', function(){
        $payload = Flight::request()->data->getData();

        if($payload['id'] != NULL && $payload['id'] != '') {
            $post = Flight::get('postService')->editPost($payload);
        } else {
            unset($payload['id']);
            $post = Flight::get('postService')->addPost($payload);
        }

        Flight::json(["message" => $post]);
    });

    /**
     * @OA\Delete(
     *      path="/posts/delete/{post_id}",
     *      tags={"posts"},
     *      summary="Delete post by id",
     *      @OA\Response(
     *           response=200,
     *           description="Deleted post data or 500 status code exception otherwise"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="post_id", example="1", description="Post ID")
     * )
     */
    Flight::route('DELETE /delete/@post_id', function($post_id){
        if($post_id == NULL || $post_id == '') {
            Flight::halt(500, "You have to provide valid post id!");
        }

        Flight::get('postService')->deletePost($post_id);
        Flight::json(['message' => "You have successfully deleted the post!"]);
    });

    /**
     * @OA\Get(
     *      path="/posts/{post_id}",
     *      tags={"posts"},
     *      summary="Get post by id",
     *      @OA\Response(
     *           response=200,
     *           description="Post data, or false if post does not exist"
     *      ),
     *      @OA\Parameter(@OA\Schema(type="number"), in="path", name="post_id", example="1", description="Post ID")
     * )
     */
    Flight::route('GET /@post_id', function($post_id){
        $post = Flight::get('postService')->getPostById($post_id);
        Flight::json($post, 200);
    });

});