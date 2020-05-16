<?php
    session_start();
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
    $role = $_SESSION['role'];

    if (!isset($id) && $role != "user") {
        header('Location: login.php');
    }
?>
<!DOCTYPE html>

    <?php require('inc/navbar.php'); ?>

    <div style="cursor: pointer; padding-top: 80px;">
        <div style="margin: 16px; display: flex; justify-content: center;">
            <a href="pending.php">
                <i title="pending" class="fa fa-edit fa-4x" aria-hidden="true">Pending Posts</i>
            </a>
        </div>
    </div>

    <div style="cursor: pointer; padding-top: 54px;">
        <div style="margin: 16px; display: flex; justify-content: center;">
            <a href="userlist.php">
                <i title="users" class="fa fa-users fa-4x" aria-hidden="true">User List</i>
            </a>
        </div>
    </div>

    <?php if ($role === "admin"): ?>
        <div style="cursor: pointer; padding-top: 54px;">
        <div style="margin: 16px; display: flex; justify-content: center;">
            <a href="moderators.php">
                <i title="moderator" class="fa fa-shield fa-4x" aria-hidden="true">Moderators</i>
            </a>
        </div>
    </div>
    <?php endif ?>
</body>

</html>