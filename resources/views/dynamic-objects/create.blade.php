<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Create Object</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="row justify-content-center">

        <div class="col-lg-8">

            <div class="mb-3">
                <a
                    href="{{ route('dynamic-objects.index') }}"
                    class="text-decoration-none"
                >
                    ← Back to Objects
                </a>
            </div>

            <div class="card border-0 shadow-sm">

                <div class="card-header bg-white py-3">
                    <h4 class="mb-1">
                        Create New Object
                    </h4>

                    <small class="text-muted">
                        Create a new module like Task, Vendor, Project or Asset.
                    </small>
                </div>

                <div class="card-body p-4">

                    <form
                        method="POST"
                        action="{{ route('dynamic-objects.store') }}"
                    >

                        @csrf

                        {{-- Object Name --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Object Name
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="name"
                                id="object_name"
                                value="{{ old('name') }}"
                                class="form-control @error('name') is-invalid @enderror"
                                placeholder="Example: Task"
                                required
                            >

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Object Key --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Object Key
                                <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="key"
                                id="object_key"
                                value="{{ old('key') }}"
                                class="form-control @error('key') is-invalid @enderror"
                                placeholder="Example: task"
                                required
                            >

                            <div class="form-text">
                                Internal key. Example: task, vendor, purchase_order.
                            </div>

                            @error('key')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Plural Label --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Plural Label
                            </label>

                            <input
                                type="text"
                                name="plural_label"
                                value="{{ old('plural_label') }}"
                                class="form-control @error('plural_label') is-invalid @enderror"
                                placeholder="Example: Tasks"
                            >

                            @error('plural_label')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        {{-- Description --}}
                        <div class="mb-3">

                            <label class="form-label">
                                Description
                            </label>

                            <textarea
                                name="description"
                                rows="4"
                                class="form-control @error('description') is-invalid @enderror"
                                placeholder="Describe this object..."
                            >{{ old('description') }}</textarea>

                            @error('description')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>


                        <div class="row">

                            {{-- Icon --}}
                            <div class="col-md-6 mb-3">

                                <label class="form-label">
                                    Icon
                                </label>

                                <input
                                    type="text"
                                    name="icon"
                                    value="{{ old('icon') }}"
                                    class="form-control @error('icon') is-invalid @enderror"
                                    placeholder="Example: bi-list-task"
                                >

                                @error('icon')
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
                                    class="form-control @error('sort_order') is-invalid @enderror"
                                >

                                @error('sort_order')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                        </div>


                        <hr class="my-4">

                        <h6 class="mb-3">
                            Object Permissions
                        </h6>


                        <div class="form-check mb-2">

                            <input
                                type="checkbox"
                                name="allow_create"
                                value="1"
                                id="allow_create"
                                class="form-check-input"
                                {{ old('allow_create', true) ? 'checked' : '' }}
                            >

                            <label
                                class="form-check-label"
                                for="allow_create"
                            >
                                Allow Create
                            </label>

                        </div>


                        <div class="form-check mb-2">

                            <input
                                type="checkbox"
                                name="allow_edit"
                                value="1"
                                id="allow_edit"
                                class="form-check-input"
                                {{ old('allow_edit', true) ? 'checked' : '' }}
                            >

                            <label
                                class="form-check-label"
                                for="allow_edit"
                            >
                                Allow Edit
                            </label>

                        </div>


                        <div class="form-check mb-4">

                            <input
                                type="checkbox"
                                name="allow_delete"
                                value="1"
                                id="allow_delete"
                                class="form-check-input"
                                {{ old('allow_delete', true) ? 'checked' : '' }}
                            >

                            <label
                                class="form-check-label"
                                for="allow_delete"
                            >
                                Allow Delete
                            </label>

                        </div>


                        <div class="d-flex justify-content-end gap-2">

                            <a
                                href="{{ route('dynamic-objects.index') }}"
                                class="btn btn-light"
                            >
                                Cancel
                            </a>

                            <button
                                type="submit"
                                class="btn btn-primary"
                            >
                                Create Object
                            </button>

                        </div>

                    </form>

                </div>

            </div>

        </div>

    </div>

</div>


<script>
    const nameInput = document.getElementById('object_name');
    const keyInput = document.getElementById('object_key');

    let keyEdited = false;

    keyInput.addEventListener('input', function () {
        keyEdited = this.value.length > 0;
    });

    nameInput.addEventListener('input', function () {

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
</script>

</body>
</html>