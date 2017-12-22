<?php
	namespace DaybreakStudios\CodeGenerator\Member;

	use DaybreakStudios\CodeGenerator\GeneratorInterface;
	use DaybreakStudios\CodeGenerator\ParentAwareInterface;

	/**
	 * Interface MemberParentAwareInterface
	 *
	 * @package DaybreakStudios\CodeGenerator\Member
	 * @internal
	 */
	interface MemberParentAwareInterface extends ParentAwareInterface {
		/**
		 * @param GeneratorInterface|MemberGeneratorInterface $parent
		 *
		 * @return $this
		 */
		public function setParent(GeneratorInterface $parent);
	}