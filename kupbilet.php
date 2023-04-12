<?php
    session_start();
    if(!isset($_SESSION['zalogowany'])) {
        header('Location: logowanie.php');
        exit();
    } else {
        $conn = @new mysqli('localhost', 'root', '', 'fontend');
        if($conn->connect_errno) echo "Error: ".$conn->connect_errno;
        else {
            $query = "SELECT id_event, cena FROM events;";
            $username = $_SESSION['username'];
            $query2 = "SELECT id, saldo FROM users WHERE username='$username'";
            $result = $conn->query($query);
            $result2 = $conn->query($query2);
            if($result->num_rows>0) {
                while($row=$result->fetch_assoc()) {
                    $id = $row['id_event'];
                    if(isset($_POST['bilet'.$id])) {
                        $_SESSION['buy'.$id]=true;
                        if($result2->num_rows>0) {
                            while($row2=$result2->fetch_assoc()) {
                                $oldsaldo = $row2['saldo'];
                                $cena = $row['cena'];
                                $id_user = $row2['id'];
                                if($row2['saldo']>$row['cena']) {
                                    $nowesaldo = $oldsaldo - $cena;
                                    $conn->query("UPDATE users SET saldo = $nowesaldo WHERE username='$username'");
                                    $conn->query("INSERT INTO powiaz VALUES (NULL, $id_user, $id, CURDATE())");
                                    $_SESSION['saldo'] = $nowesaldo;
                                    unset($_SESSION['e_saldo']);
                                    header('Location: wyklady2.php');
                                } else {
                                    $_SESSION['e_saldo']='<div class="error" style="color: red">Za mało coinów aby zakupić bilet</div>';
                                    header('Location: wyklady2.php');
                                }
                            }
                        }
                    }
                }
            }
        }
        $conn->close();
    }
?>