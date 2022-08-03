<?php

namespace Mas\Whatsapp;

class Cron
{
    public function run() {
      $abandonedCart = new \Mas\Whatsapp\AbandonedCart();
      $abandonedCart->run();
    }
}