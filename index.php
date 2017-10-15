<?php
/**
 * Created by PhpStorm.
 * User: Jean
 * Date: 14/10/2017
 * Time: 18:36
 */

include 'CloudAshes.php';

$result = '';

if (isset($_POST["input"])) {
    $input = $_POST["input"];
    $cloudAshes = new CloudAshes($input);
    $result = $cloudAshes->getResult();
}

?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Nuvem de Cinzas</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css" integrity="sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M" crossorigin="anonymous">
</head>
<body>

<div class="container">

    <form class="form-horizontal" method="post">
        <fieldset>

            <!-- Form Name -->
            <legend>Nuvem de Cinzas</legend>

            <!-- Textarea -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="input">Entrada de Dados</label>
                <div class="col-md-4">
    <textarea class="form-control" id="input" name="input" rows="10" cols="20"><?php if(isset($input)){ echo $input; }
    else { ?>. . * . . . * *
. * * . . . . .
* * * . A . . A
. * . . . . . .
. * . . . . A .
. . . A . . . .
. . . . . . . .<?php } ?></textarea>
                </div>
            </div>

            <!-- Button -->
            <div class="form-group">
                <label class="col-md-4 control-label" for="singlebutton"></label>
                <div class="col-md-4">
                    <button id="singlebutton" name="singlebutton" class="btn btn-primary">Calcular</button>
                </div>
            </div>


            <?php if(!empty ($result)){ ?>
                <div class="alert alert-<?php echo $result['status']; ?>" role="alert">
                    <?php echo $result['msg']; ?>
                </div>
            <?php } ?>

        </fieldset>
    </form>

</div>

<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN"
        crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"
        integrity="sha384-b/U6ypiBEHpOf/4+1nzFpr53nxSS+GLCkfwBdFNTxtclqqenISfwAzpKaMNFNmj4"
        crossorigin="anonymous"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/js/bootstrap.min.js"
        integrity="sha384-h0AbiXch4ZDo7tp9hKZ4TsHbi047NrKGLO3SEJAg45jXxnGIfYzk4Si90RDIqNm1"
        crossorigin="anonymous"></script>

</body>
</html>





