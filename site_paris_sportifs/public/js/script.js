document.querySelectorAll(".contactForm").forEach(form => {
  const msg = form.querySelector(".msg");

  form.addEventListener("submit", function(e) {
    e.preventDefault();

    const formData = new FormData(form);

    fetch(form.action, {
      method: "POST",
      body: formData,
      headers: {
        "Accept": "application/json"
      }
    })
    .then(response => {
        if (response.ok) {
            msg.textContent = "Merci pour votre message !";
            msg.style.color = "green";
            form.reset();

            setTimeout(() => {
                msg.textContent = "";
            }, 2000);

            // Disparaît au clic hors formulaire
            document.addEventListener("click", function handleClickOutside(e) {
                if (!form.contains(e.target)) {
                    msg.textContent = "";
                    document.removeEventListener("click", handleClickOutside); // Retire l'écouteur une fois utilisé
                }
            })
      } else {
        response.json().then(data => {
          if (data.errors) {
            msg.textContent = data.errors.map(error => error.message).join(", ");
          } else {
            msg.textContent = "Une erreur est survenue.";
          }
          msg.style.color = "red";
        });
      }
    })
    .catch(() => {
      msg.textContent = "Une erreur est survenue.";
      msg.style.color = "red";
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
