<?php
/**
 * GitHub Auto-Deploy Script for InfinityFree
 * 
 * Setup Instructions:
 * 1. Upload this file to your InfinityFree root directory (htdocs)
 * 2. Set GitHub Webhook to: https://yourdomain.com/deploy.php
 * 3. Set Secret in GitHub webhook settings
 * 4. Update variables below with your information
 */

// ============================================
// CONFIGURATION - EDIT THESE VALUES
// ============================================

// GitHub Webhook Secret (set this in GitHub webhook settings)
define('WEBHOOK_SECRET', 'your-secret-key-here');

// Your GitHub repository URL
define('REPO_URL', 'https://github.com/username/peminjaman-buku.git');

// Branch to deploy
define('BRANCH', 'main');

// Path to your website directory (usually /home/username/htdocs)
define('DEPLOY_PATH', '/home/your-username/htdocs');

// Git binary path on InfinityFree
define('GIT_PATH', '/usr/bin/git');

// Enable logging
define('ENABLE_LOG', true);
define('LOG_FILE', DEPLOY_PATH . '/deploy.log');

// ============================================
// DO NOT EDIT BELOW THIS LINE
// ============================================

/**
 * Log function
 */
function logMessage($message) {
    if (!ENABLE_LOG) return;
    
    $timestamp = date('Y-m-d H:i:s');
    $logEntry = "[{$timestamp}] {$message}\n";
    
    file_put_contents(LOG_FILE, $logEntry, FILE_APPEND);
}

/**
 * Execute command
 */
function executeCommand($command) {
    logMessage("Executing: {$command}");
    
    $output = [];
    $returnCode = 0;
    
    exec($command . ' 2>&1', $output, $returnCode);
    
    $outputStr = implode("\n", $output);
    logMessage("Output: {$outputStr}");
    logMessage("Return code: {$returnCode}");
    
    return [
        'output' => $outputStr,
        'return_code' => $returnCode,
        'success' => $returnCode === 0
    ];
}

/**
 * Verify GitHub webhook signature
 */
function verifySignature($payload, $signature) {
    if (empty($signature)) {
        return false;
    }
    
    $expectedSignature = 'sha256=' . hash_hmac('sha256', $payload, WEBHOOK_SECRET);
    
    return hash_equals($expectedSignature, $signature);
}

// ============================================
// MAIN DEPLOYMENT PROCESS
// ============================================

logMessage("=== Deployment process started ===");

// Get request payload
$payload = file_get_contents('php://input');
$signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';

// Verify webhook signature
if (!verifySignature($payload, $signature)) {
    logMessage("ERROR: Invalid webhook signature");
    http_response_code(403);
    die('Invalid signature');
}

logMessage("Webhook signature verified");

// Parse payload
$data = json_decode($payload, true);

if (!$data) {
    logMessage("ERROR: Invalid JSON payload");
    http_response_code(400);
    die('Invalid payload');
}

// Check if it's a push to the correct branch
$ref = $data['ref'] ?? '';
$expectedRef = 'refs/heads/' . BRANCH;

if ($ref !== $expectedRef) {
    logMessage("Ignoring push to {$ref}, expecting {$expectedRef}");
    die('Ignoring push to different branch');
}

logMessage("Push detected to {$ref}");

// Change to deployment directory
chdir(DEPLOY_PATH);

// Check if git repository exists
if (!file_exists(DEPLOY_PATH . '/.git')) {
    logMessage("Git repository not found, cloning...");
    
    // Clone repository
    $result = executeCommand(GIT_PATH . ' clone ' . REPO_URL . ' .');
    
    if (!$result['success']) {
        logMessage("ERROR: Failed to clone repository");
        http_response_code(500);
        die('Failed to clone repository');
    }
    
    logMessage("Repository cloned successfully");
} else {
    logMessage("Git repository found, pulling changes...");
    
    // Pull latest changes
    $result = executeCommand(GIT_PATH . ' pull origin ' . BRANCH);
    
    if (!$result['success']) {
        logMessage("ERROR: Failed to pull changes");
        http_response_code(500);
        die('Failed to pull changes');
    }
    
    logMessage("Changes pulled successfully");
}

// Install/Update Composer dependencies
if (file_exists(DEPLOY_PATH . '/composer.json')) {
    logMessage("Running composer install...");
    
    $result = executeCommand('composer install --no-dev --optimize-autoloader --no-interaction');
    
    if ($result['success']) {
        logMessage("Composer dependencies installed");
    } else {
        logMessage("WARNING: Composer install failed (might need manual install)");
    }
}

// Run Laravel optimization commands
logMessage("Running Laravel optimizations...");

// Clear and cache config
executeCommand('php artisan config:clear');
executeCommand('php artisan config:cache');

// Clear and cache routes
executeCommand('php artisan route:clear');
executeCommand('php artisan route:cache');

// Clear and cache views
executeCommand('php artisan view:clear');
executeCommand('php artisan view:cache');

// Run migrations (with --force for production)
logMessage("Running database migrations...");
$result = executeCommand('php artisan migrate --force');

if ($result['success']) {
    logMessage("Migrations completed successfully");
} else {
    logMessage("WARNING: Migrations failed or no migrations to run");
}

// Clear application cache
executeCommand('php artisan cache:clear');

logMessage("=== Deployment completed successfully ===");

// Return success response
http_response_code(200);
echo json_encode([
    'status' => 'success',
    'message' => 'Deployment completed successfully',
    'timestamp' => date('Y-m-d H:i:s')
]);
