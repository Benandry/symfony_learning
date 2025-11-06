<?php

declare(strict_types=1);

namespace App\Service\Pattern;

class AnalyzerKeyborad implements AnalyzerInterface
{
   public function analyzer(string $product): string
   {
      return "The product keyboard is analysed successfully.";
   }

   public function support(string $product): bool
   {
      return strtolower($product) === 'keyborad';
   }
}