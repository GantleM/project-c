<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> Room: </title>

    <style>
        .messageBar{
            text-align: center;
        }

        .messageBar input{
            width: 70%;
            height: 40px;
        }
    </style>

    <?php
    session_start();
    include_once("system/db_connect.php");
    include_once("system/auth.php");

    // if( $_SERVER['HTTP_REFERER'] != "https://chatgpt2.epizy.com".$_SERVER['PHP_SELF'] && $_SERVER['HTTP_REFERER'] != "http://chatgpt2.epizy.com".$_SERVER['PHP_SELF']){
        
    //     $date = date('Y/m/d H:i:s');
    //     $joinMessage = '<p style="color:blue;display:inline;"> '.$_SESSION['user_name'].' has joined. </p>';

    //     if (mysqli_query($conn, "INSERT INTO ".$_SESSION['room_name']."(sender_tag, sender, message, date) VALUES('[SYS]', '[SYSTEM]', '" . $joinMessage . "', '".$date."')")){

    //     }

    // }

    if (isset($_POST['sendMessage'])){

        $error = false;
        $system = false;
        $date = date('Y/m/d H:i:s');
        $offender = '';
        $name = $_SESSION['user_name'];


        $query = mysqli_query($conn,"SELECT * FROM users WHERE username='".$name."'");

        $row = mysqli_fetch_array($query);

        if($row){

            $tag = $row['tag'];
            $_SESSION['user_lvl'] = $row['lvl'];

        }else{

            $tag = "";
        }

        $msg = mysqli_real_escape_string($conn, $_POST['msg']);

        if(empty($msg)){

            $error = true;
        }

        if($_SESSION['user_lvl']<1){

            $error = true;
        }

        //COMMANDS ---------------------------------- 

        if(preg_match("/\/ban \b/i", $msg)){
            if($_SESSION['user_lvl'] < 4){

                $error = true;
            }else{

                $system = true;
                $offender = substr($msg, strpos($msg, " ") + 1);
                $sysMessage = '<p style="color:red;display:inline;">'.$offender.' has been banned. </p>';
            }
        }

        if(preg_match("/\/unban \b/i", $msg)){
            if($_SESSION['user_lvl'] < 4){

                $error = true;

            }else{

                $system = true;
                $offender = substr($msg, strpos($msg, " ") + 1);
                $query = "DELETE FROM ".$_SESSION['room_name']." WHERE message in ('/ban ".$offender."','/warn ".$offender."')";

                if(mysqli_query($conn, $query)){ 
                }
                $sysMessage = '<p style="color:green;display:inline;">'.$offender.' has been unbanned. </p>';

            }

        }

        if(preg_match("/\/warn\b/i", $msg)){

            if($_SESSION['user_lvl'] < 3){

                $error = true;
            }else{

                $system = true;
                $offender = substr($msg, strpos($msg, " ") + 1);
                $warnCheckquery = "SELECT * FROM ".$_SESSION['room_name']." WHERE message='/warn ".$offender."'";
                $warnCheckresult = mysqli_query($conn, $warnCheckquery);
                $warnAmount = mysqli_num_rows($warnCheckresult) + 1;

                if($warnAmount < 3){

                    $sysMessage = '<p style="color:#FFBB23;display:inline;"> '.$offender.' has been warned. ('.$warnAmount.'/3) </p>';
                }else{

                    $sysMessage = '/ban '.$offender; //-- BAN FIRST
                    
                    if (mysqli_query($conn, "INSERT INTO ".$_SESSION['room_name']."(sender_tag, sender, message, date) VALUES('[SYS]', '[SYSTEM]', '" . $sysMessage . "', '".$date."')")){
                    }

                    $sysMessage = '<p style="color:red;display:inline;"> Auto-banned '.$offender.'. Max warnings ('.$warnAmount.'/3) </p>'; //-- LOG IT

                }
            }
        }



        if($msg == "/coinflip"){
            if($_SESSION['user_lvl'] < 2){

                $error = true;
            }else{

                $system = true;
                $flipresult = array("heads", "tails")[random_int(0,1)];
                $sysMessage = '<p style="color:black;display:inline;"> The coin landed on: '.$flipresult.' </p>';
            }

        }



        if($msg == "/help"){
            if($_SESSION['user_lvl'] < 1){

                $error = true;
            }else{

                $system = true;
                $sysMessage = '<p style="color:black;display:inline;"> The following commands exist: | /ban (username) - ADMIN+ | /unban (username) - ADMIN+ | /warn (username) - MOD+ | /coinflip - VIP+ | /help - anyone |</p>';
            }

        }

        // $url_parsed_arr = parse_url($msg);
        // if($url_parsed_arr['host'] == "www.youtube.com" && $url_parsed_arr['path'] == "/watch" && substr($url_parsed_arr['query'], 0, 2) == "v=" && substr($url_parsed_arr['query'], 2) != ""){

        //     if($_SESSION['user_lvl'] < 2){

        //         $sysMessage = '<p style="color:black;display:inline;"> @'.$_SESSION["user_name"].' Youtube embeds are currenly limited to VIP+ as they are in experimental phase. </p>';

        //         if (mysqli_query($conn, "INSERT INTO ".$_SESSION['room_name']."(sender_tag, sender, message, date) VALUES('[SYS]', '[SYSTEM]', '" . $sysMessage . "', '".$date."')")){

        //         }

        //         $error = true;
        //     }
        // }

        

            



        //SEND MESSAGE---------------------------------- 

        if (!$error) {

            if($system){

                if(mysqli_query($conn, "INSERT INTO ".$_SESSION['room_name']."(sender_tag, sender, message, date) VALUES('".$tag."', '" . $name . "', '" . strip_tags($msg) . "', '".$date."')")) {

                }

                if (mysqli_query($conn, "INSERT INTO ".$_SESSION['room_name']."(sender_tag, sender, message, date) VALUES('[SYS]', '[SYSTEM]', '" . $sysMessage . "', '".$date."')")){

                }



            }else{

                if(mysqli_query($conn, "INSERT INTO ".$_SESSION['room_name']."(sender_tag, sender, message, date) VALUES('".$tag."', '" . $name . "', '" . strip_tags($msg) . "', '".$date."')")) {

                }

            }
        }
    }

    if (isset($_POST['deleteMessages'])){

        $error = false;
        $checkedBoxes = implode(', ', $_POST['check_list']);

        if (!$error) {
            $query = "DELETE FROM ".$_SESSION['room_name']." WHERE msgid in (".$checkedBoxes.")";

            if(mysqli_query($conn, $query)){ 
            }
        }
    }?>

</head>

<body onload="scrollToBottom('chBox')">

    <script src="https://code.jquery.com/jquery-3.6.4.js" integrity="sha256-a9jBBRygX1Bh5lt8GZjXDzyOB+bWve9EiO7tROUtj/E=" crossorigin="anonymous"></script>
    <script>

        jQuery().ready(function(){

            setInterval("getResult()",10000);
        });

        const scrollToBottom = (id) => {

	        const element = document.getElementById(id);
            element.scrollTop = element.scrollHeight;
        }

        function getResult(){   

            jQuery.post("system/loadMessages.php",function( data ) {

                jQuery("#msgs").html(data);

            });

            if($('#autoScroll').is(':checked')){

                scrollToBottom("chBox");
            }
        }

//---------- Start typing in search bar by default

        $(document).bind('keydown',function(e){

            $('#searchbar').focus();

            $(document).unbind('keydown');

        });



    </script>

    <!--- Boxes in the boxes --->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
        <div id="chBox" style="height: 500px; overflow: scroll;">

            <?php
                include("system/loadMessages.php");

            ?>
        </div>
        <?php if($_SESSION['user_lvl'] > 2){

            echo '<input type="submit" name="deleteMessages" value="DELETE"/>';

        }

        ?>

        <div style="display: inline;">

            <input type="checkbox" id="autoScroll"> <p style="display: inline;">Auto-scroll</p>

        </div>
    </form>

    <div >

        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" >
            <div class="messageBar">

                <input type="text" name="msg" id="searchbar" placeholder="Enter a Message" autocomplete="off"/>
            </div>					

            <div >

                <input style="display:none;"type="submit" name="sendMessage" value="Send" />

            </div>
        </form>

    </div>
    

</body>

</html>