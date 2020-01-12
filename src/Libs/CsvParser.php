<?php

namespace TaskForce\Libs;

use \SplFileObject;
use TaskForce\Exceptions\Libs\CsvParserException;
use \LogicException;
use \RuntimeException;

class CsvParser {
	
	/** @var string */
	protected $fileName;
	
	/** @var array */
	protected $headers;
	
	/** @var array */
	protected $data;
	
	/**
	 * CsvParser constructor.
	 *
	 * @param string $fileName
	 */
	public function __construct(string $fileName) {
		$this->fileName = $fileName;
	}
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 *
	 * @throws CsvParserException
	 * @throws LogicException
	 * @throws RuntimeException
	 */
	public function parseFile():void {
		$file = new SplFileObject($this->fileName);
		
		if (! $file->isFile()) {
			throw new CsvParserException('File is not found');
		}
		
		if (! $file->isReadable()) {
			throw new CsvParserException('File is not readable');
		}
		
		$file->setCsvControl(',');
		$file->setFlags(SplFileObject::READ_CSV);
		
		$file->rewind();
		$this->headers = $file->fgetcsv();
		
		while (! $file->eof()) {
			$line = $file->fgetcsv();
			
			if (isset($line[0])) {
				$this->data[] = $line;
			}
		}
	}
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 * @return array
	 */
	public function getHeaders() {
		return $this->headers;
	}
	
	/**
	 * @author Shershnev Sergey <shv.sergey70@gmail.com>
	 * @return array
	 */
	public function getData() {
		return $this->data;
	}
}
