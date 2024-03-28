<?php
# A PHP script to return baby name meaning data.
#
# Requires a query parameter "type", which can be "list", "rank", or "meaning".
# The "list" type can accept optional parameters "format", "prefix", or "substring".
# The "rank" and "meaning" types require a second parameter "name".
#
# Author : Marty Stepp
# Version: Aug 9 2010
# New features: delay, error, odd-year temporary flags; cookie examination

# globals
$RANK_FILE     = "rank.txt";
$MEANINGS_FILE = "meanings.txt";
$LIST_FILE     = "list.txt";
$FLAG_TIME     = 30;              # flag time before reverting to false (to prevent one TA from messing it up for others)
$START_YEAR    = 1900;            # can be changed by flag
$ERROR_MODE    = FALSE;           # can be changed by flag
$DELAY         = 0;               # can be changed by param or flag
$RANDOMIZE     = FALSE;           # can be changed by flag or param; shuffles the names to test whether it depends on ABC order

header("Access-Control-Allow-Origin: *");
# main

# check for various flags
# flagdelay parameter to make every request delay by 5 sec
if (param_is_truthy("flagdelay")) {
	flag_set("delay", TRUE);
}
if (flag_get("delay") || cookie_is_truthy("JSTEP_COOKIE___grading_Delay")) {
	$DELAY = 3;
}

# flagerror parameter to cause requests to error out
if (param_is_truthy("flagerror")) {
	flag_set("error", TRUE);
}
if (flag_get("error") || param_is_truthy("error") || cookie_is_truthy("JSTEP_COOKIE___grading_Error")) {
	$ERROR_MODE = TRUE;
}

# flagrandomize parameter to cause requests to send back results in random (not ABC) order
if (param_is_truthy("flagrandomize")) {
	flag_set("flagrandomize", TRUE);
}
if (flag_get("flagrandomize") || param_is_truthy("randomize") || cookie_is_truthy("JSTEP_COOKIE___grading_Randomize")) {
	$RANDOMIZE = TRUE;
}

# flagstartyear param to start at a year other than 1900
if (param_is_truthy("flagstartyear")) {
	flag_set("startyear", TRUE);
}
if (flag_get("startyear") || cookie_is_truthy("JSTEP_COOKIE___grading_StartYear")) {
	$_REQUEST["startyear"] = "" . (1654 + rand(0, 500));
}

# delay for a given number of seconds to test loading animations
if ($DELAY == 0 && isset($_REQUEST["delay"])) {
	$DELAY = max(0, min(60, (int) filter_chars($_REQUEST["delay"])));
}
if ($DELAY > 0) {
	sleep($DELAY);
}


if ($ERROR_MODE) {
	# some other unknown request type; error
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request - Intentional error caused by checking the Error checkbox.");
}

if (has_param("startyear")) {
	$START_YEAR = max(0, min(999999, (int) trim($_REQUEST["startyear"])));
}


require_params("type");

$type = filter_chars($_REQUEST["type"]);
if ($type == "list") {
	query_list($RANDOMIZE);
} elseif ($type == "rank") {
	query_rank();
} elseif ($type == "meaning") {
	query_meaning();
} else {
	# some other unknown request type; error
	header("HTTP/1.1 400 Invalid Request");
	die("ERROR 400: Invalid request - Unrecognized query type: $type");
}


# functions

# list all baby names in text or HTML format
function query_list($randomize = FALSE) {
	global $LIST_FILE;

	if (!file_exists($LIST_FILE)) {
		header("HTTP/1.1 500 Server Error");
		die("ERROR 500: Server error - Unable to read input file $LIST_FILE");
	}
	
	$lines = file_get_contents($LIST_FILE);
	$lines = trim($lines);
	$lines = preg_split("/(\r?\n)+/", $lines);
	if ($randomize) {
		shuffle($lines);
	}

	if (isset($_REQUEST["format"]) && $_REQUEST["format"] == "html") {
		# client can specify an optional prefix to start the names to show (for auto-completer)
		$prefix = "";
		$substring = "";
		if (isset($_REQUEST["prefix"])) {
			$prefix = strtolower(filter_chars($_REQUEST["prefix"]));
		} elseif (isset($_REQUEST["substring"])) {
			$substring = strtolower(filter_chars($_REQUEST["substring"]));
		}
		
		print("<ul>\n");
		foreach ($lines as $line) {
			if ((!$prefix && !$substring) || 
					($prefix && strpos(strtolower($line), $prefix) === 0) ||
					($substring && strpos(strtolower($line), $substring) !== FALSE)) {
				print("  <li>$line</li>\n");
			}
		}
		print("</ul>\n");
	} else {
		# normal list query; return all names as plain text, one per line
		require_method("GET");
		header("Content-type: text/plain");
		print implode("\n", $lines);
	}
}

# output XML data about a baby name's ranking in each decade
function query_rank() {
	global $RANK_FILE;
	global $START_YEAR;

	require_method("GET");
	require_params("name");
	$name = filter_chars($_REQUEST["name"]);
	$line = get_file_line($RANK_FILE, $name);

	header("Content-type: application/xml");
	print "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n";
	$tokens = preg_split("/[ ]+/", $line);
	print "<baby name=\"" . $tokens[0] . "\">\n";
	for ($i = 1; $i <= 11; $i++) {
		print "    <rank year=\"" . ($START_YEAR + 10 * ($i - 1)) . "\">" . $tokens[$i] . "</rank>\n";
	}
	print "</baby>\n";
}

# output a plain-text line describing a name's origin/meaning
function query_meaning() {
	global $MEANINGS_FILE;

	require_method("GET");
	require_params("name");
	$name = filter_chars($_REQUEST["name"]);
	$line = get_file_line($MEANINGS_FILE, $name);

	header("Content-type: text/plain");
	print $line;
}

# Removes all characters except letters/numbers from a string, returns it
function filter_chars($str) {
	return preg_replace("/[^A-Za-z0-9_]*/", "", $str);
}

# Returns the first line from the given file that contains the given text,
# or dies with a 404 if not found.
function get_file_line($file_name, $name) {
	if (!file_exists($file_name)) {
		header("HTTP/1.1 500 Server Error");
		die("ERROR: Unable to read input file: $file_name");
	}
	
	$text = file_get_contents($file_name);
	$lines = preg_split("/[\r]?\n/", $text);
	foreach ($lines as $line) {
		if (preg_match("/^$name /i", $line)) {
			return trim($line);
		}
	}
	
	header("HTTP/1.1 404 File Not Found");
	die("ERROR 404: Not found - Baby name $name does not have any associated data.");
	return NULL;
}

# Ensures that the current HTTP request uses the given method
# (e.g. GET or POST), otherwise crashes with an HTTP 400 error.
function require_method($method) {
	if (!isset($_SERVER["REQUEST_METHOD"]) || $_SERVER["REQUEST_METHOD"] != strtoupper($method)) {
		header("HTTP/1.1 400 Invalid Request");
		die("ERROR 400: Invalid request - This type of query accepts only $method requests.");
	}
}

# Ensures the presence of certain query parameters, which may be passed as 
# var-args.  Dies with an HTTP 400 error if not found.
function require_params($params) {
	# allow calling as a var-args function
	if (!is_array($params)) {
		$params = func_get_args();
	}
	
	$missing = array();
	foreach ($params as $param) {
		if (!isset($_REQUEST[$param])) {
			$missing[] = $param;
		}
	}
	
	if (count($missing) > 0) {
		header("HTTP/1.1 400 Invalid Request");
		die("ERROR 400 - Invalid request.  Missing required parameter" . 
				(count($missing) > 1 ? "s" : "") . ": " .
				implode(", ", $missing) . "\n");
	}
}

function has_param($name) {
	return isset($_REQUEST[$name]) && $_REQUEST[$name] !== "";
}

function param_is_truthy($name) {
	return isset($_REQUEST[$name]) && (
			$_REQUEST[$name] === "true" ||
			$_REQUEST[$name] === "1" ||
			$_REQUEST[$name] === "on" ||
			$_REQUEST[$name] === "yes");
}

function cookie_is_truthy($name) {
	return isset($_COOKIE[$name]) && (
			$_COOKIE[$name] === "true" ||
			$_COOKIE[$name] === "1" ||
			$_COOKIE[$name] === "on" ||
			$_COOKIE[$name] === "yes");
}

function flag_set($name, $truefalse) {
	if ($truefalse) {
		touch("flag_{$name}.txt");
	} else {
		unlink("flag_{$name}.txt");
	}
}

function flag_get($name) {
	global $FLAG_TIME;
	$now = time();
	if (!file_exists("flag_{$name}.txt")) {
		# print("does not exist: flag_{$name}.txt\n");
		return FALSE;
	}
	$modtime = @filemtime("flag_{$name}.txt");
	$elapsed = $now - $modtime;
	# print("now=$now, mod=$modtime, elapsed=$elapsed\n");
	if ($modtime > 0 && $elapsed < $FLAG_TIME) {
		return TRUE;
	} else {
		unlink("flag_{$name}.txt");
		return FALSE;
	}
}
?>
