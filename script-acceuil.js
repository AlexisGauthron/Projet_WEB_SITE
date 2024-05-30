document.addEventListener("DOMContentLoaded", function() {
    
    document.addEventListener("scroll", function() {
        const scrollPosition_y = window.scrollY;
        const scrollPosition_x = window.scrollX;

        const body = document.querySelector('.pp');
        const title = document.querySelector('.container_titre h1');
        const scrollLimit = 2700; // Définissez la distance de défilement limite en pixels
        body.style.height = '300vh';

        const blackDot = document.querySelector('.point_noir');
        const blackDotAppear = 500; // Distance à partir de laquelle le point noir apparaît

        const titleZoom = 1 + (scrollPosition_y / 500);

        // Calculer la taille de zoom en fonction de la position de défilement
        let zoom;
            
        if (scrollPosition_y < scrollLimit+200) {
            zoom = 100 + scrollPosition_y * 0.2; // Ajustez 0.2 pour changer l'intensité du zoom
            body.style.backgroundAttachment = "fixed";
            body.style.backgroundPosition = 'center';
        } 

        if(scrollPosition_y < scrollLimit-2550) {
            // Ajuster le padding
            const paddingValue = 2 + scrollPosition_y * 0.6; // Ajustez cette valeur selon vos besoins
            title.style.paddingTop = `${paddingValue}px`;
        }
        
        if(scrollPosition_y < scrollLimit-2200) {
            title.style.transform = `scale(${titleZoom})`;
        }

        // Appliquer le zoom comme taille de fond et centrer l'image sur les cages
        body.style.backgroundSize = `${zoom}%`;
        body.style.backgroundPosition = 'center'; // Ajustez cette valeur pour centrer sur les cages


         // Faire apparaître le point noir après une certaine distance
        if (scrollPosition_y >= blackDotAppear) {
            blackDot.style.opacity = 1;
        } else {
            blackDot.style.opacity = 0;
        }

    });

});
