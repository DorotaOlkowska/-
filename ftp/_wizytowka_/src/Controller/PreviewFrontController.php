<?php

namespace App\Controller;

use App\Response\ErrorResponse;
use App\Response\RedirectResponse;
use App\Response\Response;
use App\Service\Logger\LoggerLevel;

class PreviewFrontController extends IndexController
{
    public function updateAction($template = null)
    {
        if (!$this->previewEnabled($template)) {
            $this->getLogger()->log('preview mode is disabled', LoggerLevel::ERROR);
            return new ErrorResponse();
        }
        if (!$this->templateExists($template)) {
            $this->getLogger()->log('template not exists', LoggerLevel::ERROR);
            return new ErrorResponse(array('error' => 'template not exists'));
        }
        $request = $this->getRequest();
        if ($this->shouldRedirectToHttps() && !$request->isHttps()) {
            return new RedirectResponse($request->getSecureBaseUrl());
        }

        $businessCardModel = $this->getBusinessCardModel();
        $businessCardModel->setProperty('templateName', $template);
        $this->getBusinessCardService()->getBusinessCardCurrentService()->save($businessCardModel);

        $properties = $businessCardModel->getProperties();
        $properties['contactForm'] = $this->getContactForm($businessCardModel);
        $properties['user'] = $this->getRequest()->getEnv('USER');
        $this->handleContactForm($properties['contactForm'], $properties);

        return new Response(sprintf('%s/index.phtml', $properties['templateName']), $properties);
    }

    private function templateExists($template)
    {
        /** @var \App\Form\BusinessCardForm $businessCardForm */
        $businessCardForm = $this->getForm('\App\Form\BusinessCardForm');

        return in_array($template, $businessCardForm->getTemplateList());
    }
}
