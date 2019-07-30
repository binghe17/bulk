<?php 

$filename = './datas/bulkdata.json';

if($_GET['mode'] == 'searchId'){
    if($_POST['id'] == null){
        echo 'NO_ID';
    }else{
        if(file_exists($filename)){
            $data = file_get_contents($filename);
            $data = json_decode($data, 1);
            // print_r($data);
            $id = $_POST['id'];
            if(isset($data['data'][$id]) && $data['data'][$id] >= $_POST['maxPrice']) {
                $data['data'] = 'YES';
            }else {
                $data['data'] = 'NO';
            }
            echo json_encode($data, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
        }
    }
}
else if($_GET['mode'] == 'getTextFile'){
    if(file_exists($filename)){
        echo file_get_contents($filename);
    }else echo 'NOFILE';
}
else if($_GET['mode'] == 'saveTextFile'){
    if($_POST != null){
        // print_r($_POST);
        $data = json_encode($_POST, JSON_UNESCAPED_UNICODE + JSON_PRETTY_PRINT);
        if(file_put_contents($filename , $data)) echo $_POST['lastTime'];
    }
}

// // 설정
// $uploads_dir = './datas';
// $allowed_ext = array('csv');//헝용한 파일 확장자


// //save upload file
// else if($_GET['mode'] == 'upload'){

//     $error = $_FILES['myfile']['error'];
//     $name = $_FILES['myfile']['name'];
//     $ext = array_pop(explode('.', $name));
    
//     if( $error != UPLOAD_ERR_OK ) { // 오류 확인
//         switch( $error ) {
//             case UPLOAD_ERR_INI_SIZE:
//             case UPLOAD_ERR_FORM_SIZE:
//                 echo "파일이 너무 큽니다. ($error)";
//                 break;
//             case UPLOAD_ERR_NO_FILE:
//                 echo "파일이 첨부되지 않았습니다. ($error)";
//                 break;
//             default:
//                 echo "파일이 제대로 업로드되지 않았습니다. ($error)";
//         }
//         exit;
//     }
//     if( !in_array($ext, $allowed_ext) ) {// 확장자 확인
//         echo "허용되지 않는 확장자입니다.";
//         exit;
//     }
//     move_uploaded_file( $_FILES['myfile']['tmp_name'], $uploads_dir .'/'. $name);// 파일 이동

//     // 파일 정보 출력
//     echo "<h2>파일 정보</h2>
//     <ul>
//         <li>파일명: $name</li>
//         <li>확장자: $ext</li>
//         <li>파일형식: {$_FILES['myfile']['type']}</li>
//         <li>파일크기: {$_FILES['myfile']['size']} 바이트</li>
//     </ul>";

// }
// //save string to file
// else if($_GET['mode'] == 'string'){
//     $filename = $uploads_dir .'/'. $_POST['filename'];
//     $data = $_POST['data'];
//     file_put_contents($filename , $data);
// }