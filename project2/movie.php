<!DOCTYPE html>
<html>
<body>
    <section>
      <div>
        <div>
          <h2>Movie Information Page</h2>
          <p>Find information about Movies here!</p>
        </div>


        <?php
        // Create connection between PHP and the database
        $db = new mysqli('localhost', 'cs143', '', 'class_db');
        if ($db->connect_errno > 0) { 
            die('Unable to connect to database [' . $db->connect_error . ']'); 
        }


        // TITLE, PRODUCERS, MPAA RATING
        // query is:
        // $condition = 'M.id='.$_GET['id']." AND G.mid=M.id AND MD.mid=M.id AND D.id=MD.did;";
        // $query = "SELECT * FROM (Movie M, MovieGenre G, MovieDirector MD, Director D) WHERE ".$condition;
        if (isset($_GET["id"])){
          $condition = 'id='.$_GET['id'].";";
          $query = "SELECT * FROM Movie WHERE ".$condition;
          print "<br>";
          $rs = $db->query($query);

          // could not complete the query
          if (!$rs){
              $errmsg = $db->error; 
              print "Query unsuccessful: $errmsg <br>"; 
              exit(1); 
          }

          // print out the header for the information for the movie
          if ($rs->num_rows > 0){
            print "
            <br>
            <h3>Movie Information is:</h3>";

            // printing out the actual characteristics of the Movie (Title, Producer, MPAA Rating)
            while ($row = $rs->fetch_assoc()){  
              print "Title: ".$row['title']." (".$row['year'].")"."<br>Producer: ".$row['company']."<br>MPAA Rating: ".$row['rating']."";
              break;
            }
          } 
          else{
            print "<h4>There were no matching results in the database for this Movie.</h4>";
          }
          


          // GENRE
          $condition = 'M.id='.$_GET['id']." AND G.mid=M.id;";
          $query = "SELECT DISTINCT genre FROM (Movie M, MovieGenre G) WHERE ".$condition;
          $rs = $db->query($query);

          // could not complete the query
          if (!$rs){
              $errmsg = $db->error; 
              print "Query unsuccessful: $errmsg <br>"; 
              exit(1); 
          }

          // printing out the actual Genre
          if ($rs->num_rows > 0){
            print "<br>Genre: ";
            while ($row = $rs->fetch_assoc()){  
              print $row['genre']." ";
            }
          } 
          else {
            print "There is no Genre information for this movie.";
          }
          


          // ACTORS
          $condition = 'M.id='.$_GET['id']." AND MA.mid=M.id AND MA.aid=A.id;";
          $query = "SELECT * FROM (MovieActor MA, Movie M, Actor A) WHERE ".$condition;
          print "<br>";
          $rs = $db->query($query);

          // could not complete the query
          if (!$rs){
              $errmsg = $db->error; 
              print "Query unsuccessful: $errmsg <br>"; 
              exit(1); 
          }


          // print out the header for the information for the movie
          if ($rs->num_rows > 0){
            print "
            <br>
            <h3>Actors in this Movie:</h3>
            <table>
              <tr>
                <th>Name</th>
                <th>Role</th>
              </tr>";

            // printing out the actual characteristics of the Movie (Actors, Actor role)
            while ($row = $rs->fetch_assoc()){  
              print "<tr><td>"."<a href='actor.php?id=".$row['aid']."'>".$row['first']." ".$row['last']."</a></td><td>".$row['role']."</td><tr>";
            }
            print "</table>";
          } 
          else{
            print "
            <br>
            <h3>Actors in this Movie:</h3>
            <h4>Could not find any actors for this movie.</h4>";
          }



          // USER REVIEWS
          $condition = 'mid='.$_GET['id'].";";
          $query = "SELECT AVG(rating), COUNT(comment) FROM Review WHERE ".$condition;
          print "<br>";
          $rs = $db->query($query);

          // could not complete the query
          if (!$rs){
              $errmsg = $db->error; 
              print "Query unsuccessful: $errmsg <br>"; 
              exit(1); 
          }
          
          // print out the header for the comment details
          if ($rs->num_rows > 0){
            print "
            <br>
            <h3>User Review:</h3>";
            while ($row = $rs->fetch_assoc()) {  
              print "Average score for this Movie is ";
              print isset($row['AVG(rating)']) ? $row['AVG(rating)'] : 0;
              print "/5 based on ".$row["COUNT(comment)"]." people's reviews<br>";
              print "<a href='review.php?id=".$_GET['id']."'>Leave your review as well!</a><br>";
            }
          } 
          else{
            print "<h4>There are no results to be shown.</h4>";
          }



          // COMMENT DETAILS
          $condition = 'mid='.$_GET['id'].";";
          $query = "SELECT * FROM Review WHERE ".$condition;
          print "<br>";
          $rs = $db->query($query);
          // could not complete the query
          if (!$rs){
              $errmsg = $db->error; 
              print "Query unsuccessful: $errmsg <br>"; 
              exit(1); 
          }
          
          // printing out the actual comments
          if ($rs->num_rows > 0){
            print "
            <br>
            <h3>Comment details:</h3>";
            while ($row = $rs->fetch_assoc()){  
              print $row['name']." rates this movie with score ".$row['rating']." and left a review at ".$row['time']."<br>";
              print "Comment: <br>";
              print isset($row['comment']) ? $row['comment'] : "";
              print "<br><br>";
            }
          } 
          else{
            print "
            <br>
            <h3>Comment details:</h3>
            <h4>Nothing to be shown right now.</h4>";
          }
        }
      $db->close();
      ?>
    </section>
</body>
</html>