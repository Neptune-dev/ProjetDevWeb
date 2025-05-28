// Message après envoi
document.querySelectorAll(".contactForm").forEach(form => {
  const msg = form.querySelector(".msg");

  form.addEventListener("submit", function(e) {
    e.preventDefault();
    msg.textContent = "Merci pour votre message !";
    msg.style.color = "green";
    form.reset();
    
    setTimeout(() => {
      msg.textContent = "";
    }, 2000);

    document.addEventListener("click", function handleClickOutside(e) {
        if (!form.contains(e.target)) {
            msg.textContent = "";
            document.removeEventListener("click", handleClickOutside); // Retire l'écouteur une fois utilisé
        }
    });
  });
});

//Couleur jaune sur la page active.
document.addEventListener("DOMContentLoaded", function () {
  const links = document.querySelectorAll("nav a");
  const currentUrl = window.location.pathname;

  links.forEach(link => {
    const linkPath = new URL(link.href).pathname;
    if (linkPath === currentUrl || linkPath.endsWith(currentUrl)) {
      link.classList.add("active");
    }
  });
});
