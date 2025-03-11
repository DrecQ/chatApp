const form = document.querySelector(".typing-area"),
      inputField = form.querySelector(".input-field"),
      sendBtn = form.querySelector("button"),
      chatBox = document.querySelector(".chat-box");

form.addEventListener("submit", (e) => e.preventDefault());

sendBtn.addEventListener("click", () => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../controller/InsertChat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            inputField.value = "";
            scrollToBottom(); // Scroll vers le bas après l'envoi d'un message
        }
    };
    let formData = new FormData(form);
    xhr.send(formData);
});

setInterval(() => {
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../controller/get-chat.php", true);
    xhr.onload = () => {
        if (xhr.readyState === XMLHttpRequest.DONE && xhr.status === 200) {
            let data = xhr.response;
            chatBox.innerHTML = data;
            scrollToBottom(); // Scroll vers le bas après réception des messages
        }
    };
    xhr.send(); // Ne pas envoyer `FormData`, juste une requête simple
}, 500);

function scrollToBottom() {
    chatBox.scrollTop = chatBox.scrollHeight;
}
