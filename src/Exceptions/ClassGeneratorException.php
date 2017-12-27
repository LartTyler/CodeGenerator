<?php
	namespace DaybreakStudios\CodeGenerator\Exceptions;

	class ClassGeneratorException extends GeneratorException {
		/**
		 * @return static
		 */
		public static function createTooManyExtendsException() {
			return new static('Only interfaces can extend more than one parent.');
		}

		/**
		 * @return static
		 */
		public static function createInterfaceCannotImplementException() {
			return new static('Interfaces cannot implement other interfaces.');
		}

		/**
		 * @return static
		 */
		public static function createInterfaceCannotUseTraits() {
			return new static('Interfaces cannot use traits.');
		}

		/**
		 * @return static
		 */
		public static function createTraitsCannotExtendOrImplementException() {
			return new static('Traits cannot extend or implement another class or interface.');
		}

		/**
		 * @param mixed $type
		 *
		 * @return static
		 */
		public static function createUnrecognizedTypeException($type) {
			return new static(sprintf('The type "%s" does not map to any known types.', $type));
		}
	}