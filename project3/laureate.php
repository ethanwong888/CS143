<?php
# get the id parameter from the request
$id = intval($_GET['id']);

# AUXILARY FUNCTIONS ====================================
function change_key($array, $old_key, $new_key) {
  if( ! array_key_exists( $old_key, $array ) )
    return $array;

  $keys = array_keys( $array );
  $keys[ array_search( $old_key, $keys ) ] = $new_key;

  return array_combine( $keys, $array );
}
# ========================================================


# set the Content-Type header to JSON, so that the client knows that we are returning a JSON data
header('Content-Type: application/json');


# CREATE CONNECTION =====================================

$db = new mysqli('localhost', 'cs143', '', 'class_db');
if ($db->connect_errno > 0){ 
  die('Unable to connect to database [' . $db->connect_error . ']'); 
}
# ========================================================


# get Laureate attributes (id, givenName, familyName, gender, birth/founded date)
$query="SELECT id, name, familyName, gender, birthFoundedDate as date, city FROM Laureate WHERE id=".$id.";";

$rs = mysqli_query($db, $query);
# query failed
if (!$rs) {
  $errmsg = $db->error; 
  print "Query unsuccessful: $errmsg <br>"; 
  exit(1); 
}

$isPerson = True;
$output = array();
while ($row = mysqli_fetch_assoc($rs)){ 
  # Laureate is not a person
  if (empty($row['familyName']) && empty($row['gender'])){
    $isPerson = False;
  }
  
  # get country info
  $place = array();
  if (!empty($row['city'])){
    $placeQuery="SELECT * FROM Place WHERE city='".$row['city']."';";
    $prs = mysqli_query($db, $placeQuery);
    # query failed
    if (!$prs){
      $errmsg = $db->error; 
      print "Query unsuccessful: $errmsg <br>"; 
      exit(1); 
    }

    # get the city and country info, load into array
    while ($r = mysqli_fetch_assoc($prs)){
      $place['city'] = array('en' => $r['city']);
      if (!empty($r['country'])){
        $place['country'] = array('en' => $r['country']);
      }
    }
  }

  # (birthdate / founding date) + (birthplace / founding place)
  $originInfo = array();
  if (!empty($row['date']))
    $originInfo['date'] = $row['date'];
  if (!empty($place)) 
    $originInfo['place'] = $place;

  unset($row['date']);
  unset($row['city']);
  unset($row['country']);

  # if Person, want to change 'name' to 'givenName', give 'familyName', give 'birthdate'
  # if not a Person, want to change 'name' to 'orgName', give founding date
  if ($isPerson) {
    $row = change_key($row, 'name', 'givenName');
    $row['givenName'] = array('en' => $row['givenName']);

    if (!empty($row['familyName']))
      $row['familyName'] = array('en' => $row['familyName']);

    if (!empty($originInfo))
      $row['birth'] = $originInfo;
  }
  else {
      $row = change_key($row, 'name', 'orgName');
      $row['orgName'] = array('en' => $row['orgName']);
      $row['founded'] = $originInfo;
  }

  // unset all columns with null values
  foreach($row as $key=>$value) {
    if (empty($row[$key]))
      unset($row[$key]);
  }    
  $output = $row;
}



# get NobelPrize attributes (awardYear, category, sortOrder, portion, dateAwarded, prizeStatus, motivation, prizeAmount)
$query = "SELECT * FROM NobelPrize WHERE lid=".$id.";";

$rs = mysqli_query($db, $query);
# query failed
if (!$rs){
  $errmsg = $db->error; 
  print "Query unsuccessful: $errmsg <br>"; 
  exit(1); 
}

$nobelPrizes = array();

while ($row = mysqli_fetch_assoc($rs)){
  # ID
  unset($row['lid']);
  # Category
  if (!empty($row['category']))
    $row['category'] = array('en' => $row['category']);
  # Motivation
  if (!empty($row['motivation']))
    $row['motivation'] = array('en' => $row['motivation']);
  # Prize Amount
  if (!empty($row['prizeAmount']))
    $row['prizeAmount'] = (int)$row['prizeAmount'];

  # get Affiliations(name, city, country)
  $affiliations = array();
  $aQuery = "SELECT name, A.city, P.country FROM Affiliation A, Place P WHERE pid=".$row['pid']." AND A.city=P.city;";

  $ars = mysqli_query($db, $aQuery);
  # query failed
  if (!$ars) {
    $errmsg = $db->error; 
    print "Query unsuccessful: $errmsg <br>"; 
    exit(1); 
  }

  while ($r = mysqli_fetch_assoc($ars)){
    $affiliationInfo = array();
    # Name of Affiliation
    if (!empty($r['name'])){
      $affiliationInfo['name'] = array('en' => $r['name']);
    }
    # Affiliation's City
    if (!empty($r['city'])){
      $affiliationInfo['city'] = array('en' => $r['city']);
    }
    # Affiliation's Country
    if (!empty($r['country'])){
      $affiliationInfo['country'] = array('en' => $r['country']);
    }
    $affiliations[] = $affiliationInfo;
  }
  
  unset($row['pid']);
  if (!empty($affiliations))
    $row['affiliations'] = $affiliations;
  
  // unset all columns with null values
  foreach($row as $key=>$value){
    if (empty($row[$key]))
      unset($row[$key]);
  }
  $nobelPrizes[] = $row;
}

$output['nobelPrizes'] = $nobelPrizes;

echo json_encode($output, JSON_PRETTY_PRINT);
?>