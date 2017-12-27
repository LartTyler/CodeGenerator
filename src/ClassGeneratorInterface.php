<?php

	namespace DaybreakStudios\CodeGenerator;

	use DaybreakStudios\CodeGenerator\Comment\CommentGeneratorInterface;
	use DaybreakStudios\CodeGenerator\Member\Method\MethodGeneratorInterface;
	use DaybreakStudios\CodeGenerator\Member\Property\PropertyGeneratorInterface;
	use DaybreakStudios\CodeGenerator\Member\Traits\TraitGeneratorInterface;

	interface ClassGeneratorInterface extends GeneratorInterface {
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
		 * @return string[]
		 */
		public function getImports();

		/**
		 * @param string[] $imports
		 *
		 * @return $this
		 */
		public function setImports(array $imports);

		/**
		 * @param string      $class
		 * @param string|null $alias
		 *
		 * @return $this
		 */
		public function addImport($class, $alias = null);

		/**
		 * @return int
		 */
		public function getType();

		/**
		 * @param int $type
		 *
		 * @return $this
		 *
		 * @see ClassType
		 */
		public function setType($type);

		/**
		 * @return string[]
		 */
		public function getExtends();

		/**
		 * @param string[] $classes
		 *
		 * @return $this
		 */
		public function setExtends(array $classes);

		/**
		 * @param string      $class
		 * @param string|null $alias
		 *
		 * @return mixed
		 */
		public function addExtends($class, $alias = null);

		/**
		 * @return string[]
		 */
		public function getImplements();

		/**
		 * @param string[] $classes
		 *
		 * @return $this
		 */
		public function setImplements(array $classes);

		/**
		 * @param string      $class
		 * @param string|null $alias
		 *
		 * @return $this
		 */
		public function addImplements($class, $alias = null);

		/**
		 * @return TraitGeneratorInterface[]
		 */
		public function getTraits();

		/**
		 * @param TraitGeneratorInterface[] $traits
		 *
		 * @return $this
		 */
		public function setTraits(array $traits);

		/**
		 * @param TraitGeneratorInterface $trait
		 *
		 * @return $this
		 */
		public function addTrait(TraitGeneratorInterface $trait);

		/**
		 * @param string $name
		 * @param mixed  $trait
		 *
		 * @return TraitGeneratorInterface|ClassAwareFluentGeneratorInterface
		 */
		public function addNewTrait($name, &$trait = null);

		/**
		 * @return CommentGeneratorInterface|null
		 */
		public function getClassComment();

		/**
		 * @param CommentGeneratorInterface|null $comment
		 *
		 * @return $this
		 */
		public function setClassComment(CommentGeneratorInterface $comment = null);

		/**
		 * @param mixed $comment if provided, the created object will be stored in this variable
		 *
		 * @return ClassAwareFluentGeneratorInterface|CommentGeneratorInterface
		 */
		public function setNewClassComment(&$comment = null);

		/**
		 * @return PropertyGeneratorInterface[]
		 */
		public function getProperties();

		/**
		 * @param PropertyGeneratorInterface[] $properties
		 *
		 * @return $this
		 */
		public function setProperties(array $properties);

		/**
		 * @param PropertyGeneratorInterface $property
		 *
		 * @return $this
		 */
		public function addProperty(PropertyGeneratorInterface $property);

		/**
		 * @param string $name
		 * @param mixed  $property if provided, the created object will be stored in this variable
		 *
		 * @return PropertyGeneratorInterface|ClassAwareFluentGeneratorInterface
		 */
		public function addNewProperty($name, &$property = null);

		/**
		 * @return MethodGeneratorInterface[]
		 */
		public function getMethods();

		/**
		 * @param MethodGeneratorInterface[] $methods
		 *
		 * @return $this
		 */
		public function setMethods(array $methods);

		/**
		 * @param MethodGeneratorInterface $method
		 *
		 * @return $this
		 */
		public function addMethod(MethodGeneratorInterface $method);

		/**
		 * @param string $name
		 * @param mixed  $method if provided, the created object will be stored in this variable
		 *
		 * @return MethodGeneratorInterface|ClassAwareFluentGeneratorInterface
		 */
		public function addNewMethod($name, &$method = null);

		/**
		 * @param PropertyGeneratorInterface $property
		 * @param mixed                      $method
		 *
		 * @return $this
		 */
		public function addGetterMethod(PropertyGeneratorInterface $property, &$method = null);

		/**
		 * @param PropertyGeneratorInterface $property
		 * @param mixed                      $method
		 *
		 * @return $this
		 */
		public function addSetterMethod(PropertyGeneratorInterface $property, &$method = null);

		/**
		 * @param PropertyGeneratorInterface $property
		 *
		 * @return $this
		 */
		public function addGetterAndSetterMethods(PropertyGeneratorInterface $property);
	}