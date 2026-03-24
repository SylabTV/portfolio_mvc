<section class="project-detail">
  <div class="section-tag">PROJET</div>
  <h2><?= htmlspecialchars($project->getTitle()) ?></h2>

  <?php if ($project->getMediaUrl()) : ?>
    <?php renderMedia($project->getMediaUrl(), $project->getTitle(), 'project-media-full') ?>
  <?php endif; ?>

  <p class="project-description"><?= htmlspecialchars($project->getDescription()) ?></p>

  <div class="project-links">
    <a href="<?= htmlspecialchars($project->getGithubUrl()) ?>" target="_blank" class="button-cta">
      <i class="fa-brands fa-github"></i> Voir le code
    </a>
    <?php if ($project->getLiveUrl()) : ?>
      <a href="<?= htmlspecialchars($project->getLiveUrl()) ?>" target="_blank" class="button-cta">
        <i class="fa-solid fa-arrow-up-right-from-square"></i> Voir le site
      </a>
    <?php endif; ?>
  </div>
  <a href="index.php#projets" class="button-voirplus">
    <i class="fa-solid fa-arrow-left"></i> Retour aux projets
  </a>
</section>