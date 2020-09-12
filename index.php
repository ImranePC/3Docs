<?php
session_start(); 
// Test change again
// Default value
$_SESSION['alertView'] = "d-none";
if (!isset($_SESSION['alertMsg'])) $_SESSION['alertMsg'] = "";
if (!isset($_SESSION['searchResult'])) $_SESSION['searchResult'] = "";
if (!isset($_SESSION['searchArgument'])) $_SESSION['searchArgument'] = "";
if (!isset($_SESSION['searchView'])) $_SESSION['searchView'] = "d-none";

// Alert Enable
if (isset($_SESSION['msgFlash']) AND $_SESSION['msgFlash'] == true) {
    $_SESSION['alertView'] = "d-block";
    $_SESSION['msgFlash'] = false;
}


?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>3Docs - Accueil</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">
    <script src="https://kit.fontawesome.com/3aaf8783cf.js" crossorigin="anonymous"></script>
</head>
<body class="bg-light">
    
    <div class="container text-center mt-5 col-lg-4">
        <h1 class="display-4 text-color-main mt-2">3Docs</h1>
        <p class="text-muted">Hebergement de modèles 3D et intégrations sur vos sites.</p>
    </div>

    <div class="container mt-5 shadow-sm border bg-white col-lg-4 rounded-xl">
        <div class="m-3">
            <p class="text-center h5">Comment ça marche ?</p>
            <ul>
                <li>Préparez votre modèle 3D exporté au format .glb / .gltf. 
                    <button type="button" class="sbtn btn-sm border-0 btn-secondary bg-main" data-toggle="popover" title="" data-content="Le GLB / GLTF est plus compacte que le .fbx ou le .obj il est donc plus optimisé pour le web.">Pourquoi le gltf ?</button>
                </li>
                <li>Uploadez le modèle via le formulaire ci-dessous, vous recevrez un code unique lié à votre modèle.</li>
                <li>Copiez-collez ce code dans la boxe qui générera une URL pour intégrer le visionneur 3D dans vos sites</li>
            </ul>
        </div>        
    </div>

    <div class="container mt-5">

    </div>

    <div class="container mt-5 shadow-sm border bg-white col-lg-4 rounded-xl">
        <div class="m-3">
            <div class="alert alert-<?=$_SESSION['alertColor']?> <?=$_SESSION['alertView']?>" role="alert">
                <?=$_SESSION['alertMsg']?> 
            </div>    
            <p class="text-center h5">Upload modèle 3D</p>

            <!--Upload form-->
            <form action="serv/insert.php" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label>Votre nom <span class="text-note">- Il vous servira plus tard à retrouver vos modèles</span></label>
                    <input maxlength="24" type="text" class="form-control mb-4" required name="inputName">
                </div>
                <div class="mb-3">
                    <label>Courte description <span class="text-note">- 'Bloc lego','Petit arbre','Scène ville' ...</span></label>
                    <input maxlength="24" type="text" class="form-control mb-4" required name="inputDesc">
                </div>
                <label>Modèle 3D</label>
                <div class="custom-file">
                    <input type="file" class="custom-file-input" id="customFile" required name="inputFile">
                    <label class="custom-file-label" for="customFile">...</label>
                </div>
                
                <div class="text-center"><button type="submit" class="btn btn-main mt-3">Upload</button></div>
            </form>

        </div>
    </div>

    <div class="container mt-5 shadow-sm border bg-white col-lg-4 rounded-xl" id="search">
        <div class="m-3">
            <p class="text-center h5">Recherche modèle 3D</p>
            <form action="serv/search.php" method="post">
                <div class="mb-3">
                    <label>Nom de l'auteur</label>
                    <input maxlength="24" type="text" class="form-control" required name="inputAuthor">
                </div>

                <div class="text-center"><button type="submit" class="btn btn-main">Search</button></div>
            </form>
        </div>

        <div class="<?=$_SESSION['searchView']?>">
            <table class="table table-sm table-striped table-hover">
            <thead>
                <tr class="text-center text-success"><th colspan="4">Search result for '<?=$_SESSION['searchArgument']?>'</th></tr>
                <tr>
                <th scope="col">ID</th>
                <th scope="col">Author</th>
                <th scope="col">Description</th>
                <th scope="col">Date</th>
                </tr>
            </thead>
            <tbody>
                <!--Search content-->
                <?=$_SESSION['searchResult']?>
            </tbody>
            </table>
        </div>
    </div>

    <div class="container mt-5 shadow-sm border bg-main col-lg-3 rounded-top-xl">
        <div class="m-3">
        <form>
            <div class="row">
                <div class="col">
                    <input type="text" class="form-control" placeholder="Put ID here : ID11111" required>
                </div>
                <div class="col">
                    <button type="button" class="btn btn-block btn-outline-light">Générer l'url</button>
                </div>    
            </div>
        </div>
    </div>

    <div class="container p-0 shadow-sm border bg-white col-lg-3 rounded-bottom-xl">
        <div>
            <div class="p-4 border-bottom bg-grey">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck1">
                    <label class="custom-control-label" for="customCheck1">Parameter 0</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck2">
                    <label class="custom-control-label" for="customCheck2">Parameter 1</label>
                </div>
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" class="custom-control-input" id="customCheck3">
                    <label class="custom-control-label" for="customCheck3">Parameter 2</label>
                </div>
            </form>
        </div>
        
            <div class="container-fluid text-center text-color-main pt-3"><i class="fas fa-long-arrow-alt-down fa-4x"></i></div>

            <div class="p-3">
                <input type="text" class="form-control form-control-sm" placeholder="Output url" required value="http://...">
            </div>
        </div>
 
        <div class="embed-responsive embed-responsive-1by1 mb-3">
            <!--<iframe class="embed-responsive-item rounded-xl" src="viewer.html"></iframe>-->
        </div>
    </div>

    <div class="container m-5 p-5"></div>                   
    

    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
    <script>
        // Fileinput name change on upload
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
            $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });

        // Pop-over button
        $(function () {
            $('[data-toggle="popover"]').popover()
        })
        $('[data-toggle="popover"]').popover({
            trigger: 'focus'
        })

    </script>
</body>
</html>