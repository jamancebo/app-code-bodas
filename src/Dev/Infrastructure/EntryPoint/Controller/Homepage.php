<?php

declare(strict_types=1);

namespace DevBodas\Dev\Infrastructure\EntryPoint\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class Homepage extends AbstractController
{
    public function __invoke()
    {
        return $this->render('base.html.twig');
    }
}
