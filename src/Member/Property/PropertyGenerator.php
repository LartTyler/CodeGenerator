<?php
	namespace DaybreakStudios\CodeGenerator\Member\Property;

	use DaybreakStudios\CodeGenerator\ClassGeneratorInterface;
	use DaybreakStudios\CodeGenerator\Member\AbstractMemeberGenerator;
	use DaybreakStudios\CodeGenerator\Member\MemberAccess;
	use DaybreakStudios\CodeGenerator\Member\ScalarTypes;
	use DaybreakStudios\CodeGenerator\Utility\ClassUtil;

	class PropertyGenerator extends AbstractMemeberGenerator implements PropertyGeneratorInterface {
		/**
		 * @var string|null
		 */
		protected $type = null;

		/**
		 * @var mixed
		 */
		protected $default = null;

		/**
		 * @var bool
		 */
		protected $hasDefault = false;

		/**
		 * {@inheritdoc}
		 */
		public function getType() {
			return $this->type;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setType($type) {
			$this->type = $type;

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function isTypeScalar() {
			return ScalarTypes::isScalar($this->getType());
		}

		/**
		 * {@inheritdoc}
		 */
		public function getDefault() {
			return $this->default;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setDefault($default) {
			$this->default = $default;
			$this->hasDefault = true;

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function hasDefault() {
			return $this->hasDefault;
		}

		/**
		 * @return $this
		 */
		public function clearDefault() {
			$this->default = null;
			$this->hasDefault = false;

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function generate($depth = 0) {
			$output = '';

			if ($comment = $this->getComment())
				$output .= $comment->generate($depth) . PHP_EOL;

			$output .= $this->indent($depth);

			if ($access = $this->getAccess())
				$output .= MemberAccess::toName($access) . ' ';
			else if (($type = $this->getType()) && (!$this->isTypeScalar() || $this->getTargetPHPVersion() >= 70000))
				$output .= $type . ' ';

			$output .= '$' . $this->getName();

			if ($this->hasDefault()) {
				$default = $this->getDefault();

				if (is_string($default) && !$this->isConstant($default)) {
					$quoteStyle = $this->getQuoteStyle();

					$default = $quoteStyle . str_replace($quoteStyle, '\\' . $quoteStyle, $default) . $quoteStyle;
				} else if (is_bool($default))
					$default = $default ? 'true' : 'false';
				else if ($default === null)
					$default = 'null';
				else if (is_array($default))
					$default = '[' . implode(', ', $default) . ']';

				$output .= ' = ' . $default;
			}

			if ($access)
				$output .= ';';

			return $output;
		}

		/**
		 * @param string $string
		 *
		 * @return bool
		 */
		protected function isConstant($string) {
			if (defined($string))
				return true;
			// If we didn't find something off of `defined`, the only other constant it could possibly be is a class
			// constant on an imported (and possibly aliased) class. If we don't have a parent that's a class generator
			// we can give up now.
			else if (strpos($string, '::') === false || !($this->parent instanceof ClassGeneratorInterface))
				return false;

			$constantClass = strtok($string, '::');
			$constantName = substr(strtok(''), 1);

			foreach ($this->parent->getImports() as $class => $alias)
				if ($constantClass === $alias || $constantClass === ClassUtil::toShortName($class))
					return defined($class . '::' . $constantName);

			return false;
		}
	}