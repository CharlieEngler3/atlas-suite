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
        <h3 id="state">Not Started</h3>
        <h3 id="countdown">-- m -- s</h3>
        <button onclick = "run_clock();">Start</button>
        <button onclick = "reset();">Reset</button>
    </body>
</html>