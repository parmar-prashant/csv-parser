<?php

    /*
    * Author:    Prashant Parmar
    * Created:   10/12/2023
    * Updated:   11/01/2024
    */

    include_once('ParserFactory.php');

    $factory = new ParserFactory;

    try {
        $parser = $factory->generateObject($argv[2]);
        $parser->parse();     
    } catch(Exception $error) {
        print_r($error->getMessage());
    }
?>