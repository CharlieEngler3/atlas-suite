//Global array definition
// var userLetterGrades = [];

var totalScore = 0, rawTotal = 0, totalCredits = 0, classCount = 0;

function calcScore(level, rawGrade, credits){
    if (level == "CP") return (rawGrade + 1.00) * credits;
    else if (level == "AP/Honors") return (rawGrade + 2.00) * credits;
    else return rawGrade * credits;
}

function ProcessGrade(){
    let gradeValues = [4.33, 4.00, 3.67, 3.33, 3.00, 2.67, 2.33, 2.00, 1.67, 1.33, 1.00, 0];
    let letterGrades = ["A+", "A", "A-", "B+", "B", "B-", "C+", "C", "C-", "D+", "D", "F"];

    let grade = document.getElementById("letterGrades").value;
    let level = document.getElementById("difficulty").value;
    let credit = document.getElementById("creditNumber").value;

    if (grade == "---" || level == "---" || credit == "---") return;

    totalCredits += parseInt(credit);

    let letterGradeValue;
    for(let i = 0; i < 12; i++){
        if(grade == letterGrades[i]){
            letterGradeValue = i;
            break;
        }
    }

    rawTotal += gradeValues[letterGradeValue] * credit;
    totalScore += calcScore(level, gradeValues[letterGradeValue], credit);
    let ans = (totalScore/totalCredits).toFixed(3);
    let ans2 = (rawTotal/totalCredits).toFixed(3);
    classCount++;
    document.getElementById("WeightedGPA").innerHTML = ans;
    document.getElementById("UWGPA").innerHTML = ans2;
    document.getElementById("ClassCount").innerHTML = classCount;
}

function ClearGrades(){
    totalScore = 0;
    totalCredits = 0;
    document.getElementById("WeightedGPA").innerHTML = "---";
}

/*
function ShowFinal()
{
    //Adding a new html element inside of a containing element
    document.getElementById("container").createElement("H3");
}
*/