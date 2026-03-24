<?php
function renderMedia(string $mediaUrl, string $alt = '', string $cssClass = ''): void
{
    $ext = strtolower(pathinfo($mediaUrl, PATHINFO_EXTENSION));
    
    // On conserve le chemin pointant vers le dossier public
    $src = 'public/img/projects/' . htmlspecialchars($mediaUrl);

    // Liste des extensions considérées comme des vidéos
    $videoExtensions = ['webm', 'mp4'];

    echo '<div class="' . htmlspecialchars($cssClass) . '">';

    if (in_array($ext, $videoExtensions)) {
        // Pour les vidéos : on utilise l'extension pour le type (video/mp4 ou video/webm)
        echo '<video autoplay loop muted playsinline style="width:100%; height:auto;">
                <source src="' . $src . '" type="video/' . $ext . '" />
                Votre navigateur ne supporte pas la lecture de vidéos.
              </video>';
    } else {
        // Pour les images (jpg, png, webp, etc.)
        echo '<img src="' . $src . '" alt="' . htmlspecialchars($alt) . '" style="width:100%; height:auto;" />';
    }

    echo '</div>';
}