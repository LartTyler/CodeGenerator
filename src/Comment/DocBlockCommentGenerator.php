<?php
	namespace DaybreakStudios\CodeGenerator\Comment;

	class DocBlockCommentGenerator extends BlockCommentGenerator {
		/**
		 * {@inheritdoc}
		 */
		protected $blockPrefix = '/**';
	}