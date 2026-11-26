<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Students | Element</title>

    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nav.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons.min.css') }}" rel="stylesheet">

</head>
<style>
    .custom-pagination .page-item.active .page-link {
        color: #fff;
        background-color: #dc3545;
        border-color: #dc3545;
    }

    .custom-pagination .page-item {
        color: #dc3545;
    }
</style>
<body>

    <x-navbar />

    <section class="hero-section">

        <div class="container-fluid py-2 students-container">

            {{-- Page heading --}}
            <div class="text-center mb-4">
                <h2 class="fw-bold text-danger">Students</h2>
                <p class="text-muted">
                    View and manage student records.
                </p>
            </div>

            {{-- Student list --}}
            <div class="card student-list-card">

                {{-- Live search wrapper --}}
                <div class="card-body p-3 p-md-4" data-live-search data-url="{{ route('students') }}">

                    {{-- Table heading and Add button --}}
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                        <div>
                            <h4 class="student-heading mb-1">
                                <i class="bi bi-person-badge me-2"></i>
                                Registered Students
                            </h4>

                            <small class="text-muted">
                                Manage your student records
                            </small>
                        </div>

                        <div class="d-flex align-items-center gap-3">

                            <span class="badge bg-danger rounded-pill px-3 py-2">
                                Total:
                                <span data-search-total>{{ $students->total() }}</span>
                            </span>

                            @auth
                                <button type="button" class="btn btn-danger px-3 py-2 fw-semibold" data-bs-toggle="modal"
                                    data-bs-target="#studentModal" id="addStudentBtn">

                                    <i class="bi bi-plus-circle me-2"></i>
                                    Add New Student
                                </button>
                            @endauth

                        </div>
                    </div>

                    {{-- Search and status filter --}}
                    <form action="{{ route('students') }}" method="GET" class="row g-3 align-items-end mb-4"
                        data-search-form>

                        {{-- Search with Clear Button --}}
                        <div class="col-md-5">

                            <label for="studentSearch" class="form-label fw-semibold">
                                Search Students
                            </label>

                            <div class="input-group">

                                <span class="input-group-text bg-white">
                                    <i class="bi bi-search"></i>
                                </span>

                                <input type="text" name="search" id="studentSearch" class="form-control"
                                    placeholder="Enter name, email, phone or course" value="{{ request('search') }}"
                                    data-search-input autocomplete="off">

                                <button type="button" class="btn btn-outline-secondary" id="clearStudentSearch"
                                    aria-label="Clear search" style="{{ request('search') ? '' : 'display: none;' }}">

                                    <i class="bi bi-x-lg"></i>

                                </button>

                            </div>

                        </div>

                        {{-- Status Filter --}}
                        <div class="col-md-3">

                            <label for="status_filter" class="form-label fw-semibold">
                                Filter by Status
                            </label>

                            <select name="status" id="status_filter" class="form-select" data-search-filter>

                                <option value="">All Students</option>

                                <option value="Active" {{ request('status') == 'Active' ? 'selected' : '' }}>
                                    Active
                                </option>

                                <option value="Inactive" {{ request('status') == 'Inactive' ? 'selected' : '' }}>
                                    Inactive
                                </option>

                            </select>

                        </div>

                    </form>

                    {{-- Students table --}}
                    <div class="table-responsive">

                        <table class="table table-hover student-table">

                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Course</th>
                                    <th>Status</th>
                                    <th>Address</th>
                                    @auth
                                        <th>Actions</th>
                                    @endauth
                                </tr>
                            </thead>

                            <tbody data-search-results>

                                @forelse($students as $index => $student)

                                    <tr>
                                        <td>
                                            {{ $students->firstItem() + $index }}
                                        </td>

                                        <td class="fw-semibold">
                                            {{ $student->name }}
                                        </td>

                                        <td>{{ $student->email }}</td>

                                        <td>{{ $student->phone ?? 'N/A' }}</td>

                                        <td>{{ $student->course ?? 'N/A' }}</td>

                                        <td>
                                            @if($student->status === 'Active')
                                                <span class="badge bg-success">
                                                    Active
                                                </span>
                                            @else
                                                <span class="badge bg-secondary">
                                                    Inactive
                                                </span>
                                            @endif
                                        </td>

                                        <td style="white-space: normal; min-width: 150px;">
                                            {{ $student->address ?? 'N/A' }}
                                        </td>

                                        @auth
                                            <td>
                                                <div class="d-flex gap-2">

                                                    {{-- Edit button --}}
                                                    <button type="button" class="btn btn-sm btn-outline-primary editStudentBtn"
                                                        title="Edit student" data-bs-toggle="modal"
                                                        data-bs-target="#studentModal"
                                                        data-url="{{ route('students.update', $student->id) }}"
                                                        data-id="{{ $student->id }}" data-name="{{ $student->name }}"
                                                        data-email="{{ $student->email }}" data-phone="{{ $student->phone }}"
                                                        data-course="{{ $student->course }}"
                                                        data-status="{{ $student->status }}"
                                                        data-address="{{ $student->address }}">

                                                        <i class="bi bi-pencil-fill"></i>
                                                    </button>

                                                    {{-- Delete button --}}
                                                    <form action="{{ route('students.destroy', $student->id) }}" method="POST"
                                                        onsubmit="return confirm('Are you sure you want to delete this student?')">

                                                        @csrf
                                                        @method('DELETE')

                                                        <button type="submit" class="btn btn-sm btn-outline-danger"
                                                            title="Delete student">

                                                            <i class="bi bi-trash-fill"></i>
                                                        </button>

                                                    </form>

                                                </div>
                                            </td>
                                        @endauth

                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="8" class="text-center text-muted py-5">

                                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>

                                            No students found.

                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>
<div data-search-pagination class="custom-pagination">
    {{ $students->links('pagination::bootstrap-5') }}
</div>


                    </div>

                </div>
            </div>

        </div>

    </section>


    {{-- Add / Edit Student Modal --}}
    <div class="modal fade student-modal" id="studentModal" tabindex="-1" aria-labelledby="studentModalLabel"
        aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

            <div class="modal-content">

                <div class="modal-header">

                    <div>
                        <h5 class="modal-title student-heading" id="studentModalLabel">
                            Add New Student
                        </h5>

                        <small class="text-muted" id="studentModalDescription">
                            Enter the student details below.
                        </small>
                    </div>

                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                    </button>

                </div>

                <div class="modal-body p-4">

                    {{-- Validation errors --}}
                    @if($errors->any())

                        <div class="alert alert-danger">

                            <strong>Please correct the following:</strong>

                            <ul class="mb-0 mt-2">

                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach

                            </ul>

                        </div>

                    @endif

                    <form id="studentForm" action="{{ old('_editing_id')
    ? route('students.update', old('_editing_id'))
    : route('students.store') }}" method="POST">

                        @csrf

                        {{-- Used to identify create or edit --}}
                        <input type="hidden" name="_editing_id" id="editing_id" value="{{ old('_editing_id') }}">

                        {{-- Laravel method spoofing --}}
                        <input type="hidden" name="_method" id="formMethod"
                            value="{{ old('_editing_id') ? 'PUT' : 'POST' }}">

                        <div class="row g-3">

                            {{-- Name --}}
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">
                                    Full Name
                                </label>

                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Enter full name" value="{{ old('name') }}" required>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">
                                    Email Address
                                </label>

                                <input type="email" name="email" id="email" class="form-control"
                                    placeholder="example@email.com" value="{{ old('email') }}" required>
                            </div>

                            {{-- Phone --}}
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">
                                    Phone Number
                                </label>

                                <input type="tel" name="phone" id="phone" class="form-control"
                                    pattern="^[0-9\s\+\-\(\)]+$" placeholder="Enter phone number"
                                    value="{{ old('phone') }}">
                            </div>

                            {{-- Course --}}
                            <div class="col-md-6">
                                <label for="course" class="form-label fw-semibold">
                                    Course
                                </label>

                                <input type="text" name="course" id="course" class="form-control"
                                    placeholder="Enter course name" value="{{ old('course') }}">
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-semibold">
                                    Student Status
                                </label>

                                <select name="status" id="status" class="form-select" required>

                                    <option value="Active" {{ old('status', 'Active') == 'Active' ? 'selected' : '' }}>
                                        Active
                                    </option>

                                    <option value="Inactive" {{ old('status') == 'Inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>

                                </select>
                            </div>

                            {{-- Address --}}
                            <div class="col-md-6">
                                <label for="address" class="form-label fw-semibold">
                                    Address
                                </label>

                                <textarea name="address" id="address" rows="3" style="resize:none" class="form-control"
                                    placeholder="Enter student address">{{ old('address') }}</textarea>
                            </div>

                        </div>

                        <div class="d-flex gap-2 mt-4">

                            <button type="submit" class="btn btn-danger px-4 py-2 fw-semibold" id="saveStudentBtn">

                                <i class="bi bi-person-plus me-2"></i>
                                Save Student

                            </button>

                            <button type="button" class="btn btn-outline-secondary px-4 py-2" data-bs-dismiss="modal">

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

    {{-- Shared live search --}}
    <script src="{{ asset('js/live-search.js') }}"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {

            const studentModal = document.getElementById('studentModal');
            const studentForm = document.getElementById('studentForm');

            const modalTitle = document.getElementById('studentModalLabel');
            const modalDescription = document.getElementById('studentModalDescription');

            const editingId = document.getElementById('editing_id');
            const formMethod = document.getElementById('formMethod');
            const saveButton = document.getElementById('saveStudentBtn');

            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const phoneInput = document.getElementById('phone');
            const courseInput = document.getElementById('course');
            const statusInput = document.getElementById('status');
            const addressInput = document.getElementById('address');

            const addStudentBtn = document.getElementById('addStudentBtn');

            const addStudentUrl = @json(route('students.store'));


            // Search Clear Button
            const studentSearch = document.getElementById('studentSearch');
            const clearStudentSearch = document.getElementById('clearStudentSearch');

            function updateClearButton() {

                clearStudentSearch.style.display =
                    studentSearch.value.trim() !== '' ? 'block' : 'none';

            }

            // Show or hide clear button while typing
            studentSearch.addEventListener('input', updateClearButton);

            // Clear search and trigger AJAX live search
            clearStudentSearch.addEventListener('click', function () {

                studentSearch.value = '';

                updateClearButton();

                // Trigger shared AJAX live search
                studentSearch.dispatchEvent(new Event('input', {
                    bubbles: true
                }));

                studentSearch.focus();

            });


            // Open modal for adding a new student
            if (addStudentBtn) {

                addStudentBtn.addEventListener('click', function () {

                    studentForm.reset();

                    studentForm.action = addStudentUrl;

                    editingId.value = '';
                    formMethod.value = 'POST';

                    modalTitle.textContent = 'Add New Student';

                    modalDescription.textContent =
                        'Enter the student details below.';

                    saveButton.innerHTML =
                        '<i class="bi bi-person-plus me-2"></i> Save Student';

                    statusInput.value = 'Active';

                });

            }


            // Open modal for editing an existing student.
            // Event delegation keeps this working after AJAX search.
            document.addEventListener('click', function (event) {

                const button = event.target.closest('.editStudentBtn');

                if (!button) return;

                studentForm.action = button.dataset.url;

                editingId.value = button.dataset.id;
                formMethod.value = 'PUT';

                nameInput.value = button.dataset.name || '';
                emailInput.value = button.dataset.email || '';
                phoneInput.value = button.dataset.phone || '';
                courseInput.value = button.dataset.course || '';
                statusInput.value = button.dataset.status || 'Active';
                addressInput.value = button.dataset.address || '';

                modalTitle.textContent = 'Update Student';

                modalDescription.textContent =
                    'Change the student details below.';

                saveButton.innerHTML =
                    '<i class="bi bi-check-circle me-2"></i> Update Student';

            });


            // Reopen modal if validation fails
            @if($errors->any())

                const modal = new bootstrap.Modal(studentModal);

                modal.show();

                @if(old('_editing_id'))

                    modalTitle.textContent = 'Update Student';

                    modalDescription.textContent =
                        'Correct the details and try again.';

                    saveButton.innerHTML =
                        '<i class="bi bi-check-circle me-2"></i> Update Student';

                @endif

            @endif


                // Automatically show success modal
                @if(session('success'))

                    const successModalElement =
                        document.getElementById('successModal');

                    if (successModalElement) {

                        const successModal =
                            new bootstrap.Modal(successModalElement);

                        successModal.show();

                    }

                @endif

    });
    </script>

</body>

</html>