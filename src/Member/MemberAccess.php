<?php
	namespace DaybreakStudios\CodeGenerator\Member;

	class MemberAccess {
		const ACCESS_NOT_DEFINED = 0;
		const ACCESS_PUBLIC = 1;
		const ACCESS_PRIVATE = 2;
		const ACCESS_PROTECTED = 4;
		const ACCESS_STATIC = 8;

		const ACCESS_PUBLIC_STATIC = self::ACCESS_PUBLIC | self::ACCESS_STATIC;
		const ACCESS_PRIVATE_STATIC = self::ACCESS_PRIVATE | self::ACCESS_STATIC;
		const ACCESS_PROTECTED_STATIC = self::ACCESS_PROTECTED | self::ACCESS_STATIC;

		const NAMES = [
			self::ACCESS_PUBLIC => 'public',
			self::ACCESS_PRIVATE => 'private',
			self::ACCESS_PROTECTED => 'protected',
			self::ACCESS_STATIC => 'static',
		];

		/**
		 * @param int $access
		 *
		 * @return string
		 */
		public static function toName($access) {
			if ($access === static::ACCESS_NOT_DEFINED)
				return '';

			$matches = [];

			foreach (static::NAMES as $mask => $value)
				if ($access & $mask)
					$matches[] = $value;

			if (!$matches)
				throw new \InvalidArgumentException('Cannot convert ' . $access . ' to access string');

			return implode(' ', $matches);
		}
	}