<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Invigo - Forgot Password</title>

<!-- Fonts -->
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link href="" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

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

	.auth-card {
		max-width: 440px;
		width: 100%;
		background: #ffffff;
		border-radius: 20px;
		padding: 48px 40px;
	}	

	/* Logo */
	.logo {
		text-align: center;
		margin-bottom: 40px;
	}

	.logo img {
		width: 80px;
		height: auto;
	}

	h3 {
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

	/* Input styling */
	.form-group {
		margin-bottom: 24px;
	}

	.form-label {
		display: block;
		font-size: 0.875rem;
		font-weight: 500;
		color: #4a5568;
		margin-bottom: 8px;
	}

	.input {
		width: 100%;
		padding: 14px 16px;
		border-radius: 10px;
		border: 1.5px solid #e2e8f0;
		outline: none;
		font-size: 0.95rem;
		font-family: 'Inter', sans-serif;
		transition: all 0.2s ease;
		background: #f8fafc;
	}

	.input:focus {
		border-color: #2d2d2d;
		background: #ffffff;
		box-shadow: 0 0 0 3px rgba(45, 45, 45, 0.1);
	}

	.input::placeholder {
		color: #a0aec0;
	}

	/* Button styling */
	.btn {
		width: 100%;
		padding: 14px 20px;
		background: #2d2d2d;
		color: #ffffff;
		border-radius: 10px;
		border: none;
		font-weight: 500;
		font-size: 0.95rem;
		cursor: pointer;
		transition: all 0.3s ease;
	}

	.btn:hover {
		background: #1a1a1a;
		transform: translateY(-1px);
	}

	.btn:active {
		transform: translateY(0);
	}

	/* OTP Box */
	.otp-box {
		display: flex;
		gap: 12px;
		justify-content: center;
		margin: 32px 0;
	}

	.otp-box input {
		width: 52px;
		height: 60px;
		text-align: center;
		font-size: 1.5rem;
		font-weight: 600;
		border-radius: 12px;
		border: 1.5px solid #e2e8f0;
		outline: none;
		transition: all 0.2s ease;
		background: #f8fafc;
	}

	.otp-box input:focus {
		border-color: #2d2d2d;
		background: #ffffff;
		box-shadow: 0 0 0 3px rgba(45, 45, 45, 0.1);
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
	}

	.link:hover {
		color: #1a1a1a;
		text-decoration: underline;
	}

	.link-separator {
		color: #cbd5e0;
		margin: 0 8px;
	}

	/* Timer */
	#timer {
		text-align: center;
		font-size: 0.8rem;
		color: #718096;
		margin-top: 16px;
		min-height: 20px;
	}

	/* Fade animation */
	.fade {
		display: none;
		animation: fadeIn 0.4s ease;
	}

	@keyframes fadeIn {
		from {
			opacity: 0;
			transform: translateY(10px);
		}
		to {
			opacity: 1;
			transform: translateY(0);
		}
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
		.auth-card {
			padding: 32px 24px;
		}
		
		.otp-box input {
			width: 44px;
			height: 52px;
			font-size: 1.25rem;
		}
		
		h3 {
			font-size: 1.5rem;
		}
	}

	#err-message{
		text-align : center;
		color:#ec5b34;
		font-weight: 500;
		font-size: 12px;
	}
	
	#err-message2{
		text-align : center;
		color:#ec5b34;
		font-weight: 500;
		font-size: 12px;
	}
	
	#message{
		text-align : center;
		color:#239600;
		font-weight: 500;
		font-size: 12px;
	}
		
	#err-message_v_otp{
		text-align : center;
		color:#ec5b34;
		font-weight: 500;
		font-size: 12px;
	}

	#message_v_otp_me{
		text-align : center;
		color:#239600;
		font-weight: 500;
		font-size: 12px;
	}
	
	#scc-message_rs_otp{
		text-align : center;
		color:#239600;
		font-weight: 500;
		font-size: 12px; 
	}
</style>
</head>
<body>

<div class="auth-card">
    <!-- Logo -->
    <div class="logo">
        <img src="/uploads/invigo-logo.png" alt="Logo">
    </div>

    <!-- STEP 1: Phone Input -->
    <div id="step-phone">
        <h3>Forgot password?</h3>
        <p class="subtitle">No worries! Enter your phone number and we'll send you an OTP to reset your password.</p>

        <div class="form-group">
            <label class="form-label" for="phone">Phone Number</label>
            <input class="input" id="phone" type="tel" placeholder="Enter your phone number" autocomplete="tel">
        </div>

		<div id="err-message" style="display:none;">Please enter your phone number</div>
		<div id="err-message2" style="display:none;"></div>
		<div id="message" style="display:none;"></div>
        <button class="btn" id="sendOtpBtn" onclick="sendOtp()"><i class="ri-send-plane-2-line"></i> Send OTP </button>

        <div class="link-container">
            <span class="link" onclick="goToLogin()">
                <i class="ri-arrow-left-line"></i> Back to Login
            </span>
        </div>
    </div>

    <!-- STEP 2: OTP Verification -->
    <div id="step-otp" class="fade">
        <h3>Verify OTP</h3>
        <p class="subtitle" id="phoneText">Enter the 6-digit code sent to your phone</p>

        <div class="otp-box">
            <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric">
            <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric">
            <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric">
            <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric">
            <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric">
            <input type="text" maxlength="1" pattern="[0-9]" inputmode="numeric">
        </div>

        <div id="err-message_v_otp" style="display:none;">Please enter all 6 digits</div>
        <div id="scc-message_rs_otp" style="display:none;">OTP resent successfully!</div>
		<button class="btn" onclick="verifyOtp()"><i class="ri-shield-check-line"></i> Verify OTP</button>

        <div class="link-container">
            <span class="link" id="resend" onclick="resendOtp()">Resend OTP</span>
            <span class="link-separator">·</span>
            <span class="link" onclick="changeNumber()">Change number</span>
        </div>

        <p id="timer"></p>

        <div class="link-container" style="margin-top: 16px;">
            <span class="link" onclick="goToLogin()">
                <i class="ri-arrow-left-line"></i> Back to Login
            </span>
        </div>
    </div>

    <p class="footer-text">Powered by introps ©</p>
</div>

<script>
let countdown;

// Auto-focus next OTP input
document.querySelectorAll('.otp-box input').forEach((input, index, inputs) => {
    input.addEventListener('input', function(e) {
        if (this.value.length === 1 && index < inputs.length - 1) {
            inputs[index + 1].focus();
        }
    });
    
    input.addEventListener('keydown', function(e) {
        if (e.key === 'Backspace' && this.value === '' && index > 0) {
            inputs[index - 1].focus();
        }
    });
    
    // Only allow numbers
    input.addEventListener('keypress', function(e) {
        if (!/[0-9]/.test(e.key)) {
            e.preventDefault();
        }
    });
});

function sendOtp() {
		
    let phone = document.getElementById('phone').value;
    //$('#sendOtpBtn').prop('disabled',true);
	$('#err-message').hide();
	$('#err-message2').hide();
	$('#scc-message_rs_otp').hide();
	
    if (!phone) {
		$('#err-message').show();
		$('#err-message2').hide();
		$('#message').hide();
		$('#scc-message_rs_otp').hide();
        return;
    }

	$('#message').text('Sending Data...');
	$('#message').show();

    fetch("/Login/send_reset_otp", {
        method: "POST",
        headers: {"Content-Type":"application/x-www-form-urlencoded"},
        body: "phone=" + phone
    })
    .then(r => r.json())
    .then(r => {
        if (!r.success) {
			$('#err-message').hide();
			$('#err-message2').show();
			$('#message').hide();
			$('#scc-message_rs_otp').hide();
			$('#err-message2').text(r.message);
			$('#sendOtpBtn').prop('disabled',false);
            return;
        }

        document.getElementById('step-phone').style.display = 'none';
        document.getElementById('step-otp').style.display = 'block';

        // Mask phone number
        let maskedPhone = phone.replace(/.(?=.{3})/g, "*");
        document.getElementById('phoneText').innerText = "We've sent a 6-digit code to " + maskedPhone;

        // Focus first OTP input
        document.querySelector('.otp-box input').focus();

        startTimer();
    })
    .catch(err => {
        alert('An error occurred. Please try again.');
        console.error(err);
    });
}

function verifyOtp() {
    let otp = [...document.querySelectorAll('.otp-box input')]
        .map(i => i.value).join('');

    if (otp.length !== 6) {
        //alert('Please enter all 6 digits');
		$('#err-message_v_otp').show();
		$('#scc-message_rs_otp').hide();
        return;
    }

    fetch("/Login/verify_reset_otp_ajax", {
        method: "POST",
        headers: {"Content-Type":"application/x-www-form-urlencoded"},
        body: "otp=" + otp
    })
    .then(r => r.json())
    .then(r => {
        if (r.success) {
            location.href = "/Login/reset_password_otp";
        } else {
            alert(r.message);
            // Clear OTP inputs
            document.querySelectorAll('.otp-box input').forEach(input => input.value = '');
            document.querySelector('.otp-box input').focus();
        }
    })
    .catch(err => {
        alert('An error occurred. Please try again.');
        console.error(err);
    });
}

function resendOtp() {
    clearInterval(countdown);
    let phone = document.getElementById('phone').value;
    
    fetch("/Login/send_reset_otp", {
        method: "POST",
        headers: {"Content-Type":"application/x-www-form-urlencoded"},
        body: "phone=" + phone
    })
    .then(r => r.json())
    .then(r => {
        if (r.success) {
            //alert('OTP resent successfully!');
			$('#scc-message_rs_otp').show();
			$('#err-message_v_otp').hide();
            // Clear OTP inputs
            document.querySelectorAll('.otp-box input').forEach(input => input.value = '');
            document.querySelector('.otp-box input').focus();
            startTimer();
        } else {
            alert(r.message);
        }
    });
}

function changeNumber() {
    clearInterval(countdown);
    document.getElementById('step-otp').style.display = 'none';
    document.getElementById('step-phone').style.display = 'block';
    document.getElementById('phone').value = '';
    document.getElementById('phone').focus();
    // Clear OTP inputs
    document.querySelectorAll('.otp-box input').forEach(input => input.value = '');
}

function goToLogin() {
    window.location.href = "/Login";
}

function startTimer() {
    let time = 60;
    let el = document.getElementById('timer');
    let resend = document.getElementById('resend');

    resend.style.pointerEvents = 'none';
    resend.style.opacity = '0.4';

    countdown = setInterval(() => {
        time--;
        el.innerText = `Resend available in ${time}s`;

        if (time <= 0) {
            clearInterval(countdown);
            el.innerText = '';
            resend.style.pointerEvents = 'auto';
            resend.style.opacity = '1';
        }
    }, 1000);
}
</script>

</body>
</html>

