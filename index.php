<?php
include('super_admin/include/configuration/init.php');
global $database;


if (isset($session->user['super_admin'])) {

    header('Location: super_admin');
}
if (isset($session->user['fac_admin'])) {

    header('Location: fac_admin');
}
if (isset($session->user['dept_admin'])) {
    header('Location: dept_admin');
}

$message_s = '';
$message_c = '';
$super_side = '';
$coo_side = '';
$super = '<?php echo $message_s;  ?>

<form class="form" action="" method="post">
    <label for="username" class="form-label">Username</label>
    <input class="form-control" type="text" name="username" id="username">
    <label for="password" class="form-label">Password</label>
    <input class="form-control" type="password" name="password" id="password"><br>
    <input class="btn btn-success form-control" type="submit" value="Login" name="super" id="">
</form>';
$coo_a = '
<form class="form" action="" method="post">
<label for="username2" class="form-label">Username</label>
<input class="form-control" type="text" name="username" id="username2">
<label for="password2" class="form-label">Password</label>
<input class="form-control" type="password" name="password" id="password2"><br>
<div class="text-center">
    <input class="btn btn-success form-control" type="submit" value="Login" name="coordinator" id="">

</div>
</form>';

function notification($type, $msg)
{

    $message = '<div class="alert alert-' . $type . ' alert-dismissible" role="alert">
   <button type="button" class="close" data-dismiss="alert" aria-label="Close">
       <span aria-hidden="true">&times;</span>
   </button>
   <div class="alert-icon">
       <i class="far fa-fw fa-bell"></i>
   </div>
   <div class="alert-message">
       ' . $msg . '
   </div>
   </div>';

    return $message;
}

if (isset($session->user)) {
    // print_r($session->user);
    // echo "<br>";

    // echo key_exists('dept_admin',$session->user);
}
// $admins = '';


if (isset($session->user['fac_admin']) && isset($session->user['dept_admin'])) {
    $coo_a = '';
}

if (isset($session->user['super_admin'])) {
    // echo "Super Admin Logged in<br>";
    $super = '<div class="alert-success card"><div class="card-body text-center">Super Admin Logged-In!<br>Press <a title="Super Admin" href="super_admin">Here</a> to go to the Dashboard or<br><a href="super_admin/include/logout.php">Logout</a></div></div>';
    $super_side = '<div style="background-color:rgba(50, 50, 50, 0.5); color:white" class=" card"><div class="card-body">Super Admin Logged-In! Press <a title="Super Admin" href="super_admin">Here</a> to go to the Dashboard or <a href="super_admin/include/logout.php">Logout</a></div></div>';
}
if (isset($session->user['fac_admin'])) {

    $coo_side .= $coo_a .= '<div class="alert-success card"><div class="card-body text-center">Faculty Coordinator Logged-In!<br>Press <a title="Faculty Admin" href="fac_admin">Here</a> to go to the Dashboard or<br><a href="fac_admin/include/logout.php">Logout</a></div></div>';
}
if (isset($session->user['dept_admin'])) {
    $coo_side .= $coo_a .= '<div class="alert-success card"><div class="card-body text-center">Department Coordinator Logged-In!<br>Press <a title="Department Admin" href="dept_admin">Here</a> to go to the Dashboard or<br><a href="dept_admin/include/logout.php">Logout</a></div></div>';
}

if (isset($_POST['super'])) {
    $super = Super::find_by_query("SELECT * FROM super_admin WHERE username='{$_POST['username']}' AND password='".$database->connection->real_escape_string($_POST['password'])."' LIMIT 1");

    if ($super) {
        $super = $super[0];

        $session->login($super);
        $session->message(notification('success', 'Super Admin Logged-in Successfuly'));
        // $message_s=notification('success','Super Admin Logged-in Successfuly');
        
        header('Location: super_admin');
    } else {

        // $message_s=notification('danger','invalid Login Cridentials');
        $session->message(notification('danger', 'invalid Login Cridentials'));
        header('Location: index.php');
    }
}
if (isset($_POST['coordinator'])) {
    $coo = Coordinator::find_by_query("SELECT * FROM coordinator WHERE username='{$_POST['username']}' AND password='".$database->connection->real_escape_string($_POST['password'])."' LIMIT 1");
    if ($coo) {
        $coo = $coo[0];
        $session->login($coo);
        $session->message(notification('success', 'Coordinator Logged-in Successfuly'));
       
        if (isset($session->user['fac_admin'])) {

            header('Location: fac_admin');
        }
        if (isset($session->user['dept_admin'])) {
            header('Location: dept_admin');
        }
    } else {

        $session->message(notification('danger', 'invalid Login Cridentials'));
        header('Location: index.php');
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <script src="super_admin/js/jquery-3.6.0.js"></script>
    <link rel="shortcut icon" href="super_admin/img/icons/icon-48x48.png" />

    <title>TTWizard - Login</title>
    <link href="super_admin/css/app.css" rel="stylesheet">
    <style>
        body {
            overflow: hidden;
            height: 100vh;
            font-size: 11px;
        }
        .super_login {
            display: none;
        }
        .wrapper {
            height: 100vh;
        }
        .footer {
            position: fixed;
            bottom: 0;
            width: 100%;
            background-color: rgba(0, 0, 0, .5) !important;
        }
    </style>
    <script>
        $(document).bind("ajaxSend", () => {

            $('.coo').fadeIn("slow")

        }).bind("ajaxComplete", () => {

            $('.coo').fadeOut("slow")

        })

        $(window).on('load', function() {

            $('.coo').fadeOut("slow")

        })
        $(document).ready(function() {
            $('#super').click(function() {
                $('.super_login').slideToggle()
                $('.coo_login').slideToggle()
            })
        })
    </script>
</head>

<body>
    <?php include('super_admin/include/components/loading.php'); ?>

    <div class="wrapper">
        <main class="content" style="padding-top: 0px;">
            <div class="container-fluid p-0">

                <div class="row p-2">
                    <span class="align-middle text-light"><img style="width: 10em;" src="super_admin/img\icons\logo.png" alt="TTWizard"> TTWizard</span>
                </div>
                <div class="row">
                    <div class="col-xl-3 col-xl-3">
                        <div style="background-color:rgba(0, 0, 0, 0.2)" class="card">
                            <div style="background-color:rgba(0, 0, 0, 0.2)" class="card-header">
                                Notification
                            </div>
                            <div style="background-color:rgba(0, 0, 0, 0.2)" class="card-body">
                                <?php echo $super_side ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-6 col-xl-6">
                        <div class="card">
                            <div class="card-header">
                                <h5 class="card-title">ADMINISTRATIVE's LOGIN</h5>
                                <div class="mb-3">



                                </div>
                            </div>
                            <div class="card-body">
                                <div class="super_login">
                                    <h4 class="text-muted text-center">Super Admin (ETTC)</h4>
                                    <?php
                                    echo $session->message;
                                    echo $super; ?>


                                </div>
                                <div class="coo_login">
                                    <h4 class="text-muted text-center">Time-Table Coordinator
                                        (Faculty/Department)</h4>
                                    <?php echo $session->message  ?>
                                    <?php echo $coo_a ?>



                                </div>

                            </div>
                            <div class="card-footer">
                                <div class="text-right">
                                    <button class="btn text-primary" id="super">Admins</button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <footer class="footer">
        <div class="container-fluid">
            <div class="row text-muted">
                <div class="col-6 text-left">
                    <p class="mb-0">
                        <a href="index.php" class="text-muted"><strong>MagerPink12</strong></a> ©
                    </p>
                </div>
                <div class="col-6 text-right">
                    <ul class="list-inline">
                        <li class="list-inline-item">
                            <a class="text-muted" href="#">Support</a>
                        </li>
                        <li class="list-inline-item">
                            <a class="text-muted" href="#">Help Center</a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>




</body>

</html>