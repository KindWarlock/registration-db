<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>Список участников</title>
    <style>
        * {
            margin: 0;
            box-sizing: border-box;
        }
        .guests{
            width: 60%;
            margin: 0 auto 50px auto;
        }
        .guest {
            background-color: #e8e8e8;
            border: 1px solid white;
            padding: 10px;
            display:flex;
            width:100%;
            justify-content: space-between;
        }
        .guest__info-title {
            font-weight:800;
        }
        .confirm {
            width: 100%;
            height: 50px;
            position: fixed;
            bottom:0;
            padding: 10px;
            background: grey;
            display: flex;
            justify-content: space-between;
        }

    </style>
</head>
<body>
    <?php
    ini_set('display_errors', '1');
    ini_set('display_startup_errors', '1');
    error_reporting(E_ALL);
        include "Classes/Guest.php";
        $delete = $_POST;
        Guest::deleteGuests($delete);
    ?>
    <form method="POST">
        <div class="guests">
            <?php
                Guest::loadAll();
            ?>
        </div>
        <div class="confirm">
            <div></div>
            <input class="confirm__submit" type="submit" value="Удалить">
        </div>
    </form>
</body>
</html>