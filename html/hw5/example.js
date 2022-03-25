function runOnLoad() {
    getNames();
    document.getElementById("exampleDropDown").onchange = selectionMade;
}

function getNames() {

}

function selectionMade() {
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