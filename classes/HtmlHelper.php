<?php

class HtmlHelper
{
    /**
     * @param array $allObjects Objekte einer Klasse
     * @param string $name Name der Übergabevariablen
     * @param int $preselected PK des vorausgewählten Objekts
     * @return string
     * $allObejct braucht id and name
     */
    public static function buildSelectOption(array $allObjects, string $name, ?int $preselected = null): string
    {
        if (!isset($preselected)) $preselected = '';
        $html = "<select name='$name'>\n";

        foreach ($allObjects as $object){
            $selected = ($preselected === $object->getId()) ? 'selected' : '';
            $html .= "<option value='" . $object->getId() . " ' $selected>" . $object->getName() . "</option>\n";
        }
        $html .= "</select>\n";
        return $html;
    }
}