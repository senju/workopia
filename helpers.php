<?php

/**
 * 
 * @param string $path
 * @return  string
 */
function basePath($path = '') {
return __DIR__ . '/' . $path;
}

/**
 * 
 * @param string $name
 * @return void
 */
function loadView($name, $data=[]) {
    $path = basePath("App/views/{$name}.view.php");
    // inspect($name);
    // inspectAndDie($name);
    if(file_exists($path)){
        extract($data);
        require $path;
    }
    else{
        echo "view {$name} not found";
    }
}

/**
 * 
 * @param string $name
 * @return void
 */
function loadPartial($name, $data=[]) {
    $path = basePath("App/views/partials/{$name}.php");

    if(file_exists($path)){
        extract($data);
        require $path;
    }
    else{
        echo "partial view {$name} not found";
    }
}

/**
 * Debug for purpose
 * @param mixed 
 * @return  void
 */
function inspect($val) {
    echo '<pre>';
    var_dump($val);
    echo '</pre>';
}

/**
 * Debug for purpose
 * @param mixed 
 * @return  void
 */
function inspectAndDie($val) {
    echo '<pre>';
    die(var_dump($val));
}

function formatSalary($sal) {
    return '$' . number_format(floatval($sal));
}

function sanitize($dirty) {
    return filter_var(trim($dirty), FILTER_SANITIZE_SPECIAL_CHARS);
}

function redirect($url) {
    header("Location: {$url}");
    exit;
}