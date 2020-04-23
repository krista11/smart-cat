<?php
    require_once('C:\xampp\htdocs\bossy-cat\Controllers\mysql.php');
    session_start();
    $error = " ";
    if($_SERVER["REQUEST_METHOD"] == "POST") {

        $email = mysql::quote($_POST['email']);
        $phrase = mysql::quote($_POST['phrase']); 

        $sql = "SELECT id FROM user WHERE email = $email and phrase = $phrase";
        $result = mysql::select($sql);
        $count = count($result);

        if($count == 1) {
            $_SESSION['user_id'] = $result[0]["id"];
            header("location: ../bossy-cat");
        }else {
            
            $error = "Your email or matching phrase was incorrect. Please try again.";
        }
   }
?>
<html>
    <head>
        <title>Bossy cat | Login </title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1.0">
        <link type="text/css" rel="stylesheet" href="styles.css">
    </head>
    <body>
        <div class="login-wrapper">
            <div class="login-form">
                <div class="login-top">
                    <img src="images/cat-acc.png" alt="bossy-cat">
                </div>
                <div>
                    <form action = "" method = "post">
                        <input type= "email" name = "email" placeholder="your email.." required/><br /><br />
                        <input type="text" name="phrase" placeholder="matching phrase.." required/><br/><br />
                        <input type="submit" value = "Log in"/><br />
                    </form>
                    <div class="warning"> <?php echo $error; ?> </div>
                </div>
            </div>
        </div>
    </body>
</html>