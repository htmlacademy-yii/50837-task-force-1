<?php

namespace TaskForce\Libs;

use \Exception;
use \SplFileObject;
use \LogicException;
use \RuntimeException;
use TaskForce\Exceptions\Libs\SqlQueryFileCreatorException;

class SqlQueryFileCreator {
	
	/** @var string */
	protected $directoryForSave;
	
	/** @var string */
	protected $tableName;
	
	/** @var array */
	protected $columns;
	
	/** @var array */
	protected $tableData;
	
	/**
	 * SqlQueryFileCreator constructor.
	 *
	 * @param string $directoryForSave
	 */
	public function __construct(string $directoryForSave) {
		$this->directoryForSave = $directoryForSave;
	}
	
	/**
	 * @param string $tableName
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 */
	public function setTableName(string $tableName): void {
		$this->tableName = $tableName;
	}
	
	/**
	 * @param array $columns
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 */
	public function setTableColumns(array $columns): void {
		$this->columns = array_filter($columns);
	}
	
	/**
	 * @param array $data
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 */
	public function setTableData(array $data):void {
		$this->tableData = $data;
	}
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 * @throws Exception
	 * @throws LogicException
	 * @throws RuntimeException
	 * @throws SqlQueryFileCreatorException
	 */
	public function createDumpFile(): void {
		if (! is_dir($this->directoryForSave)) {
			mkdir($this->directoryForSave);
		}
		
		$fileName = $this->directoryForSave . "/{$this->tableName}.sql";
		
		$this->checkSetting();
		
		$output = "INSERT INTO {$this->tableName}" . $this->getImplodeTableColumns() . ' VALUES ' . $this->getValues();
		
		try {
			$file = fopen($fileName, 'w');
			
			$fileObject = new SplFileObject($fileName, 'w');
			
			if ($fileObject->fwrite($output) === false) {
				throw new Exception('Can create sql file');
			}
		} finally {
			fclose($file);
		}
	}
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 * @throws SqlQueryFileCreatorException
	 */
	protected function checkSetting() {
		if (empty($this->tableName)) {
			throw new SqlQueryFileCreatorException('Table name is empty');
		}
		
		if (empty($this->columns)) {
			throw new SqlQueryFileCreatorException('Columns are empty');
		}
		
		if (empty($this->tableData)) {
			throw new SqlQueryFileCreatorException('Table data is empty');
		}
	}
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 * @return string
	 */
	protected function getImplodeTableColumns(): string {
		return '(`' . implode('`, `', $this->columns) . '`)';
	}
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 *
	 * @return string
	 */
	protected function getValues(): string {
		return '(' . implode('), (', $this->getConvertedDataToStringsArray()) . ')';
	}
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 * @return array
	 */
	protected function getConvertedDataToStringsArray(): array {
		$valuesAsStingsArray = [];
		
		foreach ($this->tableData as $values) {
			$handledValues = [];
			
			foreach ($values as $value) {
				if (is_numeric($value)) {
					$handledValues[] = is_int($value) ? (int) $value : (float) $value;
				} else if (is_string($value)) {
					$handledValues[] = "'$value'";
				}
			}
			
			$valuesAsStingsArray[] = implode(',', $handledValues);
		}
		
		return $valuesAsStingsArray;
	}
}
