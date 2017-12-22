<?php
	namespace DaybreakStudios\CodeGenerator;

	/**
	 * Interface ClassAwareFluentGeneratorInterface
	 *
	 * @package DaybreakStudios\CodeGenerator
	 * @internal
	 */
	interface ClassAwareFluentGeneratorInterface extends ClassParentAwareInterface, FluentGeneratorInterface {
		/**
		 * @return ClassGeneratorInterface
		 */
		public function done();
	}