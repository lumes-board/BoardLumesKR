<?php

    session_start();
    
    require("../../common/verify_reCAPTCHA.php");
    
    $reCAPTCHApass = check_reCAPTCHA();

    if($reCAPTCHApass === true){


    } else {

        ?>

            <script>
                
                // reCAPTCHA 인증에 실패함
                Swal.fire({
                    icon: 'error',
                    title: 'Are you a robot?',
                    footer: 'reCAPTCHA를 성공적으로 통과하셔야 해요!'
                }).then((result) => {
                    location.href = "./signup.php";
                })

            </script>

        <?php

    }
    
 
?>