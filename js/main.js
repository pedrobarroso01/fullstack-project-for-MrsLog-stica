// add hovered class to select list item
let list = document.querySelectorAll(".navegation li");

function activeLink(){
    list.forEach(item=>{
        item.classList.remove("hovered");
    })
    this.classList.add("hovered");
}

list.forEach((item) => item.addEventListener("mouseover",activeLink));


// Menu Toggle - Barra de Menu
let toggle = document.querySelector(".toggle");
let navegation = document.querySelector(".navegation");
let main = document.querySelector(".main");
let screenView = document.querySelector(".screenView");

toggle.onclick = function(){
    navegation.classList.toggle("active");
    main.classList.toggle("active");
    screenView.classList.toggle("active");
};

// Seleção automatica do Home - li
document.addEventListener("DOMContentLoaded", function() {
    // Usando a mesma base da primeira função, atribuo a classe 'hovered' à segunda opção da lista, ul li
    var secondNavItem = document.querySelector('.navegation ul li:nth-child(2)');
    secondNavItem.classList.add('hovered');
});