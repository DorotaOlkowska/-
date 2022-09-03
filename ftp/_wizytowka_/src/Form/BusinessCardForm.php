<?php

namespace App\Form;

use App\Form\FormBuilder\Field\Input;
use App\Form\FormBuilder\Field\Textarea;
use App\Service\Request\Request;
use App\Service\ServiceContainer\ServiceContainerException;
use RecursiveDirectoryIterator;
use SplFileInfo;

class BusinessCardForm extends Form
{
    public function build()
    {
        $this->formBuilder->addField(new Input('templateName', array(
            'type' => 'radio',
            'class' => 'radio',
        ), array(
            'validators' => array(
                array(
                    'App\Form\FormBuilder\Field\Validator\InArray',
                    true,
                    array('array' => array_values($this->getTemplateListWithImages()))
                )
            ),
        )))->addField(new Input('basicInfoEnable', array(
            'type' => 'checkbox',
            'id' => 'basicInfoEnable',
            'data-onchange' => 'toggleFields',
            'onclick' => 'event.preventDefault();'
        )))->addField(new Input('detailsDataEnable', array(
            'type' => 'checkbox',
            'id' => 'detailsDataEnable',
            'data-onchange' => 'toggleFields',
            'onclick' => 'event.preventDefault();',
        )))->addField(new Input('correspondenceDataEnable', array(
            'type' => 'checkbox',
            'id' => 'correspondenceDataEnable',
            'data-onchange' => 'toggleFields',
            'onclick' => 'event.preventDefault();',
        )))->addField(new Input('mapEnable', array(
            'type' => 'checkbox',
            'id' => 'mapEnable',
            'data-onchange' => 'toggleFields',
        )))->addField(new Input('formEnable', array(
            'type' => 'checkbox',
            'id' => 'formEnable',
            'data-onchange' => 'toggleFields',
            'onclick' => 'event.preventDefault();',
        )))->addField(new Input('rodoEnable', array(
            'type' => 'checkbox',
            'id' => 'formEnable',
            'data-onchange' => 'toggleFields',
            'onclick' => 'event.preventDefault();',
        )))->addField(new Input('socialMediaEnable', array(
            'type' => 'checkbox',
            'id' => 'socialMediaEnable',
            'data-onchange' => 'toggleFields',
        )))->addField(new Input('offerEnable', array(
            'type' => 'checkbox',
            'id' => 'offerEnable',
            'data-onchange' => 'toggleFields',
        )))->addField(new Input('forceHttps', array(
            'type' => 'checkbox',
            'id' => 'forceHttps',
            'data-onchange' => 'toggleFields',
        )))->addField(new Input('businessCardTitle', array(
            'id' => 'businessCardTitle',
            'class' => 'text',
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\NotEmpty', true),
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1))
            )
        )))->addField(new Input('basicInfoSectionTitle', array(
            'id' => 'basicInfoSectionTitle',
            'class' => 'text',
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\NotEmpty', true),
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1))
            ),
            'validatorsDependency' => array(
                'basicInfoEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Textarea('rodoValue', array(
            'id' => 'rodoValue',
            'class' => 'text',
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\NotEmpty', true),
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 4096, 'min' => 1))
            ),
            'validatorsDependency' => array(
                'rodoEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Textarea('basicInfoDescription', array(
            'id' => 'basicInfoDescription',
            'class' => 'text',
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\NotEmpty', true),
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 4096, 'min' => 1))
            ),
            'validatorsDependency' => array(
                'basicInfoEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('detailsDataSectionTitle', array(
            'id' => 'detailsDataSectionTitle',
            'class' => 'text',
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\NotEmpty', true),
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1))
            ),
            'validatorsDependency' => array(
                'detailsDataEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('detailsDataAddressEnable', array(
            'type' => 'checkbox',
            'id' => 'detailsDataAddressEnable',
        )))->addField(new Input('detailsDataAddressStreet', array(
            'id' => 'detailsDataAddressStreet',
            'class' => 'text',
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'detailsDataAddressEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('detailsDataAddressLocalNumber', array(
            'id' => 'detailsDataAddressLocalNumber',
            'class' => 'text',
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'detailsDataAddressEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('detailsDataAddressZipCode', array(
            'id' => 'detailsDataAddressZipCode',
            'class' => 'text',
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'detailsDataAddressEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('detailsDataAddressCity', array(
            'id' => 'detailsDataAddressCity',
            'class' => 'text',
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'detailsDataAddressEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('detailsDataPhoneEnable', array(
            'type' => 'checkbox',
            'id' => 'detailsDataPhoneEnable',
        )))->addField(new Input('detailsDataPhoneValue', array(
            'id' => 'detailsDataPhoneValue',
            'class' => 'text',
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'detailsDataPhoneEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('detailsDataEmailEnable', array(
            'type' => 'checkbox',
            'id' => 'detailsDataEmailEnable',
        )))->addField(new Input('detailsDataEmailValue', array(
            'id' => 'detailsDataEmailValue',
            'class' => 'text',
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
                array('App\Form\FormBuilder\Field\Validator\EmailAddress', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'detailsDataEmailEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('detailsDataNipEnable', array(
            'type' => 'checkbox',
            'id' => 'detailsDataNipEnable',
        )))->addField(new Input('detailsDataNipValue', array(
            'type' => 'checkbox',
            'id' => 'detailsDataNipValue',
            'class' => 'text',
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'detailsDataNipEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('detailsDataLinkEnable', array(
            'type' => 'checkbox',
            'id' => 'detailsDataLinkEnable',
        )))->addField(new Input('correspondenceDataSectionTitle', array(
            'type' => 'checkbox',
            'id' => 'correspondenceDataSectionTitle',
            'class' => 'text',
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'correspondenceDataEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('correspondenceDataAddressEnable', array(
            'type' => 'checkbox',
            'id' => 'correspondenceDataAddressEnable',
        )))->addField(new Input('correspondenceDataAddressStreet', array(
            'type' => 'checkbox',
            'id' => 'correspondenceDataAddressStreet',
            'class' => 'text',
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'correspondenceDataAddressEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('correspondenceDataAddressLocalNumber', array(
            'type' => 'checkbox',
            'id' => 'correspondenceDataAddressLocalNumber',
            'class' => 'text',
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'correspondenceDataAddressEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('correspondenceDataAddressZipCode', array(
            'type' => 'checkbox',
            'id' => 'correspondenceDataAddressZipCode',
            'class' => 'text',
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'correspondenceDataAddressEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('correspondenceDataAddressCity', array(
            'type' => 'checkbox',
            'id' => 'correspondenceDataAddressCity',
            'class' => 'text',
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'correspondenceDataAddressEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('correspondenceDataPhoneEnable', array(
            'type' => 'checkbox',
            'id' => 'correspondenceDataPhoneEnable',
        )))->addField(new Input('mapSectionTitle', array(
            'type' => 'checkbox',
            'id' => 'mapSectionTitle',
            'class' => 'text',
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'mapEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('mapApiKeyEnable', array(
            'type' => 'checkbox',
            'id' => 'mapApiKeyEnable',
        )))->addField(new Input('mapApiKey', array(
            'id' => 'mapApiKey',
            'rel' => 'mapEnable',
            'readonly' => 'true'
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'mapApiKeyEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('mapLat', array(
            'id' => 'mapLat',
            'rel' => 'mapEnable',
            'readonly' => 'true'
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024)),
            )
        )))->addField(new Input('mapLng', array(
            'id' => 'mapLng',
            'rel' => 'mapEnable',
            'readonly' => 'true'
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024)),
            )
        )))->addField(new Input('formSectionTitle', array(
            'id' => 'formSectionTitle',
            'rel' => 'formEnable',
            'class' => 'text'
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'formEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('clientEmail', array(
            'id' => 'clientEmail',
            'rel' => 'formEnable',
            'class' => 'text'
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'formEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('socialMediaFacebookEnable', array(
            'type' => 'checkbox',
            'id' => 'socialMediaFacebookEnable',
            'class' => 'checkbox',
            'data-onchange' => 'toggleFields',
        )))->addField(new Input('socialMediaFacebookUrl', array(
            'id' => 'socialMediaFacebookUrl',
            'rel' => 'socialMediaFacebookEnable',
            'class' => 'text'
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'socialMediaFacebookEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('socialMediaInstagramEnable', array(
            'type' => 'checkbox',
            'id' => 'socialMediaInstagramEnable',
            'class' => 'checkbox',
            'data-onchange' => 'toggleFields',
        )))->addField(new Input('socialMediaInstagramUrl', array(
            'id' => 'socialMediaInstagramUrl',
            'rel' => 'socialMediaInstagramEnable',
            'class' => 'text'
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'socialMediaInstagramEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('socialMediaGooglePlusEnable', array(
            'type' => 'checkbox',
            'id' => 'socialMediaGooglePlusEnable',
            'class' => 'checkbox',
            'data-onchange' => 'toggleFields',
        )))->addField(new Input('socialMediaGooglePlusUrl', array(
            'id' => 'socialMediaGooglePlusUrl',
            'rel' => 'socialMediaGooglePlusEnable',
            'class' => 'text'
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'socialMediaGooglePlusEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('socialMediaTwitterEnable', array(
            'type' => 'checkbox',
            'id' => 'socialMediaTwitterEnable',
            'class' => 'checkbox',
            'data-onchange' => 'toggleFields',
        )))->addField(new Input('socialMediaTwitterUrl', array(
            'id' => 'socialMediaTwitterUrl',
            'rel' => 'socialMediaTwitterEnable',
            'class' => 'text'
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'socialMediaTwitterEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('socialMediaYouTubeEnable', array(
            'type' => 'checkbox',
            'id' => 'socialMediaYouTubeEnable',
            'class' => 'checkbox',
            'data-onchange' => 'toggleFields',
        )))->addField(new Input('socialMediaYouTubeUrl', array(
            'id' => 'socialMediaYouTubeUrl',
            'rel' => 'socialMediaYouTubeEnable',
            'class' => 'text'
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'socialMediaYouTubeEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('socialMediaLinkedInEnable', array(
            'type' => 'checkbox',
            'class' => 'checkbox',
            'data-onchange' => 'toggleFields',
            'id' => 'socialMediaLinkedInEnable',
        )))->addField(new Input('socialMediaLinkedInUrl', array(
            'id' => 'socialMediaLinkedInUrl',
            'rel' => 'socialMediaLinkedInEnable',
            'class' => 'text'
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'socialMediaLinkedInEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('offerSectionTitle', array(
            'id' => 'offerSectionTitle',
            'rel' => 'formEnable',
            'class' => 'text'
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'offerEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Textarea('offerContent', array(
            'id' => 'offerContent',
            'rel' => 'offerEnable',
            'class' => 'text',
            'COLS' => '40'
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 8192, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'offerEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('detailsDataLinkValue', array(
            'id' => 'detailsDataLinkValue',
            'rel' => 'formEnable',
            'class' => 'text'
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'validatorsDependency' => array(
                'detailsDataLinkEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('correspondenceDataPhoneValue', array(
            'id' => 'correspondenceDataPhoneValue',
            'rel' => 'correspondenceDataPhoneEnable',
            'class' => 'text'
        ), array(
            'validators' => array(
                array('App\Form\FormBuilder\Field\Validator\StrLen', true, array('max' => 1024, 'min' => 1)),
            ),
            'correspondenceDataAddressEnable' => array(
                'correspondenceDataPhoneEnable' => array(
                    array('App\Form\FormBuilder\Field\Validator\IsTrue', true)
                )
            )
        )))->addField(new Input('showRodoSection', array(
            'id' => 'showRodoSection',
            'type' => 'hidden'
        )));
    }

    public function getTemplateList()
    {
        $templateList = array();
        /** @var SplFileInfo $templateName */
        foreach((new RecursiveDirectoryIterator($this->formBuilder->getServiceContainer()->getService('config')->resourcesPath,
            RecursiveDirectoryIterator::SKIP_DOTS)) as $templateName
        )
        {
            if($templateName->isDir())
            {
                $templateList[$templateName->getFilename()] = $templateName->getFilename();
            }
        }

        return $templateList;
    }

    /**
     * @return array
     * @throws ServiceContainerException
     */
    public function getTemplateListWithImages()
    {
        $templateList = $this->getTemplateList();

        ksort($templateList, SORT_ASC);

        return $templateList;
    }

    /**
     * @throws ServiceContainerException
     */
    protected function applyDataFromRequest()
    {
        /** @var Request $request */
        $request = $this->formBuilder->getRequest();
        $this->setData($this->filterFields($this->inputToArray($request->getInput())))
            ->setDataToFields();
    }

    private function filterFields($array)
    {
        $fields = array_keys($this->formBuilder->getFields());

        foreach($array as $key => $value)
        {
            if(!in_array($key, $fields))
            {
                unset($array[$key]);
            }
        }

        return $array;
    }


    /**
     * @param $jsonString
     * @return array
     */
    private function inputToArray($jsonString)
    {
        $jsonString = $this->decodeInput($jsonString);
        $json = json_decode($jsonString, true);
        $array = array();

        if($json)
        {
            foreach($json as $item)
            {
                $array[$item['name']] = $item['value'];
            }
        }

        return $array;
    }

    private function decodeInput($json)
    {
      return  preg_replace_callback(
  '~\\\u[a-d0-9]{4}~iu',
          function($found){
            if(json_decode('"'.$found[0].'"')){
              return $found[0];
            }
            return "";  //or "?"
          },
          $json
        );
    }

    public function getFieldName($name)
    {
        return $name;
    }
}