<?php
// Thông tin kết nối MySQL
$conn = new mysqli("localhost", "root", "root", "livredor", 8889);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Truy vấn dữ liệu từ bảng commentaire
$result = $conn->query("SELECT id, pseudo, texte FROM commentaire");

// Hiển thị dữ liệu
while ($row = $result->fetch_assoc()) {
    echo "<p><strong>ID:</strong> {$row['id']}<br>";
    echo "<strong>Pseudo:</strong> {$row['pseudo']}<br>";
    echo "<strong>Message:</strong> {$row['texte']}</p>";
}

// Đóng kết nối
$conn->close();
?>
