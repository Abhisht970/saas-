<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Accounts</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f7fb;
        }

        .page-title {
            font-weight: 600;
        }

        .table-card {
            border: none;
            border-radius: 12px;
        }

        .table th {
            white-space: nowrap;
            font-size: 13px;
            text-transform: uppercase;
            color: #6c757d;
        }

        .table td {
            vertical-align: middle;
            white-space: nowrap;
        }

        .account-name {
            font-weight: 600;
        }
    </style>

</head>

<body>


    <div class="container-fluid px-4 py-4">


        {{-- ============================================================= --}}
        {{-- PAGE HEADER --}}
        {{-- ============================================================= --}}

        <div class="d-flex justify-content-between align-items-center mb-4">

            <div>

                <h2 class="page-title mb-1">
                    Accounts
                </h2>

                <p class="text-muted mb-0">
                    Manage your customer and business accounts.
                </p>

            </div>


            <div>

                <a href="{{ route('accounts.create') }}" class="btn btn-primary">

                    + New Account

                </a>

            </div>

        </div>



        {{-- ============================================================= --}}
        {{-- SUCCESS MESSAGE --}}
        {{-- ============================================================= --}}

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">

                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert">
                </button>

            </div>
        @endif



        {{-- ============================================================= --}}
        {{-- ACCOUNT TABLE --}}
        {{-- ============================================================= --}}

        <div class="card shadow-sm table-card">

            <div class="card-body p-0">


                <div class="table-responsive">

                    <table class="table table-hover mb-0">


                        {{-- ================================================= --}}
                        {{-- DYNAMIC TABLE HEADER --}}
                        {{-- ================================================= --}}

                        <thead class="table-light">

                            <tr>

                                @foreach ($fields as $field)
                                    <th class="px-3 py-3">

                                        {{ $field->label }}

                                        @if (!$field->is_default)
                                            <span class="badge bg-light text-secondary border ms-1"
                                                title="Custom Field">

                                                Custom

                                            </span>
                                        @endif

                                    </th>
                                @endforeach


                                {{-- Action is system column --}}
                                <th class="px-3 py-3 text-end">

                                    Actions

                                </th>

                            </tr>

                        </thead>



                        {{-- ================================================= --}}
                        {{-- DYNAMIC TABLE BODY --}}
                        {{-- ================================================= --}}

                        <tbody>

                            @forelse($accounts as $account)

                                <tr>


                                    @foreach ($fields as $field)
                                        @php

                                            /*
                                    |--------------------------------------------------------------------------
                                    | Dynamic Field Value
                                    |--------------------------------------------------------------------------
                                    |
                                    | Default:
                                    | accounts.account_name
                                    |
                                    | Custom:
                                    | accounts.custom_data['account_type']
                                    |
                                    */

                                            $value = $account->getDynamicFieldValue($field);

                                        @endphp


                                        <td class="px-3 py-3">


                                            {{-- ================================= --}}
                                            {{-- BOOLEAN / CHECKBOX --}}
                                            {{-- ================================= --}}

                                            @if ($field->type === 'checkbox')
                                                @if ($value)
                                                    <span class="badge bg-success">
                                                        Yes
                                                    </span>
                                                @else
                                                    <span class="badge bg-secondary">
                                                        No
                                                    </span>
                                                @endif



                                                {{-- ================================= --}}
                                                {{-- URL --}}
                                                {{-- ================================= --}}
                                            @elseif($field->type === 'url' && $value)
                                                <a href="{{ $value }}" target="_blank" rel="noopener noreferrer">

                                                    {{ $value }}

                                                </a>



                                                {{-- ================================= --}}
                                                {{-- EMAIL --}}
                                                {{-- ================================= --}}
                                            @elseif($field->type === 'email' && $value)
                                                <a href="mailto:{{ $value }}">

                                                    {{ $value }}

                                                </a>



                                                {{-- ================================= --}}
                                                {{-- CURRENCY --}}
                                                {{-- ================================= --}}
                                            @elseif($field->type === 'currency' && $value !== null && $value !== '')
                                                {{ number_format((float) $value, 2) }}



                                                {{-- ================================= --}}
                                                {{-- PASSWORD --}}
                                                {{-- ================================= --}}
                                            @elseif($field->type === 'password' && $value)
                                                ********



                                                {{-- ================================= --}}
                                                {{-- ARRAY VALUE --}}
                                                {{-- ================================= --}}
                                            @elseif(is_array($value))
                                                {{ implode(', ', $value) }}



                                                {{-- ================================= --}}
                                                {{-- NORMAL VALUE --}}
                                                {{-- ================================= --}}
                                            @else
                                                @if ($value !== null && $value !== '')
                                                    {{ $value }}
                                                @else
                                                    <span class="text-muted">
                                                        —
                                                    </span>
                                                @endif
                                            @endif


                                        </td>
                                    @endforeach



                                    {{-- ========================================= --}}
                                    {{-- ACTION --}}
                                    {{-- ========================================= --}}

                                    <td class="px-3 py-3 text-end">

                                        <div class="btn-group">


                                            {{-- View --}}
                                            <a href="#" class="btn btn-sm btn-outline-secondary">

                                                View

                                            </a>


                                            {{-- Edit --}}
                                            <a href="#" class="btn btn-sm btn-outline-primary">

                                                Edit

                                            </a>


                                            {{-- Delete --}}
                                            <button type="button" class="btn btn-sm btn-outline-danger">

                                                Delete

                                            </button>


                                        </div>

                                    </td>


                                </tr>


                            @empty


                                <tr>

                                    <td colspan="{{ $fields->count() + 1 }}" class="text-center py-5">

                                        <div class="text-muted">

                                            No accounts found.

                                        </div>

                                    </td>

                                </tr>


                            @endforelse

                        </tbody>


                    </table>

                </div>


            </div>

        </div>



        {{-- ============================================================= --}}
        {{-- PAGINATION --}}
        {{-- ============================================================= --}}

        <div class="mt-4">

            {{ $accounts->links() }}

        </div>


    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


</body>

</html>
