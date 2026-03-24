<section class="presentation">
  <h1>Découvrez mon<br />portfolio</h1>
  <div class="hero-label">
    <span>DÉVELOPPEUR</span>
    <span class="dot">·</span>
    <span>DESIGNER</span>
    <span class="dot">·</span>
    <span>UI/UX</span>
  </div>
  <div class="hero-layout">
    <div class="miniabout">
      <p>Je crée vos maquettes<br />et les transforme en sites<br /><strong class="strong">performants</strong> et responsives.</p>
      <a href="#contact" class="button-cta">Me contacter</a>
    </div>
    <div class="photo-wrapper">
      <img class="myphoto" src="img/moi.png" alt="Souleymane Coulibaly" />
    </div>
    <div class="minicompetences">
      <ul>
        <li>CSS</li>
        <li>HTML</li>
        <li>JavaScript</li>
        <li>UI Design / Figma</li>
      </ul>
      <a href="#competences" class="button-voirplus">Voir plus <i class="fa-solid fa-arrow-right"></i></a>
    </div>
  </div>
  <div class="scroll-indicator">
    <span>Scroll</span>
    <div class="scroll-line"></div>
  </div>
</section>

<section id="about" class="about">
  <div class="section-tag">01 — À PROPOS</div>
  <h2>Qui suis-je ?</h2>
  <div class="about-content">
    <div class="about-text">
      <p>Je m'appelle <strong>Souleymane Coulibaly</strong>, développeur web passionné par la création de sites modernes, rapides et accessibles.</p>
      <p>Je transforme des maquettes en sites web fonctionnels et responsives en utilisant HTML, CSS et JavaScript.</p>
      <p>Mon objectif : créer des interfaces simples, efficaces et agréables sur tous les appareils.</p>
    </div>
    <div class="about-stats">
      <div class="stat">
        <span class="stat-num">3WA</span>
        <span class="stat-label">3w Academy</span>
      </div>
      <div class="stat">
        <span class="stat-num">5+</span>
        <span class="stat-label">Projets réalisés</span>
      </div>
      <div class="stat">
        <span class="stat-num">100%</span>
        <span class="stat-label">Responsive</span>
      </div>
    </div>
  </div>
</section>

<section id="competences" class="competences">
  <div class="section-tag">02 — COMPÉTENCES</div>
  <h2>Mon stack</h2>
  <div class="skills-grid">
    <div class="skill-card">
      <div class="skill-icon"><i class="fa-brands fa-html5"></i></div>
      <h3>HTML5</h3>
      <p>Structure sémantique, accessibilité, SEO on-page.</p>
    </div>
    <div class="skill-card">
      <div class="skill-icon"><i class="fa-brands fa-css3-alt"></i></div>
      <h3>CSS3</h3>
      <p>Flexbox, Grid, animations, responsive design.</p>
    </div>
    <div class="skill-card">
      <div class="skill-icon"><i class="fa-brands fa-js"></i></div>
      <h3>JavaScript</h3>
      <p>DOM, ES6+, logique interactive et dynamique.</p>
    </div>
    <div class="skill-card">
      <div class="skill-icon"><i class="fa-brands fa-figma"></i></div>
      <h3>Figma / UI Design</h3>
      <p>Maquettes, prototypes, systèmes de design.</p>
    </div>
    <div class="skill-card">
      <div class="skill-icon"><i class="fa-brands fa-git-alt"></i></div>
      <h3>Git / GitHub</h3>
      <p>Versioning, collaboration, open source.</p>
    </div>
    <div class="skill-card">
      <div class="skill-icon"><i class="fa-brands fa-react"></i></div>
      <h3>React (bases)</h3>
      <p>Composants, state, hooks, rendu dynamique.</p>
    </div>
    <div class="skill-card">
      <div class="skill-icon"><i class="fa-brands fa-php"></i></div>
      <h3>PHP</h3>
      <p>Scripts serveur, logique back-end, formulaires.</p>
    </div>
    <div class="skill-card">
      <div class="skill-icon"><i class="fa-solid fa-database"></i></div>
      <h3>MySQL</h3>
      <p>Bases de données relationnelles, requêtes SQL.</p>
    </div>
    <div class="skill-card">
      <div class="skill-icon"><i class="fa-solid fa-leaf"></i></div>
      <h3>MongoDB</h3>
      <p>Base de données NoSQL, documents JSON.</p>
    </div>
  </div>
</section>

<section id="projets" class="projets">
  <div class="section-tag">03 — PROJETS</div>
  <h2>Mes réalisations</h2>
  
  <div class="projects-grid">
    <?php if (empty($projects)) : ?>
      <p class="no-projects">Aucun projet pour le moment.</p>
    <?php else : ?>
      <?php foreach ($projects as $project) : ?>
        <div class="project-card" style="position: relative; display: flex; flex-direction: column;">
          
          <a href="index.php?route=show&id=<?= $project->getId() ?>" class="project-link-wrapper">
            <?php if ($project->getMediaUrl()) : ?>
              <?php renderMedia($project->getMediaUrl(), $project->getTitle(), 'project-media-thumb') ?>
            <?php endif; ?>
          </a>

          <div class="project-card-body">
            <a href="index.php?route=show&id=<?= $project->getId() ?>" style="text-decoration: none; color: inherit;">
                <h3><?= htmlspecialchars($project->getTitle()) ?></h3>
            </a>
            
            <p><?= htmlspecialchars($project->getDescription()) ?></p>
            
            <div class="project-actions" style="margin-top: auto; display: flex; gap: 20px; padding-top: 15px;">
              
              <a href="<?= htmlspecialchars($project->getGithubUrl()) ?>" target="_blank" title="GitHub" style="position: relative; z-index: 10;">
                <i class="fa-brands fa-github"></i>
              </a>

              <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) : ?>
                <a href="index.php?route=update&id=<?= $project->getId() ?>" 
                   style="color: #3498db; position: relative; z-index: 10;" title="Modifier">
                  <i class="fa-solid fa-pen"></i>
                </a>

                <a href="index.php?route=delete&id=<?= $project->getId() ?>" 
                   onclick="return confirm('Supprimer ce projet ?');" 
                   style="color: #e74c3c; position: relative; z-index: 10;" title="Supprimer">
                  <i class="fa-solid fa-trash"></i>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
  
  <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) : ?>
    <div style="text-align: center; margin-top: 3rem;">
        <a href="index.php?route=create" class="button-cta" style="background: #27ae60; border-color: #27ae60;">
          <i class="fa-solid fa-plus"></i> Ajouter un projet
        </a>
    </div>
  <?php endif; ?>
</section>

<section id="contact" class="contact">
  <div class="section-tag">04 — CONTACT</div>
  <h2>Travaillons ensemble</h2>
  <p class="contact-sub">Un projet ? Une question ? Écrivez-moi.</p>
  
<form class="contact-form" action="https://formspree.io/f/xgonrqne" method="POST">
  <div class="form-row">
    <input type="text" name="name" placeholder="Votre nom" required />
    
    <input type="email" name="email" placeholder="Votre email" required />
  </div>

  <textarea name="message" placeholder="Votre message…" rows="5" required></textarea>

  <button type="submit">
    <span>Envoyer</span>
    <i class="fa-solid fa-paper-plane"></i>
  </button>
</form>
</section>