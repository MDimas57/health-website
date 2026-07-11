<x-filament-widgets::widget>

    <x-filament::section>

        <x-slot name="heading">

            📊 Statistik Postingan konten

        </x-slot>

        <div class="overflow-x-auto">

            <table class="w-full">

                <thead>

                    <tr class="border-b">

                        <th class="text-left py-3">Topik Kesehatan</th>

                        <th class="text-center">Artikel</th>

                        <th class="text-center">Poster</th>

                        <th class="text-center">Video</th>

                        <th class="text-center">Dokumen</th>

                        <th class="text-center">Catatan</th>

                        <th class="text-center">Total</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($contributors as $user)

                        <tr class="border-b hover:bg-gray-50 dark:hover:bg-gray-800">

                            <td class="py-4">

                                <div class="flex items-center gap-3">

                                    <img
                                        src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=14b8a6&color=fff"
                                        class="w-10 h-10 rounded-full">

                                    <div>

                                        <div class="font-semibold">

                                            {{ $user->name }}

                                        </div>

                                        <div class="text-xs text-gray-500">

                                            {{ $user->email }}

                                        </div>

                                    </div>

                                </div>

                            </td>

                            <td class="text-center">

                                {{ $user->articles_count }}

                            </td>

                            <td class="text-center">

                                {{ $user->posters_count }}

                            </td>

                            <td class="text-center">

                                {{ $user->videos_count }}

                            </td>

                            <td class="text-center">

                                {{ $user->documents_count }}

                            </td>

                            <td class="text-center">

                                {{ $user->notes_count }}

                            </td>

                            <td class="text-center">

                                <span
                                    class="inline-flex px-3 py-1 rounded-full bg-primary-600 text-white font-semibold">

                                    {{ $user->total_content }}

                                </span>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </x-filament::section>

</x-filament-widgets::widget>