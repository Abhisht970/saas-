@extends('layouts.app')

@section('title', 'Add Lead')

@section('content')

<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    {{-- Header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-900">
            Add Lead
        </h1>

        <p class="mt-1 text-sm text-gray-500">
            Create a new lead
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


    {{-- Form --}}
    <div class="bg-white border border-gray-200 rounded-xl shadow-sm">

        <form method="POST" action="{{ route('leads.store') }}" class="space-y-6">

            @csrf

            {{-- Lead Information --}}
            <div class="p-6 border-b border-gray-200">

                <h2 class="text-lg font-semibold text-gray-900 mb-6">
                    Lead Information
                </h2>

                  

            {{-- Custom Fields --}}
            @if(isset($fields) && $fields->count())

                <div class="p-6 border-b border-gray-200">

                    <h2 class="text-lg font-semibold text-gray-900 mb-6">
                        
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        @foreach($fields as $field)

                            <div>

                                <label for="custom_{{ $field->key }}"
                                       class="block text-sm font-medium text-gray-700 mb-2">

                                    {{ $field->label }}

                                    @if($field->is_required)
                                        <span class="text-red-500">*</span>
                                    @endif

                                </label>


                                @if($field->type === 'textarea')

                                    <textarea
                                        id="custom_{{ $field->key }}"
                                        name="custom_data[{{ $field->key }}]"
                                        rows="4"
                                        placeholder="{{ $field->placeholder }}"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body">{{ old('custom_data.' . $field->key) }}</textarea>


                                @elseif($field->type === 'select')

                                    <select
                                        id="custom_{{ $field->key }}"
                                        name="custom_data[{{ $field->key }}]"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body">

                                        <option value="">
                                            Select {{ $field->label }}
                                        </option>

                                        @foreach(($field->options ?? []) as $option)

                                            <option value="{{ $option }}"
                                                {{ old('custom_data.' . $field->key) == $option ? 'selected' : '' }}>
                                                {{ $option }}
                                            </option>

                                        @endforeach

                                    </select>


                                @elseif($field->type === 'number' || $field->type === 'currency')

                                    <input
                                        type="number"
                                        id="custom_{{ $field->key }}"
                                        name="custom_data[{{ $field->key }}]"
                                        value="{{ old('custom_data.' . $field->key) }}"
                                        placeholder="{{ $field->placeholder }}"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body">


                                @elseif($field->type === 'email')

                                    <input
                                        type="email"
                                        id="custom_{{ $field->key }}"
                                        name="custom_data[{{ $field->key }}]"
                                        value="{{ old('custom_data.' . $field->key) }}"
                                        placeholder="{{ $field->placeholder }}"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body">


                                @elseif($field->type === 'phone')

                                    <input
                                        type="text"
                                        id="custom_{{ $field->key }}"
                                        name="custom_data[{{ $field->key }}]"
                                        value="{{ old('custom_data.' . $field->key) }}"
                                        placeholder="{{ $field->placeholder }}"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body">


                                @elseif($field->type === 'url')

                                    <input
                                        type="url"
                                        id="custom_{{ $field->key }}"
                                        name="custom_data[{{ $field->key }}]"
                                        value="{{ old('custom_data.' . $field->key) }}"
                                        placeholder="{{ $field->placeholder }}"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body">


                                @elseif($field->type === 'date')

                                    <input
                                        type="date"
                                        id="custom_{{ $field->key }}"
                                        name="custom_data[{{ $field->key }}]"
                                        value="{{ old('custom_data.' . $field->key) }}"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body">


                                @elseif($field->type === 'datetime')

                                    <input
                                        type="datetime-local"
                                        id="custom_{{ $field->key }}"
                                        name="custom_data[{{ $field->key }}]"
                                        value="{{ old('custom_data.' . $field->key) }}"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body">


                                @elseif($field->type === 'checkbox')

                                    <div class="flex items-center gap-2 mt-3">

                                        <input
                                            type="checkbox"
                                            id="custom_{{ $field->key }}"
                                            name="custom_data[{{ $field->key }}]"
                                            value="1"
                                            {{ old('custom_data.' . $field->key) ? 'checked' : '' }}
                                            class="rounded border-gray-300 text-blue-600 focus:ring-blue-500">

                                        <label for="custom_{{ $field->key }}"
                                               class="text-sm text-gray-600">
                                            {{ $field->label }}
                                        </label>

                                    </div>

                                @else

                                    <input
                                        type="text"
                                        id="custom_{{ $field->key }}"
                                        name="custom_data[{{ $field->key }}]"
                                        value="{{ old('custom_data.' . $field->key) }}"
                                        maxlength="{{ $field->max_length }}"
                                        placeholder="{{ $field->placeholder }}"
                                        class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body">

                                @endif

                            </div>

                        @endforeach

                    </div>

                </div>

            @endif


            {{-- Buttons --}}
            <div class="p-6 flex items-center justify-end gap-3">

                <a href="{{ route('leads.index') }}"
                   class="px-5 py-2.5 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">
                    Cancel
                </a>

                <button type="submit"
                        class="px-5 py-2.5 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-700">
                    Save Lead
                </button>

            </div>

        </form>

    </div>

</div>

@endsection