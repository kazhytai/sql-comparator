<?php
/**
 * @note         Общий класс для Operator и Equality
 * @copyright    Copyright © Real Time Engineering, LLP - All Rights Reserved
 * @license      Proprietary and confidential
 * Unauthorized copying or using of this file, via any medium is strictly prohibited.
 * Content can not be copied and/or distributed without the express permission of Real Time Engineering, LLP
 * @author       Written by Nurlan Mukhanov <nmukhanov@mp.kz>, октябрь 2021
 */

declare(strict_types = 1);

namespace Kazhytai\SQLComparator\SqlComparator;

use DateTime;

abstract class Comparison implements Comparator
{
	/** @var null|int|float|string|DateTime */
	protected $value;

	/**
	 * Comparison constructor.
	 *
	 * @param null|int|float|string|DateTime $value
	 *
	 * @throws ComparatorException
	 */
	public function __construct($value) {
		$this->setValue($value);
	}

	/**
	 * @return string
	 */
	public function __toString(): string {
		if($this->value instanceof DateTime)
			return $this->getValue()->format("c");
		else
			return (string) $this->getValue();
	}

	/**
	 * @return null|int|float|string|DateTime
	 */
	public function getValue() {
		return $this->value;
	}

	/**
	 * @param null|int|float|string|DateTime $value
	 *
	 * @return Equality
	 * @throws ComparatorException
	 * @todo переделать возврат значения на собственный экземпляр при переходе на 7.4
	 */
	public function setValue($value): Comparator {
		$this->validateValue($value);
		$this->value = $value;

		return $this;
	}

	/**
	 * @param null|int|float|string|DateTime $value
	 *
	 * @throws ComparatorException
	 */
	protected function validateValue($value): void {
		//Если объект не экземпляр класса dateTime
		if(is_object($value) && !$value instanceof DateTime) {
			throw new ComparatorException("Используемый объект не является экземпляром класса DateTime");
		}
	}

	/**
	 * @return string[]
	 */
	protected function getValidDataTypes(): array {
		return [
			Comparator::TYPE_OBJECT,
			Comparator::TYPE_INTEGER,
			Comparator::TYPE_DOUBLE,
			Comparator::TYPE_STRING,
		];
	}
}
