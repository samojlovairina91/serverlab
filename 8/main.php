<?php
// объявляем класс контроллера
class Controller
{
    // метод sayHello возвращает приветствие
    public function sayHello(string $name)
    {
        return "Привет, " . htmlspecialchars($name);
    }

    // метод sayBye возвращает прощание
    public function sayBye(string $name)
    {
        return "Пока, " . htmlspecialchars($name);
    }
}

// получаем параметр route из адресной строки
$route = $_GET['route'] ?? '';

// переменная, в которую будем складывать содержимое страницы (то что в правой колонке)
$content = '';
// переменная для заголовка страницы 
$title = 'Мой блог';

// проверяем, начинается ли маршрут с "hello/"
// strpos ищет подстроку; === 0 означает "найдено в самом начале строки"
if (strpos($route, 'hello/') === 0) {
    // отрезаем первые 6 символов ("hello/"), остаётся только имя
    $name = substr($route, 6);
    // создаём объект контроллера
    $ctrl = new Controller();
    // вызываем метод sayHello, результат оборачиваем в тег <h2>
    $content = "<h2>" . $ctrl->sayHello($name) . "</h2>";
    // меняем заголовок страницы на "Страница приветствия"
    $title = "Страница приветствия";
}
// если маршрут начинается с "bye/"
elseif (strpos($route, 'bye/') === 0) {
    // отрезаем первые 4 символа ("bye/"), остаётся имя
    $name = substr($route, 4);
    $ctrl = new Controller();
    $content = "<h2>" . $ctrl->sayBye($name) . "</h2>";
    $title = "Страница прощания";
}
// если маршрут не подходит ни под одно условие (пустой или неизвестный)
else {
    $content = "<h2>Главная страница</h2><p>Добро пожаловать в мой блог.</p>";
    $title = "Мой блог";
}


$layout = <<<HTML
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <!-- сюда подставляется переменная $title -->
    <title>$title</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

<table class="layout">
    <tr>
        <td colspan="2" class="header">Мой блог</td>
    </tr>
    <tr>
        <td>
            <!-- сюда подставляется содержимое страницы -->
            $content
        </td>
        <td width="300px" class="sidebar">
            <div class="sidebarHeader">Меню</div>
            <ul>
                <!-- ссылки с параметрами маршрута -->
                <li><a href="?route=">Главная</a></li>
                <li><a href="?route=hello/Иван">Сказать "Привет"</a></li>
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

// выводим готовую страницу в браузер
echo $layout;
?>
