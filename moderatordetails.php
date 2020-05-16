<?php
    session_start();
    $id = $_SESSION['id'];
    $name = $_SESSION['name'];
    $role = $_SESSION['role'];
    if (!isset($id)) {
        header('Location: login.php');
    }
?>
<!DOCTYPE html>
  
    <?php require('inc/navbar.php'); ?>

    <div style="padding-top: 94px;">
        <h1>MODERATOR INFO</h1>

        <table>
            <tr>
                <th>Name</th>
                <td>Fahim Fayaz</td>


            </tr>
            <tr>
                <th>User Name</th>
                <td>Choto</td>

            </tr>
            <tr>
                <th>Gender</th>
                <td>Male</td>

            </tr>
            <tr>
                <th>Hobbies</th>
                <td>Traveling</td>

            </tr>
            <tr>
                <th>Profession</th>
                <td>Student</td>

            </tr>
            <tr>
                <th>Birth Date</th>
                <td>17/02/1997</td>
            </tr>
        </table>
    </div>
</body>

</html>