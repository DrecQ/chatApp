const  searchBar = document.querySelector(".users .search input"),
searchBtn = document.querySelector(".users .search button"),
userList = document.querySelector(".users .users-list");


searchBtn.onclick =()=>{
    searchBar.classList.toggle("active");
    searchBar.focus();
    searchBtn.classList.toggle("active");
    searchBar.value = "";
}

searchBar.onkeyup =()=>{
    let searchTerm = searchBar.value;

    if (searchTerm != "")
        {
            searchBar.classList.add("active");
        }else{
            searchBar.classList.remove("active");
        }
    
    //Ajax 
    let xhr = new XMLHttpRequest();
    xhr.open("POST", "../controller/Search.php", true);
    xhr.onload = ()=>{
        if(xhr.readyState === XMLHttpRequest.DONE)
        {
            if(xhr.status === 200)
            {
                let data = xhr.response;
                userList.innerHTML = data;

            }
        }
    }
  xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded")
  xhr.send("searchTerm=" + searchTerm);

}
 
//
setInterval(() =>{

    //Ajax 
  let xhr = new XMLHttpRequest();
  xhr.open("GET", "../controller/UserController.php", true);
  xhr.onload = ()=>{
      if(xhr.readyState === XMLHttpRequest.DONE)
      {
          if(xhr.status === 200)
          {
              let data = xhr.response;
              if(!searchBar.classList.contains("active"))
                {
                    userList.innerHTML = data;
                }
          }
      }
  }

  xhr.send();

}, 500); 