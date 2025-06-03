<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../services/AuthService.class.php';
use Firebase\JWT\JWT;
use Firebase\JWT\Key;

Flight::set('authService', new AuthService());

Flight::group('/auth', function(){

    /**
     * @OA\Post(
     *      path="/auth/login",
     *      tags={"auth"},
     *      summary="Login to the system using email and password",
     *      @OA\RequestBody(
     *          description="Login credentials",
     *          required=true,
     *          @OA\JsonContent(
     *              required={"email", "password"},
     *              @OA\Property(property="email", type="string", example="example@example.com", description="User email"),
     *              @OA\Property(property="password", type="string", example="securepassword", description="User password")
     *          )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="User data and JWT",
     *          @OA\JsonContent(
     *              @OA\Property(property="token", type="string", example="eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9...")
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Invalid email or password"
     *      )
     * )
     */
    Flight::route('POST /login', function(){
        $payload = Flight::request()->data->getData();

        $user = Flight::get('authService')->getUserByEmail($payload['email']);
        if (!$user || !password_verify($payload['password'], $user['password'])) {
            Flight::halt(401, "Invalid email or password");
        }

        unset($user['password']); // Remove password from response

        $jwt_payload = [
            'user' => $user,
            'iat' => time(),
            'exp' => time() + (60 * 60 * 24) // Token valid for 24 hours
        ];

        $token = JWT::encode(
            $jwt_payload,
            Config::JWT_SECRET(),
            'HS256'
        );

        Flight::json(array_merge($user, ['token' => $token]));
    });

    /**
     * @OA\Post(
     *      path="/auth/logout",
     *      tags={"auth"},
     *      summary="Logout from the system",
     *      security={{"ApiKey": {}}},
     *      @OA\Response(
     *          response=200,
     *          description="Logout successful"
     *      )
     * )
     */
    Flight::route('POST /logout', function(){
        try {
            $token = Flight::request()->getHeader("Authentication");
            if (!$token) {
                Flight::halt(401, "Missing authentication header");
            }
            $decoded_token = JWT::decode(
                $token,
                new Key(Config::JWT_SECRET(), 'HS256')
            );
            Flight::json([
                //'jwt_decoded' => $decoded_token,
                'user' => $decoded_token->user,
            ]);
        } catch (\Exception $e) {
            Flight::halt(401, $e->getMessage());
        }
    });
});