function previewPicture(e) {
    const [picture] = e.files;
    const img= document.querySelector("img#img-ajout-image");
    if ((e.files[0].size < 4000000) && (e.files[0].name.includes("png") || e.files[0].name.includes("jpg") | e.files[0].name.includes("jpeg"))) {
    if (picture) {
        img.src = URL.createObjectURL(picture);
        img.onload = () => {
          URL.revokeObjectURL(img.src);
        }; 
    }
  }
  else
    alert ("l'image est supérieure à 4 mo ou ne correspond pas au format d'images accepté (png, jpg ou jpeg)");
  
    } 


    

  function affichageMobile () {
    var affiche = document.getElementById("close");
    affiche.style = affiche.style ? "visible" : "none";

  }