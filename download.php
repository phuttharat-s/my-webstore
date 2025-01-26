<?php
// ตรวจสอบโทเค็นที่ได้รับ
$token = $_GET["token"] ?? "";
$tokenPath = "tokens/$token.txt";

if (file_exists($tokenPath)) {
    unlink($tokenPath); // ลบโทเค็นเพื่อป้องกันการใช้ซ้ำ
    $file = "downloads/premium-template.zip";

    // ให้ดาวน์โหลดไฟล์
    header("Content-Type: application/zip");
    header("Content-Disposition: attachment; filename=premium-template.zip");
    readfile($file);
} else {
    echo "โทเค็นไม่ถูกต้อง หรือหมดอายุแล้ว!";
}
?>
