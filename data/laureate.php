<?php
// get the id parameter from the request
$id = intval($_GET['id']);

// set the Content-Type header to JSON, 
// so that the client knows that we are returning JSON data
header('Content-Type: application/json');

$mng = new MongoDB\Driver\Manager("mongodb://localhost:27017");

// filter by choosing the 'id' parameter that matches the string representation of the 'id' given to them
$filter = ['id' => strval($id)];

// hide the _id field
$options = ['projection' => ['_id' => 0]];

// create the query based on the filter and options that we created above
$query = new MongoDB\Driver\Query($filter, $options); 

// execute the query from above on the 'nobel.laureates' file
$rows = $mng->executeQuery("nobel.laureates", $query);

// iterate over the rows returned from the query and return the results in JSON format
foreach ($rows as $row) {
    echo json_encode($row, JSON_PRETTY_PRINT);
}
?>