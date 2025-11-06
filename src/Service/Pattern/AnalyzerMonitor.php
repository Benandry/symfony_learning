<?php
declare(strict_types=1);

namespace App\Service\Pattern;

final class AnalyzerMonitor implements AnalyzerInterface
{
    public function analyzer(string $product): string
    {
        return "The product monitor is analysed successfully.";
    }

    public function support(string $product): bool
    {
        return strtolower($product) === 'monitor';
    }
}