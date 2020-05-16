<?php
	//create connection
	$conn = mysqli_connect('localhost', 'root', '', 'traveldiary');

	//check connection
	if (mysqli_connect_errno()) {
		echo 'Failed to connect to MySQL '. mysqli_connect_errno();
	}