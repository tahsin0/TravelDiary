<?php
	require('config/db.php');
	session_start();
	$id = $_SESSION['id'];
	$name = $_SESSION['name'];
	$role = $_SESSION['role'];

	if (!isset($id) && $role == "admin") {
    	header('Location: login.php');
  	}

  	$regName = '';
	$email = '';
	$password = '';
	$role = "moderator";

	$errName = '';
	$errEmail = '';
	$errPassword = '';

  	if(isset($_POST['submit'])){

		$filters = array(
			'regName' => array(
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

		//transfer filtered values into a new array.
		$filteredArr = filter_input_array(INPUT_POST, $filters);

		//check values and set html field values and error messages.
		(isset($filteredArr['regName'])) ? ((strlen($filteredArr['regName']) > 0 ) ? ($regName = $filteredArr['regName']) : $errName = "Name Required") : $errName = "Name Required" ;
		(isset($filteredArr['email'])) ? ($email = $filteredArr['email']) : $errEmail = "Valid Email Required" ;
		(isset($filteredArr['password'])) ? ((strlen($filteredArr['password']) > 0 ) ? ($password = $filteredArr['password']) : $errPassword = "Password Required") : $errPassword = "Password Required" ;

		$query = 'SELECT * FROM admins';
        $result = mysqli_query($conn, $query);
    	$moderators = mysqli_fetch_all($result, MYSQLI_ASSOC);
    	mysqli_free_result($result);

    	foreach ($moderators as $moderator) {
    		if ($moderator['email'] == $email) {
    			$errEmail = "Email already exists";
    		} else {
    			$query1 = "INSERT INTO admins (name, email, password, role) VALUES ('$regName', '$email', '$password', '$role')";
    			if (mysqli_query($conn, $query1)) {
    				header('Location: moderators.php');
				}else {
					echo 'ERROR: '.mysqli_error($conn);
				}
    		}
    	}
	}
?>

<!DOCTYPE html>

  <?php require('inc/navbar.php'); ?>


  <div style="padding-top: 54px; display: flex; flex-direction: column; align-items: center;">

	<h1>Moderator Registration</h1>
		<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>">
			<table style="text-align: center; border-style: solid; height: 300px;">
				<tr>
					<td>Name:</td>
					<td><input type="text" name="regName" value="<?php echo $regName; ?>">
					<br><span style="color:red"><?php echo $errName; ?></span></td> 					
				</tr>

				<tr>
					<td>Email: </td>
					<td><input type="text" name="email" value="<?php echo $email; ?>">
					<br><span style="color:red"><?php echo $errEmail; ?></span></td>					
				</tr>

				<tr>
					<td>Password:</td>
					<td> <input type="password" name="password" value="<?php echo $password; ?>">
					<br><span style="color:red"><?php echo $errPassword; ?></span></td>					
				</tr>

				<tr>
					<td colspan="2" align="center">
						<input style="width: 100%; height: 30px;" type="submit" name="submit" value="Submit">
					</td>
				</tr>

			</table>
        </form>
        </div>
	</body>
</html>