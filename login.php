
<?php 
    require('./funktions.php');
    if(authenticated()){
        redirect('./panel.php');
    }
    if($_SERVER['REQUEST_METHOD'] == 'POST' and isset($_POST['email']) and isset($_POST['password'])){
        $errors = [];
        $email = $_POST['email'];
        $password = $_POST['password'];
        // 13 
        $errors = validate_login($email, $password);
        if(!count($errors)){
            $users = get_data('users');
            $user = login($users,$email,$password);
            if($user != null){
                $_SESSION['user'] = $user;
                redirect('./panel.php');
            }else{
                $errors[] = 'invalid credential';
            }
        }
    }

?>
<html>
    <head>
        <meta charset="UTF-8">
        <title>Login to SYSTEM</title>
        <link rel="stylesheet" href="<?= asset('css/login.css')?>">
    </head>
    <body>
        <main>
            <form method="post">
                <div class="login">
                    <h3>Login to System</h3>
                    <?php if(isset($errors) and count($errors)): ?>
                        <div class="errors">
                            <ul>
                                <?php foreach($errors as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach ?>   
                            </ul>
                        </div>
                    <?php endif ?>     
                    <div>
                        <label for="email">Email:</label>
                        <input type="text" id="email" name="email" value="<?= isset($email)? $email: '' ?>">
                    </div>
                    <div>
                        <label for="password">Password:</label>
                        <input type="test" id="password" name="password" value="<?= isset($password)? $password: '' ?>">
                    </div>
                    <div>
                        <input type="submit" value="login">
                    </div>
                    <div class="homing"><li><a href="<?= BASE_URL ?>website.php">Home</a></li></div>
                </div>
            </form>
        </main>
    </body>
</html>