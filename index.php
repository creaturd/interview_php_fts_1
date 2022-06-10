<?php
require_once "MySQLConnect.php";

function prettyPrint($jsonData){ echo "<pre>" . $jsonData . "<pre/>"; }

$dbconfig = require 'DBConfig.php';
$db = new MySQLConnect();

//Напишите функцию, которые выполняет следующие действия и возвращает полученную информацию в виде JSON

//1) Подключается к удаленной БД MySQL используя следующие данные:
$db->connect($dbconfig['host'], $dbconfig['port'], $dbconfig['dbname'], $dbconfig['login'], $dbconfig['password']);

//2) Получает список видов (только названия - поле species в таблице taxomony, без дубликатов), 
//   автором описания семейства которых является человек с фамилией Petrov или Chen. 
//   Список видов отсортировать по алфавиту и вернуть в видео двумерного ассоциативного массива Автор > Вид;
$speciesAndAuthorsQuery = "SELECT DISTINCT 
    f.author, t.species FROM family f 
    LEFT JOIN taxonomy t ON f.auto_wiki = t.ncbi_id 
    WHERE f.author LIKE :petrov COLLATE latin1_bin 
    OR f.author LIKE :chen COLLATE latin1_bin 
    ORDER BY f.author ASC;";

$speciesArray = $db->query($speciesAndAuthorsQuery, ['petrov' => '%Petrov%', 'chen' => '%Chen%']);
echo prettyPrint($speciesArray);

//Задание 3 Напишите функцию, которая находит и выводит на экран количество всех записей, касающихся вируса, вызывающего Covid-19 в таблице genome.
$covid19Query = "SELECT COUNT(upid) as count FROM genome WHERE description REGEXP :covidRegexp;";
echo prettyPrint($db->query($covid19Query, ['covidRegexp' => '2019-nCov|SARS-CoV-2|MN3-MDH3|Wuhan']));