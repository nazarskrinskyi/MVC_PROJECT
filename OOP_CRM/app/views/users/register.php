<?php

$title = "Register";
ob_start();
?>
    <div class="row justify-content-center mt-4">
        <?php if (isset($_SESSION['err_msg'])): ?>
            <div class="p-2 error_display">
                <i class="fa-solid fa-shield-halved" style="color: #000000;font-size: x-large"></i><strong style="font-size: x-large"><?= $_SESSION['err_msg']?></strong><i class="fa-solid fa-shield-halved" style="color: #000000;font-size: x-large"></i>
            </div>
        <?php endif; unset($_SESSION['err_msg'])?>
        <div class="col-lg-6 col-md-8 col-sm-10">
            <h1 class="text-center mb-4">Register</h1>
            <form method="post" action="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/auth/store">
                <div class="mb-3">
                    <label for="login" class="form-label">Username</label>
                    <input placeholder="UserName..." type="text" id="login" class="form-control" name="username"
                           required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">UserEmail</label>
                    <input placeholder="UserEmail..." type="text" id="email" class="form-control" name="email"
                           required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" placeholder="Password..." type="password" class="form-control"
                           name="password" required>
                </div>

                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <input id="confirmPassword" placeholder="Password Verify..." type="password"
                           class="form-control" name="passwordVerify"
                           required>
                </div>
                <div class="text-center">
                    <button type="submit" class="btn btn-primary mt-1 col-md-3">Register</button>
                </div>
            </form>

            <div class="text-center mt-3">
                Have account already? <a href="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/auth/login"><?=htmlspecialchars('Login here')?></a>
            </div>
        </div>
    </div>
<?php
$content = ob_get_clean();

include "app/views/layout.php";
