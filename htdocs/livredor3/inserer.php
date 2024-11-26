<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire Livre d'or</title>
    <!-- Liên kết CSS -->
    <link rel="stylesheet" href="../livredor3/css/styles.css">
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

        // Xử lý form khi được gửi
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

        // Đóng kết nối sau khi xử lý
        $conn->close();
        ?>

        <!-- Biểu mẫu nhập dữ liệu -->
        <form action="" method="post">
            <label for="pseudo">Pseudo:</label>
            <input type="text" id="pseudo" name="pseudo" required>
            <label for="texte">Message:</label>
            <textarea id="texte" name="texte" required></textarea>
            <button type="submit">Envoyer</button>
        </form>
    </div>
</body>
</html>