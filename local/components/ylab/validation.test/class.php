<?php
namespace YLab\Validation\Components;
use Bitrix\Main,
    Bitrix\Iblock, CModule, CIBlock, CIBlockElement, CIBlockPropertyEnum;
use Bitrix\Main\UserTable;
use YLab\Validation\ComponentValidation;
use YLab\Validation\ValidatorHelper;

/**
 * Class ValidationTestComponent
 * Компонент пример использования модуля ylab.validation в разработке
 *
 * @package YLab\Validation\Components
 */
class ValidationTestComponent extends ComponentValidation
{
    /**
     * ValidationTestComponent constructor.
     * @param \CBitrixComponent|null $component
     * @param string $sFile
     * @throws \Bitrix\Main\IO\InvalidPathException
     * @throws \Bitrix\Main\SystemException
     * @throws \Exception
     */
    public function __construct(\CBitrixComponent $component = null, $sFile = __FILE__)
    {
        parent::__construct($component, $sFile);
    }






    /**
     * @return mixed|void
     * @throws \Exception
     */
    public function executeComponent()
    {
        /**
         * При необходимости в компоненте можно реализовать дополнительные правила валидации, например:
         */

        /**
         * Непосредственно валидация и действия при успехе и фейле
         */
        if ($this->oRequest->isPost() && check_bitrix_sessid()) {
            $this->oValidator->setData($this->oRequest->toArray());
            //var_dump($this->oRequest->toArray());
            $arrData=$this->oRequest->toArray();
            if ($this->oValidator->passes()) {
                $this->arResult['SUCCESS'] = true;
                $this->set_iblock($arrData);
            } else {
                $this->arResult['ERRORS'] = ValidatorHelper::errorsToArray($this->oValidator);
            }
        }

        $this->includeComponentTemplate();

    }

    /**
     * @return array
     */
    protected function rules()
    {

        /**
         * Перед формированием массива правил валидации мы можем вытащить все необходимые данные из различных источников
         */
        return [
            'city' => 'required|numeric',
            'user_name' => 'required',
            'date' => 'required|date_format:d.m.Y',
            'mobile' => 'required|regex:/(\+7)[0-9]{10}/'
        ];
    }

    /**
     * @param $arrData
     * Массив содержащий данные записанные в форму
     *
     */
    public function set_iblock($arrData)
    {

        echo $arrData['user_name']." ".$arrData['city']." ".$arrData['date']." ".$arrData['mobile'];

        /**
         * Метод класса CModule
         * проверяем установлен ли модуль, если да то подключаем его
         */
        if (CModule::IncludeModule('iblock')) {


            $sBlock_name = 'new_users_block';


            /**
             * Getlist
             *
             * Возвращает список информационных блоков по фильтру arFilter отсортированный в порядке arOrder
             * Получаем ИД информационного блока
             */
            $resc = CIBlock::GetList(Array(), Array('TYPE' => 'users_block', 'SITE_ID' => SITE_ID, 'CODE' => $sBlock_name), false);
            //var_dump($resc);
            while($arrc = $resc->Fetch()){
                $s_IdBlock=$arrc["ID"];}
            //var_dump($s_IdBlock);
            /**
             * Новый объект класса CIBlockElement
             *
             * Осуществляем создание нового элемента информационного блока 'new_users_block'
             */
            $el = new CIBlockElement;

            $PROP = array();
            //$PROP['ID'] = 7;
            $PROP['NAME'] = $arrData['user_name'];
            $PROP['DateBirthDay']= $arrData['date'];
            $PROP['Phone'] = $arrData['mobile'];
            
            $PROP['City'] = Array("VALUE" => $arrData['city'] );

            global $USER;
            $arLoadProductArray = Array(
                "MODIFIED_BY"    => $USER->GetID(),
                "IBLOCK_SECTION_ID" => false,
                "IBLOCK_ID"      => (int)$s_IdBlock,
                "PROPERTY_VALUES"=> $PROP,
                "NAME"           => "Пользователь",
                "ACTIVE"         => "Y",           // активен
                "IBLOCK_CODE"    => $sBlock_name

            );

            if($PRODUCT_ID = $el->Add($arLoadProductArray))
                echo "New ID: ".$PRODUCT_ID;
            else
                echo "Error: ".$el->LAST_ERROR;




        }
    }

}