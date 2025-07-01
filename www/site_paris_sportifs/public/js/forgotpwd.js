/*Gestion du mot de passe oublié*/
document.getElementById("forgot-password").addEventListener("click", function(e) {
  e.preventDefault(); // empêche la navigation
  const msg = document.getElementById("forgot-msg");
    
  msg.classList.remove("hidden");
    
  setTimeout(() => {
    msg.classList.add("hidden");
  }, 3000); // 3 secondes
});
