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

    function createUser($user, $pass)
    {
        echo "<h1> Новый пользователь! </h1>";

        # Создаем пользователя
        $file = fopen("$user.txt", "w");

        $userData = array($user, $pass, date('d-m-y H:i:s'));

        fputcsv($file, $userData);

        fclose($file);
    }

    function removeUser($user)
    {
        unlink("$user.txt");
    }

    function auth(
        $user,
        $pass,
        $session)
    {
        if ($session != '') {
            $file = fopen("$session.txt", "r");
            $userData = fgetcsv($file);

            return array($userData, true);
        }

        # Открываем файл с пользователем
        $file = fopen("$user.txt", "r");

        # Если пользователя нет - создаем
        if ($file == false) {
            createUser($user, $pass);
            $file = fopen("$user.txt", "r");
        }

        # Получаем данные о пользователе
        $userData = fgetcsv($file);

        # Проверяем пароль
        if ($pass != $userData[1]) {
            echo "<h3>Неверный пароль!</h3> 
                    <a href='index.html'>Вернуться на страницу авторизации</a>";

            return array(null, null);
        } 

        # Открываем список сессий и проверяем открыта ли эта
        $sessionsFile = fopen('_sessions.txt', 'r+');
        $sessionOpened = false;
        while (($line = fgets($sessionsFile)) !== false) {
            if (substr($line, 0, -1) == $user) {
                echo "$user : Сессия найдена в _sessions.txt";
                $sessionOpened = true;
                break;
            }
        }

        # Если сессия закрыта - внести в список открытых сессий
        if ($sessionOpened == false) {
            if (fwrite($sessionsFile, $user. "\n") == false)
                echo 'Ошибка доступа к _sessions.txt';
        };

        fclose($sessionsFile);

        return array($userData, $sessionOpened);
    }

    function showUserData(
        $userData,
        $status)
    {
        echo "<h3>Добро пожаловать, $userData[0]!</h3>";

        $diff = $userData[2];
        if ($status) {
            echo "<p> Сессия уже открыта. Продолжаем работу </p>";
        } else {
            echo "<p> Новая сессия! Обновляем время... </p>";

            # Обновляем содержимое файла
            $file = fopen("$userData[0].txt", "w");
            $userData = array($userData[0], $userData[1], date('d-m-y H:i:s'));
            fputcsv($file, $userData);
            fclose($file);
        }
        
        $diff = dateDifference(date("d-m-y H:i:s"), $diff);
        echo "Вы не были на сайте
         <br> дней - " . ($diff[0]) .
        "<br> часов - " . ($diff[1]) .
        "<br> минут - " . ($diff[2]) .
        "<br> секунд - " . ($diff[3]);
    }

    function showControlButtons($user) 
    {
        echo '<form action="calc.php" method="post">';

        # Вывод списка сессий
        echo '<h3> Список сессий: </h3>
            <select name="session">'; 

        $sessionsFile = fopen('_sessions.txt', 'r+');
        $sessionOpened = false;
        while (($line = fgets($sessionsFile)) !== false) {
            echo "<option value'" . $line . "'>$line</option>";
        }
        fclose($sessionsFile);

        echo '</select>
         <input type="hidden" name="lastUser" value="'. $user .'" />
         Закрыть текущего пользователя: <input type="checkbox" name="close">
         <input type="submit" value="Переход в пользователя">
         </form>
         <a href="index.html">Переход на страницу входа</a>';
    }

    function userWasClosed($user)
    {
        # Удаляем эту сессию
        $lines = file('_sessions.txt');
        $result = '';
        foreach ($lines as $line) {
            if (substr($line, 0, -1) != $user) $result .= $line;
        }
        file_put_contents('_sessions.txt', $result);
        fclose($lines);

        # Открываем список сессий и проверяем есть ли другие открытые
        $sessionsFile = fopen('_sessions.txt', 'r+');
        $username = '';
        while (($line = fgets($sessionsFile)) !== false) {
            $username = substr($line, 0, -1);
            break;
        }

        # Если есть еще сессия, открываем ее
        if ($username == '') {
            header("Location: index.html");
            exit();
        } else {
            $_POST["session"] = $username;
        }
    }

    ?>
    <h3>Страница доступа к пользователям</h3>
    <h3>Сегодня <?php echo date('d-m-Y'); ?></p>

    <?php 
        # Если вдруг прошлого пользователя закрыли
        if ($_POST["close"]) userWasClosed($_POST["lastUser"]);
        if ($_POST["user"] == '' and $_POST["session"] == '') { header("Location: index.html"); exit(); };

        # Аутентификация
        list($userData, $status) = auth($_POST["user"], $_POST["pass"], $_POST["session"]);

        # Если пользователя нет, прекращаем работу веб-ресурса
        if ($userData == null) exit();

        showUserData($userData, $status);

        showControlButtons($userData[0]);
    ?>
</body>
</html>
