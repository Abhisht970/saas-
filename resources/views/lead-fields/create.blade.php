@extends('layouts.app')

@section('title', 'Create Lead Field')

@section('content')

    <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

        {{-- Header --}}
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-gray-900">
                Create Lead Field
            </h1>

            <p class="mt-1 text-sm text-gray-500">
                Create a custom field for leads
            </p>
        </div>


        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="mb-6 rounded-lg border border-red-200 bg-red-50 p-4">
                <ul class="list-disc list-inside text-sm text-red-600">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif


        <div class="bg-white border border-gray-200 rounded-xl shadow-sm">

            <form method="POST" action="{{ route('leads.form.store') }}">

                @csrf


                {{-- Field Information --}}
                <div class="p-6 border-b border-gray-200">

                    <h2 class="text-lg font-semibold text-gray-900 mb-6">
                        Field Information
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">


                        {{-- Label --}}
                        <div>
                            <label for="label" class="block text-sm font-medium text-gray-700 mb-2">
                                Field Label
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" id="label" name="label" value="{{ old('label') }}" maxlength="255"
                                placeholder="Example: Industry" required
                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body">
                        </div>


                        {{-- Key --}}
                        <div>
                            <label for="key" class="block text-sm font-medium text-gray-700 mb-2">
                                Field Key
                                <span class="text-red-500">*</span>
                            </label>

                            <input type="text" id="key" name="key" value="{{ old('key') }}" maxlength="255"
                                placeholder="Example: industry" required
                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body">

                            <p class="mt-1 text-xs text-gray-500">
                                Unique key used internally.
                            </p>
                        </div>


                        {{-- Type --}}
                        <div>
                            <label for="type" class="block text-sm font-medium text-gray-700 mb-2">
                                Field Type
                                <span class="text-red-500">*</span>
                            </label>

                            <select id="type" name="type" required
                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body">

                                <option value="">
                                    Select field type
                                </option>

                                @foreach(\App\Models\LeadField::TYPES as $type)

                                    <option value="{{ $type }}" {{ old('type') === $type ? 'selected' : '' }}>

                                        {{ ucfirst($type) }}

                                    </option>

                                @endforeach

                            </select>
                        </div>


                        {{-- Placeholder --}}
                        <div>
                            <label for="placeholder" class="block text-sm font-medium text-gray-700 mb-2">
                                Placeholder
                            </label>

                            <input type="text" id="placeholder" name="placeholder" value="{{ old('placeholder') }}"
                                maxlength="255" placeholder="Enter placeholder"
                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body">
                        </div>


                        {{-- Max Length --}}
                        <div>
                            <label for="max_length" class="block text-sm font-medium text-gray-700 mb-2">
                                Max Length
                            </label>

                            <input type="number" id="max_length" name="max_length" value="{{ old('max_length') }}" min="1"
                                placeholder="Example: 100"
                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body">
                        </div>


                        {{-- Sort Order --}}
                        <div>
                            <label for="sort_order" class="block text-sm font-medium text-gray-700 mb-2">
                                Sort Order
                            </label>

                            <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}"
                                min="0" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body">
                        </div>

                    </div>

                </div>


                {{-- Options --}}
                <div class="p-6 border-b border-gray-200">

                    <h2 class="text-lg font-semibold text-gray-900 mb-2">
                        Options
                    </h2>

                    <p class="text-sm text-gray-500 mb-4">
                        Only required for Select / Multiselect fields.
                    </p>

                    <textarea name="options" rows="4" placeholder="Example:
    IT
    Finance
    Education
    Healthcare" class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body">{{ old('options') }}</textarea>

                </div>


                {{-- Field Settings --}}
                <div class="p-6 border-b border-gray-200">

                    <h2 class="text-lg font-semibold text-gray-900 mb-6">
                        Field Settings
                    </h2>

                    <div class="space-y-4">


                        {{-- Required --}}
                        <label class="flex items-center gap-3">

                            <input type="checkbox" name="is_required" value="1" {{ old('is_required') ? 'checked' : '' }}
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                            <span class="text-sm text-gray-700">
                                Required field
                            </span>

                        </label>


                        {{-- Active --}}
                        <label class="flex items-center gap-3">

                            <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }}
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                            <span class="text-sm text-gray-700">
                                Active
                            </span>

                        </label>


                        {{-- Show in List --}}
                        <label class="flex items-center gap-3">

                            <input type="checkbox" name="show_in_list" value="1" {{ old('show_in_list') ? 'checked' : '' }}
                                class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                            <span class="text-sm text-gray-700">
                                Show in lead list
                            </span>

                        </label>

                    </div>

                </div>


                {{-- Buttons --}}
                <div class="p-6 flex items-center justify-end gap-3">

                    <a href="{{ route('leads.form.create') }}"
                        class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                        Cancel
                    </a>

                    <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                        Create Field
                    </button>

                </div>

            </form>

        </div>

    </div>

@endsection