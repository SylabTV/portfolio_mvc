<?php
function renderMedia(string $mediaUrl, string $alt = '', string $cssClass = ''): void
{
    $ext = strtolower(pathinfo($mediaUrl, PATHINFO_EXTENSION));
    $src = 'public/img/projects/' . htmlspecialchars($mediaUrl);

    if ($ext === 'webm') {
        echo '<div class="' . $cssClass . '">
            <video autoplay loop muted playsinline>
                <source src="' . $src . '" type="video/webm" />
            </video>
        </div>';
    } else {
        echo '<div class="' . $cssClass . '">
            <img src="' . $src . '" alt="' . htmlspecialchars($alt) . '" />
        </div>';
    }
}