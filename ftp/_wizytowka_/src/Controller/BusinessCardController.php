<?php

namespace App\Controller;

use App\Form\BusinessCardForm;
use App\Form\FormBuilder\Field\Field;
use App\Response\JsonResponse;
use App\Response\Response;
use App\Service\BusinessCard\Model\BusinessCardModel;
use App\Service\HttpAuth\httpAuth;
use App\Service\Logger\LoggerException;
use App\Service\ServiceContainer\ServiceContainerException;

class BusinessCardController extends Controller
{
    /**
     * @param string $id
     * @return Response
     * @throws LoggerException
     * @throws ServiceContainerException
     */
    public function indexAction($id = 'current')
    {
        if (!$this->getAuthService()->hasAccess()) {
            return $this->getAuthService()->getAuthResponse();
        }

        $request = $this->getRequest();
        if ($request->isPost()) {
            return $this->postAction();
        }

        $id = $id ? $id : $this->getRequest()->getPost('id');
        if ($id === 'default') {
            $businessCardService = $this->getBusinessCardService()->getBusinessCardDefaultService();
        } else {
            $businessCardService = $this->getBusinessCardService()->getBusinessCardCurrentService();
        }

        $properties = $businessCardService->get()->getProperties();
        $properties['showRodoSection'] = true;

        $response = new JsonResponse($properties);

        return $response;
    }

    /**
     * @return JsonResponse
     * @throws ServiceContainerException
     */
    private function postAction()
    {
        $businessCardForm = new BusinessCardForm(array(
            'name' => '',
            'method' => 'post',
            'action' => ''
        ), $this->getFormBuilder());

        $data = $this->getRequest()->getPost();
        if (empty($data)) {
            $data = $this->prepareDataFromInput($this->getRequest()->getInput());
        }
        $businessCardForm->setData($data)->setDataToFields();
        if ($businessCardForm->isValid()) {
            $businessCardCurrentService = $this->getBusinessCardService()
                ->getBusinessCardCurrentService();
            $properties = array_merge($businessCardCurrentService->get()->getProperties(),
                $businessCardForm->getData());
            $businessCardCurrentService->save(new BusinessCardModel($properties));

            return new JsonResponse(array('success' => true));
        } else {
            $errors = array();
            /** @var Field $field */
            foreach (array_filter($businessCardForm->getFields(), function (Field $item) {
                return $item->hasErrors();
            }) as $field) {
                $errors[$field->getName()] = $field->getErrors();
            }

            $jsonResponse = new JsonResponse(array(
                'isError' => true,
                'errors' => $errors
            ));
            $jsonResponse->setCode(500);

            return $jsonResponse;
        }
    }

    /**
     * @return Response
     * @throws LoggerException
     * @throws ServiceContainerException
     */
    public function defaultAction()
    {
        return $this->indexAction('default');
    }

    /**
     * @return httpAuth
     * @throws ServiceContainerException
     */
    protected function getAuthService()
    {
        return $this->getService('httpAuth');
    }

    /**
     * @return JsonResponse|Response
     * @throws LoggerException
     * @throws ServiceContainerException
     */
    public function deactivateAction()
    {
        if (!$this->getAuthService()->hasAccess()) {
            return $this->getAuthService()->getAuthResponse();
        }

        $businessCardService = $this->getBusinessCardService()->getBusinessCardCurrentService();
        /** @var BusinessCardModel $businessCardModel */
        $businessCardModel = $businessCardService->get();
        $disabled = false;

        if ($businessCardModel->hasProperty('disabled')) {
            $disabled = $businessCardModel->getProperty('disabled');
        }

        $businessCardModel = $businessCardService->get();
        $businessCardModel->setProperty('disabled', !$disabled);
        $businessCardService->save($businessCardModel);

        return new JsonResponse(array('isError' => false));
    }

    private function prepareDataFromInput($input)
    {
        $array = json_decode($input);
        if (!$array || json_last_error()) {
            return array();
        }
        $data = array();
        foreach ($array as $item) {
            $data[$item->name] = $item->value;
        }
        return $data;
    }
}