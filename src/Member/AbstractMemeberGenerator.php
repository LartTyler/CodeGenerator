<?php
	namespace DaybreakStudios\CodeGenerator\Member;

	use DaybreakStudios\CodeGenerator\AbstractGenerator;
	use DaybreakStudios\CodeGenerator\Comment\CommentGeneratorInterface;
	use DaybreakStudios\CodeGenerator\Comment\DocBlockCommentGenerator;
	use DaybreakStudios\CodeGenerator\FluentAwareTrait;
	use DaybreakStudios\CodeGenerator\FluentGeneratorInterface;
	use DaybreakStudios\CodeGenerator\ParentAwareInterface;

	abstract class AbstractMemeberGenerator extends AbstractGenerator implements MemberGeneratorInterface, FluentGeneratorInterface {
		use FluentAwareTrait;

		/**
		 * @var string
		 */
		protected $name;

		/**
		 * @var int
		 * @see MemberAccess
		 */
		protected $access = MemberAccess::ACCESS_NOT_DEFINED;

		/**
		 * @var CommentGeneratorInterface|null
		 */
		protected $comment = null;

		/**
		 * @var string
		 */
		protected $quoteStyle = MemberGeneratorInterface::QUOTE_STYLE_SINGLE;

		/**
		 * @var string
		 */
		protected $commentGeneratorClass = DocBlockCommentGenerator::class;

		/**
		 * AbstractMemberGenerator constructor.
		 *
		 * @param string $name
		 */
		public function __construct($name) {
			$this->name = $name;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setTargetPHPVersion($targetPHPVersion) {
			parent::setTargetPHPVersion($targetPHPVersion);

			if ($comment = $this->getComment())
				$comment->setTargetPHPVersion($targetPHPVersion);

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function getComment() {
			return $this->comment;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setComment(CommentGeneratorInterface $comment = null) {
			$this->comment = $comment;

			if ($comment)
				$comment->setTargetPHPVersion($this->getTargetPHPVersion());

			return $this;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setNewComment(&$comment = null) {
			$class = $this->getCommentGeneratorClass();

			/** @var CommentGeneratorInterface $comment */
			$this->setComment($comment = new $class());

			if ($comment instanceof ParentAwareInterface)
				$comment->setParent($this);

			return $comment;
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
		 * {@inheritdoc}
		 */
		public function getAccess() {
			return $this->access;
		}

		/**
		 * {@inheritdoc}
		 */
		public function setAccess($access) {
			$this->access = $access;

			return $this;
		}

		/**
		 * @return string
		 */
		public function getQuoteStyle() {
			return $this->quoteStyle;
		}

		/**
		 * @param string $quoteStyle
		 *
		 * @return $this
		 * @see MemberGeneratorInterface::QUOTE_STYLE_SINGLE
		 * @see MemberGeneratorInterface::QUOTE_STYLE_DOUBLE
		 */
		public function setQuoteStyle($quoteStyle) {
			$this->quoteStyle = $quoteStyle;

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
	}