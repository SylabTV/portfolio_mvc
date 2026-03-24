//ANIMATION HERO
//miniabout et minicompetences sortent de derriere la photo
const presentation = document.querySelector(".presentation");

document.addEventListener("DOMContentLoaded", () => {
  //CLASSES D ANIMATION
  //on assigne les classes a chaque element
  const revealMap = [
    { selector: ".section-tag", cls: "js-reveal" },
    { selector: ".about h2", cls: "js-reveal" },
    { selector: ".about-text p", cls: "js-reveal" },
    { selector: ".about-stats", cls: "js-reveal-right" },
    { selector: ".stat", cls: "js-reveal" },
    { selector: ".competences h2", cls: "js-reveal" },
    { selector: ".skill-card", cls: "js-reveal-scale" },
    { selector: ".contact h2", cls: "js-reveal" },
    { selector: ".contact-sub", cls: "js-reveal" },
    { selector: ".contact-form", cls: "js-reveal" },
  ];

  revealMap.forEach(({ selector, cls }) => {
    document.querySelectorAll(selector).forEach((el, i) => {
      el.classList.add(cls);
      el.style.transitionDelay = `${i * 0.1}s`;
    });
  });

  //COMPTEUR ANIME
  //force la valeur finale a la fin pour etre sur
  function animateCounter(el, duration = 1400) {
    const raw = el.dataset.val;
    const target = parseInt(raw);
    const suffix = raw.replace(/[0-9]/g, "");
    let startTime = null;
    const step = (timestamp) => {
      if (!startTime) startTime = timestamp;
      const progress = Math.min((timestamp - startTime) / duration, 1);
      const eased = 1 - Math.pow(2, -10 * progress);
      el.textContent = Math.floor(eased * target) + suffix;
      if (progress < 1) requestAnimationFrame(step);
      else el.textContent = raw;
    };
    requestAnimationFrame(step);
  }

  //SAUVEGARDE DES VALEURS HTML
  //on sauvegarde les valeurs du html avant tout
  document.querySelectorAll(".stat-num").forEach((el) => {
    el.dataset.val = el.textContent.trim();
  });

  //CHECK REVEAL
  //scroll.js appelle cette fonction apres chaque scroll
  //on ajoute is-visible aux elements visibles et on lance les animations
  window.checkReveal = function () {
    //HERO
    //double rAF pour forcer la transition a repartir a chaque visite
    const heroRect = presentation.getBoundingClientRect();
    if (heroRect.top < window.innerHeight && heroRect.bottom > 0) {
      presentation.classList.remove("active");
      requestAnimationFrame(() =>
        requestAnimationFrame(() => {
          presentation.classList.add("active");
        }),
      );
    } else {
      presentation.classList.remove("active");
    }
    document
      .querySelectorAll(".js-reveal, .js-reveal-right, .js-reveal-scale")
      .forEach((el) => {
        const rect = el.getBoundingClientRect();
        if (rect.top < window.innerHeight && rect.bottom > 0) {
          el.classList.add("is-visible");
        }
      });

    //COMPTEUR
    //se relance a chaque fois que la section devient visible
    document.querySelectorAll(".stat-num").forEach((el) => {
      const rect = el.getBoundingClientRect();
      if (rect.top < window.innerHeight && rect.bottom > 0) {
        animateCounter(el);
      }
    });
  };

  window.checkReveal();

  //TILT 3D
  //sur les cards
  document.querySelectorAll(".skill-card").forEach((card) => {
    card.style.transition =
      "transform 0.3s ease, box-shadow 0.3s ease, background 0.3s";
    card.addEventListener("mousemove", (e) => {
      const rect = card.getBoundingClientRect();
      const x = (e.clientX - rect.left) / rect.width - 0.5;
      const y = (e.clientY - rect.top) / rect.height - 0.5;
      card.style.transform = `translateY(-6px) rotateX(${-y * 7}deg) rotateY(${x * 7}deg)`;
      card.style.boxShadow = "0 16px 40px rgba(0,0,0,0.6)";
    });
    card.addEventListener("mouseleave", () => {
      card.style.transform = "translateY(0) rotateX(0deg) rotateY(0deg)";
      card.style.boxShadow = "none";
    });
  });

  //EFFET VAGUE
  //sur le bouton envoyer
  const submitBtn = document.querySelector(
    ".contact-form button[type='submit']",
  );
  if (submitBtn) {
    submitBtn.addEventListener("click", function (e) {
      const ripple = document.createElement("span");
      const rect = this.getBoundingClientRect();
      const size = Math.max(rect.width, rect.height);
      ripple.style.cssText = `
        position: absolute;
        width: ${size}px;
        height: ${size}px;
        border-radius: 50%;
        background: rgba(255,255,255,0.18);
        transform: scale(0);
        left: ${e.clientX - rect.left - size / 2}px;
        top:  ${e.clientY - rect.top - size / 2}px;
        animation: rippleAnim 0.55s ease forwards;
        pointer-events: none;
      `;
      this.appendChild(ripple);
      setTimeout(() => ripple.remove(), 600);
    });

    if (!document.getElementById("ripple-style")) {
      const s = document.createElement("style");
      s.id = "ripple-style";
      s.textContent = `@keyframes rippleAnim { to { transform: scale(2.6); opacity: 0; } }`;
      document.head.appendChild(s);
    }
  }

  //LIEN NAV ACTIF
  const navLinks = document.querySelectorAll(".menu a[href^='#']");
  const navSections = document.querySelectorAll("section");

  const navObserver = new IntersectionObserver(
    (entries) => {
      entries.forEach((entry) => {
        if (entry.isIntersecting) {
          const id = entry.target.id || entry.target.className.split(" ")[0];
          navLinks.forEach((link) => {
            const href = link.getAttribute("href").replace("#", "");
            const active = href === id;
            link.style.color = active ? "#ff0000ff" : "";
            link.parentElement.style.borderColor = active
              ? "rgba(255,255,255,0.6)"
              : "";
          });
        }
      });
    },
    { threshold: 0.3 },
  );

  navSections.forEach((s) => navObserver.observe(s));
});
