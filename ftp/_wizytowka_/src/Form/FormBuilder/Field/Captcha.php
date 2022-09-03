<?php

namespace App\Form\FormBuilder\Field;

use App\Lib\Figlet\Figlet;
use App\Service\Request\Request;

class Captcha extends Input
{
    /** @var Request $request */
    private $request;

    public function __construct($name, $attributes, array $options = array())
    {
        parent::__construct($name, $attributes, $options);

        $this->request = $options['request'];

        $this->options['validators'] = array(
            array(
                'App\Form\FormBuilder\Field\Validator\CaptchaValidator',
                true,
                array('code' => $this->request->getSession()->get($this->getName()))
            ),
            array('App\Form\FormBuilder\Field\Validator\NotEmpty', true)
        );
    }

    public function render()
    {
        $secretCode = $this->generateCode($this->options['length']);
        $this->request->getSession()->set($this->getName(), $secretCode);
        $code = $this->getRenderedFiglet($secretCode);

        return sprintf('<pre>%s</pre> %s %s', $code, $this->renderViewHelper(), $this->renderErrors());
    }

    public function validated()
    {
        parent::validated();

        $this->request->getSession()->clear($this->getName());
        $this->setValue(null);
    }

    private function generateCode($length)
    {
        $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $code = '';

        for ($i = 0; $i < $length; $i++) {
            $code .= $characters[rand(0, strlen($characters) - 1)];
        }

        return $code;
    }

    private function getRenderedFiglet($code)
    {
        $figlet = new Figlet();
        return $figlet->setFont('big')
            ->render($code);
    }
}