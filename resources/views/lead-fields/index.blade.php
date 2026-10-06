
@extends('layouts.app')

@section('title', 'Lead Fields')

@section('content')

<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-6">

        <div>
            <h1 class="text-2xl font-bold text-gray-900">
                Lead Fields
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Manage fields available in the Lead form.
            </p>
        </div>

        <a href="{{ route('leads.form.create') }}"
           class="px-5 py-2.5 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700">
            + Create Field
        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="mb-6 rounded-lg border border-green-200 bg-green-50 p-4">
            <p class="text-sm text-green-700">
                {{ session('success') }}
            </p>
        </div>

    @endif


    {{-- Fields Table --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-gray-200">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            #
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            Label
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            Key
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            Type
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            Required
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            Status
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            List
                        </th>

                        <th class="px-6 py-3 text-left text-xs font-semibold text-gray-500 uppercase">
                            Sort
                        </th>

                        <th class="px-6 py-3 text-right text-xs font-semibold text-gray-500 uppercase">
                            Action
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-gray-200">

                    @forelse($fields as $field)

                        <tr class="hover:bg-gray-50">

                            {{-- ID --}}
                            <td class="px-6 py-4 text-sm text-gray-500">
                                {{ $field->id }}
                            </td>


                            {{-- Label --}}
                            <td class="px-6 py-4">

                                <div class="text-sm font-medium text-gray-900">
                                    {{ $field->label }}
                                </div>

                                @if($field->placeholder)

                                    <div class="text-xs text-gray-500 mt-1">
                                        {{ $field->placeholder }}
                                    </div>

                                @endif

                            </td>


                            {{-- Key --}}
                            <td class="px-6 py-4">

                                <code class="text-sm bg-gray-100 px-2 py-1 rounded">
                                    {{ $field->key }}
                                </code>

                            </td>


                            {{-- Type --}}
                            <td class="px-6 py-4">

                                <span class="text-sm text-gray-700">
                                    {{ ucfirst($field->type) }}
                                </span>

                            </td>


                            {{-- Required --}}
                            <td class="px-6 py-4">

                                @if($field->is_required)

                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-red-100 text-red-700">
                                        Required
                                    </span>

                                @else

                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600">
                                        Optional
                                    </span>

                                @endif

                            </td>


                            {{-- Status --}}
                            <td class="px-6 py-4">

                                @if($field->is_active)

                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-green-100 text-green-700">
                                        Active
                                    </span>

                                @else

                                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-gray-100 text-gray-600">
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            {{-- Show In List --}}
                            <td class="px-6 py-4">

                                @if($field->show_in_list)

                                    <span class="text-green-600 font-medium">
                                        Yes
                                    </span>

                                @else

                                    <span class="text-gray-400">
                                        No
                                    </span>

                                @endif

                            </td>


                            {{-- Sort Order --}}
                            <td class="px-6 py-4 text-sm text-gray-600">
                                {{ $field->sort_order }}
                            </td>


                            {{-- Actions --}}
                            <td class="px-6 py-4 text-right">

                                <a href="#"
                                   class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Edit
                                </a>

                                <span class="mx-2 text-gray-300">
                                    |
                                </span>

                                <a href="#"
                                   class="text-red-600 hover:text-red-800 text-sm font-medium">
                                    Delete
                                </a>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="9"
                                class="px-6 py-12 text-center">

                                <div class="text-gray-500">

                                    <p class="text-lg font-medium">
                                        No lead fields found
                                    </p>

                                    <p class="text-sm mt-1">
                                        Create your first custom lead field.
                                    </p>

                                    <a href="{{ route('lead-fields.create') }}"
                                       class="inline-block mt-4 text-blue-600 hover:text-blue-800 font-medium">
                                        + Create Lead Field
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection
