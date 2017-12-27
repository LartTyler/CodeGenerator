<?php
	namespace DaybreakStudios\CodeGenerator\Member\Traits;

	use DaybreakStudios\CodeGenerator\GeneratorInterface;

	interface TraitGeneratorInterface extends GeneratorInterface {
		/**
		 * @return string
		 */
		public function getName();

		/**
		 * @param string $name
		 *
		 * @return $this
		 */
		public function setName($name);

		/**
		 * @return array
		 */
		public function getMethodAliases();

		/**
		 * @param string $method
		 * @param string $alias
		 *
		 * @return $this
		 */
		public function setMethodAlias($method, $alias);

		/**
		 * @param string $method
		 *
		 * @return $this
		 */
		public function removeMethodAlias($method);

		/**
		 * @return array
		 */
		public function getMethodAccessChanges();

		/**
		 * @param string $method
		 * @param int    $access
		 *
		 * @return $this
		 */
		public function setMethodAccess($method, $access);

		/**
		 * @param string $method
		 *
		 * @return $this
		 */
		public function removeMethodAccessChange($method);

		/**
		 * @return array
		 */
		public function getMethodReplacements();

		/**
		 * @param string $method
		 * @param string $replacedTrait
		 *
		 * @return $this
		 */
		public function setMethodReplaces($method, $replacedTrait);

		/**
		 * @param string $method
		 *
		 * @return $this
		 */
		public function removeMethodReplacement($method);
	}