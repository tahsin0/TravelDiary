<?php
    session_start();
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
    $role = $_SESSION['role'];
    if (!isset($id)) {
        header('Location: login.php');
    }

    require('config/db.php');
    if (isset($_GET['postid'])) {
        $postid = $_GET['postid'];
        $query = "SELECT * FROM posts WHERE id =".$postid;
        $result = mysqli_query($conn, $query);
        $post = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        $query = "SELECT * FROM users WHERE id =".$post['user_id'];
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);

        $query = "SELECT * FROM comments WHERE post_id =".$postid;
        $result = mysqli_query($conn, $query);
        $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
    }

    if (isset($_POST['submit'])) {
        $postid = $_POST['postid'];
        $query = "SELECT * FROM posts WHERE id =".$postid;
        $result = mysqli_query($conn, $query);
        $post = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        $query = "SELECT * FROM users WHERE id =".$post['user_id'];
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);

        $details = $_POST['comment'];
        $user_id = $id;
        $post_id = $_POST['postid'];
        $query = "INSERT INTO comments (details, user_id, post_id) VALUES ('$details', '$user_id', '$post_id')";
        if (strlen($details) > 0) {
            mysqli_query($conn, $query);
        }

        $query = "SELECT * FROM comments WHERE post_id =".$postid;
        $result = mysqli_query($conn, $query);
        $comments = mysqli_fetch_all($result, MYSQLI_ASSOC);
        mysqli_free_result($result);
    }
?>
<!DOCTYPE html>
  
    <?php require('inc/navbar.php'); ?>

    <div style="padding-top: 64px;" class="grid-container">

        <div style="width:590px; height: 300px;" class="item1">
            <img src="<?php echo $post['image']; ?>" alt="Avatar" style="width:100%">
        </div>

        <div style="overflow-y: scroll; width:590px; height: 280px;" class="item3">
            <h3>Title: <?php echo $post['title']; ?></h3>
            <h4>Author: <?php echo $user['name']; ?></h4>
            <small>Date: <?php echo $post['created_on']; ?></small>
            <h4>Description:</h4>
            <p><?php echo $post['details']; ?></p>
        </div>

        <div style="width:590px; height: 250px; overflow-y: scroll;" class="item4">
            <div style="display: flex; flex-direction: row;">
                <h4>Comments: </h4>
                <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>">
                    <textarea rows="5" id="body" name='comment' style="resize : none; width: 360px;"></textarea>
                    <input type="hidden"  name="postid" value="<?php echo $post['id']; ?>">
                    <input style="height: 46px; width: 360px;" type="submit" value="submit" name="submit">
                </form>
            </div>

            <?php if ((array) $comments): ?>
                <?php foreach ($comments as $comment): ?>
                    <div>
                        <p>
                            <?php 
                                $query = "SELECT * FROM users WHERE id =".$comment['user_id'];
                                $result = mysqli_query($conn, $query);
                                $user = mysqli_fetch_assoc($result);
                                mysqli_free_result($result);
                                echo $user['name'];
                            ?>: <?php echo $comment['details']; ?>
                        </p>
                    </div>
                <?php endforeach ?>
            <?php endif ?>
        </div>
    </div>
</body>

</html>