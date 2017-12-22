<?php
	namespace DaybreakStudios\CodeGenerator\Utility;

	final class ClassUtil {
		/**
		 * @param string $class
		 *
		 * @return string
		 */
		public static function toShortName($class) {
			return substr($class, strrpos($class, '\\') + 1);
		}
	}