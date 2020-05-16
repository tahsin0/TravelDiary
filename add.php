<?php
    session_start();
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];

    $title = "";
    $details = "";
    $image = "";
    $errTitle = "";
    $errDetails = "";
    $errImage = "";

    if (!isset($id)) {
        header('Location: login.php');
    }

    if (isset($_POST['submit'])) {
        if (empty($_POST['title'])) {
          $errTitle="Title Required";
        } else {
          $title=$_POST['title'];
        }

        if (empty($_POST['details'])) {
          $errDetails="Details Required";
        } else {
          $details=$_POST['details'];
        }

        if (empty($_FILES['image']['name'])) {
          $errImage="Image Required";
        } else {
          $image=$_FILES['image']['name'];
        }

        if ($title != NULL && strlen($title) > 0 && $details != NULL && strlen($details) > 0 && $image != NULL && strlen($image) > 0 ) {

            require('config/db.php');

            $fileNameExt = $_FILES['image']['name'];
            $fileTmpName = $_FILES['image']['tmp_name'];
            $fileSize = $_FILES['image']['size'];
            $fileError = $_FILES['image']['error'];
            
            $fileDetails = explode('.', $fileNameExt);
            $fileName = $fileDetails[0];
            $fileExt = strtolower($fileDetails[1]);
            $fileDestination = "";

            $allowed = array('jpg', 'jpeg', 'png');

            if ($fileError === 0) {
                if (in_array($fileExt, $allowed)) {
                    if($fileSize <= 100000000000000) {
                        $fileNameNew = $fileName.time().".".$fileExt;
                        $fileDestination = "images/".$fileNameNew;
                        move_uploaded_file($fileTmpName, $fileDestination);
                    } else {
                        $errImage =  "Image size cannot be over 10mb.";
                    }
                } else {
                    $errImage = "File type not supported.";
                }
            } else {
                $errImage = "There is an error try again.";
            }

            $query = "INSERT INTO pendings (title, details, image, user_id) VALUES ('$title', '$details', '$fileDestination', '$id')";
            if (mysqli_query($conn, $query)) {
                $message = "Post uploaded for approval.";
                echo "<script type='text/javascript'>
                        alert('$message')
                        window.location.replace('index.php');
                    </script>";
                mysqli_close($conn);
            } else {
                echo 'ERROR: '.mysqli_error($conn);
            }
        }
    }
?>

<!DOCTYPE html>
   
    <?php require('inc/navbar.php'); ?>

    <div style="display: flex; justify-content: center; padding-top: 94px;">
        <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>" enctype="multipart/form-data">

            <label style="align-items: center;" for="fname">Blog Title:</label><br>
            <input style="width: 360px; height: 40px;" type="text" id="title" name="title" value="<?php echo $title; ?>" ><br><span style="color:red"><?php echo $errTitle;?></span><br>
            <label for="lname">Description:</label><br>
            <textarea rows="20" id="body" name='details' style="resize : none; width: 360px;"><?php echo $details; ?></textarea><br><span style="color:red"><?php echo $errDetails;?></span><br>
            <label for="fname">Upload Image:</label><br>
            <input type="file" id="image" name="image" value="<?php echo $image; ?>"><br><span style="color:red"><?php echo $errImage;?></span><br>
            <input style="height: 46px; width: 360px;" type="submit" value="submit" name="submit">

        </form>
    </div>
</body>

</html>