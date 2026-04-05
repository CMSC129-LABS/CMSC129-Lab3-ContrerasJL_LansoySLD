<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>UPV Orgz</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'upv-maroon': '#7b1c2e',
                        'upv-green': '#2d6a4f',
                        'upv-coral': '#e8836a',
                        'upv-border': '#d9cfc3',
                        'cream': '#fdf8f2',
                        'cream-dark': '#f5ede0',
                    },
                    fontFamily: {
                        head: ['Grandstander', 'cursive'],
                        body: ['Grandstander', 'sans-serif'],
                    },
                }
            }
        }
    </script>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Grandstander:ital,wght@0,400;0,600;0,700;0,800;1,700;1,800&display=swap"
        rel="stylesheet">

    @stack('styles')
</head>

<body class="bg-white font-body text-gray-900 min-h-screen">

    <!-- navbar -->
    <nav class="bg-white border-b border-gray-200 sticky top-0 z-50">
        <div class="max-w-6xl mx-auto px-6 flex items-center gap-3" style="height: 56px;">

            <!-- brand -->
            <a href="{{ route('orgs.index') }}"
                class="font-head font-extrabold text-3xl text-upv-maroon tracking-tight shrink-0 no-underline">
                Orgy Finder
            </a>

            <!-- search and filter group -->
            <div class="flex items-center gap-2 flex-shrink-0">

                <!-- search bar -->
                <form method="GET" action="{{ route('orgs.index') }}"
                    class="flex items-center border-2 border-upv-green rounded-full overflow-hidden bg-transparent px-1"
                    style="width: 260px;">
                    <input type="text" name="q" value="{{ request('q') }}"
                        placeholder="search organizations..." autocomplete="off"
                        class="flex-1 px-3 py-1.5 text-sm text-gray-700 bg-transparent outline-none font-body placeholder-gray-400">
                    <button type="submit"
                        class="bg-upv-green rounded-full w-7 h-7 flex items-center justify-center shrink-0 mr-0.5">
                        <svg class="w-3.5 h-3.5 fill-white" viewBox="0 0 20 20">
                            <path
                                d="M12.9 14.32a8 8 0 111.41-1.41l4.39 4.38-1.41 1.41-4.39-4.38zM8 14A6 6 0 108 2a6 6 0 000 12z" />
                        </svg>
                    </button>
                </form>

                <!-- filter button -->
                <div class="relative" x-data="{ open: false }">
                    <button onclick="this.nextElementSibling.classList.toggle('hidden')"
                        class="flex items-center gap-1.5 border-2 border-upv-green text-upv-green rounded-full px-3 py-1.5 text-sm font-medium bg-transparent">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2"
                            stroke-linecap="round" viewBox="0 0 24 24">
                            <line x1="4" y1="6" x2="20" y2="6" />
                            <line x1="8" y1="12" x2="16" y2="12" />
                            <line x1="11" y1="18" x2="13" y2="18" />
                        </svg>
                        filter
                    </button>

                    <!-- filter dropdown -->
                    <div
                        class="hidden absolute left-0 top-10 bg-white border border-gray-200 rounded-xl shadow-lg p-4 z-50 w-56">
                        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Filter by</p>

                        <!-- status -->
                        <div class="mb-3">
                            <p class="text-xs text-gray-500 mb-1.5 font-medium">Status</p>
                            <div class="flex flex-wrap gap-1.5">
                                <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                    <input type="radio" name="filter_status" value="all" class="accent-upv-green"
                                        checked> All
                                </label>
                                <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                    <input type="radio" name="filter_status" value="active" class="accent-upv-green">
                                    Active
                                </label>
                                <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                    <input type="radio" name="filter_status" value="inactive"
                                        class="accent-upv-green"> Inactive
                                </label>
                            </div>
                        </div>

                        <!-- org type -->
                        <div class="mb-4">
                            <p class="text-xs text-gray-500 mb-1.5 font-medium">Type</p>
                            <div class="flex flex-wrap gap-1.5">
                                <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                    <input type="checkbox" name="filter_type[]" value="academic"
                                        class="accent-upv-green"> Academic
                                </label>
                                <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                    <input type="checkbox" name="filter_type[]" value="sports" class="accent-upv-green">
                                    Sports
                                </label>
                                <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                    <input type="checkbox" name="filter_type[]" value="performer"
                                        class="accent-upv-green"> Arts & Performance
                                </label>
                                <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                    <input type="checkbox" name="filter_type[]" value="political"
                                        class="accent-upv-green"> Political
                                </label>
                                <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                    <input type="checkbox" name="filter_type[]" value="culture_identity"
                                        class="accent-upv-green"> Culture & Identity
                                </label>
                                <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                    <input type="checkbox" name="filter_type[]" value="media"
                                        class="accent-upv-green"> Media & Publication
                                </label>
                                <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                    <input type="checkbox" name="filter_type[]" value="special_interest"
                                        class="accent-upv-green"> Special Interest
                                </label>
                            </div>
                        </div>

                        <!-- apply button -->
                        <button class="w-full bg-upv-green text-white text-xs font-semibold py-1.5 rounded-full">
                            Apply filters
                        </button>
                    </div>
                </div>

            </div>

            <div class="flex-1"></div>

            <!-- nav button -->

            <!-- orgs -->
            <a href="{{ route('orgs.index') }}"
                class="flex items-center gap-1.5 bg-upv-maroon text-white text-sm font-medium px-4 py-1.5 rounded-full no-underline whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" viewBox="0 0 24 24">
                    <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                    <circle cx="9" cy="7" r="4" />
                    <path d="M23 21v-2a4 4 0 0 0-3-3.87" />
                    <path d="M16 3.13a4 4 0 0 1 0 7.75" />
                </svg>
                orgs
            </a>

            <!-- add org -->
            <button onClick="openAddOrgModal()"
                class="flex items-center gap-1.5 bg-upv-green text-white text-sm font-medium px-4 py-1.5 rounded-full no-underline whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                    viewBox="0 0 24 24">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                add org
            </button>

            <!-- archived orgs -->
            <a href="{{ route('orgs.archived') }}"
                class="flex items-center gap-1.5 bg-upv-coral text-white text-sm font-medium px-4 py-1.5 rounded-full no-underline whitespace-nowrap">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                    stroke-linejoin="round" viewBox="0 0 24 24">
                    <polyline points="21 8 21 21 3 21 3 8" />
                    <rect x="1" y="3" width="22" height="5" />
                    <line x1="10" y1="12" x2="14" y2="12" />
                </svg>
                archived orgs
            </a>

        </div>
    </nav>

    <main>
        @yield('content')
    </main>

    @stack('scripts')
</body>

</html>
