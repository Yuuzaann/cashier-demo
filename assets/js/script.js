// DASHBOARD -------------------------------------------------
document.addEventListener("DOMContentLoaded", () => {
  const links = document.querySelectorAll(".nav-link");

  // Efek hover di menu
  links.forEach(link => {
    link.addEventListener("mouseenter", () => {
      link.style.transition = "all 0.3s ease";
      link.style.backgroundColor = "rgba(255,255,255,0.1)";
      link.style.paddingLeft = "20px";
    });
    link.addEventListener("mouseleave", () => {
      link.style.backgroundColor = "transparent";
      link.style.paddingLeft = "12px";
    });
  });
});
// ----------------------------------------------------------

// LOGIN -----------------------------------------------------
document.addEventListener("DOMContentLoaded", () => {
  const card = document.querySelector(".login-card");
  const form = document.querySelector("form");
  const btn = document.querySelector(".login-btn");

  // Efek muncul halus
  if (card) {
    setTimeout(() => {
      card.classList.add("show");
    }, 200);
  }

  // Efek shake kalau ada error
  if (card && card.dataset.error === "1") {
    card.classList.add("shake");
    setTimeout(() => card.classList.remove("shake"), 500);
  }

  // Animasi klik tombol login
  if (btn) {
    btn.addEventListener("click", () => {
      btn.classList.add("active");
      setTimeout(() => btn.classList.remove("active"), 200);
    });
  }
});
// -----------------------------------------------------------------

