result = [];

function Button(elem)
{
    if(elem != "null" && elem != "nothing" && elem != "equals")
    {
        result.push(elem);
    }
    else if(elem == "null")
    {
        result.length = 0;
    }
    else if(elem == "equals")
    {
        result.length = 0;

        result.push(eval(document.getElementById('result').value));
    }

    var modifiedValue = document.getElementById("result").value;

    modifiedValue = modifiedValue.replaceAll("Math.", "");
    modifiedValue = modifiedValue.replaceAll("**", "^");

    document.getElementById("result_displayed").value = modifiedValue;
}

function DecimalToFraction()
{
    if(document.getElementById("result_displayed").value.indexOf(".") > -1)
    {
        return Fraction(parseFloat(document.getElementById('result').value));
    }
    
    if(document.getElementById("result_displayed").value.indexOf("/") > -1)
    {
        return eval(document.getElementById("result_displayed").value).toString();
    }
}

function Fraction(decimal)
{
    if(decimal.toString().indexOf(".") < 0)
        return document.getElementById('result').value;

    wholeNumber = decimal.toString().split(".")[0];

    minusWhole = decimal - parseFloat(wholeNumber);

    numDigits = minusWhole.toString().split(".")[1].length;

    if(numDigits > 5)
    {
        return decimal.toString();
    }

    numerator = minusWhole * 10**numDigits;
    denominator = 10**numDigits;

    gcf = GCF(numerator, denominator);

    if(gcf > 1)
    {
        numerator = numerator / gcf;
        denominator = denominator / gcf;
    }
    else
    {
        return decimal.toString();
    }

    if(parseFloat(wholeNumber) > 0)
    {
        return "(" + wholeNumber.toString() + " " + numerator + "/" + denominator + ")";
    }
    else
    {
        return "(" + numerator + "/" + denominator + ")";
    }
}

function GCF(a, b) 
{
    if (b) 
    {
        return GCF(b, a % b);
    } 
    else 
    {
        return Math.abs(a);
    }
}

function Backspace()
{
    if(result.length > 0)
    {
        result.pop();

        return result.join("");
    }

    return "";
}

function Equals()
{
    return new Function('return ' + document.getElementById('result').value + ';')();
}