<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Schools | Element</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nav.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons.min.css') }}" rel="stylesheet">
<style>
        /* Existing pagination styling */
        .custom-pagination .page-item.active .page-link {
            color: #fff;
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .custom-pagination .page-item {
            color: #dc3545;
        }

        /* Table responsive fix */
        .school-list-card .table-responsive {
            width: 101%;
            overflow-x: auto !important;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
        }

        .school-table {
            width: 100%;
            min-width: 1100px;
            margin-bottom: 0;
        }

        /* Actions column fix */
        .school-table th:last-child,
        .school-table td:last-child {
            min-width: 110px;
            white-space: nowrap;
        }

        .school-actions {
            display: flex;
            align-items: center;
            flex-wrap: nowrap;
            gap: 8px;
            width: max-content;
        }

        .school-actions form {
            margin: 0;
            flex-shrink: 0;
        }

        .school-actions button {
            flex-shrink: 0;
        }
    </style>
</head>

<body>

<x-navbar />

<section class="hero-section">

    <div class="container-fluid py-2 schools-container">

        <div class="text-center mb-4">
            <h2 class="fw-bold text-danger">Schools</h2>
            <p class="text-muted">View and manage school records.</p>
        </div>

        <div class="card school-list-card">

            {{-- LIVE SEARCH MAIN WRAPPER --}}
            <div class="card-body p-3 p-md-4"
                 data-live-search
                 data-url="{{ route('schools.index') }}">

                <!-- HEADER + SEARCH -->
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                    <div>
                        <h4 class="school-heading mb-1">
                            <i class="bi bi-building-fill me-2"></i>
                            Registered Schools
                        </h4>

                        <small class="text-muted">
                            Manage your school records
                        </small>
                    </div>

                    <div class="d-flex align-items-center gap-3 flex-wrap">

                        {{-- TOTAL COUNT --}}
                        <span class="badge bg-danger rounded-pill px-3 py-2"
                              data-search-total>
                            Total: {{ $schools->total() }}
                        </span>

                        {{-- LIVE SEARCH FORM --}}
                        <form action="{{ route('schools.index') }}"
                              method="GET"
                              data-search-form>

                            <div class="input-group" style="width:250px;">

                                <span class="input-group-text bg-white">
                                    <i class="bi bi-search"></i>
                                </span>

                                <input
                                    type="search"
                                    name="search"
                                    id="schoolSearch"
                                    class="form-control"
                                    placeholder="Search schools..."
                                    value="{{ request('search') }}"
                                    autocomplete="off"
                                    data-search-input
                                >
                            </div>
                        </form>

                        @auth
                            <button
                                type="button"
                                class="btn btn-danger px-3 py-2 fw-semibold"
                                data-bs-toggle="modal"
                                data-bs-target="#schoolModal"
                                id="addSchoolBtn">

                                <i class="bi bi-plus-circle me-2"></i>
                                Add New School

                            </button>
                        @endauth

                    </div>
                </div>


                <!-- TABLE -->
                <div id="schoolTableArea">

                    <div class="table-responsive">

                        <table class="table table-hover school-table">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>School Name</th>
                                    <th>Code</th>
                                    <th>Email</th>
                                    <th>Ph. No.</th>
                                    <th>City/State</th>
                                    <th>Address</th>
                                    <th>Status</th>

                                    @auth
                                        <th>Actions</th>
                                    @endauth
                                </tr>
                            </thead>

                            {{-- AJAX TABLE RESULTS --}}
                            <tbody data-search-results>

                                @forelse($schools as $index => $school)

                                    <tr>

                                        <td>
                                            {{ $schools->firstItem() + $index }}
                                        </td>

                                        <td class="fw-semibold">
                                            {{ $school->school_name }}
                                        </td>

                                        <td>
                                            {{ $school->school_code }}
                                        </td>

                                        <td>
                                            {{ $school->email ?? 'N/A' }}
                                        </td>

                                        <td>
                                            {{ $school->phone ?? 'N/A' }}
                                        </td>

                                        <td>
                                            {{ $school->city ?? 'N/A' }}
                                            {{ $school->state ? ', ' . $school->state : '' }}
                                            {{ $school->pincode ? ', ' . $school->pincode : '' }}
                                        </td>

                                        <td>
                                            {{ $school->address ?? '-' }}
                                        </td>

                                        <td>
                                            @if(strtolower($school->status) === 'active')
                                                <span class="badge bg-success">
                                                    Active
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    {{ $school->status }}
                                                </span>
                                            @endif
                                        </td>

                                        @auth
                                            <td>

                                                {{-- FIXED ACTION BUTTONS --}}
                                                <div class="school-actions">

                                                    {{-- EDIT --}}
                                                    <button
                                                        type="button"
                                                        class="btn btn-sm btn-outline-primary editSchoolBtn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#schoolModal"
                                                        data-url="{{ route('schools.update', $school->id) }}"
                                                        data-id="{{ $school->id }}"
                                                        data-name="{{ $school->school_name }}"
                                                        data-code="{{ $school->school_code }}"
                                                        data-email="{{ $school->email }}"
                                                        data-phone="{{ $school->phone }}"
                                                        data-address="{{ $school->address }}"
                                                        data-city="{{ $school->city }}"
                                                        data-state="{{ $school->state }}"
                                                        data-pincode="{{ $school->pincode }}"
                                                        data-status="{{ $school->status }}">

                                                        <i class="bi bi-pencil-fill"></i>

                                                    </button>

                                                    {{-- DELETE --}}
                                                    <form
                                                        action="{{ route('schools.destroy', $school->id) }}"
                                                        method="POST"
                                                        onsubmit="return confirm('Delete this school?')">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button
                                                            type="submit"
                                                            class="btn btn-sm btn-outline-danger">

                                                            <i class="bi bi-trash-fill"></i>

                                                        </button>

                                                    </form>

                                                </div>

                                            </td>
                                        @endauth

                                    </tr>

                                @empty

                                    <tr>
                                        <td
                                            colspan="@auth 9 @else 8 @endauth"
                                            class="text-center text-muted py-5">

                                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>

                                            No schools found.

                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    {{-- AJAX PAGINATION --}}
                    <div data-search-pagination class="custom-pagination mt-2">
                        {{ $schools->links('pagination::bootstrap-5') }}
                    </div>

                </div>

            </div>
        </div>

    </div>

</section>


<!-- ADD / EDIT SCHOOL MODAL -->
<div class="modal fade schoolModal"
     id="schoolModal"
     tabindex="-1"
     aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered">

        <div class="modal-content">

            <div class="modal-header">

                <div>
                    <h5 class="modal-title school-heading" id="schoolModalLabel">
                        Add New School
                    </h5>

                    <small class="text-muted" id="schoolModalDescription">
                        Enter the school details below.
                    </small>
                </div>

                <button
                    type="button"
                    class="btn-close"
                    data-bs-dismiss="modal"
                    aria-label="Close">
                </button>

            </div>

            <div class="modal-body p-4">

                @if($errors->any())

                    <div class="alert alert-danger border-0 shadow-sm rounded-3">

                        <div class="d-flex align-items-center mb-2">

                            <i class="bi bi-exclamation-triangle-fill fs-5 me-2"></i>

                            <strong>Please correct the following errors:</strong>

                        </div>

                        <ul class="mb-0 mt-2 ps-4">

                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach

                        </ul>

                    </div>

                @endif


                <form
                    id="schoolForm"
                    action="{{ old('_editing_id') ? route('schools.update', old('_editing_id')) : route('schools.store') }}"
                    method="POST">

                    @csrf

                    <input
                        type="hidden"
                        name="_editing_id"
                        id="editing_id"
                        value="{{ old('_editing_id') }}">

                    <input
                        type="hidden"
                        name="_method"
                        id="formMethod"
                        value="{{ old('_editing_id') ? 'PUT' : 'POST' }}">


                    <div class="row g-3">

                        <div class="col-md-8">

                            <label class="form-label fw-semibold">
                                School Name <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="school_name"
                                id="school_name"
                                class="form-control"
                                value="{{ old('school_name') }}"
                                required>

                        </div>


                        <div class="col-md-4">

                            <label class="form-label fw-semibold">
                                School Code <span class="text-danger">*</span>
                            </label>

                            <input
                                type="text"
                                name="school_code"
                                id="school_code"
                                class="form-control"
                                value="{{ old('school_code') }}"
                                required>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Email Address
                            </label>

                            <input
                                type="email"
                                name="email"
                                id="email"
                                class="form-control"
                                value="{{ old('email') }}">

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Phone Number
                            </label>

                            <input
                                type="tel"
                                name="phone"
                                id="phone"
                                class="form-control"
                                value="{{ old('phone') }}"
                                pattern="^[0-9\s\+\-\(\)]+$"
                                title="Digits only, no letters."
                                placeholder="e.g., +91 9876543210">

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Address
                            </label>

                            <textarea
                                name="address"
                                id="address"
                                rows="4"
                                style="resize:none"
                                class="form-control"
                                placeholder="Enter full address">{{ old('address') }}</textarea>

                        </div>


                        <div class="col-md-6">

                            <label class="form-label fw-semibold">
                                Status <span class="text-danger">*</span>
                            </label>

                            <select
                                name="status"
                                id="status"
                                class="form-select"
                                required>

                                <option
                                    value="active"
                                    {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option
                                    value="inactive"
                                    {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>

                            </select>

                        </div>


                        <div class="col-md-4">

                            <label class="form-label fw-semibold">
                                City
                            </label>

                            <input
                                type="text"
                                name="city"
                                id="city"
                                class="form-control"
                                value="{{ old('city') }}">

                        </div>


                        <div class="col-md-4">

                            <label class="form-label fw-semibold">
                                State
                            </label>

                            <input
                                type="text"
                                name="state"
                                id="state"
                                class="form-control"
                                value="{{ old('state') }}">

                        </div>


                        <div class="col-md-4">

                            <label class="form-label fw-semibold">
                                Pincode
                            </label>

                            <input
                                type="text"
                                name="pincode"
                                id="pincode"
                                class="form-control"
                                value="{{ old('pincode') }}"
                                pattern="\d*"
                                title="Numbers only.">

                        </div>

                    </div>


                    <div class="d-flex gap-2 mt-4">

                        <button
                            type="submit"
                            class="btn btn-danger px-4 py-2 fw-semibold"
                            id="saveSchoolBtn">

                            <i class="bi bi-building-add me-2"></i>
                            Save School

                        </button>

                        <button
                            type="button"
                            class="btn btn-outline-secondary px-4 py-2"
                            data-bs-dismiss="modal">

                            Cancel

                        </button>

                    </div>

                </form>

            </div>

        </div>

    </div>

</div>


<x-success-modal />

<x-footer />

{{-- SHARED LIVE SEARCH AND PAGINATION --}}
<script src="{{ asset('js/live-search.js') }}"></script>


<script>
document.addEventListener('DOMContentLoaded', function () {

  

    // MODAL ELEMENTS
    const schoolForm = document.getElementById('schoolForm');

    const modalTitle = document.getElementById('schoolModalLabel');
    const modalDescription = document.getElementById('schoolModalDescription');

    const editingId = document.getElementById('editing_id');
    const formMethod = document.getElementById('formMethod');

    const saveButton = document.getElementById('saveSchoolBtn');

    const addSchoolBtn = document.getElementById('addSchoolBtn');

    const addSchoolUrl = @json(route('schools.store'));


    // ADD SCHOOL
    if (addSchoolBtn) {

        addSchoolBtn.addEventListener('click', function () {

            schoolForm.reset();

            schoolForm.action = addSchoolUrl;

            editingId.value = '';
            formMethod.value = 'POST';

            modalTitle.textContent = 'Add New School';

            modalDescription.textContent =
                'Enter the school details below.';

            saveButton.innerHTML =
                '<i class="bi bi-building-add me-2"></i> Save School';

        });

    }


  
    const schoolModalElement = document.getElementById('schoolModal');

    schoolModalElement.addEventListener('show.bs.modal', function (event) {

        const button = event.relatedTarget;

        if (!button || !button.classList.contains('editSchoolBtn')) {
            return;
        }

        schoolForm.action = button.dataset.url;

        editingId.value = button.dataset.id;
        formMethod.value = 'PUT';

        document.getElementById('school_name').value =
            button.dataset.name || '';

        document.getElementById('school_code').value =
            button.dataset.code || '';

        document.getElementById('email').value =
            button.dataset.email || '';

        document.getElementById('phone').value =
            button.dataset.phone || '';

        document.getElementById('address').value =
            button.dataset.address || '';

        document.getElementById('city').value =
            button.dataset.city || '';

        document.getElementById('state').value =
            button.dataset.state || '';

        document.getElementById('pincode').value =
            button.dataset.pincode || '';

        document.getElementById('status').value =
            button.dataset.status || 'active';


        modalTitle.textContent = 'Update School';

        modalDescription.textContent =
            'Change the school details below.';

        saveButton.innerHTML =
            '<i class="bi bi-check-circle me-2"></i> Update School';

    });


    // CLEAR SEARCH BUTTON
    // Shared live-search.js handles the AJAX request.
    const schoolSearch = document.getElementById('schoolSearch');

    const clearSchoolSearch = document.getElementById('clearSchoolSearch');

    if (schoolSearch && clearSchoolSearch) {

        function updateClearButton() {

            clearSchoolSearch.style.display =
                schoolSearch.value.trim() !== '' ? 'block' : 'none';

        }

        schoolSearch.addEventListener('input', updateClearButton);

        clearSchoolSearch.addEventListener('click', function () {

            schoolSearch.value = '';

            updateClearButton();

            schoolSearch.dispatchEvent(
                new Event('input', { bubbles: true })
            );

            schoolSearch.focus();

        });

    }


    // REOPEN MODAL ON VALIDATION FAILURE
    @if($errors->any())

        const schoolModal = new bootstrap.Modal(
            document.getElementById('schoolModal')
        );

        schoolModal.show();

        @if(old('_editing_id'))

            modalTitle.textContent = 'Update School';

            saveButton.innerHTML =
                '<i class="bi bi-check-circle me-2"></i> Update School';

        @endif

    @endif

});
</script>

</body>
</html>
