<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Sanitize and validate the subdomain input
    $subdomain = filter_var(trim($_POST['subdomain']), FILTER_SANITIZE_SPECIAL_CHARS);

    if (empty($subdomain)) {
        echo "Subdomain cannot be empty.";
        exit();
    }

    // Ensure the subdomain contains only valid characters (letters, numbers, hyphens)
    if (!preg_match('/^[a-zA-Z0-9-]+$/', $subdomain)) {
        echo "Invalid subdomain name. Only letters, numbers, and hyphens are allowed.";
        exit();
    }

    // Ensure the subdomain does not contain a period (.)
    if (strpos($subdomain, '.') !== false) {
        echo "Subdomain name should not contain a period.";
        exit();
    }

    // Create the subdomain directory dynamically
    $subdomainDir = "/var/www/test-subdomains/{$subdomain}";
    if (!is_dir($subdomainDir)) {
        mkdir($subdomainDir, 0755, true);
        file_put_contents("{$subdomainDir}/index.html", "<h1>Welcome to {$subdomain}.test.com</h1>");
    }

    // Generate the subdomain configuration
    $subdomainConfig = "<VirtualHost *:80>\n";
    $subdomainConfig .= "    ServerName {$subdomain}.test.com\n";
    $subdomainConfig .= "    DocumentRoot {$subdomainDir}\n";
    $subdomainConfig .= "    ErrorLog /var/log/{$subdomain}-error.log\n";
    $subdomainConfig .= "    CustomLog /var/log/{$subdomain}.log common\n";
    $subdomainConfig .= "    <Directory {$subdomainDir}>\n";
    $subdomainConfig .= "        AllowOverride all\n";
    $subdomainConfig .= "        Options Indexes FollowSymLinks\n";
    $subdomainConfig .= "        Require all granted\n";
    $subdomainConfig .= "    </Directory>\n";
    $subdomainConfig .= "</VirtualHost>";

    // Call the bash script to append the configuration
    $bashScript = "/home/stage/site-management/mainweb/scripts/append_subdomain.sh";
    $escapedConfig = escapeshellarg($subdomainConfig);
    $command = "/bin/bash {$bashScript} {$escapedConfig}";

    // Execute the command and capture the output
    $output = shell_exec($command);

    // Log the command and output for debugging
    file_put_contents('/tmp/php_debug.log', "Command: {$command}\nOutput: {$output}\n", FILE_APPEND);

    if ($output === null || empty($output)) {
        echo "Failed to create subdomain. Command: {$command}<br>";
        echo "Output: {$output}<br>";
        exit();
    }

    echo "Command executed: {$command}<br>";
    echo "Output: {$output}<br>";
    echo "Subdomain {$subdomain}.test.com created successfully.";
}
?>
