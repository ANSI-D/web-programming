<?php

require_once __DIR__ . '/../services/CategoryService.class.php';

Flight::set('categoryService', new CategoryService());

Flight::group('/categories', function(){

    /**
     * @OA\Get(
     *      path="/categories",
     *      tags={"categories"},
     *      summary="Get all categories",
     *      security={
     *          {"ApiKey": {}}
     *      },
     *      @OA\Response(
     *           response=200,
     *           description="Array of all categories"
     *      )
     * )
     */
    Flight::route('GET /', function() {
        $data = Flight::get('categoryService')->getCategories();
        Flight::json($data);
    });

    /**
     * @OA\Get(
     *      path="/categories/category",
     *      tags={"categories"},
     *      summary="Get category by ID",
     *      security={
     *          {"ApiKey": {}}
     *      },
     *      @OA\Response(
     *           response=200,
     *           description="Category data or false if not found"
     *      ),
     *      @OA\Parameter(
     *          name="category_id",
     *          in="query",
     *          required=true,
     *          @OA\Schema(type="number")
     *      )
     * )
     */
    Flight::route('GET /category', function() {
        $params = Flight::request()->query;
        $category = Flight::get('categoryService')->getCategoryById($params['category_id']);
        Flight::json($category);
    });

    /**
     * @OA\Post(
     *      path="/categories/add",
     *      tags={"categories"},
     *      summary="Add or edit a category",
     *      @OA\Response(
     *           response=200,
     *           description="Success message"
     *      ),
     *      @OA\RequestBody(
     *          description="Category data",
     *          @OA\JsonContent(
     *              required={"name"},
     *              @OA\Property(property="id", type="integer", example=1),
     *              @OA\Property(property="name", type="string", example="Technology"),
     *              @OA\Property(property="description", type="string", example="Tech related posts")
     *          )
     *      )
     * )
     */
    Flight::route('POST /add', function() {
        $payload = Flight::request()->data->getData();

        if($payload['id'] != NULL && $payload['id'] != '') {
            $category = Flight::get('categoryService')->editCategory($payload);
            $message = "Category updated successfully";
        } else {
            unset($payload['id']);
            $category = Flight::get('categoryService')->addCategory($payload);
            $message = "Category added successfully";
        }

        Flight::json(["message" => $message]);
    });

    /**
     * @OA\Delete(
     *      path="/categories/delete/{category_id}",
     *      tags={"categories"},
     *      summary="Delete category by ID",
     *      @OA\Response(
     *           response=200,
     *           description="Success message"
     *      ),
     *      @OA\Parameter(
     *          name="category_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="number")
     *      )
     * )
     */
    Flight::route('DELETE /delete/@category_id', function($category_id) {
        if($category_id == NULL || $category_id == '') {
            Flight::halt(500, "You have to provide valid category id!");
        }

        Flight::get('categoryService')->deleteCategory($category_id);
        Flight::json(['message' => "Category deleted successfully"]);
    });

    /**
     * @OA\Get(
     *      path="/categories/{category_id}",
     *      tags={"categories"},
     *      summary="Get category by ID",
     *      @OA\Response(
     *           response=200,
     *           description="Category data"
     *      ),
     *      @OA\Parameter(
     *          name="category_id",
     *          in="path",
     *          required=true,
     *          @OA\Schema(type="number")
     *      )
     * )
     */
    Flight::route('GET /@category_id', function($category_id) {
        $category = Flight::get('categoryService')->getCategoryById($category_id);
        Flight::json($category);
    });

});