<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Salle d'attente - Redirection</title>
    <meta http-equiv="refresh" content="5;url=login.php">
    <style>
        body {
            margin: 0;
            padding: 0;
            height: 100vh;
            background: #111;
            color: white;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            font-family: Arial, sans-serif;
        }

        .loader {
            border: 8px solid rgba(255, 255, 255, 0.2);
            border-top: 8px solid #00c3ff;
            border-radius: 50%;
            width: 80px;
            height: 80px;
            animation: spin 1s linear infinite;
            margin-bottom: 20px;
        }

        @keyframes spin {
            to { transform: rotate(360deg); }
        }

        h1 {
            margin-bottom: 10px;
        }

        p {
            font-size: 16px;
            color: #aaa;
        }
    </style>
</head>
<body>
    <div class="loader"></div>
    <h1>Inscription réussie !</h1>
    <p>Redirection vers la page de connexion...</p>
</body>
</html>
