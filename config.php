<?php
//  SESSION TIMEOUT (30 minutes of inactivity)
define('SESSION_TIMEOUT', 30 * 60); 

ini_set('session.gc_maxlifetime', SESSION_TIMEOUT);
session_set_cookie_params([
    'lifetime' => SESSION_TIMEOUT,
    'path'     => '/',
    'secure'   => isset($_SERVER['HTTPS']),
    'httponly' => true,
    'samesite' => 'Lax',
]);

session_start();

// Inactivity check
if (!empty($_SESSION['user_id'])) {
    if (isset($_SESSION['last_active']) && (time() - $_SESSION['last_active']) > SESSION_TIMEOUT) {
        // Session has expired — destroy it cleanly
        session_unset();
        session_destroy();
        // Start a fresh session just to carry the flash message
        session_start();
        $_SESSION['timeout_msg'] = 'Your session has expired. Please log in again.';
        header('Location: login.php');
        exit;
    }
    // Refresh the activity timestamp on every page load
    $_SESSION['last_active'] = time();
}

//  SUPABASE CREDENTIALS
define('SUPABASE_URL', 'https://bmdswvdqnlpkaqqptqdf.supabase.co');
define('SUPABASE_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImJtZHN3dmRxbmxwa2FxcXB0cWRmIiwicm9sZSI6ImFub24iLCJpYXQiOjE3NzI2MzE1NDMsImV4cCI6MjA4ODIwNzU0M30.4Ql4lfLdECA1Nvu3w2-wqEII2gg07Z7C3elcFr4-Uc0');
define('SUPABASE_SERVICE_KEY', 'eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJpc3MiOiJzdXBhYmFzZSIsInJlZiI6ImJtZHN3dmRxbmxwa2FxcXB0cWRmIiwicm9sZSI6InNlcnZpY2Vfcm9sZSIsImlhdCI6MTc3MjYzMTU0MywiZXhwIjoyMDg4MjA3NTQzfQ.Ku7Ncmu7PH88geCzePiBlGesheNZP0PGj0_dmvAqjKQ');

//  CSRF PROTECTION
function csrfToken(): string {
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function csrfField(): string {
    return '<input type="hidden" name="csrf_token" value="'
        . htmlspecialchars(csrfToken(), ENT_QUOTES, 'UTF-8') . '">';
}

function csrfVerify(): void {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') return;
    $submitted = $_POST['csrf_token'] ?? ($_SERVER['HTTP_X_CSRF_TOKEN'] ?? '');
    if (empty($submitted) || empty($_SESSION['csrf_token']) || !hash_equals($_SESSION['csrf_token'], $submitted)) {
        http_response_code(403);
        unset($_SESSION['csrf_token']);
        die('<p style="font-family:sans-serif;padding:40px;max-width:480px;margin:auto"><strong>Security Error:</strong> Invalid or expired form token.<br><br><a href="javascript:history.back()" style="color:#2563eb">Go back and try again</a></p>');
    }
    unset($_SESSION['csrf_token']);
}

//  SUPABASE REQUEST
function supabaseRequest(string $endpoint, string $method = 'GET', ?array $data = null, array $extra = []): array {
    $url       = SUPABASE_URL . '/rest/v1/' . $endpoint;
    $activeKey = defined('SUPABASE_SERVICE_KEY') ? SUPABASE_SERVICE_KEY : SUPABASE_KEY;

    $headers = [
        'apikey: '               . $activeKey,
        'Authorization: Bearer ' . $activeKey,
        'Content-Type: application/json',
        'Prefer: return=representation',
    ];

    foreach ($extra as $h) {
        $headers[] = $h;
    }

    $ch = curl_init();
    curl_setopt_array($ch, [
        CURLOPT_URL            => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER     => $headers,
        CURLOPT_SSL_VERIFYPEER => false,
        CURLOPT_TIMEOUT        => 15,
    ]);

    switch (strtoupper($method)) {
        case 'POST':
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            break;
        case 'PATCH':
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PATCH');
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            break;
        case 'DELETE':
            curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
            break;
    }

    $response  = curl_exec($ch);
    $httpCode  = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError) {
        error_log('Supabase cURL error: ' . $curlError);
    }

    return [
        'data' => ($response && $response !== '') ? json_decode($response, true) : null,
        'code' => $httpCode,
    ];
}

//  HELPERS
function redirect(string $url): void {
    header('Location: ' . $url);
    exit;
}

function requireLogin(): void {
    if (empty($_SESSION['user_id'])) {
        redirect('login.php');
    }
}

function requireAdmin(): void {
    requireLogin();
    if (empty($_SESSION['is_admin'])) {
        redirect('index.php');
    }
}

function clean(string $val): string {
    return htmlspecialchars(trim($val), ENT_QUOTES, 'UTF-8');
}

function oppImage(int $index): string {
    $imgs = [
        'https://images.unsplash.com/photo-1593113598332-cd288d649433?w=700&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1559027615-cd4628902d4a?w=700&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1593113630400-ea4288922497?w=700&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1488521787991-ed7bbaae773c?w=700&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1532629345422-7515f3d16bb6?w=700&auto=format&fit=crop&q=80',
        'https://images.unsplash.com/photo-1469571486292-0ba58a3f068b?w=700&auto=format&fit=crop&q=80',
    ];
    return $imgs[$index % count($imgs)];
}