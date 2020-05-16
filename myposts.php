<?php
    require('config/db.php');

    session_start();
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
    if (!isset($id)) {
    header('Location: login.php');
    }

    $query = "SELECT * FROM posts WHERE user_id = '$id' ORDER BY created_on DESC";
    $result = mysqli_query($conn, $query);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);

    if (isset($_POST['delete'])) {
        $query = "DELETE FROM posts WHERE id =".$_POST['postid'];
        if (mysqli_query($conn, $query)) {
            $query = "SELECT * FROM posts WHERE user_id = '$id' ORDER BY created_on DESC";
            $result = mysqli_query($conn, $query);
            $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
            mysqli_free_result($result);
            mysqli_close($conn);
        } else {
            echo 'ERROR: '.mysqli_error($conn);
        }
    }
?>
<!DOCTYPE html>

  <?php require('inc/navbar.php'); ?>


    <div style="padding-top: 94px;" class="container">
        <h1>My Posts</h1>

        <table>
            <tr>
                <th>Title</th>
                <th>Date</th>
                <th>Actions</th>
            </tr>
            <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>">
                <?php foreach ($posts as $post): ?>
                    <tr>
                        <td><?php echo $post['title']; ?></td>
                        <td><?php echo $post['created_on']; ?></td>
                        <td> <a href="editpost.php?postid=<?php echo $post['id']; ?>"><button type="button">EDIT</button></a>
                        <input type="submit" style="background-color: #db6060;" value="DELETE" name="delete"></td>
                        <input type="hidden"  name="postid" value="<?php echo $post['id']; ?>">
                    </tr>
                <?php endforeach ?>
            </form>
        </table>
    </div>

</body>

</html>