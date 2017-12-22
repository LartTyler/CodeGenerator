<?php
	namespace DaybreakStudios\CodeGenerator;

	trait FluentAwareTrait {
		use ParentAwareTrait;

		/**
		 * @return GeneratorInterface
		 */
		public function done() {
			return $this->parent;
		}
	}