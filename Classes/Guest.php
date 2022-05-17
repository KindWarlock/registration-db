<?php

include "Database.php";

class Guest {
    public static $topics = [
        1 => 'Бизнес и коммуникации',
        2 => 'Технологии',
        3 => 'Реклама',
      ];

    public static $payments = [
        1 => 'WebMoney',
        2 => 'Яндекс.Деньги',
        3 => 'PayPal',
        4 => 'Кредитная карта',
      ];

    public string $created_at;
    public string $ip;
    public string $first_name;
    public string $last_name;
    public string $email;
    public string $phone;
    public int $topic;
    public int $payment;
    public bool $news = False;

    public function __construct(array $data = null) {
        if (empty($data)) {
            return;
        }
        $this->created_at = $data["dt"];
        $this->ip = $data["ip"];
        $this->first_name = $data["first_name"];
        $this->last_name = $data["last_name"];
        $this->email = $data["email"];
        $this->phone = $data["phone"];
        $this->topic = $data["topic"];
        $this->payment = $data["payment"];

        if (isset($data["news"])) {
            $this->news = True;
        }
    }

    public function save(string $file = "guests.txt") {
        $sql = "INSERT INTO `participants`(
            `first_name`, 
            `last_name`,
            `email`,
            `phone`,
            `ip`,
            `topic`,
            `payment`,
            `news`,
            `created_at`
        ) VALUES (" .
            "'" . $this->first_name . "'," .
            "'" . $this->last_name . "'," .
            "'" . $this->email . "'," .
            "'" . $this->phone . "'," .
            "'" . $this->ip . "'," .
            "'" . $this->topic . "'," .
            "'" . $this->payment . "'," .
            "'" . (int)$this->news . "'," .
            "'" . $this->created_at . "'" .
        ");";
        Database::query($sql);
    }

    public static function loadAll(string $file_name = "guests.txt"){
        $guests = Database::select("SELECT * FROM `participants`;", "Guest");
        foreach ($guests as $guest) {
            if (!empty($guest->deleted_at)) {
                continue;
            }
            echo "
            <label>
            <div class='guest'>
                <div class='guest__info'>
                    <span class='guest__info-title'> Имя: </span>" . $guest->first_name . " " . $guest->last_name . "
                    <br>
                    <span class='guest__info-title'> E-mail: </span>" . $guest->email . "
                    <br>
                    <span class='guest__info-title'> Телефон: </span>" . $guest->phone . "
                    <br>
                    <span class='guest__info-title'> Тема: </span>" . Guest::$topics[$guest->topic] . "
                    <br>
                    <span class='guest__info-title'> Способ оплаты: </span>" . Guest::$payments[$guest->payment] . "
                </div>
                <div class='guest__checkbox'>
                    <input type='checkbox' name='" . $guest->id . "'>
                </div>
            </div>
            </label>
            ";
        }
    }

    public static function deleteGuests(array $del_guests = []) {
        $ids = implode(',', array_keys($del_guests));
        $sql = "UPDATE `participants`
        SET `deleted_at` = :dt
        WHERE `id` IN (:ids)";
        $stmt = Database::prepare($sql);
        Database::exec($stmt, array(':ids' => $ids, ':dt' => date("Y-m-d_H:i:s")));
    }
}