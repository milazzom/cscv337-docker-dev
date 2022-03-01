function computeFibonacci()
{
    console.log("Compute button clicked!");
    var textInputField = document.getElementById("n_input");
    console.log("You entered:", textInputField.value, " in the text box");
    if(isNaN(textInputField.value))
    {
        alert("You must enter a number!");
        textInputField.value = "";
        return;
    }
    var n = parseInt(textInputField.value);
    console.log("The numeric value of the input is: ", n);
    var fibResult = iterativeFibonacci(n);
    document.getElementById("result").innerText = "The Fibonacci number at N = " + n + " is:" + fibResult;
}

function getNumberForCharacter(character)
{
    let characters = "abcdefghijklmnopqrstuvwxyz";
    var outputIndex = -1;
    
}

var someString = "This is a user provided string";
for(var i = 0; i < someString.length; i++)
{
    var isUpper = false;
var code = someString.charCodeAt(i);
if(code >= 65 && code <= 90) {
	console.log(someString[i], " is upper case");
    isUpper = true;
} else {
	console.log(someString[i], " is lower case");
    console.log(someString[i].toUpperCase(), " is the upper case version ");
}

    var cipherText = "abcdefghijklmnopqrstuvwxyz";
    var outputCharacter = cipherText[19];
    console.log("Cipher char: ", outputCharacter);
    if(isUpper) {
        console.log(outputCharacter.toUpperCase())
    } else {

    }

}

function recursiveFibonacci(nthNumber) {
    if(nthNumber == 0)
    {
        return 0;
    }
    if(nthNumber == 1) {
        return 1;
    }
    return recursiveFibonacci(nthNumber - 1) + recursiveFibonacci(nthNumber - 2);
}

function iterativeFibonacci(nthNumber) {
    if(nthNumber == 0)
    {
        return 0;
    }
    if(nthNumber == 1) {
        return 1;
    }
    // fn=2 -> 1, fn=3 -> 2
    var fibNMinus1 = 1;
    var fibNMinus2 = 0;
    var fibResult = 1;

    for(var i = 2; i <= nthNumber; i++)
    {
        fibResult = fibNMinus1 + fibNMinus2;
        fibNMinus2 = fibNMinus1;
        fibNMinus1 = fibResult;
    }

    return fibResult;
}
