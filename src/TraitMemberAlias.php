<?php
	namespace DaybreakStudios\CodeGenerator;

	use DaybreakStudios\CodeGenerator\Member\MemberAccess;

	class TraitMemberAlias {
		protected $name;

		/**
		 * @var string|null
		 */
		protected $alias = null;

		/**
		 * @var int
		 */
		protected $access = MemberAccess::ACCESS_NOT_DEFINED;

		public function __construct($name) {
			$this->name = $name;
		}

		/**
		 * @return mixed
		 */
		public function getName() {
			return $this->name;
		}

		/**
		 * @return null|string
		 */
		public function getAlias() {
			return $this->alias;
		}

		/**
		 * @param null|string $alias
		 *
		 * @return $this
		 */
		public function setAlias($alias) {
			$this->alias = $alias;

			return $this;
		}

		/**
		 * @return int
		 */
		public function getAccess() {
			return $this->access;
		}

		/**
		 * @param int $access
		 *
		 * @return $this
		 */
		public function setAccess($access) {
			$this->access = $access;

			return $this;
		}
	}