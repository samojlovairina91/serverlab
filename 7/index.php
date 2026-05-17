<?php
// объявляем класс контроллера
class Controller
{
    // метод sayBye принимает строку (имя) и возвращает фразу прощания
    public function sayBye(string $name)
    {
        // htmlspecialchars защищает от XSS-атак (превращает < > & в безопасные символы)
        return "Пока, " . htmlspecialchars($name);
    }
}

// получаем параметр route из адресной строки, например ?route=bye/Иван
// если параметра нет, то $route будет пустой строкой
$route = $_GET['route'] ?? '';

// переменная, в которую будем складывать содержимое страницы
$content = '';

// проверяем, начинается ли строка $route с "bye/"
// strpos ищет подстроку; === 0 означает "найдено в самом начале"
if (strpos($route, 'bye/') === 0) {
    // отрезаем первые 4 символа ("bye/"), остаётся только имя
    $name = substr($route, 4);
    // создаём объект контроллера
    $ctrl = new Controller();
    // вызываем метод sayBye и оборачиваем результат в тег <h2>
    $content = "<h2>" . $ctrl->sayBye($name) . "</h2>";
} else {
    // если параметр route не начинается с "bye/", показываем главную страницу
    $content = "<h2>Главная страница</h2><p>Добро пожаловать в мой блог.</p>";
}
$layout = <<<HTML
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Мой блог</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<table class="layout">
    <tr>
        <td colspan="2" class="header">Мой блог</td>
    </tr>
    <tr>
        <td>
            $content
        </td>
        <td width="300px" class="sidebar">
            <div class="sidebarHeader">Меню</div>
            <ul>
                <li><a href="?route=">Главная</a></li>
                <li><a href="?route=bye/Иван">Сказать "Пока"</a></li>
            </ul>
        </td>
    </tr>
    <tr>
        <td class="footer" colspan="2">Все права защищены (c) Мой блог</td>
    </tr>


</body>
</html>
HTML;

echo $layout;
?>