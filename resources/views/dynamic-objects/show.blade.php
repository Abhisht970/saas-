<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta
        name="viewport"
        content="width=device-width, initial-scale=1.0"
    >

    <title>{{ $dynamicObject->name }}</title>

    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
    >

</head>

<body class="bg-light">

<div class="container py-5">

    <div class="mb-3">

        <a
            href="{{ route('dynamic-objects.index') }}"
            class="text-decoration-none"
        >
            ← Back to Objects
        </a>

    </div>


    @if(session('success'))

        <div class="alert alert-success">
            {{ session('success') }}
        </div>

    @endif


    <div class="card border-0 shadow-sm mb-4">

        <div class="card-body">

            <div class="d-flex
                        justify-content-between
                        align-items-start">

                <div>

                    <h3 class="mb-1">
                        {{ $dynamicObject->name }}
                    </h3>

                    <div class="text-muted">

                        API Key:

                        <code>
                            {{ $dynamicObject->key }}
                        </code>

                    </div>

                    @if($dynamicObject->description)

                        <p class="mt-3 mb-0">
                            {{ $dynamicObject->description }}
                        </p>

                    @endif

                </div>


                <div>

                    @if($dynamicObject->is_active)

                        <span class="badge text-bg-success">
                            Active
                        </span>

                    @else

                        <span class="badge text-bg-secondary">
                            Inactive
                        </span>

                    @endif

                </div>

            </div>

        </div>

    </div>


    <div class="card border-0 shadow-sm">

        <div class="card-header bg-white py-3">

            <div class="d-flex
                        justify-content-between
                        align-items-center">

                <div>

                    <h5 class="mb-1">
                        Fields
                    </h5>

                    <small class="text-muted">
                        Manage fields available inside this object.
                    </small>

                </div>


                <a
                    href="{{ route(
                        'dynamic-fields.create',
                        $dynamicObject
                    ) }}"
                    class="btn btn-primary"
                >
                    + Add Field
                </a>

            </div>

        </div>


        <div class="table-responsive">

            <table class="table
                          table-hover
                          align-middle
                          mb-0">

                <thead class="table-light">

                <tr>

                    <th>Label</th>

                    <th>Field Key</th>

                    <th>Type</th>

                    <th>Required</th>

                    <th>List</th>

                    <th>Search</th>

                    <th>Status</th>

                    <th>Order</th>

                </tr>

                </thead>


                <tbody>

                @forelse($dynamicObject->fields as $field)

                    <tr>

                        <td>

                            <div class="fw-semibold">
                                {{ $field->label }}
                            </div>

                            @if($field->help_text)

                                <small class="text-muted">
                                    {{ $field->help_text }}
                                </small>

                            @endif

                        </td>


                        <td>
                            <code>
                                {{ $field->key }}
                            </code>
                        </td>


                        <td>

                            <span class="badge text-bg-light">
                                {{ ucfirst($field->type) }}
                            </span>

                        </td>


                        <td>

                            @if($field->is_required)

                                <span class="text-success">
                                    Yes
                                </span>

                            @else

                                <span class="text-muted">
                                    No
                                </span>

                            @endif

                        </td>


                        <td>

                            {{ $field->show_in_list
                                ? 'Yes'
                                : 'No'
                            }}

                        </td>


                        <td>

                            {{ $field->is_searchable
                                ? 'Yes'
                                : 'No'
                            }}

                        </td>


                        <td>

                            @if($field->is_active)

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
                            {{ $field->sort_order }}
                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="8"
                            class="text-center py-5"
                        >

                            <div class="text-muted mb-3">

                                No fields have been created
                                for this object yet.

                            </div>

                            <a
                                href="{{ route(
                                    'dynamic-fields.create',
                                    $dynamicObject
                                ) }}"
                                class="btn btn-sm btn-primary"
                            >
                                Create First Field
                            </a>

                        </td>

                    </tr>

                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

</body>
</html>