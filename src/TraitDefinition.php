<?php
	namespace DaybreakStudios\CodeGenerator;

	class TraitDefinition {
		/**
		 * @var string
		 */
		protected $trait;

		/**
		 * @var TraitMemberAlias[]
		 */
		protected $aliases = [];

		/**
		 * TraitDefinition constructor.
		 *
		 * @param $trait
		 */
		public function __construct($trait) {
			$this->trait = $trait;
		}

		/**
		 * @return TraitMemberAlias[]
		 */
		public function getAliases() {
			return $this->aliases;
		}

		/**
		 * @param array $aliases
		 *
		 * @return $this
		 */
		public function setAliases(array $aliases) {
			$this->aliases = [];

			foreach ($aliases as $alias)
				$this->addAlias($alias);

			return $this;
		}

		/**
		 * @param TraitMemberAlias $alias
		 *
		 * @return void
		 */
		public function addAlias(TraitMemberAlias $alias) {
			$this->aliases[] = $alias;
		}
	}