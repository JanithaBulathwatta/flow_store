<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Security Settings</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=JetBrains+Mono:wght@400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<style>
/* Your existing CSS styles here - keep them as they are */
:root{
  --primary:#3d52a0;--primary-d:#2d3d80;--primary-light:#eef1fb;--primary-mid:#c5cff7;
  --success:#10b981;--success-light:#d1fae5;--success-d:#059669;
  --danger:#ef4444;--danger-light:#fee2e2;
  --warning:#f59e0b;--warning-light:#fef3c7;
  --sidebar-bg:#1a1f36;--sidebar-text:#a8b4d8;
  --page-bg:#f2f4fa;--card-border:#e4e9f4;
  --text-dark:#1a1f36;--text-mid:#4a5568;--text-muted:#8a94a6;
  --input-border:#d1d9e6;--table-head:#f7f9ff;
  --sh-sm:0 1px 4px rgba(61,82,160,.07);--sh-md:0 4px 18px rgba(61,82,160,.10);
  --r-sm:8px;--r-md:12px;--r-lg:16px;
  --sidebar-w:240px;--header-h:60px;--tr:.2s cubic-bezier(.4,0,.2,1);
}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0;}
body{font-family:'Plus Jakarta Sans',sans-serif;background:var(--page-bg);color:var(--text-dark);font-size:14px;}
.main{margin-left:var(--sidebar-w);margin-top:var(--header-h);padding:24px 28px;max-width:680px;}
.pg-title{margin-bottom:22px;}
.pg-title h1{font-size:20px;font-weight:800;letter-spacing:-.3px;}
.pg-title p{font-size:13px;color:var(--text-muted);margin-top:3px;}
.sec-card{background:#fff;border:1px solid var(--card-border);border-radius:var(--r-lg);box-shadow:var(--sh-sm);margin-bottom:14px;overflow:hidden;}
.sc-header{display:flex;align-items:center;padding:16px 20px;gap:14px;}
.sc-icon{width:38px;height:38px;border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;}
.sc-info{flex:1;}
.sc-info h5{font-size:14px;font-weight:700;color:var(--text-dark);margin:0;}
.sc-info p{font-size:12px;color:var(--text-muted);margin-top:2px;}
.sc-status{display:flex;align-items:center;gap:8px;flex-shrink:0;}
.status-pill{display:inline-flex;align-items:center;gap:5px;padding:4px 11px;border-radius:20px;font-size:11px;font-weight:700;}
.sp-ok{background:var(--success-light);color:#065f46;}
.sp-warn{background:var(--warning-light);color:#92400e;}
.sp-off{background:#f1f5f9;color:#64748b;}
.sc-body{padding:0 20px;max-height:0;overflow:hidden;transition:max-height .35s cubic-bezier(.4,0,.2,1),padding .35s ease;}
.sc-body.open{max-height:600px;padding:0 20px 20px;}
.sc-divider{height:1px;background:var(--card-border);margin-bottom:16px;}
.form-row{margin-bottom:14px;}
.form-lbl{font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.4px;color:var(--text-mid);display:block;margin-bottom:5px;}
.fc{width:100%;padding:9px 12px;border:1.5px solid var(--input-border);border-radius:var(--r-sm);font-family:inherit;font-size:13px;color:var(--text-dark);outline:none;background:#fff;}
.fc:focus{border-color:var(--primary);box-shadow:0 0 0 3px rgba(61,82,160,.09);}
.btn{padding:9px 16px;border-radius:var(--r-sm);font-family:inherit;font-size:13px;font-weight:700;cursor:pointer;border:none;display:inline-flex;align-items:center;gap:6px;}
.btn-primary{background:var(--primary);color:#fff;}
.btn-primary:hover{background:var(--primary-d);}
.btn-outline{background:#fff;color:var(--text-mid);border:1.5px solid var(--card-border);}
.btn-outline:hover{border-color:var(--primary);color:var(--primary);}
.btn-sm{padding:7px 13px;font-size:12px;}
.btn-xs{padding:5px 10px;font-size:11px;border-radius:6px;}
.btn-danger-o{background:#fff;color:var(--danger);border:1.5px solid var(--danger-light);}
.btn-danger-o:hover{background:var(--danger);color:#fff;}
.tog{position:relative;display:inline-block;width:42px;height:22px;flex-shrink:0;}
.tog input{opacity:0;width:0;height:0;position:absolute;}
.tog-s{position:absolute;cursor:pointer;inset:0;border-radius:22px;background:#e2e8f0;transition:background .2s;border:1.5px solid #d1d9e6;}
.tog-s::before{content:'';position:absolute;width:16px;height:16px;left:2px;top:1px;border-radius:50%;background:#fff;transition:transform .2s;box-shadow:0 1px 3px rgba(0,0,0,.15);}
.tog input:checked + .tog-s{background:var(--success);border-color:transparent;}
.tog input:checked + .tog-s::before{transform:translateX(20px);}
.otp-row{display:flex;gap:8px;margin:14px 0 6px;}
.otp-box{width:44px;height:50px;border:2px solid var(--input-border);border-radius:var(--r-sm);font-family:'JetBrains Mono',monospace;font-size:20px;font-weight:700;text-align:center;outline:none;}
.otp-box:focus{border-color:var(--primary);}
.device-list{display:flex;flex-direction:column;gap:10px;}
.device-row{display:flex;align-items:center;gap:14px;padding:12px 14px;border:1px solid var(--card-border);border-radius:var(--r-md);}
.device-row.current-device{border-color:var(--primary-mid);background:var(--primary-light);}
.dv-icon{width:36px;height:36px;border-radius:var(--r-sm);display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0;}
.dv-info{flex:1;}
.dv-name{font-size:13px;font-weight:700;color:var(--text-dark);display:flex;align-items:center;gap:6px;}
.dv-current{font-size:10px;font-weight:800;background:var(--primary);color:#fff;padding:1px 6px;border-radius:20px;}
.dv-meta{font-size:11px;color:var(--text-muted);margin-top:2px;display:flex;gap:10px;flex-wrap:wrap;}
.inline-msg{font-size:12px;font-weight:600;display:flex;align-items:center;gap:5px;margin-top:8px;}
.inline-msg.err{color:var(--danger);}
.inline-msg.ok{color:var(--success);}
#toast-c{position:fixed;top:68px;right:22px;z-index:9999;display:flex;flex-direction:column;gap:7px;}
.t-item{padding:10px 16px;border-radius:var(--r-sm);font-size:12px;font-weight:700;display:flex;align-items:center;gap:7px;box-shadow:0 4px 16px rgba(0,0,0,.18);max-width:300px;}
.t-s{background:var(--success);color:#fff;}.t-e{background:var(--danger);color:#fff;}.t-i{background:var(--primary);color:#fff;}.t-w{background:var(--warning);color:#fff;}
.alert-info{background:#eef1fb;border-left:4px solid #3d52a0;padding:15px;margin-bottom:20px;border-radius:8px;}
.pw-wrap{position:relative;}
.pw-wrap input{padding-right:38px;}
.pw-eye{position:absolute;right:10px;top:50%;transform:translateY(-50%);background:none;border:none;cursor:pointer;color:var(--text-muted);}
.otp-step{display:none;}
.otp-step.active{display:block;}
</style>
</head>
<body>
<main class="main">

  <div class="pg-title">
    <h1><i class="fa-solid fa-shield-halved" style="font-size:17px;margin-right:8px;color:var(--primary);"></i>Security Settings</h1>
    <p>Manage your password, verification, and active sessions.</p>
  </div>

  <?php if(isset($is_first_login) && $is_first_login): ?>
  <div class="alert-info">
    <i class="fa-solid fa-shield-halved"></i> 
    <strong>Welcome! Let's secure your account</strong><br>
    Please take a moment to set up these security features. 
    <a href="#" onclick="skipSetup()" style="color:#3d52a0; margin-left:10px;">Skip for now</a>
  </div>
  <?php endif; ?>

  <!-- Card 1: Change Password -->
  <div class="sec-card">
    <div class="sc-header">
      <div class="sc-icon" style="background:var(--primary-light);color:var(--primary);"><i class="fa-solid fa-lock"></i></div>
      <div class="sc-info">
        <h5>Change Password</h5>
        <p>Update your login password. Minimum 6 characters.</p>
      </div>
      <div class="sc-status">
        <button class="btn btn-outline btn-sm" onclick="toggleCard('pw-body',this)"><i class="fa-solid fa-pen"></i>Change</button>
      </div>
    </div>
    <div class="sc-body" id="pw-body">
      <div class="sc-divider"></div>
      <div class="form-row">
        <label class="form-lbl">Current Password</label>
        <div class="pw-wrap">
          <input type="password" class="fc" id="pw-current" placeholder="Enter current password">
          <button class="pw-eye" onclick="togglePw('pw-current',this)"><i class="fa-solid fa-eye"></i></button>
        </div>
      </div>
      <div class="form-row">
        <label class="form-lbl">New Password</label>
        <div class="pw-wrap">
          <input type="password" class="fc" id="pw-new" placeholder="Enter new password">
          <button class="pw-eye" onclick="togglePw('pw-new',this)"><i class="fa-solid fa-eye"></i></button>
        </div>
      </div>
      <div class="form-row">
        <label class="form-lbl">Confirm New Password</label>
        <div class="pw-wrap">
          <input type="password" class="fc" id="pw-confirm" placeholder="Repeat new password">
          <button class="pw-eye" onclick="togglePw('pw-confirm',this)"><i class="fa-solid fa-eye"></i></button>
        </div>
      </div>
      <div style="display:flex;gap:8px;">
        <button class="btn btn-primary btn-sm" onclick="savePassword()"><i class="fa-solid fa-floppy-disk"></i>Save Password</button>
        <button class="btn btn-outline btn-sm" onclick="closeCard('pw-body')">Cancel</button>
      </div>
    </div>
  </div>

  <!-- Card 2: Two-Factor Authentication -->
  <div class="sec-card">
    <div class="sc-header">
      <div class="sc-icon" style="background:#ede9fe;color:#8b5cf6;"><i class="fa-solid fa-mobile-screen"></i></div>
      <div class="sc-info">
        <h5>Two-Factor Authentication</h5>
        <p>Require a verification code on every login.</p>
      </div>
      <div class="sc-status">
        <span class="status-pill sp-off" id="tfa-pill">Disabled</span>
        <label class="tog" style="margin-left:8px;">
          <input type="checkbox" id="tfa-tog" onchange="toggleTFA(this)">
          <span class="tog-s"></span>
        </label>
      </div>
    </div>
  </div>

  <!-- Card 3: Phone Verification -->
  <div class="sec-card">
    <div class="sc-header">
      <div class="sc-icon" style="background:#ccfbf1;color:#14b8a6;"><i class="fa-solid fa-phone"></i></div>
      <div class="sc-info">
        <h5>Phone Number Verification</h5>
        <p id="phone-status-txt">Verify your phone number via OTP.</p>
      </div>
      <div class="sc-status" id="phone-status-area">
        <span class="status-pill sp-warn" id="phone-pill">Not Verified</span>
        <button class="btn btn-outline btn-sm" id="phone-verify-btn" onclick="startOtp()">Verify Now</button>
      </div>
    </div>
    <div class="sc-body" id="otp-body">
      <div class="sc-divider"></div>
      <div class="otp-step active" id="otp-step1">
        <div class="form-row">
          <label class="form-lbl">Mobile Number</label>
          <div style="display:flex;gap:8px;">
            <input type="tel" class="fc" id="otp-phone" placeholder="e.g. 0771234567" style="flex:1;">
            <button class="btn btn-primary btn-sm" onclick="sendOtp()"><i class="fa-solid fa-paper-plane"></i>Send OTP</button>
          </div>
        </div>
        <button class="btn btn-outline btn-sm" onclick="closeCard('otp-body');resetOtp();">Cancel</button>
      </div>
      <div class="otp-step" id="otp-step2">
        <p style="font-size:13px;">Enter the 6-digit code sent to <strong id="otp-phone-display"></strong></p>
        <div class="otp-row">
          <input type="text" class="otp-box" id="ob1" maxlength="1" oninput="otpInput(this,'ob2')" onkeydown="otpBack(event,this,null)">
          <input type="text" class="otp-box" id="ob2" maxlength="1" oninput="otpInput(this,'ob3')" onkeydown="otpBack(event,this,'ob1')">
          <input type="text" class="otp-box" id="ob3" maxlength="1" oninput="otpInput(this,'ob4')" onkeydown="otpBack(event,this,'ob2')">
          <input type="text" class="otp-box" id="ob4" maxlength="1" oninput="otpInput(this,'ob5')" onkeydown="otpBack(event,this,'ob3')">
          <input type="text" class="otp-box" id="ob5" maxlength="1" oninput="otpInput(this,'ob6')" onkeydown="otpBack(event,this,'ob4')">
          <input type="text" class="otp-box" id="ob6" maxlength="1" oninput="otpInput(this,null)" onkeydown="otpBack(event,this,'ob5')">
        </div>
        <div class="inline-msg err" id="otp-err" style="display:none;">Incorrect code. Please try again.</div>
        <div style="display:flex;gap:8px;margin-top:12px;">
          <button class="btn btn-primary btn-sm" onclick="verifyOtp()">Verify</button>
          <button class="btn btn-outline btn-sm" onclick="startOtp()">Resend</button>
          <button class="btn btn-outline btn-sm" onclick="closeCard('otp-body');resetOtp();">Cancel</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Card 4: Secret Question -->
  <div class="sec-card">
    <div class="sc-header">
      <div class="sc-icon" style="background:var(--warning-light);color:var(--warning);"><i class="fa-solid fa-key"></i></div>
      <div class="sc-info">
        <h5>Secret Question</h5>
        <p id="sq-status-txt">Used for account recovery verification.</p>
      </div>
      <div class="sc-status">
        <span class="status-pill sp-warn" id="sq-pill">Not Set</span>
        <button class="btn btn-outline btn-sm" id="sq-set-btn" onclick="openSQ()">Set Now</button>
      </div>
    </div>
    <div class="sc-body" id="sq-body">
      <div class="sc-divider"></div>
      <div class="form-row">
        <label class="form-lbl">Choose a Question</label>
        <select class="fc" id="sq-question">
		  <option value="">— Select a question —</option>
		  <option>What was the model of your first mobile phone?</option>
		  <option>What is the name of your favorite fictional character?</option>
		  <option>What was the first concert you ever attended?</option>
		  <option>What is the name of the street where you had your first kiss?</option>
		  <option>What was the brand of your first pair of sneakers?</option>
		  <option>What is the middle name of your childhood best friend?</option>
		  <option>What was your favorite cartoon as a child?</option>
		  <option>What was the registration number of your first vehicle?</option>
		  <option>What is the name of the first hotel you ever stayed at?</option>
		  <option>What was the first video game you ever completed?</option>
		  <option>What is the name of your favorite teacher from primary school?</option>
		  <option>What was the first thing you bought with your own money?</option>
		  <option>What is the name of the hospital where you were born?</option>
		  <option>What was your childhood nickname given by family?</option>
		  <option>What is the surname of your favorite author?</option>
		  <option>What was the first job you ever applied for?</option>
		  <option>What is the name of your childhood stuffed animal?</option>
		  <option>What was the make and model of your first computer?</option>
		  <option>What is the name of the first school you attended?</option>
		  <option>What was your favorite board game as a child?</option>
		  <option>What is the name of your first romantic partner?</option>
		  <option>What was the first movie you saw in a theater?</option>
		  <option>What is the name of the first friend you made online?</option>
		  <option>What was the worst gift you ever received?</option>
		  <option>What is the name of your favorite childhood restaurant?</option>
		  <option>What was the first book you read completely?</option>
		  <option>What is the name of the first sports team you played for?</option>
		  <option>What was the first major news event you remember?</option>
		  <option>What is the name of your first roommate?</option>
		  <option>What was the first album you ever bought?</option>
		  <option>What is the name of your favorite vacation spot as a child?</option>
		  <option>What was the first website you ever created?</option>
		  <option>What is the name of your most memorable teacher?</option>
		  <option>What was the first social media platform you joined?</option>
		  <option>What is the name of your first credit card?</option>
		  <option>What was the first app you installed on your smartphone?</option>
		  <option>What is the name of the first person you interviewed?</option>
		  <option>What was the first piece of art you created?</option>
		  <option>What is the name of your favorite childhood park?</option>
		  <option>What was the first code or script you ever wrote?</option>
		  <option>What is the name of the first company you started?</option>
		  <option>What was the first award you ever received?</option>
		  <option>What is the middle name of your godparent?</option>
		  <option>What was the first thing you cooked by yourself?</option>
		  <option>What is the name of your first mentor?</option>
		  <option>What was the first language you learned besides your native one?</option>
		  <option>What is the name of the street you lived on at age 8?</option>
		  <option>What was the first charity you donated to?</option>
		  <option>What is the name of your favorite scientist?</option>
		  <option>What was the first thing you saved up money to buy?</option>
		</select>
      </div>
      <div class="form-row">
        <label class="form-lbl">Your Answer</label>
        <input type="text" class="fc" id="sq-answer" placeholder="Type your answer">
      </div>
      <div style="display:flex;gap:8px;">
        <button class="btn btn-primary btn-sm" onclick="saveSQ()">Save</button>
        <button class="btn btn-outline btn-sm" onclick="closeCard('sq-body')">Cancel</button>
      </div>
    </div>
  </div>

  <!-- Card 5: Active Devices -->
  <div class="sec-card">
    <div class="sc-header">
      <div class="sc-icon" style="background:var(--danger-light);color:var(--danger);"><i class="fa-solid fa-laptop"></i></div>
      <div class="sc-info">
        <h5>Active Devices</h5>
        <p>All sessions currently logged in to your account.</p>
      </div>
      <div class="sc-status">
        <span class="status-pill sp-ok" id="devices-count-pill">0 Active</span>
      </div>
    </div>
    <div style="padding:0 20px 20px;">
      <div class="sc-divider" style="margin-bottom:14px;"></div>
      <div class="device-list" id="device-list">Loading...</div>
    </div>
  </div>

</main>
<div id="toast-c"></div>

<script>
// ============================================
// INITIAL DATA FROM PHP
// ============================================
var PAGE_DATA = <?php echo json_encode([
    'tfa_enabled' => $tfa_enabled ?? false,
    'phone_verified' => $phone_verified ?? false,
    'phone' => $phone ?? null,
    'sq_is_set' => $sq_is_set ?? false,
    'sq_question' => $sq_question ?? null,
    'is_first_login' => $is_first_login ?? false
]); ?>;

// ============================================
// INITIALIZE PAGE
// ============================================
$(document).ready(function() {
    // Apply initial state
    if (PAGE_DATA.tfa_enabled) {
        $('#tfa-tog').prop('checked', true);
        $('#tfa-pill').removeClass('sp-off').addClass('sp-ok').html('<i class="fa-solid fa-circle-check"></i> Enabled');
    }
    
    if (PAGE_DATA.phone_verified) {
        $('#phone-pill').removeClass('sp-warn').addClass('sp-ok').html('<i class="fa-solid fa-circle-check"></i> Verified');
        $('#phone-verify-btn').hide();
        $('#phone-status-txt').text('Phone number verified.');
    }
    
    if (PAGE_DATA.sq_is_set) {
        $('#sq-pill').removeClass('sp-warn').addClass('sp-ok').html('<i class="fa-solid fa-circle-check"></i> Configured');
        $('#sq-set-btn').text('Change');
        $('#sq-status-txt').text('Security question is set.');
    }
    
    // Load active devices
    loadDevices();
});

// ============================================
// UI HELPER FUNCTIONS
// ============================================
function toggleCard(id, btn) {
    var $b = $('#' + id);
    if ($b.hasClass('open')) {
        closeCard(id);
    } else {
        $b.addClass('open');
        if (btn) $(btn).html('<i class="fa-solid fa-times"></i>Close');
    }
}

function closeCard(id) {
    $('#' + id).removeClass('open');
    if (id === 'pw-body') $('[onclick*="pw-body"]').html('<i class="fa-solid fa-pen"></i>Change');
}

function togglePw(id, btn) {
    var inp = $('#' + id);
    var showing = inp.attr('type') === 'text';
    inp.attr('type', showing ? 'password' : 'text');
    $(btn).find('i').attr('class', 'fa-solid ' + (showing ? 'fa-eye' : 'fa-eye-slash'));
}

// ============================================
// PASSWORD FUNCTIONS
// ============================================
function savePassword() {
    var cur = $('#pw-current').val().trim();
    var nw = $('#pw-new').val();
    var cn = $('#pw-confirm').val();
    
    if (!cur) { toast('Enter your current password.', 'w'); return; }
    if (nw.length < 6) { toast('Password must be at least 6 characters.', 'w'); return; }
    if (nw !== cn) { toast('Passwords do not match.', 'w'); return; }
    
    $.post('/security_settings/change_password', {
        current_password: cur,
        new_password: nw
    }, function(res) {
        if (res.success) {
            closeCard('pw-body');
            $('#pw-current, #pw-new, #pw-confirm').val('');
            toast(res.message, 's');
            checkAllSetupComplete();
        } else {
            toast(res.message, 'e');
        }
    }, 'json');
}

// ============================================
// TWO-FACTOR AUTHENTICATION
// ============================================
function toggleTFA(el) {
    var enabled = el.checked;
    $.post('/security_settings/set_tfa', {enabled: enabled ? 1 : 0}, function(res) {
        if (res.success) {
            var pill = $('#tfa-pill');
            if (enabled) {
                pill.removeClass('sp-off').addClass('sp-ok').html('<i class="fa-solid fa-circle-check"></i> Enabled');
                toast(res.message, 's');
            } else {
                pill.removeClass('sp-ok').addClass('sp-off').text('Disabled');
                toast(res.message, 'w');
            }
            checkAllSetupComplete();
        } else {
            toast(res.message, 'e');
            el.checked = !enabled;
        }
    }, 'json');
}

// ============================================
// OTP / PHONE VERIFICATION
// ============================================
function startOtp() {
    resetOtp();
    $('#otp-body').addClass('open');
}

function sendOtp() {
    var ph = $('#otp-phone').val().trim();
    if (ph.length < 10) {
        toast('Enter a valid phone number', 'w');
        return;
    }
    
    $.post('/security_settings/send_otp', {phone: ph}, function(res) {
        if (res.success) {
            $('#otp-phone-display').text(ph);
            $('#otp-step1').removeClass('active');
            $('#otp-step2').addClass('active');
            toast(res.message, 's');
        } else {
            toast(res.message, 'e');
        }
    }, 'json');
}

function otpInput(el, nextId) {
    el.value = el.value.replace(/\D/g, '').slice(-1);
    if (el.value && nextId) $('#' + nextId).focus();
    var all = ['ob1','ob2','ob3','ob4','ob5','ob6'].map(function(id) {
        return $('#' + id).val();
    }).join('');
    if (all.length === 6) verifyOtp();
}

function otpBack(e, el, prevId) {
    if (e.key === 'Backspace' && !el.value && prevId) {
        $('#' + prevId).focus();
    }
}

function verifyOtp() {
    var code = ['ob1','ob2','ob3','ob4','ob5','ob6'].map(function(id) {
        return $('#' + id).val();
    }).join('');
    
    if (code.length < 6) return;
    
    var phone = $('#otp-phone').val().trim();
    
    $.post('/security_settings/verify_otp', {phone: phone, otp: code}, function(res) {
        if (res.success) {
            $('#otp-err').hide();
            toast(res.message, 's');
            setTimeout(function() {
                closeCard('otp-body');
                resetOtp();
                $('#phone-pill').removeClass('sp-warn').addClass('sp-ok').html('<i class="fa-solid fa-circle-check"></i> Verified');
                $('#phone-verify-btn').hide();
                $('#phone-status-txt').text('Phone number verified.');
                checkAllSetupComplete();
            }, 1000);
        } else {
            $('#otp-err').show();
            setTimeout(function() {
                $('#otp-err').hide();
                $('.otp-box').val('').focus();
            }, 2000);
        }
    }, 'json');
}

function resetOtp() {
    $('.otp-box').val('');
    $('#otp-phone').val('');
    $('#otp-step1').addClass('active');
    $('#otp-step2').removeClass('active');
    $('#otp-err').hide();
}

// ============================================
// SECRET QUESTION
// ============================================
function openSQ() {
    $('#sq-body').addClass('open');
}

function saveSQ() {
    var q = $('#sq-question').val();
    var a = $('#sq-answer').val().trim();
    
    if (!q) { toast('Please select a question', 'w'); return; }
    if (!a) { toast('Please enter an answer', 'w'); return; }
    
    $.post('/security_settings/set_secret_question', {question: q, answer: a}, function(res) {
        if (res.success) {
            closeCard('sq-body');
            $('#sq-pill').removeClass('sp-warn').addClass('sp-ok').html('<i class="fa-solid fa-circle-check"></i> Configured');
            $('#sq-set-btn').text('Change');
            $('#sq-status-txt').text('Security question is set.');
            toast(res.message, 's');
            checkAllSetupComplete();
        } else {
            toast(res.message, 'e');
        }
    }, 'json');
}

// ============================================
// ACTIVE DEVICES
// ============================================
function loadDevices() {
    $.get('/security_settings/get_sessions', function(res) {
        if (res.success && res.sessions) {
            var sessions = res.sessions;
            $('#devices-count-pill').text(sessions.length + ' Active');
            
            if (sessions.length === 0) {
                $('#device-list').html('<p style="color:var(--text-muted);">No active sessions found.</p>');
                return;
            }
            
            var html = '';
            $.each(sessions, function(i, d) {
                html += '<div class="device-row' + (d.is_current ? ' current-device' : '') + '">';
                html += '<div class="dv-icon" style="background:var(--primary-light);color:var(--primary);"><i class="fa-solid ' + d.device_icon + '"></i></div>';
                html += '<div class="dv-info">';
                html += '<div class="dv-name">' + d.device_name + (d.is_current ? '<span class="dv-current">This device</span>' : '') + '</div>';
                html += '<div class="dv-meta">';
                html += '<span><i class="fa-solid fa-globe"></i>' + d.ip_address + '</span>';
                html += '<span><i class="fa-regular fa-clock"></i>' + d.last_active + '</span>';
                html += '</div></div>';
                if (!d.is_current) {
                    html += '<button class="btn btn-danger-o btn-xs" onclick="revokeSession(\'' + d.session_token + '\')"><i class="fa-solid fa-trash"></i>Remove</button>';
                }
                html += '</div>';
            });
            $('#device-list').html(html);
        } else {
            $('#device-list').html('<p style="color:var(--text-muted);">Unable to load sessions.</p>');
        }
    }, 'json');
}

function revokeSession(sessionToken) {
    if (!confirm('Remove this device? It will be logged out immediately.')) return;
    
    $.post('/security_settings/revoke_session', {session_id: sessionToken}, function(res) {
        if (res.success) {
            toast(res.message, 's');
            loadDevices(); // Reload the list
        } else {
            toast(res.message, 'e');
        }
    }, 'json');
}

// ============================================
// FIRST LOGIN SETUP
// ============================================
function checkAllSetupComplete() {
    // Check if this is first login and user completed all security features
    if (PAGE_DATA.is_first_login) {
        var tfaDone = $('#tfa-tog').is(':checked');
        var phoneDone = PAGE_DATA.phone_verified || $('#phone-pill').hasClass('sp-ok');
        var sqDone = PAGE_DATA.sq_is_set || $('#sq-pill').hasClass('sp-ok');
        
        if (tfaDone && phoneDone && sqDone) {
            // All security features are set, complete setup
            $.post('/security_settings/complete_setup', function(res) {
                if (res.success) {
                    toast('Security setup complete! Redirecting...', 's');
                    setTimeout(function() {
                        window.location.href = '/Dash';
                    }, 1500);
                }
            });
        }
    }
}

function skipSetup() {
    if (confirm('Are you sure you want to skip? You can set up security features later.')) {
        $.post('/security_settings/skip_setup', function(res) {
            if (res.success) {
                window.location.href = '/Dash';
            }
        });
    }
}

// ============================================
// TOAST NOTIFICATIONS
// ============================================
function toast(msg, type) {
    var icons = {s: 'fa-circle-check', w: 'fa-triangle-exclamation', e: 'fa-circle-xmark', i: 'fa-circle-info'};
    var classes = {s: 't-s', w: 't-w', e: 't-e', i: 't-i'};
    var $t = $('<div class="t-item ' + classes[type] + '"><i class="fa-solid ' + icons[type] + '"></i>' + msg + '</div>');
    $('#toast-c').append($t);
    setTimeout(function() {
        $t.css({opacity: 0, transform: 'translateX(14px)', transition: 'all .3s'});
        setTimeout(function() { $t.remove(); }, 300);
    }, 2800);
}
</script>
</body>
</html>