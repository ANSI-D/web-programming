<?php

require_once __DIR__ . '/../services/UserService.class.php';
//require_once __DIR__ . '/../../data/roles.php';

Flight::set('userService', new UserService());

Flight::group('/users', function(){

    /**
     * @OA\Get(
     *      path="/users",
     *      tags={"users"},
     *      summary="Get all users",
     *      @OA\Response(
     *           response=200,
     *           description="Array of all users"
     *      )
     * )
     */
    Flight::route('GET /', function() {
        $data = Flight::get('userService')->getUsers();
        Flight::json($data);
    });

    /**
     * @OA\Get(
     *      path="/users/user",
     *      tags={"users"},
     *      summary="Get user by ID",
     *      @OA\Response(
     *           response=200,
     *           description="User data or false if not found"
     *      ),
     *      @OA\Parameter(
     *          name="user_id",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="number")
     *      )
     * )
     */
    Flight::route('GET /user', function() {
        $params = Flight::request()->query;
        $user = Flight::get('userService')->getUserById($params['user_id']);
        Flight::json($user);
    });

    /**
     * @OA\Post(
     *      path="/users/add",
     *      tags={"users"},
     *      summary="Add or edit a user",
     *      @OA\Response(
     *           response=200,
     *           description="Success message"
     *      ),
     *      @OA\RequestBody(
     *          description="User data",
     *          @OA\JsonContent(
     *              required={"username", "email", "password"},
     *              @OA\Property(property="username", type="string", example="john_doe"),
     *              @OA\Property(property="email", type="string", example="john@example.com"),
     *              @OA\Property(property="password", type="string", example="securepassword"),
     *              @OA\Property(property="role", type="string", example="user")
     *          )
     *      )
     * )
     */
    Flight::route('POST /add', function() {
        //Flight::auth_middleware()->authorizeRole(Roles::ADMIN);

        $payload = Flight::request()->data->getData();

        // Check if 'id' exists in the payload before accessing it
        if (isset($payload['id']) && $payload['id'] != NULL && $payload['id'] != '') {
            $user = Flight::get('userService')->editUser($payload);
            $message = "User updated successfully";
        } else {
            unset($payload['id']); // Ensure 'id' is not passed to the addUser method
            $user = Flight::get('userService')->addUser($payload);
            $message = "User added successfully";
        }

        Flight::json(["message" => $message]);
    });

    /**
     * @OA\Delete(
     *      path="/users/delete/{user_id}",
     *      tags={"users"},
     *      summary="Delete user by ID",
     *      @OA\Response(
     *           response=200,
     *           description="Success message"
     *      ),
     *      @OA\Parameter(
     *          name="user_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="number")
     *      )
     * )
     */
    Flight::route('DELETE /delete/@user_id', function($user_id) {
        if($user_id == NULL || $user_id == '') {
            Flight::halt(500, "You have to provide valid user id!");
        }

        Flight::get('userService')->deleteUser($user_id);
        Flight::json(['message' => "User deleted successfully"]);
    });

    /**
     * @OA\Get(
     *      path="/users/{user_id}",
     *      tags={"users"},
     *      summary="Get user by ID",
     *      @OA\Response(
     *           response=200,
     *           description="User data"
     *      ),
     *      @OA\Parameter(
     *          name="user_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="number")
     *      )
     * )
     */
    Flight::route('GET /@user_id', function($user_id) {
        $user = Flight::get('userService')->getUserById($user_id);
        Flight::json($user);
    });

    /**
     * @OA\Post(
     *      path="/users/login",
     *      tags={"users"},
     *      summary="User login",
     *      @OA\Response(
     *           response=200,
     *           description="Login success or failure"
     *      ),
     *      @OA\RequestBody(
     *          description="Login credentials",
     *          @OA\JsonContent(
     *              required={"email", "password"},
     *              @OA\Property(property="email", type="string", example="john@example.com"),
     *              @OA\Property(property="password", type="string", example="securepassword")
     *          )
     *      )
     * )
     */
    Flight::route('POST /login', function() {
        $login_data = Flight::request()->data->getData();
        $user = Flight::get('userService')->authenticate($login_data['email'], $login_data['password']);
        
        if ($user) {
            // Create JWT token or session here
            Flight::json(["message" => "Login successful", "user" => $user]);
        } else {
            Flight::halt(401, "Invalid email or password");
        }
    });

});