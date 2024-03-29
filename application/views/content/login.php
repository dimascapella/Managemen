<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="<?= base_url('assets/css/') ?>style_login.css">
</head>

<body>
    <div class="container">
        <div class="row align-items-center">
            <div class="col-sm-3"></div>
            <div class="col-sm-6">
                <div class="card">
                    <a href="<?= base_url() ?>"><i class="fas fa-arrow-left text-white text-20"></i></a>
                    <form action="<?= base_url('login/auth') ?>" method="POST">
                        <div class="form-group">
                            <div class="title">
                                <p>Login Admin</p>
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="input-container">
                                <i class="fa fa-user icon" aria-hidden="true"></i>
                                <input type="text" class="input-field" placeholder="username" name="username" value="<?php if (isset($_COOKIE["setUsername"])) {
                                                                                                                            echo $_COOKIE["setUsername"];
                                                                                                                        } ?>" autocomplete="off">
                            </div>
                            <div class="error"><?= form_error('username') ?></div>
                        </div>
                        <div class="form-group">
                            <div class="input-container">
                                <i class="fa fa-key icon" aria-hidden="true"></i>
                                <input type="password" class="input-field" placeholder="password" name="password" value="<?php if (isset($_COOKIE["setPassword"])) {
                                                                                                                                echo $_COOKIE["setPassword"];
                                                                                                                            } ?>" autocomplete="off">
                            </div>
                            <div class="error"><?= form_error('username') ?></div>
                        </div>
                        <div class="form-group">
                            <div class="row align-items-center remember">
                                <input type="checkbox" name="remember" <?php if (isset($_COOKIE["setUsername"])) { ?> checked="checked" <?php } ?>>Remember Me
                            </div>
                        </div>
                        <h4 class="text-danger text-center py-2"><?= @$error ?></h4>
                        <div class="form-group">
                            <input type="submit" value="Login" class="btn float-right login_btn">
                        </div>
                    </form>
                    <div class="form-group">
                        <p class="warning">login specifically for shop owner !</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-3"></div>
        </div>
    </div>
    <script src="<?= base_url('assets/js/') ?>javascript.js"></script>
</body>

</html>