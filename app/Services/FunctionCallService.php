<?php

namespace App\Services;

use App\Models\Organization;

class FunctionCallService
{

    public function getOrgsForPrompt(): array
    {
        return Organization::where('is_archived', false)
            ->get()->map(fn($org) => [
                'id'          => $org->id,
                'name'        => $org->name,
                'type'        => $org->type        ?? 'N/A',
                'status'      => $org->status      ?? 'N/A',
                'members'     => $org->members     ?? 'N/A',
                'email'       => $org->email       ?? 'N/A',
                'description' => $org->description ?? '',
            ])->toArray();
    }

    // ── CRUD ──────────────────────────────────────────

    public function createOrg(array $data): array
    {
        $org = Organization::create([
            'name'        => $data['name'],
            'type'        => $data['type']        ?? 'other',
            'status'      => $data['status']      ?? 'active',
            'email'       => $data['email']       ?? null,
            'members'     => $data['members']     ?? 0,
            'description' => $data['description'] ?? null,
            'is_archived' => false,
        ]);
        return ['success' => true, 'org' => $org->toArray()];
    }

    public function updateOrg(int $id, array $data): array
    {
        $org = Organization::find($id);
        if (!$org) return ['success' => false, 'message' => 'Org not found.'];
        $org->update(array_filter($data, fn($v) => $v !== null));
        return ['success' => true, 'org' => $org->fresh()->toArray()];
    }

    public function archiveOrg(int $id): array
    {
        $org = Organization::find($id);
        if (!$org) return ['success' => false, 'message' => 'Org not found.'];
        $org->update(['is_archived' => true, 'archived_at' => now()]);
        return ['success' => true, 'message' => "'{$org->name}' has been archived."];
    }

    public function findOrgByName(string $name): ?array
    {
        $org = Organization::where('is_archived', false)
            ->where('name', 'ilike', "%{$name}%")
            ->first();
        return $org ? $org->toArray() : null;
    }
}
