<!DOCTYPE html>
<html>
<head> 
</head>


<!-- actual code stuff -->
<body>
    <section id="search">
      <div>
        <div>
          <h2>Actor Information</h2>
          <p>Find Information about an Actor and the movies they've been in here!</p>
        </div>


        <?php 
        // Create connection between PHP and the database
        $db = new mysqli('localhost', 'cs143', '', 'class_db');
        if ($db->connect_errno > 0) { 
            die('Unable to connect to database [' . $db->connect_error . ']'); 
        }

        // if an ID was given to look at
        if (isset($_GET["id"])) {
          // Get Actor Information into the $rs variable
          $cond = 'id='.$_GET['id'].";";
          $query = "SELECT * FROM Actor WHERE ".$cond;
          print "<br>";
          $rs = $db->query($query);

          // could not complete the query
          if (!$rs) {
              $errmsg = $db->error; 
              print "Query unsuccessful: $errmsg <br>"; 
              exit(1); 
          }

          // print out the headers for the information for the actor (name, sex, dob, dod)
          if ($rs->num_rows > 0) {
            print "
            <br>
            <h3>Actor Information is:</h3>
            <table>
              <tr>
                <th>Name</th>
                <th>Sex</th>
                <th>Date Of Birth</th>
                <th>Date Of Death</th>
              </tr>";

            // printing out the actual characteristics of the actor 
            while ($row = $rs->fetch_assoc()) {  
              print "<tr><td>".$row['first']." ".$row['last']."</td><td>".$row['sex']."</td><td>".$row['dob']."</td><td>";
              if ($row['dod'] == '0000-00-00'){
                print 'Still Alive';
              }
              else {
                print $row['dod'];
              }
              print "</td><tr>";
            }
            print "</table>";
          } 
          // there were no results for this person in the database
          else {
            print "<h3>Sorry, this actor could not be found in our database.</h3>";
          }
          

          // printing out actor and their associated movies

          //check if MovieActor.aid == given ID AND Movie.ID==MovieActor.mid
          $cond = 'A.aid='.$_GET['id']." AND M.id=A.mid;";
          $query = "SELECT * FROM (MovieActor A, Movie M) WHERE ".$cond;
          print "<br>";
          $rs = $db->query($query);

          // could not complete the query
          if (!$rs) {
              $errmsg = $db->error; 
              print "Query unsuccessful: $errmsg <br>"; 
              exit(1); 
          }
          // print out the headers for the information for the actor's movies (role, movie title)
          if ($rs->num_rows > 0) {
            print "
            <br>
            <h3>Actor's Movies and Role:</h3>
            <table>
              <tr>
                <th>Role</th>
                <th>Movie Title</th>
              </tr>";

            // printing out the actual characteristics of the actor's movies
            while ($row = $rs->fetch_assoc()) {  
              print "<tr><td>".$row['role']."</td><td><a href='movie.php?id=".$row['id']."'>".$row['title']."</a></td><tr>";
            }
            print "</table>";
          }
          // there were no results for this person in the database
          else {
            print "<h3>Sorry, there were no results for movies this actor has been in.</h3>";
          }
        }
      $db->close();
      ?>
    </section>
</body>
</html>
