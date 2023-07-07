<?php


$title = "Edit User";
ob_start();
?>
    <h1 class="text-center mb-4">Edit User</h1>
    <div class="row justify-content-center mt-4">
        <?php if (isset($_SESSION['err_msg'])): ?>
            <div class="p-2 error_display">
                <i class="fa-solid fa-shield-halved" style="color: #000000;font-size: x-large"></i><strong style="font-size: x-large"><?= $_SESSION['err_msg']?></strong><i class="fa-solid fa-shield-halved" style="color: #000000;font-size: x-large"></i>
            </div>
        <?php endif; unset($_SESSION['err_msg'])?>
        <div class="col-lg-6 col-md-8 col-sm-10">
            <form method="post" action="/<?= filter_var(APP_BASE_PATH, FILTER_SANITIZE_URL) ?>/users/update/<?= $_GET['id'] ?>">
                <div class="mb-3">
                    <label for="login" class="form-label">UserName</label>
                    <input value="<?= $user['username'] ?>" placeholder="UserName..." type="text" id="login"
                           autocomplete="on" class="form-control" name="username" required>
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">UserEmail</label>
                    <input value="<?= $user['email'] ?>" placeholder="UserEmail..." type="email" id="email"
                           autocomplete="on" class="form-control" name="email" required>
                </div>

                <div class="mb-3">
                    <label for="role" class="form-label">UserRole</label>
                    <select class="form-control" id="role" name="role">
                        <?php foreach ($roles as $key => $role): ?>
                            <option value="<?= $role['id'] ?>" <?php
                            echo $user['role'] == $role['id'] ? 'selected' : '' ?>><?= $role['role_name'] ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary">Edit</button>
            </form>
        </div>
    </div>
<?php
$content = ob_get_clean();

include "app/views/layout.php";
