<?php

    /*
    * Author:    Prashant Parmar
    * Created:   10/01/2024
    * Updated:   10/01/2024
    */

    include_once('constants.php');
    include_once('Parser.php');
    include_once('CsvTsvFileParser.php');
    include_once('JsonFileParser.php');
    include_once('XmlFileParser.php');

    class ParserFactory {
        public function generateObject($file) {

            // Check file exists or not.
            if(!file_exists($file)) {
                throw new Exception(FILE_NOT_FOUND_ERR);
            }

            $fileExtension = pathinfo($file, PATHINFO_EXTENSION);

            // Check for the mandatory headings.
            if(!in_array($fileExtension, Parser::ALLOWED_EXTENSIONS)) {
                throw new Exception(UNSUPPORTED_FILE_TYPE_ERR);
            }

            // Based on the file type, generate and return the file parser object.
            switch($fileExtension) {
                case 'csv':
                case 'tsv':
                    return new CsvTsvFileParser($file);
                    break;
                case 'json':
                    return new JsonFileParser($file);
                    break;
                case 'xml':
                    return new XmlFileParser($file);
                    break;
            }
        }
    }

?>