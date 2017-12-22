<?php

	namespace DaybreakStudios\CodeGenerator;

	interface ClassParentAwareInterface extends ParentAwareInterface {
		/**
		 * @param GeneratorInterface|ClassGeneratorInterface $parent
		 *
		 * @return $this
		 */
		public function setParent(GeneratorInterface $parent);
	}