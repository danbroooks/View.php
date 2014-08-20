<?php

class ClassGraph {

	private $paths;
	private $classes;
	private $children;
	private $descendants;

	public function __construct() {

		$this->paths = array();
		$this->classes = array();
		foreach($this->find_all_classes() as $class => $path) {
			$this->classes[] = $class;
			$this->paths[$class] = $path;
		}

		$this->children = array();
		foreach($this->classes as $class) {
			$this->find_child_classes($class);
		}

		$this->descendants = array();
		foreach($this->classes as $class) {
			$this->build_descendant_map($class);
		}
	}

	public function getClassList() {
		return $this->classes;
	}

	public function getDescendantsOf($class) {
		if (is_object($class)) {
			$class = get_class($class);
		}

		if (array_key_exists($class, $this->descendants)) {
			return $this->descendants[$class];
		} else {
			return array();
		}
	}

	private function get_class_tokens($class) {
		return token_get_all(file_get_contents($this->paths[$class]));
	}

	private function find_all_classes() {
		$classes = array();

		foreach(Glob::find('*.class.php')->get() as $classfile) {
			$classes = array_merge(
				$classes,
				$this->find_php_classes_in_file($classfile)
			);
		};

		return $classes;
	}

	private function find_php_classes($str) {
		$classes = array();
		$tokens = token_get_all($str);
		$count = count($tokens);
		for ($i = 2; $i < $count; $i++) {
			if (   $tokens[$i - 2][0] == T_CLASS
				&& $tokens[$i - 1][0] == T_WHITESPACE
				&& $tokens[$i][0] == T_STRING) {

				$class_name = $tokens[$i][1];
				$classes[] = $class_name;
			}
		}
		return $classes;
	}

	private function find_php_classes_in_file($filepath) {
		$php_code = file_get_contents($filepath);
		$graph = array();
		foreach ($this->find_php_classes($php_code) as $foundClass) {
			$graph[$foundClass] = $filepath;
		}
		return $graph;
	}

	private function find_child_classes($class) {
		$children = array();
		$tokens = $this->get_class_tokens($class);
		$ntokens = count($tokens);
		for ($i = 6; $i < $ntokens; $i++) {
			if (
			       $tokens[$i - 6][0] == T_CLASS
				&& $tokens[$i - 5][0] == T_WHITESPACE
				&& $tokens[$i - 4][1] == $class
				&& $tokens[$i - 3][0] == T_WHITESPACE
				&& $tokens[$i - 2][0] == T_EXTENDS
				&& $tokens[$i - 1][0] == T_WHITESPACE
				&& $tokens[$i][0] == T_STRING 
			){
				$this->children[$tokens[$i][1]][] = $class;
			}
		}
	}

	private function build_descendant_map($class) {
		if (array_key_exists($class, $this->children)) {
			$this->descendants[$class] = array();

			foreach ($this->children[$class] as $child) {
				$this->descendants[$class] = array_merge(
					$this->descendants[$class],
					array($child),
					$this->build_descendant_map($child)
				);
			}

			return $this->descendants[$class];
		} else {
			return array();
		}
	}

}