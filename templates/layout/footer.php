</main>

    <footer>
      <div class="footer-info">
        <p>&copy; 2026 — Souleymane Coulibaly</p>
      </div>
      
      <nav class="footer-nav">
        <a class="footer-link" href="https://github.com/SylabTV" target="_blank">GitHub</a>
        <a class="footer-link" href="https://www.linkedin.com/in/scoulibaly22/" target="_blank">LinkedIn</a>
        
        <?php if (isset($_SESSION['admin_logged_in']) && $_SESSION['admin_logged_in'] === true) : ?>
            <a class="footer-link" href="index.php?route=logout" style="color: #ff4d4d; border: 1px solid rgba(255,77,77,0.3); padding: 2px 8px; border-radius: 4px;">Déconnexion</a>
        <?php else : ?>
            <a class="footer-link" href="index.php?route=login" style="opacity: 0.2; font-size: 0.7rem;">Admin</a>
        <?php endif; ?>
      </nav>
    </footer>

    <script src="javascript/scroll.js"></script>
    <script src="javascript/animation.js"></script>
    <script src="javascript/theme.js"></script>
  </body>
</html>