<!DOCTYPE html>
<html lang="en">
<meta charset="UTF-8">
<title>Page Title</title>
<meta name="viewport" content="width=device-width,initial-scale=1">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.3.1/dist/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<style>
    header{
        background-color: #56bac7;
        text-align : center;
    }
    body{
        background-color: #a6eef7;
    }
    button{
        padding: 5%;
    }
    div{
        margin: 0;
        position: absolute;
        top: 50%;
        left: 50%;
        -ms-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
    }
</style>
<header>
    <h1>Voici ton score ! Partage-le avec tes amis !</h1>
    <?php echo "Ton score : $_GET[score]"; ?>
</header>
<body>

    

    <script>
        function copierDansPressePapiers() {
            var maVariable = "<?php echo "Essaye de battre mon score de "."$_GET[score]"." !"; ?>";

            var tempInput = document.createElement("input");
            tempInput.value = maVariable;
            document.body.appendChild(tempInput);

            tempInput.select();
            document.execCommand("copy");

            document.body.removeChild(tempInput);

            alert("Score copié dans le presse-papiers : " + maVariable);
        }
    </script>
    <div>
    <button onclick="copierDansPressePapiers()">Partage ton score avec tes amis !</button>
    </div>
</body>
</html>

