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
            <div class="card-body p-3 p-md-4">

                <!-- HEADER + SEARCH -->
                <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                    <div>
                        <h4 class="school-heading mb-1">
                            <i class="bi bi-building-fill me-2"></i>
                            Registered Schools
                        </h4>
                        <small class="text-muted">Manage your school records</small>
                    </div>

                    <div class="d-flex align-items-center gap-3 flex-wrap">

                        <span class="badge bg-danger rounded-pill px-3 py-2"
                              id="schoolTotal">
                            Total: {{ $schools->total() }}
                        </span>

                        <!-- LIVE SEARCH -->
                        <div class="input-group" style="width:250px;">
                            <span class="input-group-text bg-white">
                                <i class="bi bi-search"></i>
                            </span>

                            <input
                                type="search"
                                id="schoolSearch"
                                class="form-control"
                                placeholder="Search schools..."
                                autocomplete="off"
                            >
                        </div>

                        @auth
                            <button type="button"
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

                            <tbody id="schoolTableBody">

                                @forelse($schools as $index => $school)

                                    <tr>
                                        <td>{{ $schools->firstItem() + $index }}</td>

                                        <td class="fw-semibold">
                                            {{ $school->school_name }}
                                        </td>

                                        <td>{{ $school->school_code }}</td>

                                        <td>{{ $school->email ?? 'N/A' }}</td>

                                        <td>{{ $school->phone ?? 'N/A' }}</td>

                                        <td>
                                            {{ $school->city ?? 'N/A' }}
                                            {{ $school->state ? ', ' . $school->state : '' }}
                                            {{ $school->pincode ? ', ' . $school->pincode : '' }}
                                        </td>

                                        <td>{{ $school->address ?? '-' }}</td>

                                        <td>
                                            @if(strtolower($school->status) === 'active')
                                                <span class="badge bg-success">Active</span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    {{ $school->status }}
                                                </span>
                                            @endif
                                        </td>

                                        @auth
                                            <td>
                                                <div class="d-flex gap-2">

                                                    <button type="button"
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

                                                    <form action="{{ route('schools.destroy', $school->id) }}"
                                                          method="POST"
                                                          onsubmit="return confirm('Delete this school?')">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit"
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
                                        <td colspan="@auth 9 @else 8 @endauth"
                                            class="text-center text-muted py-5">
                                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                            No schools found.
                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>
                        </table>
                    </div>

                    <!-- PAGINATION -->
                    <div id="schoolPagination">

                        @if($schools->total() > 0)

                            <div class="pagination-wrapper d-flex flex-column flex-md-row justify-content-between align-items-center gap-3 mt-4">

                                <div class="text-muted small">
                                    Showing
                                    <strong>{{ $schools->firstItem() }}</strong>
                                    to
                                    <strong>{{ $schools->lastItem() }}</strong>
                                    of
                                    <strong>{{ $schools->total() }}</strong>
                                    schools
                                </div>

                                <div class="user-pagination">

                                    @if($schools->onFirstPage())
                                        <span class="user-page-link disabled">
                                            <i class="bi bi-chevron-left"></i>
                                        </span>
                                    @else
                                        <a href="{{ $schools->previousPageUrl() }}"
                                           class="user-page-link">
                                            <i class="bi bi-chevron-left"></i>
                                        </a>
                                    @endif

                                    @foreach($schools->getUrlRange(
                                            max(1, $schools->currentPage() - 2),
                                            min($schools->lastPage(), $schools->currentPage() + 2)
                                        ) as $page => $url)

                                            @if($page == $schools->currentPage())
                                                <span class="user-page-link active">
                                                    {{ $page }}
                                                </span>
                                            @else
                                                <a href="{{ $url }}" class="user-page-link">
                                                    {{ $page }}
                                                </a>
                                            @endif

                                    @endforeach

                                    @if($schools->hasMorePages())
                                        <a href="{{ $schools->nextPageUrl() }}"
                                           class="user-page-link">
                                            <i class="bi bi-chevron-right"></i>
                                        </a>
                                    @else
                                        <span class="user-page-link disabled">
                                            <i class="bi bi-chevron-right"></i>
                                        </span>
                                    @endif

                                </div>
                            </div>

                        @endif

                    </div>

                </div>

            </div>
        </div>
    </div>
</section>


<!-- ADD / EDIT SCHOOL MODAL -->
<div class="modal fade schoolModal" id="schoolModal" tabindex="-1" aria-hidden="true">

    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

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

                <button type="button"
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

                <form id="schoolForm"
                      action="{{ old('_editing_id') ? route('schools.update', old('_editing_id')) : route('schools.store') }}"
                      method="POST">

                    @csrf

                    <input type="hidden"
                           name="_editing_id"
                           id="editing_id"
                           value="{{ old('_editing_id') }}">

                    <input type="hidden"
                           name="_method"
                           id="formMethod"
                           value="{{ old('_editing_id') ? 'PUT' : 'POST' }}">

                    <div class="row g-3">

                        <div class="col-md-8">
                            <label class="form-label fw-semibold">
                                School Name <span class="text-danger">*</span>
                            </label>

                            <input type="text"
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

                            <input type="text"
                                   name="school_code"
                                   id="school_code"
                                   class="form-control"
                                   value="{{ old('school_code') }}"
                                   required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Email Address</label>

                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control"
                                   value="{{ old('email') }}">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Phone Number</label>

                            <input type="tel"
                                   name="phone"
                                   id="phone"
                                   class="form-control"
                                   value="{{ old('phone') }}"
                                   pattern="^[0-9\s\+\-\(\)]+$"
                                   title="Digits only, no letters."
                                   placeholder="e.g., +91 9876543210">
                        </div>

                        <div class="col-md-6">
                            <label class="form-label fw-semibold">Address</label>

                            <textarea name="address"
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

                            <select name="status"
                                    id="status"
                                    class="form-select"
                                    required>

                                <option value="active"
                                    {{ old('status', 'active') == 'active' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="inactive"
                                    {{ old('status') == 'inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>

                            </select>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">City</label>

                            <input type="text"
                                   name="city"
                                   id="city"
                                   class="form-control"
                                   value="{{ old('city') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">State</label>

                            <input type="text"
                                   name="state"
                                   id="state"
                                   class="form-control"
                                   value="{{ old('state') }}">
                        </div>

                        <div class="col-md-4">
                            <label class="form-label fw-semibold">Pincode</label>

                            <input type="text"
                                   name="pincode"
                                   id="pincode"
                                   class="form-control"
                                   value="{{ old('pincode') }}"
                                   pattern="\d*"
                                   title="Numbers only.">
                        </div>

                    </div>

                    <div class="d-flex gap-2 mt-4">

                        <button type="submit"
                                class="btn btn-danger px-4 py-2 fw-semibold"
                                id="saveSchoolBtn">

                            <i class="bi bi-building-add me-2"></i>
                            Save School
                        </button>

                        <button type="button"
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

<script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {

    // SUCCESS MODAL
    @if(session('success'))
        const successModalElement = document.getElementById('successModal');

        if (successModalElement) {
            const successModal = new bootstrap.Modal(successModalElement);
            successModal.show();
        }
    @endif


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
            modalDescription.textContent = 'Enter the school details below.';

            saveButton.innerHTML =
                '<i class="bi bi-building-add me-2"></i> Save School';

        });
    }


    // EDIT SCHOOL - EVENT DELEGATION
    // Works even after AJAX replaces table rows.
    document.addEventListener('click', function (event) {

        const button = event.target.closest('.editSchoolBtn');

        if (!button) return;

        schoolForm.action = button.dataset.url;
        editingId.value = button.dataset.id;
        formMethod.value = 'PUT';

        document.getElementById('school_name').value = button.dataset.name || '';
        document.getElementById('school_code').value = button.dataset.code || '';
        document.getElementById('email').value = button.dataset.email || '';
        document.getElementById('phone').value = button.dataset.phone || '';
        document.getElementById('address').value = button.dataset.address || '';
        document.getElementById('city').value = button.dataset.city || '';
        document.getElementById('state').value = button.dataset.state || '';
        document.getElementById('pincode').value = button.dataset.pincode || '';
        document.getElementById('status').value = button.dataset.status || 'active';

        modalTitle.textContent = 'Update School';
        modalDescription.textContent = 'Change the school details below.';

        saveButton.innerHTML =
            '<i class="bi bi-check-circle me-2"></i> Update School';

    });


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


    // ==================================
    // LIVE SEARCH WITHOUT PAGE RELOAD
    // ==================================

    const schoolSearch = document.getElementById('schoolSearch');
    const schoolTableBody = document.getElementById('schoolTableBody');
    const schoolPagination = document.getElementById('schoolPagination');
    const schoolTotal = document.getElementById('schoolTotal');
    const schoolTableArea = document.getElementById('schoolTableArea');

    let searchTimer;
    let searchController = null;


    async function loadSchools(url = null) {

        clearTimeout(searchTimer);

        searchTimer = setTimeout(async function () {

            if (searchController) {
                searchController.abort();
            }

            searchController = new AbortController();

            const params = new URLSearchParams({
                search: schoolSearch.value
            });

            const requestUrl = url ||
                `{{ route('schools.index') }}?${params.toString()}`;

            try {

                schoolTableArea.style.opacity = '0.5';

                const response = await fetch(requestUrl, {
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'text/html'
                    },
                    signal: searchController.signal
                });

                if (!response.ok) {
                    throw new Error('Unable to load schools');
                }

                const html = await response.text();

                const parser = new DOMParser();
                const doc = parser.parseFromString(html, 'text/html');

                const newBody = doc.getElementById('schoolTableBody');
                const newPagination = doc.getElementById('schoolPagination');
                const newTotal = doc.getElementById('schoolTotal');

                if (!newBody || !newPagination || !newTotal) {
                    throw new Error('Invalid server response');
                }

                // Replace only table rows
                schoolTableBody.innerHTML = newBody.innerHTML;

                // Replace pagination
                schoolPagination.innerHTML = newPagination.innerHTML;

                // Update total count
                schoolTotal.textContent = newTotal.textContent;

            } catch (error) {

                if (error.name !== 'AbortError') {
                    console.error(error);
                }

            } finally {

                schoolTableArea.style.opacity = '1';

            }

        }, url ? 0 : 350);

    }


    // SEARCH WHILE TYPING
    schoolSearch.addEventListener('input', function () {
        loadSchools();
    });


    // AJAX PAGINATION
    document.addEventListener('click', function (event) {

        const link = event.target.closest(
            '#schoolPagination .user-pagination a'
        );

        if (link) {

            event.preventDefault();

            loadSchools(link.href);

        }

    });

});
</script>

</body>
</html>
