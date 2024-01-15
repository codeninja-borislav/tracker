<?php

namespace App\Console\Commands;

use App\Contracts\NotificationServiceInterface;
use App\Services\NotificationService;
use Illuminate\Console\Command;

class NotifyUsersCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:notify-users-command';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Notify users based on their subscription preferences';

    public function __construct(protected NotificationServiceInterface $notificationService)
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->notificationService->checkAndNotifyUsers();
    }
}
