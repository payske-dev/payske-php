<?php

require '../init.php';

\Payske\Payske::setApiKey(\getenv('Payske_SECRET_KEY'));
\Payske\Payske::setClientId(\getenv('Payske_CLIENT_ID'));

if (isset($_GET['code'])) {
    // The user was redirected back from the OAuth form with an authorization code.
    $code = $_GET['code'];

    try {
        $resp = \Payske\OAuth::token([
            'grant_type' => 'authorization_code',
            'code' => $code,
        ]);
    } catch (\Payske\Exception\OAuth\OAuthErrorException $e) {
        exit('Error: ' . $e->getMessage());
    }

    $accountId = $resp->Payske_user_id;

    echo "<p>Success! Account <code>{$accountId}</code> is connected.</p>\n";
    echo "<p>Click <a href=\"?deauth={$accountId}\">here</a> to disconnect the account.</p>\n";
} elseif (isset($_GET['error'])) {
    // The user was redirect back from the OAuth form with an error.
    $error = $_GET['error'];
    $error_description = $_GET['error_description'];

    echo '<p>Error: code=' . \htmlspecialchars($error, \ENT_QUOTES) . ', description=' . \htmlspecialchars($error_description, \ENT_QUOTES) . "</p>\n";
    echo "<p>Click <a href=\"?\">here</a> to restart the OAuth flow.</p>\n";
} elseif (isset($_GET['deauth'])) {
    // Deauthorization request
    $accountId = $_GET['deauth'];

    try {
        \Payske\OAuth::deauthorize([
            'Payske_user_id' => $accountId,
        ]);
    } catch (\Payske\Exception\OAuth\OAuthErrorException $e) {
        exit('Error: ' . $e->getMessage());
    }

    echo '<p>Success! Account <code>' . \htmlspecialchars($accountId, \ENT_QUOTES) . "</code> is disconnected.</p>\n";
    echo "<p>Click <a href=\"?\">here</a> to restart the OAuth flow.</p>\n";
} else {
    $url = \Payske\OAuth::authorizeUrl([
        'scope' => 'read_only',
    ]);
    echo "<a href=\"{$url}\">Connect with Payske</a>\n";
}
