<!doctype html>
<html lang="fr">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="author" content="Souleymane Coulibaly" />
    <meta name="description" content="Portfolio web mobile designer developpeur" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
    <link href="https://fonts.googleapis.com/css2?family=Syncopate:wght@400;700&family=Rajdhani:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="css/style.css" />
    <title>CS Web — Portfolio Développeur</title>
</head>
<body>
    <div class="grain"></div>
    <header>
        <a href="index.php" class="logo-link">
            <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) : ?>
                <span class="logo-text admin-mode">ADMIN</span>
            <?php else : ?>
                <span class="logo-text">Portfolio</span>
            <?php endif; ?>
        </a>

        <nav class="menu">
            <ul>
                <li><a href="index.php">Accueil</a></li>
                <li><a href="index.php#about">À propos</a></li>
                <li><a href="index.php#competences">Compétences</a></li>
                <li><a href="index.php#projets">Projets</a></li>
                <li><a href="index.php#contact">Contact</a></li>
                
                <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) : ?>
                    <li>
                        <a href="index.php?route=logout" style="color: #ff4d4d; border: 1px solid rgba(255, 77, 77, 0.3);">
                            <i class="fa-solid fa-power-off"></i>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </nav>

        <nav class="link">
            <ul>
                <li>
                    <a href="https://github.com/SylabTV" class="button-contact" aria-label="GitHub" target="_blank">
                        <i class="fa-brands fa-github"></i>
                    </a>
                </li>
                <li>
                    <a href="https://www.linkedin.com/in/scoulibaly22/" class="button-contact" aria-label="LinkedIn" target="_blank">
                        <i class="fa-brands fa-linkedin-in"></i>
                    </a>
                </li>
            </ul>
        </nav>

        <button class="theme-toggle" id="themeToggle" aria-label="Basculer le thème">
            <span class="theme-toggle-track">
                <span class="theme-toggle-thumb"></span>
                <span class="theme-label theme-label-dark">DARK</span>
                <span class="theme-label theme-label-light">LIGHT</span>
            </span>
        </button>
    </header>
    <main>