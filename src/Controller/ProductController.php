<?php 

namespace App\Controller;

use App\Service\Pattern\AnalyzerProduct;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProductController extends AbstractController
{
    #[Route('/product', name: 'app_product')]
    public function index(AnalyzerProduct $analyser ): Response
    {
        $products = ['Keyborad', 'Mouse', 'Monitor', 'CPU'];
        
        $analyses = [];
        foreach ($products as $product) {
          try {
           $analyse = $analyser->analyzerProduct($product);
          $analyses[] = [
            'product' => $product,
            'analyse' => $analyse,
            'status' => 'success'
          ];
          } catch (\Exception $e) {
           $analyses[] = [
            'product' => $product,
            'analyse' => $e->getMessage(),
            'status' => 'failed'
           ];
          }
        }

        return $this->render('product/index.html.twig', [
            'analyses' => $analyses,
        ]);
    }
}