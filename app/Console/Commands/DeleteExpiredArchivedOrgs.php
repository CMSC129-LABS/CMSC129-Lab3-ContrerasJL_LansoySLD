<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Organization;
use Illuminate\Support\Facades\Storage;

class DeleteExpiredArchivedOrgs extends Command
{
    protected $signature   = 'orgs:delete-expired';
    protected $description = 'Delete orgs that have been archived for more than 30 days';

    public function handle()
    {
        $expired = Organization::where('is_archived', true)
            ->where('archived_at', '<=', now()->subDays(30))
            ->get();

        foreach ($expired as $org) {
            if ($org->logo)  Storage::disk('public')->delete($org->logo);
            if ($org->cover) Storage::disk('public')->delete($org->cover);
            $org->delete();
        }

        $this->info("Deleted {$expired->count()} expired archived organizations.");
    }
}
