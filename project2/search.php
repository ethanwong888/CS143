<!DOCTYPE html>
<html>
<head>
    
</head>

<body>
      <!-- ======= Search Section ======= -->
    <section id="search">
      <div>

        <div>
          <h2>Search</h2>
          <p>Search for an Actor or Movie</p>
        </div>
        
        <form method="post">
            <input type="text" placeholder="Search..." name="search">
            <button>Search</button>
        </form>
        <?php 
        

        // Create connection between PHP and the database
        $db = new mysqli('localhost', 'cs143', '', 'class_db');
        if ($db->connect_errno > 0) { 
            die('Unable to connect to database [' . $db->connect_error . ']'); 
        }

        if (isset($_POST["search"])) {
          // Search through Actors
          // setting the proper condition for the query
          $condition = '';
          // similar to split() from Python --> used to split first and last names, makes it easier to search
          $arr = explode(" ", $_POST["search"]);
          $count = count($arr);
          if ($count == 1) {
            $condition = "first LIKE '%".$arr[0]."%' OR last LIKE '%".$arr[0]."%';";
          } 
          else if ($count == 2) {
            $condition = "first LIKE '%".$arr[0]."%' AND last LIKE '%".$arr[1]."%';";
          } 
          

          $query = "SELECT * FROM Actor WHERE ".$condition;
          $rs = $db->query($query);

          // could not complete the query
          if (!$rs) {
              $errmsg = $db->error; 
              print "Query unsuccessful: $errmsg <br>"; 
              exit(1); 
          }

          // print out the headers for the information for the actor (name, sex, dob, dod)
          if ($rs->num_rows > 0) {
            echo "
            <br>
            <h3>Matching actors:</h3>
            <table>
              <tr>
                <th>Name</th>
                <th>Sex</th>
                <th>Date Of Birth</th>
                <th>Date Of Death</th>
              </tr>";

            // printing out the actual characteristics of the actor
            while ($row = $rs->fetch_assoc()) {  
              echo "<tr><td>"."<a href='actor.php?id=".$row['id']."'>".$row['first']." ".$row['last']."</a></td><td>".$row['sex']."</td><td>"."<a href='actor.php?id=".$row['id']."'>".$row['dob']."</a></td><td>";
              if ($row['dod'] == '0000-00-00'){
                print 'Still Alive';
              }
              else {
                print $row['dod'];
              }
              echo "</td><tr>";
            }
            echo "</table>";
          } 
          // there were no results for this person in the database
          else {
            print "<h4>Sorry, this actor could not be found in our database.</h4>";
          }




          // Search through Movies
          // setting the proper condition for the query
          $condition = '';
          foreach ($arr as $val) {
            $condition .= "title LIKE '%".mysqli_real_escape_string($db, $val)."%' AND ";
          }
          $condition = substr($condition, 0, -4); // remove the trailing AND


          $query = "SELECT * FROM Movie WHERE ".$condition.";";
          $rs = $db->query($query);

          // could not complete the query
          if (!$rs) {
              $errmsg = $db->error; 
              print "Query unsuccessful: $errmsg <br>"; 
              exit(1); 
          }

          // print out the headers for the information for the movie (title, year, rating, company)
          if ($rs->num_rows > 0) {
            echo "
            <br>
            <h3>Matching movies:</h3>
            <table>
              <tr>
                <th>Title</th>
                <th>Year</th>
                <th>Rating</th>
                <th>Company</th>
              </tr>";

            // printing out the actual characteristics of the movie
            while ($row = $rs->fetch_assoc()) {  
              echo "<tr><td>"."<a href='movie.php?id=".$row['id']."'>".$row['title']."</a></td><td>".$row['year']."</td><td>";
              echo isset($row['rating']) ? $row['rating'] : 'N/A';
              echo "</td><td>".$row['company']."</td><tr>";
            }
            echo "</table>";
          } 
          else {
            print "<h4>Sorry, this movie could not be found in our database.</h4>";
          }
        }
      $db->close();
      ?>
    </section>
</body>
</html>