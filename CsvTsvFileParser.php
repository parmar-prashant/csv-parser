<?php

    /*
    * Author:    Prashant Parmar
    * Created:   10/01/2024
    * Updated:   10/01/2024
    */

    class CsvTsvFileParser extends Parser {
        public function __construct($file) {
            parent::__construct($file);
        }

        /*
        * Handles the parser functionality and acts as the starting point.
        */
        public function parse() : void {
            $fileExtension = pathinfo($this->file, PATHINFO_EXTENSION);
            $readIndex = 0;
            $currentDataStringFormat = '';
            $currentData = [];

            // Based on the file type, use the delimiter.
            $delimiter = ($fileExtension === 'csv') ? "," : "\t";

            while (($currentData = fgetcsv($this->readFileHandle, null, $delimiter)) !== FALSE) {
                if($readIndex++ === 0) {
                    if(!self::verifyMandatoryHeadings($currentData)) {
                        unlink(COMBINATION_FILE_NAME);
                        throw new Exception(MISSING_HEADING_ERR);
                    }
                } else {

                    // Re-arrange data according to the combination count file format.
                    $currentData = self::reArrangeData($currentData);

                    // Display product information in an object form. 
                    self::productObjectRepresentation($currentData);

                    // Convert the array to string to use it as an index to count the records.
                    $currentDataStringFormat = implode(',', $currentData);
                    
                    // Logic to find the key in array. If found, increament the count else initialize it with 1.
                    if(array_key_exists($currentDataStringFormat, $this->writeBuffer)) {
                        $this->writeBuffer[$currentDataStringFormat] += 1;
                    } else {
                        $this->writeBuffer[$currentDataStringFormat] = 1;
                    }
                }
            }

            // Generate the output combination CSV file.
            self::generateOutputCSVFile();
        }
    }
?>