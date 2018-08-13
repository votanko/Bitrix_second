<?php

class UsersListComponent extends \CBitrixComponent
{
    /**
     * \CBitrixComponent executeComponent
     * перекрывающий метод
     */
    public function executeComponent()
    {
        /**@global $APPLICATION
         */
        global $APPLICATION;

        $APPLICATION->RestartBuffer();
        $this->arResult = $this->getUsersList();

        $this->includeComponentTemplate();
    }

    /**
     * @return string
     *
     * Возвращает строку,содержащую элементы инфоблока и их св-ва
     */
    protected function getUsersList()
    {
        $sResult = "";
        if (CModule::IncludeModule('iblock')) {}
            $iBlock = 1;
            $arSelect = Array("ID", "IBLOCK_ID", "NAME", "DATE_ACTIVE_FROM", "PROPERTY_*");
            $arFilter = array("IBLOCK_ID" => $iBlock, "ACTIVE_DATE" => "Y", "ACTIVE" => "Y");
            $res = CIBlockElement::GetList(Array(), $arFilter, false, false, $arSelect);
            while ($ob = $res->GetNextElement()) {
                $arFields = $ob->GetFields();
                $sResult = $sResult . "ID element: " . $arFields['ID'] . ". User: " . $arFields['NAME'];
                $arProps = $ob->GetProperties();
                $sResult = $sResult . "<br>ID User: " . $arProps['ID']['VALUE'] . ". Name user: " . $arProps['NAME']['VALUE'] . "<br>";
            





            $iblocktype = "newblock_users";
            $obIBlockType =  new CIBlockType;
            $arFields = Array(
                "ID"=>$iblocktype,
                "SECTIONS"=>"Y",
                "LANG"=>Array(
                    "ru"=>Array(
                        "NAME"=>"Тип блока пользователей",
                    )
                )
            );




            $res = $obIBlockType->Add($arFields);
            if(!$res){
                $error = $obIBlockType->LAST_ERROR;
                echo $error.'ololo';
            } else {
                $obIblock = new CIBlock;
                $arFields = Array(
                    "NAME"=> "Пользователи вебинар 2",
                    "ACTIVE" => "Y",
                    "IBLOCK_TYPE_ID" => $iblocktype,
                    "SITE_ID" => 's1' //Массив ID сайтов
                );
                $newIblockID = $obIblock->Add($arFields);
            }
            var_dump($obIblock->LAST_ERROR);
            var_dump($newIblockID);
            //var_dump($ID);

        ///////////////////////////////////////Add Property

            $ibp = new CIBlockProperty;

            $arFields = Array(
                "NAME" => "ID",
                "ACTIVE" => "Y",
                "SORT" => 500, // Сортировка
                "CODE" => "ID",
                "PROPERTY_TYPE" => "N", // Список


                "IBLOCK_ID" => $newIblockID
            );
            $propId = $ibp->Add($arFields);
            if ($propId > 0)
            {
                $arFields["ID"] = $propId;
                $arCommonProps[$arFields["CODE"]] = $arFields;
                echo "&mdash; Добавлено свойство ".$arFields["NAME"]."<br />";
            }
            else
                echo "&mdash; Ошибка добавления свойства ".$arFields["NAME"]."<br />";
////////////////////Добавляем ФИО
            $arFields = Array(
                "NAME" => "ФИО",
                "ACTIVE" => "Y",
                "SORT" => 500, // Сортировка
                "CODE" => "NAME",
                "PROPERTY_TYPE" => "S", // Список


                "IBLOCK_ID" => $newIblockID
            );
            $propId = $ibp->Add($arFields);
            if ($propId > 0)
            {
                $arFields["ID"] = $propId;
                $arCommonProps[$arFields["CODE"]] = $arFields;
                echo "&mdash; Добавлено свойство ".$arFields["NAME"]."<br />";
            }
            else
                echo "&mdash; Ошибка добавления свойства ".$arFields["NAME"]."<br />";

            var_dump($ibp->LAST_ERROR);
/////////////////////////// Дата рождентия
            $arFields = Array(
                "NAME" => "Дата рождения",
                "ACTIVE" => "Y",
                "SORT" => 500, // Сортировка
                "CODE" => "DateBirthDay",
                "PROPERTY_TYPE" => "S",


                "IBLOCK_ID" => $newIblockID
            );
            $propId = $ibp->Add($arFields);
            if ($propId > 0)
            {
                $arFields["ID"] = $propId;
                $arCommonProps[$arFields["CODE"]] = $arFields;
                echo "&mdash; Добавлено свойство ".$arFields["NAME"]."<br />";
            }
            else
                echo "&mdash; Ошибка добавления свойства ".$arFields["NAME"]."<br />";

            var_dump($ibp->LAST_ERROR);
            ////////////////////////////////////Phone
            $arFields = Array(
                "NAME" => "Телефон",
                "ACTIVE" => "Y",
                "SORT" => 500, // Сортировка
                "CODE" => "Phone",
                "PROPERTY_TYPE" => "S",


                "IBLOCK_ID" => $newIblockID
            );
            $propId = $ibp->Add($arFields);
            if ($propId > 0)
            {
                $arFields["ID"] = $propId;
                $arCommonProps[$arFields["CODE"]] = $arFields;
                echo "&mdash; Добавлено свойство ".$arFields["NAME"]."<br />";
            }
            else
                echo "&mdash; Ошибка добавления свойства ".$arFields["NAME"]."<br />";

            var_dump($ibp->LAST_ERROR);
            //////////////////////////City
            $arFields = Array(
                "NAME" => "Город",
                "ACTIVE" => "Y",
                "SORT" => 500, // Сортировка
                "CODE" => "City",
                "PROPERTY_TYPE" => "L",
                "LIST_TYPE" => "L",
                "VALUES" => array(
                   "Tomsk","Moskva","StPetrburg"
                ),

                "IBLOCK_ID" => $newIblockID
            );
            $propId = $ibp->Add($arFields);
            if ($propId > 0)
            {
                $arFields["ID"] = $propId;
                $arCommonProps[$arFields["CODE"]] = $arFields;
                echo "&mdash; Добавлено свойство ".$arFields["NAME"]."<br />";
            }
            else
                echo "&mdash; Ошибка добавления свойства ".$arFields["NAME"]."<br />";

            var_dump($ibp->LAST_ERROR);
//Удаление типа блока по его имени

/*
            global  $DB;
            $type_block='testoviy';
            $DB->StartTransaction();
            if(!CIBlockType::Delete($type_block))
            {
                $DB->Rollback();
                echo 'Delete error!';
            }
            $DB->Commit();
*/

//Получение инфоблока по его имени

         /*

            $element_code = 'www';



                $resc = CIBlock::GetList(Array(), Array('TYPE' => 'users_block', 'SITE_ID' => SITE_ID, 'CODE' => $element_code), false);
                //var_dump($resc);
                while($arrc = $resc->Fetch()){
                    $cc_name=$arrc["ID"];}
*/





/*
            global $DB;
            $iblock_id=23;
            $strWarning='';
            $DB->StartTransaction();
            if(!CIBlock::Delete($iblock_id))
            {
                $strWarning .= GetMessage("IBLOCK_DELETE_ERROR");
                $DB->Rollback();
            }
            else
                $DB->Commit();
*/






        }
        return $sResult;
    }
}
