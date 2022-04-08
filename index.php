<?php

// конечно вендоры и прочие файлы автозагрузки я добавлять в коммит не буду,
// чтобы работали классы не назодясь в одном файле, это надо сделать)
const DB_PORT = '4497';

const DB_HOST = 'mysql-rfam-public.ebi.ac.uk';

const DB_USERNAME = 'rfamro';

const DB_PASSWORD = '';

const DB_NAME = 'Rfam';



// Задание 2
//поскольку задание подрузамевается как на 30 минут, особо оптимизациями и написаниями моделей для обращения не занимался
function getJson() {
    $sql = "select distinct last_name as author, t.species from author
right join family_author fa on author.author_id = fa.author_id
right join family_ncbi fn on fn.rfam_acc = fa.rfam_acc
right join taxonomy t on t.ncbi_id = fn.ncbi_id
where last_name IN ('Petrov', 'Chen')";
    $connect  = new MySQLConnect();
    $connect->connect(DB_HOST,DB_PORT,DB_NAME, DB_USERNAME, '');
    $connect->query($sql)->getAll();
    $data = $connect->query($sql)->getAll();
    echo  json_encode($data);

}


// Задание 3
function getCovid19Rows () {
    $sql = 'SELECT count(*) as "COVID-19" FROM Rfam.genome t WHERE description like "%SARS-CoV-2%"';
    $connect  = new MySQLConnect();
    $connect->connect(DB_HOST,DB_PORT,DB_NAME, DB_USERNAME, DB_PASSWORD);
    $data = $connect->query($sql)->getAll();
    foreach ($data as $row){
        echo 'Count ROWS IN TABLE: '.$row['COVID-19'].'<br>';
    }

}