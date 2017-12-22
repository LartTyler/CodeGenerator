<?php
	namespace DaybreakStudios\CodeGenerator;

	abstract class AbstractGenerator implements GeneratorInterface {
		protected $targetPHPVersion = PHP_VERSION_ID;

		/**
		 * @var string
		 */
		protected $indentation = "\t";

		/**
		 * @var array
		 */
		protected $indentationCache = [];

		/**
		 * {@inheritdoc}
		 */
		public function getTargetPHPVersion() {
			return $this->targetPHPVersion;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setTargetPHPVersion($targetPHPVersion) {
			$this->targetPHPVersion = $targetPHPVersion;

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function getIndentation() {
			return $this->indentation;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setIndentation($indentation) {
			$this->indentation = $indentation;
			$this->indentationCache = [];

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		protected function indent($depth) {
			if ($indentation = @$this->indentationCache[$depth])
				return $indentation;

			return $this->indentationCache[$depth] = str_repeat($this->getIndentation(), $depth);
		}
	}