<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $record->record_name ?? $dynamicObject->name }}</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="mb-3">
        <a
            href="{{ route('dynamic-records.index', $dynamicObject->key) }}"
            class="text-decoration-none"
        >
            ← Back to {{ $dynamicObject->plural_label ?? $dynamicObject->name }}
        </a>
    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">

            <h4 class="mb-1">
                {{ $record->record_name ?? $dynamicObject->name }}
            </h4>

            <small class="text-muted">
                {{ $dynamicObject->name }} Record
            </small>

        </div>


        <div class="card-body p-4">

            @foreach($fields as $field)

                <div class="mb-4">

                    <div class="text-muted small mb-1">
                        {{ $field->label }}
                    </div>

                    <div class="fw-semibold">

                        @php
                            $value = $record->data[$field->key] ?? null;
                        @endphp

                        @if(is_array($value))

                            {{ implode(', ', $value) }}

                        @elseif($value !== null && $value !== '')

                            {{ $value }}

                        @else

                            -

                        @endif

                    </div>

                </div>

            @endforeach

        </div>

    </div>

</div>

</body>

</html>