<?php
	namespace DaybreakStudios\CodeGenerator;

	use DaybreakStudios\CodeGenerator\Comment\CommentGeneratorInterface;
	use DaybreakStudios\CodeGenerator\Comment\DocBlockCommentGenerator;
	use DaybreakStudios\CodeGenerator\Member\MemberAccess;
	use DaybreakStudios\CodeGenerator\Member\Method\MethodGenerator;
	use DaybreakStudios\CodeGenerator\Member\Method\MethodGeneratorInterface;
	use DaybreakStudios\CodeGenerator\Member\Property\PropertyGenerator;
	use DaybreakStudios\CodeGenerator\Member\Property\PropertyGeneratorInterface;
	use DaybreakStudios\CodeGenerator\Utility\ClassUtil;

	class ClassGenerator extends AbstractGenerator implements ClassGeneratorInterface {
		/**
		 * @var string
		 */
		protected $name;

		/**
		 * @var int
		 */
		protected $type;

		/**
		 * @var string|null
		 */
		protected $namespace = null;

		/**
		 * @var string[]
		 */
		protected $imports = [];

		/**
		 * @var string|null
		 */
		protected $extends = null;

		/**
		 * @var string[]
		 */
		protected $implements = [];

		/**
		 * @var CommentGeneratorInterface|null
		 */
		protected $classComment = null;

		/**
		 * @var PropertyGeneratorInterface[]
		 */
		protected $properties = [];

		/**
		 * @var MethodGeneratorInterface[]
		 */
		protected $methods = [];

		/**
		 * @var bool
		 */
		protected $importReferencedClasses = true;

		/**
		 * @var string
		 */
		protected $commentGeneratorClass = DocBlockCommentGenerator::class;

		/**
		 * @var string
		 */
		protected $propertyGeneratorClass = PropertyGenerator::class;

		/**
		 * @var string
		 */
		protected $methodGeneratorClass = MethodGenerator::class;

		/**
		 * ClassGenerator constructor.
		 *
		 * @param string $name
		 * @param int    $type
		 */
		public function __construct($name, $type = ClassGeneratorInterface::TYPE_CONCRETE) {
			$this->name = $name;
			$this->type = $type;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setTargetPHPVersion($targetPHPVersion) {
			parent::setTargetPHPVersion($targetPHPVersion);

			if ($comment = $this->getClassComment())
				$comment->setTargetPHPVersion($targetPHPVersion);

			foreach ($this->getProperties() as $property)
				$property->setTargetPHPVersion($targetPHPVersion);

			foreach ($this->getMethods() as $method)
				$method->setTargetPHPVersion($targetPHPVersion);

			return $this;
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
		 * @return null|string
		 */
		public function getNamespace() {
			return $this->namespace;
		}

		/**
		 * @param null|string $namespace
		 *
		 * @return $this
		 */
		public function setNamespace($namespace) {
			$this->namespace = $namespace;

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function getImports() {
			return $this->imports;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setImports(array $classes) {
			$this->imports = [];

			foreach ($classes as $class => $alias) {
				if (is_int($class)) {
					$class = $alias;
					$alias = null;
				}

				$this->addImport($class, $alias);
			}

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function addImport($class, $alias = null) {
			if ($alias)
				$this->imports[$class] = $alias;
			else
				$this->imports[$class] = false;

			return $this;
		}

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
		public function getExtends() {
			return $this->extends;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setExtends($class, $alias = null) {
			if ($alias) {
				$this->addImport($class, $alias);

				$this->extends = $alias;
			} else if ($this->getImportReferencedClasses()) {
				$this->addImport($class);

				$this->extends = ClassUtil::toShortName($class);
			} else
				$this->extends = $class;

			return $this;
		}

		/**
		 * @return string[]
		 */
		public function getImplements() {
			return $this->implements;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setImplements(array $classes) {
			$this->implements = [];

			foreach ($classes as $class => $alias) {
				if (is_int($class)) {
					$class = $alias;
					$alias = null;
				}

				$this->addImplements($class, $alias);
			}

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function addImplements($class, $alias = null) {
			if ($alias) {
				$this->addImport($class, $alias);

				$this->implements[] = $alias;
			} else if ($this->getImportReferencedClasses()) {
				$this->addImport($class);

				$this->implements[] = ClassUtil::toShortName($class);
			} else
				$this->implements[] = $class;

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function getClassComment() {
			return $this->classComment;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setClassComment(CommentGeneratorInterface $comment = null) {
			$this->classComment = $comment;

			$comment->setTargetPHPVersion($this->getTargetPHPVersion());

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setNewClassComment(&$comment = null) {
			$class = $this->getCommentGeneratorClass();

			/** @var CommentGeneratorInterface $comment */
			$this->setClassComment($comment = new $class());

			if ($comment instanceof ParentAwareInterface)
				$comment->setParent($this);

			return $comment;
		}

		/**
		 * {@inheritdoc}
		 */
		public function getProperties() {
			return $this->properties;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setProperties(array $properties) {
			$this->properties = [];

			/** @var PropertyGeneratorInterface $property */
			foreach ($properties as $property)
				$this->addProperty($property);

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function addProperty(PropertyGeneratorInterface $property) {
			$this->properties[$property->getName()] = $property;

			$property->setTargetPHPVersion($this->getTargetPHPVersion());

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function addNewProperty($name, &$property = null) {
			$class = $this->getPropertyGeneratorClass();

			/** @var PropertyGeneratorInterface $property */
			$this->addProperty($property = new $class($name));

			if ($property instanceof ParentAwareInterface)
				$property->setParent($this);

			return $property;
		}

		/**
		 * {@inheritdoc}
		 */
		public function getMethods() {
			return $this->methods;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setMethods(array $methods) {
			$this->methods = [];

			/** @var MethodGeneratorInterface $method */
			foreach ($methods as $method)
				$this->addMethod($method);

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function addMethod(MethodGeneratorInterface $method) {
			$this->methods[$method->getName()] = $method;

			$method->setTargetPHPVersion($this->getTargetPHPVersion());

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function addNewMethod($name, &$method = null) {
			$class = $this->getMethodGeneratorClass();

			/** @var MethodGeneratorInterface $method */
			$this->addMethod($method = new $class($name));

			if ($method instanceof ParentAwareInterface)
				$method->setParent($this);

			return $method;
		}

		/**
		 * {@inheritdoc}
		 */
		public function addGetterMethod(PropertyGeneratorInterface $property, &$method = null) {
			/** @var MethodGeneratorInterface $method */
			$this->addNewMethod('get' . ucwords($property->getName()), $method)
				->setNewComment()
					->setLines([
						'Returns the ' . $property->getName() . ' property.',
						'',
						'@return ' . ($property->getType() ?: 'mixed'),
					])
					->done()
				->setAccess(MemberAccess::ACCESS_PUBLIC)
				->setCode('return $this->' . $property->getName());

			if ($returnType = $property->getType())
				$method->setReturnType($returnType);

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function addSetterMethod(PropertyGeneratorInterface $property, &$method = null) {
			/** @var MethodGeneratorInterface $method */
			$this->addNewMethod('set' . ucwords($property->getName()), $method)
				->setNewComment()
					->setLines([
						'Sets the ' . $property->getName() . ' property.',
						'',
						'@param ' . ($property->getType() ?: 'mixed') . ' ' . $property->getName(),
						'',
						'@return $this',
					])
					->done()
				->setAccess(MemberAccess::ACCESS_PUBLIC)
				->setReturnType($this->getName())
				->addArgument($property)
				->setCode(sprintf('$this->%1$s = %1$s;%2$s%2$sreturn $this;', $property->getName(), PHP_EOL));

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function addGetterAndSetterMethods(PropertyGeneratorInterface $property) {
			return $this
				->addGetterMethod($property)
				->addSetterMethod($property);
		}

		/**
		 * @return bool
		 */
		public function getImportReferencedClasses() {
			return $this->importReferencedClasses;
		}

		/**
		 * @param bool $importReferencedClasses
		 *
		 * @return $this
		 */
		public function setImportReferencedClasses($importReferencedClasses) {
			$this->importReferencedClasses = $importReferencedClasses;

			return $this;
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
		 * @return string
		 */
		public function getMethodGeneratorClass() {
			return $this->methodGeneratorClass;
		}

		/**
		 * @param string $methodGeneratorClass
		 *
		 * @return $this
		 */
		public function setMethodGeneratorClass($methodGeneratorClass) {
			$this->methodGeneratorClass = $methodGeneratorClass;

			return $this;
		}

		/**
		 * @return string
		 */
		public function getCommentGeneratorClass() {
			return $this->commentGeneratorClass;
		}

		/**
		 * @param string $commentGeneratorClass
		 *
		 * @return $this
		 */
		public function setCommentGeneratorClass($commentGeneratorClass) {
			$this->commentGeneratorClass = $commentGeneratorClass;

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function generate($depth = 0) {
			$output = '';

			if ($ns = $this->getNamespace())
				$output .= $this->indent($depth) . 'namespace ' . $ns . ';' . PHP_EOL . PHP_EOL;

			if ($imports = $this->getImports()) {
				foreach ($imports as $class => $alias) {
					$output .= $this->indent($depth) . 'use ' . $class;

					if ($alias !== false)
						$output .= 'as ' . $alias;

					$output .= ';' . PHP_EOL;
				}

				$output .= PHP_EOL;
			}

			if ($comment = $this->getClassComment())
				$output .= $comment->generate($depth) . PHP_EOL;

			$output .= $this->indent($depth);
			$type = $this->getType();

			if ($type < ClassGeneratorInterface::TYPE_INTERFACE) {
				if ($type === ClassGeneratorInterface::TYPE_FINAL)
					$output .= 'final ';
				else if ($type === ClassGeneratorInterface::TYPE_ABSTRACT)
					$output .= 'abstract ';

				$output .= 'class ';
			} else
				$output .= 'interface ';

			$output .= $this->getName() . ' ';

			if ($extends = $this->getExtends())
				$output .= 'extends ' . $extends . ' ';

			if ($implements = $this->getImplements())
				$output .= 'implements ' . implode(', ', $implements) . ' ';

			$output .= '{' . PHP_EOL;

			foreach ($this->getProperties() as $property)
				$output .= $property->generate($depth + 1) . PHP_EOL . PHP_EOL;

			foreach ($this->getMethods() as $method)
				$output .= $method->generate($depth + 1) . PHP_EOL . PHP_EOL;

			return rtrim($output) . PHP_EOL . $this->indent($depth) . '}';
		}
	}