const password = document.getElementById("login_clave");
const ver =document.getElementById("ver");
const verH =document.getElementById("verHover");
const ocultar =document.getElementById("hidden");
const ocultarH =document.getElementById("hiddenHover");

verH.style.display="none";
ocultar.style.display="none";
ocultarH.style.display="none";

function mostrarPass(){
    password.type="text";
    ver.style.display="none";
    verH.style.display="none";
    ocultar.style.display="inline-block";
    ocultarH.style.display="none";
}
function ocultarPass(){
    password.type="password";
    ver.style.display="inline-block";
    verH.style.display="none";
    ocultar.style.display="none";
    ocultarH.style.display="none";
}

ver.addEventListener('mouseover',()=>{
    ver.style.display="none";
    verH.style.display="inline-block";
    ocultar.style.display="none";
    ocultarH.style.display="none";
})
verH.addEventListener('mouseout',()=>{
    verH.style.display="none";
    ver.style.display="inline-block";
    ocultar.style.display="none";
    ocultarH.style.display="none";
})
ocultar.addEventListener('mouseover',()=>{
    verH.style.display="none";
    ver.style.display="none";
    ocultar.style.display="none";
    ocultarH.style.display="inline-block";
})
ocultarH.addEventListener('mouseout',()=>{
    verH.style.display="none";
    ver.style.display="none";
    ocultarH.style.display="none";
    ocultar.style.display="inline-block";
})
verH.addEventListener('click',mostrarPass);
ocultarH.addEventListener('click',ocultarPass);
