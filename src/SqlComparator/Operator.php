<?php
/**
 * @note         Абстрактный класс для выборки с операторами gt, ge, lt, le.
 * @copyright    Copyright © Real Time Engineering, LLP - All Rights Reserved
 * @license      Proprietary and confidential
 * Unauthorized copying or using of this file, via any medium is strictly prohibited.
 * Content can not be copied and/or distributed without the express permission of Real Time Engineering, LLP
 * @author       Written by Kuatbek Kazhytai <kkazhytai@mp.kz>, сентябрь 2021
 */

declare(strict_types = 1);

namespace Kazhytai\SQLComparator\SqlComparator;

use DateTime;

abstract class Operator extends Comparison
{
	/**
	 * @param DateTime|float|int|numeric $value
	 *
	 * @throws ComparatorException
	 */
	protected function validateValue($value): void {
		if(!in_array(gettype($value), $this->getValidDataTypes())) {
			throw new ComparatorException("Недопустимое значение переменной");
		}

		if(is_string($value) && !is_numeric($value)) {
			throw new ComparatorException("Используемое свойство не является типом numeric");
		}

		parent::validateValue($value);
	}
}
