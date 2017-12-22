<?php
	namespace DaybreakStudios\CodeGenerator;

	interface GeneratorInterface {
		/**
		 * @return int
		 */
		public function getTargetPHPVersion();

		/**
		 * @param int $version
		 *
		 * @return $this
		 */
		public function setTargetPHPVersion($version);

		/**
		 * @return string
		 */
		public function getIndentation();

		/**
		 * @param string $indentation
		 *
		 * @return $this
		 */
		public function setIndentation($indentation);

		/**
		 * @param int $depth
		 *
		 * @return string
		 */
		public function generate($depth = 0);
	}