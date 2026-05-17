<?php
//Задание 1
echo "<h1>Задание 1</h1>";
echo "<hr>";

// объявляем абстрактный класс, от него нельзя создать объект, только наследоваться
abstract class HumanAbstract
{
    // приватное свойство. доступно только внутри этого класса
    private $name;

    // конструктор вызывается при создании объекта через new
    public function __construct(string $name)
    {
        // сохраняем переданное имя в свойство name
        $this->name = $name;
    }

    // геттер для имени. возвращает значение приватного свойства name
    public function getName(): string
    {
        return $this->name;
    }

    abstract public function getGreetings(): string;
    abstract public function getMyNameIs(): string;

    // конкретный метод, который собирает готовую фразу
    public function introduceYourself(): string
    {
        // склеиваем приветствие + "меня зовут" + имя
        return $this->getGreetings() . '! ' . $this->getMyNameIs() . ' ' . $this->getName() . '.';
    }
}

// класс для русского языка, наследуется от HumanAbstract
class RussianHuman extends HumanAbstract
{
    // реализуем приветствие по-русски
    public function getGreetings(): string
    {
        return 'Привет';
    }

    // реализуем фразу "меня зовут" по-русски
    public function getMyNameIs(): string
    {
        return 'Меня зовут';
    }
}

// класс для английского языка
class EnglishHuman extends HumanAbstract
{
    public function getGreetings(): string
    {
        return 'Hello';
    }

    public function getMyNameIs(): string
    {
        return 'My name is';
    }
}

// создаём объект русский человек с именем Иван
$russian = new RussianHuman('Иван');
// создаём объект английский человек с именем John
$english = new EnglishHuman('John');

// вызываем метод introduceYourself у русского.
echo $russian->introduceYourself() . "<br>";
// вызываем метод introduceYourself у англичанина.




//Задание 2
echo "<hr>";
echo "<h1>Задание 2</h1>";
echo "<hr>";

class Cat
{
    // приватное свойство для имени
    private $name;
    // приватное свойство для цвета
    private $color;

    // конструктор принимает имя и цвет
    public function __construct(string $name, string $color)
    {
        $this->name = $name;
        $this->color = $color;
    }

    // геттер для цвета
    public function getColor(): string
    {
        return $this->color;
    }

    // метод возвращает приветствие кошки
    public function sayHello(): string
    {
        // подставляем имя и цвет в строку
        return "Меня зовут " . $this->name . ", я " . $this->color . " цвета.";
    }
}

// создаём кошку с именем Барсик и цветом рыжего
$cat = new Cat('Барсик', 'рыжего');
// выводим приветствие кошки
echo $cat->sayHello() . "<br>";




// задание 3
echo "<hr>";
echo "<h1>Задание 3</h1>";
echo "<hr>";

// интерфейс - контракт. кто его использует (implements) обязан реализовать метод calculateSquare
interface CalculateSquare
{
    // объявляем метод, который будет считать площадь. у него нет тела, только название и тип возвращаемого значения
    public function calculateSquare(): float;
}

// класс прямоугольник
class Rectangle implements CalculateSquare
{
    //приватная - только внутри класса
    private $width;
    private $height;

    // конструктор вызывается при создании объекта. принимает ширину и высоту
    public function __construct(float $width, float $height)
    {
        // сохраняем ширину в свойство
        $this->width = $width;
        $this->height = $height;
    }

    // реализуем метод calculateSquare, который требует интерфейс
    public function calculateSquare(): float
    {
        // возвращаем результат
        return $this->width * $this->height;
    }
}

// класс круг. тоже реализует интерфейс CalculateSquare
class Circle implements CalculateSquare
{
    // радиус круга
    private $radius;

    // конструктор принимает радиус
    public function __construct(float $radius)
    {
        // сохраняем радиус
        $this->radius = $radius;
    }

    // реализуем метод calculateSquare
    public function calculateSquare(): float
    {
        return pi() * pow($this->radius, 2);
    }
}

// класс треугольник. НЕ реализует интерфейс
class Triangle
{
    // основание треугольника
    private $base;
    // высота треугольника
    private $height;

    // конструктор принимает основание и высоту
    public function __construct(float $base, float $height)
    {
        // сохраняем основание
        $this->base = $base;
        $this->height = $height;
    }
    // у треугольника нет метода calculateSquare
}

// функция принимает любой объект и проверяет, умеет ли он считать площадь
function printSquare($object)
{
    // instanceof - проверяет, реализует ли объект интерфейс CalculateSquare
    if ($object instanceof CalculateSquare) {
        // get_class - возвращает имя класса объекта (например "Rectangle" или "Circle")
        $className = get_class($object);
        // вызываем метод calculateSquare. он есть, потому что объект прошёл проверку instanceof
        echo "Объект класса $className имеет площадь: " . $object->calculateSquare() . "<br>";
    } else {
        // если интерфейс не реализован
        $className = get_class($object);
        echo "Объект класса $className не реализует интерфейс CalculateSquare.<br>";
    }
}

// создаём объект прямоугольник с шириной 5 и высотой 10
$rectangle = new Rectangle(5, 10);
// создаём объект круг с радиусом 7
$circle = new Circle(7);
// создаём объект треугольник с основанием 4 и высотой 6
$triangle = new Triangle(4, 6);

// вызываем функцию printSquare для каждого объекта
printSquare($rectangle); // сработает ветка if, так как Rectangle implements CalculateSquare
printSquare($circle);    // сработает ветка if, так как Circle implements CalculateSquare
printSquare($triangle);  // сработает ветка else, так как Triangle не реализует интерфейс





// задание 4
echo "<hr>";
echo "<h1>Задание 4</h1>";
echo "<hr>";

// родительский класс урок
class Lesson
{
    // protected - доступно внутри этого класса и в дочерних классах - снаружи не видно
    protected $title;
    protected $text;
    protected $homework;

    // конструктор вызывается при создании объекта. принимает заголовок, текст и дз
    public function __construct(string $title, string $text, string $homework)
    {
        // сохраняем в свойство
        $this->title = $title;
        $this->text = $text;
        $this->homework = $homework;
    }
}

// платный урок. наследует всё от класса Lesson (title, text, homework и их конструктор)
class PaidLesson extends Lesson
{
    // приватное свойство цена только внутри PaidLesson
    private $price;

    // конструктор принимает всё то же что и родитель, плюс цену
    public function __construct(string $title, string $text, string $homework, float $price)
    {
        // parent::__construct - вызываем конструктор родительского класса
        // он сам сохранит title, text, homework
        parent::__construct($title, $text, $homework);
        // а цену сохраняем сами, так как родитель про цену ничего не знает
        $this->price = $price;
    }

    // геттер для цены. позволяет получить значение price извне
    public function getPrice(): float
    {
        return $this->price;
    }

    // сеттер для цены. позволяет изменить price извне
    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
}

// создаём объект платного урока
$paidLesson = new PaidLesson(
    'Урок о наследовании в PHP',  // заголовок
    'Лол, кек, чебурек',          // текст
    'Ложитесь спать, утро вечера мудренее',  // домашнее задание
    99.90                          // цена
);

// var_dump - встроенная функция. выводит всё, что есть в переменной
// для объекта показывает: класс, количество свойств, названия свойств, их типы, значения и видимость (public/protected/private)
echo "<pre>";
var_dump($paidLesson);
echo "</pre>";
?>