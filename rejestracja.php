<?php
    session_start();
    if(isset($_POST['newusername'])) {
        $allgood = true;
        $nick = $_POST['newusername'];
        if((strlen($nick)<3) || (strlen($nick)>20)) {
            $allgood = false;
            $_SESSION['e_nick'] = "Nick musi posiadać od 3 do 20 znaków!";
        }
        if(ctype_alnum($nick)==false) {
            $allgood = false;
            $_SESSION['e_nick'] = "Nick może składać się tylko z liter i cyfr (bez polskich znaków)!";
        }
        $haslo1 = $_POST['newhaslo1'];
        $haslo2 = $_POST['newhaslo2'];
        if((strlen($haslo1)<8) || (strlen($haslo1)>20)) {
            $allgood = false;
            $_SESSION['e_haslo'] = "Hasło musi posiadać od 8 do 20 znaków!";
        }else if($haslo1!=$haslo2) {
            $allgood = false;
            $_SESSION['e_haslo'] = "Podane hasła nie są identyczne!";
        }
        $haslo_hash = password_hash($haslo1, PASSWORD_DEFAULT);

        $_SESSION['fr_nick']=$nick;
        $_SESSION['fr_haslo1']=$haslo1;
        $_SESSION['fr_haslo2']=$haslo2;

        mysqli_report(MYSQLI_REPORT_STRICT);

        try {
            $conn = new mysqli("localhost", "root", "", "fontend");
            if($conn->connect_errno!=0) {
                throw new Exception(mysqli_connect_errno());
            } else {
                $rez = $conn->query("SELECT id FROM users WHERE username='$nick'");
                if(!$rez) throw new Exception($conn->error);
                if($rez->num_rows>0) {
                    $allgood=false;
                    $_SESSION['e_nick']="Istnieje już użytkownik o takim nicku! Wybierz inny.";
                }
                if($allgood==true) {
                    if($conn->query("INSERT INTO users VALUES (NULL, '$nick', '$haslo_hash', 69)")) {
                        $_SESSION['udanarejestracja']=true;
                        header('Location: logowanie.php');
                    } else {
                        throw new Exception($conn->error);
                    }
                }
            $conn->close();                
            }
        } catch(Exception $e) {
            echo('<span style="color: red;">Błąd serwera! Przepraszamy za utrudnienia');
            echo('<br>Informacja developerska: '.$e);
        }
    }
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge, chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="images/favi.png" type="image/png" sizes="32x32">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" 
        href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
        integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js"
        integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl"
        crossorigin="anonymous"></script>
    <link href="http://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet"
        type='text/css'>
    <title>Wykładomania - zarejestruj się</title>
    <style>
        .navbar-brand, .nav-link, body {
            color: white;
        }
        .fixed-center {
            position: fixed;
            left: 50%;
            transform: translate(-50%, 0);
            top: 30%;
        }
        body {
            background-color: #003;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg py-4" style="background-image: url('images/backgtrans.png');">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="index.php" class="navbar-brand"><img src="images/psk.png" alt="PŚk"></a>
                    <a href="index.php" class="navbar-brand" style="font-family:'Verdana';">Wykładomania</a>
                </div>
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="wyklady.php" class="nav-link">Wykłady</a></li>
                    <li class="nav-item"><button class="btn btn-primary"  onclick="location.href='logowanie.php'">Kup bilet</button></li>
                </ul>
            </div>
        </nav>
        <div class="fixed-center">
            <img src="images/grad.png" alt="" style="height: 100px; position:relative; left:30%">
            <h1 style="text-align: center;">Zarejestruj się</h1>
            <form method="post">
  <div class="form-outline mb-4">
    <input type="text" id="username" name="newusername" class="form-control" 
    value="<?php
    if(isset($_SESSION['fr_nick'])) {
        echo $_SESSION['fr_nick'];
        unset($_SESSION['fr_nick']);
    }    
    ?>"/>
    <label class="form-label" for="username">Username</label>
    <?php
    if(isset($_SESSION['e_nick'])) {
        echo "<p style='color: red'>".$_SESSION['e_nick']."</p>";
        unset($_SESSION['e_nick']);
    }
    ?>
  </div>
  <div class="form-outline mb-4">
    <input type="password" id="haslo" name="newhaslo1" class="form-control" 
    value="<?php
    if(isset($_SESSION['fr_haslo1'])) {
        echo $_SESSION['fr_haslo1'];
        unset($_SESSION['fr_haslo1']);
    }
    ?>"/>
    <label class="form-label" for="haslo">Password</label>
    <?php
    if(isset($_SESSION['e_haslo'])) {
        echo "<p style='color: red'>".$_SESSION['e_haslo']."</p>";
        unset($_SESSION['e_haslo']);
    }
    ?>
  </div>
  <div class="form-outline mb-4">
    <input type="password" id="haslo" name="newhaslo2" class="form-control" 
    value="<?php
    if(isset($_SESSION['fr_haslo2'])) {
        echo $_SESSION['fr_haslo2'];
        unset($_SESSION['fr_haslo2']);
    }
    ?>"/>
    <label class="form-label" for="haslo">Repeat password</label>
    <?php
    if(isset($_SESSION['e_haslo'])) {
        echo "<p style='color: red'>".$_SESSION['e_haslo']."</p>";
        unset($_SESSION['e_haslo']);
    }
    ?>
  </div>
  <button type="submit" class="btn btn-primary btn-block mb-4">Register</button>
</form>
        </div>
        <footer class="mainfooter fixed-bottom">
            <p class="float-left">&copy; 2023 Wykładomania</p>
        </footer>
    </div>
</body>
</html>