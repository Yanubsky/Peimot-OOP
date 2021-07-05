<?php 

function console_log( $info ){
    echo '<script>';
    echo 'console.log('. json_encode( $info ) .')';
    echo '</script>';
};

function preArr ($arr){
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
};

function reArrayFiles($arr, $count) {
    $reArray= [];
    $filesKeys = array_keys($arr); // returns the keys of an assoc array

    for ($i=0; $i<$count; $i++) {
        foreach ($filesKeys as $key) {
            $reArray[$i][$key] = $arr[$key][$i];
        };
    };
    return $reArray;
};

?>

