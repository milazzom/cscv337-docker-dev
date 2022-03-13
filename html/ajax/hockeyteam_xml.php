<?php
$team = array("Mike", "Chris", "Dave", "Brian", "Dzastina", "Paul", "Terry", "Dana", "Chris", "Chris", "Marlon");
$xw = xmlwriter_open_memory();
xmlwriter_set_indent($xw, 1);
$res = xmlwriter_set_indent_string($xw, ' ');

xmlwriter_start_document($xw, '1.0', 'UTF-8');

// The root element
xmlwriter_start_element($xw, 'hockey_team');


foreach ($team as $player) {
// Start a child element
xmlwriter_start_element($xw, 'player');
if($player == "Mike" || $player == "Andrew") {
    xmlwriter_write_attribute($xw, "role", "captain");
}
xmlwriter_text($xw, $player);
xmlwriter_end_element($xw); // tag11
}

xmlwriter_end_element($xw);

header("Content-Type: application/xml");
echo xmlwriter_output_memory($xw);