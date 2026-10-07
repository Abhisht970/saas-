<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Add Field</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-9">

            <div class="mb-3">
                <a
                    href="{{ route('dynamic-objects.show', $dynamicObject) }}"
                    class="text-decoration-none"
                >
                    ← Back to {{ $dynamicObject->name }}
                </a>
            </div>


            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">

                    <h4 class="mb-1">
                        Add New Field
                    </h4>

                    <small class="text-muted">
                        Object:
                        <strong>{{ $dynamicObject->name }}</strong>
                    </small>

                </div>


                <div class="card-body p-4">

                    <form
                        method="POST"
                        action="{{ route('dynamic-fields.store', $dynamicObject) }}"
                    >

                        @csrf


                        <div class="row">

                            {{-- Field Label --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Field Label
                                    <span class="text-danger">*</span>
                                </label>

                                <input
                                    type="text"
                                    name="label"
                                    id="field_label"
                                    value="{{ old('label') }}"
                                    class="form-control @error('label') is-invalid @enderror"
                                    placeholder="Example: Task Name"
                                    required
                                >

                                @error('label')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- Field Key --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Field Key
                                </label>

                                <input
                                    type="text"
                                    name="key"
                                    id="field_key"
                                    value="{{ old('key') }}"
                                    class="form-control @error('key') is-invalid @enderror"
                                    placeholder="task_name"
                                >

                                <div class="form-text">
                                    Internal field name.
                                </div>

                                @error('key')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- Field Type --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Field Type
                                    <span class="text-danger">*</span>
                                </label>

                                <select
                                    name="type"
                                    id="field_type"
                                    class="form-select @error('type') is-invalid @enderror"
                                    required
                                >

                                    <option value="">
                                        Select Type
                                    </option>

                                    <option value="text" {{ old('type') === 'text' ? 'selected' : '' }}>
                                        Text
                                    </option>

                                    <option value="textarea" {{ old('type') === 'textarea' ? 'selected' : '' }}>
                                        Textarea
                                    </option>

                                    <option value="email" {{ old('type') === 'email' ? 'selected' : '' }}>
                                        Email
                                    </option>

                                    <option value="phone" {{ old('type') === 'phone' ? 'selected' : '' }}>
                                        Phone
                                    </option>

                                    <option value="number" {{ old('type') === 'number' ? 'selected' : '' }}>
                                        Number
                                    </option>

                                    <option value="currency" {{ old('type') === 'currency' ? 'selected' : '' }}>
                                        Currency
                                    </option>

                                    <option value="url" {{ old('type') === 'url' ? 'selected' : '' }}>
                                        URL
                                    </option>

                                    <option value="password" {{ old('type') === 'password' ? 'selected' : '' }}>
                                        Password
                                    </option>

                                    <option value="date" {{ old('type') === 'date' ? 'selected' : '' }}>
                                        Date
                                    </option>

                                    <option value="datetime" {{ old('type') === 'datetime' ? 'selected' : '' }}>
                                        Date & Time
                                    </option>

                                    <option value="select" {{ old('type') === 'select' ? 'selected' : '' }}>
                                        Select / Picklist
                                    </option>

                                    <option value="radio" {{ old('type') === 'radio' ? 'selected' : '' }}>
                                        Radio
                                    </option>

                                    <option value="checkbox" {{ old('type') === 'checkbox' ? 'selected' : '' }}>
                                        Checkbox
                                    </option>

                                </select>

                                @error('type')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>


                            {{-- Sort Order --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Sort Order
                                </label>

                                <input
                                    type="number"
                                    name="sort_order"
                                    value="{{ old('sort_order', 0) }}"
                                    min="0"
                                    class="form-control"
                                >

                            </div>


                            {{-- Placeholder --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Placeholder
                                </label>

                                <input
                                    type="text"
                                    name="placeholder"
                                    value="{{ old('placeholder') }}"
                                    class="form-control"
                                    placeholder="Enter value..."
                                >

                            </div>


                            {{-- Default Value --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Default Value
                                </label>

                                <input
                                    type="text"
                                    name="default_value"
                                    value="{{ old('default_value') }}"
                                    class="form-control"
                                >

                            </div>


                            {{-- Options --}}
                            <div
                                class="col-12 mb-3"
                                id="options_section"
                                style="display:none;"
                            >

                                <label class="form-label">
                                    Options
                                </label>

                                <textarea
                                    name="options"
                                    rows="4"
                                    class="form-control"
                                    placeholder="High&#10;Medium&#10;Low"
                                >{{ old('options') }}</textarea>

                                <div class="form-text">
                                    Select/Radio ke liye one option per line.
                                </div>

                            </div>


                            {{-- Min Length --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Minimum Length
                                </label>

                                <input
                                    type="number"
                                    name="min_length"
                                    value="{{ old('min_length') }}"
                                    min="0"
                                    class="form-control"
                                >

                            </div>


                            {{-- Max Length --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Maximum Length
                                </label>

                                <input
                                    type="number"
                                    name="max_length"
                                    value="{{ old('max_length') }}"
                                    min="0"
                                    class="form-control"
                                >

                            </div>


                            {{-- Validation Regex --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Validation Regex
                                </label>

                                <input
                                    type="text"
                                    name="validation_regex"
                                    value="{{ old('validation_regex') }}"
                                    class="form-control"
                                >

                            </div>


                            {{-- Validation Message --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Validation Message
                                </label>

                                <input
                                    type="text"
                                    name="validation_message"
                                    value="{{ old('validation_message') }}"
                                    class="form-control"
                                >

                            </div>


                            {{-- Help Text --}}
                            <div class="col-12 mb-4">

                                <label class="form-label">
                                    Help Text
                                </label>

                                <textarea
                                    name="help_text"
                                    rows="2"
                                    class="form-control"
                                >{{ old('help_text') }}</textarea>

                            </div>

                        </div>


                        <hr>


                        <h6 class="mb-3">
                            Field Settings
                        </h6>


                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-check mb-3">

                                    <input
                                        type="checkbox"
                                        name="is_required"
                                        value="1"
                                        id="is_required"
                                        class="form-check-input"
                                        {{ old('is_required') ? 'checked' : '' }}
                                    >

                                    <label
                                        for="is_required"
                                        class="form-check-label"
                                    >
                                        Required
                                    </label>

                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-check mb-3">

                                    <input
                                        type="checkbox"
                                        name="is_unique"
                                        value="1"
                                        id="is_unique"
                                        class="form-check-input"
                                        {{ old('is_unique') ? 'checked' : '' }}
                                    >

                                    <label
                                        for="is_unique"
                                        class="form-check-label"
                                    >
                                        Unique
                                    </label>

                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-check mb-3">

                                    <input
                                        type="checkbox"
                                        name="show_in_list"
                                        value="1"
                                        id="show_in_list"
                                        class="form-check-input"
                                        {{ old('show_in_list') ? 'checked' : '' }}
                                    >

                                    <label
                                        for="show_in_list"
                                        class="form-check-label"
                                    >
                                        Show in List
                                    </label>

                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-check mb-3">

                                    <input
                                        type="checkbox"
                                        name="is_searchable"
                                        value="1"
                                        id="is_searchable"
                                        class="form-check-input"
                                        {{ old('is_searchable') ? 'checked' : '' }}
                                    >

                                    <label
                                        for="is_searchable"
                                        class="form-check-label"
                                    >
                                        Searchable
                                    </label>

                                </div>
                            </div>


                            <div class="col-md-4">
                                <div class="form-check mb-3">

                                    <input
                                        type="checkbox"
                                        name="is_active"
                                        value="1"
                                        id="is_active"
                                        class="form-check-input"
                                        {{ old('is_active', true) ? 'checked' : '' }}
                                    >

                                    <label
                                        for="is_active"
                                        class="form-check-label"
                                    >
                                        Active
                                    </label>

                                </div>
                            </div>

                        </div>


                        <div class="d-flex justify-content-end gap-2">

                            <a
                                href="{{ route('dynamic-objects.show', $dynamicObject) }}"
                                class="btn btn-light"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Save Field
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


<script>
    const labelInput = document.getElementById('field_label');
    const keyInput = document.getElementById('field_key');
    const typeInput = document.getElementById('field_type');
    const optionsSection = document.getElementById('options_section');

    let keyEdited = false;

    keyInput.addEventListener('input', function () {
        keyEdited = this.value.length > 0;
    });

    labelInput.addEventListener('input', function () {

        if (keyEdited) {
            return;
        }

        let key = this.value
            .toLowerCase()
            .trim()
            .replace(/[^a-z0-9]+/g, '_')
            .replace(/^_+|_+$/g, '');

        keyInput.value = key;
    });

    function toggleOptions() {

        const type = typeInput.value;

        if (type === 'select' || type === 'radio') {
            optionsSection.style.display = 'block';
        } else {
            optionsSection.style.display = 'none';
        }
    }

    typeInput.addEventListener('change', toggleOptions);

    toggleOptions();
</script>

</body>
</html>