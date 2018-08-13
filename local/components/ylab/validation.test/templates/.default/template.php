<? if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED !== true) die();
use Bitrix\Main,
    Bitrix\Iblock, CModule, CIBlock, CIBlockElement, CIBlockPropertyEnum;
/** @var array $arParams */
/** @var array $arResult */
/** @global CMain $APPLICATION */
/** @global CUser $USER */
/** @global CDatabase $DB */
/** @var CBitrixComponentTemplate $this */
/** @var string $templateName */
/** @var string $templateFile */
/** @var string $templateFolder */
/** @var string $componentPath */
/** @var CBitrixComponent $component */
?>

<form action="" method="post" class="form form-block">
    <?= bitrix_sessid_post() ?>
    <? if (count($arResult['ERRORS'])): ?>
        <p><?= implode('<br/>', $arResult['ERRORS']) ?></p>
    <?elseif ($arResult['SUCCESS']):?>



        <p>Успешная валидация</p>
    <?
    //var_dump($arResult);
    endif; ?>



    <?
    /**
     * Метод класса CModule
     * проверяем установлен ли модуль, если да то подключаем его
     * Получаем пары ИД Значение св-ва 'City' и выводим их в форме.
     */
    if (CModule::IncludeModule('iblock')) {
        $sBlock_name="new_users_block";
        $oResc = CIBlock::GetList(Array(), Array('TYPE' => 'users_block', 'SITE_ID' => SITE_ID, 'CODE' => $sBlock_name), false);

        while ($arrBlock = $oResc->Fetch()) {
            $sID_block = $arrBlock["ID"];
        }

        $oProperty_enums = CIBlockPropertyEnum::GetList(Array("DEF" => "DESC", "SORT" => "ASC"), Array("IBLOCK_ID" => (int)$sID_block, "CODE" => "City"));


    }
    ?>
    <div>
        <label>
            Имя пользователя<br>
            <input type="text" name="user_name"/>
        </label>
        <br>
        <label>
            Город<br>
            <select name="city">
                <option value="">Выбрать</option>
                <?
                while ($arrEnum_fields = $oProperty_enums->GetNext()) {
                    echo"<option value=\"".$arrEnum_fields["ID"] . "\">" . $arrEnum_fields["VALUE"] . "</option>";
                }
                ?>

            </select>
        </label>
    </div>
    <div>
        <label>
            Дата<br>
            <input type="text" name="date"/>
        </label>
    </div>
    <div>
        <label>
            Мобильный телефон<br>
            <input type="text" name="mobile"/>
        </label>
    </div>
    <div class="btn green">
        <button type="submit" name="submit">Отправить</button>
    </div>
</form>