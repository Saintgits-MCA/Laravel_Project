
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Dashboard | Element</title>

    <style>
        body {
            background: #f7f7fb;
            font-family: Arial, sans-serif;
            min-height: 100vh;
        }

        .dashboard-wrapper {
            padding: 50px 0;
            min-height: 75vh;
        }

        .welcome-section {
            background: linear-gradient(120deg, #ff777d, #ffe1e2);
            padding: 45px;
            border-radius: 16px;
            margin-bottom: 30px;
        }

        .welcome-section h1 {
            font-weight: 700;
            color: #222;
        }

        .welcome-section p {
            color: #444;
        }

        .dashboard-card {
            background: white;
            padding: 25px;
            border-radius: 14px;
            box-shadow: 0 4px 18px rgba(0,0,0,0.06);
            height: 100%;
            transition: 0.3s;
        }

        .dashboard-card:hover {
            transform: translateY(-5px);
        }

        .dashboard-icon {
            font-size: 35px;
            color: #dc3545;
            margin-bottom: 15px;
        }

        .dashboard-card h5 {
            font-weight: 700;
        }

        .dashboard-link {
            color: #dc3545;
            text-decoration: none;
            font-weight: 600;
        }

        .dashboard-link:hover {
            color: #a71d2a;
        }

        .welcome-btn {
            background: #dc3545;
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 7px;
            text-decoration: none;
            display: inline-block;
            font-weight: 600;
        }

        .welcome-btn:hover {
            background: #bb2d3b;
            color: white;
        }
        /* Keep navbar above all dashboard content */
.custom-navbar {
    position: relative !important;
    z-index: 9999 !important;
    overflow: visible !important;
}

/* Allow dropdown to display above dashboard sections */
.custom-navbar .navbar-collapse {
    overflow: visible !important;
}

.custom-navbar .dropdown {
    position: relative;
}

.custom-navbar .dropdown-menu {
    position: absolute;
    z-index: 10000 !important;
}

/* Keep dashboard content below navbar */
.dashboard-wrapper {
    position: relative;
    z-index: 1;
}

/* Prevent dashboard cards from covering navbar dropdown */
.dashboard-card {
    position: relative;
    z-index: 0;
}
    </style>
</head>

<body>

    <x-navbar />

    <div class="container dashboard-wrapper">

        <!-- Welcome Section -->
        <div class="welcome-section">

            <span class="badge bg-light text-danger mb-3">
                ELEMENT DASHBOARD
            </span>

            <h1>
                Welcome Back, {{ Auth::user()->name }}!
            </h1>

            <p class="mt-3 mb-4">
                You have successfully logged in to Element.
                Manage your users, students, and schools from your dashboard.
            </p>

            <a href="{{ route('user_index') }}" class="welcome-btn">
                Explore Users <i class="bi bi-arrow-right"></i>
            </a>

        </div>

        <!-- Dashboard Cards -->
        <div class="row g-4">

            <!-- Users -->
            <div class="col-md-6 col-lg-4">
                <div class="dashboard-card">

                    <div class="dashboard-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>

                    <h5>Users Management</h5>

                    <p class="text-muted">
                        View and manage registered users.
                    </p>

                    <a href="{{ route('user_index') }}" class="dashboard-link">
                        View Users →
                    </a>

                </div>
            </div>

            <!-- Students -->
            <div class="col-md-6 col-lg-4">
                <div class="dashboard-card">

                    <div class="dashboard-icon">
                        <i class="bi bi-mortarboard-fill"></i>
                    </div>

                    <h5>Students Management</h5>

                    <p class="text-muted">
                        Access and manage student records.
                    </p>

                    <a href="{{ route('students') }}" class="dashboard-link">
                        View Students →
                    </a>

                </div>
            </div>

            <!-- Schools -->
            <div class="col-md-6 col-lg-4">
                <div class="dashboard-card">

                    <div class="dashboard-icon">
                        <i class="bi bi-building-fill"></i>
                    </div>

                    <h5>Schools Management</h5>

                    <p class="text-muted">
                        View and manage registered schools.
                    </p>

                    <a href="{{ route('schools.index') }}" class="dashboard-link">
                        View Schools →
                    </a>

                </div>
            </div>

        </div>

    </div>

    <x-footer />

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const dropdownButton = document.getElementById('userDropdown');

        if (dropdownButton && window.bootstrap) {
            bootstrap.Dropdown.getOrCreateInstance(dropdownButton);
        } else {
            console.error('Bootstrap JavaScript or userDropdown button not found.');
        }
    });
</script>
</body>
</html>
