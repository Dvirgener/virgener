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


function formErrorMessaage(array $array,string $field){

if (array_key_exists($field, $array)) {
    ?>
    <div class="row ms-2 mt-1" style="color:red; font-size:14px">
        <?php echo e($array[$field][0]); ?>
    </div>
    <?php
    }
}

function validInvalidForm(?array $errorMsg = [], ?array $oldForm = [],string $field){
    if (empty($errorMsg)){
        $formValid = '';
        return $formValid;
    }

    if (isset($errorMsg['firstName'])){
        if ($field === "firstName" && empty($oldForm[$field])){
            $formValid = "is-invalid";
            return $formValid;
        }
    }

    if (isset($errorMsg['email'])){
        if ($field === "email"){
            $formValid = "is-invalid";
            return $formValid;
        }
    }

    if (isset($errorMsg['password']) || isset($errorMsg['confirmPassword'])){
        if ($field === "password" || $field === "confirmPassword"){
            $formValid = "is-invalid";
            return $formValid;
        }
        else{
            $formValid = '';
            return $formValid;
        }
    }





    $formValid = "is-valid";
    return $formValid;


    
}