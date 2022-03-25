function runOnLoad() {
    getNames();
    document.getElementById("exampleDropDown").onchange = selectionMade;
}

function getNames() {
    var select = document.getElementById("exampleDropDown");
    var httpRequest = new XMLHttpRequest();
    httpRequest.onreadystatechange = function() {
        
        if(httpRequest.readyState == 4 && httpRequest.status == 200) {
            console.log("This request succeeded!", httpRequest.responseText);
            var names = httpRequest.responseText.split("\n");
            console.log("There are " + names.length + " names returned!");
            
            for(var i = 0; i < names.length; i++) {
                var currentName = names[i];
                var option = new Option(currentName, currentName);
                select.add(option, false);
                
            }
        }
    };
    httpRequest.open("GET", "http://u.arizona.edu/~milazzom/cscv337/sp19/hw5/babynames.php?type=list");
    httpRequest.send();
}

function selectionMade() {
    var selectedName = document.getElementById("exampleDropDown").value;
    console.log("The selected name is: ", selectedName);
    getNameMeaning();
    getNameRankData();
}

function getNameRankData() {
    console.log("Getting name rank data!");
}

function getNameMeaning() {
    console.log("Getting name meaning data!");
}

document.addEventListener('DOMContentLoaded', function() {
    runOnLoad();
  }, false);