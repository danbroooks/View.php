<?php

class View {

	private $template;
	private $path;
	private $renderedTemplate;
	private $variables;
	private static $silent = true;

	public function __construct($template = null) {
		$this->template = $template;
	}

	public function render($variables = array()) {
		$this->variables = $variables;
		
		if ($this->template) {
			$this->path = $this->findTemplate();

			if ($this->path) {

				return $this->loadTemplateFile()
					->evaluateConditions()
					->evaluateControls()
					->injectVariables()
					->loadIncludes()
					->getRenderedTemplate();
			}

		} else if (!self::$silent){
			dd("You didn't pick a template");
		}
	}

	public function getRenderedTemplate() {
		return $this->renderedTemplate;
	}

	private function loadTemplateFile() {
		$this->renderedTemplate = file_get_contents($this->path);
		return $this;
	}

	private function injectVariables() {
		foreach($this->variables as $var => $val) {
			$this->renderedTemplate = str_replace('$'.$var, $val, $this->renderedTemplate);
		}
		return $this;
	}

	private function evaluateConditions() {
		$overflow = 0;
		while(preg_match('/<% if \$([a-zA-Z0-9_]+) %>/i', $this->renderedTemplate, $cond)) {
			$match = $cond[0];
			$condition = $cond[1];

			// TODO

			$overflow++;
			if ($overflow > 2000) break;
		};

		return $this;
	}

	private function evaluateControls() {
		$overflow = 0;
		while(preg_match('/<% loop \$([a-zA-Z0-9_]+) %>/i', $this->renderedTemplate, $control)) {
			$match = $control[0];
			$iterator = $control[1];

			// TODO

			$overflow++;
			if ($overflow > 2000) break;
		};

		return $this;
	}

	private function loadIncludes() {
		$overflow = 0;
		while(preg_match('/<% include ([a-zA-Z0-9_]+) %>/i', $this->renderedTemplate, $includes)) {
			$match = $includes[0];
			$template = $includes[1];
			$include = '';

			if ($this->findTemplate($template)) {
				$view = new View($template);
				$include = $view->render($this->variables);
			} else if (!self::$silent){
				dd('Could not find template '. $template);
			}

			$this->renderedTemplate = str_replace($match, $include, $this->renderedTemplate);

			$overflow++;
			if ($overflow > 2000) break;
		};

		return $this;
	}

	private function findTemplate($template = null){
		$template = $template ? $template : $this->template;
		$find = $this->glob($template.'.template.html');
		return count($find) ? $find[0] : false;
	}

	private function glob($glob) {
		$files = glob($glob); 
		foreach (glob(dirname($glob).'/*') as $dir) {
			$files = array_merge($files, $this->glob($dir.'/'.basename($glob)));
		}
		return $files;
	}
}

