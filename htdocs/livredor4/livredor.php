<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livre d'or</title>
    <link rel="stylesheet" href="../livredor4/css/styles.css">
</head>
<body>
    <div class="container">
        <h1>Livre d'or</h1>

        <?php
        // Kết nối MySQL
        $conn = new mysqli("localhost", "root", "root", "livredor", 8889);

        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("<p class='error'>Connection failed: " . $conn->connect_error . "</p>");
        }

        // Xử lý form thêm tin nhắn
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $pseudo = $conn->real_escape_string($_POST['pseudo']);
            $texte = $conn->real_escape_string($_POST['texte']);

            // Chèn dữ liệu vào bảng
            $sql = "INSERT INTO commentaire (pseudo, texte) VALUES ('$pseudo', '$texte')";
            if ($conn->query($sql) === TRUE) {
                echo "<p class='success'>Message ajouté avec succès!</p>";
            } else {
                echo "<p class='error'>Erreur: " . $conn->error . "</p>";
            }
        }

        // Hiển thị danh sách tin nhắn với phân trang
        $messages_per_page = 5; // Số tin nhắn mỗi trang
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $page = max($page, 1); // Không cho phép số trang nhỏ hơn 1
        $start = ($page - 1) * $messages_per_page;

        // Lấy tin nhắn từ bảng
        $sql = "SELECT id, pseudo, texte FROM commentaire ORDER BY id DESC LIMIT $start, $messages_per_page";
        $result = $conn->query($sql);

        // Tính tổng số tin nhắn
        $total_sql = "SELECT COUNT(*) AS total FROM commentaire";
        $total_result = $conn->query($total_sql);
        $total_row = $total_result->fetch_assoc();
        $total_messages = $total_row['total'];
        $total_pages = ceil($total_messages / $messages_per_page);
        ?>

        <!-- Biểu mẫu thêm tin nhắn -->
        <form action="livredor.php" method="post">
            <label for="pseudo">Pseudo:</label>
            <input type="text" id="pseudo" name="pseudo" required>
            <label for="texte">Message:</label>
            <textarea id="texte" name="texte" required></textarea>
            <button type="submit">Envoyer</button>
        </form>

        <!-- Hiển thị tin nhắn -->
        <h2>Messages</h2>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<div class='message'>";
                echo "<p><strong>ID:</strong> {$row['id']}</p>";
                echo "<p><strong>Pseudo:</strong> {$row['pseudo']}</p>";
                echo "<p><strong>Message:</strong> {$row['texte']}</p>";
                echo "</div>";
            }
        } else {
            echo "<p>Pas de messages pour le moment.</p>";
        }
        ?>

        <!-- Phân trang -->
        <div class="pagination">
            <?php
            if ($page > 1) {
                echo '<a href="livredor.php?page=' . ($page - 1) . '">Précédent</a>';
            }
            if ($page < $total_pages) {
                echo '<a href="livredor.php?page=' . ($page + 1) . '">Suivant</a>';
            }
            ?>
        </div>

        <?php
        // Đóng kết nối
        $conn->close();
        ?>
    </div>
</body>
</html>
