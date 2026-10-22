<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <style>
        body { font-family: Arial; background:#f5f5f5; }
        .login-box {
            width: 350px;
            margin: 100px auto;
            padding: 25px;
            background: #fff;
            border-radius: 6px;
        }
        input {
            width: 100%;
            padding: 10px;
            margin-bottom: 12px;
        }
        button {
            width: 100%;
            padding: 10px;
            background: #007bff;
            color: #fff;
            border: none;
        }
        .error { color: red; margin-bottom: 10px; }
    </style>
</head>
<body>

<div class="login-box">
    <h3>Login</h3>

    <?php if ($this->session->flashdata('error')): ?>
        <div class="error"><?= $this->session->flashdata('error'); ?></div>
    <?php endif; ?>

    <?= form_open('auth/login'); ?>

        <input type="email" name="email" placeholder="Email" required>

        <input type="password" name="password" placeholder="Password" required>

        <button type="submit">Login</button>

    <?= form_close(); ?>
</div>

</body>
</html>
