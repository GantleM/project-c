<?php 
    session_start();
    
?>
<meta name="viewport" content="width=device-width, initial-scale=1">
<!-- 

Version: V1.1.1
Developer: GantleM 
Date: Last edit 29/03/2023
Subject: Coding project | simple chat app, 
Title: chatgpt2 

Note(s):
- New login-system
    -> Has error messages
-->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<title>Project C</title>

<style> 

    .loaderWrapper{
        position: fixed;
        z-index: 99999;
        top:0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #212529;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .loader {
        margin: auto;
        border: 20px solid #454545;
        border-radius: 50%;
        border-top: 20px solid #0d6efd;
        width: 200px;
        height: 200px;
        animation: spinner 4s linear infinite;
    }

    .loaderWrapper.hidden{
        animation: fadeOut 1s;
        animation-fill-mode: forwards;
    }

    @keyframes fadeOut{
        100% {
            opacity: 0;
        }
    }

    @keyframes spinner {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }

</style>

<!-- Links/texts at the side -->
<div class="loaderWrapper">
    <div class="loader"></div>
</div>


<nav class="navbar navbar-expand-lg bg-body-tertiary mb-2 p-3">
  <div class="container-fluid">
    <!-- If Logged in, profile pictur, if not, "Log-in" button. -->
    <?php 
        if(isset($_SESSION['user_name']) && $_SESSION['user_name'] != ""){
    ?>
         
        <a href="profile.php"> <img width="40" height="40" src="pPic.png"/> </a>
         
    <?php }
    else{?>
        
        <button class="btn btn-outline-primary" onclick="goToProfile()"> Log-in </button> 
    
    <?php }; ?>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="CreateRoom2.php">Chatrooms</a>
        </li>
        
    <!-- if < lvl 4  -->
    <?php if($_SESSION['user_lvl'] >= 4){?>
        <li class="nav-item">
          <a class="nav-link" href="admin.php">Admin Panel</a>
        </li>
    <?php } ?>

      </ul>
    </div>
  </div>
</nav>



<script>

    // Listens/waits till the page loads then does a function
    window.addEventListener("load", function(){
        const loader = document.querySelector(".loader");
        const loaderWrapper = document.querySelector(".loaderWrapper"); 
        setTimeout(() => {  
            loader.className += "hidden";
            loaderWrapper.className +="hidden";
        }, 500);
        

    })

    function goToProfile(){
        window.location.href='login.php';
    }

</script>
        
    