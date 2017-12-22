<?php
	namespace DaybreakStudios\CodeGenerator\Member\Method;

	use DaybreakStudios\CodeGenerator\ClassAwareFluentGeneratorInterface;
	use DaybreakStudios\CodeGenerator\FluentGeneratorInterface;

	interface MethodAwareFluentGeneratorInterface extends FluentGeneratorInterface, MethodParentAwareInterface {
		/**
		 * @return MethodGeneratorInterface|ClassAwareFluentGeneratorInterface
		 */
		public function done();
	}