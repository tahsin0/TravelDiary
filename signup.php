<?php
	require('config/db.php');

	$name = '';
	$email = '';
	$password = '';
	$status = 1;

	$errName = '';
	$errEmail = '';
	$errPassword = '';
	session_start();
	session_destroy();

	if(isset($_POST['submit'])){

		$filters = array(
			'name' => array(
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
		(isset($filteredArr['name'])) ? ((strlen($filteredArr['name']) > 0 ) ? ($name = $filteredArr['name']) : $errName = "Name Required") : $errName = "Name Required" ;
		(isset($filteredArr['email'])) ? ($email = $filteredArr['email']) : $errEmail = "Valid Email Required" ;
		(isset($filteredArr['password'])) ? ((strlen($filteredArr['password']) > 0 ) ? ($password = $filteredArr['password']) : $errPassword = "Password Required") : $errPassword = "Password Required" ;

		if ($name != NULL && $email != NULL && $password != NULL) {
			//fetch values from users table and put them in result then transfer them to users as array.
			$query = 'SELECT * FROM users';
			$result = mysqli_query($conn, $query);
			$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
			mysqli_free_result($result);

			//check whether the users array is empty, if not check whether the email is unique, if it is unique then insert into users table.
			//if the array is empty goes to else block.
			//another query to get the updated users table and set session values for id and name then redirect to homepage.
			if ((array) $users) {
				foreach ($users as $user) {
					if($user['email'] === $email){
						$errEmail = "Already Exists";
					}else {
						$query1 = "INSERT INTO users (name, email, password, status) VALUES ('$name', '$email', '$password', '$status')";
						if (mysqli_query($conn, $query1)) {
							$query = 'SELECT * FROM users';
							$result = mysqli_query($conn, $query);
							$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
							mysqli_free_result($result);
							foreach ($users as $user) {
								if ($user['email'] = $email) {
									session_start();
									$_SESSION['id'] = $user['id'];
									$_SESSION['name'] = $user['name'];
									$_SESSION['role'] = "user";
									mysqli_close($conn);
									header('Location: index.php');
								}
							}
						}else {
							echo 'ERROR: '.mysqli_error($conn);
						}
					}
				}
			}else {
				$query1 = "INSERT INTO users (name, email, password, status) VALUES ('$name', '$email', '$password', '$status')";
				if (mysqli_query($conn, $query1)) {
					$query = 'SELECT * FROM users';
							$result = mysqli_query($conn, $query);
							$users = mysqli_fetch_all($result, MYSQLI_ASSOC);
							mysqli_free_result($result);
							foreach ($users as $user) {
								if ($user['email'] = $email) {
									session_start();
									$_SESSION['id'] = $user['id'];
									$_SESSION['name'] = $user['name'];
									$_SESSION['role'] = "user";
									mysqli_close($conn);
									header('Location: index.php');
								}
							}
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

	<h1>Registration</h1>
		<form method="post" action="<?php echo htmlentities($_SERVER['PHP_SELF'])?>">
			<table style="text-align: center; border-style: solid; height: 300px;">
				<tr>
					<td>Name:</td>
					<td><input type="text" name="name" value="<?php echo $name; ?>">
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