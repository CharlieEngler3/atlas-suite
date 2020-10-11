var startTime = new Date(), endTime = new Date();
var state = 1;

function time_remaining(){
    var t = endTime - Date.parse(new Date());
	var seconds = Math.floor((t/1000) % 60);
	var minutes = Math.floor((t/1000/60) % 60);
	return {'minutes':minutes, 'seconds':seconds};
}

function run_clock(){
    state = 1;
    startTime = new Date();
    endTime.setTime(startTime.getTime() + (25 * 60 * 1000));
    document.getElementById("state").innerHTML = "Work!";

    function update_clock(){
		var t = time_remaining();
        document.getElementById("countdown").innerHTML = t.minutes + ' min ' + minTwoDigits(t.seconds) + ' sec';
        
        if(t.minutes <= 0 && t.seconds <= 0){
            if (state == 1){
                startTime = new Date();
                endTime.setTime(startTime.getTime() + (5 * 60 * 1000));
                document.getElementById("state").innerHTML = "Take a Break!";
                state = 0;
            }
            else {
                startTime = new Date();
                endTime.setTime(startTime.getTime() + (25 * 60 * 1000));
                document.getElementById("state").innerHTML = "Work!";
                state = 1;
            }
        }
    }
    
	update_clock(); 
	var timeinterval = setInterval(update_clock, 1000);
}

function minTwoDigits(n) {
    return (n < 10 ? '0' : '') + n;
}