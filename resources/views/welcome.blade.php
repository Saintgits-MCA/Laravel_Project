<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Element | Home</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/favicon.png') }}">

    <!-- Bootstrap CSS -->
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Navbar CSS -->
    <link href="{{ asset('css/nav.css') }}" rel="stylesheet">
  <link href="{{ asset('css/main.css') }}" rel="stylesheet">
   
</head>

<body>

    <!-- Common Navbar -->
    <x-navbar />

    <!-- Hero Section -->
    <main>

        <section class="hero-section">

            <div class="hero-container">

                <!-- Left Content -->
                <div class="hero-content">

                    <div class="hero-label">
                        WELCOME TO ELEMENT
                    </div>

                    <h1>
                        Build Something
                        <span>Amazing</span>
                        With Laravel.
                    </h1>

                    <p>
                        Welcome to Element, a modern web experience
                        built with Laravel. Explore our website,
                        discover useful resources, and learn how
                        powerful web applications are created with
                        clean design and simple technology.
                    </p>

                    <div class="hero-buttons">

                        <a href="{{ route('user_index') }}"
                           class="btn-primary-custom">
                            Explore Users →
                        </a>

                        <a href="https://laravel.com/docs"
                           target="_blank"
                           rel="noopener noreferrer"
                           class="btn-outline-custom">
                            Laravel Documentation
                        </a>

                    </div>

                </div>

                
<!-- Right Illustration -->
<div class="hero-illustration">

    <!-- Window Header -->
    <div class="illustration-header">
        <div class="window-dots">
            <span class="dot red"></span>
            <span class="dot yellow"></span>
            <span class="dot green"></span>
        </div>

        <span class="ms-auto small text-muted">
            element.blade.php
        </span>
    </div>

    <!-- Editor Title -->
    <div class="illustration-title">
        <span class="title-icon">✦ </span>
        Element Development
        <span class="live-status">LIVE</span>
    </div>

    <!-- Code Editor -->
    <div class="code-editor">

        <div class="code-row line-1">
            <span class="line-number">01</span>
            <span class="code-purple">Route::get</span>
            <span class="code-text">('/home', function () {</span>
        </div>

        <div class="code-row line-2">
            <span class="line-number">02</span>
            <span class="code-indent"></span>
            <span class="code-purple">return</span>
            <span class="code-text"> view('welcome');</span>
        </div>

        <div class="code-row line-3">
            <span class="line-number">03</span>
            <span class="code-text">});</span>
        </div>

        <div class="code-row line-4">
            <span class="line-number">04</span>
            <span class="code-green">// Building something amazing...</span>
        </div>

        <div class="code-row line-5">
            <span class="line-number">05</span>
            <span class="code-yellow">Laravel</span>
            <span class="code-text">::ready();</span>
        </div>

    </div>

    <!-- Terminal -->
    <div class="terminal-box">

        <div class="terminal-heading">
            <span>TERMINAL</span>
            <span class="terminal-indicator">● Running</span>
        </div>

        <div class="terminal-command">
            <span class="terminal-prompt">$</span>
            php artisan serve
        </div>

        <div class="terminal-output">
            <span class="terminal-check">✓</span>
            Laravel development server ready
        </div>

    </div>

    

    <!-- Final Result -->
    <div class="illustration-bottom">
        <div>
            <span class="success-check">✓</span>
            <strong>Powered by Laravel</strong>
        </div>

        <span class="ready-label">Project Ready</span>
    </div>

</div>


            </div>

        </section>

        <!-- Features Section -->
        <section class="features-section">

            <div class="section-container">

                <div class="section-heading">

                    <span>WHAT WE OFFER</span>

                    <h2>Everything Starts With a Great Idea</h2>

                    <p>
                        Discover the features and resources that make
                        building web applications easier.
                    </p>

                </div>

                <div class="features-grid">

                    <!-- Feature 1 -->
                    <div class="feature-card">

                        <div class="feature-icon">⚡</div>

                        <h3>Powerful Performance</h3>

                        <p>
                            Laravel provides an expressive and efficient
                            foundation for developing modern web
                            applications with clean and maintainable code.
                        </p>

                    </div>

                    <!-- Feature 2 -->
                    <div class="feature-card">

                        <div class="feature-icon">🎨</div>

                        <h3>Modern Design</h3>

                        <p>
                            Create attractive and responsive interfaces
                            with reusable components, Bootstrap utilities,
                            and custom styling.
                        </p>

                    </div>

                    <!-- Feature 3 -->
                    <div class="feature-card">

                        <div class="feature-icon">🔒</div>

                        <h3>Secure Development</h3>

                        <p>
                            Build applications with Laravel's helpful
                            security features, validation tools, and
                            structured development practices.
                        </p>

                    </div>

                </div>

            </div>

        </section>

        <!-- Call To Action -->
        <section class="cta-section">

            <h2>Ready to Explore Element?</h2>

            <p>
                Learn more about our website and discover what
                makes this project special.
            </p>

            <a href="{{ route('react-demo') }}"
               class="btn-primary-custom">
                Demo React →
            </a>

        </section>

    </main>

    <x-footer/>
</body>
</html>

