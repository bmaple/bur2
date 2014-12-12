<?php
require_once('User.php');
session_start();
$user = new User();
if(isset($_POST['submit'])){
    print $user->login();
    if($user->login()){
        $_SESSION['user'] = serialize($user);
        header("location:files.php");
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bureaucrat File Management</title>

    <!-- Bootstrap Core CSS -->
    <link href="theme/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="theme/css/sb-admin.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="theme/font-awesome-4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

    <div class="col-lg-2">
    </div>
    <div class="col-lg-8">
        <div id="page-wrapper">

            <div class="container-fluid">

                <div class="row">
                    <div class="col-lg-12">


                        <h1>Bureaucrat Login</h1>

                        <form id ='login' action='index.php' method='post' accept-charset='UTF-8'>
                            <label for="username">Username: </label>
                            <input type='text' class="form-control" name='username' id='username' maxlength='20' /> <br />
                            <label for="password">Password: </label>
                            <input type='password' class="form-control" name='password' id='password' maxlength='20' /> <br />
                            <input type='submit' name='submit' id='submit'value="Login" />
                            <a href='register.php'>Sign up</a>
                        </form>

                    </div>
                    <div class="col-lg-3">
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

    </div>
    <!-- /#wrapper -->
    <div class="col-lg-2">
    </div>

    <!-- jQuery -->
    <script src="theme/js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="theme/js/bootstrap.min.js"></script>

</body>
</html>
