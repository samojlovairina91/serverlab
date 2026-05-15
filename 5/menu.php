<?php
// Функция рисует главное меню и подменю сортировки
function renderMenu($active_menu, $sort) {

    // Основные пункты меню (ключ => название на экране)
    $items = [
        'view'   => 'Просмотр',
        'add'    => 'Добавление записи',
        'edit'   => 'Редактирование записи',
        'delete' => 'Удаление записи'
    ];

    // Начинаем формировать HTML основного меню
    $html = '<div class="menu">';

    // Перебираем все пункты меню
    foreach ($items as $key => $name) {
        // Если этот пункт совпадает с активным — добавляем класс 'active' (красная кнопка)
        $active_class = ($active_menu == $key) ? 'active' : '';

        // Ссылка ведёт на index.php с параметрами: menu=название_пункта и текущая сортировка
        $html .= "<a href='index.php?menu=$key&sort=$sort' class='$active_class'>$name</a>";
    }
    $html .= '</div>';

    // Если активный пункт — 'Просмотр', добавляем подменю для выбора сортировки
    if ($active_menu == 'view') {
        $sort_items = [
            'id'       => 'По порядку добавления',   // сортировка по id
            'lastname' => 'По фамилии',              // сортировка по фамилии
            'birthday' => 'По дате рождения'         // сортировка по дате
        ];

        $html .= '<div class="submenu">';

        foreach ($sort_items as $key => $name) {
            // Если этот тип сортировки активен — выделяем красным
            $active_class = ($sort == $key) ? 'active' : '';

            // Ссылка: меню=view, сортировка=выбранная, страница сбрасывается на 1
            $html .= "<a href='index.php?menu=view&sort=$key&page=1' class='$active_class'>$name</a>";
        }
        $html .= '</div>';
    }

    // Возвращаем готовый HTML с меню
    return $html;
}
?>