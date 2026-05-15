<?php
// Функция удаления контакта: показывает список контактов, при клике удаляет выбранный
function renderDelete() {
    // Открываем базу данных
    $db = new SQLite3('database.sqlite');

    // Получаем список всех контактов (нужны id, фамилия, имя, отчество)
    // Сортируем по фамилии и имени для удобства
    $result = $db->query("SELECT id, lastname, firstname, middlename FROM contacts ORDER BY lastname, firstname");
    $contacts = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $contacts[] = $row;  // Заполняем массив контактами
    }

    // Переменная для сообщения об успехе или ошибке
    $message = '';

    // Проверяем, был ли передан параметр delete_id (какой контакт удаляем)
    if (isset($_GET['delete_id'])) {
        $delete_id = (int)$_GET['delete_id'];  // Превращаем в целое число

        // Сначала получаем фамилию контакта (чтобы потом вывести в сообщении)
        $stmt = $db->prepare("SELECT lastname FROM contacts WHERE id = :id");
        $stmt->bindValue(':id', $delete_id, SQLITE3_INTEGER);
        $res = $stmt->execute();
        $contact = $res->fetchArray(SQLITE3_ASSOC);

        // Если контакт с таким id существует
        if ($contact) {
            $lastname = $contact['lastname'];  // Запоминаем фамилию

            // Удаляем контакт из базы
            $stmt = $db->prepare("DELETE FROM contacts WHERE id = :id");
            $stmt->bindValue(':id', $delete_id, SQLITE3_INTEGER);

            if ($stmt->execute()) {
                // Если удаление успешно - выводим сообщение с фамилией удалённого
                $message = "<div class='success'>Запись с фамилией $lastname удалена</div>";
                // Перезагружаем страницу, чтобы обновить список (уберем удалённый контакт)
                header("Location: index.php?menu=delete");
                exit;  // Прерываем выполнение скрипта после редиректа
            } else {
                $message = "<div class='error'>Ошибка удаления</div>";
            }
        }
    }

    // Формируем HTML: сначала выводим сообщение (если есть)
    $html = $message;
    $html .= '<div class="edit-list">';

    // Для каждого контакта создаём ссылку
    foreach ($contacts as $c) {
        // Формируем инициалы: первая буква имени + точка + первая буква отчества + точка
        $initials = mb_substr($c['firstname'], 0, 1) . '.' . mb_substr($c['middlename'], 0, 1) . '.';
        // Ссылка ведёт на эту же страницу с параметром delete_id (при клике удалится этот контакт)
        $html .= "<a href='index.php?menu=delete&delete_id={$c['id']}'>"
                 . htmlspecialchars($c['lastname']) . " " . $initials . "</a><br>";
    }
    $html .= '</div>';

    // Закрываем базу данных
    $db->close();

    // Возвращаем готовый HTML
    return $html;
}
?>