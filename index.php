<?php
    session_start();

    // Default value
    $_SESSION['alertView'] = "d-none";
    if (!isset($_SESSION['alertMsg'])) $_SESSION['alertMsg'] = "";
    if (!isset($_SESSION['searchResult'])) $_SESSION['searchResult'] = "";
    if (!isset($_SESSION['searchArgument'])) $_SESSION['searchArgument'] = "";
    if (!isset($_SESSION['searchView'])) $_SESSION['searchView'] = "d-none";
    // Default page value
    if (isset($_GET['page'])) $page = $_GET['page'];
    if (!isset($page)) $page = "upload";    

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
    <link rel="stylesheet" href="/3Docs/css/style.css">
    <script src="https://kit.fontawesome.com/3aaf8783cf.js" crossorigin="anonymous"></script>
</head>
<body class="bg-light">
    
    <?php include 'includes/nav.html' ?>

    <div class="container text-center mt-5 col-lg-4">
        <h1 class="display-4 text-color-main mt-2">3Docs</h1>
        <p class="text-muted">3D models hosting and integration in your website.</p>
    </div>

    <div class="container mt-5 shadow-sm border bg-white col-lg-4 rounded-xl">
        <div class="m-3">
            <p class="text-center h5">How that work ?</p>
            <ul>
                <li>Prepare your 3D model in .glb / .gltf format.
                    <button type="button" id="formatBtn" class="btn btn-sm border-0 btn-secondary bg-main" data-toggle="popover" title="" data-content="GLB/GLTF is more optimized for the web than .fbx or .obj. It is more compact, so your pages load faster.">Why this format ?</button>
                </li>
                <li>Upload your models.</li>
                <li>Keep the generated code to create an integration link in the <a class='custom-link' href='/page=view'>View</a> page.</li>
            </ul>
        </div>
    </div>

    <?php if ($page) include "pages/$page.html"; ?>

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

        // Update iframe on search
        function updateUrl() {
            var searchId = document.getElementById("searchId").value;
            var outputUrl = "<iframe src='http://localhost/3Docs/viewer.html?load=" + searchId + "'></iframe>";
            document.getElementById("outputUrl").value = outputUrl;
            document.getElementById("previewFrame").src = "http://localhost/3Docs/viewer.html?load=" + searchId;
        }

        // Copy to clipboard
        function copy(id) {
            var copyText = document.getElementById(id);
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
        }
        // // Paste to input
        document.getElementById('pasteBtn').addEventListener('click', ()=>{
            let pasteZone = document.getElementById('searchId');
            pasteZone.value = '';

            navigator.clipboard.readText()
            .then((text)=>{
                pasteZone.value = text;
            });
        });
    </script>
</body>
</html>