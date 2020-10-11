<html>
    <head>
        <title>Pomodoro Timer</title>

        <link rel="stylesheet" href="../../style/dark.css"/>
        <script src="script.js" defer></script>

        <div class="user_bar">
            <a href="../../index.php">Home</a>
        </div>
    </head>

    <body>
        <h1>Pomodoro Timer</h1>
        <div class="pomodoro">
            <h3 class="pomodoro_text" id="state">Not Started</h3>
            <h3 class="pomodoro_text" id="countdown">-- m -- s</h3>
            <button class="pomodoro_button" onclick="run_clock();">Start</button>
            <button class="pomodoro_button" onclick="reset();">Reset</button>
        </div>
    </body>
</html>