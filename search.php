<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search Student Results</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <style>
        * {
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: #f5f7fa;
            padding: 40px 20px;
            margin: 0;
        }

        .container {
            max-width: 600px;
            margin: 0 auto;
        }

        h2 {
            text-align: center;
            margin-bottom: 30px;
            color: #333;
        }

        form {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        input[type="text"] {
            flex: 1;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        button {
            padding: 10px 18px;
            border: none;
            background-color: #007bff;
            color: white;
            border-radius: 8px;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #0056b3;
        }

        .card {
            background: white;
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 15px;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            transition: transform 0.2s ease;
        }

        .card:hover {
            transform: translateY(-3px);
        }

        .card strong {
            display: inline-block;
            width: 110px;
            color: #333;
        }

        .no-result {
            text-align: center;
            color: red;
            font-weight: bold;
            margin-top: 20px;
        }

        @media (max-width: 500px) {
            form {
                flex-direction: column;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Search Student Results</h2>

    <form method="GET">
        <input type="text" name="query" placeholder="Enter Roll Number or Name" required>
        <button type="submit">Search</button>
    </form>

    <?php
    if (isset($_GET['query'])) {
        $search = "%" . $_GET['query'] . "%";

        $stmt = $conn->prepare("SELECT * FROM students_results WHERE roll_number LIKE ? OR student_name LIKE ?");
        $stmt->bind_param("ss", $search, $search);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                echo "<div class='card'>";
                echo "<p><strong>Name:</strong> " . htmlspecialchars($row['student_name']) . "</p>";
                echo "<p><strong>Roll No:</strong> " . htmlspecialchars($row['roll_number']) . "</p>";
                echo "<p><strong>Subject:</strong> " . htmlspecialchars($row['subject']) . "</p>";
                echo "<p><strong>Marks:</strong> " . htmlspecialchars($row['marks']) . "</p>";
                echo "<p><strong>Grade:</strong> " . htmlspecialchars($row['grade']) . "</p>";
                echo "<p><strong>Exam Date:</strong> " . htmlspecialchars($row['exam_date']) . "</p>";
                echo "</div>";
            }
        } else {
            echo "<p class='no-result'>No records found.</p>";
        }

        $stmt->close();
    }
    $conn->close();
    ?>
</div>

</body>
</html>
