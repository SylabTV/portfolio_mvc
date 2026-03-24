// DARK LIGHT MODE
(function () {
  const btn = document.getElementById("themeToggle");
  const photo = document.querySelector(".myphoto");

  if (!btn) return;

  function updatePhoto(isLight) {
    if (photo) photo.src = isLight ? "img/moi3.png" : "img/moi.png";
  }

  // Charger la préférence au démarrage
  const saved = localStorage.getItem("theme");
  if (saved === "light") {
    document.body.classList.add("light-mode");
    updatePhoto(true);
  }

  btn.addEventListener("click", () => {
    const isLight = document.body.classList.toggle("light-mode");
    localStorage.setItem("theme", isLight ? "light" : "dark");
    updatePhoto(isLight);
  });
})();
