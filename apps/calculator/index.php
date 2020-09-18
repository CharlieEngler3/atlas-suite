<html>
	<head>
		<link href="../../style/dark.css" rel="stylesheet">
		
		<title>Calculator</title>

		<div class="user_bar">
        	<a href='../../index.php'>Home</a>
		  </div>
		  
		<script>
			function Button()
			{
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

				numerator = minusWhole * 10**numDigits;
				denominator = 10**numDigits;

				gcf = GCF(numerator, denominator);

				if(gcf > 1)
				{
					numerator = numerator / gcf;
					denominator = denominator / gcf;
				}

				if(parseFloat(wholeNumber) > 0)
				{
					return wholeNumber.toString() + " " + numerator + "/" + denominator;
				}
				else
				{
					return numerator + "/" + denominator;
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
		</script>
	</head>
	
	<body>
		<h1>Calculator</h1>
		
		<div class="calculator" style="touch-action: pan-y;">
			<input class="calculator_result" type="text" readonly id="result_displayed">
			<input type="hidden" id="result">
			<br/>
			<button class="calculator_button" onclick="document.getElementById('result').value+='1';Button();">1</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='2';Button();">2</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='3';Button();">3</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='4';Button();">4</button>
			<br/>
			<button class="calculator_button" onclick="document.getElementById('result').value+='5';Button();">5</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='6';Button();">6</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='7';Button();">7</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='8';Button();">8</button>
			<br/>
			<button class="calculator_button" onclick="document.getElementById('result').value+='9';Button();">9</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='0';Button();">0</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='.';Button();">.</button>
			<button class="calculator_button" onclick="document.getElementById('result').value+='-';Button();">(-)</button>
			<br/>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='+';Button();">+</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='-';Button();">-</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='*';Button();">×</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='/';Button();">÷</button>
			<br/>
			<button class="calculator_clear_button" onclick="document.getElementById('result').value=eval(document.getElementById('result').value);Button();">=</button>
			<br/>
			<button class="calculator_clear_button" onclick="document.getElementById('result').value = document.getElementById('result').value.slice(0, -1);Button();">Backspace</button>
			<br/>
			<button class="calculator_clear_button" onclick="document.getElementById('result').value='';Button();">Clear</button>
			<br/>
			<br/>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='(';Button();">(</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+=')';Button();">)</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='Math.sqrt(';Button();">√</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='**';Button();">^</button>
			<br/>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='Math.sin(';Button();">sin</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='Math.asin(';Button();">asin</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='Math.cos(';Button();">cos</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='Math.acos(';Button();">acos</button>
			<br/>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='Math.tan(';Button();">tan</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='Math.atan';Button();">atan</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result').value+='Math.log(';Button();">ln</button>
			<button class="calculator_basic_operation_button" onclick="document.getElementById('result_displayed').value = DecimalToFraction();">d⇿f</button>
		</div>
	</body>
</html>
