<?php

    /*
    * Author:    Prashant Parmar
    * Created:   10/01/2024
    * Updated:   10/01/2024
    */

    class XmlFileParser extends Parser {
        public function __construct($file) {
            parent::__construct($file);
        }

        /*
        * Handles the parser functionality and acts as the starting point.
        */
        public function parse() : void {

            // Logic to parse the XML file and write output to CSV file.

            echo 'XML file parser!';
        }
    }
?>