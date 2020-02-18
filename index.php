<!DOCTYPE HTML>
<?php 
    include 'web.php';
?>
<html>  
    <head>
        <link rel="stylesheet" type="text/css" href="style/style.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <script  type="text/javascript"  src="js/general.js"></script>
    </head>
    <body>
        <div class="container">
            <div class="row">
                <div class="col-2"></div>
                <div class="col-8">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-box">
                                <h4>Login Here</h4>
                                <form action="login.php" method="post">
                                    <div class="form-block"> 
                                        <div class="form-row">
                                            <label for="uname"><b>Username</b></label>
                                            <input type="text" placeholder="Username" name="uname" required>
                                        </div>
                                        <div class="form-row">
                                            <label for="uname"><b>Password</b></label>
                                            <input type="password" placeholder="Password" name="psw" required>
                                        </div>
                                        <div class="button-row">
                                            <button type="submit">Login</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>  
                        <div class="col-6">
                            <div class="form-box">
                                <h4>Sign Up Here</h4>
                                <form action="register.php" method="post">
                                    <div class="form-block"> 
                                        <div class="form-row">
                                            <label for="uname"><b>Username</b></label>
                                            <input type="text" placeholder="Username" name="uname" required>
                                        </div>
                                        <div class="form-row">
                                            <label for="uname"><b>Password</b></label>
                                            <input type="password" id="password" placeholder="Password" name="psw" required>
                                        </div>
                                        <div class="form-row">
                                            <label for="uname"><b>Confirm Password</b></label>
                                            <input type="password" id="confirm_password" placeholder="Confirm Password" name="conf_psw" onchange="check_pass();">
                                        </div>
                                        <div class="button-row">
                                            <button id="submit" type="submit">Register</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-2"></div>
            </div>
        </div>
    </body>
</html>
