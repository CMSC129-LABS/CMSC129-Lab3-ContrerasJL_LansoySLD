<?php
namespace App\Services;
use App\Models\Organization;

class FunctionCallService {
    public function getOrgsForPrompt(): array {
        return Organization::all()->map(fn($org) => [
            'name'        => $org->name,
            'type'        => $org->type        ?? 'N/A',
            'status'      => $org->status      ?? 'N/A',
            'members'     => $org->members     ?? 'N/A',
            'tags'        => $org->tags        ?? '',
            'description' => $org->description ?? '',
        ])->toArray();
    }
}