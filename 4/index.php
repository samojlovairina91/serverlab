<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Калькулятор</title>
    <style>
        body {
            font-family: Arial;
            text-align: center;
            margin-top: 50px;
        }
        .calculator {
            display: inline-block;
            border: 2px solid #333;
            padding: 20px;
            border-radius: 10px;
            background: #f9f9f9;
        }
        .display {
            width: 100%;
            height: 50px;
            font-size: 24px;
            text-align: right;
            margin-bottom: 15px;
            padding: 5px;
            border: 1px solid #ccc;
            background: white;
        }
        .buttons {
            display: grid;
            grid-template-columns: repeat(5, 60px);
            gap: 10px;
        }
        button {
            height: 50px;
            font-size: 18px;
            cursor: pointer;
        }
        .equals {
            background: #4CAF50;
            color: white;
        }
        .clear {
            background: #f44336;
            color: white;
        }
    </style>
</head>
<body>
<div class="calculator">
    <input type="text" id="display" class="display" value="">
    <div class="buttons">
        <button onclick="add('7')">7</button>
        <button onclick="add('8')">8</button>
        <button onclick="add('9')">9</button>
        <button onclick="add('+')">+</button>
        <button onclick="add('(')">(</button>

        <button onclick="add('4')">4</button>
        <button onclick="add('5')">5</button>
        <button onclick="add('6')">6</button>
        <button onclick="add('-')">-</button>
        <button onclick="add(')')">)</button>

        <button onclick="add('1')">1</button>
        <button onclick="add('2')">2</button>
        <button onclick="add('3')">3</button>
        <button onclick="add('*')">*</button>
        <button onclick="clearDisplay()" class="clear">C</button>

        <button onclick="add('0')">0</button>
        <button onclick="add('.')">.</button>
        <button onclick="calculate()" class="equals">=</button>
        <button onclick="add('/')">/</button>
        <button onclick="clearDisplay()">AC</button>
    </div>
</div>

<script>
    function add(value) {
        let display = document.getElementById('display');
        display.value += value;
    }

    function clearDisplay() {
        let display = document.getElementById('display');
        display.value = '';
    }

    function calculate() {
        let expression = document.getElementById('display').value;
        if (expression === '') return;

        fetch('calculate.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: 'expr=' + encodeURIComponent(expression)
        })
        .then(response => response.text())
        .then(data => {
            document.getElementById('display').value = data;
        });
    }
</script>
</body>
</html>