<?php

    class HockeyTeam {

        public $players;

    }

    header("Content-Type: application/json");

    $team = new HockeyTeam();
    $team->players = array("Mike", "Chris", "Dave", "Brian", "Dzastina", "Paul", "Terry", "Dana", "Chris", "Chris", "Marlon");
    echo json_encode($team);