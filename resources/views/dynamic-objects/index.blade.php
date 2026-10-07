<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">

    <meta name="viewport"
          content="width=device-width, initial-scale=1.0">

    <title>Objects</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >
</head>

<body class="bg-light">

<div class="container py-5">

    <div class="d-flex justify-content-between align-items-center mb-4">

        <div>
            <h2 class="mb-1">
                Objects
            </h2>

            <p class="text-muted mb-0">
                Create and manage CRM objects.
            </p>
        </div>

        <a
            href="{{ route('dynamic-objects.create') }}"
            class="btn btn-primary"
        >
            + Create Object
        </a>

    </div>


    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    <div class="card border-0 shadow-sm">

        <div class="table-responsive">

            <table class="table table-hover align-middle mb-0">

                <thead class="table-light">

                    <tr>
                        <th>Object</th>

                        <th>API Key</th>

                        <th>Fields</th>

                        <th>Records</th>

                        <th>Status</th>

                        <th width="180">
                            Actions
                        </th>
                    </tr>

                </thead>

                <tbody>

                @forelse($objects as $object)

                    <tr>

                        <td>

                            <div class="fw-semibold">
                                {{ $object->name }}
                            </div>

                            <small class="text-muted">
                                {{ $object->plural_label }}
                            </small>

                        </td>


                        <td>

                            <code>
                                {{ $object->key }}
                            </code>

                        </td>


                        <td>
                            {{ $object->fields_count }}
                        </td>


                        <td>
                            {{ $object->records_count }}
                        </td>


                        <td>

                            @if($object->is_active)

                                <span class="badge text-bg-success">
                                    Active
                                </span>

                            @else

                                <span class="badge text-bg-secondary">
                                    Inactive
                                </span>

                            @endif

                        </td>


                        <td>

                            <a
                                href="{{ route('dynamic-objects.show', $object) }}"
                                class="btn btn-sm btn-outline-primary"
                            >
                                Manage
                            </a>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="text-center py-5 text-muted"
                        >
                            No objects created yet.
                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>


    <div class="mt-4">

        {{ $objects->links() }}

    </div>

</div>

</body>
</html>