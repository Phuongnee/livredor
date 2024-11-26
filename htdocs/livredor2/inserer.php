<?php
// Thông tin kết nối MySQL (MAMP)
$host = "localhost"; // Máy chủ
$port = "8889"; // Cổng của MAMP
$username = "root"; // Tên đăng nhập mặc định của MAMP
$password = "root"; // Mật khẩu mặc định của MAMP
$dbname = "livredor"; // Tên cơ sở dữ liệu bạn đã tạo

// Kết nối MySQL
$conn = new mysqli($host, $username, $password, $dbname, $port);

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Thu thập và xử lý dữ liệu từ form
$pseudo = $conn->real_escape_string($_POST['pseudo']);
$texte = $conn->real_escape_string($_POST['texte']);

// Truy vấn SQL để chèn dữ liệu
$sql = "INSERT INTO commentaire (pseudo, texte) VALUES ('$pseudo', '$texte')";

// Thực thi truy vấn và kiểm tra
if ($conn->query($sql) === TRUE) {
    echo "Message ajouté avec succès!";
} else {
    echo "Erreur: " . $conn->error;
}


// Đóng kết nối
$conn->close();
?>
