<?php

  //connect to db
include('../config/db_connect.php');
  //check get request id parameter
  if(isset($_GET['id'])){
    $id = mysqli_real_escape_string($connect,$_GET['id']);

    //make query for single pizza using id
    $sql = "SELECT * FROM pizzas WHERE id = $id";

    //get query results
    $result = mysqli_query($connect, $sql);

    //fetch result in array format
    $pizza = mysqli_fetch_assoc($result);

    //free up memory and close connection to db
    mysqli_free_result($result);
    mysqli_close($connect);
  }

  //check for post form submission
  if (isset($_POST['delete'])){
    //Use id from request to locate on db
    $id_to_delete = mysqli_real_escape_string($connect, $_POST['id_to_delete']);

    //create sql query to delete
    $sql = "DELETE FROM pizzas WHERE id = $id_to_delete";

    //execute query to db
    if (mysqli_query($connect, $sql)){
      //successful delete
      //redirect to index
      header('Location: index.php');
    } else {
      //failed delete
      echo 'query error: ' . mysqli_error($connect);
    }

    mysqli_close($connect);
  }

 ?>
 <!DOCTYPE html>
 <html lang="en" dir="ltr">
   <?php include('templates/header.php'); ?>

   <div class="container center">
     <?php if($pizza){ ?>
       <h4><?php echo htmlspecialchars($pizza['title']); ?></h4>
       <p>Created by <?php echo htmlspecialchars($pizza['email']); ?></p>
       <p><?php echo date($pizza['created_at']); ?></p>
       <h5>Ingredients:</h5>
       <h6><?php foreach(explode(', ', $pizza['ingredients']) as $ingredient) { ?>
         <?php echo $ingredient;
         echo '<br />' ?>
       <?php } ?>
     </h6>

    <?php } else { ?>
      <h5>No such pizza exists!</h5>
    <?php } ?>

    <!-- Delete form -->
    <form action="details.php" method="post">
      <input type="hidden" name="id_to_delete" value="<?php echo $pizza['id'] ?>">
      <input type="submit" name="delete" value="Delete" class="btn brand z-depth-0">
    </form>

   </div>




   <?php include('templates/footer.php'); ?>
 </html>
