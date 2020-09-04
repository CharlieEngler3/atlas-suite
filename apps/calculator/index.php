<html>
	<head>
		<link href="../../style/dark.css" rel="stylesheet">
		
		<title>Calculator</title>

		<div class="user_bar">
        	<a href='../../index.php'>Home</a>
      	</div>
	</head>
	
	<body>
		<h1>Calculator</h1>
		
		<div class="calculator">
			<input class="calculator_result" type="text" readonly id="result">
			<br/>
			<button class="calculator_button" onclick="document.getElementById('result').value+='1';">1</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='2';">2</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='3';">3</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='4';">4</button>
			<br/>
			<button class="calculator_button" onclick="document.getElementById('result').value+='5';">5</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='6';">6</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='7';">7</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='8';">8</button>
			<br/>
			<button class="calculator_button" onclick="document.getElementById('result').value+='9';">9</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='0';">0</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='.';">.</button>
			<button class="calculator_button" onclick="document.getElementById('result').value=eval(document.getElementById('result').value);">=</button>
			<br/>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='+';">+</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='-';">-</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='*';">×</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='/';">÷</button>
			<br/>
			<button class="calculator_clear_button" onclick="document.getElementById('result').value='';">Clear</button>
		</div>
	</body>
</html>
