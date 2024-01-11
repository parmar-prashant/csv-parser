<?php

    /*
    * Author:    Prashant Parmar
    * Created:   14/12/2023
    */

    include_once('constants.php');

    Class Parser {
        
        /*
        * Constant variable to validate allowed extensions as input source. New formats can be added in future.
        */
        public const ALLOWED_EXTENSIONS = [
            'csv',
            'tsv'
        ];

        /*
        * Constant variable to hold the heading values making it easier to add/remove. It also has required boolean value for each heading.
        */
        public const HEADINGS = [
            'brand_name' => true,
            'model_name' => true,
            'condition_name' => false,
            'grade_name' => false,
            'gb_spec_name' => false,
            'colour_name' => false,
            'network_name' => false
        ];

        /*
        * Constant variable to hold the heading values making it easier to add/remove. It also has required boolean value for each heading.
        */
        public const COUNT_FILE_HEADINGS = [
            'make','model','colour','capacity','network','grade','condition','count'
        ];

        private $readIndex = 0;
        private $writeIndex = 0;
        private $currentDataStringFormat = '';
        private $writeBuffer = [];

        public function __construct(string $file){
            $this->file = $file;
        }

        /*
        * Handles the parser functionality and acts as the starting point.
        */
        public function parse() {
           
            $fileExtension = pathinfo($this->file, PATHINFO_EXTENSION);

            // Check file exists or not.
            if(!file_exists($this->file)) {
                throw new Exception(FILE_NOT_FOUND_ERR);
            }

            // Check for the mandatory headings.
            if(!in_array($fileExtension, self::ALLOWED_EXTENSIONS)) {
                throw new Exception(UNSUPPORTED_FILE_TYPE_ERR);
            }

            // File handlers to read and write to CSv file.
            $this->readFileHandle = fopen($this->file, "r");
            $this->writeFileHandle = fopen(COMBINATION_FILE_NAME, "w");

            // Put the headings for combination count CSV file
            fputcsv($this->writeFileHandle, self::COUNT_FILE_HEADINGS);

            // Handler to point the flow towards required logic based on the file type.
            switch($fileExtension) {
                case 'csv':
                case 'tsv':
                    self::readFromCSVorTSV($fileExtension);
                    break;
                // Provision to add new logic for JSON files
                case 'json':
                    self::readFromJSON();
                    break;
            }

            fclose($this->readFileHandle);
            fclose($this->writeFileHandle);
        }

        /*
        * Read logic for CSV or TSV files
        */
        private function readFromCSVorTSV(string $fileExtension) {
            // Based on the file type, use the delimiter.
            $delimiter = ($fileExtension === 'csv') ? "," : "\t";

            while (($currentData = fgetcsv($this->readFileHandle, null, $delimiter)) !== FALSE) {                

                // Check if required mandatory heading are present or not.
                if($this->readIndex++ === 0) {
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
                    $this->currentDataStringFormat = implode(',', $currentData);
                    
                    // Logic to find the key in array. If found, increament the count else initialize it with 1.
                    if(array_key_exists($this->currentDataStringFormat, $this->writeBuffer)) {
                        $this->writeBuffer[$this->currentDataStringFormat] += 1;
                    } else {
                        $this->writeBuffer[$this->currentDataStringFormat] = 1;
                    }
                }
            }
            
            // Write the buffer holder to combination count CSV file.
            foreach($this->writeBuffer as $record => $count) {
                $record = explode(',', $record);
                array_push($record, $count);
                fputcsv($this->writeFileHandle, $record);
            }
        }

        /*
        * Checks whether all the required headings are present or not.
        */
        private function verifyMandatoryHeadings(array $fileHeadings) {
            $isValidFile = true;
            foreach(self::HEADINGS as $heading => $isRequired) {
                if($isRequired && !in_array($heading, $fileHeadings)) {
                    $isValidFile = false;
                    break;
                }
            }
            return $isValidFile;
        }

        /*
        * Re-arrange data according to the combination count CSV file format
        */
        private function reArrangeData(array $data) {
            return [
                trim($data[0]), trim($data[1]), trim($data[5]), 
                trim($data[4]), trim($data[6]), trim($data[3]),
                trim($data[2])
            ];
        }

        /*
        * Formats the product information in mentioned object representation and saves it in a text file.
        */
        private function productObjectRepresentation(array $data) {
            echo "- make: " . $data[0] . " (string, required) - Brand name" . "\n";
            echo "- model: " . $data[1] . " (string, required) - Model name" . "\n";
            echo "- colour: " . $data[2] . " (string) - Colour name" . "\n";
            echo "- capacity: " . $data[3] . " (string) - GB Spec name" . "\n";
            echo "- network: " . $data[4] . " (string) - Network name" . "\n";
            echo "- grade: " . $data[5] . " (string) - Grade Name" . "\n";
            echo "- condition: " . $data[6] . " (string) - Condition Name" . "\n";
            echo "\n ----------------------------------------------------------------- \n";
        }
    }
?>