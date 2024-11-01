<?php
include '../components/connect.php';

if (isset($_POST['approve'])) {
    $tutor_id = $_POST['tutor_id'];
    $conn->prepare("UPDATE `tutors` SET approval_status = 'approved' WHERE id = ?")->execute([$tutor_id]);
} elseif (isset($_POST['reject'])) {
    $tutor_id = $_POST['tutor_id'];
    $conn->prepare("UPDATE `tutors` SET approval_status = 'rejected' WHERE id = ?")->execute([$tutor_id]);
}

$query = $conn->prepare("SELECT * FROM `tutors` WHERE approval_status = 'pending'");
$query->execute();
$pending_tutors = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Admin Approval</title>

<!-- Font Awesome CDN link -->
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

    .view-all-button, .view-messages-button {
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

    .view-all-button:hover, .view-messages-button:hover {
        background-color: #0056b3;
    }

    div {
        background-color: #ffffff;
        padding: 15px;
        border-radius: 8px;
        box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
        margin-bottom: 15px;
        max-width: 600px;
        margin: auto;
    }

    p {
        color: #555;
        font-size: 16px;
        margin: 5px 0;
    }

    button {
        background-color: #28a745;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 14px;
        margin-right: 10px;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #218838;
    }

    button[name="reject"] {
        background-color: #dc3545;
    }

    button[name="reject"]:hover {
        background-color: #c82333;
    }

    hr {
        border: 0;
        height: 1px;
        background-color: #ddd;
        margin: 15px 0;
    }
    
    .logout-button {
        background-color: #ff6347;
        color: white;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-size: 16px;
        text-decoration: none;
        transition: background-color 0.3s ease;
        margin-left: 10px;
    }

    .logout-button:hover {
        background-color: #e5533d;
    }

</style>

<script>
    function confirmAction(action, name, tutorId) {
        const confirmation = confirm(`Are you sure you want to ${action} ${name}?`);
        if (confirmation) {
            document.getElementById('tutor_id').value = tutorId;
            document.getElementById('action_form').action = action === 'approve' ? 'approve' : 'reject';
            document.getElementById('action_form').submit();
        }
    }
</script>

</head>

<body>
<h2>Approve or Reject Teacher</h2>

<div class="button-container">
    <a href="all_teachers.php" class="view-all-button">View All Teachers</a>
    <a href="student_messages.php" class="view-messages-button">View Student Messages</a>
    <a href="logout.php" class="logout-button">Logout</a>
</div>



<!-- Hidden form to handle actions -->
<form id="action_form" method="post" style="display: none;">
    <input type="hidden" name="tutor_id" id="tutor_id" value="">
</form>

<?php foreach ($pending_tutors as $tutor): ?>
    <div>
        <p>Name: <?= htmlspecialchars($tutor['name']) ?></p>
        <p>Email: <?= htmlspecialchars($tutor['email']) ?></p>
        <p>Profession: <?= htmlspecialchars($tutor['profession']) ?></p>
        <button onclick="confirmAction('approve', '<?= htmlspecialchars($tutor['name']) ?>', '<?= $tutor['id'] ?>')">Approve</button>
        <button onclick="confirmAction('reject', '<?= htmlspecialchars($tutor['name']) ?>', '<?= $tutor['id'] ?>')">Reject</button>
    </div>
    <hr>
<?php endforeach; ?>

</body>
</html>
