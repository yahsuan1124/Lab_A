<?php
$host = "localhost";
$dbname ="AddressBook";
$user = "root";
$password = ""; 

$db = new PDO("mysql:host=${host};dbname=${dbname}",$user); 
   

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the POST data
    $postData = file_get_contents("php://input");
    $data = json_decode($postData, true);

    $images = array();

    if (isset($data['imageIds'])) {
        foreach ($data['imageIds'] as $id) {
            $stmt = $db->prepare("SELECT photo FROM headphoto WHERE uid = ?");
            if ($stmt->execute([$id])) {
                $row = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($row) {
                    $images[$id] = base64_encode($row['photo']);
                } else {
                    $images[$id] = null;
                }
            } else {
                $images[$id] = null;
            }
        }
        echo json_encode($images);
    } else {
        echo json_encode(array('error' => '沒圖啊老大'));
    }
} else {
    echo json_encode(array('error' => '蛤'));
}
