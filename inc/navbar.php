<?php
  $role = "";

  if (isset($_SESSION['role'])) {
    $role = $_SESSION['role'];
  }
  
  if (!isset($role)) {
    $url = "login.php";
  } elseif ($role === "user") {
    $url = "index.php";
  } else {
    $url = "adminhome.php";
  }
?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="home.css">
    <link rel="stylesheet" href="user.css">
    <link rel="stylesheet" href="details.css">
    <link rel="stylesheet" href="font-awesome-4.7.0/css/font-awesome.css">
    <title>TravelDiary</title>
    <style>
    * {
      box-sizing: border-box;
    }

    body {
      margin: 0;
      font-family: Arial, Helvetica, sans-serif;
    }

    .topnav .search-container {
      float: right;
    }

    .topnav input[type=text] {
      padding: 6px;
      margin-top: 8px;
      font-size: 17px;
      border: none;
    }

    .topnav .search-container button {
      float: right;
      padding: 6px 10px;
      margin-top: 8px;
      margin-right: 16px;
      background: #ddd;
      font-size: 17px;
      border: none;
      cursor: pointer;
    }

    .topnav .search-container button:hover {
      background: #ccc;
    }

    @media screen and (max-width: 600px) {
      .topnav .search-container {
        float: none;
      }

      .topnav a,
      .topnav input[type=text],
      .topnav .search-container button {
        float: none;
        display: block;
        text-align: left;
        width: 100%;
        margin: 0;
        padding: 14px;
      }
    }
  </style>
</head>

<body>
  <div style="width: 100%; height: 60px; background-color: #dfdfdf; display: flex; justify-content: space-between; position: fixed;">
    <div style="padding-left: 30px; padding-bottom: 10px;">
      <h2><a style="text-decoration: none; color: black;" href="<?php echo $url; ?>">Travel Diary</a></h2>
    </div>

    <?php if (isset($id)): ?>
      <div style="margin: 16px;">
        <?php if ($role == "user"): ?>
          <a href="myposts.php"><i style="padding-right: 14px;" title="MY Posts" class="fa fa-archive fa-2x" aria-hidden="true"> My Posts</i></a>
        <?php endif ?>
        <a href="user.php"><i style="padding-right: 14px;" title="Profile" class="fa fa-user fa-2x" aria-hidden="true"> <?php echo $name; ?></i></a>
        <a href="login.php"><i style="padding-right: 14px;" title="Logout" class="fa fa-sign-out fa-2x" aria-hidden="true"></i></a>
      </div>
    <?php endif ?>
    
  </div>