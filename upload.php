<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

$targetDir = "uploads/";
if (!file_exists($targetDir)) {
  mkdir($targetDir, 0777, true);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $fileTmpPath = $_FILES['image']['tmp_name'];
    $fileName = basename($_FILES['image']['name']);
    $targetFilePath = $targetDir . uniqid() . "_" . $fileName;

    if (move_uploaded_file($fileTmpPath, $targetFilePath)) {
      echo json_encode([
        'status' => 'success',
        'url' => 'http://janshare.lovestoblog.com/' . $targetFilePath
      ]);
    } else {
      echo json_encode([
        'status' => 'error',
        'message' => 'Không thể di chuyển file.'
      ]);
    }
  } else {
    echo json_encode([
      'status' => 'error',
      'message' => 'Không có file được upload hoặc có lỗi xảy ra.'
    ]);
  }
} else {
  echo json_encode([
    'status' => 'error',
    'message' => 'Phương thức không hợp lệ.'
  ]);
}
