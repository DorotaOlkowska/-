<?php

namespace App\Controller;

use App\Response\RedirectResponse;
use App\Response\Response;
use App\Service\BusinessCard\Model\BusinessCardModel;
use App\Service\BusinessCardUrlCrypt\BusinessCardUrlCryptService;
use App\Service\Logger\LoggerLevel;

class PreviewController extends Controller
{
    public function indexAction()
    {
        if (!$this->previewEnabled()) {
            $this->getLogger()->log('Preview is disabled', LoggerLevel::ERROR);
            return new RedirectResponse('/');
        }

        if (!$this->isValid()) {
            $this->getLogger()->log('empty hash', LoggerLevel::ERROR);
            return new RedirectResponse('/');
        }

        $businessCardCurrentService = $this->getBusinessCardService()->getBusinessCardCurrentService();
        $defaultData = $this->getDefaultData();
        $previewData = array_merge($defaultData, $this->getPreviewData());
        $this->setUpExpireDate($previewData);
        $businessCardModel = new BusinessCardModel($previewData);
        $businessCardCurrentService->save($businessCardModel);
        $this->getSession()->set('previewInitialized', true);

        return new RedirectResponse('/');
    }

    public function setUpExpireDate(&$previewData)
    {
        if (!isset($previewData['expireDate']) || !$previewData['expireDate']) {
            $expireDate = new \DateTime();
            $expireDate->modify('+ 30 day');
            $previewData['expireDate'] = $expireDate->getTimestamp();
        }
    }

    public function getPreviewLinkAction($requestParameter = array())
    {
        if (!$this->previewEnabled()) {
            return new RedirectResponse('/');
        }

        if (!$this->getAuthService()->hasAccess()) {
            return $this->getAuthService()->getAuthResponse();
        }
        $clientData = $this->getRequest()->getPost();
        $parameters = array();
        if (is_array($requestParameter)) {
            $parameters = $requestParameter;
        } else {
            parse_str(parse_url($requestParameter, PHP_URL_QUERY), $parameters);
        }
        $clientData = array_merge($clientData, $parameters);
        $businessCardUrlCryptService = $this->getBusinessCardUrlCryptService();
        $hash = $businessCardUrlCryptService->encrypt(json_encode($clientData));
        $url = $this->getService('router')
            ->getControllerActionRoute('\App\Controller\PreviewController', 'indexAction', array(
                '{hash}' => urlencode($hash)
            ));

        return new Response('../response.phtml', array('response' => $this->getFullUrl($url)));
    }

    private function getHash()
    {
        return $this->getRequest()->getQuery('hash');
    }

    private function isValid()
    {
        $hash = $this->getRequest()->getQuery('hash');

        return !empty($hash);
    }

    /**
     * @return BusinessCardUrlCryptService|\App\Service\ServiceInterface
     * @throws \App\Service\ServiceContainer\ServiceContainerException
     */
    private function getBusinessCardUrlCryptService()
    {
        return $this->getService('BusinessCardUrlCrypt');
    }

    private function getDefaultData()
    {
        return $this->getBusinessCardService()->getBusinessCardDefaultService()->get()->getProperties();
    }

    private function getPreviewData()
    {
        $previewData = json_decode($this->getBusinessCardUrlCryptService()->decrypt($this->getHash()), true);
        $this->decodeUrlData($previewData);
        return $previewData ? $previewData : array();
    }

    private function decodeUrlData(&$previewData)
    {
        foreach ($previewData as $key => &$value) {
            $value = urldecode($value);
        }
    }

    private function getFullUrl($url)
    {
        $request = $this->getRequest();

        return sprintf("http://%s%s", $request->getServer('HTTP_HOST'), $url);
    }
}
