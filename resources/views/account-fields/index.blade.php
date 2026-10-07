<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Account Fields</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <div class="container py-5">

        {{-- Page Header --}}
        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>
                <h2 class="mb-1">
                    Account Fields
                </h2>

                <p class="text-muted mb-0">
                    Manage fields available for Account records.
                </p>
            </div>

            <a href="{{ route('account-fields.create') }}" class="btn btn-primary">
                + Create Field
            </a>

        </div>


        {{-- Account Fields Table --}}
        <div class="card shadow-sm">

            <div class="card-body">

                <div class="table-responsive">

                    <table class="table table-hover align-middle">

                        <thead class="table-light">

                            <tr>
                                <th>#</th>
                                <th>Label</th>
                                <th>Key</th>
                                <th>Type</th>
                                <th>Required</th>
                                <th>Locked</th>
                                <th>List</th>
                                <th>Active</th>
                                <th>Order</th>
                                <th width="150">Action</th>
                            </tr>

                        </thead>

                        <tbody>

                            @forelse($fields as $field)
                                <tr>

                                    <td>
                                        {{ $field->id }}
                                    </td>

                                    <td>
                                        <strong>
                                            {{ $field->label }}
                                        </strong>

                                        @if ($field->is_default)
                                            <span class="badge bg-secondary ms-1">
                                                Default
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        <code>
                                            {{ $field->key }}
                                        </code>
                                    </td>

                                    <td>
                                        <span class="badge bg-info text-dark">
                                            {{ ucfirst($field->type) }}
                                        </span>
                                    </td>

                                    <td>
                                        @if ($field->is_required)
                                            <span class="badge bg-success">
                                                Yes
                                            </span>
                                        @else
                                            <span class="badge bg-light text-dark">
                                                No
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($field->is_locked)
                                            <span class="badge bg-warning text-dark">
                                                Yes
                                            </span>
                                        @else
                                            <span class="badge bg-light text-dark">
                                                No
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $field->show_in_list ? 'Yes' : 'No' }}
                                    </td>

                                    <td>
                                        @if ($field->is_active)
                                            <span class="badge bg-success">
                                                Active
                                            </span>
                                        @else
                                            <span class="badge bg-danger">
                                                Inactive
                                            </span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $field->sort_order }}
                                    </td>

                                    <td>

                                        <a href="#" class="btn btn-sm btn-outline-primary">
                                            Edit
                                        </a>

                                        @if (!$field->is_locked)
                                            <button type="button" class="btn btn-sm btn-outline-danger">
                                                Delete
                                            </button>
                                        @endif

                                    </td>

                                </tr>

                            @empty

                                <tr>

                                    <td colspan="10" class="text-center py-5 text-muted">

                                        No account fields found.

                                    </td>

                                </tr>
                            @endforelse

                        </tbody>

                    </table>

                </div>

            </div>

        </div>

    </div>

</body>

</html>
