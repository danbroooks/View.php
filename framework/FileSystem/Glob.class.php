<?php 

class Glob {

	private $files;

	public static function find($glob) {
		$inst = new Glob();
		$glob = '../'.$glob;
		return $inst->search($glob);
	}

	public function get() {
		return $this->files;
	}

	public function all() {
		return $this->get();
	}

	public function first() {
		return count($this->files) ? $this->files[0] : null;
	}

	public function search($glob) {
		$this->files = $this->rglob($glob);
		return $this;
	}

	private function rglob($glob) {
		$files = glob($glob); 
		foreach (glob(dirname($glob).'/*') as $dir) {
			$files = array_merge($files, $this->rglob($dir.'/'.basename($glob)));
		}
		return $files;
	}


}