<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Organization;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class OrganizationSeeder extends Seeder
{
    public function run(): void
    {
        Storage::disk('public')->deleteDirectory('logos');
        Storage::disk('public')->deleteDirectory('covers');

        // clear existing data
        Organization::truncate();

        // read from JSON
        $json = File::get(database_path('seeders/data/organizations.json'));
        $orgs = json_decode($json, true);

        foreach ($orgs as $org) {
            $logoPath  = null;
            $coverPath = null;

            // copy logo
            if (!empty($org['logo'])) {
                $sourceLogo = database_path('seeders/data/images/logos/' . $org['logo']);
                $this->command->info('Looking for: ' . $sourceLogo);
                $this->command->info('Exists: ' . (File::exists($sourceLogo) ? 'YES ✅' : 'NO ❌'));
                if (File::exists($sourceLogo)) {
                    $logoPath = 'logos/' . $org['logo'];
                    Storage::disk('public')->put($logoPath, File::get($sourceLogo));
                    $this->command->info('Copied: ' . $logoPath);
                }
            }

            // copy cover
            if (!empty($org['cover'])) {
                $sourceCover = database_path('seeders/data/images/covers/' . $org['cover']);
                $this->command->info('Looking for: ' . $sourceCover);
                $this->command->info('Exists: ' . (File::exists($sourceCover) ? 'YES ✅' : 'NO ❌'));
                if (File::exists($sourceCover)) {
                    $coverPath = 'covers/' . $org['cover'];
                    Storage::disk('public')->put($coverPath, File::get($sourceCover));
                    $this->command->info('Copied: ' . $coverPath);
                }
            }

            Organization::create([
                'name'        => $org['name'],
                'description' => $org['description'],
                'type'        => $org['type'],
                'status'      => $org['status'],
                'email'       => $org['email'],
                'members'     => $org['members'],
                'is_archived' => $org['is_archived'],
                'logo'        => $logoPath,
                'cover'       => $coverPath,
                'archived_at' => $org['is_archived'] ? now() : null,
                'created_at'  => now(),
                'updated_at'  => now(),
            ]);
        }

        $this->command->info(' Organizations seeded!');
    }
}
