<?php
  require('config/db.php');

  session_start();
  $id = $_SESSION['id'];
  $name = $_SESSION['name'];
  $role = $_SESSION['role'];

  if (!isset($id)) {
    header('Location: login.php');
  }

  $query = 'SELECT * FROM posts ORDER BY created_on DESC';
  $result = mysqli_query($conn, $query);
  $posts = mysqli_fetch_all($result, MYSQLI_ASSOC);
  mysqli_free_result($result);
  mysqli_close($conn);
?>

<!DOCTYPE html>

  <?php require('inc/navbar.php'); ?>


  <div style="cursor: pointer; padding-top: 54px;">
    <div style="margin: 16px; display: flex; justify-content: center;">
      <a href="add.php">
        <i title="Upload" class="fa fa-plus-circle fa-4x" aria-hidden="true"></i>
      </a>
    </div>
    <p style="margin: 16px; display: flex; justify-content: center;"><a href="add.php">SHARE YOUR EXPERIENCE</a></p>
  </div>
  </div>

  <div style="display: flex; flex-wrap: wrap; justify-content: space-around;">
    <?php foreach ($posts as $post): ?>    
      <div class="card" style="margin: 10px;">
        <a style="text-decoration: none;" href="details.php?postid=<?php echo $post['id']; ?>">
          <img src="<?php echo $post['image']; ?>" alt="Avatar" style="width:100%; height: 300px;">
          <div class="container">
            <h4><b><?php echo $post['title']; ?></b></h4>
          </div>
        </a>
      </div>
    <?php endforeach ?>
  </div>

</body>

</html>