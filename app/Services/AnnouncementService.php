<?php

namespace App\Services;


use App\Http\Resources\AnnouncementResource;
use App\Models\Announcement;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Collection;

class AnnouncementService
{

    public function create(array $data): Announcement
    {
        return Announcement::create($data);
    }

    public function index($withPaginate = true)
    {
        $announcements = Announcement::with('images');

        $sort_field = request('sort_field', false);

        if ($sort_field) {
            $announcements->orderBy($sort_field, request('sort_direction', 'asc'));
        }

        if ($withPaginate) {
            $announcements = $announcements->paginate(10)->items();
        } else {
            $announcements = $announcements->get();
        }

        return AnnouncementResource::collection($announcements);
    }

    public function show(Announcement $announcement): JsonResource
    {
        return new AnnouncementResource($announcement);
    }

}
