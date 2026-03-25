<?php
// config/helpers.php

if (!function_exists('renderMedia')) {
    function renderMedia(string $mediaUrl, string $alt = '', string $cssClass = ''): void
    {
        $ext = strtolower(pathinfo($mediaUrl, PATHINFO_EXTENSION));
        
        // ATTENTION : Vérifie bien que tes images sont dans ce dossier précis
        $src = 'public/img/projects/' . htmlspecialchars($mediaUrl);
        
        $videoExtensions = ['webm', 'mp4'];

        echo '<div class="' . htmlspecialchars($cssClass) . '">';

        if (in_array($ext, $videoExtensions)) {
            // Lecture auto + muet (indispensable) + boucle
            echo '<video autoplay loop muted playsinline style="width:100%; height:auto; display:block; border-radius:8px;">
                    <source src="' . $src . '" type="video/' . $ext . '" />
                  </video>';
        } else {
            echo '<img src="' . $src . '" alt="' . htmlspecialchars($alt) . '" style="width:100%; height:auto; display:block; border-radius:8px;" />';
        }

        echo '</div>';
    }
}