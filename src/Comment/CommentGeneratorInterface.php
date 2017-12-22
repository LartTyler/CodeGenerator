<?php
	namespace DaybreakStudios\CodeGenerator\Comment;

	use DaybreakStudios\CodeGenerator\GeneratorInterface;

	interface CommentGeneratorInterface extends GeneratorInterface {
		/**
		 * @return string
		 */
		public function getLinePrefix();

		/**
		 * @param string $prefix
		 *
		 * @return $this
		 */
		public function setLinePrefix($prefix);

		/**
		 * @return string[]
		 */
		public function getLines();

		/**
		 * @param string[] $lines
		 *
		 * @return $this
		 */
		public function setLines(array $lines);

		/**
		 * @param string $line
		 *
		 * @return $this
		 */
		public function prepend($line);

		/**
		 * @param string $line
		 *
		 * @return $this
		 */
		public function append($line);

		/**
		 * @param CommentGeneratorInterface $comment
		 * @param bool|string               $separatorLine
		 *
		 * @return $this
		 */
		public function merge(CommentGeneratorInterface $comment, $separatorLine = false);
	}