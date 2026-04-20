<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $message = strtolower(trim($_POST["message"]));
    $responses = [
        "halo" => "Halo! Ada yang bisa saya bantu?",
        "siapa kamu" => "Saya adalah chatbot sederhana.",
        "apa kabar" => "Saya hanya sebuah program, tapi saya selalu baik!",
        "terima kasih" => "Sama-sama!",
        "bye" => "Sampai jumpa lagi!"
    ];

    echo $responses[$message] ?? "Maaf, saya tidak mengerti.";
}
?>