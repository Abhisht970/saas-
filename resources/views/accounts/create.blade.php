<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Create Account</title>


    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">


    <style>

        body {
            background: #f5f7fb;
        }

        .form-card {
            border: none;
            border-radius: 12px;
        }

        .page-title {
            font-weight: 600;
        }

        .field-label {
            font-weight: 500;
        }

        .required-star {
            color: #dc3545;
        }

    </style>

</head>


<body>


<div class="container py-5">


    {{-- ============================================================= --}}
    {{-- HEADER --}}
    {{-- ============================================================= --}}

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>

            <h2 class="page-title mb-1">
                Create Account
            </h2>

            <p class="text-muted mb-0">
                Enter account information below.
            </p>

        </div>


        <a
            href="{{ route('accounts.index') }}"
            class="btn btn-outline-secondary">

            ← Back to Accounts

        </a>

    </div>



    {{-- ============================================================= --}}
    {{-- VALIDATION ERRORS --}}
    {{-- ============================================================= --}}

    @if($errors->any())

        <div class="alert alert-danger">

            <strong>
                Please correct the following errors:
            </strong>

            <ul class="mb-0 mt-2">

                @foreach($errors->all() as $error)

                    <li>
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif



    {{-- ============================================================= --}}
    {{-- FORM --}}
    {{-- ============================================================= --}}

    <form
        action="{{ route('accounts.store') }}"
        method="POST">

        @csrf


        <div class="card shadow-sm form-card">

            <div class="card-body p-4">


                <div class="row g-4">


                    {{-- ================================================= --}}
                    {{-- DYNAMIC FIELDS --}}
                    {{-- ================================================= --}}

                    @foreach($fields as $field)


                        @php

                            $value = old(
                                $field->key,
                                $field->default_value
                            );

                            $options = $field->options ?? [];

                        @endphp



                        <div
                            class="{{ $field->type === 'textarea' ? 'col-12' : 'col-md-6' }}">


                            {{-- ========================================= --}}
                            {{-- LABEL --}}
                            {{-- ========================================= --}}

                            @if($field->type !== 'checkbox')

                                <label
                                    for="{{ $field->key }}"
                                    class="form-label field-label">

                                    {{ $field->label }}

                                    @if($field->is_required)

                                        <span class="required-star">
                                            *
                                        </span>

                                    @endif

                                </label>

                            @endif



                            {{-- ========================================= --}}
                            {{-- TEXT --}}
                            {{-- ========================================= --}}

                            @if($field->type === 'text')

                                <input
                                    type="text"
                                    id="{{ $field->key }}"
                                    name="{{ $field->key }}"
                                    value="{{ $value }}"
                                    placeholder="{{ $field->placeholder }}"
                                    @if($field->max_length)
                                        maxlength="{{ $field->max_length }}"
                                    @endif
                                    @if($field->min_length)
                                        minlength="{{ $field->min_length }}"
                                    @endif
                                    {{ $field->is_required ? 'required' : '' }}
                                    class="form-control
                                    @error($field->key) is-invalid @enderror"
                                >



                            {{-- ========================================= --}}
                            {{-- EMAIL --}}
                            {{-- ========================================= --}}

                            @elseif($field->type === 'email')

                                <input
                                    type="email"
                                    id="{{ $field->key }}"
                                    name="{{ $field->key }}"
                                    value="{{ $value }}"
                                    placeholder="{{ $field->placeholder }}"
                                    {{ $field->is_required ? 'required' : '' }}
                                    class="form-control
                                    @error($field->key) is-invalid @enderror"
                                >



                            {{-- ========================================= --}}
                            {{-- NUMBER --}}
                            {{-- ========================================= --}}

                            @elseif($field->type === 'number')

                                <input
                                    type="number"
                                    id="{{ $field->key }}"
                                    name="{{ $field->key }}"
                                    value="{{ $value }}"
                                    placeholder="{{ $field->placeholder }}"
                                    {{ $field->is_required ? 'required' : '' }}
                                    class="form-control
                                    @error($field->key) is-invalid @enderror"
                                >



                            {{-- ========================================= --}}
                            {{-- CURRENCY --}}
                            {{-- ========================================= --}}

                            @elseif($field->type === 'currency')

                                <input
                                    type="number"
                                    step="0.01"
                                    id="{{ $field->key }}"
                                    name="{{ $field->key }}"
                                    value="{{ $value }}"
                                    placeholder="{{ $field->placeholder }}"
                                    {{ $field->is_required ? 'required' : '' }}
                                    class="form-control
                                    @error($field->key) is-invalid @enderror"
                                >



                            {{-- ========================================= --}}
                            {{-- URL --}}
                            {{-- ========================================= --}}

                            @elseif($field->type === 'url')

                                <input
                                    type="url"
                                    id="{{ $field->key }}"
                                    name="{{ $field->key }}"
                                    value="{{ $value }}"
                                    placeholder="{{ $field->placeholder }}"
                                    {{ $field->is_required ? 'required' : '' }}
                                    class="form-control
                                    @error($field->key) is-invalid @enderror"
                                >



                            {{-- ========================================= --}}
                            {{-- PASSWORD --}}
                            {{-- ========================================= --}}

                            @elseif($field->type === 'password')

                                <input
                                    type="password"
                                    id="{{ $field->key }}"
                                    name="{{ $field->key }}"
                                    placeholder="{{ $field->placeholder }}"
                                    {{ $field->is_required ? 'required' : '' }}
                                    class="form-control
                                    @error($field->key) is-invalid @enderror"
                                >



                            {{-- ========================================= --}}
                            {{-- DATE --}}
                            {{-- ========================================= --}}

                            @elseif($field->type === 'date')

                                <input
                                    type="date"
                                    id="{{ $field->key }}"
                                    name="{{ $field->key }}"
                                    value="{{ $value }}"
                                    {{ $field->is_required ? 'required' : '' }}
                                    class="form-control
                                    @error($field->key) is-invalid @enderror"
                                >



                            {{-- ========================================= --}}
                            {{-- DATETIME --}}
                            {{-- ========================================= --}}

                            @elseif($field->type === 'datetime')

                                <input
                                    type="datetime-local"
                                    id="{{ $field->key }}"
                                    name="{{ $field->key }}"
                                    value="{{ $value }}"
                                    {{ $field->is_required ? 'required' : '' }}
                                    class="form-control
                                    @error($field->key) is-invalid @enderror"
                                >



                            {{-- ========================================= --}}
                            {{-- TEXTAREA --}}
                            {{-- ========================================= --}}

                            @elseif($field->type === 'textarea')

                                <textarea
                                    id="{{ $field->key }}"
                                    name="{{ $field->key }}"
                                    rows="4"
                                    placeholder="{{ $field->placeholder }}"
                                    {{ $field->is_required ? 'required' : '' }}
                                    class="form-control
                                    @error($field->key) is-invalid @enderror"
                                >{{ $value }}</textarea>



                            {{-- ========================================= --}}
                            {{-- SELECT --}}
                            {{-- ========================================= --}}

                            @elseif($field->type === 'select')

                                <select
                                    id="{{ $field->key }}"
                                    name="{{ $field->key }}"
                                    {{ $field->is_required ? 'required' : '' }}
                                    class="form-select
                                    @error($field->key) is-invalid @enderror">


                                    <option value="">
                                        Select {{ $field->label }}
                                    </option>


                                    @foreach($options as $option)

                                        <option
                                            value="{{ $option }}"
                                            {{ (string) $value === (string) $option ? 'selected' : '' }}>

                                            {{ $option }}

                                        </option>

                                    @endforeach


                                </select>



                            {{-- ========================================= --}}
                            {{-- RADIO --}}
                            {{-- ========================================= --}}

                            @elseif($field->type === 'radio')


                                <div>

                                    @foreach($options as $option)

                                        <div class="form-check form-check-inline">

                                            <input
                                                class="form-check-input"
                                                type="radio"
                                                name="{{ $field->key }}"
                                                id="{{ $field->key }}_{{ $loop->index }}"
                                                value="{{ $option }}"
                                                {{ (string) $value === (string) $option ? 'checked' : '' }}
                                                {{ $field->is_required ? 'required' : '' }}
                                            >


                                            <label
                                                class="form-check-label"
                                                for="{{ $field->key }}_{{ $loop->index }}">

                                                {{ $option }}

                                            </label>

                                        </div>

                                    @endforeach

                                </div>



                            {{-- ========================================= --}}
                            {{-- CHECKBOX --}}
                            {{-- ========================================= --}}

                            @elseif($field->type === 'checkbox')


                                <div class="form-check form-switch mt-4">

                                    <input
                                        type="checkbox"
                                        class="form-check-input"
                                        id="{{ $field->key }}"
                                        name="{{ $field->key }}"
                                        value="1"
                                        {{ old($field->key, $field->default_value) ? 'checked' : '' }}
                                    >


                                    <label
                                        class="form-check-label field-label"
                                        for="{{ $field->key }}">

                                        {{ $field->label }}

                                    </label>

                                </div>



                            {{-- ========================================= --}}
                            {{-- FALLBACK --}}
                            {{-- ========================================= --}}

                            @else

                                <input
                                    type="text"
                                    id="{{ $field->key }}"
                                    name="{{ $field->key }}"
                                    value="{{ $value }}"
                                    placeholder="{{ $field->placeholder }}"
                                    {{ $field->is_required ? 'required' : '' }}
                                    class="form-control
                                    @error($field->key) is-invalid @enderror"
                                >

                            @endif



                            {{-- ========================================= --}}
                            {{-- HELP TEXT --}}
                            {{-- ========================================= --}}

                            @if($field->help_text)

                                <div class="form-text">

                                    {{ $field->help_text }}

                                </div>

                            @endif



                            {{-- ========================================= --}}
                            {{-- FIELD VALIDATION ERROR --}}
                            {{-- ========================================= --}}

                            @error($field->key)

                                <div class="invalid-feedback d-block">

                                    {{ $message }}

                                </div>

                            @enderror


                        </div>


                    @endforeach


                </div>

            </div>

        </div>



        {{-- ============================================================= --}}
        {{-- BUTTONS --}}
        {{-- ============================================================= --}}

        <div class="d-flex justify-content-end gap-2 mt-4">


            <a
                href="{{ route('accounts.index') }}"
                class="btn btn-light border px-4">

                Cancel

            </a>


            <button
                type="submit"
                class="btn btn-primary px-4">

                Create Account

            </button>


        </div>


    </form>


</div>


</body>

</html>