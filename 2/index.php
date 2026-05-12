<html>
<head>
    <title>Форма обратной связи</title>
    <style>
        body { font-family: Arial; margin: 0; padding: 0; }
        header { display: flex; align-items: center; gap: 20px; padding: 20px; background: #f0f0f0; }
        footer { text-align: center; padding: 15px; background: #333; color: white; margin-top: 40px; }
        main { max-width: 600px; margin: 0 auto; padding: 20px; }
        label, input, select, textarea { display: block; width: 100%; margin-top: 10px; margin-bottom: 15px; }
        input[type="checkbox"] { width: auto; display: inline-block; margin-right: 10px; }
        button { background: #007bff; color: white; border: none; padding: 10px 20px; cursor: pointer; margin-top: 10px; }
        .link-btn { display: inline-block; background: #28a745; color: white; padding: 10px 20px; text-decoration: none; margin-top: 20px; }
    </style>
</head>
<body>

<header>
    <img src="https://mospolytech.ru/themes/custom/mos_polytech/logo.svg" alt="Логотип" height="50">
    <h1>Форма обратной связи</h1>
</header>

<main>
    <form action="https://httpbin.org/post" method="POST">
        
        <label>Имя пользователя:</label>
        <input type="text" name="username" required>

        <label>E-mail пользователя:</label>
        <input type="email" name="email" required>

        <label>Тип обращения:</label>
        <select name="type">
            <option value="жалоба">Жалоба</option>
            <option value="предложение">Предложение</option>
            <option value="благодарность">Благодарность</option>
        </select>

        <label>Текст обращения:</label>
        <textarea name="message" rows="5" required></textarea>

        <label>Вариант ответа:</label>
        <input type="checkbox" name="notify_sms" value="sms"> СМС
        <input type="checkbox" name="notify_email" value="email"> E-mail

        <button type="submit">Отправить</button>
    </form>

    <a href="headers.php" class="link-btn">Перейти на 2 страницу</a>
</main>

<footer>
    Собрать сайт из двух страниц.

1 страница: Сверстать форму обратной связи. Отправку формы осуществить на URL: https://httpbin.org/post. Добавить кнопку для перехода на 2 страницу.

2 страница: вывести на страницу результат работы функции get_headers. Загрузить код в удаленный репозиторий. Залить на хостинг.
</footer>

</body>
</html>