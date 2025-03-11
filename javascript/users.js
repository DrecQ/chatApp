const searchBar = document.querySelector(".users .search input"),
      searchBtn = document.querySelector(".users .search button"),
      userList = document.querySelector(".users .users-list");

// Fonction pour envoyer une requête AJAX
function sendRequest(url, method, data = null) {
    let xhr = new XMLHttpRequest();
    xhr.open(method, url, true);
    
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            let response = xhr.response.trim();
            userList.innerHTML = response;
        }
    };
    
    if (data) {
        xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
        xhr.send(data);
    } else {
        xhr.send();
    }
}

// Gestion du clic sur le bouton de recherche
searchBtn.addEventListener("click", () => {
    searchBar.classList.toggle("active");
    searchBtn.classList.toggle("active");
    searchBar.focus();
    searchBar.value = "";
});

// Gestion de la saisie dans la barre de recherche
searchBar.addEventListener("keyup", () => {
    let searchTerm = searchBar.value.trim();

    if (searchTerm !== "") {
        searchBar.classList.add("active");
        sendRequest("../controller/Search.php", "POST", `searchTerm=${searchTerm}`);
    } else {
        searchBar.classList.remove("active");
    }
});

// Actualisation des utilisateurs toutes les 500ms (délai pour ne pas surcharger le serveur)
setInterval(() => {
    if (!searchBar.classList.contains("active")) {
        sendRequest("../controller/UserController.php", "GET");
    }
}, 500);
