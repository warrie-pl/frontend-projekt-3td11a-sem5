<?php
    session_start();
    if(!isset($_SESSION['zalogowany'])) {
        header('Location: wyklady.php');
        exit();
    }

    $conn = @new mysqli('localhost', 'root', '', 'fontend');
    if($conn->connect_errno!=0) echo "Error: ".$conn->connect_errno;
    else {
        $rez = $conn->query("SELECT * FROM events;");
        $username = $_SESSION['username'];
        $rez2 = $conn->query("SELECT COUNT(*) FROM powiaz,users WHERE users.id=powiaz.id_user AND users.username='$username';");
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
    <title>Wykładomania - wykłady</title>
    <style>
        .navbar-brand, .nav-link, body {
            color: white;
        }
        .fixed-center {
            position: fixed;
            left: 50%;
            transform: translate(-50%, 0);
            top: 50%;
        }
        body {
            background-color: #000033;
        }
        .event-img > img{
            width: 150px;
            height: 180px;
        }
        <?php 
           if($rez2->num_rows>0)
                {
                    while($rz=$rez2->fetch_assoc()) {
                        echo ("#bilet".$rz['id_eventa']." {
                            display: none;
                        }");
                    }
                }
        ?>
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
                    <li class="nav-item"><a href="#" class="nav-link">Wykłady</a></li>
                    <li class="nav-item"><i class="nav-link">Witaj, <?php echo($_SESSION['username']); ?></i></li>
                    <li class="nav-item"><a href="user.php" class="nav-link">Mój profil</a></li>
                    <li class="nav-item"><a href="logout.php" class="nav-link">Wyloguj się</a></li>
                    <li class="nav-item"><button class="btn btn-primary" onclick="location.href='wyklady.php'">Kup bilet</button></li>
                </ul>
            </div>
        </nav>
        <div>
            <div class="event-schedule-area-two bg-color pad100">
    <div class="container">
        <?php if(isset($_SESSION['e_saldo'])) echo($_SESSION['e_saldo']); ?>
        <div class="row">
            <div class="col-lg-12">
                <div class="section-title text-center">
                    <div class="title-text">
                        <h2>Wykłady</h2>
                    </div>
                    <p>
                        Na tej stronie można znaleźć listę obecnie oferowanych wykładów.
                    </p>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade active show" id="home" role="tabpanel">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th class="text-center" scope="col">Data</th>
                                        <th scope="col">Wykładowca</th>
                                        <th scope="col">Nazwa oraz opis wykładu</th>
                                        <th scope="col">Miejsce odbycia</th>
                                        <th scope="col">Cena</th>
                                        <th class="text-center" scope="col">Zakup</th>
                                    </tr>
                                </thead>
                                <?php 
                                    if($rez->num_rows>0) {
                                        while($wiersz=$rez->fetch_assoc()) {
                                            $id = $wiersz['id_event'];
                                            $data = $wiersz['data'];
                                            $obraz = $wiersz['portret'];
                                            $event_name = $wiersz['event_name'];
                                            $event_host = $wiersz['event_host'];
                                            $event_host_deg = $wiersz['event_host_deg'];
                                            $event_cat = $wiersz['event_cat'];
                                            $time_from = $wiersz['time_from'];
                                            $time_until = $wiersz['time_until'];
                                            $event_desc = $wiersz['event_desc'];
                                            $event_venue = $wiersz['event_venue'];
                                            $cena = $wiersz['cena'];
                                            echo(
                                                    "<tbody>
                                            <tr class='inner-box'>
                                                <th scope='row'>
                                                    <div class='event-date'>
                                                        <span>$data</span>
                                                    </div>
                                                </th>
                                                <td>
                                                    <div class='event-img'>
                                                        <img src='data:image/jpeg;base64,".base64_encode($obraz)."' alt='' />
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class='event-wrap'>
                                                        <h3><a href='#'>$event_name</a></h3>
                                                        <div class='meta'>
                                                            <div class='organizers'>
                                                                <a href='#'>$event_host, $event_host_deg</a>
                                                            </div>
                                                            <div class='categories'>
                                                                <a href='#'>$event_cat</a>
                                                            </div>
                                                            <div class='time'>
                                                                <span>$time_from - $time_until</span>
                                                            </div>
                                                            <div class='desc'><span>$event_desc</span></div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class='r-no'>
                                                        <span>$event_venue</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class='r-no'>
                                                        <span>$cena &cent;</span>
                                                    </div>
                                                </td>
                                                <td>
                                                    <div class='primary-btn' id='bilet".$id."'>
                                                        <form method='post' action='kupbilet.php'>
                                                            <button class='btn btn-primary' type='submit' name='bilet".$id."' id='bilet".$id."'>Kup bilet</button>
                                                        </form>
                                                    </div>
                                                    <div id='bought".$id."'></div>
                                                </td>
                                            </tr>
                                        </tbody>"
                                            );
                                        }
                                    }
                                ?>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
        </div>
        <footer class="mainfooter fixed-bottom">
            <p class="float-left">&copy; 2023 Wykładomania</p>
        </footer>
    </div>
</body>
</html>