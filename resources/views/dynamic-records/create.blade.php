<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create {{ $dynamicObject->name }}</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">

        <div class="card border-0 shadow-sm">

            <div class="card-body">

                <h3>
                    Create {{ $dynamicObject->name }}
                </h3>

                <p class="text-muted">
                    Total Fields: {{ $fields->count() }}
                </p>

                <hr>

                <form method="POST" action="{{ route('dynamic-records.store', $dynamicObject->key) }}">
                    @csrf

                    @foreach ($fields as $field)
                        <div class="mb-3">

                            <label class="form-label">
                                {{ $field->label }}

                                @if ($field->is_required)
                                    <span class="text-danger">*</span>
                                @endif
                            </label>

                            @if ($field->type === 'textarea')
                                <textarea name="{{ $field->key }}" class="form-control" placeholder="{{ $field->placeholder }}" rows="4"></textarea>
                            @else
                                <input type="text" name="{{ $field->key }}" class="form-control"
                                    placeholder="{{ $field->placeholder }}">
                            @endif

                        </div>
                    @endforeach

                    <button type="submit" class="btn btn-primary">
                        Save {{ $dynamicObject->name }}
                    </button>

                </form>

            </div>

        </div>

    </div>

</body>

</html>
