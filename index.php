<?php
error_reporting(E_ALL);

$link = 'http://api.openweathermap.org/data/2.5/weather';
$apiid = 'b3989de3991a32e3272231146a1f1178';
$city_id = '454310';
$units = 'metric';
$lang = 'ru';
$api = "$link?id=$city_id&units=$units&lang=$lang&appid=$apiid";

$json = file_get_contents($api); 
if ($json === false) {
    exit('Не удалось получить данные'); 
}

$data = json_decode($json, true);
if ($data === null) {
    exit('Ошибка декодирования json');
}

function checkData($data) { 
    if (empty($data)) { 
        return 'не удалось получить данные'; 
    }

return $data;
    
}

$today = date('d M Y H:i');

$month = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sept', 'Oct', 'Nov', 'Dec'];

$month_ru = ['Января', 'Февраля', 'Марта', 'Апреля', 'Мая', 'Июня', 'Июля', 'Августа', 'Сентября', 'Октября', 'Ноября', 'Декабря'];

$today = str_replace($month, $month_ru, $today);

$icon = 'http://openweathermap.org/img/w/' . $data['weather'][0]['icon'] . '.png';

$weather = checkData($data['weather'][0]['description'] !== 0)? 
         'Погодные условия - ' . checkData($data['weather'][0]['description']) : 'без осадков';

$clouds = checkData($data['clouds']['all'] !== 0) ? 
        'облачность - ' . checkData($data['clouds']['all']) . " %" : 'безоблачно';

$data_sunrise = checkData($data['sys']['sunrise']);
$sunrise = date('H:i', $data_sunrise);
$data_sunset = checkData($data['sys']['sunset']);
$sunset = date('H:i', $data_sunset);

$temper = checkData($data['main']['temp']);
$temperatura = number_format($temper, 1, '.', '');
$pressure = checkData($data['main']['pressure']);
$wind_speed = checkData($data['wind']['speed']);
$wind_deg = checkData($data['wind']['deg']);
$humidity = checkData($data['main']['humidity']);

?>
<!DOCTYPE html>
<html lang='ru'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Стандартные функции</title>
        <style>
            body {
                font-family: sans-serif;  
                max-width: 400px;
                padding: 15px 20px;
                border: 1px solid #ccc;
            }
        </style>
</head>
<body>
    <h2>Погода в Вентспилсе</h2>
    <p><?= 'Сейчас: ' . $today ?></p>
    <h2><img src="<?= $icon ?>"><?= $temperatura ?> ºС</h2>
    <span><?= $weather .', '. $clouds ?></span>
    <p><?= 'Давление: ' . $pressure . ' гПа' ?></p>
    <p><?= 'Ветер: скорость - ' . $wind_speed . ' м/с, направление - ' . $wind_deg . ' º' ?></p>
    <p><?= 'Влажность: ' . $humidity . ' %' ?></p>
    <p><?= 'Восход: ' . $sunrise ?></p>
    <p><?= 'Закат: ' . $sunset ?></p>
</body>
</html>
