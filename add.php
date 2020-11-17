<?php

//connect to db
include('../config/db_connect.php');

// Check if data has been sent by submit button
// if(isset($_GET['submit'])){
//   echo $_GET['email'];
//   echo $_GET['title'];
//   echo $_GET['ingredients'];
// }

//save errors into array
$errors = ['email'=>'', 'title'=>'', 'ingredients'=>''];

//intialize default variables
$email = $title = $ingredients = '';

//convert submitted text to safe html entities
if(isset($_POST['submit'])){
  // echo htmlspecialchars($_POST['email']);
  // echo htmlspecialchars($_POST['title']);
  // echo htmlspecialchars($_POST['ingredients']);

  //Form validation checks
  // check email
  if(empty($_POST['email'])){
    $errors['email'] = 'An email is required';
  } else{
    $email = $_POST['email'];
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $errors['email'] = 'Email must be a valid email address';
    }
  }

  // check title
  if(empty($_POST['title'])){
    $errors['title'] = 'A title is required';
  } else{
    $title = $_POST['title'];
    if(!preg_match('/^[a-zA-Z\s]+$/', $title)){
      $errors['title'] = 'Title must be letters and spaces only';
    }
  }

  // check ingredients
  if(empty($_POST['ingredients'])){
    $errors['ingredients'] = 'At least one ingredient is required';
  } else{
    $ingredients = $_POST['ingredients'];
    //check for comma separated
    if(!preg_match('/^([a-zA-Z\s]+)(,\s*[a-zA-Z\s]*)*$/', $ingredients)){
      $errors['ingredients'] = 'Ingredients must be a comma separated list';
    }
  }

  //check if errors, if none redirect to home page
  if (array_filter($errors)){
    //do nothing, let user correct errors
  } else {
    //prevent malicious sql injection with escape string
    $email = mysqli_real_escape_string($connect,$_POST['email']);
    $title = mysqli_real_escape_string($connect,$_POST['title']);
    $ingredients = mysqli_real_escape_string($connect,$_POST['ingredients']);

    //add items back into database
    $sql = "INSERT INTO pizzas(title,email,ingredients) VALUES('$title','$email','$ingredients')";

    //save to db and check
    if (mysqli_query($connect, $sql)){
      //success (saved to db)
      header('Location: index.php');
    } else {
      //error
      echo 'query error: ' . mysqli_error($connect);
    }



  }
}
 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
     <?php include('templates/header.php'); ?>

     <section class="container grey-text">
       <h4 class="center">Add a Pizza</h4>
       <form class="white" action="add.php" method="post">
         <label>Email</label>
         <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" autocomplete="off" autofocus="on" />
         <div class="red-text"><?php echo $errors['email']; ?></div>

         <label>Title</label>
         <input type="text" name="title" value="<?php echo htmlspecialchars($title); ?>" autocomplete="off" />
        <div class="red-text"><?php echo $errors['title']; ?></div>

         <label>Ingredients (comma separated)</label>
         <input type="text" name="ingredients" value="<?php echo htmlspecialchars($ingredients); ?>" autocomplete="off" />
        <div class="red-text"><?php echo $errors['ingredients']; ?></div>

         <div class="center">
           <button type="submit" name="submit" class="btn brand z-depth-0">Submit</button>
         </div>

       </form>
     </section>




     <?php include('templates/footer.php'); ?>

 </html>
