<?php
	namespace DaybreakStudios\CodeGenerator\Member\Property;

	use DaybreakStudios\CodeGenerator\GeneratorInterface;
	use DaybreakStudios\CodeGenerator\ParentAwareInterface;

	/**
	 * Interface PropertyParentAwareInterface
	 *
	 * @package DaybreakStudios\CodeGenerator\Member\Property
	 * @internal
	 */
	interface PropertyParentAwareInterface extends ParentAwareInterface {
		/**
		 * @param GeneratorInterface|PropertyGeneratorInterface $parent
		 *
		 * @return $this
		 */
		public function setParent(GeneratorInterface $parent);
	}