<?php
// Функция показывает форму добавления контакта и обрабатывает отправку
function renderAdd() {
    // Переменная для хранения сообщения об успехе или ошибке
    $message = '';

    // Проверяем, была ли отправлена форма (метод POST и нажата кнопка add)
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add'])) {

        // Открываем базу данных
        $db = new SQLite3('database.sqlite');

        // Готовим SQL-запрос с плейсхолдерами (:lastname, :firstname и т.д.)
        $stmt = $db->prepare("INSERT INTO contacts (lastname, firstname, middlename, gender, birthday, phone, address, email, comment) 
                              VALUES (:lastname, :firstname, :middlename, :gender, :birthday, :phone, :address, :email, :comment)");

        // Подставляем реальные значения из формы вместо плейсхолдеров
        // SQLITE3_TEXT означает, что данные - текст
        $stmt->bindValue(':lastname', $_POST['lastname'], SQLITE3_TEXT);
        $stmt->bindValue(':firstname', $_POST['firstname'], SQLITE3_TEXT);
        $stmt->bindValue(':middlename', $_POST['middlename'], SQLITE3_TEXT);
        $stmt->bindValue(':gender', $_POST['gender'], SQLITE3_TEXT);
        $stmt->bindValue(':birthday', $_POST['birthday'], SQLITE3_TEXT);
        $stmt->bindValue(':phone', $_POST['phone'], SQLITE3_TEXT);
        $stmt->bindValue(':address', $_POST['address'], SQLITE3_TEXT);
        $stmt->bindValue(':email', $_POST['email'], SQLITE3_TEXT);
        $stmt->bindValue(':comment', $_POST['comment'], SQLITE3_TEXT);

        // Выполняем запрос. Если успешно - зелёное сообщение, если нет - красное
        if ($stmt->execute()) {
            $message = '<div class="success">Запись добавлена</div>';
        } else {
            $message = '<div class="error">Ошибка: запись не добавлена</div>';
        }

        // Закрываем базу
        $db->close();
    }

    // Формируем HTML-код формы
    $html = $message;  // Сначала выводим сообщение (если есть)
    $html .= '<form method="post">';  // method="post" - данные отправляются скрыто, не в URL
    $html .= '<label>Фамилия:</label> <input type="text" name="lastname" required><br>';
    $html .= '<label>Имя:</label> <input type="text" name="firstname" required><br>';
    $html .= '<label>Отчество:</label> <input type="text" name="middlename"><br>';
    $html .= '<label>Пол:</label> <select name="gender"><option value="М">М</option><option value="Ж">Ж</option></select><br>';
    $html .= '<label>Дата рождения:</label> <input type="date" name="birthday"><br>';
    $html .= '<label>Телефон:</label> <input type="text" name="phone"><br>';
    $html .= '<label>Адрес:</label> <input type="text" name="address"><br>';
    $html .= '<label>Email:</label> <input type="email" name="email"><br>';
    $html .= '<label>Комментарий:</label> <textarea name="comment"></textarea><br>';
    $html .= '<input type="submit" name="add" value="Добавить">';
    $html .= '</form>';

    // Возвращаем форму (она вставится в index.php вместо $content)
    return $html;
}
?>