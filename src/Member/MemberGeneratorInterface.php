<?php
	namespace DaybreakStudios\CodeGenerator\Member;

	use DaybreakStudios\CodeGenerator\Comment\CommentGeneratorInterface;
	use DaybreakStudios\CodeGenerator\GeneratorInterface;

	interface MemberGeneratorInterface extends GeneratorInterface {
		const QUOTE_STYLE_SINGLE = "'";
		const QUOTE_STYLE_DOUBLE = '"';

		/**
		 * @return CommentGeneratorInterface|null
		 */
		public function getComment();

		/**
		 * @param CommentGeneratorInterface|null $comment
		 *
		 * @return $this
		 */
		public function setComment(CommentGeneratorInterface $comment = null);

		/**
		 * @return CommentGeneratorInterface|MemberAwareFluentGeneratorInterface
		 */
		public function setNewComment();

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
		 * @return int
		 * @see MemberAccess
		 */
		public function getAccess();

		/**
		 * @param int $access
		 *
		 * @return $this
		 * @see MemberAccess
		 */
		public function setAccess($access);
	}