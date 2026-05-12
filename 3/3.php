<?php

$equation = "X + 67 = 129";

// Убираем пробелы (X + 67 = 129 → X+67=129)
$eq = str_replace(' ', '', $equation);

// Разбиваем на левую и правую часть (X+67 и 129)
$parts = explode('=', $eq);
$left = $parts[0];   
$right = $parts[1]; 

// Ищем оператор в левой части (+, -, *, /)
if (strpos($left, '+') !== false) {
    $operator = '+';
    // Разбиваем левую часть на два числа (X и 67)
    $operands = explode('+', $left);
    $first = $operands[0];   // X
    $second = $operands[1];  // 67
    
    // Если X слева (X + 67 = 129)
    if ($first == 'X' || $first == 'x') {
        $x = $right - $second;      // 129 - 67
        $position = "X слева от плюса";
    }
    // Если X справа (67 + X = 129)
    elseif ($second == 'X' || $second == 'x') {
        $x = $right - $first;       // 129 - 67
        $position = "X справа от плюса";
    }
}

// Выводим результат
echo "Уравнение: $equation\n";
echo "Оператор: $operator\n";
echo "Где X: $position\n";
echo "Результат: X = $x\n";
?>