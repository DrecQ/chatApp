  const form = document.querySelector(".signup form"),
  continueBtn = form.querySelector(".button input"),
  errorText = form.querySelector(".error-txt");


form.onsubmit = (e)=>{
    e.preventDefault(); 
}

  continueBtn.onclick = ()=>{
    //Ajax 

    let xhr = new XMLHttpRequest();
    xhr.open("POST", "controller/signup.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE)
        {
            if(xhr.status === 200)
            {
                let data = xhr.response;
                if(data == "success")
                {
                    location.href = "view/login.php";
                }else{
                    errorText.textContent = data;
                    errorText.style.display = "block";
                }
            }
        }
    }

    // Envoie des informations d'Ajax à php
    let formData = new FormData(form);
    xhr.send(formData);
}