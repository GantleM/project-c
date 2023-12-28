<!DOCTYPE html>
<html data-bs-theme="dark">
    <head>
        <?php 
            include_once "header.php";
            include_once "system/auth.php";
               


            function loadData(){
                include_once "system/db_connect.php";

                $query = mysqli_query($conn, "SELECT * FROM users WHERE username='".$_SESSION["user_name"]."'");
                $row = mysqli_fetch_array($query);
                if($row){
                    $result = $row['email'];
                    return($result);
                    
                }
            }

            $email = loadData();

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
        <div class="container">
            <div class="card mx-auto" style="max-width: 50rem">
                <div class="card-header text-bg-primary "> 
                    <img style="width:10vw" src="pPic.png"/> 
                </div>
                
                <div class="card-body text-bg-dark">
                    <h1> Basic Information </h1>
                    
                    <p class="fw-bold text-body-secondary mb-0">Username</p>
                    <span class="badge bg-light"><?php echo($_SESSION["user_tag"]);?></span> <p class="d-inline"><?php echo($_SESSION["user_name"]);?></p>
                
                    <p class="fw-bold text-body-secondary mb-0">Email adress</p>
                    <p class=""> <?php echo($email);?>  </p>
                        
                

                
                    <button class="btn btn-lg btn-danger" onclick="window.location.href='system/logout.php';"> Log-out </button> 
                </div> 
            </div>
        </div>
    </body>
</html> 