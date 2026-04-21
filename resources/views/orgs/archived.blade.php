@extends('layouts.app')
@include('components.chatbot')
@use('Illuminate\Support\Facades\Storage')

@section('content')
    <div class="w-full mx-auto px-6 py-6 grid grid-cols-2 gap-5 items-start">

        <!-- left panel -->
        <div class="sticky top-20 flex flex-col gap-3">
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
                <div class="mt-8"></div>
            </div>

            <!-- info card -->
            <div class="w-full bg-cream-dark border-2 border-gray-200 rounded-2xl p-4 shadow-sm">
                @if ($selected)
                    <div class="flex items-center justify-between gap-2 mb-2">
                        <span class="font-head font-bold text-lg text-upv-maroon">{{ $selected->name }}</span>
                        <span class="bg-upv-coral text-white text-xs font-semibold px-4 py-1 rounded-full shrink-0">
                            archived
                        </span>
                    </div>

                    <p class="text-sm leading-relaxed text-gray-600 mb-4">
                        {{ $selected->description ?? 'No description available.' }}
                    </p>

                    <div class="bg-white rounded-2xl border border-gray-200 px-4 py-3 flex flex-wrap gap-x-6 gap-y-3">
                        <div class="flex flex-col gap-0.5">
                            <span class="text-[0.62rem] text-gray-400 lowercase tracking-wide">members</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $selected->members }}</span>
                        </div>
                        <div class="w-px bg-gray-200 self-stretch"></div>
                        <div class="flex flex-col gap-0.5">
                            <span class="text-[0.62rem] text-gray-400 lowercase tracking-wide">type</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $selected->type }}</span>
                        </div>
                        <div class="w-px bg-gray-200 self-stretch"></div>
                        <div class="flex flex-col gap-0.5">
                            <span class="text-[0.62rem] text-gray-400 lowercase tracking-wide">email</span>
                            <span class="text-sm font-semibold text-gray-800">{{ $selected->email ?? 'N/A' }}</span>
                        </div>
                    </div>
                @else
                    <p class="text-sm text-gray-400 text-center py-6">No archived organizations.</p>
                @endif
            </div>
        </div>

        <!-- right panel -->
        <div class="flex flex-col gap-2">

            @forelse($orgs as $org)
                <div data-org-item data-org-selected="{{ $selected && $selected->id === $org->id ? 'true' : 'false' }}"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl cursor-pointer
                    {{ $selected && $selected->id === $org->id ? 'bg-upv-coral/10 border-2 border-upv-coral' : 'bg-white border border-gray-200' }}">

                    <div
                        class="w-9 h-9 rounded-full bg-gray-100 border-2 border-gray-300 flex items-center justify-center shrink-0 overflow-hidden">
                        @if ($org->logo)
                            <img src="{{ Storage::url($org->logo) }}" class="w-full h-full object-cover">
                        @else
                            <svg class="w-4 h-4 fill-gray-400" viewBox="0 0 24 24">
                                <path
                                    d="M21 19V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2zM8.5 13.5l2.5 3 3.5-4.5 4.5 6H5l3.5-4.5z" />
                            </svg>
                        @endif
                    </div>

                    <a href="{{ route('orgs.archived.show', $org->id) }}"
                        class="font-head font-bold text-sm flex-1 no-underline text-gray-800">
                        {{ $org->name }}
                    </a>

                    <!-- days remaining -->
                    <span class="text-xs {{ $org->days_left !== null && $org->days_left <= 7 ? 'text-red-400' : 'text-gray-400' }} font-medium whitespace-nowrap">
                        {{ $org->days_left !== null ? "deletes in {$org->days_left} days" : '' }}
                    </span>

                    <!-- Restore -->
                    <form method="POST" action="{{ route('orgs.restore', $org->id) }}">
                        @csrf
                        @method('PUT')
                        <button type="submit"
                            class="flex items-center gap-1 text-upv-green text-xs font-semibold px-3 py-1 border-2 border-upv-green rounded-full hover:bg-green-100">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" viewBox="0 0 24 24">
                                <path d="M3 12a9 9 0 1 0 9-9 9.75 9.75 0 0 0-6.74 2.74L3 8" />
                                <path d="M3 3v5h5" />
                            </svg>
                            restore
                        </button>
                    </form>

                    <!-- delete -->
                    <button onclick="openDeleteModal('{{ route('orgs.destroy', $org->id) }}')"
                        class="flex items-center gap-1 text-upv-coral text-xs font-semibold px-3 py-1 border-2 border-upv-coral rounded-full hover:bg-red-100">
                        <svg class="w-3 h-3" fill="none" stroke="currentColor" stroke-width="2.5"
                            stroke-linecap="round" viewBox="0 0 24 24">
                            <polyline points="3 6 5 6 21 6" />
                            <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                            <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                        </svg>
                        delete
                    </button>

                </div>
            @empty
                <div class="flex flex-col items-center justify-center py-16 text-center">
                    <p class="text-sm text-gray-400 font-medium">No archived organizations yet.</p>
                </div>
            @endforelse

        </div>
    </div>

    <!-- delete Confirmation Modal -->
    <div id="deleteConfirmModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-xl p-6 w-full max-w-sm mx-4 border-2 border-gray-100">
            <div class="flex flex-col items-center text-center gap-3">
                <!-- icon -->
                <div class="w-12 h-12 rounded-full bg-upv-coral/10 flex items-center justify-center">
                    <svg class="w-6 h-6 text-upv-coral" fill="none" stroke="currentColor" stroke-width="2"
                        stroke-linecap="round" viewBox="0 0 24 24">
                        <polyline points="3 6 5 6 21 6" />
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6" />
                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2" />
                    </svg>
                </div>
                <h2 class="font-head font-bold text-lg text-gray-800">delete forever?</h2>
                <p class="text-sm text-gray-400">this action is permanent and cannot be undone. the org and all its data will be gone.</p>
            </div>

            <div class="flex gap-2 mt-6">
                <button onclick="closeDeleteModal()"
                    class="flex-1 border-2 border-gray-200 text-gray-500 text-sm font-semibold py-2 rounded-full hover:bg-gray-50 transition-colors">
                    cancel
                </button>
                <form id="deleteConfirmForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="flex-1 bg-upv-coral text-white text-sm font-semibold py-2 px-6 rounded-full hover:opacity-90 transition-opacity">
                        yes, delete
                    </button>
                </form>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.querySelectorAll('[data-org-item]').forEach(item => {
                if (item.dataset.orgSelected === 'true') return;
                item.addEventListener('mouseenter', () => {
                    item.style.backgroundColor = '';
                    item.style.borderColor = 'rgb(220, 81, 60)';
                });
                item.addEventListener('mouseleave', () => {
                    item.style.backgroundColor = '';
                    item.style.borderColor = '';
                });
            });

            function openDeleteModal(action) {
                document.getElementById('deleteConfirmForm').action = action;
                document.getElementById('deleteConfirmModal').classList.remove('hidden');
            }

            function closeDeleteModal() {
                document.getElementById('deleteConfirmModal').classList.add('hidden');
            }

            document.getElementById('deleteConfirmModal').addEventListener('click', function(e) {
                if (e.target === this) closeDeleteModal();
            });
        </script>
    @endpush
@endsection