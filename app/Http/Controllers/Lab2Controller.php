<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// --- BÀI TẬP 1 ---
class Car {
    public $brand;
    public $color;
    public function getInfo() {
        return "Brand: {$this->brand}, Color: {$this->color}";
    }
}

// --- BÀI TẬP 2 ---
class Student {
    private $name;
    private $age;
    public function __construct($name, $age) {
        $this->name = $name;
        $this->age = $age;
    }
    public function getInfo() {
        return "Name: {$this->name}, Age: {$this->age}";
    }
}

// --- BÀI TẬP 3 ---
class MathHelper {
    public static function add($a, $b) {
        return $a + $b;
    }
}
class AdvancedMath extends MathHelper {
    public static function pow($a, $b) {
        return $a ** $b;
    }
}

// --- BÀI TẬP 4 ---
abstract class Animal {
    abstract public function makeSound();
}
interface CanRun {
    public function run();
}
class Dog extends Animal implements CanRun {
    public function makeSound() { return "Woof! Woof!"; }
    public function run() { return "Dog is running..."; }
}
class Cat extends Animal {
    public function makeSound() { return "Meow! Meow!"; }
}

// --- BÀI TẬP 5 --- 
// Bỏ qua Autoloader vì Laravel đã có Composer Autoload.

// --- BÀI TẬP 6 ---
class BankAccount {
    private $accountNumber;
    private $accountName;
    private $balance;
    public $logs = [];

    public function __construct($accountNumber, $accountName, $balance = 0) {
        $this->accountNumber = $accountNumber;
        $this->accountName = $accountName;
        $this->balance = $balance;
    }
    public function deposit($amount) {
        if ($amount > 0) {
            $this->balance += $amount;
            $this->logs[] = "Nạp thành công $amount. Số dư mới: {$this->balance}";
        } else {
            $this->logs[] = "Số tiền nạp không hợp lệ.";
        }
    }
    public function withdraw($amount) {
        if ($amount > 0 && $amount <= $this->balance) {
            $this->balance -= $amount;
            $this->logs[] = "Rút thành công $amount. Số dư mới: {$this->balance}";
        } else {
            $this->logs[] = "Số tiền rút không hợp lệ hoặc số dư không đủ.";
        }
    }
    public function getBalanceInfo() {
        return "Tài khoản: {$this->accountNumber} - Chủ thẻ: {$this->accountName} - Số dư: {$this->balance}";
    }
}

// --- BÀI TẬP 7 ---
interface Downloadable {
    public function download();
}
class Book {
    protected $title;
    protected $author;
    protected $price;
    public function __construct($title, $author, $price) {
        $this->title = $title;
        $this->author = $author;
        $this->price = $price;
    }
    public function getInfo() {
        return "Title: {$this->title}, Author: {$this->author}, Price: {$this->price}";
    }
}
class Ebook extends Book implements Downloadable {
    private $fileSize;
    public function __construct($title, $author, $price, $fileSize) {
        parent::__construct($title, $author, $price);
        $this->fileSize = $fileSize;
    }
    public function getInfo() {
        return parent::getInfo() . ", File Size: {$this->fileSize}MB";
    }
    public function download() {
        return "Đang tải xuống Ebook '{$this->title}' ({$this->fileSize}MB)...";
    }
}

// --- BÀI TẬP 8 ---
class Person {
    protected $name;
    protected $age;
    public function __construct($name, $age) {
        $this->name = $name;
        $this->age = $age;
    }
    public function getInfo() {
        return "Name: {$this->name}, Age: {$this->age}";
    }
}
class Student8 extends Person {
    private $studentID;
    public function __construct($name, $age, $studentID) {
        parent::__construct($name, $age);
        $this->studentID = $studentID;
    }
    public function getInfo() {
        return parent::getInfo() . ", Student ID: {$this->studentID}";
    }
}

class Lab2Controller extends Controller
{
    public function index() {
        return view('lab2.index');
    }

    public function bt1() {
        $car1 = new Car();
        $car1->brand = "Toyota";
        $car1->color = "Red";

        $car2 = new Car();
        $car2->brand = "Honda";
        $car2->color = "Blue";

        return view('lab2.bt1', compact('car1', 'car2'));
    }

    public function bt2() {
        $student = new Student("Nguyen Van A", 20);
        return view('lab2.bt2', compact('student'));
    }

    public function bt3() {
        $sum = MathHelper::add(3, 5);
        $pow = AdvancedMath::pow(2, 3);
        return view('lab2.bt3', compact('sum', 'pow'));
    }

    public function bt4() {
        $dog = new Dog();
        $cat = new Cat();
        return view('lab2.bt4', compact('dog', 'cat'));
    }

    public function bt5() {
        $message = "Laravel sử dụng Composer Autoloader tự động nạp class, nên không cần tự viết file autoload.php hay require thủ công.";
        return view('lab2.bt5', compact('message'));
    }

    public function bt6() {
        $account = new BankAccount("123456789", "Nguyen Van A", 50000);
        $initialInfo = $account->getBalanceInfo();
        $account->deposit(20000);
        $account->withdraw(30000);
        $account->withdraw(100000); 


        
        return view('lab2.bt6', [
            'initialInfo' => $initialInfo,
            'logs' => $account->logs,
            'finalInfo' => $account->getBalanceInfo()
        ]);
    }

    public function bt7() {
        $book = new Book("Lập trình PHP", "Nguyễn Văn A", 100000);
        $ebook = new Ebook("Lập trình PHP nâng cao", "Trần Văn B", 150000, 5);
        
        return view('lab2.bt7', compact('book', 'ebook'));
    }

    public function bt8() {
        $student = new Student8("Le Van C", 21, "SV001");
        return view('lab2.bt8', compact('student'));
    }
}
