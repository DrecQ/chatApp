const form = document.querySelector(".login form"),
continueBtn = form.querySelector(".button input"),
errorText = form.querySelector(".error-txt");


form.onsubmit = (e)=>{
  e.preventDefault(); 
}

continueBtn.onclick = ()=>{
  //Ajax 

  let xhr = new XMLHttpRequest();
  xhr.open("POST", "../controller/LoginController.php", true);
  xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE)
      {
          if(xhr.status === 200)
          {
              let data = xhr.response;
              console.log(data);
                if(data == "success")
               {
                   location.href = "user.php";
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