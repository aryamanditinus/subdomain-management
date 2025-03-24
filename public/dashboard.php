<?php
session_start();
require_once '../config/db.php';
require_once '../includes/auth.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit();
}

$userId = $_SESSION['user_id'];

// Fetch user details
$query = $pdo->prepare("SELECT * FROM users WHERE id = :id");
$query->execute(['id' => $userId]);
$user = $query->fetch(PDO::FETCH_ASSOC);

// Fetch user's subdomains
$subdomains = [];
$subdomainQuery = $pdo->prepare("SELECT * FROM subdomains WHERE user_id = :user_id");
$subdomainQuery->execute(['user_id' => $userId]);
$subdomains = $subdomainQuery->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/styles.css">
    <title>User Dashboard</title>
</head>
<body>
    <header>
        <h1>Welcome, <?php echo htmlspecialchars($user['username']); ?></h1>
        <a href="logout.php">Logout</a>
    </header>
    <main>
        <h2>Your Subdomains</h2>
        <ul>
            <?php if (count($subdomains) > 0): ?>
                <?php foreach ($subdomains as $subdomain): ?>
                    <li><?php echo htmlspecialchars($subdomain['name']); ?>.test.com</li>
                <?php endforeach; ?>
            <?php else: ?>
                <li>No subdomains created yet.</li>
            <?php endif; ?>
        </ul>

        <h2>Create a New Subdomain</h2>
        <form action="create_subdomain.php" method="POST">
            <input type="text" name="subdomain" required placeholder="Subdomain Name">
            <button type="submit">Create Subdomain</button>
        </form>
    </main>
</body>
</html>
