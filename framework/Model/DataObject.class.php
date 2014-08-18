<?php

class DataObject implements DataObjectInterface {

	public function toArray() {
		return array();
	}

}

interface DataObjectInterface {

	public function toArray();

}