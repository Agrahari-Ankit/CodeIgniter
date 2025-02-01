<!DOCTYPE html>
<html lang="en">
   <head>
      <meta charset="utf-8">
      <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0">
      <title>Login</title>
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
                        <h1>Login</h1>
                        <p class="account-subtitle">Access to our dashboard</p>
                        <form action="https://kanakku.dreamguystech.com/html/template/index.html">
                           <div class="form-group">
                              <label class="form-control-label">Email Address</label>
                              <input type="email" class="form-control">
                           </div>
                           <div class="form-group">
                              <label class="form-control-label">Password</label>
                              <div class="pass-group">
                                 <input type="password" class="form-control pass-input">
                                 <span class="fas fa-eye toggle-password"></span>
                              </div>
                           </div>
                            
                           <button class="btn btn-lg btn-block btn-primary w-100" type="submit">Login</button>
                           
                           <div class="text-center dont-have">Don't have an account yet? <a href="/register">Register</a></div>
                        </form>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      <script src="assets/js/jquery-3.6.0.min.js"></script>
      <script src="assets/js/bootstrap.bundle.min.js"></script>
      <script src="assets/js/feather.min.js"></script>
      <!-- <script src="assets/js/script.js"></script> -->
      <script>
        $(document).ready(function() {
            $("form").submit(function(e) {
                e.preventDefault(); // Prevent form from submitting normally

                $.ajax({
                    url: "/api/login",
                    type: "POST",
                    data: {
                        email: $("input[type='email']").val(),
                        password: $("input[type='password']").val()
                    },
                    success: function(response) {
                        console.log(response.data.role);
                        alert(response.message);
                        if(response.data.role=='customer'){
                           window.location.href = "customer/dashboard"; 
                        }else{
                           window.location.href = "admin/dashboard"; 
                        }
                    },
                    error: function(xhr) {
                        alert(xhr.responseJSON.message); 
                    }
                });
            });
        });
    </script>
   </body>
</html>