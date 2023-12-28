<!DOCTYPE html>
<html data-bs-theme="dark">
    <head>
        <?php 
            include_once "system/db_connect.php";
        ?>
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <style>
            .ocean {
                z-index: 0;
                height: 5vh;
                width: 100%;
                position: relative;
                bottom: 0;
                left: 0;
                background: #363c42;
                }

                .wave {
                    
                z-index: 0;
                background: url(waveGraysvg.svg) repeat-x;
                position: absolute;
                bottom: -10px;
                width: 6400px;
                height: 198px;
                animation: wave 12s cubic-bezier(0.36, 0.45, 0.63, 0.53) infinite, swell 8s ease -1.25s infinite;;
                transform: translate3d(0, 0, 0);
                }



                @keyframes wave {
                0% {
                    margin-left: 0;
                }
                100% {
                    margin-left: -1600px;
                }
                }
                @keyframes swell {
                0%,
                100% {
                    transform: translate3d(0, -40px, 0);
                }
                50% {
                    transform: translate3d(0, -10px, 0);
                }
                }
                .endWave{
                display:none;
                }
            body {
                background-size: 40px 40px;
                background-image: radial-gradient(circle, #000000 1px, rgba(0, 0, 0, 0) 1px);
            }   
            .bk_picture{
                background-image: url("./images/layered-peaks-haikei.svg");
                background-size:cover;
                background-repeat: no-repeat;
            }
            
        </style>
    </head>
    <body class="overflow-x-hidden">  
        
  
    
        <?php include_once("header.php");?>

        <div class="bk_picture d-flex justify-content-center align-items-center" style="width:100vw; height:30vw; margin-top: -1vh;"> 
            <button onClick="window.location='https://chatgpt2.epizy.com/signup.php'" class="shadow-sm me-4 btn btn-lg btn-primary z-1 "> Sign-up! </button>
            <button onClick="window.location='https://chatgpt2.epizy.com/CreateRoom2.php'" class="shadow-sm btn btn-lg btn-outline-secondary z-1"> Open Project C</button>
        </div>            

        <h1 class="text-center z-1">Patch-notes</h1>
        <div class="card container-md overflow-x-auto width-4 z-1 mb-4" style="height:40vh">

            <?php
                $query = "SELECT * FROM `patchnotes` ORDER BY `version` DESC";
                $result = mysqli_query($conn, $query);
                $resultCheck = mysqli_num_rows($result);

                
                if ($resultCheck > 0){
                    while ($row = mysqli_fetch_assoc($result)){
                                
                        ?>
                    
                        <div class="card my-2">
                            <div class="card-header">
                                <p class="fw-bold"><?php echo "V".$row['version']?> <span class="badge bg-secondary">New</span></p>
                            </div>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row["title"]?> </h5>
                                <p class="card-text"><?php echo nl2br($row['message'])?></p>
                            </div>
                            <div class="card-footer text-body-secondary">
                                <?php echo $row["date"]?>
                            </div>
                        </div>
                        

                        <?php
                    
                    }
                }   
            ?>
        </div>
    
        <!--Decoration -->
        <!-- <div class="ocean opacity-50 z-0">
            <div class="wave"></div>
        </div> -->
    </body>
</html> 