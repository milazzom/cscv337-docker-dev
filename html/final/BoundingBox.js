var script = document.createElement("script");
script.type = "text/javascript";
script.src = "http://www.movable-type.co.uk/scripts/latlon.js";

document.body.appendChild(script);

LatLon.prototype.boundingBox = function (distance) { 
    return [this.destinationPoint(-90, distance).lon, this.destinationPoint(180, distance).lat, this.destinationPoint(90, distance).lon, this.destinationPoint(0, distance).lat,]; 
}

function convertMilesToKilometers(distanceInMiles) {
    return distanceInMiles * 1.609344;
}