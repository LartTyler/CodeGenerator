<?php
	namespace DaybreakStudios\CodeGenerator\Comment;

	class InheritDocBlockCommentGenerator extends DocBlockCommentGenerator {
		/**
		 * InheritDocBlockCommentGenerator constructor.
		 */
		public function __construct() {
			parent::__construct([
				'{@inheritdoc}',
			]);
		}
	}