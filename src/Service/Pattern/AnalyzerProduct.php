<?php

declare(strict_types=1);

namespace App\Service\Pattern;

use Exception;
use Symfony\Component\DependencyInjection\Attribute\AutowireIterator;

final class AnalyzerProduct
{
    public function __construct(
        #[AutowireIterator('app.analyse')]
        private iterable $analysers
    )
    {
    }

   public function analyzerProduct(string $product): string
   {
     foreach ($this->analysers as $analyser) {
        if ($analyser->support($product)) {
           return $analyser->analyzer($product);
        }
     }
     throw new Exception("Product not supported: ");
   }
}