const stock = document.querySelector(".stock");

for (let index = 0; index < stock.length; index++) {
    const element = stock[index];

    if(element>10){
        element.style.color="#27FF27";
    }if(element<=10){
        element.style.color="#FF2727";
        
    }

}


