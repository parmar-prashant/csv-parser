<?php

    /*
    * Author:    Prashant Parmar
    * Created:   10/01/2024
    * Updated:   10/01/2024
    */

    /*
    * Abstract class to define the template for the parser and for different file formats in future.
    */
    abstract class Parser {
        protected $readFileHandle = null;
        protected $writeFileHandle = null;
        protected $file = null;
        protected $writeBuffer = [];

        public function __construct($file) {
            $this->file = $file;
            $this->readFileHandle = fopen($this->file, "r");
            $this->writeFileHandle = fopen('assets/' . COMBINATION_FILE_NAME, "w");
        }

        /*
        * Constant variable to validate allowed extensions as input source. New formats can be added in future.
        */
        public const ALLOWED_EXTENSIONS = [
            'csv' => 'csv',
            'tsv' => 'tsv',
            'json' => 'json',
            'xml' => 'xml'
        ];

        /*
        * Constant variable to hold the heading values making it easier to add/remove. It also has required boolean value for each heading.
        */
        protected const HEADINGS = [
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
        protected const COUNT_FILE_HEADINGS = [
            'make','model','colour','capacity','network','grade','condition','count'
        ];

        /*
        * Checks whether all the required headings are present or not.
        */
        protected function verifyMandatoryHeadings(array $fileHeadings) : bool {
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
        protected function reArrangeData(array $data) : array {
            return [
                trim($data[0]), trim($data[1]), trim($data[5]), 
                trim($data[4]), trim($data[6]), trim($data[3]),
                trim($data[2])
            ];
        }

        /*
        * Write the buffer holder to combination count CSV file.
        */
        protected function generateOutputCSVFile() : void {
            foreach($this->writeBuffer as $record => $count) {
                $record = explode(',', $record);
                array_push($record, $count);
                fputcsv($this->writeFileHandle, $record);
            }
        }

        /*
        * Formats the product information in mentioned object representation and saves it in a text file.
        */
        protected function productObjectRepresentation(array $data) : void {
            echo "- make: " . $data[0] . " (string, required) - Brand name" . "\n";
            echo "- model: " . $data[1] . " (string, required) - Model name" . "\n";
            echo "- colour: " . $data[2] . " (string) - Colour name" . "\n";
            echo "- capacity: " . $data[3] . " (string) - GB Spec name" . "\n";
            echo "- network: " . $data[4] . " (string) - Network name" . "\n";
            echo "- grade: " . $data[5] . " (string) - Grade Name" . "\n";
            echo "- condition: " . $data[6] . " (string) - Condition Name" . "\n";
            echo "\n ----------------------------------------------------------------- \n";
        }

        /*
        * Abstract parse method to be implemented by the child class such CSV or TSV or JSON or XML parser classes.
        */
        abstract public function parse() : void;
    }
?>