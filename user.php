<?php
    session_start();
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
    $role = $_SESSION['role'];

    if (!isset($id)) {
        header('Location: login.php');
    }

    if ($role == "user") {
        require('config/db.php');
        $query = "SELECT * FROM users WHERE id =".$id;
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
    } else {
        require('config/db.php');
        $query = "SELECT * FROM admins WHERE id =".$id;
        $result = mysqli_query($conn, $query);
        $user = mysqli_fetch_assoc($result);
        mysqli_free_result($result);
    }

    $updateName = '';
    $email = '';
    $password = '';

    $errName = '';
    $errEmail = '';
    $errPassword = '';

    if (isset($_POST['change']) && $role == "user") {
        if (strlen($_POST['password']) == 0 && strlen($_POST['confirmPassword']) == 0) {
            $filters = array(
                'name' => array(
                    'filter' => FILTER_SANITIZE_STRING,
                    'options' => array(
                        'default' => NULL
                    )
                ),
                'email' => array(
                    'filter' => FILTER_VALIDATE_EMAIL,
                    'options' => array(
                        'default' => NULL
                    )
                )
            );

            $filteredArr = filter_input_array(INPUT_POST, $filters);

            (isset($filteredArr['name'])) ? ((strlen($filteredArr['name']) > 0 ) ? ($updateName = $filteredArr['name']) : $errName = "Name Required") : $errName = "Name Required" ;
            (isset($filteredArr['email'])) ? ($email = $filteredArr['email']) : $errEmail = "Valid Email Required" ;

            if ($updateName != NULL && $email != NULL) {
                $query = "UPDATE users SET name='$updateName', email='$email' WHERE id = {$id}";
                if (mysqli_query($conn, $query)) {
                    $_SESSION['name'] = $updateName;
                    header('Location: index.php');
                } else {
                    echo 'ERROR: '.mysqli_error($conn);
                }
            }
        } else if (strlen($_POST['password']) > 0 && strlen($_POST['confirmPassword']) > 0 && ($_POST['password'] === $_POST['confirmPassword'])) {
                $filters = array(
                    'name' => array(
                        'filter' => FILTER_SANITIZE_STRING,
                        'options' => array(
                            'default' => NULL
                        )
                    ),
                    'email' => array(
                        'filter' => FILTER_VALIDATE_EMAIL,
                        'options' => array(
                            'default' => NULL
                        )
                    ),
                    'password' => array(
                        'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
                        'options' => array(
                            'default' => NULL
                        )
                    )
                );

                $filteredArr = filter_input_array(INPUT_POST, $filters);

                (isset($filteredArr['name'])) ? ((strlen($filteredArr['name']) > 0 ) ? ($updateName = $filteredArr['name']) : $errName = "Name Required") : $errName = "Name Required" ;
                (isset($filteredArr['email'])) ? ($email = $filteredArr['email']) : $errEmail = "Valid Email Required" ;
                (isset($filteredArr['password'])) ? ((strlen($filteredArr['password']) > 0 ) ? ($password = $filteredArr['password']) : $errPassword = "Password Required") : $errPassword = "Password Required" ;

                if ($updateName != NULL && $email != NULL && $password != NULL) {
                    $query = "UPDATE users SET name='$updateName', email='$email', password='$password' WHERE id = {$id}";
                    if (mysqli_query($conn, $query)) {
                        $_SESSION['name'] = $updateName;
                        header('Location: index.php');
                    } else {
                        echo 'ERROR: '.mysqli_error($conn);
                    }
                }
            } else {
                $errPassword = "Passwords do not match";
        }
    }

    if (isset($_POST['change']) && $role != "user") {
        if (strlen($_POST['password']) == 0 && strlen($_POST['confirmPassword']) == 0) {
            $filters = array(
                'name' => array(
                    'filter' => FILTER_SANITIZE_STRING,
                    'options' => array(
                        'default' => NULL
                    )
                ),
                'email' => array(
                    'filter' => FILTER_VALIDATE_EMAIL,
                    'options' => array(
                        'default' => NULL
                    )
                )
            );

            $filteredArr = filter_input_array(INPUT_POST, $filters);

            (isset($filteredArr['name'])) ? ((strlen($filteredArr['name']) > 0 ) ? ($updateName = $filteredArr['name']) : $errName = "Name Required") : $errName = "Name Required" ;
            (isset($filteredArr['email'])) ? ($email = $filteredArr['email']) : $errEmail = "Valid Email Required" ;

            if ($updateName != NULL && $email != NULL) {
                $query = "UPDATE admins SET name='$updateName', email='$email' WHERE id = {$id}";
                if (mysqli_query($conn, $query)) {
                    $_SESSION['name'] = $updateName;
                    header('Location: adminhome.php');
                } else {
                    echo 'ERROR: '.mysqli_error($conn);
                }
            }
        } else if (strlen($_POST['password']) > 0 && strlen($_POST['confirmPassword']) > 0 && ($_POST['password'] === $_POST['confirmPassword'])) {
                $filters = array(
                    'name' => array(
                        'filter' => FILTER_SANITIZE_STRING,
                        'options' => array(
                            'default' => NULL
                        )
                    ),
                    'email' => array(
                        'filter' => FILTER_VALIDATE_EMAIL,
                        'options' => array(
                            'default' => NULL
                        )
                    ),
                    'password' => array(
                        'filter' => FILTER_SANITIZE_SPECIAL_CHARS,
                        'options' => array(
                            'default' => NULL
                        )
                    )
                );

                $filteredArr = filter_input_array(INPUT_POST, $filters);

                (isset($filteredArr['name'])) ? ((strlen($filteredArr['name']) > 0 ) ? ($updateName = $filteredArr['name']) : $errName = "Name Required") : $errName = "Name Required" ;
                (isset($filteredArr['email'])) ? ($email = $filteredArr['email']) : $errEmail = "Valid Email Required" ;
                (isset($filteredArr['password'])) ? ((strlen($filteredArr['password']) > 0 ) ? ($password = $filteredArr['password']) : $errPassword = "Password Required") : $errPassword = "Password Required" ;

                if ($updateName != NULL && $email != NULL && $password != NULL) {
                    $query = "UPDATE admins SET name='$updateName', email='$email', password='$password' WHERE id = {$id}";
                    if (mysqli_query($conn, $query)) {
                        $_SESSION['name'] = $updateName;
                        header('Location: adminhome.php');
                    } else {
                        echo 'ERROR: '.mysqli_error($conn);
                    }
                }
            } else {
                $errPassword = "Passwords do not match";
        }
    }

    if (isset($_POST['back'])) {
        header('Location: index.php');
    }
    
?>
<!DOCTYPE html>
  
    <?php require('inc/navbar.php'); ?>

    <div style="padding-top: 94px;" class="container" >
        <h1>USER INFO</h1>

        <form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>">
            <table>
                <tr>
                    <th>Name</th>
                    <td><input type="text" name="name" style="width: 300px" value="<?php echo $user['name']; ?>">
                        <br><span style="color:red"><?php echo $errName; ?></span></td>
                </tr>

                <tr>
                    <th>Email</th>
                    <td><input type="text" name="email" style="width: 300px" value="<?php echo $user['email']; ?>">
                        <br><span style="color:red"><?php echo $errEmail; ?></span></td>
                </tr>

                <tr>
                    <th>New Password</th>
                    <td><input type="password" name="password" style="width: 300px" value=""></td>
                </tr>

                <tr>
                    <th>Confirm Password</th>
                    <td><input type="password" name="confirmPassword" style="width: 300px" value="">
                    <br><span style="color:red"><?php echo $errPassword; ?></span></td>
                </tr>
            </table>

            <div style="text-align: center; padding: 20px" class="container">
                <input style="height: 46px; width: 200px;" type="submit" value="BACK" name="back">
                <input style="height: 46px; width: 200px;" type="submit" value="CHANGE" name="change">
            </div>
        </form>
    </div>
</body>

</html>