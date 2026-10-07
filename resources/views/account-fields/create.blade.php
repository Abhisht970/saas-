<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Create Account Field</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

    <style>
        body {
            background: #f5f7fb;
        }

        .form-card {
            border: 0;
            border-radius: 12px;
        }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            color: #6c757d;
            letter-spacing: .5px;
        }
    </style>

</head>

<body>

<div class="container py-5">

    {{-- Header --}}
    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">
                Create Account Field
            </h2>

            <p class="text-muted mb-0">
                Add a custom field to the Account module.
            </p>
        </div>

        <a href="{{ route('account-fields.index') }}"
           class="btn btn-outline-secondary">

            ← Back to Fields

        </a>

    </div>


    {{-- Validation Errors --}}
    @if ($errors->any())

        <div class="alert alert-danger">

            <strong>
                Please correct the following errors:
            </strong>

            <ul class="mb-0 mt-2">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif


    <form
        action="{{ route('account-fields.store') }}"
        method="POST">

        @csrf


        {{-- ========================================================= --}}
        {{-- BASIC INFORMATION --}}
        {{-- ========================================================= --}}

        <div class="card shadow-sm form-card mb-4">

            <div class="card-body p-4">

                <div class="section-title mb-3">
                    Basic Information
                </div>

                <div class="row g-3">


                    {{-- Label --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Field Label
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="label"
                            id="label"
                            value="{{ old('label') }}"
                            class="form-control @error('label') is-invalid @enderror"
                            placeholder="Example: Account Type"
                            required
                        >

                        @error('label')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Key --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Field Key
                            <span class="text-danger">*</span>
                        </label>

                        <input
                            type="text"
                            name="key"
                            id="key"
                            value="{{ old('key') }}"
                            class="form-control @error('key') is-invalid @enderror"
                            placeholder="account_type"
                            required
                        >

                        <div class="form-text">
                            Lowercase letters, numbers and underscore only.
                        </div>

                        @error('key')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror

                    </div>


                    {{-- Type --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Field Type
                            <span class="text-danger">*</span>
                        </label>

                        <select
                            name="type"
                            id="type"
                            class="form-select @error('type') is-invalid @enderror"
                            required>

                            <option value="">
                                Select Field Type
                            </option>

                            <option value="text"
                                {{ old('type') == 'text' ? 'selected' : '' }}>
                                Text
                            </option>

                            <option value="textarea"
                                {{ old('type') == 'textarea' ? 'selected' : '' }}>
                                Textarea
                            </option>

                            <option value="email"
                                {{ old('type') == 'email' ? 'selected' : '' }}>
                                Email
                            </option>

                            <option value="number"
                                {{ old('type') == 'number' ? 'selected' : '' }}>
                                Number
                            </option>

                            <option value="currency"
                                {{ old('type') == 'currency' ? 'selected' : '' }}>
                                Currency
                            </option>

                            <option value="url"
                                {{ old('type') == 'url' ? 'selected' : '' }}>
                                URL
                            </option>

                            <option value="password"
                                {{ old('type') == 'password' ? 'selected' : '' }}>
                                Password
                            </option>

                            <option value="date"
                                {{ old('type') == 'date' ? 'selected' : '' }}>
                                Date
                            </option>

                            <option value="datetime"
                                {{ old('type') == 'datetime' ? 'selected' : '' }}>
                                Date & Time
                            </option>

                            <option value="select"
                                {{ old('type') == 'select' ? 'selected' : '' }}>
                                Select / Dropdown
                            </option>

                            <option value="radio"
                                {{ old('type') == 'radio' ? 'selected' : '' }}>
                                Radio
                            </option>

                            <option value="checkbox"
                                {{ old('type') == 'checkbox' ? 'selected' : '' }}>
                                Checkbox
                            </option>

                        </select>

                    </div>


                    {{-- Placeholder --}}
                    <div class="col-md-6">

                        <label class="form-label">
                            Placeholder
                        </label>

                        <input
                            type="text"
                            name="placeholder"
                            value="{{ old('placeholder') }}"
                            class="form-control"
                            placeholder="Enter placeholder text"
                        >

                    </div>


                    {{-- Help Text --}}
                    <div class="col-12">

                        <label class="form-label">
                            Help Text
                        </label>

                        <input
                            type="text"
                            name="help_text"
                            value="{{ old('help_text') }}"
                            class="form-control"
                            placeholder="Explain what this field is used for"
                        >

                    </div>

                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- FIELD OPTIONS --}}
        {{-- ========================================================= --}}

        <div
            class="card shadow-sm form-card mb-4"
            id="optionsSection"
            style="display:none;">

            <div class="card-body p-4">

                <div class="section-title mb-3">
                    Field Options
                </div>

                <label class="form-label">
                    Options
                </label>

                <textarea
                    name="options"
                    class="form-control"
                    rows="6"
                    placeholder="Prospect&#10;Customer&#10;Partner&#10;Vendor">{{ old('options') }}</textarea>

                <div class="form-text">
                    Enter one option per line.
                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- DEFAULT VALUE --}}
        {{-- ========================================================= --}}

        <div class="card shadow-sm form-card mb-4">

            <div class="card-body p-4">

                <div class="section-title mb-3">
                    Default Value
                </div>

                <label class="form-label">
                    Default Value
                </label>

                <input
                    type="text"
                    name="default_value"
                    value="{{ old('default_value') }}"
                    class="form-control"
                    placeholder="Optional default value"
                >

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- VALIDATION --}}
        {{-- ========================================================= --}}

        <div class="card shadow-sm form-card mb-4">

            <div class="card-body p-4">

                <div class="section-title mb-3">
                    Validation
                </div>

                <div class="row g-3">


                    <div class="col-md-6">

                        <label class="form-label">
                            Minimum Length
                        </label>

                        <input
                            type="number"
                            name="min_length"
                            value="{{ old('min_length') }}"
                            class="form-control"
                            min="0"
                            placeholder="Example: 3"
                        >

                    </div>


                    <div class="col-md-6">

                        <label class="form-label">
                            Maximum Length
                        </label>

                        <input
                            type="number"
                            name="max_length"
                            value="{{ old('max_length') }}"
                            class="form-control"
                            min="0"
                            placeholder="Example: 150"
                        >

                    </div>


                    <div class="col-md-6">

                        <label class="form-label">
                            Validation Regex
                        </label>

                        <input
                            type="text"
                            name="validation_regex"
                            value="{{ old('validation_regex') }}"
                            class="form-control"
                            placeholder="Optional regular expression"
                        >

                    </div>


                    <div class="col-md-6">

                        <label class="form-label">
                            Validation Error Message
                        </label>

                        <input
                            type="text"
                            name="validation_message"
                            value="{{ old('validation_message') }}"
                            class="form-control"
                            placeholder="Example: Please enter a valid value"
                        >

                    </div>

                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- FIELD BEHAVIOUR --}}
        {{-- ========================================================= --}}

        <div class="card shadow-sm form-card mb-4">

            <div class="card-body p-4">

                <div class="section-title mb-3">
                    Field Behaviour
                </div>


                <div class="row g-4">


                    {{-- Required --}}
                    <div class="col-md-3">

                        <div class="form-check form-switch">

                            <input
                                type="checkbox"
                                class="form-check-input"
                                name="is_required"
                                value="1"
                                id="is_required"
                                {{ old('is_required') ? 'checked' : '' }}
                            >

                            <label
                                class="form-check-label"
                                for="is_required">

                                Required

                            </label>

                        </div>

                    </div>


                    {{-- Unique --}}
                    <div class="col-md-3">

                        <div class="form-check form-switch">

                            <input
                                type="checkbox"
                                class="form-check-input"
                                name="is_unique"
                                value="1"
                                id="is_unique"
                                {{ old('is_unique') ? 'checked' : '' }}
                            >

                            <label
                                class="form-check-label"
                                for="is_unique">

                                Unique

                            </label>

                        </div>

                    </div>


                    {{-- Show In List --}}
                    <div class="col-md-3">

                        <div class="form-check form-switch">

                            <input
                                type="checkbox"
                                class="form-check-input"
                                name="show_in_list"
                                value="1"
                                id="show_in_list"
                                {{ old('show_in_list') ? 'checked' : '' }}
                            >

                            <label
                                class="form-check-label"
                                for="show_in_list">

                                Show In List

                            </label>

                        </div>

                    </div>


                    {{-- Active --}}
                    <div class="col-md-3">

                        <div class="form-check form-switch">

                            <input
                                type="checkbox"
                                class="form-check-input"
                                name="is_active"
                                value="1"
                                id="is_active"
                                {{ old('is_active', 1) ? 'checked' : '' }}
                            >

                            <label
                                class="form-check-label"
                                for="is_active">

                                Active

                            </label>

                        </div>

                    </div>

                </div>

            </div>

        </div>



        {{-- ========================================================= --}}
        {{-- BUTTONS --}}
        {{-- ========================================================= --}}

        <div class="d-flex justify-content-end gap-2">

            <a
                href="{{ route('account-fields.index') }}"
                class="btn btn-light border">

                Cancel

            </a>

            <button
                type="submit"
                class="btn btn-primary px-4">

                Create Field

            </button>

        </div>

    </form>

</div>


<script>

    const typeSelect = document.getElementById('type');
    const optionsSection = document.getElementById('optionsSection');

    function updateOptionsVisibility() {

        const optionTypes = [
            'select',
            'radio',
            'checkbox'
        ];

        if (optionTypes.includes(typeSelect.value)) {

            optionsSection.style.display = 'block';

        } else {

            optionsSection.style.display = 'none';

        }

    }


    typeSelect.addEventListener(
        'change',
        updateOptionsVisibility
    );


    updateOptionsVisibility();


    /*
    |--------------------------------------------------------------------------
    | Automatically generate field key from label
    |--------------------------------------------------------------------------
    */

    const labelInput = document.getElementById('label');
    const keyInput = document.getElementById('key');

    let keyManuallyChanged = false;


    keyInput.addEventListener('input', function () {

        keyManuallyChanged = true;

    });


    labelInput.addEventListener('input', function () {

        if (keyManuallyChanged) {
            return;
        }

        let key = this.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9]+/g, '_')
            .replace(/^_+|_+$/g, '');

        keyInput.value = key;

    });

</script>

</body>
</html>