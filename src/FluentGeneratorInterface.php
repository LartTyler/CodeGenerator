<?php
	namespace DaybreakStudios\CodeGenerator;

	interface FluentGeneratorInterface extends ParentAwareInterface {
		/**
		 * @return GeneratorInterface
		 */
		public function done();
	}