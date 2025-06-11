/*Contactez nous qui marche*/
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


/*Publicité*/
document.addEventListener('DOMContentLoaded', () => {
  const adButton = document.getElementById('adButton');
  const videoContainer = document.getElementById('videoContainer');
  const rewardMsg = document.getElementById('rewardMsg');
  const balanceElem = document.getElementById('balance');

  if (!adButton || !videoContainer || !rewardMsg || !balanceElem) return;

  adButton.addEventListener('click', () => {
    adButton.disabled = true;
    console.log("On lance la pub !");
    videoContainer.classList.add('active');

    videoContainer.innerHTML = `<p style='color:black; padding: 1rem 0rem;'>🎬 La publicité commence... Patientez 15 secondes.</p>`;

    const iframe = document.createElement('iframe');
    iframe.width = 560;
    iframe.height = 315;
    iframe.src = "https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1&controls=0";
    iframe.frameBorder = 0;
    iframe.allow = "autoplay";
    iframe.allowFullscreen = true;

    videoContainer.appendChild(iframe);

    setTimeout(() => {
      // Masquer la pub (avec transition)
          videoContainer.classList.remove('active');

      // Nettoyer après la transition
      setTimeout(() => {
        videoContainer.innerHTML = '';
      }, 300);

      fetch('/site_paris_sportifs/reward_ad')
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            balanceElem.textContent = data.newBalance;
            rewardMsg.textContent = "✅ +200 unités ajoutées à votre solde !";

            // Disparition du message après 3s
            setTimeout(() => {
              rewardMsg.textContent = '';
            }, 3000);
          } else {
            rewardMsg.textContent = "Erreur : " + data.message;
          } 
        });
    }, 15000);
  });
});