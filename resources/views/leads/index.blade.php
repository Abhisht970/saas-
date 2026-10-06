@extends('layouts.app')

@section('content')

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="flex items-center justify-between mb-6">
            <div>
                <h1 class="text-2xl font-bold text-gray-900">
                    Leads
                </h1>

                <p class="mt-1 text-sm text-gray-500">
                    Manage your CRM leads
                </p>
            </div>

            <a href="{{ route('leads.create') }}"
                class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
                + Add Lead
            </a>
        </div>

        {{-- Leads Table --}}
        <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    
                    <thead class="bg-gray-50">
                        <tr>
                            @foreach ($customFields as $field)

                                <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                                    {{ $field->label }}
                                </th>

                            @endforeach
                            
                            <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">
                                Action
                            </th>

                        </tr>

                    </thead>


                    {{-- Table Body --}}
                    <tbody class="divide-y divide-gray-200">

                        @forelse ($leads as $lead)

                            <tr class="hover:bg-gray-50">

                                @foreach ($customFields as $field)

                                    <td class="px-6 py-4 text-sm text-gray-700">

                                        @php
                                            $value = $lead->custom_data[$field->key] ?? null;
                                        @endphp


                                        @if (is_array($value))

                                            {{ implode(', ', $value) }}

                                        @elseif ($value !== null && $value !== '')

                                            {{ $value }}

                                        @else

                                            <span class="text-gray-400">
                                                -
                                            </span>

                                        @endif

                                    </td>

                                @endforeach


                                {{-- Action --}}
                                <td class="px-6 py-4 text-right">

                                    <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                        View
                                    </a>

                                    <span class="mx-2 text-gray-300">
                                        |
                                    </span>

                                    <a href="#" class="text-indigo-600 hover:text-indigo-800 text-sm font-medium">
                                        Edit
                                    </a>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="{{ $customFields->count() + 1 }}" class="px-6 py-12 text-center text-gray-500">

                                    No leads found.

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>
            </div>

        </div>

    </div>

@endsection