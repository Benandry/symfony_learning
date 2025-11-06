<?php
declare(strict_types=1);

namespace App\Service\Pattern;

final class AnalyzerMouse implements AnalyzerInterface
{
   public function analyzer(string $product): string
   {
      return "The product mouse is analysed successfully.";
   }

   public function support(string $product): bool
   {
      return strtolower($product) === 'mouse';
   }
}