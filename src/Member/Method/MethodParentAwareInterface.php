<?php
	namespace DaybreakStudios\CodeGenerator\Member\Method;

	use DaybreakStudios\CodeGenerator\GeneratorInterface;
	use DaybreakStudios\CodeGenerator\ParentAwareInterface;

	/**
	 * Interface MethodParentAwareInterface
	 *
	 * @package DaybreakStudios\CodeGenerator\Member\Method
	 * @internal
	 */
	interface MethodParentAwareInterface extends ParentAwareInterface {
		/**
		 * @param GeneratorInterface|MethodGeneratorInterface $parent
		 *
		 * @return $this
		 */
		public function setParent(GeneratorInterface $parent);
	}