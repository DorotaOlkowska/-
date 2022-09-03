<?php

namespace App\Controller;

use App\Form\BusinessCardForm;
use App\Form\FormBuilder\Field\Field;
use App\Response\JsonResponse;
use App\Response\Response;
use App\Service\BusinessCard\Model\BusinessCardModel;

class BusinessCardFormController extends BusinessCardController
{
    /**
     * @return Response
     * @throws \App\Service\Logger\LoggerException
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    public function getAction()
    {
        if ($this->getService('request')->isPost()) {
            return $this->postAction();
        } else {
            return $this->formAction();
        }
    }

    /**
     * @return Response
     * @throws \App\Service\Logger\LoggerException
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    public function formAction()
    {
        if (!$this->getAuthService()->hasAccess()) {
            return $this->getAuthService()->getAuthResponse();
        }

        $businessCardForm = new BusinessCardForm(array(
            'name' => 'businessCardForm',
            'method' => 'post',
            'action' => ''
        ), $this->getFormBuilder());

        return new Response('form.phtml', array('form' => $businessCardForm));
    }

    /**
     * @return Response
     * @throws \App\Service\Logger\LoggerException
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    public function postAction()
    {
        if (!$this->getAuthService()->hasAccess()) {
            return $this->getAuthService()->getAuthResponse();
        }

        $businessCardForm = new BusinessCardForm(array(
            'name' => '',
            'method' => 'post',
            'action' => ''
        ), $this->getFormBuilder());

        if ($businessCardForm->isValid()) {
            $this->getBusinessCardService()
                ->getBusinessCardCurrentService()
                ->save(new BusinessCardModel($businessCardForm->getData()));

            return new JsonResponse(array(
                'isError' => false,
                'exceptionClass' => '',
                'exceptionMessage' => '',
                'errors' => array()
            ));
        } else {
            $errors = array();
            /** @var Field $field */
            foreach (array_filter($businessCardForm->getFields(), function (Field $item) {
                return $item->hasErrors();
            }) as $field) {
                $errors[$field->getName()] = $field->getErrors();
            }

            return new JsonResponse(array(
                'isError' => true,
                'exceptionClass' => 'Api_Service_Exception_InvalidFormData',
                'exceptionMessage' => '',
                'errors' => $errors
            ));
        }
    }
}