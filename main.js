
let modeNoel = false;

let boutonNoel = document.getElementById("modenoel");

let aside = document.getElementById("aside");
let section = document.getElementById("article");
let header = document.getElementById("header");
let footer = document.getElementById("footer");
let texte1 = document.getElementsByClassName("texte")[0];
let texte2 = document.getElementsByClassName("texte")[1];

boutonNoel.addEventListener("click", modenoel);
function modenoel()
{
    if(!modeNoel)
    {

        modeNoel = true;
        aside.style.backgroundImage = "url('image/Gragas_3.png')";
        section.style.backgroundImage = "url('image/foret.jpg')";
        header.style.backgroundImage = "url('image/guirlande2.gif')";
        texte1.style.color = "white";
        texte2.style.color = "white";
        boutonNoel.innerHTML = "Mode normal";
        footer.style.backgroundColor = "red";
    }
    else
    {
        modeNoel = false;
        aside.style.backgroundImage = "url('image/simple.jpg')";
        section.style.backgroundImage = "";
        header.style.backgroundImage = "";
        texte1.style.color = "white";
        texte2.style.color = "white";
        boutonNoel.innerHTML = "Mode Noël";
        footer.style.backgroundColor = "#4caf50";
    }
    
}