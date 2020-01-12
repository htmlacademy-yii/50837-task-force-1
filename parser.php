<?php

use TaskForce\Libs\CsvParser;
use TaskForce\Exceptions\Libs\CsvParserException;
use TaskForce\Libs\SqlQueryFileCreator;

require_once 'vendor/autoload.php';

const DUMP_DIR_PATH = __DIR__ . '/sql-dump';

$csvDataFilesDirectory = __DIR__ . '/data';

if (! is_dir($csvDataFilesDirectory)) {
	throw new LogicException('No directory in path: ' . $csvDataFilesDirectory);
}

$filesInDirectory = scandir($csvDataFilesDirectory);

if (empty($filesInDirectory)) {
	throw new LogicException('No available files in directory: ' . $filesInDirectory);
}

$tablesNames = [];

foreach ($filesInDirectory as $file) {
	preg_match('/^(.+?)\.csv$/', $file, $matches);
	
	if (isset($matches[1])) {
		$tablesNames[] = $matches[1];
	}
}

foreach ($tablesNames as $tableName) {
	$parser = new CsvParser($csvDataFilesDirectory . "/{$tableName}.csv");
	
	try {
		$parser->parseFile();
	} catch (CsvParserException $e) {
		echo $e->getMessage();
	} catch (Exception $e) {
		echo 'Unknown error. Message:' . $e->getMessage();
	}
	
	$sqlFileCreator = new SqlQueryFileCreator(DUMP_DIR_PATH);
	$sqlFileCreator->setTableName($tableName);
	$sqlFileCreator->setTableColumns($parser->getHeaders());
	$sqlFileCreator->setTableData($parser->getData());
	
	$sqlFileCreator->createDumpFile();
}
