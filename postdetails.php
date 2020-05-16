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
    $query = "SELECT * FROM pendings WHERE id =".$postid;
    $result = mysqli_query($conn, $query);
    $post = mysqli_fetch_assoc($result);
    mysqli_free_result($result);

    $query = "SELECT * FROM users WHERE id =".$post['user_id'];
    $result = mysqli_query($conn, $query);
    $user = mysqli_fetch_assoc($result);

    if(isset($_POST['approve'])){

        $postid = $_POST['postid'];

        $postid = $_POST['postid'];
        $query = "SELECT * FROM pendings WHERE id =".$postid;
        $result = mysqli_query($conn, $query);
        $post = mysqli_fetch_assoc($result);
        mysqli_free_result($result);

        $title = $post['title'];
        $details = $post['details'];
        $image = $post['image'];
        $user_id = $post['user_id'];

        $query = "INSERT INTO posts (title, details, image, user_id) VALUES ('$title', '$details', '$image', '$user_id')";
        if (mysqli_query($conn, $query)) {
            $query = "DELETE FROM pendings WHERE id =".$postid;
            if (mysqli_query($conn, $query)) {
                $message = "Post uploaded.";
                echo "<script type='text/javascript'>
                        alert('$message')
                        window.location.replace('pending.php');
                    </script>";
                mysqli_close($conn);
            } else {
                echo 'ERROR: '.mysqli_error($conn);
            }
        } else {
            echo 'ERROR: '.mysqli_error($conn);
        }
    }

    if (isset($_POST['delete'])) {
        $postid = $_POST['postid'];
        $query = "DELETE FROM pendings WHERE id =".$postid;
        if (mysqli_query($conn, $query)) {
            $message = "Post deleted.";
            echo "<script type='text/javascript'>alert('$message');</script>";
            mysqli_close($conn);
            header('Location: pending.php');
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

        <div style="overflow-y: scroll; width:590px; height: 280px;" class="item3">
            <h3>Title: <?php echo $post['title']; ?></h3>
            <h4>Author: <?php echo $user['name']; ?></h4>
            <h4>Description:</h4>
            <p><?php echo $post['details']; ?></p>
        </div>

    <div style="width:590px; height: 250px; overflow-y: scroll;" class="item4">
        <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>">
            <input style="height: 46px; width: 200px;" type="submit" value="APPROVE" name="approve">
            <input style="height: 46px; width: 200px; background-color: #db6060;" type="submit" value="DELETE" name="delete">
            <input type="hidden"  name="postid" value="<?php echo $post['id']; ?>">
        </form>
    </div>

</body>

</html>