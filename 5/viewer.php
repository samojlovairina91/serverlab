<?php
// Функция рисует таблицу с контактами и пагинацию
function renderViewer($sort, $page) {

    // Открываем базу данных SQLite
    // Если файла database.sqlite нет - он создастся сам
    $db = new SQLite3('database.sqlite');

    // Создаём таблицу contacts, если она ещё не существует
    // AUTOINCREMENT - id будет увеличиваться автоматически
    // PRIMARY KEY - уникальный идентификатор каждой записи
    $db->exec("CREATE TABLE IF NOT EXISTS contacts (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        lastname TEXT,
        firstname TEXT,
        middlename TEXT,
        gender TEXT,
        birthday TEXT,
        phone TEXT,
        address TEXT,
        email TEXT,
        comment TEXT
    )");

    // Определяем, по какому полю сортировать
    $order_by = 'id';  // по умолчанию - порядок добавления
    if ($sort == 'lastname') $order_by = 'lastname, firstname';  // по фамилии и имени
    if ($sort == 'birthday') $order_by = 'birthday';             // по дате рождения

    // Настройки пагинации
    $limit = 10;                        // 10 записей на страницу
    $offset = ($page - 1) * $limit;     // сколько записей пропустить

    // Считаем общее количество записей в таблице
    $count_result = $db->query("SELECT COUNT(*) as cnt FROM contacts");
    $total = $count_result->fetchArray()['cnt'];   // общее количество контактов
    $total_pages = ceil($total / $limit);          // сколько всего страниц

    // Запрашиваем из базы только нужные записи для текущей страницы
    // ORDER BY - сортировка, LIMIT - сколько взять, OFFSET - сколько пропустить
    $result = $db->query("SELECT * FROM contacts ORDER BY $order_by LIMIT $limit OFFSET $offset");

    // Начинаем формировать HTML-таблицу
    $html = '<table>';
    $html .= '<tr><th>Фамилия</th><th>Имя</th><th>Отчество</th><th>Пол</th><th>Дата рождения</th><th>Телефон</th><th>Адрес</th><th>Email</th><th>Комментарий</th></tr>';

    // В цикле проходим по каждой полученной записи
    // fetchArray(SQLITE3_ASSOC) превращает строку базы данных в массив с названиями колонок
    while ($row = $result->fetchArray(SQLITE3_ASSOC)) {
        $html .= '<tr>';
        // htmlspecialchars - защита от XSS-атак (превращает < и > в &lt; &gt;)
        $html .= '<td>' . htmlspecialchars($row['lastname']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['firstname']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['middlename']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['gender']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['birthday']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['phone']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['address']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['email']) . '</td>';
        $html .= '<td>' . htmlspecialchars($row['comment']) . '</td>';
        $html .= '</tr>';
    }
    $html .= '</table>';

    // Если страниц больше одной - рисуем пагинацию
    if ($total_pages > 1) {
        $html .= '<div class="pagination">';
        // Цикл от 1 до общего количества страниц
        for ($i = 1; $i <= $total_pages; $i++) {
            // Если это текущая страница - добавляем рамку
            $active = ($i == $page) ? 'style="border: 2px solid #333;"' : '';
            // Ссылка ведёт на ту же страницу, но с новым номером page
            $html .= "<a href='index.php?menu=view&sort=$sort&page=$i' $active>$i</a>";
        }
        $html .= '</div>';
    }

    // Закрываем соединение с базой данных
    $db->close();

    // Возвращаем готовый HTML
    return $html;
}
?>