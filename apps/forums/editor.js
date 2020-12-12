editor = document.getElementById("editor").getContext("2d");

fontSize = 12;

editor.font = fontSize.toString() + "px Arial";

editorWidth = 850;
editorHeight = 1100;

editor.beginPath();
editor.rect(0, 0, editorWidth, editorHeight);
editor.stroke();

let x = 12;
let y = 12;

let modifierActive = false;

let text = [];

let letters = ["a","b","c","d","e","f","g","h","i","j","k","l","m","n","o","p","q","r","s","t","u","v","w","x","y","z"," ",".",",","'","\"","?","!","@","#","$","%","^","&","*","(",
               ")","-","_","=","+","\\","|","<",">","/","~","`","[","]","{","}",":",";","0","1","2","3","4","5","6","7","8","9","A","B","C","D","E","F","G","H","I","J","K","L","M",
               "N","O","P","Q","R","S","T","U","V","W","X","Y","Z"];

document.addEventListener('keydown', function(event)
{
    if(event.code == "ControlLeft")
    {
        UpdateBody("Control");
        console.log("Control");
        return;
    }

    if(modifierActive)
    {
        UpdateBody(event.key.toLowerCase());
    }

    if(letters.includes(event.key.toLowerCase()) && !modifierActive)
    {
        event.preventDefault();
        text.push(event.key);
        UpdateBody("");
    }

    if(event.code == "Enter")
    {
        text.push(new Letter("newline",0));
        UpdateBody("");
    }

    if(event.code == "Backspace")
    {
        event.preventDefault();
        text.pop();
        UpdateBody("");
    }

    if(event.code == "Tab")
    {
        event.preventDefault();
        text.push(new Letter("tab",0));
        UpdateBody("");
    }
});

function UpdateBody(modifier)
{
    if(modifier == "")
    {
        editor.clearRect(0, 0, editorWidth, editorHeight);

        editor.beginPath();
        editor.rect(0, 0, editorWidth, editorHeight);
        editor.stroke();

        x = fontSize;
        y = 12;

        editor.fillText(text.join(""), x, y);

        editor.beginPath();
        editor.rect(x, y-fontSize, 2, y);
        editor.fill();
    }
    else
    {
        if(modifier == "Control")
        {
            modifierActive = true;
            return;
        }

        if(modifier == "a")
        {
            console.log("Ctrl + a");
        }

        modifierActive = false;
    }
}

function FindIndex(needle, haystack)
{
    for(let i = 0; i < haystack.length; i++)
    {
        if(haystack[i] == needle)
        {
            return i;
        }
    }
}