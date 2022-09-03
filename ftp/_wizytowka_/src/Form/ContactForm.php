<?php

namespace App\Form;

use App\Form\FormBuilder\Field\Checkbox;
use App\Service\Logger\Logger;
use App\Service\Mailer\Mail;
use App\Service\BusinessCard\Model\BusinessCardModel;
use App\Form\FormBuilder\Field\Captcha;
use App\Form\FormBuilder\Field\Input;
use App\Form\FormBuilder\Field\Textarea;
use App\Service\Mailer\Mailer;

class ContactForm extends Form
{
    public function build()
    {
        $this->formBuilder->addField(new Input($this->getFieldName('email'), array(
            'label' => 'Adres e-mail',
            'placeholder' => 'Wpisz swój e-mail...',
            'class' => 'textInput',
            'type' => 'text'
        ), array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\NotEmpty', true),
                array('App\Form\FormBuilder\Field\Validator\EmailAddress', true)
            )
        )))->addField(new Input($this->getFieldName('phone'), array(
            'label' => 'Telefon',
            'placeholder' => 'Wpisz swój nr telefonu...',
            'class' => 'textInput',
            'type' => 'text'
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\NotEmpty', true),
                array('App\Form\FormBuilder\Field\Validator\Regex', true, array('pattern' => '/^([0-9] ?){9,}$/'))
            )
        )))->addField(new Input($this->getFieldName('subject'), array(
            'label' => 'Temat',
            'placeholder' => 'Podaj temat wiadomości...',
            'class' => 'textInput',
            'type' => 'text'
        ), array(
            'filters' => array('StringTrim'),
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\NotEmpty', true)
            )
        )))->addField(new Textarea($this->getFieldName('message'), array(
            'label' => 'Treść wiadomości',
            'placeholder' => 'Wpisz treść wiadomości...',
            'class' => 'require',
        ), array(
            'required' => true,
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\NotEmpty', true)
            )
        )))->addField(new Captcha($this->getFieldName('captcha'), array(
            'label' => 'Przepisz kod z obrazka widoczny poniżej:',
            'placeholder' => 'Kod...',
            'class' => 'require',
            'id' => 'captcha-input',
            'type' => 'text'
        ), array(
            'length' => 4,
            'request' => $this->formBuilder->getRequest()
        )))->addField(new Input($this->getFieldName('send'), array(
            'type' => 'submit',
            'label' => 'Wyślij',
            'class' => 'submit',
            'value' => ' Wyślij',
            'id' => 'send'
        )));

        if($this->getOption('rodoEnable'))
        {
            $this->formBuilder->addField(new Checkbox($this->getFieldName('rodoRegulations'), array(
                'type' => 'checkbox',
                'class' => 'checkbox',
                'id' => 'rodoRegulations',
                'style' => 'float: left'
            ), array(
                'label' => $this->getOption('rodoValue'),
                'validators' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )));
        }
    }

    public function getName()
    {
        return $this->attributes['name'];
    }

    public function getAction()
    {
        return $this->attributes['action'];
    }

    public function getMethod()
    {
        return $this->attributes['method'];
    }

    /**
     * @param BusinessCardModel $businessCardModel
     * @param Mailer $mailer
     * @param Logger $logger
     * @return bool
     * @throws \App\Service\Logger\LoggerException
     */
    public function handle(BusinessCardModel $businessCardModel, Mailer $mailer, Logger $logger)
    {
        $mail = new Mail();
        $mail->setMessage(sprintf('Telefon: %s</br>Wiadomość:</br>%s', $this->data['phone'], $this->data['message']));
        $mail->setFromAddress($this->data['email']);
        $mail->setSubject($this->data['subject']);
        try
        {
            $mail->setToAddress($businessCardModel->getProperty('clientEmail'));
            $mailer->send($mail);

            return true;
        }
        catch(\Exception $e)
        {
            $logger->logException($e);

            return false;
        }
    }
}