# OBS Nightbot API

A lightweight PHP middleware designed to handle Nightbot OAuth2 authentication for a local OBS plugin. This API manages the authorization callback, exchanges authorization codes for tokens, and provides an endpoint for refreshing access tokens.

## Features

- OAuth2 Callback Handling: Receives the authorization code from Nightbot and exchanges it for access and refresh tokens.
- Local Plugin Integration: Automatically sends the retrieved tokens to a local OBS plugin running on localhost:8921.
- Token Refresh: Provides a secure endpoint to refresh expired access tokens.
- Rate Limiting: Protects against abuse with a limit of 10 requests per minute per IP.
- Internationalization: Automatically detects and serves the UI in English or Portuguese based on the user's browser settings.
- Dark Theme: A clean, dark-themed interface matching Nightbot's aesthetics.

## Installation

This project is designed to run on standard PHP hosting environments like cPanel.

1. Upload the index.php and .htaccess files to your web server's public directory (e.g., public_html or a subdirectory).
2. Ensure your server supports PHP and has cURL enabled.

## Configuration

You need to configure your Nightbot Client ID, Client Secret, and Redirect URI. You can do this in two ways:

### Option 1: Environment Variables (Recommended)

Edit the .htaccess file and set your environment variables:

SetEnv NIGHTBOT_CLIENT_ID "YOUR_CLIENT_ID"
SetEnv NIGHTBOT_CLIENT_SECRET "YOUR_CLIENT_SECRET"
SetEnv NIGHTBOT_REDIRECT_URI "https://your-domain.com/"

### Option 2: Secrets File

Create a file named nightbot_secrets.php one directory above your public root (to keep it inaccessible from the web) with the following content:

<?php
$NIGHTBOT_CLIENT_ID = "YOUR_CLIENT_ID";
$NIGHTBOT_CLIENT_SECRET = "YOUR_CLIENT_SECRET";
$NIGHTBOT_REDIRECT_URI = "https://your-domain.com/";
?>

## Endpoints

### GET /
The Callback URL. Configure your Nightbot App to redirect to this URL.
- Input: code (Query parameter)
- Behavior: Exchanges code for tokens, displays a success page, and POSTs tokens to http://localhost:8921/token.

### POST /refresh-token
Endpoint to refresh access tokens.
- Input (JSON): { "refresh_token": "..." }
- Output (JSON): New access token and refresh token data.

## Disclaimer
This project is not owned by, associated with, or part of Nightbot. Developed by FabioZumbi12.

## License
This project is licensed under the MIT License - see the LICENSE file for details.