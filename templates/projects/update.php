<section class="project-form">
  <div class="section-tag">ADMIN</div>
  <h2>Modifier un projet</h2>
  
  <form class="contact-form" action="index.php?route=check_update" method="POST" enctype="multipart/form-data">
    
    <input type="hidden" name="id" value="<?= $project->getId() ?>" />
    
    <div class="form-row">
      <input type="text" name="title" placeholder="Titre du projet" value="<?= htmlspecialchars($project->getTitle()) ?>"  />
    </div>

    <textarea name="description" placeholder="Description du projet…" rows="5" ><?= htmlspecialchars($project->getDescription()) ?></textarea>

    <div class="form-row">
      <input type="url" name="github_url" placeholder="Lien GitHub" value="<?= htmlspecialchars($project->getGithubUrl()) ?>" />
      <input type="url" name="live_url" placeholder="Lien du site (optionnel)" value="<?= htmlspecialchars($project->getLiveUrl()) ?>" />
    </div>

    <div class="form-row" style="flex-direction: column; align-items: flex-start;">
      <label style="margin-bottom: 10px;">Changer le média (laisser vide pour garder l'actuel) (GIF, WEBM, MP4, PNG, JPG)</label>
      <input type="file" name="project_file" id="project_file" accept=".gif,.webm,.mp4,.png,.jpg,.jpeg" />
      
      <?php if ($project->getMediaUrl()) : ?>
        <p style="font-size: 0.8rem; margin-top: 5px; opacity: 0.6;">
            Fichier actuel : <?= htmlspecialchars($project->getMediaUrl()) ?>
        </p>
      <?php endif; ?>
    </div>

    <button type="submit">
      <span>Modifier le projet</span>
      <i class="fa-solid fa-pen"></i>
    </button>
  </form>

  <a href="index.php#projets" class="button-voirplus">
    <i class="fa-solid fa-arrow-left"></i> Retour aux projets
</a>
</section>