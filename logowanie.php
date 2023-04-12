<?php
    session_start();
    if(isset($_SESSION['zalogowany']) && ($_SESSION['zalogowany'] == true)) {
        header('Location: index2.php');
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
    <title>Wykładomania - zaloguj się</title>
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
            <h1 style="text-align: center;">Zaloguj się</h1>
            <form action="zaloguj.php" method="post">
  <div class="form-outline mb-4">
    <input type="text" id="username" name="username" class="form-control" />
    <label class="form-label" for="username">Username</label>
  </div>
  <div class="form-outline mb-4">
    <input type="password" id="haslo" name="haslo" class="form-control" />
    <label class="form-label" for="haslo">Password</label>
  </div>
  <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>
  <?php if(isset($_SESSION['blad'])) echo $_SESSION['blad'];?>
  <div class="text-center">
  </form>
    <p>Not a member? <a href="rejestracja.php">Register</a></p>
  </div>
  <?php if(isset($_SESSION['udanarejestracja'])) echo "<p>Rejestracja przebiegła pomyślnie! Zaloguj się za pomocą nowego konta</p>";?>
        </div>
        <footer class="mainfooter fixed-bottom">
            <p class="float-left">&copy; 2023 Wykładomania</p>
        </footer>
    </div>
</body>
</html>