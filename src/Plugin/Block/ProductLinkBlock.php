<?php

namespace Drupal\product_page\Plugin\Block;

use Drupal\Core\Block\BlockBase;
use Drupal\product_page\Services\EndroidQRCodeGen;
use Drupal\Core\Plugin\ContainerFactoryPluginInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Provides a block for QR Code Display
 * 
 * @Block(
 * id = "block_product_link",
 * admin_label =@Translation("Product QR Code Link Block"),
 * )
 */

class ProductLinkBlock extends BlockBase implements ContainerFactoryPluginInterface
{

    protected $qrservice;

    public function __construct(array $configuration, $plugin_id, $plugin_definition, EndroidQRCodeGen $qrservice)
    {
        parent::__construct($configuration, $plugin_id, $plugin_definition);
        $this->qrservice= $qrservice;
    }

    public static function create(ContainerInterface $container, array $configuration, $plugin_id, $plugin_definition)
    {
            return new static(
                $configuration,
                $plugin_id,
                $plugin_definition,
                $container->get('product_page.qrcode'),
            );
    }

    public function build()
    {
        $build = [];
  
        $node = \Drupal::routeMatch()->getParameter('node');

        if ($node instanceof \Drupal\node\NodeInterface) {
            // $gen_qr = \Drupal::service('product_page.qrcode')->generateQrCode($node->field_product_buy_link->uri);
            $gen_qr = $this->qrservice->generateQrCode($node->field_product_buy_link->uri);
            $build = [
            '#theme' => 'generate_qrblock',
            '#gen_qr' => $gen_qr,
            ];

            return $build;
        }
    }

    public function getCacheMaxAge()
    {
         return 0;
    }

}
