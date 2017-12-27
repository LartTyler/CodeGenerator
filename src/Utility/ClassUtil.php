<?php
	namespace DaybreakStudios\CodeGenerator\Utility;

	final class ClassUtil {
		/**
		 * @param string $class
		 *
		 * @return string
		 */
		public static function toShortName($class) {
			if (strpos($class, '\\') === false)
				return $class;

			return substr($class, strrpos($class, '\\') + 1);
		}
	}