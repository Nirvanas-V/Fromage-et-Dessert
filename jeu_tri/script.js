
console.log('debut du code'); 

const redSquare = document.getElementById('redSquare');
let isRedDragging = false;

let blueSquareArray = []; // Array to store all blue squares

let blueSquare = createRandomSquare();
blueSquareArray.push(blueSquare);

let textContainer1 = document.getElementById('textContainer1');
let textContainer2 = document.getElementById('textContainer2');
let textContainer3 = document.getElementById('textContainer3');

redSquare.addEventListener('mousedown', startDragging.bind(null, redSquare, 'red'));

function addImageToSquare(square, imagePath) {
    const img = document.createElement('img');
    img.src = imagePath;
    img.alt = 'nop';
    if('image/bouteilless.png'==imagePath)
    {
        img.style.width = '34px';
        img.style.height = '50px';
        //img.style.position = 'relative';
    }
    else if('image/sac_plastique.png'==imagePath)
    {
        img.style.width = '120%';
        img.style.height = '120%';
    }
    else if('image/trognon.png'==imagePath)
    {
        img.style.width = '120%';
        img.style.height = '120%';
    }
    square.appendChild(img);
}


function createRandomSquare() {
    const newSquare = document.createElement('div');
    newSquare.className = 'square';
    newSquare.style.width = '50px';
    //newSquare.style.height = '50px';

    // Générer un nombre aléatoire entre 0 et 2 pour déterminer le type de carré
    const randomType = Math.floor(Math.random() * 3);

    if (randomType === 0) {
        newSquare.style.color = 'blue';
        addImageToSquare(newSquare, 'image/bouteilless.png');
    } else if (randomType === 1) {
        newSquare.style.color = 'yellow';
        addImageToSquare(newSquare, 'image/trognon.png');
    } else {
        newSquare.style.color = 'violet';
        addImageToSquare(newSquare, 'image/sac_plastique.png');
    }

    document.body.appendChild(newSquare);

    const maxX = window.innerWidth - 50;
    const randomX = Math.floor(Math.random() * maxX);
    newSquare.style.left = randomX + 'px';
    newSquare.style.top = '0px';

    return newSquare; 
}

// Modifier la fonction startNewBlueSquareInterval pour utiliser createRandomSquare
function startNewSquareInterval() {
    setInterval(function () {
        const newSquare = createRandomSquare();
        blueSquareArray.push(newSquare); // Ajouter le carré au tableau
        addDraggableBehavior(newSquare);
        fallSquare(newSquare);
    }, 3000);
}
function addDraggableBehavior(square) {
    let isDragging = false;

    square.addEventListener('mousedown', function (e) {
        isDragging = true;

        const offsetX = e.clientX - square.offsetLeft;
        const offsetY = e.clientY - square.offsetTop;

        document.addEventListener('mousemove', moveSquare);
        document.addEventListener('mouseup', function () {
            isDragging = false;
            document.removeEventListener('mousemove', moveSquare);
        });

        function moveSquare(e) {
            if (isDragging) {
                const posX = e.clientX - square.offsetWidth / 2;
                const posY = e.clientY - square.offsetHeight / 2;

                square.style.left = posX + 'px';
                square.style.top = posY + 'px';
            }
        }
    });
}

function startDragging(square, color, e) {
    if (color === 'red') {
        isRedDragging = true;
    }

    const offsetX = e.clientX - square.offsetLeft;
    const offsetY = e.clientY - square.offsetTop;

    document.addEventListener('mousemove', moveSquare.bind(null, square, color));
    document.addEventListener('mouseup', () => {
        if (color === 'red') {
            isRedDragging = false;
        }
        document.removeEventListener('mousemove', moveSquare);
    });
}

function moveSquare(square, color, e) {
    const isDragging = color === 'red' ? isRedDragging : false;

    if (isDragging) {
        const posX = e.clientX - square.offsetWidth / 2;
        const posY = e.clientY - square.offsetHeight / 2;

        square.style.left = posX + 'px';
        square.style.top = posY + 'px';

        // Check collision when moving the red square
        if (color === 'red') {
            checkCollision();
        }
    }
}

function isTouchingRedAndBlue(blueRect, redRect) {
    return (
        blueRect.left < redRect.right &&
        blueRect.right > redRect.left &&
        blueRect.top < redRect.bottom &&
        blueRect.bottom > redRect.top
    );
}

function checkCollision() {
    const redRect = redSquare.getBoundingClientRect();

    for (let i = 0; i < blueSquareArray.length; i++) {
        const square = blueSquareArray[i];
        const squareRect = square.getBoundingClientRect();

        if (isTouchingRedAndBlue(squareRect, redRect)) {
            pushBlueSquare(square);
        }
    }
}

function pushBlueSquare(square) {
    const pushDistance = 20;
    const currentLeft = parseInt(square.style.left, 10);
    const direction = currentLeft > redSquare.offsetLeft ? 'right' : 'left';
    const newLeft = direction === 'right' ? currentLeft + pushDistance : currentLeft - pushDistance;
    square.style.left = newLeft + 'px';
}


function fallSquare(square) {
    let posY = 0;

    function fall() {
        posY += 0.8;
        checkCollisionWithContainer1(square);
        if (posY + 10 > window.innerHeight) {
            posY = 0;
            console.log('carrer detruit');
            

            /* let currentCount = parseInt(textContainer1.textContent);
            textContainer1.textContent = currentCount - 1;

            let currentCount2 = parseInt(textContainer2.textContent);
            textContainer2.textContent = currentCount2 - 1;

            let currentCount3 = parseInt(textContainer3.textContent);
            textContainer3.textContent = currentCount3 - 1; */

            square.remove();
            
        }

        square.style.top = posY + 'px';

        requestAnimationFrame(fall);
    }

    fall();
}

function checkCollisionWithContainer1(square) {
    const rectangleContainer1 = document.getElementById('rectangleContainer1');
    const containerRect = rectangleContainer1.getBoundingClientRect();

    const rectangleContainer2 = document.getElementById('rectangleContainer2');
    const containerRect2 = rectangleContainer2.getBoundingClientRect();

    const rectangleContainer3 = document.getElementById('rectangleContainer3');
    const containerRect3 = rectangleContainer3.getBoundingClientRect();

    const blueSquareRect = square.getBoundingClientRect();

    if (
        blueSquareRect.left >= containerRect.left &&
        blueSquareRect.right <= containerRect.right &&
        blueSquareRect.top >= containerRect.top &&
        blueSquareRect.bottom <= containerRect.bottom &&
        square.style.color == "blue"
    ) {
        console.log('Carré entièrement dans rectangleContainer1, couleur:', square.style.backgroundColor);

        // Incrémenter le texte dans textContainer1
         let currentCount = parseInt(textContainer1.textContent);
        textContainer1.textContent = currentCount + 1; 
        //supprime
        posY = 0;
        square.remove();
    }

    else if (
        blueSquareRect.left >= containerRect2.left &&
        blueSquareRect.right <= containerRect2.right &&
        blueSquareRect.top >= containerRect2.top &&
        blueSquareRect.bottom <= containerRect2.bottom &&
        square.style.color == "yellow"
    )
    {console.log('Carré entièrement dans rectangleContainer1, couleur:', square.style.backgroundColor);

    // Incrémenter le texte dans textContainer1
     let currentCount = parseInt(textContainer2.textContent);
    textContainer2.textContent = currentCount + 1; 
    //supprime
    posY = 0;
    square.remove();}

    else if (
        blueSquareRect.left >= containerRect3.left &&
        blueSquareRect.right <= containerRect3.right &&
        blueSquareRect.top >= containerRect3.top &&
        blueSquareRect.bottom <= containerRect3.bottom &&
        square.style.color == "violet"
    )
    {console.log('Carré entièrement dans rectangleContainer1, couleur:', square.style.backgroundColor);

    // Incrémenter le texte dans textContainer1
     let currentCount = parseInt(textContainer3.textContent);
    textContainer3.textContent = currentCount + 1; 
    //supprime
    posY = 0;
    square.remove();}
}

//startNewBlueSquareInterval();
startNewSquareInterval();


fallSquare(blueSquare);


/* 
les geule du site
l'affichage
les explication
les visuelle de dejet
*/

