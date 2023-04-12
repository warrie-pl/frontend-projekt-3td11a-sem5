<?php
    session_start();
    if ((!isset($_POST['username'])) || (!isset($_POST['haslo']))) {
        header('Location: index.php');
        exit();
    }
    $conn = @new mysqli('localhost', 'root', '', 'fontend');
    if($conn->connect_errno!=0) echo "Error: ".$conn->connect_errno;
    else {
        $username = htmlentities($_POST['username'], ENT_QUOTES, "UTF-8");
        $password = htmlentities($_POST['haslo'], ENT_QUOTES, "UTF-8");
        $pass_hash = password_hash($password, PASSWORD_DEFAULT);
        $query = "SELECT * FROM users WHERE username='$username'";
        $result = mysqli_query($conn, $query);
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);
            if (password_verify($password, $pass_hash)) {
                $_SESSION['zalogowany']=true;
                $_SESSION['username']=$username;
                $_SESSION['saldo'] = $row['saldo'];
                unset($_SESSION['blad']);
                header('Location: index2.php');
            } else {
                $_SESSION['blad'] = '<span style="color:red">Incorrect username or password!</span>';
                header('Location: logowanie.php');
            }
        } else {
            $_SESSION['blad'] = '<span style="color:red">Incorrect username or password!</span>';
            header('Location: logowanie.php');
        }
        $conn->close();
    }
?>