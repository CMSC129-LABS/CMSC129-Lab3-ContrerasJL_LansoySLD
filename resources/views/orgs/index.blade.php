@extends('layouts.app')

@section('content')
<div class="w-full mx-auto px-6 py-6 grid grid-cols-2 gap-5 items-start">

    <!-- left panel (org details) -->
    <div class="sticky top-20 flex flex-col gap-3">

        <!-- cover plus logo -->
        <div class="bg-white border-2 border-gray-200 rounded-2xl p-4 shadow-sm">
            <div class="relative">
                <!-- cover -->
                <div class="bg-[#1a1a1a] rounded-2xl aspect-[16/7] flex items-center justify-center">
                    <svg class="w-12 h-12 fill-white opacity-20" viewBox="0 0 24 24">
                        <path d="M21 19V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2zM8.5 13.5l2.5 3 3.5-4.5 4.5 6H5l3.5-4.5z"/>
                    </svg>
                </div>
                <!-- logo -->
                <div class="absolute -bottom-6 left-4 w-28 h-28 rounded-full bg-white border-4 border-white shadow-md flex items-center justify-center overflow-hidden">
                    <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                        <svg class="w-8 h-8 fill-gray-400" viewBox="0 0 24 24">
                            <path d="M21 19V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2zM8.5 13.5l2.5 3 3.5-4.5 4.5 6H5l3.5-4.5z"/>
                        </svg>
                    </div>
                </div>
            </div>
            <!-- spacer -->
            <div class="mt-5"></div>
        </div>

        <!-- info card -->
        <div class="w-full bg-cream-dark border-2 border-gray-200 rounded-2xl p-4 shadow-sm">

            <!-- name and status -->
            <div class="flex items-center justify-between gap-2 mb-2">
                <span class="font-head font-bold text-lg text-upv-maroon">UPV Komsai.Org</span>
                <span class="bg-upv-green text-white text-xs font-semibold px-4 py-1 rounded-full shrink-0">
                    active
                </span>
            </div>

            <!-- Description -->
            <p class="text-sm leading-relaxed text-gray-600 mb-4">
                UPV Komsai.Org is a university-wide organization for anyone who has taken up at least 3.0 units of CMSC
                or any equivalent course, BS Computer Science students, faculty, and alumni of the University of the
                Philippines Visayas.
            </p>

            <!-- Meta row -->
            <div class="bg-white rounded-2xl border border-gray-200 px-4 py-3 flex flex-wrap gap-x-6 gap-y-3">

                <!-- Members -->
                <div class="flex flex-col gap-0.5">
                    <span class="text-[0.62rem] text-gray-400 lowercase tracking-wide">members</span>
                    <span class="text-sm font-semibold text-gray-800 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="#555" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/>
                            <circle cx="9" cy="7" r="4"/>
                        </svg>
                        130
                    </span>
                </div>

                <!-- Divider -->
                <div class="w-px bg-gray-200 self-stretch"></div>

                <!-- Type -->
                <div class="flex flex-col gap-0.5">
                    <span class="text-[0.62rem] text-gray-400 lowercase tracking-wide">type</span>
                    <span class="text-sm font-semibold text-gray-800 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="#555" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24">
                            <rect x="2" y="3" width="20" height="14" rx="2"/>
                            <path d="M8 21h8M12 17v4"/>
                        </svg>
                        academic
                    </span>
                </div>

                <!-- Divider -->
                <div class="w-px bg-gray-200 self-stretch"></div>

                <!-- Email -->
                <div class="flex flex-col gap-0.5">
                    <span class="text-[0.62rem] text-gray-400 lowercase tracking-wide">email</span>
                    <span class="text-sm font-semibold text-gray-800 flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" stroke="#555" stroke-width="2" stroke-linecap="round" viewBox="0 0 24 24">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/>
                            <polyline points="22,6 12,13 2,6"/>
                        </svg>
                        upvkomsai@gmail.com
                    </span>
                </div>

            </div>
        </div>
    </div>

   <!-- right panel (org list) -->
    <div class="flex flex-col gap-2">

        <!-- Active / selected row -->
        <div class="flex items-center gap-3 px-4 py-3 bg-upv-green rounded-xl cursor-pointer">
            <div class="w-9 h-9 rounded-full bg-white/20 border-2 border-white/40 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 fill-white opacity-60" viewBox="0 0 24 24">
                    <path d="M21 19V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2zM8.5 13.5l2.5 3 3.5-4.5 4.5 6H5l3.5-4.5z"/>
                </svg>
            </div>
            <span class="text-white font-head font-bold text-sm flex-1">UPV Komsai.Org</span>
            <a href="#" class="text-white/70">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
            </a>
            <a href="#" class="text-white/70">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                    <path d="M10 11v6M14 11v6"/>
                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                </svg>
            </a>
        </div>

        <!-- Regular rows -->
        @for ($i = 0; $i < 8; $i++)
        <div class="flex items-center gap-3 px-4 py-3 bg-white border border-gray-200 rounded-xl cursor-pointer">
            <div class="w-10 h-9 rounded-full bg-gray-100 border-2 border-gray-300 flex items-center justify-center shrink-0">
                <svg class="w-4 h-4 fill-gray-400" viewBox="0 0 24 24">
                    <path d="M21 19V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2zM8.5 13.5l2.5 3 3.5-4.5 4.5 6H5l3.5-4.5z"/>
                </svg>
            </div>
            <span class="text-gray-800 font-head font-semibold text-sm flex-1">UPV Komsai.Org</span>
            <a href="#" class="text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" viewBox="0 0 24 24">
                    <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/>
                    <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/>
                </svg>
            </a>
            <a href="#" class="text-gray-400">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="1.8" stroke-linecap="round" viewBox="0 0 24 24">
                    <polyline points="3 6 5 6 21 6"/>
                    <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                    <path d="M10 11v6M14 11v6"/>
                    <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                </svg>
            </a>
        </div>
        @endfor
    </div>
</div>
@endsection