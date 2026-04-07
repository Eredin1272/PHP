<?php

echo "Hello, World with echo!";
echo "<br />";

print "Hello, World with print!";
echo "<br /><br />";

$days = 288;
$message = "Все возвращаются на работу!";

// Конкатенация
echo "Количество дней: " . $days . "<br />";
echo $message . "<br /><br />";

// двойные кавычки
echo "Количество дней: $days<br />";
echo "$message";

?>



