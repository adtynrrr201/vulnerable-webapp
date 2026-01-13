<?php
// Vulnerable login application with SQL injection
// Configuration for local MySQL installation
$db_host = getenv('DB_HOST') ?: 'localhost';  // Use 'localhost' for local MySQL
$db_user = getenv('DB_USER') ?: 'root';
$db_pass = getenv('DB_PASSWORD') ?: '';  // Leave empty for local MySQL with no password, or set your local password
$db_name = getenv('DB_NAME') ?: 'vulnerable_app';

// Retry connection with exponential backoff
$max_retries = 5;
$retry_delay = 1; // seconds

for ($i = 0; $i < $max_retries; $i++) {
    try {
        $conn = new mysqli($db_host, $db_user, $db_pass, $db_name);

        if ($conn->connect_error) {
            if ($i == $max_retries - 1) {
                die("Connection failed after $max_retries attempts: " . $conn->connect_error);
            }
            sleep($retry_delay);
            $retry_delay *= 2; // exponential backoff
            continue;
        }

        // Connection successful, break out of loop
        break;
    } catch (mysqli_sql_exception $e) {
        if ($i == $max_retries - 1) {
            die("Connection failed after $max_retries attempts: " . $e->getMessage());
        }
        sleep($retry_delay);
        $retry_delay *= 2; // exponential backoff
    }
}

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    // VULNERABLE SQL QUERY - Direct string interpolation
    $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
    
    $result = $conn->query($sql);
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $message = "Welcome back, " . htmlspecialchars($user['username']) . "!";
    } else {
        $message = "Invalid credentials!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Vulnerable Login App</title>
    <style>
        body { font-family: Arial, sans-serif; margin: 50px; }
        .container { max-width: 400px; margin: 0 auto; }
        .form-group { margin-bottom: 15px; }
        label { display: block; margin-bottom: 5px; }
        input[type="text"], input[type="password"] { 
            width: 100%; padding: 8px; border: 1px solid #ccc; 
        }
        input[type="submit"] { 
            background: #007cba; color: white; padding: 10px 20px; 
            border: none; cursor: pointer; 
        }
        .message { 
            padding: 10px; margin: 10px 0; 
            border-radius: 4px; 
        }
        .success { background: #d4edda; color: #155724; }
        .error { background: #f8d7da; color: #721c24; }
        .vulnerability-note {
            background: #fff3cd; color: #856404; padding: 15px;
            border-radius: 4px; margin: 20px 0;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login System</h2>
        
        <div class="vulnerability-note">
            <strong>⚠️ Security Notice:</strong> This application contains intentional SQL injection vulnerabilities for educational purposes only.
        </div>
        
        <?php if ($message): ?>
            <div class="message <?php echo strpos($message, 'Welcome') !== false ? 'success' : 'error'; ?>">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="username">Username:</label>
                <input type="text" id="username" name="username" required>
            </div>
            
            <div class="form-group">
                <label for="password">Password:</label>
                <input type="password" id="password" name="password" required>
            </div>
            
            <input type="submit" value="Login">
        </form>
        
        <h3>Test SQL Injection:</h3>
        <p>Try these usernames to bypass login:</p>
        <ul>
            <li><code>' OR '1'='1</code></li>
            <li><code>' OR 'x'='x' -- </code></li>
            <li><code>' UNION SELECT username, password, 'admin' FROM users -- </code></li>
        </ul>
    </div>
</body>
</html>