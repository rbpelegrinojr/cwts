<?php
//load.php

// $connect = new PDO('mysql:host=localhost;dbname=gad', 'root', '');

// $data = array();

// $query = "SELECT * FROM events_tbl";

// $statement = $connect->prepare($query);

// $statement->execute();

// $result = $statement->fetchAll();

// foreach($result as $row)
// {
//  $data[] = array(
//   'id'   => $row["event_id"],
//   'title'   => $row["event_title"],
//   'start'   => $row["event_date"]
//  );
// }

// echo json_encode($data);

include 'include/db.php';

$query = mysqli_query($con, "SELECT * FROM events_tbl");

$data = array();

while ($row = mysqli_fetch_array($query)) {
	$data[] = array(
		'id' => $row['event_id'],
		'title' => $row['event_title'].' @ '.$row['event_time'],
		'start' => $row['event_date']);
}
echo json_encode($data);
?>