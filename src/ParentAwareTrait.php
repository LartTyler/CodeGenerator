<?php
	namespace DaybreakStudios\CodeGenerator;

	trait ParentAwareTrait {
		/**
		 * @var ClassGeneratorInterface|null
		 */
		protected $parent = null;

		/**
		 * @param GeneratorInterface $parent
		 *
		 * @return $this
		 */
		public function setParent(GeneratorInterface $parent) {
			$this->parent = $parent;

			return $this;
		}
	}