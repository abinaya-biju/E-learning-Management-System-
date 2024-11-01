<?php
include '../components/connect.php';

// Delete teacher functionality
if (isset($_POST['delete'])) {
    $tutor_id = $_POST['tutor_id'];
    $conn->prepare("DELETE FROM `tutors` WHERE id = ?")->execute([$tutor_id]);
    header("Location: all_teachers.php"); // Redirect after deletion
    exit();
}

// Fetch all teachers
$query = $conn->prepare("SELECT * FROM `tutors`");
$query->execute();
$all_teachers = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Teachers</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f3f3f3;
            margin: 0;
            padding: 20px;
        }

        h2 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        .button-container {
            text-align: center;
            margin-bottom: 20px;
        }

        .back-button {
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            text-decoration: none;
            transition: background-color 0.3s ease;
        }

        .back-button:hover {
            background-color: #0056b3;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin: auto;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #333;
            color: white;
        }

        td {
            color: #555;
        }

        button.delete-btn {
            background-color: #dc3545;
            color: white;
            border: none;
            padding: 8px 12px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button.delete-btn:hover {
            background-color: #c82333;
        }
    </style>
</head>

<body>

<h2>All Teachers</h2>

<div class="button-container">
    <a href="admin_approval.php" class="back-button">Back to Admin Approval</a>
</div>

<table>
    <thead>
        <tr>
            <th>Name</th>
            <th>Email</th>
            <th>Profession</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($all_teachers as $teacher): ?>
            <tr>
                <td><?= htmlspecialchars($teacher['name']) ?></td>
                <td><?= htmlspecialchars($teacher['email']) ?></td>
                <td><?= htmlspecialchars($teacher['profession']) ?></td>
                <td>
                    <form method="post" style="display:inline;">
                        <input type="hidden" name="tutor_id" value="<?= $teacher['id'] ?>">
                        <button type="submit" name="delete" class="delete-btn" onclick="return confirm('Are you sure you want to delete this teacher?')">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

</body>
</html>
