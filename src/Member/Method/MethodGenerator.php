<?php
	namespace DaybreakStudios\CodeGenerator\Member\Method;

	use DaybreakStudios\CodeGenerator\Member\AbstractMemeberGenerator;
	use DaybreakStudios\CodeGenerator\Member\MemberAccess;
	use DaybreakStudios\CodeGenerator\Member\Property\PropertyGenerator;
	use DaybreakStudios\CodeGenerator\Member\Property\PropertyGeneratorInterface;
	use DaybreakStudios\CodeGenerator\Member\ScalarTypes;
	use DaybreakStudios\CodeGenerator\ParentAwareInterface;

	class MethodGenerator extends AbstractMemeberGenerator implements MethodGeneratorInterface {
		/**
		 * @var bool
		 */
		protected $abstract = false;

		/**
		 * @var bool
		 */
		protected $final = false;

		/**
		 * @var PropertyGeneratorInterface[]
		 */
		protected $arguments = [];

		/**
		 * @var string|null
		 */
		protected $returnType = null;

		/**
		 * @var string
		 */
		protected $code = null;

		/**
		 * @var string
		 */
		protected $propertyGeneratorClass = PropertyGenerator::class;

		/**
		 * {@inheritdoc}
		 */
		public function setTargetPHPVersion($targetPHPVersion) {
			parent::setTargetPHPVersion($targetPHPVersion);

			// Cascade version changes
			foreach ($this->getArguments() as $argument)
				$argument->setTargetPHPVersion($targetPHPVersion);

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function isAbstract() {
			return $this->abstract;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setAbstract($abstract) {
			$this->abstract = $abstract;

			return $this;
		}

		/**
		 * @return bool
		 */
		public function isFinal() {
			return $this->final;
		}

		/**
		 * @param bool $final
		 *
		 * @return $this
		 */
		public function setFinal($final) {
			$this->final = $final;

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function getArguments() {
			return $this->arguments;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setArguments(array $arguments) {
			$this->arguments = [];

			/** @var PropertyGeneratorInterface $argument */
			foreach ($arguments as $argument)
				$this->addArgument($argument);

			$this->arguments = $arguments;

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function addArgument(PropertyGeneratorInterface $argument) {
			// Arguments cannot have access or comments, so if either is set, clone the argument and clear them.
			if ($argument->getAccess() || $argument->getComment()) {
				$argument = clone $argument;
				$argument
					->setAccess(MemberAccess::ACCESS_NOT_DEFINED)
					->setComment(null);
			}

			$this->arguments[$argument->getName()] = $argument;

			$argument->setTargetPHPVersion($this->getTargetPHPVersion());

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function addNewArgument($name, &$method = null) {
			$class = $this->getPropertyGeneratorClass();

			$this->addArgument($method = new $class($name));

			if ($method instanceof ParentAwareInterface)
				$method->setParent($this);

			return $method;
		}

		/**
		 * {@inheritdoc}
		 */
		public function getReturnType() {
			return $this->returnType;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setReturnType($returnType) {
			$this->returnType = $returnType;

			return $this;
		}

		/**
		 * @return bool
		 */
		public function isReturnTypeScalar() {
			return ScalarTypes::isScalar($this->getReturnType());
		}

		/**
		 * {@inheritdoc}
		 */
		public function getCode() {
			return $this->code;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setCode($code) {
			if ($code instanceof \Closure)
				$code = $this->convertClosure($code);
			else if (is_callable($code))
				$code = $this->convertClosure(\Closure::fromCallable($code));

			$this->code = $code;

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

			if ($this->isAbstract())
				$output .= 'abstract ';
			else if ($this->isFinal())
				$output .= 'final ';

			$output .= 'function ' . $this->getName() . '(';

			$args = array_map(function(PropertyGeneratorInterface $property) {
				return $property->generate();
			}, $this->getArguments());

			$output .= implode(', ', $args) . ')';

			if (($returnType = $this->getReturnType()) && $this->getTargetPHPVersion() >= 70000)
				$output .= ': ' . $returnType;

			// Abstract and interface methods should not contain a body
			if ($this->isAbstract() || !$this->getCode())
				$output .= ';';
			else {
				$output .= ' {' . PHP_EOL;
				$lines = explode(PHP_EOL, $this->getCode());

				foreach ($lines as $i => $line) {
					if (strlen($line) > 0)
						$lines[$i] = $this->indent($depth + 1) . $line;
				}

				$output .= implode(PHP_EOL, $lines) . PHP_EOL . $this->indent($depth) . '}';
			}

			return $output;
		}

		/**
		 * @return string
		 */
		public function getPropertyGeneratorClass() {
			return $this->propertyGeneratorClass;
		}

		/**
		 * @param string $propertyGeneratorClass
		 *
		 * @return $this
		 */
		public function setPropertyGeneratorClass($propertyGeneratorClass) {
			$this->propertyGeneratorClass = $propertyGeneratorClass;

			return $this;
		}

		/**
		 * @param \Closure $closure
		 *
		 * @return string
		 */
		protected function convertClosure(\Closure $closure) {
			$refl = new \ReflectionFunction($closure);
			$file = new \SplFileObject($refl->getFileName());

			$file->seek($refl->getStartLine() - 1);

			$code = '';
			$depth = null;

			for ($i = $refl->getStartLine(), $ii = $refl->getEndLine() - 1; $i < $ii; $i++) {
				if ($file->eof())
					throw new \RuntimeException('Unexpected EOF while parsing closure source');

				$line = $file->fgets();

				if ($depth === null)
					$depth = strlen($line) - strlen(ltrim($line));

				if (strlen($line) > 0)
					$line = substr($line, $depth);

				$code .= rtrim($line) . PHP_EOL;
			}

			return rtrim($code, PHP_EOL);
		}
	}