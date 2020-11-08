<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\IndexAnnouncementRequest;
use App\Http\Requests\StoreAnnouncementRequest;
use App\Jobs\UploadPhotoJob;
use App\Models\Announcement;
use App\Services\AnnouncementService;
use App\Services\ImageService;

class AnnouncementController extends ApiBaseController
{

    /**
     * @OA\Post(
     *     path="/api/announcement",
     *     summary="Создание объявления",
     *     tags={"announcement"},
     *     @OA\RequestBody(
     *         required=true,
     *         description="Данные объявления",
     *         @OA\JsonContent(
     *             required={"title", "description", "price","images"},
     *             @OA\Property(property="title", type="string", example="Название объявления"),
     *             @OA\Property(property="description", type="string", example="Описание объявления"),
     *             @OA\Property(property="price", type="int", example="100"),
     *             @OA\Property(
     *                 property="images",
     *                 type="array",
     *                 @OA\Items(
     *                     type="string",
     *                     example="https://miro.medium.com/max/11730/0*ihTZPO4iffJ8n69_"
     *                 )
     *             )
     *         ),
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Объявление успешно создано",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="success"),
     *             @OA\Property(property="ID", type="int", example="1"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="validation_error"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="array",
     *                 @OA\Items(
     *                     type="array",
     *                     example="price",
     *                     @OA\Items(
     *                         type="string",
     *                         example="The price field is required."
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function store(StoreAnnouncementRequest $request, AnnouncementService $announcementService, ImageService $imageService)
    {
        $announcement = $announcementService->create($request->only('title', 'description', 'price'));
        $this->dispatch(new UploadPhotoJob($imageService->create($announcement, $request->get('images'))));
        return response()->json(['status' => 'success', 'ID' => $announcement->id])->setStatusCode(201);
    }

    /**
     * @OA\Get(
     *     path="/api/announcement",
     *     summary="Получение списка объявлений с возможностью сортировки",
     *     tags={"announcement"},
     *     @OA\Parameter(
     *         name="sort_field",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="price",
     *         ),
     *     ),
     *     @OA\Parameter(
     *         name="sort_direction",
     *         in="query",
     *         required=false,
     *         @OA\Schema(
     *             type="string",
     *             example="asc"
     *         ),
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Получение списка объявлений",
     *         @OA\JsonContent(
     *             @OA\Property(
     *                 property="announcements",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="title", type="string", example="Название объявления"),
     *                     @OA\Property(property="price", type="int", example="10000"),
     *                     @OA\Property(property="photo", type="string", example="http://tapir.localhost/storage/announcements/1/images/image1.jpg"),
     *                 )
     *             ),
     *         )
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Ошибка валидации",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="validation_error"),
     *             @OA\Property(
     *                 property="errors",
     *                 type="array",
     *                 @OA\Items(
     *                     type="array",
     *                     example="sort_field",
     *                     @OA\Items(
     *                         type="string",
     *                         example="The selected sort field is invalid."
     *                     )
     *                 )
     *             )
     *         )
     *     )
     * )
     */
    public function index(IndexAnnouncementRequest $request, AnnouncementService $announcementService)
    {
        return response()->json(['announcements' => $announcementService->index()]);
    }

    /**
     * @OA\Get(
     *     path="/api/announcement/{id}",
     *     summary="Получение списка объявлений с возможностью сортировки",
     *     tags={"announcement"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         @OA\Schema(
     *             type="int"
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Получение объявления",
     *         @OA\JsonContent(
     *             @OA\Property(property="title", type="string", example="Название объявления"),
     *             @OA\Property(property="price", type="int", example="10000"),
     *             @OA\Property(property="photo", type="string", example="http://tapir.localhost/storage/announcements/1/images/image1.jpg"),
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Объявление не найдено",
     *         @OA\JsonContent(
     *             @OA\Property(property="status", type="string", example="error_not_found"),
     *             @OA\Property(property="message", type="string", example="Not Found."),
     *         )
     *     )
     * )
     */
    public function show(Announcement $announcement, AnnouncementService $announcementService)
    {
        return response()->json($announcementService->show($announcement));
    }

}
