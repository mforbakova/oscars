<?php

use Mforbakova\Mojeoskary2\OskaryClass;
use Mforbakova\Mojeoskary2\LoadOscars;

require 'vendor/autoload.php';
$errorMessage;
if (isset($_FILES["men"]["tmp_name"]) && ($_FILES["women"]["tmp_name"])) {
    try {
        $newOscar = new LoadOscars();
        $newOscar->loadOscars($_FILES['men']['tmp_name'], OskaryClass::GENDER_MAN);
        $newOscar->loadOscars($_FILES['women']['tmp_name'], OskaryClass::GENDER_WOMAN);
    } catch (Exception $e) {
        $errorMessage = $e->getMessage();
        $newOscar = null;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <head>
        <title>Oskary</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
    </head>

<body>
    <div class="shadow p-3 mb-5 bg-body rounded col-sm-7">Vložte súbor s hercami:<br>
        <form action="" method="post" enctype="multipart/form-data">
            <input type="file" name="men" required><br>
            Vložte súbor s herečkami:<br>
            <input type="file" name="women" required>
            <input type="submit" value="Odoslať">
        </form>
    </div>
    <div>
        <?php
        if (isset($errorMessage)) {
            echo $errorMessage;
        }
        ?>
    </div>

    <?php if (isset($newOscar)) : ?>
        <div class="row p-4">
            <div class="col-5">
                <table class="table table-bordered shadow p-3 mb-5 bg-body rounded">
                    <tr>
                        <th>Rok</th>
                        <th>Muži</th>
                        <th>Ženy</th>
                    </tr>
                    <?php
                    foreach ($newOscar->getItemsPerYear() as $year => $item) {
                        echo "<tr>";
                        echo "<td>$year</td>";
                        echo "<td >" . $item[OskaryClass::GENDER_MAN]->getName() . " (" . $item[OskaryClass::GENDER_MAN]->getAge() . ")<br>" . $item[OskaryClass::GENDER_MAN]->getMovie() . "</td>";
                        echo "<td>" . $item[OskaryClass::GENDER_WOMAN]->getName() . " (" . $item[OskaryClass::GENDER_WOMAN]->getAge() . ")<br>" . $item[OskaryClass::GENDER_WOMAN]->getMovie() . "</td>";
                        echo "</tr>";
                    }
                    ?>

                </table>
            </div>
            <div class="col-sm-5">
                <table class="table table-bordered shadow p-3 mb-5 bg-body rounded">
                    <tr>
                        <th>Název filmu</th>
                        <th>Rok</th>
                        <th>Herečka</th>
                        <th>Herec</th>
                    </tr>
                    <tr>
                        <?php
                        foreach ($newOscar->getItemsPerMovie() as $movie => $item) {
                            echo "<td>$movie</td>";
                            if (($item[OskaryClass::GENDER_WOMAN]->getYear()) !== ($item[OskaryClass::GENDER_MAN]->getYear())) {
                                echo "<td>" . $item[OskaryClass::GENDER_WOMAN]->getYear() . "(herečka) <br>" . $item[OskaryClass::GENDER_MAN]->getYear() . "(herec)</td>";
                            } else echo "<td>" . ($item[OskaryClass::GENDER_WOMAN]->getYear()) . "</td>";
                            echo "<td>" . $item[OskaryClass::GENDER_WOMAN]->getMovie() . "</td>";
                            echo "<td>" . $item[OskaryClass::GENDER_MAN]->getMovie() . "</td>";
                            echo "</tr>";
                        }
                        ?>
                    </tr>
                </table>

            </div>
        <?php endif; ?>

</body>