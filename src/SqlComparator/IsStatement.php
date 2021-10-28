<?php
/**
 * @note         Абстрактный класс для выборки с операторами Is и IsNot
 * @copyright    Copyright © Real Time Engineering, LLP - All Rights Reserved
 * @license      Proprietary and confidential
 * Unauthorized copying or using of this file, via any medium is strictly prohibited.
 * Content can not be copied and/or distributed without the express permission of Real Time Engineering, LLP
 * @author       Written by Kuatbek Kazhytai <kkazhytai@mp.kz>, сентябрь 2021
 */

declare(strict_types = 1);

namespace SqlComparator;

use MP\Utils\TextUtils;

abstract class IsStatement implements Comparator
{
	/** @var bool|null */
	protected ?bool $value;

	/**
	 * IsStatement constructor.
	 *
	 * @param bool|null $value
	 */
	public function __construct($value) {
		$this->setValue($value);
	}

	/**
	 * @return string
	 */
	public function __toString(): string {
		return TextUtils::boolToString($this->getValue());
	}

	/**
	 * @return bool|null
	 */
	public function getValue(): ?bool {
		return $this->value;
	}

	/**
	 * @param bool|null $value
	 *
	 * @return $this
	 */
	public function setValue($value): IsStatement {
		$this->validateValue($value);
		$this->value = $value;

		return $this;
	}

	/**
	 * @param bool|null $value
	 */
	protected function validateValue(?bool $value): void {
	}
}
