<?php
/**
 * @note         Базовый интерфейс генерации условных запросов
 * @copyright    Copyright © Real Time Engineering, LLP - All Rights Reserved
 * @license      Proprietary and confidential
 * Unauthorized copying or using of this file, via any medium is strictly prohibited.
 * Content can not be copied and/or distributed without the express permission of Real Time Engineering, LLP
 * @author       Written by Kuatbek Kazhytai <kkazhytai@mp.kz>, сентябрь 2021
 */

declare(strict_types = 1);

namespace Kazhytai\SQLComparator\SqlComparator;

use DateTime;

interface Comparator
{
	const TYPE_BOOLEAN = "boolean";
	const TYPE_DOUBLE  = "double";
	const TYPE_FLOAT   = "float";
	const TYPE_INTEGER = "integer";
	const TYPE_NULL    = "NULL";
	const TYPE_OBJECT  = "object";
	const TYPE_STRING  = "string";

	/**
	 * Comparator constructor.
	 *
	 * @param int|float|string|DateTime|null|bool $value
	 */
	public function __construct($value);

	/**
	 * @return string
	 */
	public function __toString(): string;

	/**
	 * @return int|float|string|DateTime|null|bool
	 */
	public function getValue();

	/**
	 * @param int|float|string|DateTime|null|bool $value
	 *
	 * @return Comparator
	 */
	public function setValue($value): Comparator;
}
