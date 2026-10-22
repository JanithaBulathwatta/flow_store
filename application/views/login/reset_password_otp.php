<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invigo - Reset Password</title>

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="/assets/css/icons.css" rel="stylesheet">

<style>
/* Reset */
* { margin: 0; padding: 0; box-sizing: border-box; }

body {
    background: linear-gradient(135deg, #f0f4f8 0%, #e2e8f0 100%);
    font-family: 'Inter', -apple-system, BlinkMacSystemFont, sans-serif;
    min-height: 100vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 20px;
}

.container {
    max-width: 440px;
    width: 100%;
    margin: 0 auto;
}

.card {
    background: #ffffff;
    border-radius: 20px;
    padding: 48px 40px;
    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
    max-width: 400px;
    margin: 0 auto;
}

/* Logo */
.logo {
    text-align: center;
    margin-bottom: 32px;
}

.logo img {
    width: 80px;
    height: auto;
}

h5 {
    font-size: 1.75rem;
    font-weight: 600;
    color: #1a202c;
    margin-bottom: 8px;
    text-align: center;
}

.subtitle {
    color: #718096;
    font-size: 0.95rem;
    text-align: center;
    margin-bottom: 32px;
    line-height: 1.5;
}

/* Alert Messages */
.alert {
    padding: 14px 16px;
    border-radius: 10px;
    margin-bottom: 24px;
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 0.875rem;
    animation: slideDown 0.3s ease;
}

.alert-danger {
    background: #fef2f2;
    border: 1px solid #fecaca;
    color: #991b1b;
}

.alert-danger::before {
    content: "\eb98";
    font-family: 'remixicon';
    font-size: 1.25rem;
}

@keyframes slideDown {
    from {
        opacity: 0;
        transform: translateY(-10px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Form styling */
.form-control {
    width: 100%;
    padding: 14px 16px;
    border-radius: 10px;
    border: 1.5px solid #e2e8f0;
    outline: none;
    font-size: 0.95rem;
    font-family: 'Inter', sans-serif;
    transition: all 0.2s ease;
    background: #f8fafc;
    margin-bottom: 0;
}

.form-control:focus {
    border-color: #2d2d2d;
    background: #ffffff;
    box-shadow: 0 0 0 3px rgba(45, 45, 45, 0.1);
}

.form-control::placeholder {
    color: #a0aec0;
}

.mb-3 {
    margin-bottom: 20px;
}

/* Button styling */
.btn {
    width: 100%;
    padding: 14px 20px;
    border-radius: 10px;
    border: none;
    font-weight: 500;
    font-size: 0.95rem;
    cursor: pointer;
    transition: all 0.3s ease;
    font-family: 'Inter', sans-serif;
}

.btn-primary {
    background: #2d2d2d;
    color: #ffffff;
}

.btn-primary:hover {
    background: #1a1a1a;
    transform: translateY(-1px);
    box-shadow: 0 4px 12px rgba(45, 45, 45, 0.15);
}

.btn-primary:active {
    transform: translateY(0);
}

.w-100 {
    width: 100%;
}

/* Links */
.link-container {
    text-align: center;
    margin-top: 24px;
}

.link {
    color: #2d2d2d;
    cursor: pointer;
    font-size: 0.875rem;
    font-weight: 500;
    text-decoration: none;
    transition: color 0.2s ease;
    display: inline-flex;
    align-items: center;
    gap: 4px;
}

.link:hover {
    color: #1a1a1a;
    text-decoration: underline;
}

/* Footer text */
.footer-text {
    text-align: center;
    margin-top: 32px;
    font-size: 0.75rem;
    color: #a0aec0;
}

/* Responsive */
@media (max-width: 480px) {
    .card {
        padding: 32px 24px;
    }
    
    h5 {
        font-size: 1.5rem;
    }
}
</style>
</head>
<body>

<div class="container mt-5">
    <!-- Logo -->
    <div class="logo">
        <img src="/uploads/invigo-logo.png" alt="Logo">
    </div>

    <div class="card p-4 mx-auto" style="max-width:400px">
        <h5>Set New Password</h5>
        <p class="subtitle">Create a strong password to secure your account</p>

        <?php if ($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?= $this->session->flashdata('error') ?></div>
        <?php endif; ?>

        <form method="POST" action="/Login/reset_password_otp">
            <input type="password" name="password" class="form-control mb-3" placeholder="New password" required>
            <input type="password" name="confirm_password" class="form-control mb-3" placeholder="Confirm password" required>
            <button class="btn btn-primary w-100">Reset Password</button>
        </form>

        <div class="link-container">
            <a href="/Login/login" class="link">
                <i class="ri-arrow-left-line"></i>
                <span>Back to Login</span>
            </a>
        </div>
    </div>

    <p class="footer-text">Powered by inspace ©</p>
</div>

</body>
</html>