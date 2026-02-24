<?php

$dayOfWeek =  date('N');

# График для John Styles
if ($dayOfWeek == 1 || $dayOfWeek == 3 || $dayOfWeek == 5) {
    $johnTime = "8:00 - 12:00";
} else  {
    $johnTime = "Нерабочий день";
}

# График для Jane Doe
if ($dayOfWeek == 2 || $dayOfWeek == 4 || $dayOfWeek == 6) {
    $janeTime = "12:00 - 16:00";
} else {
    $janeTime = "Нерабочий день";
}

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Расписание работы</title>
    <style>
        table {
            border-collapse: collapse;
            width: 50%;
            justify-content: center;
            margin: 0 auto;

        }
        th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: center;
        }
        th {
            background-color: #a1a1a1;
        }
        tr {
            background-color: #dddddd;
        }
    </style>
</head>
<body>

<h2 style="text-align: center;  ">Расписание на текущий день недели : <?php echo date('l') . " " . date('(d.m.y)'); ?></h2>

<table>
    <tr>
        <th>№</th>
        <th>Фамилия Имя</th>
        <th>График работы</th>
    </tr>
    <tr>
        <td>1</td>
        <td>John Styles</td>
        <td><?php echo $johnTime; ?></td>
    </tr>
    <tr>
        <td>2</td>
        <td>Jane Doe</td>
        <td><?php echo $janeTime; ?></td>
    </tr>
</table>

</body>
</html>

<?php
echo "Использование FOR </br><br/>";
$a = 0;
$b = 0;

for ($i = 0; $i <= 5; $i++) {
   $a += 10;
   $b += 5;
   
   echo "Итерация $i : а = $a, b = $b ,<br />";
}

echo "End of the loop: a = $a, b = $b<br/><br/><br/> ";

?>

<?php

echo "Использование WHILE </br><br/>";

$a = 0;
$b = 0;
$i = 0;

while ($i <= 5) {
    $a += 10;
    $b += 5;

   echo "Итерация $i : а = $a, b = $b ,<br />";
    
    $i++;
}

echo "End of the loop: a = $a, b = $b<br/><br/><br/> ";

?>

<?php
echo "Использование DO WHILE </br><br/>";

$a = 0;
$b = 0;
$i = 0;

do {
    $a += 10;
    $b += 5;
    
    echo "Итерация $i : а = $a, b = $b ,<br />";

    $i++;
} 
while ($i <= 5);
echo "End of the loop: a = $a, b = $b<br/><br/><br/>";

?>