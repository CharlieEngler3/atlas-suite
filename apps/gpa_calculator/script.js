//Global array definition
var userLetterGrades = [];

//Dropdown reference
document.getElementById("letterGrades").value;

//Function declaration
function ProcessGrade()
{
    //Local array definition
    let gradeThresholds = [95, 80, 70, 60];
    let letterGrades = ["A", "B", "C", "D", "F"];

    //Local variable definition
    let grade = document.getElementById("grade").value;

    let numberGrade = parseFloat(grade);

    let letterGradeValue;

    //Simple loop
    for(let i = 0; i < 4; i++)
    {
        if(numberGrade >= gradeThresholds[i])
        {
            letterGradeValue = i;
            break;
        }
        
        if(i == 3 && numberGrade < gradeThresholds[i])
        {
            letterGradeValue = 4;
        }
    }

    //Reference to the header displaying the grade
    document.getElementById("LetterGrade").innerHTML = letterGrades[letterGradeValue];

    //Pushing a value into an array
    userLetterGrades.push(letterGrades[letterGradeValue]);
}

function ShowFinal()
{
    //Adding a new html element inside of a containing element
    document.getElementById("container").createElement("H3");
}