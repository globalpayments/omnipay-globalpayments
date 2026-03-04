<?php

namespace Omnipay\GlobalPayments\Tests\Utils;

class HelperMethods
{
    public static function getValidExpYear(): int
    {
        return ((int) date('Y')) + 1;
    }
}
