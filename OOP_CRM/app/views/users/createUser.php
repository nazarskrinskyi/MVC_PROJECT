<?php

$title = "User Creation";
ob_start();
?>
    <h1 class="text-center mb-4">Create User</h1>
    <div class="row justify-content-center mt-4">
        <?php if (isset($_SESSION['err_msg'])): ?>
            <div class="p-2 error_display mb-3">
                <i class="fa-solid fa-shield-halved" style="color: #000000;font-size: x-large"></i><strong style="font-size: x-large"><?= $_SESSION['err_msg']?></strong><i class="fa-solid fa-shield-halved" style="color: #000000;font-size: x-large"></i>
            </div>
        <?php endif; unset($_SESSION['err_msg'])?>
        <div class="col-lg-6 col-md-8 col-sm-10">
            <form method="post" action="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/users/store">
                <div class="mb-3">
                    <label for="login" class="form-label">Username</label>
                    <input placeholder="UserName..." type="text" id="login" class="form-control" name="username"
                           autocomplete="on" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">UserEmail</label>
                    <input placeholder="UserEmail..." type="email" id="email" class="form-control" name="email"
                           autocomplete="on" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" placeholder="Password..." type="password" class="form-control" name="password"
                           autocomplete="on" required>
                </div>

                <div class="mb-3">
                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                    <input id="confirmPassword" placeholder="Password Verify..." type="password" class="form-control"
                           autocomplete="on" name="passwordVerify"
                           required>
                </div>

                <button type="submit" class="btn btn-primary mt-2">Create</button>
            </form>
        </div>
    </div>
<?php
$content = ob_get_clean();

include "app/views/layout.php";
