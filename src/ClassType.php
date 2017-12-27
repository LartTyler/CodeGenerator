<?php
	namespace DaybreakStudios\CodeGenerator;

	class ClassType {
		const TYPE_CONCRETE = 1;
		const TYPE_FINAL = 2;
		const TYPE_ABSTRACT = 3;
		const TYPE_INTERFACE = 4;
		const TYPE_TRAIT = 5;

		const NAMES = [
			self::TYPE_CONCRETE => 'class',
			self::TYPE_FINAL => 'final class',
			self::TYPE_ABSTRACT => 'abstract class',
			self::TYPE_INTERFACE => 'interface',
			self::TYPE_TRAIT => 'trait',
		];

		/**
		 * @param int $type
		 *
		 * @return string|null
		 */
		public static function toName($type) {
			return @self::NAMES[$type];
		}
	}