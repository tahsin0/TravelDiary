<?php
    session_start();
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
    $role = $_SESSION['role'];
    if (!isset($id)) {
        header('Location: login.php');
    }

    require('config/db.php');
    $query = 'SELECT * FROM admins WHERE role = "moderator"';
    $result = mysqli_query($conn, $query);
    $moderators = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    if (isset($_POST['delete'])) {
        $query = "DELETE FROM admins WHERE id =".$_POST['moderatorid'];
        if (mysqli_query($conn, $query)) {
            $query = 'SELECT * FROM admins WHERE role = "moderator"';
            $result = mysqli_query($conn, $query);
            $moderators = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_free_result($result);
        } else {
            echo 'ERROR: '.mysqli_error($conn);
        }
    }
?>
<!DOCTYPE html>
   
    <?php require('inc/navbar.php'); ?>
    
    <div style="padding-top: 94px;" class="container">
        <h1>Moderators</h1>

        <table>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>

            <?php foreach ($moderators as $moderator): ?>
                <tr>
                    <td><?php echo $moderator['name']; ?></td>
                    <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>">
                        <td><input type="submit" style="background-color: #db6060;" value="DELETE" name="delete"></td>
                        <input type="hidden"  name="moderatorid" value="<?php echo $moderator['id']; ?>">
                    </form>
                </tr>
            <?php endforeach ?>         
        </table>
        
        <div style="cursor: pointer; padding-top: 54px;">
            <div style="margin: 16px; display: flex; justify-content: center;">
              <a href="addmoderator.php">
                <i title="Add Moderators" class="fa fa-plus-circle fa-4x" aria-hidden="true"></i>
              </a>
            </div>
            <p style="margin: 16px; display: flex; justify-content: center;">ADD MODERATORS</p>
          </div>
    </div>
</body>

</html>