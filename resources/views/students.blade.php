
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Students | Element</title>

    <link rel="icon" type="image/png"
          href="{{ asset('images/favicon.png') }}">

    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/nav.css') }}" rel="stylesheet">
    <link href="{{ asset('css/main.css') }}" rel="stylesheet">
    <link href="{{ asset('css/bootstrap-icons.min.css') }}" rel="stylesheet">

</head>

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

                <div class="card-body p-3 p-md-4">

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
                                Total: {{ $students->total() }}
                            </span>

                            @auth<button type="button"
                                    class="btn btn-danger px-3 py-2 fw-semibold"
                                    data-bs-toggle="modal"
                                    data-bs-target="#studentModal"
                                    id="addStudentBtn">

                                <i class="bi bi-plus-circle me-2"></i>
                                Add New Student
                            </button>@endauth

                        </div>
                    </div>

                    {{-- Students table --}}
                    <div class="table-responsive">
                        <form action="{{ route('students') }}" method="GET"
      class="row g-3 align-items-end mb-4">

    {{-- Search by name, email, phone or course --}}
    <div class="col-md-5">
        <label for="search" class="form-label fw-semibold">
            Search Students
        </label>

        <input
            type="text"
            name="search"
            id="search"
            class="form-control"
            placeholder="Enter name, email, phone or course"
            value="{{ request('search') }}"
        >
    </div>

    {{-- Filter by status --}}
    <div class="col-md-3">
        <label for="status_filter" class="form-label fw-semibold">
            Filter by Status
        </label>

        <select name="status" id="status_filter" class="form-select">
            <option value="">All Students</option>

            <option value="Active"
                {{ request('status') == 'Active' ? 'selected' : '' }}>
                Active
            </option>

            <option value="Inactive"
                {{ request('status') == 'Inactive' ? 'selected' : '' }}>
                Inactive
            </option>
        </select>
    </div>
    <div class="col-md-4">
    <button type="submit" class="btn btn-danger">Filter</button>

    <a href="{{ route('students') }}"
       class="btn btn-outline-secondary">Reset</a>
</div>
</form>
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
                                    @auth<th>Actions</th>@endauth
                                </tr>
                            </thead>

                            <tbody>

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

                                        @auth<td>
                                            <div class="d-flex gap-2">

                                                {{-- Edit button --}}
                                                <button type="button"
                                                        class="btn btn-sm btn-outline-primary editStudentBtn"
                                                        title="Edit student"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#studentModal"
                                                        data-url="{{ route('students.update', $student->id) }}"
                                                        data-id="{{ $student->id }}"
                                                        data-name="{{ $student->name }}"
                                                        data-email="{{ $student->email }}"
                                                        data-phone="{{ $student->phone }}"
                                                        data-course="{{ $student->course }}"
                                                        data-status="{{ $student->status }}"
                                                        data-address="{{ $student->address }}">

                                                    <i class="bi bi-pencil-fill"></i>
                                                </button>

                                                {{-- Delete button --}}
                                                <form action="{{ route('students.destroy', $student->id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Are you sure you want to delete this student?')">

                                                    @csrf
                                                    @method('DELETE')

                                                    <button type="submit"
                                                            class="btn btn-sm btn-outline-danger"
                                                            title="Delete student">

                                                        <i class="bi bi-trash-fill"></i>
                                                    </button>
                                                </form>

                                            </div>
                                        </td>@endauth
                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="8"
                                            class="text-center text-muted py-5">

                                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>

                                            No students registered yet.

                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    {{-- Pagination --}}
                    @if($students->total() >= 0)

                        <div class="pagination-wrapper">

                            {{-- Records information --}}
                            <div class="pagination-info">
                                Showing
                                <strong>{{ $students->firstItem() ?? 0 }}</strong>
                                to
                                <strong>{{ $students->lastItem() ?? 0 }}</strong>
                                of
                                <strong>{{ $students->total() }}</strong>
                                students
                            </div>

                            {{-- Page navigation --}}
                            <div class="student-pagination">

                                {{-- Previous --}}
                                <a href="{{ $students->previousPageUrl() ?? '#' }}"
                                   class="student-page-link {{ $students->onFirstPage() ? 'disabled' : '' }}"
                                   aria-label="Previous page">

                                    <i class="bi bi-chevron-left"></i>
                                </a>

                                {{-- Page numbers --}}
                                @foreach($students->getUrlRange(1, $students->lastPage()) as $page => $url)

                                    <a href="{{ $url }}"
                                       class="student-page-link {{ $students->currentPage() == $page ? 'active' : '' }}"
                                       @if($students->currentPage() == $page) aria-current="page" @endif>

                                        {{ $page }}
                                    </a>

                                @endforeach

                                {{-- Next --}}
                                <a href="{{ $students->nextPageUrl() ?? '#' }}"
                                   class="student-page-link {{ !$students->hasMorePages() ? 'disabled' : '' }}"
                                   aria-label="Next page">

                                    <i class="bi bi-chevron-right"></i>
                                </a>

                            </div>

                        </div>

                    @endif

                </div>
            </div>

        </div>
    </section>

    {{-- Add / Edit Student Modal --}}
    <div class="modal fade student-modal"
         id="studentModal"
         tabindex="-1"
         aria-labelledby="studentModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

            <div class="modal-content">

                <div class="modal-header">

                    <div>
                        <h5 class="modal-title student-heading"
                            id="studentModalLabel">
                            Add New Student
                        </h5>

                        <small class="text-muted" id="studentModalDescription">
                            Enter the student details below.
                        </small>
                    </div>

                    <button type="button"
                            class="btn-close"
                            data-bs-dismiss="modal"
                            aria-label="Close">
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

                    <form id="studentForm"
                          action="{{ old('_editing_id')
                              ? route('students.update', old('_editing_id'))
                              : route('students.store') }}"
                          method="POST">

                        @csrf

                        {{-- Used to identify create or edit --}}
                        <input type="hidden"
                               name="_editing_id"
                               id="editing_id"
                               value="{{ old('_editing_id') }}">

                        {{-- Laravel method spoofing for update --}}
                        <input type="hidden"
                               name="_method"
                               id="formMethod"
                               value="{{ old('_editing_id') ? 'PUT' : 'POST' }}">

                        <div class="row g-3">

                            {{-- Name --}}
                            <div class="col-md-6">
                                <label for="name" class="form-label fw-semibold">
                                    Full Name
                                </label>

                                <input type="text"
                                       name="name"
                                       id="name"
                                       class="form-control"
                                       placeholder="Enter full name"
                                       value="{{ old('name') }}"
                                       required>
                            </div>

                            {{-- Email --}}
                            <div class="col-md-6">
                                <label for="email" class="form-label fw-semibold">
                                    Email Address
                                </label>

                                <input type="email"
                                       name="email"
                                       id="email"
                                       class="form-control"
                                       placeholder="example@email.com"
                                       value="{{ old('email') }}"
                                       required>
                            </div>

                            {{-- Phone --}}
                            <div class="col-md-6">
                                <label for="phone" class="form-label fw-semibold">
                                    Phone Number
                                </label>

                                <input type="tel"
                                       name="phone"
                                       id="phone"
                                       class="form-control"
                                       pattern="^[0-9\s\+\-\(\)]+$"
                                       placeholder="Enter phone number"
                                       value="{{ old('phone') }}">
                            </div>

                            {{-- Course --}}
                            <div class="col-md-6">
                                <label for="course" class="form-label fw-semibold">
                                    Course
                                </label>

                                <input type="text"
                                       name="course"
                                       id="course"
                                       class="form-control"
                                       placeholder="Enter course name"
                                       value="{{ old('course') }}">
                            </div>

                            {{-- Status --}}
                            <div class="col-md-6">
                                <label for="status" class="form-label fw-semibold">
                                    Student Status
                                </label>

                                <select name="status"
                                        id="status"
                                        class="form-select"
                                        required>

                                    <option value="Active"
                                        {{ old('status', 'Active') == 'Active' ? 'selected' : '' }}>
                                        Active
                                    </option>

                                    <option value="Inactive"
                                        {{ old('status') == 'Inactive' ? 'selected' : '' }}>
                                        Inactive
                                    </option>
                                </select>
                            </div>

                            {{-- Address --}}
                            <div class="col-md-6">
                                <label for="address" class="form-label fw-semibold">
                                    Address
                                </label>

                                <textarea name="address"
                                          id="address"
                                          rows="3"
                                          style="resize:none"
                                          class="form-control"
                                          placeholder="Enter student address">{{ old('address') }}</textarea>
                            </div>

                        </div>

                        <div class="d-flex gap-2 mt-4">

                            <button type="submit"
                                    class="btn btn-danger px-4 py-2 fw-semibold"
                                    id="saveStudentBtn">

                                <i class="bi bi-person-plus me-2"></i>
                                Save Student
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

    <x-footer/>

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>

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

            const addStudentUrl = @json(route('students.store'));

            // Open modal for adding a new student
            document.getElementById('addStudentBtn')
                .addEventListener('click', function () {

                    studentForm.reset();

                    studentForm.action = addStudentUrl;
                    editingId.value = '';
                    formMethod.value = 'POST';

                    modalTitle.textContent = 'Add New Student';
                    modalDescription.textContent = 'Enter the student details below.';

                    saveButton.innerHTML =
                        '<i class="bi bi-person-plus me-2"></i> Save Student';

                    statusInput.value = 'Active';
                });

            // Open modal for editing an existing student
            document.querySelectorAll('.editStudentBtn')
                .forEach(function (button) {

                    button.addEventListener('click', function () {

                        studentForm.action = this.dataset.url;

                        editingId.value = this.dataset.id;
                        formMethod.value = 'PUT';

                        nameInput.value = this.dataset.name || '';
                        emailInput.value = this.dataset.email || '';
                        phoneInput.value = this.dataset.phone || '';
                        courseInput.value = this.dataset.course || '';
                        statusInput.value = this.dataset.status || 'Active';
                        addressInput.value = this.dataset.address || '';

                        modalTitle.textContent = 'Update Student';
                        modalDescription.textContent =
                            'Change the student details below.';

                        saveButton.innerHTML =
                            '<i class="bi bi-check-circle me-2"></i> Update Student';
                    });
                });

            // Reopen the modal if validation fails
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

            // Automatically show success modal after create, update or delete
            @if(session('success'))

                const successModalElement = document.getElementById('successModal');

                const successModal = new bootstrap.Modal(successModalElement);

                successModal.show();

            @endif

        });
    </script>

</body>
</html>
