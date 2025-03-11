const form = document.querySelector(".signup form"),
      continueBtn = form.querySelector(".button input"),
      errorText = form.querySelector(".error-txt");

// Empêcher la soumission du formulaire classique
form.addEventListener("submit", (e) => {
    e.preventDefault(); 
});

// Gérer le clic sur le bouton d'inscription
continueBtn.addEventListener("click", () => {
    // Création de la requête AJAX
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../controller/signup.php", true); // Assurez-vous que le chemin est correct
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            let data = xhr.response.trim(); // Trim pour enlever les espaces superflus
            if (data === "success") {
                location.href = "../index.php"; // Redirection en cas de succès
            } else {
                errorText.textContent = data; // Affichage de l'erreur retournée
                errorText.style.display = "block";
            }
        }
    };

    // Envoi des données du formulaire via AJAX
    let formData = new FormData(form);
    xhr.send(formData);
});
