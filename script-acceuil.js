document.addEventListener("DOMContentLoaded", function() {
    
    document.addEventListener("scroll", function() {
        const scrollPosition_y = window.scrollY;
        const scrollPosition_x = window.scrollX;

        const body = document.querySelector('.pp');
        const bodyh1 = document.querySelector('.container_titre');
        const scrollLimit = 10000; // Définissez la distance de défilement limite en pixels
        body.style.height = '600vh';


        // Calculer la taille de zoom en fonction de la position de défilement
        let zoom;
            
        if (scrollPosition_y < scrollLimit) {
            zoom = 100 + scrollPosition_y * 0.2; // Ajustez 0.2 pour changer l'intensité du zoom
            body.style.backgroundAttachment = "fixed";
            body.style.backgroundPosition = 'center';
            
        } 
        else {
            zoom = 100 + scrollLimit* 0.1;

            body.style.backgroundPosition = 'center 98%';
        }

        if(scrollPosition_y < scrollLimit/2) {
            bodyh1.style.backgroundSize = `${zoom}%`;
            bodyh1.style.backgroundAttachment = "scroll";
        }

        // Appliquer le zoom comme taille de fond et centrer l'image sur les cages
        body.style.backgroundSize = `${zoom}%`;
        body.style.backgroundPosition = 'center'; // Ajustez cette valeur pour centrer sur les cages
    });

});
