<html>
<head>
    <title>Результат get_headers</title>
    <style>
        body { font-family: Arial; margin: 0; padding: 0; }
        header { display: flex; align-items: center; gap: 20px; padding: 20px; background: #f0f0f0; }
        footer { text-align: center; padding: 15px; background: #333; color: white; margin-top: 40px; }
        main { max-width: 800px; margin: 0 auto; padding: 20px; }
        textarea { width: 100%; height: 400px; font-family: monospace; font-size: 14px; }
        .back-link { display: inline-block; background: #007bff; color: white; padding: 10px 20px; text-decoration: none; margin-top: 20px; }
    </style>
</head>
<body>

<header>
    <img src="https://mospolytech.ru/themes/custom/mos_polytech/logo.svg" alt="Логотип" height="50">
    <h1>Результат get_headers</h1>
</header>

<main>
    <h3>Заголовки с https://httpbin.org:</h3>
    <textarea readonly>
<?php
// Получаем заголовки с httpbin.org
$url = "https://httpbin.org";
$headers = get_headers($url, 1);

if ($headers) {
    echo "URL: " . $url . "\n\n";
    echo "РЕЗУЛЬТАТ get_headers:\n";
    echo "======================\n\n";
    
  
    foreach ($headers as $key => $value) {
        if (is_array($value)) {
            echo $key . ": \n";
            foreach ($value as $subvalue) {
                echo "    " . $subvalue . "\n";
            }
        } else {
            echo $key . ": " . $value . "\n";
        }
    }
} else {
    echo "Ошибка: не удалось получить заголовки с $url";
}
?>
    </textarea>
    
    <br>
    <a href="index.php" class="back-link">← Вернуться к форме</a>
</main>

<footer>
    Собрать сайт из двух страниц.

1 страница: Сверстать форму обратной связи. Отправку формы осуществить на URL: https://httpbin.org/post. Добавить кнопку для перехода на 2 страницу.

2 страница: вывести на страницу результат работы функции get_headers. Загрузить код в удаленный репозиторий. Залить на хостинг.
</footer>

</body>
</html>
