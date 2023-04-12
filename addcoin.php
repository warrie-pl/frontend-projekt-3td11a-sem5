<?php
    session_start();
    if(isset($_SESSION['zalogowany'])) {
        if(isset($_POST['dodac'])) {
            $conn = @new mysqli('localhost', 'root', '', 'fontend');
        if ($conn->connect_errno != 0) echo "Error: " . $conn->connect_errno;
        else {
            if($rez=@$conn->query(
                sprintf("SELECT saldo FROM users WHERE username='%s'", 
                mysqli_real_escape_string($conn,$_SESSION['username'])))) {
                $wiersz = $rez->fetch_assoc();
                $nowesaldo = $wiersz['saldo'] + $_POST['dodac'];
                $username = $_SESSION['username'];
                if($rez=@$conn->query(sprintf("UPDATE users SET saldo=%d WHERE username='%s'", $nowesaldo, $_SESSION['username']))) {
                    $_SESSION['saldo'] = $nowesaldo;
                    $_SESSION['nsaldokom'] = '<span style="color:yellow;">Pomyślnie dodano do salda '.$_POST['dodac'].' coinów.</span>';
                } else {
                    echo "Błąd: " . $conn->error;
                }
                header('Location: user.php');
            }
            }
        $conn->close();
    }
    } else {
        header('Location: index.php');
        exit();
    }
?>