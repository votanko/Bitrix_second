<?php


use Phinx\Migration\AbstractMigration;

/**
 * Class Init
 *
 * Стартовая миграция с настройками
 */
class Init extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    addCustomColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Any other destructive changes will result in an error when trying to
     * rollback the migration.
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    /**
     * function up
     *
     * Создание нового инфоблока "Новые пользователи" типа users_block
     * добавление св-в инфоблоку: Имя, Дата рождения, Телефон, Город
     */
    public function up(){
        if (CModule::IncludeModule("iblock")){
            $sType_block='users_block';
            $SORT=500;
            /**
             * Новый объект класса CIBLOCK
             */
            $oIb = new CIBlock;
            $arFields = Array(
                "ACTIVE" => 'Y',
                "NAME" => 'Новые пользователи',
                "CODE" => 'new_users_block',
                "IBLOCK_TYPE_ID" => $sType_block,
                "SITE_ID" => 's1',
                "SORT" => $SORT,
                "DESCRIPTION_TYPE" => 'text',


            );
            /**
             * Вызов метода Add - добавление инифоблока
             */
            $iID=$oIb->Add($arFields);
            //var_dump($oIb->LAST_ERROR);
            //var_dump($iID);
            /**
             * Вызов метода SetPermission - задаем права 777 на блок
             */
            $oIb->SetPermission($iID,Array("1"=>"X", "2"=>"X", "3"=>"X"));

            /**
             * Добавляем св-ва
             */
            $iNewIblockID=$iID;
            /**
             * Объект класса $CIBlockProperty
             */
            $oIbp = new CIBlockProperty;



            /**
             * Добавляем Имя
             */
            $arFields = Array(
                "NAME" => "Имя",
                "ACTIVE" => "Y",
                "SORT" => 500, // Сортировка
                "CODE" => "NAME",
                "PROPERTY_TYPE" => "S", // Список


                "IBLOCK_ID" => $iNewIblockID
            );
            /**
             * Вызов метода Add класса CIBlockProperty   - добавление  нового св-ва
             */
            $iPropId = $oIbp->Add($arFields);
            if ($iPropId > 0)
            {
                $arFields["ID"] = $iPropId;
                $arCommonProps[$arFields["CODE"]] = $arFields;
                echo "&mdash; Добавлено свойство ".$arFields["NAME"]."<br />";
            }
            else
                echo "&mdash; Ошибка добавления свойства ".$arFields["NAME"]."<br />";

            var_dump($oIbp->LAST_ERROR);
            /**
             * Добавляем 'Дата рождения'
             */
            $arFields = Array(
                "NAME" => "Дата рождения",
                "ACTIVE" => "Y",
                "SORT" => 500, // Сортировка
                "CODE" => "DateBirthDay",
                "PROPERTY_TYPE" => "S",


                "IBLOCK_ID" => $iNewIblockID
            );
            /**
             * Вызов метода Add класса CIBlockProperty   - добавление  нового св-ва
             */
            $iPropId = $oIbp->Add($arFields);
            if ($iPropId > 0)
            {
                $arFields["ID"] = $iPropId;
                $arCommonProps[$arFields["CODE"]] = $arFields;
                echo "&mdash; Добавлено свойство ".$arFields["NAME"]."<br />";
            }
            else
                echo "&mdash; Ошибка добавления свойства ".$arFields["NAME"]."<br />";

            //var_dump($oIbp->LAST_ERROR);
            /**
             * Добавляем 'Телефон'
             */
            $arFields = Array(
                "NAME" => "Телефон",
                "ACTIVE" => "Y",
                "SORT" => 500, // Сортировка
                "CODE" => "Phone",
                "PROPERTY_TYPE" => "S",


                "IBLOCK_ID" => $iNewIblockID
            );
            /**
             * Вызов метода Add класса CIBlockProperty   - добавление  нового св-ва
             */
            $iPropId = $oIbp->Add($arFields);
            if ($iPropId > 0)
            {
                $arFields["ID"] = $iPropId;
                $arCommonProps[$arFields["CODE"]] = $arFields;
                echo "&mdash; Добавлено свойство ".$arFields["NAME"]."<br />";
            }
            else
                echo "&mdash; Ошибка добавления свойства ".$arFields["NAME"]."<br />";

            //var_dump($oIbp->LAST_ERROR);
            /**
             * Добавляем 'Город'
             */
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

                "IBLOCK_ID" => $iNewIblockID
            );
            /**
             * Вызов метода Add класса CIBlockProperty   - добавление  нового св-ва
             */
            $iPropId = $oIbp->Add($arFields);
            if ($iPropId > 0)
            {
                $arFields["ID"] = $iPropId;
                $arCommonProps[$arFields["CODE"]] = $arFields;
                echo "&mdash; Добавлено свойство ".$arFields["NAME"]."<br />";
            }
            else
                echo "&mdash; Ошибка добавления свойства ".$arFields["NAME"]."<br />";

            //var_dump($oIbp->LAST_ERROR);



        }
    }


    /**
     * Функция down()
     * уничтожение инфоблока "new_users_block"
     */
    public function down(){
        $sType_block='users_block';
        $sBlock_name="new_users_block";
        /**
         * Метод класса CModule
         * проверяем установлен ли модуль, если да то подключаем его
         */
        if (CModule::IncludeModule("iblock")) {
            /**
             * Getlist
             *
             * Возвращает список информационных блоков по фильтру arFilter отсортированный в порядке arOrder
             */
            $oResc = CIBlock::GetList(Array(), Array('TYPE' => $sType_block, 'SITE_ID' => SITE_ID, 'CODE' => $sBlock_name), false);
            //var_dump($resc);
            while ($arrc = $oResc->Fetch()) {
                $sID_block = $arrc["ID"];
                //var_dump($sID_block);
            }
        }
        /**
         * Метод класса CModule
         * проверяем установлен ли модуль, если да то подключаем его
         */
        if (CModule::IncludeModule("iblock")){
            /**
             * Новый объект класса CIBLOCK
             */
            $oIb = new CIBlock;
            /**
             * Delete
             *
             * Метод удаляет информационный блок
             */
            $ID=$oIb->Delete(intval($sID_block));



        }}
}
