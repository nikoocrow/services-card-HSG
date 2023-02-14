const detalles = document.querySelectorAll(".scard-body");

     detalles.forEach(element => {
        element.addEventListener("toggle", (event) => {
            if (element.open) {

                element.querySelector(".scard-toggle-open").style.display  = "none";
                element.querySelector(".scard-toggle-close").style.display = "block";
                  
            } else {
                element.querySelector(".scard-toggle-close").style.display = "none";
                element.querySelector(".scard-toggle-open").style.display  = "block";
               
            }
          });
             
    });



  



