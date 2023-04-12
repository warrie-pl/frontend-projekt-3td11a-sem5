<?php
    session_start();
    if(!isset($_SESSION['zalogowany'])) {
        header('Location: index.php');
        exit();
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
    <title>Wykładomania - strona główna</title>
    <style>
        .navbar-brand, .nav-link, body {
            color: white;
        }
        .fixed-center {
            position: fixed;
            left: 50%;
            transform: translate(-50%, 0);
            bottom: 4%;
        }
        .fixed-center>* {
            font-family:"Trebuchet MS";
        }
        body {
            background-image: url('images/bg2.png'); 
        }
        .nav-item>a,i {
            text-shadow: 2px 2px black;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <nav class="navbar navbar-expand-lg py-4">
            <div class="container-fluid">
                <div class="navbar-header">
                    <a href="index.php" class="navbar-brand"><img src="images/psk.png" alt="PŚk"></a>
                    <a href="index.php" class="navbar-brand" style="font-family:'Verdana';">Wykładomania</a>
                </div>
                <ul class="navbar-nav">
                    <li class="nav-item"><a href="wyklady.php" class="nav-link">Wykłady</a></li>
                    <li class="nav-item"><i class="nav-link">Witaj, <?php echo($_SESSION['username']); ?></i></li>
                    <li class="nav-item"><a href="user.php" class="nav-link">Mój profil</a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link">Wyloguj się</a></li>
                    <li class="nav-item"><button class="btn btn-primary" onclick="location.href='wyklady.php'">Kup bilet</button></li>
                </ul>
            </div>
        </nav>
        <div class="fixed-center">
            <h2 style="position:relative; left: 450px; bottom: 50px">Nazwa użytkownika: <?php if(isset($_SESSION['username'])) echo $_SESSION['username'];?></h2>
            <h3>Saldo: <?php if(isset($_SESSION['saldo'])) echo $_SESSION['saldo'];?> <img src="images/coin.png" alt="">
            <form action="addcoin.php" method="post">
                Ile dodać coinów?
                <input type="number" name="dodac" />
                <button type="submit">Dodaj</button>
            </form>
            <?php if(isset($_SESSION['nsaldokom'])) echo $_SESSION['nsaldokom'];?>
            <h3>Bilety:</h3>
            <ul>
                <?php
                $conn = @new mysqli('localhost', 'root', '', 'fontend');
                if($conn->connect_errno!=0) echo "Error: ".$conn->connect_errno;
                else {
                    $username = $_SESSION['username'];
                    $rez = $conn->query("SELECT event_name FROM events, powiaz, users WHERE events.id_event=powiaz.id_eventa AND users.id=powiaz.id_user AND users.username='$username'");
                    if($rez->num_rows>0) {
                        while($wiersz=$rez->fetch_assoc()) {
                            $event_name=$wiersz['event_name'];
                            echo("<li>$event_name</li>");
                        }
                    }
                }
                ?>
            </ul>
        </div>
        <footer class="mainfooter fixed-bottom">
            <p class="float-left">&copy; 2023 Wykładomania</p>
        </footer>
    </div>
</body>
</html>