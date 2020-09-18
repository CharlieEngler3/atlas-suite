<html>
	<head>
		<link href="../../style/dark.css" rel="stylesheet">
		
		<title>Calculator</title>

		<div class="user_bar">
        	<a href='../../index.php'>Home</a>
		  </div>
		  
		<script src="script.js" defer></script>
	</head>
	
	<body>
		<h1>Calculator</h1>
		
		<div class="calculator" style="touch-action: pan-y;">
			<input class="calculator_result" type="text" readonly id="result_displayed">
			<input type="hidden" id="result">
			<br/>
			<button class="calculator_button" onclick="document.getElementById('result').value+='1';Button('1');">1</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='2';Button('2');">2</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='3';Button('3');">3</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='4';Button('4');">4</button>
			<br/>
			<button class="calculator_button" onclick="document.getElementById('result').value+='5';Button('5');">5</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='6';Button('6');">6</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='7';Button('7');">7</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='8';Button('8');">8</button>
			<br/>
			<button class="calculator_button" onclick="document.getElementById('result').value+='9';Button('9');">9</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='0';Button('0');">0</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='.';Button('.');">.</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='-';Button('-');">(-)</button>
			<br/>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='+';Button('+');">+</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='-';Button('-');">-</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='*';Button('*');">×</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='/';Button('/');">÷</button>
			<br/>
			<button class="calculator_clear_button" onclick="document.getElementById('result').value= Equals();Button('equals');">=</button>
			<br/>
			<button class="calculator_clear_button" onclick="document.getElementById('result').value = Backspace();Button('nothing');">Backspace</button>
			<br/>
			<button class="calculator_clear_button" onclick="document.getElementById('result').value='';Button('null');">Clear</button>
			<br/>
			<br/>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='(';Button('(');">(</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+=')';Button(')');">)</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='Math.sqrt(';Button('Math.sqrt(');">√</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='**';Button('**');">^</button>
			<br/>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='Math.sin(';Button('Math.sin(');">sin</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='Math.asin(';Button('Math.asin(');">asin</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='Math.cos(';Button('Math.cos(');">cos</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='Math.acos(';Button('Math.acos(');">acos</button>
			<br/>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='Math.tan(';Button('Math.tan(');">tan</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='Math.atan';Button('Math.atan');">atan</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='Math.log(';Button('Math.log(');">ln</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result_displayed').value = DecimalToFraction();">d⇿f</button>
		</div>
	</body>
</html>
