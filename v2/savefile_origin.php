<?php 

$filename = './datas/bulkdata.json';

if($_GET['mode'] == 'searchId'){
    if($_GET['id'] == null){
		$data = "NO_ID";
    }else{
        if(file_exists($filename)){
            $data = file_get_contents($filename);
            $data = json_decode($data, 1);
            // print_r($data);
            $id = $_GET['id'];
            if(isset($data['data'][$id]) && $data['data'][$id] >= $_GET['maxPrice']) {
                $data['data'] = 'YES';
            }else {
                $data['data'] = 'NO';
            }
        }else $data = 'NO_DATA';
	}
	echo originResult($data);
	die();
}
else if($_GET['mode'] == 'getTextFile'){
    if(file_exists($filename)){
        echo originResult( file_get_contents($filename), '','json');
    }else echo originResult('NOFILE');
}
else if($_GET['mode'] == 'saveTextFile'){
    unset($_GET['mode']);
    // echo 'res = ';
    // echo json_encode($_GET['data']);
    if($_GET != null){
        // print_r($_GET);
        $data = json_encode($_GET, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
        file_put_contents($filename , $data);
        // echo $data;
        echo originResult( $_GET['lastTime'] );
        
    }
}


//--------ORIGIN : print js code
function originResult($data, $keyname='res', $type='text'){
    if($keyname == '') $keyname = 'res';
    if($type == 'text') return $keyname .' = '. json_encode($data, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT) ;//string, array일때 (json 이외의 데이터유형 일때)
    else return $keyname .' = '. $data ;//데이터가 json일때
}


