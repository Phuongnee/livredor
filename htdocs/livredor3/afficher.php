<?php
// Kết nối MySQL
$conn = new mysqli("localhost", "root", "root", "livredor", 8889);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Số tin nhắn mỗi trang
$messages_per_page = 5;

// Lấy số trang hiện tại từ URL (mặc định là 1)
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$page = max($page, 1); // Không cho phép số trang nhỏ hơn 1

// Tính toán vị trí bắt đầu
$start = ($page - 1) * $messages_per_page;

// Lấy dữ liệu từ bảng commentaire với giới hạn
$sql = "SELECT id, pseudo, texte FROM commentaire ORDER BY id DESC LIMIT $start, $messages_per_page";
$result = $conn->query($sql);

// Hiển thị dữ liệu
while ($row = $result->fetch_assoc()) {
    echo "<p><strong>ID:</strong> {$row['id']}<br>";
    echo "<strong>Pseudo:</strong> {$row['pseudo']}<br>";
    echo "<strong>Message:</strong> {$row['texte']}</p>";
}

// Tính tổng số tin nhắn
$total_sql = "SELECT COUNT(*) AS total FROM commentaire";
$total_result = $conn->query($total_sql);
$total_row = $total_result->fetch_assoc();
$total_messages = $total_row['total'];

// Tính tổng số trang
$total_pages = ceil($total_messages / $messages_per_page);

// Hiển thị nút phân trang
if ($page > 1) {
    echo '<a href="afficher.php?page=' . ($page - 1) . '">Précédent</a> ';
}
if ($page < $total_pages) {
    echo '<a href="afficher.php?page=' . ($page + 1) . '">Suivant</a>';
}

// Đóng kết nối
$conn->close();
?>
