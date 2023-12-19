# The Big Phone Store - Interview Project

This project is developed using PHP 8.3 with no external libraries.

## Folder Structure

The project contains three code files as follows:

- *index.php* : This is the starting point of the execution and we will run the project by passing the file name as an argument from the command line (example below).
- *parser.php* : It contains the main logic of parsing the given CSV file as an input source.
- *constatns.php* : All the static values e.g. Error messages are defined here for better code management and reusability.

## How to run the project

You can run the project by passing a CSV or TSV file as an argument as follows:
- `php index.php --filename comma.csv;` Example CSV file provided with the project description
- `php index.php --filename tab.tsv;` Example TSV file provided with the project description
- `php index.php --filename tab_less.tsv;` Tested TSV file with less number of records
- `php index.php --filename comma_less.csv;` Tested CSV file with less number of records
- `php index.php --filename comma_missing_heading.csv;` Tested CSV file with missing mandatory headers
- `php index.php --filename tab_missing_heading.tsv;` Tested TSV file with missing mandatory headers

## Note

- Please place the input files in the same folder as code files.
- *--unique-combinations* is not passed as a parameter. But the file name is used from *constants.php* and can be changed as per the requirement.
- While execution, if any exception is generated, the *combination_count.csv* file be deleted and an exception message will be displayed.


