<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
    <title>Register</title>
    <link rel="shortcut icon" href="assets/img/favicon.png">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/fontawesome.min.css">
    <link rel="stylesheet" href="assets/plugins/fontawesome/css/all.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>

<body>

    <div class="main-wrapper login-body">
        <div class="login-wrapper">
            <div class="container"> 
                <div class="loginbox">
                    <div class="login-right">
                        <div class="login-right-wrap">
                            <h1>Register</h1>
                            <p class="account-subtitle">Access to our dashboard</p>
                            <form id="registerForm">
                                <div class="form-group">
                                    <label class="form-control-label">First Name</label>
                                    <input class="form-control" type="text" name="first_name" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Last Name</label>
                                    <input class="form-control" type="text" name="last_name" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Email Address</label>
                                    <input class="form-control" type="email" name="email" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Password</label>
                                    <input class="form-control" type="password" name="password" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Confirm Password</label>
                                    <input class="form-control" type="password" name="confirm_password" required>
                                </div>
                                <div class="form-group mb-0">
                                    <button class="btn btn-lg btn-block btn-primary w-100"
                                        type="submit">Register</button>
                                </div>
                            </form>

                             
                            <div class="text-center dont-have">Already have an account? <a href="/">Login</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/feather.min.js"></script>
    <script>
    $(document).ready(function() {
    $("form").submit(function(e) {
        e.preventDefault(); // Prevent default form submission

        // Clear previous error messages
        $(".error-message").remove();

        var first_name = $("input[name='first_name']").val();
        var last_name = $("input[name='last_name']").val();
        var email = $("input[name='email']").val();
        var password = $("input[name='password']").val();
        var confirm_password = $("input[name='confirm_password']").val();

        // Flag to check if there are validation errors
        var hasError = false;

        // Client-side validation for required fields
        if (first_name === '') {
            $("input[name='first_name']").after('<span class="error-message" style="color: red;">This field is required.</span>');
            hasError = true;
        }
        
        if (last_name === '') {
            $("input[name='last_name']").after('<span class="error-message" style="color: red;">This field is required.</span>');
            hasError = true;
        }
        
        if (email === '') {
            $("input[name='email']").after('<span class="error-message" style="color: red;">This field is required.</span>');
            hasError = true;
        }

        if (password === '') {
            $("input[name='password']").after('<span class="error-message" style="color: red;">This field is required.</span>');
            hasError = true;
        }

        if (confirm_password === '') {
            $("input[name='confirm_password']").after('<span class="error-message" style="color: red;">This field is required.</span>');
            hasError = true;
        }

        // Additional validation checks
        if (password !== confirm_password) {
            $("input[name='confirm_password']").after('<span class="error-message" style="color: red;">Passwords do not match.</span>');
            hasError = true;
        }

        // Email validation
        var emailPattern = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailPattern.test(email)) {
            $("input[name='email']").after('<span class="error-message" style="color: red;">Please enter a valid email address.</span>');
            hasError = true;
        }

        if (password.length < 6) {
            $("input[name='password']").after('<span class="error-message" style="color: red;">Password must be at least 6 characters long.</span>');
            hasError = true;
        }

        // If there are validation errors, stop submission
        if (hasError) {
            return;
        }

        // If all validations pass, proceed with the AJAX request
        $.ajax({
            url: "/api/register",
            type: "POST",
            data: {
                first_name: first_name,
                last_name: last_name,
                email: email,
                password: password,
                confirm_password: confirm_password
            },
            success: function(response) {
                alert(response.message); 
                window.location.href = "/"; // Redirect to login page
            },
            error: function(xhr) {
                alert(xhr.responseJSON.message || "Registration failed!");
            }
        });
    });
});

    </script>
</body>

</html>