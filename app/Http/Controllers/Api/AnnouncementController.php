<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\IndexAnnouncementRequest;
use App\Http\Requests\StoreAnnouncementRequest;
use App\Jobs\UploadPhotoJob;
use App\Models\Announcement;
use App\Services\AnnouncementService;
use App\Services\ImageService;

class AnnouncementController extends Controller
{

    public function store(StoreAnnouncementRequest $request, AnnouncementService $announcementService, ImageService $imageService)
    {
        $announcement = $announcementService->create($request->only('title', 'description', 'price'));
        $this->dispatch(new UploadPhotoJob($imageService->create($announcement, $request->get('images'))));
        return response()->json(['status' => 'success', 'ID' => $announcement->id])->setStatusCode(201);
    }

    public function index(IndexAnnouncementRequest $request, AnnouncementService $announcementService)
    {
        return response()->json(['announcements' => $announcementService->index()]);
    }

    public function show(Announcement $announcement, AnnouncementService $announcementService)
    {
        return response()->json($announcementService->show($announcement));
    }

}
