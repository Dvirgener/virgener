<?php

declare(strict_types=1);

use Framework\Http;

function dd($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";

    die();
}

function pd($value)
{
    echo "<pre>";
    print_r($value);
    echo "</pre>";
}

function e(mixed $value): string
{
    return htmlspecialchars((string) $value);
}

function redirectTo(string $path)
{
    header("Location: {$path}");
    http_response_code(Http::REDIRECT_STATUS_CODE);
    exit;
}


function formErrorMessaage(array $array, string $field)
{

    if (array_key_exists($field, $array)) {
?>
        <div class="row ms-2 mt-1" style="color:red; font-size:14px">
            <?php echo e($array[$field][0]); ?>
        </div>
<?php
    }
}


function validInvalidForm(?array $errorMsg = [], ?array $oldForm = [], string $field)
{
    if (empty($errorMsg)) {
        $formValid = 'cawdcw';
        return $formValid;
    }

    if (isset($errorMsg['firstName'])) {
        if ($field === "firstName" && empty($oldForm[$field])) {
            $formValid = "is-invalid";
            return $formValid;
        }
    }

    if (isset($errorMsg['lastName'])) {
        if ($field === "lastName" && empty($oldForm[$field])) {
            $formValid = "is-invalid";
            return $formValid;
        }
    }

    if (isset($errorMsg['serialNumber'])) {
        if ($field === "serialNumber" && empty($oldForm[$field])) {
            $formValid = "is-invalid";
            return $formValid;
        }
    }

    if (isset($errorMsg['email'])) {
        if ($field === "email") {
            $formValid = "is-invalid";
            return $formValid;
        }
    }

    if (isset($errorMsg['password']) || isset($errorMsg['confirmPassword'])) {
        if ($field === "password" || $field === "confirmPassword") {
            $formValid = "is-invalid";
            return $formValid;
        }
    }

    if (isset($errorMsg['rank'])) {
        if ($field === "rank") {
            $formValid = "is-invalid";
            return $formValid;
        }
    }

    if (isset($errorMsg['position'])) {
        if ($field === "position") {
            $formValid = "is-invalid";
            return $formValid;
        }
    }


    $formValid = "is-valid";
    return $formValid;
}

function bgColor($saa, $obr, $dv, $aar)
{
    $backgroundColor = "";
    if ($saa != 0) {
        $backgroundColor = "red";
    }
    if ($obr != 0) {
        $backgroundColor = "orange";
    }
    if ($dv != 0) {
        $backgroundColor = "yellow";
    }
    if ($aar != 0) {
        $backgroundColor = "green";
    }
    return $backgroundColor;
}

function fileUpload($fileData)
{
}
