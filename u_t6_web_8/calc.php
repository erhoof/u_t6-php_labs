<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Userpage</title>
</head>
<body>
    <?php
    function dateDifference($date_1 , $date_2)
    {
        $datetime1 = date_create($date_1);
        $datetime2 = date_create($date_2);

        $interval = date_diff($datetime1, $datetime2);

        return array($interval->days, $interval->h, $interval->m, $interval->s);
    }

    $user = $_POST["user"];
    $pass = $_POST["pass"];

    $file = @fopen("$user.txt", "r");
    if ($file !== FALSE) {
        $userData = fgetcsv($file);

        if ($pass != $userData[1]) {
            echo "<h3>Неверный пароль!</h3> 
                  <a href='index.html'>Вернуться на страницу авторизации</a>";
        } else {
            echo "<h3>Добро пожаловать, $user!</h3>
                <h3>Период между посещениями сайта</h3>
                <p>Сегодня " . (date('d-m-Y')) . "</p>";

            $diff = dateDifference(date("d-m-y H:i:s"),
            $userData[2]);

            echo "Вы не были на сайте<br>
                    дней - " . ($diff[0]) .
                "<br>часов - " . ($diff[1]) .
                "<br>минут - " . ($diff[2]) .
                "<br>секунд - " . ($diff[3]);

            fclose($file);

            // Update file
            $file = fopen("$user.txt", "wb");

            $userData = array($user, $pass, date('d-m-y H:i:s'));

            fputcsv($file, $userData);

            fclose($file);
        }

    } else {
        $file = fopen("$user.txt", "wb");

        echo "<h3>Новый пользователь! $user</h3>";
        echo "<h3>Сегодня " . (date('d-m-Y')) . "</h3>";

        $userData = array($user, $pass, date('d-m-y H:i:s'));

        fputcsv($file, $userData);

        fclose($file);
    }
    ?>
</body>
</html>
