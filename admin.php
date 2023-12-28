<!DOCTYPE html>
<html lang="en" data-bs-theme="dark">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>


            body{
                font-family: "Lato", sans-serif;
                background: #A6E0FF;
                margin:0;
            }
        </style>


        <?php
            include_once "header.php";
            include_once "system/auth.php";
            include_once("system/db_connect.php");
            

            if (isset($_POST['updateUser'])) {
                    $uname = mysqli_real_escape_string($conn, $_POST["username"]);
                    $tag = mysqli_real_escape_string($conn, $_POST["tag"]);
                    $lvl = mysqli_real_escape_string($conn, $_POST["level"]);
        
                    if(mysqli_query($conn, "UPDATE users SET tag = '".$tag."',lvl = '".$lvl."' WHERE username = '".$uname."'")) {
                        header("Location:".$_SERVER['PHP_SELF']."?udtUser=true");
                    }
                    else{
                        header("Location:".$_SERVER['PHP_SELF']."?error=true");
                    }
            }

            if (isset($_POST['systemMessage'])) {
                $msg = mysqli_real_escape_string($conn, $_POST["message"]);
                $sysMessage = '<p style="color:orange;display:inline;">'.$msg.'</p>';

                $arQuery = "SELECT * FROM activerooms";
                $arResult = mysqli_query($conn, $arQuery);
                $arResultCheck = mysqli_num_rows($arResult);

                

                if ($arResultCheck > 0){

                    while ($row = mysqli_fetch_assoc($arResult)){
                        if (mysqli_query($conn, "INSERT INTO ".$row['roomname']."(sender_tag, sender, message, date) VALUES('[SYS]', '[SYSTEM]', '" . $sysMessage . "', UTC_TIMESTAMP())")){
                        
                            header("Location:".$_SERVER['PHP_SELF']."?sysmsg=true");
                        }
                    }
                }else{
                    header("Location:".$_SERVER['PHP_SELF']."?error=true");
                }
                
            }

            if (isset($_POST['patchMessage'])) {
                $msg = mysqli_real_escape_string($conn, $_POST["message"]);
                $title = mysqli_real_escape_string($conn, $_POST["title"]);
                $version = mysqli_real_escape_string($conn, $_POST["version"]);
                $date = date('Y-m-d H:i:s');

                if (mysqli_query($conn, "INSERT INTO patchnotes (date, version, title, message) VALUES('".$date."','".$version."','".$title."','".$msg."')")){
                    header("Location:".$_SERVER['PHP_SELF']."?patch=true");
                }
                else{
                    header("Location:".$_SERVER['PHP_SELF']."?error=true");
                }
                
            }
        ?>
    </head>
    <body>
        
            
        <div style="text-align:center;">
            <form style="margin-top:2%;" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">


                <select name="username">


                <?php 

                    $query = "SELECT * FROM users";
                    $result = mysqli_query($conn, $query);
                    $resultCheck = mysqli_num_rows($result);

                    if ($resultCheck > 0){

                        while ($row = mysqli_fetch_assoc($result)){
                            echo "<option value=".$row['username'].">".$row['username']."</option>";
                        }
                    }

                    ?>

                </select>

                <select name="tag">
                    <option value=""> N/A </option>
                    <option value='<p style="color:olive;display:inline">[OG] </p>'> [OG] </option>
                    <option value='<p style="color:lime;display:inline">[VIP] </p>'> [VIP] </option>
                    <option value='<p style="color:green;display:inline">[MOD] </p>'> [MOD] </option>
                    <option value='<p style="color:red;display:inline">[ADMIN] </p>'> [ADMIN] </option>
                    <option value='<p style="color:maroon;display:inline">[TESTER] </p>'> [TESTER] </option>
                    <option value='<p style="color:blue;display:inline">[DEV] </p>'> [DEV] </option>
                </select>


                <input type="text" name="level" placeholder="New level">

                <!-- <input type="text" name="tag" placeholder="New tag"> -->
                    
                    
                <input type="submit" name="updateUser" value="Update user">

            </form>

            <form style="margin-top:2%;" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                <input type="text" name="message" placeholder="System message">
                <input type="submit" name="systemMessage" value="Send system message">
            </form>

            <p>Only need version number.</p>
            <form style="margin-top:2%;" id="patchNotes" method="POST" action="<?php echo $_SERVER['PHP_SELF']; ?>">

                <input type="text" name="version" placeholder="Patch version"> <input type="text" name="title" placeholder="Patch title"> 
                
                <input type="submit" name="patchMessage" value="Send patch message">
            </form>
            <textarea rows="4" cols="50" name="message" form="patchNotes">Enter text here</textarea>
        </div>

        <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3">
            <div id="liveToast_sysmsg" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header text-bg-success">
                <strong class="me-auto">System alert</strong>
                <small>Now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    System message sent successfully!
                </div>
            </div>
        </div>

        <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3">
            <div id="liveToast_udtUser" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header text-bg-success">
                <strong class="me-auto">System alert</strong>
                <small>Now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    User updated successfully!
                </div>
            </div>
        </div>

        <div class="toast-container position-fixed top-0 start-50 translate-middle-x p-3">
            <div id="liveToast_patch" class="toast" role="alert" aria-live="assertive" aria-atomic="true">
                <div class="toast-header text-bg-success">
                <strong class="me-auto">System alert</strong>
                <small>Now</small>
                <button type="button" class="btn-close" data-bs-dismiss="toast" aria-label="Close"></button>
                </div>
                <div class="toast-body">
                    Patch notes sent successfully!
                </div>
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
                    ERROR - command did not work!
                </div>
            </div>
        </div>



        <script>

            const queryString = window.location.search;
            const urlParams = new URLSearchParams(queryString);
            const isMsgSuccess = urlParams.get('sysmsg');
            const isUdtUserSuccess = urlParams.get('udtUser');
            const isPatchSuccess = urlParams.get('patch');
            
            const isErrorActive = urlParams.get('error');
            

            console.log(isMsgSuccess);
            
            const toastLive_sysmsg = document.getElementById('liveToast_sysmsg');
            const toastLive_udtUser = document.getElementById('liveToast_udtUser');
            const toastLive_patch = document.getElementById('liveToast_patch');
            const toastLive_error = document.getElementById('liveToast_error');
            
            
            if(isMsgSuccess){
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLive_sysmsg)
                toastBootstrap.show();
            }

            if(isUdtUserSuccess){
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLive_udtUser)
                toastBootstrap.show();
            }

            if(isPatchSuccess){
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLive_patch)
                toastBootstrap.show();
            }

            if(isErrorActive){
                const toastBootstrap = bootstrap.Toast.getOrCreateInstance(toastLive_error)
                toastBootstrap.show();
            }
        </script>
    </body>
</html>