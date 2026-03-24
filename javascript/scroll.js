const sections = document.querySelectorAll("section");
let isScrolling = false;
const WHEEL_THRESHOLD = 10;

window.addEventListener(
  "wheel",
  (e) => {
    e.preventDefault();

    if (isScrolling) return;
    if (Math.abs(e.deltaY) < WHEEL_THRESHOLD) return;

    isScrolling = true;
    const direction = e.deltaY > 0 ? 1 : -1;
    const headerH = document.querySelector("header").offsetHeight;
    let nextSection;

    if (direction > 0) {
      //SCROLL BAS
      //on cherche la premiere section dont le top depasse le header
      for (let i = 0; i < sections.length; i++) {
        const top = sections[i].getBoundingClientRect().top;
        if (top > headerH + 10) {
          nextSection = sections[i];
          break;
        }
      }
      if (!nextSection) nextSection = sections[sections.length - 1];
    } else {
      //SCROLL HAUT
      //on cherche la derniere section dont le top est derriere le header
      for (let i = sections.length - 1; i >= 0; i--) {
        const top = sections[i].getBoundingClientRect().top;
        if (top < headerH - 10) {
          nextSection = sections[i];
          break;
        }
      }
      if (!nextSection) nextSection = sections[0];
    }

    //RESET ANIMATIONS
    //on reset les animations de la section cible avant de scroller
    nextSection
      .querySelectorAll(".js-reveal, .js-reveal-right, .js-reveal-scale")
      .forEach((el) => {
        el.classList.remove("is-visible");
      });

    //HERO
    //si on quitte le hero on retire .active pour que l animation rejoue au retour
    const hero = document.querySelector(".presentation");
    if (nextSection !== hero) {
      hero.classList.remove("active");
    }

    //SCROLL TO SECTION
    //hero = y=0, autres = position absolue moins le header
    if (nextSection === hero) {
      window.scrollTo({ top: 0, behavior: "smooth" });
    } else {
      const targetY =
        window.scrollY + nextSection.getBoundingClientRect().top - headerH;
      window.scrollTo({ top: targetY, behavior: "smooth" });
    }

    //LANCEMENT ANIMATIONS
    //quand le scroll est fini on lance les animations
    setTimeout(() => {
      isScrolling = false;
      if (window.checkReveal) window.checkReveal();
    }, 850);
  },
  { passive: false },
);

//CLIC NAV
//pour les clics sur les liens nav - le wheel ne se declenche pas
let scrollTimer = null;
window.addEventListener("scroll", () => {
  clearTimeout(scrollTimer);
  scrollTimer = setTimeout(() => {
    if (window.checkReveal) window.checkReveal();
  }, 150);
});

//CLIC LOGO ET ACCUEIL
//remonte tout en haut
document
  .querySelectorAll(".logo-link, .menu a[href='#presentation']")
  .forEach((el) => {
    el.addEventListener("click", (e) => {
      e.preventDefault();
      window.scrollTo({ top: 0, behavior: "smooth" });
    });
  });
