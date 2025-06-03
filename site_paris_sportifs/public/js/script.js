/*Pour le message de prévention dans le header*/
document.addEventListener('DOMContentLoaded', () => {
  const messages = [
    "🔞 Parier comporte des risques… la pauvreté en comporte davantage !",
    "🔞 Parier comporte des risques… mais s'arrêter c'est accepter sa défaite.",
    "🔞 Parier comporte des risques… mais qui ne tente rien n’a rien",
    "🔞 Parier comporte des risques… mais la vie sans risque est ennuyeuse !",
    "🔞 Parier comporte des risques… mais vous êtes peut-être à un pari de vous refaire.",
    "🔞 Votre banquier n'aime pas ce site. Nous si.",
    "🔞 Si vous perdez, ce n’est pas de la malchance. C’est la faute de l’arbitre.",
    "🔞 Ne rêvez pas votre vie, pariez-la.",
    "🔞 Le jeu ne fait pas le bonheur… sauf quand ça passe à la 95e.",
    "🔞 Misez. Vibrez. Recommencez.",
    "🔞 Parier ne résout pas les problèmes. Mais ça les rend plus excitants.",
    "🔞 La chance ne sourit qu'aux audacieux et aux parieurs.",
    "🔞 La vie est un pari. Faites-en un gagnant.",
    "🔞 Parier, c’est comme l’amour : parfois on gagne, parfois on perd, mais on ne s’ennuie jamais.",
  ];

  const messageElement = document.getElementById("message");
    const randomIndex = Math.floor(Math.random() * messages.length);
    messageElement.textContent = messages[randomIndex];
  }
);



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

    videoContainer.innerHTML = `<p>🎬 La publicité commence... Patientez 15 secondes.</p>`;

    const iframe = document.createElement('iframe');
    iframe.width = 560;
    iframe.height = 315;
    iframe.src = "https://www.youtube.com/embed/dQw4w9WgXcQ?autoplay=1&controls=0";
    iframe.frameBorder = 0;
    iframe.allow = "autoplay";
    iframe.allowFullscreen = true;

    videoContainer.appendChild(iframe);

    setTimeout(() => {
      fetch('/site_paris_sportifs/reward_ad')
        .then(res => res.json())
        .then(data => {
          if (data.success) {
            balanceElem.textContent = data.newBalance;
            rewardMsg.textContent = "✅ +200 unités ajoutées à votre solde !";
          } else {
            rewardMsg.textContent = "Erreur : " + data.message;
          }
        });
    }, 15000);
  });
});
