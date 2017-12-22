<?php
	namespace DaybreakStudios\CodeGenerator\Comment;

	use DaybreakStudios\CodeGenerator\AbstractGenerator;
	use DaybreakStudios\CodeGenerator\FluentAwareTrait;
	use DaybreakStudios\CodeGenerator\FluentGeneratorInterface;

	abstract class AbstractCommentGenerator extends AbstractGenerator implements CommentGeneratorInterface, FluentGeneratorInterface {
		use FluentAwareTrait;

		/**
		 * @var string
		 */
		protected $linePrefix;

		/**
		 * @var string[]
		 */
		protected $lines;

		/**
		 * CommentGenerator constructor.
		 *
		 * @param string   $linePrefix
		 * @param string[] $lines
		 */
		public function __construct($linePrefix, array $lines = []) {
			$this->linePrefix = $linePrefix;
			$this->lines = $lines;
		}

		/**
		 * {@inheritdoc}
		 */
		public function getLines() {
			return $this->lines;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setLines(array $lines) {
			$this->lines = $lines;

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function getLinePrefix() {
			return $this->linePrefix;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setLinePrefix($linePrefix) {
			$this->linePrefix = $linePrefix;

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function prepend($line) {
			array_unshift($this->lines, $line);

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function append($line) {
			$this->lines[] = $line;

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function merge(CommentGeneratorInterface $comment, $separatorLine = false) {
			$lines = $this->getLines();

			if ($separatorLine !== false)
				$lines[] = $separatorLine;

			$this->setLines(array_merge($lines, $comment->getLines()));

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function generate($depth = 0) {
			$prefix = $this->indent($depth) . $this->getLinePrefix();
			$output = '';

			foreach ($this->getLines() as $line)
				$output .= $prefix . rtrim($line) . PHP_EOL;

			return rtrim($output);
		}
	}