<x-pulse::card :cols="$cols" :rows="$rows" :class="$class">
    <x-pulse::card-header name="Pulse DB Auditor">
        <x-slot:icon>
            <x-pulse::icons.circle-stack />
        </x-slot:icon>
    </x-pulse::card-header>

    <x-pulse::scroll :expand="$expand" wire:poll.5s="">

        {{-- Database Summary --}}
        <x-pulse::table>
            <x-pulse::thead>
                <tr>
                    <x-pulse::th>Database Name</x-pulse::th>
                    <x-pulse::th>Database Size</x-pulse::th>
                    <x-pulse::th>Total Table Count</x-pulse::th>
                    <x-pulse::th>Engin</x-pulse::th>
                    <x-pulse::th>Character Set</x-pulse::th>
                </tr>
            </x-pulse::thead>
            <tbody>
                <tr class="h-2 first:h-0 "></tr>
                <tr>
                    <x-pulse::td>{{ $summary['database_name'] }}</x-pulse::td>
                    <x-pulse::td>{{ $summary['size'] }}</x-pulse::td>
                    <x-pulse::td>{{ $summary['table_count'] }}</x-pulse::td>
                    <x-pulse::td>{{ $summary['engin'] }}</x-pulse::td>
                    <x-pulse::td>{{ $summary['character_set'] }}</x-pulse::td>
                </tr>
            </tbody>
        </x-pulse::table>

        {{-- Table Summary --}}
        <x-pulse::table class="mt-4">
            <x-pulse::thead>
                <tr>
                    <x-pulse::th>Table Name</x-pulse::th>
                    <x-pulse::th>Total Primary Key</x-pulse::th>
                    <x-pulse::th>Total Index Key</x-pulse::th>
                    <x-pulse::th>Total Forign Key</x-pulse::th>
                    <x-pulse::th>Total Unique Key</x-pulse::th>
                    <x-pulse::th>Standard Result</x-pulse::th>
                </tr>
            </x-pulse::thead>
            <tbody>
                <tr class="h-2 first:h-0"></tr>
                @foreach ($constraintDetails as $tableName => $constraint)
                    @php
                        $standardResult = $constraint['standardResult']->where('name', $tableName)->first();

                    @endphp

                    <tr>
                        <x-pulse::td>{{ $tableName }}</x-pulse::td>
                        <x-pulse::td>{{ $constraint['primary_key_count'] }}</x-pulse::td>
                        <x-pulse::td>{{ $constraint['index_key_count'] }}</x-pulse::td>
                        <x-pulse::td>{{ $constraint['foreign_key_count'] }}</x-pulse::td>
                        <x-pulse::td>{{ $constraint['unique_key_count'] }}</x-pulse::td>
                        <x-pulse::td>
                            @if ($standardResult)
                                <p style="display: flex; justify-content: space-between;">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="red" class="w-6 h-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                                    </svg>
                                    <a href="/laravel-db-auditor" title="Stanadrd Info" id="info-btn-{{ $tableName }}" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke=""
                                            class="w-5 h-5 stroke-gray-400 dark:stroke-gray-600">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
                                        </svg>
                                    </a>
                                </p>
                            @else
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="green" class="w-6 h-6">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                </svg>
                            @endif
                        </x-pulse::td>
                    </tr>
                @endforeach
            </tbody>
        </x-pulse::table>

    </x-pulse::scroll>
   
</x-pulse::card>
