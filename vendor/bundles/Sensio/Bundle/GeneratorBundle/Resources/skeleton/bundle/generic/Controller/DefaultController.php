<?php

namespace {{ namespace }}\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
{% if 'annotation' == format -%}
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
{%- endif %}


class DefaultController extends Controller
{
    {% if 'annotation' == format -%}
    /**
     * @Route("/")
     * @Template
     */
    {%- endif %}

    public function indexAction()
    {
        {% if 'annotation' != format -%}
        return $this->render('{{ bundle }}:Default:index.html.twig');
        {%- else -%}
        return array();
        {%- endif %}

    }
}
