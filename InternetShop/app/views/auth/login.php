<?php

$title = "Login";
ob_start();
?>
<?php if (isset($_SESSION['err_msg'])): ?>
    <div class="error_display mb-3">
        <i class="fa-solid fa-shield-halved" style="color: #000000;font-size: x-large"></i>
        <strong style="font-size: x-large"><?= $_SESSION['err_msg'] ?></strong>
        <i class="fa-solid fa-shield-halved" style="color: #000000;font-size: x-large"></i>
    </div>
<?php endif;
unset($_SESSION['err_msg']) ?>
    <div class="row justify-content-center mt-4 mb-3">
        <div class="col-lg-6 col-md-8 col-sm-10">
            <h1 class="text-center mb-4">Authorization</h1>
            <form method="post" action="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/auth/authenticate/">
                <div class="mb-3">
                    <label for="email" class="form-label">UserEmail</label>
                    <input placeholder="UserEmail..." type="text" id="email" class="form-control" name="email"
                           autocomplete="on" required>
                </div>

                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input id="password" placeholder="Password..." type="password" class="form-control"
                           name="password" required>
                </div>

                <div>
                    <input type="checkbox" name="remember" id="remember" class="form-check-input">
                    <label class="form-check-label" for="remember">Remember Me</label>
                </div>

                <div class="text-center">
                    <button type="submit" class="btn btn-primary mt-1 col-md-3">Login</button>
                </div>

            </form>
            <div class="text-center mt-3">
                Don`t have an account? <a href="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/auth/register/"><?=htmlspecialchars('Register here')?></a>
            </div>
        </div>
    </div>
    <script type="text/javascript" src="../../js/sidebarCollapse.js"></script>
<?php
$content = ob_get_clean();

include "app/views/layout.php";

