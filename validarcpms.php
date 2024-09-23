<?php
session_start();
if (!isset($_SESSION['active'])) {
    header('location: index.php');
}
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://kit.fontawesome.com/47b4aaa3bf.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="resources/js/jquery-ui-1.13.1/jquery-ui.min.css">
    <link rel="stylesheet" href="resources/css/styles.css">
    <link rel="icon" type="image/png" href="resources/img/calendarioPrecios.png" />
    <title>Validar CPMS | Dirsapol</title>
</head>

<body>
    <div class="preloader">
        <div class="cont-img">
            <img src="resources/img/_EscudoSanidad.png" alt="Escudo sanidad">
            <img src="resources/img/_EscudoPNP.png" alt="Escudo PNP">
        </div>
        <div class="circle-load"></div>
        <p>Cargando...</p>
    </div>
    <div class="wrapper">
        <header>
            <div class="cont-inputsearch">
                <input type="text" id="ipress-validador" value="<? echo $_SESSION['active']; ?>" readonly>
            </div>
            <div class="cont-info-tarifario">
                <h2>Tarifario Actual: 05-2023</h2>
                <img src="resources/img/_EscudoSanidad.png" alt="">
            </div>
        </header>
        <div class="section">
            <div class="container">
                <form action="" method="post" name="frmExcelImport" id="frmExcelImport" enctype="multipart/form-data">
                    <label for="mi-archivo" id="lbl-miarchivo">Click para seleccionar Archivo Excel</label>
                    <input type="file" name="mi-archivo" id="mi-archivo" accept=".xls,.xlsx" required>
                    <button type="submit" id="submit" name="import" class="button">Validar</button>
                </form>
                <div class="info">
                    <i class="fa-solid fa-circle-info icon-info"></i>
                    <figure><img class="img-info" src="resources/img/pasosvalidar.png" alt=""></figure>
                </div>
                <div class="btn-options">

                    <a id="btn-reset" class="button btn-reset"> Limpiar</a>
                    <a id="btn-export" class="button btn-export"><i class="fa-solid fa-file-excel"></i> Exportar</a>

                </div>

            </div>
            <div class="cont-table">
                <table>
                    <thead>
                        <tr>
                            <th>Código CPMS</th>
                            <th>Descripción CPMS</th>
                            <th class="td-red">Id Atención</th>
                            <th>Responsable</th>
                        </tr>
                    </thead>
                    <tbody id="cont-result">
                    </tbody>
                </table>
            </div>
            <div id="load-validate" class="cont-loading-validate">
                <div class="custom-loader"></div>
                <p>Validando Archivo</p>
            </div>

        </div>
    </div>
</body>
<script>
</script>
<script language="javascript" src="resources/js/jquery-3.6.0.min.js"></script>
<script language="javascript" src="resources/js/jquery-ui-1.13.1/jquery-ui.min.js"></script>
<script language="javascript" src="resources/js/functions.js"></script>

</html>