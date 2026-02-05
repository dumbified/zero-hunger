<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - Zero Hunger</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="image/png" href="/favicon.ico">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&display=swap">
    <link rel="stylesheet" href="/global.css">
</head>
<body>
    <div class="login-container">
        <!-- Left Panel: Branding -->
        <div class="login-left">
            <div class="brand-text">Zero Hunger</div>
        </div>

        <!-- Right Panel: Login Form -->
        <div class="login-right">
            <div class="login-form-container">
                <h1 class="form-heading">Welcome back!</h1>
                <p class="form-subheading">Login to continue</p>

                <?php if (session()->has('error')): ?>
                    <div class="alert alert-error">
                        <?= session()->get('error') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('success')): ?>
                    <div class="alert alert-success">
                        <?= session()->get('success') ?>
                    </div>
                <?php endif; ?>

                <?php if (session()->has('errors')): ?>
                    <div class="alert alert-error">
                        <ul style="list-style: disc; list-style-position: inside; margin: 0; padding: 0;">
                            <?php foreach (session()->get('errors') as $error): ?>
                                <li><?= $error ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                <?php endif; ?>

                <form action="<?= site_url('admin/login/authenticate') ?>" method="post">
                    <?= csrf_field() ?>
                    
                    <div class="input-group">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                        <input 
                            type="text" 
                            name="username" 
                            value="<?= old('username') ?>"
                            class="form-input"
                            placeholder="Username"
                            required
                            autofocus
                        >
                    </div>

                    <div class="input-group">
                        <svg class="input-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                        </svg>
                        <input 
                            type="password" 
                            name="password" 
                            class="form-input"
                            placeholder="Password"
                            required
                        >
                    </div>

                    <button type="submit" class="login-btn">
                        Login
                    </button>
                </form>

                <a href="<?= site_url('/') ?>" class="back-link">
                    ← Back to Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>
