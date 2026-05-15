<?php
// Функция редактирования контакта: показывает список контактов и форму с данными выбранного
function renderEdit() {
    // Открываем базу данных
    $db = new SQLite3('database.sqlite');

    // Получаем список всех контактов (только id, фамилию и имя) для отображения в виде ссылок
    // Сортируем по фамилии, затем по имени
    $result = $db->query("SELECT id, lastname, firstname FROM contacts ORDER BY lastname, firstname");
    $contacts = [];
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $contacts[] = $row;  // Заполняем массив контактами
    }

    // Определяем, какой контакт сейчас редактируем
    // Если в URL передан edit_id - используем его, иначе берём первый контакт из списка (если есть)
    $edit_id = isset($_GET['edit_id']) ? (int)$_GET['edit_id'] : (count($contacts) > 0 ? $contacts[0]['id'] : 0);

    // Массив с пустыми значениями по умолчанию (на случай, если контактов нет)
    $contact_data = [
        'lastname' => '', 'firstname' => '', 'middlename' => '',
        'gender' => 'М', 'birthday' => '', 'phone' => '', 'address' => '',
        'email' => '', 'comment' => ''
    ];

    // Если есть ID редактируемой записи - загружаем её данные из базы
    if ($edit_id > 0) {
        $stmt = $db->prepare("SELECT * FROM contacts WHERE id = :id");
        $stmt->bindValue(':id', $edit_id, SQLITE3_INTEGER);
        $res = $stmt->execute();
        if ($row = $res->fetchArray(SQLITE3_ASSOC)) {
            $contact_data = $row;  // Заменяем пустой массив на реальные данные из БД
        }
    }

    // Обработка отправки формы сохранения
    $message = '';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
        // Готовим запрос на обновление записи
        $stmt = $db->prepare("UPDATE contacts SET 
            lastname = :lastname,
            firstname = :firstname,
            middlename = :middlename,
            gender = :gender,
            birthday = :birthday,
            phone = :phone,
            address = :address,
            email = :email,
            comment = :comment
            WHERE id = :id");

        // Подставляем значения из формы
        $stmt->bindValue(':id', $_POST['id'], SQLITE3_INTEGER);
        $stmt->bindValue(':lastname', $_POST['lastname'], SQLITE3_TEXT);
        $stmt->bindValue(':firstname', $_POST['firstname'], SQLITE3_TEXT);
        $stmt->bindValue(':middlename', $_POST['middlename'], SQLITE3_TEXT);
        $stmt->bindValue(':gender', $_POST['gender'], SQLITE3_TEXT);
        $stmt->bindValue(':birthday', $_POST['birthday'], SQLITE3_TEXT);
        $stmt->bindValue(':phone', $_POST['phone'], SQLITE3_TEXT);
        $stmt->bindValue(':address', $_POST['address'], SQLITE3_TEXT);
        $stmt->bindValue(':email', $_POST['email'], SQLITE3_TEXT);
        $stmt->bindValue(':comment', $_POST['comment'], SQLITE3_TEXT);

        // Выполняем запрос и выводим сообщение об успехе или ошибке
        if ($stmt->execute()) {
            $message = '<div class="success">Запись сохранена</div>';
        } else {
            $message = '<div class="error">Ошибка сохранения</div>';
        }
    }

    // Формируем HTML: сначала список контактов в виде ссылок
    $html = '<div class="edit-list">';
    foreach ($contacts as $c) {
        // Если этот контакт сейчас редактируется - добавляем класс current (красный)
        $active_class = ($c['id'] == $edit_id) ? 'current' : '';
        // Ссылка ведёт на эту же страницу, но с новым edit_id
        // Инициалы: первая буква имени + точка (И.)
        $initials = mb_substr($c['firstname'], 0, 1) . '.';
        $html .= "<a href='index.php?menu=edit&edit_id={$c['id']}' class='$active_class'>"
                 . htmlspecialchars($c['lastname']) . " " . $initials . "</a>";
    }
    $html .= '</div>';

    // Добавляем сообщение (если было сохранение)
    $html .= $message;

    // Форма редактирования. action не указан - отправляется на ту же страницу
    // value полей берутся из $contact_data (текущая запись)
    $html .= '<form method="post">';
    $html .= '<input type="hidden" name="id" value="' . $edit_id . '">';
    $html .= '<label>Фамилия:</label> <input type="text" name="lastname" value="' . htmlspecialchars($contact_data['lastname']) . '" required><br>';
    $html .= '<label>Имя:</label> <input type="text" name="firstname" value="' . htmlspecialchars($contact_data['firstname']) . '" required><br>';
    $html .= '<label>Отчество:</label> <input type="text" name="middlename" value="' . htmlspecialchars($contact_data['middlename']) . '"><br>';
    // Выпадающий список для пола. Если gender = 'Ж' - ставим selected
    $html .= '<label>Пол:</label> <select name="gender">';
    $html .= '<option value="М"' . ($contact_data['gender'] == 'М' ? ' selected' : '') . '>М</option>';
    $html .= '<option value="Ж"' . ($contact_data['gender'] == 'Ж' ? ' selected' : '') . '>Ж</option>';
    $html .= '</select><br>';
    $html .= '<label>Дата рождения:</label> <input type="date" name="birthday" value="' . htmlspecialchars($contact_data['birthday']) . '"><br>';
    $html .= '<label>Телефон:</label> <input type="text" name="phone" value="' . htmlspecialchars($contact_data['phone']) . '"><br>';
    $html .= '<label>Адрес:</label> <input type="text" name="address" value="' . htmlspecialchars($contact_data['address']) . '"><br>';
    $html .= '<label>Email:</label> <input type="email" name="email" value="' . htmlspecialchars($contact_data['email']) . '"><br>';
    $html .= '<label>Комментарий:</label> <textarea name="comment">' . htmlspecialchars($contact_data['comment']) . '</textarea><br>';
    $html .= '<input type="submit" name="save" value="Сохранить">';
    $html .= '</form>';

    $db->close();  // Закрываем базу данных
    return $html;  // Возвращаем готовый HTML
}
?>