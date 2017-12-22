<?php
	namespace DaybreakStudios\CodeGenerator\Member\Property;

	use DaybreakStudios\CodeGenerator\Comment\CommentGeneratorInterface;
	use DaybreakStudios\CodeGenerator\Member\MemberGeneratorInterface;

	interface PropertyGeneratorInterface extends MemberGeneratorInterface {
		/**
		 * @return CommentGeneratorInterface|PropertyAwareFluentGeneratorInterface
		 */
		public function setNewComment();

		/**
		 * @return string|null
		 */
		public function getType();

		/**
		 * @param string|null $type
		 *
		 * @return $this
		 */
		public function setType($type);

		/**
		 * @return mixed
		 */
		public function getDefault();

		/**
		 * @param mixed $default
		 *
		 * @return $this
		 */
		public function setDefault($default);

		/**
		 * @return $this
		 */
		public function clearDefault();

		/**
		 * @return bool
		 */
		public function hasDefault();
	}