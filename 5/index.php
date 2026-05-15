<?php
// Подключаем файлы с функциями
require_once 'menu.php';
require_once 'viewer.php';
require_once 'add.php';
require_once 'edit.php';
require_once 'delete.php';

// Определяем, какой пункт меню выбран. По умолчанию 'view' (просмотр)
$active_menu = 'view';
if (isset($_GET['menu'])) {
    $active_menu = $_GET['menu'];
}

// Определяем тип сортировки. По умолчанию 'id' (порядок добавления)
$sort = 'id';
if (isset($_GET['sort'])) {
    $sort = $_GET['sort'];
}

// Номер страницы для пагинации
$page = 1;
if (isset($_GET['page'])) {
    $page = (int)$_GET['page'];
}

// Вызываем функцию из menu.php, которая возвращает HTML с меню
$menu_html = renderMenu($active_menu, $sort);

// В зависимости от выбранного пункта меню вызываем нужную функцию
$content = '';
if ($active_menu == 'view') {
    $content = renderViewer($sort, $page);
} elseif ($active_menu == 'add') {
    $content = renderAdd();
} elseif ($active_menu == 'edit') {
    $content = renderEdit();
} elseif ($active_menu == 'delete') {
    $content = renderDelete();
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Записная книжка</title>
    <style>
        body { font-family: Arial; margin: 20px; }
        .menu { margin-bottom: 20px; }
        .menu a, .submenu a {
            display: inline-block;
            padding: 10px 15px;
            margin: 5px;
            background-color: blue;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .menu a.active, .submenu a.active {
            background-color: red;
        }
        .submenu a {
            background-color: lightblue;
            color: black;
            font-size: 14px;
        }
        table {
            border-collapse: collapse;
            width: 100%;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .pagination a {
            margin: 0 5px;
            padding: 5px 10px;
            text-decoration: none;
            border: 1px solid #ccc;
        }
        .pagination a:hover {
            border: 2px solid #333;
        }
        .success {
            color: green;
            font-weight: bold;
        }
        .error {
            color: red;
            font-weight: bold;
        }
        form label {
            display: inline-block;
            width: 120px;
            margin-top: 10px;
        }
        form input, form textarea, form select {
            width: 250px;
            padding: 5px;
        }
        .edit-list {
            margin-bottom: 20px;
        }
        .edit-list a {
            display: inline-block;
            margin: 5px;
            padding: 5px 10px;
            background-color: #eee;
            text-decoration: none;
            color: black;
            border-radius: 3px;
        }
        .edit-list a.current {
            background-color: red;
            color: white;
        }
    </style>
</head>
<body>
    <?php echo $menu_html; ?>
    <?php echo $content; ?>
</body>
</html>