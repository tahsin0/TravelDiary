<?php
    session_start();
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
    $role = $_SESSION['role'];
    if (!isset($id)) {
        header('Location: login.php');
    }

    require('config/db.php');
    $query = 'SELECT * FROM users';
    $result = mysqli_query($conn, $query);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    if (isset($_POST['block'])) {
        $query = "UPDATE users SET status = 0 WHERE id = {$_POST['userid']}";
        if (mysqli_query($conn, $query)) {
            $query = 'SELECT * FROM users';
            $result = mysqli_query($conn, $query);
            $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_free_result($result);
        } else {
            echo 'ERROR: '.mysqli_error($conn);
        }
    }

    if (isset($_POST['unblock'])) {
        $query = "UPDATE users SET status = 1 WHERE id = {$_POST['userid']}";
        if (mysqli_query($conn, $query)) {
            $query = 'SELECT * FROM users';
            $result = mysqli_query($conn, $query);
            $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_free_result($result);
        } else {
            echo 'ERROR: '.mysqli_error($conn);
        }
    }
?>
<!DOCTYPE html>

    <?php require('inc/navbar.php'); ?>

    <div style="padding-top: 94px;" class="container">
        <h1>USER INFO</h1>

        <table>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo $user['name']; ?></td>
                    <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>">
                        <?php if ($user['status'] == 1): ?>
                            <td><input type="submit" value="Block" name="block"></td>
                            <input type="hidden"  name="userid" value="<?php echo $user['id']; ?>">
                        <?php else: ?>
                            <td><input type="submit" value="Unblock" name="unblock"></td>
                            <input type="hidden"  name="userid" value="<?php echo $user['id']; ?>">
                        <?php endif ?>   
                    </form>                                 
                </tr>
            <?php endforeach ?>         
        </table>
    </div>
</body>
</html>