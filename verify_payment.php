<?php
// ไฟล์นี้ใช้ตรวจสอบว่ามีการโอนเงินเข้าแล้วหรือไม่

// ตั้งค่า API Key ของ TrueMoney หรือ PromptPay
$truemoney_api_key = "YOUR_TRUEMONEY_API_KEY";
$promptpay_api_key = "YOUR_PROMPTPAY_API_KEY";

// ฟังก์ชันตรวจสอบยอดเงินจาก TrueMoney
function checkTrueMoneyPayment($api_key) {
    $url = "https://tmn-api.com/check-balance?api_key=" . $api_key;
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    return $data["latest_transaction"];
}

// ฟังก์ชันตรวจสอบยอดเงินจาก PromptPay
function checkPromptPayPayment($api_key) {
    $url = "https://promptpay-api.com/check-payment?api_key=" . $api_key;
    $response = file_get_contents($url);
    $data = json_decode($response, true);
    return $data["latest_transaction"];
}

// ตรวจสอบการชำระเงิน
$trueMoneyTransaction = checkTrueMoneyPayment($truemoney_api_key);
$promptPayTransaction = checkPromptPayPayment($promptpay_api_key);

// ถ้าพบการชำระเงิน
if ($trueMoneyTransaction || $promptPayTransaction) {
    $token = bin2hex(random_bytes(16)); // สร้างโทเค็นดาวน์โหลดแบบสุ่ม
    file_put_contents("tokens/$token.txt", "valid"); // บันทึกโทเค็น
    echo json_encode(["status" => "success", "token" => $token]);
} else {
    echo json_encode(["status" => "fail"]);
}
?>
