
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Element | Users</title>

    <link rel="icon" href="{{ asset('images/favicon.png') }}">
</head>
<style>
    .custom-pagination .page-item.active .page-link {
    color: #fff;
    background-color: #dc3545;
    border-color: #dc3545;
}
.custom-pagination .page-item{
color: #dc3545;
}
</style>
<body>

    <x-navbar />

    <section class="hero-section">

        <div class="container-fluid pt-1 pb-5 users-container">

            {{-- Page heading --}}
            <div class="text-center mb-4">
                <h2 class="fw-bold text-danger">Users</h2>

                <p class="text-muted">
                    View and manage registered users.
                </p>
            </div>

            {{-- Users table card --}}
            <div class="card user-list-card">

       <div class="card-body py-3 p-md-4" data-live-search data-url="{{ route('user_index') }}">
                    {{-- Table heading and Add button --}}
                    <div class="d-flex justify-content-between align-items-center flex-wrap gap-3 mb-4">

                        <div>
                            <h4 class="user-heading mb-1">
                                <i class="bi bi-people-fill me-2"></i>
                                Registered Users
                            </h4>

                            <small class="text-muted">
                                View and manage registered users
                            </small>
                        </div>

                        <div class="d-flex align-items-center gap-3">

                            <span class="badge bg-danger rounded-pill px-3 py-2" data-search-total>
                                Total: {{ $users->total() }}
                            </span>
                            {{-- Live Search with Clear Button --}}
                            <form action="{{ route('user_index') }}" class="mt-2" method="GET" data-search-form class="mb-4">
                            
                                <div class="input-group" style="max-width: 350px;">
                            
                                    <span class="input-group-text bg-white">
                                        <i class="bi bi-search"></i>
                                    </span>
                            
                                    <input type="text" name="search" id="userSearch" class="form-control" placeholder="Search users..."
                                        value="{{ request('search') }}" data-search-input autocomplete="off">
                            
                                    <button type="button" class="btn btn-outline-secondary" id="clearUserSearch" aria-label="Clear search"
                                        style="{{ request('search') ? '' : 'display: none;' }}">
                            
                                        <i class="bi bi-x-lg"></i>
                            
                                    </button>
                            
                                </div>
                            
                            </form>
                           <button type="button"
                                    class="btn btn-danger px-3 py-2 fw-semibold"
                                    id="addUserBtn"
                                    data-bs-toggle="modal"
                                    data-bs-target="#userModal">

                                <i class="bi bi-person-plus me-2"></i>
                                Add New User
                            </button>

                        </div>

                    </div>

                    {{-- Users table --}}
                    <div class="table-responsive">

                        <table class="table table-hover user-table w-100">

                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Registered Date</th>
                                    @auth<th>Actions</th>@endauth
                                </tr>
                            </thead>

                            <tbody data-search-results>

                                @forelse($users as $user)

                                    <tr>
                                        <td>{{ $user->id }}</td>

                                        <td class="fw-semibold">
                                            {{ $user->name }}
                                        </td>

                                        <td>{{ $user->email }}</td>

                                        <td>
                                            {{ $user->created_at?->format('d M Y') ?? 'N/A' }}
                                        </td>

                                        @auth<td>
                                            <button type="button"
                                                    class="btn btn-sm btn-outline-primary editUserBtn"
                                                    title="Edit user"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#userModal"
                                                    data-id="{{ $user->id }}"
                                                    data-name="{{ $user->name }}"
                                                    data-email="{{ $user->email }}"
                                                    data-password="{{$user->password}}"
                                                    data-url="{{ route('users.update', $user->id) }}">

                                                <i class="bi bi-pencil-fill me-1"></i>
                                                
                                            </button>
                                        </td>@endauth
                                    </tr>

                                @empty

                                    <tr>
                                        <td colspan="5"
                                            class="text-center text-muted py-4">

                                            <i class="bi bi-inbox fs-2 d-block mb-2"></i>
                                            No users found in the database.

                                        </td>
                                    </tr>

                                @endforelse

                            </tbody>

                        </table>

                    </div>

                    <div data-search-pagination class="custom-pagination">
                        {{ $users->links('pagination::bootstrap-5') }}
                    </div>

                </div>
            </div>

        </div>
    </section>

    {{-- Add / Edit User Modal --}}
    <div class="modal fade user-modal"
         id="userModal"
         tabindex="-1"
         aria-labelledby="userModalLabel"
         aria-hidden="true">

        <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">

            <div class="modal-content">

                <div class="modal-header">

                    <div>
                        <h5 class="modal-title user-heading"
                            id="userModalLabel">

                            <i class="bi bi-person-plus me-2"></i>
                            Create User

                        </h5>

                        <small class="text-muted"
                               id="userModalDescription">
                            Enter the details to register a new user.
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

                    {{-- Add / Edit Form --}}
                    <form id="userForm"
                          action="{{ old('_editing_id')
    ? route('users.update', old('_editing_id'))
    : route('users.store') }}"
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

                        {{-- Name --}}
                        <div class="mb-3">

                            <label for="name"
                                   class="form-label fw-semibold">
                                Full Name
                            </label>

                            <input type="text"
                                   name="name"
                                   id="name"
                                   class="form-control @error('name') is-invalid @enderror"
                                   placeholder="Enter full name"
                                   value="{{ old('name') }}"
                                   required>

                            @error('name')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Email --}}
                        <div class="mb-3">

                            <label for="email"
                                   class="form-label fw-semibold">
                                Email Address
                            </label>

                            <input type="email"
                                   name="email"
                                   id="email"
                                   class="form-control @error('email') is-invalid @enderror"
                                   placeholder="example@email.com"
                                   value="{{ old('email') }}"
                                   required>

                            @error('email')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Password --}}
                        <div class="mb-3">

                            <label for="password"
                                   class="form-label fw-semibold"
                                   id="passwordLabel" value="{{ old('password') }}">
                                Password
                            </label>

                            <div class="input-group">

                                <input type="password"
                                       name="password"
                                       id="password"
                                       class="form-control @error('password') is-invalid @enderror"
                                       placeholder="Minimum 4 characters"
                                       autocomplete="new-password" value="{{ old('password') }}">

                                <button class="btn password-toggle"
                                        type="button"
                                        onclick="togglePassword('password', 'passwordEye')"
                                        aria-label="Show password">

                                    <i class="bi bi-eye"
                                       id="passwordEye"></i>

                                </button>

                            </div>

                            <small class="text-muted" id="passwordHelp">
                                Required when creating a new user.
                            </small>

                            @error('password')
                                <div class="text-danger small mt-1">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>

                        {{-- Confirm Password --}}
                        <div class="mb-4">

                            <label for="password_confirmation"
                                   class="form-label fw-semibold">
                                Confirm Password
                            </label>

                            <div class="input-group">

                                <input type="password"
                                       name="password_confirmation"
                                       id="password_confirmation"
                                       class="form-control"
                                       placeholder="Re-enter password"
                                       autocomplete="new-password">

                                <button class="btn password-toggle"
                                        type="button"
                                        onclick="togglePassword('password_confirmation', 'confirmPasswordEye')"
                                        aria-label="Show confirm password">

                                    <i class="bi bi-eye"
                                       id="confirmPasswordEye"></i>

                                </button>

                            </div>

                        </div>

                        {{-- Submit and Cancel --}}
                        <div class="d-flex gap-2">

                            <button type="submit"
                                    class="btn btn-danger px-4 py-2 fw-semibold"
                                    id="saveUserBtn">

                                <i class="bi bi-person-plus me-2"></i>
                                Register User

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

    <script src="{{ asset('js/live-search.js') }}"></script>

    <script>
        // Password Show / Hide
        function togglePassword(inputId, iconId) {

            const passwordInput = document.getElementById(inputId);
            const eyeIcon = document.getElementById(iconId);

            if (passwordInput.type === 'password') {

                passwordInput.type = 'text';

                eyeIcon.classList.remove('bi-eye');
                eyeIcon.classList.add('bi-eye-slash');

            } else {

                passwordInput.type = 'password';

                eyeIcon.classList.remove('bi-eye-slash');
                eyeIcon.classList.add('bi-eye');

            }
        }

        document.addEventListener('DOMContentLoaded', function () {
            // Live search clear button
            const userSearch = document.getElementById('userSearch');
            const clearUserSearch = document.getElementById('clearUserSearch');

            function updateClearButton() {
                clearUserSearch.style.display =
                    userSearch.value.trim() !== '' ? 'block' : 'none';
            }

            userSearch.addEventListener('input', updateClearButton);

            clearUserSearch.addEventListener('click', function () {

                userSearch.value = '';

                updateClearButton();

                // Trigger shared AJAX live search
                userSearch.dispatchEvent(
                    new Event('input', { bubbles: true })
                );

                userSearch.focus();
            });
            const userModal = document.getElementById('userModal');
            const userForm = document.getElementById('userForm');

            const modalTitle = document.getElementById('userModalLabel');
            const modalDescription = document.getElementById('userModalDescription');

            const editingId = document.getElementById('editing_id');
            const formMethod = document.getElementById('formMethod');

            const nameInput = document.getElementById('name');
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const confirmPasswordInput = document.getElementById('password_confirmation');

            const passwordLabel = document.getElementById('passwordLabel');
            const passwordHelp = document.getElementById('passwordHelp');

            const saveButton = document.getElementById('saveUserBtn');

            const addUserUrl = @json(route('users.store'));

            // Reset modal for adding a new user
            document.getElementById('addUserBtn')
                .addEventListener('click', function () {

                    userForm.reset();

                    userForm.action = addUserUrl;

                    editingId.value = '';
                    formMethod.value = 'POST';

                    modalTitle.innerHTML =
                        '<i class="bi bi-person-plus me-2"></i> Create User';

                    modalDescription.textContent =
                        'Enter the details to register a new user.';

                    passwordLabel.textContent = 'Password';
                    passwordInput.placeholder = 'Minimum 8 characters';
                    passwordHelp.textContent =
                        'Required when creating a new user.';

                    passwordInput.required = true;
                    confirmPasswordInput.required = true;

                    saveButton.innerHTML =
                        '<i class="bi bi-person-plus me-2"></i> Register User';

                });

           userModal.addEventListener('show.bs.modal', function (event) {

                const button = event.relatedTarget;

                // Only execute when Edit button opens the modal
                if (!button || !button.classList.contains('editUserBtn')) {
                    return;
                }

                userForm.reset();

                // Set update URL
                userForm.action = button.dataset.url;

                editingId.value = button.dataset.id;
                formMethod.value = 'PUT';

                // Prefill user details
                nameInput.value = button.dataset.name || '';
                emailInput.value = button.dataset.email || '';

                // Prefill existing password (your current plain-text setup)
                passwordInput.value = button.dataset.password || '';
                confirmPasswordInput.value = button.dataset.password || '';

                // Password is optional during editing
                passwordInput.required = false;
                confirmPasswordInput.required = false;

                // Update modal heading
                modalTitle.innerHTML =
                    '<i class="bi bi-pencil-square me-2"></i> Edit User';

                modalDescription.textContent =
                    'Update the user details below.';

                passwordLabel.textContent = 'Password';

                passwordInput.placeholder = 'Enter password';

                passwordHelp.textContent =
                    'You can keep or change the existing password.';

                saveButton.innerHTML =
                    '<i class="bi bi-check-circle me-2"></i> Update User';

            });

            // Reopen modal when validation fails
            @if($errors->any())

                const modal = new bootstrap.Modal(userModal);
                modal.show();

                @if(old('_editing_id'))

                    modalTitle.innerHTML =
                        '<i class="bi bi-pencil-square me-2"></i> Edit User';

                    modalDescription.textContent =
                        'Correct the details and try again.';

                    passwordLabel.textContent = 'New Password';

                    passwordInput.required = false;
                    confirmPasswordInput.required = false;

                    passwordHelp.textContent =
                        'Only enter a password if you want to change it.';

                    saveButton.innerHTML =
                        '<i class="bi bi-check-circle me-2"></i> Update User';

                @else

                    passwordInput.required = true;
                    confirmPasswordInput.required = true;

                @endif

            @endif

            // Automatically show success modal
            @if(session('success'))

                const successModalElement =
                    document.getElementById('successModal');

                const successModal =
                    new bootstrap.Modal(successModalElement);

                successModal.show();

            @endif

        });
    </script>

</body>
</html>
