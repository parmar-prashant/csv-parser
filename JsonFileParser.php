<?php

    /*
    * Author:    Prashant Parmar
    * Created:   10/01/2024
    * Updated:   10/01/2024
    */

    class JsonFileParser extends Parser {
        public function __construct($file) {
            parent::__construct($file);
        }

        /*
        * Handles the parser functionality and acts as the starting point.
        */
        public function parse() : void {
            $fileExtension = pathinfo($this->file, PATHINFO_EXTENSION);

            // Logic to parse the JSON file and write output to CSV file.

            echo 'JSON file parser!';
        }
    }
?>