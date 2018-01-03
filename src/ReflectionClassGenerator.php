<?php
	namespace DaybreakStudios\CodeGenerator;

	use DaybreakStudios\CodeGenerator\Member\MemberAccess;
	use DaybreakStudios\CodeGenerator\Member\Method\MethodGeneratorInterface;
	use DaybreakStudios\CodeGenerator\Member\Property\PropertyGeneratorInterface;
	use DaybreakStudios\CodeGenerator\Utility\ClassUtil;

	class ReflectionClassGenerator extends ClassGenerator {
		/**
		 * @var \ReflectionClass
		 */
		protected $sourceClass;

		/**
		 * ReflectionClassGenerator constructor.
		 *
		 * @param string $sourceClass
		 * @param string $name
		 * @param int    $type
		 */
		public function __construct($sourceClass, $name, $type = ClassType::TYPE_CONCRETE) {
			parent::__construct($name, $type);

			$this->sourceClass = new \ReflectionClass($sourceClass);
		}

		/**
		 * @return \ReflectionClass
		 */
		public function getSourceClass() {
			return $this->sourceClass;
		}

		/**
		 * @param \ReflectionClass $sourceClass
		 *
		 * @return $this
		 */
		public function setSourceClass(\ReflectionClass $sourceClass) {
			$this->sourceClass = $sourceClass;

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function generate($depth = 0) {
			$source = $this->getSourceClass();

			if ($this->getType() === ClassType::TYPE_INTERFACE && !$source->isInterface())
				throw new \RuntimeException('Cannot generate an interface from an abstract or concrete class.');

			$bareInst = $source->newInstanceWithoutConstructor();

			$interfaces = $this->getDirectInterfaces($source);

			if ($this->getType() === ClassType::TYPE_INTERFACE)
				$this->setExtends($interfaces);
			else {
				if ($parent = $source->getParentClass())
					$this->setExtends([
						$parent->getName(),
					]);

				foreach ($interfaces as $interface)
					$this->addImplements($interface);
			}

			foreach ($source->getProperties() as $property) {
				if (isset($this->getProperties()[$property->getName()]))
					continue;
				else if ($property->getDeclaringClass()->getName() !== $source->getName())
					continue;

				$property->setAccessible(true);

				/** @var PropertyGeneratorInterface $prop */
				$this->addNewProperty($property->getName(), $prop)
					->setAccess($this->getAccess($property))
					->setDefault($property->getValue($bareInst));

				if ($comment = $property->getDocComment())
					$prop->setNewComment()
						->setLines($this->splitDocComment($comment));
			}

			foreach ($source->getMethods() as $method) {
				if (isset($this->getMethods()[$method->getName()]))
					continue;
				else if ($method->getDeclaringClass()->getName() !== $source->getName())
					continue;

				/** @var MethodGeneratorInterface $meth */
				$this->addNewMethod($method->getName(), $meth)
					->setAccess($this->getAccess($method));

				if ($comment = $method->getDocComment())
					$meth->setNewComment()
						->setLines($this->splitDocComment($comment));

				if ($method->isAbstract())
					$meth->setAbstract(true);
				else if ($method->isFinal())
					$meth->setFinal(true);

				if ($this->getTargetPHPVersion() >= 70000 && $returnType = $method->getReturnType()) {
					$returnType = $returnType->getName();

					if (strpos($returnType, '\\') !== false && $this->getImportReferencedClasses()) {
						$this->addImport($returnType);

						$returnType = ClassUtil::toShortName($returnType);
					}

					$meth->setReturnType($returnType);
				}

				foreach ($method->getParameters() as $parameter) {
					/** @var PropertyGeneratorInterface $param */
					$meth->addNewArgument($parameter->getName(), $param);

					$type = $parameter->getClass();

					if (!$type && $this->getTargetPHPVersion() >= 70000 && $type = $parameter->getType())
						$type = $type->getName();

					if ($type) {
						if (strpos($type, '\\') !== false && $this->getImportReferencedClasses()) {
							$this->addImport($type);

							$type = ClassUtil::toShortName($type);
						}

						$param->setType($type);
					}

					if ($parameter->isOptional()) {
						if ($parameter->isDefaultValueConstant())
							$default = $parameter->getDefaultValueConstantName();
						else
							$default = $parameter->getDefaultValue();

						$param->setDefault($default);
					}
				}

				$meth->setCode($method->getClosure($bareInst));
			}

			return parent::generate($depth);
		}

		/**
		 * @param \ReflectionProperty|\ReflectionMethod $refl
		 *
		 * @return int
		 */
		protected function getAccess($refl) {
			if (!($refl instanceof \ReflectionProperty) && !($refl instanceof \ReflectionMethod))
				throw new \RuntimeException('Can only retrieve access from \\ReflectionMethod and' .
					'\\ReflectionProperty objects.');

			$access = MemberAccess::ACCESS_NOT_DEFINED;

			if ($refl->isStatic())
				$access |= MemberAccess::ACCESS_STATIC;

			if ($refl->isPrivate())
				$access |= MemberAccess::ACCESS_PRIVATE;
			else if ($refl->isProtected())
				$access |= MemberAccess::ACCESS_PROTECTED;
			else if ($refl->isPublic())
				$access |= MemberAccess::ACCESS_PUBLIC;

			return $access;
		}

		/**
		 * @param string $comment
		 *
		 * @return array
		 */
		protected function splitDocComment($comment) {
			return array_filter(array_map(function($line) {
				$line = trim($line);

				if (strpos($line, '/**') === 0 || strpos($line, '*/') === 0)
					return null;

				return ltrim($line, ' *');
			}, explode(PHP_EOL, $comment)), function($item) {
				return $item !== null;
			});
		}

		/**
		 * @param \ReflectionClass $class
		 *
		 * @return string[]
		 */
		protected function getDirectInterfaces(\ReflectionClass $class) {
			$parent = $class->getParentClass();

			if (!$parent)
				return $class->getInterfaceNames();

			$parentInterfaces = $parent->getInterfaceNames();

			return array_filter($class->getInterfaceNames(), function($item) use ($parentInterfaces) {
				return !in_array($item, $parentInterfaces);
			});
		}
	}