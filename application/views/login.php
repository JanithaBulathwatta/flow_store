<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invigo - Login</title>

<!-- Bootstrap & Icons -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Raleway:300,200,400,700" rel="stylesheet">
<link href="" rel="stylesheet">
	
	<style>
		/* Reset */
		body, html { margin:0; padding:0; height:100%; font-family: 'Raleway', sans-serif; }

		/* Split screen container */
		.split-container { display: flex; height: 100vh; }

		/* Left-half with white frame */
		.left-half {
			flex: 1.4;
			background: #ffffff;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 8px;
		}

		.gradient-frame {
			width: 100%;
			height: 100%;
			  background: linear-gradient(
		  -45deg,
		  #000F1E,
		  #041F3A,
		  #253F55,
		  #2B5661,
		  #3E6672
		);
			background-size: 400% 400%;
			animation: gradientMove 5s ease infinite;
			border-radius: 20px;
			padding: 60px;
			display: flex;
			align-items: flex-end;
			justify-content: center;
			color: #fff;
		}

		@keyframes gradientMove {
		  0% {
				background-position: 0% 50%;
			}
			50% {
				background-position: 100% 50%;
			}
			100% {
				background-position: 0% 50%;
			}
		}

		.left-half .overlay {
			max-width: 400px;
		}
		.left-half .overlay h3 {
			font-size: 1.8rem;
			font-weight: 500;
			line-height: 1.4;
			margin-bottom: 15px;
		}
		.left-half .overlay p {
			font-size: 0.95rem;
			font-weight: 300;
			line-height: 1.6;
			opacity: 0.9;
		}

		/* Right-half */
		.right-half {
			flex: 0.8;
			display: flex;
			align-items: center;
			justify-content: center;
			background: #ffffff;
			padding: 20px;
		}

		/* Login card */
		.login-box {
			background: #fff;
			width: 100%;
			max-width: 380px;
			border-radius: 0;
			padding: 40px 30px;
			box-shadow: none;
			text-align: left;
		}

		/* Logo */
		.login-box img {
			width: 200px;
			margin-bottom: 25px;
		}

		/* Welcome heading */
		.login-box h2 {
			font-size: 2rem;
			font-weight: 600;
			color: #2d2d2d;
			margin-bottom: 40px;
			font-family: 'Raleway', sans-serif;
		}

		/* Form labels */
		.form-label { 
			font-weight: 400; 
			font-size: 0.8rem; 
			margin-bottom: 8px;
			color: #6b6b6b;
			text-align: left;
		}

		/* Inputs */
		.form-control {
			height: 48px;
			border-radius: 4px;
			padding: 12px 16px;
			font-size: 0.95rem;
			border: 1px solid #e8e8e8;
			background: #fafafa;
		}
		.form-control:focus { 
			border-color: #d0d0d0; 
			box-shadow: none;
			background: #ffffff;
		}

		/* Password toggle */
		.input-group .btn {
			border-radius: 0 4px 4px 0;
			border-left: none;
			background: transparent;
			border: 1px solid #e8e8e8;
			border-left: none;
		}

		.input-group .form-control {
			border-right: none;
		}

		.input-group:focus-within .btn {
			border-color: #d0d0d0;
		}

		.input-group:focus-within .form-control {
			border-color: #d0d0d0;
		}

		/* Buttons */
		.btn-primary {
			background-color: #2d2d2d !important;
			border-color: #2d2d2d !important;
			font-weight: 500;
			font-size: 0.95rem;
			border-radius: 4px;
			width: 100%;
			padding: 13px;
			transition: all 0.3s ease;
		}
		.btn-primary:hover { background-color: #1a1a1a !important; transform: none; }

		/* Links */
		.foget, .otp-login {
			font-size: 0.8rem;
			color: #6b6b6b;
			cursor: pointer;
			text-decoration: none;
		}

		.foget:hover, .otp-login a:hover {
			color: #2d2d2d;
		}

		/* Terms text */
		.terms-text {
			font-size: 0.75rem;
			color: #999;
			text-align: center;
			margin-bottom: 20px;
			line-height: 1.6;
		}

		.terms-text a {
			color: #2d2d2d;
			text-decoration: underline;
		}

		/* Footer text */
		.footer-text {
			font-size: 0.75rem;
			color: #999;
			text-align: center;
			margin-top: 30px;
		}

		/* Alerts */
		.alert { font-size: 0.9rem; text-align: left; margin-bottom: 20px; }

		/* Responsive */
		@media(max-width: 991px) {
			.split-container { flex-direction: column; }
			.left-half { display: none; }
		}
		
		.text-center{
			text-align:center;
		}
		
		#loginMsg{
			font-weight: 500 !important; 
			font-size: 14px !important;
		}
		</style>
		</head>
		<body>

		<div class="split-container">

			<!-- Left side -->
			<div class="left-half">
				<div class="gradient-frame">
					<div class="overlay">
						<h3>Stay focused, stay determined, and stay moving.</h3>
						<p>Every step forward is progress. Embrace the journey, trust the process, and let your dedication shape your success.</p>
					</div>
				</div>
			</div>

			<!-- Right side -->
			<div class="right-half">
				<div class="login-box">
					<img src="/uploads/invigo-logo.png" alt="Logo">

					<h2>Hi... Welcome Back</h2>

					<!-- Flash Messages -->
					<!--<?php if ($this->session->flashdata('error')): ?>
					<div class="alert alert-danger alert-dismissible fade show" role="alert">
						<i class="ri-error-warning-line me-2"></i>
						<?php echo $this->session->flashdata('error'); ?>
						<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
					</div>
					<?php endif; ?>
					<?php if ($this->session->flashdata('success')): ?>
					<div class="alert alert-success alert-dismissible fade show" role="alert">
						<i class="ri-check-line me-2"></i>
						<?php echo $this->session->flashdata('success'); ?>
						<button type="button" class="btn-close" data-bs-dismiss="alert"></button>
					</div>
					<?php endif; ?>-->

					<!-- Login Form -->
					<form method="POST" id="loginForm">
						<div class="form-group">
							<label class="form-label" for="signin-email">Email</label>
							<input type="email" class="form-control" name="un" id="un" placeholder="" required>
						</div>

						<div class="form-group">
							<label class="form-label" for="signin-password">Password</label>
							<div class="input-group">
								<input type="password" class="form-control" name="pw" id="pw" placeholder="" required>
								<button type="button" class="btn" onclick="togglePassword('signin-password', this)">
									<i class="ri-eye-off-line"></i>
								</button>
							</div>
						</div>

						<div class="form-group" style="text-align: left;">
							<a href="/Login/forgot_password" class="foget">Forgot password?</a>
							<span style="float: right;"><a href="/Login/change_password" class="foget">Change Password</a></span>
						</div>

						<div class="terms-text">
							By signing up, I confirm that I have read and agree to LumeLink's<br>
							<a href="#">Privacy Policy and Terms of Service.</a>
						</div>
						<div class="text-center" id="loginMsg"></div>
						<button type="submit" class="btn btn-primary">Sign in</button>
					</form>

					<p class="footer-text">
						Powered by introps ©
					</p>

				</div>
			</div>
		</div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.6.0/js/bootstrap.bundle.min.js"></script>
	<script>
		const loginForm = document.getElementById('loginForm');
		loginForm.addEventListener('submit', (e) => {
			e.preventDefault();

			const formData = new FormData();
			const un = document.getElementById('un').value;
			const pw = document.getElementById('pw').value;
			const loginMsg = document.getElementById('loginMsg');

			formData.append('un', un);
			formData.append('pw', pw);

			fetch('/Login/login_user', {
				method : 'POST',
				body: formData
			})
			.then((res) => res.json())
			.then((re) => {
				// add new IF statment to show worning massage (21/4/2026)-> santhosh
				if(re == 'blocked'){
					loginMsg.style.color = '#e83200';
					loginMsg.innerHTML = 'This device is blocked. Contact Admin.';
				}
				else if(re == 0){
					loginForm.reset();
					loginMsg.style.color = '#e83200'
					loginMsg.innerHTML = 'Invalid Username or Password !'
				}else{
					loginMsg.style.color = '#239600'
					loginMsg.innerHTML = 'Login Success !';
					window.location.href = '/Dash';
				}
			})
		})
		
		const toggleIcon = document.getElementById('togglePassword');
		toggleIcon.addEventListener('click', () => togglePasswordVisibility())

		function togglePasswordVisibility() {
		  const passwordInput = document.getElementById('pw');
		  
		  if (passwordInput.type === 'password') {
			passwordInput.type = 'text';
			toggleIcon.classList.remove('fa-eye');
			toggleIcon.classList.add('fa-eye-slash');
		  } else {
			passwordInput.type = 'password';
			toggleIcon.classList.remove('fa-eye-slash');
			toggleIcon.classList.add('fa-eye');
		  }
		}


	</script>

</body>
</html>


