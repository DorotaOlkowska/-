<?php

namespace App\Controller;

use App\Form\BusinessCardForm;
use App\Form\ContactForm;
use App\Response\ErrorResponse;
use App\Response\JsonResponse;
use App\Response\RedirectResponse;
use App\Response\Response;
use App\Service\BusinessCard\Model\BusinessCardModel;
use App\Service\Logger\LoggerLevel;
use App\Service\Mailer\Mailer;
use App\View\ViewExtensions\Extensions\MapExtension;
use App\View\ViewExtensions\Extensions\ResourceExtension;

class IndexController extends Controller
{
    /**
     * @return RedirectResponse|Response
     * @throws \App\Service\Logger\LoggerException
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    public function indexAction()
    {
        if ($this->isDisabled()) {
            return new Response('blackdown.phtml');
        }

        $request = $this->getRequest();

        if ($this->shouldRedirectToHttps() && !$request->isHttps()) {
            return new RedirectResponse($request->getSecureBaseUrl());
        }

        $businessCardModel = $this->getBusinessCardModel();
        $properties = $businessCardModel->getProperties();
        $properties['contactForm'] = $this->getContactForm($businessCardModel);
        $properties['user'] = $this->getRequest()->getEnv('USER');

        $this->handleContactForm($properties['contactForm'], $properties);

        if ($this->previewEnabled()) {
            if (!$this->previewWasInitialized()) {
                $this->getLogger()->log('Preview mode wasn\'t initialized!', LoggerLevel::ERROR);
                return new ErrorResponse();
            }
            $expireDate = new \DateTime();
            $expireDate->setTimestamp($businessCardModel->getProperty('expireDate'));
            if ($expireDate <= new \DateTime('now')) {
                $this->getLogger()->log(sprintf('Preview expired as %s', $expireDate->format('Y-m-d H:i:s')));
                return new ErrorResponse();
            }
            $this->view->addExtension(new ResourceExtension($this->context));

            return new Response('../preview.phtml', $properties);
        }
        return new Response(sprintf('%s/index.phtml', $properties['templateName']), $properties);
    }

    /**
     * @param null $templateName
     * @return RedirectResponse|Response
     * @throws \App\Service\Logger\LoggerException
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    public function templateAction($templateName = null)
    {
        if ($this->isDisabled()) {
            return new Response('blackdown.phtml');
        }

        $request = $this->getRequest();

        if ($this->shouldRedirectToHttps() && !$request->isHttps()) {
            return new RedirectResponse($request->getSecureBaseUrl());
        }

        if (!$this->previewEnabled()) {
            return new Response('blackdown.phtml');
        }

        $businessCardModel = $this->getBusinessCardModel();
        $properties = $businessCardModel->getProperties();
        $properties['contactForm'] = $this->getContactForm($businessCardModel);
        $properties['user'] = $this->getRequest()->getEnv('USER');
        $properties['templateName'] = $templateName;

        $this->handleContactForm($properties['contactForm'], $properties);

        return new Response(sprintf('%s/index.phtml', $properties['templateName']), $properties);
    }

    /**
     * @param BusinessCardModel $businessCardModel
     * @return ContactForm
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     * @throws \Exception
     */
    protected function getContactForm(BusinessCardModel $businessCardModel)
    {
        $contactForm = new ContactForm(array(
            'name' => 'contactForm',
            'method' => 'post',
            'action' => ''
        ), $this->getFormBuilder(),
            array(
                'rodoEnable' => $this->getBusinessCardModelProperty($businessCardModel, 'rodoEnable'),
                'rodoValue' => $this->getBusinessCardModelProperty($businessCardModel, 'rodoValue')
            )
        );

        return $contactForm;
    }

    private function getBusinessCardModelProperty(BusinessCardModel $businessCardModel, $propertyName)
    {
        if ($businessCardModel->hasProperty($propertyName)) {
            return $businessCardModel->getProperty($propertyName, null);
        }

        return null;
    }

    /**
     * @return Response
     * @throws \App\Service\Logger\LoggerException
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    public function isNewAction()
    {
        if (!$this->getAuthService()->hasAccess()) {
            return $this->getAuthService()->getAuthResponse();
        }

        return new JsonResponse(array('isNew' => true));
    }

    /**
     * @param ContactForm $contactForm
     * @param array $properties
     * @throws \App\Service\Logger\LoggerException
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    protected function handleContactForm(ContactForm &$contactForm, array &$properties)
    {
        $properties['showContactForm'] = true;
        $properties['contactFormErrors'] = false;
        $properties['showSuccessConfirmation'] = false;

        if ($this->getRequest()->isPost()) {
            if ($contactForm->isValid()) {
                if ($contactForm->handle($this->getBusinessCardModel(), $this->getMailer(),
                    $this->getService('logger'))) {
                    $properties['showContactForm'] = false;
                    $properties['showSuccessConfirmation'] = true;
                    $properties['contactFormErrors'] = false;
                } else {
                    $properties['showContactForm'] = true;
                    $properties['contactFormErrors'] = true;
                }
            } else {
                $properties['contactFormErrors'] = true;
            }
        }
    }

    public function mapAction()
    {
        if ($this->isDisabled()) {
            return new RedirectResponse('/');
        }

        $request = $this->getRequest();
        if ($this->shouldRedirectToHttps() && !$request->isHttps()) {
            return new RedirectResponse(
                sprintf('https://%s%s', $request->getHttpHost(), $request->getRequestUri())
            );
        }

        $this->view->addExtension(new MapExtension());

        if ($this->previewEnabled())
        {
            $properties = $this->getBusinessCardService()->getBusinessCardDefaultService()->get()->getProperties();
        }
        else
        {
            $properties = $this->getBusinessCardModel()->getProperties();
        }

        $properties['user'] = isset($_ENV['USER']) ? $_ENV['USER'] : null;

        return new Response(sprintf('%s/map.phtml', $properties['templateName']), $properties);
    }

    /**
     * @return BusinessCardModel
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    protected function getBusinessCardModel()
    {
        return $this->getBusinessCardService()->getBusinessCardCurrentService()->get();
    }


    /**
     * @return Mailer
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    protected function getMailer()
    {
        return $this->serviceContainer->getService('mailer');
    }

    /**
     * @return bool
     */
    protected function shouldRedirectToHttps()
    {
        try {
            return (bool)$this->getBusinessCardModel()->getProperty('forceHttps');
        } catch (\Exception $e) {
            return false;
        }
    }

    protected function isDisabled()
    {
        try {
            return (bool)$this->getBusinessCardModel()->getProperty('disabled');
        } catch (\Exception $e) {
            return false;
        }
    }

    /**
     * @return JsonResponse
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    public function templatesAction()
    {
        if (!$this->getAuthService()->hasAccess()) {
            return $this->getAuthService()->getAuthResponse();
        }

        $businessCardForm = new BusinessCardForm(array(), $this->getFormBuilder());

        return new JsonResponse(array(
            'isError' => false,
            'exceptionClass' => '',
            'exceptionMessage' => '',
            'errors' => '',
            'data' => array(
                'templateList' => array_keys($businessCardForm->getTemplateListWithImages())
            )
        ));
    }

    private function previewWasInitialized()
    {
        return $this->getSession()->get('previewInitialized');
    }
}