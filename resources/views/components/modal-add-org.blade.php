<!-- backdrop -->
<div id="addOrgModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 hidden">

    <!-- modal box -->
    <div class="bg-white rounded-2xl shadow-2xl w-full max-w-2xl mx-4 relative">

        <!-- close button -->
        <button onclick="closeAddOrgModal()"
            class="absolute top-4 right-5 text-gray-500 text-xl font-bold leading-none z-10 hover:opacity-80 transition-opacity duration-150">
            ✕
        </button>

        <form method="POST" action="{{ route('orgs.store') }}" enctype="multipart/form-data">
            @csrf

            <div class="relative w-full rounded-t-2xl overflow-visible">
                <!-- cover photo banner -->
                <label
                    class="block w-full h-36 bg-gray-100 rounded-t-2xl cursor-pointer overflow-hidden relative group border-b-2 border-upv-green">
                    <img id="coverPreview" alt="" class="w-full h-full object-cover hidden">
                    <div class="absolute inset-0 flex items-center justify-center gap-3 pointer-events-none">
                        <span class="w-9 h-9 rounded-full bg-black/50 flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round" viewBox="0 0 24 24">
                                <path
                                    d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                                <circle cx="12" cy="13" r="4" />
                            </svg>
                        </span>
                        <!-- tooltip -->
                        <span
                            class="absolute bottom-3 left-1/2 -translate-x-1/2 bg-gray-900/80 text-white text-xs rounded-lg px-3 py-1.5 whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                            Click to upload cover photo
                        </span>
                    </div>
                    <input type="file" name="cover" accept="image/*" class="hidden"
                        onchange="previewImage(this, 'coverPreview')">
                </label>

                <!-- profile photo circle -->
                <div class="absolute -bottom-10 left-6 group">
                    <label
                        class="block w-20 h-20 rounded-full border-2 border-upv-green bg-gray-200 cursor-pointer overflow-hidden relative">
                        <img id="profilePreview" alt="" class="w-full h-full object-cover hidden">
                        <div
                            class="absolute inset-0 flex items-center justify-center bg-black/30 rounded-full pointer-events-none">
                            <svg class="w-5 h-5" fill="none" stroke="white" stroke-width="1.8" stroke-linecap="round"
                                stroke-linejoin="round" viewBox="0 0 24 24">
                                <path
                                    d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z" />
                                <circle cx="12" cy="13" r="4" />
                            </svg>
                        </div>
                        <input type="file" name="logo" accept="image/*" class="hidden"
                            onchange="previewImage(this, 'profilePreview')">
                    </label>
                    <span
                        class="absolute -bottom-8 left-1/2 -translate-x-1/2 bg-gray-900/80 text-white text-xs rounded-lg px-3 py-1.5 whitespace-nowrap opacity-0 group-hover:opacity-100 transition-opacity duration-200 pointer-events-none">
                        Click to upload profile photo
                    </span>
                </div>
            </div>

            <!-- form fields  -->
            <div class="pt-14 px-7 pb-7">
                <div class="grid grid-cols-2 gap-x-8 gap-y-5">

                    <div class="flex flex-col gap-4">

                        <!-- name org -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-1.5">
                                Name of the org?
                            </label>
                            <input type="text" name="name" placeholder="Type name here..."
                                class="w-full border-2 border-upv-green rounded-xl px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 outline-none font-body">
                        </div>

                        <!-- description -->
                        <div class="flex flex-col flex-1">
                            <label class="block text-sm font-semibold text-gray-800 mb-1.5">
                                Describe the org
                            </label>
                            <textarea name="description" placeholder="Type description here..." rows="5"
                                class="w-full h-full border-2 border-upv-green rounded-xl px-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 outline-none resize-none font-body"></textarea>
                        </div>

                    </div>

                    <div class="flex flex-col gap-4">

                        <!-- active / inactive -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-1.5">
                                Active or Inactive?
                            </label>
                            <div class="flex items-center gap-5">
                                <label class="flex items-center gap-1.5 cursor-pointer">
                                    <input type="radio" name="status" value="active" checked
                                        class="accent-upv-green w-4 h-4">
                                    <span class="text-sm text-gray-700">active</span>
                                </label>
                                <label class="flex items-center gap-1.5 cursor-pointer">
                                    <input type="radio" name="status" value="inactive"
                                        class="accent-upv-green w-4 h-4">
                                    <span class="text-sm text-upv-maroon font-medium">inactive</span>
                                </label>
                            </div>
                        </div>

                        <!-- Type -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-1.5">
                                Type of org?
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg class="w-4 h-4" fill="none" stroke="#555" stroke-width="2"
                                        stroke-linecap="round" viewBox="0 0 24 24">
                                        <rect x="2" y="3" width="20" height="14" rx="2" />
                                        <path d="M8 21h8M12 17v4" />
                                    </svg>
                                </span>
                                <select name="type"
                                    class="w-full border-2 border-upv-green rounded-xl pl-9 pr-4 py-2.5 text-sm text-gray-700 outline-none appearance-none bg-white font-body">
                                    <option value="academic">Academic</option>
                                    <option value="sports">Sports</option>
                                    <option value="performer">Arts & Performance</option>
                                    <option value="political">Political</option>
                                    <option value="culture_identity">Culture & Identity</option>
                                    <option value="media">Media & Publication</option>
                                    <option value="special_interest">Special Interest</option>
                                    <option value="other">Other</option>
                                </select>
                                <span class="absolute right-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg class="w-4 h-4 stroke-gray-500" fill="none" stroke-width="2"
                                        stroke-linecap="round" viewBox="0 0 24 24">
                                        <polyline points="6 9 12 15 18 9" />
                                    </svg>
                                </span>
                            </div>
                        </div>

                        <!-- unmber of members -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-1.5">
                                Number of members?
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg class="w-4 h-4" fill="none" stroke="#555" stroke-width="2"
                                        stroke-linecap="round" viewBox="0 0 24 24">
                                        <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" />
                                        <circle cx="9" cy="7" r="4" />
                                    </svg>
                                </span>
                                <input type="number" name="members" placeholder="Type no. here..."
                                    class="w-full border-2 border-upv-green rounded-xl pl-9 pr-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 outline-none font-body">
                            </div>
                        </div>

                        <!-- email -->
                        <div>
                            <label class="block text-sm font-semibold text-gray-800 mb-1.5">
                                Email?
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none">
                                    <svg class="w-4 h-4" fill="none" stroke="#555" stroke-width="2"
                                        stroke-linecap="round" viewBox="0 0 24 24">
                                        <path
                                            d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" />
                                        <polyline points="22,6 12,13 2,6" />
                                    </svg>
                                </span>
                                <input type="email" name="email" placeholder="Type email here..."
                                    class="w-full border-2 border-upv-green rounded-xl pl-9 pr-4 py-2.5 text-sm text-gray-700 placeholder-gray-400 outline-none font-body">
                            </div>
                        </div>

                    </div>

                </div>

                <!-- submit -->
              <button type="submit"
                class="w-full mt-6 bg-upv-green text-white font-head font-bold text-base py-3 rounded-xl hover:opacity-80 transition-opacity duration-150">
                add new org
            </button>

            </div>

        </form>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('addOrgModal').addEventListener('click', function(e) {
            if (e.target === this) closeAddOrgModal();
        });
    });
</script>
