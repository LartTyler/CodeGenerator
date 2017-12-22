<?php
	namespace DaybreakStudios\CodeGenerator\Member\Property;

	use DaybreakStudios\CodeGenerator\ClassAwareFluentGeneratorInterface;
	use DaybreakStudios\CodeGenerator\FluentGeneratorInterface;

	/**
	 * Interface PropertyAwareFluentGeneratorInterface
	 *
	 * @package DaybreakStudios\CodeGenerator\Member\Property
	 * @internal
	 */
	interface PropertyAwareFluentGeneratorInterface extends FluentGeneratorInterface, PropertyParentAwareInterface {
		/**
		 * @return PropertyGeneratorInterface|ClassAwareFluentGeneratorInterface
		 */
		public function done();
	}