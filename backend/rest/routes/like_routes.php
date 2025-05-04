<?php

require_once __DIR__ . '/../services/LikeService.class.php';

Flight::set('likeService', new LikeService());

Flight::group('/likes', function(){

    /**
     * @OA\Get(
     *      path="/likes",
     *      tags={"likes"},
     *      summary="Get all likes",
     *      security={
     *          {"ApiKey": {}}
     *      },
     *      @OA\Response(
     *           response=200,
     *           description="Array of all likes"
     *      )
     * )
     */
    Flight::route('GET /', function() {
        $data = Flight::get('likeService')->getLikes();
        Flight::json($data);
    });

    /**
     * @OA\Get(
     *      path="/likes/like",
     *      tags={"likes"},
     *      summary="Get like by ID",
     *      security={
     *          {"ApiKey": {}}
     *      },
     *      @OA\Response(
     *           response=200,
     *           description="Like data or false if not found"
     *      ),
     *      @OA\Parameter(
     *          name="like_id",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="number")
     *      )
     * )
     */
    Flight::route('GET /like', function() {
        $params = Flight::request()->query;
        $like = Flight::get('likeService')->getLikeById($params['like_id']);
        Flight::json($like);
    });

    /**
     * @OA\Post(
     *      path="/likes/add",
     *      tags={"likes"},
     *      summary="Add a like",
     *      security={
     *          {"ApiKey": {}}
     *      },
     *      @OA\Response(
     *           response=200,
     *           description="Success message"
     *      ),
     *      @OA\RequestBody(
     *          description="Like data",
     *          @OA\JsonContent(
     *              required={"post_id", "user_id", "like_status"},
     *              @OA\Property(property="post_id", type="integer", example=1),
     *              @OA\Property(property="user_id", type="integer", example=1),
     *              @OA\Property(property="like_status", type="boolean", example=true)
     *          )
     *      )
     * )
     */
    Flight::route('POST /add', function() {
        $payload = Flight::request()->data->getData();

        try {
            $like = Flight::get('likeService')->addLike($payload);
            Flight::json(["message" => "Like added successfully", "data" => $like]);
        } catch (Exception $e) {
            Flight::halt(400, $e->getMessage());
        }
    });

    /**
     * @OA\Delete(
     *      path="/likes/delete/{like_id}",
     *      tags={"likes"},
     *      summary="Delete like by ID",
     *      security={
     *          {"ApiKey": {}}
     *      },
     *      @OA\Response(
     *           response=200,
     *           description="Success message"
     *      ),
     *      @OA\Parameter(
     *          name="like_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="number")
     *      )
     * )
     */
    Flight::route('DELETE /delete/@like_id', function($like_id) {
        if($like_id == NULL || $like_id == '') {
            Flight::halt(400, "You have to provide valid like id!");
        }

        Flight::get('likeService')->deleteLike($like_id);
        Flight::json(['message' => "Like deleted successfully"]);
    });

    /**
     * @OA\Get(
     *      path="/likes/count/{post_id}",
     *      tags={"likes"},
     *      summary="Get like count for post",
     *      @OA\Response(
     *           response=200,
     *           description="Like count"
     *      ),
     *      @OA\Parameter(
     *          name="post_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="number")
     *      )
     * )
     */
    Flight::route('GET /count/@post_id', function($post_id) {
        $count = Flight::get('likeService')->getLikeCount($post_id);
        Flight::json(["count" => $count]);
    });

    /**
     * @OA\Get(
     *      path="/likes/status/{post_id}/{user_id}",
     *      tags={"likes"},
     *      summary="Check if user liked a post",
     *      security={
     *          {"ApiKey": {}}
     *      },
     *      @OA\Response(
     *           response=200,
     *           description="Like status"
     *      ),
     *      @OA\Parameter(
     *          name="post_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="number")
     *      ),
     *      @OA\Parameter(
     *          name="user_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="number")
     *      )
     * )
     */
    Flight::route('GET /status/@post_id/@user_id', function($post_id, $user_id) {
        $status = Flight::get('likeService')->getUserLikeStatus($post_id, $user_id);
        Flight::json(["liked" => $status]);
    });

});