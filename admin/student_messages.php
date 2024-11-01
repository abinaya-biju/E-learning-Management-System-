<?php
include '../components/connect.php';

// Query for student messages
$message_query = $conn->prepare("SELECT * FROM `contact` ORDER BY id DESC");
$message_query->execute();
$student_messages = $message_query->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Messages</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">
    <link rel="stylesheet" href="../css/admin_style.css">
</head>
<body>

<?php include '../components/admin_header.php'; ?>

<section class="messages">
    <h1 class="heading">Student Messages</h1>

    <div class="box-container">
        <?php if (empty($student_messages)): ?>
            <p>No messages received yet.</p>
        <?php else: ?>
            <?php foreach ($student_messages as $message): ?>
                <div class="box">
                    <p><strong>Name:</strong> <?= htmlspecialchars($message['name']) ?></p>
                    <p><strong>Email:</strong> <?= htmlspecialchars($message['email']) ?></p>
                    <p><strong>Number:</strong> <?= htmlspecialchars($message['number']) ?></p>
                    <p><strong>Message:</strong> <?= nl2br(htmlspecialchars($message['message'])) ?></p>
                    <hr>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

<?php include '../components/footer.php'; ?>

</body>
</html>
