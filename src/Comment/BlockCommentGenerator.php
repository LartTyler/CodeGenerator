<?php
	namespace DaybreakStudios\CodeGenerator\Comment;

	class BlockCommentGenerator extends AbstractCommentGenerator {
		/**
		 * @var string
		 */
		protected $blockPrefix = '/*';

		/**
		 * @var string
		 */
		protected $blockSuffix = ' */';

		/**
		 * BlockCommentGenerator constructor.
		 *
		 * @param array $lines
		 */
		public function __construct(array $lines = []) {
			parent::__construct(' * ', $lines);
		}

		/**
		 * @return string
		 */
		public function getBlockPrefix() {
			return $this->blockPrefix;
		}

		/**
		 * @param string $blockPrefix
		 *
		 * @return $this
		 */
		public function setBlockPrefix($blockPrefix) {
			$this->blockPrefix = $blockPrefix;

			return $this;
		}

		/**
		 * @return string
		 */
		public function getBlockSuffix() {
			return $this->blockSuffix;
		}

		/**
		 * @param string $blockSuffix
		 *
		 * @return $this
		 */
		public function setBlockSuffix($blockSuffix) {
			$this->blockSuffix = $blockSuffix;

			return $this;
		}

		/**
		 * @param int $depth
		 *
		 * @return string
		 */
		public function generate($depth = 0) {
			$indent = $this->indent($depth);
			$output = $indent . $this->getBlockPrefix() . PHP_EOL . parent::generate($depth) . PHP_EOL . $indent .
				$this->getBlockSuffix();

			return $output;
		}
	}