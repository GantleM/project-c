<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TEST 1</title>
    <style>

    /* --- Public rooms --- */

    </style>

    <?php 

    session_start();
    include_once("system/db_connect.php");
    include_once("system/auth.php");
   


   

    if (isset($_POST['createroom'])){

        $error = false;
        $name = mysqli_real_escape_string($conn, $_POST['name']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);

        if (!preg_match("/^[a-zA-Z0-9]+$/",$name)) {
            $error = true;
            echo "Room name must contain only alphabets or numbers!";
        }
                    
        if (!$error) {
            if(mysqli_query($conn, "INSERT INTO activerooms(roomname, roompass) VALUES('" . $name . "', '" . md5($password) . "')")) {
                echo("Successfully made room!");
                if(mysqli_query($conn,"CREATE TABLE `$name` (`msgid` int(11) NOT NULL AUTO_INCREMENT,`sender_tag` varchar(255) DEFAULT NULL,`sender` varchar(255) DEFAULT NULL,`message` varchar(500) DEFAULT NULL,`date` DATETIME NOT NULL,PRIMARY KEY (`msgid`)) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;")){
                    
                    echo("</br>"."Successfully setup chatroom!");
                  }
            }
        }

    }


    
    if(isset($_GET['room'])){
        //Make it based on id in loadMessages.php
        $name = mysqli_real_escape_string($conn, $_GET['room']);

        $banCheckquery = "SELECT * FROM ".$name." WHERE message='/ban ".$_SESSION['user_name']."'";
        $banCheckresult = mysqli_query($conn, $banCheckquery);
        $banCheck = mysqli_num_rows($banCheckresult);
        
        if($banCheck > 0){
            header("Location:".$_SERVER['PHP_SELF'].'?'.'isbanned=true');
            // http_build_query(array_merge($_GET, array('isBanned'=>'true')));
            
        }else{
            $_SESSION['room_name'] = $_GET['room'];
            $_SESSION['room_id'] = $row['roomid'];
        }
    }
    
    

    

    

    ?>
</head>
<body>


    
    <?php include_once("header.php");?>

    <div class="container row mx-auto">

        <div class="container-fluid overflow-x-auto" style="">

            <div class="btn-group">
                <?php
                $query = "SELECT * FROM activerooms";
                $result = mysqli_query($conn, $query);
                $resultCheck = mysqli_num_rows($result);

                if ($resultCheck > 0){
                    while ($row = mysqli_fetch_assoc($result)){

                        ?>
                            
                            <button class="my-3 rounded-circle btn-xl border-0 p-4 "  data-bs-toggle="tooltip" data-bs-placement="bottom" data-bs-title="<?php echo($row['roomname']) ?>" onClick="window.location='https://chatgpt2.epizy.com<?php echo($_SERVER['PHP_SELF']."?room=".$row['roomname'])?>'"> <?php echo(substr($row['roomname'], 0,3))?> </button>
                            
                        <?php  
                    }
                }?>
            </div>
            <hr/>
        </div>

        <div class="col align-items-center">
            <?php include("Test2C.php"); ?>
        </div>
    </div>

    <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3">
        <div id="liveToast_error" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
            <div class="toast-header text-bg-danger">
            <strong class="me-auto">System alert</strong>
            <small>Now</small>
            <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
            </div>
            <div class="toast-body">
                You are banned from that room!
            </div>
        </div>
    </div>
    <!-- <ul class="nav flex-column border-end ms-4">
    <li class="nav-item">
    </li>
    </ul> -->
    <script>
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));

        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);

        const isErrorActive = urlParams.get('isbanned');
        console.log(isErrorActive);
        const toastLive_error = document.getElementById('liveToast_error');

        if(isErrorActive){
            const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLive_error)
            toastBootstrap.show();
        }
    </script>
    
</body>
</html>