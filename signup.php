<!DOCTYPE html>

<html data-bs-theme="dark">

    <head>



        <?php 

            include_once "header.php";

            include_once "system/db_connect.php";

            if(isset($_POST["signup"])){
                
                $error = false;
                $uname = mysqli_real_escape_string($conn,$_POST["username"]);
                $email = mysqli_real_escape_string($conn,$_POST["email"]);
                $psw = mysqli_real_escape_string($conn,$_POST["password"]);
                $cpsw = mysqli_real_escape_string($conn,$_POST["cpassword"]);

                $uname_error = "";
                $email_error = "";
                $password_error = "";
                $cpassword_error = "";



                if (!preg_match("/^[a-zA-Z0-9]+$/",$uname)) {

                    $error = true;
                    $uname_error = "is-invalid";
                }

                if(!filter_var($email,FILTER_VALIDATE_EMAIL)) {

                    $error = true;
                    $email_error = "is-invalid";
                }

                if(strlen($psw) < 6) {

                    $error = true;
                    $password_error ="is-invalid";
                }

                if($psw != $cpsw) {

                    $error = true;
                    $cpassword_error = "is-invalid";
                }
                if(!$error){
                    $query = mysqli_query($conn, "SELECT * FROM users WHERE username='".$uname."'");

                    if(mysqli_num_rows($query) > 0){

                        $uname_error = "is-invalid";

                    }else{
                        if(mysqli_query($conn, "INSERT INTO users(lvl, username, email, pass) VALUES(1,'" . $uname . "', '" . $email . "', '" . md5($psw) . "')")) {

                            $success_message = "Successfully Registered!";
                            header("Location:login.php");
                        }
                    }
                }
            }
        
        ?>

        <style>
            body {
                background-size: 40px 40px;
                background-image: radial-gradient(circle, #000000 1px, rgba(0, 0, 0, 0) 1px);
            }
        </style>

        <meta name="viewport" content="width=device-width, initial-scale=1">

    </head>

    <body>

        <!-- The sign-up form -->

        <div>

            <div class="container card mt-4 mx-auto" style="max-width:40rem">

                <h1 class="text-align-center my-3"> Sign-up now! </h1>

                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text">@</span>
                        <div class="form-floating <?php echo($uname_error)?>">
                            <input type="text" name="username" class="form-control <?php echo($uname_error)?>" id="floatingInputGroup1" placeholder="Username">
                            <label for="floatingInputGroup1">Username</label>
                        </div>
                        <div class="invalid-feedback">
                            Username not available! (characters/numbers only)
                        </div>
                    </div>

                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-envelope-at-fill" viewBox="0 0 16 16">
                            <path d="M2 2A2 2 0 0 0 .05 3.555L8 8.414l7.95-4.859A2 2 0 0 0 14 2zm-2 9.8V4.698l5.803 3.546L0 11.801Zm6.761-2.97-6.57 4.026A2 2 0 0 0 2 14h6.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586l-1.239-.757ZM16 9.671V4.697l-5.803 3.546.338.208A4.482 4.482 0 0 1 12.5 8c1.414 0 2.675.652 3.5 1.671"/>
                            <path d="M15.834 12.244c0 1.168-.577 2.025-1.587 2.025-.503 0-1.002-.228-1.12-.648h-.043c-.118.416-.543.643-1.015.643-.77 0-1.259-.542-1.259-1.434v-.529c0-.844.481-1.4 1.26-1.4.585 0 .87.333.953.63h.03v-.568h.905v2.19c0 .272.18.42.411.42.315 0 .639-.415.639-1.39v-.118c0-1.277-.95-2.326-2.484-2.326h-.04c-1.582 0-2.64 1.067-2.64 2.724v.157c0 1.867 1.237 2.654 2.57 2.654h.045c.507 0 .935-.07 1.18-.18v.731c-.219.1-.643.175-1.237.175h-.044C10.438 16 9 14.82 9 12.646v-.214C9 10.36 10.421 9 12.485 9h.035c2.12 0 3.314 1.43 3.314 3.034zm-4.04.21v.227c0 .586.227.8.581.8.31 0 .564-.17.564-.743v-.367c0-.516-.275-.708-.572-.708-.346 0-.573.245-.573.791Z"/>
                            </svg>
                        </span>
                        <div class="form-floating <?php echo($email_error)?>">
                            <input type="email" name="email" class="form-control <?php echo($email_error)?>" id="floatingInputGroup1" placeholder="someone@example.com">
                            <label for="floatingInputGroup1">Email address</label>
                        </div>
                        <div class="invalid-feedback">
                            Please enter valid email ID! 
                        </div>
                    </div>


                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"/>
                            </svg>
                        </i></span>
                        <div class="form-floating <?php echo($password_error)?>">
                            <input type="password" name="password" class="form-control <?php echo($password_error)?>" id="floatingInputGroup1" placeholder="Password">
                            <label for="floatingInputGroup1">Password</label>
                        </div>
                        <div class="invalid-feedback">
                            Password must be minimum of 6 characters!
                        </div>
                    </div>

                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"/>
                            </svg>
                        </i></span>

                        <div class="form-floating <?php echo($cpassword_error)?>">
                            <input type="password" name="cpassword" class="form-control <?php echo($cpassword_error)?>" id="floatingInputGroup1" placeholder="Confirm password">
                            <label for="floatingInputGroup1">Confirm password</label>
                        </div>
                        <div class="invalid-feedback">
                            Passwords don't match!
                        </div>
                    </div>

                    <input type="submit" name="signup" value="Sign-up" class="mx-auto d-grid btn btn-lg btn-primary">
                </form>

                <p class="mx-auto mt-3 mb-0"> Already have an account? </p>
                <a class="mx-auto mb-2" href="login.php"> Log-in here! </a>
                

            </div>
        </div>
    </body>
</html> 