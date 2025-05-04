<?php

require_once __DIR__ . '/../services/CommentService.class.php';

Flight::set('commentService', new CommentService());

Flight::group('/comments', function(){

    /**
     * @OA\Get(
     *      path="/comments",
     *      tags={"comments"},
     *      summary="Get all comments",
     *      security={
     *          {"ApiKey": {}}
     *      },
     *      @OA\Response(
     *           response=200,
     *           description="Array of all comments"
     *      )
     * )
     */
    Flight::route('GET /', function() {
        $data = Flight::get('commentService')->getComments();
        Flight::json($data);
    });

    /**
     * @OA\Get(
     *      path="/comments/comment",
     *      tags={"comments"},
     *      summary="Get comment by ID",
     *      security={
     *          {"ApiKey": {}}
     *      },
     *      @OA\Response(
     *           response=200,
     *           description="Comment data or false if not found"
     *      ),
     *      @OA\Parameter(
     *          name="comment_id",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="number")
     *      )
     * )
     */
    Flight::route('GET /comment', function() {
        $params = Flight::request()->query;
        $comment = Flight::get('commentService')->getCommentById($params['comment_id']);
        Flight::json($comment);
    });

    /**
     * @OA\Post(
     *      path="/comments/add",
     *      tags={"comments"},
     *      summary="Add or edit a comment",
     *      security={
     *          {"ApiKey": {}}
     *      },
     *      @OA\Response(
     *           response=200,
     *           description="Success message"
     *      ),
     *      @OA\RequestBody(
     *          description="Comment data",
     *          @OA\JsonContent(
     *              required={"content", "post_id", "user_id"},
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="content", type="string", example="This is a great post!"),
     *              @OA\Property(property="post_id", type="integer", example=1),
     *              @OA\Property(property="user_id", type="integer", example=1),
     *              @OA\Property(property="created_at", type="string", format="date-time", example="2023-01-01 12:00:00")
     *          )
     *      )
     * )
     */
    Flight::route('POST /add', function() {
        $payload = Flight::request()->data->getData();

        try {
            if($payload['id'] != NULL && $payload['id'] != '') {
                $comment = Flight::get('commentService')->editComment($payload);
                $message = "Comment updated successfully";
            } else {
                unset($payload['id']);
                $comment = Flight::get('commentService')->addComment($payload);
                $message = "Comment added successfully";
            }

            Flight::json(["message" => $message]);
        } catch (Exception $e) {
            Flight::halt(400, $e->getMessage());
        }
    });

    /**
     * @OA\Delete(
     *      path="/comments/delete/{comment_id}",
     *      tags={"comments"},
     *      summary="Delete comment by ID",
     *      security={
     *          {"ApiKey": {}}
     *      },
     *      @OA\Response(
     *           response=200,
     *           description="Success message"
     *      ),
     *      @OA\Parameter(
     *          name="comment_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="number")
     *      )
     * )
     */
    Flight::route('DELETE /delete/@comment_id', function($comment_id) {
        if($comment_id == NULL || $comment_id == '') {
            Flight::halt(400, "You have to provide valid comment id!");
        }

        Flight::get('commentService')->deleteComment($comment_id);
        Flight::json(['message' => "Comment deleted successfully"]);
    });

    /**
     * @OA\Get(
     *      path="/comments/{comment_id}",
     *      tags={"comments"},
     *      summary="Get comment by ID",
     *      security={
     *          {"ApiKey": {}}
     *      },
     *      @OA\Response(
     *           response=200,
     *           description="Comment data"
     *      ),
     *      @OA\Parameter(
     *          name="comment_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="number")
     *      )
     * )
     */
    Flight::route('GET /@comment_id', function($comment_id) {
        $comment = Flight::get('commentService')->getCommentById($comment_id);
        Flight::json($comment);
    });

    /**
     * @OA\Get(
     *      path="/comments/post/{post_id}",
     *      tags={"comments"},
     *      summary="Get comments by post ID",
     *      security={
     *          {"ApiKey": {}}
     *      },
     *      @OA\Response(
     *           response=200,
     *           description="Array of comments for the post"
     *      ),
     *      @OA\Parameter(
     *          name="post_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="number")
     *      )
     * )
     */
    Flight::route('GET /post/@post_id', function($post_id) {
        $comments = Flight::get('commentService')->getCommentsByPostId($post_id);
        Flight::json(["data" => $comments]);
    });

});