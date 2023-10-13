<!DOCTYPE html>
<html>
<head>
</head>

<body>
    <section>
      <div>
        <div>
          <h2>Reviews</h2>
          <p>Add a review for a movie here!</p>
        </div>

        <?php 
        // Create connection between PHP and the database
        $db = new mysqli('localhost', 'cs143', '', 'class_db');
        if ($db->connect_errno > 0){ 
            die('Unable to connect to database [' . $db->connect_error . ']'); 
        }


        // Get information on which movie the review is being left for
        if (isset($_GET["id"])){
          $condition = 'id='.$_GET['id'].";";
          $query = "SELECT * FROM Movie WHERE ".$condition;
          echo "<br>";
          $rs = $db->query($query);

          // could not complete the query
          if (!$rs){
              $errmsg = $db->error; 
              print "Query unsuccessful: $errmsg <br>"; 
              exit(1); 
          }

          // print out name of the movie
          if ($rs->num_rows > 0){
            echo "
            <br>
            <h4>Movie Title:</h4>";

            while ($row = $rs->fetch_assoc()){  
              echo "<h3>".$row['title']." (".$row['year'].")</h3><br>";
              break;
            }
          } 
          else{
            echo "<h4>Movie was not found.</h4>";
          }
        }
    ?>

    
    <!-- the actual form to fill out -->
    <form method="post">
          <!-- User Name -->
          <div> 
              <label>Your Name:</label>
              <input type="text" placeholder="Your Name" name="name" value="Anonymous">
          </div>
          <br>

          <!-- User Rating -->
          <div> 
              <label>Rating:</label>
              <select name="rating" id="rating">
              <option value="1">1</option>
              <option value="2">2</option>
              <option value="3">3</option>
              <option value="4">4</option>
              <option value="5">5</option>
              </select>
          </div>
          <br>

          <!-- User Comment -->
          <div> 
              <label>Comment:</label>
              <textarea type="text" placeholder="no more than 500 characters" name="comment" rows="10"></textarea>
          </div>
          <br><br>

          <!-- Submit Button -->
          <button>Rating it!</button>
    </form>


    <!-- Adding the review to the database -->
    <?php
        date_default_timezone_set('America/Los_Angeles');
        if (isset($_POST["comment"])) {
          // Get movie information, time information
          $condition = "('".$_POST["name"]."', '".date('Y-m-d H:i:s')."', ".$_GET["id"].", ".$_POST["rating"].", '".$_POST["comment"]."');";
          $query = "INSERT INTO Review VALUES ".$condition;
          echo "<br>";
          $rs = $db->query($query);

          // could not complete the query
          if (!$rs){
              $errmsg = $db->error; 
              print "Query unsuccessful: $errmsg <br>"; 
              exit(1); 
          }
          // upon successful query (Review table has been updated) show a message that the review was received
          else{
              echo "Your feedback has been received. Thank you!";
          }
        }
      $db->close();
    ?>
    </section>
</body>
</html>