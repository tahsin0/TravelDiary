<?php
    session_start();
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
    $role = $_SESSION['role'];
    if (!isset($id)) {
        header('Location: login.php');
    }

    require('config/db.php');
    $query = "SELECT * from pendings";
    $result = mysqli_query($conn, $query);
    $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
    
    $query = 'SELECT * FROM users';
    $result = mysqli_query($conn, $query);
    $users = mysqli_fetch_all($result, MYSQLI_ASSOC);
    mysqli_free_result($result);
?>
<!DOCTYPE html>
    
    <?php require('inc/navbar.php'); ?>

    <div style="padding-top: 94px;" class="container">
        <h1>Pending Posts</h1>

        <table>
            <tr>
                <th>Title</th>
                <th>User</th>
                <th>Actions</th>
            </tr>

            <?php foreach ($posts as $post): ?>
                <tr>
                    <td><?php echo $post['title']; ?></td>
                    <td>
                        <?php
                            foreach ($users as $user) {
                                 if ($user['id'] === $post['user_id']) {
                                     echo $user['name'];
                                 }
                             } 
                        ?>
                    </td>
                    <td> <a href="postdetails.php?postid=<?php echo $post['id']; ?>"><button type="button">Details</button>
                </tr>
            <?php endforeach ?>
        </table>
    </div>
</body>
</html>