@extends('layouts.app')

@section('content')
    <div class="w-full mx-auto px-6 py-6 grid grid-cols-2 gap-5 items-start">

        <!-- left panel (org details) -->
        <div class="sticky top-20 flex flex-col gap-3">

            <!-- cover plus logo -->
            <div class="bg-white border-2 border-gray-200 rounded-2xl p-4 shadow-sm">
                <div class="relative">
                    <!-- cover -->
                    <div class="rounded-2xl aspect-[16/7] overflow-hidden bg-[#1a1a1a] flex items-center justify-center">
                        @if ($selected && $selected->cover)
                            <img src="{{ Storage::url($selected->cover) }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-12 h-12 fill-white opacity-20" viewBox="0 0 24 24">
                                <path
                                    d="M21 19V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2zM8.5 13.5l2.5 3 3.5-4.5 4.5 6H5l3.5-4.5z" />
                            </svg>
                        @endif
                    </div>
                    <!-- logo -->
                    <div
                        class="absolute -bottom-6 left-4 w-28 h-28 rounded-full bg-white border-4 border-white shadow-md flex items-center justify-center overflow-hidden">
                        @if ($selected && $selected->logo)
                            <img src="{{ Storage::url($selected->logo) }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                <svg class="w-8 h-8 fill-gray-400" viewBox="0 0 24 24">
                                    <path
                                        d="M21 19V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2zM8.5 13.5l2.5 3 3.5-4.5 4.5 6H5l3.5-4.5z" />
                                </svg>
                            </div>
                        @endif
                    </div>
                </div>
                <!-- spacer -->
                <div class="mt-8"></div>
            </div>

            <!-- info card -->
            <div class="w-full bg-cream-dark border-2 border-gray-200 rounded-2xl p-4 shadow-sm">
                @if ($selected)
                    <!-- name and status -->
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="font-head font-bold text-lg text-upv-maroon">{{ $selected->name }}</span>
                        <span
                            class="{{ $selected->status === 'active' ? 'bg-upv-green' : 'bg-gray-400' }} text-white text-xs font-semibold px-4 py-1 rounded-full shrink-0">
                            {{ $selected->status }}
                        </span>
                    </div>

                    <!-- Description -->
                    <p class="text-sm leading-relaxed text-gray-600 mb-4">
                        {{ $selected->description ?? 'No description available.' }}
                    </p>

                    <!-- Meta row -->
                    <div class="bg-white rounded-2xl border border-gray-200 px-4 py-3 flex flex-wrap gap-x-6 gap-y-3">

                        <!-- Members -->
                        <div class="flex flex-col gap-0.5">
                            <span class="text-[0.62rem] text-gray-400 lowercase tracking-wide">members</span>
                            <span class="text-sm font-semibold text-gray-800 flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="#555" stroke-width="2" stroke-linecap="round"
                                    viewBox="0 0 24 24">
                                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                    <circle cx="9" cy="7" r="4" />
                                </svg>
                                {{ $selected->members }}
                            </span>
                        </div>

                        <div class="w-px bg-gray-200 self-stretch"></div>

                        <!-- Type -->
                        <div class="flex flex-col gap-0.5">
                            <span class="text-[0.62rem] text-gray-400 lowercase tracking-wide">type</span>
                            <span class="text-sm font-semibold text-gray-800 flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="#555" stroke-width="2" stroke-linecap="round"
                                    viewBox="0 0 24 24">
                                    <rect x="2" y="3" width="20" height="14" rx="2" />
                                    <path d="M8 21h8M12 17v4" />
                                </svg>
                                {{ $selected->type }}
                            </span>
                        </div>

                        <div class="w-px bg-gray-200 self-stretch"></div>

                        <!-- Email -->
                        <div class="flex flex-col gap-0.5">
                            <span class="text-[0.62rem] text-gray-400 lowercase tracking-wide">email</span>
                            <span class="text-sm font-semibold text-gray-800 flex items-center gap-1.5">
                                <svg class="w-4 h-4" fill="none" stroke="#555" stroke-width="2" stroke-linecap="round"
                                    viewBox="0 0 24 24">
                                    <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                    <polyline points="22,6 12,13 2,6" />
                                </svg>
                                {{ $selected->email ?? 'N/A' }}
                            </span>
                        </div>

                    </div>
                @else
                    <p class="text-sm text-gray-400 text-center py-6">No organization found.</p>
                @endif
            </div>
        </div>

        <!-- right panel (org list) -->
        <div class="flex flex-col gap-2">

            @forelse($orgs as $org)
                <div
                    class="flex items-center gap-3 px-4 py-3 rounded-xl cursor-pointer
                    {{ $selected && $selected->id === $org->id ? 'bg-upv-green' : 'bg-white border border-gray-200' }}">

                    <!-- logo thumbnail -->
                    <div
                        class="w-9 h-9 rounded-full overflow-hidden flex items-center justify-center shrink-0
                        {{ $selected && $selected->id === $org->id ? 'bg-white/20 border-2 border-white/40' : 'bg-gray-100 border-2 border-gray-300' }}">
                        @if ($org->logo)
                            <img src="{{ Storage::url($org->logo) }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-4 h-4 {{ $selected && $selected->id === $org->id ? 'fill-white opacity-60' : 'fill-gray-400' }}"
                                viewBox="0 0 24 24">
                                <path
                                    d="M21 19V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2zM8.5 13.5l2.5 3 3.5-4.5 4.5 6H5l3.5-4.5z" />
                            </svg>
                        @endif
                    </div>

                    <!-- name — clicking selects the org -->
                    <a href="{{ route('orgs.show', $org->id) }}"
                        class="font-head font-bold text-sm flex-1 no-underline
                        {{ $selected && $selected->id === $org->id ? 'text-white' : 'text-gray-800' }}">
                        {{ $org->name }}
                    </a>

                    <!-- Edit -->
                    <button
                        onclick="openEditOrgModal({{ $org->id }}, '{{ addslashes($org->name) }}', '{{ addslashes($org->description) }}', '{{ $org->status }}', '{{ $org->type }}', '{{ $org->members }}', '{{ $org->email }}', '{{ $org->cover ? Storage::url($org->cover) : '' }}', '{{ $org->logo ? Storage::url($org->logo) : '' }}')"
                        class="{{ $selected && $selected->id === $org->id ? 'text-white/70' : 'text-gray-400' }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round"
                            viewBox="0 0 24 24">
                            <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" />
                            <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" />
                        </svg>
                    </button>

                    <!-- Archive -->
                    <form method="POST" action="{{ route('orgs.archive', $org->id) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                            class="{{ $selected && $selected->id === $org->id ? 'text-white/70' : 'text-gray-400' }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8"
                                stroke-linecap="round" stroke-linejoin="round" viewBox="0 0 24 24">
                                <polyline points="21 8 21 21 3 21 3 8" />
                                <rect x="1" y="3" width="22" height="5" />
                                <line x1="10" y1="12" x2="14" y2="12" />
                            </svg>
                        </button>
                    </form>

                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <p class="text-sm text-gray-400 font-medium">No organizations found.</p>
                    <button onclick="openAddOrgModal()" class="mt-3 text-upv-green text-sm font-semibold">+ add one</button>
                </div>
            @endforelse

        </div>
    </div>

    {{-- Modals --}}
    <x-modal-add-org />
    <x-modal-edit-org />

    @push('scripts')
        <script>
            // ── Add Org Modal ──
            function openAddOrgModal() {
                document.getElementById('addOrgModal').classList.remove('hidden');
            }

            function closeAddOrgModal() {
                document.getElementById('addOrgModal').classList.add('hidden');
            }

            // ── Edit Org Modal ──
            function openEditOrgModal(id, name, description, status, type, members, email, cover, logo) {
                document.getElementById('editOrgId').value = id;
                document.getElementById('editOrgName').value = name;
                document.getElementById('editOrgDesc').value = description;
                document.getElementById('editOrgMembers').value = members;
                document.getElementById('editOrgEmail').value = email;

                // status radio
                document.querySelectorAll('input[name="edit_status"]').forEach(r => {
                    r.checked = r.value === status;
                });

                // type select
                document.getElementById('editOrgType').value = type;

                // cover preview
                const coverPreview = document.getElementById('editCoverPreview');
                if (cover) {
                    coverPreview.src = cover;
                    coverPreview.classList.remove('hidden');
                } else {
                    coverPreview.src = '';
                    coverPreview.classList.add('hidden');
                }

                // logo preview
                const logoPreview = document.getElementById('editProfilePreview');
                if (logo) {
                    logoPreview.src = logo;
                    logoPreview.classList.remove('hidden');
                } else {
                    logoPreview.src = '';
                    logoPreview.classList.add('hidden');
                }

                document.getElementById('editOrgModal').classList.remove('hidden');
            }

            function closeEditOrgModal() {
                document.getElementById('editOrgModal').classList.add('hidden');
            }

            // ── Image Preview ──
            function previewImage(input, previewId) {
                const file = input.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = document.getElementById(previewId);
                        preview.src = e.target.result;
                        preview.classList.remove('hidden');
                    }
                    reader.readAsDataURL(file);
                }
            }

            // ── Close modals when clicking outside ──
            document.getElementById('addOrgModal').addEventListener('click', function(e) {
                if (e.target === this) closeAddOrgModal();
            });

            // ── Auto open add modal if validation errors ──
            @if ($errors->any())
                openAddOrgModal();
            @endif
        </script>
    @endpush
@endsection