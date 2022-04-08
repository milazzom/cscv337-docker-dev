<?php
# CSE 190M Homework 8 (Kevin Bacon) actor ID lookup service
# This is provided to the students and doesn't need to be modified by them.

# "constants"
$SERVER   = "mysql-server";
$USER     = "root";
$PASSWORD = "Be@rD0wn!";
$DATABASE = "imdb";
$MIN_TOTAL_LENGTH = 2;
$MAX_DELAY = 30;
$MAX_ACTORS = 50;

header('Access-Control-Allow-Origin: *');

# optional delay to test slow servers and loading-div stuff
if (isset($_REQUEST["delay"])) {
	$delay = min($MAX_DELAY, max(0, (int) $_REQUEST["delay"]));
	sleep($delay);
}

# gather info for user name / password / db
# $user       = sanitized_param("user",     $USER,     FALSE, TRUE);
# $password   = sanitized_param("password", $PASSWORD, FALSE, TRUE);


# gather info about which db to use (imdb_small or imdb)
$database   = $DATABASE;
if (isset($_REQUEST["imdb"])) {
	$database = "imdb";
}

# see if we should get all matching actors or not
$limit = 1;
if (isset($_REQUEST["all"])) {
	$limit = $MAX_ACTORS;  # return lots of actors
}

# gather info for first/last name
$first_name = sanitized_param("first_name", "");
$last_name  = sanitized_param("last_name",  "");
if (strlen($first_name) + strlen($last_name) < $MIN_TOTAL_LENGTH) {
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400 - Invalid request.  This service requires parameters named either 'first_name' or 'last_name' of total length >= $MIN_TOTAL_LENGTH");
}

$host = "mysql-server";
$user = "root";
$pass = "Be@rD0wN!";
$db = "imdb";
try {
    $conn = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
 
    
} catch(PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}
# connect to database
# check(mysql_connect($SERVER, $USER, $PASSWORD), "mysql_connect(server=\"$SERVER\", user=\"$USER\", password=\"$PASSWORD\")");
# check(mysql_select_db($database), "mysql_select_db(\"$database\")");

# perform the given query and output the result, else print error
$query = "SELECT COUNT(a.id) AS count, a.id, a.first_name, a.last_name
          FROM actors a
          JOIN roles r  ON r.actor_id = a.id
          JOIN movies m ON m.id = r.movie_id
          WHERE a.first_name LIKE :fname
            AND a.last_name  LIKE :lname
          GROUP BY a.id
          ORDER BY count DESC, a.last_name, a.first_name
          LIMIT $limit;";
$fname = "%" . $first_name . "%";
$lname = "%" . $last_name . "%";

$stmt = $conn->prepare($query);
$stmt->execute(array(":fname"=> $fname, ":lname" => $lname));
$data = $stmt->fetchAll();
$rows = count($data);
if ($rows <= 0) {
	# no match found
	header("HTTP/1.1 404 File Not Found");
	die("HTTP/1.1 404 File Not Found - $first_name $last_name");
}

header("Content-type: text/xml");
print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";

if ($rows == 1) {
	# single (most popular) actor only
	$row = $data[0];
	$actor_id = $row["id"];
	$first_name = sanitize($row["first_name"]);
	$last_name = sanitize($row["last_name"]);
	$appearances = $row["count"];
	print "<actor id=\"$actor_id\" first_name=\"$first_name\" last_name=\"$last_name\" appearances=\"$appearances\" />\n";
} else {
	# many actors; show all
	print "<actors count=\"$rows\">\n";
	foreach ($data as $row) {
		$actor_id = $row["id"];
		$first_name = sanitize($row["first_name"]);
		$last_name = sanitize($row["last_name"]);
		$appearances = $row["count"];
		print "\t<actor id=\"$actor_id\" first_name=\"$first_name\" last_name=\"$last_name\" appearances=\"$appearances\" />\n";
	}
	print "</actors>\n";
}


# makes sure result is not false/null; else prints error
function check($result, $message) {
	if (!$result) {
		die("SQL error encountered!");
	}
}

# returns TRUE if the given query parameter has been passed and is a
# "truthy" string like 1, yes, true, on, etc.
function param_is_true($name) {
	if (!isset($_REQUEST[$name])) {
		return FALSE;
	}
	$param = strtolower(sanitized_param($name));
	return ($param === "1"    || $param === "on" ||
	        $param === "true" || $param === "yes" || $param === "enabled");
}

# returns the value of the given query parameter, using an optional default.
# if required and not found, raises an HTTP error.
function sanitized_param($name, $default = "", $required = FALSE, $required_nonempty = FALSE) {
	$value = $default;
	if (isset($_REQUEST[$name])) {
		$value = sanitize($_REQUEST[$name]);
	} else if ($required) {
		header("HTTP/1.1 400 Invalid Request");
		die("ERROR 400 - Invalid request.  Missing a required parameter named '$name'");
	}

	if ($value === "" && $required_nonempty) {
		header("HTTP/1.1 400 Invalid Request");
		die("ERROR 400 - Invalid request.  This service requires a non-empty parameter named '$name'");
	}

	return $value;
}

# cleans non-alphanumeric characters out of the given string
function sanitize($input) {
	# $input = htmlspecialchars(trim($input));
	$input = preg_replace("/[^a-zA-Z0-9 _'!&()-.:;?@`~]+/", "", $input);
	# $input = mysql_real_escape_string($input);
	return $input;
}
?>

