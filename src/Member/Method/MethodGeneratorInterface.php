<?php
	namespace DaybreakStudios\CodeGenerator\Member\Method;

	use DaybreakStudios\CodeGenerator\Comment\CommentGeneratorInterface;
	use DaybreakStudios\CodeGenerator\Member\MemberGeneratorInterface;
	use DaybreakStudios\CodeGenerator\Member\Property\PropertyGeneratorInterface;

	interface MethodGeneratorInterface extends MemberGeneratorInterface {
		/**
		 * @return CommentGeneratorInterface|MethodAwareFluentGeneratorInterface
		 */
		public function setNewComment();

		/**
		 * @return bool
		 */
		public function isAbstract();

		/**
		 * @param bool $abstract
		 *
		 * @return $this
		 */
		public function setAbstract($abstract);

		/**
		 * @return bool
		 */
		public function isFinal();

		/**
		 * @param bool $final
		 *
		 * @return $this
		 */
		public function setFinal($final);

		/**
		 * @return PropertyGeneratorInterface
		 */
		public function getArguments();

		/**
		 * @param PropertyGeneratorInterface[] $arguments
		 *
		 * @return $this
		 */
		public function setArguments(array $arguments);

		/**
		 * @param PropertyGeneratorInterface $argument
		 *
		 * @return $this
		 */
		public function addArgument(PropertyGeneratorInterface $argument);

		/**
		 * @param string $name
		 * @param mixed  $argument
		 *
		 * @return MethodAwareFluentGeneratorInterface|PropertyGeneratorInterface
		 */
		public function addNewArgument($name, &$argument = null);

		/**
		 * @return string|null
		 */
		public function getReturnType();

		/**
		 * @param string|null $returnType
		 *
		 * @return $this
		 */
		public function setReturnType($returnType);

		/**
		 * @return bool
		 */
		public function isReturnTypeScalar();

		/**
		 * @return string
		 */
		public function getCode();

		/**
		 * @param \Closure|callable|string $code
		 *
		 * @return $this
		 */
		public function setCode($code);
	}