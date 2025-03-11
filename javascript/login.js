const form = document.querySelector(".login form"),
      continueBtn = form.querySelector(".button input"),
      errorText = form.querySelector(".error-txt");

form.addEventListener("submit", (e) => e.preventDefault());

continueBtn.addEventListener("click", () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "./controller/LoginController.php", true); // Vérifie si le chemin est correct
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            let data = xhr.response.trim(); // Trim pour éviter les espaces blancs
            console.log(data);

            if (data === "success") {
                // Une fois l'utilisateur authentifié, on récupère l'ID unique de la session PHP
                let userId = <?php echo $_SESSION['unique_id']; ?>;  // Utiliser PHP pour insérer l'ID utilisateur dans le script

                // Rediriger vers le chat avec l'ID utilisateur passé en paramètre
                location.href = `./view/chat.php?user_id=${userId}`;
            } else {
                errorText.innerHTML = data;
                errorText.style.display = "block";
            }
        }
    };

    // Ajoute les données du formulaire à FormData
    let formData = new FormData(form);
    xhr.send(formData);
});
