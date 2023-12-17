<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tetris 404</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        body {
            position: relative;
            background-image: url('background2.png');
            background-position: center;
        }

        canvas {
            border: 10px solid #ffee00;
            border-top: none;
            display: block;
            padding-left: 5px;
            padding-right: 5px;
            margin: 0 auto;
            position: relative;
        }

        img {
            position: absolute;
            z-index: -1;
            left: 22%;
            top: -37.6%;
        }

        div {
            margin: 110px 0px;
        }

        p {
            color: white;
            position: center;
            position: absolute;
            font-size: 40px;
        }

        #nextPieceCanvas {
            border: 5px solid #888234;
            margin: 20px;
            
            padding: 10px;
            height: 100px;
        }

        .canvas-container {
            display: flex;
            justify-content: space-between;
        }

        .canvas-container {
            display: row;
            justify-content: space-between;
        }

        #txt_score{

            color: #ffee00;
        }

    </style>
</head>

<body class="bg-dark">

    <div class="container">
        <div class="justify-content-center">
            <div class="canvas-container">
            <div class="gerer_score">
                <h1 id="txt_score">Score : </h1>
                <p id="score"></p>
            </div>
                <canvas id="tetrisCanvas" width="502" height="510"></canvas>
                <canvas id="nextPieceCanvas" width="120" height="120"></canvas>
            </div>
            
            
        </div>



        <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

        <script>
            let score = document.getElementsByTagName("p")[0];
            let scoreInt = 0;
            score.textContent = scoreInt;
            const canvas = document.getElementById('tetrisCanvas');
            const context = canvas.getContext('2d');

            // Ajoutez cela dans votre code pour obtenir le canvas et le contexte pour la prochaine pièce
            const nextPieceCanvas = document.getElementById('nextPieceCanvas');
            const nextPieceContext = nextPieceCanvas.getContext('2d');

            const LIGNES = 10;
            const COLONNES = 10;
            const TAILLE_BLOC = 50;
            let randomIndexActuelle = -1;
            let randomIndexFutur;


            let tableau = Array.from({ length: LIGNES }, () => Array(COLONNES).fill(null));




            const pieces = [
                { shape: [[1, 1, 1, 1]], color: 'cyan' },
                { shape: [[1, 1], [1, 1]], color: 'yellow' },
                { shape: [[1, 1, 1], [0, 1, 0]], color: 'magenta' },
                { shape: [[1, 1, 1], [1, 0, 0]], color: 'orange' },
                { shape: [[1, 1, 1], [0, 0, 1]], color: 'green' },
                { shape: [[1, 1, 0], [0, 1, 1]], color: 'blue' },
                { shape: [[0, 1, 1], [1, 1, 0]], color: 'red' }
            ];


            let pieceActuelle = getRandomPiece();
            let currentPieceRow = 0;
            let currentPieceColumn = Math.floor(COLONNES / 2) - Math.floor(pieceActuelle.shape[0].length / 2);


            function draw() {
                context.clearRect(0, 0, canvas.width, canvas.height);
                drawBoard();
                drawPiece();
            }


            function drawBoard() {
                for (let ligne = 0; ligne < LIGNES; ligne++) {
                    for (let col = 0; col < COLONNES; col++) {
                        const blockColor = tableau[ligne][col];
                        if (blockColor) {
                            context.fillStyle = blockColor;
                            context.fillRect(col * TAILLE_BLOC, ligne * TAILLE_BLOC, TAILLE_BLOC, TAILLE_BLOC);
                            context.strokeStyle = 'black';
                            context.strokeRect(col * TAILLE_BLOC, ligne * TAILLE_BLOC, TAILLE_BLOC, TAILLE_BLOC);
                        }
                    }
                }
            }


            // Appelez cette fonction chaque fois que vous générez une nouvelle pièce pour la prochaine pièce
            function drawNextPiece(nextPiece) {
                nextPieceContext.clearRect(0, 0, nextPieceCanvas.width, nextPieceCanvas.height);
                const blockSize = nextPieceCanvas.width / nextPiece.shape[0].length;

                for (let row = 0; row < nextPiece.shape.length; row++) {
                    for (let col = 0; col < nextPiece.shape[row].length; col++) {
                        if (nextPiece.shape[row][col]) {
                            nextPieceContext.fillStyle = nextPiece.color;
                            nextPieceContext.fillRect(col * blockSize, row * blockSize, blockSize, blockSize);
                            nextPieceContext.strokeStyle = 'black';
                            nextPieceContext.strokeRect(col * blockSize, row * blockSize, blockSize, blockSize);
                        }
                    }
                }
            }


            function drawPiece() {
                for (let row = 0; row < pieceActuelle.shape.length; row++) {
                    for (let col = 0; col < pieceActuelle.shape[row].length; col++) {
                        if (pieceActuelle.shape[row][col]) {
                            context.fillStyle = pieceActuelle.color;
                            context.fillRect((currentPieceColumn + col) * TAILLE_BLOC, (currentPieceRow + row) * TAILLE_BLOC, TAILLE_BLOC, TAILLE_BLOC);
                            context.strokeStyle = 'black';
                            context.strokeRect((currentPieceColumn + col) * TAILLE_BLOC, (currentPieceRow + row) * TAILLE_BLOC, TAILLE_BLOC, TAILLE_BLOC);
                        }
                    }
                }
            }


            function getRandomPiece() {
                if (randomIndexActuelle == -1) {
                    randomIndexFutur = Math.floor(Math.random() * pieces.length);
                }
                randomIndexActuelle = randomIndexFutur;
                randomIndexFutur = Math.floor(Math.random() * pieces.length);
                drawNextPiece(pieces[randomIndexFutur]);
                return pieces[randomIndexActuelle];

            }


            function moveDown() {
                currentPieceRow++;
                if (checkCollision()) {
                    currentPieceRow--;
                    mergePiece();
                    clearLines();
                    spawnNewPiece();
                    if (checkCollision()) {
                        // Game over
                        alert("Game Over!");
                        partagerScore();
                    }
                }
                draw();
            }


            function moveLeft() {
                currentPieceColumn--;
                if (checkCollision()) {
                    currentPieceColumn++;
                }
                draw();
            }


            function moveRight() {
                currentPieceColumn++;
                if (checkCollision()) {
                    currentPieceColumn--;
                }
                draw();
            }


            function rotate() {
                if (pieceActuelle && pieceActuelle.shape) {
                    const rotatedPiece = rotateMatrix(pieceActuelle);
                    if (!checkCollision(rotatedPiece)) {
                        pieceActuelle = rotatedPiece;
                    }
                }
                draw();
            }






            function checkCollision(piece = pieceActuelle) {
                for (let row = 0; row < piece.shape.length; row++) {
                    for (let col = 0; col < piece.shape[row].length; col++) {
                        if (
                            piece.shape[row][col] &&
                            (currentPieceColumn + col < 0 ||
                                currentPieceColumn + col >= COLONNES ||
                                currentPieceRow + row >= LIGNES ||
                                tableau[currentPieceRow + row][currentPieceColumn + col])
                        ) {
                            return true;
                        }
                    }
                }
                return false;
            }


            function mergePiece() {
                for (let row = 0; row < pieceActuelle.shape.length; row++) {
                    for (let col = 0; col < pieceActuelle.shape[row].length; col++) {
                        if (pieceActuelle.shape[row][col]) {
                            tableau[currentPieceRow + row][currentPieceColumn + col] = pieceActuelle.color;
                        }
                    }
                }
            }




            function clearLines() {
                let linesToClear = [];

                // Vérifier quelles lignes doivent être effacées
                for (let row = LIGNES - 1; row >= 0; row--) {
                    if (tableau[row].every(cell => cell !== null && cell !== 0)) {
                        linesToClear.push(row);
                        scoreInt += 20;
                        score.textContent = scoreInt;
                        if (scoreInt >= 400) {
                            score.textContent = 404;
                            alert("Felicitation, vous avez perdus votre temps !");
                            setTimeout(partagerScore, 2000);
                        }
                    }
                }


                // Supprimer les lignes complètes du tableau
                tableau = tableau.filter((_, index) => !linesToClear.includes(index));


                // Ajouter de nouvelles lignes vides au début
                for (let i = 0; i < linesToClear.length; i++) {
                    tableau.unshift(Array(COLONNES).fill(null));
                }
            }




            function spawnNewPiece() {
                pieceActuelle = getRandomPiece();
                currentPieceRow = 0;
                currentPieceColumn = Math.floor(COLONNES / 2) - Math.floor(pieceActuelle.shape[0].length / 2);
            }


            function rotateMatrix(piece) {
                const rows = piece.shape.length;
                const cols = piece.shape[0].length;
                const rotated = Array.from({ length: cols }, () => Array(rows));


                for (let row = 0; row < rows; row++) {
                    for (let col = 0; col < cols; col++) {
                        rotated[col][rows - 1 - row] = piece.shape[row][col];
                    }
                }


                return { shape: rotated, color: piece.color };
            }




            function resetGame() {
                for (let row = 0; row < LIGNES; row++) {
                    for (let col = 0; col < COLONNES; col++) {
                        tableau[row][col] = 0;
                    }
                }
                scoreInt = 0;
                score.textContent = 0;
                spawnNewPiece();
                draw();
            }


            document.addEventListener('keydown', function (event) {
                switch (event.key) {
                    case 'ArrowUp':
                        rotate();
                        break;
                    case 'ArrowDown':
                        moveDown();
                        break;
                    case 'ArrowLeft':
                        moveLeft();
                        break;
                    case 'ArrowRight':
                        moveRight();
                        break;
                }
            });


            setInterval(moveDown, 1000);
            function partagerScore(){
                window.location.href = "score.php?score=" + encodeURIComponent(scoreInt)
            }

            // Initial setup
            resetGame();
        </script>


    </div>
</body>


</html>