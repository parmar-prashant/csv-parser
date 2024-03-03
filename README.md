# CSV parser

This project is developed using PHP 8.3 with no external libraries.

## Architecture description

For the first submission, only classes were there without any OOPS concepts. With the current version, concepts such as polymorphism, encapsulation and abstraction are implemented using *Abstract Class* over *Interface* for the following reasons:

- To achieve encapsulation and proper data hiding because an interface only provides public method definitions whereas on the other hand, the Abstract class has provision to define variables and methods with protected and private access specifiers as well along with abstract method definitions.
- Interface can only have method definitions whereas an Abstract class can have variables, foundation methods and abstract method definitions for child classes.

## Folder Structure

The project contains three code files as follows:

- *index.php* : This is the starting point of the execution and we will run the project by passing the file name as an argument from the command line (example below).
- *ParserFactory.php* : This class file works as a factory generating parser class objects based on the file extension.
- *CsvTsvFileParser.php* : Class extending *Parser Abstract Class* and containing logic to parse CSV or TSV files.
- *JsonFileParser.php* : Class extending *Parser Abstract Class* and provision to add logic to parse JSON files in future.
- *XmlFileParser.php* : Class extending *Parser Abstract Class* and provision to add logic to parse XML files in future.
- *Parser.php* : Class file containing a template for different file type parser classes along with foundation properties and methods which can be used by child classes.
- *constatns.php* : All the static values e.g. Error messages are defined here for better code management and reusability.
- *parser_old.php* : Contains logic for the first submission.

## How to run the project

You can run the project by passing a CSV or TSV file as an argument as follows:
- `php index.php --filename comma.csv;` Example CSV file provided with the project description
- `php index.php --filename tab.tsv;` Example TSV file provided with the project description
- `php index.php --filename tab_less.tsv;` Tested TSV file with less number of records
- `php index.php --filename comma_less.csv;` Tested CSV file with less number of records
- `php index.php --filename comma_missing_heading.csv;` Tested CSV file with missing mandatory headers
- `php index.php --filename tab_missing_heading.tsv;` Tested TSV file with missing mandatory headers
- `php index.php --filename test.json;` Tested JSON file which will print *JSON file parser!*
- `php index.php --filename test.xml;` Tested XML file which will print *XML file parser!*

## Note

- Please place the input files in the assets folder.
- *--unique-combinations* is not passed as a parameter. But the file name is used from *constants.php* and can be changed as per the requirement.
- While execution, if an exception is generated, the *combination_count.csv* file will be deleted and an exception message will be displayed.
- For Dependency Injection, I could not find a probable use case for the latest implementation as I have covered all the code reusability visa *Parser.php*. If *Parser.php* was not there then I would create a data reader class (Injectable) which will read from any source type (configurable) and inject it in all the classes such as *CsvTsvFileParser.php* or *JsonFileParser.php* or *XmlFileParser.php*.


