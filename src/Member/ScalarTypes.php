<?php
	namespace DaybreakStudios\CodeGenerator\Member;

	class ScalarTypes {
		const STRING = 'string';
		const INTEGER = 'int';
		const BOOLEAN = 'bool';
		const FLOAT = 'float';

		const ALL = [
			self::STRING,
			self::INTEGER,
			self::BOOLEAN,
			self::FLOAT,
		];

		/**
		 * @param string|null $type
		 *
		 * @return bool
		 */
		public static function isScalar($type) {
			if (!$type || strpos($type, '\\'))
				return false;

			return in_array($type, self::ALL);
		}
	}