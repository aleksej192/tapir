<?php

namespace App\Console\Commands;

use App\Models\Announcement;
use App\Services\AnnouncementService;
use Illuminate\Console\Command;

class GetAnnouncement extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'announcement:get {announcement?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Получение списка объявлений';

    private $announcementService;

    /**
     * Create a new command instance.
     *
     * @param AnnouncementService $announcementService
     */
    public function __construct(AnnouncementService $announcementService)
    {
        parent::__construct();
        $this->announcementService = $announcementService;
    }

    /**
     * Execute the console command.
     *
     */
    public function handle()
    {
        $announcement = $this->argument('announcement');
        $rows = $announcement ?
            [$this->announcementService->show(Announcement::find($this->argument('announcement')))->jsonSerialize()]
            :
            $this->announcementService->index(false)->jsonSerialize();
        $this->table(['title', 'price', 'photo'], $rows);
    }
}
