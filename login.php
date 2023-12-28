<!DOCTYPE html>

<html data-bs-theme="dark">
    <head>
        <?php 
            include_once ("header.php");
            include_once "system/db_connect.php";

            if (isset($_POST['login'])) {
                $uname = mysqli_real_escape_string($conn, $_POST["username"]);
                $password = mysqli_real_escape_string($conn, $_POST["password"]);
                $query = mysqli_query($conn, "SELECT * FROM users WHERE username='".$uname."' and pass='".md5($password)."'");
                $row = mysqli_fetch_array($query);

                if($row){

                    $_SESSION['user_id'] = $row['uid'];

		            $_SESSION['user_name'] = $row['username'];

                    $_SESSION['user_lvl'] = $row['lvl'];
                    
                    $_SESSION['user_tag'] = $row['tag'];
		            header("Location:index.php");
            

                }

                else{
                    $logIn_error = "is-invalid";    
                }
            }
        ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <style>
            body {
                background-size: 40px 40px;
                background-image: radial-gradient(circle, #000000 1px, rgba(0, 0, 0, 0) 1px);
            }
    
        </style>

    </head>

    <body>


        <?php  ?>

        <!-- The log-in form -->

        <div class="loginBox">

            <div class="container card mt-4 mx-auto" style="max-width:40rem">

                <h1 class="text-align-center my-3"> Log-in to an exisitng account! </h1>

                <form method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text">@</span>
                        <div class="form-floating <?php echo($logIn_error) ?>">
                            <input type="text" name="username" class="form-control <?php echo($logIn_error) ?>" id="floatingInputGroup1" placeholder="Username">
                            <label for="floatingInputGroup1">Username</label>
                        </div>
                        <div class="invalid-feedback">
                            Username or password is invalid!
                        </div>
                    </div>

                    <div class="input-group has-validation mb-3">
                        <span class="input-group-text">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-lock-fill" viewBox="0 0 16 16">
                                <path d="M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2m3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2"/>
                            </svg>
                        </i></span>
                        <div class="form-floating <?php echo($logIn_error) ?>">
                            <input type="password" name="password" class="form-control <?php echo($logIn_error) ?>" id="floatingInputGroup1" placeholder="Password">
                            <label for="floatingInputGroup1">Password</label>
                        </div>
                        <div class="invalid-feedback">
                            Username or password is invalid!
                        </div>
                    </div>

                    
                    <input type="submit" name="login" value="Log-in" class="mx-auto d-grid btn btn-lg btn-primary">
                </form>

                <p class="mx-auto mt-3 mb-0"> Don't have an account? </p>
                <a class="mx-auto mb-2" href="signup.php"> Sign-up here! </a>
                

            </div>

            

            

        </div>

        

    </body>

</html> 