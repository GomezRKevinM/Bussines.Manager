const password = document.getElementById("login_clave");
const ver =document.getElementById("ver");
const verH =document.getElementById("verHover");
const ocultar =document.getElementById("hidden");
const ocultarH =document.getElementById("hiddenHover");

const password2 = document.getElementById("login_clave2");
const ver2 =document.getElementById("ver2");
const verH2 =document.getElementById("verHover2");
const ocultar2 =document.getElementById("hidden2");
const ocultarH2 =document.getElementById("hiddenHover2");

verH.style.display="none";
ocultar.style.display="none";
ocultarH.style.display="none";

verH2.style.display="none";
ocultar2.style.display="none";
ocultarH2.style.display="none";

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
function mostrarPassT(){
    password2.type="text";
    ver2.style.display="none";
    verH2.style.display="none";
    ocultar2.style.display="inline-block";
    ocultarH2.style.display="none";
}
function ocultarPassT(){
    password2.type="password";
    ver2.style.display="inline-block";
    verH2.style.display="none";
    ocultar2.style.display="none";
    ocultarH2.style.display="none";
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
ver2.addEventListener('mouseover',()=>{
    ver2.style.display="none";
    verH2.style.display="inline-block";
    ocultar2.style.display="none";
    ocultarH2.style.display="none";
})
verH2.addEventListener('mouseout',()=>{
    verH2.style.display="none";
    ver2.style.display="inline-block";
    ocultar2.style.display="none";
    ocultarH2.style.display="none";
})
ocultar2.addEventListener('mouseover',()=>{
    verH2.style.display="none";
    ver2.style.display="none";
    ocultar2.style.display="none";
    ocultarH2.style.display="inline-block";
})
ocultarH2.addEventListener('mouseout',()=>{
    verH2.style.display="none";
    ver2.style.display="none";
    ocultarH2.style.display="none";
    ocultar2.style.display="inline-block";
})

verH.addEventListener('click',mostrarPass);
ocultarH.addEventListener('click',ocultarPass);

verH2.addEventListener('click',mostrarPassT);
ocultarH2.addEventListener('click',ocultarPassT);
