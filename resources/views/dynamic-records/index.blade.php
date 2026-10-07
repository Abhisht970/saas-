<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>{{ $dynamicObject->plural_label ?? $dynamicObject->name }}</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h3 class="mb-1">
                {{ $dynamicObject->plural_label ?? $dynamicObject->name }}
            </h3>

            <small class="text-muted">
                Total Records: {{ $records->total() }}
            </small>
        </div>

        <a
            href="{{ route('dynamic-records.create', $dynamicObject->key) }}"
            class="btn btn-primary"
        >
            + Create {{ $dynamicObject->name }}
        </a>

    </div>


    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif


    <div class="card border-0 shadow-sm">

        <div class="table-responsive">

            <table class="table table-hover mb-0">

                <thead class="table-light">

                    <tr>

                        <th>ID</th>

                        @foreach($fields as $field)
                            <th>{{ $field->label }}</th>
                        @endforeach

                    </tr>

                </thead>

                <tbody>

                    @forelse($records as $record)

                        <tr>

                            <td>{{ $record->id }}</td>

                            @foreach($fields as $field)

                                <td>
                                    {{ $record->data[$field->key] ?? '-' }}
                                </td>

                            @endforeach

                        </tr>

                    @empty

                        <tr>

                            <td
                                colspan="{{ $fields->count() + 1 }}"
                                class="text-center py-4 text-muted"
                            >
                                No records found.
                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    <div class="mt-4">
        {{ $records->links() }}
    </div>

</div>

</body>
</html>