<!DOCTYPE html>
<html lang="en">

<head>
    @vite(['resources/css/app.css', 'resources/js/chatbot.js'])
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>UPV Orgz</title>

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
                UPV Org Hub
            </a>

            <!-- search and filter group -->
            <div class="flex items-center gap-2 flex-shrink-0">

                <!-- search bar -->
                <div class="relative">
                    <form method="GET" action="{{ route('orgs.index') }}"
                        class="flex items-center border-2 border-upv-green rounded-full overflow-hidden bg-transparent px-1"
                        style="width: 260px;">
                        <input type="text" name="q" id="searchInput" value="{{ request('q') }}"
                            placeholder="search organizations..." autocomplete="off"
                            class="flex-1 px-3 py-1.5 text-sm text-gray-700 bg-transparent outline-none font-body placeholder-gray-400">

                        <!-- clear button -->
                        <button type="button" id="clearSearch"
                            class="{{ request('q') ? '' : 'hidden' }} text-gray-400 hover:text-gray-600 mr-1">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" stroke-width="2.5"
                                stroke-linecap="round" viewBox="0 0 24 24">
                                <line x1="18" y1="6" x2="6" y2="18" />
                                <line x1="6" y1="6" x2="18" y2="18" />
                            </svg>
                        </button>

                        <button type="submit"
                            class="bg-upv-green rounded-full w-7 h-7 flex items-center justify-center shrink-0 mr-0.5">
                            <svg class="w-3.5 h-3.5 fill-white" viewBox="0 0 20 20">
                                <path
                                    d="M12.9 14.32a8 8 0 111.41-1.41l4.39 4.38-1.41 1.41-4.39-4.38zM8 14A6 6 0 108 2a6 6 0 000 12z" />
                            </svg>
                        </button>
                    </form>

                    <!-- suggestions dropdown -->
                    <div id="searchSuggestions"
                        class="hidden absolute left-0 top-11 bg-white border border-gray-200 rounded-xl shadow-lg z-50 w-full overflow-hidden">
                    </div>
                </div>

                <!-- filter button -->
                <div class="relative">
                    <button onclick="this.nextElementSibling.classList.toggle('hidden')"
                        class="flex items-center gap-1.5 border-2 border-upv-green text-upv-green rounded-full px-3 py-1.5 text-sm font-medium bg-transparent hover:bg-upv-green hover:text-white transition-colors duration-150">
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
                        <form method="GET" action="{{ route('orgs.index') }}">

                            @if (request('q'))
                                <input type="hidden" name="q" value="{{ request('q') }}">
                            @endif

                            <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider mb-3">Filter by</p>

                            <!-- status -->
                            <div class="mb-3">
                                <p class="text-xs text-gray-500 mb-1.5 font-medium">Status</p>
                                <div class="flex flex-wrap gap-1.5">
                                    <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                        <input type="radio" name="filter_status" value="all"
                                            class="accent-upv-green"
                                            {{ request('filter_status', 'all') === 'all' ? 'checked' : '' }}> All
                                    </label>
                                    <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                        <input type="radio" name="filter_status" value="active"
                                            class="accent-upv-green"
                                            {{ request('filter_status') === 'active' ? 'checked' : '' }}> Active
                                    </label>
                                    <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                        <input type="radio" name="filter_status" value="inactive"
                                            class="accent-upv-green"
                                            {{ request('filter_status') === 'inactive' ? 'checked' : '' }}> Inactive
                                    </label>
                                </div>
                            </div>

                            <!-- org type -->
                            <div class="mb-4">
                                <p class="text-xs text-gray-500 mb-1.5 font-medium">Type</p>
                                <div class="flex flex-wrap gap-1.5">
                                    <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                        <input type="checkbox" name="filter_type[]" value="academic"
                                            class="accent-upv-green"
                                            {{ in_array('academic', request('filter_type', [])) ? 'checked' : '' }}>
                                        Academic
                                    </label>
                                    <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                        <input type="checkbox" name="filter_type[]" value="sports"
                                            class="accent-upv-green"
                                            {{ in_array('sports', request('filter_type', [])) ? 'checked' : '' }}>
                                        Sports
                                    </label>
                                    <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                        <input type="checkbox" name="filter_type[]" value="performer"
                                            class="accent-upv-green"
                                            {{ in_array('performer', request('filter_type', [])) ? 'checked' : '' }}>
                                        Arts & Performance
                                    </label>
                                    <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                        <input type="checkbox" name="filter_type[]" value="political"
                                            class="accent-upv-green"
                                            {{ in_array('political', request('filter_type', [])) ? 'checked' : '' }}>
                                        Political
                                    </label>
                                    <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                        <input type="checkbox" name="filter_type[]" value="culture_identity"
                                            class="accent-upv-green"
                                            {{ in_array('culture_identity', request('filter_type', [])) ? 'checked' : '' }}>
                                        Culture & Identity
                                    </label>
                                    <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                        <input type="checkbox" name="filter_type[]" value="media"
                                            class="accent-upv-green"
                                            {{ in_array('media', request('filter_type', [])) ? 'checked' : '' }}>
                                        Media & Publication
                                    </label>
                                    <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                        <input type="checkbox" name="filter_type[]" value="special_interest"
                                            class="accent-upv-green"
                                            {{ in_array('special_interest', request('filter_type', [])) ? 'checked' : '' }}>
                                        Special Interest
                                    </label>
                                    <label class="flex items-center gap-1.5 text-xs text-gray-700 cursor-pointer">
                                        <input type="checkbox" name="filter_type[]" value="other"
                                            class="accent-upv-green"
                                            {{ in_array('other', request('filter_type', [])) ? 'checked' : '' }}>
                                        Other
                                    </label>
                                </div>
                            </div>

                            <!-- apply + clear buttons -->
                            <div class="flex gap-2">
                                <button type="submit"
                                    class="flex-1 bg-upv-green text-white text-xs font-semibold py-1.5 rounded-full hover:opacity-90 transition-opacity">
                                    Apply filters
                                </button>
                                <a href="{{ route('orgs.index') }}"
                                    class="flex-1 text-center border-2 border-gray-300 text-gray-500 text-xs font-semibold py-1.5 rounded-full hover:opacity-90 transition-opacity no-underline">
                                    Clear
                                </a>
                            </div>

                        </form>
                    </div>
                </div>

            </div>

            <div class="flex-1"></div>

            <!-- orgs -->
            @php $onOrgs = request()->routeIs('orgs.index') || request()->routeIs('orgs.show'); @endphp
            <a href="{{ route('orgs.index') }}"
                class="flex items-center gap-1.5 text-sm font-medium px-4 py-1.5 rounded-full no-underline whitespace-nowrap transition-all duration-150
                {{ $onOrgs ? 'bg-upv-maroon text-white ring-2 ring-upv-maroon ring-offset-2 shadow-md' : 'bg-upv-maroon text-white hover:opacity-80' }}">
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
            <button onclick="handleAddOrg()"
                class="flex items-center gap-1.5 bg-upv-green text-white text-sm font-medium px-4 py-1.5 rounded-full whitespace-nowrap cursor-pointer border-0 hover:opacity-80 transition-all duration-150">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                    viewBox="0 0 24 24">
                    <line x1="12" y1="5" x2="12" y2="19" />
                    <line x1="5" y1="12" x2="19" y2="12" />
                </svg>
                add org
            </button>

            <!-- archived orgs -->
            @php $onArchived = request()->routeIs('orgs.archived') || request()->routeIs('orgs.archived.show'); @endphp
            <a href="{{ route('orgs.archived') }}"
                class="flex items-center gap-1.5 text-sm font-medium px-4 py-1.5 rounded-full no-underline whitespace-nowrap transition-all duration-150
                {{ $onArchived ? 'bg-upv-coral text-white ring-2 ring-upv-coral ring-offset-2 shadow-md' : 'bg-upv-coral text-white hover:opacity-80' }}">
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

    <script>
        function handleAddOrg() {
            const onArchived = {{ request()->routeIs('orgs.archived*') ? 'true' : 'false' }};
            if (onArchived) {
                window.location.href = "{{ route('orgs.index') }}?add=1";
            } else {
                openAddOrgModal();
            }
        }
        function closeAddOrgModal() {
            const modal = document.getElementById('addOrgModal');
            if (modal) modal.classList.add('hidden');
        }

        const searchInput = document.getElementById('searchInput');
        const suggestions = document.getElementById('searchSuggestions');
        const clearBtn = document.getElementById('clearSearch');

        // clear button click
        clearBtn.addEventListener('click', function() {
            searchInput.value = '';
            clearBtn.classList.add('hidden');
            suggestions.classList.add('hidden');
            suggestions.innerHTML = '';
            searchInput.closest('form').submit();
        });

        // single input listener
        searchInput.addEventListener('input', function() {
            const q = this.value.trim();

            // show/hide clear button
            clearBtn.classList.toggle('hidden', q.length === 0);

            if (q.length < 1) {
                suggestions.classList.add('hidden');
                suggestions.innerHTML = '';
                return;
            }

            fetch(`/orgs/search?q=${encodeURIComponent(q)}`)
                .then(res => res.json())
                .then(orgs => {
                    if (orgs.length === 0) {
                        suggestions.innerHTML = `
                            <div class="px-4 py-3 text-sm text-gray-400 text-center">
                                No organizations found.
                            </div>`;
                        suggestions.classList.remove('hidden');
                        return;
                    }

                    suggestions.innerHTML = orgs.map(org => `
                        <a href="/orgs/${org.id}"
                            class="flex items-center gap-3 px-4 py-2.5 hover:bg-gray-50 no-underline border-b border-gray-100 last:border-0">
                            <div class="w-8 h-8 rounded-full overflow-hidden bg-gray-100 flex items-center justify-center shrink-0">
                                ${org.logo
                                    ? `<img src="/storage/${org.logo}" class="w-full h-full object-cover">`
                                    : `<svg class="w-4 h-4 fill-gray-400" viewBox="0 0 24 24"><path d="M21 19V5a2 2 0 0 0-2-2H5a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2zM8.5 13.5l2.5 3 3.5-4.5 4.5 6H5l3.5-4.5z"/></svg>`
                                }
                            </div>
                            <div>
                                <p class="text-sm font-semibold text-gray-800 font-body">${org.name}</p>
                                <p class="text-xs text-gray-400 font-body">${org.type}</p>
                            </div>
                        </a>
                    `).join('');

                    suggestions.classList.remove('hidden');
                });
        });

        // hide when clicking outside
        document.addEventListener('click', function(e) {
            if (!searchInput.contains(e.target) && !suggestions.contains(e.target)) {
                suggestions.classList.add('hidden');
            }
        });

        // hide on Escape
        searchInput.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') suggestions.classList.add('hidden');
        });
    </script>

    <x-toast />
</body>

</html>
