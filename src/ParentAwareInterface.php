<?php
	namespace DaybreakStudios\CodeGenerator;

	interface ParentAwareInterface {
		/**
		 * @param GeneratorInterface $parent
		 *
		 * @return $this
		 */
		public function setParent(GeneratorInterface $parent);
	}