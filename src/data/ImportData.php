<?php

use function PHPSTORM_META\type;

class ImportData {
    static $count = 0;
    static function formatData(string $path, array $args = []):array {
        $file = new SplFileObject($path);
        $valuesArray = [];

        while (!$file->eof()) {

            $sql = "(";
            $var = $file->fgetcsv();
            if (!self::$count && count($args)) {
                $var[] = implode(', ', $args);
                self::$count++;
            }
            else {
                for ($i = 0; $i < count($args); $i++) {
                    $var[] = random_int(1, 10);
                }
            }

            for($i = 0; $i < count($var); $i++) {
                $var[$i] = sprintf('"%s"', trim($var[$i]), '\'" ');
            }

            $sql .= implode(", ", $var);
            $sql .= ")";
            $valuesArray[] = $sql;
        }
        self::$count = 0;
        return $valuesArray;


    }

    // static function addAdditionalParameter($values, array $args) {
    //     type($values)
    //     // for($i = 0; $i < count($values); $i++) {
    //     //     if ($i == 0) {
    //             //echo $arrayData[$i];
    //             $values .= $args[0];
    //         //}
    //     //}
    //     //return $arrayData;
    // }

    static function getFormattedData(array $arrayData, string
    $dataCatigories) :void {
        $titleTables = explode(', ', trim(array_shift($arrayData), ')('));

        for($i = 0; $i < count($titleTables); $i++) {
            $titleTables[$i] = sprintf('`%s`', trim($titleTables[$i], '"'));
        }
        array_pop($arrayData);

        $sql = "INSERT INTO $dataCatigories (" . implode(", ", $titleTables) .") VALUES \n";
        $sql .= implode(",\n", $arrayData) . ";\n";

        file_put_contents("../../queries.sql", $sql, FILE_APPEND);
    }
}
