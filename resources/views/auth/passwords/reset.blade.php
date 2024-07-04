<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 100%;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            color: #333;
        }
        .form-group {
            margin-bottom: 15px;
            position: relative;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            color: #333;
        }
        .form-group input {
            width: 100%;
            padding: 10px;
            box-sizing: border-box;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        .form-group input.is-invalid {
            border-color: red;
        }
        .invalid-feedback {
            color: red;
            margin-top: 5px;
            font-size: 0.9em;
        }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            background-color: #007bff;
            color: #fff;
            text-align: center;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .btn:hover {
            background-color: #0056b3;
        }
        .toggle-password {
            position: absolute;
            right: 10px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Reset Password</h1>
        <form method="POST" action="{{ route('password.update') }}">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <input type="hidden" name="email" value="{{ $email }}">

            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" required>
                <span class="toggle-password" onclick="togglePassword('password')">&#128065;</span>
                <div class="invalid-feedback" id="passwordError"></div>
            </div>

            <div class="form-group">
                <label for="password-confirm">Confirm Password</label>
                <input id="password-confirm" type="password" name="password_confirmation" required>
                <span class="toggle-password" onclick="togglePassword('password-confirm')">&#128065;</span>
                <div class="invalid-feedback" id="confirmPasswordError"></div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn">Reset Password</button>
            </div>
        </form>
    </div>

    <script>
        function togglePassword(id) {
            var input = document.getElementById(id);
            if (input.type === "password") {
                input.type = "text";
            } else {
                input.type = "password";
            }
        }

        document.querySelector('form').addEventListener('submit', function (event) {
            event.preventDefault();

            var password = document.getElementById('password');
            var confirmPassword = document.getElementById('password-confirm');
            var passwordError = document.getElementById('passwordError');
            var confirmPasswordError = document.getElementById('confirmPasswordError');

            var isValid = true;

            if (!password.value) {
                password.classList.add('is-invalid');
                passwordError.textContent = 'Password is required.';
                isValid = false;
            } else {
                password.classList.remove('is-invalid');
                passwordError.textContent = '';
            }

            if (password.value !== confirmPassword.value) {
                confirmPassword.classList.add('is-invalid');
                confirmPasswordError.textContent = 'Passwords do not match.';
                isValid = false;
            } else {
                confirmPassword.classList.remove('is-invalid');
                confirmPasswordError.textContent = '';
            }

            if (isValid) {
                this.submit();
            }
        });
    </script>
</body>
</html>
