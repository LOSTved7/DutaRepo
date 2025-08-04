<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Update Credentials</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- ✅ SweetAlert2 CDN -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        body {
            background: linear-gradient(to right, #83a4d4, #b6fbff);
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            padding: 0;
        }

        header {
            background-color: #2c3e50;
            color: white;
            padding: 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
            box-shadow: 0 2px 6px rgba(0,0,0,0.2);
        }

        .container {
            max-width: 480px;
            margin: 50px auto;
            background: white;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-group label {
            display: block;
            font-weight: 600;
            margin-bottom: 6px;
        }

        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 15px;
        }

        .btn-submit {
            width: 100%;
            background-color: #2980b9;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
            margin-top: 10px;
        }

        .btn-submit:hover {
            background-color: #2471a3;
        }

        .error-msg {
            color: red;
            font-size: 14px;
            margin-top: 4px;
        }

        .success-msg {
            color: green;
            text-align: center;
            margin-bottom: 10px;
            font-weight: 600;
        }
    </style>
</head>
<body>
    <header>Secure Update Panel</header>

    <div class="container">
        <h2>Update Username & Password</h2>

        @if (session('success'))
            <p class="success-msg">{{ session('success') }}</p>
        @endif

        <form method="POST" action="{{url('updateCredentials')}}" id="updateForm">
            @csrf

            <!-- Username -->
            <input type="hidden" name="users_id" value="{{Auth::user()->id}}">
            <div class="form-group">
                <label for="username">Current Username</label>
                <input type="text" name="current_username" id="current_username" value="{{ Auth::user()->email }}" readonly>
            </div>
            <div class="form-group">
                <label for="username">New Username(Optional)</label>
                <input type="text" name="username" id="username" value="{{ old('username', auth()->user()->username ?? '') }}">
            </div>
            <!-- Current password -->
            <div class="form-group">
                <label for="current_password">Current Password</label>
                <input type="password" name="current_password" id="current_password" required>
                @if (session('error'))
                    <p class="error-msg">{{ session('error') }}</p>
                @endif
            </div>

            <!-- New password -->
            <div class="form-group">
                <label for="new_password">New Password</label>
                <input type="password" name="new_password" id="new_password" required>
                <p class="error-msg" id="passwordError" style="display: none;">New password must be different from current password</p>
                <p class="error-msg" id="strongError" style="display: none;">
                    Password must be at least 8 characters and contain uppercase, lowercase, number, and special character
                </p>
            </div>

            <!-- Confirm -->
            <div class="form-group">
                <label for="confirm_password">Confirm New Password</label>
                <input type="password" name="confirm_password" id="confirm_password" required>
                <p class="error-msg" id="confirmError" style="display: none;">Passwords do not match</p>
            </div>

            <button type="submit" class="btn-submit">Update</button>
        </form>

        <script>
             window.onload = function () {
        Swal.fire({
            title: 'Password Verified 🎉',
            text: 'Kindly update your login credentials.',
            icon: 'success',
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        });
    };
            document.getElementById('updateForm').addEventListener('submit', function(e) {
                const current = document.getElementById('current_password').value;
                const newPass = document.getElementById('new_password').value;
                const confirm = document.getElementById('confirm_password').value;

                let valid = true;

                // Reset all errors
                document.getElementById('passwordError').style.display = 'none';
                document.getElementById('confirmError').style.display = 'none';
                document.getElementById('strongError').style.display = 'none';

                const strongRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_]).{8,}$/;

                // Current vs New same?
                if (current === newPass) {
                    document.getElementById('passwordError').style.display = 'block';
                    valid = false;
                }

                // Strong password?
                if (!strongRegex.test(newPass)) {
                    document.getElementById('strongError').style.display = 'block';
                    valid = false;
                }

                // New vs Confirm mismatch?
                if (newPass !== confirm) {
                    document.getElementById('confirmError').style.display = 'block';
                    valid = false;
                }

                if (!valid) e.preventDefault();
            });
        </script>
</body>
</html>
