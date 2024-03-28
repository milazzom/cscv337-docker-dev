<?php
    $movie = $_GET['film'];

    function loadMovieInfo() {

    }

    function loadReviews() {

    }

    function loadOverview() {
        $markup = "<div>This is overview data";

        # process files here... appending data to $markup variable

        $markup = $markup . "</div>";
        return $markup;
    }


    $overviewMarkup = loadOverview();
    print_r($overviewMarkup);


?>