var startTime = new Date(), endTime = new Date();
var state = 1, x;
var pauseState = 1;

function remainder(){
    var t = endTime - Date.parse(new Date());
    var minutes = Math.floor((t/1000/60) % 60);
	var seconds = Math.floor((t/1000) % 60);
	return {'minutes':minutes, 'seconds':seconds};
}

function reset(){
    document.getElementById("state").innerHTML = "Not Started";
    document.getElementById("countdown").innerHTML = "-- m -- s";
    clearInterval(x);
}

function run_clock(){
    startTime = new Date();
    endTime.setTime(startTime.getTime() + (25 * 60 * 1000));
    document.getElementById("state").innerHTML = "Work!";

    function update_clock(){
		var t = remainder();
        document.getElementById("countdown").innerHTML = t.minutes + ' min ' + twoDig(t.seconds) + ' sec';
        
        if(t.minutes <= 0 && t.seconds <= 0){
            if (state == 1){
                startTime = new Date();
                endTime.setTime(startTime.getTime() + (5 * 60 * 1000 + 1000));
                document.getElementById("state").innerHTML = "Take a Break!";
                state = 0;
            }
            else {
                startTime = new Date();
                endTime.setTime(startTime.getTime() + (25 * 60 * 1000 + 1000));
                document.getElementById("state").innerHTML = "Work!";
                state = 1;
            }
        }
    }
    
	update_clock(); 
	x = setInterval(update_clock, 1000);
}

function twoDig(n) {
    return (n < 10 ? '0' : '') + n;
}