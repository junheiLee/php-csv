<?php

require_once '/ojt/db/connection.php';

// 파일 존재 여부 확인
$csvFile = '/ojt/data/Test_Catalog_UTF8_.csv';

if (!file_exists($csvFile)) {
    die('file not found');
}

// Connection 획득
$con = new Connection();

// 파일 읽기
$handle = fopen($csvFile, 'r');
fgets($handle);
$row = 0;
while (($data = fgetcsv($handle, 1500, ',')) !== FALSE) {
    
    $row += 1;
    echo '[START] ' . $row . '행 저장';

    if (!($con->existCategory($row, $data))) {
        $con->insertCategory($row, $data);
    }
    $con->insertProduct($row, $data);

	echo ' [END] ' . nl2br("\n");
}

// 사용 마친 resouce 닫기
$con->close();
fclose($handle);

$failedRow = $con->printSaveFailed();
echo $row . '행 중' . $failedRow . '개 실패' . nl2br("\n");