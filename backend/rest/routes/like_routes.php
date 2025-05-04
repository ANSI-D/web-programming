<?php

require_once __DIR__ . '/../services/LikeService.class.php';

Flight::set('likeService', new LikeService());

Flight::group('/likes', function(){

    /**
     * @OA\Get(
     *      path="/likes",
     *      tags={"likes"},
     *      summary="Get all likes",

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
     *      path="/likes/{like_id}",
     *      tags={"likes"},
     *      summary="Get like by ID",

     *      @OA\Response(
     *           response=200,
     *           description="Like data or false if not found"
     *      ),
     *      @OA\Parameter(
     *          name="like_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="number")
     *      )
     * )
     */
    Flight::route('GET /@like_id', function($like_id) {
        $like = Flight::get('likeService')->getLikeById($like_id);
        Flight::json($like);
    });

    /**
     * @OA\Post(
     *      path="/likes",
     *      tags={"likes"},
     *      summary="Add a like",

     *      @OA\Response(
     *           response=200,
     *           description="Success message"
     *      ),
     *      @OA\RequestBody(
     *          description="Like data",
     *          @OA\JsonContent(
     *              required={"comment_id", "user_id"},
     *              @OA\Property(property="comment_id", type="integer", example=1),
     *              @OA\Property(property="user_id", type="integer", example=1)
     *          )
     *      )
     * )
     */
    Flight::route('POST /', function() {
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
     *      path="/likes/{like_id}",
     *      tags={"likes"},
     *      summary="Delete like by ID",

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
    Flight::route('DELETE /@like_id', function($like_id) {
        if($like_id == NULL || $like_id == '') {
            Flight::halt(400, "You have to provide valid like id!");
        }

        Flight::get('likeService')->deleteLike($like_id);
        Flight::json(['message' => "Like deleted successfully"]);
    });

    /**
     * @OA\Get(
     *      path="/likes/comment/{comment_id}",
     *      tags={"likes"},
     *      summary="Get likes for a comment",
     *      @OA\Response(
     *           response=200,
     *           description="Array of likes"
     *      ),
     *      @OA\Parameter(
     *          name="comment_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="number")
     *      )
     * )
     */
    Flight::route('GET /comment/@comment_id', function($comment_id) {
        $likes = Flight::get('likeService')->getLikesByCommentId($comment_id);
        Flight::json($likes);
    });

    /**
     * @OA\Get(
     *      path="/likes/user/{user_id}",
     *      tags={"likes"},
     *      summary="Get likes by a user",

     *      @OA\Response(
     *           response=200,
     *           description="Array of likes"
     *      ),
     *      @OA\Parameter(
     *          name="user_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="number")
     *      )
     * )
     */
    Flight::route('GET /user/@user_id', function($user_id) {
        $likes = Flight::get('likeService')->getLikesByUserId($user_id);
        Flight::json($likes);
    });

    /**
     * @OA\Delete(
     *      path="/likes/user/{user_id}/comment/{comment_id}",
     *      tags={"likes"},
     *      summary="Delete like by user and comment",

     *      @OA\Response(
     *           response=200,
     *           description="Success message"
     *      ),
     *      @OA\Parameter(
     *          name="user_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="number")
     *      ),
     *      @OA\Parameter(
     *          name="comment_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="number")
     *      )
     * )
     */
    Flight::route('DELETE /user/@user_id/comment/@comment_id', function($user_id, $comment_id) {
        Flight::get('likeService')->deleteLikeByUserAndComment($user_id, $comment_id);
        Flight::json(['message' => "Like deleted successfully"]);
    });

    /**
     * @OA\Get(
     *      path="/likes/count/comment/{comment_id}",
     *      tags={"likes"},
     *      summary="Get like count for comment",
     *      @OA\Response(
     *           response=200,
     *           description="Like count"
     *      ),
     *      @OA\Parameter(
     *          name="comment_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="number")
     *      )
     * )
     */
    Flight::route('GET /count/comment/@comment_id', function($comment_id) {
        $count = Flight::get('likeService')->getLikeCountForComment($comment_id);
        Flight::json(["count" => $count]);
    });

    /**
     * @OA\Get(
     *      path="/likes/status/comment/{comment_id}/user/{user_id}",
     *      tags={"likes"},
     *      summary="Check if user liked a comment",
     *      @OA\Response(
     *           response=200,
     *           description="Like status"
     *      ),
     *      @OA\Parameter(
     *          name="comment_id",
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
    Flight::route('GET /status/comment/@comment_id/user/@user_id', function($comment_id, $user_id) {
        $status = Flight::get('likeService')->getUserLikeStatusForComment($comment_id, $user_id);
        Flight::json(["liked" => $status]);
    });

});