<?php
if (file_exists(__DIR__ . '/../nightbot_secrets.php')) {
    include __DIR__ . '/../nightbot_secrets.php';
}

$CLIENT_ID = $NIGHTBOT_CLIENT_ID ?? getenv('NIGHTBOT_CLIENT_ID');
$CLIENT_SECRET = $NIGHTBOT_CLIENT_SECRET ?? getenv('NIGHTBOT_CLIENT_SECRET');
$REDIRECT_URI = $NIGHTBOT_REDIRECT_URI ?? getenv('NIGHTBOT_REDIRECT_URI');

$lang = substr($_SERVER['HTTP_ACCEPT_LANGUAGE'] ?? 'en', 0, 2);
$locale = ($lang === 'pt') ? 'pt' : 'en';

$messages = [
    'pt' => [
        'error' => 'Erro',
        'config_error' => 'Erro de Configuração',
        'auth_title' => 'Autenticando...',
        'auth_code_missing' => 'Código de autorização ausente.',
        'auth_failed' => 'Falha na autenticação com o Nightbot.',
        'config_missing' => 'As credenciais do Nightbot não foram definidas. Verifique o arquivo de segredos ou as variáveis de ambiente.',
        'connecting' => 'Conectando ao OBS...',
        'sending_tokens' => 'Enviando tokens para o seu plugin local.',
        'success' => 'Sucesso!',
        'close_window' => 'Você já pode fechar esta janela.',
        'obs_error' => 'Não foi possível conectar ao plugin do OBS. Verifique se o OBS está aberto.',
        'footer' => 'Esta página não pertence, não é associada e nem faz parte oficial do <a href="https://nightbot.tv" target="_blank">Nightbot</a>.<br>Desenvolvido por FabioZumbi12',
        'rate_limit' => 'Muitas requisições. Tente novamente em 1 minuto.',
        'refresh_missing' => 'refresh_token ausente',
        'info_title' => 'Plugin OBS Nightbot',
        'info_desc' => 'Esta página é usada para autenticação do plugin. Para baixar e instalar, utilize os links abaixo:',
        'download_btn' => 'Baixar Plugin',
        'source_btn' => 'Código Fonte'
    ],
    'en' => [
        'error' => 'Error',
        'config_error' => 'Configuration Error',
        'auth_title' => 'Authenticating...',
        'auth_code_missing' => 'Authorization code missing.',
        'auth_failed' => 'Authentication with Nightbot failed.',
        'config_missing' => 'Nightbot credentials not defined. Check secrets file or environment variables.',
        'connecting' => 'Connecting to OBS...',
        'sending_tokens' => 'Sending tokens to your local plugin.',
        'success' => 'Success!',
        'close_window' => 'You can close this window.',
        'obs_error' => 'Could not connect to OBS plugin. Check if OBS is open.',
        'footer' => 'This page is not owned by, associated with, or part of <a href="https://nightbot.tv" target="_blank">Nightbot</a>.<br>Developed by FabioZumbi12',
        'rate_limit' => 'Too many requests. Try again in 1 minute.',
        'refresh_missing' => 'refresh_token missing',
        'info_title' => 'OBS Nightbot Plugin',
        'info_desc' => 'This page is used for plugin authentication. To download and install, use the links below:',
        'download_btn' => 'Download Plugin',
        'source_btn' => 'Source Code'
    ]
];

$t = $messages[$locale];

$svg_success = '<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#4caf50" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>';
$svg_error = '<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#ff5252" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>';
$svg_loading = '<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#7289da" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="spin"><line x1="12" y1="2" x2="12" y2="6"></line><line x1="12" y1="18" x2="12" y2="22"></line><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"></line><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"></line><line x1="2" y1="12" x2="6" y2="12"></line><line x1="18" y1="12" x2="22" y2="12"></line><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"></line><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"></line></svg>';
$svg_download = '<svg xmlns="http://www.w3.org/2000/svg" width="64" height="64" viewBox="0 0 24 24" fill="none" stroke="#7289da" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"></path><g class="download-arrow"><polyline points="7 10 12 15 17 10"></polyline><line x1="12" y1="15" x2="12" y2="3"></line></g></svg>';

function renderHtml($title, $bodyContent, $script = '') {
    global $t, $locale;
    return "
    <!DOCTYPE html>
    <html lang='{$locale}'>
    <head>
      <meta charset='UTF-8'>
      <title>{$title}</title>
      <link href='https://fonts.googleapis.com/css2?family=Lexend:wght@300;400;500;600&display=swap' rel='stylesheet'/>
      <style>
        body {
          background-color: #18191e;
          color: #e0e6ed;
          font-family: 'Lexend', sans-serif;
          display: flex;
          flex-direction: column;
          align-items: center;
          justify-content: center;
          height: 100vh;
          margin: 0;
          text-align: center;
        }
        .panel {
          background-color: #1e2025;
          padding: 40px;
          border-radius: 8px;
          box-shadow: 0 4px 15px rgba(0, 0, 0, 0.5);
          max-width: 400px;
          width: 90%;
          border: 1px solid #26282d;
          display: flex;
          align-items: center;
          text-align: left;
        }
        h1 { margin-top: 0; margin-bottom: 15px; font-size: 24px; }
        p { color: #9aa5b1; margin-bottom: 0; line-height: 1.5; }
        .footer {
          margin-top: 30px;
          font-size: 12px;
          color: #5c6370;
          max-width: 400px;
          line-height: 1.5;
        }
        .footer a {
          color: #7289da;
          text-decoration: none;
        }
        .icon-box { margin-bottom: 0; margin-right: 20px; display: flex; justify-content: center; flex-shrink: 0; }
        .spin { animation: spin 2s linear infinite; }
        @keyframes spin { 100% { transform: rotate(360deg); } }
        .download-arrow { animation: bounce 2s infinite; }
        @keyframes bounce {
          0%, 20%, 50%, 80%, 100% { transform: translateY(0); }
          40% { transform: translateY(-6px); }
          60% { transform: translateY(-3px); }
        }
      </style>
    </head>
    <body>
      <div class='panel'>
        {$bodyContent}
      </div>
      <div class='footer'>
        {$t['footer']}
      </div>
      " . ($script ? "<script>{$script}</script>" : "") . "
    </body>
    </html>
    ";
}

if (!$CLIENT_ID || !$CLIENT_SECRET || !$REDIRECT_URI) {
    echo renderHtml($t['config_error'], "<div class='icon-box'>{$svg_error}</div><div><h1 style='color: #ff5252'>{$t['config_error']}</h1><p>{$t['config_missing']}</p></div>");
    exit;
}

$method = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (strpos($uri, '/refresh-token') !== false && $method === 'POST') {
    header('Content-Type: application/json');
    
    $ip = $_SERVER['REMOTE_ADDR'];
    $limit = 10; 
    $window = 60; 
    $rateFile = sys_get_temp_dir() . '/nb_ratelimit_' . md5($ip);
    
    $requests = file_exists($rateFile) ? json_decode(file_get_contents($rateFile), true) : [];
    if (!is_array($requests)) {
        $requests = [];
    }
    $now = time();
    
    $requests = array_filter($requests, function($timestamp) use ($now, $window) {
        return $timestamp > ($now - $window);
    });
    
    if (count($requests) >= $limit) {
        http_response_code(429);
        echo json_encode(['error' => $t['rate_limit']]);
        exit;
    }
    
    $requests[] = $now;
    file_put_contents($rateFile, json_encode($requests));

    $input = json_decode(file_get_contents('php://input'), true);
    $refreshToken = $input['refresh_token'] ?? null;

    if (!$refreshToken) {
        http_response_code(400);
        echo json_encode(['error' => $t['refresh_missing']]);
        exit;
    }

    $ch = curl_init('https://api.nightbot.tv/oauth2/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'client_id' => $CLIENT_ID,
        'client_secret' => $CLIENT_SECRET,
        'grant_type' => 'refresh_token',
        'refresh_token' => $refreshToken
    ]));
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);

    http_response_code($httpCode >= 400 ? 500 : 200);
    echo $response;
    exit;
}

if ($method === 'GET') {
    $code = $_GET['code'] ?? null;

    if (!$code) {
        $buttons = "
            <div style='margin-top: 20px;'>
                <a href='https://github.com/FabioZumbi12/NightbotSR-ObsPlugin/releases' target='_blank' style='display: inline-block; background-color: #7289da; color: #fff; padding: 10px 15px; border-radius: 4px; text-decoration: none; font-size: 14px; margin-right: 10px;'>{$t['download_btn']}</a>
                <a href='https://github.com/FabioZumbi12/NightbotSR-ObsPlugin/' target='_blank' style='display: inline-block; background-color: #4f545c; color: #fff; padding: 10px 15px; border-radius: 4px; text-decoration: none; font-size: 14px;'>{$t['source_btn']}</a>
            </div>
        ";
        echo renderHtml($t['info_title'], "<div class='icon-box'>{$svg_download}</div><div><h1 style='color: #7289da'>{$t['info_title']}</h1><p>{$t['info_desc']}</p>{$buttons}</div>");
        exit;
    }

    $ch = curl_init('https://api.nightbot.tv/oauth2/token');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'client_id' => $CLIENT_ID,
        'client_secret' => $CLIENT_SECRET,
        'grant_type' => 'authorization_code',
        'code' => $code,
        'redirect_uri' => $REDIRECT_URI
    ]));

    $response = curl_exec($ch);
    $data = json_decode($response, true);
    curl_close($ch);

    if (isset($data['error']) || !isset($data['access_token'])) {
        echo renderHtml($t['error'], "<div class='icon-box'>{$svg_error}</div><div><h1 style='color: #ff5252'>{$t['error']}</h1><p>{$t['auth_failed']}</p></div>");
        exit;
    }

    $jsonResponse = json_encode($data);
    
    $script = "
      fetch('http://localhost:8921/token', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({$jsonResponse})
      })
      .then(() => {
        document.getElementById('icon-box').innerHTML = '$svg_success';
        document.querySelector('h1').innerText = '{$t['success']}';
        document.querySelector('h1').style.color = '#4caf50';
        document.getElementById('status').innerText = '{$t['close_window']}';
        setTimeout(() => { 
            try {
                window.close();
            } catch (e) { console.log('Auto-close blocked by browser'); }
        }, 10000);
      })
      .catch(err => {
        document.getElementById('icon-box').innerHTML = '$svg_error';
        document.querySelector('h1').innerText = '{$t['error']}!';
        document.querySelector('h1').style.color = '#ff5252';
        document.getElementById('status').innerText = '{$t['obs_error']}';
      });
    ";

    echo renderHtml($t['auth_title'], "<div class='icon-box' id='icon-box'>{$svg_loading}</div><div><h1>{$t['connecting']}</h1><p id='status'>{$t['sending_tokens']}</p></div>", $script);
    exit;
}
?>
