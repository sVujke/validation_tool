<?php
$dataArray=explode(",", $data);

$newData = array($dataArray[1],$dataArray[2],$dataArray[3],$dataArray[4]);
$list = array ($newData);
$existingImg = [];
$existingImgName = [];

$filepath='output/'.$dataArray[0];

$fp = fopen($filepath, 'a');


if (($handle = fopen($filepath, "r")) !== FALSE) {
	$start_row = 1; //define start row
	$i = 1; //define row count flag
	while (($row = fgetcsv($handle)) !== FALSE) {
		if($i >= $start_row) {
			array_push($existingImg, $row);
			array_push($existingImgName, $row[0]);
		}
		$i++;
	}
	fclose($handle);
}


if (in_array($newData, $existingImg)){
} else {
	
	if (in_array($newData[0], $existingImgName)){
		$key = array_search($newData[0], $existingImgName);
		unset($existingImg[$key]);
	}
	array_push($existingImg, $newData);
	file_put_contents($filepath, '');
	foreach ($existingImg as $fields) {
		fputcsv($fp, $fields);	
	}	
}

fclose($fp);

$row = 1;
if (($handle = fopen($filepath, "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $num = count($data);
        $row++;
        for ($c=0; $c < $num; $c++) {
        }
    }
    fclose($handle);
}


?>
