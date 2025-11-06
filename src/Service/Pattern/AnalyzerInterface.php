<?php

declare(strict_types=1);

namespace App\Service\Pattern;

use Symfony\Component\DependencyInjection\Attribute\AutoconfigureTag;

#[AutoconfigureTag('app.analyse')]
interface AnalyzerInterface
{
   public function analyzer(string $product): string;
   public function support(string $product): bool;
}