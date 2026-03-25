<section class="project-form">
  <div class="section-tag">ADMIN</div>
  <h2>Ajouter un projet</h2>
  
  <form class="contact-form" action="index.php?route=check_create" method="POST" enctype="multipart/form-data">
    
    <div class="form-row">
      <input type="text" name="title" placeholder="Titre du projet" required />
    </div>

    <textarea name="description" placeholder="Description du projet…" rows="5" ></textarea>

    <div class="form-row">
      <input type="url" name="github_url" placeholder="Lien GitHub"  />
      <input type="url" name="live_url" placeholder="Lien du site (optionnel)" />
    </div>

    <div class="form-row">
      <label for="project_file" style="margin-bottom: 10px; display: block;">Fichier média (GIF, WEBM, MP4, PNG, JPG)</label>
      <input type="file" name="project_file" id="project_file" accept=".gif,.webm,.mp4,.png,.jpg,.jpeg" required />
    </div>

    <button type="submit">
      <span>Ajouter le projet</span>
      <i class="fa-solid fa-plus"></i>
    </button>
  </form>

  <a href="index.php#projets" class="button-voirplus">
    <i class="fa-solid fa-arrow-left"></i> Retour aux projets
</a>
</section>