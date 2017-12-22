<?php
	namespace DaybreakStudios\CodeGenerator\Member;

	use DaybreakStudios\CodeGenerator\FluentGeneratorInterface;

	/**
	 * Interface MemberAwareFluentGeneratorInterface
	 *
	 * @package DaybreakStudios\CodeGenerator\Member
	 * @internal
	 */
	interface MemberAwareFluentGeneratorInterface extends FluentGeneratorInterface , MemberParentAwareInterface {
		/**
		 * @return MemberGeneratorInterface
		 */
		public function done();
	}