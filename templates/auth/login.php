<section class="contact">
    <div class="section-tag">ADMINISTRATION</div>
    <h2>Connexion</h2>
    
    <?php if(isset($_GET['error'])): ?>
        <p style="color: #ff4d4d; margin-bottom: 20px;">Identifiants invalides</p>
    <?php endif; ?>

    <form class="contact-form" action="index.php?route=check_login" method="POST" style="max-width: 400px; margin: 0 auto;">
        <input type="text" name="name" placeholder="Nom d'admin" required />
        <input type="password" name="password" placeholder="Mot de passe" required />
        <button type="submit">
            <span>Entrer</span>
            <i class="fa-solid fa-unlock-keyhole"></i>
        </button>
    </form>
</section>