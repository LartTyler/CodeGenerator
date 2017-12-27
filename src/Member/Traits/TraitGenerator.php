<?php
	namespace DaybreakStudios\CodeGenerator\Member\Traits;

	use DaybreakStudios\CodeGenerator\AbstractGenerator;
	use DaybreakStudios\CodeGenerator\FluentAwareTrait;
	use DaybreakStudios\CodeGenerator\FluentGeneratorInterface;
	use DaybreakStudios\CodeGenerator\Member\MemberAccess;

	class TraitGenerator extends AbstractGenerator implements TraitGeneratorInterface, FluentGeneratorInterface {
		use FluentAwareTrait;

		/**
		 * @var string
		 */
		protected $name;

		/**
		 * @var string[]
		 */
		protected $aliases = [];

		/**
		 * @var int[]
		 */
		protected $accessChanges = [];

		/**
		 * @var string[]
		 */
		protected $replacements = [];

		/**
		 * TraitGenerator constructor.
		 *
		 * @param string $name
		 */
		public function __construct($name) {
			$this->name = $name;
		}

		/**
		 * {@inheritdoc}
		 */
		public function getName() {
			return $this->name;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setName($name) {
			$this->name = $name;

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function getMethodAliases() {
			return $this->aliases;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setMethodAlias($method, $alias) {
			$this->aliases[$method] = $alias;

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function removeMethodAlias($method) {
			unset($this->aliases[$method]);

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function getMethodAccessChanges() {
			return $this->accessChanges;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setMethodAccess($method, $access) {
			$this->accessChanges[$method] = $access;

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function removeMethodAccessChange($method) {
			unset($this->accessChanges[$method]);

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function getMethodReplacements() {
			return $this->replacements;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setMethodReplaces($method, $replacedTrait) {
			$this->replacements[$method] = $replacedTrait;

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function removeMethodReplacement($method) {
			unset($this->replacements[$method]);

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function generate($depth = 0) {
			$output = $this->indent($depth) . 'use ' . $this->getName();
			$resolutions = [];

			foreach ($this->getMethodReplacements() as $method => $replaced)
				$resolutions[] = $this->getName() . '::' . $method . ' insteadof ' . $replaced;

			$aliases = [];

			foreach ($this->getMethodAliases() as $method => $alias)
				$aliases[$method] = $alias;

			foreach ($this->getMethodAccessChanges() as $method => $access) {
				$alias = @$aliases[$method] ?: '';

				$aliases[$method] = trim(MemberAccess::toName($access) . ' ' . $alias);
			}

			foreach ($aliases as $method => $alias)
				$resolutions[] = $this->getName() . '::' . $method . ' as ' . $alias;

			if ($resolutions) {
				$output .= ' {' . PHP_EOL;

				foreach ($resolutions as $resolution)
					$output .= $this->indent($depth + 1) . $resolution . ';' . PHP_EOL;

				$output .= $this->indent($depth) . '}';
			} else
				$output .= ';';

			return $output;
		}
	}