<?php

    /*
    * Author:    Prashant Parmar
    * Created:   14/12/2023
    */

    include_once('parser.php');

    $parser = new Parser($argv[2]);

    try {
        $parser->parse();     
    } catch(Exception $error) {
        print_r($error->getMessage());
    }
?>