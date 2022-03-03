function getNameData() {
    var name = document.getElementById("name").value;
    var httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function() {
        switch(httpRequest.readyState) {
            case 0:
                console.log("Request is not initialized.");
                break;
            case 1:
                console.log("Server connection established.");
                break;
            case 2:
                console.log("Request received");
                break;
            case 3:
                console.log("Processing request");
                break;
            case 4:
                console.log("Request is finished and the response is ready!  This is where you want to process data.");
                break;

        }
    };
    httpRequest.open("GET", "http://u.arizona.edu/~milazzom/cscv337/sp19/hw5/babynames.php?type=rank&name=" + encodeURIComponent(name));
    httpRequest.send();
}