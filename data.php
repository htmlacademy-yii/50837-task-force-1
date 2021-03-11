<?php

class FormatData {
    private $path;
    private $catigories;
    private $count = 0;

    public function __construct(string $path, string $catigories)
    {
        $this->path = $path;
        $this->catigories = $catigories;
    }

    public function getPath() {
        return $this->path;
    }

    public function getCatigories() {
        return $this->catigories;
    }

    private function formatData($path) :array {
        $file = new SplFileObject($path);
        $valuesArray = [];

        while (!$file->eof()) {

            $sql = "(";
            $var = $file->fgetcsv();

            for($i = 0; $i < count($var); $i++) {
                //if (stripos($var[$i], ' ')) {
                    $var[$i] = sprintf('"%s"', trim($var[$i]), '\'" ');
                //}
            }

            if ($this->count === 0) {
                array_unshift($var, 'id');
            } elseif ($this->count === 1) {
                array_unshift($var, 1);
            } else {
                array_unshift($var, 'NULL');
            }

            $this->count++;

            $sql .= implode(", ", $var);
            $sql .= ")";
            $valuesArray[] = $sql;
        }
        return $valuesArray;
    }

    public function getArrayData(string $path) {
        return $this->formatData($path);
    }

    public function getFormattedData(array $arrayData, string
    $dataCatigories) :void {
        $titleTables = explode(', ', trim(array_shift($arrayData), ')('));

        for($i = 0; $i < count($titleTables); $i++) {
            $titleTables[$i] = sprintf('`%s`', trim($titleTables[$i], '"'));
        }
        array_pop($arrayData);

        $sql = "INSERT INTO $dataCatigories (" . implode(", ", $titleTables) .") VALUES \n";
        $sql .= implode(",\n", $arrayData) . ";\n";

        file_put_contents("queries.sql", $sql, FILE_APPEND);
    }
}

$dataCategories = new FormatData('./data/categories.csv', 'categories');
$dataCategories->getFormattedData($dataCategories->getArrayData($dataCategories->getPath()), $dataCategories->getCatigories());

$dataCities = new FormatData('./data/cities.csv', 'cities');
$dataCities->getFormattedData($dataCities->getArrayData($dataCities->getPath()), $dataCities->getCatigories());

$dataOpinions = new FormatData('./data/opinions.csv', 'opinions');
$dataOpinions->getFormattedData($dataOpinions->getArrayData($dataOpinions->getPath()), $dataOpinions->getCatigories());

$dataProfiles = new FormatData('./data/profiles.csv', 'profiles');
$dataProfiles->getFormattedData($dataProfiles->getArrayData($dataProfiles->getPath()), $dataProfiles->getCatigories());

$dataReplies = new FormatData('./data/replies.csv', 'replies');
$dataReplies->getFormattedData($dataReplies->getArrayData($dataReplies->getPath()), $dataReplies->getCatigories());

$dataTasks = new FormatData('./data/tasks.csv', 'tasks');
$dataTasks->getFormattedData($dataTasks->getArrayData($dataTasks->getPath()), $dataTasks->getCatigories());

$dataUsers = new FormatData('./data/users.csv', 'users');
$dataUsers->getFormattedData($dataUsers->getArrayData($dataUsers->getPath()), $dataUsers->getCatigories());
