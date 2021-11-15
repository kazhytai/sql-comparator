<?php
/**
 * @note         Abstract parent class for Eq and Ne
 * @copyright    Copyright © Real Time Engineering, LLP - All Rights Reserved
 * @license      Proprietary and confidential
 * Unauthorized copying or using of this file, via any medium is strictly prohibited.
 * Content can not be copied and/or distributed without the express permission of Real Time Engineering, LLP
 * @author       Written by Kuatbek Kazhytai <kkazhytai@mp.kz>, сентябрь 2021
 */

declare(strict_types=1);

namespace Kazhytai\SqlComparator\Comparator;

use DateTime;

abstract class Equality extends Comparison
{
    /**
     * @param DateTime|float|int|string|null $value
     *
     * @throws ComparatorException
     */
    protected function validateValue($value): void
    {
        if (!in_array(gettype($value), array_merge($this->getValidDataTypes(), [Comparator::TYPE_NULL]))) {
            throw new ComparatorException("Unacceptable variable value");
        }

        parent::validateValue($value);
    }
}
