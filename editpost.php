<?php
    session_start();
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
    $role = $_SESSION['role'];
    if (!isset($id)) {
        header('Location: login.php');
    }

    require('config/db.php');
    $postid = $_GET['postid'];
    $query = "SELECT * FROM posts WHERE id =".$postid;
    $result = mysqli_query($conn, $query);
    $post = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    $query = "SELECT * FROM users WHERE id =".$post['user_id'];
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if (isset($_POST['change'])) {
        $title = $_POST['title'];
        $details = $_POST['details'];

        $query = "UPDATE posts SET title='$title', details='$details' WHERE id = {$_POST['postid']}";
        if (mysqli_query($conn, $query)) {
            header('Location: myposts.php');
        } else {
            echo 'ERROR: '.mysqli_error($conn);
        }
    }
?>

<!DOCTYPE html>
   
    <?php require('inc/navbar.php'); ?>

    <div style="padding-top: 64px;" class="grid-container">

        <div style="width:590px; height: 300px;" class="item1">
            <img src="<?php echo $post['image']; ?>" alt="Avatar" style="width:100%">
        </div>
        <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>">
            <div style="overflow-y: scroll; width:590px; height: 280px;" class="item3">         
                <h3>Title: <input type="text" name="title" value="<?php echo $post['title']; ?>"></h3>
                <h4>Author: <?php echo $user['name']; ?></h4>
                <h4>Description:</h4>
                <p><textarea name="details" style="width:559px; height: 99px;"><?php echo $post['details']; ?></textarea></p>
            </div>

            <div style="width:590px; height: 250px; overflow-y: scroll;" class="item4">
                
                    <a href="myposts.php"><button type="button" style="height: 46px; width: 200px;">BACK</button></a>
                    <input style="height: 46px; width: 200px;" type="submit" value="CHANGE" name="change">
                    <input type="hidden"  name="postid" value="<?php echo $post['id']; ?>">           
            </div>
        </form>
    </div>
</body>

</html>