<?php
$host = "localhost";
$user = "root";
$password = "";
$database = "library";

$conn = mysqli_connect($host, $user, $password, $database);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $donor = $_POST['donor_name'];
    $title = $_POST['book_title'];
    $author = $_POST['author'];
    $genre = $_POST['genre'];

    $sql = "INSERT INTO donated_books (donor_name, book_title, author, genre)
            VALUES ('$donor', '$title', '$author', '$genre')";

    if (mysqli_query($conn, $sql)) {
        $msg = "📚 Book Donated Successfully!";
    } else {
        $msg = "❌ Error: " . mysqli_error($conn);
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Book Donation Portal</title>
    <style>
        body {
            background: linear-gradient(to right, #6a11cb, #2575fc);
            font-family: Arial, sans-serif;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .container {
            width: 90%;
            max-width: 700px;
            margin: 50px auto;
            background: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 8px 16px rgba(0,0,0,0.2);
        }

        h2 {
            text-align: center;
            color: #4a00e0;
        }

        input, select {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        input[type="submit"] {
            background-color: #4a00e0;
            color: white;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #3700b3;
        }

        .message {
            text-align: center;
            color: green;
            font-weight: bold;
        }

        table {
            width: 100%;
            margin-top: 30px;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #999;
            padding: 10px;
            text-align: center;
        }

        th {
            background-color: #4a00e0;
            color: white;
        }

        .footer {
            text-align: center;
            margin-top: 40px;
            color: #aaa;
        }
    </style>
</head>
<body>
<div class="container">
    <h2>📘 Book Donation Form</h2>

    <?php if (isset($msg)) echo "<p class='message'>$msg</p>"; ?>

    <form method="post">
        <label>Your Name</label>
        <input type="text" name="donor_name" required>

        <label>Book Title</label>
        <input type="text" name="book_title" required>

        <label>Author</label>
        <input type="text" name="author" required>

        <label>Genre</label>
        <select name="genre" required>
            <option value="">-- Select Genre --</option>
            <option value="Fiction">Fiction</option>
            <option value="Non-fiction">Non-fiction</option>
            <option value="Educational">Educational</option>
            <option value="Science">Science</option>
            <option value="Biography">Biography</option>
        </select>

        <input type="submit" value="Donate Book">
    </form>

    <h2>📚 List of Donated Books</h2>
    <table>
        <tr>
            <th>ID</th>
            <th>Donor</th>
            <th>Title</th>
            <th>Author</th>
            <th>Genre</th>
            <th>Donated On</th>
        </tr>
        <?php
        $result = mysqli_query($conn, "SELECT * FROM donated_books ORDER BY donation_date DESC");
        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<tr>
                        <td>{$row['id']}</td>
                        <td>{$row['donor_name']}</td>
                        <td>{$row['book_title']}</td>
                        <td>{$row['author']}</td>
                        <td>{$row['genre']}</td>
                        <td>{$row['donation_date']}</td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No donations yet.</td></tr>";
        }
        ?>
    </table>

    <div class="footer">
        &copy; <?php echo date("Y"); ?> Book Bank | Donate. Inspire. Read.
    </div>
</div>
</body>
</html>

<?php mysqli_close($conn); ?>
