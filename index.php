<?php

include('../config/db_connect.php');

//write query for all pizzas
$sql = 'SELECT title, ingredients, id FROM pizzas ORDER BY created_at';

//make query and get results
$result= mysqli_query($connect, $sql);

//fetch results as an array
//MYSQLI_ASSOC will return an associated array
$pizzas = mysqli_fetch_all($result, MYSQLI_ASSOC);

//free up memory
mysqli_free_result($result);

//close connection to DB
mysqli_close($connect);

// print_r($pizzas);

//convert ingredients string to array using explode function
//explode takes 2 arguments, the separator, and the array to explode
//explode(', ',$pizzas[0]['ingredients'])


 ?>

 <!DOCTYPE html>
 <html lang="en" dir="ltr">
     <?php include('templates/header.php'); ?>

    <h4 class="center grey-text">Pizzas!</h4>

    <div class="container">
      <div class="row">

        <?php foreach($pizzas as $pizza){ ?>

          <div class="col s6 md3">
            <div class="card z-depth-0">
              <img src="img/pizza.svg" alt="pizza-img" class="pizza">
              <div class="card-content center">
                <h6> <?php echo htmlspecialchars($pizza['title']);  ?></h6>
                <ul>
                  <?php foreach(explode(', ', $pizza['ingredients']) as $ingredient ) { ?>
                    <li><?php echo htmlspecialchars($ingredient) ?></li>
                  <?php } ?>
                </ul>
              </div>
              <div class="card-action right-align">
                <a href="details.php?id=<?php echo $pizza['id']; ?>" class="brand-text">more info</a>
              </div>
            </div>
          </div>

            <?php } ?>

      </div>
    </div>




     <?php include('templates/footer.php'); ?>

 </html>
